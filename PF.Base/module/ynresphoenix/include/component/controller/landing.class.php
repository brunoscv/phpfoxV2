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
class Ynresphoenix_Component_Controller_Landing extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aPages = Phpfox::getService('ynresphoenix')->getActivePages();

        $this->template()->setHeader([
            'ynresphoenix.js' => 'module_ynresphoenix',
            'owl.carousel.min.js' => 'module_ynresphoenix',
            'owl.carousel_v1.js' => 'module_ynresphoenix',
            'owl-carousel/owl.carousel.css' => 'module_ynresphoenix',
            'owl-carousel/owl.carousel_v1.css' => 'module_ynresphoenix',
            'owl-carousel/owl.theme.default.min.css' => 'module_ynresphoenix',
            'animate.css' => 'module_ynresphoenix',
            'masterslider.min.js'=>'module_core',
            'masterslider.css' => 'module_core',
        ]);
        if(!Phpfox::isUser())
        {
            $this->template()->setHeader('cache',['update.js' => 'module_notification']);
        }
        $this->template()->assign([
            'sPathFile' => Phpfox::getParam('core.path_file'),
            'aPages' => $aPages
        ]);

        if(!Phpfox::isUser())
        {
            $this->template()->setHeader('cache',['update.js' => 'module_notification']);
        }
    }
    
    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('ynresphoenix.component_controller_landing_clean')) ? eval($sPlugin) : false);
    }
}
