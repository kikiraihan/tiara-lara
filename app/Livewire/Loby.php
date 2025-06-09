<?php

namespace App\Livewire;

use App\Models\Dataset;
use App\Models\User;
use Livewire\Component;

class Loby extends Component
{
    public $count_dataset_uninfered, $count_dataset_infered, $count_user,$user_login_name;

    public function mount(){
        $this->user_login_name = auth()->user()->name;
        $this->count_dataset_infered = Dataset::whereNotNull('result')->count();
        $this->count_dataset_uninfered = Dataset::whereNull('result')->count();
        $this->count_user = User::count();
    }

    public function render()
    {
        return view('livewire.loby');
    }
}
