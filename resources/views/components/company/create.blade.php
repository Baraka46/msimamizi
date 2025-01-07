<form action="{{ route('register.handleStep') }}" method="POST">
    @csrf

    @if ($step == 1)
        <input type="hidden" name="step" value="1">
        <h2>Step 1: Register Your Company</h2>

        <label for="name">Company Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" requir ed>

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label for="address">Address:</label>
        <input type="text" name="address" value="{{ old('address') }}" required>

        <button type="submit">Next</button>
    @elseif ($step == 2)
        <input type="hidden" name="step" value="2">
        <h2>Step 2: Register the Owner</h2>

        <input type="hidden" name="company_email" value="{{ $companyEmail }}">

        <label for="name">Owner Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label for="email">Owner Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Register</button>
    @endif
</form>
