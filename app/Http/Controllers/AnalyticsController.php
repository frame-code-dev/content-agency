<?php

namespace App\Http\Controllers;

use App\Services\InstagramService;
use App\Models\User;
use App\Models\ContentPlan;
use App\Models\Competitor;
use App\Models\InstagramAccount;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    protected InstagramService $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    public function contentPerformance()
    {
        $user = auth()->user();
        $account = $user ? $user->instagramAccount : null;
        $posts = $account ? $this->instagramService->fetchUserPosts($account) : [];
        $insights = $account ? $this->instagramService->fetchAccountInsights($account, $posts) : [];
        $contentPlans = ContentPlan::where('user_id', $user->id ?? 1)->orderBy('created_at', 'desc')->get();

        return view('analytics.content', compact('user', 'account', 'posts', 'insights', 'contentPlans'));
    }

    public function engagementAnalytics()
    {
        $user = auth()->user();
        $account = $user ? $user->instagramAccount : null;
        $posts = $account ? $this->instagramService->fetchUserPosts($account) : [];
        $insights = $account ? $this->instagramService->fetchAccountInsights($account, $posts) : [];

        // DB calculated metrics
        $insights['total_likes'] = array_sum(array_column($posts, 'like_count'));
        $insights['total_comments'] = array_sum(array_column($posts, 'comments_count'));

        return view('analytics.engagement', compact('user', 'account', 'posts', 'insights'));
    }

    public function reachImpressions()
    {
        $user = auth()->user();
        $account = $user ? $user->instagramAccount : null;
        $posts = $account ? $this->instagramService->fetchUserPosts($account) : [];
        $insights = $account ? $this->instagramService->fetchAccountInsights($account, $posts) : [];

        return view('analytics.reach', compact('user', 'account', 'posts', 'insights'));
    }

    public function audienceInsights()
    {
        $user = auth()->user();
        $account = $user ? $user->instagramAccount : null;
        $posts = $account ? $this->instagramService->fetchUserPosts($account) : [];
        $insights = $account ? $this->instagramService->fetchAccountInsights($account, $posts) : [];

        return view('analytics.audience', compact('user', 'account', 'posts', 'insights'));
    }

    public function campaignPerformance()
    {
        $user = auth()->user();
        $account = $user ? $user->instagramAccount : null;
        $plans = ContentPlan::where('user_id', $user->id ?? 1)->orderBy('created_at', 'desc')->get();

        return view('analytics.campaigns', compact('user', 'account', 'plans'));
    }

    public function messagesComments()
    {
        $user = auth()->user();
        $account = $user ? $user->instagramAccount : null;
        $posts = $account ? $this->instagramService->fetchUserPosts($account) : [];
        $totalComments = array_sum(array_column($posts, 'comments_count'));

        return view('analytics.messages', compact('user', 'account', 'posts', 'totalComments'));
    }
}
