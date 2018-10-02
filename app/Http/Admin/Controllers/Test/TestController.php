<?php

namespace App\Http\Admin\Controllers\Test;

use App\Http\Admin\Actions\Test\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request) {
        return (new IndexAction($request))->run();
    }
}
