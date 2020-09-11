<?php

namespace Apps\YNC_FbClone\Controller\Admin;

use Phpfox_Component;
use Phpfox;

defined('PHPFOX') or exit('NO DICE!');

class EditIcons extends Phpfox_Component
{
    public function process()
    {

        $iEditId = $this->request()->getInt('id');
        $aRow = Phpfox::getService('yncfbclone')->getForEdit($iEditId);
        $aRow['mobile_icon'] = materialParseMobileIcon($aRow['mobile_icon']);
        if (!empty($aRow['image_path'])) {
            $aRow['full_path'] = Phpfox::getLib('image.helper')->display([
                'server_id' => $aRow['server_id'],
                'path' => 'core.url_pic',
                'file' => 'yncfbclone/' . $aRow['image_path'],
                'suffix' => '_200',
                'return_url' => true
            ]);
        }
//        die(d($aRow));
        $this->template()->assign(array(
                'aForms' => $aRow,
                'iEditId' => $iEditId

            )
        );

        if (!empty($_FILES['image']['name'])) {
            if (!$_FILES['image']['error']) {
                if (preg_match('/image\//i', $_FILES['image']['type'])) {
                } else {
                    return \Phpfox_Error::set(_p('this_is_not_an_image_file_please_choose_another_image_file'));
                }
            } else {
                return \Phpfox_Error::set(_p('there_were_errors_when_uploading_files'));
            }
        }

        if (Phpfox::getService('yncfbclone')->updateMenuIcon($iEditId)) {
            $this->url()->send('admincp.yncfbclone.menu-icons', null,
                _p('successfully_updated_menu_icon'));
        }
        $this->template()
            ->setTitle(_p('menu_icons'))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('yncfbclone'), $this->url()->makeUrl('admincp.yncfbclone.menu-icons'))
            ->setBreadCrumb(_p('edit_icon'));
    }
}
