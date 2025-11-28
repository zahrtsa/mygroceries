@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-10 px-4">
    <div class="relative bg-white rounded-3xl shadow-xl border border-rose-100 overflow-hidden">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-rose-100">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-[#ed000c] flex items-center justify-center shadow-md text-white">
                    <i class="fa fa-calendar-day text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-semibold text-slate-900">
                        Rekap Harian
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Lihat detail belanja untuk tanggal yang kamu pilih.
                    </p>
                </div>
            </div>
        </div>

        {{-- FORM PILIH TANGGAL --}}
        <form method="GET" action="{{ route('belanja.rekapanharian') }}"
              class="px-6 pt-4 pb-2 flex flex-col sm:flex-row gap-3 sm:items-center">
            <div class="flex items-center gap-2">
                <label for="tanggal" class="text-sm font-medium text-slate-700">
                    Pilih tanggal
                </label>
            </div>
            <div class="flex gap-3 items-center">
                <select id="tanggal" name="tanggal"
                    class="px-3 py-2 rounded-xl border border-slate-300 bg-white text-sm text-slate-900 focus:border-[#ed000c] focus:ring-2 focus:ring-[#ed000c]/20 shadow-sm">
                    @foreach($optionsTanggal as $tgl)
                        <option value="{{ $tgl }}" @selected($tanggal == $tgl)>
                            {{ \Carbon\Carbon::parse($tgl)->translatedFormat('l, d F Y') }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#ed000c] px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow hover:bg-red-600 transition">
                    <i class="fa fa-search"></i>
                    Tampilkan
                </button>
            </div>
        </form>

        {{-- INFO TANGGAL + TOTAL --}}
        <div class="px-6 pt-2 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div class="text-sm text-slate-700">
                <span class="text-slate-500">Tanggal:</span>
                <span class="ml-1 font-semibold text-[#ed000c]">
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="px-4 pb-6">
            <div class="rounded-2xl border border-rose-100 overflow-x-auto">
                <table class="w-full text-sm text-center">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#ed000c] to-rose-400 text-white text-xs uppercase tracking-wide">
                            <th class="py-3 px-4 text-left rounded-tl-2xl">Nama Barang</th>
                            <th class="py-3 px-4">Qty</th>
                            <th class="py-3 px-4">Harga Satuan</th>
                            <th class="py-3 px-4">Total Harga</th>
                            <th class="py-3 px-4 rounded-tr-2xl">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="border-b border-rose-100 odd:bg-white even:bg-rose-50/60 hover:bg-rose-50 transition">
                                <td class="py-2.5 px-4 text-left font-medium text-slate-800">
                                    {{ $item->nama_barang }}
                                </td>
                                <td class="py-2.5 px-4 text-slate-700">
                                    {{ $item->qty }}
                                </td>
                                <td class="py-2.5 px-4 text-slate-700">
                                    Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                </td>
                                <td class="py-2.5 px-4 font-semibold text-slate-900">
                                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="py-2.5 px-4">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-semibold inline-flex items-center gap-1
                                        {{ $item->status == 'Sudah Dibeli'
                                            ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                            : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                        <span class="h-1.5 w-1.5 rounded-full
                                            {{ $item->status == 'Sudah Dibeli' ? 'bg-emerald-500' : 'bg-amber-400' }}">
                                        </span>
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-7 text-slate-400 bg-rose-50 rounded-b-2xl">
                                    Tidak ada data belanja pada tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FOOTER TOTAL --}}
        <div class="px-6 pb-6 flex justify-end">
            <div class="inline-flex items-center rounded-full bg-[#ed000c]/5 border border-rose-100 px-6 py-2 text-sm sm:text-base font-semibold text-[#ed000c] shadow-sm">
                Total Belanja: Rp {{ number_format($totalBelanja, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>
@endsection
