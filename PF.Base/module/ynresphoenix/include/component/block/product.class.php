<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Component_Block_Product extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aSettings = Phpfox::getService('ynresphoenix')->getPageDetailByType('product');
        $aProducts = Phpfox::getService('ynresphoenix')->getItemByPage('product');
        $this->template()->assign(array(
            'aProductSettings' => $aSettings,
            'aProducts' => $aProducts
        ));
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('ynresphoenix.component_block_product_clean')) ? eval($sPlugin) : false);
    }
}
