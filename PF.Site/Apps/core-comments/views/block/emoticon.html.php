<?php
defined('PHPFOX') or exit('NO DICE!');
?>

<div class="comment-emoji-container js_comment_emoticon_container js_emoticon_container_{$iFeedId}_{$iParentId}_{$iEditId}">
    <ul class="nav comment-emoji-header">
        {if count($aRecentEmoticons)}
            <li class="active"><a href="#3a_{$iFeedId}_{$iParentId}_{$iEditId}" data-toggle="tab">{_p var='recent'}</a></li>
        {/if}
        <li {if !count($aRecentEmoticons)}class="active"{/if}><a href="#4a_{$iFeedId}_{$iParentId}_{$iEditId}" data-toggle="tab">{_p var='all'}</a></li>
        <span class="item-hover-info js_hover_emoticon_info"></span>
        <a class="item-close" onclick="$Core.Comment.hideEmoticon($(this),{$bIsReply});return false;"><span class="ico ico-close"></span></a>
    </ul>
    <div class="tab-content comment-emoji-content">
        {if count($aRecentEmoticons)}
            <div class="tab-pane active" id="3a_{$iFeedId}_{$iParentId}_{$iEditId}">
                <div class="comment-emoji-list">
                    <div class="item-container">
                        {foreach from=$aRecentEmoticons item=aRecent}
                            <div class="item-emoji" onmouseover="$Core.Comment.showEmojiTitle($(this), '{$aRecent.code}')"
                                 onclick="return $Core.Comment.selectEmoji($(this), '{$aRecent.code}', {$bIsReply}, {$bIsEdit});" title="{_p var=$aRecent.title} {$aRecent.code}">
                                <div class="item-outer">
                                    <img src="{param var='core.path_actual'}PF.Site/Apps/core-comments/assets/images/emoticons/{$aRecent.image}"
                                         border="0"
                                         data-code="{$aRecent.code}"
                                         alt="{$aRecent.image}">
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        {/if}
        <div class="tab-pane {if !count($aRecentEmoticons)}active{/if}" id="4a_{$iFeedId}_{$iParentId}_{$iEditId}">
            <div class="comment-emoji-list">
                <div class="item-container">
                    {foreach from=$aEmoticons item=aEmoji}
                        <div class="item-emoji" onmouseover="$Core.Comment.showEmojiTitle($(this), '{$aEmoji.code}')"
                             onclick="return $Core.Comment.selectEmoji($(this), '{$aEmoji.code}', {$bIsReply}, {$bIsEdit});" title="{_p var=$aEmoji.title} {$aEmoji.code}">
                            <div class="item-outer">
                                <img src="{param var='core.path_actual'}PF.Site/Apps/core-comments/assets/images/emoticons/{$aEmoji.image}"
                                     border="0"
                                     data-code="{$aEmoji.code}"
                                     alt="{$aEmoji.image}">
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>
