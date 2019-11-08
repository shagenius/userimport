<?php

namespace App\Http\Controllers;

use App\UploadUserCSV;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class UploadUserCSVController extends Controller
{
    protected $required_headers = ['First Name', 'Last Name', 'Email', 'Password', 'Platforms'];
    
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
       
//        $validator->after(function($validator) use ($userCsv) {
//           if ($userCsv->guessClientExtension()!=='csv') {
//               echo $userCsv->guessClientExtension();
//               $validator->errors()->add('field', 'File should be in csv format');
//           }
//       });
       
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
       
                    }
                    $raw_header = collect($data);
                    $required_header = collect($this->required_headers);
                        if(!$raw_header->intersect($required_header)==$required_header){
                            return response()->json([
                                'data' => array(
                                    'message' => 'Uploaded file is not valid, missing required columns.'                            
                                )
                            ], 400);
                        }
                   
                        $header = collect($data)->map(function ($item, $key) {
                            return Str::snake($item);
                        })->flip();
                } else {
                        $successUserData = Storage::disk('local')->exists('success.json')  ? json_decode(Storage::disk('local')->get('success.json')) : array();
                        $errorUserData = Storage::disk('local')->exists('error.json')  ? json_decode(Storage::disk('local')->get('error.json')) : array();
                        
                        print_r($data);exit;
                                
                        $request = new Request($row);
                         echo 'here';exit;
                        $data = $request->all();
                        
                        $user = new User($data);
                        
                        $validator = Validator::make($data, User::rules());
                        
                        if($validator->fails()){
                            $user->setAppends(['errors','extra_fields'])->toArray();
                            $user->errors = $validator->errors()->toArray();
                            $user->extra_fields = $num;
                            $invalid_user = $user->toArray();
                            $errorUserData[] =  $invalid_user;
                            Storage::disk('local')->put('error.json', json_encode($errorUserData));
                        } else {
                            $valid_user = $user->toArray();
                            $successUserData[] =  $valid_user;
                            Storage::disk('local')->put('success.json', json_encode($successUserData));
                        }
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
