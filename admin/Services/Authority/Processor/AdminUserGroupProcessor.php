<?php
/**
 * 后台分组处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Authority\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\System\AdminUserGroup;

class AdminUserGroupProcessor extends BaseProcessor
{
    protected $tableName = 'admin_user_groups';
    protected $tableClass = AdminUserGroup::class;

    public function getSingleByNo($groupNo, $columns = [])
    {
        if (empty($groupNo)) {
            return '';
        }
        $where = ['group_no' => $groupNo];
        return $this->getSingle($where, $columns);
    }
}