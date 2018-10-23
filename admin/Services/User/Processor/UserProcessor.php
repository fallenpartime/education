<?php
/**
 * 用户信息处理
 * Date: 2018/10/23
 * Time: 10:29
 */
namespace Admin\Services\User\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\User\User;

class UserProcessor extends BaseProcessor
{
    protected $tableName = 'users';
    protected $tableClass = User::class;
}
