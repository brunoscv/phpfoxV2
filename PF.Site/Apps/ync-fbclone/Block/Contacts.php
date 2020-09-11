<?php

namespace Apps\YNC_FbClone\Block;

use Phpfox_Component;
use Phpfox;

class Contacts extends Phpfox_Component
{
    function process()
    {
        $aUsers = Phpfox::getService('yncfbclone')->getFriendContact();

        $this->template()
            ->setPhrase([
                'no_friends_found'
            ])
            ->assign([
                'sHeader' => _p('contacts'),
                'aUsers' => $aUsers,
            ]);
        return 'block';
    }

}