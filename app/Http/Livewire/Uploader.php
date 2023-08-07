<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;

class Uploader extends Component
{
    use WithFileUploads;
 
    public $pdfs = [];
    public $year;

    public function save()
    {
        $this->validate([
            'pdfs.*' => 'file|mimetypes:application/pdf|max:100240', // 100MB Max
        ]);
 
        foreach ($this->pdfs as $photo) {
            $filename = $photo->getClientOriginalName();
            $photo->storeAs($this->year, $filename, 'public');
        }

        // return redirect('dashboard');
       
    }

    public function render()
    {
        $directory = "public/photos";
        $files = Storage::files($directory);
        $fileNames = array_map('basename', $files);
        // dump($fileNames);
        return view('livewire.uploader',
        ['fileNames'=>$fileNames]
        );
    }
}
