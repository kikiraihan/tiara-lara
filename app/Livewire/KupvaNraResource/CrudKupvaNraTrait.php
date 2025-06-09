<?php

namespace App\Livewire\KupvaNraResource;

use Filament\Forms;
use Filament\Infolists;

trait CrudKupvaNraTrait
{
    public function createForm()
    {
        return 
        [
            Forms\Components\TextInput::make('id_lkpbu')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('tahun')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('nra')
                ->required()
                ->numeric()
                ->default(0.00),
        ];
    }

    public function editForm()
    {
        return 
        [
            Forms\Components\TextInput::make('id_lkpbu')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('tahun')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('nra')
                ->required()
                ->numeric()
                ->default(0.00),
        ];
    }

    public function viewInfolist()
    {
        return [];
    }

}