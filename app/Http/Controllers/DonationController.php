<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $pendingDonations = $user->donations()
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $assignedDonations = $user->donations()
            ->where('status', 'assigned')
            ->with('volunteer')
            ->latest()
            ->take(5)
            ->get();

        $collectedDonations = $user->donations()
            ->where('status', 'collected')
            ->latest()
            ->take(5)
            ->get();

        return view('donor.dashboard', compact(
            'pendingDonations',
            'assignedDonations',
            'collectedDonations'
        ));
    }

    public function index()
    {
        $donations = Donation::all();
        return view('donor.donations', compact('donations'));
    }

    public function create()
    {
        return view('new-donation');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:money,food,clothes',
            'description' => 'required|string',
            'occasion' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:20',
        ]);

        if (Auth::check()) {
            $validated['donor_id'] = Auth::id();
        }
        $validated['status'] = 'pending';

        $donation = Donation::create($validated);

        if (Auth::check()) {
            return redirect()->route('donor.dashboard')->with('success', 'Donation submitted successfully!');
        } else {
            return redirect()->route('home')->with('success', 'Donation submitted successfully! Please register to track your donations.');
        }
    }

    public function show(Donation $donation)
    {
        return view('donor.donations.show', compact('donation'));
    }
} 