<?php

namespace App\Http\Controllers;

use App\UploadUserCSV;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use Symfony\Component\Process\Process;

class UploadUserCSVController extends Controller
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

    
    public function store(Request $request)
    {
        $userCsv = $request->file('user_file');
        
        $validator = Validator::make($request->all(), UploadUserCSV::rules());
       
        $validator->after(function($validator) use ($userCsv) {
           if ($userCsv->guessClientExtension()!=='csv') {
               $validator->errors()->add('field', 'File should be in csv format');
           }
       });
       
        if($validator->fails()){
            return response()->json([
                'data' => array(
                        'message' => $validator->errors()->toArray()
                )
            ], 400);
        }
              
        $userFile =  UploadUserCSV::uploadFile($userCsv);
        $row = 1;
        $header = [];
        if (($handle = fopen($userFile, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                if($row==1) {
                    for ($c=0; $c < $num; $c++) {
                        $header[$data[$c]] = trim($c);
                    }
                } else {
                        $user = new User();
                        $user->first_name = trim($data[$header['first_name']]);
                        $user->last_name = trim($data[$header['last_name']]);
                        $user->email = trim($data[$header['email']]);
                        $user->password = bcrypt(trim($data[$header['password']]));
                        $user->platforms = trim($data[$header['platforms']]);
                        $user->save();
                }
                $row++;
            }
            fclose($handle);
        }
//       $process = new Process('php ../artisan import:csv');
//       $process->start();
        return response()->json([
                'data' => array(
                        'status' => 'converting'
                )
            ], 200);

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
