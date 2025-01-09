<!-- resources/views/cars/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Car Details</h1>
    <p><strong>Plate Number:</strong> {{ $car->plate_number }}</p>
    <p><strong>Model:</strong> {{ $car->model }}</p>
    <p><strong>Route:</strong> {{ $car->route }}</p>
    <p><strong>Daily Hesabu Target:</strong> {{ $car->daily_hesabu_target }}</p>

    <h2>Assign Supervisor</h2>
    <form action="{{ route('cars.show',  ['id' => $car->id])" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="assigned_supervisor_id" class="form-label">Select Supervisor:</label>
            <select id="assigned_supervisor_id" name="assigned_supervisor_id" class="form-control">
                <option value="">-- Select Supervisor --</option>
                @foreach ($supervisors as $supervisor)
                    <option value="{{ $supervisor->id }}" 
                        {{ $car->assigned_supervisor_id == $supervisor->id ? 'selected' : '' }}>
                        {{ $supervisor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assign</button>
    </form>
</div>
@endsection
