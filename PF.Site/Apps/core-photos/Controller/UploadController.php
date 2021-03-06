<?php
/**
 * [PHPFOX_HEADER]
 */

namespace Apps\Core_Photos\Controller;

use Phpfox_Component;
use Phpfox_Plugin;

defined('PHPFOX') or exit('NO DICE!');

class UploadController extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $this->url()->send('photo.add', [], null, 301);
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('photo.component_controller_upload_clean')) ? eval($sPlugin) : false);
    }
}