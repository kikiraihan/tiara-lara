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
use App\Repositories\InferenceRepository;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Arr;
use Illuminate\Support\Facades\Log;
// use Log;

class PageDocumentList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithInfolists;
    use UploadDocumentTrait;
    use CrudDocumentTrait;

    public Model $record;

    // beware of public var of component's instances
    protected $inferenceRepository;
    protected $currentRecord;


    function __construct() {
        $inferenceRepository = app()->get(InferenceRepository::class);
        $this->inferenceRepository = $inferenceRepository;
    }

    public function table(Table $table): Table
    {
        $ctx = $this;

        return $table
            ->query(Document::query()->latest())
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('category')->searchable(),
                Tables\Columns\TextColumn::make('total_pages')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_private')->boolean(),
                Tables\Columns\TextColumn::make('file_path')->limit(20),
                Tables\Columns\TextColumn::make('created_at')->since()->sortable(),
                Tables\Columns\TextColumn::make('last_proc_at')->since()->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->label('Detail')
                    ->infolist($this->viewInfolist())
                    ->modalHeading('Informasi Dokumen'),
                Action::make('proc')
                    ->label('Proses')
                    ->action(function (Model $record) use($ctx){
                        Log::info("infer1 arg");
                        $ctx->setCurrentRecord($record);
                        Log::info(json_encode($record));
                        $ctx->doAction('proc');
                    })
                    /* 
                        ->action(
                        function () {
                        $log = app()->get(Log::class);
                        preout($log);
                        // logs("test proses");
                        return;
                    }) */
                    ,
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
                    ->label('Upload Dokumen')
                    ->color('primary')
                    ->form($this->createForm())
                    // ->action(fn(array $data) => $this->uploadPDF($data)),
                    ->url(route('crud.document.upload')),
                    
            ])
            ->heading('Manajemen Dokumen');
    }

    function doAction(string $name, string|null $component = null, string|null $infolist = null){
        Log::info("mountInfolistAction $name $component");
        switch($name){
            case "test1":
                Log::info("$name $component");
                // update the ui
                
            break;
            case "proc":
            case "extract":
                $record = $this->getCurrentRecord();
                Log::info("extract start");
                Log::info($record);
                Log::info("extract end");
                $d = [
                    "id" => $record->id,
                    "file" => $record->file_path,
                ];

                Log::info("extract conditional push");
                // $r = $this->inferenceRepository->extract($d);
                $r = $this->inferenceRepository->conditionalPush(1, $d);
            break;
            case "infer":
            case "infer1":
                Log::info("Infer start");
                $record = $this->getMountedTableActionRecord();
                $f = $record->model->name;
                $r = 1;
                
                $r = $this->inferenceRepository->infer($f, [
                    "f" => $f, 
                    "a" => "user-infer",
                    "file" => $record->file_path,
                    // wip additional rules
                ]);
                
                if( Arr::get($r, 'success') ){
                    $evtn = 'infer-success';
                    // $record->result = json_encode($r);
                    // $record->save();
                }else{
                    $evtn = 'infer-fail';
                }
                $this->dispatch($evtn, [
                    "data" => [
                        "x" => 1,
                        "r" => $r,
                    ]
                ]);

                Log::info(json_encode($r));
                Log::info("Infer complete");
            break;
            default:
                Log::info("Unknown mnt infolist");
        }
    }

    public function render(): View
    {
        return view('livewire.document-resource.document-list');
    }

    /**
     * Get the value of currentRecord
     */ 
    public function getCurrentRecord()
    {
        return $this->currentRecord;
    }

    /**
     * Set the value of currentRecord
     *
     * @return  self
     */ 
    public function setCurrentRecord($currentRecord)
    {
        $this->currentRecord = $currentRecord;

        return $this;
    }
}
