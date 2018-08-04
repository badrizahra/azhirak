<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Module;
use App\PermissionRole;
use App\Role;
use Illuminate\Http\Request;


class PermissionController extends Controller
{
    /**
     * check
     * check if this role has permission to see page or not
     *
     * @used-by index
     *
     * @param $role
     * @param $permission
     * @return bool
     */
    public  function check($role,$permission){
        $flag=PermissionRole::where(['role_id'=>$role,'permission_id'=>$permission])->first();
        if($flag){
            return true;
        }else{
            return false;
        }
    }

    /**
     * index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::where('title','!=','admin')->where([['title','!=','user']])->get();
        $modules = Module::get();
        $listChecked = [];
        $counterRole = 0;
        $arrRole = [];
        if(is_array($modules) && count($modules)) {
            foreach($modules as $module) {
                foreach ($module->permission as $value){
                    foreach ($roles as $role) {
                        $counterRole++;
                        $arrRole[] = $role->id;
                        if($this->check($role->id,$value->id)) {
                            $listChecked[$role->id][$value->id] = 'checked';
                        }else{
                            $listChecked[$role->id][$value->id] = 'unchecked';
                        }
                    }
                }
            }
        }

        return view('admin.permission.index',compact('roles','modules','listChecked'));
    }

    /**
     * update
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function  update(Request $request){
        //dd($request->all());
        $per=PermissionRole::get();
        foreach ($per as $value){
            $value->delete();
        }
        foreach ($request->all() as $key=>$value){
            if($key=='_method' || $key=='_token') continue;
            $arr=explode('-',$key);
            PermissionRole::create(['role_id'=>$arr[0],'permission_id'=>$arr[1]]);
        }
        // PermissionRole::insert(['role_id'=>'1','permission_id'=>'2'],['role_id'=>'2','permission_id'=>'2']);
        return redirect(route('permission.index'))->with(['message'=>'تغییرات با موفقیت انجام شد','type'=>'alert-success']);
    }

}
