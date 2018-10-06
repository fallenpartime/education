<?php
/**
 * 后台用户信息处理
 * Date: 2018/10/4
 * Time: 16:15
 */
namespace Admin\Services\Authority\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\System\AdminUserInfo;

class AdminUserInfoProcessor extends BaseProcessor
{
    protected $tableName = 'admin_user_infos';
    protected $tableClass = AdminUserInfo::class;
}