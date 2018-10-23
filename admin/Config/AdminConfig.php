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
            'index'       => ['title'=>'首页', 'url'=>''],
            'owners'      => ['title'=>'管理员列表', 'url'=>route('owners')],
        ];
    }

    public static function getIndexUrl($indexTag, $columnName = 'url', $withDefault = 1)
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

    public static function getAdminOperateList()
    {
        return [
            '1'  => '添加管理员',
        ];
    }

    public static function getOperateList()
    {
        return [
            '1'  => '添加文章',
        ];
    }
}
