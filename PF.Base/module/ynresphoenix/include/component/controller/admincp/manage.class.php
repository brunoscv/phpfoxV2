<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:12
 */
defined('PHPFOX') or exit('NO DICE!');
class Ynresphoenix_Component_Controller_Admincp_Manage extends Phpfox_Component
{
    public function process()
    {
        $sPageType = $this->request()->get('req4');
        if(empty($sPageType) || !in_array($sPageType,['contact','product','photo','member','testimonial']))
        {
            $this->url()->send('admincp.ynresphoenix');
            return false;
        }
        if ($aDeleteIds = $this->request()->getArray('id')) {
            if (Phpfox::getService('ynresphoenix.process')->deleteMultipleItems($aDeleteIds)) {
                $this->url()->send('admincp.ynresphoenix.manage.'.$sPageType, null, _p('Items successfully deleted'));
            }
        }

        if (($iDelete = $this->request()->getInt('delete'))) {
            if (Phpfox::getService('ynresphoenix.process')->deleteItem($iDelete)) {
                $this->url()->send('admincp.ynresphoenix.manage.'.$sPageType, null, _p('Item successfully deleted'));
            }
        }
        $aPageItems = Phpfox::getService('ynresphoenix')->getManageItemByPage($sPageType);
        $aPageDetail = Phpfox::getService('ynresphoenix')->getPageDetailByType($sPageType);
        $this->template()->setTitle(_p('Manage Items'))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('module_ynresphoenix'),$this->url()->makeUrl('admincp.app',['id' => '__module_ynresphoenix']))
            ->setBreadcrumb(_p($aPageDetail['type'].'_l'));
        $this->template()->setHeader(array(
                    'backend.css' => 'module_ynresphoenix',
                     'magnific-popup.css' => 'module_ynresphoenix',
                     'jquery.magnific-popup.min.js' => 'module_ynresphoenix',
                     'drag.js' => 'static_script',
                     '<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'' . 'ynresphoenix.itemOrdering'. '\'}); }</script>'
                                     ))
            ->assign([
                'sType' => $sPageType,
                'aPageItems' => $aPageItems,
                'aPage' => $aPageDetail
                     ]);
    }

    function __call($name, $arguments)
    {

    }

}