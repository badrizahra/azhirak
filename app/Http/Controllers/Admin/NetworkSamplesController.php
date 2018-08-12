<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NetworkSample;
use App\User;
use App\NetworkTag;
use App\Status;
use App\Helpers\Helper;
use App\Http\Requests\NetworkSampleRequest;
use Illuminate\Http\Request;

// Image upload
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class NetworkSamplesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $networkSamples = NetworkSample::all();

        return view('admin.networksamples.index', compact('networkSamples'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = Status::all();
        $data['networkTags'] = NetworkTag::all();

        return view('admin.networksamples.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NetworkSampleRequest $request)
    {
        $validated = $request->validated();

        $networkSample = new NetworkSample($validated);
        
        if($request->file('image')) 
        {
            $image = $request->file('image');
            $folder = '/uploads/networksamples/';
            $prefix = 'networksample';
            
            $imageRes = Helper::upload_image($image ,$folder, $prefix);
            
            $networkSample->image = $folder . $imageRes;
            
            if(!$imageRes) 
            {
                return redirect()->route('networksamples.index')->with(['message' => 'تصویر بدرستی آپلود نشد', 'type' => 'alert-danger']);
            }
        }
        
        $networkSample->status_id = $request['status_id'];
        $networkSample->user_id = auth()->user()->id;
        if(!$networkSample->save()) {
            return redirect()->route('networksamples.index')->with(['message' => 'خطا در افزودن نمونه کار', 'type' => 'alert-danger']);
        }

        if($request['networkTags']){
            $selected_tags = array_values($request['networkTags']);
            $networkTags = NetworkTag::find($selected_tags);
            if(!Helper::manage_network_tags($networkSample->id, $networkTags)) {
                return redirect()->route('networksamples.index')->with(['message' => 'خطا در افزودن تگ ها', 'type' => 'alert-danger']);
             };
        }

        // Success
        return redirect()->route('networksamples.index')->with(['message' => 'نمونه کار با موفقیت اضافه شد', 'type' => 'alert-success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NetworkSample  $networkSample
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['networkSample'] = NetworkSample::findOrFail($id);
        $data['status'] = Status::all();
        $data['networkTags'] = NetworkTag::all();

        return view('admin.networksamples.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NetworkSample  $networkSample
     * @return \Illuminate\Http\Response
     */
    public function edit(NetworkSample $networkSample)
    {   
        $data['status'] = Status::all();
        $data['networkTags'] = NetworkTag::all();
        $data['networkSample'] = $networkSample;

        return view('admin.networksamples.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NetworkSample  $networkSample
     * @return \Illuminate\Http\Response
     */
    public function update(NetworkSampleRequest $request, $id)
    {
        $validated = $request->validated();

        $networkSample = NetworkSample::findOrFail($id);
        
        if($request->file('image')) 
        {
            $image = $request->file('image');
            $folder = '/uploads/networksamples/';
            $prefix = 'networksample';
            
            if($networkSample->image){
                // Sample has image
                File::delete(public_path($networkSample->image));
            }

            $imageRes = Helper::upload_image($image ,$folder, $prefix);
            
            $networkSample->image = $folder . $imageRes;
            $validated['image'] = $networkSample->image;
            
            if(!$imageRes) 
            {
                // Image not saved
                return redirect()->route('networksamples.index')->with(['message' => 'تصویر بدرستی آپلود نشد', 'type' => 'alert-danger']);
            }
        // dd('here');

        }        
        
        $validated['status_id'] = $request['status_id'];
        $networkSample->user_id = auth()->user()->id;

        if(!$networkSample->update($validated)) {
            // networksample update query failed
            return redirect()->route('networksamples.index')->with([
                'message' => 'خطا در آپدیت نمونه کار.',
                'type' => 'alert-danger']);
        } else {
            // update status_id
            $networkSample->status_id = $request['status_id'];
            if(!$networkSample->save()) {
                return redirect()->route('networksamples.index')->with([
                    'message' => 'خطا در آپدیت نمونه کار.',
                    'type' => 'alert-danger']);
            }
        }
        
        if($request['networkTags']) {
            $selected_tags = array_values($request['networkTags']);
            $networkTags = NetworkTag::find($selected_tags);
            
            if(!Helper::manage_network_tags($networkSample->id, $networkTags)) {
                return redirect()->route('networksamples.index')->with([
                    'networkSample' => $networkSample,
                    'message' => 'خطا در افزودن تگ ها',
                    'type' => 'alert-danger']);
            }
        } else {
            if(!Helper::manage_network_tags($networkSample->id)) {
                return redirect()->route('networksamples.index')->with([
                    'networkSample' => $networkSample,
                    'message' => 'خطا در افزودن تگ ها',
                    'type' => 'alert-danger']);
            }
        }
        
        return redirect()->route('networksamples.index')->with(['message' => 'نمونه کار بدرستی آپدیت شد', 'type' => 'alert-success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NetworkSample  $networkSample
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $networkSample = NetworkSample::findOrFail($request->id);
        
        if(Helper::manage_network_tags($networkSample->id)) {
            if($networkSample->delete()) {
                if($networkSample->image) {
                    // sample has image
                    if(File::delete(public_path($networkSample->image))) {
                        // Success
                        return redirect()->route('networksamples.index')->with(['message'=>'حذف با موفقیت انجام شد.','type'=>'alert-success']);
                    } else {
                        // file delete failed
                        return redirect()->route('networksamples.index')->with(['message'=>'خطا در حذف تصویر.','type'=>'alert-danger']);
                    }
                } else {
                    // Success
                    return redirect()->route('networksamples.index')->with(['message'=>'حذف با موفقیت انجام شد.','type'=>'alert-success']);
                }
            } else {
                // networksample->delete() failed
                return redirect()->route('networksamples.index')->with(['message' => 'خطا در حذف نمونه کار.', 'type' => 'alert-danger']);
            }
        } else {
            // manage_network_tags failed
            return redirect()->route('networksamples.index')->with(['message' => 'خطا در حذف تگ ها', 'type' => 'alert-danger']);
        }

    }

}