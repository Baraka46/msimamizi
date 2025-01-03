<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the logged-in user
        $role = $user->role;    // Assume the 'role' field determines the user's role

        return view('dashboard', compact('user', 'role'));
    }
}
