<?php
/**
 * 后台用户处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Authority\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\System\AdminUser;

class AdminUserProcessor extends BaseProcessor
{
    protected $tableName = 'admin_users';
    protected $tableClass = AdminUser::class;

    public function getSingleByName($name, $columns = [])
    {
        if (empty($name)) {
            return '';
        }
        $where = ['name' => $name];
        return $this->getSingle($where, $columns);
    }
}