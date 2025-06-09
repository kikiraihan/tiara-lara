<?php

namespace App\Livewire\Dashboard;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Dashboard extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    use DashFilterTrait;

    protected $listeners = ['refreshComponent' => '$refresh'];
    public $on_search;
    public $pjpOrKupva;

    public function mount(){
        $this->on_search=False;
        $this->pjpOrKupva=False;
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard');
        // return view('livewire.internal.dashboard.dash-merge');
    }

    public function filterAction(): Action
    {
        return Action::make('filter')
            ->label("Mulai")
            // ->color('primary')
            // ->badge(5)
            // ->outlined()
            // ->extraAttributes([
            //     'class' => 'bg-white border-2',
            // ])
            ->form($this->filterForm())
            // ->slideOver()
            ->action(fn ($data) => $this->runDash($data));
    }
}

