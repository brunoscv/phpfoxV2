<?php

namespace Apps\YNC_FbClone\Controller;

use Phpfox_Component;
use Phpfox;

defined('PHPFOX') or exit('NO DICE!');

class FriendProfile extends Phpfox_Component
{
    public function process()
    {
        Phpfox::getBlock('yncfbclone.friends');
        return;
    }
}
