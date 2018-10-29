<?php
/**
 * 文章action插件
 * Date: 2018/10/30
 * Time: 0:13
 */
namespace Front\Traits;

use Admin\Models\Article\Article;
use Admin\Services\Article\ArticleService;

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

    protected function readCounter()
    {
        if (empty($this->article)) {
            return 0;
        }
        $id = array_get($this->article, 'id');
        $result = Article::find($id)->increment('read_count');
        if ($result) {
            $this->getService()->readCounter();
        }
    }
}