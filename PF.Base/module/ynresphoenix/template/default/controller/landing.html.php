<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[YouNetCo]
 * @author  		YouNetCo
 * @package 		Ynclean
 * @version 		4.01
 */
 
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPages)}
<div id="page_ynresphoenix_landing-nav" class="right">
	<ul>
        {foreach from=$aPages item=aPage key=iKey}
		<li>
			<a href="{$aPage.div_id}" class="">
                {if !empty($aPage.icon_path)}
                    {img server_id=$aPage.server_id path='core.url_pic' file=$aPage.icon_path suffix='_16'}
                {else}
                    {$aPage.default_icon}
                {/if}
                {if !empty($aPage.icon_hover_path)}
                    {img server_id=$aPage.server_id path='core.url_pic' file=$aPage.icon_hover_path suffix='_16'}
                {else}
                    {$aPage.default_icon}
                {/if}
            </a>
			{if !empty($aPage.title)}<div class="fp-tooltip right">{$aPage.title|clean}</div>{/if}
		</li>
        {/foreach}
	</ul>
</div>
{/if}
