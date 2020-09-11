<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:12
 */
defined('PHPFOX') or exit('NO DICE!');
class Ynresphoenix_Component_Controller_Admincp_Homepage extends Phpfox_Component
{
    public function process()
    {
        $iLimit = Phpfox::getService('ynresphoenix')->getCountPhotos('home',10);
        $aImages = Phpfox::getService('ynresphoenix')->getAllPhotos('home');
        if ($aVals = $this->request()->getArray('val')) {
            if (Phpfox::getService('ynresphoenix.pages.home')->add()) {
                $this->url()->send('admincp.ynresphoenix.homepage', null, _p('Photos successfully upload'));
            }
        }
        $this->template()->setHeader(array(
                     'magnific-popup.css' => 'module_ynresphoenix',
                     'jquery.magnific-popup.min.js' => 'module_ynresphoenix',
                     'backend.css' => 'module_ynresphoenix',
                     'drag.js' => 'static_script',
                     '<script type="text/javascript">$Behavior.ynresphoenixProgressBarSettings = function(){ if ($Core.exists(\'#js_ynresphoenix_slider_photos_holder\')) { oProgressBar = {holder: \'#js_ynresphoenix_slider_photos_holder\', progress_id: \'#js_progress_bar\', uploader: \'#js_progress_uploader\', add_more: false, max_upload: ' . $iLimit . ', total: 1, frame_id: \'js_upload_frame\', file_id: \'image[]\'}; $Core.progressBarInit(); } }</script>',
                     'jquery/ui.js' => 'static_script',
                                     ))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('module_ynresphoenix'),$this->url()->makeUrl('admincp.app',['id' => '__module_ynresphoenix']))
            ->setBreadcrumb(_p('Homepage Details'))
            ->assign([
                 'sRecommendSize' => Phpfox::getService('ynresphoenix.helper')->getRecommendSize('home'),
                 'iLimit' => $iLimit,
                 'aImages' => $aImages
                     ]);
    }
    
    function __call($name, $arguments)
    {

    }
}