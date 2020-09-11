{if !empty($aPages)}
<div class="js_yncfb_shortcut" id="yncfb_shortcut">
    <div class="fbclone-menu-title js_edit_shortcuts">
        <span>{_p var='shortcuts'}</span>
        <div class="js_shortcut_edit" data-app="ync_fbshortcut" data-action="edit_shortcut" data-action-type="click"  style="display: none;">
            <div class="item-outer">
                <a data-app="ync_fbshortcut" data-action="edit_shortcut" data-action-type="click">{_p var='edit'}</a>
            </div>
        </div>
    </div>
    {foreach from=$aPages key=iKey item=aShortcutPage name=page}
    <li class="js_page_item_{$aShortcutPage.page_id} ync-fbclone-shortcut-item">
        <a href="{$aShortcutPage.url}" class="ajax_link">
            <div class="shortcut-icon">
                {if Phpfox::isModule('photo')}
                {img server_id=$aShortcutPage.image_server_id title=$aShortcutPage.title path='pages.url_image' file=$aShortcutPage.image_path suffix='_200_square' no_default=false max_width=50 time_stamp=true}
                {else}
                {img thickbox=true server_id=$aShortcutPage.image_server_id title=$aShortcutPage.title path='pages.url_image' file=$aShortcutPage.pages_image_path suffix='_200_square' no_default=false max_width=50 time_stamp=true}
                {/if}
            </div>
            <div class="shortcut-info"> {$aShortcutPage.title}</div>
        </a>
         <div class="item-options-holder shortcut-select" data-component="shortcuts-options">
            <a role="button" data-toggle="dropdown" href="#" class="shortcuts-options item-options">
                <span class="ico ico-dottedmore"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#?call=yncfbclone.tooglePin&amp;item_id={$aShortcutPage.page_id}&amp;is_pin=1" class="js_yncfbclone_item_pin {if $aShortcutPage.is_pin==0}is_pinned{/if}">{_p var = 'pin_to_top'}</a></li>
                <li><a href="#?call=yncfbclone.tooglePin&amp;item_id={$aShortcutPage.page_id}&amp;is_pin=0" class="js_yncfbclone_item_pin {if $aShortcutPage.is_pin==1}is_pinned{/if}">{_p var = 'unpin_from_top'}</a></li>
                {if isset($aShortcutPage.is_hidden) && $aShortcutPage.is_hidden==0}<li><a href="javascript:void(0);" onclick="$.ajaxCall('yncfbclone.toogleHidden', 'item_id={$aShortcutPage.page_id}&amp;load=true'); return false;">{_p var = 'hide_from_shortcuts'}</a></li>{/if}
                {if $aShortcutPage.item_type == 0 && $aShortcutPage.creator_id != Phpfox::getUserId()}
                <li>
                    <a href="javascript:void(0);" onclick="$.ajaxCall('like.delete', 'type_id=pages&amp;item_id={$aShortcutPage.page_id}'); return false;">
                        {_p var='unlike_page'}
                    </a>
                </li>
                {elseif $aShortcutPage.item_type == 1 && $aShortcutPage.creator_id != Phpfox::getUserId()}
                <li><a href="javascript:void(0);" onclick="$.ajaxCall('like.delete', 'type_id=groups&item_id={$aShortcutPage.page_id}&reload=true'); return false;">{_p var='leave_group'}</a></li>
                {/if}
            </ul>
        </div>
    </li>
    {/foreach}
    <li class="js_ync_shortcut_unpin" style="display: none"></li>
    {if !empty($aPagesExtra)}
    <li class="js_ync_shortcut_seemore"><span class="ico ico-caret-down"></span>{_p var = 'see_more'}...</li>
    <div class="js_ync_shortcut_extra" style="display: none;" data-number="{$iCnt}">
        {foreach from=$aPagesExtra key=iKey item=aShortcutPage name=page}
        <li class="js_page_item_{$aShortcutPage.page_id} ync-fbclone-shortcut-item">
            <a href="{$aShortcutPage.url}" class="ajax_link">
                <div class="shortcut-icon" >
                    {if Phpfox::isModule('photo')}
                    {img server_id=$aShortcutPage.image_server_id title=$aShortcutPage.title path='pages.url_image' file=$aShortcutPage.image_path suffix='_200_square' no_default=false max_width=50 time_stamp=true}
                    {else}
                    {img thickbox=true server_id=$aShortcutPage.image_server_id title=$aShortcutPage.title path='pages.url_image' file=$aShortcutPage.pages_image_path suffix='_200_square' no_default=false max_width=50 time_stamp=true}
                    {/if}
                </div>
                <div class="shortcut-info"> {$aShortcutPage.title}</div>
                
            </a>
            <div class="item-options-holder shortcut-select" data-component="shortcuts-options">
                <a role="button" data-toggle="dropdown" href="#" class="shortcuts-options item-options">
                    <span class="ico ico-dottedmore-o"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#?call=yncfbclone.tooglePin&amp;item_id={$aShortcutPage.page_id}&amp;is_pin=1" class="js_yncfbclone_item_pin {if $aShortcutPage.is_pin==0}is_pinned{/if}">{_p var = 'pin_to_top'}</a></li>
                    <li><a href="#?call=yncfbclone.tooglePin&amp;item_id={$aShortcutPage.page_id}&amp;is_pin=0" class="js_yncfbclone_item_pin {if $aShortcutPage.is_pin==1}is_pinned{/if}">{_p var = 'unpin_from_top'}</a></li>
                    {if isset($aShortcutPage.is_hidden) && $aShortcutPage.is_hidden==0}<li><a href="javascript:void(0);" onclick="$.ajaxCall('yncfbclone.toogleHidden', 'item_id={$aShortcutPage.page_id}&amp;load=true'); return false;">{_p var = 'hide_from_shortcuts'}</a></li>{/if}
                    {if $aShortcutPage.item_type == 0 && $aShortcutPage.creator_id != Phpfox::getUserId()}
                    <li>
                        <a href="javascript:void(0);" onclick="$.ajaxCall('like.delete', 'type_id=pages&amp;item_id={$aShortcutPage.page_id}'); return false;">
                            {_p var='unlike_page'}
                        </a>
                    </li>
                    {elseif $aShortcutPage.item_type == 1 && $aShortcutPage.creator_id != Phpfox::getUserId()}
                    <li><a href="javascript:void(0);" onclick="$.ajaxCall('like.delete', 'type_id=groups&item_id={$aShortcutPage.page_id}&reload=true'); return false;">{_p var='leave_group'}</a></li>
                    {/if}
                </ul>
            </div>
        </li>
        {/foreach}
        <li class="js_ync_shortcut_unpin_extra" style="display: none"></li>
    </div>
    {/if}
</div>
{/if}
