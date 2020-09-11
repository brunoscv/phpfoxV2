<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */

namespace Apps\Socialconnect\Controller;

use Phpfox;
use Phpfox_Component;
use Phpfox_Error;
use Phpfox_Plugin;
defined('PHPFOX') or exit('NO DICE!');

class IndexController extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isUser(true);
        //DELETE CONNECTION
        if ($iDelete = $this->request()->get('disconnect')) {
            if (Phpfox::getService('socialconnect.data')->deleteEntry($iDelete)) {
                $this->url()->send('socialconnect', false, _p('Successfully deleted connection!'));
            }
        }
        $baseUrl = \Phpfox_Url::instance()->makeUrl('socialconnect');
        $indexUrl = '';
        if (strpos($baseUrl, 'index.php') === false) {
            $indexUrl = str_replace('/socialconnect','/index.php/socialconnect',$baseUrl);
        }

        $aConnections = Phpfox::getService('socialconnect.data')->getEnabledData();
        $this->template()
            ->setBreadCrumb(_p('Manage Social Connections'))
            ->setTitle(_p('Manage Social Connections'))
            ->assign(array(
                'social_path' =>  str_replace("index.php","PF.Site",Phpfox::getParam('core.path')) . "Apps/socialconnect/assets/images/",
                 'aConnections' => $aConnections,
                'indexUrl' => $indexUrl
        ));
    }
}
