<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:09
 */
defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Service_Process extends Phpfox_Service
{
    private $_sBlockName = '';
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('ynresphoenix_pages');
        $this->_sBlockName = Phpfox::getService('ynresphoenix.helper')->getBlockName();
    }

    public function updateActive($iPageId,$iActive)
    {
        $this->database()->update($this->_sTable,['enabled' => $iActive],'page_id ='.$iPageId);
        $this->database()->update(Phpfox::getT('block'),['is_active' => $iActive],'module_id = \'ynresphoenix\' AND m_connection = \'ynresphoenix.landing\' AND component =\''.$this->_sBlockName[$iPageId].'\'');
        return true;
    }
    public function updateBlockOrdering($aParams)
    {
        $iCnt = 0;
        foreach ($aParams['values'] as $mKey => $mOrdering)
        {
            $iCnt++;
            $this->database()->update(Phpfox::getT('block'), array('ordering' => $iCnt),'module_id = \'ynresphoenix\' AND m_connection = \'ynresphoenix.landing\' AND component =\''.$this->_sBlockName[$mKey].'\'');
        }

        return true;
    }
    public function updatePageSetting($aVals)
    {
        if(!$aVals || !isset($aVals['id']))
        {
            return Phpfox_Error::set(_p('ynresphoenix.invalid_params'));
        }
        $iPageId = $aVals['id'];
        $oFilter = Phpfox::getLib('parse.input');
        $aVals = $this->updatePhraseValue($aVals,'title');
        if(in_array($aVals['type'],['home','statistic'])){
            $aVals = $this->updatePhraseValue($aVals,'description');
        }
        $aBasicUpdate = [
               'title' => isset($aVals['title']) ? $oFilter->clean($aVals['title']) : '',
               'description' => isset($aVals['description']) ? $oFilter->clean($aVals['description']) : ''
        ];
        $this->database()->update(Phpfox::getT('block'),['title' => $aBasicUpdate['title']],'module_id = \'ynresphoenix\' AND m_connection = \'ynresphoenix.landing\' AND component =\''.$this->_sBlockName[$iPageId].'\'');

        //update basic info
        $this->database()->update($this->_sTable,$aBasicUpdate,'page_id = '.$iPageId);
        //update image
        $oFile = Phpfox::getLib('file');
        if (isset($_FILES['background']['name']) && ($_FILES['background']['name'] != '')) {
            $aImage = $oFile->load('background', array('jpg', 'gif', 'png'));
            if (!Phpfox_Error::isPassed()) {
                return false;
            }

            if ($aImage === false) {
                return Phpfox_Error::set(_p('Please select an image to upload'));
            }
            $this->upload($iPageId,'background_path','background');
        }
        if (isset($_FILES['icon']['name']) && ($_FILES['icon']['name'] != '')) {
            $aImage = $oFile->load('icon', array('jpg', 'gif', 'png'));
            if (!Phpfox_Error::isPassed()) {
                return false;
            }

            if ($aImage === false) {
                return Phpfox_Error::set(_p('Please select an image to upload'));
            }
            $this->upload($iPageId,'icon_path','icon');
        }
        if (isset($_FILES['icon_hover']['name']) && ($_FILES['icon_hover']['name'] != '')) {
            $aImage = $oFile->load('icon_hover', array('jpg', 'gif', 'png'));
            if (!Phpfox_Error::isPassed()) {
                return false;
            }

            if ($aImage === false) {
                return Phpfox_Error::set(_p('Please select an image to upload'));
            }
            $this->upload($iPageId,'icon_hover_path','icon_hover');
        }
        if(isset($aVals['type']))
        {
            Phpfox::getService('ynresphoenix.pages.'.$aVals['type'])->updateSetting($iPageId,$aVals);
        }
        return true;
    }

    public function upload($ItemId,$fieldImage,$sFile,$bReturnPath = false,$bForce = false)
    {

        if(!$bForce && !in_array($sFile,['background','icon','icon_hover','hover','top_background','main_photo','photo']))
        {
            return false;
        }

        $oFile = Phpfox_File::instance();
        $oImage = Phpfox_Image::instance();
        $sPicStorage = Phpfox::getParam('core.dir_pic') . 'ynresphoenix/';
        $aSize = (in_array($fieldImage,['background_path','top_background_path','photo_path','main_photo_path'])) ? array(200, 1024) : array(16, 32, 50);
        $sStoreImage = '';
        if(!$bReturnPath) {
            $sStoreImage = $this->database()->select($fieldImage)
                ->from($this->_sTable)
                ->where('page_id = ' . (int)$ItemId)
                ->execute('getSlaveField');
        }
        else{
            if($fieldImage == 'top_background_path' || $fieldImage == 'main_photo_path')
            {
                $oParams = $this->database()->select('params')
                    ->from($this->_sTable)
                    ->where('page_id = ' . (int)$ItemId)
                    ->execute('getSlaveField');
                $aParams = json_decode($oParams,true);
                $sStoreImage = $aParams[$fieldImage];
            }
            else if(in_array($fieldImage,['photo_path_icon','photo_path','photo_path_hover'])){
                $sStoreImage = $this->database()->select('photo_path')
                    ->from(Phpfox::getT('ynresphoenix_photos'))
                    ->where('parent_id = ' . (int)$ItemId.' AND photo_type = \''.$sFile.'\'')
                    ->execute('getSlaveField');
            }
        }
        if (!empty($sStoreImage) && $fieldImage != 'background_path' && $fieldImage != 'top_background_path') {
            if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($sStoreImage, ''))) {
                $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($sStoreImage, ''));
            }
            foreach ($aSize as $size) {
                if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($sStoreImage, '_' . $size))) {
                    $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($sStoreImage, '_' . $size));
                }
            }
        }

        if (!is_dir($sPicStorage)) {
            @mkdir($sPicStorage, 0777, 1);
            @chmod($sPicStorage, 0777);
        }

        $sFileName = $oFile->upload($sFile, $sPicStorage, $fieldImage.rand());


        foreach($aSize as $size)
        {
            $oImage->createThumbnail($sPicStorage . sprintf($sFileName, ''), $sPicStorage . sprintf($sFileName, '_'.$size), $size, $size);
        }
        if(!$bReturnPath) {
            $this->database()->update($this->_sTable, array(
                $fieldImage => 'ynresphoenix/' . $sFileName,
                'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID'),
            ), 'page_id = ' . $ItemId);
        }
        else{
            return $sFileName;
        }
    }

    public function updateItemsOrdering($sType,$aParams)
    {
        $iCnt = 0;
        foreach ($aParams['values'] as $mKey => $mOrdering)
        {
            $iCnt++;
            $this->database()->update(Phpfox::getT('ynresphoenix_items'), array('ordering' => $iCnt),'type =\''.$sType.'\' AND item_id ='.$mKey);
        }

        return true;
    }
    public function deleteMultipleItems($aIds)
    {
        foreach ($aIds as $iId) {
            $this->deleteItem($iId);
        }
        return true;
    }

    public function deleteItem($iId)
    {
        $aPhotos = Phpfox::getService('ynresphoenix')->getPhotosByItem($iId);
        if(count($aPhotos))
        {
            $aSize = array(16, 32, 50,1024);$oFile = Phpfox_File::instance();
            foreach($aPhotos as $aPhoto) {
                if (!empty($aPhoto['photo_path'])) {
                    if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($aPhoto['photo_path'], ''))) {
                        $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($aPhoto['photo_path'], ''));
                    }
                    foreach ($aSize as $size) {
                        if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($aPhoto['photo_path'], '_' . $size))) {
                            $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($aPhoto['photo_path'], '_' . $size));
                        }
                    }
                }
            }
            $this->database()->delete(Phpfox::getT('ynresphoenix_photos'),'parent_id ='.$iId);
        }
        $aItem = $this->database()->select('*')
            ->from(Phpfox::getT('ynresphoenix_items'))
            ->where('item_id=' . (int) $iId)
            ->execute('getSlaveRow');
        if (isset($aItem['title']) && Core\Lib::phrase()->isPhrase($aItem['title'])){
            Phpfox::getService('language.phrase.process')->delete($aItem['title'], true);
        }
        if (isset($aItem['description']) && Core\Lib::phrase()->isPhrase($aItem['description'])){
            Phpfox::getService('language.phrase.process')->delete($aItem['description'], true);
        }
        $this->database()->delete(Phpfox::getT('ynresphoenix_items'), 'item_id = ' . (int) $iId);

        return true;
    }

    public function deletePhoto($iId,$iItemId = null)
    {
        $aPhoto = $this->database()->select('ysp.photo_id,ysp.photo_path,ysp.photo_type,ysp.server_id,ysp.description')
                        ->from(Phpfox::getT('ynresphoenix_photos'),'ysp')
                        ->where('ysp.photo_id ='.$iId)
                        ->execute('getRow');
        if($aPhoto)
        {
            $aSize = array(16,32,50,1024);
            $oFile = Phpfox_File::instance();
            if (!empty($aPhoto['photo_path'])) {
                if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($aPhoto['photo_path'], ''))) {
                    $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($aPhoto['photo_path'], ''));
                }
                foreach ($aSize as $size) {
                    if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($aPhoto['photo_path'], '_' . $size))) {
                        $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($aPhoto['photo_path'], '_' . $size));
                    }
                }
            }
            if (isset($aPhoto['description']) && Core\Lib::phrase()->isPhrase($aPhoto['description'])){
                Phpfox::getService('language.phrase.process')->delete($aPhoto['description'], true);
            }

            $this->database()->delete(Phpfox::getT('ynresphoenix_photos'),'photo_id ='.$iId);
            if($iItemId && $aPhoto['photo_type'] == 'main_photo')
            {
                $iNextPhoto = $this->database()->select('photo_id')
                                ->from(Phpfox::getT('ynresphoenix_photos'))
                                ->where('parent_id = '.$iItemId)
                                ->order('ordering')
                                ->execute('getField');
                if($iNextPhoto)
                    $this->database()->update(Phpfox::getT('ynresphoenix_photos'),['photo_type' => 'main_photo'],'photo_id ='.$iNextPhoto);
            }
        }
        return true;
    }

    public function updateItemPhoto($iParentId,$sPhotoType,$sPath,$sPageType,$bForce = false)
    {
        if(empty($sPath) || (!$iParentId && !$bForce))
        {
            return false;
        }
        $iPhotoId = $this->database()->select('photo_id')
                    ->from(Phpfox::getT('ynresphoenix_photos'))
                    ->where('parent_id = '.$iParentId.' AND photo_type like \''.$sPhotoType.'\' AND page_type =\''.$sPageType.'\'')
                    ->execute('getField');
        if((int)$iPhotoId && !$bForce)
        {
            $this->database()->update(Phpfox::getT('ynresphoenix_photos'),['photo_path' => $sPath,'user_id' => (int)Phpfox::getUserId(),'time_stamp' => PHPFOX_TIME],'photo_id ='.$iPhotoId);
            return true;
        }
        else{
            $aInsert = [
                'parent_id' => $iParentId,
                'photo_path' => $sPath,
                'photo_type' => $sPhotoType,
                'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID'),
                'page_type' => $sPageType,
                'user_id'   => (int)Phpfox::getUserId(),
                'time_stamp' => PHPFOX_TIME
            ];
            $id = $this->database()->insert(Phpfox::getT('ynresphoenix_photos'),$aInsert);
            return $id;
        }
    }

    public function updatePhotoCaption($iPhotoId,$aVals)
    {
        $aVals = $this->updatePhraseValue($aVals,'description');
        return $this->database()->update(Phpfox::getT('ynresphoenix_photos'),['description' => $aVals['description']],'photo_id ='.$iPhotoId);
    }

    public function updatePhotosOrdering($aParams,$iParentId = 0)
    {
        $iCnt = 0;
        foreach ($aParams['values'] as $mKey => $mOrdering)
        {
            $iCnt++;
            $this->database()->update(Phpfox::getT('ynresphoenix_photos'), array('ordering' => $iCnt),'photo_id ='.$mKey.' AND parent_id ='.$iParentId);
        }

        return true;
    }
    public function resetDefaultSettings($sType)
    {
        $aPageSetting = Phpfox::getService('ynresphoenix')->getPageDetailByType($sType);
        $oFile = Phpfox_File::instance();
        $aSize = array(16, 32, 50);
        if (!empty($aPageSetting['icon_path'])) {
            if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($aPageSetting['icon_path'], ''))) {
                $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($aPageSetting['icon_path'], ''));
            }
            foreach ($aSize as $size) {
                if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($aPageSetting['icon_path'], '_'.$size))) {
                    $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($aPageSetting['icon_path'], '_'.$size));
                }
            }
        }
        if (!empty($aPageSetting['icon_hover_path'])) {
            if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($aPageSetting['icon_hover_path'], ''))) {
                $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($aPageSetting['icon_hover_path'], ''));
            }
            foreach ($aSize as $size) {
                if (file_exists(Phpfox::getParam('core.dir_pic') . sprintf($aPageSetting['icon_hover_path'], '_'.$size))) {
                    $oFile->unlink(Phpfox::getParam('core.dir_pic') . sprintf($aPageSetting['icon_hover_path'], '_'.$size));
                }
            }
        }
        $aDefaultSetting = Phpfox::getService('ynresphoenix.helper')->getDefaultSettings($sType);
        if(empty($aDefaultSetting))
        {
            return false;
        }
        $this->database()->update(Phpfox::getT('block'),['title' => $aDefaultSetting['title']],'module_id = \'ynresphoenix\' AND m_connection = \'ynresphoenix.landing\' AND component =\''.$sType.'\'');
        $aDefaultSetting['params'] = json_encode($aDefaultSetting['params']);
        if($this->database()->update($this->_sTable,$aDefaultSetting,'type = \''.$sType.'\''))
            return true;
        return false;
    }

    public function updatePhraseValue($aVals,$sFieldName,$bIsRequire = false,$sVarName = 'title')
    {
        $aLanguages = Phpfox::getService('language')->getAll();
        $sDefault = Phpfox::getService('language')->getDefaultLanguage();
        $sDefaultLanguage = Phpfox::getService('language')->getLanguage($sDefault);
        $sValueDefault = strip_tags($aVals[$sFieldName . '_' . $sDefault], Phpfox::getParam('core.allowed_html'));

        if (Core\Lib::phrase()->isPhrase($aVals[$sFieldName])) {
            if (empty($sValueDefault) && $bIsRequire) {
                return _p($sVarName).' '.$sDefaultLanguage['title'].' '._p('is required');
            }
            foreach ($aLanguages as $aLanguage) {
                if (empty($aVals[$sFieldName . '_' . $aLanguage['language_id']])) {
                    $aVals[$sFieldName . '_' . $aLanguage['language_id']] = $sValueDefault;
                }
                Phpfox::getService('ban')->checkAutomaticBan($aVals[$sFieldName . '_' . $aLanguage['language_id']]);
                $name = strip_tags($aVals[$sFieldName . '_' . $aLanguage['language_id']], Phpfox::getParam('core.allowed_html'));
                Phpfox::getService('language.phrase.process')->updateVarName($aLanguage['language_id'], $aVals[$sFieldName], $name);
            }
        } else {
            if (empty($sValueDefault) && $bIsRequire) {
                return _p($sVarName).' '.$sDefaultLanguage['title'].' '._p('is required');
            }

            $name = strip_tags($aVals[$sFieldName . '_' . $aLanguages[0]['language_id']], Phpfox::getParam('core.allowed_html'));
            $phrase_var_name = 'ynresphoenix_setting_' . md5('Business Template' . $name . PHPFOX_TIME);

            //Validate phrases
            $aText = [];
            foreach ($aLanguages as $aLanguage) {
                if (empty($aVals[$sFieldName . '_' . $aLanguage['language_id']])) {
                    $aVals[$sFieldName . '_' . $aLanguage['language_id']] = $sValueDefault;
                }
                Phpfox::getService('ban')->checkAutomaticBan($aVals[$sFieldName . '_'. $aLanguage['language_id']]);
                $aText[$aLanguage['language_id']] = strip_tags($aVals[$sFieldName . '_' . $aLanguage['language_id']], Phpfox::getParam('core.allowed_html'));
            }
            $aValsPhrase = [
                'var_name' => $phrase_var_name,
                'text' => $aText
            ];
            $aVals[$sFieldName] = Phpfox::getService('language.phrase.process')->add($aValsPhrase);
        }
        return $aVals;
    }
}