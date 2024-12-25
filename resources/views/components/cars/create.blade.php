<!-- resources/views/cars/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">Add New Car</h1>
    <form action="{{ route('cars.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="plate_number" class="form-label">Plate Number</label>
            <input type="text" class="form-control" id="plate_number" name="plate_number" required>
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" class="form-control" id="model" name="model">
        </div>
        <div class="mb-3">
            <label for="route" class="form-label">Route</label>
            <input type="text" class="form-control" id="route" name="route" required>
        </div>
        <div class="mb-3">
            <label for="daily_hesabu_target" class="form-label">Daily Hesabu Target</label>
            <input type="number" class="form-control" id="daily_hesabu_target" name="daily_hesabu_target" required>
        </div>
      
        <button type="submit" class="btn btn-success">Add Car</button>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary ms-2">Back to Car List</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
