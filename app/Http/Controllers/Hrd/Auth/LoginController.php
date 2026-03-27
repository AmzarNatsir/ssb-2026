<?php

namespace App\Http\Controllers\Hrd\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HRD\ProfilPerusahaanModel;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = 'hrd/utama';
    /*
    public function index()
    {
        $data['profil_perusahaan'] = ProfilPerusahaanModel::first();
        return view('HRD.auth.login', $data);
    }
    */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'nik';
    }
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('HRD.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/hrd');
    }

}
