<?php

namespace Database\Seeders;

use App\Models\PengeluaranBulanan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranBulananSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan pengecekan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        PengeluaranBulanan::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $users = User::all();

        // Tahun yang ingin di-seed (sebelum 2025)
        $years = [2023, 2024, (int) date('Y')];

        foreach ($users as $user) {
            foreach ($years as $year) {
                for ($month = 1; $month <= 12; ++$month) {
                    // fallback kalau user belum punya budget/pendapatan
                    $budgetBulanan = $user->budget_bulanan ?? 2_000_000;
                    $pendapatanBulanan = $user->pendapatan_bulanan ?? 4_000_000;

                    $min = (int) ($budgetBulanan * 0.5);
                    $max = (int) $budgetBulanan;

                    // jaga-jaga biar rand tidak error
                    if ($min < 0) {
                        $min = 0;
                    }
                    if ($max <= $min) {
                        $max = $min + 1;
                    }

                    $totalPengeluaran = rand($min, $max);
                    $saldoBersih = $pendapatanBulanan - $totalPengeluaran;

                    PengeluaranBulanan::create([
                        'user_id' => $user->id,
                        'bulan' => $month,
                        'tahun' => $year,
                        'total_pengeluaran' => $totalPengeluaran,
                        'saldo_bersih' => $saldoBersih,
                    ]);
                }
            }
        }
    }
}
