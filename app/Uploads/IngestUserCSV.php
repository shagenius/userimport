<?php
namespace App\Uploads;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

Class IngestUserCSV {
    
    public $filename;
    public $filelocation;
    public $file;



    /**
     * IngestUserCSV constructor
     */
    public function __construct($file) 
    {
        $this->file = $file;
    }
    
    public function uploadCSV(){
        return $this->upload($this->file);
    }
    
    private function upload($file, $extension){
//        $path = Storage::putFileAs("userCSV", $file, uniqid().".".$extension);
//        $uploadedFile = Invoice::create([
//            'path' => $path,
//            'processed' => false,
//        ]);
//
//        return $uploadedFile;
        
            return 'Uploaded';
    }
}

