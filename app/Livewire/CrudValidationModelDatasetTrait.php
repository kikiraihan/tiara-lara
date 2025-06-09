<?php

namespace App\Livewire;

use App\Models\ModelMachineLearning;
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

trait CrudValidationModelDatasetTrait
{
    public function createForm()
    {
        return 
        [
            Select::make('model_id')
                ->label('Pilih Model')
                ->options(
                    ModelMachineLearning::all()
                    ->pluck('name', 'id')
                    ->toArray()
                ) // Ambil daftar model dari database
                ->searchable()
                ->required()
                ->reactive(), // Agar perubahan di `model_id` bisa dideteksi secara real-time
            Forms\Components\TextInput::make('column_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TagsInput::make('rule')
                ->reorderable()
                ->nestedRecursiveRules([
                    'min:3',
                    'max:255',
                ])
                ->label('rule'),
            // Forms\Components\TextInput::make('rule')
            //     ->required()
            //     ->maxLength(255),
        ];
    }

    public function editForm()
    {
        return 
        [
            Select::make('model_id')
                ->label('Pilih Model')
                ->options(
                    ModelMachineLearning::all()
                    ->pluck('name', 'id')
                    ->toArray()
                ) // Ambil daftar model dari database
                ->searchable()
                ->required()
                ->reactive(), // Agar perubahan di `model_id` bisa dideteksi secara real-time
            Forms\Components\TextInput::make('column_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TagsInput::make('rule')
                ->reorderable()
                ->nestedRecursiveRules([
                    'min:3',
                    'max:255',
                ])
                ->label('rule'),
            // Forms\Components\TextInput::make('rule')
            //     ->required()
            //     ->maxLength(255),
        ];
    }

    public function viewInfolist()
    {
        return [

        ];
    }
}