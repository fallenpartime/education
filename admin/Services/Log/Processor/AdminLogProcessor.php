<?php
/**
 * 系统日志
 * Date: 2018/10/23
 * Time: 15:17
 */
namespace Admin\Services\Log\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\System\AdminLog;

class AdminLogProcessor extends BaseProcessor
{
    protected $tableName = 'admin_logs';
    protected $tableClass = AdminLog::class;
}
