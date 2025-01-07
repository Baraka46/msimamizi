<x-app-layout>
    <h1>Cars</h1>
    @foreach ($cars as $car)
        <h2>{{ $car->make }} {{ $car->model }}</h2>
        <p>License Plate: {{ $car->license_plate }}</p>
        <form method="POST" action="{{ route('cars.assignSupervisor', $car) }}">
            @csrf
            <label for="supervisors">Assign Supervisors:</label>
            <select name="supervisors[]" multiple>
                @foreach (\App\Models\Supervisor::all() as $supervisor)
                    <option value="{{ $supervisor->id }}" 
                        {{ $car->supervisors->contains($supervisor->id) ? 'selected' : '' }}>
                        {{ $supervisor->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Assign</button>
        </form>
    @endforeach
</x-app-layout>
