<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserExtraField extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name', 'value'
    ];
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
     {
         return [
             'name' => 'required',
             'value' => 'required',
         ];
     }
}
