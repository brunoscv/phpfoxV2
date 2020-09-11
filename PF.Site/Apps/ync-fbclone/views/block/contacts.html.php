<?php
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="yncfbclone-contact-list-container">
<div class="js_yncfbclone_search_user_list"></div>
{if count($aUsers)}
<ul class="user_rows_mini core-friend-block friend-online-block js_yncfbclone_block_contact">
    {foreach from=$aUsers name=friend item=aFriend}
    <li class="user_rows">
        <div class="user_rows_image" data-toggle="tooltip" data-placement="bottom" title="{$aFriend.full_name}">
            {if Phpfox::isModule('mail') && User_Service_Privacy_Privacy::instance()->hasAccess('' . $aFriend.user_id . '', 'mail.send_message')}
            <a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aFriend.user_id}{right_curly}); return false;">
                {img user=$aFriend suffix='_50_square' width=32 height=32 class="img-responsive" title=$aFriend.full_name no_link=true}
            </a>
            {else}
            <a href="{url link=$aFriend.user_name}" class="ajax_link">
                {img user=$aFriend suffix='_50_square' width=32 height=32 class="img-responsive" title=$aFriend.full_name no_link=true}
            </a>
            {/if}
        </div>
        <div class="user_rows_name" style="display: none;">
            {if Phpfox::isModule('mail') && User_Service_Privacy_Privacy::instance()->hasAccess('' . $aFriend.user_id . '', 'mail.send_message')}
            <a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aFriend.user_id}{right_curly}); return false;">
                {$aFriend.full_name}
            </a>
            {else}
            <a class="ajax_link" href="{url link=$aFriend.user_name}">{$aFriend.full_name}</a>
            {/if}
        </div>
        {if $aFriend.is_online == 1}
            <span class="js_yncfbclone_friend_active"></span>
        {/if}
    </li>
    {/foreach}
</ul>
{else}
<div class="extra_info js_yncfbclone_extra">
    {_p var='no_friends_found'}
</div>
{/if}
</div>
<div class="input-group fbclone-contact-search-wrapper">
    <div class="input-group-addon">
        <button onclick="$Core.autoSuggestFriends.getUsersList($('.js_yncfbclone_search_user'));" class="btn btn-sm" aria-hidden="true">
            <span class="ico ico-search-o"></span>
        </button>
    </div>
    <input type="text" class="js_yncfbclone_search_user form-control input-sm" placeholder="{_p var='Search'}">
    <div class="input-group-addon">
        {if Phpfox::getUserParam('mail.can_compose_message')}
        <a href="{url link='mail.compose'}" title="{_p('compose')}" class="popup btn-compose">
            <i class="ico ico-compose"></i>
        </a>
        {/if}
    </div>
</div>

{literal}
<script>
    $Behavior.yncfbclone_init_search_friend = function () {
        $Core.autoSuggestFriends.init({
            'sCurrentSearchId': 'js_yncfbclone_search_user',
            'sCurrentUsersListId': 'js_yncfbclone_search_user_list'
        });
    }
</script>
{/literal}