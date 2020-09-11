<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:09
 */
defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Service_Pages_Product extends Phpfox_Service
{
    private $_sItemTable;

    public function __construct()
    {
        $this->_sTable = Phpfox::getT('ynresphoenix_pages');
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
            ->where('page_type = \'product\'')
            ->execute('getField');

        $sPhrase = _p('You can only have maximum 10 products');
        return array($sPhrase,10,$iCount);
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
        $aVals = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals,'description',false,'Short Description');
        if(!is_array($aVals))
        {
            return Phpfox_Error::set($aVals);
        }
        $aVals['params'] = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals['params'],'link_text');
        if(!is_array($aVals['params']))
        {
            return Phpfox_Error::set($aVals['params']);
        }
        $aInsert = array(
            'title' => $oFilter->clean($aVals['title']),
            'description' => isset($aVals['description']) ? $oFilter->clean($aVals['description']) : '',
            'type' => 'product',
            'page_type' => 'product',
            'user_id' => Phpfox::getUserId(),
            'time_stamp' => PHPFOX_TIME,
            'params' => isset($aVals['params']) ? json_encode($aVals['params']) : '',
        );
        $bCanAddMorePhoto = true;
        $iHasMainPhoto = 0;
        if ($bIsUpdate) {
            $iId = $aVals['item_id'];
            $iHasMainPhoto = $this->isHasMainPhoto($iId);
            $this->database()->update($this->_sItemTable, $aInsert, 'item_id = ' . (int) $aVals['item_id']);
            $iLimit = Phpfox::getService('ynresphoenix')->getCountPhotos('product',4,$iId);
            if(!$iLimit) $bCanAddMorePhoto = false;
        } else {
            $iId = $this->database()->insert($this->_sItemTable, $aInsert);
            if (!$iId) {
                return false;
            }
        }
        if($bCanAddMorePhoto && isset($_FILES['photo'])) {
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
                            if(!$iHasMainPhoto)
                            {
                                $iHasMainPhoto = Phpfox::getService('ynresphoenix.process')->updateItemPhoto($iId, 'main_photo', $sPhotoPath, 'product', true);
                            }
                            else
                            {
                                Phpfox::getService('ynresphoenix.process')->updateItemPhoto($iId, 'photo', $sPhotoPath, 'product', true);
                            }
                        }
                    }
                }
            }
        }
        return $iId;
    }
    public function getPhraseText($aVals)
    {
        return $aVals;
    }
    public function getItemPhraseText($aVals)
    {
        return Phpfox::getService('ynresphoenix')->getPhraseText($aVals['link_text'],'link_text');
    }
    public function setMainPhoto($iProductId,$iPhotoId)
    {
        $this->database()->update(Phpfox::getT('ynresphoenix_photos'),['photo_type' => 'photo'],'page_type = \'product\' AND parent_id ='.$iProductId);
        $this->database()->update(Phpfox::getT('ynresphoenix_photos'),['photo_type' => 'main_photo'],'photo_id = '.$iPhotoId);
        return true;
    }
    public function isHasMainPhoto($iProductId)
    {
        return $this->database()->select('photo_id')
                    ->from(Phpfox::getT('ynresphoenix_photos'))
                    ->where('photo_type = \'main_photo\' AND parent_id ='.$iProductId)
                    ->execute('getSlaveField');
    }
}