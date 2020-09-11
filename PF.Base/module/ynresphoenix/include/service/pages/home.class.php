<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:09
 */
defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Service_Pages_Home extends Phpfox_Service
{
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('ynresphoenix_pages');
    }

    public function updateSetting($iPageId,$aVals)
    {
        if(!count($aVals) || !isset($aVals['params']))
        {
            return false;
        }
        $aVals['params'] = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals['params'],'button_text');
        $aVals['params'] = Phpfox::getService('ynresphoenix.process')->updatePhraseValue($aVals['params'],'social_text');
        $this->database()->update($this->_sTable,['params' => json_encode($aVals['params'])],'page_id ='.$iPageId);
        return true;
    }

    public function add()
    {
        $oFile = Phpfox_File::instance();
        $iId = 0;
        $bIsPass = false;
        $iLimit = Phpfox::getService('ynresphoenix')->getCountPhotos('photo',10);
        if(!$iLimit) return false;
        foreach ($_FILES['image']['error'] as $iKey => $sError)
        {
            if ($sError == UPLOAD_ERR_OK)
            {
                if($oFile->load('image[' . $iKey . ']', array('jpg', 'gif', 'png'))){
                    $bIsPass = true;
                    $sPhotoPath = Phpfox::getService('ynresphoenix.process')->upload($iId,'photo_path','image[' . $iKey . ']',true,true);
                    if(!empty($sPhotoPath))
                    {
                        $sPhotoPath = 'ynresphoenix/'.$sPhotoPath;
                        Phpfox::getService('ynresphoenix.process')->updateItemPhoto($iId,'photo',$sPhotoPath,'home',true);
                    }
                }
            }
        }
        if ($bIsPass === false) {
            return Phpfox_Error::set(_p('Please select an image to upload'));
        }
        return true;
    }
    public function getPhraseText($aVals)
    {
        $aButtonText = Phpfox::getService('ynresphoenix')->getPhraseText($aVals['button_text'],'button_text');
        $aSocialText = Phpfox::getService('ynresphoenix')->getPhraseText($aVals['social_text'],'social_text');
        return array_merge($aButtonText,$aSocialText);
    }
}