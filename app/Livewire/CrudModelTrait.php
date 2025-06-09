<?php

namespace App\Livewire;

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

trait CrudModelTrait
{
    public function createForm()
    {
        return 
        [
            Forms\Components\TextInput::make('name')
                ->required()
                ->placeholder('svm-01-02-2023')
                ->maxLength(255),

            Forms\Components\FileUpload::make('file_path')
                ->label('Upload model')
                ->hint('Pickle File')
                ->required()
                // ->acceptedFileTypes(['application/octet-stream']) // Validasi tipe file (pickle)
                ->directory('pickles') // Direktori penyimpanan
                ->maxSize(1024), // Ukuran maksimum dalam KB (misal 1 MB)
                
            Forms\Components\FileUpload::make('template_dataset_path')
                ->label('Upload template File')
                ->hint('CSV file')
                ->required()
                ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel']) // Validasi tipe file (csv)
                ->directory('template_datasets') // Direktori penyimpanan
                ->maxSize(2048), // Ukuran maksimum dalam KB (misal 2 MB)

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
}