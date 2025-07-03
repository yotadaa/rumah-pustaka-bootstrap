<?php

namespace App\Livewire\Akreditasi;

use App\Models\Berkas;
use App\Models\Indikator;
use App\Models\OpsiIndikator;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Aspek as AspekModel;
use App\Models\Komponen;
use App\Models\SubAspek;

class Aspek extends Component
{

    public $berkas_id, $komponen_id, $aspek, $formName, $aspekId, $subAspekName, $clickedAspek, $showingAspek, $subaspek_id, $sub_del;
    public $showForm = false;
    public $indikator, $filled_indikator;
    public $confirmingDelete = null;
    public $confirmingDeleteText;
    public $total_score;


    public function mount($berkas_id, $komponen_id)
    {
        $all_aspek = AspekModel::where('komponen_id', $this->komponen_id)->pluck('id');
        $this->indikator = Indikator::where('multiple', 0)->whereIn('aspek_id', $all_aspek)->get();
        $this->indikator_ids = $this->indikator->pluck('id');
        $this->filled_indikator = OpsiIndikator::whereIn('indikator_id', $this->indikator_ids)->where('choosen', true)->get();
        $this->berkas_id = $berkas_id;
        $this->komponen_id = $komponen_id;

        if (!Berkas::find($this->berkas_id) || !Komponen::find($this->komponen_id)) {
            return redirect()->route('admin.akreditasi.daftar');
        }
    }

    public function confirmDelete(string $id)
    {
        $this->confirmingDelete = AspekModel::find($id);
    }
    public function sub_delete(string $id)
    {
        $this->sub_del = SubAspek::find($id);
    }
    public function cancelDelete()
    {
        $this->confirmingDelete = null;
        $this->sub_del = null;
    }

    public function delete_subaspek()
    {
        if ($this->sub_del->name != $this->confirmingDeleteText) {
            return;
        }

        $this->sub_del->delete();
        $this->dispatch('show-toast', message: ['mode' => 'danger', 'message' => "Komponen berhasil dihapus."]);
        session()->flash('message', 'Komponen berhasil dihapus.');
        $this->sub_del = null;
    }

    public function delete()
    {
        if ($this->confirmingDelete->name != $this->confirmingDeleteText) {
            return;
        }

        $all_aspek = AspekModel::where([
            'komponen_id' => $this->komponen_id,
            'berkas_id' => $this->berkas_id
        ])->where('no', '>', $this->confirmingDelete->no)->get()->each(function ($aspek) {
            $aspek->no = $aspek->no - 1;
            $aspek->save();
        });
        $this->confirmingDelete->delete();
        $this->dispatch('show-toast', message: ['mode' => 'danger', 'message' => "Komponen berhasil dihapus."]);
        session()->flash('message', 'Komponen berhasil dihapus.');
        $this->confirmingDelete = null;
    }

    public function chooseAspek($_id)
    {
        $this->clickedAspek = $_id;
        $this->subAspekName = "";
        $this->subaspek_id = null;
    }
    public function showAspek($_id)
    {
        if ($this->showingAspek == $_id) {
            $this->showingAspek = null;
        } else {
            $this->showingAspek = $_id;
        }
    }


    public function subAspekForm()
    {
        $this->validate([
            'subAspekName' => 'required|string|max:255',
        ]);

        $existingNumbers = SubAspek::where(["aspek_id" => $this->clickedAspek])->orderBy('no')->pluck('no')->toArray();

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
        if ($this->subaspek_id != null) {
            $curr_asp = SubAspek::findOrFail($this->subaspek_id);
            $curr_asp->name = $this->subAspekName;
            $curr_asp->save();
            $this->dispatch('show-toast', message: ['mode' => 'primary', 'message' => "Sub Aspek berhasil diperbarui."]);
        } else {
            SubAspek::create([
                "name" => $this->subAspekName,
                "aspek_id" => $this->clickedAspek,
                "no" => $maxContinuous + 1,
                "id" => Str::uuid()
            ]);
            $this->dispatch('show-toast', message: ['mode' => 'primary', 'message' => "Sub Aspek berhasil ditambahkan."]);
        }

        $this->subAspekName = "";
        $this->subaspek_id = null;
        $this->dispatch('close-modal');
    }

    public function submit()
    {
        $this->validate([
            'formName' => 'required|string|max:255',
        ]);
        if ($this->aspekId != null) {
            // dd($this->selectedRoles);
            $komponen = AspekModel::findOrFail($this->aspekId);
            $komponen->update(['name' => $this->formName]);
            $this->dispatch('show-toast', message: ['mode' => 'primary', 'message' => "Aspek berhasil diperbarui."]);
        } else {
            $existingNumbers = AspekModel::where('komponen_id', $this->komponen_id)->orderBy('no')->pluck('no')->toArray();

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

            // Siapkan data baru
            $data = [
                'no' => $maxContinuous + 1, // Tambahkan 1 setelah nomor terakhir berurutan
                'id' => Str::uuid(),
                'name' => $this->formName,
                'berkas_id' => $this->berkas_id,
                'komponen_id' => $this->komponen_id
            ];

            // Insert ke database
            AspekModel::create($data);
            $this->dispatch('show-toast', message: ['mode' => 'primary', 'message' => "Aspek berhasil ditambahkan."]);
        }

        // dd($this->selectedRoles);
        $this->resetForm();
        $this->toggleForm();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->resetForm();

        $this->showForm = true;
        $this->aspekId = $id;
        // dd($id);
        $aspek = AspekModel::findOrFail($id);
        $this->formName = $aspek->name;
    }

    public function editSubAspek($id)
    {
        $this->subAspekName = "";
        $aspek = SubAspek::findOrFail($id);
        $this->subaspek_id = $id;
        $this->subAspekName = $aspek->name;
    }

    private function resetForm()
    {
        $this->formName = '';
        // $this->selectedRoles = [];
    }

    public function changeDirection($aspek_id, $var)
    {
        $aspek = AspekModel::findOrFail($aspek_id);
        $aspekOther = AspekModel::where([
            'no' => $aspek->no - $var,
            'komponen_id' => $this->komponen_id,
            'berkas_id' => $this->berkas_id
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


    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->aspekId = null;
    }
    public function render()
    {
        $all_aspek = AspekModel::where('komponen_id', $this->komponen_id)->pluck('id');
        $all_indikator = Indikator::whereIn('aspek_id', $all_aspek)->pluck('id');
        $opsi_indikator = OpsiIndikator::whereIn('indikator_id', $all_indikator)->where('choosen', true)->get();
        $this->indikator = Indikator::where('multiple', 0)->whereIn('aspek_id', $all_aspek)->get();
        $num_indicator = Indikator::where('multiple', 0)->whereIn('aspek_id', $all_aspek)->count();
        $this->total_score = $num_indicator == 0 ? 0 : $opsi_indikator->sum('score') / $num_indicator;

        // check first if App/Models/Berkas with berkas_id and App/Models/Komponen with komponen_id is exists, if not go to route('admin.akreditasi')
        $this->aspek = AspekModel::where(
            [
                'komponen_id' => $this->komponen_id,
                // 'berkas_id' => $this->berkas_id
            ]
        )->get()->sortBy('no');
        return view('livewire.akreditasi.aspek');
    }
}
