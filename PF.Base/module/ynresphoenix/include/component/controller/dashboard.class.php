<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @version         4.01
 * @package         Module_Ynclean
 *
 * @author          YouNetCo
 * @copyright       [YouNetCo]
 */
class Ynresphoenix_Component_Controller_Dashboard extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        return Phpfox_Module::instance()->setController('core.index-member');
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('ynclean.component_controller_dashboard_clean')) ? eval($sPlugin) : false);
    }
}
