<?php
namespace Apps\YNC_FbClone\Block;
use Phpfox_Component;
use Phpfox;

class Photos extends Phpfox_Component
{
    function process()
    {
        if (!Phpfox::isModule('photo')) {
            return false;
        }

        $sFullControllerName = Phpfox::getLib('module')->getFullControllerName();
        if ($sFullControllerName == 'photo.index' || $sFullControllerName == 'photo.albums') {
            return false;
        }

        $sMore = '';
        $sLinkPhoto = '';
        $sLinkAlbums = '';
        $mUser = Phpfox::getLib('request')->get('req1');
        if (!$mUser) {
            if (Phpfox::isUser()) {
                $this->url()->send('profile');
            } else {
                Phpfox::isUser(true);
            }
        }
        $aUser = Phpfox::getService('user')->get($mUser, false);

        if(!$this->request()->get('req2') || $this->request()->get('req2') == 'albums') {
            return false;
        }

        $IsInfoPage = $this->request()->get('req2');
        $sWhere = 'p.view_id = 0 AND p.group_id = 0 AND p.privacy IN(0,1,2,3,4) AND p.user_id = ' . $aUser['user_id']
            . ((!Phpfox::getParam('photo.display_profile_photo_within_gallery')) ? ' AND p.is_profile_photo IN (0)' : '')
            . ((!Phpfox::getParam('photo.display_cover_photo_within_gallery')) ? ' AND p.is_cover_photo IN (0)' : '')
            . ((!Phpfox::getParam('photo.display_timeline_photo_within_gallery')) ? ' AND p.type_id = 0' : '');

        list(, $aPhotos) = Phpfox::getService('photo')->get( $sWhere, 'p.photo_id DESC', '');
        foreach ( $aPhotos as $iKey => $aPhoto)
        {
            $aPhotos[$iKey] = Phpfox::getService('photo')->canViewItem($aPhotos[$iKey]['photo_id'], true);
            if (empty($aPhotos[$iKey])) {
                unset($aPhotos[$iKey]);
            }
        }

        $iCntPhoto = count($aPhotos);
        $aModerationMenu = [];
        $bShowModerator = false;

        if (Phpfox::getUserParam('photo.can_feature_photo')) {
            $aModerationMenu[] = array(
                'phrase' => _p('feature'),
                'action' => 'feature'
            );
            $aModerationMenu[] = array(
                'phrase' => _p('un_feature'),
                'action' => 'un-feature'
            );
        }
        if (Phpfox::getUserParam('photo.can_delete_other_photos') || Phpfox::isAdmin()) {
            $aModerationMenu[] = array(
                'phrase' => _p('delete'),
                'action' => 'delete'
            );
        }

        $bIsPhotoProfile = 0;
        $bModeratorPhotoActive = false;
        if ($this->request()->get('req2') == 'photo' && $this->request()->get('req3') == '') {
            $bModeratorPhotoActive = true;
            $bIsPhotoProfile = 1;
            if (count($aModerationMenu) && $this->request()->get('mode') != 'edit') {
                $this->setParam('global_moderation', array(
                        'name' => 'photo',
                        'ajax' => 'photo.moderation',
                        'menu' => $aModerationMenu
                    )
                );
                $bShowModerator = true;
            }
        }

        $this->template()
            ->assign(array(
                    'bShowModerator' => $bShowModerator,
                    'bModeratorPhotoActive' => $bModeratorPhotoActive,
                    'bIsPhotoProfile' => $bIsPhotoProfile
                )
            );

        list(, $aAlbums) = Phpfox::getService('photo.album')->get('pa.view_id = 0 AND pa.group_id = 0 AND pa.privacy IN(0,1,2,3,4) AND pa.user_id =' . (int)$aUser['user_id'] . ' AND pa.profile_id = 0 AND pa.cover_id = 0 AND pa.timeline_id = 0', 'pa.album_id DESC', '', '');
        foreach ($aAlbums as $iAlbumKey => $aAlbum) {
            $aAlbums[$iAlbumKey]['link'] = Phpfox::permalink('photo.album', $aAlbum['album_id'], $aAlbum['name']);
            switch ($aAlbum['privacy']) {
                case 0:
                case 1:
                case 2:
                    $aAlbums[$iAlbumKey]['privacy_text'] = _p('public');
                break;
                case 3:
                    $aAlbums[$iAlbumKey]['privacy_text'] = _p('only_me');
                break;
                case 4:
                    $aAlbums[$iAlbumKey]['privacy_text'] = _p('custom');
                break;
            }
            if (Phpfox::isModule('privacy')) {
                if (!Phpfox::getService('privacy')->check('photo_album', $aAlbum['album_id'], $aAlbum['user_id'],
                    $aAlbum['privacy'], $aAlbum['is_friend'], true)) {
                    $aAlbums[$iAlbumKey]['is_not_show'] = true;
                }
            }
            Phpfox::getService('photo.album')->getPermissions($aAlbums[$iAlbumKey]);
            if ( $aAlbums[$iAlbumKey]['is_not_show']) {
                unset( $aAlbums[$iAlbumKey]);
            }
        }
        $iCntAlbum = count($aAlbums);
        $bModeratorAlbumActive = false;
        $bShowModeratorAlbum = false;

        if ($this->request()->get('req3') == 'albums' && $this->request()->get('req4') == '') {
            $bModeratorAlbumActive = true;

            if (Phpfox::getUserParam('photo.can_delete_other_photo_albums') || Phpfox::isAdmin()) {
                $this->setParam('global_moderation', array(
                        'name' => 'album',
                        'ajax' => 'photo.albumModeration',
                        'menu' => array(
                            array(
                                'phrase' => _p('delete'),
                                'action' => 'delete'
                            )
                        )
                    )
                );
                $bShowModeratorAlbum = true;
            }
        }



        $this->template()
            ->clearBreadCrumb()
            ->assign(array(
                    'bShowModeratorAlbum' => $bShowModeratorAlbum,
                    'bModeratorAlbumActive' => $bModeratorAlbumActive
                )
            );

        $bIsInfoPages = false;
        if ($IsInfoPage == 'info') {
            $bIsInfoPages = true;
            if ($iCntPhoto  > 10) {
                $aPhotos = array_slice($aPhotos, 0, 10);
                $sMore = _p('see_all');
                $sLinkPhoto = $this->url()->makeUrl($aUser['user_name'].'/photo');
            }
            if ($iCntAlbum  > 3) {
                $aAlbums = array_slice($aAlbums, 0, 3);
                $sMore = _p('see_all');
                $sLinkAlbums = $this->url()->makeUrl($aUser['user_name'].'/photo.albums');
            }
        }

        $sHTML = '';
        if ($aUser['user_id'] == Phpfox::getUserId()) {
            $sLink = $this->url()->makeUrl('photo.add');
            $sHTML = '<button onclick="$Core.box(\'yncfbclone.newAlbum\', 500, \'module=&amp;item=0\'); return false;" type="button" class="btn btn-default js_yncfbclone_create_album"><span class="ico ico-plus mr-1"></span>' .  _p('create_album') . '</button>';
            $sHTML .= '<a href="' . $sLink .'" class="btn btn-default">' . _p('add_photos') . '</a>';
            $sHTML .= '<div class="dropdown hide ynfbclone-profile-action-more">
                            <a class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="ico  ico-dottedmore"></i></a>
                            <ul class="dropdown-menu dropdown-menu-right" >
                            <li><a onclick="$Core.box(\'yncfbclone.newAlbum\', 500, \'module=&amp;item=0\'); return false;" href="javascript:void(0);"><i class="ico ico-plus mr-1"></i>' . _p('create_album') . '</a></li>
                            <li><a href="' . $sLink .'"><i class="ico ico-plus mr-1"></i>' . _p('add_photos') . '</a></li>
                            </ul>
                        </div>';
        }
        $this->template()->assign([
            'sHeader' => _p('photos') . $sHTML,
            'aPhotos' => $aPhotos,
            'aAlbums' => $aAlbums,
            'sMore' => $sMore,
            'sLinkPhoto' => $sLinkPhoto,
            'sLinkAlbums' => $sLinkAlbums,
            'iCntPhoto' => $iCntPhoto,
            'iCntAlbum' => $iCntAlbum,
            'bIsInfoPages' => $bIsInfoPages,
            'sName' => $aUser['user_name']
        ]);
        return 'block';
    }
}