<?php
/**
 * 分组详情
 * Date: 2018/10/4
 * Time: 9:18
 */
namespace App\Http\Admin\Actions\System\Group;

use Admin\Actions\BaseAction;
use Admin\Models\System\AdminUserGroup;
use Admin\Services\Authority\AuthorityService;
use Admin\Services\Authority\Integration\RelateAuthoritiesCheckedIntegration;
use Admin\Services\Authority\Processor\AdminUserGroupProcessor;
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
            'authorities'   => $this->getAuthorities(),
            'menu'  =>  ['manageCenter', 'groupManage', 'groupInfo'],
            'actionUrl'     => route('groupInfo', ['work_no'=>2]),
            'redirectUrl'   => route('groups'),
        ];
        return $this->createView('admin.system.group.detail', $result);
    }

    protected function getAuthorities()
    {
        $service = new AuthorityService();
        $menus = $service->relateMenu();
        if (!empty($this->_group)) {
            $groupActions = !empty($this->_group->actions)? json_decode($this->_group->actions, true): [];
            list($status, $count, $menus) = (new RelateAuthoritiesCheckedIntegration($menus, $groupActions))->process();
        }
        return $menus;
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $groupNo = $httpTool->getBothSafeParam('group_no', HttpConfig::PARAM_NUMBER_TYPE);
        $name = $httpTool->getBothSafeParam('name');
        $name = trim($name);
        $tip = $httpTool->getBothSafeParam('tip');
        $tip = trim($tip);
        if(empty($groupNo)){
            $this->errorJson(500, '分组编号为空');
        }
        if(empty($name)){
            $this->errorJson(500, '分组名为空');
        }
        if(empty($tip)){
            $this->errorJson(500, '分组Tip为空');
        }
        if (!empty($id) && empty($this->_group)) {
            $this->errorJson(500, '记录不存在');
        }
        $data = [
            'group_no'  =>  $groupNo,
            'name'      =>  $name,
            'tip'       =>  $tip,
            'actions'   =>  $this->getActionJson(),
        ];
        list($res, $id) = empty($id)? $this->store($data): $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function getActionJson()
    {
        $actions = $this->request->get('auth_checked');
        if (empty($actions)) {
            return null;
        }
        return json_encode(array_unique($actions));
    }

    protected function store($data)
    {
        list($res, $model) = (new AdminUserGroupProcessor())->insert($data);
        $insertId = $res? $model->id: 0;
        return [$res, $insertId];
    }

    protected function update($data)
    {
        return (new AdminUserGroupProcessor())->update($this->_group->id, $data);
    }
}