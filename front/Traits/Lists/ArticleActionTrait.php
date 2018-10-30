<?php
/**
 * 文章列表插件
 * Date: 2018/10/30
 * Time: 9:55
 */
namespace Front\Traits\Lists;

use Admin\Models\Article\Article;
use Admin\Services\Article\ArticleService;
use Frameworks\Tool\Random\HashTool;
use Front\Config\PaginationConfig;

trait ArticleActionTrait
{
    protected $limit = 0;
    protected $page = 1;

    protected function initParams()
    {
        $this->page = 1;
        $this->limit = PaginationConfig::PAGE_SIZE;
        $code = request('code');
        if (empty($code)) {
            return false;
        }
        $hashTool = new HashTool();
        $params = $hashTool->decode($code);
        if (empty($params)) {
            return false;
        }
        if (count($params) >= 2) {
            if ($params[0] > 0) {
                $this->page = intval($params[0]);
            }
            if ($params[1] > 0) {
                $this->limit = intval($params[1]);
            }
        }
    }

    protected function getList()
    {
        $this->initParams();
        $model = $this->pageModel(Article::where(['type'=>$this->type, 'is_show'=>1]), $this->page, $this->limit)->select(['id', 'type', 'title', 'description', 'list_pic'])->orderBy('published_at', 'DESC');
        return $model->get();
    }

    protected function processList()
    {
        $list = [];
        $records = $this->getList();
        $service = new ArticleService();
        if (!$records->isEmpty()) {
            foreach ($records as $item) {
                $unit = [
                    'title' =>  $item->title,
                    'desc'  =>  $item->description,
                    'image' =>  $item->list_pic,
                    'link'  =>  $service->_init($item->id)->getShowUrl($item->type),
                ];
                $list[] = $unit;
            }
        }
        // 分页code
        $code = $service->getHashTool()->encode($this->page + 1, $this->limit);
        if (empty($list)) {
            $this->errorJson(500, '没有更多了');
        }
        $data = [
            'code'  =>  $code,
            'list'  =>  $list,
        ];
        $this->successJson('', $data);
    }
}
