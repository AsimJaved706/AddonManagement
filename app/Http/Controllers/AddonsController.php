<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Addons;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;
use ZipArchive;
use Illuminate\Support\Facades\Artisan;
class AddonsController extends Controller
{
    // view form
    public function index()
    {
        return view('form.form');
    }

    // Addons
    public function viewRecord()
    {
        $data = Addons::get();
        return view('view_record.viewrecord',compact('data'));
    }

    public function updateaddon(Request $request,$id)
    {
        try{
            $status       = $request->status;
            $comments       = $request->comments;

            $update = [
                'status'        => $status,
                'comments'        => $comments,
            ];
            Addons::where('id',$id)->update($update);
            Toastr::success('Data updated successfully :)','Success');
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error('Data updated fail :)','Error');
            return redirect()->back();
        }
    }

    // // save 
    public function saveRecord(Request $request)
    {
        if ($request->hasFile('addon_file')) {
            $zip_file = $request->file('addon_file');
            $file_name = $zip_file->getClientOriginalName();
            $public_path = public_path('zip');
            $zip_file->move($public_path, $file_name);
            $url = asset('zip/' . $file_name);
        }

        $user_id=auth()->user()->id;
        $request->validate([
            'addon_name'=> 'required',
        ]);

        try{
            $user_id     = $user_id;
            $addon_name      = $request->addon_name;
            $file_name = $file_name;
            $file_path     = $url;

            $Addon = new Addons();
            $Addon->user_id    = $user_id;
            $Addon->addon_name = $addon_name;
            $Addon->file_name = $file_name;
            $Addon->file_path  = $file_path;
            $Addon->status  = 'pending';
            $Addon->save();
            Toastr::success('Data added successfully :)','Success');
            return redirect()->back();

        }catch(\Exception $e){
            Toastr::error('Data added fail :)','Error');
            return redirect()->back();
        }
    }

    public function extractZip(Request $request){
        // Path to the ZIP file
        $encodedFilePath  = urldecode($request->input('zipFilePath'));
        $zipFilePath = urlencode($encodedFilePath );
        // Destination directory for extracted files
        $extractPath = public_path('modules');
        $filename = pathinfo(basename($request->input('zipFilePath')), PATHINFO_FILENAME);

        try {
            file_put_contents($zipFilePath, $extractPath);
            $zip = new ZipArchive();
            Artisan::call('module:make', ['name' => $filename]);
            if ($zip->open($zipFilePath) == true) {
               $zip->open($zipFilePath);
               $zip->extractTo($extractPath);
               $zip->close();

                return response()->json(['message' => 'ZIP file extracted successfully']);
            } else {
                return response()->json(['error' => 'Failed to open ZIP file'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }}


