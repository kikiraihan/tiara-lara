<?php

namespace App\Livewire\DatasetResource\CsvValidator;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;

class New24Jan_KupvaPerbulanValidatorCsv implements ToCollection, WithHeadingRow, WithValidation
{
    public function __construct()
    {
        // Add any initialization logic here, if necessary
    }

    /**
     * Process the imported rows
     */
    public function collection(Collection $rows)
    {
        // Here you can process the data further if needed.
        // For example, save the dataset to a file or perform specific actions.
    }

    /**
     * Validation rules for the CSV file based on column names.
     */
    public function rules(): array
    {
        return [
            'tahun' => 'required|integer',
            'bulan' => 'required|integer',
            'sandi' => 'required|numeric',
            'jenis_produk' => 'required|string',
            'jenis_valuta' => 'required|string',
            'saldo_awal' => 'required|numeric',
            'rata_saldo_awal' => 'required|numeric',
            'volume_pembelian' => 'required|numeric',
            'volume_penjualan' => 'required|numeric',
            'saldo_akhir' => 'required|numeric',
            'rata_saldo_akhir' => 'required|numeric',
            'kurs_tengah' => 'required|numeric',
            '_saldo_akhir_hitung' => 'required|numeric',
            '_saldo_akhir_lebih' => 'required|numeric',
            '_saldo_akhir_lebih_selisih' => 'required|numeric',
            '_spread_keuntungan' => 'required|numeric',
            '_stok_mata_uang_bertambah' => 'required|numeric',
            'saldo_awal_outlier' => 'nullable|numeric',
            'volume_pembelian_outlier' => 'nullable|numeric',
            'volume_penjualan_outlier' => 'nullable|numeric',
            'saldo_akhir_outlier' => 'nullable|numeric',
            '_saldo_akhir_hitung_outlier' => 'nullable|numeric',
            '_saldo_akhir_lebih_selisih_outlier' => 'nullable|numeric',
            '_spread_keuntungan_outlier' => 'nullable|numeric',
            'NRA_APU' => 'nullable|numeric',
            'No_KPMIU' => 'nullable|string',
            'tanggal_KPMIU' => 'nullable|date',
            'nama_KUPVA_BB' => 'nullable|string',
            'jatuh_tempo_izin' => 'nullable|date',
            'NPWP' => 'nullable|string',
            'wilayah_kerja' => 'required|string',
            'pulau' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'pengurus' => 'nullable|string',
            'pemegang_saham' => 'nullable|string',
            'pemegang_saham_list' => 'nullable|string',
            'pengurus_list' => 'nullable|string',
        ];
    }

    /**
     * Custom error messages (optional).
     */
    public function customValidationMessages()
    {
        return [
            'tahun.required' => 'Kolom tahun wajib diisi.',
            'bulan.required' => 'Kolom bulan wajib diisi.',
            'sandi.required' => 'Kolom sandi wajib diisi.',
            'jenis_produk.required' => 'Kolom jenis_produk wajib diisi.',
            'jenis_valuta.required' => 'Kolom jenis_valuta wajib diisi.',
            'saldo_awal.required' => 'Kolom saldo_awal wajib diisi.',
            'rata_saldo_awal.required' => 'Kolom rata_saldo_awal wajib diisi.',
            'volume_pembelian.required' => 'Kolom volume_pembelian wajib diisi.',
            'volume_penjualan.required' => 'Kolom volume_penjualan wajib diisi.',
            'saldo_akhir.required' => 'Kolom saldo_akhir wajib diisi.',
            'rata_saldo_akhir.required' => 'Kolom rata_saldo_akhir wajib diisi.',
            'kurs_tengah.required' => 'Kolom kurs_tengah wajib diisi.',
            '_saldo_akhir_hitung.required' => 'Kolom _saldo_akhir_hitung wajib diisi.',
            '_saldo_akhir_lebih.required' => 'Kolom _saldo_akhir_lebih wajib diisi.',
            '_saldo_akhir_lebih_selisih.required' => 'Kolom _saldo_akhir_lebih_selisih wajib diisi.',
            '_spread_keuntungan.required' => 'Kolom _spread_keuntungan wajib diisi.',
            '_stok_mata_uang_bertambah.required' => 'Kolom _stok_mata_uang_bertambah wajib diisi.',
            'wilayah_kerja.required' => 'Kolom wilayah_kerja wajib diisi.',
            'pulau.required' => 'Kolom pulau wajib diisi.',
            'provinsi.required' => 'Kolom provinsi wajib diisi.',
            'kota.required' => 'Kolom kota wajib diisi.',
        ];
    }
}
