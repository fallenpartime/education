<?php
/**
 * 管理员列表
 * Date: 2018/10/3
 * Time: 19:59
 */
namespace App\Http\Admin\Actions\Master;

use Admin\Actions\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Models\System\AdminUserInfo;
use Frameworks\Tool\Http\HttpConfig;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $isOwner = $httpTool->getBothSafeParam('is_owner', HttpConfig::PARAM_NUMBER_TYPE);
        $model = AdminUserInfo::with('role');
        $urlParams = [];
        if ($isOwner > 0) {
            list($model, $urlParams) = $this->whereModel($model, $httpTool->getParams(), $urlParams);
        }
        $list = $model->get();
        $result = [
            'list'  =>  $this->processList($list),
            'urlParams'     =>  $urlParams,
            'menu'  =>  ['manageCenter', 'ownerManage', 'owners']
        ];
        return $this->createView('admin.system.owner.index', $result);
    }

    protected function whereModel($model, $params = [], $urlParams = [])
    {
        $isOwner = intval($params['is_owner']);
        if ($isOwner > 0) {
            $ownerValue = $isOwner - 1;
            $model = $model->where('is_owner', $ownerValue);
            $urlParams['is_owner'] = $isOwner;
        }
        return [$model, $urlParams];
    }

    protected function processList($list)
    {
        $outList = [];
        if (!empty($list)) {
            foreach ($list as $item) {
                $unitOwner = [
                    'id'    =>  $item->id,
                    'user_id'       =>  $item->user_id,
                    'role_no'       =>  '',
                    'role_name'     =>  '',
                    'is_owner'      =>  $item->is_owner,
                    'name'  =>  '',
                    'phone' =>  '',
                    'status_desc'   =>  $this->getStatusDescription($item),
                    'edit_url'      =>  route('ownerInfo', ['work_no'=>1, 'id'=>$item->id]),
                    'indexTag'      =>  AdminConfig::getIndexUrl($item->index_action, 'title'),
                    'created_at'    =>  $item->created_at,
                ];
                if (!empty($item->role)) {
                    $unitOwner['role_no']  = $item->role->role_no;
                    $unitOwner['role_name'] = $item->role->name;
                }
                if (!empty($item->user)) {
                    $unitOwner['name']  = $item->user->name;
                    $unitOwner['phone'] = $item->user->phone;
                }
                $outList[] = $unitOwner;
            }
        }
        return $outList;
    }

    protected function getStatusDescription($item)
    {
        $description = [];
        $description[] = '是否允许登录：'.(!empty($item->is_admin)? '是': '否');
        $description[] = '是否显示为执行人：'.(!empty($item->is_owner)? '是': '否');
        $description[] = '是否超级管理员：'.(!empty($item->is_super)? '是': '否');
        return implode('<br>', $description);
    }
}