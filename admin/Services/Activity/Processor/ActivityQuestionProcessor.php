<?php
/**
 * 活动问题处理单元
 * Date: 2018/10/16
 * Time: 14:59
 */
namespace Admin\Services\Activity;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\Activity\ActivityQuestion;

class ActivityQuestionProcessor extends BaseProcessor
{
    protected $tableName = 'activity_questions';
    protected $tableClass = ActivityQuestion::class;
}
