<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $unreadNotifications = auth()->user()->unreadNotifications;
        // dd($unreadNotifications);
        return view('Warehouse.main');
    }

    public function readNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return true;
    }
}
