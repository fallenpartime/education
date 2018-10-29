<?php
/**
 * 验证服务
 * Date: 2018/10/29
 * Time: 23:37
 */
namespace Wechat\Services;

use Illuminate\Http\Request;

class OauthService
{
    protected $request = null;
    protected $user = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->initUserInfo();
    }

    protected function initUserInfo()
    {

    }

    public function validate()
    {

    }
}