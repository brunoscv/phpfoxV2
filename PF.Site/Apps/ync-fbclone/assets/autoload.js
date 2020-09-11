
$Ready(function() {
    $(".js_yncfb_shortcut .shortcut-select").on("show.bs.dropdown", function(event){
        $(this).closest('.ync-fbclone-shortcut-item').addClass('open');
    });
    $(".js_yncfb_shortcut .shortcut-select").on("hide.bs.dropdown", function(event){
        $(this).closest('.ync-fbclone-shortcut-item').removeClass('open');
    });
    $(document).on('keyup', '.js_ync_fbshortcut_filter', function(){
        var value = $(this).val().toLowerCase();
        $(".js_shortcut_all_item .js_shortcut_item").find(".js_yncfbclone_title").each(function () {
            var paragraph = $(this).text();
            if (paragraph.toLowerCase().indexOf(value) > -1) {
                $(this).closest('.js_shortcut_item').show();
            } else {
                $(this).closest('.js_shortcut_item').hide();
            }
        });

    });

    $("#js_yncfbclone_section_photo_header li").click(function() {
        $("#js_yncfbclone_section_photo li").removeClass('active');
        $(this).addClass("active");
        $("#js_yncfbclone_section_photo .tab_content").hide();
        var selected_tab = $(this).find("a").attr("href");
        $(selected_tab).fadeIn();
        return false;
    });

    $("#js_yncfbclone_section_friends_header li").click(function() {
        $("#js_yncfbclone_section_friends li").removeClass('active');
        $(this).addClass("active");
        $("#js_yncfbclone_section_friends .tab_content").hide();
        var selected_tab = $(this).find("a").attr("href");
        $(selected_tab).fadeIn();
        if ($(this).find("a").attr('id') == 'js_tab_friend') {
            $('.js_yncfbclone_tab_mutual_friend_search').hide();
            $('.js_yncfbclone_tab_friend_search').show();
            $('.js_yncfb_friend_result').show();
            $('.js_yncfb_mutual_result').hide();
        } else {
            $('.js_yncfbclone_tab_mutual_friend_search').show();
            $('.js_yncfbclone_tab_friend_search').hide();
            $('.js_yncfb_friend_result').hide();
            $('.js_yncfb_mutual_result').show();
        }
        return false;
    });

    if ($('#js_yncfbclone_friend').hasClass('active')) {
        $('#tab_mutual_friend').hide();
    };
    $(window).click(function() {
        if($('#yncfbclone_edit_shortcut_form').length > 0){
            $('.js_yncfbclone_status_data').each(function(){
            $(this).removeClass('show');
        });
        }
    });
    $('.js-dropdown-shortcut-action').click(function(event){
        event.stopPropagation();
        var aShortcutMoreId = $(this).data('idshortcut'),
            aShortcutWidth = $(this).outerWidth(),
            aShortcutOffset = $(this).offset(),
            aShortcutLeft = aShortcutOffset.left,
            aShortcutTop = aShortcutOffset.top;
        $('.js_yncfbclone_status_data').each(function(){
            if ($(this).data('count') == aShortcutMoreId) {
                $(this).css('top',aShortcutOffset.top);
                $(this).css('left',aShortcutOffset.left);
                $(this).css('min-width',aShortcutWidth);
                $(this).toggleClass('show');
            }else{
                $(this).removeClass('show');
            }
        });
    });

    $('#js_yncfbclone_search_user_info, #js_yncfbclone_search_mutual_user_info').off('keydown').on('keydown', function(e){
        if (e.keyCode == 13) {
            $(this).find('button').click();
        }
    });

    if ($('#page_profile_index').length > 0 && $('#page_profile_index').hasClass('yncfbclone-has-right-column')) {
        $('.js_yncfbclone_permission_view_friend').hide();
    }

    if (($('body#page_photo_index._is_profile_view').length || $('body#page_photo_albums._is_profile_view').length) && $('.profiles_banner').length) {
        var $btn_app_addnew = $('.btn-app-addnew');
        if (!$btn_app_addnew.length || $('#yncfbclone_create_album').length) {
            return;
        }
        var $share_photo_btn = $('<a>', {
            'id': 'yncfbclone_create_album',
            'href': 'javascript:void(0)',
            'class': 'btn btn-success js_yncfbclone_create_album',
            'onclick': '$Core.box(\'yncfbclone.newAlbum\', 500, \'module=&amp;item=0\'); return false;',
            'html': '<span class="ico ico-plus mr-1"></span>' + oTranslations['create_album']
        });
        $share_photo_btn.prependTo($btn_app_addnew);
    }
});

$(document).on('click', '.js_yncfbshortcut_status', function () {
    $(this).parent().siblings('li').removeClass('is_tick');
    $(this).closest('li').addClass('is_tick');
    var sStatus = $(this).closest('li').attr('id');
    var iPageId = $(this).closest('li').closest('ul').data('count');
    $('.js_data_default_' + iPageId).css('display', 'none');
    if (sStatus == 'js_yncfbshortcut_pinned') {
        $('.js_data_new_' + iPageId + ' .js_yncfbshortcut_pinned').show();
    }else {
        $('.js_data_new_' + iPageId + ' .js_yncfbshortcut_pinned').hide();
    }
    if (sStatus == 'js_yncfbshortcut_hidden') {
        $('.js_data_new_' + iPageId + ' .js_yncfbshortcut_hidden').show();
    }else {
        $('.js_data_new_' + iPageId + ' .js_yncfbshortcut_hidden').hide();
    }
    if (sStatus == 'js_yncfbshortcut_sort') {
        $('.js_data_new_' + iPageId + ' .js_yncfbshortcut_sort').show();
    }else {
        $('.js_data_new_' + iPageId + ' .js_yncfbshortcut_sort').hide();
    }
});

$(document).on('click','.js_yncfbclone_item_like',function()
{
    var aParams = $.getParams(this.href),
        sParams = '',
        ctn  =  $(this).closest('li');

    for (sVar in aParams)
    {
        sParams += '&' + sVar + '=' + aParams[sVar] + '';
    }
    sParams = sParams.substr(1, sParams.length);

    if (aParams['like'] == '1')
    {
        $('.js_item_is_not_like:first',ctn).addClass('hide').hide();
        $('.js_item_is_like:first',ctn).removeClass('hide').show();
        $(this).removeClass('is_liked');
        $(this).parents('.js_item_is_not_like:first').siblings().find('.js_yncfbclone_item_like').addClass('is_liked');
    }
    else
    {
        $('.js_item_is_like:first',ctn).addClass('hide').hide();
        $('.js_item_is_not_like:first',ctn).removeClass('hide').show();
        $(this).removeClass('is_liked');
        $(this).parents('.js_item_is_like:first').siblings().find('.js_yncfbclone_item_like').addClass('is_liked');
    }

    $Core.ajaxMessage();
    $.ajaxCall(aParams['call'], sParams + '&global_ajax_message=true');

    return false;
});

$(document).on('click','.js_yncfbclone_create_album',function() {
    $("#js_yncfbclone_section_photo li:nth-child(1)").removeClass('active');
    $("#js_yncfbclone_section_photo li:nth-child(2)").addClass("active");
    $("#tab1").hide();
    $("#tab2").show();
    var selected_tab = $("#js_yncfbclone_section_photo li:eq(2)").find("a").attr("href");
    $(selected_tab).fadeIn();
    return false;
});

var yncfbclone = {

    changeShortcutStatus: function(e){
        if ($('.js_yncfbclone_status_data').length) {
            var data = [];
            $('.js_yncfbclone_status_data').each(function(){
                var iShortcutId = $(this).data('count');
                var iStatus = 0, iTime=0;
                if ($('.js_data_new_' + iShortcutId + ' .js_yncfbshortcut_sort').css('display') != 'none') {
                    iStatus = 1;
                }
                if ($('.js_data_new_' + iShortcutId + ' .js_yncfbshortcut_pinned').css('display') != 'none') {
                    iStatus = 2;
                    iTime = $.now();
                }
                if ($('.js_data_new_' + iShortcutId + ' .js_yncfbshortcut_hidden').css('display') != 'none') {
                    iStatus = 3;
                }
                var iOrdering = $(this).data('ordering');

                if (iStatus > 0) {
                    var aShortcut = {
                        id: iShortcutId,
                        status: iStatus,
                        ordering: iOrdering,
                        newOrdering: iTime
                    };
                    data.push(aShortcut);
                }
            });
            $.ajaxCall('yncfbclone.updateStatus', 'data=' + JSON.stringify(data) );

        }
    }
}

var timeOutKeyUp;
$Core.autoSuggestFriends =
    {
        sCurrentSearch: '',
        iMaxSearch: 15,//
        iCurrentUserValue: 0,
        isBeingBuilt: false,
        sCurrentSearchId: '',
        sCurrentUsersListId: '',
        aFoundUsers: {},
        aFoundUser: '',
        iMaxSelect: '',
        init: function (aParams) {
            this.sCurrentSearchId = aParams.sCurrentSearchId;
            this.sCurrentUsersListId = aParams.sCurrentUsersListId;

            if (!this.isBuild()) {
                this.build();
            }
        },
        isBuild: function () {
            if (!this.isBeingBuilt) {
                var ele = $('.' + this.sCurrentSearchId);
                if (ele.length && ele.hasClass('_build')) {
                    this.isBeingBuilt = true;
                }
            }

            return this.isBeingBuilt;
        },
        build: function () {
            var ele = $('.' + this.sCurrentSearchId);
            if (ele.length) {
                ele.attr('onkeyup', '$Core.autoSuggestFriends.getUsersList($(this))');
                ele.addClass('_build');

                //Init value
                this.iCurrentUserValue = $('#' + this.sCurrentValueId).val();
            }
        },
        getUsersList: function ($oObj) {
            if ($oObj.val() == '') {
                $('.js_yncfbclone_block_contact').show();
                $('.js_yncfbclone_search_user_list').hide();
            }else {
                clearInterval(timeOutKeyUp);
                timeOutKeyUp = setTimeout(function () {
                    if ($('body').hasClass('page-loading')) return false;
                    $Core.autoSuggestFriends.sCurrentSearch = $oObj.val();
                    $.ajaxCall('yncfbclone.ajaxGetUsers', 'search_for=' + $oObj.val() + '&total_search=' + $Core.autoSuggestFriends.iMaxSearch);
                }, 500);
            }
        },
        generateSelectBox: function () {
            $('.js_yncfbclone_block_contact').hide();
            $('.js_yncfbclone_search_user_list').show();

            var $aUsers = JSON.parse(JSON.stringify($Cache.users));
            var $sHtml = '<div class="search-user-result">';

            if ($aUsers.length === 0) {
                if ($('.js_yncfbclone_extra').length > 0) {
                    $('.js_yncfbclone_extra').hide();
                }
                $sHtml += '<div class="extra_info">' + oTranslations['no_friends_found'] + '</div>';
            } else {
                $sHtml += '<ul class="user_rows_mini core-friend-block friend-online-block">';
                $.each($aUsers, function ($sKey, $aUser) {
                    var $mRegSearch = new RegExp($Core.autoSuggestFriends.sCurrentSearch.value, 'i');

                    if ($aUser['full_name'].match($mRegSearch)) {
                        if ($aUser['full_name'].match($mRegSearch)) {
                            if (($aUser['user_image'].substr(0, 5) === 'http:') || ($aUser['user_image'].substr(0, 6) === 'https:')) {
                                $aUser['user_image'] = '<img src="' + $aUser['user_image'] + '">';
                            }
                            if ($aUser['send_mess'] == 1) {
                                $sHtml += '<li class="user_rows" onclick="$Core.composeMessage({user_id:' + $aUser['user_id'] + '}); return false;">';
                                $sHtml += '<div class="user_rows_image" data-toggle="tooltip" data-placement="bottom" title="' + $aUser['full_name'] + '">';
                                $sHtml += '<div class="img-wrapper">' + $aUser['user_image'] + '</div>';
                                $sHtml += '</div>';
                                $sHtml += '<div class="user_rows_name" style="display: none;">';
                                $sHtml += '<a href="#">' + $aUser['full_name'] + '</a>';
                                $sHtml += '</div>';
                                if ($aUser['is_online'] == 1) {
                                    $sHtml += '<span class="js_yncfbclone_friend_active"></span>';
                                }
                                $sHtml += '</li>';
                            } else {
                                $sHtml += '<li class="user_rows">';
                                $sHtml += '<div class="user_rows_image" data-toggle="tooltip" data-placement="bottom" title="' + $aUser['full_name'] + '">';
                                $sHtml += '<div class="img-wrapper">' + $aUser['user_image'] + '</div>';
                                $sHtml += '</div>';
                                $sHtml += '<div class="user_rows_name" style="display: none;">';
                                $sHtml += '<a class="ajax_link" href="' + $aUser['url_link'] +'">' + $aUser['full_name'] + '</a>';
                                $sHtml += '</div>';
                                if ($aUser['is_online'] == 1) {
                                    $sHtml += '<span class="js_yncfbclone_friend_active active"></span>';
                                }else {
                                    $sHtml += '<span class="js_yncfbclone_friend_active"></span>';
                                }
                                $sHtml += '</li>';
                            }
                        }
                    }
                });
                $sHtml += '</ul>';
            }
            $sHtml += '</div>';
            $('.' + $Core.autoSuggestFriends.sCurrentUsersListId).html($sHtml);
        }
    };

$Core.autoSuggestFriendsInfo =
    {
        sCurrentSearch: '',
        iMaxSearch: 20,//
        iCurrentUserValue: 0,
        isBeingBuilt: false,
        sCurrentSearchId: '',
        sCurrentUsersListId: '',
        aFoundUsers: {},
        aFoundUser: '',
        iMaxSelect: '',
        init: function (aParams) {
            this.sCurrentSearchId = aParams.sCurrentSearchId;
            this.sCurrentUsersListId = aParams.sCurrentUsersListId;

            if (!this.isBuild()) {
                this.build();
            }
        },
        isBuild: function () {
            if (!this.isBeingBuilt) {
                var ele = $('#' + this.sCurrentSearchId);
                if (ele.length && ele.hasClass('_build')) {
                    this.isBeingBuilt = true;
                }
            }

            return this.isBeingBuilt;
        },
        build: function () {
            var ele = $('#' + this.sCurrentSearchId);
            if (ele.length) {
                ele.attr('onkeyup', '$Core.autoSuggestFriendsInfo.getUsersList($(this))');
                ele.addClass('_build');

                //Init value
                this.iCurrentUserValue = $('#' + this.sCurrentValueId).val();
            }
        },
        getUsersList: function ($oObj) {
            if ($oObj.val() == '') {
                $('.js_yncfbclone_tab_friend').show();
                $('.js_yncfbclone_tab_friend_seemore').show();
                $('.js_yncfb_friend_result').hide();
                $('#js_yncfbclone_search_user_info_list').hide();
            }else {
                clearInterval(timeOutKeyUp);
                timeOutKeyUp = setTimeout(function () {
                    if ($('body').hasClass('page-loading')) return false;
                    $Core.autoSuggestFriendsInfo.sCurrentSearch = $oObj.val();
                    var profile_id = $('#js_yncfbclone_profile_user_id').val();
                    $.ajaxCall('yncfbclone.ajaxGetFriends', 'search_for=' + $oObj.val() + '&total_search=' + $Core.autoSuggestFriendsInfo.iMaxSearch + '&profile_id=' + profile_id);
                }, 500);
            }
        },
        generateSelectBox: function () {
            $('.js_yncfbclone_tab_friend_seemore').hide();
            $('.js_yncfbclone_tab_friend').hide();
            $('.js_yncfb_friend_result').show();
            $('#js_yncfbclone_search_user_info_list').show();
            var value = $('.js_yncfbclone__filter').val();

            if(value.length === 0){
                $('.js_yncfb_friend_result').text('');
            }
            var $aUsers = JSON.parse(JSON.stringify($Cache.users));
            var $sHtml = '<div>';

            if ($aUsers.length === 0) {
                $('.js_yncfb_friend_result').text(oTranslations['no_results_for'] +': ' + value);
            } else {
                $('.js_yncfb_friend_result').text(oTranslations['results_for'] + ': ' + value);
                $sHtml += '<ul class="js_friend_all_item">';
                $.each($aUsers, function ($sKey, $aUser) {
                    var $mRegSearch = new RegExp($Core.autoSuggestFriendsInfo.sCurrentSearch.value, 'i');

                    if ($aUser['full_name'].match($mRegSearch)) {
                        if ($aUser['full_name'].match($mRegSearch)) {
                            if (($aUser['user_image'].substr(0, 5) === 'http:') || ($aUser['user_image'].substr(0, 6) === 'https:')) {
                                $aUser['user_image'] = '<img src="' + $aUser['user_image'] + '">';
                            }

                            $sHtml += '<li class="js_friend_item">';
                            $sHtml += '<div class="item-outer">';
                            $sHtml += '<div class="item-image">';
                            $sHtml += '<div class="img-wrapper">' + $aUser['user_image'] + '</div>';
                            $sHtml += '</div>';
                            $sHtml += '<div class="item-content">';
                            $sHtml += '<div class="item-name">';
                            $sHtml += '<span class="user_profile_link_span" id="js_user_name_link_' + $aUser['full_name'] + '">';
                            $sHtml += '<a href="' + $aUser['url_link'] +'">'+ $aUser['full_name'] + '</a>';
                            $sHtml += '</span>';
                            $sHtml += '</div>';
                            $sHtml += '<div class="item-friend">' + $aUser['total_friend'] + ' ' + oTranslations['friends'] +'</div>';
                            $sHtml += '</div>';
                            if ($aUser['show_dropdown'] == 1) {
                                $sHtml += '<div class="dropdown friend-actions">';

                                if ($aUser['is_friend'] == 0) {
                                    if ($aUser['is_friend'] == 0 && $aUser['is_friend_request'] > 0) {
                                        $sHtml += '<a href="#" onclick="return $Core.addAsFriend('+ $aUser['user_id'] + ');" title="confirm_friend_request" class="btn btn-md btn-default btn-round">';
                                        $sHtml += '<span class="mr-1 ico ico-user2-check-o"></span>' + oTranslations['confirm'];
                                        $sHtml += '</a>';
                                    }else if ($aUser['can_add_friend'])
                                    {
                                        $sHtml += '<a href="#" onclick="return $Core.addAsFriend('+ $aUser['user_id'] + ');" title="' + oTranslations['add_as_friend'] +'" class="btn btn-md btn-default btn-round">';
                                        $sHtml += '<span class="mr-1 ico ico-user1-plus-o"></span>'+ oTranslations['add_as_friend'];
                                        $sHtml += '</a>';
                                    }

                                }else {
                                    $sHtml += '<a href="" data-toggle="dropdown" class="btn btn-md btn-default btn-round has-caret" title="friend_request_sent">';
                                    if ($aUser['is_friend'] == 1) {
                                        $sHtml += '<span class="mr-1 ico ico-check"></span>';
                                        $sHtml += oTranslations['friend'] + '<span class="ml-1 ico ico-caret-down"></span>';
                                    }else{
                                        $sHtml += '<span class="mr-1 ico ico-clock-o mr-1 friend-request-sent"></span>';
                                        $sHtml += oTranslations['request_sent'] + '<span class="ml-1 ico ico-caret-down"></span>';
                                    }
                                    $sHtml += '</a>';
                                }

                                $sHtml += '<ul class="dropdown-menu dropdown-menu-right">';
                                    if ($aUser['send_mess'] == 1) {
                                        $sHtml += '<li>';
                                        $sHtml += '<a href="#" onclick="$Core.composeMessage({user_id:' + $aUser['user_id'] + '}); return false;">';
                                        $sHtml += '<span class="mr-1 ico ico-pencilline-o"></span>'+ oTranslations['message'];
                                        $sHtml += '</a>';
                                        $sHtml += '</li>';
                                    }
                                        $sHtml += '<li>';
                                        $sHtml += '<a href="#?call=report.add&amp;height=220&amp;width=400&amp;type=user&amp;id='+$aUser['user_id']+'" class="inlinePopup" title="report_this_user">';
                                        $sHtml += '<span class="ico ico-warning-o mr-1"></span>'+ oTranslations['report_this_user'];
                                        $sHtml += '</a>';
                                        $sHtml += '</li>';

                                if ($aUser['is_friend'] == 1) {
                                    $sHtml += '<li class="item-delete">';
                                    $sHtml += '<a href="#" onclick="$Core.jsConfirm({}, function(){$.ajaxCall(\'friend.delete\', \'friend_user_id='+$aUser['user_id']+'&reload=1\');}, function(){}); return false;">';
                                    $sHtml += '<span class="mr-1 ico ico-user2-del-o"></span>'+ oTranslations['remove_friend'];
                                    $sHtml += '</a>';
                                    $sHtml += '</li>';
                                } else if ($aUser['request_id']>0) {
                                    $sHtml += '<li class="item-delete">';
                                    $sHtml += '<a href="'+$aUser['request_link'] +'" class="sJsConfirm">';
                                    $sHtml += '<span class="mr-1 ico ico-user2-del-o"></span>'+ oTranslations['cancel_request'];
                                    $sHtml += '</a>';
                                    $sHtml += '</li>';
                                }
                                $sHtml += '</ul>';

                                $sHtml += '</div>';
                            }
                            $sHtml += '</div>';
                            $sHtml += '</li>';

                        }
                    }
                });
                $sHtml += '</ul>';
            }
            $sHtml += '</div>';
            $('#' + $Core.autoSuggestFriendsInfo.sCurrentUsersListId).html($sHtml);
        }
    };

$Core.autoSuggestMutualFriendsInfo =
    {
        sCurrentSearch: '',
        iMaxSearch: 20,//
        iCurrentUserValue: 0,
        isBeingBuilt: false,
        sCurrentSearchId: '',
        sCurrentUsersListId: '',
        aFoundUsers: {},
        aFoundUser: '',
        iMaxSelect: '',
        init: function (aParams) {
            this.sCurrentSearchId = aParams.sCurrentSearchId;
            this.sCurrentUsersListId = aParams.sCurrentUsersListId;

            if (!this.isBuild()) {
                this.build();
            }
        },
        isBuild: function () {
            if (!this.isBeingBuilt) {
                var ele = $('#' + this.sCurrentSearchId);
                if (ele.length && ele.hasClass('_build')) {
                    this.isBeingBuilt = true;
                }
            }

            return this.isBeingBuilt;
        },
        build: function () {
            var ele = $('#' + this.sCurrentSearchId);
            if (ele.length) {
                ele.attr('onkeyup', '$Core.autoSuggestMutualFriendsInfo.getUsersList($(this))');
                ele.addClass('_build');

                //Init value
                this.iCurrentUserValue = $('#' + this.sCurrentValueId).val();
            }
        },
        getUsersList: function ($oObj) {
            if ($oObj.val() == '') {
                $('.js_yncfbclone_tab_mutual_friend').show();
                $('.js_yncfbclone_tab_mutual_friend_seemore').show();
                $('.js_yncfb_mutual_result').hide();
                $('#js_yncfbclone_search_mutual_user_info_list').hide();
            }else {
                clearInterval(timeOutKeyUp);
                timeOutKeyUp = setTimeout(function () {
                    if ($('body').hasClass('page-loading')) return false;
                    $Core.autoSuggestMutualFriendsInfo.sCurrentSearch = $oObj.val();
                    var profile_id = $('#js_yncfbclone_profile_user_id').val();
                    $.ajaxCall('yncfbclone.ajaxGetMutualFriends', 'search_for=' + $oObj.val() + '&total_search=' + $Core.autoSuggestMutualFriendsInfo.iMaxSearch + '&profile_id=' + profile_id);
                }, 500);
            }
        },
        generateSelectBox: function () {
            $('.js_yncfbclone_tab_mutual_friend_seemore').hide();
            $('.js_yncfbclone_tab_mutual_friend').hide();
            $('.js_yncfb_mutual_result').show();
            $('#js_yncfbclone_search_mutual_user_info_list').show();
            var value = $('.js_yncfbclone__mutual_filter').val();
            if(value.length === 0){
                $('.js_yncfb_mutual_result').text('');
            }
            var $aUsers = JSON.parse(JSON.stringify($Cache.users));
            var $sHtml = '<div>';

            if ($aUsers.length === 0) {
                $('.js_yncfb_mutual_result').text(oTranslations['no_results_for'] +': ' + value);
            } else {
                $('.js_yncfb_mutual_result').text(oTranslations['results_for'] + ': ' + value);
                $sHtml += '<ul class="js_friend_all_item">';
                $.each($aUsers, function ($sKey, $aUser) {
                    var $mRegSearch = new RegExp($Core.autoSuggestMutualFriendsInfo.sCurrentSearch.value, 'i');

                    if ($aUser['full_name'].match($mRegSearch)) {
                        if ($aUser['full_name'].match($mRegSearch)) {
                            if (($aUser['user_image'].substr(0, 5) === 'http:') || ($aUser['user_image'].substr(0, 6) === 'https:')) {
                                $aUser['user_image'] = '<img src="' + $aUser['user_image'] + '">';
                            }

                            $sHtml += '<li class="js_friend_item">';
                            $sHtml += '<div class="item-outer">';
                            $sHtml += '<div class="item-image">';
                            $sHtml += '<div class="img-wrapper">' + $aUser['user_image'] + '</div>';
                            $sHtml += '</div>';
                            $sHtml += '<div class="item-content">';
                            $sHtml += '<div class="item-name">';
                            $sHtml += '<span class="user_profile_link_span" id="js_user_name_link_' + $aUser['full_name'] + '">';
                            $sHtml += '<a href="' + $aUser['url_link'] +'">'+ $aUser['full_name'] + '</a>';
                            $sHtml += '</span>';
                            $sHtml += '</div>';
                            $sHtml += '<div class="item-friend">' + $aUser['total_friend'] + ' ' + oTranslations['friends'] +'</div>';
                            $sHtml += '</div>';
                            if ($aUser['show_dropdown'] == 1) {
                                $sHtml += '<div class="dropdown friend-actions">';
                                    $sHtml += '<a href="" data-toggle="dropdown" class="btn btn-md btn-default btn-round has-caret" title="friend_request_sent">';
                                    if ($aUser['is_friend'] == 1) {
                                        $sHtml += '<span class="mr-1 ico ico-check"></span>';
                                        $sHtml += oTranslations['friend'] + '<span class="ml-1 ico ico-caret-down"></span>';
                                    }else{
                                        $sHtml += '<span class="mr-1 ico ico-clock-o mr-1 friend-request-sent"></span>';
                                        $sHtml += oTranslations['request_sent'] + '<span class="ml-1 ico ico-caret-down"></span>';
                                    }
                                    $sHtml += '</a>';

                                    $sHtml += '<ul class="dropdown-menu dropdown-menu-right">';
                                    if ($aUser['send_mess'] == 1) {
                                        $sHtml += '<li>';
                                        $sHtml += '<a href="#" onclick="$Core.composeMessage({user_id:' + $aUser['user_id'] + '}); return false;">';
                                        $sHtml += '<span class="mr-1 ico ico-pencilline-o"></span>'+ oTranslations['message'];
                                        $sHtml += '</a>';
                                        $sHtml += '</li>';
                                    }
                                    $sHtml += '<li>';
                                    $sHtml += '<a href="#?call=report.add&amp;height=220&amp;width=400&amp;type=user&amp;id='+$aUser['user_id']+'" class="inlinePopup" title="report_this_user">';
                                    $sHtml += '<span class="ico ico-warning-o mr-1"></span>'+ oTranslations['report_this_user'];
                                    $sHtml += '</a>';
                                    $sHtml += '</li>';

                                if ($aUser['is_friend'] == 1) {
                                    $sHtml += '<li class="item-delete">';
                                    $sHtml += '<a href="#" onclick="$Core.jsConfirm({}, function(){$.ajaxCall(\'friend.delete\', \'friend_user_id='+$aUser['user_id']+'&reload=1\');}, function(){}); return false;">';
                                    $sHtml += '<span class="mr-1 ico ico-user2-del-o"></span>'+ oTranslations['remove_friend'];
                                    $sHtml += '</a>';
                                    $sHtml += '</li>';
                                }
                                $sHtml += '</ul>';

                                $sHtml += '</div>';
                            }
                            $sHtml += '</div>';
                            $sHtml += '</li>';

                        }
                    }
                });
                $sHtml += '</ul>';
            }
            $sHtml += '</div>';
            $('#' + $Core.autoSuggestMutualFriendsInfo.sCurrentUsersListId).html($sHtml);
        }
    };
