<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:12
 */
defined('PHPFOX') or exit('NO DICE!');
class Ynresphoenix_Component_Controller_Admincp_Add extends Phpfox_Component
{
    public function process()
    {
        $bIsEdit = false;
        $sPageType = $this->request()->get('req4');
        $aLanguages = Phpfox::getService('language')->getAll();
        if(empty($sPageType) || !in_array($sPageType,['introduction','contact','client','product','blog','photo','member','statistic','reason','testimonial']))
        {
            $this->url()->send('admincp.ynresphoenix');
            return false;
        }
        if ($iEditId = $this->request()->getInt('id')) {
            $bIsEdit = true;
            $aItem = Phpfox::getService('ynresphoenix')->getItem($iEditId);
            if(!$aItem)
            {
                $this->url()->send('admincp.ynresphoenix.manage.'.$sPageType );
            }
            $this->template()->assign('aForms', $aItem);
        } else {
            list($sPhrase,$iLimit,$iCount) = Phpfox::getService('ynresphoenix.pages.'.$sPageType)->getCountItems();
            if ($iCount >= $iLimit && $iLimit) {
                $this->url()->send('admincp.ynresphoenix.manage.'.$sPageType, $sPhrase );
            }
        }
        if($sPageType == 'photo' || $sPageType == 'product')
        {
            $aCurrentCurrencies = Phpfox::getService('ynresphoenix.helper')->getCurrentCurrencies();
            $currency_id = $aCurrentCurrencies[0]['currency_id'];
            $iMax = ($sPageType == 'photo') ? 8 : 4;
            if($bIsEdit){
                $iLimit = Phpfox::getService('ynresphoenix')->getCountPhotos($sPageType,$iMax,$iEditId);
                $aImages = Phpfox::getService('ynresphoenix')->getAllPhotos($sPageType,$iEditId,$sPageType);
            }
            else{
                $iLimit = ($sPageType == 'photo') ? 8 : 4;
                $aImages = [];
            }
            $this->template()->setHeader(['<script type="text/javascript">$Behavior.ynresphoenixProgressBarSettings = function(){ if ($Core.exists(\'#js_ynresphoenix_photos_gallery_holder\')) { oProgressBar = {holder: \'#js_ynresphoenix_photos_gallery_holder\', progress_id: \'#js_progress_bar\', uploader: \'#js_progress_uploader\', add_more: false, max_upload: ' . $iLimit . ', total: 1, frame_id: \'js_upload_frame\', file_id: \'photo[]\'}; $Core.progressBarInit(); } }</script>',
                                          'jquery/ui.js' => 'static_script',])
                    ->assign([
                                  'sRecommendSize' => Phpfox::getService('ynresphoenix.helper')->getRecommendSize($sPageType),
                                  'iLimit' => $iLimit,
                                  'aImages' => $aImages,
                                  'sCurrencyId' => $currency_id,
                                  'sSymbol' => $aCurrentCurrencies[0]['symbol'],
                                      ]);
        }
        if ($aVals = $this->request()->getArray('val')) {
            if ($bIsEdit) {
                $aVals['item_id'] = $iEditId;
                if (Phpfox::getService('ynresphoenix.pages.'.$sPageType)->add($aVals, true)) {
                    $this->url()->send('admincp.ynresphoenix.manage.'.$sPageType, null, _p('Item successfully updated'));
                }
            } else {
                if (Phpfox::getService('ynresphoenix.pages.'.$sPageType)->add($aVals)) {
                    $this->url()->send('admincp.ynresphoenix.manage.'.$sPageType, null, _p('Item successfully added'));
                }
            }
        }
        $this->template()->setTitle(_p('Manage Items'));
        $this->template()->setHeader(array(
                    'backend.css' => 'module_ynresphoenix',
                     'magnific-popup.css' => 'module_ynresphoenix',
                     'jquery.magnific-popup.min.js' => 'module_ynresphoenix',
                     'drag.js' => 'static_script',
                     'jquery.validate.js' => 'module_ynresphoenix',
                     'admin.js' => 'module_ynresphoenix',
                     '<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'' . 'ynresphoenix.pagesOrdering'. '\'}); }</script>'
                                     ))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('module_ynresphoenix'),$this->url()->makeUrl('admincp.app',['id' => '__module_ynresphoenix']))
            ->setBreadcrumb(_p('add').' '._p($sPageType))
            ->setPhrase([
                    'please_enter_a_valid_url_for_example_http_example_com',
                    'please_enter_a_valid_email_address',
                    'please_enter_a_valid_youtube_link',
                    'please_enter_location'
                        ])
            ->assign([
                'iEditId' => $iEditId,
                'sType' => $sPageType,
                'apiKey' => Phpfox::getParam('core.google_api_key'),
                'aLanguages' => $aLanguages
                     ]);
    }

    function __call($name, $arguments)
    {

    }

}