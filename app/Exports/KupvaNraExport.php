<?php

namespace App\Exports;

use App\Models\KupvaNra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KupvaNraExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    /**
     * Return the collection of data to export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return KupvaNra::all();  // Ambil semua data dari tabel pjp_nras
    }

    /**
     * Return the headers for the CSV export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'sandi_kupva', 'tahun', 'nra_apu'  // Header CSV sesuai dengan kolom di tabel
        ];
    }

    /**
     * Map the data for each row of the CSV.
     *
     * @param  mixed  $kupvaNra
     * @return array
     */
    public function map($kupvaNra): array
    {
        return [
            $kupvaNra->id_lkpbu,
            $kupvaNra->tahun,
            (int) $kupvaNra->nra==0?"0":$kupvaNra->nra
        ];
    }

    /**
     * @return array
     */
    public function getCsvSettings(): array
    {
        // Anda bisa mengubah separator jika perlu (defaultnya koma)
        return [
            'delimiter' => ';', // Anda bisa menggantinya dengan ';' jika diperlukan
        ];
    }
}
