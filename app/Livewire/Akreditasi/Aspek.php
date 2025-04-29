<?php

namespace App\Livewire\Akreditasi;

use App\Models\Berkas;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Aspek as AspekModel;
use App\Models\Komponen;

class Aspek extends Component
{

    public $berkas_id, $komponen_id, $aspek, $formName, $aspekId;
    public $showForm = false;
    public $confirmingDelete = null;
    public $confirmingDeleteText;


    public function mount($berkas_id, $komponen_id)
    {
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

    public function delete()
    {
        if ($this->confirmingDelete->name != $this->confirmingDeleteText) {
            return;
        }

        $this->confirmingDelete->delete();
        session()->flash('message', 'Komponen berhasil dihapus.');
        $this->confirmingDelete = null;
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
        } else {
            $existingNumbers = AspekModel::orderBy('no')->pluck('no')->toArray();

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
        }

        // dd($this->selectedRoles);
        $this->resetForm();
        $this->toggleForm();
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

        // check first if App/Models/Berkas with berkas_id and App/Models/Komponen with komponen_id is exists, if not go to route('admin.akreditasi')
        $this->aspek = AspekModel::where(
            [
                'komponen_id' => $this->komponen_id,
                'berkas_id' => $this->berkas_id
            ]
        )->get()->sortBy('no');
        return view('livewire.akreditasi.aspek');
    }
}
