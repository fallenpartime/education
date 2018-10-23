<?php
/**
 * 业务日志
 * Date: 2018/10/23
 * Time: 15:17
 */
namespace Admin\Services\Log\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\System\OperateLog;

class OperateLogProcessor extends BaseProcessor
{
    protected $tableName = 'operate_logs';
    protected $tableClass = OperateLog::class;
}
