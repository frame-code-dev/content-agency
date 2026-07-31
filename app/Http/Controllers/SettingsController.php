<?php

namespace App\Http\Controllers;

use App\Services\InstagramService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected InstagramService $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    public function index()
    {
        $user = auth()->user() ?? \App\Models\User::first();
        $account = $user ? $user->instagramAccount : \App\Models\InstagramAccount::first();

        $config = [
            'instagram_client_id' => config('services.instagram.client_id'),
            'instagram_mock_mode' => $this->instagramService->isMockMode(),
            'openai_api_key' => config('services.openai.key') ? '••••••••' . substr(config('services.openai.key'), -4) : 'Not Set',
        ];

        return view('settings', compact('user', 'account', 'config'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'agency_name' => 'nullable|string|max:255',
        ]);

        if (auth()->check() && $request->has('agency_name')) {
            auth()->user()->update(['name' => $request->agency_name]);
        }

        return redirect()->route('settings')->with('success', 'Settings updated successfully.');
    }
}
