<?php
/**
 * 获取相关联权限列表
 * Date: 2018/10/3
 * Time: 23:52
 */
namespace Admin\Services\Authority\Integration;

use Admin\Base\Processor\BaseWorkProcessor;
use Illuminate\Support\Facades\DB;

class RelateAuthoritiesIntegration extends BaseWorkProcessor
{
    protected $_menu = [];
    protected $_type = [];

    public function __construct($type, $columns = '')
    {
        $this->_type = $type;
        $this->_menu = DB::table("admin_actions")->select($columns)->whereIn('type', $type)->get();
    }

    protected function separate()
    {
        $mainMenuList = $subMenuList = $operateMenuList = [];
        foreach ($this->_menu as $menu) {
            $menuId = $menu->id;
            $menuType = $menu->type;
            if ($menuType == 1) {
                $mainMenuList[$menuId] = ['menu'=>$menu, 'length'=>0, 'list'=>[]];
            }
            if ($menuType == 2) {
                $subMenuList[$menuId] = ['menu'=>$menu, 'length'=>0, 'list'=>[]];
            }
            if (in_array(3, $this->_type)) {
                if ($menuType == 3) {
                    $operateMenuList[$menuId] = ['menu'=>$menu];
                }
            }
        }
        return [$mainMenuList, $subMenuList, $operateMenuList];
    }

    protected function combine($mainMenuList, $subMenuList, $operateMenuList)
    {
        if (in_array(3, $this->_type)) {
            foreach ($operateMenuList as $operateKey => $item) {
                $parentId = $item['parent_id'];
                $subMenuList[$parentId]['list'][$operateKey] = $item;
                $subMenuList[$parentId]['length']++;
            }
        }
        foreach ($subMenuList as $subKey => $item) {
            $item['length'] = $item['length'] == 0? 1: $item['length'];
            $parentId = $item['parent_id'];
            $mainMenuList[$parentId]['list'][$subKey] = $item;
            $mainMenuList[$parentId]['length'] += $item['length'];
        }
        foreach ($mainMenuList as $mainKey => $item) {
            $mainMenuList[$mainKey]['length'] = $item['length'] == 0? 1: $item['length'];
        }
        return $mainMenuList;
    }

    public function process()
    {
        $list = [];
        if (!empty($this->_menu)) {
            list($mainMenuList, $subMenuList, $operateMenuList) = $this->separate();
            $list = $this->combine($mainMenuList, $subMenuList, $operateMenuList);
        }
        if (empty($list)) {
            return $this->parseResult('权限列表为空', 0, $list);
        }
        $this->status = 1;
        return $this->parseResult('', count($list), $list);
    }
}