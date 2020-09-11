<?php
$module = Phpfox_Module::instance();
$module->addAliasNames('yncfbclone', 'YNC_FbClone')
    ->addComponentNames('block', [
        'yncfbclone.edit-shortcuts' => Apps\YNC_FbClone\Block\EditShortcuts::class,
        'yncfbclone.view-shortcuts' => Apps\YNC_FbClone\Block\ViewShortcuts::class,
        'yncfbclone.people-you-may-know' => Apps\YNC_FbClone\Block\PeopleYouMayKnow::class,
        'yncfbclone.friends' => Apps\YNC_FbClone\Block\Friends::class,
        'yncfbclone.photos' => Apps\YNC_FbClone\Block\Photos::class,
        'yncfbclone.videos' => Apps\YNC_FbClone\Block\Videos::class,
        'yncfbclone.create-album' => Apps\YNC_FbClone\Block\CreateAlbum::class,
        'yncfbclone.your-pages' => Apps\YNC_FbClone\Block\YourPages::class,
        'yncfbclone.contacts' => Apps\YNC_FbClone\Block\Contacts::class,
        'yncfbclone.friendprofileprivate' => Apps\YNC_FbClone\Block\FriendProfilePrivate::class,
    ])
    ->addComponentNames('controller', [
        'yncfbclone.admincp.menu-icons' => Apps\YNC_FbClone\Controller\Admin\MenuIcons::class,
        'yncfbclone.admincp.edit-icons' => Apps\YNC_FbClone\Controller\Admin\EditIcons::class,
        'yncfbclone.friendprofile' => Apps\YNC_FbClone\Controller\FriendProfile::class,
        'yncfbclone.videoprofile' => Apps\YNC_FbClone\Controller\VideoProfile::class,
    ])
    ->addTemplateDirs([
        'yncfbclone' => PHPFOX_DIR_SITE_APPS . 'ync-fbclone' . PHPFOX_DS . 'views',
    ])
    ->addServiceNames([
        'yncfbclone' => Apps\YNC_FbClone\Service\Process::class,
    ])
    ->addComponentNames('ajax', [
        'yncfbclone.ajax' => Apps\YNC_FbClone\Ajax\Ajax::class,
    ]);