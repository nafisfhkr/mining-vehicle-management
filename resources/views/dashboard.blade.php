<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pemesanan Kendaraan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            @if(auth()->user()->role == 'admin')
            <div class="mb-6 flex gap-4">
                <a href="{{ route('bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    + Buat Pesanan Baru
                </a>
                <a href="{{ route('bookings.export') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                    Download Laporan Excel
                </a>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <h3 class="text-lg font-bold mb-4">Grafik Pemakaian Kendaraan</h3>
                <canvas id="usageChart" height="100"></canvas>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyetuju</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->vehicle->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->vehicle->license_plate }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->driver->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Mulai: {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}<br>
                                    Selesai: {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = match($booking->status) {
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-yellow-100 text-yellow-800',
                                        };
                                        $statusLabel = match($booking->status) {
                                            'pending_lvl_1' => 'Menunggu Level 1',
                                            'pending_lvl_2' => 'Menunggu Level 2',
                                            'approved' => 'Disetujui',
                                            'rejected' => 'Ditolak',
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    1. {{ $booking->approver1->name }}<br>
                                    2. {{ $booking->approver2->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if(auth()->user()->role == 'approver')
                                        @if(
                                            (auth()->id() == $booking->approver_1_id && $booking->status == 'pending_lvl_1') ||
                                            (auth()->id() == $booking->approver_2_id && $booking->status == 'pending_lvl_2')
                                        )
                                            <div class="flex space-x-2">
                                                <form action="{{ route('bookings.approve', $booking->id) }}" method="POST">
                                                    @csrf
                                                    <button class="text-green-600 hover:text-green-900">Setuju</button>
                                                </form>
                                                <form action="{{ route('bookings.reject', $booking->id) }}" method="POST">
                                                    @csrf
                                                    <button class="text-red-600 hover:text-red-900">Tolak</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400">Menunggu antrian</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data pemesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('usageChart');
    
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Toyota Hilux', 'Truk Hino', 'Bus Karyawan'], 
                datasets: [{
                    label: 'Jumlah Pemakaian',
                    data: [12, 19, 3], 
                    borderWidth: 1,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });
    </script>
</x-app-layout>