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
            'image_url' => 'required',             
        ]);

        if($validator->fails()){
            return sendError('Validation Error.', $validator->errors());       
        }

        $data = $request->all();
        // if($image = $request->file('image_url'))
        // {
        //     $destionation = "Frame/image";
        //     $fileName = date('YmdHis').'.'.$image->getClientOriginalName();
        //     $image->storeAs($destionation, $fileName);
        //     $catagoryurl = Storage::url($image); 
        //     $data['image_url'] = "$catagoryurl";
        // }
        $frame = Frames::create($data);
        return sendResponse($frame, 'Frame created successfully.');
    }

    public function showFrameCatagory(Request $request)
    {
        $page = $request->page ?? 1;
        $size = $request->size ?? 10;
        $catagory_id = $request->catagory_id ?? null;

        $query = Frames::with('catagory');


        if ($catagory_id) {
            $query->where('catagory_id', $catagory_id);
        }

        $frames = $query->paginate($size, ['*'], 'page', $page);


        $groupedData = $frames->getCollection()->groupBy('catagory_id')->map(function ($items, $categoryId) {
            $category = $items->first()->catagory;

            return [
                'categories_id' => $categoryId,
                'categories_name' => $category->catagory_name,
                'frames' => $items->map(function ($frame) {
                    return [
                        'id' => $frame->id,
                        'image_url' => $frame->image_url,
                        'is_popular' => $frame->is_popular,
                        'is_premium' => $frame->is_premium,
                    ];
                })->values(),
            ];
        })->values();

     
        return showResponse($groupedData, 'Frame listing successfully.');
    }

    public function editFrame(Request $request)
    {
      
        $validator = Validator::make($request->all(),[
            'catagory_id' => 'required',        
            'image_url' => 'required',             
        ]);

        if($validator->fails()){
            return sendError('Validation Error.', $validator->errors());       
        }

        $data = $request->all();
        // if($image = $request->file('image_url'))
        // {
        //     $destionation = "Frame/image";
        //     $fileName = date('YmdHis').'.'.$image->getClientOriginalName();
        //     $image->storeAs($destionation, $fileName);
        //     $catagoryurl = Storage::url($image); 
        //     $data['image_url'] = "$catagoryurl";
        // }
        $frame = Frames::where('id', $request->id)->update($data);
        return sendResponse($frame, 'Frame updated successfully.');
    }
    public function deleteFrame($id)
    {
        if($id != "")
        {
            $data = Frames::findOrFail($id)->delete();
            return sendResponse($data, 'Frame Deleted successfully.');
        }else{
            return sendError('Error.', "Frame Not Deleted Successfully.");       
        }
        

    }
}
