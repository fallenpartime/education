<?php
/**
 * 后台权限处理
 * Date: 2018/10/4
 * Time: 0:35
 */
namespace Admin\Services\Authority\Processor;

use Admin\Base\Processor\BaseProcessor;
use Admin\Models\System\AdminAction;

class AdminActionProcessor extends BaseProcessor
{
    protected $tableName = "admin_actions";
    protected $tableClass = AdminAction::class;

    public function getSingleByName($name, $columns = [])
    {
        if (empty($name)) {
            return '';
        }
        $where = ['name' => $name];
        return $this->getSingle($where, $columns);
    }

    public function getSingleByAction($action, $columns = [])
    {
        if (empty($action)) {
            return '';
        }
        $where = ['ts_action' => $action];
        return $this->getSingle($where, $columns);
    }
}