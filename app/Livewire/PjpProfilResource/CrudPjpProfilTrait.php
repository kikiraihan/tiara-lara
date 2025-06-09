<?php

namespace App\Livewire\PjpProfilResource;

use Filament\Forms;
use Filament\Infolists;

trait CrudPjpProfilTrait
{
    public function createForm()
    {
        return 
        [
            Forms\Components\TextInput::make('sandi')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('no_izin')
                ->maxLength(255),
            // Forms\Components\TextInput::make('nama')
            //     ->maxLength(255),
            Forms\Components\DatePicker::make('tgl_jatuh_tempo_izin'),
            Forms\Components\TextInput::make('npwp')
                ->maxLength(255),
            Forms\Components\TextInput::make('modal_disetor')
                ->required()
                ->numeric()
                ->default(0),
            Forms\Components\TextInput::make('kpwdn')
                ->maxLength(255),
            Forms\Components\TextInput::make('pulau')
                ->maxLength(255),
            Forms\Components\TextInput::make('provinsi')
                ->maxLength(255),
            Forms\Components\TextInput::make('kota')
                ->maxLength(255),
            Forms\Components\TagsInput::make('pengurus')
                ->reorderable()
                ->nestedRecursiveRules([
                    'min:3',
                    'max:255',
                ])
                ->separator(';'),
            Forms\Components\TagsInput::make('pemegang_saham')
                ->reorderable()
                ->nestedRecursiveRules([
                    'min:3',
                    'max:255',
                ])
                ->separator(';'),
        ];
    }

    public function editForm()
    {
        return 
        [
            Forms\Components\TextInput::make('sandi')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('no_izin')
                ->maxLength(255),
            // Forms\Components\TextInput::make('nama')
            //     ->maxLength(255),
            Forms\Components\DatePicker::make('tgl_jatuh_tempo_izin'),
            Forms\Components\TextInput::make('npwp')
                ->maxLength(255),
            Forms\Components\TextInput::make('modal_disetor')
                ->required()
                ->numeric()
                ->default(0),
            Forms\Components\TextInput::make('kpwdn')
                ->maxLength(255),
            Forms\Components\TextInput::make('pulau')
                ->maxLength(255),
            Forms\Components\TextInput::make('provinsi')
                ->maxLength(255),
            Forms\Components\TextInput::make('kota')
                ->maxLength(255),
            Forms\Components\TagsInput::make('pengurus')
                ->reorderable()
                ->nestedRecursiveRules([
                    'min:3',
                    'max:255',
                ])
                ->separator(';'),
            Forms\Components\TagsInput::make('pemegang_saham')
                ->reorderable()
                ->nestedRecursiveRules([
                    'min:3',
                    'max:255',
                ])
                ->separator(';'),
        ];
    }

    public function viewInfolist()
    {
        return [
            Infolists\Components\Section::make('Informasi PJP Profil')
                ->schema([
                    Infolists\Components\TextEntry::make('sandi')
                        ->label('Sandi'),
                    Infolists\Components\TextEntry::make('no_izin')
                        ->label('No. Izin'),
                    // Infolists\Components\TextEntry::make('nama')
                    //     ->label('Nama'),
                    Infolists\Components\TextEntry::make('tgl_jatuh_tempo_izin')
                        ->label('Tanggal Jatuh Tempo Izin')
                        ->date(),
                    Infolists\Components\TextEntry::make('npwp')
                        ->label('NPWP'),
                    Infolists\Components\TextEntry::make('modal_disetor')
                        ->label('Modal Disetor')
                        ->numeric(),
                    Infolists\Components\TextEntry::make('kpwdn')
                        ->label('KPWDN'),
                    Infolists\Components\TextEntry::make('pulau')
                        ->label('Pulau'),
                    Infolists\Components\TextEntry::make('provinsi')
                        ->label('Provinsi'),
                    Infolists\Components\TextEntry::make('kota')
                        ->label('Kota'),
                    Infolists\Components\TextEntry::make('pengurus')
                        ->label('Pengurus')
                        ->badge()->color('info')
                        ->separator(';'),
                    Infolists\Components\TextEntry::make('pemegang_saham')
                        ->label('Pemegang Saham')
                        ->badge()->color('success')
                        ->separator(';'),
                    Infolists\Components\TextEntry::make('created_at')
                        ->label('Tanggal Dibuat')
                        ->dateTime(),
                    Infolists\Components\TextEntry::make('updated_at')
                        ->label('Tanggal Diperbarui')
                        ->dateTime(),
                ])
                ->columns(2),
        ];
    }


}