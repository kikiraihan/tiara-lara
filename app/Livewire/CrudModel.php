<?php

namespace App\Livewire;


use App\Models\Dataset;
use App\Models\ModelMachineLearning;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class CrudModel extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use CrudModelTrait;

    public function table(Table $table): Table
    {
        return $table
            ->query(ModelMachineLearning::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Code name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_human')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model_used')
                    ->label('Algorithm')
                    ->searchable(),
                // Tables\Columns\IconColumn::make('file_path')
                //     ->label('File')
                //     ->icon('eos-configuration-file-o')
                //     // ->icon(null)
                //     ->alignCenter()
                //     ->url(fn($record) => $record->file_path ? url($record->file_path) : null) // URL untuk unduh jika ada
                //     ->openUrlInNewTab()
                //     ->tooltip(fn($record) => $record->file_path) // Tampilkan tooltip dengan data isi file_path
                //     ->extraAttributes(['class' => 'hover:text-blue-500 hover:scale-110 transition']), // Tambahkan efek hover

                // Tables\Columns\IconColumn::make('template_dataset_path')
                //     ->label('Template')
                //     // ->icon('eos-csv-file')
                //     ->alignCenter()
                //     ->url(fn($record) => $record->template_dataset_path ? url($record->template_dataset_path) : null) // URL untuk unduh jika ada
                //     ->openUrlInNewTab()
                //     ->tooltip(fn($record) => $record->template_dataset_path) // Tampilkan tooltip dengan data isi file_path
                //     ->extraAttributes(['class' => 'hover:text-blue-500 hover:scale-110 transition']), // Tambahkan efek hover

                // Tables\Columns\TextColumn::make('validation_rules_count')
                //     ->label('Validation Rules') // Nama kolom di tabel
                //     ->counts('validationRules') // Hitung jumlah relasi validationRules
                //     ->alignCenter()
                //     ->sortable(), // Jika ingin kolom bisa diurutkan
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
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->headerActions([
                // CreateAction::make()
                //     ->form($this->createForm())
                //     ->color('primary')
                //     // ->modalAlignment(Alignment::Center)
                //     // ->alignment(Alignment::Center)
                //     ->label('Tambah Data'), // Atau label(null),
            ])
            ->heading('Model')
            // ->description('kelo here.')
            ;
    }

    public function render()
    {
        return view('livewire.crud-model');
    }
}
