<?php
/**
 * 投票页面（保存）
 * Date: 2018/10/30
 * Time: 1:51
 */
namespace App\Http\Front\Actions\Activity\Vote;

use Admin\Models\Activity\ActivityQuestion;
use Admin\Services\Activity\Processor\ActivityVoteProcessor;
use Admin\Traits\ApiActionTrait;
use Front\Actions\BaseAction;
use Front\Traits\ActivityActionTrait;

class InfoAction extends BaseAction
{
    use ActivityActionTrait, ApiActionTrait;

    public function run()
    {
        if (!$this->initRecordByCode()) {
            dd(404);
        }
        if ($this->request->isMethod('post')) {
            $this->process();
        }
        $service = $this->getService();
        $code = $service->getCode(array_get($this->record, 'id'), array_get($this->record, 'type'));
        $questions = ActivityQuestion::where(['activity_id'=>array_get($this->record, 'id'), 'is_show'=>1])->with('answers')->get();
        $result = [
            'record'        =>  $this->record,
            'questions'     =>  $questions,
            'vote_url'      =>  route('front.activity.vote', ['code'=>$code]),
        ];
        return view('front.activity.vote.index', $result);
    }

    protected function process()
    {
        $votes = [];
        $answers = $this->request->get('answer');
        $others = $this->request->get('answer_other');
        if (!empty($answers)) {
            foreach ($answers as $answer) {
                list($questionId, $answerId) = explode('-', $answer);
                $unit = [
                    'activity_id'   =>  array_get($this->record, 'id'),
                    'user_id'   =>  1,
                    'type'      =>  0,
                    'question_id'   =>  $questionId,
                    'answer_id'     =>  $answerId,
                ];
                $votes[] = $unit;
            }
        }
        if (!empty($others)) {
            foreach ($others as $questionId => $other) {
                $other = trim($other);
                if (!empty($other)) {
                    $unit = [
                        'activity_id'   =>  array_get($this->record, 'id'),
                        'user_id'   =>  1,
                        'type'      =>  1,
                        'question_id'   =>  $questionId,
                        'other'     =>  $other,
                    ];
                    $votes[] = $unit;
                }
            }
        }
        if (!empty($votes)) {
            $processor = new ActivityVoteProcessor();
            foreach ($votes as $vote) {
                $processor->insert($vote);
            }
        }
        $thankUrl = '';
        $this->successJson('', ['url'=>$thankUrl]);
    }
}
