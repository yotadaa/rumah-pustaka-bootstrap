<?php

namespace App\Livewire\Iso;

use Livewire\Component;
use App\Models\Berkas as BerkasModel;
use App\Models\Komponen;
use App\Models\File;
use App\Models\Role;

// Modul
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use ZipArchive;

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
        $this->berkas = BerkasModel::all();
        return view('livewire.iso.berkas');
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

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($this->berkasId) {
            $berkas = BerkasModel::find($this->berkasId);
            $berkas->update(['name' => $this->name]);
            session()->flash('message', 'Berkas berhasil diperbarui.');
        } else {
            BerkasModel::create(['id' => Str::uuid(), 'name' => $this->name, 'model' => 'iso']);
            session()->flash('message', 'Berkas berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function editnama($id)
    {
        $berkas = BerkasModel::findOrFail($id);
        $this->berkasId = $berkas->id;
        $this->name = $berkas->name;
        $this->showFormBerkas = true;
    }

    public function confirmDelete(string $id)
    {
        $this->confirmingDelete = BerkasModel::find($id);
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function delete()
    {
        if ($this->confirmingDelete->name != $this->confirmingDeleteText) {
            return;
        }

        $this->confirmingDelete->delete();
        session()->flash('message', 'Berkas berhasil dihapus.');
        $this->confirmingDelete = null;
    }

    private function resetForm()
    {
        $this->berkasId = null;
        $this->name = '';
        $this->showFormBerkas = false;
    }

    public function downloadZip($komponenId = null, $berkasId = null)
    {
        // Fetch files based on conditions
        $files = File::where('berkas_id', $berkasId);
        $roles = Role::all();

        if ($komponenId != null) {
            $files = $files->where('komponen_id', $komponenId);
        }

        $files = $files->get();

        if ($files->isEmpty()) {
            session()->flash('error', 'No files found for download.');
            return redirect()->back();
        }

        // Get the berkas name
        $berkas = BerkasModel::findOrFail($berkasId);
        $filename = $berkas->name;

        // Get the komponen name if komponenId is provided
        $komponenName = null;
        if ($komponenId) {
            $komponen = Komponen::find($komponenId);
            $komponenName = $komponen ? $komponen->name : 'UnknownKomponen';
        }

        $zip = new ZipArchive();
        $zipFileName = $filename . '.zip';
        $zipFilePath = public_path($zipFileName); // Save the zip file in the public directory

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {

            foreach ($roles as $role) {
                foreach ($files as $file) {
                    $komponen = Komponen::find($file->komponen_id);
//&& in_array($role->id, auth()->user()->access->pluck('role_id')->toArray())        
                    if ($komponen && in_array($role->id, $komponen->access->pluck('role_id')->toArray()) ) {
                        $filePath = public_path($file->path);
        
                        if (file_exists($filePath)) {
                            $relativePath = $role->name . '/' . $komponen->name . '/' . basename($filePath);
                            $zip->addFile($filePath, $relativePath);
                        } else {
                            session()->flash('warning', "File {$file->path} was not found and skipped.");
                        }
                    }
                }
            }

            $zip->close();

            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            session()->flash('error', 'Failed to create zip file.');
            return redirect()->back();
        }
    }
}
