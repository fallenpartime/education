<?php
/**
 *
 * Date: 2018/10/2
 * Time: 23:53
 */
namespace App\Http\Admin\Actions\Test;

use Admin\Actions\BaseAction;

class IndexAction extends BaseAction
{
    public function run()
    {
        $actionName = $this->request->route()->getName();
        return view('admin.test.index', ['content'=>$actionName]);
    }
}