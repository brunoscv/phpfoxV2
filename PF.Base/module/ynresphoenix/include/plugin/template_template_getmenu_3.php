<?php
    if (Phpfox::isModule('ynresphoenix')) {
        if ($sConnection == 'main') {
            if (!Phpfox::isUser() || flavor()->active->id != 'ynresphoenix') {
                // Remove dashboard menu
                foreach ($aMenus as $key => $value) {
                    if ($value['module'] == 'ynresphoenix' && $value['url'] == 'ynresphoenix.dashboard') {
                        unset($aMenus[$key]);
                        break;
                    }
                }
            }
        }
        if(Phpfox::getParam('ynresphoenix.enable_fix_menu'))
        {
            Phpfox_Template::instance()->setHeader('<script type="text/javascript">
                        $Behavior.onSetFixMenuForPhoenixTemplate = function(){
                            $(window).bind(\'scroll\', function () {
                                if ($(window).scrollTop() > 180) {
                                    $(\'.ynresphoenix-navbar\').addClass(\'ynresphoenix-fixed\');
                                } else {
                                    $(\'.ynresphoenix-navbar\').removeClass(\'ynresphoenix-fixed\');
                                }
                            });
                        }
                </script>');
        }
        Phpfox_Template::instance()->setHeader([
          'jquery.mCustomScrollbar.min.css' => 'module_ynresphoenix',
          'jquery.mCustomScrollbar.concat.min.js' => 'module_ynresphoenix',
        ]);
        Phpfox_Template::instance()->setHeader(
          '<script type="text/javascript">
                    $Behavior.onChangePageOtherLanding = function(){$(".modal-backdrop").remove();}</script>'
        );
    }
?>
