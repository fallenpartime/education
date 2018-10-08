<?php
/**
 * 文章操作
 * Date: 2018/10/8
 * Time: 2:06
 */
namespace App\Http\Admin\Controllers\Article;

use App\Http\Admin\Actions\Article\Operate\DetailAction;
use App\Http\Admin\Actions\Article\Operate\InfoAction;
use App\Http\Admin\Actions\Article\Operate\ShowAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class OperateController extends Controller
{
    /**
     * 新闻详情
     * @param Request $request
     */
    public function detail(Request $request)
    {
        return (new DetailAction($request))->run();
    }

    /**
     * 新闻显示状态修改
     * @param Request $request
     */
    public function show(Request $request)
    {
        return (new ShowAction($request))->run();
    }
}