<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:09
 */
defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Service_Pages_Testimonial extends Phpfox_Service
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
            ->where('page_type = \'testimonial\'')
            ->execute('getField');

        $sPhrase = _p('You can only have maximum 5 testimonials');
        return array($sPhrase,5,$iCount);
    }

    public function add($aVals,$bIsUpdate = false)
    {
        $oFile = Phpfox_File::instance();
        $oFilter = Phpfox::getLib('parse.input');
        $bHasImage = false;
        $aVals = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals,'description',true,'Testimonial');
        if(!is_array($aVals))
        {
            return Phpfox_Error::set($aVals);
        }
        $aVals['params'] = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals['params'],'position',true,'position');
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
        $aInsert = array(
            'title' => $oFilter->clean($aVals['title']),
            'description' => isset($aVals['description']) ? $oFilter->clean($aVals['description']) : '',
            'type' => 'testimonial',
            'page_type' => 'testimonial',
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
                Phpfox::getService('ynresphoenix.process')->updateItemPhoto($iId,'photo',$sPhotoPath,'testimonial');
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
        return Phpfox::getService('ynresphoenix')->getPhraseText($aVals['position'],'position');
    }
}