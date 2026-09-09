@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-2">Riwayat Biaya Pemeliharaan</h2>
<p class="text-gray-500 mb-4">Total keseluruhan: <strong>Rp {{ number_format($totalCost, 0, ',', '.') }}</strong></p>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">WO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teknisi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tindakan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Biaya</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($logs as $log)
            <tr>
                <td class="px-6 py-4">WO-{{ $log->id }}</td>
                <td class="px-6 py-4">{{ optional(optional($log->complaint)->propertyUnit)->unit_number ?? '-' }}</td>
                <td class="px-6 py-4">{{ optional($log->technician)->name ?? '-' }}</td>
                <td class="px-6 py-4 text-sm">{{ Str::limit($log->action_details, 60) ?? '-' }}</td>
                <td class="px-6 py-4 font-semibold">Rp {{ number_format($log->cost_estimate, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-sm">{{ $log->updated_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $logs->links() }}</div>
@endsection