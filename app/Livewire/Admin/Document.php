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

    public $file = null;
    public $all_document;
    public function mount($document_id)
    {
        $this->document = [
            ...$this->document,
            'id' => $document_id
        ];

        $this->all_document = File::where('indikator_id', $document_id)->get();
        // dd($document_id);

    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        $helper = new uploadFileController();
        $path = $helper->create("dokumen", $this->file);

        // dd($path);
        File::create([
            'path' => $path,
            'folder' => "-",
            'filename' => $this->file->getClientOriginalName()
            ,
            'komponen_id' => "-",
            'berkas_id' => "-",
            'role_id' => -1,
            'indikator_id' => $this->document['id'],
            'score' => 1,
        ]);

        $this->dispatch('show-toast', message: ['mode' => 'info', 'message' => "File berhasil diupload"]);
    }


    public function render()
    {
        $this->all_document = File::where('indikator_id', $this->document['id'])->get();
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
