<?php

use App\Http\Controllers\InstagramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlannerController;
use App\Http\Controllers\CompetitorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Instagram OAuth Entry & Callback (Publicly accessible for Client OAuth Login)
Route::middleware(['web'])->group(function () {
    Route::get('/auth/instagram', [InstagramController::class, 'redirect'])->name('instagram.connect');
    Route::get('/auth/instagram/callback', [InstagramController::class, 'callback'])->name('instagram.callback');
});

// Protected Application Routes (Authentication Required)
Route::middleware(['auth'])->group(function () {
    // Dashboard Overview
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Analytics & Detailed Modules
    Route::get('/analytics/content', [AnalyticsController::class, 'contentPerformance'])->name('analytics.content');
    Route::get('/analytics/engagement', [AnalyticsController::class, 'engagementAnalytics'])->name('analytics.engagement');
    Route::get('/analytics/reach', [AnalyticsController::class, 'reachImpressions'])->name('analytics.reach');
    Route::get('/analytics/audience', [AnalyticsController::class, 'audienceInsights'])->name('analytics.audience');
    Route::get('/campaigns', [AnalyticsController::class, 'campaignPerformance'])->name('campaigns.index');
    Route::get('/messages', [AnalyticsController::class, 'messagesComments'])->name('messages.index');

    // Content Planner & SPK Decision Engine (Stage 1 & 2)
    Route::get('/planner', [PlannerController::class, 'index'])->name('planner.index');
    Route::post('/planner', [PlannerController::class, 'store'])->name('planner.store');
    Route::post('/planner/ai-generate', [PlannerController::class, 'generateAiContent'])->name('planner.ai-generate');
    Route::post('/planner/auto-hermes', [PlannerController::class, 'autoGenerateHermes'])->name('planner.auto-hermes');
    Route::delete('/planner/{plan}', [PlannerController::class, 'destroy'])->name('planner.destroy');

    // Competitor Intelligence & AI Gap Analysis (Stage 3)
    Route::get('/competitors', [CompetitorController::class, 'index'])->name('competitors.index');
    Route::post('/competitors', [CompetitorController::class, 'store'])->name('competitors.store');
    Route::post('/competitors/auto-hermes', [CompetitorController::class, 'autoGenerateHermes'])->name('competitors.auto-hermes');
    Route::delete('/competitors/{competitor}', [CompetitorController::class, 'destroy'])->name('competitors.destroy');

    // Instagram Disconnect & Sync
    Route::post('/auth/instagram/sync', [InstagramController::class, 'sync'])->name('instagram.sync');
    Route::post('/auth/instagram/disconnect', [InstagramController::class, 'disconnect'])->name('instagram.disconnect');

    // AI Analysis (Single Post & Overall Portfolio Audit)
    Route::post('/analysis', [AnalysisController::class, 'analyze'])->name('analysis.process');
    Route::post('/analysis/portfolio', [AnalysisController::class, 'analyzePortfolio'])->name('analysis.portfolio');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';
