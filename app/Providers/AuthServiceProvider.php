<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /**
         * input : $data that include controller and method name in the form of string
         * author : badri
         * act :  specifies that user can done this method in this controller
         */
        Gate::define('permission', function ($user, $data) {
            if($user->isSuperAdmin()){
                return true;
            }else{
                $data = explode('-',$data);
                foreach ($data as $value){
                    $arr        = explode('.',$value);
                    $controller = ucwords($arr['0']).'Controller';
                    $action     = $arr[1];
                    $per        = Permission::where(['controller'=>$controller,'action'=>$action])->first();
                    if($per){
                        $perId  = $per->id;
                        $roleId = $user->role_id;
                        $flag   = PermissionRole::where(['role_id'=>$roleId,'permission_id'=>$perId])->first();
                        if($flag){  return true;}
                    }
                }
                return false;
            }

        });
    }
}
