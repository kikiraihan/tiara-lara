<?php

namespace App\Livewire\KupvaProfilResource;

use Filament\Forms;
use Filament\Infolists;

trait CrudKupvaProfilTrait
{
    public function createForm()
    {
        return 
        [
            Forms\Components\TextInput::make('id_lkpbu')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('no_kpmiu')
                ->maxLength(255),
            Forms\Components\DatePicker::make('tanggal_kpmiu'),
            // Forms\Components\TextInput::make('nama_kupva_bb')
            //     ->maxLength(255),
            Forms\Components\DatePicker::make('jatuh_tempo_izin'),
            Forms\Components\TextInput::make('npwp')
                ->maxLength(255),
            Forms\Components\TextInput::make('wilayah_kerja')
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
            Forms\Components\TextInput::make('id_lkpbu')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('no_kpmiu')
                ->maxLength(255),
            Forms\Components\DatePicker::make('tanggal_kpmiu'),
            // Forms\Components\TextInput::make('nama_kupva_bb')
            //     ->maxLength(255),
            Forms\Components\DatePicker::make('jatuh_tempo_izin'),
            Forms\Components\TextInput::make('npwp')
                ->maxLength(255),
            Forms\Components\TextInput::make('wilayah_kerja')
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
            Infolists\Components\Section::make('Informasi Kupva Profil')
                ->schema([
                    Infolists\Components\TextEntry::make('id_lkpbu')->label('ID LKPBU'),
                    Infolists\Components\TextEntry::make('no_kpmiu')->label('No. KPMIU'),
                    Infolists\Components\TextEntry::make('tanggal_kpmiu')->label('Tanggal KPMIU')->date(),
                    // Infolists\Components\TextEntry::make('nama_kupva_bb')->label('Nama Kupva BB'),
                    Infolists\Components\TextEntry::make('jatuh_tempo_izin')->label('Jatuh Tempo Izin')->date(),
                    Infolists\Components\TextEntry::make('npwp')->label('NPWP'),
                    Infolists\Components\TextEntry::make('wilayah_kerja')->label('Wilayah Kerja'),
                    Infolists\Components\TextEntry::make('pulau')->label('Pulau'),
                    Infolists\Components\TextEntry::make('provinsi')->label('Provinsi'),
                    Infolists\Components\TextEntry::make('kota')->label('Kota'),
                    Infolists\Components\TextEntry::make('pengurus')
                        ->label('Pengurus')
                        ->badge()->color('info')
                        ->separator(';'),
                    Infolists\Components\TextEntry::make('pemegang_saham')
                        ->label('Pemegang Saham')
                        ->badge()->color('success')
                        ->separator(';'),
                ])
                ->columns(2),
        ];
    }

}