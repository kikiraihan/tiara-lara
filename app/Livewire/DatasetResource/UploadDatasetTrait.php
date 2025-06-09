<?php

namespace App\Livewire\DatasetResource;

use App\Enums\TemplateValidatorMapEnum;
use App\Models\Dataset;
use App\Models\ModelMachineLearning;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

trait UploadDatasetTrait
{
    public function importForm()
    {
        return [
            // Dropdown untuk memilih model ID
            Select::make('model_id')
                ->label('Pilih Model')
                ->options($this->getModelOptions()) // Ambil daftar model dari database
                ->searchable()
                ->required()
                ->reactive(), // Agar perubahan di `model_id` bisa dideteksi secara real-time

            Actions::make([
                Action::make('Dataset Template')
                    // ->url(asset('template_csv/2024-q4-df_km_2020.csv')) //variable
                    ->url(fn ($get) => $this->getDatasetTemplateUrl($get('model_id'))) // Gunakan $get untuk mengambil nilai model_id
                    ->color('success')
                    ->icon('heroicon-o-archive-box-arrow-down')
                    ->button(), // Field ini juga akan muncul jika `model_id` ,
            ])->visible(fn ($get) => $get('model_id')),

            Fieldset::make('Dataset')
            ->schema([
                // ...
                TextInput::make('title')
                    ->label('Judul dataset')
                    ->required()
                    ->maxLength(255)
                    ,
    
                FileUpload::make('uploadcsv')
                    ->label('CSV File')
                    ->storeFiles(false)
                    ->maxSize(50024)
                    ->required()
                    ,
            ])
            ->columns(1)
            ->visible(fn ($get) => $get('model_id'))
            , // Field ini juga akan muncul jika `model_id` ,

        ];
    }

    
    private function getDatasetTemplateUrl($modelId)
    {
        $templates = [
            1 => 'template_csv/2024-q4-pjp_perbulan_2021.csv',
            2 => 'template_csv/2024-q4-pjp_perbulan_2021.csv',
            3 => 'template_csv/2024-q4-pjp_perbulan_2021.csv',
            4 => 'template_csv/2024-q4-df_km_2020.csv',
            5 => 'template_csv/2024-q4-df_km_2020.csv',
            6 => 'template_csv/2024-q4-df_km_2020.csv',
        ];

        if (!isset($templates[$modelId])) {
            Notification::make()
                ->title('Error')
                ->body('Template tidak ditemukan untuk Model ID yang dipilih.')
                ->danger()
                ->send();

            return null;
        }

        return asset($templates[$modelId]);
    }
    
    private function getModelOptions()
    {
        return \App\Models\ModelMachineLearning::all()
            ->pluck('name_human', 'id')
            ->toArray(); // Format: ['id' => 'name']
    }


    public function uploadCSV(array $data, $form_component)
    {
        set_time_limit(6000); // Mengatur batas waktu maksimum eksekusi menjadi 6000 detik.

        // ambil judul
        $title = $data['title']; 

        // Ambil file yang diunggah
        $file = $data['uploadcsv'];

        // Validasi tipe file
        if (!in_array($file->getMimeType(), ['text/csv', 'text/plain'])) {
            // Hapus temporary file
            unlink($file->getRealPath());

            // Kirim notifikasi jika tipe file tidak valid
            return Notification::make()
                ->title("Error: tipe file yang diupload adalah " . $file->getMimeType())
                ->danger()
                ->persistent()
                ->send();
        }

        // Ambil ID model dari data
        $modelId = $data['model_id'] ?? null;
        if (!$modelId || !ModelMachineLearning::where('id', $modelId)->exists()) {
            // Hapus temporary file
            unlink($file->getRealPath());

            // Kirim notifikasi jika model_id tidak valid
            return Notification::make()
                ->title("Error: Model ID tidak valid")
                ->danger()
                ->persistent()
                ->send();
        }

        // Ambil model dan periksa apakah memiliki aturan validasi
        $model = ModelMachineLearning::findOrFail($modelId);

        // $ov = false;
        // // Cek apakah model memiliki aturan validasi
        // if ($model->validationRules->isEmpty() && $ov) {
        //     // Hapus temporary file
        //     unlink($file->getRealPath());

        //     // Kirim notifikasi jika tidak ada aturan validasi
        //     return Notification::make()
        //         ->title("Error: Model belum memiliki aturan validasi")
        //         ->danger()
        //         ->persistent()
        //         ->send();
        // }

        // Ambil aturan validasi
        // $rules = $model->validationRules->pluck('rule', 'column_name')->toArray();

        // $validatorEnum = TemplateValidatorMapEnum::tryFrom($model->template_dataset_validator);

        // // Ambil enum dari properti 'template_dataset_validator'
        // $validatorEnum = $model->template_dataset_validator;
        // // Ambil nama kelas dari enum
        // $validatorClass = $validatorEnum->getClass();

        try {
            // Proses validasi dan impor menggunakan Laravel Excel
            // dd($model->template_dataset_validator);
            // Excel::import(new $model->template_dataset_validator, $file); // nonaktifkan dulu validasi dataset

            $fname_save = $file->getFilename();
            $fname_save = str_replace("=", "", $fname_save);
            // Simpan metadata dataset jika validasi berhasil
            $fname = $file->storeAs('datasets', $fname_save, 'var-shared');
            
            $dataset = Dataset::create([
                'title'=> $title,
                'file_path' => $fname_save,
                'model_id' => $model->id,
            ]);

            Log::info($file->getRealPath());

            // set kosong lagi form
            $form_component->fill();
            // Hapus temporary file
            // unlink($file->getRealPath()); //sudah dihandle ->fill()

            // Kirim notifikasi berhasil
            return Notification::make()
                ->title("Berhasil import data ke dataset ID: " . $dataset->id)
                ->success()
                ->send();

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Tangani error validasi
            $failures = $e->failures();

            $messages = []; // Array untuk menyimpan pesan

            foreach ($failures as $index => $failure) {
                // Hentikan loop setelah iterasi kelima
                if ($index >= 5) break;

                // Tambahkan pesan ke array
                $messages[] =
                    $failure->errors()[0] // Pesan error
                    . 'kolom ' . $failure->attribute() // Nama kolom
                    . ', baris ' . $failure->row()
                    . " | \n\n\n"
                    ; // Nomor baris
            }

            // Gabungkan semua pesan menjadi satu string
            $finalMessage = implode("\n\n", $messages);

            // Kirim notifikasi error
            Notification::make()
                ->title($finalMessage)
                ->danger()
                ->persistent()
                ->send();

            $data['uploadcsv']=null;
            $form_component->fill($data);

        } finally {
            // kosong
        }
    }

}