<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pesanan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <div class="bg-indigo-600 p-4 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-white">Formulir Peminjaman Kendaraan</h3>
                    <p class="mt-1 text-sm text-indigo-200">
                        Lengkapi data di bawah ini untuk mengajukan permohonan kendaraan dinas.
                    </p>
                </div>

                <div class="p-6 sm:p-8 bg-white border-b border-gray-200">
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                            <div class="flex">
                                <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                                <div>
                                    <p class="font-bold">Harap perbaiki kesalahan berikut:</p>
                                    <ul class="list-disc list-inside text-sm mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-8">
                            <h4 class="text-gray-600 text-sm uppercase font-bold mb-4 border-b pb-2">Detail Peminjaman</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="vehicle_id">
                                        Pilih Kendaraan
                                    </label>
                                    <div>
                                        <select name="vehicle_id" id="vehicle_id" class="block w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                                            @foreach($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}">
                                                    {{ $vehicle->name }} ({{ $vehicle->license_plate }}) - Posisi: {{ $vehicle->location }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 italic">Pastikan lokasi kendaraan sesuai dengan kebutuhan.</p>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="driver_id">
                                        Pilih Driver
                                    </label>
                                    <div>
                                        <select name="driver_id" id="driver_id" class="block w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                                            @foreach($drivers as $driver)
                                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="start_date">
                                        Tanggal Mulai
                                    </label>
                                    <input type="date" name="start_date" id="start_date" class="block w-full bg-gray-50 text-gray-700 border border-gray-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="end_date">
                                        Tanggal Selesai
                                    </label>
                                    <input type="date" name="end_date" id="end_date" class="block w-full bg-gray-50 text-gray-700 border border-gray-300 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-100 mb-8">
                            <h4 class="text-indigo-800 text-sm uppercase font-bold mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Pihak Penyetuju (Approval)
                            </h4>
                            <p class="text-sm text-indigo-600 mb-6">
                                Sesuai SOP Perusahaan, setiap peminjaman wajib mendapatkan persetujuan berjenjang dari 2 level pimpinan yang berbeda.
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-indigo-900 text-sm font-bold mb-2">
                                        Penyetuju Level 1 (Atasan Langsung)
                                    </label>
                                    <div>
                                        <select name="approver_1_id" class="block w-full bg-white border border-indigo-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm">
                                            <option value="">-- Pilih Approver --</option>
                                            @foreach($approvers as $approver)
                                                <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-indigo-900 text-sm font-bold mb-2">
                                        Penyetuju Level 2 (Manajer/Pimpinan)
                                    </label>
                                    <div>
                                        <select name="approver_2_id" class="block w-full bg-white border border-indigo-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm">
                                            <option value="">-- Pilih Approver --</option>
                                            @foreach($approvers as $approver)
                                                <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6">
                            <a href="{{ route('dashboard') }}" class="mr-4 px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>

                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-bold text-sm text-black uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>