<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\News;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalNews = News::count();

        return view('dashboard', compact('totalUsers', 'totalNews'));
    }
}
