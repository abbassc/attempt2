<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Make a Donation</title>
  <link rel="stylesheet" href="{{asset('../css/styles.css')}}">
</head>
<body>
  <header>
    <h1>Make a Donation</h1>
    <nav>
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>
        <li><a href="{{ route('login') }}">Login</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section>
      <h2>Donate Now</h2>

      <form action="{{ route('donations.store') }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter your family name" value="{{ old('name') }}" required>
        @error('name')
            <span class="error">{{ $message }}</span>
        @enderror

        <label>Phone:</label>
        <input type="text" name="phone" placeholder="Enter your phone number" value="{{ old('phone') }}" required>
        @error('phone')
            <span class="error">{{ $message }}</span>
        @enderror

        <label>Donation Type:</label>
        <select name="type" required>
          <option value="">-- Select --</option>
          <option value="money" {{ old('type') == 'money' ? 'selected' : '' }}>Money</option>
          <option value="food" {{ old('type') == 'food' ? 'selected' : '' }}>Food</option>
          <option value="clothes" {{ old('type') == 'clothes' ? 'selected' : '' }}>Clothes</option>
        </select>
        @error('type')
            <span class="error">{{ $message }}</span>
        @enderror

        <label>Amount / Description:</label>
        <input type="text" name="description" placeholder="Enter amount or description" value="{{ old('description') }}" required>
        @error('description')
            <span class="error">{{ $message }}</span>
        @enderror

        <label>Occasion:</label>
        <input type="text" name="occasion" placeholder="Enter occasion title" value="{{ old('occasion') }}">
        @error('occasion')
            <span class="error">{{ $message }}</span>
        @enderror

        <label>Location:</label>
        <input type="text" name="location" placeholder="Enter your location" value="{{ old('location') }}" required>
        @error('location')
            <span class="error">{{ $message }}</span>
        @enderror

        <label>Date:</label>
        <input type="date" name="date" value="{{ old('date') }}" required>
        @error('date')
            <span class="error">{{ $message }}</span>
        @enderror

        <label>Time:</label>
        <input type="text" name="time" placeholder="Enter the prefered time" value="{{ old('time') }}" required>
        @error('time')
            <span class="error">{{ $message }}</span>
        @enderror

        <button type="submit">Submit Donation</button>
      </form>
      
    </section>
  </main>
  <footer>
    <p>&copy; 2025 Nahej Ali Organization</p>
  </footer>
</body>
</html>
