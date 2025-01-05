<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;

class RegistrationController extends Controller
{
    public function showForm(Request $request)
    {
        // Determine the step (default is 1)
        $step = $request->query('step', 1);

        // If step 2, fetch the company email passed in the query string
        $companyEmail = $request->query('email', null);

        return view('components.company.create', compact('step', 'companyEmail'));
    }

    public function handleStep(Request $request)
    {
        if ($request->input('step') == 1) {
            // Step 1: Handle company registration
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:companies,email',
                'address' => 'required|string|max:255',
            ]);
    
            // Create the company and ensure it is saved
            $company = Company::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
            ]);
           
            // Redirect to step 2 with the company's ID
            return redirect()->route('register.form', [
                'step' => 2,
                'company_id' => $company->id,
            ]);
        } elseif ($request->input('step') == 2) {
            // Step 2: Handle owner registration
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'company_id' => 'required|exists:companies,id', // Ensure the company ID exists
            ]);
    

           
            // Create the user and assign them the role of 'owner'
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'company_id' => $validated['company_id'], // Assign company_id from the request
                'role' => 'owner', // Set role to 'owner'
            ]);
         
            return redirect()->route('login')->with('success', 'Company and Owner registered successfully.');
        }
    }
    
}
