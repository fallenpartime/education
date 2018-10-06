<?php
/**
 * 角色详情
 * Date: 2018/10/4
 * Time: 16:07
 */
namespace App\Http\Admin\Actions\System\Role;

use Admin\Actions\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Models\System\AdminUserGroup;
use Admin\Models\System\AdminUserRole;
use Admin\Models\System\AdminUserRoleAccess;
use Admin\Services\Authority\AuthorityService;
use Admin\Services\Authority\Integration\RelateAuthoritiesCheckedIntegration;
use Admin\Services\Authority\Processor\AdminUserGroupProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleAccessProcessor;
use Admin\Services\Authority\Processor\AdminUserRoleProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class DetailAction extends BaseAction
{
    use ApiActionTrait;

    protected $_role = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_role = AdminUserRole::find($id);
        }
        if ($workNo == 1 || $workNo == 2 || $workNo == 3) {
            if ($workNo == 1) {
                return $this->showInfo();
            } else if($workNo == 2) {
                $this->process();
            } else {
                $this->showGroupAuthority();
            }
        }
        $this->errorJson(500, '请求类型不匹配');
    }

    protected function showInfo()
    {
        $service = new AuthorityService();
        $roleMenus = $service->relateMenu();
        $groupMenus = $service->relateMenu();
        $indexUrls = AdminConfig::indexUrlList();
        $result = [
            'record'            =>  $this->_role,
            'roles'             =>  AdminUserRole::all(),
            'groups'            =>  $this->getAccess(),
            'authorities'       =>  $this->parseRoleMenu($roleMenus),
            'groupAuthorities'  =>  $this->parseGroupMenu($groupMenus),
            'indexUrls'         => $indexUrls,
            'menu'  =>  ['manageCenter', 'roleManage', 'roleInfo'],
            'actionUrl'         => route('roleInfo', ['work_no'=>2]),
            'redirectUrl'       => route('roles'),
            'groupAuthorityUrl' => route('roleInfo', ['work_no'=>3]),
        ];
        return $this->createView('admin.system.role.detail', $result);
    }

    protected function getAccess()
    {
        $groupList = [];
        $groups = AdminUserGroup::all();
        if (!empty($groups)) {
            foreach ($groups as $group) {
                $groupNo = $group->group_no;
                $groupList[$groupNo] = ['model'=>$group, 'access'=>null];
            }
        }
        if (!empty($this->_role)) {
            $accesses = $this->_role->accesses;
            if (!empty($accesses)) {
                foreach ($accesses as $access) {
                    $groupNo = $access->group_no;
                    $groupList[$groupNo]['access'] = $access;
                }
            }
        }
        return $groupList;
    }

    protected function parseRoleMenu($menus)
    {
        if (!empty($this->_role)) {
            $roleActions = !empty($this->_role->actions)? json_decode($this->_role->actions, true): [];
            list($status, $count, $menus) = (new RelateAuthoritiesCheckedIntegration($menus, $roleActions))->process();
        }
        return $menus;
    }

    protected function parseGroupMenu($menus)
    {
        $groupActions = [];
        if (!empty($this->_role)) {
            $accesses = $this->_role->accesses;
            if (!empty($accesses)) {
                foreach ($accesses as $access) {
                    $groupActionList = [];
                    $group = $access->group;
                    if (!empty($group) && !empty($group->actions)) {
                        $groupActionList = json_decode($group->actions, true);
                    }
                    $groupActions = array_merge($groupActions, $groupActionList);
                }
            }
            if (!empty($groupActions)) {
                $groupActions = array_unique($groupActions);
                list($status, $count, $menus) = (new RelateAuthoritiesCheckedIntegration($menus, $groupActions))->process();
            }
        }
        return $menus;
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $roleNo = $httpTool->getBothSafeParam('no', HttpConfig::PARAM_NUMBER_TYPE);
        $name = $httpTool->getBothSafeParam('name');
        $name = trim($name);
        $indexUrl = $httpTool->getBothSafeParam('indexurl');
        $indexUrl = trim($indexUrl);
        if (empty($roleNo)) {
            $this->errorJson(500, '角色编号为空');
        }
        if (empty($name)) {
            $this->errorJson(500, '分组名为空');
        }
        if (!empty($id) && empty($this->_role)) {
            $this->errorJson(500, '记录不存在');
        }
        $data = [
            'role_no'   =>  $roleNo,
            'name'      =>  $name,
            'index_action'  =>  !empty($indexUrl)? $indexUrl: null,
            'actions'   =>  $this->getActionJson(),
        ];
        list($res, $id) = empty($id)? $this->store($data): $this->update($data);
        $this->storeAccess($id);
        $this->successJson();
    }

    protected function getActionJson()
    {
        $actions = $this->request->get('auth_checked');
        if (empty($actions)) {
            return null;
        }
        return json_encode(array_unique($actions));
    }

    protected function storeAccess($roleNo)
    {
        if (!empty($roleNo)) {
            AdminUserRoleAccess::where('role_no', $roleNo)->delete();
            $groups = AdminUserGroup::all();
            if (empty($groups)) {
                return false;
            }
            $processor = new AdminUserRoleAccessProcessor();
            foreach ($groups as $group) {
                $groupNo = $this->request->get("{$group->tip}");
                $isLeader = $this->request->get("{$group->tip}_leader");
                $isLeader = !empty($isLeader)? 1: 0;
                $leaderNo = $this->request->get("{$group->tip}_leader_no");
                if ($groupNo > 0) {
                    if ($isLeader > 0) {
                        $leaderNo = 0;
                    }
                    $data = [
                        'group_no'  =>  $groupNo,
                        'role_no'   =>  $roleNo,
                        'leader_no' =>  $leaderNo,
                        'is_leader' =>  $isLeader,
                    ];
                    $processor->insert($data);
                }
            }
        }
    }

    protected function store($data)
    {
        list($res, $model) = (new AdminUserRoleProcessor())->insert($data);
        $insertId = $res? $model->id: 0;
        return [$res, $insertId];
    }

    protected function update($data)
    {
        return (new AdminUserRoleProcessor())->update($this->_role->id, $data);
    }

    protected function showGroupAuthority()
    {
        $httpTool = $this->getHttpTool();
        $data = ['list'=>[]];
        $groupId = $httpTool->getBothSafeParam('group_id', HttpConfig::PARAM_NUMBER_TYPE);
        if ($groupId > 0) {
            $group = (new AdminUserGroupProcessor())->getSingleByNo($groupId);
            if (!empty($group) && !empty($group->actions)) {
                $data['list'] = json_decode($group->actions);
            }
        }
        $this->successJson('', $data);
    }
}