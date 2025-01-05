<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
    // In User.php model

// Checking if the user is an Admin
public function isAdmin()
{
    return $this->role === 'admin' && is_null($this->company_id);
}

// Checking if the user is an Owner
public function isOwner()
{
    return $this->role === 'owner' && !is_null($this->company_id);
}
public function isSupervisor()
{
    // Assuming you have a `role` column that contains the user's role
    return $this->role === 'supervisor'&& !is_null($this->company_id);
}

// Method for Admins to access all companies
public function allCompanies()
{
    // Admin can access all companies but cannot perform owner-specific tasks
    if ($this->isAdmin()) {
        return Company::all(); // Admin gets all companies
    }

    return null; // Non-admin users don't have access to all companies
}

// Method for Owners to access their own company
public function ownCompany()
{
    // Only owners can access their own company, based on company_id
    if ($this->isOwner()) {
        return Company::find($this->company_id); // Owner can only access their own company
    }

    return null; // Non-owner users don't have access to a specific company
}
public function company()
{
    return $this->hasOne(Company::class);
}

// Method to assign a supervisor (Owner-specific functionality)
public function assignSupervisorToCar($supervisorData, $carId)
{
    if ($this->isOwner()) {
        // Add supervisor details to the car in their company
        $supervisor = new Supervisor($supervisorData);
        $supervisor->car_id = $carId;
        $supervisor->save();

        // Send a temporary password to the supervisor via email
        // Assuming Supervisor has an email and password field
        $supervisor->sendTemporaryPassword();

        return $supervisor;
    }

    return null; // Admin cannot assign supervisors
}

// Method to set the Hesabu rate (Owner-specific functionality)
public function setHesabuRate($rate)
{
    if ($this->isOwner()) {
        // Set the Hesabu rate for the owner's company
        $company = $this->ownCompany(); // Get the owner's company
        $company->hesabu_rate = $rate;
        $company->save();

        return $company;
    }

    return null; // Admin cannot set Hesabu rate
}


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
