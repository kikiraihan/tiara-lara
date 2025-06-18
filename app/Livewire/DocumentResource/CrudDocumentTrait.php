<?php

namespace App\Livewire\DocumentResource;

use App\Models\Document;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

trait CrudDocumentTrait
{
    public function createForm()
    {
        return [
            TextInput::make('title')
                ->label('Judul Dokumen')
                ->required(),

            Select::make('category')
                ->label('Kategori')
                ->options([
                    'general' => 'General',
                    'legal' => 'Legal',
                    'finance' => 'Finance',
                ])
                ->required(),

            Toggle::make('is_private')
                ->label('Privat?')
                ->default(false),
        ];
    }

    public function editForm()
    {
        return $this->createForm();
    }

    public function viewInfolist()
    {
        return [
            Section::make('Informasi Dokumen')
                ->schema([
                    TextEntry::make('title')->label('Judul'),
                    TextEntry::make('category')->label('Kategori'),
                    TextEntry::make('total_pages')->label('Total Halaman'),
                    TextEntry::make('is_private')
                        ->label('Privat')
                        ->formatStateUsing(fn (bool $state) => $state ? 'Ya' : 'Tidak'),
                    TextEntry::make('created_at')->label('Dibuat'),
                    TextEntry::make('updated_at')->label('Diubah Terakhir'),
                ])
        ];
    }

    protected function deleteRecordAndFile($record)
    {
        try {
            if (!empty($record->file_path)) {
                $this->deleteFile($record->file_path);
            }

            $record->delete();

            return true;
        } catch (\Exception $e) {
            Notification::make()
                ->title("Gagal menghapus dokumen. Pesan: {$e->getMessage()}")
                ->danger()
                ->persistent()
                ->send();

            return false;
        }
    }

    protected function deleteFile(string $filePath)
    {
        try {
            Storage::disk('public')->delete($filePath);
        } catch (\Exception $e) {
            Notification::make()
                ->title("Gagal menghapus file. Pesan: {$e->getMessage()}")
                ->danger()
                ->persistent()
                ->send();

            throw $e;
        }
    }
}
