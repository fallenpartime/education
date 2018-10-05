<?php
/**
 * 角色详情
 * Date: 2018/10/4
 * Time: 16:07
 */
namespace App\Http\Admin\Actions\System\Role;

use Admin\Actions\BaseAction;
use Admin\Traits\ApiActionTrait;

class DetailAction extends BaseAction
{
    use ApiActionTrait;

    protected $_role = null;

    public function run()
    {
        $result = [
            'menu'  =>  ['manageCenter', 'roleManage', 'roleInfo']
        ];
        return $this->createView('admin.system.role.detail', $result);
    }

    protected function showInfo()
    {

    }

    protected function process()
    {

    }
}