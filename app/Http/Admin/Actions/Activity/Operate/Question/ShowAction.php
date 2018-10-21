<?php
/**
 * 显示状态修改
 * Date: 2018/10/20
 * Time: 21:57
 */
namespace App\Http\Admin\Actions\Activity\Operate\Question;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\ActivityQuestion;
use Admin\Services\Activity\Processor\ActivityQuestionProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class ShowAction extends BaseAction
{
    use ApiActionTrait;

    protected $_question = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_question = ActivityQuestion::find($id);
        }
        if (empty($this->_question)) {
            $this->errorJson(500, '问题不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $showValue = $this->_question->is_show;
        $showValue = ($showValue + 1) % 2;
        $res = (new ActivityQuestionProcessor())->update($this->_question->id, ['is_show'=>$showValue]);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}