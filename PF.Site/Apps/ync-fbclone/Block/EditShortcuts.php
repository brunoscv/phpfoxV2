<?php
namespace Apps\YNC_FbClone\Block;
use Phpfox_Component;
use Phpfox;

class EditShortcuts extends Phpfox_Component
{
    public function process()
    {
        $aPages = Phpfox::getService('yncfbclone')->getLimitShortcut(null, null);
        $this->template()->assign([
            'aPages' => $aPages
        ]);
        return 'block';
    }
}