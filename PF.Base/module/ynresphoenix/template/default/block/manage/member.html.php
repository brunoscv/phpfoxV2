<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/7/16
 * Time: 15:47
 */
defined('PHPFOX') or exit('NO DICE!');
?>

<div class="panel-default">
    <div class="panel-heading">
        <div class="panel-title" style="position: relative">
            {_p('Members')}
            {if count($aPageItems) < 8}
            <button onclick="window.location.href='{url link='admincp.ynresphoenix.add'}{$sType}'" style="position: absolute; right: 0; bottom: -6px;" class="btn btn-success btn-sm">{_p('Add Member')}</button>
            {/if}
        </div>
    </div>
</div>
{if count($aPageItems)}
<form method="post" action="{url link='admincp.ynresphoenix.manage'}{$sType}">
    <div class="panel panel-default" id="ynresphoenix_manage_pages">
        <div class="table-responsive">
        <table id="js_drag_drop" class="table table-bordered" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><input class="drag_handle_input" type="hidden" name="type" value="{$aPageItems.0.type}"/></th>
                    <th class="w20"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" /></th>
                    <th class="w20"></th>
                    <th class="t_center w50">{_p('Image')}</th>
                    <th>{_p('Member Name')}</th>
                    <th>{_p('Member Position')}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$aPageItems key=iKey item=aItem}
                    <tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
                        <td class="drag_handle">
                            <input type="hidden" name="val[ordering][{$aItem.item_id}]" value="{$aItem.ordering}" />
                        </td>
                        <td><input type="checkbox" name="id[]" class="checkbox" value="{$aItem.item_id}" id="js_id_row{$aItem.item_id}" /></td>
                        <td class="t_center">
                            <a href="#" class="js_drop_down_link" title="{_p('ynresphoenix.manage')}"></a>
                            <div class="link_menu">
                                <ul>
                                    <li><a href="{url link='admincp.ynresphoenix.add'}{$sType}?id={$aItem.item_id}" >{_p('Edit')}</a></li>
                                    <li><a href="{url link='admincp.ynresphoenix.manage'}{$sType}?delete={$aItem.item_id}" class="sJsConfirm" data-message="{_p('Are you sure you want to delete this member?')}">{_p('Delete')}</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            {if !empty($aItem.photo_path)}
                                {img server_id=$aItem.server_id path='core.url_pic' file=$aItem.photo_path suffix='_1024' width='50px'}
                            {/if}
                        </td>

                        <td>
                            {if Phpfox::isPhrase($this->_aVars['aItem']['title'])}
                                {phrase var=$aItem.title}
                            {else}
                                {$aItem.title|convert}
                            {/if}
                        </td>
                        <td>
                            {if isset($aItem.params.position) && Phpfox::isPhrase($this->_aVars['aItem']['params']['position'])}
                                {phrase var=$aItem.params.position}
                            {elseif isset($aItem.params.position)}
                                {$aItem.params.position|convert}
                            {/if}
                        </td>

                    </tr>
                {/foreach}
            </tbody>
        </table>
        </div>
        <div class="panel-footer">
            <div class="extra_info" style="float: left;">
                <span>{_p('You can have maximum 8 members')}</span>
                <br/>
                <span>{_p('You can go to Manage Pages page')} ->  {if Phpfox::isPhrase($this->_aVars['aPage']['title'])}{phrase var=$aPage.title}{else}{$aPage.title|convert}{/if} -> {_p('Settings to configure settings for this page')}</span>
            </div>
            <div class="table_bottom">
                <input type="submit" id="delete_selected" name="delete[submit]" value="{_p('Delete Selected')}" class="sJsConfirm delete btn btn-danger sJsCheckBoxButton disabled" onclick=""/>
            </div>
        </div>
    </div>
</form>
{else}
<div class="p_4">
    {_p('No members found.')}
</div>
{/if}