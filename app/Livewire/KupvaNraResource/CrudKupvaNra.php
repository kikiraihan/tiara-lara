<?php

namespace App\Livewire\KupvaNraResource;

use App\Exports\KupvaNraExport;
use App\Models\KupvaNra;
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

class CrudKupvaNra extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use CrudKupvaNraTrait;

    public function table(Table $table): Table
    {
        return $table
            ->query(KupvaNra::query())
            ->columns([
                Tables\Columns\TextColumn::make('id_lkpbu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun')
                    // ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nra')
                    ->numeric()
                    ->sortable(),
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
                ->action(fn () => Excel::download(new KupvaNraExport, 'kupva_nra_'. date('Y_F_d') .'.csv', \Maatwebsite\Excel\Excel::CSV)),

                // ActionGroup::make([
                //     Action::make('csvdownload')
                //         ->label('CSV')
                //         ->color('success')
                //         ->icon('eos-csv-file')
                //         ->action(fn () => Excel::download(new KupvaNraExport, 'kupva_nra_'. date('Y_F_d') .'.csv', \Maatwebsite\Excel\Excel::CSV)),

                //     Action::make('exceldownload')
                //         ->label('Excel')
                //         ->color('success')
                //         ->icon('eos-csv-file')
                //         ->action(fn () => Excel::download(new KupvaNraExport, 'kupva_nra_'. date('Y_F_d') .'.xlsx', \Maatwebsite\Excel\Excel::XLSX)),
                // ])
                //     ->label('Download')
                //     ->color('success')
                //     ->icon('eos-download')
                //     ->button(),

                CreateAction::make()
                    ->form($this->createForm())
                    ->color('primary')
                    // ->modalAlignment(Alignment::Center)
                    // ->alignment(Alignment::Center)
                    ->label('Tambah Data'), // Atau label(null),
            ])
            ->heading('NRA KUPVA')
            // ->description('kelo here.')
            ;
    }

    public function render()
    {
        return view('livewire.kupva-nra-resource.crud-kupva-nra');
    }
}
