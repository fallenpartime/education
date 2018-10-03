<?php
/**
 * 后台验证
 * Date: 2018/10/2
 * Time: 22:39
 */
namespace Admin\Auth;

use Frameworks\Tool\CompareTool;
use Illuminate\Http\Request;

class AuthService
{
    protected $request = null;
    protected $adminInfo = [];
    protected $actionList = [];
    protected $currentAction = '';
    public $isMaster = 0;
    public $isSuper = 0;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->_init($request);
    }

    protected function _clear()
    {
        $this->adminInfo = [];
        $this->actionList = [];
        $this->currentAction = '';
        $this->isMaster = 0;
        $this->isSuper = 0;
    }

    protected function _init(Request $request)
    {
        $this->_clear();
        $this->currentAction = $request->route()->getName();
        $this->initAdminInfo();
        $this->initActionList();
    }

    protected function initAdminInfo()
    {
        $this->adminInfo = [
            'user_id'       =>  1,
            'username'      =>  'manager',
            'role_id'       =>  99,
            'group_list'    =>  [1],
            'is_manager'    =>  1,
            'is_super'      =>  1
        ];
        $this->isMaster = 1;
        $this->isSuper = 1;
    }

    protected function initActionList()
    {
        $this->actionList = [];
    }

    public function getAdminInfo()
    {
        return $this->adminInfo;
    }

    public function getActionList()
    {
        return $this->actionList;
    }

    public function validateLogin()
    {
        $loginStatus = false;
        $redirectUrl = route('admin.login');
        if (!empty($this->adminInfo)) {
            $loginStatus = true;
        }
        return [$loginStatus, $redirectUrl, $this->adminInfo];
    }

    public function validateCurrentAction()
    {
        list($status, $redirectUrl, $adminInfo) = $this->validateLogin();
        if (empty($status)) {
            return redirect($redirectUrl);
        }
        if ($this->isMaster) {
            return [true, ''];
        }
        $validate = $this->validateAction($this->currentAction);
        if ($validate) {
            return [true, ''];
        }
        $redirectUrl = route('admin.warn');
        return [false, redirect($redirectUrl)];
    }

    /**
     * 对比操作
     * @param $action
     * @param $method 0-or 1-and
     * @return bool
     */
    public function validateAction($action, $method = 1)
    {
        if (empty($action)) {
            return false;
        }
        $actionList = $this->actionList;
        if (empty($actionList)) {
            return false;
        }
        if (is_array($action)) {
            return CompareTool::compareValues($method, CompareTool::METHOD_IN_ARRAY, $action, $actionList);
        }
        return in_array($action, $actionList);
    }
}