<?php
/**
 * 选项控制器
 * Date: 2018/10/20
 * Time: 22:32
 */
namespace App\Http\Admin\Controllers\Activity;

use App\Http\Admin\Actions\Activity\Question\IndexAction;
use App\Http\Admin\Actions\Activity\Question\InfoAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    /**
     * 投票问题列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 投票问题详情
     * @param Request $request
     */
    public function info(Request $request)
    {
        return (new InfoAction($request))->run();
    }
}