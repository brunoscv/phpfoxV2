<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:12
 */
defined('PHPFOX') or exit('NO DICE!');
class Ynresphoenix_Component_Controller_Admincp_Setting extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin(true);
        $sSection = $this->request()->get('req4');
        $aPage = Phpfox::getService('ynresphoenix')->getPageDetailForEdit($sSection);
        $aLanguages = Phpfox::getService('language')->getAll();
        if(!$aPage)
        {
            $this->url()->send('admincp.ynresphoenix',_p('invalid_params'));
            return false;
        }
        $sSamplePath = Phpfox::getParam('core.path_file').'module/ynresphoenix/static/images/layout_'.$sSection.'.png';
        $this->template()->setTitle(_p('settings'))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('module_ynresphoenix'),$this->url()->makeUrl('admincp.app',['id' => '__module_ynresphoenix']))
            ->setBreadcrumb(_p($aPage['type'].'_l').' '._p('settings'))
            ->setPhrase([
                'please_enter_a_valid_url_for_example_http_example_com',
                'please_enter_a_valid_email_address',
                'please_enter_a_valid_youtube_link'
                        ])
            ->setHeader([
                'backend.css' => 'module_ynresphoenix',
                'jquery.validate.js' => 'module_ynresphoenix',
                'admin.js' => 'module_ynresphoenix',
                'jquery.magnific-popup.min.js' => 'module_ynresphoenix',
                'magnific-popup.css' => 'module_ynresphoenix',
                        ])
            ->assign([
                'sPage' => $sSection,
                'aForms' => $aPage,
                'sPageTitle' => _p($aPage['type'].'_l'),
                'sType' => $aPage['type'],
                'sPagesType' => $aPage['type'],
                'sRecommendSize' => Phpfox::getService('ynresphoenix.helper')->getRecommendSize($aPage['type']),
                'sSamplePath' => $sSamplePath,
                'aLanguages' => $aLanguages
                ]);
        if($aVals = $this->request()->getArray('val'))
        {
            if(Phpfox::getService('ynresphoenix.process')->updatePageSetting($aVals))
            {
                $this->url()->send('admincp.ynresphoenix',_p('Settings updated successfully'));
            }
        }
    }
    
    function __call($name, $arguments)
    {

    }
}