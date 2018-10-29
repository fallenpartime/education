<?php
/**
 * 活动action插件
 * Date: 2018/10/30
 * Time: 0:29
 */
namespace Front\Traits;

use Admin\Services\Activity\ActivityService;

trait ActivityActionTrait
{
    protected $activity = null;
    protected $type = 0;
    protected $activityService = null;

    protected function getService()
    {
        if (empty($this->article)) {
            $this->activityService = new ActivityService();
        } else {
            $this->activityService = new ActivityService(array_get($this->article, 'id'));
        }
        return $this->activityService;
    }
}