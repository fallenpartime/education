<?php
/**
 * 通用工具
 * Date: 2018/10/3
 * Time: 23:10
 */
namespace Admin\Component;

class CommonTool
{
    /**
     * 判定是否整数
     * @param $str
     * @return bool
     */
    public static function is_digital($str)
    {
        $len = strlen($str);
        if($len==0) return false;

        $arr = str_split($str);
        for($i =0; $i<$len; $i++) {
            if(ord($arr[$i]) > 0xa0 || !is_numeric($arr[$i]))
                return false;
        }
        return true;
    }
}