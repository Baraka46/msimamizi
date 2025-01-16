
    <div class="container">
        <h1>Edit Service Detail</h1>

        <form action="{{ route('service_details.update', $serviceDetail) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="service_id">Service</label>
                <select name="service_id" id="service_id" class="form-control" required>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{ $service->id == $serviceDetail->service_id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" name="item_name" id="item_name" class="form-control" value="{{ $serviceDetail->item_name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $serviceDetail->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="cost">Cost</label>
                <input type="number" name="cost" id="cost" class="form-control" step="0.01" value="{{ $serviceDetail->cost }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</x-app-layout>
