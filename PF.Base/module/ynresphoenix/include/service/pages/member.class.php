<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:09
 */
defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Service_Pages_Member extends Phpfox_Service
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
            ->where('page_type = \'member\'')
            ->execute('getField');

        $sPhrase = _p('You can only have maximum 8 members');
        return array($sPhrase,8,$iCount);
    }

    public function add($aVals,$bIsUpdate = false)
    {
        $oFile = Phpfox_File::instance();
        $oFilter = Phpfox::getLib('parse.input');
        $bHasImage = false;
        $aVals = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals,'description');
        if(!is_array($aVals))
        {
            return Phpfox_Error::set($aVals);
        }
        $aVals['params'] = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals['params'],'position',true,'position');
        if(!is_array($aVals['params']))
        {
            return Phpfox_Error::set($aVals['params']);
        }
        $aVals['params'] = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals['params'],'favorite_quote',false,'Favourite quote');
        if(!is_array($aVals['params']))
        {
            return Phpfox_Error::set($aVals['params']);
        }
        if (isset($_FILES['photo']['name']) && ($_FILES['photo']['name'] != '')) {
            $aImage = $oFile->load('photo', array('jpg', 'gif', 'png'));
            if (!Phpfox_Error::isPassed()) {
                return false;
            }

            if ($aImage === false) {
                return Phpfox_Error::set(_p('Please select an image to upload'));
            }
            $bHasImage = true;
        }
        if(empty($aVals['title']))
        {
            return Phpfox_Error::set(_p('Name cannot be empty'));
        }
        if (!$aVals['had_photo'] && (!isset($_FILES['photo']['name']) || ($_FILES['photo']['name'] == ''))) {
            return Phpfox_Error::set(_p('Photo of member is required'));
        }
        $aInsert = array(
            'title' => $oFilter->clean($aVals['title']),
            'description' => isset($aVals['description']) ? $oFilter->clean($aVals['description']) : '',
            'type' => 'member',
            'page_type' => 'member',
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
        if ($bHasImage) {
            $sPhotoPath = Phpfox::getService('ynresphoenix.process')->upload($iId,'photo_path','photo',true);
            if(!empty($sPhotoPath))
            {
                $sPhotoPath = 'ynresphoenix/'.$sPhotoPath;
                Phpfox::getService('ynresphoenix.process')->updateItemPhoto($iId,'photo',$sPhotoPath,'member');
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
        $aPosition = Phpfox::getService('ynresphoenix')->getPhraseText($aVals['position'],'position');
        $aFavoriteQuote = Phpfox::getService('ynresphoenix')->getPhraseText($aVals['favorite_quote'],'favorite_quote');
        return array_merge($aPosition,$aFavoriteQuote);
    }
}