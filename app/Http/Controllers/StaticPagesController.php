<?php

namespace App\Http\Controllers;

class StaticPagesController extends Controller
{
    /**
     * 帮助页
     */
    public function help()
    {
        return view('static_pages.help');
    }

    /**
     * 关于页
     */
    public function about()
    {
        return view('static_pages.about');
    }

}
