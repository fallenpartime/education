<?php
/**
 * 学校学区
 * Date: 2018/10/7
 * Time: 20:05
 */
namespace Admin\Services\Sql\School;

use Admin\Base\Processor\BaseSqlProcessor;
use Admin\Services\Sql\BaseSqlDelegation;

class SchoolDistrictProcessor extends BaseSqlProcessor implements BaseSqlDelegation
{
    public function getListSql($model, $params, $url, $options = [])
    {
        $urlParams = ['search'=>'search'];
        $url .= '?'.implode('&', $urlParams);
        return [$model, $urlParams, $url];
    }
}