<?php
/**
 * 管理员权限
 * Date: 2018/10/10
 * Time: 17:48
 */
namespace Admin\Services\Authority\Integration;

use Admin\Base\Processor\BaseWorkProcessor;

class OwnerAuthoritiesIntegration extends BaseWorkProcessor
{
    protected $_user = null;
    protected $_owner = null;
    protected $_role = null;
    protected $_userAction = null;

    public function __construct($owner)
    {
        $this->_init($owner);
    }

    public function _init($owner)
    {
        $this->_owner = $owner;
        $this->_user = $this->_owner->user;
        $this->_role = $this->_owner->role;
        $this->_userAction = $this->_owner->userAction;
        $this->status = 0;
        return $this;
    }

    public function process()
    {
        if (empty($this->_owner)) {
            return $this->parseResult('账号信息为空', []);
        }
        $userActions = $this->getUserActions();
        $this->status = 1;
        return $this->parseResult('', $userActions);
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

    protected function getRoleActions()
    {
        $roleActions = [];
        if (!empty($this->_role) && !empty($this->_role->actions)) {
            $roleActions = json_decode($this->_role->actions, true);
        }
        return $roleActions;
    }

}
