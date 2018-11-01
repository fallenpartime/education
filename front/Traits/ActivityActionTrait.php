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
    protected $articleService = null;
    protected $likeUrl = '';

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
        if (isset($this->type) && $this->type > 0) {
            if ($this->type != intval($params[1])) {
                return false;
            }
        }
        $this->record = $service->getRecord($params[0]);
        if (!empty($this->record)) {
            $service = $this->getService();
            $this->likeUrl = route('front.activity.like', ['code'=>$service->getCode(array_get($this->record, 'id'), array_get($this->record, 'type'))]);
            return true;
        }
        return false;
    }
}