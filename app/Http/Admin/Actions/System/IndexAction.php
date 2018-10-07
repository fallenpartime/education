<?php
/**
 * 入口
 * Date: 2018/10/7
 * Time: 18:16
 */
namespace App\Http\Admin\Actions\System;

use Admin\Actions\BaseAction;

class IndexAction extends BaseAction
{
    public function run()
    {
        dd($this->getHttpTool()->getSession('admin_info'));
        exit('index');
    }
}