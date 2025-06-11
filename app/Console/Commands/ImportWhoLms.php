<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportWhoLms extends Command
{
    protected $signature = 'who:import-lms';
    protected $description = 'Import WHO LMS data';

    public function handle()
    {
        $sources = [
            'wfa_boys_0-to-5-years_zscores.csv' => ['gender' => 'L', 'type' => 'wfa'],
            'wfa_girls_0-to-5-years_zscores.csv' => ['gender' => 'P', 'type' => 'wfa'],
            'lhfa_boys_0-to-5-years_zscores.csv' => ['gender' => 'L', 'type' => 'lhfa'],
            'lhfa_girls_0-to-5-years_zscores.csv' => ['gender' => 'P', 'type' => 'lhfa'],
        ];

        $lms = [
            'L' => ['wfa' => [], 'lhfa' => []],
            'P' => ['wfa' => [], 'lhfa' => []],
        ];

        foreach ($sources as $file => $info) {
            $path = storage_path('app/file_growth/' . $file);
            $rows = Excel::toCollection(null, $path)[0]; // Sheet pertama

            $rows = $rows->slice(1)->values();
            foreach ($rows as $row) {
                // if (!isset($row['age']) && isset($row['age_in_months'])) {
                //     $row['age'] = $row['age_in_months']; // adaptasi dari struktur WHO
                // }
                // dd(vars: $row);
                $bulan = (int) $row[0];
                $lms[$info['gender']][$info['type']][$bulan] = [
                    'L' => (float) str_replace(',', '.', $row[1]),
                    'M' => (float) str_replace(',', '.', $row[2]),
                    'S' => (float) str_replace(',', '.', $row[3]),
                ];
            }

            $this->info("✅ Imported: {$file}");
        }

        // Simpan sebagai JSON terpisah per kombinasi
        foreach (['L', 'P'] as $gender) {
            foreach (['wfa', 'lhfa'] as $type) {
                $filename = "growth_{$gender}_{$type}.json";
                Storage::put("growth/{$filename}", json_encode($lms[$gender][$type], JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION ));
                $this->info("✅ Saved JSON: {$filename}");
            }
        }

        $this->info('✅ Semua data LMS WHO berhasil di-import dan disimpan!');
    }
}
