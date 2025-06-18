<?php

namespace App\Livewire\DocumentResource;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class PageDocumentUploadForm extends Component implements HasForms
{
    use InteractsWithForms;
    use UploadDocumentTrait;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->uploadForm())
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $this->uploadPDF($data,$this->form);
    }

    public function render()
    {
        return view('livewire.document-resource.document-upload-form');
    }
}
