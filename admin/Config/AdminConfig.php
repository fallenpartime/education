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
            '2'  => '编辑文章',
            '3'  => '作废文章',
            '4'  => '文章显示状态修改',
            '20' => '添加活动',
            '21' => '编辑活动',
            '22' => '活动开放状态修改',
            '23' => '活动作废',
            '24' => '活动显示状态修改',
            '40' => '添加问题',
            '41' => '编辑问题',
            '42' => '作废问题',
            '43' => '问题显示状态修改',
            '50' => '用户意见作废',
            '51' => '用户意见答复',
            '52' => '用户意见显示状态修改',
        ];
    }
}
