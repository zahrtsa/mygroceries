@extends('layouts.app')

@section('content')
<div class="min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="mb-6">
            <p class="text-xs font-semibold tracking-[0.28em] text-emerald-500 uppercase">
                Laporan
            </p>
            <h1 class="mt-1 text-3xl font-semibold text-slate-900">
                Rekap Pengeluaran
            </h1>
            <p class="mt-1 text-sm text-slate-600">
                Lihat total belanja per bulan berdasarkan tahun yang kamu pilih.
            </p>
        </div>

        {{-- 2 CARD: RINGKASAN & DONUT --}}
        <div class="mb-6 grid grid-cols-1 gap-5 md:grid-cols-2">
            {{-- Ringkasan tahun --}}
            <div class="rounded-2xl bg-white shadow-md border border-slate-200 p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-4">
                    Ringkasan Tahun {{ $tahun }}
                </h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Total Pendapatan</dt>
                        <dd class="font-semibold text-emerald-600">
                            Rp {{ number_format($total_pendapatan, 0, ',', '.') }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Budget Belanja</dt>
                        <dd class="font-semibold text-sky-600">
                            Rp {{ number_format($budget_belanja, 0, ',', '.') }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Total Pengeluaran</dt>
                        <dd class="font-semibold text-red-600">
                            Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Saldo Bersih</dt>
                        <dd class="font-semibold text-slate-900">
                            Rp {{ number_format($saldo_bersih, 0, ',', '.') }}
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Donut chart --}}
            <div class="rounded-2xl bg-white shadow-md border border-slate-200 p-5">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-slate-900">
                        Komposisi Keuangan
                    </h2>
                    <p class="text-xs text-slate-500">
                        Pendapatan vs Belanja vs Saldo
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-32 h-32 mx-auto">
                        <canvas id="donut-chart"></canvas>
                    </div>
                    <div class="flex-1 space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span class="text-slate-600">Pendapatan</span>
                            </div>
                            <span class="font-semibold text-slate-900">
                                {{ $persen_pendapatan }}%
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                <span class="text-slate-600">Pengeluaran</span>
                            </div>
                            <span class="font-semibold text-slate-900">
                                {{ $persen_pengeluaran }}%
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-slate-500"></span>
                                <span class="text-slate-600">Saldo</span>
                            </div>
                            <span class="font-semibold text-slate-900">
                                {{ $persen_saldo }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD TABEL BULAN / TOTAL BELANJA --}}
        <div class="rounded-2xl bg-white shadow-xl border border-slate-200">
            <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">
                        Detail Bulanan {{ $tahun }}
                    </h2>
                    <p class="text-xs text-slate-500">
                        Bulan &mdash; Total Belanja
                    </p>
                </div>

                {{-- DROPDOWN TAHUN --}}
                <form
                    action="{{ route('belanja.pengeluaran.index') }}"
                    method="GET"
                    id="filter-year-form-bottom"
                    class="w-full md:w-auto"
                >
                    <label for="tahun_bottom" class="block text-xs font-semibold text-slate-700 mb-1">
                        Pilih Tahun
                    </label>
                    <div class="relative w-full md:w-40">
                        <select
                            name="tahun"
                            id="tahun_bottom"
                            class="w-full rounded-lg border border-slate-300 bg-white pl-3 pr-8 py-2 text-sm text-slate-900 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-400/30 cursor-pointer"
                            onchange="document.getElementById('filter-year-form-bottom').submit()"
                        >
                            @foreach($daftar_tahun as $t)
                                <option value="{{ $t }}" {{ (int)$tahun === (int)$t ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-2 flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                </form>
            </div>

            <div class="px-6 py-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-xs font-semibold text-slate-500">
                            <th class="py-2">Bulan</th>
                            <th class="py-2 text-right">Total Belanja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$adaDataTahunIni)
                            <tr>
                                <td colspan="2" class="py-4 text-center text-sm text-slate-500">
                                    Belum ada data untuk tahun ini.
                                </td>
                            </tr>
                        @else
                            @foreach($laporan_bulanan as $row)
                                <tr class="border-b border-slate-100 last:border-0">
                                    <td class="py-2 text-slate-800">
                                        {{ $row['bulan'] }}
                                    </td>
                                    <td class="py-2 text-right text-slate-900 font-medium">
                                        Rp {{ number_format($row['total_belanja'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('donut-chart');
        if (!ctx) return;

        const data = {
            labels: ['Pendapatan', 'Pengeluaran', 'Saldo'],
            datasets: [{
                data: [
                    {{ $persen_pendapatan }},
                    {{ $persen_pengeluaran }},
                    {{ $persen_saldo }},
                ],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.95)',
                    'rgba(239, 68, 68, 0.95)',
                    'rgba(100, 116, 139, 0.95)',
                ],
                borderWidth: 0,
                hoverOffset: 4,
            }]
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15,23,42,0.9)',
                        bodyFont: { size: 11 },
                        padding: 8,
                        callbacks: {
                            label: function (context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
