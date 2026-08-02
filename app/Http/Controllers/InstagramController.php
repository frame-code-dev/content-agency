<?php

namespace App\Http\Controllers;

use App\Services\InstagramService;
use Illuminate\Http\Request;
use Exception;

class InstagramController extends Controller
{
    protected InstagramService $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    public function redirect()
    {
        return redirect()->away($this->instagramService->getAuthorizationUrl());
    }

    public function callback(Request $request)
    {
        if ($request->has('error') || !$request->has('code')) {
            $reason = $request->get('error_description') 
                ?? $request->get('error_reason') 
                ?? $request->get('error') 
                ?? 'Meta authorization dialog was cancelled or denied by user.';

            return redirect()->route('login')->with('error', 'Meta OAuth Notice: ' . $reason);
        }

        try {
            $account = $this->instagramService->handleOAuthCallback(
                $request->get('code'),
                auth()->id() ?? 1
            );

            $user = $account->user ?? \App\Models\User::find($account->user_id);
            if ($user) {
                // 1. Regenerate session ID FIRST to prevent session fixation & clear old transient keys
                $request->session()->regenerate();
                
                // 2. Login user into the fresh regenerated session with remember token
                auth()->login($user, true);
                
                // 3. Persist session directly to database session table
                $request->session()->save();
            }

            return redirect()->route('dashboard')->with('success', 'Instagram account successfully connected.');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Connection failed: ' . $e->getMessage());
        }
    }

    public function sync()
    {
        $user = auth()->user();
        if ($user && $user->instagramAccount) {
            try {
                $this->instagramService->syncAccountData($user->instagramAccount);
                return redirect()->route('dashboard')->with('success', 'Data Instagram berhasil disinkronkan dan disimpan ke database.');
            } catch (Exception $e) {
                return redirect()->route('dashboard')->with('error', 'Gagal sinkronisasi data API Instagram: ' . $e->getMessage());
            }
        }

        return redirect()->route('dashboard')->with('error', 'Tidak ada akun Instagram yang terhubung.');
    }

    public function disconnect()
    {
        $user = auth()->user() ?? \App\Models\User::first();
        if ($user && $user->instagramAccount) {
            $user->instagramAccount->delete();
        }

        return redirect()->route('dashboard')->with('success', 'Instagram account disconnected successfully.');
    }

    public function importZip(Request $request, \App\Services\InstagramImportService $importService)
    {
        $request->validate([
            'export_file' => ['required', 'file', 'mimes:zip,json,txt', 'max:51200'], // max 50MB
        ], [
            'export_file.required' => 'Harap pilih file data ekspor Meta Instagram (.zip atau .json).',
            'export_file.mimes'    => 'File harus berformat .zip atau .json dari Meta Accounts Center.',
            'export_file.max'      => 'Ukuran file maksimal adalah 50MB.',
        ]);

        try {
            $user = auth()->user() ?? \App\Models\User::first();
            $result = $importService->importExportFile($user, $request->file('export_file'));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => $result['message'],
                    'redirect' => route('dashboard'),
                ]);
            }

            return redirect()->route('dashboard')->with('success', $result['message']);
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses file: ' . $e->getMessage(),
                ], 422);
            }

            return redirect()->route('dashboard')->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    public function uploadChunk(Request $request, \App\Services\InstagramImportService $importService)
    {
        try {
            $request->validate([
                'file_chunk'   => ['required', 'file'],
                'file_id'      => ['required', 'string'],
                'chunk_index'  => ['required', 'integer'],
                'total_chunks' => ['required', 'integer'],
                'file_name'    => ['required', 'string'],
            ]);

            $fileId      = preg_replace('/[^a-zA-Z0-9_-]/', '', $request->input('file_id'));
            $chunkIndex  = (int) $request->input('chunk_index');
            $totalChunks = (int) $request->input('total_chunks');
            $fileName    = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $request->input('file_name'));

            $chunkDir = storage_path('app/tmp/chunks/' . $fileId);
            if (!\Illuminate\Support\Facades\File::exists($chunkDir)) {
                \Illuminate\Support\Facades\File::makeDirectory($chunkDir, 0777, true, true);
            }

            // Save incoming slice to chunk directory
            $chunkPath = $chunkDir . '/chunk_' . $chunkIndex;
            $file = $request->file('file_chunk');
            if (!$file || !$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chunk file upload tidak valid atau terputus.',
                ], 422);
            }
            $file->move($chunkDir, 'chunk_' . $chunkIndex);

            // Check if all chunks have been received
            $allChunksExist = true;
            for ($i = 0; $i < $totalChunks; $i++) {
                if (!\Illuminate\Support\Facades\File::exists($chunkDir . '/chunk_' . $i)) {
                    $allChunksExist = false;
                    break;
                }
            }

            if ($allChunksExist) {
                $assembledDir = storage_path('app/tmp/imports');
                if (!\Illuminate\Support\Facades\File::exists($assembledDir)) {
                    \Illuminate\Support\Facades\File::makeDirectory($assembledDir, 0777, true, true);
                }

                $assembledFilePath = $assembledDir . '/' . $fileId . '_' . $fileName;
                $outStream = fopen($assembledFilePath, 'wb');

                for ($i = 0; $i < $totalChunks; $i++) {
                    $chunkFile = $chunkDir . '/chunk_' . $i;
                    $inStream = fopen($chunkFile, 'rb');
                    while (!feof($inStream)) {
                        fwrite($outStream, fread($inStream, 8192));
                    }
                    fclose($inStream);
                }
                fclose($outStream);

                // Clean up chunk files
                \Illuminate\Support\Facades\File::deleteDirectory($chunkDir);

                // Process assembled ZIP / JSON file via InstagramImportService
                try {
                    set_time_limit(600); // 10 mins execution
                    $user = auth()->user() ?? \App\Models\User::first();
                    $result = $importService->importFromZipPath($user, $assembledFilePath);

                    // Clean up assembled ZIP file
                    if (\Illuminate\Support\Facades\File::exists($assembledFilePath)) {
                        \Illuminate\Support\Facades\File::delete($assembledFilePath);
                    }

                    return response()->json([
                        'success'     => true,
                        'is_complete' => true,
                        'message'     => $result['message'],
                        'redirect'    => route('dashboard'),
                    ]);
                } catch (\Throwable $e) {
                    if (\Illuminate\Support\Facades\File::exists($assembledFilePath)) {
                        \Illuminate\Support\Facades\File::delete($assembledFilePath);
                    }

                    \Illuminate\Support\Facades\Log::error('Instagram Zip Concatenation Exception: ' . $e->getMessage(), [
                        'trace' => $e->getTraceAsString()
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal memproses file ZIP gabungan: ' . $e->getMessage(),
                    ], 422);
                }
            }

            return response()->json([
                'success'     => true,
                'is_complete' => false,
                'chunk_index' => $chunkIndex,
                'total_chunks' => $totalChunks,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Upload Chunk Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah chunk: ' . $e->getMessage(),
            ], 500);
        }
    }
}
