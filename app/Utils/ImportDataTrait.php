<?php

namespace App\Utils;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Validators\ValidationException;

trait ImportDataTrait
{
    public function importForm(String $path_to_template){
        return [
            Actions::make([
                Action::make('Template')
                    ->url(asset($path_to_template)) //variable
                    ->color('success')
                    ->icon('eos-download-o')
                    ->button(),

                Action::make('csv splitter')
                    ->url('https://extendsclass.com/csv-splitter.html') //variable
                    ->color('success')
                    ->icon('eos-link-o')
                    ->label('pecah CSV Online')
                    // ->target('_blank') // Membuka tautan dalam tab baru
                    ->button()
                    ->outlined()
                    ,

                Action::make('vlookupOnline')
                    ->url('http://www.vlookuponline.com/vlookup-online-tool-without-excel') //variable
                    ->color('success')
                    ->icon('eos-link-o')
                    ->label('vlookup online')
                    // ->target('_blank') // Membuka tautan dalam tab baru
                    ->button()
                    ->outlined()
                    ,
            ]),
            FileUpload::make('uploadcsv')
                ->label('CSV File')
                ->storeFiles(false)
                // ->acceptedFileTypes(['text/csv','text/plain']) // error di windows
                // ->acceptedFileTypes(['text/csv', 'text/plain', 'csv', 'txt', 'application/csv', 'application/octet-stream']) 
                ->maxSize(50024)
                ->required(),
        ];
    }

    public function uploadCSV(array $data, $import_class_instance)
    {
        set_time_limit(6000); // ini_set('max_execution_time', 600).  Ubah menjadi 10 menit (600 detik) atau nilai sesuai kebutuhan. berlaku sementara

        // Proses file yang diunggah
        $file = $data['uploadcsv'];

        // Validasi
        if (!in_array($file->getMimeType(),['text/csv','text/plain'])){
            //hapus temporary file
            unlink($file->getRealPath());
            
            return Notification::make()
                ->title("error tipe file yang diupload adalah ".$file->getMimeType())
                ->danger()
                // ->duration(8000)
                ->persistent()
                ->send();
        }

        // Proses
        try {
            $importer = $import_class_instance; //variable
            $importer->import($file);
            Notification::make()
                ->title("Berhasil import data")
                ->success()
                ->send();
            //hapus temporary file
            unlink($file->getRealPath());
        }
        
        // dokumentasi error handling
        // https://docs.laravel-excel.com/3.1/imports/validation.html#gathering-all-failures-at-the-end
        catch (ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $message =
                    $failure->errors()[0]."\n" 
                    .'in column '
                    .$failure->attribute()
                    .', in row '
                    .$failure->row()."\n" 
                    ;
                Notification::make()
                    ->title($message)
                    ->danger()
                    // ->duration(strlen($message) * 300)
                    ->persistent()
                    ->send();
            }
            //hapus temporary file
            unlink($file->getRealPath());
        }
    }
}