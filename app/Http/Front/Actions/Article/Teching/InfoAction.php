<?php
/**
 * 教研活动详情
 * Date: 2018/10/30
 * Time: 0:05
 */
namespace App\Http\Front\Actions\Article\Teching;

use Front\Actions\BaseAction;
use Front\Traits\ArticleActionTrait;

class InfoAction extends BaseAction
{
    use ArticleActionTrait;

    protected $type = 4;

    public function run()
    {
        if (!$this->initRecordByCode()) {
            dd(404);
        }
        $this->getService()->readCounter();
        $result = [
            'record'        =>  $this->record,
            'like_url'      =>  $this->likeUrl,
        ];
        return view('front.article.teching.info', $result);
    }
}
