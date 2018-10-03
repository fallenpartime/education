<?php
/**
 * 基础处理类
 * Date: 2018/10/3
 * Time: 17:48
 */
namespace Admin\Base\Processor;

use Admin\Component\DBTool;

abstract class BaseProcessor
{
    protected $tableName = '';
    protected $tableClass = null;

    public function getList($where, $columns = [], $limit = [])
    {
        return DBTool::getList($this->tableName, $columns, $where, $limit);
    }

    public function getSingle($where, $columns = [])
    {
        return DBTool::getSingle($this->tableName, $columns, $where);
    }

    public function getSingleById($id, $columns = [])
    {
        if (empty($id)) {
            return '';
        }
        $where = ['id' => $id];
        return $this->getSingle($where, $columns);
    }

    public function store($data)
    {
        $model = new $this->tableClass;
        foreach ($data as $dname => $datum) {
            $model->$dname = $datum;
        }
        return $model->save();
    }

    public function remove($condition)
    {}
}