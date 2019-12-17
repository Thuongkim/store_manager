<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Categorize;
use App\Models\Sale;
use App\Models\User;
use App\Models\File;
use Auth;
use DB;
use Response;

class FileController extends Controller
{
    public function dropzone()
    {
        return view('dropzone-view');
    }
    public function dropzoneStore(Request $request)
    {
        // dd(1);
       if ($request->hasFile('file')) {
            $imageFiles = $request->file('file');
            $folderDir = '\public\images';
            $destinationPath = base_path() . $folderDir;
            $ext = $imageFiles->getClientOriginalExtension();
            $destinationFileName = "\contract_".sha1(date('YmdHis') . str_random(30)).'.'.$ext;
            $imageFiles->move($destinationPath, $destinationFileName);

            // save file in database
            $file = new File;
            $file->url = $destinationFileName;
            $file->user_id = Auth::user()->id;
            $file->fileable_type = "App\Models\Contract";
            $file->save();   
            return response()->json(['id'=>$file->id]);


        // $image = $request->file('file');
        // $imageName = $image->getClientOriginalName();
        // $image->move(public_path('images'),$imageName);
        
        // $imageUpload = new File();
        // $imageUpload->url = $imageName;
        // $imageUpload->user_id = Auth::user()->id;
        // $imageUpload->fileable_type = "App\Models\Contract";
        // $imageUpload->save();
        // return response()->json(['id'=>$imageUpload->id]);   
        }
       
    }
    public function dropzoneDelete(Request $request)
    {

        $image_id = $request->imageId;
        $uploaded_image = File::where('id', $image_id)->first();
 
        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }
 
        $file_path = public_path() .'\images'. $uploaded_image->url;
        // dd($file_path);
 
        if (file_exists($file_path)) {
            unlink($file_path);
        }
 
        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }
 
        return Response::json(['message' => 'File successfully delete'], 200);

       // $filename =  $request->filename;
       // dd($filename);
       //  File::where('url',$filename)->delete();
       //  $path=public_path().'/images/'.$filename;
       //  if (file_exists($path)) {
       //      unlink($path);
       //  }
       //  return $filename;   

    }
    public function getDropzone(Request $request)
    {
        $id = $request->id;
        $file = File::where('fileable_id', $id)->where('fileable_type', 'App\Models\Contract')->get(['id', 'url']);
        return response()->json(['data'=>$file]);   
        // $contract_id = $request->id;

        // $images = File::get(['user_id', 'url','fileable_id'])->where('fileable_id', $contract_id);

        // $imageAnswer = [];

        // foreach ($images as $image) {
        //     $imageAnswer[] = [
        //         'user_id' => $image->user_id,
        //         'fileable_id' => $image->fileable_id,
        //         'url' => $image->url,
        //     ];
        // }
        // return response()->json([
        //     'images' => $imageAnswer
        // ]);

    }

}
