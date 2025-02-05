<?php

namespace App\Livewire\Iso;

use Livewire\Component;
use App\Models\Berkas;
use App\Models\KomponenIso;
use App\Models\Komponen as Matriks;
use App\Models\Role;
use App\Models\Access;
use App\Models\UserAccess;
use App\Models\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as FileController;
use ZipArchive;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Helper\uploadFileController;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads; // Add this line

class Komponen extends Component
{
    use WithFileUploads;

    //user
    public $userAccess;
    //form
    public $komponenId;

    // parameters
    public $id;
    public $role_id;

    //form
    public $showForm = false;
    public $selectedRoles = [];
    public $formName;
    public $formRole;

    //file
    public $selectedFile = null;
    public $file;

    public $komponen = null;
    public $berkas;
    public $roles;
    public $detail;

    //delete
    public $confirmingDelete;
    public $confirmingDeleteText;

    // view
    public $display = 1;

    public function mount($id, $role_id)
    {
        $this->id = $id;
        $this->role_id = $role_id;
    }

    public function changeDisplay()
    {
        if ($this->display == 1) {
            $this->display = 2;
        } elseif ($this->display == 2) {
            $this->display = 1;
        }
    }

    public function confirmDelete(string $id)
    {
        $this->confirmingDelete = Matriks::find($id);
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
        session()->flash('message', 'Komponen berhasil dihapus.');
        $this->confirmingDelete = null;
    }

    public function downloadZip($komponenId = null, $berkasId = null)
    {
        // Fetch files based on conditions
        $files = File::where('berkas_id', $berkasId);

        if ($komponenId != null) {
            $files = $files->where('komponen_id', $komponenId);
        }

        $files = $files->get();

        if ($files->isEmpty()) {
            session()->flash('error', 'No files found for download.');
            return redirect()->back();
        }

        // Create a new ZipArchive instance

        $filename = $this->berkas->name;
        $zip = new ZipArchive();
        $zipFileName = $filename . ' - ' . Matriks::findOrFail($komponenId)->name . '.zip';
        $zipFilePath = public_path($zipFileName); // Save the zip file in the public directory

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            foreach ($files as $file) {
                // Assuming the file path is stored in the 'path' attribute of the File model
                // and the path is relative to the public directory
                $filePath = public_path($file->path);

                // Check if the file exists before adding it to the zip
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                } else {
                    // Log or handle missing files
                    session()->flash('warning', 'Some files were not found and were skipped.');
                }
            }

            $zip->close();

            // Download the zip file
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            session()->flash('error', 'Failed to create zip file.');
            return redirect()->back();
        }
    }

    public function onChange()
    {
        // Log::info("Name updated to: {$this->name}");
    }

    public function selectForUpload($id)
    {
        $this->selectedFile = $id;
    }

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:10240', // Max 10MB
            'selectedFile' => 'required|string',
        ]);

        $helper = new uploadFileController();
        $path = $helper->create('berkas/' . $this->berkas->id . '/' . $this->selectedFile, $this->file);

        $data = [
            'path' => $path,
            'folder' => 'docs',
            'filename' => basename($path),
            'komponen_id' => $this->selectedFile,
            'berkas_id' => $this->berkas->id,
            'role_id' => $this->role_id,
        ];
        // dd($data, $this->selectedFile);
        File::create($data);

        $this->dispatch('file-uploaded');

        // Reset file input
        $this->reset('file');

        session()->flash('message', 'File uploaded successfully.');
    }

    public function submit()
    {
        $this->validate([
            'formName' => 'required|string|max:255',
            // 'formRole' => 'required|integer',
            'selectedRoles' => 'required|array',
            'selectedRoles.*' => 'required|integer',
        ]);

        if ($this->komponenId != null) {
            // dd($this->selectedRoles);
            $komponen = Matriks::findOrFail($this->komponenId);
            $komponen->update(['name' => $this->formName]);
            // Access::where('komponen_id', $this->komponenId)->delete();

            // foreach ($this->selectedRoles as $role) {
            //     Access::create([
            //         'komponen_id' => $this->komponenId,
            //         'role_id' => $role,
            //     ]);
            // }
            // Step 1: Fetch existing roles from the Access table for the given komponen_id
            $existingRoles = Access::where('komponen_id', $this->komponenId)->pluck('role_id')->toArray();

            // Step 2: Determine roles to add (roles in selectedRoles but not in existingRoles)
            $rolesToAdd = array_diff($this->selectedRoles, $existingRoles);

            // Step 3: Determine roles to remove (roles in existingRoles but not in selectedRoles)
            $rolesToRemove = array_diff($existingRoles, $this->selectedRoles);

            // dd($this->komponenId, $existingRoles, $rolesToAdd, $rolesToRemove);

            // Step 4: Add new roles to the Access table
            foreach ($rolesToAdd as $role) {
                Access::create([
                    'komponen_id' => $this->komponenId,
                    'role_id' => $role,
                ]);
            }

            // Step 5: Remove roles that are no longer in selectedRoles
            if (!empty($rolesToRemove)) {
                Access::where('komponen_id', $this->komponenId)->whereIn('role_id', $rolesToRemove)->delete();
            }
        } else {
            $data = [
                'id' => Str::uuid(),
                'name' => $this->formName,
                'model' => 'iso',
            ];
            Matriks::create($data);
            foreach ($this->selectedRoles as $role) {
                Access::create([
                    'komponen_id' => $data['id'],
                    'role_id' => $role,
                ]);
            }
        }

        // dd($this->selectedRoles);
        $this->resetForm();
        $this->toggleForm();
    }

    public function render()
    {
        $this->userAccess = UserAccess::where('user_id', Auth::user()->id)->get();
        $this->berkas = Berkas::findOrFail($this->id);
        $this->komponen = Matriks::with(['access'])
            ->get()
            ->sortBy(function ($item) {
                // Extract the main section number and sub-section numbers
                preg_match('/^(\d+)(?:\.(\d+(?:\.\d+)*))?/', $item->name, $matches);

                $mainSection = (int) ($matches[1] ?? 0); // Main section number (e.g., 4, 5, 6)
                $subSection = $matches[2] ?? '0'; // Sub-section number (e.g., 1, 2, 1.1, 1.2)

                // Convert the sub-section into a sortable format (e.g., "1.2" => "0001.0002")
                $subSectionParts = explode('.', $subSection);
                $subSectionFormatted = implode(
                    '.',
                    array_map(function ($part) {
                        return str_pad($part, 4, '0', STR_PAD_LEFT); // Pad each part with leading zeros
                    }, $subSectionParts),
                );

                // Combine main section and sub-section for sorting
                return sprintf('%04d.%s', $mainSection, $subSectionFormatted);
            });
        $this->roles = Role::where('id', $this->role_id)->get();
        return view('livewire.iso.komponen');
    }

    public function edit($id)
    {
        $this->resetForm();

        $this->selectedRoles = [];
        $this->showForm = true;
        $this->komponenId = $id;
        // dd($id);
        $komponen = Matriks::findOrFail($id);
        foreach ($komponen->access as $role) {
            $this->toggleRole($role->role_id);
        }
        $this->formName = $komponen->name;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->komponenId = null;
    }

    public function changeRole($role)
    {
        $this->formRole = $role;
    }

    private function resetForm()
    {
        $this->formName = '';
        $this->formRole = null;
        // $this->selectedRoles = [];
    }

    public function select($id)
    {
        $this->detail = $id;
    }

    public function toggleRole($id)
    {
        if (in_array($id, $this->selectedRoles)) {
            $this->selectedRoles = array_diff($this->selectedRoles, [$id]);
        } else {
            $this->selectedRoles[] = $id;
        }
    }
}
