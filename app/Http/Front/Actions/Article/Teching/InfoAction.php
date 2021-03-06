<?php
/**
 * 教研活动详情
 * Date: 2018/10/30
 * Time: 0:05
 */
namespace App\Http\Front\Actions\Article\Teching;

use Front\Actions\BaseAction;
use Front\Traits\ArticleActionTrait;
use Front\Traits\ErrorActionTrait;

class InfoAction extends BaseAction
{
    use ArticleActionTrait, ErrorActionTrait;

    protected $type = 4;

    public function run()
    {
        if (!$this->initRecordByCode()) {
            return $this->errorArticleRedirect('文章不见啦');
        }
        $this->getService()->readCounter();
        $result = [
            'record'        =>  $this->record,
            'like_url'      =>  $this->likeUrl,
        ];
        return view('front.article.teching.info', $result);
    }
}
