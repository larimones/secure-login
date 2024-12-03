<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showWelcomePage()
    {
        $user = Auth::user();

        return view('dashboard', ['user' => $user]);
    }

    public function showAdminDashboard()
    {
        $user = Auth::user();

        return view('admin-dashboard', ['user' => $user]);
    }
}