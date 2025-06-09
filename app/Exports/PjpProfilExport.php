<?php

namespace App\Exports;

use App\Models\PjpProfil;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PjpProfilExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    /**
     * Return the collection of data to export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PjpProfil::all();
    }

    /**
     * Return the headers for the CSV export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'sandi', 'no_izin', 
            // 'nama', 
            'tgl_jatuh_tempo_izin', 'npwp', 'modal_disetor', 
            'kpwdn', 'pulau', 'provinsi', 'kota', 'pengurus', 'pemegang_saham'
        ];
    }

    /**
     * Map the data for each row of the CSV.
     *
     * @param  mixed  $pjpProfil
     * @return array
     */
    public function map($pjpProfil): array
    {
        return [
            $pjpProfil->sandi,
            $pjpProfil->no_izin,
            // $pjpProfil->nama,
            $pjpProfil->tgl_jatuh_tempo_izin,
            $pjpProfil->npwp,
            $pjpProfil->modal_disetor,
            $pjpProfil->kpwdn,
            $pjpProfil->pulau,
            $pjpProfil->provinsi,
            $pjpProfil->kota,
            $pjpProfil->pengurus,
            $pjpProfil->pemegang_saham
        ];
    }

    /**
     * @return array
     */
    public function getCsvSettings(): array
    {
        // Set the CSV separator to semicolon
        return [
            'delimiter' => ',',
        ];
    }

}
