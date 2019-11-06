<?php

namespace App;

use SplFileObject;
use NoRewindIterator;
use Illuminate\Support\Facades\Storage;

class ImportCSV
{
    protected $file;
 
    public function __construct($fileObj, $mode = "r")
    {
        $filename = $fileObj->getClientOriginalName();
        
        if (!file_exists($fileObj->getRealPath())) {
 
            throw new Exception("File not found");
 
        }
        
        $path =Storage::putFileAs(
            'userupload',
            $fileObj,
            $filename
        );
 
        $this->file = new SplFileObject(storage_path('/app/'.$path), $mode);
    }
 
    protected function iterateTextRows()
    {
        $count = 0;
 
        while (!$this->file->eof()) {
 
            yield $this->file->fgets();
 
            $count++;
        }
        
        return $count;
    }
 
    protected function iterateBinaryRows($bytes)
    {
        $count = 0;
 
        while (!$this->file->eof()) {
 
            yield $this->file->fread($bytes);
 
            $count++;
        }
    }
 
    public function getRows($type = "text", $bytes = NULL)
    {
        if ($type == "text") {
 
            return new NoRewindIterator($this->iterateTextRows());
 
        } else {
 
            return new NoRewindIterator($this->iterateBinaryRows($bytes));
        }
 
    }
}