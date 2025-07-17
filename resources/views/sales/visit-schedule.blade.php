@extends('sales/layouts.app')

@section('content')
    {{-- Inisialisasi Alpine.js untuk mengelola state modal --}}
    <div x-data="{
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        scheduleToEdit: {},
        scheduleToDelete: {}
    }">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Jadwal Kunjungan</h1>
            {{-- Tombol ini akan membuka modal tambah --}}
            <button @click="showAddModal = true"
                class="w-full md:w-auto px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-transform transform hover:scale-105">
                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Jadwal Baru
            </button>
        </div>


        <div class="bg-white dark:bg-gray-800 p-2 md:p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 px-4 md:px-0">Daftar Jadwal Anda</h2>

            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Tanggal & Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Tujuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($schedules as $schedule)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $schedule->start_time->isoFormat('D MMM YY') }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $schedule->start_time->format('H:i') }} -
                                        {{ $schedule->end_time->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $schedule->customer->name_store ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $schedule->title }}</td>
                                <td class="px-6 py-4"><span @class([
                                    'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    'bg-yellow-100 text-yellow-800' => $schedule->status === 'Pending',
                                    'bg-green-100 text-green-800' => $schedule->status === 'Completed',
                                    'bg-red-100 text-red-800' => $schedule->status === 'Cancelled',
                                ])>{{ $schedule->status }}</span></td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    @if ($schedule->status === 'Pending')
                                        <form action="{{ route('sales.visit_schedule.complete', $schedule->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 mr-3">Selesaikan</button>
                                        </form>
                                        <button @click="scheduleToEdit = {{ json_encode($schedule) }}; showEditModal = true" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 mr-3">Edit</button>
                                    @elseif ($schedule->status === 'Completed')
                                        <span class="text-gray-400 cursor-not-allowed mr-3">Edit</span>
                                    @endif
                                    @if ($schedule->status !== 'Cancelled')
                                        <button @click="scheduleToDelete = {{ $schedule }}; showDeleteModal = true" class="text-red-600 hover:text-red-900 dark:text-red-400">Hapus</button>
                                    @else
                                         <button @click="scheduleToDelete = {{ $schedule }}; showDeleteModal = true" class="text-red-600 hover:text-red-900 dark:text-red-400">Hapus</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">Tidak ada jadwal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4">
                @forelse ($schedules as $schedule)
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-lg text-gray-800 dark:text-white">
                                    {{ $schedule->customer->name_store ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $schedule->start_time->isoFormat('dddd, D MMM YY') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}
                                </p>
                            </div>
                            <div><span @class([
                                'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
                                'bg-yellow-100 text-yellow-800' => $schedule->status === 'Pending',
                                'bg-green-100 text-green-800' => $schedule->status === 'Completed',
                                'bg-red-100 text-red-800' => $schedule->status === 'Cancelled',
                            ])>{{ $schedule->status }}</span></div>
                        </div>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">Tujuan: {{ $schedule->title }}</p>
                        <div class="mt-4 border-t border-gray-200 dark:border-gray-600 pt-4 text-right space-x-3">
                            @if ($schedule->status === 'Pending')
                                <form action="{{ route('sales.visit_schedule.complete', $schedule->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 border border-green-500 text-green-600 text-sm font-semibold rounded-md hover:bg-green-50 dark:hover:bg-green-900/50">Selesaikan</button>
                                </form>
                                <button @click="scheduleToEdit = {{ json_encode($schedule) }}; showEditModal = true"
                                    class="px-3 py-1.5 border border-indigo-500 text-indigo-600 text-sm font-semibold rounded-md hover:bg-indigo-50 dark:hover:bg-indigo-900/50">Edit</button>
                            @elseif ($schedule->status === 'Completed')
                                 <button class="px-3 py-1.5 border border-gray-300 text-gray-400 text-sm font-semibold rounded-md cursor-not-allowed">Edit</button>
                            @endif
                            @if ($schedule->status !== 'Cancelled')
                               <button @click="scheduleToDelete = {{ $schedule }}; showDeleteModal = true"
                                class="px-3 py-1.5 border border-red-500 text-red-600 text-sm font-semibold rounded-md hover:bg-red-50 dark:hover:bg-red-900/50">Hapus</button>
                            @else
                                <button @click="scheduleToDelete = {{ $schedule }}; showDeleteModal = true"
                                class="px-3 py-1.5 border border-red-500 text-red-600 text-sm font-semibold rounded-md hover:bg-red-50 dark:hover:bg-red-900/50">Hapus</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-10">Tidak ada jadwal.</div>
                @endforelse
            </div>
        </div>

        <div x-show="showAddModal" @keydown.escape.window="showAddModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
            <div @click.away="showAddModal = false"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Tambah Jadwal Baru</h3>
                <form action="{{ route('sales.visit_schedule.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div><label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pelanggan</label><select
                                name="id_customer" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id_customer }}">{{ $customer->name_store }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tujuan
                                Kunjungan</label><input type="text" name="title" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu
                                    Mulai</label><input type="datetime-local" name="start_time" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu
                                    Selesai</label><input type="datetime-local" name="end_time" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan
                                (Opsional)</label>
                            <textarea name="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3"><button type="button" @click="showAddModal = false"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-600 rounded-md">Batal</button><button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan</button></div>
                </form>
            </div>
        </div>

        <div x-show="showEditModal" @keydown.escape.window="showEditModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
            <div @click.away="showEditModal = false"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Edit Jadwal Kunjungan</h3>
                <form :action="`/sales/visit-schedule/${scheduleToEdit.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div><label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pelanggan</label><select
                                name="id_customer" required x-model="scheduleToEdit.id_customer"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id_customer }}">{{ $customer->name_store }}</option>
                                @endforeach
                            </select></div>
                        <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tujuan
                                Kunjungan</label><input type="text" name="title" required
                                x-model="scheduleToEdit.title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu
                                    Mulai</label><input type="datetime-local" name="start_time" required
                                    :value="scheduleToEdit.start_time ? scheduleToEdit.start_time.slice(0, 16) : ''"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu
                                    Selesai</label><input type="datetime-local" name="end_time" required
                                    :value="scheduleToEdit.end_time ? scheduleToEdit.end_time.slice(0, 16) : ''"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div><label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label><select
                                name="status" required x-model="scheduleToEdit.status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                <option>Pending</option>
                                <option>Completed</option>
                                <option>Cancelled</option>
                            </select></div>
                        <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan
                                (Opsional)</label>
                            <textarea name="notes" rows="3" x-model="scheduleToEdit.notes"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3"><button type="button" @click="showEditModal = false"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-600 rounded-md">Batal</button><button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md">Update</button></div>
                </form>
            </div>
        </div>

        <div x-show="showDeleteModal" @keydown.escape.window="showDeleteModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display: none;">
            <div @click.away="showDeleteModal = false"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">Konfirmasi Pembatalan</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Anda yakin ingin membatalkan jadwal ini?</p>
                <form :action="`/sales/visit-schedule/${scheduleToDelete.id}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showDeleteModal = false"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-600 rounded-md">Tidak</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Ya, Batalkan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection