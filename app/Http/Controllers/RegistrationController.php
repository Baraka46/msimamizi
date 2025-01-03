<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;


class RegistrationController extends Controller
{
    // Display the registration form
    public function showForm()
    {
        return view('components.company.create');
    }


    public function registerCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|email|max:255|unique:companies,email',
        ]);

        $company = Company::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone,
            'email' => $request->email,
        ]);

        return response()->json(['success' => true, 'company_id' => $company->id]);
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make(Str::random(8)), // Temporary password
            'role' => 'owner',
            'company_id' => $request->company_id,
        ]);

        // Send email with temporary password (optional)

        return response()->json(['success' => true]);
    }
    
    
}
