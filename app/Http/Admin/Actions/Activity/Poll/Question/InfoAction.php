<?php
/**
 * 网络投票活动详情
 * Date: 2018/10/20
 * Time: 22:18
 */
namespace App\Http\Admin\Actions\Activity\Poll\Question;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\Activity;
use Admin\Models\Activity\ActivityQuestion;
use Admin\Services\Activity\Processor\ActivityQuestionProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class InfoAction extends BaseAction
{
    use ApiActionTrait;

    protected $_question = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_question = ActivityQuestion::find($id);
        }
        if ($workNo == 1 || $workNo == 2) {
            if ($workNo == 1) {
                return $this->showInfo();
            } else {
                $this->process();
            }
        }
        $this->errorJson(500, '请求类型不匹配');
    }

    protected function showInfo()
    {
        $httpTool = $this->getHttpTool();
        $activityId = $httpTool->getBothSafeParam('activity_id', HttpConfig::PARAM_NUMBER_TYPE);
        $result = [
            'record'            =>  $this->_question,
            'activityId'        =>  !empty($this->_question)? $this->_question->activity_id: $activityId,
            'articleType'       =>  1,
            'menu'              => ['activityCenter', 'pollManage', 'activityPollQuestionInfo'],
            'actionUrl'         => route('activityPollQuestionInfo', ['work_no'=>2]),
        ];
        return $this->createView('admin.activity.poll.question.info', $result);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $activityId = $httpTool->getBothSafeParam('activity_id', HttpConfig::PARAM_NUMBER_TYPE);
        $isCheckbox = $httpTool->getBothSafeParam('is_checkbox', HttpConfig::PARAM_NUMBER_TYPE);
        $type = $httpTool->getBothSafeParam('type', HttpConfig::PARAM_NUMBER_TYPE);
        $title = $httpTool->getBothSafeParam('title');
        $picPreview = $this->request->get('list_pic_preview');
        $source = !empty($picPreview)?  $picPreview[0]: '';
        $title = trim($title);
        if (empty($activityId)) {
            $this->errorJson(500, '活动ID不能为空');
        }
        $activity = Activity::find($activityId);
        if (empty($activity)) {
            $this->errorJson(500, '活动不存在');
        }
        if (empty($title) && empty($source)) {
            $this->errorJson(500, '标题与图片不能同时为空');
        }
        if (!empty($id) && empty($this->_question)) {
            $this->errorJson(500, '问题不存在');
        }
        $data = [
            'activity_id'   =>  $activityId,
            'type'      =>  $type,
            'title'     =>  $title,
            'source'    =>  $source,
            'is_checkbox'   =>  !empty($isCheckbox)? $isCheckbox: 0,
        ];
        $res = empty($this->_question)? $this->save($data): $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new ActivityQuestionProcessor();
        list($status, $question) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '问题创建失败');
        }
        $this->successJson();
    }

    protected function update($data)
    {
        $processor = new ActivityQuestionProcessor();
        list($status, $id) = $processor->update($this->_question->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '问题修改失败');
        }
        $this->successJson();
    }
}
