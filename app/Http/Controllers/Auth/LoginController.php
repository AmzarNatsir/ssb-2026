<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cache;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'nik';
    }

    protected function redirectTo()
    {
        $defaultApp = Cache::get('default-app-' . auth()->user()->id);
        $protocol = preg_match('/(?=(http))/', request()->headers->get('referer')) ? 'http://' : 'https://';
        if ($defaultApp) {
            switch ($defaultApp) {
                case 'hrd':
                    $path = '/hrd/home';
                    break;
                case 'project':
                    $path =  $protocol . 'tender.' . env('APP_DOMAIN') . '/home';
                    break;
                case 'hse':
                    $path =  $protocol . 'hse.' . env('APP_DOMAIN') . '/home';
                    break;
                case 'workshop':
                    $path =  $protocol . 'workshop.' . env('APP_DOMAIN') . '/home';
                    break;
                case 'warehouse':
                    $path =  $protocol . 'warehouse.' . env('APP_DOMAIN') . '/home';
                    break;

                default:
                    $path =  '/home';
                    break;
            }

            return $path;
        }
        
        return '/home';
    }
}
