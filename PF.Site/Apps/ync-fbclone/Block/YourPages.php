<?php

namespace Apps\YNC_FbClone\Block;

use Phpfox_Component;
use Phpfox;

class YourPages extends Phpfox_Component
{
    function process()
    {
        $aPages = Phpfox::getService('yncfbclone')->getYourPages();
        $iCnt = Phpfox::getService('yncfbclone')->numberPages();

        if ($iCnt == 0) {
            return false;
        }
        $this->template()->assign([
            'sHeader' => _p('your_pages'),
            'aPages' => $aPages,
            'iCnt' => $iCnt,
            'sUrl' => $this->url()->makeUrl('pages', ['view' => 'my'])
        ]);
        return 'block';
    }

}
