<?php

namespace App\Livewire\Akreditasi;

use Livewire\Component;

class Berkas extends Component
{

    public $showFormBerkas = false;
    public $berkas;
    public $name;
    public $editName;
    public $berkasId = null;
    public $confirmingDelete = null;
    public $confirmingDeleteText;

    public function render()
    {
        return view('livewire.akreditasi.berkas');
    }
    
    public function toggleFormBerkas()
    {
        if ($this->showFormBerkas) {
            $this->resetForm();
            $this->reset(['name', 'berkasId']);
            $this->resetErrorBag();
        } else {
            $this->showFormBerkas = true;
            $this->name = '';
        }
    }

    private function resetForm()
    {
        $this->berkasId = null;
        $this->name = '';
        $this->showFormBerkas = false;
    }

}
