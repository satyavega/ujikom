<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\FormController;
use App\Models\Post;
use Illuminate\View\View;


class AdminController extends Controller
{
    public function AdminDashboard(){

        return view('admin.index');

    }
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function AdminLogin(){

        return view('admin.admin_login');

    }
    public function AdminProfile(){

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }
    public function AdminForm(){

        return view('admin.admin_form');
    }
    public function FormAddMember(){

        return view('admin.form_member');
    }
    public function dashboard(): View{

        $posts = Post::latest()->paginate(5);

        return view('admin.admin_dashboard', compact('posts'));
    }
    // public function index(){

    //     $users = User::all(); // Mendapatkan semua data pengguna dari model User

    //     return view('admin.index', compact('users'));
    // }
    public function index(){

        $posts = Post::paginate(10); // Misalnya, batasi 10 data per halaman

        return view('admin.index', compact('posts'));
    }


    public function edit(string $id){

        $post = Post::findOrFail($id);

        return view('admin.body.edit', compact('post'));
    }

}
