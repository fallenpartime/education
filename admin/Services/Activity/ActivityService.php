<?php
/**
 * 活动服务
 * Date: 2018/10/29
 * Time: 9:44
 */
namespace Admin\Services\Activity;

use Admin\Config\ActivityConfig;
use Illuminate\Support\Facades\Redis;

class ActivityService
{
    protected $id = 0;

    public function __construct($id = 0)
    {
        $this->id = $id;
    }

    public function _init($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 获取缓存关键字
     * @param $id
     * @return string
     */
    public function cacheKeyword($id)
    {
        return ActivityConfig::getCacheKeyword($id);
    }

    /**
     * 获取活动缓存记录
     * @return array
     */
    public function getCacheRecord()
    {
        $id = intval($this->id);
        if ($id <= 0) {
            return [];
        }
        $cacheKeyword = $this->cacheKeyword($id);
        return Redis::hgetall($cacheKeyword);
    }

    /**
     * 设置活动缓存信息
     * @param $data
     * @return array
     */
    public function setCacheRecord($data)
    {
        $id = intval($this->id);
        if ($id <= 0) {
            return false;
        }
        $cacheKeyword = $this->cacheKeyword($id);
        return Redis::hmset($cacheKeyword, $data);
    }

    /**
     * 活动缓存作废
     * @return array
     */
    public function removeCacheRecord()
    {
        $id = intval($this->id);
        if ($id <= 0) {
            return false;
        }
        $cacheKeyword = $this->cacheKeyword($id);
        return Redis::del($cacheKeyword);
    }
}
