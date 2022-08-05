<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        if (isset($inputs['file'])) $inputs['photos'][] = $inputs['file'];


        $validator = Validator::make($inputs, [
            "photos" => ["required", "max:1000"],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $images = [];
        foreach ($inputs['photos'] as $image) {

            $fileInfo = $image->getClientOriginalName();
            $newFileName = time() . '.' . $image->extension();
            $path = Storage::disk('local')->put('images' . '/' . $newFileName, $image);
            $url = Storage::disk('local')->url($path);
            $photo = [
                'file_original_name' => pathinfo($fileInfo, PATHINFO_FILENAME),
                'extension' => pathinfo($fileInfo, PATHINFO_EXTENSION),
                'file_name' => $newFileName,
                'type' => $image->getMimeType(),
                'url' =>  $url,
                'file_path' => $path,
            ];
            $images[] = Upload::create($photo)->id;
        }
        return response()->json($images, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id , Request $request)
    {
        $upload = Upload::find($id);
        if ($upload) {
            Storage::disk('local')->delete($upload->url);
            $upload->delete();
            return true;
        }
        return false;
    }
}
