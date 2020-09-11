<?php

/**
 * [PHPFOX_HEADER]
 */
defined('PHPFOX') or exit('NO DICE!');

/**
 *
 * @version        4.01
 * @package        Ynclean
 *
 * @author         YouNetCo
 * @copyright      [YouNetCo]
 */
class Ynresphoenix_Component_Ajax_Ajax extends Phpfox_Ajax
{
    public function updateActivity()
    {
        Phpfox::isAdmin(true);
        if(Phpfox::getService('ynresphoenix.process')->updateActive($this->get('id'),$this->get('active')))
        {
            Phpfox::getLib('cache')->remove('block_all');
        }
    }
    public function pagesOrdering()
    {
        Phpfox::isAdmin(true);
        $aVals = $this->get('val');
        Phpfox::getService('core.process')->updateOrdering(array(
                               'table' => 'ynresphoenix_pages',
                               'key' => 'page_id',
                               'values' => $aVals['ordering']
                           )
        );
        Phpfox::getService('ynresphoenix.process')->updateBlockOrdering(array(
                            'values' => $aVals['ordering']
                         ));
        Phpfox::getLib('cache')->remove('block_all');
    }
    public function itemOrdering()
    {
        Phpfox::isAdmin(true);
        $sItemType = $this->get('type');
        $aVals = $this->get('val');
        Phpfox::getService('ynresphoenix.process')->updateItemsOrdering($sItemType,array('values' => $aVals['ordering']));
    }

    public function deletePhoto()
    {
        Phpfox::isAdmin(true);
        $iPhotoId = $this->get('id');
        $iProductId = $this->get('product_id',0);
        if(!$iPhotoId)
        {
            return false;
        }
        Phpfox::getService('ynresphoenix.process')->deletePhoto($iPhotoId,$iProductId);
        Phpfox::addMessage(_p('Photo successfully deleted'));
        $this->call('window.location.reload();');
    }
    public function updatePhotoCaption()
    {
        Phpfox::isAdmin(true);
        $iId = $this->get('id');
        $aVals = $this->get('aVals');
        if (!$iId) {
            return false;
        }
        if (Phpfox::getService('ynresphoenix.process')->updatePhotoCaption($iId, $aVals))
        {
            $this->alert(_p('Caption updated successfully'),null,300,150,true);
        }
        else{
            $this->alert(_p('Caption updated failed, please try again'),null,300,150,true);
        }
    }
    public function updatePhotoOrdering()
    {
        $aVals = $this->get('val');
        $iParentId = $this->get('iParent',0);
        Phpfox::getService('ynresphoenix.process')->updatePhotosOrdering(array('values' => $aVals['ordering']),$iParentId);
    }
    public function setMainPhoto()
    {
        $iPhotoId = $this->get('photo_id');
        $iProductId = $this->get('product_id');
        if(!$iPhotoId || !$iProductId)
        {
            return false;
        }
        if(Phpfox::getService('ynresphoenix.pages.product')->setMainPhoto($iProductId,$iPhotoId))
        {
            //$this->call('$(".js_photo_item").find("span").removeClass("is_main_photo");');
            //$this->call('$("#js_photo_item_'.$iPhotoId.'").addClass("is_main_photo");');
            $this->alert(_p('Successfully set main photo for this product'),null,300,150,true);
        }
    }
}
