<?php
/**
 * db工具
 * Date: 2018/10/3
 * Time: 23:31
 */
namespace Admin\Component;

use Illuminate\Support\Facades\DB;

class DBTool
{
    public static function getList($table, $columns, $where, $limit)
    {
        $processor = DB::table($table);
        if (!empty($columns)) {
            $processor = $processor->select($columns);
        }
        if (!empty($where)) {
            foreach ($where as $key => $item) {
                $processor->where($key, $item);
            }
        }
        if (is_array($limit)) {
            $countLimit = count($limit);
            if ($countLimit == 1) {
                $processor = $processor->limit($limit[0]);
            } else if($countLimit == 2) {
                $processor = $processor->offset($limit[0])->limit($limit[1]);
            }
        } else if(!empty($limit)) {
            $processor = $processor->limit($limit);
        }
        return $processor->get();
    }

    public static function getSingle($table, $columns, $where)
    {

        $processor = DB::table($table);
        if (!empty($columns)) {
            $processor = $processor->select($columns);
        }
        if (!empty($where)) {
            foreach ($where as $key => $item) {
                $processor->where($key, $item);
            }
        }
        return $processor->first();
    }
}