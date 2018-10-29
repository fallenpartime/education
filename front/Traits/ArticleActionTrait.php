<?php
/**
 * 文章action插件
 * Date: 2018/10/30
 * Time: 0:13
 */
namespace Front\Traits;

use Admin\Services\Article\ArticleService;
use Vinkla\Hashids\Facades\Hashids;

trait ArticleActionTrait
{
    protected $article = null;
    protected $type = 0;
    protected $articleService = null;

    protected function getService()
    {
        if (empty($this->article)) {
            $this->articleService = new ArticleService();
        } else {
            $this->articleService = new ArticleService(array_get($this->article, 'id'));
        }
        return $this->articleService;
    }

    protected function initArticleByCode()
    {
        $code = request('code');
        $params = Hashids::decode($code);
        if (empty($params)) {
            return false;
        } else if(count($params) != 1) {
            return false;
        }
        $this->article = (new ArticleService())->getRecord($params[0]);
    }
}