<?php
/**
 * 师生交互
 * Date: 2018/10/29
 * Time: 23:19
 */
namespace App\Http\Front\Actions\Interact\Admonition;

use Admin\Models\User\UserAdmonition;
use Front\Actions\BaseAction;

class IndexAction extends BaseAction
{
    protected $userId = 1;

    public function run()
    {
        $list = UserAdmonition::where(['user_id'=>$this->userId, 'is_show'=>1])->select(['content', 'reply_content'])->get();
        $result = [
            'list'  =>  $list,
            'consult_url'   =>  route('front.admonition.consult')
        ];
        return view('front.interact.admonition.index', $result);
    }
}