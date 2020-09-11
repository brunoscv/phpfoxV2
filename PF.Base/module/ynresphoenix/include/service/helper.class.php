<?php

/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:09
 */
defined('PHPFOX') or exit('NO DICE!');

class Ynresphoenix_Service_Helper extends Phpfox_Service
{
    private $_PageInfo = [
            '1' => 'home',
            '2' => 'member',
            '3' => 'product',
            '4' => 'testimonial',
            '5' => 'photo',
            '6' => 'contact'
        ];
    private $_RecommendSize = [
            'home' => '600x400',
            'introduction' => '1920x660',
            'member' => '1920x1000',
            'product' => '1920x1000',
            'client' => '1920x1000',
            'statistic' => '1920x500',
            'reason' => '1920x660',
            'testimonial' => '',
            'photo' => '1920x1000',
            'blog' => '1920x1000',
            'contact' => '1920x1000'
        ];
    private static $_defaultSettings = [];

    public function __construct()
    {
        self::$_defaultSettings = [
            'home' => [
                'title' => _p('home'),
                'description' => _p('home_description'),
                'params' => [
                    'button_text' => 'View More',
                    'link' => 'https://phpfox.younetco.com',
                    'social_text' => 'Phoenix Template',
                    'facebook' => 'https://www.facebook.com',
                    'twitter' => 'https://www.twitter.com',
                    'google' => 'https://www.google.com'
                ],
                'background_path' => 'ynresphoenix/default/home_bg.png',
                'icon_path' => '',
                'icon_hover_path' => '',
                'server_id' => 0,
            ],
            'product' => [
                'title' => _p('feature_products'),
                'description' => '',
                'params' => [
                    'button_text' => 'View Detail'
                ],
                'background_path' => 'ynresphoenix/default/product_bg.jpeg',
                'icon_path' => '',
                'icon_hover_path' => '',
                'server_id' => 0,
            ],
            'member' => [
                'title' => _p('team_members'),
                'description' => '',
                'params' => [
                    'button_text' => 'View Detail'
                ],
                'background_path' => 'ynresphoenix/default/member_bg.jpg',
                'icon_path' => '',
                'icon_hover_path' => '',
                'server_id' => 0,
            ],
            'photo' => [
                'title' => _p('photo_galleries'),
                'description' => '',
                'params' => '',
                'background_path' => '',
                'icon_path' => '',
                'icon_hover_path' => '',
                'server_id' => 0,
            ],
            'contact' => [
                'title' => _p('contact_us'),
                'description' => '',
                'params' => [
                    'main_photo_path' => 'ynresphoenix/default/contact_photo.jpg',
                    'show_map' => 1,
                ],
                'background_path' => 'ynresphoenix/default/contact_bg_reponsive.jpg',
                'icon_path' => '',
                'icon_hover_path' => '',
                'server_id' => 0,
            ],
            'testimonial' => [
                'title' => _p('testimonials'),
                'description' => '',
                'params' => '',
                'background_path' => '',
                'icon_path' => '',
                'icon_hover_path' => '',
                'server_id' => 0,
            ],
        ];
    }
    public function getBlockName()
    {
        return $this->_PageInfo;
    }
    public function getRecommendSize($sKey)
    {
        return $this->_RecommendSize[$sKey];
    }
    public function getAllBlock()
    {
        return $this->database()->select('*')
                    ->from(Phpfox::getT('block'))
                    ->where('module_id = \'ynresphoenix\' AND m_connection = \'ynresphoenix.landing\' AND type_id = 0')
                    ->execute('getRows');
    }
    public function getOneBlock($sType)
    {
        return $this->database()->select('*')
                    ->from(Phpfox::getT('block'))
                    ->where('module_id = \'ynresphoenix\' AND m_connection = \'ynresphoenix.landing\' AND type_id = 0 AND component = \''.$sType.'\'')
                    ->execute('getRow');
    }
    public function getCurrentCurrencies($sGateway = 'paypal', $sDefaultCurrency = '') {

        $aFoxCurrencies = Phpfox::getService('core.currency')->getForBrowse();

        $aResults = array();
        foreach($aFoxCurrencies as $aCurrency)
        {
            if ($aCurrency['is_default'] == '1'){
                $aResults[] = $aCurrency;
            }
        }

        return $aResults;
    }
    public function getDefaultSettings($sType)
    {
        if(isset(self::$_defaultSettings[$sType]))
            return self::$_defaultSettings[$sType];
        return false;
    }
}