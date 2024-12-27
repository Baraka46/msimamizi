<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the list of supervisors.
     */
    public function index()
{
    // Ensure that only the owner can access the list of supervisors
    if (Auth::user()->role !== 'owner') {
        return redirect()->route('home')->with('error', 'You are not authorized to view this page.');
    }

    $ownerCompanyId = auth()->user()->company_id;
    
    // Get all supervisors (assuming supervisor role)
    $supervisors = User::where('role', 'supervisor')->get();

    // Get all disabled supervisors (role = user and company_id matches owner)
    $disabledSupervisors = User::where('company_id', $ownerCompanyId)
                               ->where('role', 'user')
                               ->get();

    // Pass both variables to the view
    return view('components.user.index', compact('supervisors', 'disabledSupervisors')); 
}


    /**
     * Show the form for creating a new supervisor.
     */
    public function create()
    {
        // Ensure that only the owner can create a new supervisor
        if (Auth::user()->role !== 'owner') {
            return redirect()->route('home')->with('error', 'You are not authorized to perform this action.');
        }

        return view('components.user.create'); // Assuming you already have the view
    }
    public function disableSupervisor($id)
    {
        // Find the supervisor by ID
        $supervisor = User::findOrFail($id);
    
        // Update the supervisor's role to 'user'
        $supervisor->role = 'user';
        $supervisor->save();
    
        // Fetch the updated list of all supervisors (same as in the index method)
        $ownerCompanyId = auth()->user()->company_id;
        $supervisors = User::where('role', 'supervisor')->get();
        $disabledSupervisors = User::where('company_id', $ownerCompanyId)
                                   ->where('role', 'user')
                                   ->get();
    
        // Return the view with both the supervisor and the lists of supervisors
        return view('components.user.index', compact('supervisors', 'disabledSupervisors'))
               ->with('success', 'Supervisor has been disabled.');
    }
    

    // Controller
    public function enableSupervisor($id)
    {
        // Find the user (supervisor) by the ID
        $user = User::findOrFail($id);
    
        // Ensure the user is currently a 'user' (disabled)
        if ($user->role === 'user') {
            // Change the role to 'supervisor' to enable the user
            $user->role = 'supervisor';
            $user->save();
    
            return redirect()->route('supervisors.index')->with('success', 'Supervisor enabled successfully');
        }
    
        // If the user is already a supervisor, you can return an error or just skip
        return redirect()->route('supervisors.index')->with('error', 'User is already a supervisor');
    }
    

    /**
     * Store a newly created supervisor in storage.
     */
    public function store(Request $request)
    {
        // Ensure that only the owner can create a supervisor
        if (Auth::user()->role !== 'owner') {
            return redirect()->route('home')->with('error', 'You are not authorized to perform this action.');
        }

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:15',
        'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $owner = Auth::user();
        // Create the supervisor user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->address = $request->input('address');
        $user->password = Hash::make($request->input('password'));
        $user->role = 'supervisor'; // Assign supervisor role
        $user->company_id = $owner->company_id;
        $user->save();

        return redirect()->route('supervisors.index')->with('success', 'Supervisor created successfully.');
    }
}
