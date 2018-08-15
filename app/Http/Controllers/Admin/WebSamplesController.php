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
use Nayjest\Grids\Grid;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\ObjectDataRow;
use Html;

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
//        $webSamples = WebSample::all();
//
//        return view('admin.websamples.index', compact('webSamples'));
        $title = 'مدیریت نمونه کارهای وب';

        $n = 12;
        $query = WebSample
            ::leftJoin('statuses', 'web_samples.status_id','=','statuses.id')
            ->select('web_samples.*')
            ->addSelect('statuses.title as status');

        $grid = new Grid(
            (new GridConfig)
                ->setDataProvider(
                    new EloquentDataProvider($query)
                )
                ->setName('id')
                ->setPageSize(12)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('ID')
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_DESC)
                    ,
                    (new FieldConfig)
                        ->setName('title')
                        ->setLabel('عنوان')
                        ->setCallback(function ($val) {
                            return $val;
                        })
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('url')
                        ->setLabel('آدرس وب سایت')
                        ->setCallback(function ($val) {
                            return $val;
                        })
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('status')
                        ->setLabel('وضعیت')
                        ->setCallback(function ($val) {
                            return $val;
                        })
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('created_at')
                        ->setLabel('تاریخ درج')
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                        ->setCallback(function ($val) {
                            return $val;
                        })
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('ویرایش')
                        ->setCallback(function ($val, ObjectDataRow $row) {
                            return HTML::decode(link_to_route('websamples.edit', '<i data-toggle="tooltip" title="ویرایش"  class="fa fa-edit" style="font-size:20px"></i>', [$val], ['class' => 'small button']));
                        })
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('حذف')
                        ->setCallback(function ($val, ObjectDataRow $row) use($n) {
                            if ($val) {
                                $this_row = '';
                                if(($row->getId() - 1) % $n == 0) {
                                    $this_row = '</form>';
                                }
                                return  $this_row.HTML::decode('<form method="post" action="'.route('websamples.destroy',$val).'" onsubmit="return confirm(\'آیا از حذف مطمئن هستید؟\');" ><input type="hidden" name="_method" value="delete"><input name="_token" type="hidden" value="'.csrf_token().'"><button class="btn-delete" type="submit" /><i data-toggle="tooltip" title="حذف"  class="fa fa-trash status" style="font-size:20px; color:#e23513"></i></form>');
                            }
                        })
                ])
        );
        $grid = $grid->render();
        return view('admin/websamples/index', compact( 'title', 'grid'));
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
                return redirect()->route('websamples.index')->with(['message' => 'تصویر بدرستی آپلود نشد', 'type' => 'alert-danger']);
            }
        }
        
        $webSample->status_id = $request['status_id'];
        $webSample->user_id = auth()->user()->id;
        if(!$webSample->save()) {
            return redirect()->route('websamples.index')->with(['message' => 'خطا در افزودن نمونه کار', 'type' => 'alert-danger']);
        }

        if($request['webTags']){
            $selected_tags = array_values($request['webTags']);
            $webTags = WebTag::find($selected_tags);
            if(!Helper::manage_web_tags($webSample->id, $webTags)) {
                return redirect()->route('websamples.index')->with(['message' => 'خطا در افزودن تگ ها', 'type' => 'alert-danger']);
             };
        }

        // Success
        return redirect()->route('websamples.index')->with(['message' => 'نمونه کار با موفقیت اضافه شد', 'type' => 'alert-success']);
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
        $data['status'] = Status::all();
        $data['webTags'] = WebTag::all();
        $data['webSample'] = $webSample;

        return view('admin.websamples.edit', $data);
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
        
        if($request->file('image')) 
        {
            $image = $request->file('image');
            $folder = '/uploads/websamples/';
            $prefix = 'websample';
            
            if($webSample->image){
                // Sample has image
                File::delete(public_path($webSample->image));
            }

            $imageRes = Helper::upload_image($image ,$folder, $prefix);
            
            $webSample->image = $folder . $imageRes;
            $validated['image'] = $webSample->image;
            
            if(!$imageRes) 
            {
                // Image not saved
                return redirect()->route('websamples.index')->with(['message' => 'تصویر بدرستی آپلود نشد', 'type' => 'alert-danger']);
            }
        // dd('here');

        }        
        
        $validated['status_id'] = $request['status_id'];
        $webSample->user_id = auth()->user()->id;

        if(!$webSample->update($validated)) {
            // websample update query failed
            return redirect()->route('websamples.index')->with([
                'message' => 'خطا در آپدیت نمونه کار.',
                'type' => 'alert-danger']);
        } else {
            // update status_id
            $webSample->status_id = $request['status_id'];
            if(!$webSample->save()) {
                return redirect()->route('websamples.index')->with([
                    'message' => 'خطا در آپدیت نمونه کار.',
                    'type' => 'alert-danger']);
            }
        }
        
        if($request['webTags']) {
            $selected_tags = array_values($request['webTags']);
            $webTags = WebTag::find($selected_tags);
            
            if(!Helper::manage_web_tags($webSample->id, $webTags)) {
                return redirect()->route('websamples.index')->with([
                    'webSample' => $webSample,
                    'message' => 'خطا در افزودن تگ ها',
                    'type' => 'alert-danger']);
            }
        } else {
            if(!Helper::manage_web_tags($webSample->id)) {
                return redirect()->route('websamples.index')->with([
                    'webSample' => $webSample,
                    'message' => 'خطا در افزودن تگ ها',
                    'type' => 'alert-danger']);
            }
        }
        
        return redirect()->route('websamples.index')->with(['message' => 'نمونه کار بدرستی آپدیت شد', 'type' => 'alert-success']);

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
        
        if(Helper::manage_web_tags($webSample->id)) {
            if($webSample->delete()) {
                if($webSample->image) {
                    // sample has image
                    if(File::delete(public_path($webSample->image))) {
                        // Success
                        return redirect()->route('websamples.index')->with(['message'=>'حذف با موفقیت انجام شد.','type'=>'alert-success']);
                    } else {
                        // file delete failed
                        return redirect()->route('websamples.index')->with(['message'=>'خطا در حذف تصویر.','type'=>'alert-danger']);
                    }
                } else {
                    // Success
                    return redirect()->route('websamples.index')->with(['message'=>'حذف با موفقیت انجام شد.','type'=>'alert-success']);
                }
            } else {
                // websample->delete() failed
                return redirect()->route('websamples.index')->with(['message' => 'خطا در حذف نمونه کار.', 'type' => 'alert-danger']);
            }
        } else {
            // manage_web_tags failed
            return redirect()->route('websamples.index')->with(['message' => 'خطا در حذف تگ ها', 'type' => 'alert-danger']);
        }

    }

}
