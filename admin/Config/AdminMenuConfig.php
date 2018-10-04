<?php
/**
 * 后台管理菜单配置
 * Date: 2018/10/3
 * Time: 20:47
 */
namespace Admin\Config;

class AdminMenuConfig
{

    public static function menuList()
    {
        return [
//            'servicePlatform'   =>  '',
//            'platformManage'=>[
//                'toManageProjectList'   =>Yii::$app->urlManager->createUrl(['platform/manage/toManageProjectList']),
//                'toSimpleProjectList'   =>Yii::$app->urlManager->createUrl(['platform/manage/toSimpleProjectList']),
//                'toManageEarlyendList'  =>Yii::$app->urlManager->createUrl(['platform/manage/toManageEarlyendList']),
//                'toManageChangeMoneyList'   =>Yii::$app->urlManager->createUrl(['platform/manage/toManageChangeMoneyList']),
//                'toManageProjectItemList'   =>Yii::$app->urlManager->createUrl(['platform/manage/toManageProjectItemList']),
//                'projectLogManage'=>''
//            ],
            'manageCenter'  =>  [
                'groupManage'       =>  '',
                'authorityManage'   =>  '',
            ],
        ];
    }

    public static function children()
    {
        return [
            'manageCenter'  =>  [
                'groupManage'   =>  [
                    'groups'            =>  route('groups'),
                    'groupInfo'         =>  route('groupInfo', ['work_no'=>1])
                ],
                'authorityManage'   =>  [
                    'authorities'       =>  route('authorities'),
                    'authorityInfo'     =>  route('authorityInfo', ['work_no'=>1])
                ],
            ],
        ];
    }
}