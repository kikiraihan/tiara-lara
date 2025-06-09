<?php

namespace App\Livewire\KupvaProfilResource;

use App\Exports\KupvaProfilExport;
use App\Models\KupvaProfil;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class CrudKupvaProfil extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use CrudKupvaProfilTrait;

    public function table(Table $table): Table
    {
        return $table
            ->query(KupvaProfil::query())
            ->columns([
                Tables\Columns\TextColumn::make('id_lkpbu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_kpmiu')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tanggal_kpmiu')
                    ->date()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('nama_kupva_bb')
                    // ->searchable(),
                Tables\Columns\TextColumn::make('jatuh_tempo_izin')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('npwp')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('wilayah_kerja')
                    ->label('wilayah kerja (KPwDN)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pulau')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('provinsi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pengurus')
                    ->searchable()
                    ->label('Pengurus')
                    ->badge()
                    ->color('info')
                    ->separator(';')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pemegang_saham')
                    ->searchable()
                    ->label('Pemegang Saham')
                    ->badge()
                    ->color('success')
                    ->separator(';')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->form($this->editForm()),
                ViewAction::make()
                    ->infolist($this->viewInfolist()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->headerActions([

                Action::make('csvdownload')
                    ->label('Export')
                    ->color('success')
                    ->icon('eos-csv-file')
                ->action(fn () => Excel::download(new KupvaProfilExport, 'kupva_profil_'. date('Y_F_d') .'.csv', \Maatwebsite\Excel\Excel::CSV)),

                CreateAction::make()
                    ->form($this->createForm())
                    ->color('primary')
                    // ->modalAlignment(Alignment::Center)
                    // ->alignment(Alignment::Center)
                    ->label('Tambah Data'), // Atau label(null),
            ])
            ->heading('Profil KUPVA')
            // ->description('kelo here.')
            ;
    }

    public function render()
    {
        return view('livewire.kupva-profil-resource.crud-kupva-profil');
    }
}
