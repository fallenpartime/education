<?php
/**
 * 后台配置类
 * Date: 2018/10/5
 * Time: 9:53
 */
namespace Admin\Config;

class AdminConfig
{
    public static function indexUrlList()
    {
        return [
            'index'       => ['title'=>'入口', 'url'=>''],
        ];
    }

    public static function getIndexUrl($indexTag, $columnName = 'url')
    {
        $indexUrls = self::indexUrlList();
        if (empty($indexTag)) {
            $indexTag = 'index';
        }
        if (!array_key_exists($indexTag, $indexUrls)) {
            $indexTag = 'index';
        }
        return $indexUrls[$indexTag][$columnName];
    }
}