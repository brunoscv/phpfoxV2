<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
namespace Apps\Socialconnect;

defined('PHPFOX') or exit('NO DICE!');

use Core\App;
use Core\App\Install\Setting;
/**
 * Class Install
 * @package Apps\Core_Blogs
 */
class Install extends App\App
{
    private $_app_phrases = [

    ];

    public $store_id = 0;

    protected function setId()
    {
        $this->id = 'Socialconnect';
    }

    protected function setSupportVersion()
    {
        $this->start_support_version = '4.6.0';
        $this->end_support_version = '';
    }

    protected function setAlias()
    {
        $this->alias = 'socialconnect';
    }

    protected function setName()
    {
        $this->name = _p('Social Connect');
    }

    protected function setVersion()
    {
        $this->version = '4.86';
    }

    protected function setSettings()
    {
        $this->settings = [

        ];
    }
    protected function setUserGroupSettings()
    {
        $this->user_group_settings = [
            'socialconnect_view' => [
                'var_name' => 'socialconnect_view',
                'info' => 'Allow to use social connect?',
                'type' => Setting\Groups::TYPE_RADIO,
                'value' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1'
                ],
                'options' => Setting\Groups::$OPTION_YES_NO
            ],
        ];
    }
    protected function setComponent()
    {
        $this->component = [
            'block' => [
                'connection' => '',
                'suggestion' => ''
            ],
            'controller' => [
                'index' => 'socialconnect.index',
            ]
        ];
    }

    protected function setComponentBlock()
    {
        $this->component_block = [
            'Verified Social' => [
                'type_id' => '0',
                'm_connection' => 'profile.index',
                'component' => 'connection',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '1',
            ],
            'Connection Suggestions' => [
                'type_id' => '0',
                'm_connection' => 'core.index-member',
                'component' => 'suggestion',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '1',
            ],
        ];
    }

    protected function setPhrase()
    {
        $this->addPhrases($this->_app_phrases);
    }

    protected function setOthers()
    {
        $this->database = [
            'Socialconnect',
            'Socialconnect_Data',
        ];
        $this->admincp_route = "/socialconnect/admincp";
        $this->admincp_menu = [
            'Social Connect Settings' => 'socialconnect.index',
        ];
        $this->admincp_action_menu = [
            '/admincp/socialconnect/add' => 'New Connection'
        ];
        $this->_publisher = 'Foxexpert';
        $this->_publisher_url = 'http://foxexpert.com';
        $this->_apps_dir = "socialconnect";

        $this->_admin_cp_menu_ajax = false;
    }
}
