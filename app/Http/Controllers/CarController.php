<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\CarGroup;
use App\Models\GroupExpense;
use App\Services\VehicleOffenceCheckerService;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    // Only allow owners or admins to access cars
    

    /**
     * Show the list of cars for the logged-in user
     */
    public function index()
{
    $user = auth()->user();

    // Admin and Owner can see their cars
    if ($user->isOwner() || $user->isAdmin()) {
        $cars = Car::when($user->isOwner(), function ($query) use ($user) {
            // Restrict access for owners to only their own company
            $query->forOwner($user);
        })->get();

        return view('components.cars.index', compact('cars'));
    }

    // Supervisors can see cars they are supervising
    if ($user->isSupervisor()) {
        $cars = Car::where('assigned_supervisor_id', $user->id)->get();

        return view('components.cars.index', compact('cars'));
    }

    // If the user doesn't match any role, redirect to dashboard
    return redirect()->route('dashboard')->with('error', 'Unauthorized');
}



    /**
     * Show the form for creating a new car
     */
    public function create()
    {
        return view('components.cars.create');
    }

    /**
     * Store a newly created car
     */
    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|unique:cars,plate_number',
            'model' => 'nullable|string',
            'route' => 'required|string',
            'daily_hesabu_target' => 'required|integer',
            'assigned_supervisor_id' => 'nullable|exists:users,id',
        ]);

        $car = Car::create([
            'company_id' => auth()->user()->company_id, // Only allow owner to create cars for their company
            'plate_number' => $request->plate_number,
            'model' => $request->model,
            'route' => $request->route,
            'daily_hesabu_target' => $request->daily_hesabu_target,
            'assigned_supervisor_id' => $request->assigned_supervisor_id,
        ]);

        return redirect()->route('cars.index')->with('success', 'Car created successfully.');
    }

    /**
     * Show the details of a specific car
     */
public function show(Car $car)
{
    $car->load(['maintenances', 'inhouse_maintenance']);
    $external = $car->maintenances
                    ->sortByDesc('date')
                    ->values();

    $inhouse  = $car->inhouse_maintenance
                    ->sortByDesc('date')
                    ->values();
    return view('components.cars.show', compact('car','external','inhouse'));
}


public function assignSupervisorForm($id)
{
    $car = Car::findOrFail($id);
    $supervisors = User::where('role', 'supervisor')->get(); // Fetch available supervisors

    return view('components.cars.assign-supervisor', compact('car', 'supervisors'));
}

public function assignSupervisor(Request $request, $id)
{
    $car = Car::findOrFail($id);

    $request->validate([
        'supervisor_id' => 'required|exists:users,id',
    ]);

    $car->update(['assigned_supervisor_id' => $request->supervisor_id]);

    return redirect()->route('cars.show', $id)->with('success', 'Supervisor assigned successfully.');
}

    
    /**
     * Show the form for editing a car
     */
    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the details of a specific car
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'plate_number' => 'required|unique:cars,plate_number,' . $car->id,
            'model' => 'nullable|string',
            'route' => 'required|string',
            'daily_hesabu_target' => 'required|integer',
            'assigned_supervisor_id' => 'nullable|exists:users,id',
        ]);

        $car->update($request->all());

        return redirect()->route('cars.index')->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified car
     */
    public function destroy($id)
{
    $car = Car::findOrFail($id);
    // Check if the authenticated user is the owner
    if (auth()->user()->id !== $car->company_id) {
        return redirect()->route('cars.index')->with('error', 'Unauthorized action');
    }

    $car->delete();
    return redirect()->route('cars.index')->with('success', 'Car deleted successfully');
}
public function GroupCreate(){
    $user = auth()->user();

    if ($user->isOwner()) {
        // Retrieve cars for the owner's company
        $cars = Car::forOwner($user)->get();
    } elseif ($user->isSupervisor()) {
        // Retrieve cars assigned to the supervisor
        $cars = Car::where('assigned_supervisor_id', $user->id)->get();
    } else {
        // Default fallback (e.g., for other roles)
        $cars = collect(); // Empty collection
    }

    return view('components.cars.group-create', compact('cars'));
}
public function GroupStore(Request $request)
{
    $user = auth()->user();
    $companyId = $user->company_id;

    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'car_ids' => 'required|array', // Ensure car_ids is an array
        'car_ids.*' => 'exists:cars,id', // Validate that each ID exists in the cars table
        'description' => 'nullable|string|max:255',
    ]);
    $carGroup = CarGroup::create([
        'name' => $request->name,
        'description' => $request->description,
        'company_id' => $companyId,
    ]);

    Car::whereIn('id', $request->car_ids)->update(['car_group_id' => $carGroup->id]);

    return redirect()->route('GroupIndex.index')->with('success', 'Group created and cars assigned successfully!');
}


public function GroupIndex(Request $request)
{
    $user = auth()->user();

    if ($user->isOwner()) {
        $carGroups = CarGroup::where('company_id', $user->company_id)
            ->with(['cars', 'groupExpenses']) // Load both relationships
            ->get();
    } elseif ($user->isSupervisor()) {
        $carGroups = CarGroup::whereHas('cars', function ($query) use ($user) {
            $query->where('assigned_supervisor_id', $user->id);
        })->with(['cars', 'groupExpenses'])
        ->get();
    } else {
        $carGroups = collect();
    }

    return view('components.cars.group-index', compact('carGroups'));
}

    public function fetchOffenceData(VehicleOffenceCheckerService $scraper, Request $request)
    {
        $user = Auth::user();
        $carsQuery = Car::query();
        
        
        if ($user->isSupervisor()) {
            $carsQuery->where('assigned_supervisor_id', $user->id);
        } elseif ($user->isOwner()) {
            $carsQuery->where('company_id', $user->company_id);
        } elseif ($user->isAdmin()) {
        } else {
            abort(403, 'Unauthorized action');
        }
    
        $cars = $carsQuery->get();
        $plates = $cars->pluck('plate_number')
                       ->map(function ($plate) {
                           return strtolower(str_replace(' ', '', $plate));
                       })
                       ->unique()
                       ->values()
                       ->toArray();

                      
    
        try {
            $results = $scraper->fetchOffences($plates);
            // dd($results);

            session(['scraped_results' => $results]);

              return redirect()->route('offense.index')->with('success', 'Data refreshed successfully!');
        } catch (\Exception $e) {
            return redirect()->route('offense.index')->withErrors($e->getMessage());
        }
    }

    public function showOffense()
{
    $results = session('scraped_results');

    if (!$results) {
        return redirect()->route('cars.scrape'); 
    }

    return view('components.cars.scraped', compact('results'));
}

    public function showTicket($reference)
{
    $results = session('scraped_results', []);
    $allOffenses = collect($results)->flatMap(function ($item) {
        return $item['pending_transactions'] ?? [];
    });
    $ticket = $allOffenses->firstWhere('reference', $reference);

    if (!$ticket) {
        abort(404, 'Ticket not found or session expired.');
    }

    return view('components.cars.ticketShow', compact('ticket'));
}



}
