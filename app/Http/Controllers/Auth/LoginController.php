<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // Restore car from DB to session if not set
        if ($user->car_model_id && !session()->has('selected_car_model')) {
            $carModel = \App\Models\CarModel::with('carType')->find($user->car_model_id);
            if ($carModel) {
                session([
                    'selected_car_model' => [
                        'id'             => $carModel->id,
                        'name'           => $carModel->name,
                        'type_name'      => optional($carModel->carType)->name ?? 'Car',
                        'price_modifier' => $carModel->price_modifier,
                    ]
                ]);
            }
        }

        // Restore any pending cart item (legacy support)
        if (session()->has('pending_cart_item')) {
            $cartItem = session('pending_cart_item');
            $cart = session()->get('cart', []);
            $cart[$cartItem['service_id']] = $cartItem;
            session()->put('cart', $cart);
            session()->forget('pending_cart_item');
            return redirect()->route('welcome');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isProvider()) {
            return redirect()->route('provider.dashboard');
        }

        if ($user->role === 'worker') {
            return redirect()->route('dashboard');
        }

        // customer / user
        return redirect()->route('welcome');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
