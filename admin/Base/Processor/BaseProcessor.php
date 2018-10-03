<?php
/**
 * 基础处理类
 * Date: 2018/10/3
 * Time: 17:48
 */
namespace Admin\Base\Processor;

abstract class BaseProcessor
{
    protected $tableName = '';
    protected $tableClass = null;

    public function getList($where, $fields = '*', $limit = 0)
    {}

    public function getSingle($where, $fields = '*')
    {}

    public function getSingleById($id, $fields = '*')
    {}

    public function store($data)
    {}

    public function remove($condition)
    {}
}