<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:12
 */
defined('PHPFOX') or exit('NO DICE!');
class Ynresphoenix_Component_Controller_Admincp_Index extends Phpfox_Component
{
    public function process()
    {
        if($sType = $this->request()->get('reset'))
        {
            if(Phpfox::getService('ynresphoenix.process')->resetDefaultSettings($sType))
            {
                $this->url()->send('admincp.ynresphoenix',_p('reset_default_successfully'));
            }
            else{
                $this->url()->send('admincp.ynresphoenix',_p('something_went_wrong'));
            }
        }
        $aPages = Phpfox::getService('ynresphoenix')->getAllPages();
        $this->template()->assign([
                                      'aPages' => $aPages
                                  ]);
        $this->template()->setTitle(_p('ynresphoenix.admin_menu_manage_pages'))
                        ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
                        ->setBreadCrumb(_p('module_ynresphoenix'),$this->url()->makeUrl('admincp.app',['id' => '__module_ynresphoenix']))
                        ->setBreadcrumb(_p('admin_menu_manage_pages'));
        $this->template()->setHeader(array(
                                  'backend.css' => 'module_ynresphoenix',
                                 'magnific-popup.css' => 'module_ynresphoenix',
                                 'jquery.magnific-popup.min.js' => 'module_ynresphoenix',
                                 'drag.js' => 'static_script',
                                 '<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'' . 'ynresphoenix.pagesOrdering'. '\'}); }</script>'
                                     ));
    }

    function __call($name, $arguments)
    {

    }
}