<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceProvider;

class CartController extends Controller
{
    /**
     * Add a service to the provider's cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:service_providers,id',
            'service_id'  => 'required|exists:services,id',
        ]);

        $pid = $request->provider_id;
        $sid = (int) $request->service_id;

        $cartKey = "cart_provider_{$pid}";
        $cart = session()->get($cartKey, []);

        if (!in_array($sid, $cart)) {
            $cart[] = $sid;
            session()->put($cartKey, $cart);
        }

        return response()->json([
            'success'   => true,
            'cartCount' => count($cart),
            'cart'      => $cart,
        ]);
    }

    /**
     * Remove a service from the provider's cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:service_providers,id',
            'service_id'  => 'required|exists:services,id',
        ]);

        $pid = $request->provider_id;
        $sid = (int) $request->service_id;

        $cartKey = "cart_provider_{$pid}";
        $cart = session()->get($cartKey, []);

        if (($key = array_search($sid, $cart)) !== false) {
            unset($cart[$key]);
            $cart = array_values($cart); // Re-index array
            session()->put($cartKey, $cart);
        }

        return response()->json([
            'success'   => true,
            'cartCount' => count($cart),
            'cart'      => $cart,
        ]);
    }

    /**
     * Get the current cart for a provider with full service details.
     */
    public function get(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:service_providers,id',
        ]);

        $pid = $request->provider_id;
        $cartKey = "cart_provider_{$pid}";
        $cartIds = session()->get($cartKey, []);

        if (empty($cartIds)) {
            return response()->json([
                'items' => [],
                'total_duration' => 0,
                'total_base_price' => 0,
            ]);
        }

        $services = Service::whereIn('id', $cartIds)->get();

        // Sort items to match the order they were added if desired, but default DB order is fine here for summary
        $items = [];
        $totalDuration = 0;
        $totalBasePrice = 0;

        foreach ($services as $service) {
            $items[] = [
                'id' => $service->id,
                'name' => $service->name,
                'price' => $service->base_price,
                'duration' => $service->duration_minutes,
            ];
            $totalDuration += $service->duration_minutes;
            $totalBasePrice += $service->base_price;
        }

        return response()->json([
            'items' => $items,
            'total_duration' => $totalDuration,
            'total_base_price' => $totalBasePrice,
        ]);
    }
}

// update: cart system (2026-05-08)

// update: cart system (2026-04-20)
