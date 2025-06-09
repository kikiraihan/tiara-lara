<?php

namespace App\Exports;

use App\Models\PjpNra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PjpNraExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    /**
     * Return the collection of data to export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PjpNra::all();  // Ambil semua data dari tabel pjp_nras
    }

    /**
     * Return the headers for the CSV export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'sandi_pjp', 'tahun', 'nra_apu'  // Header CSV sesuai dengan kolom di tabel
        ];
    }

    /**
     * Map the data for each row of the CSV.
     *
     * @param  mixed  $pjpNra
     * @return array
     */
    public function map($pjpNra): array
    {
        return [
            $pjpNra->sandi,
            $pjpNra->tahun,
            (int) $pjpNra->nra==0?"0":$pjpNra->nra
        ];
    }

    /**
     * @return array
     */
    public function getCsvSettings(): array
    {
        // Anda bisa mengubah separator jika perlu (defaultnya koma)
        return [
            'delimiter' => ',', // Anda bisa menggantinya dengan ';' jika diperlukan
        ];
    }
}
