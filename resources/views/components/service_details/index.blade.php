<x-app-layout>
    <div class="container">
        <h1>Service Details</h1>

        <a href="{{ route('service_details.create') }}" class="btn btn-primary mb-3">Add New Service Detail</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Service</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($serviceDetails as $serviceDetail)
                    <tr>
                        <td>{{ $serviceDetail->item_name }}</td>
                        <td>{{ $serviceDetail->description }}</td>
                        <td>{{ number_format($serviceDetail->cost, 2) }}</td>
                        <td>{{ $serviceDetail->service->name }}</td>
                        <td>
                            <a href="{{ route('service_details.edit', $serviceDetail) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('service_details.destroy', $serviceDetail) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
