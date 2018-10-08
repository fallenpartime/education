<?php
/**
 * 教育新闻文章列表
 * Date: 2018/10/8
 * Time: 2:19
 */
namespace Admin\Services\Sql\Article;

use Admin\Base\Processor\BaseSqlProcessor;
use Admin\Services\Sql\BaseSqlDelegation;

class NewsSqlProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        $model = $model->where('type', 1);
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}
