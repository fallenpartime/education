<?php
/**
 * 活动action插件
 * Date: 2018/10/30
 * Time: 0:29
 */
namespace Front\Traits;

use Admin\Services\Activity\ActivityService;
use Frameworks\Tool\Random\HashTool;

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

    protected function initActivityByCode()
    {
        $code = request('code');
        if (empty($code)) {
            return false;
        }
        $hashTool = new HashTool();
        $params = $hashTool->decode($code);
        if (empty($params)) {
            return false;
        } else if(count($params) != 1) {
            return false;
        }
        $this->activity = (new ActivityService())->getRecord($params[0]);
        $this->type = $params[1];
    }
}
