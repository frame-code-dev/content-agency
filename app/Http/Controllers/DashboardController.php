<?php

namespace App\Http\Controllers;

use App\Services\InstagramService;
use App\Models\User;
use App\Models\InstagramAccount;
use App\Models\ContentPlan;
use App\Models\Competitor;
use Illuminate\Http\Request;
use Exception;

class DashboardController extends Controller
{
    protected InstagramService $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Fetch connected Instagram account for this user from database ONLY
        $account = $user->instagramAccount;

        $posts = [];
        $postsPaginator = null;
        $insights = [];
        $error = null;

        if ($account) {
            try {
                // If account has not been synced to DB yet or has no stored posts, trigger sync
                if (!$account->last_synced_at || $account->posts()->count() === 0) {
                    $syncedData = $this->instagramService->syncAccountData($account);
                    $account = $syncedData['account'];
                    $insights = $syncedData['insights'];
                } else {
                    $insightsData = $account->insights_data ?? [];
                    $insights = array_merge([
                        'followers_count' => $account->followers_count,
                        'follows_count'   => $account->follows_count,
                        'media_count'     => $account->media_count,
                        'reach'           => $account->reach,
                        'impressions'     => $account->impressions,
                        'engagement_rate' => $account->engagement_rate,
                        'profile_views'   => $account->profile_views,
                        'is_live_api'     => $account->is_live_api,
                        'last_synced_at'  => $account->last_synced_at,
                    ], $insightsData);
                }

                $postsPaginator = $account->posts()->orderBy('posted_at', 'desc')->paginate(10);
                $posts = $account->posts()->orderBy('posted_at', 'desc')->get()->map(function ($p) {
                    return [
                        'id' => $p->instagram_post_id,
                        'caption' => $p->caption,
                        'media_type' => $p->media_type,
                        'media_url' => $p->media_url,
                        'permalink' => $p->permalink,
                        'like_count' => $p->like_count,
                        'comments_count' => $p->comments_count,
                        'timestamp' => $p->posted_at ? $p->posted_at->toIso8601String() : null,
                    ];
                })->toArray();

            } catch (Exception $e) {
                $error = $e->getMessage();
            }

            // Real Database Aggregations when account exists
            $contentPlansCount = ContentPlan::where('user_id', $user->id)->count();
            $scheduledPlansCount = ContentPlan::where('user_id', $user->id)->where('status', 'scheduled')->count();
            $competitorsCount = Competitor::where('user_id', $user->id)->count();
            $recentPlans = ContentPlan::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(4)->get();
        } else {
            $contentPlansCount = 0;
            $scheduledPlansCount = 0;
            $competitorsCount = 0;
            $recentPlans = collect();
        }

        $userRole = $user->roles->pluck('name')->first() ?? 'client';

        return view('dashboard', compact(
            'user',
            'userRole',
            'account',
            'posts',
            'postsPaginator',
            'insights',
            'contentPlansCount',
            'scheduledPlansCount',
            'competitorsCount',
            'recentPlans',
            'error'
        ));
    }
}
