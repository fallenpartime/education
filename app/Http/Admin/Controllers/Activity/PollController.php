<?php
/**
 * 网络投票控制器
 * Date: 2018/10/20
 * Time: 22:16
 */
namespace App\Http\Admin\Controllers\Activity;

use App\Http\Admin\Actions\Activity\Poll\IndexAction;
use App\Http\Admin\Actions\Activity\Poll\InfoAction;
use App\Http\Admin\Actions\Activity\Poll\Question\IndexAction as QuestionIndexAction;
use App\Http\Admin\Actions\Activity\Poll\Question\InfoAction as QuestionInfoAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class PollController extends Controller
{

    /**
     * 网络投票活动列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 网络投票活动详情
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new InfoAction($request))->run();
    }

    /**
     * 投票问题列表
     * @param Request $request
     */
    public function questions(Request $request)
    {
        return (new QuestionIndexAction($request))->run();
    }

    /**
     * 投票问题详情
     * @param Request $request
     */
    public function questionInfo(Request $request)
    {
        return (new QuestionInfoAction($request))->run();
    }
}