<?php
/**
 * 投票详情页
 * Date: 2018/10/30
 * Time: 1:49
 */
namespace App\Http\Front\Actions\Activity\Poll;

use Front\Actions\BaseAction;
use Front\Traits\ActivityActionTrait;

class InfoAction extends BaseAction
{
    use ActivityActionTrait;

    protected $type = 1;

    public function run()
    {
        if (!$this->initRecordByCode()) {
            dd(404);
        }
        $this->getService()->readCounter();
        $result = [
            'record'        =>  $this->record,
            'like_url'      =>  '',
            'vote_url'      =>  '',
        ];
        return view('front.activity.poll.info', $result);
    }
}
