{{-- File: resources/views/sales/edit-customer-status.blade.php --}}

@extends('sales/layouts.app')

@section('content')
    <h1 class="text-3xl font-bold text-white mb-6">Edit Status Pelanggan</h1>

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ubah Status untuk {{ $customer->name_store }}</h2>

        <form action="{{ route('customer.updateStatus', ['id' => $customer->id_customer]) }}" method="POST">
            @csrf
            @method('PUT') {{-- Gunakan metode PUT untuk update --}}

            <div class="mb-4">
                <label for="current_status" class="block text-sm font-medium text-gray-700 mb-1">Status Saat Ini:</label>
                <p class="text-lg font-bold text-gray-900">{{ $customer->status }}</p>
            </div>

            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Pilih Status Baru:</label>
                <select id="status" name="status" required
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                    <option value="">-- Pilih Status --</option>
                    @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption }}"
                            {{ old('status', $customer->status) == $statusOption ? 'selected' : '' }}>
                            {{ str_replace('_', ' ', $statusOption) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('customers.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>
@endsection
