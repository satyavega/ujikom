<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
{
    $users = User::all();
    $totalUsers = User::count();
    return view('admin.index', ['users' => $users, 'totalUsers' => $totalUsers]);
}

}
