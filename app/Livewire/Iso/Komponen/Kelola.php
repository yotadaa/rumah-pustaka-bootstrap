<?php

namespace App\Livewire\Iso\Komponen;

use App\Http\Controllers\Helper\uploadFileController;
use App\Models\Berkas;
use App\Models\File;
use App\Models\Komponen;
use Livewire\Component;
use Livewire\WithFileUploads; // Add this line

use Spatie\PdfToImage\Pdf;
class Kelola extends Component
{
    use WithFileUploads;

    public $berkasId, $komponenId, $role_id;

    public $file;

    public $berkas, $komponen;

    public function mount($berkasId, $komponenId, $role_id)
    {
        $this->berkasId = $berkasId;
        $this->komponenId = $komponenId;
        $this->role_id = $role_id;
    }

    public function generatePdfThumbnail($pdfPath)
    {
        $pdf = new Pdf(public_path($pdfPath));
        $thumbnailPath = 'thumbnails/' . basename($pdfPath, '.pdf') . '.jpg';

        $pdf->setPage(1) // First page as thumbnail
            ->saveImage(public_path($thumbnailPath));

        return asset($thumbnailPath);
    }

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:10240',
        ]);

        $helper = new uploadFileController();
        $path = $helper->create('berkas/' . $this->berkas->id . '/' . $this->komponen->id, $this->file);

        $data = [
            'path' => $path,
            'folder' => 'docs',
            'filename' => basename($path),
            'komponen_id' => $this->komponen->id,
            'berkas_id' => $this->berkas->id,
            'role_id' => $this->role->id,
        ];
        // dd($data, $this->selectedFile);
        File::create($data);

        $this->dispatch('file-uploaded');

        // Reset file input
        $this->reset('file');

        session()->flash('message', 'File uploaded successfully.');
    }


    public function render()
    {
        $this->berkas = Berkas::find($this->berkasId);
        $this->komponen = Komponen::find($this->komponenId);
        return view('livewire.iso.komponen.kelola');
    }
}
