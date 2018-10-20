<?php
/**
 * 教研活动
 * Date: 2018/10/8
 * Time: 1:58
 */
namespace App\Http\Admin\Actions\Article\Teching;

use Admin\Actions\BaseAction;
use Admin\Models\Article;
use Admin\Services\Common\CommonService;
use Admin\Services\Sql\Article\TechingSqlProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('techings');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new TechingSqlProcessor())->getListSql(new Article(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('picture')->select(['id', 'type', 'title', 'is_show', 'read_count', 'like_count', 'list_pic', 'created_at', 'published_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['articleCenter', 'techingManage', 'techings'],
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route('techings'),
        ];
        return $this->createView('admin.article.teching.index', $result);
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
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('articleTechingInfo')) {
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
            $list[$key]->edit_url = route('articleTechingInfo', ['work_no'=>1, 'id'=>$item->id]);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }
}
