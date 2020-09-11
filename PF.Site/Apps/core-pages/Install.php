<?php

namespace Apps\Core_Pages;

use Core\App;

class Install extends App\App
{
    private $_app_phrases = [

    ];

    public $store_id = 1896;

    protected function setId()
    {
        $this->id = 'Core_Pages';
    }

    protected function setAlias()
    {
        $this->alias = 'pages';
    }

    protected function setName()
    {
        $this->name = _p('pages_app');
    }

    protected function setVersion()
    {
        $this->version = '4.7.9';
    }

    protected function setSupportVersion()
    {
        $this->start_support_version = '4.7.6';
    }

    protected function setSettings()
    {
        $this->settings = [
            'admin_in_charge_of_page_claims' => [
                'info' => 'Admin in Charge of Page Claims',
                'description' => 'Choose which admin should receive a mail when someone claims a page. Claiming a page is a user group setting, not every member is allowed to claim a page. To enable a user group to claim pages please go to <b>Manage User Groups</b>.',
                'type' => 'select',
                'options' => ['None', 'Admin'],
                'value' => 0,
                'ordering' => 2
            ],
            'pages_limit_per_category' => [
                'info' => 'Pages Limit Per Category',
                'description' => 'Define the limit of how many pages per category can be displayed when viewing All Pages page.',
                'type' => 'integer',
                'value' => 6,
                'ordering' => 1
            ],
            'pagination_at_search_page' => [
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
            'display_pages_profile_photo_within_gallery' => [
                'info' => 'Display pages profile photo within gallery',
                'description' => 'Disable this feature if you do not want to display pages profile photos within the photo gallery.',
                'type' => 'boolean',
                'value' => 0,
                'ordering' => 3
            ],
            'display_pages_cover_photo_within_gallery' => [
                'info' => 'Display pages cover photo within gallery',
                'description' => 'Disable this feature if you do not want to display pages cover photos within the photo gallery.',
                'type' => 'boolean',
                'value' => 0,
                'ordering' => 4
            ],
            'pages_setting_meta_description' => [
                'info' => 'Pages Meta Description',
                'description' => 'Meta description added to pages related to the Pages app. <a role="button" onclick="$Core.editMeta(\'seo_pages_meta_description\', true)">Click here</a> to edit meta description.<span style="float:right;">(SEO) <input style="width:150px;" readonly value="seo_pages_meta_description"></span>',
                'type' => '',
                'value' => '{_p var="seo_pages_meta_description"}',
                'ordering' => 5,
                'group_id' => 'seo'
            ],
            'pages_setting_meta_keywords' => [
                'info' => 'Pages Meta Keywords',
                'description' => 'Meta keywords that will be displayed on sections related to the Pages app. <a role="button" onclick="$Core.editMeta(\'seo_pages_meta_keywords\', true)">Click here</a> to edit meta keywords.<span style="float:right;">(SEO) <input style="width:150px;" readonly value="seo_pages_meta_keywords"></span>',
                'type' => '',
                'value' => '{_p var="seo_pages_meta_keywords"}',
                'ordering' => 6,
                'group_id' => 'seo'
            ],
        ];
    }

    protected function setUserGroupSettings()
    {
        $iOrdering = 0;
        $this->user_group_settings = [
            'can_view_browse_pages' => [
                'info' => 'Can browse and view pages?',
                'type' => 'boolean',
                'value' => 1,
                'ordering' => ++$iOrdering
            ],
            'can_add_new_pages' => [
                'info' => 'Can create new pages?',
                'type' => 'boolean',
                'value' => [
                    1 => 1,
                    2 => 1,
                    3 => 0,
                    4 => 1,
                    5 => 0
                ],
                'ordering' => ++$iOrdering
            ],
            'can_edit_all_pages' => [
                'info' => 'Can edit all pages?',
                'type' => 'boolean',
                'value' => [
                    1 => 1,
                    2 => 0,
                    3 => 0,
                    4 => 1,
                    5 => 0
                ],
                'ordering' => ++$iOrdering
            ],
            'can_delete_all_pages' => [
                'info' => 'Can delete all pages?',
                'type' => 'boolean',
                'value' => [
                    1 => 1,
                    2 => 0,
                    3 => 0,
                    4 => 1,
                    5 => 0
                ],
                'ordering' => ++$iOrdering
            ],
            'can_approve_pages' => [
                'info' => 'Can approve pages?',
                'type' => 'boolean',
                'value' => [
                    1 => 1,
                    2 => 0,
                    3 => 0,
                    4 => 1,
                    5 => 0
                ],
                'ordering' => ++$iOrdering
            ],
            'approve_pages' => [
                'info' => 'Pages must be approved first before they are displayed publicly?',
                'type' => 'boolean',
                'value' => 0,
                'ordering' => ++$iOrdering
            ],
            'can_claim_page' => [
                'info' => 'Can members of this user group contact the site to claim a page?',
                'type' => 'boolean',
                'value' => [
                    1 => 1,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0
                ],
                'ordering' => ++$iOrdering
            ],
            'can_add_cover_photo_pages' => [
                'info' => 'Can add a cover photo on pages?',
                'type' => 'boolean',
                'value' => [
                    1 => 1,
                    2 => 1,
                    3 => 0,
                    4 => 1,
                    5 => 0
                ],
                'ordering' => ++$iOrdering
            ],
            'max_upload_size_pages' => [
                'info' => 'Max file size for photos upload in kilobytes (kb). (1024 kb = 1 mb). For unlimited add "0" without quotes.',
                'type' => 'integer',
                'value' => [
                    1 => 8192,
                    2 => 8192,
                    3 => 0,
                    4 => 8192,
                    5 => 0
                ],
                'ordering' => ++$iOrdering
            ],
            'points_pages' => [
                'info' => 'Activity points received when creating a new page.',
                'type' => 'integer',
                'value' => [
                    1 => 1,
                    2 => 1,
                    3 => 0,
                    4 => 1,
                    5 => 0
                ],
                'ordering' => ++$iOrdering
            ],
            'pages_flood_control' => [
                'info' => 'Define how many minutes this user group should wait before they can add new page. Note: Set to 0 if there should be no limit.',
                'type' => 'integer',
                'value' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0
                ],
                'ordering' => ++$iOrdering
            ],
            'can_feature_page' => [
                'var_name' => 'can_feature_page',
                'info' => 'Can feature a page?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '1',
                    '5' => '0'
                ],
                'ordering' => ++$iOrdering
            ],
            'can_sponsor_pages' => [
                'var_name' => 'can_sponsor_pages',
                'info' => 'Can members of this user group mark a page as Sponsor without paying fee?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => ++$iOrdering
            ],
            'can_purchase_sponsor_pages' => [
                'var_name' => 'can_purchase_sponsor_pages',
                'info' => 'Can members of this user group purchase a sponsored ad space?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => ++$iOrdering
            ],
            'pages_sponsor_price' => [
                'var_name' => 'pages_sponsor_price',
                'info' => 'How much is the sponsor space worth for pages? This works in a CPM basis.',
                'description' => '',
                'type' => 'currency',
                'ordering' => ++$iOrdering
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

    protected function setComponent()
    {
        $this->component = [
            'block' => [
                'photo' => '',
                'admin' => '',
                'widget' => '',
                'profile' => '',
                'category' => '',
                'menu' => '',
                'like' => '',
                'people-also-like' => '',
                'featured' => '',
                'sponsored' => ''
            ],
            'controller' => [
                'index' => 'pages.index',
                'view' => 'pages.view',
                'profile' => 'pages.profile',
            ]
        ];
    }

    protected function setComponentBlock()
    {
        $this->component_block = [
            'People Also Like' => [
                'type_id' => '0',
                'm_connection' => 'pages.view',
                'component' => 'people-also-like',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '1',
            ],
            'Widgets' => [
                'type_id' => '0',
                'm_connection' => 'pages.view',
                'component' => 'widget',
                'location' => '1',
                'is_active' => '1',
                'ordering' => '2',
            ],
            'Pages Likes/Members' => [
                'type_id' => '0',
                'm_connection' => 'pages.view',
                'component' => 'like',
                'location' => '1',
                'is_active' => '1',
                'ordering' => '3',
            ],
            'Pages Mini Menu' => [
                'type_id' => '0',
                'm_connection' => 'pages.view',
                'component' => 'menu',
                'location' => '1',
                'is_active' => '1',
                'ordering' => '4',
            ],
            'Pages' => [
                'type_id' => '0',
                'm_connection' => 'profile.index',
                'component' => 'profile',
                'location' => '1',
                'is_active' => '1',
                'ordering' => '4',
            ],
            'Page Admins' => [
                'type_id' => '0',
                'm_connection' => 'pages.view',
                'component' => 'admin',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '5',
            ],
            'Categories' => [
                'type_id' => '0',
                'm_connection' => 'pages.index',
                'component' => 'category',
                'location' => '1',
                'is_active' => '1',
                'ordering' => '10',
            ],
            'Featured Pages' => [
                'type_id' => '0',
                'm_connection' => 'pages.index',
                'component' => 'featured',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '1',
            ],
            'Sponsored Pages' => [
                'type_id' => '0',
                'm_connection' => 'pages.index',
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
        $this->menu = [
            'phrase_var_name' => 'menu_pages',
            'url' => 'pages',
            "icon" => "flag"
        ];
        $this->_apps_dir = 'core-pages';
        $this->_admin_cp_menu_ajax = false;

        // brand
        $this->_publisher = 'phpFox';
        $this->_publisher_url = 'http://store.phpfox.com/';

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

        $this->admincp_route = '/pages/admincp';
        $this->admincp_menu = [
            _p('manage_integrated_items') => 'pages.integrate',
            _p('add_new_category') => 'pages.add',
            _p('manage_categories') => '#',
            _p('manage_claims') => 'pages.claim'
        ];
        $this->_admin_cp_menu_ajax = false;

        $this->_writable_dirs = [
            'PF.Base/file/pic/pages/'
        ];

        $this->allow_remove_database = false; // do not allow user to remove database
    }
}
