<?php
defined('PHPFOX') or exit('NO DICE!');
?>
{if !$bUpdateOpened}
<div class="dropdown-menu comment-sticker-container js_comment_sticker_container js_sticker_set_{$iFeedId}_{$iParentId}_{$iEditId}">
{/if}
    <ul class="nav comment-sticker-header">
        <div class="header-sticker-list">
            <li class="active" title="{_p var='recent_stickers'}"><a class="item-recent" href="#1b1_{$iFeedId}_{$iParentId}_{$iEditId}" data-toggle="tab"><span class="ico ico-clock-o"></span></a></li>
            <a class="comment-prev-sticker" style="display: none;"><span class="ico ico-angle-left"></span></a>
            {if count($aStickerSets)}
                <div class="item-container">
                    <div class="comment-full-sticker">
                        {foreach from=$aStickerSets key=iKey item=aSet}
                            <li class="item-header-sticker" onclick="setTimeout(function(){l}$Core.Comment.initCanvasForSticker('.core_comment_gif:not(.comment_built)'){r},100); return true;">
                                <a href="#1b2_{$iFeedId}_{$iParentId}_{$iEditId}_{$aSet.set_id}" data-toggle="tab" title="{$aSet.title|clean}">
                                    {$aSet.full_path}
                                </a>
                            </li>
                        {/foreach}
                    </div>
                </div>
            {/if}
            <a class="comment-next-sticker" ><span class="ico ico-angle-right"></span></a>
        </div>

        <a class="item-add" href="#" data-feed-id="{$iFeedId}" data-parent-id="{$iParentId}" data-edit-id="{$iEditId}" onclick="$Core.Comment.loadStickerCollection(this); return false;"><span class="ico ico-plus"></span></a>
    </ul>
    <div class="tab-content comment-sticker-content">
            <div class="tab-pane active" id="1b1_{$iFeedId}_{$iParentId}_{$iEditId}">
                <div class="comment-sticker-list">
                    <div class="item-container">
                        {if count($aRecentStickers)}
                            {foreach from=$aRecentStickers key=iKey item=aSticker}
                                <div class="item-sticker ">
                                    <div class="item-outer">
                                        <a href="#" onclick="return $Core.Comment.selectSticker(this,{$aSticker.sticker_id});" data-feed-id="{$iFeedId}" data-parent-id="{$iParentId}" data-edit-id="{$iEditId}">
                                            {$aSticker.full_path}
                                        </a>
                                    </div>
                                </div>
                            {/foreach}
                        {else}
                            <div class="comment-none-sticker">
                                <div class="none-sticker-icon"><span class="ico ico-smile"></span></div>
                                <div class="none-sticker-info">{_p var='you_havent_used_any_stickers_yet'}</div>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>

        {if count($aStickerSets)}
            {foreach from=$aStickerSets key=iKey item=aSet}
                <div class="tab-pane" id="1b2_{$iFeedId}_{$iParentId}_{$iEditId}_{$aSet.set_id}">
                    <div class="comment-sticker-list">
                        <div class="item-container">
                            {foreach from=$aSet.stickers item=aSticker}
                                <div class="item-sticker">
                                    <div class="item-outer">
                                        <a href="#" onclick="return $Core.Comment.selectSticker(this,{$aSticker.sticker_id});" data-feed-id="{$iFeedId}" data-parent-id="{$iParentId}" data-edit-id="{$iEditId}">
                                            {$aSticker.full_path}
                                        </a>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            {/foreach}
        {/if}
    </div>
{if !$bUpdateOpened}
</div>
{/if}
{literal}
<script type="text/javascript">
    $Behavior.onLoadAttachSticker = function(){
        $Core.Comment.initStickerAttachBar($('.js_comment_attach_sticker.open-list'));
    }
</script>
{/literal}
