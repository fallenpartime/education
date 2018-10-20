<?php
/**
 * 活动配置
 * Date: 2018/10/8
 * Time: 2:41
 */
namespace Admin\Config;

class ActivityConfig
{
    const POLL_TYPE = 1;

    public static function getTypeList()
    {
        return [
            static::POLL_TYPE       =>  ['type' =>  static::POLL_TYPE, 'title'  =>  '网络投票活动'],
        ];
    }
}