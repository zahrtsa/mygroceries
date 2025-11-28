@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto my-12 px-4">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 px-6 sm:px-7 pt-7 pb-8">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-11 h-11 rounded-full bg-[#ed000c] flex items-center justify-center text-white shadow-md">
                <i class="fa fa-plus-circle text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold text-slate-900">
                    Tambah Item Belanja
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Masukkan barang yang ingin kamu beli hari ini.
                </p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('belanja.item.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama barang --}}
            <div>
                <label for="nama_barang" class="block text-sm font-semibold text-slate-800 mb-1.5">
                    Nama Barang <span class="text-slate-400">*</span>
                </label>
                <input
                    type="text"
                    name="nama_barang"
                    id="nama_barang"
                    value="{{ old('nama_barang') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm sm:text-base text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-[#ed000c] focus:ring-2 focus:ring-[#ed000c]/20 focus:outline-none"
                    placeholder="Contoh: Indomie Goreng"
                    required
                    autofocus
                >
            </div>

            {{-- Qty & Harga --}}
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="sm:w-1/3">
                    <label for="qty" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Qty <span class="text-slate-400">*</span>
                    </label>
                    <input
                        type="number"
                        name="qty"
                        id="qty"
                        min="1"
                        value="{{ old('qty') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm sm:text-base text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-[#ed000c] focus:ring-2 focus:ring-[#ed000c]/20 focus:outline-none"
                        placeholder="1"
                        required
                    >
                </div>
                <div class="sm:w-2/3">
                    <label for="harga_satuan" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Harga Satuan (Rp) <span class="text-slate-400">*</span>
                    </label>
                    <input
                        type="number"
                        name="harga_satuan"
                        id="harga_satuan"
                        min="0"
                        step="100"
                        value="{{ old('harga_satuan') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm sm:text-base text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-[#ed000c] focus:ring-2 focus:ring-[#ed000c]/20 focus:outline-none"
                        placeholder="Contoh: 5000"
                        required
                    >
                </div>
            </div>

            {{-- Actions --}}
            <div class="pt-4 flex items-center justify-between">
                <a href="{{ route('belanja.item.index') }}"
                   class="inline-flex items-center gap-2 text-xs sm:text-sm text-slate-500 hover:text-slate-700">
                    <i class="fa fa-arrow-left"></i>
                    Kembali ke list
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#ed000c] hover:bg-red-600 text-white text-sm sm:text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-[#ed000c]/40"
                >
                    <i class="fa fa-save"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
