<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */

namespace Apps\Socialconnect\Controller\Admin;

use Admincp_Component_Controller_App_Index;
use Phpfox;
use Phpfox_Plugin;

defined('PHPFOX') or exit('NO DICE!');

class IndexController extends Admincp_Component_Controller_App_Index
{
    public function process()
    {
        //DELETE
        if ($iDelete = $this->request()->getInt('delete')) {
            if (Phpfox::getService('socialconnect.data')->delete($iDelete)) {
                $this->url()->send('admincp.socialconnect', false, _p('Successfully deleted connection!'));
            }
        }

        $aConnections = Phpfox::getService('socialconnect.data')->getData();
        $this->template()
            ->setBreadCrumb(_p('Social connect settings'))
            ->setTitle(_p('Social connect settings'))
            ->assign(array(
                'path' =>  str_replace("index.php","PF.Site",Phpfox::getParam('core.path')) . "Apps/socialconnect/assets/images/",
            'aConnections' => $aConnections
        ));
    }
}
