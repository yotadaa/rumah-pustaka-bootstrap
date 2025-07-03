<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Livewire\Attributes\On; // <-- Import the On attribute

class Notification extends Component
{
    public $message = null;
    public $loading = false;

    public function mount()
    {
        $this->message = session('message');
    }
    #[On('show-toast')]
    public function showToast($message)
    {
        $this->message = $message;
    }

    #[On('show-loading')]
    public function showLoading($loading)
    {
        $this->loading = $loading;
    }
    public function render()
    {
        // $this->message = session('message');
        return view('livewire.component.notification');
    }

    // tambahkan atribut dan method yang sesuai
}
