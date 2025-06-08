<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Notification extends Component
{
    public $message = "tes";

    public function mount()
    {
        $this->message = session('message');
    }

    public function render()
    {
        $this->message = session('message');
        return view('livewire.component.notification');
    }
}
