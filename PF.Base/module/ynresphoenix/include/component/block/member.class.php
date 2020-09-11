<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Component_Block_Member extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aSettings = Phpfox::getService('ynresphoenix')->getPageDetailByType('member');
        $aMembers = Phpfox::getService('ynresphoenix')->getItemByPage('member');
        $this->template()->assign(array(
            'aMemberSettings' => $aSettings,
            'aMembers' => $aMembers
        ));
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('ynresphoenix.component_block_photo_clean')) ? eval($sPlugin) : false);
    }
}
