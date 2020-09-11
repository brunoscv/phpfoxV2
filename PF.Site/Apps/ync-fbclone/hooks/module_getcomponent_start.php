<?php
if (defined('PHPFOX_IS_USER_PROFILE') && Phpfox::isModule('yncfbclone') && flavor()->active->id == 'yncfbclone') {
    if ($sClass == 'friend.profile') {
        $sClass = 'yncfbclone.friendprofile';
    }
    if ($sClass == 'v.profile') {
        $sClass = 'yncfbclone.videoprofile';
    }

    Phpfox::getLib('template')->setHeader(array(
            '<script type="text/javascript">$Behavior.initAddButton = function(){if ($(\'._is_profile_view\').length > 0 && $(\'.app-addnew-block\').length > 0) {
                var btnAdd = $(\'.app-addnew-block\');
                var silbs = $(\'.header_bar_search\');
                btnAdd.insertBefore(silbs, btnAdd);
            }
        }</script>'
        )
    );
}


