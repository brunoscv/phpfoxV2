<?php

namespace Apps\PHPfox_Groups;

use Core\App;
use Core\App\Install\Setting;

/**
 * Class Install
 * @author  phpFox
 * @package Apps\PHPfox_Groups
 */
class Install extends App\App
{
    private $_app_phrases = [

    ];

    public $store_id = 2007;

    protected function setId()
    {
        $this->id = 'PHPfox_Groups';
    }

    /**
     * Set start and end support version of your App.
     */
    protected function setSupportVersion()
    {
        $this->start_support_version = '4.7.6';
    }

    protected function setAlias()
    {
        $this->alias = 'groups';
    }

    public function setName()
    {
        $this->name = _p('Groups');
    }

    public function setVersion()
    {
        $this->version = '4.7.9';
    }

    public function setSettings()
    {
        $this->settings = [
            'groups_limit_per_category' => [
                'info' => 'Groups Limit Per Category',
                'description' => 'Define the limit of how many groups per category can be displayed when viewing All Groups page.',
                'type' => 'integer',
                'value' => 6,
                'ordering' => 1
            ],
            'pagination_at_search_groups' => [
                'info' => 'Paging Type',
                'description' => '',
                'type' => 'select',
                'options' => [
                    'loadmore' => 'Scrolling down to load more items',
                    'next_prev' => 'Use Next and Pre buttons',
                    'pagination' => 'Use pagination with page number'
                ],
                'value' => 'loadmore',
                'ordering' => 0
            ],
            'display_groups_profile_photo_within_gallery' => [
                'info' => 'Display groups profile photo within gallery',
                'description' => 'Disable this feature if you do not want to display groups profile photos within the photo gallery.',
                'type' => 'boolean',
                'value' => 0,
                'ordering' => 3
            ],
            'display_groups_cover_photo_within_gallery' => [
                'info' => 'Display groups cover photo within gallery',
                'description' => 'Disable this feature if you do not want to display groups cover photos within the photo gallery.',
                'type' => 'boolean',
                'value' => 0,
                'ordering' => 4
            ],
            'groups_setting_meta_description' => [
                'info' => 'Groups Meta Description',
                'description' => 'Meta description added to groups related to the Groups app. <a role="button" onclick="$Core.editMeta(\'seo_groups_meta_description\', true)">Click here</a> to edit meta description.<span style="float:right;">(SEO) <input style="width:150px;" readonly value="seo_groups_meta_description"></span>',
                'type' => '',
                'value' => '{_p var="seo_groups_meta_description"}',
                'ordering' => 5,
                'group_id' => 'seo'
            ],
            'groups_setting_meta_keywords' => [
                'info' => 'Groups Meta Keywords',
                'description' => 'Meta keywords that will be displayed on sections related to the Groups app. <a role="button" onclick="$Core.editMeta(\'seo_groups_meta_keywords\', true)">Click here</a> to edit meta keywords.<span style="float:right;">(SEO) <input style="width:150px;" readonly value="seo_groups_meta_keywords"></span>',
                'type' => '',
                'value' => '{_p var="seo_groups_meta_keywords"}',
                'ordering' => 6,
                'group_id' => 'seo'
            ],
        ];
    }

    public function setUserGroupSettings()
    {
        $this->user_group_settings = [
            'pf_group_browse' => [
                'var_name' => 'pf_group_browse',
                'info' => 'Can browse groups?',
                'type' => Setting\Groups::TYPE_RADIO,
                'value' => [
                    "1" => "1",
                    "2" => "1",
                    "3" => "1",
                    "4" => "1",
                    "5" => "0"
                ],
                'options' => Setting\Groups::$OPTION_YES_NO
            ],
            'pf_group_add_cover_photo' => [
                'var_name' => 'pf_group_add_cover_photo',
                'info' => 'Can add a cover photo on groups?',
                'type' => Setting\Groups::TYPE_RADIO,
                'value' => [
                    "1" => "1",
                    "2" => "1",
                    "3" => "1",
                    "4" => "1",
                    "5" => "0"
                ],
                'options' => Setting\Groups::$OPTION_YES_NO
            ],
            'can_edit_all_groups' => [
                'info' => 'Can edit all groups?',
                'type' => 'boolean',
                'value' => [
                    1 => 1,
                    2 => 0,
                    3 => 0,
                    4 => 1,
                    5 => 0
                ],
                'ordering' => 3
            ],
            'can_delete_all_groups' => [
                'info' => 'Can delete all groups?',
                'type' => 'boolean',
                'value' => [
                    1 => 1,
                    2 => 0,
                    3 => 0,
                    4 => 1,
                    5 => 0
                ],
                'ordering' => 4
            ],
            'can_approve_groups' => [
                'info' => 'Can approve groups?',
                'type' => 'boolean',
                'value' => [
                    1 => 1,
                    2 => 0,
                    3 => 0,
                    4 => 1,
                    5 => 0
                ],
                'ordering' => 5
            ],
            'pf_group_add' => [
                'var_name' => 'pf_group_add',
                'info' => 'Can add groups?',
                'type' => Setting\Groups::TYPE_RADIO,
                'value' => [
                    "1" => "1",
                    "2" => "1",
                    "3" => "0",
                    "4" => "1",
                    "5" => "0"
                ],
                'options' => Setting\Groups::$OPTION_YES_NO
            ],
            'pf_group_max_upload_size' => [
                'var_name' => 'pf_group_max_upload_size',
                'info' => 'Max file size for upload files in kilobytes (kb). For unlimited add "0" without quotes.',
                'type' => Setting\Groups::TYPE_TEXT,
                'value' => 8192,
            ],
            'pf_group_approve_groups' => [
                'var_name' => 'pf_group_approve_groups',
                'info' => 'Groups must be approved first before they are displayed publicly?',
                'type' => Setting\Groups::TYPE_RADIO,
                'value' => 0,
                'options' => Setting\Groups::$OPTION_YES_NO
            ],
            'points_groups' => [
                'var_name' => 'points_groups',
                'info' => 'Activity points received when creating a new group.',
                'type' => Setting\Groups::TYPE_TEXT,
                'value' => 1
            ],
            'flood_control' => [
                'info' => 'Define how many minutes this user group should wait before they can add new group. Note: Setting it to "0" (without quotes) is default and users will not have to wait.',
                'type' => 'integer',
                'value' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0
                ]
            ],
            'can_feature_group' => [
                'var_name' => 'can_feature_group',
                'info' => 'Can feature a group?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '1',
                    '5' => '0'
                ]
            ],
            'can_sponsor_groups' => [
                'var_name' => 'can_sponsor_groups',
                'info' => 'Can members of this user group mark a group as Sponsor without paying fee?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ]
            ],
            'can_purchase_sponsor_groups' => [
                'var_name' => 'can_purchase_sponsor_groups',
                'info' => 'Can members of this user group purchase a sponsored ad space?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ]
            ],
            'groups_sponsor_price' => [
                'var_name' => 'groups_sponsor_price',
                'info' => 'How much is the sponsor space worth for groups? This works in a CPM basis.',
                'description' => '',
                'type' => 'currency'
            ],
            'auto_publish_sponsored_item' => [
                'var_name' => 'auto_publish_sponsored_item',
                'info' => 'Auto publish sponsored item?',
                'description' => 'After the user has purchased a sponsored space, should the item be published right away? 
If set to No, the admin will have to approve each new purchased sponsored item space before it is shown in the site.',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
            ],
        ];
    }

    public function setComponent()
    {
        $this->component = [
            "block" => [
                "about" => "",
                "admin" => "",
                "category" => "",
                "events" => "",
                "members" => "",
                "menu" => "",
                "photo" => "",
                "profile" => "",
                "widget" => "",
                "cropme" => "",
                "related" => "",
                "featured" => "",
                "sponsored" => ""
            ],
            "controller" => [
                "index" => "groups.index",
                "add" => "groups.add",
                "all" => "groups.all",
                "view" => "groups.view",
                "profile" => "groups.profile"
            ]
        ];
    }

    public function setComponentBlock()
    {
        $this->component_block = [
            "Groups Likes/Members" => [
                "type_id" => "0",
                "m_connection" => "groups.view",
                "component" => "members",
                "location" => "3",
                "is_active" => "1",
                "ordering" => "3"
            ],
            "Groups Info" => [
                "type_id" => "0",
                "m_connection" => "groups.view",
                "component" => "about",
                "location" => "1",
                "is_active" => "1",
                "ordering" => "3"
            ],
            "Groups Mini Menu" => [
                "type_id" => "0",
                "m_connection" => "groups.view",
                "component" => "menu",
                "location" => "1",
                "is_active" => "0",
                "ordering" => "4"
            ],
            "Groups Widget" => [
                "type_id" => "0",
                "m_connection" => "groups.view",
                "component" => "widget",
                "location" => "1",
                "is_active" => "1",
                "ordering" => "5"
            ],
            "Groups" => [
                "type_id" => "0",
                "m_connection" => "profile.index",
                "component" => "profile",
                "location" => "1",
                "is_active" => "1",
                "ordering" => "4"
            ],
            "Groups Admin" => [
                "type_id" => "0",
                "m_connection" => "groups.view",
                "component" => "admin",
                "location" => "3",
                "is_active" => "1",
                "ordering" => "6"
            ],
            "Categories" => [
                "type_id" => "0",
                "m_connection" => "groups.index",
                "component" => "category",
                "location" => "1",
                "is_active" => "1",
                "ordering" => "10"
            ],
            "Feed display" => [
                "type_id" => "0",
                "m_connection" => "groups.view",
                "component" => "display",
                "location" => "2",
                "is_active" => "1",
                "ordering" => "10",
                "module_id" => "feed"
            ],
            "Group Events" => [
                "type_id" => "0",
                "m_connection" => "groups.view",
                "component" => "events",
                "location" => "3",
                "is_active" => "1",
                "ordering" => "7"
            ],
            "Related Groups" => [
                "type_id" => "0",
                "m_connection" => "groups.view",
                "component" => "related",
                "location" => "1",
                "is_active" => "1",
                "ordering" => "8"
            ],
            'Featured Groups' => [
                'type_id' => '0',
                'm_connection' => 'groups.index',
                'component' => 'featured',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '1',
            ],
            'Sponsored Groups' => [
                'type_id' => '0',
                'm_connection' => 'groups.index',
                'component' => 'sponsored',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '2',
            ],
        ];
    }

    protected function setPhrase()
    {
        $this->phrase = $this->_app_phrases;
    }

    protected function setOthers()
    {
        $this->admincp_route = "/groups/admincp";
        $this->admincp_menu = [
            _p("Add New Category") => "groups.add-category",
            _p("Manage Categories") => "#",
            _p('Manage Integrated Items') => 'groups.integrate',
            _p("Convert old groups") => "groups.convert"
        ];
        $this->menu = [
            "phrase_var_name" => "menu_groups",
            "url" => "groups",
            "icon" => "users"
        ];
        $this->_writable_dirs = [
            'PF.Base/file/pic/pages/'
        ];
        $this->_publisher = 'phpFox';
        $this->_publisher_url = 'http://store.phpfox.com/';
        $this->_admin_cp_menu_ajax = false;
        $this->_apps_dir = 'core-groups';
        // database tables
        $this->database = [
            'PagesAdminTable',
            'PagesCategoryTable',
            'PagesClaimTable',
            'PagesFeedCommentTable',
            'PagesFeedTable',
            'PagesInviteTable',
            'PagesLoginTable',
            'PagesPermTable',
            'PagesSignupTable',
            'PagesTable',
            'PagesTextTable',
            'PagesTypeTable',
            'PagesUrlTable',
            'PagesWidgetTable',
            'PagesWidgetTextTable',
            'PagesMenuTable'
        ];
        $this->allow_remove_database = false; // do not allow user to remove database
    }
}
