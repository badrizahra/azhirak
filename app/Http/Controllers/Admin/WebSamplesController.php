<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\WebSample;
use App\User;
use App\WebTag;
use App\Status;
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
        $status = Status::all();
        $webTags = WebTag::all();

        return view('websamples.create', [
            'status'=>$status,
            'webTags'=>$webTags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebSampleRequest $request)
    {
        // User the User model function to addWebSample for user
        // $user->addWebSample([
        //     'title'=>$request('title'),
        //     'description'=>$request('description'),
        //     'url'=>$request('url'),
        //     'image'=>$request('image')
        //     ]);

        $validated = $request->validated();

        $image = $request->file('image');
        $image_mime = $image->getClientOriginalExtension();
        $imagePath = 'uploads/websamples/' . $image->getFilename() . '.' . $image->getClientOriginalExtension();
        
        $webSample = new WebSample($validated);
        $webSample->image = $imagePath;
        $webSample->status_id = $request['status'];
        $webSample->user_id = auth()->user()->id;
        $webSample->save();
        
        $selected_tags = array_values($request['webTags']);
        $webTags = WebTag::find($selected_tags);
        $webSample->webtags()->attach($webTags);
        
        Storage::disk('public')->put( 'websamples/' . $image->getFilename() . '.' . $image_mime, File::get($image));

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
            $imagePath = 'uploads/websamples' . $image->getFilename() . '.' . $image->getClientOriginalExtension();

            // delete old
            File::delete($webSample->image);
            // store new 
            Storage::disk('public')->put( 'websamples/' . $image->getFilename() . '.' . $image_mime, File::get($image));
            // set new path to db
            $validated['image'] = $imagePath;
            $validated['image_mimetype'] = $image_mime;
        }
        
        $webSample->update($validated);

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

        return redirect('/admin/websamples');
    }

}
