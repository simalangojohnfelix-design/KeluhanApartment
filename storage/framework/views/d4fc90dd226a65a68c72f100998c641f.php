<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #INV-WO-<?php echo e($task->id); ?> - Palazzo Palace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        @media print {
            body { background: white !important; print-color-adjust: exact; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .invoice-container { box-shadow: none !important; border: none !important; padding: 10px !important; width: 100% !important; max-width: 100% !important; }
        }
    </style>
</head>
<body class="bg-gray-100 py-6 px-4 text-xs" style="font-family: 'Inter', sans-serif;" onload="window.print()">

    <!-- Wrapper Tombol Aksi (Hilang saat diprint) -->
    <div class="max-w-2xl mx-auto mb-4 flex justify-between items-center no-print">
        <a href="<?php echo e(route('technician.tasks.show', $task->id)); ?>" class="text-xs font-bold text-gray-600 hover:text-gray-900 bg-white px-3 py-1.5 rounded-lg shadow-sm border border-gray-200 transition">
            &larr; Kembali ke Detail Tugas
        </a>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-md transition flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / Download PDF
        </button>
    </div>

    <!-- KERTAS INVOICE UTAMA (Kompak 1 Halaman) -->
    <div class="invoice-container max-w-2xl mx-auto bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        
        <!-- Kop Surat / Header Invoice -->
        <div class="flex justify-between items-start border-b border-gray-200 pb-4 mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Palazzo Palace</h1>
                <p class="text-[10px] text-gray-500 mt-0.5 uppercase tracking-widest font-bold">Apartment Management & Maintenance Division</p>
                <p class="text-[10px] text-gray-400">Jl. M.H. Thamrin No. 88, Kota Palembang</p>
            </div>
            <div class="text-right">
                <span class="inline-block bg-blue-50 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider border border-blue-100 mb-1">
                    INVOICE ESTIMASI
                </span>
                <p class="text-xs font-bold text-gray-800">No: INV/WO/<?php echo e(date('Y')); ?>/00<?php echo e($task->id); ?></p>
                <p class="text-[10px] text-gray-500">Tanggal: <?php echo e(date('d/m/Y')); ?></p>
            </div>
        </div>

        <!-- Informasi Penagihan & Unit -->
        <div class="grid grid-cols-2 gap-4 mb-4 bg-gray-50 p-3.5 rounded-lg border border-gray-100">
            <div>
                <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Ditujukan Kepada Owner:</p>
                <p class="font-bold text-gray-900">Yth. Dewan Pemilik / Owner</p>
                <p class="text-gray-600 text-[11px]">Unit Perbaikan: <strong class="text-gray-800">No. <?php echo e(optional(optional($task->complaint)->propertyUnit)->unit_number); ?></strong> (Tenant: <?php echo e(optional(optional($task->complaint)->tenant)->name); ?>)</p>
            </div>
            <div>
                <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Informasi Penugasan:</p>
                <p class="text-gray-700 text-[11px]">Teknisi: <strong class="text-gray-900"><?php echo e(optional($task->technician)->name); ?></strong></p>
                <p class="text-gray-700 text-[11px]">Status: <strong class="text-blue-600 uppercase text-[10px]"><?php echo e(str_replace('_', ' ', $task->status)); ?></strong></p>
            </div>
        </div>

        <!-- Rincian Kerusakan -->
        <div class="mb-4">
            <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Deskripsi Keluhan Lapangan</p>
            <div class="border border-gray-200 rounded-lg p-3 bg-white">
                <p class="font-bold text-gray-900 text-[11px]"><?php echo e(optional($task->complaint)->title); ?></p>
                <p class="text-[11px] text-gray-600 mt-0.5 leading-relaxed"><?php echo e(optional($task->complaint)->description); ?></p>
            </div>
        </div>

        <?php if($task->action_details): ?>
        <div class="mb-4">
            <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Catatan Diagnosa Teknisi</p>
            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50/50">
                <p class="text-[11px] text-gray-700 leading-relaxed"><?php echo e($task->action_details); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Tabel Item Anggaran Biaya -->
        <div class="mb-4">
            <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Rincian Komponen Biaya (RAB)</p>
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 text-[10px] uppercase text-gray-600 font-bold border-b border-gray-200">
                        <tr>
                            <th class="p-2.5">Keterangan / Nama Material</th>
                            <th class="p-2.5 text-center w-24">Kuantitas</th>
                            <th class="p-2.5 text-right w-28">Subtotal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-[11px]">
                        <?php
                            $items = [];
                            try {
                                $items = json_decode($task->spare_parts, true) ?? [];
                            } catch(\Exception $e) {
                                $items = [];
                            }
                        ?>

                        <?php if(is_array($items) && count($items) > 0): ?>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="p-2.5 font-medium text-gray-800"><?php echo e($item['name'] ?: 'Material Perbaikan'); ?></td>
                                <td class="p-2.5 text-center text-gray-600"><?php echo e($item['qty'] ?? '1 Pcs'); ?></td>
                                <td class="p-2.5 text-right font-medium text-gray-800">Rp <?php echo e(number_format($item['price'] ?? 0, 0, ',', '.')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="p-2.5 text-gray-500 italic">Tidak ada rincian material tambahan.</td>
                            </tr>
                        <?php endif; ?>

                        <!-- Baris Jasa Teknisi -->
                        <tr class="bg-gray-50/50">
                            <td class="p-2.5">
                                <span class="font-bold text-gray-800 block">Jasa Tenaga Kerja Teknisi</span>
                                <span class="text-[10px] text-gray-500">Tarif standar: Rp 50.000 / hari</span>
                            </td>
                            <td class="p-2.5 text-center text-gray-600"><?php echo e($task->estimated_days ?? 1); ?> Hari</td>
                            <td class="p-2.5 text-right font-medium text-gray-800">
                                Rp <?php echo e(number_format(($task->estimated_days ?? 1) * 50000, 0, ',', '.')); ?>

                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-gray-100 border-t-2 border-gray-200 font-bold text-gray-900">
                        <tr>
                            <td colspan="2" class="p-2.5 text-right uppercase text-[10px] tracking-wider">Grand Total Estimasi Biaya:</td>
                            <td class="p-2.5 text-right text-sm text-blue-600">
                                Rp <?php echo e(number_format($task->cost_estimate ?? 0, 0, ',', '.')); ?>

                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Catatan Khusus untuk Owner (Pengganti TTD) -->
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 text-[11px] text-blue-900 flex justify-between items-center">
            <div>
                <span class="font-bold block">Status Pengajuan Owner:</span>
                <?php if($task->status == 'in_progress' || $task->status == 'completed'): ?>
                    <span>✓ Telah disetujui (ACC) oleh Owner. Pengerjaan dilanjutkan.</span>
                <?php else: ?>
                    <span>Menunggu tindakan persetujuan (ACC / Tolak) melalui panel dashboard Owner.</span>
                <?php endif; ?>
            </div>
            <div class="text-right font-bold uppercase text-[10px] tracking-wider text-blue-700">
                Palazzo Palace System
            </div>
        </div>

    </div>

</body>
</html><?php /**PATH D:\MSI\sistem-apartemen\resources\views/technician/tasks/invoice.blade.php ENDPATH**/ ?>