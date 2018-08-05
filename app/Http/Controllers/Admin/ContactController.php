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
                        ->setSorting(Grid::SORT_ASC)
                    ,
                    (new FieldConfig)
                        ->setName('subject')
                        ->setLabel('عنوان')
                        ->setCallback(function ($val, ObjectDataRow $row) {
                            if($row->getSrc()->answer_date == null) {
                                return "<span style='font-weight: bold'>". $val."</span>";
                            }
                            else {
                                return  $val;
                            }
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
                            if($row->getSrc()->answer_date == null) {
                                return "<span style='font-weight: bold'>". $val."</span>";
                            }
                            else {
                                return  $val;
                            }
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
                            if($row->getSrc()->answer_date == null) {
                                return "<span style='font-weight: bold'>". $val."</span>";
                            }
                            else {
                                return  $val;
                            }
                        })
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('حذف')
                        ->setCallback(function ($val, ObjectDataRow $row) use($n) {
                            if ($val) {
//                                if (Gate::allows('permission', 'faq.delete')) {
//                                    $this_row = '';
//                                    if(($row->getId() - 1) % $n == 0) {
//                                        $this_row = '</form>';
//                                    }
//                                    return  $this_row.HTML::decode('<form method="post" action="'.route('faq.delete').'" onsubmit="return confirm(\'آیا از حذف مطمئن هستید؟\');" ><input type="hidden" name="_method" value="delete"><input type="hidden" name="id" value="'.$val.'"><input name="_token" type="hidden" value="'.csrf_token().'"><button class="btn-delete" type="submit" /><i data-toggle="tooltip" title="حذف"  class="fa fa-trash status" style="font-size:20px; color:#e23513"></i></form>');
//                                }
//                                else {
                                    return '<i data-toggle="tooltip" title="" class="fa fa-trash" style="font-size:20px; color:#ababab" data-original-title="حذف"></i>';
//                                }
                            }
                        })
                ])
        );
        $grid = $grid->render();
        return view('admin/contact/index', compact( 'title', 'grid'));

    }
}