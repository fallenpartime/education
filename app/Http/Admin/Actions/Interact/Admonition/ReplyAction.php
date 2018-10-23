<?php
/**
 * 用户意见回复
 * Date: 2018/10/22
 * Time: 3:46
 */
namespace App\Http\Admin\Actions\Interact\Admonition;

use Admin\Actions\BaseAction;
use Admin\Models\User\UserAdmonition;
use Admin\Services\User\Processor\UserAdmonitionProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class ReplyAction extends BaseAction
{
    use ApiActionTrait;

    protected $_admonition = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_admonition = UserAdmonition::find($id);
        }
        if (empty($this->_admonition)) {
            $this->errorJson(500, '用户意见不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $content = $httpTool->getBothSafeParam('content', HttpConfig::PARAM_TEXT_TYPE);
        if (empty($content)) {
            $this->errorJson(500, '答复内容为空');
        }
        $authService = $this->getAuthService();
        $adminInfo = $authService->getAdminInfo();
        $res = (new UserAdmonitionProcessor())->update($this->_admonition->id, [
            'reply_content'     =>  $content,
            'reply_at'          =>  date('Y-m-d H:i:s'),
            'reply_owner'       =>  $adminInfo['username'],
            'reply_userid'      =>  $adminInfo['userid'],
        ]);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
