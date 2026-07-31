<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AiAnalysisService
{
    /**
     * Analyze post caption & metrics using OpenAI API
     */
    public function analyzePostContent(string $caption, int $likes = 0, int $comments = 0): array
    {
        $apiKey = config('services.openai.key');

        if (!$apiKey) {
            throw new Exception('OpenAI API key is not configured.');
        }

        $systemPrompt = <<<PROMPT
You are an expert Social Media Strategist and Senior Content Director at a top-tier creative agency.
Analyze the provided Instagram post details and return a STRICT JSON response (no markdown formatting, no code blocks) with the exact structure:

{
    "tone_of_voice": "Brief analysis of tone (e.g., Professional yet Playful, Authoritative, Casual)",
    "sentiment": {
        "label": "Positive | Neutral | Negative",
        "score": 85,
        "explanation": "Short sentence explaining the sentiment context."
    },
    "hashtag_audit": {
        "status": "Optimal | Needs Work | Missing",
        "count": 5,
        "feedback": "Evaluation of hashtag relevance, reach potential, and clutter."
    },
    "recommendations": [
        {
            "category": "Hook & Lead",
            "action": "Specific recommendation to improve the opening line."
        },
        {
            "category": "Call to Action (CTA)",
            "action": "Specific recommendation to drive comments or shares."
        },
        {
            "category": "Hashtag & Formatting",
            "action": "Specific formatting or hashtag strategy adjustment."
        }
    ],
    "overall_agency_score": 88
}
PROMPT;

        $userPrompt = "Post Caption:\n\"{$caption}\"\n\nEngagement Metrics:\nLikes: {$likes}\nComments: {$comments}";

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->timeout(20)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'temperature' => 0.7,
            ]);

            if ($response->failed()) {
                Log::error('OpenAI API Error', $response->json() ?? []);
                throw new Exception('AI analysis request failed.');
            }

            $rawContent = $response->json()['choices'][0]['message']['content'] ?? '{}';
            return json_decode($rawContent, true) ?? [];

        } catch (Exception $e) {
            Log::error('AI Service Exception: ' . $e->getMessage());
            throw new Exception('Failed to generate AI analysis: ' . $e->getMessage());
        }
    }
}
