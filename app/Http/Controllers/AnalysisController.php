<?php

namespace App\Http\Controllers;

use App\Services\AiAnalysisService;
use Illuminate\Http\Request;
use Exception;

class AnalysisController extends Controller
{
    protected AiAnalysisService $aiService;

    public function __construct(AiAnalysisService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'post_id' => 'required|string',
            'caption' => 'required|string',
            'media_url' => 'nullable|url',
            'likes' => 'nullable|integer',
            'comments' => 'nullable|integer',
            'timestamp' => 'nullable|string',
        ]);

        try {
            $postData = [
                'id' => $request->input('post_id'),
                'caption' => $request->input('caption'),
                'media_url' => $request->input('media_url'),
                'likes' => $request->input('likes', 0),
                'comments' => $request->input('comments', 0),
                'timestamp' => $request->input('timestamp', now()->toIso8601String()),
            ];

            $analysis = $this->aiService->analyzePostContent(
                $postData['caption'],
                $postData['likes'],
                $postData['comments']
            );

            return view('analysis', compact('postData', 'analysis'));
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
}
