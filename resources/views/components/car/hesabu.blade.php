<x-app-layout>
    <div class="container">
        <h1>Daily Hesabu Entry</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('hesabu.store') }}">
            @csrf

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ old('date') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" class="form-control" value="{{ old('description') }}" required>
            </div>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" class="form-control" step="0.01" value="{{ old('amount') }}" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="business" {{ old('category') == 'business' ? 'selected' : '' }}>Business</option>
                    <option value="personal" {{ old('category') == 'personal' ? 'selected' : '' }}>Personal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                    <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save Hesabu</button>
        </form>
    </div>
</x-app-layout>
