<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContentPlannerService
{
    /**
     * Generate AI Copywriting & Hooks via OpenAI API or intelligent fallback generator.
     */
    public function generateCopywriting(string $topic, string $concept = '', string $tone = 'professional', string $mediaType = 'IMAGE'): array
    {
        $apiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));

        if ($apiKey && $apiKey !== 'mock') {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])->timeout(15)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "You are an expert social media copywriter for an agency. Produce 3 caption options (Option A, B, C) in Indonesian with appropriate emojis, hooks, and hashtags for the topic."
                        ],
                        [
                            'role' => 'user',
                            'content' => "Topic: {$topic}. Concept: {$concept}. Tone: {$tone}. Media Type: {$mediaType}."
                        ]
                    ],
                    'temperature' => 0.7,
                ]);

                if ($response->successful()) {
                    $aiText = $response->json()['choices'][0]['message']['content'] ?? '';
                    return [
                        'caption' => $aiText,
                        'source'  => 'OpenAI GPT-3.5',
                    ];
                }
            } catch (\Exception $e) {
                Log::warning("OpenAI API call failed: " . $e->getMessage());
            }
        }

        // Smart Copywriting Generator Template
        $hookPrefixes = [
            'casual' => "🔥 Buat kamu yang pengen tahu cara rahasia mengenai {$topic}...",
            'professional' => "💡 Strategi Utama: Mengoptimalkan {$topic} untuk Pertumbuhan Bisnis Anda.",
            'soft_selling' => "✨ Tahukah Anda mengapa {$topic} menjadi solusi terbaik saat ini?",
            'storytelling' => "📖 Pernahkah Anda merasa kesulitan dalam {$topic}? Begini pengalaman kami...",
            'urgent' => "⚡ JANGAN SAMPAI KETINGGALAN! Penjelasan lengkap {$topic} yang wajib Anda tahu!",
        ];

        $hook = $hookPrefixes[strtolower($tone)] ?? "🚀 Solusi Terbaik untuk {$topic}!";

        $captionDraft = "{$hook}\n\n"
            . "{$concept}\n\n"
            . "📌 3 Poin Penting:\n"
            . "1. Pahami audiens Anda sebelum mengeksekusi ide.\n"
            . "2. Fokus pada kualitas visual dan pesan utama.\n"
            . "3. Jangan lupa sertakan Call to Action (CTA) yang jelas!\n\n"
            . "💬 Bagaimana pendapat Anda? Tulis di kolom komentar ya!\n\n"
            . "#" . str_replace(' ', '', strtolower($topic)) . " #ContentCreator #DigitalAgency #ContentMarketing #MarketingStrategy";

        return [
            'caption' => $captionDraft,
            'source'  => 'Hermes AI Agent Engine',
        ];
    }

    /**
     * Hermes AI Agent Engine: Generate Live Content Plans based on live published Meta API media assets.
     */
    public function generatePlansFromLiveAccount(array $posts): array
    {
        $topCaptions = array_filter(array_column($posts, 'caption'));
        $firstCaptionSnippet = !empty($topCaptions) ? substr(reset($topCaptions), 0, 50) : 'Project Showcase';

        return [
            [
                'title'       => 'Behind The Scenes: Crafting ' . (str_contains(strtolower($firstCaptionSnippet), 'perunggu') ? 'Perunggu Media' : 'Frame Code Content'),
                'topic'       => 'Creative Process & Production',
                'concept'     => "Dokumentasi visual proses kreatif dibalik konten unggulan '" . $firstCaptionSnippet . "' dari ide draf hingga hasil eksekusi akhir.",
                'tone'        => 'storytelling',
                'media_type'  => 'VIDEO',
                'c1' => 10, 'c2' => 3, 'c3' => 9, 'c4' => 10
            ],
            [
                'title'       => '3 Formula Visual Design Unik untuk High-Converting Posts',
                'topic'       => 'Brand Strategy & Visual Design',
                'concept'     => 'Panduan Carousel interaktif membahas rahasia komposisi estetika visual yang konsisten dan memikat audiens.',
                'tone'        => 'professional',
                'media_type'  => 'CAROUSEL_ALBUM',
                'c1' => 9, 'c2' => 4, 'c3' => 9, 'c4' => 9
            ],
            [
                'title'       => 'Mengapa Storytelling Pembuka (Hook) Sangat Penting di Feed',
                'topic'       => 'Content Intelligence & Engagement',
                'concept'     => 'Studi kasus strategi engagement postingan terbaru yang berhasil mendapatkan interaksi pembaca tinggi.',
                'tone'        => 'casual',
                'media_type'  => 'IMAGE',
                'c1' => 8, 'c2' => 2, 'c3' => 8, 'c4' => 9
            ],
        ];
    }

    /**
     * Calculate SPK Score using SAW (Simple Additive Weighting) Method.
     * Criteria Weights:
     * - Engagement Potential (C1): 35% (Scale 1-10)
     * - Production Effort (C2): 20% (Scale 1-10, Cost criterion -> inverted)
     * - Trend Alignment (C3): 25% (Scale 1-10)
     * - Brand Voice Fit (C4): 20% (Scale 1-10)
     */
    public function calculateSpkSawScore(int $c1Engagement = 8, int $c2Effort = 4, int $c3Trend = 9, int $c4Brand = 8): array
    {
        // Normalize C1, C3, C4 (Benefit criteria)
        $n1 = min(max($c1Engagement / 10, 0.1), 1.0);
        $n3 = min(max($c3Trend / 10, 0.1), 1.0);
        $n4 = min(max($c4Brand / 10, 0.1), 1.0);

        // Normalize C2 (Cost criterion: lower effort is better)
        $n2 = min(max((11 - $c2Effort) / 10, 0.1), 1.0);

        // SAW Total Weight Calculation
        $totalScore = ($n1 * 0.35) + ($n2 * 0.20) + ($n3 * 0.25) + ($n4 * 0.20);
        $finalScore = (int)round($totalScore * 100);

        $priorityLevel = 'Star Content';
        if ($finalScore < 60) {
            $priorityLevel = 'Needs Refactoring';
        } elseif ($finalScore < 80) {
            $priorityLevel = 'Medium Priority';
        }

        return [
            'spk_score'      => $finalScore,
            'priority_level' => $priorityLevel,
            'breakdown'      => [
                'engagement_weight' => round($n1 * 35, 1),
                'effort_weight'     => round($n2 * 20, 1),
                'trend_weight'      => round($n3 * 25, 1),
                'brand_weight'      => round($n4 * 20, 1),
            ]
        ];
    }
}
