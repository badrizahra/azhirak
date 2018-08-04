<?php
/**
 * Author: Badri
 * Date: 7/30/2018
 * Time: 4:36 PM
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class UserController extends Controller {

    public function index() {
        $title = 'لیست کاربران';

        return view('admin/user/index',compact('title'));
    }
}

