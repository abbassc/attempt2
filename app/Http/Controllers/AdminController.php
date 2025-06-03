<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationAssignment;
use App\Models\DonationStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get all pending donations
        $pendingDonations = Donation::where('status', 'pending')
            ->latest()
            ->get();

        // Get all volunteers
        $volunteers = User::where('role', 'volunteer')->get();

        // Get statistics
        $totalDonations = Donation::count();
        $totalVolunteers = User::where('role', 'volunteer')->count();
        $totalCollected = Donation::where('status', 'collected')->count();
        $totalPending = Donation::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'pendingDonations',
            'volunteers',
            'totalDonations',
            'totalVolunteers',
            'totalCollected',
            'totalPending'
        ));
    }

    public function donations()
    {
        $donations = Donation::with(['donor', 'volunteer'])
            ->latest()
            ->paginate(10);

        return view('admin.donations', compact('donations'));
    }

    public function volunteers()
    {
        $volunteers = User::where('role', 'volunteer')
            ->withCount(['donations' => function($query) {
                $query->where('status', 'collected');
            }])
            ->get();

        return view('admin.volunteers', compact('volunteers'));
    }

    public function assignDonation(Request $request, Donation $donation)
    {
        $request->validate([
            'volunteer_id' => 'required|exists:users,id'
        ]);

        // Check if the selected user is a volunteer
        $volunteer = User::where('id', $request->volunteer_id)
            ->where('role', 'volunteer')
            ->firstOrFail();

        // Update donation status and assignment
        $donation->update([
            'volunteer_id' => $volunteer->id,
            'status' => 'assigned'
        ]);

        // Create donation assignment record
        DonationAssignment::create([
            'donation_id' => $donation->id,
            'volunteer_id' => $volunteer->id,
            'status' => 'assigned',
            'assigned_at' => now()
        ]);

        // Create status history record
        DonationStatus::create([
            'donation_id' => $donation->id,
            'status' => 'assigned',
            'updated_by' => Auth::id(),
            'notes' => "Assigned to volunteer: {$volunteer->name}"
        ]);

        return back()->with('success', 'Donation assigned successfully to ' . $volunteer->name);
    }

    public function statistics()
    {
        $donationStats = [
            'total' => Donation::count(),
            'pending' => Donation::where('status', 'pending')->count(),
            'assigned' => Donation::where('status', 'assigned')->count(),
            'collected' => Donation::where('status', 'collected')->count(),
            'types' => [
                'money' => Donation::where('type', 'money')->count(),
                'food' => Donation::where('type', 'food')->count(),
                'clothes' => Donation::where('type', 'clothes')->count(),
            ]
        ];

        $volunteerStats = [
            'total' => User::where('role', 'volunteer')->count(),
            'active' => User::where('role', 'volunteer')
                ->whereHas('donations', function($query) {
                    $query->where('status', 'assigned');
                })
                ->count(),
        ];

        return view('admin.statistics', compact('donationStats', 'volunteerStats'));
    }
} 