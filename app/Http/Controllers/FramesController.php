<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Frames;


class FramesController extends Controller
{
    public function addFrame(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'catagory_id' => 'required',
            'catagory_name' => 'required',
            'image_url' => 'required|file|mimes:jpeg,png,jpg,gif',             
        ]);

        if($validator->fails()){
            return sendError('Validation Error.', $validator->errors());       
        }

        $data = $request->all();
        if($image = $request->file('image_url'))
        {
            $destionation = "Frame/image";
            $fileName = date('YmdHis').'.'.$image->getClientOriginalName();
            $image->storeAs($destionation, $fileName);
            $catagoryurl = Storage::url($image); 
            $data['catagory_url'] = "$catagoryurl";
        }
        

        $frame = Frames::create($data);
   
        return sendResponse($frame, 'Frame created successfully.');
    }
}
