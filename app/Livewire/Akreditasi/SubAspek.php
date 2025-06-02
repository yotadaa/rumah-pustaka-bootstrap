<?php

namespace App\Livewire\Akreditasi;

use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Aspek as AspekModel;
use App\Models\SubAspek as SubAspekModel;
use App\Models\Indikator;
use App\Models\OpsiIndikator;

class SubAspek extends Component
{

    public $indikator_id, $aspek_id, $komponen_id, $berkas_id, $aspek;
    public $showForm = false;
    public $formName;
    public $modal;

    ## sub aspeks
    public $sub_aspeks, $sub_aspek_id, $sub_aspek_name, $delete_sub, $confirm_delete_sub;
    public $sub_edit, $sub_edit_name;


    ### indikator
    public $indikator_konten, $indikator_a, $indikator_b, $indikator_c, $indikator_d, $indikator_e, $indikator_multi = false, $indikator_sub;

    public function mount($aspek_id, $komponen_id, $berkas_id)
    {
        $this->aspek_id = $aspek_id;
        $this->komponen_id = $komponen_id;
        $this->berkas_id = $berkas_id;
    }

    public function toggleModal($modal_key, $close = false, $condition = "normal", $id = null)
    {
        $this->modal = $modal_key;
        $this->dispatch('showModal');
        if ($close) {
            $this->modal = null;
        }
        logger("codition: " . $condition);
        logger("key: " . $modal_key);
        if ($condition == "del") {
            if ($this->delete_sub != null) {
                $this->delete_sub = null;
            }

            $this->delete_sub = SubAspekModel::findOrFail($id);
            logger($this->delete_sub);
        } else if ($condition == "edit") {
            $this->sub_edit = SubAspekModel::findOrFail($id);
            $this->sub_aspek_name = $this->sub_edit->name;
        } else if ($condition == "tambah-indikator") {
            $this->indikator_sub = $id;
        }
    }
    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->aspekId = null;
    }

    public function toggleMultiSoal()
    {
        $this->indikator_multi = !$this->indikator_multi;
    }

    public function render()
    {

        $this->aspek = AspekModel::findOrFail($this->aspek_id);
        $this->sub_aspeks = SubAspekModel::where('aspek_id', $this->aspek_id)->orderBy('no')->get();
        return view('livewire.akreditasi.sub-aspek');
    }

    public function delete_sub_aspek()
    {
        if ($this->confirm_delete_sub == $this->delete_sub->name) {
            $this->delete_sub->delete();

            $this->modal = null;
            $this->delete_sub = null;
        }

    }

    public function subAspekForm()
    {
        $this->validate([
            'sub_aspek_name' => 'required|string|max:255',
        ]);

        $existingNumbers = SubAspekModel::where(["aspek_id" => $this->aspek_id])->orderBy('no')->pluck('no')->toArray();

        // Cari nomor terbesar tanpa terputus
        $maxContinuous = 0;
        foreach ($existingNumbers as $index => $number) {
            if ($number == $index + 1) {
                $maxContinuous = $number;
            } else {
                // Putus, berhenti
                break;
            }
        }
        if ($this->sub_edit != null) {
            $curr_asp = SubAspekModel::findOrFail($this->sub_edit->id);
            logger($curr_asp);
            $curr_asp->name = $this->sub_aspek_name;
            $curr_asp->save();
        } else {
            SubAspekModel::create([
                "name" => $this->sub_aspek_name,
                "aspek_id" => $this->aspek_id,
                "no" => $maxContinuous + 1,
                "id" => Str::uuid()
            ]);
        }

        $this->sub_aspek_name = "";
        $this->sub_aspek_id = null;
        $this->modal = false;
    }

    public function changeDirection($sa_id, $var)
    {
        $aspek = SubAspekModel::findOrFail($sa_id);
        $aspekOther = SubAspekModel::where([
            'no' => $aspek->no - $var,
            'aspek_id' => $this->aspek_id,
        ])->first();

        // Simpan dulu nomor aspek awal
        $originalNo = $aspek->no;

        // Tukar nomor
        $aspek->no = $aspekOther->no;
        $aspekOther->no = $originalNo;

        // Simpan perubahan
        $aspek->save();
        $aspekOther->save();
    }

    public function submit_indikator()
    {


        $this->validate([
            'indikator_konten' => 'required|string|max:255',
            'indikator_a' => 'required|string|max:255',
            'indikator_b' => 'required|string|max:255',
            'indikator_c' => 'required|string|max:255',
            'indikator_d' => 'required|string|max:255',
            'indikator_e' => 'required|string|max:255',
        ]);

        $ind_id = Str::uuid();
        Indikator::create([
            "id" => $ind_id,
            "content" => $this->indikator_konten,
            "aspek_id" => $this->aspek_id,
            "sub_aspek_id" => $this->indikator_sub,
            "multiple" => false,

        ]);

        dd([
            "id" => Str::uuid(),
            "indikator_id" => $ind_id,
            "konten" => $this->indikator_a,
            "option" => "a"
        ]);
        OpsiIndikator::create([
            "id" => Str::uuid(),
            "indikator_id" => $ind_id,
            "konten" => $this->indikator_a,
            "option" => "a"
        ]);
        OpsiIndikator::create([
            "id" => Str::uuid(),
            "indikator_id" => $ind_id,
            "konten" => $this->indikator_b,
            "option" => "b"
        ]);
        OpsiIndikator::create([
            "id" => Str::uuid(),
            "indikator_id" => $ind_id,
            "konten" => $this->indikator_c,
            "option" => "c"
        ]);
        OpsiIndikator::create([
            "id" => Str::uuid(),
            "indikator_id" => $ind_id,
            "konten" => $this->indikator_d,
            "option" => "d"
        ]);
        OpsiIndikator::create([
            "id" => Str::uuid(),
            "indikator_id" => $ind_id,
            "konten" => $this->indikator_e,
            "option" => "e"
        ]);

    }

}
