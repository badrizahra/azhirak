<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;

use Nayjest\Grids\Grid;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\ObjectDataRow;
use Html;

use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'لیست رول ها ';
        $query = (new Role)
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
                        ->setLabel('ردیف')
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_ASC)
                    ,
                    (new FieldConfig)
                        ->setName('title')
                        ->setLabel('عنوان')
                       /* ->setCallback(function ($val, ObjectDataRow $row) {
                            if($row->getSrc()->discount != null) {
                                $this_row = '<a href="'.route('package.show',$row->getSrc()->id).'"><div style="color:#ec5e2f;">' .$val.'</div></a>';
                            }
                            else {
                                $this_row = '<a href="'.route('package.show',$row->getSrc()->id).'">' .$val. '';
                            }
                            return  $this_row;
                        })*/
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('ویرایش')
                        ->setCallback(function ($val, ObjectDataRow $row) {
                            if (Gate::allows('permission', 'role.edit') && $val) {
                                return HTML::decode(link_to_route('role.edit', '<i data-toggle="tooltip" title="ویرایش"  class="fa fa-edit" style="font-size:20px"></i>', [$val], ['class' => 'small button']));
                            }
                        })
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('حذف')
                        ->setCallback(function ($val, ObjectDataRow $row) {
                            $role=$row->getSrc()->title;
                            if($role!="user" && $role!="super admin" && $role!="seller"){
                                if (Gate::allows('permission', 'role.destroy') && $val) {
                                    $del = "<a onclick=\"return confirm('آیا مطمئن هستید?')\"  href='".route('role.destroy',[$val])."' class=\"small button\"><i data-toggle=\"tooltip\" title=\"\" class=\"fa fa-trash\" style=\"font-size:20px; color: red\" data-original-title=\"حذف\"></i></a>";
                                    return $del;
                                }
                            }
                            return '';
                        })
                ])
        );
        $grid = $grid->render();
        return view('admin/role/index', compact( 'title', 'grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/role/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        Role::create($request->all());
        return redirect()->route('role.index')->with(['message'=>'رول جدید با موفقیت افزوده شد.','type'=>'alert-success']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $item = Role::find($id);
        return view('admin/role/edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Role::find($id)->update($request->all());
        return redirect()->route('role.index')->with(['message'=>'ویرایش با موفقیت انجام شد.','type'=>'alert-success']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!Role::where('id', $id)->delete()) {
            return redirect()->route('role.index')->with(['message'=>'عملیات با مشکل روبرو شد. لطفا دوباره تلاش کنید.','type'=>'alert-danger']);
        }
        else {
            return redirect()->route('role.index')->with(['message'=>'حذف با موفقیت انجام شد.','type'=>'alert-success']);
        }
    }

}
