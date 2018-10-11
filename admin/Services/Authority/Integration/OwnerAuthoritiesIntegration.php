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
        $this->_user = $owner->user;
        $this->_role = $owner->role;
        $this->_userAction = $owner->userAction;
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
        list($status, $message, $userActionList) = (new RoleAuthoritiesIntegration($this->_role))->process();
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
}
