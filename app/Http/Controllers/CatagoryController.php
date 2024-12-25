<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Catagory;
class CatagoryController extends Controller
{
    public function addCatagory(Request $request)
    {
        dd($request->all());
        $validator = Validator::make($request->all(),[
            'priority' => 'required',
            'catagory_name' => 'required',
            'catagory_url' => 'required|mimes:jpeg,png,jpg,gif', 
        ]);

        if($validator->fails()){
            return sendError('Validation Error.', $validator->errors());       
        }

        $data = $request->all();
        if($image = $request->file('catagory_url'))
        {
            $destionation = "Catagory/image";
            $fileName = date('YmdHis').'.'.$image->getClientOriginalName();
            $image->storeAs($destionation, $fileName);
            $catagoryurl = Storage::url($image); 
            $data['catagory_url'] = "$catagoryurl";
        }
        

        $catagory = Catagory::create($data);
   
        return sendResponse($catagory, 'Catagory created successfully.');
    }

    public function showAllCatagory()
    {
        $catagory = Catagory::select('id','priority','catagory_name', 'catagory_url')->get();      
        return showResponse($catagory, 'Catagory listing successfully.');
    }

    public function editCatagory(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'priority' => 'required',
            'catagory_name' => 'required',
            'catagory_url' => 'required|file|mimes:jpeg,png,jpg,gif', 
        ]);
        try {

            if($validator->fails()){
                return sendError('Validation Error.', $validator->errors());       
            }
        
    
            $data = $request->all();
            if($image = $request->file('catagory_url'))
            {
                $destionation = "Catagory/image";
                $fileName = date('YmdHis').'.'.$image->getClientOriginalName();
                $image->storeAs($destionation, $fileName);
                $catagoryurl = Storage::url($image); 
                $data['catagory_url'] = "$catagoryurl";
            }
           
            $catagory = Catagory::where('id', $id)->update($data);            
            return sendResponse($data, 'Catagory updated successfully.');
        }catch (\Exception $e) {
            return sendError('Error updating category.', $e->getMessage() . $e->getLine());
        }
    }

    public function delete_catagory($id)
    {
        if($id != "")
        {
            $data = Catagory::findOrFail($id)->delete();
            return sendResponse($data, 'Catagory Deleted successfully.');
        }else{
            return sendError('Error.', "Catagory Not Deleted Successfully.");       
        }
    }

}
