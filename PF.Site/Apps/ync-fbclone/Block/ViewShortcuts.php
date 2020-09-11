<?php

namespace Apps\YNC_FbClone\Block;
use Phpfox_Component;
use Phpfox;

class ViewShortcuts extends Phpfox_Component
{
    public function process()
    {
        $aPages = Phpfox::getService('yncfbclone')->getLimitShortcut(15, ' AND ys.is_hidden = 0');
        $this->setParam('aPages', $aPages);
        $iCnt = count($aPages);
        if ($iCnt > 5) {
            $aPagesLess = array_slice($aPages, 0, 5);
            $aPagesExtra = array_slice($aPages, 5, $iCnt);
            Phpfox::getLib('template')->assign(['aPages'=> $aPagesLess, 'aPagesExtra' => $aPagesExtra, 'iCnt' => count($aPagesExtra)]);
        }else {
            Phpfox::getLib('template')->assign('aPages', $aPages);
        }

        return 'block';
    }
}