<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:08
 */
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="panel panel-default" id="ynresphoenix_manage_pages">
    <div class="panel-heading">
        <div class="panel-title">
            {_p('pages')}
        </div>
    </div>
{if count($aPages)}
<div class="table-responsive">
    <table class="table table-bordered" id="js_drag_drop" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th class="w20"></th>
                <th class="w100">{_p('ynresphoenix.icon')}</th>
                <th class="w100">{_p('ynresphoenix.hover_icon')}</th>
                <th>{_p('ynresphoenix.title')}</th>
                <th class="t_center w40" style="width:60px;">{_p('ynresphoenix.active')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$aPages key=iKey item=aPage}
            <tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
                <td class="drag_handle"><input type="hidden" name="val[ordering][{$aPage.page_id}]" value="{$aPage.ordering}" /></td>
                <td class="t_center">
                    <a href="#" class="js_drop_down_link" title="{_p('ynresphoenix.manage')}"></a>
                    <div class="link_menu">
                        <ul>
                            <li><a href="{if $aPage.type == 'home'}{url link='admincp.ynresphoenix.homepage'}{else}{url link='admincp.ynresphoenix.manage'}{$aPage.type}{/if}">{_p('ynresphoenix.manage')}</a></li>
                            <li><a href="{url link='admincp.ynresphoenix.setting'}{$aPage.type}">{_p('ynresphoenix.settings')}</a></li>
                            <li><a href="{url link='admincp.ynresphoenix' reset=$aPage.type}" class="sJsConfirm">{_p('ynresphoenix.reset_default_settings')}</a></li>
                        </ul>
                    </div>
                </td>

                <td class="ynresphoenix_icon" align="center">
                    {if !empty($aPage.icon_path)}
                        {img server_id=$aPage.server_id path='core.url_pic' file=$aPage.icon_path suffix='_32'}
                    {elseif isset($aPage.default_icon)}
                        {$aPage.default_icon}
                    {/if}
                </td>
                <td class="ynresphoenix_icon" align="center">
                    {if !empty($aPage.icon_hover_path)}
                        {img server_id=$aPage.server_id path='core.url_pic' file=$aPage.icon_hover_path suffix='_32'}
                    {elseif isset($aPage.default_icon)}
                        {$aPage.default_icon}
                    {/if}
                </td>

                <td>
                    {$aPage.title|clean}
                </td>

                <td class="t_center">
                    <div class="js_item_is_active"{if !$aPage.enabled} style="display:none;"{/if}>
                    <a href="#?call=ynresphoenix.updateActivity&amp;id={$aPage.page_id}&amp;active=0" class="js_item_active_link" title="{_p('ynresphoenix.deactivate')}"></a>
                    </div>
                    <div class="js_item_is_not_active"{if $aPage.enabled} style="display:none;"{/if}>
                    <a href="#?call=ynresphoenix.updateActivity&amp;id={$aPage.page_id}&amp;active=1" class="js_item_active_link" title="{_p('ynresphoenix.activate')}"></a>
                    </div>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
{else}
    <div class="extra_info">
        {_p('ynresphoenix.no_pages_found')}
    </div>
{/if}
</div>
