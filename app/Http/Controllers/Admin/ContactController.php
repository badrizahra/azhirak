<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nayjest\Grids\Grid;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\ObjectDataRow;
use Html;


class ContactController extends Controller
{
    /**
     * Index
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت تماس ها ';
        $n = 12;
        $query = (new Contact)
            ->newQuery();

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
                        ->setName('subject')
                        ->setLabel('عنوان')
                        ->setCallback(function ($val, ObjectDataRow $row) {
                            $id = $row->getSrc()->id;
                            if($row->getSrc()->is_seen == 0) {
                                $res_row = "<span style='font-weight: bold'>". $val."</span>";
                            }
                            else {
                                $res_row = $val;
                            }
                            return '<a href="'.route('contact.show',$id).'">'.$res_row.'</a>';
                        })
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('name')
                        ->setLabel('نام و نام خانوادگی')
                        ->setCallback(function ($val, ObjectDataRow $row) {
                            $id = $row->getSrc()->id;
                            if($row->getSrc()->is_seen == 0) {
                                $res_row = "<span style='font-weight: bold'>". $val."</span>";
                            }
                            else {
                                $res_row = $val;
                            }
                            return '<a href="'.route('contact.show',$id).'">'.$res_row.'</a>';
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
                        ->setCallback(function ($val, ObjectDataRow $row) {
                            $id = $row->getSrc()->id;
                            if($row->getSrc()->is_seen == 0) {
                                $res_row = "<span style='font-weight: bold'>". $val."</span>";
                            }
                            else {
                                $res_row = $val;
                            }
                            return '<a href="'.route('contact.show',$id).'">'.$res_row.'</a>';
                        })
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('حذف')
                        ->setCallback(function ($val, ObjectDataRow $row) use($n) {
                            if ($val) {
                                return  HTML::decode('<form method="post" action="'.route('contact.delete').'" onsubmit="return confirm(\'آیا از حذف مطمئن هستید؟\');" ><input type="hidden" name="_method" value="delete"><input type="hidden" name="id" value="'.$val.'"><input name="_token" type="hidden" value="'.csrf_token().'"><button class="btn-delete" type="submit" /><i data-toggle="tooltip" title="حذف"  class="fa fa-trash status" style="font-size:20px; color:#e23513"></i></form>');
                            }
                        })
                ])
        );
        $grid = $grid->render();
        return view('admin/contact/index', compact( 'title', 'grid'));

    }

    public function show($id) {
        $item = Contact::find($id);
        $title = '';
        return view('admin/contact/show',compact('item','title'));
    }

    /**
     * Delete
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request) {
        if(!$request->id) {
            return redirect()->route('contact.index')->with(['message'=>'اطلاعات نامعتبر است.','type'=>'alert-danger']);
        }

        if (Contact::where('id', $request->id)->delete()) {
            return redirect()->route('contact.index')->with(['message'=>'حذف با موفقیت انجام شد.','type'=>'alert-success']);
        }
        else {
            return redirect()->route('contact.index')->with(['message'=>'عملیات با مشکل مواجه شد.','type'=>'alert-danger']);
        }
    }
}