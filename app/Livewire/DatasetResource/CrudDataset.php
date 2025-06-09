<?php

namespace App\Livewire\DatasetResource;

use App\Imports\CImports;
use App\Models\Dataset;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\InferenceRepository;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

use Filament\Infolists;
// use Filament\Infolists\Components\Actions;
// use Filament\Infolists\Components\Actions\Action;

use Illuminate\Support\Facades\Log;
// use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Model;

// use Action;
use Arr;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;

class CrudDataset extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithInfolists;
    
    // use InferDatasetTrait;
    use CrudDatasetTrait;
    use UploadDatasetTrait;

    // beware of public var of component's instances
    protected $inferenceRepository;

    public Model $record;

    // function __construct(BaseRepositoryInterface $inferenceRepository) {
        // BaseRepositoryInterface $inferenceRepository
    function __construct() {
        $inferenceRepository = app()->get(InferenceRepository::class);
        $this->inferenceRepository = $inferenceRepository;
    }

    function mount(Dataset $record): void {
        Log::info(json_encode($record));
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Dataset::query()->orderBy('created_at', 'desc'))
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model.name_human')
                    ->label('Model Template')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('model.type')
                //     ->label('Tipe')
                //     ->searchable(),
                Tables\Columns\IconColumn::make('file_path')
                    ->icon(fn ($record) => $record->file_path ? 'eos-check-circle' : 'eos-question-mark')
                    ->colors([
                        'success' => fn ($record) => $record->file_path,
                        'secondary' => fn ($record) => !$record->file_path, // Abu-abu untuk nilai kosong
                    ]),
                Tables\Columns\IconColumn::make('result')
                    ->icon(fn ($record) => $record->result ? 'eos-check-circle' : 'eos-question-mark')
                    ->colors([
                        'success' => fn ($record) => $record->result,
                        'secondary' => fn ($record) => !$record->result, // Abu-abu untuk nilai kosong
                    ]),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // $this->inferAction(),
                Tables\Actions\Action::make('infer')
                    // This is the important part!
                    ->accessSelectedRecords()
                    ->action(function (Model $record) {
                        Log::info("infer1 arg");
                        Log::info(json_encode($record));
                    })
                    ->infolist([
                        Section::make('Data x')
                            ->schema([
                                // TextInput::make('name')->default('John'),
                                TextEntry::make("id"),
                                TextEntry::make("file_path"),
                                TextEntry::make("model.name"),
                                TextEntry::make("kolom")
                                    ->helperText(function(Model $e){
                                        $d = Excel::toCollection(new CImports(), "/var/shared/datasets/{$e->file_path}")
                                            ->toArray();
                                        
                                        $s = json_encode([
                                            $d[0][0],
                                            count($d[0])
                                        ]);

                                        return new HtmlString(<<<HTML
                                            <pre>$s</pre>
                                        HTML);
                                    }),
                                TextEntry::make('hasil')
                                    ->helperText(function(Model $e){
                                        $json = json_encode($e->result);
                                        return new HtmlString(<<<HTML
                                            <pre>$json</pre>
                                        HTML);
                                    }),
                                TextEntry::make('updated_at'),
                            ]),
                        Infolists\Components\Actions::make([
                            Infolists\Components\Actions\Action::make('test1')
                            ->icon('heroicon-m-star')
                            ->requiresConfirmation()
                            ->action(function () {
                                Log::info("action infolist");
                            }),
                        ]),
                        Infolists\Components\Actions::make([
                            Infolists\Components\Actions\Action::make('infer')
                            ->icon('heroicon-m-star')
                            ->requiresConfirmation()
                            ->action(function (Model $record) {
                                Log::info("infer1 arg");
                                Log::info(json_encode($record));
                            }),
                        ])
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                // Hentikan proses jika terjadi error pada deleteRecord
                                if (!$this->deleteRecordAndFile($record)) {
                                    return; // Hentikan seluruh proses jika ada error
                                }
                            }
                    
                            // Kirim notifikasi setelah semua record berhasil dihapus
                            Notification::make()
                                ->title("Berhasil menghapus semua data dan file yang terkait.")
                                ->success()
                                ->send();
                        })                                  
                        ->icon('heroicon-s-trash')
                        ->color('danger')
                        ->label('hapus'), // Atau label(null),
                ]),
            ])
            ->headerActions([
                // CreateAction::make()
                //     ->form($this->createForm())
                //     ->color('primary')
                //     // ->modalAlignment(Alignment::Center)
                //     // ->alignment(Alignment::Center)
                //     ->label('Tambah Data'), // Atau label(null),

                Action::make('csvupload')
                    ->label('Upload Data')
                    // ->icon('eos-csv-file')
                    ->url(route('crud.dataset.upload')),
                    // ->form($this->importForm('_csv_template/cabang.csv'))
                    // ->action(fn ($data) => $this->uploadCSV($data)),
            ])
            ->heading('Dataset')
            // ->description('kelo here.')
            ;
    }

    public function render()
    {
        return view('livewire.dataset-resource.crud-dataset');
    }

    // mixed mountInfolistAction(string $name, string|null $component = null, string|null $infolist = null)
    function mountInfolistAction(string $name, string|null $component = null, string|null $infolist = null){
        switch($name){
            case "test1":
                Log::info("$name $component");
                // update the ui
                
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
                    $record->result = json_encode($r);
                    $record->save();
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
}
