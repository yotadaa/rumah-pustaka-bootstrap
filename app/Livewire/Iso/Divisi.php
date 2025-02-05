<?php

namespace App\Livewire\Iso;

use Livewire\Component;

//model
use App\Models\Role;

class Divisi extends Component
{
    public $divisions;
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }
    public function render()
    {
        $this->divisions = Role::all();
        return view('livewire.iso.divisi');
    }
}
