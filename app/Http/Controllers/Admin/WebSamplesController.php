<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\WebSample;
use App\User;
use App\Http\Requests\WebSampleRequest;
use Illuminate\Http\Request;

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
        return view('websamples.create');
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

        $webSample = new WebSample($validated);
        $webSample -> save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebSample  $webSample
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $webSample = WebSample::find($id);
        return($webSample);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WebSample  $webSample
     * @return \Illuminate\Http\Response
     */
    public function edit(WebSample $webSample)
    {   
        return view('websamples.edit', ['webSample' => $webSample]);
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

        $webSample = WebSample::find($id);
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
        $webSample = WebSample::find($request->id);

        $webSample->delete();

        return redirect('/admin/websamples');
    }
}
