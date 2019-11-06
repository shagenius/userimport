<?php

namespace App\Http\Controllers;

use App\UserCSV;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Jobs\ProcessUserCSV;
use Wilgucki\Csv\Facades\Reader as CsvReader;

class UserCSVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
     
        return view('index');
    }

    
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), UserCSV::rules());
        
        if($validator->fails()){
            return response()->json([
                'data' => array(
                        'message' => $validator->errors()->toArray()
                )
            ], 400);
        }
        
        $userCsv = $request->file('user_file')->getRealPath();
        
        $reader = CsvReader::open($userCsv);
        
        while (($line = $reader->readLine()) !== false) {
            print_r($line);
        }
        
    }
    
    /**
     * Display the successful/failed resources.
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function show($status)
    {
        if($status==null){
            return response()->json([
                'data' => array(
                        'message' => 'No status provided for download'
                )
            ], 400);
        } 
        return response()->json([
                'data' => array(
                        'message' => 'Downloading...'
                )
            ], 200);
        
    }
}
