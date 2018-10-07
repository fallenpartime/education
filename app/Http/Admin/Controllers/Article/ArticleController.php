<?php
/**
 * 文章列表
 * Date: 2018/10/8
 * Time: 2:06
 */
namespace App\Http\Admin\Controllers\Article;

use App\Http\Admin\Actions\Article\News\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * 教育新闻
     * @param Request $request
     */
    public function news(Request $request)
    {
        return (new IndexAction($request))->run();
    }
}