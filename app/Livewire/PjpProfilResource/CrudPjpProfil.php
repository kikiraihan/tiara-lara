<?php

namespace App\Livewire\PjpProfilResource;

use App\Exports\PjpProfilExport;
use App\Models\PjpProfil;
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
use Maatwebsite\Excel\Facades\Excel;

class CrudPjpProfil extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use CrudPjpProfilTrait;

    public function table(Table $table): Table
    {
        return $table
            ->query(PjpProfil::query())
            ->columns([
                Tables\Columns\TextColumn::make('sandi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_izin')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('nama')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('tgl_jatuh_tempo_izin')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('npwp')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('modal_disetor')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kpwdn')
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
                ->action(fn () => Excel::download(new PjpProfilExport, 'pjp_profil_'. date('Y_F_d') .'.csv', \Maatwebsite\Excel\Excel::CSV)),

                CreateAction::make()
                    ->form($this->createForm())
                    ->color('primary')
                    // ->modalAlignment(Alignment::Center)
                    // ->alignment(Alignment::Center)
                    ->label('Tambah Data'), // Atau label(null),
            ])
            ->heading('Profil PJP')
            // ->description('kelo here.')
            ;
    }

    public function render()
    {
        return view('livewire.kupva-profil-resource.crud-kupva-profil');
    }
}
