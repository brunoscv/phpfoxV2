<?php

defined('PHPFOX') or exit('NO DICE!');

?>
{if $sNotShareFriend}
{else}
<div id="js_yncfbclone_section_friends" class="ync-fbclone-profile-friend-section ync-fbclone-information-section">
    <div  class="ync-fbclone-information-header" id="js_yncfbclone_section_friends_header">
        <ul>
            <li id="js_yncfbclone_friend" class="active"><a href="#tab_friend" rel="tab_friend" id="js_tab_friend">{_p var = 'all_friends'}<span class="item-number">{$iCount}</span></a></li>
            {if $iMutualCount > 0}<li id="js_yncfbclone_mutual_friend"><a href="#tab_mutual_friend" rel="tab_mutual_friend" id="js_tab_mutual_friend">{_p var = 'mutual_friends'}<span class="item-number">{$iMutualCount}</span></a></li>{/if}
            <div class="js_yncfbclone_friend_search yncfbclone-profilepage-search-custom">
                <div class="input-group js_yncfbclone_tab_friend_search">
                    <input type="hidden" id="js_yncfbclone_profile_user_id" value="{$aSubject.user_id}">
                    <input type="text" id="js_yncfbclone_search_user_info" class="js_yncfbclone__filter input-sm" placeholder="{_p  var = 'Search friend...'}" value="" onkeyup="$Core.autoSuggestFriendsInfo.getUsersList($(this))">
                    <div class="input-group-addon">
                        <button onclick="$Core.autoSuggestFriendsInfo.getUsersList($('#js_yncfbclone_search_user_info'));" class="btn btn-sm" aria-hidden="true">
                            <span class="ico ico-search-o"></span>
                        </button>
                    </div>
                </div>
                <div class="input-group js_yncfbclone_tab_mutual_friend_search" style="display: none;">
                    <input type="hidden" id="js_yncfbclone_profile_user_id" value="{$aSubject.user_id}">
                    <input type="text" id="js_yncfbclone_search_mutual_user_info" class="js_yncfbclone__mutual_filter input-sm" placeholder="{_p  var = 'Search friend...'}" value="" onkeyup="$Core.autoSuggestMutualFriendsInfo.getUsersList($(this))">
                    <div class="input-group-addon">
                        <button onclick="$Core.autoSuggestMutualFriendsInfo.getUsersList($('#js_yncfbclone_search_mutual_user_info'));" class="btn btn-sm" aria-hidden="true">
                            <span class="ico ico-search-o"></span>
                        </button>
                    </div>
                </div>
            </div>
        </ul>
    </div>

    <div id="tabs_content_container" class="ync-fbclone-information-content">
        <div class="js_yncfb_result mt-2 js_yncfb_friend_result"></div>
        <div class="js_yncfb_result mt-2 js_yncfb_mutual_result"></div>
        <div id="tab_friend" class="tab_content" style="display: block;">
            <div id="js_yncfbclone_search_user_info_list"></div>
            <ul class="js_friend_all_item js_yncfbclone_tab_friend">
            {if $iCount>0}
            {foreach from=$aFriends item=aUser}
                <li class="js_friend_item">
                    <div class="item-outer">
                        <div class="item-image">
                            {img user=$aUser suffix='_120_square'}
                        </div>
                        <div class="item-content">
                            <div class="item-name">{$aUser|user}</div>
                            <div class="item-friend">{$aUser.total_friend} {_p var='friends'}</div>
                        </div>

                        {if Phpfox::isUser() && $aUser.user_id != Phpfox::getUserId()}
                        <div class="dropdown friend-actions">
                            {if Phpfox::isUser() && Phpfox::isModule('friend') && !$aUser.is_friend}
                            {if !$aUser.is_friend && $aUser.is_friend_request > 0}
                            <a href="#" onclick="return $Core.addAsFriend('{$aUser.user_id}');" title="{_p var='confirm_friend_request'}" class="btn btn-md btn-default btn-round">
                                <span class="mr-1 ico ico-user2-check-o"></span>
                                {_p var='confirm'}
                            </a>
                            {elseif Phpfox::getUserParam('friend.can_add_friends')}
                            <a href="#" onclick="return $Core.addAsFriend('{$aUser.user_id}');" title="{_p var='add_as_friend'}" class="btn btn-md btn-default btn-round">
                                <span class="mr-1 ico ico-user1-plus-o"></span>
                                {_p var='add_as_friend'}
                            </a>
                            {/if}
                            {/if}

                            {if Phpfox::isModule('friend') && $aUser.is_friend > 0}
                            <a href="" data-toggle="dropdown" class="btn btn-md btn-default btn-round has-caret" title="{_p var='friend_request_sent'}">
                                {if $aUser.is_friend == 1}
                                <span class="mr-1 ico ico-check"></span>
                                {_p var='friend'} <span class="ml-1 ico ico-caret-down"></span>
                                {else}
                                <span class="mr-1 ico ico-clock-o mr-1 friend-request-sent"></span>
                                {_p var='request_sent'} <span class="ml-1 ico ico-caret-down"></span>
                                {/if}
                            </a>
                            {/if}

                            <ul class="dropdown-menu dropdown-menu-right">
                                {if Phpfox::isModule('mail') && User_Service_Privacy_Privacy::instance()->hasAccess('' . $aUser.user_id . '', 'mail.send_message')}
                                <li>
                                    <a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aUser.user_id}{right_curly}); return false;">
                                        <span class="mr-1 ico ico-pencilline-o"></span>
                                        {_p var='message'}
                                    </a>
                                </li>
                                {/if}

                                <li>
                                    <a href="#?call=report.add&amp;height=220&amp;width=400&amp;type=user&amp;id={$aUser.user_id}" class="inlinePopup" title="{_p var='report_this_user'}">
                                        <span class="ico ico-warning-o mr-1"></span>
                                        {_p var='report_this_user'}</a>
                                </li>
                                {if Phpfox::isModule('friend') && isset($aUser.is_friend) && $aUser.is_friend == 1}
                                <li class="item-delete">
                                    <a href="#" onclick="$Core.jsConfirm({l}{r}, function(){l}$.ajaxCall('friend.delete', 'friend_user_id={$aUser.user_id}&reload=1');{r}, function(){l}{r}); return false;">
                                        <span class="mr-1 ico ico-user2-del-o"></span>
                                        {_p var='remove_friend'}
                                    </a>
                                </li>
                                {elseif Phpfox::isModule('friend') && $aUser.request_id > 0}
                                <li class="item-delete">
                                    <a href="{url link='friend.pending' id=$aUser.request_id}" class="sJsConfirm">
                                        <span class="mr-1 ico ico-user2-del-o"></span>
                                        {_p var='cancel_request'}
                                    </a>
                                </li>
                                {/if}
                            </ul>
                        </div>
                        {/if}
                    </div>
                </li>
            {/foreach}
            {else}
            <div class="extra_info">
                {_p var='no_friends_found'}
            </div>
            {/if}
            </ul>
            {if !empty($sMore)}<a class="js_yncfbclone_tab_friend_seemore ync-fbclone-information-view-more" href="{$sLink}">{_p var = 'see_all'}</a>{/if}
        </div>
        {if $iMutualCount > 0}
        <div id="tab_mutual_friend" class="tab_content">
            <div id="js_yncfbclone_search_mutual_user_info_list"></div>
            <ul class="js_friend_all_item js_yncfbclone_tab_mutual_friend">
            {foreach from=$aMutalFriends item=aUser}
                <li class="js_friend_item">
                    <div class="item-outer">
                        <div class="item-image">
                            {img user=$aUser suffix='_120_square'}
                        </div>
                        <div class="item-content">
                            <div class="item-name">{$aUser|user}</div>
                            <div class="item-friend">{$aUser.total_friend} {_p var='friends'}</div>
                        </div>
                        {if Phpfox::isUser() && $aUser.user_id != Phpfox::getUserId()}
                        <div class="dropdown friend-actions">
                            {if Phpfox::isModule('friend') && $aUser.is_friend > 0}
                            <a href="" data-toggle="dropdown" class="btn btn-md btn-default btn-round has-caret" title="{_p var='friend_request_sent'}">
                                {if $aUser.is_friend == 1}
                                <span class="mr-1 ico ico-check"></span>
                                {_p var='friend'} <span class="ml-1 ico ico-caret-down"></span>
                                {else}
                                <span class="mr-1 ico ico-clock-o mr-1 friend-request-sent"></span>
                                {_p var='request_sent'} <span class="ml-1 ico ico-caret-down"></span>
                                {/if}
                            </a>
                            {/if}

                            <ul class="dropdown-menu dropdown-menu-right">
                                {if Phpfox::isModule('mail') && User_Service_Privacy_Privacy::instance()->hasAccess('' . $aUser.user_id . '', 'mail.send_message')}
                                <li>
                                    <a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aUser.user_id}{right_curly}); return false;">
                                        <span class="mr-1 ico ico-pencilline-o"></span>
                                        {_p var='message'}
                                    </a>
                                </li>
                                {/if}

                                <li>
                                    <a href="#?call=report.add&amp;height=220&amp;width=400&amp;type=user&amp;id={$aUser.user_id}" class="inlinePopup" title="{_p var='report_this_user'}">
                                        <span class="ico ico-warning-o mr-1"></span>
                                        {_p var='report_this_user'}</a>
                                </li>
                                {if Phpfox::isModule('friend') && isset($aUser.is_friend) && $aUser.is_friend == 1}
                                <li class="item-delete">
                                    <a href="#" onclick="$Core.jsConfirm({l}{r}, function(){l}$.ajaxCall('friend.delete', 'friend_user_id={$aUser.user_id}&reload=1');{r}, function(){l}{r}); return false;">
                                        <span class="mr-1 ico ico-user2-del-o"></span>
                                        {_p var='remove_friend'}
                                    </a>
                                </li>
                                {/if}
                            </ul>
                        </div>
                        {/if}
                    </div>
                </li>
            {/foreach}
            </ul>
            {if !empty($sMore)}<a class="js_yncfbclone_tab_mutual_friend_seemore ync-fbclone-information-view-more" href="{$sLink}">{_p var = 'see_all'}</a>{/if}
        </div>
        {/if}
    </div>
</div>
{literal}
<script>
    $Behavior.yncfbclone_init_search_friend_info = function () {
        $Core.autoSuggestFriendsInfo.init({
            'sCurrentSearchId': 'js_yncfbclone_search_user_info',
            'sCurrentUsersListId': 'js_yncfbclone_search_user_info_list'
        });
    };
    $Behavior.yncfbclone_init_search_mutual_friend_info = function () {
        $Core.autoSuggestMutualFriendsInfo.init({
            'sCurrentSearchId': 'js_yncfbclone_search_mutual_user_info',
            'sCurrentUsersListId': 'js_yncfbclone_search_mutual_user_info_list'
        });
    }
//    $Core.autoSuggestFriendsInfo.init({
//        'sCurrentSearchId': 'js_yncfbclone_search_user_info',
//        'sCurrentUsersListId': 'js_yncfbclone_search_user_info_list'
//    });
//    $Core.autoSuggestMutualFriendsInfo.init({
//        'sCurrentSearchId': 'js_yncfbclone_search_mutual_user_info',
//        'sCurrentUsersListId': 'js_yncfbclone_search_mutual_user_info_list'
//    });
</script>
{/literal}
{/if}