<?php
namespace Apps\YNC_FbClone\Block;
use Phpfox_Component;
use Phpfox;
use Phpfox_Search;
use Phpfox_Pager;

class Friends extends Phpfox_Component
{
    function process()
    {
        $mUser = Phpfox::getLib('request')->get('req1');
        if (!$mUser) {
            if (Phpfox::isUser()) {
                $this->url()->send('profile');
            } else {
                Phpfox::isUser(true);
            }
        }
        $aUser = Phpfox::getService('user')->get($mUser, false);

        if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'friend.view_friend'))
        {
            $this->template()->assign([
                'sNotShareFriend' => _p('full_name_does_not_share_this_section', [
                    'full_name' => Phpfox::getService('user')->getFirstName($aUser['full_name'])
                ])
            ]);
            return Phpfox::getBlock('yncfbclone.friendprofileprivate');
        }
        $iMutualCount = '';
        $aMutalFriends = '';
        if ($aUser['user_id'] != Phpfox::getUserId()) {
            list($iMutualCount, $aMutalFriends) = Phpfox::getService('friend')->getMutualFriends($aUser['user_id']);
            foreach ($aMutalFriends as $iKey => $aFriend) {
                $aMutalFriends[$iKey]['is_friend'] = Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aFriend['user_id']);
            }
        }
        if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'friend.view_friend'))
        {
            return false;
        }

        $aFriends = Phpfox::getService('yncfbclone')->get('friend.is_page = 0 AND friend.user_id = ' . $aUser['user_id'], 'friend.is_top_friend DESC, friend.ordering ASC, RAND()', 0, '', false);
        $iCount = count($aFriends);
        foreach ($aFriends as $iKey => $aFriend) {
            $aFriends[$iKey]['is_friend'] = Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aFriend['user_id']);
            if (!$aFriends[$iKey]['is_friend']) {
                $aFriends[$iKey]['is_friend'] = (Phpfox::getService('friend.request')->isRequested(Phpfox::getUserId(), $aFriend['user_id']) ? 2 : false);
            }
            $aFriends[$iKey]['request_id'] = db()->select('request_id')->from(Phpfox::getT('friend_request'))->where('user_id =' . $aFriend['user_id'] .' AND friend_user_id='.Phpfox::getUserId())->executeField();
            $aFriends[$iKey]['is_friend_request'] = db()->select('request_id')->from(Phpfox::getT('friend_request'))->where('user_id =' . Phpfox::getUserId() .' AND friend_user_id='.$aFriend['user_id'])->executeField();

        }
        $IsInfoPage = $this->request()->get('req2');
        $sMore = '';
        $sLink = '';
        if ($IsInfoPage == 'info') {
            if ($iCount > 6) {
                $aFriends = array_slice($aFriends, 0, 6);
                $sMore = _p('see_all');
                $sLink = $this->url()->makeUrl($aUser['user_name'] . '/friend');
            }
            if ($iMutualCount > 6) {
                $aMutalFriends = array_slice($aMutalFriends, 0, 6);
                $sMore = _p('see_all');
                $sLink = $this->url()->makeUrl($aUser['user_name'] . '/friend');
            }
        }
        $iCntRequest = 0;
        $sHTML = '';
        if ($aUser['user_id'] == Phpfox::getUserId()) {
            $sLinkFriendRequest = $this->url()->makeUrl('friend.accept');
            $sLinkFindFriend = $this->url()->makeUrl('user.browse');
            $iCntRequest = Phpfox::getService('yncfbclone')->countFriendRequest(Phpfox::getUserId());
            if ($iCntRequest > 0) {
                $sHTML = '<a href="' . $sLinkFriendRequest .'" class="btn btn-default">' . _p('friend_requests') .'<span class="item-count">' .$iCntRequest.'</span>' . '</a>';
            }
            $sHTML .= '<a href="' . $sLinkFindFriend .'" class="btn btn-default"><i class="ico ico-plus mr-1"></i>' . _p('find_friends') . '</a>';
            $sHTML .= '<a href="' . $this->url()->makeUrl('user.privacy') .'" class="btn btn-default ynfbclone-friend-edit-privacy"><i class="ico ico-pencil"></i></a>';
            $sHTML .= '<div class="dropdown hide ynfbclone-profile-action-more">
                            <a class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="ico  ico-dottedmore"></i></a>
                            <ul class="dropdown-menu dropdown-menu-right" >
                            <li><a href="' . $sLinkFindFriend .'"><i class="ico ico-plus mr-1"></i>' . _p('find_friends') . '</a></li>
                            <li><a href="' . $this->url()->makeUrl('user.privacy') .'"><i class="ico ico-pencil"></i>'. _p('privacy_settings') .'</a></li>
                            </ul>
                        </div>';
        }
        $this->template()->assign([
            'sHeader' => _p('friend') . $sHTML,
            'aFriends' => $aFriends,
            'aSubject' => $aUser,
            'iCount' => $iCount,
            'iMutualCount' => $iMutualCount,
            'aMutalFriends' => $aMutalFriends,
            'iCntRequest' => $iCntRequest,
            'sMore' => $sMore,
            'sLink' => $sLink,
            'sPlaceholderKeyword' => _p('Search friend...'),
        ])->setPhrase(array(  // phrase for JS
            'results_for',
            'no_results_for',
            'confirm',
            'add_as_friend',
            'friend',
            'request_sent',
            'message',
            'report_this_user',
            'remove_friend',
            'cancel_request',
        ));
        return 'block';
    }

}