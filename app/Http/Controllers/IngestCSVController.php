<?php

namespace App\Http\Controllers;

use App\Uploads\IngestUserCSV;
use Illuminate\Http\Request;

class IngestCSVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo 'adas';exit;
    }

    
    public function upload(Request $request)
    {
        $filepath = $request->filepath;
        $filename = $request->filename;
        
        $infoPath = pathinfo(public_path($filepath.$filename));
        
        $extension = $infoPath['extension'];
        
        if ($extension !== 'csv'){
            $errors['file'] = 'This is not a valid file, a csv file must be uploaded!';
            return response()->json([
                'data' => $errors
            ], 400);
        }
        
        return response()->json([
            'data' => $infoPath
        ], 200);
        
//        try{
//        $extension = strtolower($file->getClientOriginalExtension());
//        if ($extension !== 'csv'){
//            $errors['file'] = 'This is not a .csv file!';
//            return response()->json([
//                'data' => $errors
//            ], 400);
//        }
//        $IngestUserCSV = new IngestUserCSV($file);
//        $IngestUserCSV->uploadCSV($file); 
//        $message = array(
//            'status' => 'converting',
//        );
//        return response()->json([
//            'data' => $message
//        ], 200);
//    }catch (\Exception $exception){
//        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal Server Error');
//    }
            
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
