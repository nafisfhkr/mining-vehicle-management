<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pesanan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <strong class="font-bold">Oops! Ada kesalahan input:</strong>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Kendaraan</label>
                            <select name="vehicle_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }} ({{ $vehicle->type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Driver</label>
                            <select name="driver_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai</label>
                                <input type="date" name="end_date" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <hr class="my-6">
                        <h3 class="font-bold text-lg mb-4">Pihak Penyetuju (Approval)</h3>
                        <p class="text-sm text-gray-500 mb-4">Sesuai aturan, persetujuan harus berjenjang minimal 2 level.</p>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Penyetuju Level 1 (Atasan Langsung)</label>
                            <select name="approver_1_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Approver 1 --</option>
                                @foreach($approvers as $approver)
                                    <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Penyetuju Level 2 (Manajer/Pimpinan)</label>
                            <select name="approver_2_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Approver 2 --</option>
                                @foreach($approvers as $approver)
                                    <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                @endforeach
                            </select>
                            @error('approver_2_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                                Simpan Pesanan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>