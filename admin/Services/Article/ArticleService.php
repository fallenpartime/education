<?php
/**
 * 文章服务
 * Date: 2018/10/29
 * Time: 9:30
 */
namespace Admin\Services\Article;

use Admin\Config\ArticleConfig;
use Admin\Models\Article\Article;
use Illuminate\Support\Facades\Redis;

class ArticleService
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
        return ArticleConfig::getCacheKeyword($id);
    }

    /**
     * 获取文章缓存记录
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
     * 设置文章缓存信息
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
     * 文章缓存作废
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

    /**
     * 阅读计数器
     */
    public function readCounter()
    {
        $id = intval($this->id);
        if ($id <= 0) {
            return false;
        }
        $result = Article::find($id)->increment('read_count');
        if ($result) {
            $cacheKeyword = $this->cacheKeyword($id);
            Redis::hincrby($cacheKeyword, 'read_count', 1);
        }
        return true;
    }

    /**
     * 点赞计数器
     */
    public function likeCounter()
    {
        $id = intval($this->id);
        if ($id <= 0) {
            return false;
        }
        $cacheKeyword = $this->cacheKeyword($id);
        return Redis::hincrby($cacheKeyword, 'like_count', 1);
    }
}
