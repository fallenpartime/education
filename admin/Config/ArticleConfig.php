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
    const EXAM_TYPE = 2;
    const PRACTICE_TYPE = 3;
    const TECH_TYPE = 2;

    public static function getTypeList()
    {
        return [
            static::NEWS_TYPE       =>  ['type' =>  static::NEWS_TYPE, 'title'  =>  '教育新闻'],
            static::EXAM_TYPE       =>  ['type' =>  static::EXAM_TYPE, 'title'  =>  '中高考政策'],
            static::PRACTICE_TYPE   =>  ['type' =>  static::PRACTICE_TYPE, 'title'  =>  '社会实践记录'],
            static::TECH_TYPE       =>  ['type' =>  static::TECH_TYPE, 'title'  =>  '教研活动'],
        ];
    }
}