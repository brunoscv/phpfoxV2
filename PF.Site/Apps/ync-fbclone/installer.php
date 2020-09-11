<?php
$installer = new Core\App\Installer();
$installer->onInstall(function () use ($installer) {
    (new \Apps\YNC_FbClone\Installation\Data\v402())->process();
});