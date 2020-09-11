<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */

namespace Apps\Socialconnect;

defined('PHPFOX') or exit('NO DICE!');

use Phpfox;

Phpfox::getLib('module')
    ->addAliasNames('socialconnect', 'Socialconnect')
    ->addServiceNames([
        'socialconnect.data' => Service\Data::class,
    ])
    ->addTemplateDirs([
        'socialconnect' => PHPFOX_DIR_SITE_APPS . 'socialconnect' . PHPFOX_DS . 'views'
    ])
    ->addComponentNames('controller', [
        'socialconnect.index' => Controller\IndexController::class,
        'socialconnect.auth' => Controller\AuthController::class,
        'socialconnect.vkontakte' => Controller\VkontakteController::class,
        'socialconnect.twitter' => Controller\TwitterController::class,

        'socialconnect.facebook' => Controller\FacebookController::class,
        'socialconnect.windowslive' => Controller\WindowsliveController::class,
        'socialconnect.yahoo' => Controller\YahooController::class,
        'socialconnect.google' => Controller\GoogleController::class,
        'socialconnect.twitchtv' => Controller\TwitchtvController::class,
        'socialconnect.odnoklassniki' => Controller\OdnoklassnikiController::class,
        'socialconnect.linkedin' => Controller\LinkedInController::class,
        'socialconnect.github' => Controller\GithubController::class,

        'socialconnect.admincp.index' => Controller\Admin\IndexController::class,
        'socialconnect.admincp.add' => Controller\Admin\AddController::class,
    ])
    ->addComponentNames('block', [
        'socialconnect.connection' => Block\Connection::class,
        'socialconnect.suggestion' => Block\Suggestion::class,
    ])
    ->addComponentNames('ajax', [
        'socialconnect.ajax' => Ajax\Ajax::class
    ]);

group('/socialconnect', function () {
    // BackEnd routes
    route('/admincp', function () {
        auth()->isAdmin(true);
        Phpfox::getLib('module')->dispatch('socialconnect.admincp.index');
        return 'controller';
    });

    route('/admincp/order', function () {
        auth()->isAdmin(true);
        $ids = request()->get('ids');
        $ids = trim($ids, ',');
        $ids = explode(',', $ids);
        $values = [];
        foreach ($ids as $key => $id) {
            $values[$id] = $key + 1;
        }
        Phpfox::getService('core.process')->updateOrdering([
                'table' => 'socialconnect',
                'key' => 'connect_id',
                'values' => $values,
            ]
        );

        return true;
    });

    route('/auth', 'socialconnect.auth');
    route('/vkontakte', 'socialconnect.vkontakte');
    route('/twitter', 'socialconnect.twitter');

    route('/facebook', 'socialconnect.facebook');
    route('/windowslive', 'socialconnect.windowslive');
    route('/yahoo', 'socialconnect.yahoo');
    route('/google', 'socialconnect.google');
    route('/twitchtv', 'socialconnect.twitchtv');
    route('/odnoklassniki', 'socialconnect.odnoklassniki');
    route('/linkedin', 'socialconnect.linkedin');
    route('/github', 'socialconnect.github');
    route('/', 'socialconnect.index');

});