<?php
/**
 * 活动处理单元
 * Date: 2018/10/16
 * Time: 14:59
 */
namespace Admin\Services\Activity\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\Activity\Activity;

class ActivityProcessor extends BaseProcessor
{
    protected $tableName = 'activities';
    protected $tableClass = Activity::class;
}
