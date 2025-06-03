<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Donation Statistics</title>
  <link rel="stylesheet" href="{{asset('../css/styles.css')}}">
</head>
<body>
  <header>
    <h1>Donation Statistics</h1>
    <nav>
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.donations') }}">Donations</a></li>
        <li><a href="{{ route('admin.volunteers') }}">Volunteers</a></li>
        <li>
          <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">Logout</button>
          </form>
        </li>
      </ul>
    </nav>
  </header>
  <main>
    <section>
      <h2>Donation Statistics</h2>
      <div class="stats-grid">
        <div class="card">
          <h3>Total Donations</h3>
          <p>{{ $donationStats['total'] }}</p>
        </div>
        <div class="card">
          <h3>Pending Donations</h3>
          <p>{{ $donationStats['pending'] }}</p>
        </div>
        <div class="card">
          <h3>Assigned Donations</h3>
          <p>{{ $donationStats['assigned'] }}</p>
        </div>
        <div class="card">
          <h3>Collected Donations</h3>
          <p>{{ $donationStats['collected'] }}</p>
        </div>
      </div>
    </section>

    <section>
      <h2>Volunteer Statistics</h2>
      <div class="stats-grid">
        <div class="card">
          <h3>Total Volunteers</h3>
          <p>{{ $volunteerStats['total'] }}</p>
        </div>
        <div class="card">
          <h3>Active Volunteers</h3>
          <p>{{ $volunteerStats['active'] }}</p>
        </div>
      </div>
    </section>

    <section>
      <h2>Donation Types</h2>
      <table>
        <thead>
          <tr>
            <th>Type</th>
            <th>Count</th>
            <th>Percentage</th>
          </tr>
        </thead>
        <tbody>
          @foreach($donationStats['types'] as $type => $count)
            <tr>
              <td>{{ ucfirst($type) }}</td>
              <td>{{ $count }}</td>
              <td>{{ number_format(($count / $donationStats['total']) * 100, 1) }}%</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 Nahej Ali Organization</p>
  </footer>
</body>
</html> 