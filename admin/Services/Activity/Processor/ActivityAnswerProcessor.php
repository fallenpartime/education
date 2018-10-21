<?php
/**
 * 活动问题答案处理单元
 * Date: 2018/10/16
 * Time: 14:59
 */
namespace Admin\Services\Activity\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\Activity\ActivityAnswer;

class ActivityAnswerProcessor extends BaseProcessor
{
    protected $tableName = 'activity_answers';
    protected $tableClass = ActivityAnswer::class;
}
