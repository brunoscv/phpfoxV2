<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:09
 */
defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Service_Pages_Contact extends Phpfox_Service
{
    private $_sItemTable;

    public function __construct()
    {
        $this->_sTable = Phpfox::getT('ynresphoenix_pages');
        $this->_sItemTable = Phpfox::getT('ynresphoenix_items');
    }

    public function updateSetting($iPageId,$aVals)
    {
        if(!count($aVals))
        {
            return false;
        }
        if(!isset($aVals['params']))
        {
            $aVals['params']['show_map'] = 0;
        }
        $aPageSettings = Phpfox::getService('ynresphoenix')->getPageDetailByType('contact');
        if(!empty($aPageSettings['params']['main_photo_path'])){
            $sFileName = ['main_photo_path' => $aPageSettings['params']['main_photo_path']];
        }
        else{
            $sFileName = ['main_photo_path' => ''];
        }
        if (isset($_FILES['main_photo']['name']) && ($_FILES['main_photo']['name'] != '')) {
            $aImage = Phpfox::getLib('file')->load('main_photo', array('jpg', 'gif', 'png'));
            if (!Phpfox_Error::isPassed()) {
                return false;
            }

            if ($aImage === false) {
                return Phpfox_Error::set(_p('Please select an image to upload'));
            }
            $sFileName['main_photo_path'] = 'ynresphoenix/'.Phpfox::getService('ynresphoenix.process')->upload($iPageId,'main_photo_path','main_photo',true);

        }
        $aUpdate = array_merge($sFileName,$aVals['params']);
        $this->database()->update($this->_sTable,['params' => json_encode($aUpdate)],'page_id ='.$iPageId);
        return true;
    }
    public function getCountItems()
    {
        $iCount = $this->database()->select('COUNT(*)')
            ->from($this->_sItemTable)
            ->where('page_type = \'blog\'')
            ->execute('getField');

        $sPhrase = '';
        return array($sPhrase,0,$iCount);
    }

    public function add($aVals,$bIsUpdate = false)
    {
        $oFilter = Phpfox::getLib('parse.input');
        $aVals = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals,'title',true,'title');
        if(!is_array($aVals))
        {
            return Phpfox_Error::set($aVals);
        }
        if(empty($aVals['params']['location_fulladdress']))
        {
            $aVals['params']['location_address_lat'] = '0';
            $aVals['params']['location_address_lng'] = '0';
            $aVals['params']['location_address'] = '';
        }

        $aInsert = array(
            'title' => $oFilter->clean($aVals['title']),
            'description' => isset($aVals['description']) ? $oFilter->clean($aVals['description']) : '',
            'type' => 'contact',
            'page_type' => 'contact',
            'user_id' => Phpfox::getUserId(),
            'time_stamp' => PHPFOX_TIME,
            'params' => isset($aVals['params']) ? json_encode($aVals['params']) : '',
        );

        if ($bIsUpdate) {
            $iId = $aVals['item_id'];
            $this->database()->update($this->_sItemTable, $aInsert, 'item_id = ' . (int) $aVals['item_id']);
        } else {
            $iId = $this->database()->insert($this->_sItemTable, $aInsert);
            if (!$iId) {
                return false;
            }
        }

        return $iId;
    }
    public function getAllMapInfo($aContacts)
    {
        $aResult = [];
        foreach ($aContacts as $aContact) {

            if(!empty($aContact['params']['location_address_lat']) && !empty($aContact['params']['location_address_lng']) && !empty($aContact['params']['location_address']))
            {
                $aResult[] = [
                    'lat' => $aContact['params']['location_address_lat'],
                    'long' => $aContact['params']['location_address_lng'],
                    'address' => $aContact['params']['location_address'],
                    'address_title' => \Core\Lib::phrase()->isPhrase($aContact['title']) ? _p($aContact['title']) : $aContact['title']
                ];
            }
        }
        return $aResult;
    }
    public function getPhraseText($aVals)
    {
        return $aVals;
    }
    public function getItemPhraseText($aVals)
    {
        return $aVals;
    }
}