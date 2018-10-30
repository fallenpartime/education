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
    protected $record = null;
    protected $type = 0;
    protected $articleService = null;

    protected function getService()
    {
        if (empty($this->articleService)) {
            $this->articleService = new ActivityService();
        }
        if (!empty($this->record)) {
            $this->articleService = $this->articleService->_init(array_get($this->record, 'id'));
        }
        return $this->articleService;
    }

    protected function initRecordByCode()
    {
        $code = request('code');
        if (empty($code)) {
            return false;
        }
        $service = $this->getService();
        $params = $service->getHashTool()->decode($code);
        if (empty($params)) {
            return false;
        } else if(count($params) < 2) {
            return false;
        }
        if ($this->type == intval($params[1])) {
            return false;
        }
        $this->record = $service->getRecord($params[0]);
        if (!empty($this->record)) {
            return true;
        }
        return false;
    }
}
