<?php
/**
 * session工具
 * Date: 2018/10/7
 * Time: 17:53
 */
namespace Frameworks\Tool\Http;

use Illuminate\Http\Request;

class SessionTool
{
    protected $request = null;
    protected $session = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->session = $request->getSession();
    }

    public function getSession()
    {
        return $this->session;
    }

    public function set($key, $value)
    {
        $this->session->put($key, $value);
    }

    public function remove($key)
    {
        $this->session->forget($key);
    }

    public function get($key)
    {
        return $this->session->get($key);
    }
}
