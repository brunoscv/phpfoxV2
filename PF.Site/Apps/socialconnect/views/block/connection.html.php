<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="block event-mini-block-container" style="position: relative">
    <div class="title">{_p var='Verified Social'}</div>
    <div class="content">
        <div class="event-mini-block-content">
            {foreach from=$aConnections item=aConnection}
                <div style="margin-bottom: 8px;padding-bottom: 8px;border-bottom: 1px solid #eee;">
                    {if !empty($aConnection.image_path)}
                        <img src="{$aConnection.image_path}" style="max-width: 32px;float:left;margin-right:10px;"/>
                    {else}
                        <img src="{$social_path}{$aConnection.adapter}.png" style="max-width: 32px;float:left;margin-right:10px;" />
                    {/if}
                    <p style="margin:0;float:left;width: calc(100% - 50px);">
                        {_p var='as'} {$aConnection.data.displayName|shorten:30:'':true|split:55|max_line}
                    </p>
                    <div class='clear'></div>
                </div>
            {/foreach}
        </div>
    </div>
</div>