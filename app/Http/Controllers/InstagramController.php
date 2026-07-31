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
}
