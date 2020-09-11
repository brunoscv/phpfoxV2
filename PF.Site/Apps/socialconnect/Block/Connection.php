<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
namespace Apps\Socialconnect\Block;

use Phpfox;
use Phpfox_Component;


class Connection extends Phpfox_Component
{
    public function process()
    {
        $aUser = $this->getParam('aUser');

        $aConnections = Phpfox::getService('socialconnect.data')->getUserSocial($aUser["user_id"]);

        if (empty($aConnections)) {
            return false;
        }

        $this->template()
            ->assign([
                'aConnections' => $aConnections,
                'social_path' =>  str_replace("index.php","PF.Site",Phpfox::getParam('core.path')) . "Apps/socialconnect/assets/images/",
            ]);
    }
}
