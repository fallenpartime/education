<?php
/**
 * 教育新闻列表
 * Date: 2018/10/8
 * Time: 1:58
 */
namespace App\Http\Admin\Actions\Article\News;

use Admin\Actions\BaseAction;
use Admin\Models\Article;
use Admin\Services\Common\CommonService;
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
            $list = $this->pageModel($model, $page, $pageSize)->with('picture')->select(['id', 'type', 'title', 'is_show', 'list_pic', 'created_at', 'published_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['articleCenter', 'newsManage', 'news'],
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route('news'),
        ];
        return $this->createView('admin.article.news.index', $result);
    }

    protected function allowOperate()
    {
        $operateList = [
            'change_show' => 0
        ];
        $operateUrl = [
            'change_url' => ''
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('articleShow')) {
            $operateList['change_show'] = 1;
            $operateUrl['change_url'] = route('articleShow');
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_change' => 0
        ];
        $list[$key]->allow_operate_change = 0;
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('articleNewsInfo')) {
            $operateList['allow_operate_edit'] = 1;
        }
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('articleShow')) {
            $operateList['allow_operate_change'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route('articleNewsInfo', ['work_no'=>1, 'id'=>$item->id]);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }
}
