<?php
/**
 * 教育新闻列表
 * Date: 2018/10/8
 * Time: 1:58
 */
namespace App\Http\Admin\Actions\Article\News;

use Admin\Actions\BaseAction;
use Admin\Models\Article;
use Admin\Services\Sql\Article\NewsSqlProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('news');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new NewsSqlProcessor())->getListSql(new Article(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('district')->select(['id', 'type', 'title', 'is_show', 'name', 'address', 'is_show', 'created_at'])->get();
            $list = $this->processList($list);
        }
        
//        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
//        list($operateList, $operateUrl) = $this->allowOperate();
//        $result = [
//            'list'          => $list,
//            'pageList'      => $pageList,
//            'urlParams'     => $urlParams,
//            'menu'          => ['schoolCenter', 'schoolManage', 'schools'],
//            'operateList'   => $operateList,
//            'operateUrl'    => $operateUrl,
//            'redirectUrl'   => route('schools'),
//        ];
        $result = [
            'list'          => [],
            'pageList'      => '',
            'urlParams'     => [],
            'menu'          => ['articleCenter', 'newsManage', 'news'],
            'operateList'   => [],
            'operateUrl'    => [],
            'redirectUrl'   => route('news'),
        ];
        return $this->createView('admin.article.news.index', $result);
    }

    protected function processList($list)
    {

    }
}
