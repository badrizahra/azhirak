<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('admin.Layouts.header',function($view){
            $user=Auth::user();
            if($user->img==''){
                $user->img='image/profile.png';
            }
            else{
                $user->img='image/'.$user->id.'/'.$user->img;
            }
            $view->with('user',$user);
        });

        View::composer('site.layouts.rightProfile',function($view){

            $user = Auth::user();
            //seller info
            $seller = Seller::where('user_id',$user->id)->first();


        });

        View::composer('site.layouts.header',function($view){

        });

        View::composer('site.layouts.footer',function($view){

        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
