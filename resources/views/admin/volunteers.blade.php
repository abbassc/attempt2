<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Volunteers</title>
  <link rel="stylesheet" href="{{asset('../css/styles.css')}}">
</head>
<body>
  <header>
    <h1>Manage Volunteers</h1>
    <nav>
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.donations') }}">Donations</a></li>
        <li><a href="{{ route('admin.statistics') }}">Statistics</a></li>
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
      <h2>All Volunteers</h2>
      @if($volunteers->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Location</th>
              <th>Availability</th>
              <th>Completed Donations</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($volunteers as $volunteer)
              <tr>
                <td>{{ $volunteer->name }}</td>
                <td>{{ $volunteer->email }}</td>
                <td>{{ $volunteer->phone }}</td>
                <td>{{ $volunteer->location }}</td>
                <td>{{ $volunteer->availability }}</td>
                <td>{{ $volunteer->donations_count }}</td>
                <td>
                  @if($volunteer->donations()->where('status', 'assigned')->count() > 0)
                    <span style="color: orange;">Active</span>
                  @else
                    <span style="color: green;">Available</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p>No volunteers found.</p>
      @endif
    </section>
  </main>
  <footer>
    <p>&copy; 2025 Nahej Ali Organization</p>
  </footer>
</body>
</html> 