<?php

namespace App\Exports;

use App\Models\KupvaProfil;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class KupvaProfilExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithCustomCsvSettings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch the data from the KupvaProfil model
        return KupvaProfil::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Define the CSV headings as per your requirement
        return [
            'ID LKPBU',
            'No. KPMIU',
            'Tanggal KPMIU',
            // 'Nama KUPVA BB',
            'Jatuh Tempo Izin',
            'NPWP',
            'Wilayah Kerja',
            'Pulau',
            'Provinsi',
            'Kota',
            'Pengurus',
            'Pemegang Saham',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        // Map the data for each row based on the format you want
        return [
            $row->id_lkpbu,
            $row->no_kpmiu,
            $row->tanggal_kpmiu,
            // $row->nama_kupva_bb,
            $row->jatuh_tempo_izin,
            $row->npwp,
            $row->wilayah_kerja,
            $row->pulau,
            $row->provinsi,
            $row->kota,
            $row->pengurus,
            $row->pemegang_saham,
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Kupva Profil';
    }


    /**
     * @return array
     */
    public function getCsvSettings(): array
    {
        // Set the CSV separator to semicolon
        return [
            'delimiter' => ';',
        ];
    }

}
