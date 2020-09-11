<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Component_Block_Contact extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aSettings = Phpfox::getService('ynresphoenix')->getPageDetailByType('contact');
        $aContacts = Phpfox::getService('ynresphoenix')->getItemByPage('contact');
        $aDefaultMapInfo = [];
        if(count($aContacts)){
            $aDefaultMapInfo = Phpfox::getService('ynresphoenix.pages.contact')->getAllMapInfo($aContacts);
        }
        $sAllMapLocation = '[';
        $sAllMapContent = '[';
        $iCnt = count($aDefaultMapInfo);
        if($iCnt)
        {
            foreach ($aDefaultMapInfo as $key => $aMap)
            {
                if($key < $iCnt - 1)
                {
                    $sAllMapLocation .= '{latitude: '.$aMap['lat'].',longitude:'.$aMap['long'].'},';
                    $sAllMapContent .= '"<b>'.$aMap['address_title'].'</b>: <br/>'.$aMap['address'].'",';
                }
                else{
                    $sAllMapLocation .= '{latitude: '.$aMap['lat'].',longitude:'.$aMap['long'].'}';
                    $sAllMapContent .= '"<b>'.$aMap['address_title'].'</b>: <br/>'.$aMap['address'].'"';
                }
            }
        }
        $sAllMapLocation .= ']';
        $sAllMapContent .= ']';
        $this->template()->assign(array(
            'aContactSettings' => $aSettings,
            'aContacts' => $aContacts,
            'apiKey' => Phpfox::getParam('core.google_api_key'),
            'aDefaultMap' => $aDefaultMapInfo,
            'oAllMapLocation' => $sAllMapLocation,
            'oAllMapContent' => $sAllMapContent
        ));
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('ynresphoenix.component_block_contact_clean')) ? eval($sPlugin) : false);
    }
}
