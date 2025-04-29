<?php

namespace App\Livewire\Akreditasi;

use Livewire\Component;
use App\Models\Aspek as AspekModel;

class Indikator extends Component
{

    public $indikator_id, $aspek_id, $komponen_id, $berkas_id, $aspek;

    public function mount($aspek_id, $komponen_id, $berkas_id) {
        $this->aspek_id = $aspek_id;
        $this->komponen_id = $komponen_id;
        $this->berkas_id = $berkas_id;
    }
    public function render()
    {

        $this->aspek = AspekModel::where(
            [
                'komponen_id' => $this->komponen_id,
                'berkas_id' => $this->berkas_id
            ]
        )->get()->sortBy('no');
        return view('livewire.akreditasi.indikator');
    }
}
