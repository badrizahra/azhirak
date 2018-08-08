<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\WebSample;
use App\User;
use App\WebTag;
use App\Status;
use App\Helpers\Helper;
use App\Http\Requests\WebSampleRequest;
use Illuminate\Http\Request;

// Image upload
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class WebSamplesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $webSamples = WebSample::all();

        return($webSamples);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = Status::all();
        $data['webTags'] = WebTag::all();

        return view('admin.websamples.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebSampleRequest $request)
    {
        $validated = $request->validated();
        
        // Storage::disk('public')->put( 'websamples/' . $image->getFilename() . '.' . $image_mime, File::get($image));
        
        if($request->file('image')) 
        {
            // $width = 300;
            // $length = 300;
            $image = $request->file('image');
            // $imageName = $image->getFilename();
            // $imageExtenstion = '.' . $image -> getClientOriginalExtension();
            $folder = '/uploads/websamples/';
            // $storage_path = public_path($folder . $imageName . $imageExtenstion);

            $image_res = Helper::upload_image($image ,$folder);
            
            if(!$image_res) 
            {
                return false;
            }
            
            dd($image_res);
            
        }


        $webSample = new WebSample($validated);
        $webSample->image = $imagePath;
        $webSample->status_id = $request['status'];
        $webSample->user_id = auth()->user()->id;
        if(!$webSample->save()) {
            return false;
        }

        $selected_tags = array_values($request['webTags']);
        $webTags = WebTag::find($selected_tags);
        $webSample->webtags()->attach($webTags);

        return redirect('/admin/websamples');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebSample  $webSample
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $webSample = WebSample::findOrFail($id);
        return view ('websamples.show', ['webSample' => $webSample]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WebSample  $webSample
     * @return \Illuminate\Http\Response
     */
    public function edit(WebSample $webSample)
    {   
        $status = Status::all();
        $webTags = WebTag::all();

        return view('websamples.edit', [
            'webSample' => $webSample,
            'status' => $status,
            'webTags' => $webTags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WebSample  $webSample
     * @return \Illuminate\Http\Response
     */
    public function update(WebSampleRequest $request, $id)
    {
        $validated = $request->validated();

        $webSample = WebSample::findOrFail($id);
        
        if($request->file('image')) {

            // websample::uploadImage()

            // validate new image

            //set new variables
            $image = $request->file('image');
            $image_mime = $image->getClientOriginalExtension();
            $imagePath = 'uploads/websamples/' . $image->getFilename() . '.' . $image->getClientOriginalExtension();

            // delete old
            File::delete($webSample->image);
            // store new 
            Storage::disk('public')->put( 'websamples/' . $image->getFilename() . '.' . $image_mime, File::get($image));
            // set new path to db
            $validated['image'] = $imagePath;
            $validated['image_mimetype'] = $image_mime;
        }
        
        $webSample->update($validated);
        
        $selected_tags = array_values($request['webTags']);
        $webTags = WebTag::find($selected_tags);
        $webSample->webtags()->detach();
        $webSample->webtags()->attach($webTags);

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WebSample  $webSample
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $webSample = WebSample::findOrFail($request->id);
        
        File::delete($webSample->image);
        
        $webSample->delete();
        $webSample->webtags()->detach();

        return redirect('/admin/websamples');
    }

}
