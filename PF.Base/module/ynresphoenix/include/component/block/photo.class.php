<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Component_Block_Photo extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aSettings = Phpfox::getService('ynresphoenix')->getPageDetailByType('photo');
        $aGalleries = Phpfox::getService('ynresphoenix')->getItemByPage('photo');
        $this->template()->assign(array(
            'aPhotoSettings' => $aSettings,
            'aGalleries' => $aGalleries
        ));
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('ynresphoenix.component_block_welcome_clean')) ? eval($sPlugin) : false);
    }
}
