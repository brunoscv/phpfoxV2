<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Component_Block_Home extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aSettings = Phpfox::getService('ynresphoenix')->getPageDetailByType('home');
        $aPhotos = Phpfox::getService('ynresphoenix')->getAllPhotos('home');
        $bNoPhotos = false;
        if(!$aPhotos || count($aPhotos) == 0)
        {
            $bNoPhotos = true;
        }
        $this->template()->assign(array(
            'sPathFile' => Phpfox::getParam('core.path_file'),
            'aHomeSettings' => $aSettings,
            'aPhotos'   => $aPhotos,
            'bNoPhotos' => $bNoPhotos
        ));
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('ynresphoenix.component_block_home_clean')) ? eval($sPlugin) : false);
    }
}
