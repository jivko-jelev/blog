<?php
/**
 * Created by PhpStorm.
 * User: blade
 * Date: 2.4.2019 г.
 * Time: 12:10
 */

namespace App\Http\Controllers;


class AdminController
{
    public function index()
    {
        return view('admin.dashboard');
    }

}