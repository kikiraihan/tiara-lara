<?php

namespace App\Livewire\PjpNraResource;

use App\Exports\PjpNraExport;
use App\Models\PjpNra;
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

class CrudPjpNra extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use CrudPjpNraTrait;

    public function table(Table $table): Table
    {
        return $table
            ->query(PjpNra::query())
            ->columns([
                Tables\Columns\TextColumn::make('sandi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nra')
                    ->label('NRA')
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
                ->action(fn () => Excel::download(new PjpNraExport, 'pjp_nra_'. date('Y_F_d') .'.csv', \Maatwebsite\Excel\Excel::CSV)),

                CreateAction::make()
                    ->form($this->createForm())
                    ->color('primary')
                    // ->modalAlignment(Alignment::Center)
                    // ->alignment(Alignment::Center)
                    ->label('Tambah Data'), // Atau label(null),
            ])
            ->heading('NRA PJP')
            // ->description('kelo here.')
            ;
    }

    public function render()
    {
        return view('livewire.pjp-nra-resource.crud-pjp-nra');
    }
}
