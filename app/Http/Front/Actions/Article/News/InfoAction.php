<?php
/**
 * 教育快讯详情
 * Date: 2018/10/30
 * Time: 0:05
 */
namespace App\Http\Front\Actions\Article\News;

use Front\Actions\BaseAction;
use Front\Traits\ArticleActionTrait;

class InfoAction extends BaseAction
{
    use ArticleActionTrait;

    protected $type = 1;

    public function run()
    {
        if (!$this->initRecordByCode()) {
            dd(404);
        }
        $service = $this->getService();
        $service->readCounter();
        $likeUrl = route('front.article.like', ['code'=>$service->getCode(array_get($this->record, 'id'))]);
        $result = [
            'record'        =>  $this->record,
            'like_url'      =>  $likeUrl,
        ];
        return view('front.article.news.info', $result);
    }
}
