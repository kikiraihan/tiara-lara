<?php

namespace App\Livewire;


use App\Models\Dataset;
use App\Models\ModelMachineLearning;
use App\Models\User;
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

// forms
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Form;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Log;

class CrudUser extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use CrudModelTrait;

    public function table(Table $table): Table
    {
        $form = $this->createForm();

        return $table
            ->query(User::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
                EditAction::make()->form(
                    $this->createForm("u")
                ),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form($form)
                    ->color('primary')
                    // ->modalAlignment(Alignment::Center)
                    // ->alignment(Alignment::Center)
                    ->label('Tambah Data'), // Atau label(null),
            ])
            ->heading('Users')
            // ->description('kelo here.')
            ;
    }

    public function createForm($t="create")
    {
        $fpassword = Forms\Components\TextInput::make('password')
            ->placeholder('password')
            ->maxLength(255);
        switch($t){
            case "c":
            case "create":
                $fpassword->required();
            break;
            default:
        }

        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->placeholder('nama user')
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->required()
                ->placeholder('email')
                ->maxLength(255),
            $fpassword,
        ];
    }

    public function render()
    {
        return view('livewire.crud-user');
    }

    function cl1(){
        Log::info("Test click user");
        return null;
    }
}
