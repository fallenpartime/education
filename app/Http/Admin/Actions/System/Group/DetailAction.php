<?php
/**
 * 分组详情
 * Date: 2018/10/4
 * Time: 9:18
 */
namespace App\Http\Admin\Actions\System\Group;

use Admin\Actions\BaseAction;
use Admin\Models\System\AdminUserGroup;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class DetailAction extends BaseAction
{
    use ApiActionTrait;

    protected $_group = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_group = AdminUserGroup::find($id);
        }
        if ($workNo == 1 || $workNo == 2) {
            if ($workNo == 1) {
                return $this->showInfo();
            } else {
                $this->process();
            }
        }
        $this->errorJson(500, '请求类型不匹配');
    }

    protected function showInfo()
    {
        $result = [
            'record'        => $this->_group,
            'menu'  =>  ['manageCenter', 'groupManage', 'groupInfo'],
            'actionUrl'     => route('groupInfo', ['work_no'=>2]),
            'redirectUrl'   => route('groups'),
        ];
        return $this->createView('admin.system.group.detail', $result);
    }

    protected function process()
    {

    }
}