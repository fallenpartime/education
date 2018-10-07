<?php
/**
 * 后台分组处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\School\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\School\School;

class SchoolProcessor extends BaseProcessor
{
    protected $tableName = 'schools';
    protected $tableClass = School::class;

    public function getSingleByNo($no, $columns = [])
    {
        if (empty($no)) {
            return '';
        }
        $where = ['no' => $no];
        return $this->getSingle($where, $columns);
    }
}