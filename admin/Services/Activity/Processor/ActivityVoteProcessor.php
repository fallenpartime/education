<?php
/**
 * 活动投票处理单元
 * Date: 2018/10/16
 * Time: 14:59
 */
namespace Admin\Services\Activity;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\Activity\ActivityVote;

class ActivityVoteProcessor extends BaseProcessor
{
    protected $tableName = 'activity_votes';
    protected $tableClass = ActivityVote::class;
}
