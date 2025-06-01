<?php

namespace App\Livewire\Akreditasi;

use Livewire\Component;
use App\Models\Aspek as AspekModel;
use App\Models\SubAspek as SubAspekModel;

class SubAspek extends Component
{

    public $indikator_id, $aspek_id, $komponen_id, $berkas_id, $aspek, $sub_aspeks;
    public $showForm = false;
    public $formName;
    public $modal = "initial";

    ## sub aspeks
    public $delete_sub;
    public $confirm_delete_sub;

    ### indikator

    public function mount($aspek_id, $komponen_id, $berkas_id)
    {
        $this->aspek_id = $aspek_id;
        $this->komponen_id = $komponen_id;
        $this->berkas_id = $berkas_id;
    }

    public function toggleModal($modal_key)
    {
        $this->modal = $modal_key . "123";
        $this->dispatch('showModal');
    }



    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->aspekId = null;
    }

    public function render()
    {

        $this->aspek = AspekModel::findOrFail($this->aspek_id);
        $this->sub_aspeks = SubAspekModel::where('aspek_id', $this->aspek_id)->orderBy('no')->get();
        return view('livewire.akreditasi.sub-aspek');
    }

    public function delete_sub_aspek()
    {

    }


}
