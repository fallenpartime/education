<?php
/**
 * 后台验证
 * Date: 2018/10/2
 * Time: 22:39
 */
namespace Admin\Auth;

use Illuminate\Http\Request;

class AuthService
{
    protected $request = null;
    protected $adminInfo = [];
    protected $actionName = '';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->_init();
    }

    protected function _init()
    {
        $this->actionName = $this->request->route()->getName();
    }

    protected function initAdminInfo()
    {

    }

    public function validateLogin()
    {
        $loginStatus = false;
        $redirectUrl = '';
        return [$loginStatus, $redirectUrl, $this->adminInfo];
    }
}