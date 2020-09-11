<?php

namespace Apps\YNC_FbClone;

use Core\App;

/**
 * Class Install
 * @author  Neil J. <neil@phpfox.com>
 * @version 4.6.0
 * @package Apps\YNC_FbClone
 */
class Install extends App\App
{
    private $_app_phrases = [

    ];

    protected function setId()
    {
        $this->id = 'YNC_FbClone';
    }

    protected function setAlias()
    {
        $this->alias = 'yncfbclone';
    }

    protected function setName()
    {
        $this->name = _p('yncfbclone');
    }

    protected function setVersion()
    {
        $this->version = '4.02p6';
    }

    protected function setSupportVersion()
    {
        $this->start_support_version = '4.6.1';
    }

    protected function setSettings()
    {
    }

    protected function setUserGroupSettings()
    {
    }

    protected function setComponent()
    {
        $this->component = [
            "block" => [
                "people-you-may-know" => "",
                "contacts" => "",
                "your-pages" => ""
            ]
        ];
    }

    protected function setComponentBlock()
    {
        $this->component_block = [
            "People You May Know" => [
                "type_id"      => "0",
                "m_connection" => "core.index-member",
                "component"    => "people-you-may-know",
                "location"     => "3",
                "is_active"    => "1",
                "ordering"     => "4"
            ],
            "Profile Friends" => [
                "type_id"      => "0",
                "m_connection" => "profile.info",
                "component"    => "friends",
                "location"     => "4",
                "is_active"    => "1",
                "ordering"     => "1"
            ],
            "Profile Friends App" => [
                "type_id"      => "0",
                "m_connection" => "friend.profile",
                "component"    => "friends",
                "location"     => "4",
                "is_active"    => "1",
                "ordering"     => "1"
            ],
            "Profile Photos " => [
                "type_id"      => "0",
                "m_connection" => "profile.info",
                "component"    => "photos",
                "location"     => "4",
                "is_active"    => "1",
                "ordering"     => "2"
            ],
            "Profile Photos App " => [
                "type_id"      => "0",
                "m_connection" => "photo.index",
                "component"    => "photos",
                "location"     => "4",
                "is_active"    => "1",
                "ordering"     => "2"
            ],"Profile Albums App " => [
                "type_id"      => "0",
                "m_connection" => "photo.albums",
                "component"    => "photos",
                "location"     => "4",
                "is_active"    => "1",
                "ordering"     => "2"
            ],
            "Profile Videos" => [
                "type_id"      => "0",
                "m_connection" => "profile.info",
                "component"    => "videos",
                "location"     => "4",
                "is_active"    => "1",
                "ordering"     => "3"
            ],"Profile Videos App" => [
                "type_id"      => "0",
                "m_connection" => "v.index",
                "component"    => "videos",
                "location"     => "4",
                "is_active"    => "1",
                "ordering"     => "2"
            ],"Your Pages" => [
                "type_id"      => "0",
                "m_connection" => "core.index-member",
                "component"    => "your-pages",
                "location"     => "3",
                "is_active"    => "1",
                "ordering"     => "5"
            ], "Contacts" => [
                "type_id"      => "0",
                "m_connection" => "core.index-member",
                "component"    => "contacts",
                "location"     => "3",
                "is_active"    => "1",
                "ordering"     => "6"
            ],
        ];
    }

    protected function setPhrase()
    {
        $this->phrase = $this->_app_phrases;
    }

    protected function setOthers()
    {
        $this->_apps_dir = 'ync-fbclone';
        $this->_publisher = 'YouNetCo';
        $this->_publisher_url = 'https://phpfox.younetco.com/';

        $this->admincp_route = '/yncfbclone/admincp';

        $this->_admin_cp_menu_ajax = false;

        $this->database = [
            'Ync_Facebook_Shortcuts',
            'Ync_Facebook_Icons',
        ];

        $this->admincp_menu = [
            'Settings' => '#',
            _p('menu_icons') => 'yncfbclone.menu-icons',
        ];

        $this->_writable_dirs = [
            'PF.Base/file/pic/yncfbclone/'
        ];
    }
}