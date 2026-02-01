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

        
        $vehicleUsage = Booking::select('vehicle_id')
            ->selectRaw('count(*) as total')
            ->groupBy('vehicle_id')
            ->with('vehicle') 
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->vehicle->name => $item->total];
            });

        $chartLabels = $vehicleUsage->keys();
        $chartData = $vehicleUsage->values();

        return view('dashboard', compact('bookings', 'chartLabels', 'chartData'));
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

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create Booking',
            'description' => 'Membuat pesanan baru'
        ]);

        return redirect()->route('dashboard')->with('success', 'Pesanan berhasil dibuat, menunggu persetujuan Level 1.');
    }

    public function approve(Booking $booking)
    {
        $user = Auth::user();

        if ($user->id == $booking->approver_1_id && $booking->status == 'pending_lvl_1') {
            $booking->update(['status' => 'pending_lvl_2']);
            $message = 'Disetujui Level 1. Menunggu Level 2.';
        } 
        elseif ($user->id == $booking->approver_2_id && $booking->status == 'pending_lvl_2') {
            $booking->update(['status' => 'approved']);
            $message = 'Disetujui Level 2. Booking Final.';
        } else {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk tahap ini.');
        }

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Approve Booking',
            'description' => 'Menyetujui Booking ID: ' . $booking->id
        ]);

        return back()->with('success', $message);
    }

    public function reject(Booking $booking)
    {
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

    public function exportExcel()
    {
        $fileName = 'laporan_pemesanan_kendaraan.csv';
        $bookings = Booking::with(['vehicle', 'driver', 'approver1', 'approver2'])->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // UPDATE HEADER KOLOM
        $columns = ['ID', 'Kendaraan', 'Lokasi', 'Plat Nomor', 'Driver', 'Tanggal Mulai', 'Tanggal Selesai', 'Status', 'Penyetuju 1', 'Penyetuju 2'];

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->vehicle->name ?? '-',
                    
                    // UPDATE DATA LOKASI
                    $booking->vehicle->location ?? '-', 
                    
                    $booking->vehicle->license_plate ?? '-',
                    $booking->driver->name ?? '-',
                    $booking->start_date,
                    $booking->end_date,
                    $booking->status,
                    $booking->approver1->name ?? '-',
                    $booking->approver2->name ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}