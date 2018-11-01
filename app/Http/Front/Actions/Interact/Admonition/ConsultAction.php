<?php
/**
 * 互动提交
 * Date: 2018/10/30
 * Time: 0:55
 */
namespace App\Http\Front\Actions\Interact\Admonition;

use Admin\Services\User\Processor\UserAdmonitionProcessor;
use Front\Actions\BaseAction;

class ConsultAction extends BaseAction
{
    protected $userId = 1;

    public function run()
    {
        if ($this->request->isMethod('post')) {
            $this->process();
        }
        return view('front.interact.admonition.consult');
    }

    protected function process()
    {
        $redirectUrl = route('front.admonitions');
        $data = [
            'user_id'   =>  $this->userId,
            'name'      =>  $this->request->get('name'),
            'phone'     =>  $this->request->get('phone'),
            'content'   =>  $this->request->get('idea'),
        ];
        (new UserAdmonitionProcessor())->insert($data);
        header("Location: {$redirectUrl}");
        exit();
    }
}