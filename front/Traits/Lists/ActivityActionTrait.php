<?php
/**
 * 活动列表插件
 * Date: 2018/10/30
 * Time: 9:56
 */
namespace Front\Traits\Lists;

use Frameworks\Tool\Random\HashTool;

trait ActivityActionTrait
{
    protected $type = 0;
    protected $limit = 0;
    protected $page = 0;

    protected function initParams()
    {
        $code = request('code');
        if (empty($code)) {
            return false;
        }
        $hashTool = new HashTool();
        $params = $hashTool->decode($code);
        if (empty($params)) {
            return false;
        }
        if (count($params) >= 2) {
            $this->page = $params[0];
            $this->limit = $params[1];
        }
        return false;
    }

    protected function getList()
    {

    }
}
