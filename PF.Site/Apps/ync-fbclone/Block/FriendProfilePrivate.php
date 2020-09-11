<?php

namespace Apps\YNC_FbClone\Block;

use Phpfox_Component;
use Phpfox;

defined('PHPFOX') or exit('NO DICE!');

class FriendProfilePrivate extends Phpfox_Component
{
    public function process()
    {
        $sController = Phpfox::getLib("module")->getfullControllerName();
        if ($sController == 'profile.info') {
            return false;
        }
        $mUser = Phpfox::getLib('request')->get('req1');
        if (!$mUser) {
            if (Phpfox::isUser()) {
                $this->url()->send('profile');
            } else {
                Phpfox::isUser(true);
            }
        }
        $aUser = Phpfox::getService('user')->get($mUser, false);

        $this->template()->assign([
            'sNotShareFriend' => _p('full_name_does_not_share_this_section', [
                'full_name' => Phpfox::getService('user')->getFirstName($aUser['full_name'])
            ])
        ]);

        return 'block';
    }
}
