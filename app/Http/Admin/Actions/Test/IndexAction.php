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
        $result = [
            'menu'  =>  ['manageCenter', 'authorityCenter', 'authorities']
        ];
        return $this->createView('admin.test.index', $result);
    }
}