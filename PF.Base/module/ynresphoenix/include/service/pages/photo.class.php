<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:09
 */
defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Service_Pages_Photo extends Phpfox_Service
{
    private $_sItemTable;
    private $_sPhotoTable;

    public function __construct()
    {
        $this->_sTable = Phpfox::getT('ynresphoenix_pages');
        $this->_sPhotoTable = Phpfox::getT('ynresphoenix_photos');
        $this->_sItemTable = Phpfox::getT('ynresphoenix_items');
    }

    public function updateSetting($iPageId,$aVals)
    {
        if(!count($aVals) || !isset($aVals['params']))
        {
            return false;
        }
        $this->database()->update($this->_sTable,['params' => json_encode($aVals['params'])],'page_id ='.$iPageId);
        return true;
    }

    public function getCountItems()
    {
        $iCount = $this->database()->select('COUNT(*)')
            ->from($this->_sItemTable)
            ->where('page_type = \'photo\'')
            ->execute('getField');

        $sPhrase = _p('You can only have maximum 8 galleries');
        return array($sPhrase,8,$iCount);
    }

    public function add($aVals,$bIsUpdate = false)
    {
        $oFile = Phpfox_File::instance();
        $oFilter = Phpfox::getLib('parse.input');
        $aVals = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals,'title',true,'title');
        if(!is_array($aVals))
        {
            return Phpfox_Error::set($aVals);
        }
        if (!$aVals['had_photo'] && empty($_FILES['photo'])) {
            return Phpfox_Error::set(_p('Photo of gallery is required'));
        }
        $aInsert = array(
            'title' => $oFilter->clean($aVals['title']),
            'description' => isset($aVals['description']) ? $oFilter->clean($aVals['description']) : '',
            'type' => 'gallery',
            'page_type' => 'photo',
            'user_id' => Phpfox::getUserId(),
            'time_stamp' => PHPFOX_TIME,
            'params' => isset($aVals['params']) ? json_encode($aVals['params']) : '',
        );

        if ($bIsUpdate && $aVals['had_photo']) {
            $iId = $aVals['item_id'];
            $this->database()->update($this->_sItemTable, $aInsert, 'item_id = ' . (int) $aVals['item_id']);
            $iLimit = Phpfox::getService('ynresphoenix')->getCountPhotos('photo',8,$iId);
            if(!$iLimit) return false;
        }
        else{
            $iId = 0;
        }
        $oFile = Phpfox_File::instance();
        $bIsPass = false;
        if(isset($_FILES['photo'])) {
            foreach ($_FILES['photo']['error'] as $iKey => $sError) {
                if ($sError == UPLOAD_ERR_OK) {
                    if ($oFile->load('photo[' . $iKey . ']', array('jpg', 'gif', 'png'))) {
                        $bIsPass = true;
                        if ($bIsUpdate && ($iId == 0)) {
                            $iId = $aVals['item_id'];
                            $this->database()->update($this->_sItemTable, $aInsert, 'item_id = ' . (int)$aVals['item_id']);
                        } elseif ($iId == 0) {
                            $iId = $this->database()->insert($this->_sItemTable, $aInsert);
                            if (!$iId) {
                                return false;
                            }
                        }
                        $sPhotoPath = Phpfox::getService('ynresphoenix.process')->upload($iId, 'photo_path', 'photo[' . $iKey . ']', true, true);
                        if (!empty($sPhotoPath)) {
                            $sPhotoPath = 'ynresphoenix/' . $sPhotoPath;
                            Phpfox::getService('ynresphoenix.process')->updateItemPhoto($iId, 'photo', $sPhotoPath, 'photo', true);
                        }
                    }
                }
            }
        }
        if ($bIsPass === false && !$aVals['had_photo']) {
            return Phpfox_Error::set(_p('Please select an image to upload'));
        }
        return $iId;
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