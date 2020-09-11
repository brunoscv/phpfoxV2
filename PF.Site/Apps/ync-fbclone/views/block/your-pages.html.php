<?php
defined('PHPFOX') or exit('NO DICE!');
?>
{if $iCnt > 0}
    {if $iCnt > 3}<a class="item-seeall" href="{$sUrl}">{_p var = 'see_all_page'}</a>{/if}
    <div class="fbclone-yourpage-block">
    {foreach from=$aPages name=aPages item=aPage}
    <div class="yourpage-item">
        <div class="item-image">
            {img user=$aPage suffix='_120_square'}
        </div>
        <div class="item-name">
            <a href="{$aPage.link}">{$aPage.title}</a>
        </div>
    </div>
    {/foreach}
    </div>
{else}
<div class="extra_info">
    {_p var='no_pages_found'}
</div>
{/if}
