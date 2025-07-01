<?php

namespace App\Livewire\DocumentResource;

use App\Models\Document;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Fieldset;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait UploadDocumentTrait
{
    public function uploadForm()
    {
        return [
            Fieldset::make('Upload Dokumen')
                ->schema([
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

                    FileUpload::make('uploadpdf')
                        ->label('File PDF')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(10240) // 10 MB
                        ->required()
                        ->storeFiles(false), // Disimpan manual di handler
                ])
                ->columns(1),
        ];
    }

    public function uploadPDF(array $data, $formComponent)
    {
        try {
            $file = $data['uploadpdf'];

            // Validasi mime type
            if ($file->getClientOriginalExtension() !== 'pdf') {
                return Notification::make()
                    ->title("Error: File harus berupa PDF.")
                    ->danger()
                    ->persistent()
                    ->send();
            }

            $filename = uniqid('document_') . '.pdf';

            // Simpan file
            // wip use env
            // $path = $file->storeAs('documents', $filename, 'var-shared'); // kalau di server
            $path = $file->storeAs('documents', $filename, 'public');

            // Hitung total halaman (opsional — jika bisa pakai library pembaca PDF)

            // Simpan metadata
            $document = Document::create([
                'title' => $data['title'],
                'category' => $data['category'],
                'is_private' => $data['is_private'] ?? false,
                'file_path' => $path,
                'total_pages' => null, // atau isi jika punya logic hitung halaman
                'file_size' => null, // atau isi jika punya logic hitung halaman
            ]);

            // Reset form
            $formComponent->fill();

            return Notification::make()
                ->title("Berhasil upload dokumen: ID {$document->id}")
                ->success()
                ->send();

                
        } catch (\Throwable $th) {
            Log::info('error saat upload document', [$th->getMessage()]);
            // Kirim notifikasi error
            Notification::make()
                ->title('Terjadi error saat upload document: '.$th->getMessage())
                ->danger()
                ->persistent()
                ->send();

            $data['uploadcsv']=null;
            $formComponent->fill($data);
        }
        
    }
}
