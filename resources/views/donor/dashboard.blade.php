<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Donor Profile</title>
  <link rel="stylesheet" href="{{asset('../css/styles.css')}}">
</head>
<body>
  <header>
    <h1>Donor Profile</h1>
    <nav>
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('donations.create') }}">Donate</a></li>        
        <li><a href="#about">About</a></li>
        <li>
          <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">Logout</button>
          </form>
        </li>
      </ul>
    </nav>
  </header>
  <main class="section">
    @if(session('success'))
      <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
        {{ session('error') }}
      </div>
    @endif

    <div id="remaining-2">
      <h2>Make a donation</h2>
      <a href="{{ route('donations.create') }}" class="btn">Make a Donation</a>
    </div>

    <section id="remaining" style="display: block;">
      <h2>Donor Details</h2>
      <p>Name: {{ Auth::user()->name }}</p>
      <p>Phone: {{ Auth::user()->phone }}</p>
      <p>Location: {{ Auth::user()->location }}</p>

      <h3>Past Donations</h3>
      @if($pendingDonations->count() > 0)
        <h4>Pending Donations</h4>
        <table>
          <tr><th>Type</th><th>Description</th><th>Date</th><th>Status</th></tr>
          @foreach($pendingDonations as $donation)
            <tr>
              <td>{{ $donation->type }}</td>
              <td>{{ $donation->description }}</td>
              <td>{{ $donation->date }}</td>
              <td>{{ $donation->status }}</td>
            </tr>
          @endforeach
        </table>
      @endif

      @if($assignedDonations->count() > 0)
        <h4>Assigned Donations</h4>
        <table>
          <tr><th>Type</th><th>Description</th><th>Date</th><th>Volunteer</th><th>Status</th></tr>
          @foreach($assignedDonations as $donation)
            <tr>
              <td>{{ $donation->type }}</td>
              <td>{{ $donation->description }}</td>
              <td>{{ $donation->date }}</td>
              <td>{{ $donation->volunteer->name }}</td>
              <td>{{ $donation->status }}</td>
            </tr>
          @endforeach
        </table>
      @endif

      @if($collectedDonations->count() > 0)
        <h4>Collected Donations</h4>
        <table>
          <tr><th>Type</th><th>Description</th><th>Date</th><th>Volunteer</th><th>Status</th></tr>
          @foreach($collectedDonations as $donation)
            <tr>
              <td>{{ $donation->type }}</td>
              <td>{{ $donation->description }}</td>
              <td>{{ $donation->date }}</td>
              <td>{{ $donation->volunteer->name }}</td>
              <td>{{ $donation->status }}</td>
            </tr>
          @endforeach
        </table>
      @endif
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Nahej Ali Organization</p>
  </footer>
</body>
</html> 