<?php

namespace App\Livewire\DatasetResource;
use App\Imports\CImports;
use Filament\Tables;
use Filament\Infolists;
use Illuminate\Support\Facades\Log;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Model;

// use Action;
use Arr;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;

trait InferDatasetTrait{
  public function inferAction(){
    return Tables\Actions\Action::make('infer')
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
    ]);
  }
}
