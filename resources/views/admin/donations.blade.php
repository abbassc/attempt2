<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Donations</title>
  <link rel="stylesheet" href="{{asset('../css/styles.css')}}">
</head>
<body>
  <header>
    <h1>Manage Donations</h1>
    <nav>
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.volunteers') }}">Volunteers</a></li>
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
      <h2>All Donations</h2>
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
      @if($donations->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Type</th>
              <th>Description</th>
              <th>Location</th>
              <th>Date</th>
              <th>Time</th>
              <th>Donor</th>
              <th>Volunteer</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($donations as $donation)
              <tr>
                <td>{{ $donation->type }}</td>
                <td>{{ $donation->description }}</td>
                <td>{{ $donation->location }}</td>
                <td>{{ $donation->date }}</td>
                <td>{{ $donation->time }}</td>
                <td>{{ $donation->donor ? $donation->donor->name : 'Anonymous' }}</td>
                <td>{{ $donation->volunteer ? $donation->volunteer->name : 'Not Assigned' }}</td>
                <td>{{ $donation->status }}</td>
                <td>
                  @if($donation->status === 'pending')
                    <form action="{{ route('admin.donations.assign', $donation) }}" method="POST" style="display: flex; gap: 0.5rem; align-items: center;">
                      @csrf
                      <select name="volunteer_id" required style="flex: 1;">
                        <option value="">Select Volunteer</option>
                        @foreach($volunteers as $volunteer)
                          <option value="{{ $volunteer->id }}">{{ $volunteer->name }}</option>
                        @endforeach
                      </select>
                      <button type="submit" class="button">Assign</button>
                    </form>
                  @else
                    <span>{{ ucfirst($donation->status) }}</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{ $donations->links() }}
      @else
        <p>No donations found.</p>
      @endif
    </section>
  </main>
  <footer>
    <p>&copy; 2025 Nahej Ali Organization</p>
  </footer>
</body>
</html> 