<?php
/**
 *
 * Date: 2018/10/2
 * Time: 23:53
 */
namespace App\Http\Admin\Actions\Test;

use Admin\Actions\BaseAction;
use Illuminate\Support\Facades\Redis;

class IndexAction extends BaseAction
{
    public function run()
    {
        $keyname = 'edu:test:name';
//        Redis::set($keyname, time());
        dd(Redis::keys("*"));
//        $result = [
//            'menu'  =>  ['manageCenter', 'authorityCenter', 'authorities']
//        ];
//        return $this->createView('admin.test.index', $result);
    }
}
