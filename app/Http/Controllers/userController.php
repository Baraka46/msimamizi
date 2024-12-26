<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    // UserController.php

public function createSupervisor(Request $request)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Create the new user
    $user = new User;
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password'));

    // Assign the 'supervisor' role
    $role = Role::where('name', 'supervisor')->first(); // Make sure this role exists in your Role table
    $user->role()->associate($role);
    $user->save();

    // Optionally, assign the supervisor to a specific school or other related data if needed
    // $user->school_id = $request->input('school_id');
    // $user->save();

    return redirect()->route('users.index')->with('success', 'Supervisor created successfully.');
}

}
