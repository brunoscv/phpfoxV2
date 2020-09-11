<?php
defined('PHPFOX') or exit('NO DICE!');
?>
<form action="" method="GET" id="yncfbclone_edit_shortcut_form" onsubmit="yncfbclone.changeShortcutStatus(); return false;">
    <div class="ync-fbclone-shortcut-edit-container">
        <div class="shortcut-edit-header">
            <div class="item-shortcut-info">
                {_p var = 'shortcut_are_quick_links_to_some_of_your_pages_and_groups'}
            </div>
            <div class="item-shortcut-search">
                <div class="input-group">
                    <input type="text" class="js_ync_fbshortcut_filter input-sm" placeholder="{_p  var = 'search_your_pages_and_groups'}">
                    <div class="input-group-addon">
                        <span class="ico ico-search-o"></span>
                    </div>
                </div>

            </div>
        </div>
        <div class="shortcut-edit-wrapper">
            <div class="js_shortcut_all_item shortcut-edit-item-all">
                {foreach from=$aPages item=aPage}
                <div class="js_shortcut_item shortcut-edit-item">
                    <div class="item-shortcut-content">
                        <div class="item-icon">
                            {if Phpfox::isModule('photo')}
                            {img server_id=$aPage.image_server_id title=$aPage.title path='pages.url_image' file=$aPage.image_path suffix='_200_square' no_default=false max_width=50 time_stamp=true}
                            {else}
                            {img thickbox=true server_id=$aPage.image_server_id title=$aPage.title path='pages.url_image' file=$aPage.pages_image_path suffix='_200_square' no_default=false max_width=50 time_stamp=true}
                            {/if}
                        </div>
                        <span class="item-title js_yncfbclone_title"> {$aPage.title}</span>
                    </div>
                    <div class="dropdown item-shortcut-action">
                        <button class="btn btn-default btn-sm dropdown-toggle js-dropdown-shortcut-action" type="button" data-toggle="dropdown" data-idshortcut="{$aPage.page_id}">
                            <span class="js_data_default_{$aPage.page_id}" data-title="js_data_default_{$aPage.page_id}">
                                {if $aPage.is_hidden == 0 && $aPage.is_pin == 0}
                                <span class="js_yncfbshortcut_default_sort">
                                    <i class="ico ico-magic"></i>
                                    <span>{_p var = 'sorted_automatically'}</span>
                                </span>
                                {else}
                                    {if $aPage.is_hidden == 1}
                                        <span class="js_yncfbshortcut_default_hidden">
                                            <i class="ico ico-eye"></i>
                                            <span>{_p var = 'hidden_from_shortcuts'}</span>
                                        </span>
                                    {elseif $aPage.is_pin == 1}
                                        <span class="js_yncfbshortcut_default_pinned">
                                            <i class="ico ico-thumb-tack"></i>
                                            <span>{_p var = 'pinned_to_top'}</span>
                                        </span>
                                    {/if}
                                {/if}
                            </span>
                            <span class="js_data_new_{$aPage.page_id}">
                                <span class="js_yncfbshortcut_sort" style="display: none" data-shortcutid="{$aPage.page_id}" data-status="1" data-ordering="{$aPage.ordering}">
                                    <i class="ico ico-magic"></i>
                                    <span>{_p var = 'sorted_automatically'}</span>
                                </span>
                                <span class="js_yncfbshortcut_hidden" style="display: none" data-shortcutid="{$aPage.page_id}" data-status="3" data-ordering="{$aPage.ordering}">
                                    <i class="ico ico-eye"></i>
                                    <span>{_p var = 'hidden_from_shortcuts'}</span>
                                </span>

                                <span class="js_yncfbshortcut_pinned" style="display: none" data-shortcutid="{$aPage.page_id}" data-status="2" data-ordering="{$aPage.ordering}">
                                    <i class="ico ico-thumb-tack"></i>
                                    <span>{_p var = 'pinned_to_top'}</span>
                                </span>
                            </span>
                            <span class="caret"></span>
                        </button>
                        
                    </div>
                    <div style="clear: both"></div>
                </div>
                {/foreach}
            </div>
        </div>
        <div class="shortcut-edit-bottom">
            <input type="button" value="{_p('cancel')}" class="btn btn-default btn-sm" onclick="return js_box_remove(this);" />
            <input type="submit" value="{_p('save')}" class="btn btn-primary btn-sm" />
        </div>
    </div>
    <div class="js-ynfbclone-shortcut-action-container-list">
        {foreach from=$aPages item=aPage}
        <ul class="dropdown-menu dropdown-menu-right js_yncfbclone_status_data" data-count="{$aPage.page_id}">
            <li id="js_yncfbshortcut_sort" {if $aPage.is_hidden == 0 && $aPage.is_pin == 0}class="is_tick"{/if}>
            <a href="javascript:void(0);" class="js_yncfbshortcut_status">
                <i class="ico ico-magic"></i>
                <span>{_p var = 'sorted_automatically'}</span>
            </a>
            </li>
            <li id="js_yncfbshortcut_pinned" {if $aPage.is_pin == 1}class="is_tick"{/if}>
            <a href="javascript:void(0);" class="js_yncfbshortcut_status">
                <i class="ico ico-thumb-tack"></i>
                <span>{_p var = 'pinned_to_top'}</span>
            </a>
            </li>
            <li id="js_yncfbshortcut_hidden" {if $aPage.is_hidden == 1}class="is_tick"{/if}>
            <a href="javascript:void(0);" class="js_yncfbshortcut_status">
                <i class="ico ico-eye"></i>
                <span>{_p var = 'hidden_from_shortcuts'}</span>
            </a>
            </li>
        </ul>
        {/foreach}
    </div>
</form>