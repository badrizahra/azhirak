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

        return view('admin.websamples.index', compact('webSamples'));
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

        $webSample = new WebSample($validated);
        
        if($request->file('image')) 
        {
            $image = $request->file('image');
            $folder = '/uploads/websamples/';
            $prefix = 'websample';
            
            $imageRes = Helper::upload_image($image ,$folder, $prefix);
            
            $webSample->image = $folder . $imageRes;
            
            if(!$imageRes) 
            {
                return false;
            }
        } else {
            $webSample->image = '/uploads/websamples/websample_default.jpg';
        }
        
        $webSample->status_id = $request['status_id'];
        $webSample->user_id = auth()->user()->id;
        if(!$webSample->save()) {
            return false;
        }

        if($request['webTags']){

            // $webRes = Helper::add_tags($request['id'], $request['webTags']);

            $selected_tags = array_values($request['webTags']);
            $webTags = WebTag::find($selected_tags);
            Helper::manage_web_tags($webSample->id, $webTags);
        }


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
        $data['webSample'] = WebSample::findOrFail($id);
        $data['status'] = Status::all();
        $data['webTags'] = WebTag::all();

        return view('admin.websamples.show', $data);
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

        return view('admin.websamples.edit', [
            'webSample' => $webSample,
            'status' => $status,
            'webTags' => $webTags,
        ]);

        $data['status'] = Status::all();
        $data['webTags'] = WebTag::all();
        $data['webSample'] = $webSample;

        return view('admin.websamples.create', $data);
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
        // dd($validated);

        $webSample = WebSample::findOrFail($id);

        if($request->file('image')) 
        {
            $image = $request->file('image');
            $folder = '/uploads/websamples/';
            $prefix = 'websample';
            
            File::delete(public_path($webSample->image));
            $imageRes = Helper::upload_image($image ,$folder, $prefix);
            
            $webSample->image = $folder . $imageRes;
            $validated['image'] = $webSample->image;
            
            if(!$imageRes) 
            {
                return false;
            }
        }
        
        $validated['status_id'] = $request['status_id'];
        // $webSample->user_id = auth()->user()->id;
        if($webSample->user_id == auth()->user()->id) {
            if(!$webSample->update($validated)) {
                // websample update query failed
                return false;
            } else {
                // update status_id
                $webSample->status_id = $request['status_id'];
                $webSample->save();
            }
        } else {
            // this user didnt create the sample
            return false;
        }
        
        if($request['webTags']){

            // $webRes = Helper::add_web_tags($request['id'], $request['webTags']);

            $selected_tags = array_values($request['webTags']);
            $webTags = WebTag::find($selected_tags);
            $tagRes = Helper::manage_web_tags($webSample->id, $webTags);
            if(!$tagRes) {
                return false;
            }
        } else {
            $tagRes = Helper::manage_web_tags($webSample->id);
            if(!$tagRes) {
                return false;
            }
        }

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
        
        if(File::delete(public_path($webSample->image))) {
            if($webSample->delete()) {
                $res = Helper::manage_web_tags($webSample->id);
                if($res) {
                    return redirect('/admin/websamples');
                } else {
                    return false;
                }
            }         
        }
    }

    /**
     * Deletes websample image and sets websample image to default
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete_image(Request $request) 
    {
        $webSample = WebSample::findOrFail($request->id);
        if(File::delete(public_path($websample->image))) {
            $webSample->image = '/uploads/websamples/websample_default.jpg';
            $webSample->save();
            return back();
        } else {
            return false;
        }
    }

}
