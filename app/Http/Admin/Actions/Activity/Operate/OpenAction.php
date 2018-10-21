<?php
/**
 * 活动开启状态修改
 * Date: 2018/10/20
 * Time: 21:57
 */
namespace App\Http\Admin\Actions\Activity\Operate;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\Activity;
use Admin\Services\Activity\Processor\ActivityProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class OpenAction extends BaseAction
{
    use ApiActionTrait;

    protected $_activity = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_activity = Activity::find($id);
        }
        if (empty($this->_activity)) {
            $this->errorJson(500, '活动不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $openValue = $this->_activity->is_open;
        if ($openValue == 0) {
            $this->open();
        }
        if ($openValue == 1) {
            $this->close();
        }
        $this->errorJson(500, '操作类型错误');
    }

    protected function open()
    {
        $res = (new ActivityProcessor())->update($this->_activity->id, ['is_open'=>1, 'opened_at'=>date('Y-m-d H:i:s')]);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function close()
    {
        $res = (new ActivityProcessor())->update($this->_activity->id, [ 'overed_at'=>date('Y-m-d H:i:s')]);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}