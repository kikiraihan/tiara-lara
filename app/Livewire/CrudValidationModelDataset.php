<?php

namespace App\Livewire;

use App\Models\Dataset;
use App\Models\ModelMachineLearning;
use App\Models\ValidationDatasetModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CrudValidationModelDataset extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use CrudValidationModelDatasetTrait;

    public function table(Table $table): Table
    {
        return $table
            ->query(ValidationDatasetModel::query())
            ->columns([
                Tables\Columns\TextColumn::make('model.name') // Relasi ke model
                    ->label('Model Name') // Tampilkan nama model
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('column_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rule')
                    ->searchable(),
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
                SelectFilter::make('model_id')
                ->label('Model ID')
                ->options(
                    ModelMachineLearning::pluck('name', 'id')->toArray() // Ambil nama model sebagai opsi
                )
                ->searchable()
                ->placeholder('Semua Model') // Tambahkan opsi default
            ])// , layout: FiltersLayout::AboveContent)
            ->actions([
                //
                EditAction::make()
                    ->form($this->editForm()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                        ->icon('heroicon-s-trash')
                        ->color('danger')
                        ->label('hapus'), // Atau label(null),
                ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form($this->createForm())
                    ->color('primary')
                    // ->modalAlignment(Alignment::Center)
                    // ->alignment(Alignment::Center)
                    ->label('Tambah Data'), // Atau label(null),
            ])
            ->heading('Validation Model Dataset')
            // ->description('kelo here.')
            ;
    }

    public function render()
    {
        return view('livewire.crud-validation-model-dataset');
    }
}
