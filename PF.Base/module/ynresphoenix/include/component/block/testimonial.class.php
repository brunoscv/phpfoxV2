<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Component_Block_Testimonial extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aSettings = Phpfox::getService('ynresphoenix')->getPageDetailByType('testimonial');
        $aTestimonials = Phpfox::getService('ynresphoenix')->getItemByPage('testimonial');
        $this->template()->assign(array(
            'aTestimonialSettings' => $aSettings,
            'aTestimonials' => $aTestimonials
        ));
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('ynresphoenix.component_block_testimonial_clean')) ? eval($sPlugin) : false);
    }
}
