<?php

namespace App\Livewire\DocumentResource;

use App\Models\Document;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Livewire\DocumentResource\UploadDocumentTrait;
use App\Livewire\DocumentResource\CrudDocumentTrait;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class PageDocumentList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithInfolists;
    use UploadDocumentTrait;
    use CrudDocumentTrait;

    public Model $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(Document::query()->latest())
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('category')->searchable(),
                Tables\Columns\TextColumn::make('total_pages')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_private')->boolean(),
                Tables\Columns\TextColumn::make('file_path')->limit(20),
                Tables\Columns\TextColumn::make('created_at')->since()->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->label('Detail')
                    ->infolist($this->viewInfolist())
                    ->modalHeading('Informasi Dokumen'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->label('Hapus Dokumen')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                if (!$this->deleteRecordAndFile($record)) {
                                    return; // stop if any deletion fails
                                }
                            }
                            Notification::make()
                                ->title('Berhasil menghapus semua dokumen')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->headerActions([
                Action::make('upload')
                    ->label('Upload PDF')
                    ->color('primary')
                    ->form($this->createForm())
                    // ->action(fn(array $data) => $this->uploadPDF($data)),
                    ->url(route('crud.document.upload')),
                    
            ])
            ->heading('Manajemen Dokumen');
    }

    public function render(): View
    {
        return view('livewire.document-resource.document-list');
    }
}
