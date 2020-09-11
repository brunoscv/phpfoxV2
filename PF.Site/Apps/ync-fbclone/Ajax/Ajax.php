<?php
namespace Apps\YNC_FbClone\Ajax;
use Phpfox_Ajax;
use Phpfox;
use Phpfox_Template;

class Ajax extends Phpfox_Ajax
{
    function tooglePin()
    {
        $Id = $this->get('item_id');
        $iPin = $this->get('is_pin');
        Phpfox::getService('yncfbclone')->tooglePin($Id, $iPin);    
    }
    function toogleHidden()
    {
        $Id = $this->get('item_id');
        Phpfox::getService('yncfbclone')->toogleHidden($Id);
        $this->call('$Core.reloadPage();');
    }

    public function editShortcuts()
    {
        Phpfox::getBlock('yncfbclone.edit-shortcuts');
    }

    public function updateStatus()
    {
        $data = $this->get('data');
        Phpfox::getService('yncfbclone')->updateShortcutStatus(json_decode($data, true));
        $this->call('$Core.reloadPage();');
    }

    public function add()
    {
        Phpfox::isUser(true);
        if (Phpfox::getService('yncfbclone')->add($this->get('type_id'), $this->get('item_id'), null,
            $this->get('custom_app_id', null), [], $this->get('table_prefix', ''))
        ) {
            $iPhotoId = $this->get('item_id');
            $iTotalLike = Phpfox::getService('yncfbclone')->getTotalLike($iPhotoId);
            $this->html('#js_yncfbclone_total_like_' . $iPhotoId, '');
            $this->html('#js_yncfbclone_total_like_' . $iPhotoId, $iTotalLike);
        }
    }

    public function delete()
    {
        Phpfox::isUser(true);

        if (Phpfox::getService('like.process')->delete($this->get('type_id'), $this->get('item_id'),
            (int)$this->get('force_user_id'), false, $this->get('table_prefix', ''))
        ) {
            $iPhotoId = $this->get('item_id');
            $iTotalLike = Phpfox::getService('yncfbclone')->getTotalLike($iPhotoId);
            $this->html('#js_yncfbclone_total_like_' . $iPhotoId, '');
            $this->html('#js_yncfbclone_total_like_' . $iPhotoId, $iTotalLike);
        }
    }

    public function newAlbum()
    {
        if (!Phpfox::isModule('photo')) {
            return false;
        }
        $this->setTitle(_p('create_a_new_photo_album'));
        Phpfox::isUser(true);
        Phpfox::getUserParam('photo.can_create_photo_album', true);
        Phpfox::getBlock('yncfbclone.create-album');
        $this->call('<script type="text/javascript">$Core.loadInit();</script>');
    }

    public function addAlbum()
    {
        if (!Phpfox::isModule('photo')) {
            return false;
        }
        Phpfox::isUser(true);
        Phpfox::getUserParam('photo.can_create_photo_album', true);
        $iTotalAlbums = Phpfox::getService('photo.album')->getAlbumCount(Phpfox::getUserId());
        $bAllowedAlbums = (Phpfox::getUserParam('photo.max_number_of_albums') == '' ? true : (!Phpfox::getUserParam('photo.max_number_of_albums') ? false : (Phpfox::getUserParam('photo.max_number_of_albums') <= $iTotalAlbums ? false : true)));
        if (!$bAllowedAlbums) {
            $this->alert(_p('you_have_reached_your_limit_you_are_currently_unable_to_create_new_photo_albums'));
            return false;
        }
        $aVals = $this->get('val');
        if ($iId = Phpfox::getService('photo.album.process')->add($aVals)) {
            $sName = Phpfox::getLib('database')->select('user_name')
                    ->from(':user')
                    ->where('user_id = ' . (int)Phpfox::getUserId())
                    ->executeField();
            $this->call('window.location.href="' . Phpfox::getLib('url')->makeUrl($sName . '/photo.albums') . '"');
        }
    }

    public function redirectAlbum()
    {
        $sName = $this->get('name');
        $this->call('window.location.href="' . Phpfox::getLib('url')->makeUrl($sName . '/photo.albums') . '"');
    }

    public function redirectPhoto()
    {
        $sName = $this->get('name');
        $this->call('window.location.href="' . Phpfox::getLib('url')->makeUrl($sName . '/photo') . '"');
    }

    public function ajaxGetUsers()
    {
        $sSearch = $this->get('search_for');
        $iLimit = $this->get('total_search');

        $this->call('$Cache.users = ' . json_encode(Phpfox::getService('yncfbclone')->getUsersFromCache($sSearch, $iLimit)) . ';');
        if ($sSearch != '') {
            $this->call('$Core.autoSuggestFriends.generateSelectBox();');
        }
    }

    public function ajaxGetFriends()
    {
        $sSearch = $this->get('search_for');
        $iLimit = $this->get('total_search');
        $iId = $this->get('profile_id');

        $this->call('$Cache.users = ' . json_encode(Phpfox::getService('yncfbclone')->getUsersFriendFromCache($sSearch, $iLimit, $iId)) . ';');
        if ($sSearch != '') {
            $this->call('$Core.autoSuggestFriendsInfo.generateSelectBox();');
        }
    }

    public function ajaxGetMutualFriends()
    {
        $sSearch = $this->get('search_for');
        $iLimit = $this->get('total_search');
        $iId = $this->get('profile_id');

        $this->call('$Cache.users = ' . json_encode(Phpfox::getService('yncfbclone')->getUsersMutualFriendFromCache($sSearch, $iLimit, $iId)) . ';');
        if ($sSearch != '') {
            $this->call('$Core.autoSuggestMutualFriendsInfo.generateSelectBox();');
        }
    }
}
