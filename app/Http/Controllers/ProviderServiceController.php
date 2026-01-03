<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProviderService;
use App\Models\Service;
use App\Models\ServiceProvider;

class ProviderServiceController extends Controller
{
    private function getProvider(): ServiceProvider
    {
        $sp = Auth::user()->serviceProvider;
        abort_unless($sp, 403);
        return $sp;
    }

    public function index()
    {
        $provider = $this->getProvider();
        $allServices = Service::orderBy('name')->get();
        $enabledIds  = $provider->providerServices()->where('is_available', true)->pluck('service_id')->toArray();

        return view('provider.services.index', compact('provider', 'allServices', 'enabledIds'));
    }

    public function toggle(Request $request, Service $service)
    {
        $provider = $this->getProvider();

        $existing = ProviderService::where('service_provider_id', $provider->id)
            ->where('service_id', $service->id)
            ->first();

        if ($existing) {
            $existing->update(['is_available' => !$existing->is_available]);
            $msg = $existing->is_available ? 'Service enabled.' : 'Service disabled.';
        } else {
            ProviderService::create([
                'service_provider_id' => $provider->id,
                'service_id'          => $service->id,
                'is_available'        => true,
            ]);
            $msg = 'Service added to your offerings.';
        }

        return back()->with('success', $msg);
    }

    public function updateHours(Request $request)
    {
        $provider = $this->getProvider();
        $validated = $request->validate([
            'open_time'  => 'required',
            'close_time' => 'required',
        ]);
        
        $provider->update($validated);
        
        return back()->with('success', 'Working hours updated successfully.');
    }
}
