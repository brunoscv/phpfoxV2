<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:09
 */
defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Service_Ynresphoenix extends Phpfox_Service
{
    private $_sItemTable;

    public function __construct()
    {
        $this->_sTable = Phpfox::getT('ynresphoenix_pages');
        $this->_sItemTable = Phpfox::getT('ynresphoenix_items');
    }

    public function getAllPages()
    {
        $aBlocks = Phpfox::getService('ynresphoenix.helper')->getAllBlock();
        if(count($aBlocks))
        {
            foreach($aBlocks as $aBlock)
            {
                $this->database()->update($this->_sTable,['enabled' => $aBlock['is_active'],'ordering' => $aBlock['ordering'],'title'=>$aBlock['title']],'type = \''.$aBlock['component'].'\'');
            }
        }
        $aPages =  $this->database()->select('bp.*')
                        ->from($this->_sTable,'bp')
                        ->join(Phpfox::getT('block'),'b','b.component = bp.type AND module_id = \'ynresphoenix\' AND m_connection=\'ynresphoenix.landing\'')
                        ->order('bp.ordering')
                        ->execute('getRows');
        foreach($aPages as $key => $aPage){
            $aPages[$key]['params'] = json_decode($aPage['params'],true);
            $aPages[$key]['title'] = _p($aPage['title']);
            switch ($aPage['type']){
                case 'home':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-flag\"></i>";
                    break;
                case 'product':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-diamond\"></i>";
                    break;
                case 'member':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-user\"></i>";
                    break;
                case 'photo':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-picture-o\"></i>";
                    break;
                case 'testimonial':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-commenting\"></i>";
                    break;
                case 'contact':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-map-marker\"></i>";
                    break;
            }
        }
        return $aPages;
    }
    public function getPageDetailForEdit($sType)
    {
        $aBlock = Phpfox::getService('ynresphoenix.helper')->getOneBlock($sType);
        if($aBlock)
        {
            $this->database()->update($this->_sTable,['enabled' => $aBlock['is_active'],'ordering' => $aBlock['ordering'],'title'=>$aBlock['title']],'type = \''.$aBlock['component'].'\'');

        }
        $aPage =  $this->database()->select('bp.*')
                ->from($this->_sTable,'bp')
                ->join(Phpfox::getT('block'),'b','b.component = bp.type AND module_id = \'ynresphoenix\' AND m_connection=\'ynresphoenix.landing\'')
                ->where('bp.type = \''.$sType.'\'')
                ->execute('getRow');
        if($aPage)
        {
            $aTitles = $this->getPhraseText($aPage['title'],'title');
            $aDescription = $this->getPhraseText($aPage['description'],'description');
            $aPage['params'] = json_decode($aPage['params'],true);
            if(is_array($aPage['params'])){
                $aParams = Phpfox::getService('ynresphoenix.pages.'.$sType)->getPhraseText($aPage['params']);
                $aPage = array_merge($aPage,$aTitles,$aDescription,$aPage['params'],$aParams);
            }
            else{
                $aPage = array_merge($aPage,$aTitles,$aDescription);
            }
        }
        return $aPage;
    }
    public function getPageDetailByType($sType)
    {
        $aBlock = Phpfox::getService('ynresphoenix.helper')->getOneBlock($sType);
        if($aBlock)
        {
            $this->database()->update($this->_sTable,['enabled' => $aBlock['is_active'],'ordering' => $aBlock['ordering'],'title'=>$aBlock['title']],'type = \''.$aBlock['component'].'\'');

        }
        $aPage =  $this->database()->select('bp.*')
                ->from($this->_sTable,'bp')
                ->join(Phpfox::getT('block'),'b','b.component = bp.type AND module_id = \'ynresphoenix\' AND m_connection=\'ynresphoenix.landing\'')
                ->where('bp.type = \''.$sType.'\'')
                ->execute('getRow');
        if($aPage)
        {
            $aPage['params'] = json_decode($aPage['params'],true);
        }
        return $aPage;
    }
    public function getManageItemByPage($sType)
    {
        $aItems =  $this->database()->select('*')
                        ->from(Phpfox::getT('ynresphoenix_items'))
                        ->where('page_type = \''.$sType.'\'')
                        ->order('ordering')
                        ->execute('getRows');
        if(count($aItems)) {
            foreach ($aItems as $key => $aItem) {
                $aPhoto = $this->database()->select('photo_path,server_id')
                    ->from(Phpfox::getT('ynresphoenix_photos'))
                    ->where('parent_id =' . $aItem['item_id'] . ' AND page_type = \'' . $sType . '\' AND'. (($sType == 'product') ? ' photo_type = \'main_photo\'' :' photo_type = \'photo\''))
                    ->execute('getRows');
                if ($aPhoto) {
                    $aItems[$key]['photo_path'] = $aPhoto[0]['photo_path'];
                    $aItems[$key]['server_id'] = $aPhoto[0]['server_id'];
                } else {
                    $aItems[$key]['photo_path'] = '';
                    $aItems[$key]['server_id'] = 0;
                }
                $aItems[$key]['total_photo'] = count($aPhoto);
                $aItems[$key]['params'] = json_decode($aItem['params'], true);
            }

        }

        return $aItems;
    }
    public function getPhotosByItem($iItemId)
    {
        return $this->database()->select('ysp.photo_id,ysp.photo_path,ysp.photo_type,ysp.server_id')
                    ->from(Phpfox::getT('ynresphoenix_photos'),'ysp')
                    ->join(Phpfox::getT('ynresphoenix_items'),'ysi','ysp.parent_id = ysi.item_id')
                    ->where('ysp.parent_id ='.$iItemId)
                    ->execute('getRows');
    }

    public function getItem($iItemId)
    {
        $aItem = $this->database()->select('*')
            ->from($this->_sItemTable)
            ->where('item_id ='.$iItemId)
            ->execute('getRow');
        if($aItem)
        {
            $aItem['params'] = json_decode($aItem['params'],true);
            $aPhotos = $this->getPhotosByItem($iItemId);
            if(count($aPhotos))
            {
                foreach($aPhotos as $key => $aPhoto)
                {
                    $aItem[$aPhoto['photo_type']] = $aPhoto['photo_path'];
                    $aItem['server_id'] = $aPhoto['server_id'];
                }
            }
            $aTitles = $this->getPhraseText($aItem['title'],'title');
            $aDescription = $this->getPhraseText($aItem['description'],'description');
            if(is_array($aItem['params'])){
                $aParams = Phpfox::getService('ynresphoenix.pages.'.$aItem['page_type'])->getItemPhraseText($aItem['params']);
                $aItem = array_merge($aItem,$aTitles,$aDescription,$aItem['params'],$aParams);
            }
            else{
                $aItem = array_merge($aItem,$aTitles,$aDescription);
            }
        }
        return $aItem;
    }

    public function getCountPhotos($sType,$iLimit,$iParentId = 0)
    {
        $iCount =  $this->database()->select('COUNT(*)')
            ->from(Phpfox::getT('ynresphoenix_photos'))
            ->where('page_type = \''.$sType.'\' AND parent_id = '.$iParentId)
            ->execute('getField');
        return ($iLimit - (int)$iCount);
    }

    public function getAllPhotos($sType,$iParentId = 0,$sPageType = null)
    {
        $aPhotos =  $this->database()->select('ysp.*')
                            ->from(Phpfox::getT('ynresphoenix_photos'),'ysp')
                            ->join($this->_sTable,'yrp','yrp.type = ysp.page_type')
                            ->where('ysp.page_type = \''.$sType.'\' AND ysp.parent_id = '.$iParentId)
                            ->order('ysp.ordering ASC,ysp.photo_id DESC')
                            ->execute('getRows');
        if(count($aPhotos) && $sPageType == 'photo')
        {
            foreach($aPhotos as $key => $aPhoto)
            {
                $aDescription = $this->getPhraseText($aPhoto['description'],'description');
                $aPhotos[$key] = array_merge($aPhoto,$aDescription);
            }
        }
        return $aPhotos;
    }
    public function getItemByPage($sType)
    {
        $aItems = $this->database()->select('*')
            ->from($this->_sItemTable)
            ->where('page_type = \''.$sType.'\'')
            ->order('ordering')
            ->execute('getRows');
        if($aItems)
        {
            foreach ($aItems as $key => $aItem) {
                $aItems[$key]['params'] = json_decode($aItem['params'],true);
                $aPhotos = $this->getAllPhotos($sType,$aItem['item_id']);

                if($aPhotos)
                {
                    foreach ($aPhotos as $aPhoto) {
                        if($aPhoto['photo_type'] == 'photo')
                        {
                            if($sType == 'product' || $sType == 'photo'){
                                $aItems[$key]['photos'][] = $aPhoto;
                            }
                            else{
                                $aItems[$key]['photo'] = $aPhoto;
                            }
                        }
                        elseif($aPhoto['photo_type'] == 'main_photo')
                        {
                            $aItems[$key]['main_photo'] = $aPhoto;
                            if($sType == 'product')
                                $aItems[$key]['photos'][] = $aPhoto;
                        }
                        elseif($aPhoto['photo_type'] == 'icon')
                        {
                            $aItems[$key]['icon'] = $aPhoto;
                        }
                        elseif($aPhoto['photo_type'] == 'hover')
                        {
                            $aItems[$key]['hover'] = $aPhoto;
                        }
                    }
                }
            }
        }
        return $aItems;
    }
    public function getActivePages()
    {
        $aBlocks = Phpfox::getService('ynresphoenix.helper')->getAllBlock();
        if(count($aBlocks))
        {
            foreach($aBlocks as $aBlock)
            {
                $this->database()->update($this->_sTable,['enabled' => $aBlock['is_active'],'ordering' => $aBlock['ordering'],'title'=>$aBlock['title']],'type = \''.$aBlock['component'].'\'');
            }
        }
        $aPages =  $this->database()->select('bp.*')
            ->from($this->_sTable,'bp')
            ->join(Phpfox::getT('block'),'b','b.component = bp.type AND module_id = \'ynresphoenix\' AND m_connection=\'ynresphoenix.landing\'')
            ->order('bp.ordering')
            ->where('bp.enabled = 1')
            ->execute('getRows');
        foreach($aPages as $key => $aPage){
            $aPages[$key]['title'] = \Core\Lib::phrase()->isPhrase($aPage['title']) ? _p($aPage['title']) : $aPage['title'];
            switch ($aPage['type']){
                case 'home':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-flag\"></i>";
                    $aPages[$key]['div_id'] = "#ynresphoenix_home";
                    break;
                case 'member':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-user\"></i>";
                    $aPages[$key]['div_id'] = "#ynresphoenix_member";
                    break;
                case 'product':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-diamond\"></i>";
                    $aPages[$key]['div_id'] = "#ynresphoenix_product";
                    break;
                case 'photo':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-picture-o\"></i>";
                    $aPages[$key]['div_id'] = "#ynresphoenix_photo";
                    break;
                case 'testimonial':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-commenting\"></i>";
                    $aPages[$key]['div_id'] = "#ynresphoenix_testimonial";
                    break;
                case 'contact':
                    $aPages[$key]['default_icon'] = "<i class=\"fa fa-map-marker\"></i>";
                    $aPages[$key]['div_id'] = "#ynresphoenix_contact";
                    break;
            }
            $aPages[$key]['params'] = json_decode($aPage['params'],true);
        }
        return $aPages;
    }
    public function getPhraseText($sVar,$sName)
    {
        if (substr($sVar, 0, 7) == '{phrase' && substr($sVar, -1) == '}') {
            $sVar = preg_replace('/\s+/', ' ', $sVar);
            $sVar = str_replace([
                "{phrase var='",
                "{phrase var=\"",
                "'}",
                "\"}"
            ], "", $sVar);
        }//End support legacy
        $aLanguages = Phpfox::getService('language')->getAll();
        $aRow = [];
        foreach ($aLanguages as $aLanguage){
            $sPhraseValue = (Core\Lib::phrase()->isPhrase($sVar)) ? _p($sVar, [], $aLanguage['language_id']) : $sVar;
            $aRow[$sName. '_' . $aLanguage['language_id']] = $sPhraseValue;
        }
        return $aRow;
    }
}