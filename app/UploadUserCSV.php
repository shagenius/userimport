<?php

Namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCSV extends Model
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
}

