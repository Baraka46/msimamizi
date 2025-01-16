<?php

namespace App\Http\Controllers;

use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        $serviceDetails = ServiceDetail::all();
        return view('components.service_details.index', compact('serviceDetails'));
    }

    // Show the form for creating a new service detail
    public function create(Request $request)
{
    $serviceId = $request->get('service_id'); // Retrieve service_id from the query parameters
    $services = Service::all();             // Fetch all available services

    $selectedService = null;
    if ($serviceId) {
        $selectedService = Service::with('car')->find($serviceId); // Fetch the selected service and its car
    }

    return view('components.service_details.create', compact('services', 'selectedService'));
}


    // Store a newly created service detail in the database
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
        ]);

        ServiceDetail::create($request->all());

        return redirect()->route('service_details.index')
            ->with('success', 'Service Detail added successfully.');
    }

    // Show the form for editing the specified service detail
    public function edit(ServiceDetail $serviceDetail)
    {
        $services = Service::all(); // Get all services for selection
        return view('components.service_details.edit', compact('serviceDetail', 'services'));
    }

    // Update the specified service detail in the database
    public function update(Request $request, ServiceDetail $serviceDetail)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
        ]);

        $serviceDetail->update($request->all());

        return redirect()->route('service_details.index')
            ->with('success', 'Service Detail updated successfully.');
    }

    // Remove the specified service detail from the database
    public function destroy(ServiceDetail $serviceDetail)
    {
        $serviceDetail->delete();

        return redirect()->route('service_details.index')
            ->with('success', 'Service Detail deleted successfully.');
    }
}
