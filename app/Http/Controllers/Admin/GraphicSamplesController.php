<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\GraphicSample;
use App\User;
use App\GraphicTag;
use App\Status;
use App\Helpers\Helper;
use App\Http\Requests\GraphicSampleRequest;
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

class GraphicSamplesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت نمونه کارهای گرافیک';

        $n = 12;
        $query = GraphicSample
            ::leftJoin('statuses', 'graphic_samples.status_id','=','statuses.id')
            ->select('graphic_samples.*')
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
                            return HTML::decode(link_to_route('graphicsamples.edit', '<i data-toggle="tooltip" title="ویرایش"  class="fa fa-edit" style="font-size:20px"></i>', [$val], ['class' => 'small button']));
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
                                return  $this_row.HTML::decode('<form method="post" action="'.route('graphicsamples.destroy',$val).'" onsubmit="return confirm(\'آیا از حذف مطمئن هستید؟\');" ><input type="hidden" name="_method" value="delete"><input name="_token" type="hidden" value="'.csrf_token().'"><button class="btn-delete" type="submit" /><i data-toggle="tooltip" title="حذف"  class="fa fa-trash status" style="font-size:20px; color:#e23513"></i></form>');
                            }
                        })
                ])
        );
        $grid = $grid->render();
        return view('admin.graphicsamples.index', compact( 'title', 'grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = Status::all();
        $data['graphicTags'] = GraphicTag::all();

        return view('admin.graphicsamples.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GraphicSampleRequest $request)
    {
        $validated = $request->validated();

        $graphicSample = new GraphicSample($validated);
        
        if($request->file('image')) 
        {
            $image = $request->file('image');
            $folder = '/uploads/graphicsamples/';
            $prefix = 'graphicsample';
            
            $imageRes = Helper::upload_image($image ,$folder, $prefix);
            
            $graphicSample->image = $folder . $imageRes;
            
            if(!$imageRes) 
            {
                return redirect()->route('graphicsamples.index')->with(['message' => 'تصویر بدرستی آپلود نشد', 'type' => 'alert-danger']);
            }
        }
        
        $graphicSample->status_id = $request['status_id'];
        $graphicSample->user_id = auth()->user()->id;
        if(!$graphicSample->save()) {
            return redirect()->route('graphicsamples.index')->with(['message' => 'خطا در افزودن نمونه کار', 'type' => 'alert-danger']);
        }

        if($request['graphicTags']){
            $selected_tags = array_values($request['graphicTags']);
            $graphicTags = GraphicTag::find($selected_tags);
            if(!Helper::manage_graphic_tags($graphicSample->id, $graphicTags)) {
                return redirect()->route('graphicsamples.index')->with(['message' => 'خطا در افزودن تگ ها', 'type' => 'alert-danger']);
             };
        }

        // Success
        return redirect()->route('graphicsamples.index')->with(['message' => 'نمونه کار با موفقیت اضافه شد', 'type' => 'alert-success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GraphicSample  $graphicSample
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['graphicSample'] = GraphicSample::findOrFail($id);
        $data['status'] = Status::all();
        $data['graphicTags'] = GraphicTag::all();

        return view('admin.graphicsamples.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GraphicSample  $graphicSample
     * @return \Illuminate\Http\Response
     */
    public function edit(GraphicSample $graphicSample)
    {   
        $data['status'] = Status::all();
        $data['graphicTags'] = GraphicTag::all();
        $data['graphicSample'] = $graphicSample;

        return view('admin.graphicsamples.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GraphicSample  $graphicSample
     * @return \Illuminate\Http\Response
     */
    public function update(GraphicSampleRequest $request, $id)
    {
        $validated = $request->validated();

        $graphicSample = GraphicSample::findOrFail($id);
        
        if($request->file('image')) 
        {
            $image = $request->file('image');
            $folder = '/uploads/graphicsamples/';
            $prefix = 'graphicsample';
            
            if($graphicSample->image){
                // Sample has image
                File::delete(public_path($graphicSample->image));
            }

            $imageRes = Helper::upload_image($image ,$folder, $prefix);
            
            $graphicSample->image = $folder . $imageRes;
            $validated['image'] = $graphicSample->image;
            
            if(!$imageRes) 
            {
                // Image not saved
                return redirect()->route('graphicsamples.index')->with(['message' => 'تصویر بدرستی آپلود نشد', 'type' => 'alert-danger']);
            }
        // dd('here');

        }        
        
        $validated['status_id'] = $request['status_id'];
        $graphicSample->user_id = auth()->user()->id;

        if(!$graphicSample->update($validated)) {
            // graphicsample update query failed
            return redirect()->route('graphicsamples.index')->with([
                'message' => 'خطا در آپدیت نمونه کار.',
                'type' => 'alert-danger']);
        } else {
            // update status_id
            $graphicSample->status_id = $request['status_id'];
            if(!$graphicSample->save()) {
                return redirect()->route('graphicsamples.index')->with([
                    'message' => 'خطا در آپدیت نمونه کار.',
                    'type' => 'alert-danger']);
            }
        }
        
        if($request['graphicTags']) {
            $selected_tags = array_values($request['graphicTags']);
            $graphicTags = GraphicTag::find($selected_tags);
            
            if(!Helper::manage_graphic_tags($graphicSample->id, $graphicTags)) {
                return redirect()->route('graphicsamples.index')->with([
                    'graphicSample' => $graphicSample,
                    'message' => 'خطا در افزودن تگ ها',
                    'type' => 'alert-danger']);
            }
        } else {
            if(!Helper::manage_graphic_tags($graphicSample->id)) {
                return redirect()->route('graphicsamples.index')->with([
                    'graphicSample' => $graphicSample,
                    'message' => 'خطا در افزودن تگ ها',
                    'type' => 'alert-danger']);
            }
        }
        
        return redirect()->route('graphicsamples.index')->with(['message' => 'نمونه کار بدرستی آپدیت شد', 'type' => 'alert-success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GraphicSample  $graphicSample
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $graphicSample = GraphicSample::findOrFail($request->id);
        
        if(Helper::manage_graphic_tags($graphicSample->id)) {
            if($graphicSample->delete()) {
                if($graphicSample->image) {
                    // sample has image
                    if(File::delete(public_path($graphicSample->image))) {
                        // Success
                        return redirect()->route('graphicsamples.index')->with(['message'=>'حذف با موفقیت انجام شد.','type'=>'alert-success']);
                    } else {
                        // file delete failed
                        return redirect()->route('graphicsamples.index')->with(['message'=>'خطا در حذف تصویر.','type'=>'alert-danger']);
                    }
                } else {
                    // Success
                    return redirect()->route('graphicsamples.index')->with(['message'=>'حذف با موفقیت انجام شد.','type'=>'alert-success']);
                }
            } else {
                // graphicsample->delete() failed
                return redirect()->route('graphicsamples.index')->with(['message' => 'خطا در حذف نمونه کار.', 'type' => 'alert-danger']);
            }
        } else {
            // manage_graphic_tags failed
            return redirect()->route('graphicsamples.index')->with(['message' => 'خطا در حذف تگ ها', 'type' => 'alert-danger']);
        }

    }

}