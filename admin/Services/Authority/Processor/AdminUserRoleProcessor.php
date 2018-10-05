<?php
/**
 * 后台角色处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Authority\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\System\AdminUserRole;

class AdminUserRoleProcessor extends BaseProcessor
{
    protected $tableName = 'admin_user_roles';
    protected $tableClass = AdminUserRole::class;
}