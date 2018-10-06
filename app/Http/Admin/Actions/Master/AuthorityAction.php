<?php
/**
 * 用户权限
 * Date: 2018/10/6
 * Time: 0:47
 */
namespace App\Http\Admin\Actions\Master;

use Admin\Actions\BaseAction;
use Admin\Models\System\AdminUserInfo;
use Admin\Services\Authority\AuthorityService;
use Admin\Services\Authority\Integration\RelateAuthoritiesCheckedIntegration;
use Admin\Services\Authority\Processor\AdminUserActionProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class AuthorityAction extends BaseAction
{
    use ApiActionTrait;

    protected $_user = null;
    protected $_owner = null;
    protected $_role = null;
    protected $_userAction = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_owner = AdminUserInfo::find($id);
            if (!empty($this->_owner)) {
                $this->_user = $this->_owner->user;
                $this->_role = $this->_owner->role;
                $this->_userAction = $this->_owner->userAction;
            }
        }
        if ($workNo == 1 || $workNo == 2) {
            if ($workNo == 1) {
                if (empty($this->_owner)) {
                    header('Location: '.route('owners'));
                }
                return $this->showInfo();
            } else {
                $this->process();
            }
        }
        $this->errorJson(500, '请求类型不匹配');
    }

    protected function showInfo()
    {
        $service = new AuthorityService();
        $authorities = $service->relateMenu();
        $authorities = $this->parseUserMenu($authorities);
        $result = [
            'record'            =>  $this->_owner,
            'user'              =>  $this->_user,
            'authorities'       =>  $authorities,
            'menu'  =>  ['manageCenter', 'ownerManage', 'ownerAuthority'],
            'actionUrl'         => route('ownerAuthority', ['work_no'=>2]),
            'redirectUrl'       => route('owners'),
        ];
        return $this->createView('admin.system.owner.authority', $result);
    }

    protected function getUserActions()
    {
        $userActionList = array_merge($this->getGroupActions(), $this->getRoleActions());
        $userActionList = array_unique($userActionList);
        $userAction = $this->_userAction;
        if (!empty($userAction) && !empty($userAction->actions)) {
            $actionList = json_decode($userAction->actions, true);
            $allowList = array_get($actionList, 'allow');
            $banList = array_get($actionList, 'ban');
            if (!empty($allowList)) {
                $userActionList = array_merge($userActionList, $allowList);
            }
            if (!empty($banList)) {
                foreach ($banList as $item) {
                    $pos = array_search($item, $userActionList);
                    if ($pos === false) {
                        continue;
                    }
                    unset($userActionList[$pos]);
                }
            }
        }
        $userActionList = array_unique($userActionList);
        return $userActionList;
    }

    protected function parseUserMenu($menus)
    {
        $userActions = $this->getUserActions();
        if (!empty($userActions)) {
            list($status, $count, $menus) = (new RelateAuthoritiesCheckedIntegration($menus, $userActions))->process();
        }
        return $menus;
    }

    protected function getRoleActions()
    {
        $roleActions = [];
        if (!empty($this->_role) && !empty($this->_role->actions)) {
            $roleActions = json_decode($this->_role->actions, true);
        }
        return $roleActions;
    }

    protected function getGroupActions()
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
        }
        $groupActions = array_unique($groupActions);
        return $groupActions;
    }

    protected function process()
    {
        $authList = $this->request->get('auth_checked');
        if (empty($authList)) {
            $this->errorJson(500, '权限为空');
        }
        $originalList = array_merge($this->getGroupActions(), $this->getRoleActions());
        $originalList = array_unique($originalList);
        $allowList = array_diff($authList, $originalList);
        $banList = array_diff($originalList, $authList);
        $data = [
            'user_id'   =>  $this->_owner->user_id,
            'actions'   =>  null,
        ];
        if (!empty($allowList) || !empty($banList)) {
            $allowList = array_values($allowList);
            $banList = array_values($banList);
            $actions = ['allow'=>!empty($allowList)? $allowList: [], 'ban'=>!empty($banList)? $banList: []];
            $data['actions'] = json_encode($actions);
        }
        list($res, $userAid) = empty($this->_userAction)? $this->store($data): $this->update($data);
        $this->successJson();
    }

    protected function store($data)
    {
        list($res, $model) = (new AdminUserActionProcessor())->insert($data);
        $insertId = $res? $model->id: 0;
        return [$res, $insertId];
    }

    protected function update($data)
    {
        return (new AdminUserActionProcessor())->update($this->_userAction->id, $data);
    }
}