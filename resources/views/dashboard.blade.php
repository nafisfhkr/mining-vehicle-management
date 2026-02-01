<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard Monitoring') }}
            </h2>
            @if(auth()->user()->role == 'admin')
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('bookings.export') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export Excel
                </a>
                <a href="{{ route('bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Pesanan
                </a>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="p-6 flex items-center">
                        <div class="p-4 rounded-full bg-indigo-50 text-indigo-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Pesanan</div>
                            <div class="text-3xl font-extrabold text-gray-800">{{ $bookings->count() }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="p-6 flex items-center">
                        <div class="p-4 rounded-full bg-amber-50 text-amber-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Perlu Persetujuan</div>
                            <div class="text-3xl font-extrabold text-gray-800">
                                {{ $bookings->whereIn('status', ['pending_lvl_1', 'pending_lvl_2'])->count() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="p-6 flex items-center">
                        <div class="p-4 rounded-full bg-emerald-50 text-emerald-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Disetujui</div>
                            <div class="text-3xl font-extrabold text-gray-800">
                                {{ $bookings->where('status', 'approved')->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 lg:col-span-1">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                            Statistik Pemakaian
                        </h3>
                        <div class="relative h-64 w-full">
                            <canvas id="vehicleChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 lg:col-span-2">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Riwayat Pemesanan Terkini
                        </h3>
                        
                        @if(session('success'))
                            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-4 flex items-center" role="alert">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="overflow-x-auto rounded-lg border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Driver</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Penyetuju</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($bookings as $booking)
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $booking->vehicle->name }}</div>
                                            <div class="text-xs text-gray-500 font-mono bg-gray-100 inline-block px-1 rounded">{{ $booking->vehicle->license_plate }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $booking->vehicle->location }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <div class="flex items-center">
                                                <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600 mr-2">
                                                    {{ substr($booking->driver->name, 0, 1) }}
                                                </div>
                                                {{ $booking->driver->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <div class="flex flex-col space-y-1">
                                                <div class="flex items-center text-xs">
                                                    <span class="w-4 h-4 rounded-full flex items-center justify-center mr-1 {{ $booking->status == 'pending_lvl_1' ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-400' }}">1</span>
                                                    <span class="{{ $booking->status == 'pending_lvl_1' ? 'font-bold text-gray-900' : '' }}">{{ $booking->approver1->name }}</span>
                                                </div>
                                                <div class="flex items-center text-xs">
                                                    <span class="w-4 h-4 rounded-full flex items-center justify-center mr-1 {{ $booking->status == 'pending_lvl_2' ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-400' }}">2</span>
                                                    <span class="{{ $booking->status == 'pending_lvl_2' ? 'font-bold text-gray-900' : '' }}">{{ $booking->approver2->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $badges = [
                                                    'pending_lvl_1' => 'bg-amber-100 text-amber-800 border border-amber-200',
                                                    'pending_lvl_2' => 'bg-orange-100 text-orange-800 border border-orange-200',
                                                    'approved' => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                                                    'rejected' => 'bg-red-100 text-red-800 border border-red-200',
                                                ];
                                                $labels = [
                                                    'pending_lvl_1' => 'Menunggu Lvl 1',
                                                    'pending_lvl_2' => 'Menunggu Lvl 2',
                                                    'approved' => 'Disetujui',
                                                    'rejected' => 'Ditolak',
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $badges[$booking->status] }}">
                                                {{ $labels[$booking->status] }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if(auth()->user()->role == 'approver')
                                                @if(
                                                    (auth()->id() == $booking->approver_1_id && $booking->status == 'pending_lvl_1') ||
                                                    (auth()->id() == $booking->approver_2_id && $booking->status == 'pending_lvl_2')
                                                )
                                                    <div class="flex flex-col gap-3"> <form action="{{ route('bookings.approve', $booking->id) }}" method="POST" class="w-full">
                                                            @csrf
                                                            <button class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-black font-bold uppercase tracking-wider rounded shadow transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                Setuju
                                                            </button>
                                                        </form>
                                                        
                                                        <form action="{{ route('bookings.reject', $booking->id) }}" method="POST" class="w-full">
                                                            @csrf
                                                            <button class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase tracking-wider rounded shadow transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                Tolak
                                                            </button>
                                                        </form>

                                                    </div>
                                                @else
                                                    <span class="text-gray-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-gray-300">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                                <p class="text-base font-medium">Belum ada data pemesanan.</p>
                                                <p class="text-sm text-gray-400">Silakan buat pesanan baru untuk memulai.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('vehicleChart').getContext('2d');
            const labels = {!! json_encode($chartLabels ?? []) !!};
            const data = {!! json_encode($chartData ?? []) !!};

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels, 
                    datasets: [{
                        label: 'Frekuensi',
                        data: data,
                        backgroundColor: [
                            '#4f46e5', 
                            '#f59e0b', 
                            '#10b981',
                            '#6366f1', 
                            '#ef4444'  
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    cutout: '70%', 
                }
            });
        });
    </script>
</x-app-layout>