<?php

Namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UploadUserCSV extends Model
{
    protected $fillable = ['user_file'];
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
     {
         return [
             'user_file' => 'required|file'
         ];
     }
     
    public static function uploadFile($file)
    {
        $filename = $file->getClientOriginalName();
        
        try { 
            $path = Storage::putFileAs('uploads',$file ,$filename);
            $uploadedFile = storage_path('/app/'.$path);
            return $uploadedFile;
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }

        return;
                
    }
}

