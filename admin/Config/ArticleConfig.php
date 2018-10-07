<?php
/**
 * 文章配置
 * Date: 2018/10/8
 * Time: 2:41
 */
namespace Admin\Config;

class ArticleConfig
{
    const NEWS_TYPE = 1;
    const SOUND_TYPE = 2;

    public static function getTypeList()
    {
        return [
            static::NEWS_TYPE       =>  ['type' =>  static::NEWS_TYPE, 'title'  =>  '教育新闻'],
            static::SOUND_TYPE      =>  ['type' =>  static::SOUND_TYPE, 'title'  =>  '教育之声']
        ];
    }
}