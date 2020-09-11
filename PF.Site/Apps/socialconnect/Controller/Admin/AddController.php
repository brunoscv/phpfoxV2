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

class AddController extends Admincp_Component_Controller_App_Index
{
    public function process()
    {
        $iEditId = $this->request()->getInt('edit');
        $bIsEdit = false;

        if ($iEditId) {
            $aRow = Phpfox::getService('socialconnect.data')->getForEdit($iEditId);
            $bIsEdit = true;
            $this->template()->assign([
                    'aForms' => $aRow,
                    'iEditId' => $iEditId,
                ]
            );
        }

        if (($aVals = $this->request()->getArray('val'))) {
            if ($bIsEdit) {
                if (Phpfox::getService('socialconnect.data')->updateConnection($iEditId, $aVals)) {
                    $this->url()->send('admincp.app', ['id' => 'Socialconnect'],
                            _p('Successfully updated Connection'));
                }
            } else {
                if (Phpfox::getService('socialconnect.data')->addConnection($aVals)) {
                    $this->url()->send('admincp.app', ['id' => 'Socialconnect'],
                        _p('Successfully added a new Connection'));
                }
            }
        }
        $baseUrl = \Phpfox_Url::instance()->makeUrl('socialconnect');
        $indexUrl = '';
        if (strpos($baseUrl, 'index.php') === false) {
            $indexUrl = str_replace('/socialconnect','/index.php/socialconnect',$baseUrl);
        }

        $this->template()
            ->setTitle($bIsEdit ? _p('Edit connection') : _p('Add connection'))
            ->setBreadCrumb($bIsEdit ? _p('Edit connection') : _p('Add connection'))
            ->assign([
                    'path' =>  str_replace("index.php","PF.Site",Phpfox::getParam('core.path')) . "Apps/socialconnect/assets/images/",
                    'bIsEdit' => $bIsEdit,
                    'sitename' => $indexUrl,
                    'norm' => $baseUrl
                ]
            );
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('v.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
    }
}