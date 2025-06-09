<?php

namespace App\Livewire\DatasetResource;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;

trait CrudDatasetTrait
{
    public function createForm()
    {
        return 
        [
        ];
    }

    public function editForm()
    {
        return 
        [
            
        ];
    }

    public function viewInfolist()
    {
        return [

        ];
    }

    protected function deleteRecordAndFile($record)
    {
        try {
            // Hapus file jika atribut file_path tersedia
            if (!empty($record->file_path)) {
                $this->deleteFile($record->file_path);
            }

            // Hapus record dari database
            $record->delete();

            return true; // Proses berhasil
        } catch (\Exception $e) {
            // Kirim notifikasi error dan hentikan
            Notification::make()
                ->title("Error: Tidak dapat menghapus record atau file. Pesan: " . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();

            return false; // Proses gagal
        }
    }

    protected function deleteFile(string $filePath)
{
    try {
        // Gunakan Storage untuk memeriksa dan menghapus file
        \Storage::delete($filePath);
        // if (\Storage::exists($filePath)) {
        // } else {
        //     throw new \Exception("File tidak ditemukan di path: " . $filePath);
        // }
    } catch (\Exception $e) {
        // Tangani error dengan notifikasi
        Notification::make()
            ->title("Error: Tidak dapat menghapus file. Pesan: " . $e->getMessage())
            ->danger()
            ->persistent()
            ->send();

        throw $e; // Lempar exception agar proses utama tahu ada error
    }
}



}