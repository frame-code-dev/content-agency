<?php

namespace App\Http\Controllers;

use App\Models\ContentPlan;
use App\Models\User;
use App\Services\ContentPlannerService;
use Illuminate\Http\Request;

class PlannerController extends Controller
{
    protected $plannerService;

    public function __construct(ContentPlannerService $plannerService)
    {
        $this->plannerService = $plannerService;
    }

    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $plans = ContentPlan::where('user_id', $user->id)
            ->orderBy('scheduled_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($plans->isEmpty()) {
            $this->seedHermesPlans($user->id);
            $plans = ContentPlan::where('user_id', $user->id)
                ->orderBy('scheduled_at', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('planner', compact('plans'));
    }

    public function autoGenerateHermes()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $account = $user->instagramAccount;
        $username = $account ? $account->username : 'Instagram';
        $this->seedHermesPlans($user->id);
        return redirect()->route('planner.index')->with('status', "🤖 Hermes AI Agent Berhasil Menganalisis Live Meta API @{$username} & Me-generate Draf Konten SPK SAW!");
    }

    protected function seedHermesPlans($userId)
    {
        $user = auth()->user() ?? User::find($userId);
        $account = $user ? $user->instagramAccount : \App\Models\InstagramAccount::where('user_id', $userId)->first();
        $instagramService = app(\App\Services\InstagramService::class);
        $posts = $account ? $instagramService->fetchUserPosts($account) : [];

        $ideas = $this->plannerService->generatePlansFromLiveAccount($posts);

        foreach ($ideas as $index => $idea) {
            $spk = $this->plannerService->calculateSpkSawScore($idea['c1'], $idea['c2'], $idea['c3'], $idea['c4']);
            $ai = $this->plannerService->generateCopywriting($idea['title'], $idea['concept'], $idea['tone'], $idea['media_type']);

            ContentPlan::create([
                'user_id'        => $userId,
                'title'          => $idea['title'],
                'topic'          => $idea['topic'],
                'concept'        => $idea['concept'],
                'caption'        => $ai['caption'],
                'tone'           => $idea['tone'],
                'media_type'     => $idea['media_type'],
                'scheduled_at'   => now()->addDays($index + 1),
                'status'         => 'draft',
                'spk_score'      => $spk['spk_score'],
                'priority_level' => $spk['priority_level'],
            ]);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'topic'       => 'nullable|string|max:255',
            'concept'     => 'nullable|string',
            'tone'        => 'required|string',
            'media_type'  => 'required|string',
            'scheduled_at' => 'nullable|date',
            'c1_engagement' => 'nullable|numeric',
            'c2_effort'     => 'nullable|numeric',
            'c3_trend'      => 'nullable|numeric',
            'c4_brand'      => 'nullable|numeric',
        ]);

        $user = auth()->user() ?? User::first();

        // Calculate SPK SAW Score
        $spk = $this->plannerService->calculateSpkSawScore(
            (int)($request->input('c1_engagement', 8)),
            (int)($request->input('c2_effort', 4)),
            (int)($request->input('c3_trend', 9)),
            (int)($request->input('c4_brand', 8))
        );

        // Generate AI Copywriting draft
        $aiResult = $this->plannerService->generateCopywriting(
            $validated['title'],
            $validated['concept'] ?? $validated['title'],
            $validated['tone'],
            $validated['media_type']
        );

        ContentPlan::create([
            'user_id'        => $user->id ?? 1,
            'title'          => $validated['title'],
            'topic'          => $validated['topic'] ?? $validated['title'],
            'concept'        => $validated['concept'] ?? '',
            'caption'        => $aiResult['caption'],
            'tone'           => $validated['tone'],
            'media_type'     => $validated['media_type'],
            'scheduled_at'   => $validated['scheduled_at'] ?? now()->addDays(2),
            'status'         => 'draft',
            'spk_score'      => $spk['spk_score'],
            'priority_level' => $spk['priority_level'],
        ]);

        return redirect()->route('planner.index')->with('status', 'Rencana konten berhasil dibuat & dianalisis oleh SPK SAW Engine!');
    }

    public function generateAiContent(Request $request)
    {
        $topic = $request->input('topic', 'Promosi Produk Baru');
        $tone = $request->input('tone', 'professional');
        $concept = $request->input('concept', '');

        $result = $this->plannerService->generateCopywriting($topic, $concept, $tone);

        return response()->json($result);
    }

    public function destroy(ContentPlan $plan)
    {
        $plan->delete();
        return redirect()->route('planner.index')->with('status', 'Draf konten berhasil dihapus.');
    }
}
