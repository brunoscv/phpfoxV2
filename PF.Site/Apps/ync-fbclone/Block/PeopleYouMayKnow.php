<?php

namespace Apps\YNC_FbClone\Block;
use Phpfox_Component;
use Phpfox;

class PeopleYouMayKnow extends Phpfox_Component
{
    public function process()
    {
        if (Phpfox::isModule('friend')){
            $aUsers = Phpfox::getService('friend.suggestion')->get();
            if (empty($aUsers)) {
                return false;
            }

            foreach ($aUsers as $iKey=>$aUser) {
                list($iMutualCount,) = Phpfox::getService('friend')->getMutualFriends($aUser['user_id'], 1);
                $aUsers[$iKey]['mutual_friend'] = $iMutualCount;
            }

            if (count($aUsers) > 5) {
                $this->template()->assign([
                    'aFooter' => array(
                        _p('view_all') => $this->url()->makeUrl('friend.suggestion'))
                ]);
            }
            $this->template()->assign([
                'aUsers' => $aUsers,
                'sHeader' => _p('people_you_may_know')
            ]);
            return 'block';
        } else {
            return false;
        }
    }
}