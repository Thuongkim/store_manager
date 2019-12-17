<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Auth;
use Image;
use Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageUploadRequest;

class FilesController extends Controller
{
	public function postImages(Request $request)
	{
		if ($request->hasFile('file')) {
			$imageFiles = $request->file('file');
			$folderDir = "uploads/appendixes/";
			$destinationPath = public_path('uploads/appendixes');
			$ext = $imageFiles->getClientOriginalExtension();
            $destinationFileName = "appendix-".sha1(date('YmdHis') . str_random(30)).'.'.$ext;
			$imageFiles->move($destinationPath, $destinationFileName);
            // save file in database
			$file = new File;
			$file->url = $folderDir . $destinationFileName;
			$file->user_id = Auth::user()->id;
			$file->fileable_type = "App\Models\Appendix";
			$file->save();
			return response()->json(['id'=>$file->id]);
		}
	}

	public function destroyImages(Request $request)
	{
		$image_id = $request->imageId;
        $uploaded_image = File::where('id', $image_id)->first();
 
        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }
 
        $file_path = public_path() . $uploaded_image->url;
        // $resized_file = $this->photos_path . '/' . $uploaded_image->resized_name;
 
        if (file_exists($file_path)) {
            Storage::delete($uploaded_image->url);
        }
 
        // if (file_exists($resized_file)) {
        //     unlink($resized_file);
        // }
 
        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }
 
        return Response::json(['message' => 'File successfully delete'], 200);
	}

	public function showImages(Request $request)
	{
		$id = $request->id;
		$file = File::where('fileable_id', $id)->where('fileable_type', 'App\Models\Appendix')->get(['id', 'url']);
		return response()->json(['data'=>$file]);	
	}

}
