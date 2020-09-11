<?php
namespace Apps\YNC_FbClone\Block;
use Phpfox_Component;
use Phpfox;

class Videos extends Phpfox_Component
{
    function process()
    {
        if (!defined('PHPFOX_IS_USER_PROFILE')) {
            return false;
        }

        if (!Phpfox::isModule('v')) {
            return false;
        }

        $sMore = '';
        $sLink = '';
        $mUser = Phpfox::getLib('request')->get('req1');
        if (!$mUser) {
            if (Phpfox::isUser()) {
                $this->url()->send('profile');
            } else {
                Phpfox::isUser(true);
            }
        }

        $aUser = Phpfox::getService('user')->get($mUser, false);

        if (!$this->request()->get('req2')) {
            return false;
        }
        $IsInfoPage = $this->request()->get('req2');

        $aVideos = Phpfox::getService('yncfbclone')->getVideoForProfile($aUser['user_id']);
        $iCntVideos = Phpfox::getService('yncfbclone')->countVideos($aUser['user_id']);
        foreach ($aVideos as $iKey => $aVideo) {
            $aVideos[$iKey]['link'] = Phpfox::permalink('video.play', $aVideo['video_id'], $aVideo['title']);
            $aVideos[$iKey]['image_path'] = Phpfox::getService('yncfbclone')->convertImagePath($aVideo, 500);
            if ($aVideo['duration']) {
                $aVideos[$iKey]['duration'] = Phpfox::getService('v.video')->getDuration($aVideo['duration']);
            }

            if (Phpfox::isModule('privacy')) {
                if (!Phpfox::getService('privacy')->check('v', $aVideo['video_id'], $aVideo['user_id'],
                    $aVideo['privacy'],
                    $aVideo['is_friend'], true)) {
                    $aVideos[$iKey]['is_not_show'] = true;
                }
            }
            Phpfox::getService('v.video')->getPermissions($aVideos[$iKey]);

            if ($aVideos[$iKey]['is_not_show']) {
                unset($aVideos[$iKey]);
            }
        }

        if ($IsInfoPage == 'info') {
            if ($iCntVideos > 10) {
                $aVideos = array_slice($aVideos, 0, 10);
                $sMore = _p('see_all');
                $sLinkViewMore = $this->url()->makeUrl($aUser['user_name'] . '/video');
            }
        }


        $sHTML = '';
        if ($aUser['user_id'] == Phpfox::getUserId()) {
            $sLink = $this->url()->makeUrl('video.share');
            $sHTML = '<a href="' . $sLink .'" class="btn btn-default ynfbclone-profile-action-one"><i class="ico ico-plus"></i><span class="item-text">' . _p('add_videos') . '</span></a>';
        }

        $bModeratorVideoActive = false;
        if ($this->request()->get('req2') == 'video' && $this->request()->get('req3') == '') {
            $bModeratorVideoActive = true;
        }

        $aModerationMenus = [];
        $bShowModerator = false;
        if (user('pf_video_delete_all_video') || Phpfox::isAdmin()) {
            $aModerationMenus[] = [
                'phrase' => _p('Delete'),
                'action' => 'delete',
            ];
        }


        if (user('pf_video_feature')) {
            $aModerationMenus[] = array(
                'phrase' => _p('feature'),
                'action' => 'feature'
            );
            $aModerationMenus[] = array(
                'phrase' => _p('un_feature'),
                'action' => 'un-feature'
            );
        }

        if (count($aModerationMenus)) {
            $this->setParam('global_moderation', [
                    'name' => 'video',
                    'ajax' => 'v.moderation',
                    'menu' => $aModerationMenus
                ]
            );
            $bShowModerator = true;
        }

        $this->template()->assign([
            'sHeader' => _p('videos') . $sHTML,
            'aVideos' => $aVideos,
            'sMore' => $sMore,
            'sLink' => $sLink,
            'sLinkViewMore' => $sLinkViewMore,
            'bModeratorVideoActive' => $bModeratorVideoActive,
            'bShowModerator' => $bShowModerator,
        ]);
        return 'block';
    }
}