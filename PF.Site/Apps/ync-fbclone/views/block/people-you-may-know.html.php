<?php

defined('PHPFOX') or exit('NO DICE!');
?>

{if !PHPFOX_IS_AJAX}
<div id="js_friend_suggestion_loader" style="display:none;">{img theme='ajax/small.gif' class='v_middle'} {_p var='finding_another_suggestion'}</div>
<div id="js_friend_suggestion">
{/if}
<div class="user_rows_mini core-friend-block">
    {foreach from=$aUsers name=aUsers item=aUser}
    <div class="user_rows">
        <div class="user_rows_image">
            {img user=$aUser suffix='_120_square'}
        </div>
        <div class="user_rows_inner">
            {$aUser|user}
            {assign var=aUser value=$aUser}
            {module name='user.friendship' friend_user_id=$aUser.user_id type='icon' extra_info=true mutual_list=true}
        </div>
        <a class="item-hide" role="button" onclick="$('#js_friend_suggestion').hide(); $('#js_friend_suggestion_loader').show(); $.ajaxCall('friend.removeSuggestion', 'user_id={$aUser.user_id}&amp;load=true'); return false;" title="{_p var='hide_this_suggestion'}"><span class="ico ico-close"></span></a>
    </div>
    {/foreach}
</div>

{if !PHPFOX_IS_AJAX}
</div>
{/if}


