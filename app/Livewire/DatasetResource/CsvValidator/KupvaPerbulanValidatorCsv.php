<?php

namespace App\Livewire\DatasetResource\CsvValidator;

// use App\Models\Dataset;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Nette\Utils\Validators;

class KupvaPerbulanValidatorCsv implements ToCollection, WithHeadingRow, WithValidation
{
    // private $rules;
    
    public function __construct(){
        // $this->rules = $rules;
    }
    /**
     * Process the imported rows
     */
    public function collection(Collection $rows)
    {
        // Di sini Anda bisa memproses data lebih lanjut jika diperlukan.
        // Misalnya, Anda bisa menyimpan dataset ke file lain atau melakukan tindakan tertentu.
    }

        /**
     * Validation rules for the CSV file based on column names.
     */
    public function rules(): array
    {
        // wip use specific columns
        return [
            'tahun' => 'required|integer',
            'bulan' => 'required|integer',
            'sandi' => 'required|numeric',
            'jenis_produk' => 'required|string', #|max:255
            'jenis_valuta' => 'required|string', #|max:255
            'saldo_awal' => 'required|numeric',
            'rata_saldo_awal' => 'required|numeric',
            'volume_pembelian' => 'required|numeric',
            'volume_penjualan' => 'required|numeric',
            'saldo_akhir' => 'required|numeric',
            'rata_saldo_akhir' => 'required|numeric',
            'kurs_tengah' => 'required|numeric',
            'saldo_akhir_hitung' => 'required|numeric',
            'saldo_akhir_lebih' => 'required|numeric',
            'saldo_akhir_lebih_selisih' => 'required|numeric',
            'spread_keuntungan' => 'required|numeric',
            'stok_mata_uang_bertambah' => 'required|numeric',
            'NRA_APU' => 'nullable|numeric',
            // 'nama_KUPVA_BB' => 'required|string', #|max:255
            'wilayah_kerja' => 'required|string', #|max:255
            'pulau' => 'required|string', #|max:255
            'provinsi' => 'required|string', #|max:255
            'kota' => 'required|string', #|max:255
            'pengurus' => 'nullable|string', #|max:255
            'pengurus_list' => 'nullable|string', #|max:255
            'pemegang_saham' => 'nullable|string', #|max:255
            'pemegang_saham_list' => 'nullable|string', #|max:255
            'saldo_awal_outlier' => 'nullable|numeric',
            'volume_pembelian_outlier' => 'nullable|numeric',
            'volume_penjualan_outlier' => 'nullable|numeric',
            'saldo_akhir_outlier' => 'nullable|numeric',
            'saldo_akhir_hitung_outlier' => 'nullable|numeric',
            'saldo_akhir_lebih_selisih_outlier' => 'nullable|numeric',
            'spread_keuntungan_outlier' => 'nullable|numeric',
            // 'rf_4km_y' => 'nullable|numeric',
            'kpwdn' => 'nullable|string', #|max:255
        ];
    }

    /**
     * Custom error messages (optional).
     */
    public function customValidationMessages()
    {
        return [
            'tahun.required' => 'Tahun (tahun) wajib diisi.',
            'bulan.required' => 'Bulan (bulan) wajib diisi.',
            'sandi.required' => 'Kode (sandi) wajib diisi.',
            'jenis_produk.required' => 'Jenis produk (jenis_produk) wajib diisi.',
            'jenis_valuta.required' => 'Jenis valuta (jenis_valuta) wajib diisi.',
            'saldo_awal.required' => 'Saldo awal (saldo_awal) wajib diisi.',
            'rata_saldo_awal.required' => 'Rata-rata saldo awal (rata_saldo_awal) wajib diisi.',
            'volume_pembelian.required' => 'Volume pembelian (volume_pembelian) wajib diisi.',
            'volume_penjualan.required' => 'Volume penjualan (volume_penjualan) wajib diisi.',
            'saldo_akhir.required' => 'Saldo akhir (saldo_akhir) wajib diisi.',
            'rata_saldo_akhir.required' => 'Rata-rata saldo akhir (rata_saldo_akhir) wajib diisi.',
            'kurs_tengah.required' => 'Kurs tengah (kurs_tengah) wajib diisi.',
            'saldo_akhir_hitung.required' => 'Saldo akhir hitung (saldo_akhir_hitung) wajib diisi.',
            'saldo_akhir_lebih.required' => 'Saldo akhir lebih (saldo_akhir_lebih) wajib diisi.',
            'saldo_akhir_lebih_selisih.required' => 'Selisih saldo akhir lebih (saldo_akhir_lebih_selisih) wajib diisi.',
            'spread_keuntungan.required' => 'Spread keuntungan (spread_keuntungan) wajib diisi.',
            'stok_mata_uang_bertambah.required' => 'Stok mata uang bertambah (stok_mata_uang_bertambah) wajib diisi.',
            'NRA_APU.nullable' => 'NRA APU (NRA_APU) opsional, jika ada.',
            'wilayah_kerja.required' => 'Wilayah kerja (wilayah_kerja) wajib diisi.',
            'pulau.required' => 'Pulau (pulau) wajib diisi.',
            'provinsi.required' => 'Provinsi (provinsi) wajib diisi.',
            'kota.required' => 'Kota (kota) wajib diisi.',
            'pengurus.nullable' => 'Pengurus (pengurus) opsional, jika ada.',
            'pengurus_list.nullable' => 'Daftar pengurus (pengurus_list) opsional, jika ada.',
            'pemegang_saham.nullable' => 'Pemegang saham (pemegang_saham) opsional, jika ada.',
            'pemegang_saham_list.nullable' => 'Daftar pemegang saham (pemegang_saham_list) opsional, jika ada.',
            'saldo_awal_outlier.nullable' => 'Outlier saldo awal (saldo_awal_outlier) opsional, jika ada.',
            'volume_pembelian_outlier.nullable' => 'Outlier volume pembelian (volume_pembelian_outlier) opsional, jika ada.',
            'volume_penjualan_outlier.nullable' => 'Outlier volume penjualan (volume_penjualan_outlier) opsional, jika ada.',
            'saldo_akhir_outlier.nullable' => 'Outlier saldo akhir (saldo_akhir_outlier) opsional, jika ada.',
            'saldo_akhir_hitung_outlier.nullable' => 'Outlier saldo akhir hitung (saldo_akhir_hitung_outlier) opsional, jika ada.',
            'saldo_akhir_lebih_selisih_outlier.nullable' => 'Outlier selisih saldo akhir lebih (saldo_akhir_lebih_selisih_outlier) opsional, jika ada.',
            'spread_keuntungan_outlier.nullable' => 'Outlier spread keuntungan (spread_keuntungan_outlier) opsional, jika ada.',
            'kpwdn.nullable' => 'KPW DN (kpwdn) opsional, jika ada.',
        ];
    }


}
