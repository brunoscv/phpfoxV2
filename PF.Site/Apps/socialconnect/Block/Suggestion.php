<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
namespace Apps\Socialconnect\Block;

use Phpfox;
use Phpfox_Component;


class Suggestion extends Phpfox_Component
{
    public function process()
    {
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
