<?php
 
namespace Apps\Auth;
 
// Load phpFox module service instance, this is core of phpFox service,
// module service contains your app configuration.
$module =\Phpfox_Module::instance();
 
// Instead of \Apps\FirstApp every where. Let register an alias **first_app** that map to our app.
$module->addAliasNames('auth', 'Auth');
 
// Register your controller here
$module->addComponentNames('controller', [
        'auth.index' => Controller\IndexController::class,
    ]);
 
// Register template directory
$module->addTemplateDirs([
        'auth' => PHPFOX_DIR_SITE_APPS . 'Auth/views',
    ]);
 
 
route('auth',function (){
    \Phpfox_Module::instance()->dispatch('auth.index');
    return 'controller';   
});

(new Install())->processInstall();