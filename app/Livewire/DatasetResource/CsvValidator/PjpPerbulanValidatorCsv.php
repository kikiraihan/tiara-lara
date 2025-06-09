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

class PjpPerbulanValidatorCsv implements ToCollection, WithHeadingRow, WithValidation
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
        // dd($rows[0]);
        // Di sini Anda bisa memproses data lebih lanjut jika diperlukan.
        // Misalnya, Anda bisa menyimpan dataset ke file lain atau melakukan tindakan tertentu.
    }

    /**
     * Define the validation rules dynamically
     */
    public function rules(): array
    {
        // wip use specific columns
        return [
            'tahun' => 'required|numeric',
            'bulandata' => 'required|numeric',
            'sandi' => 'required|numeric',
            'total_nominal_transaksi_mean' => 'required|numeric',
            'total_nominal_transaksi_std' => 'required|numeric',
            'total_nominal_transaksi_min' => 'required|numeric',
            'total_nominal_transaksi_max' => 'required|numeric',
            'total_nominal_transaksi_sum' => 'required|numeric',
            'total_nominal_transaksi_25' => 'required|numeric',
            'total_nominal_transaksi_50' => 'required|numeric',
            'total_nominal_transaksi_75' => 'required|numeric',
            'frekuensi_pengiriman_mean' => 'required|numeric',
            'frekuensi_pengiriman_std' => 'required|numeric',
            'frekuensi_pengiriman_min' => 'required|numeric',
            'frekuensi_pengiriman_max' => 'required|numeric',
            'frekuensi_pengiriman_sum' => 'required|numeric',
            'frekuensi_pengiriman_25' => 'required|numeric',
            'frekuensi_pengiriman_50' => 'required|numeric',
            'frekuensi_pengiriman_75' => 'required|numeric',
            'most_frequent_sender' => 'required|string|max:255',
            'most_frequent_receiver' => 'required|string|max:255',
            'most_frequent_city' => 'required|numeric',
            'most_frequent_country' => 'required|string|max:255',
            'selisih_transaksi_outgoing_incoming' => 'required|numeric',
            // 'nama' => 'nullable|string|max:255',
            'pemegang_saham' => 'nullable|string|max:255',
            // 'pemegang_saham_list' => 'nullable|string|max:255',
            'modal_disetor' => 'nullable|numeric',
            'kpwdn' => 'nullable|string|max:255',
            'pengurus' => 'nullable|string',
            'pulau' => 'nullable|string',
            'provinsi' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            // 'nra_nr' => 'nullable|numeric',
            'nra_apu' => 'nullable|numeric',
            'other_sandi_related_through_receiver' => 'nullable|integer',
            'other_sandi_related_through_sender' => 'nullable|integer',
            'total_nominal_transaksi_mean_outlier' => 'nullable|numeric',
            'total_nominal_transaksi_std_outlier' => 'nullable|numeric',
            'frekuensi_pengiriman_mean_outlier' => 'nullable|numeric',
            'frekuensi_pengiriman_std_outlier' => 'nullable|numeric',
            // 'y_1pm_dt' => 'required|date_format:Y-m-d',
            // 'y_1pm_svr' => 'required|numeric',
        ];
    }

    /**
     * Custom error messages (optional).
     */
    public function customValidationMessages()
    {
        return [
            'tahun.required' => 'Tahun (tahun) wajib diisi.',
            'bulandata.required' => 'Bulan data (bulandata) wajib diisi.',
            'sandi.required' => 'Kode (sandi) wajib diisi.',
            'total_nominal_transaksi_mean.required' => 'Total nominal transaksi rata-rata (total_nominal_transaksi_mean) wajib diisi.',
            'total_nominal_transaksi_std.required' => 'Total nominal transaksi standar deviasi (total_nominal_transaksi_std) wajib diisi.',
            'total_nominal_transaksi_min.required' => 'Total nominal transaksi minimum (total_nominal_transaksi_min) wajib diisi.',
            'total_nominal_transaksi_max.required' => 'Total nominal transaksi maksimum (total_nominal_transaksi_max) wajib diisi.',
            'total_nominal_transaksi_sum.required' => 'Total nominal transaksi jumlah (total_nominal_transaksi_sum) wajib diisi.',
            'total_nominal_transaksi_25.required' => 'Total nominal transaksi kuartil pertama (total_nominal_transaksi_25) wajib diisi.',
            'total_nominal_transaksi_50.required' => 'Total nominal transaksi kuartil kedua (total_nominal_transaksi_50) wajib diisi.',
            'total_nominal_transaksi_75.required' => 'Total nominal transaksi kuartil ketiga (total_nominal_transaksi_75) wajib diisi.',
            'frekuensi_pengiriman_mean.required' => 'Frekuensi pengiriman rata-rata (frekuensi_pengiriman_mean) wajib diisi.',
            'frekuensi_pengiriman_std.required' => 'Frekuensi pengiriman standar deviasi (frekuensi_pengiriman_std) wajib diisi.',
            'frekuensi_pengiriman_min.required' => 'Frekuensi pengiriman minimum (frekuensi_pengiriman_min) wajib diisi.',
            'frekuensi_pengiriman_max.required' => 'Frekuensi pengiriman maksimum (frekuensi_pengiriman_max) wajib diisi.',
            'frekuensi_pengiriman_sum.required' => 'Frekuensi pengiriman jumlah (frekuensi_pengiriman_sum) wajib diisi.',
            'frekuensi_pengiriman_25.required' => 'Frekuensi pengiriman kuartil pertama (frekuensi_pengiriman_25) wajib diisi.',
            'frekuensi_pengiriman_50.required' => 'Frekuensi pengiriman kuartil kedua (frekuensi_pengiriman_50) wajib diisi.',
            'frekuensi_pengiriman_75.required' => 'Frekuensi pengiriman kuartil ketiga (frekuensi_pengiriman_75) wajib diisi.',
            'most_frequent_sender.required' => 'Pengirim paling sering (most_frequent_sender) wajib diisi.',
            'most_frequent_receiver.required' => 'Penerima paling sering (most_frequent_receiver) wajib diisi.',
            'most_frequent_city.required' => 'Kota paling sering (most_frequent_city) wajib diisi.',
            'most_frequent_country.required' => 'Negara paling sering (most_frequent_country) wajib diisi.',
            'selisih_transaksi_outgoing_incoming.required' => 'Selisih transaksi keluar dan masuk (selisih_transaksi_outgoing_incoming) wajib diisi.',
            'pemegang_saham.nullable' => 'Pemegang saham (pemegang_saham) opsional, jika ada.',
            'modal_disetor.nullable' => 'Modal disetor (modal_disetor) opsional, jika ada.',
            'kpwdn.nullable' => 'KPW DN (kpwdn) opsional, jika ada.',
            'pengurus.nullable' => 'Pengurus (pengurus) opsional, jika ada.',
            'pulau.nullable' => 'Pulau (pulau) opsional, jika ada.',
            'provinsi.nullable' => 'Provinsi (provinsi) opsional, jika ada.',
            'kota.nullable' => 'Kota (kota) opsional, jika ada.',
            'nra_apu.nullable' => 'NRA APU (nra_apu) opsional, jika ada.',
            'other_sandi_related_through_receiver.nullable' => 'Lainnya sandi terkait melalui penerima (other_sandi_related_through_receiver) opsional, jika ada.',
            'other_sandi_related_through_sender.nullable' => 'Lainnya sandi terkait melalui pengirim (other_sandi_related_through_sender) opsional, jika ada.',
            'total_nominal_transaksi_mean_outlier.required' => 'Outlier total nominal transaksi rata-rata (total_nominal_transaksi_mean_outlier) wajib diisi.',
            'total_nominal_transaksi_std_outlier.required' => 'Outlier total nominal transaksi standar deviasi (total_nominal_transaksi_std_outlier) wajib diisi.',
            'frekuensi_pengiriman_mean_outlier.required' => 'Outlier frekuensi pengiriman rata-rata (frekuensi_pengiriman_mean_outlier) wajib diisi.',
            'frekuensi_pengiriman_std_outlier.required' => 'Outlier frekuensi pengiriman standar deviasi (frekuensi_pengiriman_std_outlier) wajib diisi.',
        ];
    }


}
