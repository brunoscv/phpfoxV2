<?php

namespace Apps\YNC_FbClone\Controller\Admin;

use Phpfox_Component;
use Phpfox;

defined('PHPFOX') or exit('NO DICE!');

class MenuIcons extends Phpfox_Component
{
    private $_aStockIcons;

    public function process()
    {
        $aIcons = db()->select('*')
            ->from(':ync_facebook_icons')
            ->executeRows();

        $this->_aStockIcons = $aIcons;

        $iParentId = $this->request()->getInt('parent');

        $aTypes = Phpfox::getService('admincp.menu')->getTypes();
        $aRows = Phpfox::getService('admincp.menu')->get(($iParentId > 0 ? array('menu.parent_id = ' . (int)$iParentId) : array('menu.parent_id = 0 AND menu.m_connection IN(\'main\')')));
        $aMenus = array();
        $aModules = array();

        foreach ($aRows as $iKey => $aRow) {
            if (Phpfox::isModule($aRow['module_id'])) {
                if (!$iParentId && in_array($aRow['m_connection'], $aTypes)) {
                    $aMenus[$aRow['m_connection']][] = $aRow;
                } else {
                    $aModules[$aRow['m_connection']][] = $aRow;
                }
            }
        }
        unset($aRows);
        $aMenus = $aMenus['main'];
        foreach ($aMenus as $iKey => $aMenu) {
            $aMenus[$iKey]['mobile_icon'] = materialParseMobileIcon($aMenus[$iKey]['mobile_icon']);
            if ($aMenu['server_id'] == '-1') {
                $aMenus[$iKey]['full_path'] = Phpfox::getParam('core.path_actual') . 'PF.Site/Apps/ync-fbclone/assets/images/' . $aMenu['image_path'];
            } else if (!empty($aMenu['image_path'])) {
                $aMenus[$iKey]['full_path'] = Phpfox::getLib('image.helper')->display([
                    'server_id' => $aMenu['server_id'],
                    'path' => 'core.url_pic',
                    'file' => 'yncfbclone/' . $aMenu['image_path'],
                    'suffix' => '_200',
                    'return_url' => true
                ]);
            }
            $this->matchStockIcons($aMenus[$iKey]);
        }

        $iResetId = $this->request()->get('reset');
        if ($iResetId > 0) {
            Phpfox::getService('yncfbclone')->resetMenuIcon($iResetId);
            $this->url()->send('admincp.yncfbclone.menu-icons', null, _p('successfully_reset_menu_icon'));
        }
        if (($iId = $this->request()->getInt('id')) && ($sSuggestedIcon = $this->request()->get('suggested_icon'))) {
            Phpfox::getService('yncfbclone')->applySuggestedIcon($iId, $sSuggestedIcon);
            $this->url()->send('admincp.yncfbclone.menu-icons', null, _p('successfully_apply_stock_icon'));
        }

        $this->template()
            ->setTitle(_p('menu_icons'))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('yncfbclone'), $this->url()->makeUrl('admincp.yncfbclone.menu-icons'))
            ->setBreadCrumb(_p('menu_icons'))
            ->assign(array(
                    'aMenus' => $aMenus,
                )
            );
    }

    private function matchStockIcons(&$aMenu)
    {
        foreach ($this->_aStockIcons as $aStockIcon) {
            $aKeywords = explode(',', $aStockIcon['keywords']);
            foreach ($aKeywords as $keyword) {
                if (strpos(strtolower($aMenu['name']), $keyword) !== false) {
                    $aMenu['suggested_icon'] = $aStockIcon['icon'];
                    break;
                }
            }
            if (!empty($aMenu['suggested_icon'])) {
                break;
            }
        }
    }
}
