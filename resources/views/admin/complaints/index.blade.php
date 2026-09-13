@extends('layouts.app') 

@section('content') 
<div class="mb-8" style="font-family: 'Inter', sans-serif;">     
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition">&larr; Kembali ke Dasbor</a>     
    <h2 class="text-3xl font-bold text-gray-800 mt-2" style="font-family: 'Playfair Display', serif;">Validasi Keluhan Masuk</h2> 
</div> 

@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-8 font-medium">
    {{ session('success') }}
</div>
@endif 

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" style="font-family: 'Inter', sans-serif;">     
    <table class="w-full text-left border-collapse">         
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm uppercase tracking-wide">             
            <tr>                 
                <th class="p-4 font-bold">Pelapor & Unit</th>                 
                <th class="p-4 font-bold">Rincian Laporan</th>                 
                <th class="p-4 font-bold">Status Saat Ini</th>                 
                <th class="p-4 font-bold text-center">Tindakan Admin</th>             
            </tr>         
        </thead>         
        <tbody class="divide-y divide-gray-100">             
            @foreach($complaints as $c)            
            <tr class="hover:bg-gray-50 transition">                 
                <td class="p-4">                     
                    <div class="font-bold text-gray-800">{{ optional($c->tenant)->name ?: '-' }}</div>                     
                    <div class="text-sm text-gray-500 mt-1">Unit: <span class="font-semibold">{{ optional($c->propertyUnit)->unit_number ?: '-' }}</span></div>                 
                </td>                 
                <td class="p-4">                     
                    <span class="text-xs font-bold tracking-widest uppercase text-blue-600">{{ $c->category ?: 'Lainnya' }}</span><br>                     
                    <div class="font-bold text-gray-800 mt-1">{{ $c->title }}</div>
                    <span class="inline-block mt-2 text-xs font-bold uppercase px-3 py-1 rounded-full {{ $c->urgency=='high' ? 'bg-red-100 text-red-700' : ($c->urgency=='medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                        Urgensi: {{ $c->urgency }}
                    </span>                 
                </td>                 
                <td class="p-4">
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 uppercase tracking-wide">
                        {{ str_replace('_', ' ', $c->status) }}
                    </span>
                </td>                 
                <td class="p-4 bg-gray-50 border-l border-gray-100">                     
                    <form action="{{ route('admin.complaints.update', $c->id) }}" method="POST" class="flex flex-col gap-3">                        
                        @csrf @method('PUT')
                        
                        @if($c->status == 'pending')
                            <select name="technician_id" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                                <option value="">-- Pilih Teknisi Bertugas --</option>
                                @foreach($technicians as $tech)                                
                                    <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                @endforeach
                            </select>
                            
                            <div class="flex gap-2">
                                <button type="submit" name="status" value="waiting_approval" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-xs font-bold transition shadow-sm">
                                    Minta ACC Teknisi
                                </button>
                                <button type="submit" name="status" value="rejected" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg text-xs font-bold transition">
                                    Tolak
                                </button>
                            </div>
                        @else
                            <div class="text-center text-sm text-gray-500 font-medium py-2">
                                Menunggu Tindakan Lanjutan
                            </div>
                        @endif
                    </form>                 
                </td>             
            </tr>             
            @endforeach         
        </tbody>     
    </table> 
</div> 
@endsection