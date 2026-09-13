@extends('layouts.app') 

@section('content')
<div class="max-w-4xl mx-auto space-y-6" style="font-family: 'Inter', sans-serif;">
    
    <!-- Tombol Navigasi & Link Menuju Invoice Formal -->
    <div class="flex justify-between items-center">
        <a href="{{ route('technician.tasks.index') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition">&larr; Kembali ke Daftar Tugas</a> 
        
        <a href="{{ route('technician.tasks.invoice', $task->id) }}" target="_blank" class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-xl font-bold transition text-sm flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Buka Invoice / Struk Formal &rarr;
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl font-medium shadow-sm">
        {{ session('success') }}
    </div>
    @endif 
    @if ($errors->any())
    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl font-medium shadow-sm">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Input Rincian & Estimasi Biaya -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <span class="text-xs font-bold tracking-widest uppercase text-blue-600">Work Order #WO-{{ $task->id }}</span>
                <h2 class="text-2xl font-bold text-gray-800 mt-1" style="font-family: 'Playfair Display', serif;">{{ optional($task->complaint)->title }}</h2>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                {{ $task->status == 'completed' ? 'bg-green-100 text-green-700' : ($task->status == 'waiting_approval' ? 'bg-amber-100 text-amber-700' : ($task->status == 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700')) }}">
                Status: {{ str_replace('_', ' ', $task->status) }}
            </span>
        </div>

        <p class="text-sm text-gray-500 mb-4">
            Unit: <strong class="text-gray-800">Unit {{ optional(optional($task->complaint)->propertyUnit)->unit_number }}</strong> &bull; 
            Penyewa: <strong class="text-gray-800">{{ optional(optional($task->complaint)->tenant)->name }}</strong>
        </p>
        <p class="text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm leading-relaxed mb-6">{{ optional($task->complaint)->description }}</p>
        
        @if(optional($task->complaint)->photo)
        <div class="mb-8">
            <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Foto Bukti Kerusakan (Tenant):</p>
            <img src="{{ asset('storage/'.$task->complaint->photo) }}" class="rounded-xl max-h-56 object-cover border border-gray-200 shadow-sm" alt="Foto Keluhan">
        </div>
        @endif

        <form action="{{ route('technician.tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT') 

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Detail Tindakan Perbaikan Lapangan</label>
                <textarea name="action_details" rows="3" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-blue-500 outline-none" placeholder="Jelaskan tindakan perbaikan..." {{ in_array($task->status, ['waiting_approval', 'completed']) ? 'readonly' : '' }}>{{ $task->action_details }}</textarea>
            </div>

            <!-- Tabel Item Transaksi Dinamis -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label class="block text-sm font-bold text-gray-700">Rincian Material & Suku Cadang</label>
                    @if(!in_array($task->status, ['waiting_approval', 'completed']))
                    <button type="button" onclick="addItemRow()" class="bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        + Add Item
                    </button>
                    @endif
                </div>

                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-xs uppercase text-gray-600 font-bold border-b border-gray-200">
                            <tr>
                                <th class="p-3">Keterangan / Nama Barang</th>
                                <th class="p-3 text-center w-32">Jumlah</th>
                                <th class="p-3 text-right w-40">Subtotal (Rp)</th>
                                <th class="p-3 text-center w-16">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemRowsContainer" class="divide-y divide-gray-200 text-sm">
                            <!-- Baris Item Dinamis -->
                        </tbody>
                        <tbody class="divide-y divide-gray-200 text-sm bg-gray-50/50">
                            <tr>
                                <td class="p-3">
                                    <span class="font-bold block text-gray-800">Jasa Tenaga Kerja Teknisi</span>
                                    <span class="text-xs text-gray-500">Tarif standar: Rp 50.000 / hari</span>
                                </td>
                                <td class="p-3 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <input type="number" id="estimatedDays" name="estimated_days" value="{{ $task->estimated_days ?? 1 }}" min="1" class="w-16 border border-gray-300 rounded-lg p-1.5 text-center text-sm outline-none bg-white" oninput="calculateTotal()" {{ in_array($task->status, ['waiting_approval', 'completed']) ? 'readonly' : '' }}>
                                        <span class="text-xs text-gray-500">Hari</span>
                                    </div>
                                </td>
                                <td class="p-3 text-right font-medium text-gray-800" colspan="2">
                                    <span id="laborTotalDisplay">Rp {{ number_format(($task->estimated_days ?? 1) * 50000, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 border-t-2 border-gray-200 font-bold text-gray-900">
                            <tr>
                                <td colspan="2" class="p-3 text-right uppercase text-xs tracking-wider">Total Estimasi Biaya (Grand Total):</td>
                                <td colspan="2" class="p-3 text-right text-base text-blue-600">
                                    Rp <span id="grandTotalDisplay">0</span>
                                    <input type="hidden" id="costEstimate" name="cost_estimate" value="{{ $task->cost_estimate ?? 0 }}">
                                    <input type="hidden" id="sparePartsJson" name="spare_parts" value="{{ $task->spare_parts }}">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Upload Foto -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto Kondisi SEBELUM</label>
                    @if(!in_array($task->status, ['waiting_approval', 'completed']))
                        <input type="file" name="photo_before" accept="image/*" class="w-full text-sm text-gray-500">
                    @endif
                    @if($task->photo_before)
                        <img src="{{ asset('storage/'.$task->photo_before) }}" class="mt-2 rounded-xl max-h-32 object-cover border shadow-sm">
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Foto Kondisi SESUDAH 
                        @if($task->status == 'in_progress') <span class="text-red-500 font-normal">(Wajib untuk menyelesaikan)</span> @endif
                    </label>
                    @if($task->status != 'completed')
                        <input type="file" name="photo_after" accept="image/*" class="w-full text-sm text-gray-500" {{ $task->status == 'in_progress' ? 'required' : '' }}>
                    @endif
                    @if($task->photo_after)
                        <img src="{{ asset('storage/'.$task->photo_after) }}" class="mt-2 rounded-xl max-h-32 object-cover border shadow-sm">
                    @endif
                </div>
            </div>

            <!-- Tombol Aksi Mutlak Berdasarkan Status -->
            <div class="pt-6 border-t border-gray-200 flex justify-end">
                @if($task->status == 'waiting_approval')
                    <div class="w-full flex items-center justify-between bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-xl text-sm font-medium">
                        <span>⏳ Struk estimasi biaya telah dikirim ke Owner. Menunggu persetujuan (ACC).</span>
                        <button type="button" class="bg-gray-300 text-gray-500 px-6 py-2 rounded-xl font-bold cursor-not-allowed text-xs" disabled>
                            Terkunci (Menunggu ACC)
                        </button>
                    </div>
                @elseif($task->status == 'in_progress')
                    <div class="w-full bg-blue-50 border border-blue-200 rounded-xl p-6 shadow-sm">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-blue-900 mb-1">🛠️ Pekerjaan Disetujui (ACC)</h3>
                            <p class="text-sm text-blue-700">Owner telah menyetujui anggaran. Pastikan Anda mengunggah <strong>Foto SESUDAH</strong> di atas, lalu klik tombol di bawah untuk menutup tiket.</p>
                            @if($task->owner_comment)
                                <div class="mt-3 bg-white p-3 rounded-lg border border-blue-100 text-sm text-blue-800 shadow-sm">
                                    <strong>Catatan Owner:</strong> {{ $task->owner_comment }}
                                </div>
                            @endif
                        </div>
                        <input type="hidden" name="complete_task" value="1">
                        <button type="submit" onclick="prepareSubmit(); return confirm('Apakah Anda yakin pekerjaan ini telah selesai dan foto hasil perbaikan sudah diunggah?');" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl font-bold transition shadow-md text-sm flex justify-center items-center gap-2">
                            ✓ Selesaikan Pekerjaan & Tutup Tiket Keluhan
                        </button>
                    </div>
                @elseif($task->status == 'completed')
                    <div class="w-full text-center bg-green-50 border border-green-200 text-green-700 p-5 rounded-xl text-sm font-bold shadow-sm">
                        🎉 Pekerjaan Telah Selesai. Tiket perbaikan ini berhasil ditutup dan tersimpan di Log Owner.
                    </div>
                @else
                    <input type="hidden" name="status" value="waiting_approval">
                    <button type="submit" onclick="prepareSubmit()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-md text-sm">
                        Kirim Struk ke Owner (Minta ACC) &rarr;
                    </button>
                @endif
            </div>
        </form> 
    </div> 
</div> 

<script>
let initialItems = [];
try {
    let saved = document.getElementById('sparePartsJson').value;
    if (saved && saved.startsWith('[')) {
        initialItems = JSON.parse(saved);
    } else if (saved) {
        initialItems = [{ name: saved, qty: '1 Pcs', price: 0 }];
    }
} catch(e) {
    initialItems = [];
}

if (initialItems.length === 0) {
    initialItems = [{ name: '', qty: '1 Pcs', price: '' }];
}

// Cek apakah form sedang terkunci (waiting_approval atau completed)
const isLocked = {{ in_array($task->status, ['waiting_approval', 'completed']) ? 'true' : 'false' }};

function renderItems() {
    let container = document.getElementById('itemRowsContainer');
    container.innerHTML = '';

    initialItems.forEach((item, index) => {
        let tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td class="p-2.5">
                <input type="text" value="${item.name || ''}" class="w-full border border-gray-300 rounded-lg p-2 text-sm outline-none item-name bg-white" placeholder="Nama barang / material..." oninput="updateData()" ${isLocked ? 'readonly' : ''}>
            </td>
            <td class="p-2.5 text-center">
                <input type="text" value="${item.qty || '1 Pcs'}" class="w-24 border border-gray-300 rounded-lg p-2 text-center text-sm outline-none item-qty bg-white" oninput="updateData()" ${isLocked ? 'readonly' : ''}>
            </td>
            <td class="p-2.5 text-right">
                <input type="number" value="${item.price || ''}" class="w-32 border border-gray-300 rounded-lg p-2 text-right text-sm outline-none item-price bg-white" placeholder="0" oninput="updateData()" ${isLocked ? 'readonly' : ''}>
            </td>
            <td class="p-2.5 text-center">
                ${!isLocked ? `<button type="button" onclick="removeItemRow(${index})" class="text-red-500 hover:text-red-700 font-bold text-xs">Hapus</button>` : '<span class="text-gray-400 text-xs">Kunci</span>'}
            </td>
        `;
        container.appendChild(tr);
    });
    calculateTotal();
}

function addItemRow() {
    if(isLocked) return;
    initialItems.push({ name: '', qty: '1 Pcs', price: '' });
    renderItems();
}

function removeItemRow(index) {
    if(isLocked) return;
    if (initialItems.length > 1) {
        initialItems.splice(index, 1);
        renderItems();
    } else {
        alert('Minimal harus ada 1 baris item material.');
    }
}

function updateData() {
    let rows = document.querySelectorAll('.item-row');
    initialItems = [];
    rows.forEach(row => {
        let name = row.querySelector('.item-name').value;
        let qty = row.querySelector('.item-qty').value;
        let price = parseFloat(row.querySelector('.item-price').value) || 0;
        initialItems.push({ name, qty, price });
    });
    calculateTotal();
}

function calculateTotal() {
    let materialTotal = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        let price = parseFloat(row.querySelector('.item-price').value) || 0;
        materialTotal += price;
    });

    let days = parseFloat(document.getElementById('estimatedDays').value) || 0;
    let laborCost = days * 50000;
    let grandTotal = materialTotal + laborCost;
    
    document.getElementById('laborTotalDisplay').innerText = 'Rp ' + laborCost.toLocaleString('id-ID');
    document.getElementById('grandTotalDisplay').innerText = grandTotal.toLocaleString('id-ID');
    document.getElementById('costEstimate').value = grandTotal;
}

function prepareSubmit() {
    document.getElementById('sparePartsJson').value = JSON.stringify(initialItems);
}

window.onload = function() {
    renderItems();
};
</script>
@endsection