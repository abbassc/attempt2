<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Page</title>
  <link rel="stylesheet" href="{{asset('../css/styles.css')}}">
</head>
<body>
  <header>
    <h1>Admin Page</h1>
    <nav>
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#dashboard">Dashboard</a></li>
        <li><a href="#panel">Panel</a></li>
        <li><a href="#report">Reports</a></li>
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
    <div class="dashboard" id="dashboard">
      <h1>Dashboard</h1>

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

      <section id="donations">
        <h2>New Donations</h2>
        @if($pendingDonations->count() > 0)
          <ul>
            @foreach($pendingDonations as $donation)
              <li>
                <div class="card">
                  <h3>{{ $donation->type }} Donation</h3>
                  <p>Location: {{ $donation->location }}</p>
                  <p>Date: {{ $donation->date }}</p>
                  <p>Time: {{ $donation->time }}</p>
                  <p>Description: {{ $donation->description }}</p>
                  <form action="{{ route('admin.donations.assign', $donation) }}" method="POST" style="display: flex; gap: 0.5rem; align-items: center;">
                    @csrf
                    <select name="volunteer_id" required style="flex: 1;">
                      <option value="">Select Volunteer</option>
                      @foreach($volunteers as $volunteer)
                        <option value="{{ $volunteer->id }}">{{ $volunteer->name }}</option>
                      @endforeach
                    </select>
                    <button type="submit" class="button">Assign to Volunteer</button>
                  </form>
                </div>
              </li>
            @endforeach
          </ul>
        @else
          <p>No pending donations at the moment.</p>
        @endif
      </section>

      <section id="volunteers">
        <h2>Volunteers</h2>
        @if($volunteers->count() > 0)
          <table>
            <thead>
              <tr>
                <th>Volunteer Name</th>
                <th>Location</th>
                <th>Availability</th>
                <th>Phone</th>
              </tr>
            </thead>
            <tbody>
              @foreach($volunteers as $volunteer)
                <tr>
                  <td>{{ $volunteer->name }}</td>
                  <td>{{ $volunteer->location }}</td>
                  <td>{{ $volunteer->availability }}</td>
                  <td>{{ $volunteer->phone }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <p>No volunteers registered yet.</p>
        @endif
      </section>

      <div class="card">
        <h3>Donation Statistics</h3>
        <p>Total Donations: {{ $totalDonations }}</p>
        <p>Pending Donations: {{ $totalPending }}</p>
        <p>Collected Donations: {{ $totalCollected }}</p>
        <a href="{{ route('admin.statistics') }}" class="button">View Details</a>
      </div>

      <div class="card">
        <h3>Volunteer Statistics</h3>
        <p>Total Volunteers: {{ $totalVolunteers }}</p>
        <a href="{{ route('admin.volunteers') }}" class="button">View Details</a>
      </div>
    </div>

    <section class="mainandsidebar" id="panel">
      <!-- Sidebar -->
      <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="{{ route('admin.donations') }}">Manage Donations</a>
        <a href="{{ route('admin.volunteers') }}">Manage Volunteers</a>
        <a href="{{ route('admin.statistics') }}">View Statistics</a>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <div class="section">
          <h3>Quick Actions</h3>
          <a href="{{ route('admin.donations') }}" class="button">View All Donations</a>
          <a href="{{ route('admin.volunteers') }}" class="button">View All Volunteers</a>
          <a href="{{ route('admin.statistics') }}" class="button">View Statistics</a>
        </div>
      </div>
    </section>
  </main>
  <footer>
    <p>&copy; 2025 Nahej Ali Organization</p>
  </footer>
</body>
</html>
