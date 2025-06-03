<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationAssignment;
use App\Models\DonationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    public function dashboard()
    {
        $volunteer = Auth::user();
        
        // Get available (unassigned) donations
        $availableDonations = Donation::whereNull('volunteer_id')
            ->where('status', 'pending')
            ->whereNotIn('id', function($query) use ($volunteer) {
                $query->select('donation_id')
                    ->from('donation_assignments')
                    ->where('volunteer_id', $volunteer->id);
            })
            ->latest()
            ->get();

        // Get assigned donations
        $assignedDonations = Donation::where('volunteer_id', $volunteer->id)
            ->where('status', 'assigned')
            ->latest()
            ->get();

        // Get completed donations
        $completedDonations = Donation::where('volunteer_id', $volunteer->id)
            ->where('status', 'collected')
            ->latest()
            ->get();

        return view('volunteer.dashboard', compact(
            'availableDonations',
            'assignedDonations',
            'completedDonations'
        ));
    }

    public function assignments()
    {
        $assignments = Auth::user()
            ->donationAssignments()
            ->with(['donation', 'donation.user'])
            ->latest()
            ->paginate(10);

        return view('volunteer-assignments', compact('assignments'));
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        $request->validate([
            'status' => ['required', 'in:collected,cancelled'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $assignment = $donation->currentAssignment();
        if (!$assignment || $assignment->volunteer_id !== Auth::id()) {
            return back()->with('error', 'You are not assigned to this donation.');
        }

        if ($request->status === 'collected') {
            $donation->update(['status' => 'collected']);
            $assignment->update([
                'status' => 'collected',
                'collected_at' => now(),
                'notes' => $request->notes,
            ]);

            DonationStatus::create([
                'donation_id' => $donation->id,
                'status' => 'collected',
                'updated_by' => Auth::id(),
                'notes' => $request->notes,
            ]);
        } else {
            $donation->update(['status' => 'pending', 'volunteer_id' => null]);
            $assignment->update([
                'status' => 'cancelled',
                'notes' => $request->notes,
            ]);

            DonationStatus::create([
                'donation_id' => $donation->id,
                'status' => 'pending',
                'updated_by' => Auth::id(),
                'notes' => $request->notes,
            ]);
        }

        return back()->with('success', 'Donation status updated successfully!');
    }

    public function availableDonations()
    {
        $donations = Donation::whereNull('volunteer_id')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('available-donations', compact('donations'));
    }

    public function reserveDonation(Donation $donation)
    {
        if ($donation->volunteer_id) {
            return back()->with('error', 'This donation is already assigned.');
        }

        $donation->update([
            'volunteer_id' => Auth::id(),
            'status' => 'assigned'
        ]);

        return back()->with('success', 'Donation reserved successfully.');
    }

    public function upcomingTasks()
    {
        $tasks = Auth::user()->assignedDonations()
            ->where('status', '!=', 'collected')
            ->with(['user', 'statuses'])
            ->latest()
            ->paginate(10);

        return view('upcoming-tasks', compact('tasks'));
    }

    public function pastTasks()
    {
        $tasks = Auth::user()->assignedDonations()
            ->where('status', 'collected')
            ->with(['user', 'statuses'])
            ->latest()
            ->paginate(10);

        return view('past-tasks', compact('tasks'));
    }

    public function collectDonation(Donation $donation)
    {
        if ($donation->volunteer_id !== Auth::id()) {
            return back()->with('error', 'You are not assigned to this donation.');
        }

        $donation->update([
            'status' => 'collected',
        ]);

        $assignment = $donation->assignments()
            ->where('volunteer_id', Auth::id())
            ->latest()
            ->first();

        $assignment->update([
            'status' => 'collected',
            'collected_at' => now(),
        ]);

        DonationStatus::create([
            'donation_id' => $donation->id,
            'status' => 'collected',
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('volunteer.dashboard')
            ->with('success', 'Donation marked as collected!');
    }

    public function markAsCompleted(Donation $donation)
    {
        if ($donation->volunteer_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $donation->update([
            'status' => 'collected'
        ]);

        return back()->with('success', 'Donation marked as completed.');
    }
} 