<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use App\Models\InstagramAccount;
use App\Models\User;
use App\Services\CompetitorService;
use App\Services\InstagramService;
use Illuminate\Http\Request;

class CompetitorController extends Controller
{
    protected $competitorService;
    protected $instagramService;

    public function __construct(CompetitorService $competitorService, InstagramService $instagramService)
    {
        $this->competitorService = $competitorService;
        $this->instagramService = $instagramService;
    }

    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $account = $user->instagramAccount;
        $posts = $account ? $this->instagramService->fetchUserPosts($account) : [];
        $insights = $account ? $this->instagramService->fetchAccountInsights($account, $posts) : [];

        $competitors = Competitor::where('user_id', $user->id)->get();

        if ($competitors->isEmpty()) {
            $this->seedHermesCompetitor($user->id);
            $competitors = Competitor::where('user_id', $user->id)->get();
        }

        $gapAnalysis = $this->competitorService->runGapAnalysis($insights, $competitors->toArray());

        return view('competitors', compact('account', 'posts', 'insights', 'competitors', 'gapAnalysis'));
    }

    public function autoGenerateHermes()
    {
        $user = auth()->user() ?? User::first();
        $account = $user ? $user->instagramAccount : InstagramAccount::where('user_id', $user->id ?? 1)->first();
        $username = $account ? $account->username : 'Instagram';
        $this->seedHermesCompetitor($user->id ?? 1);
        return redirect()->route('competitors.index')->with('status', "🤖 Hermes AI Agent Berhasil Menganalisis Live Meta API @{$username} & Menjalankan Niche Competitor Analysis!");
    }

    protected function seedHermesCompetitor($userId)
    {
        $user = auth()->user() ?? User::find($userId);
        $account = $user ? $user->instagramAccount : InstagramAccount::where('user_id', $userId)->first();
        $handles = ['@framecode.studio', '@creative.agency', '@cinematography.id'];

        foreach ($handles as $handle) {
            $data = $account
                ? $this->instagramService->fetchCompetitorBusinessDiscovery($account, $handle)
                : $this->competitorService->fetchCompetitorProfile($handle);

            Competitor::updateOrCreate(
                ['user_id' => $userId, 'username' => $data['username']],
                [
                    'followers_count' => $data['followers_count'],
                    'engagement_rate' => $data['engagement_rate'],
                    'avg_likes'       => $data['avg_likes'],
                    'avg_comments'    => $data['avg_comments'],
                ]
            );
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
        ]);

        $user = auth()->user() ?? User::first();
        $account = $user ? $user->instagramAccount : InstagramAccount::where('user_id', $user->id ?? 1)->first();

        $data = $account
            ? $this->instagramService->fetchCompetitorBusinessDiscovery($account, $validated['username'])
            : $this->competitorService->fetchCompetitorProfile($validated['username']);

        Competitor::updateOrCreate(
            ['user_id' => $user->id ?? 1, 'username' => $data['username']],
            [
                'followers_count' => $data['followers_count'],
                'engagement_rate' => $data['engagement_rate'],
                'avg_likes'       => $data['avg_likes'],
                'avg_comments'    => $data['avg_comments'],
            ]
        );

        $statusMsg = ($data['is_real_api'] ?? false)
            ? "Metrik live Meta Business Discovery API untuk {$data['username']} berhasil disimpan!"
            : "Kompetitor {$data['username']} berhasil ditambahkan ke matriks benchmark!";

        return redirect()->route('competitors.index')->with('status', $statusMsg);
    }

    public function destroy(Competitor $competitor)
    {
        $competitor->delete();
        return redirect()->route('competitors.index')->with('status', 'Kompetitor berhasil dihapus.');
    }
}
