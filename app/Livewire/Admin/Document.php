<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\Helper\uploadFileController;
use Livewire\Component;
use Livewire\WithFileUploads;
use \App\Models\File;

class Document extends Component
{
    use WithFileUploads;

    public $document = [
        "id" => null,
    ];

    public $is_processing = false;
    public $file = null;
    public $all_document;
    public $berkas_id;
    public function mount($document_id, $berkas_id)
    {
        $this->berkas_id = $berkas_id;
        $this->document = [
            ...$this->document,
            'id' => $document_id
        ];

        // dd($berkas_id);
        $this->all_document = File::where('indikator_id', $document_id)->where('berkas_id', $berkas_id)->get();
        // dd($document_id);
    }

    public function delete_file($id)
    {
        try {
            $file = File::findOrFail($id);
            $helper = new uploadFileController();
            $helper->delete($file->path);
            $file->delete();
        } catch (\Exception $e) {
            $this->dispatch('show-toast', message: ['mode' => 'danger', 'message' => "File tidak ditemukan"]);

        }
    }

    public function updatedFile()
    {
        $this->is_processing = true;
        $this->validate([
            'file' => 'required|file|max:10240', // Max 10MB
        ]);
        try {
            $helper = new uploadFileController();
            $path = $helper->create("dokumen", $this->file);

            // dd($path);
            File::create([
                'path' => $path,
                'folder' => "-",
                'filename' => $this->file->getClientOriginalName()
                ,
                'komponen_id' => "-",
                'berkas_id' => $this->berkas_id,
                'role_id' => -1,
                'indikator_id' => $this->document['id'],
                'score' => 1,
            ]);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', message: ['mode' => 'danger', 'message' => "Terjadi error: " . $e->getMessage()]);
        } finally {
            $this->dispatch('show-toast', message: ['mode' => 'info', 'message' => "File berhasil diupload"]);
            $this->file = null;
            $this->is_processing = false;
        }

    }


    public function render()
    {
        $this->all_document = File::where('indikator_id', $this->document['id'])->get();
        $this->all_document = File::where('indikator_id', $this->document['id'])->where('berkas_id', $this->berkas_id)->get();

        return view('livewire.admin.document');
    }

    public function closePage()
    {
        $this->document = [
            ...$this->document,
            'id' => null
        ];

    }
}
