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

class NetworkSamplesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت نونه کارهای شبکه';

        $n = 12;
        $query = NetworkSample
            ::leftJoin('statuses', 'network_samples.status_id','=','statuses.id')
            ->select('network_samples.*')
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
                            return HTML::decode(link_to_route('networksamples.edit', '<i data-toggle="tooltip" title="ویرایش"  class="fa fa-edit" style="font-size:20px"></i>', [$val], ['class' => 'small button']));
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
                                return  $this_row.HTML::decode('<form method="post" action="'.route('networksamples.destroy',$val).'" onsubmit="return confirm(\'آیا از حذف مطمئن هستید؟\');" ><input type="hidden" name="_method" value="delete"><input name="_token" type="hidden" value="'.csrf_token().'"><button class="btn-delete" type="submit" /><i data-toggle="tooltip" title="حذف"  class="fa fa-trash status" style="font-size:20px; color:#e23513"></i></form>');
                            }
                        })
                ])
        );
        $grid = $grid->render();
        return view('admin.networksamples.index', compact( 'title', 'grid'));
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