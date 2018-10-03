<?php

namespace App\Http\Admin\Controllers\System;

use App\Http\Admin\Actions\System\Authority\DetailAction;
use App\Http\Admin\Actions\System\Authority\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{

    public function authorities(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    public function authorityInfo(Request $request)
    {
        return (new DetailAction($request))->run();
    }
}
