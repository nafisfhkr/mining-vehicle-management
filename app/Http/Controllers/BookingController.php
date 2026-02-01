<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        
        
        if ($user->role == 'admin') {
            
            $bookings = Booking::with(['vehicle', 'driver', 'approver1', 'approver2'])
                        ->latest()
                        ->get();
        } else {
            
            $bookings = Booking::with(['vehicle', 'driver', 'creator'])
                ->where(function($q) use ($user) {
                    $q->where('approver_1_id', $user->id)
                      ->where('status', 'pending_lvl_1');
                })
                ->orWhere(function($q) use ($user) {
                    $q->where('approver_2_id', $user->id)
                      ->where('status', 'pending_lvl_2');
                })
                ->get();
        }

        return view('dashboard', compact('bookings'));
    }

    
    public function create()
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        
        $approvers = User::where('role', 'approver')->get();
        
        return view('bookings.create', compact('vehicles', 'drivers', 'approvers'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'approver_1_id' => 'required|different:approver_2_id', 
            'approver_2_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $request->vehicle_id,
            'driver_id' => $request->driver_id,
            'approver_1_id' => $request->approver_1_id,
            'approver_2_id' => $request->approver_2_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending_lvl_1', // Status Awal
        ]);

        // Catat Log (Poin Plus)
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create Booking',
            'description' => 'Membuat pesanan baru'
        ]);

        return redirect()->route('dashboard')->with('success', 'Pesanan berhasil dibuat, menunggu persetujuan Level 1.');
    }

    // Proses Penyetujuan (Approval Logic)
    public function approve(Booking $booking)
    {
        $user = Auth::user();

        // Cek Level 1
        if ($user->id == $booking->approver_1_id && $booking->status == 'pending_lvl_1') {
            $booking->update(['status' => 'pending_lvl_2']);
            $message = 'Disetujui Level 1. Menunggu Level 2.';
        } 
        // Cek Level 2
        elseif ($user->id == $booking->approver_2_id && $booking->status == 'pending_lvl_2') {
            $booking->update(['status' => 'approved']);
            $message = 'Disetujui Level 2. Booking Final.';
        } else {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk tahap ini.');
        }

        // Catat Log
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Approve Booking',
            'description' => 'Menyetujui Booking ID: ' . $booking->id
        ]);

        return back()->with('success', $message);
    }

    // Proses Penolakan
    public function reject(Booking $booking)
    {
        // Siapapun approver-nya (1 atau 2) bisa menolak langsung
        if (Auth::id() == $booking->approver_1_id || Auth::id() == $booking->approver_2_id) {
            $booking->update(['status' => 'rejected']);
            
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Reject Booking',
                'description' => 'Menolak Booking ID: ' . $booking->id
            ]);

            return back()->with('success', 'Booking ditolak.');
        }
        
        return back()->with('error', 'Unauthorized');
    }
}