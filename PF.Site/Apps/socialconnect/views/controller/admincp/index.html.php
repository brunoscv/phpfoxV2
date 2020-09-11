<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">{_p('Faq')}</div>
    </div>
    <div class="panel-body" style="line-height: 25px;">
        1. {_p var='Required https, Required Phpfox short urls enabled'}. <br/>
        2. {_p var='Enabled curl extenstion of PHP, using minimal version 7.62.0 (ask your hosting)'}. <br/>
        3. {_p var='Carefully create your api keys for different networks and setup Authorized callback for each adapter callback is different.'} <br/>
        4. {_p var='Detailed instruction you may find in create page for each adapter.'}
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
           {_p var='Manage Connections'}
        </div>
    </div>
    {if !empty($aConnections)}
    <table  class="table table-admin" id="_sort" data-sort-url="{url link='socialconnect.admincp.order'}">
        <thead>
        <tr>
            <th style="width:20px"></th>
            <th style="width:50px"></th>
            <th>{_p var='Adapter'}</th>
            <th>{_p var='Image Path'}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$aConnections key=iKey name=rules item=aRule}
            <tr  class="tr" data-sort-id="{$aRule.connect_id}">
                <td class="t_center">
                    <i class="fa fa-sort"></i>
                </td>
                <td class="text-center">
                    <a class="js_drop_down_link" title="Manage"></a>
                    <div class="link_menu">
                        <ul>
                            <li><a class="popup" href="{url link='admincp.socialconnect.add' edit=$aRule.connect_id}">{_p('Edit')}</a></li>
                            <li>
                                <a  href="{url link='admincp.socialconnect' delete=$aRule.connect_id}">{_p('Delete')}</a>
                            </li>
                        </ul>
                    </div>
                </td>
                <td>
                    {$aRule.adapter}
                </td>
                <td>
                    {if !empty($aRule.image_path)}
                        <img src="{$aRule.image_path}" style="max-width: 100px;"/>
                    {else}
                        <img src="{$path}{$aRule.adapter}.png" style="width: 32px;" />
                    {/if}
                </td>
                <td class="text-center on_off">
                    <div class="js_item_is_active"{if !$aRule.is_enabled} style="display:none;"{/if}>
                        <a href="#?call=socialconnect.updateActivity&amp;id={$aRule.connect_id}&amp;active=0" class="js_item_active_link" title="{_p var='Deactivate'}"></a>
                    </div>
                    <div class="js_item_is_not_active"{if $aRule.is_enabled} style="display:none;"{/if}>
                     <a href="#?call=socialconnect.updateActivity&amp;id={$aRule.connect_id}&amp;active=1" class="js_item_active_link" title="{_p var='Activate'}"></a>
                    </div>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    {else}
        <div style="margin:10px;">
            {_p var='No connections added'}
        </div>
    {/if}
</div>
