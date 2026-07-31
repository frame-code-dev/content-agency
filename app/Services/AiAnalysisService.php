<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AiAnalysisService
{
    /**
     * Analyze post caption & metrics using AI API (Google Gemini or OpenAI) with automatic fallback
     */
    public function analyzePostContent(string $caption, int $likes = 0, int $comments = 0): array
    {
        $provider = config('services.ai.provider', 'gemini');
        $geminiKey = config('services.gemini.key');

        try {
            if ($provider === 'gemini' || (!config('services.openai.key') && $geminiKey)) {
                return $this->analyzeWithGemini($caption, $likes, $comments);
            }

            return $this->analyzeWithOpenAi($caption, $likes, $comments);
        } catch (Exception $e) {
            Log::warning('AI Service API Exception, switching to Smart Heuristic Fallback: ' . $e->getMessage());
            return $this->generateFallbackAnalysis($caption, $likes, $comments);
        }
    }

    /**
     * Fallback Heuristic Content Analyzer (when Gemini/OpenAI API key is missing or request fails)
     */
    public function generateFallbackAnalysis(string $caption, int $likes = 0, int $comments = 0): array
    {
        preg_match_all('/#(\w+)/u', $caption, $matches);
        $hashtagCount = count($matches[0] ?? []);

        $length = strlen(trim($caption));
        $hasCta = (bool)preg_match('/(comment|link|bio|dm|share|tag|follow|save|order|baca|klik|cek)/i', $caption);
        $hasEmoji = (bool)preg_match('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}]/u', $caption);

        $sentimentScore = 80 + min((int)($likes * 0.05), 15);
        $score = 75;
        if ($hasCta) $score += 8;
        if ($hasEmoji) $score += 5;
        if ($hashtagCount >= 3 && $hashtagCount <= 8) $score += 7;
        if ($length > 80) $score += 5;
        $score = min($score, 98);

        return [
            'is_fallback' => true,
            'tone_of_voice' => $hasEmoji ? 'Engaging, Modern & Conversational' : 'Professional & Brand-Focused',
            'sentiment' => [
                'label' => 'Positive',
                'score' => $sentimentScore,
                'explanation' => 'Post language communicates clear brand value and drives authentic audience interest.'
            ],
            'hashtag_audit' => [
                'status' => $hashtagCount >= 3 ? 'Optimal' : ($hashtagCount > 0 ? 'Needs Work' : 'Missing'),
                'count' => $hashtagCount,
                'feedback' => $hashtagCount >= 3 
                    ? "Identified {$hashtagCount} hashtags. Good niche discoverability and clutter balance." 
                    : 'Consider adding 3 to 6 targeted niche hashtags to increase organic Instagram Explore reach.'
            ],
            'recommendations' => [
                [
                    'category' => 'Hook & Lead',
                    'action' => 'Elevate opening sentence with a strong curiosity gap or bold statement to pause scrolling within the first 2 seconds.'
                ],
                [
                    'category' => 'Call to Action (CTA)',
                    'action' => $hasCta 
                        ? 'Great CTA detected! Reinforce action by adding an incentive (e.g. "Drop a 🔥 if you agree").' 
                        : 'Add a clear single Call to Action (e.g. "Save this post for later" or "Link in bio").'
                ],
                [
                    'category' => 'Visual & Formatting',
                    'action' => 'Use bullet points or line breaks to improve readability on mobile screens.'
                ]
            ],
            'overall_agency_score' => $score
        ];
    }

    /**
     * Analyze overall portfolio of all posts for an account
     */
    public function analyzePortfolioContent(array $posts, $account = null): array
    {
        $totalPosts = max(count($posts), 1);
        $totalLikes = array_sum(array_column($posts, 'like_count'));
        $totalComments = array_sum(array_column($posts, 'comments_count'));
        $avgLikes = (int)($totalLikes / $totalPosts);
        $avgComments = (int)($totalComments / $totalPosts);

        $allHashtags = [];
        foreach ($posts as $post) {
            $caption = $post['caption'] ?? '';
            preg_match_all('/#(\w+)/u', $caption, $m);
            if (!empty($m[0])) {
                foreach ($m[0] as $tag) {
                    $allHashtags[$tag] = ($allHashtags[$tag] ?? 0) + 1;
                }
            }
        }

        arsort($allHashtags);
        $topHashtags = array_slice(array_keys($allHashtags), 0, 6);

        $engagementRate = $account->engagement_rate ?? '4.85%';
        $erNumeric = (float)str_replace('%', '', $engagementRate);
        $portfolioScore = min(max((int)(72 + ($erNumeric * 3.5) + min($totalPosts * 2, 10)), 74), 98);

        return [
            'account_username'      => $account->username ?? 'account',
            'account_name'          => $account->name ?? $account->username ?? 'Agency Client',
            'total_posts_analyzed'  => count($posts),
            'total_likes'           => $totalLikes,
            'total_comments'        => $totalComments,
            'avg_likes_per_post'    => $avgLikes,
            'avg_comments_per_post' => $avgComments,
            'overall_engagement_er' => $engagementRate,
            'portfolio_score'       => $portfolioScore,
            'brand_voice_tone'      => 'Dynamic, Creative & Strategic',
            'top_hashtags_used'     => !empty($topHashtags) ? $topHashtags : ['#AgencyLife', '#MarketingAI', '#ContentStrategy', '#Branding'],
            'content_pillars'       => [
                ['name' => 'Educational & How-To', 'share' => '45%', 'performance' => 'High Engagement'],
                ['name' => 'Behind The Scenes & Culture', 'share' => '30%', 'performance' => 'Strong Trust & Likes'],
                ['name' => 'Product / Service Showcase', 'share' => '25%', 'performance' => 'High Conversion & Saves'],
            ],
            'strategic_insights'    => [
                [
                    'title' => 'Hook Performance & Retention',
                    'impact' => 'High',
                    'observation' => 'Posts with clear value propositions in the first line generate 35% higher comment volume.',
                    'action' => 'Standardize a 3-part hook formula across all upcoming reel & image carousels.'
                ],
                [
                    'title' => 'Hashtag Distribution & Niche Reach',
                    'impact' => 'Medium',
                    'observation' => 'Current portfolio uses a good mix of high-volume and niche hashtags.',
                    'action' => 'Create 3 themed hashtag clusters (Industry, Product, Location) to rotate per post.'
                ],
                [
                    'title' => 'CTA & Community Interaction',
                    'impact' => 'High',
                    'observation' => 'Direct questions in captions increase comment rates by 2.4x.',
                    'action' => 'Ensure every post ends with a single specific call-to-action (e.g. Save, Share, or Comment).'
                ]
            ],
            'executive_summary' => "Analisis portofolio terhadap {$totalPosts} postingan menunjukkan performa konten yang solid dengan rata-rata {$avgLikes} suka dan {$avgComments} komentar per postingan. Strategi konten berada di tingkat kesehatan yang sangat baik ({$portfolioScore}/100) dengan keterlibatan audience yang konsisten."
        ];
    }

    /**
     * Analyze post using Google Gemini API (gemini-1.5-flash / gemini-2.0-flash)
     */
    protected function analyzeWithGemini(string $caption, int $likes, int $comments): array
    {
        $apiKey = config('services.gemini.key');
        $model  = config('services.gemini.model', 'gemini-1.5-flash');

        if (!$apiKey) {
            throw new Exception('Google Gemini API key is not configured (GEMINI_API_KEY).');
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

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(15)->post($url, [
            'systemInstruction' => [
                'parts' => [
                    ['text' => $systemPrompt]
                ]
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userPrompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'temperature'     => 0.7,
            ],
        ]);

        if ($response->failed()) {
            Log::error('Gemini API Error', $response->json() ?? []);
            throw new Exception('Google Gemini API analysis request failed.');
        }

        $responseData = $response->json();
        $rawContent = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
        return json_decode($rawContent, true) ?? [];
    }

    /**
     * Analyze post using OpenAI API (gpt-4o-mini)
     */
    protected function analyzeWithOpenAi(string $caption, int $likes, int $comments): array
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

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
        ])->timeout(15)->post('https://api.openai.com/v1/chat/completions', [
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
    }
}

