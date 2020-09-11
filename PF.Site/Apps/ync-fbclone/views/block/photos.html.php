<?php
defined('PHPFOX') or exit('NO DICE!');
?>

<div id="js_yncfbclone_section_photo" class="ync-fbclone-profile-photo-section ync-fbclone-information-section">
    <div class="ync-fbclone-information-header" id="js_yncfbclone_section_photo_header">
        <ul>
            <li id="js_yncfbclone_photo" class="active"><a href="#tab1" rel="tab1" {if !$bIsInfoPages}onclick="$.ajaxCall('yncfbclone.redirectPhoto', 'name={$sName}');"{/if}>{_p var = 'photos'} <span class="item-number">{$iCntPhoto}</span></a></li>
            <li id="js_yncfbclone_album"><a href="#tab2" rel="tab2" {if !$bIsInfoPages}onclick="$.ajaxCall('yncfbclone.redirectAlbum', 'name={$sName}');"{/if}>{_p var = 'albums'} <span class="item-number">{$iCntAlbum}</span></a></li>
        </ul>
    </div>

    <div id="tabs_content_container" class="ync-fbclone-information-content">
        <span class="js_yncfbclone_is_photo_profile" data-is-profile="{$$bIsPhotoProfile}"></span>
        <div id="tab1" class="tab_content container-photo" style="display: block;">
            <div class="item-container profile-photo-listing clearfix" id="photo_collection">
                {if count($aPhotos)>0}
                {foreach from=$aPhotos item=aForms}
                    <article class="photo-listing-item feature-photo sponsored-photo" data-url="{$aForms.link}" data-photo-id="{$aForms.photo_id}" id="js_photo_id_{$aForms.photo_id}">
                        <div class="item-outer">
                            <a class="item-media" {if !$aForms.can_view} class="no_ajax_link" onclick="tb_show('{_p('warning')}', $.ajaxBox('photo.warning', 'height=300&width=350&link={$aForms.link}')); return false;" href="javascript:;" {else} href="{$aForms.link}" {/if}
                            {if !empty($aForms.destination)}style="background-image: url({if !$aForms.can_view}{img theme="misc/mature.jpg" return_url=true}{else}{img server_id=$aForms.server_id path='photo.url_photo' file=$aForms.destination suffix='_500' title=$aForms.title return_url=true}{/if})"{/if}>
                            </a>
                            <div class="item-inner {if $aForms.hasPermission}has-permission{/if}">
                                <a class="item-title fw-bold" href="{$aForms.link}">
                                    {$aForms.title|clean}
                                </a>
                                <div class="item-inner-bottom js_yncfbclone_like_photo">
                                    <div class="js_item_is_not_like">
                                        <a href="#?call=yncfbclone.delete&amp;type_id=photo&amp;item_id={$aForms.photo_id}&amp;like=1" class="js_yncfbclone_item_like <?php if ((int)$this->_aVars['aForms']['is_liked'] > 0): ?>is_liked<?php endif; ?>">{_p var = 'unlike'}</a>
                                    </div>
                                    <div class="js_item_is_like">
                                        <a href="#?call=yncfbclone.add&amp;type_id=photo&amp;item_id={$aForms.photo_id}&amp;like=0" class="js_yncfbclone_item_like <?php if ((int)$this->_aVars['aForms']['is_liked'] == 0): ?>is_liked<?php endif; ?>">{_p var = 'like'}</a>
                                    </div>
                                    <a href="{$aForms.link}" class="item-comment">{_p var = 'comment'}</a>
                                    <div class="item-like-icon">
                                        <i class="ico ico-thumbup"></i><span id="js_yncfbclone_total_like_{$aForms.photo_id}">{$aForms.total_like}</span> 
                                    </div>
                                </div>
                            </div>

                            <div class="item-media-flag">
                                {if (isset($sView) && $sView == 'my' || isset($bIsDetail)) && $aForms.view_id == 1}
                                <div class="sticky-label-icon sticky-pending-icon">
                                    <span class="flag-style-arrow"></span>
                                    <i class="ico ico-clock-o"></i>
                                </div>
                                {/if}
                                {if $aForms.is_sponsor}
                                <div class="sticky-label-icon sticky-sponsored-icon">
                                    <span class="flag-style-arrow"></span>
                                    <i class="ico ico-sponsor"></i>
                                </div>
                                {/if}
                                {if $aForms.is_featured}
                                <div class="sticky-label-icon sticky-featured-icon">
                                    <span class="flag-style-arrow"></span>
                                    <i class="ico ico-diamond"></i>
                                </div>
                                {/if}
                            </div>

                            {if $bShowModerator && $bModeratorPhotoActive}
                                <div class="{if $bShowModerator} moderation_row{/if} js_moderation_photo">
                                   {if !empty($bShowModerator)}
                                       <label class="item-checkbox">
                                           <input type="checkbox" class="js_global_item_moderate" name="item_moderate[]" value="{$aForms.photo_id}" id="check{$aForms.photo_id}" />
                                           <i class="ico ico-square-o"></i>
                                       </label>
                                   {/if}
                                </div>
                            {/if}
                            {if $aForms.hasPermission}
                                <div class="item-option photo-button-option">
                                    <div class="dropdown">
                                        <span role="button" class="row_edit_bar_action" data-toggle="dropdown">
                                            <i class="ico ico-pencil"></i>
                                        </span>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            {template file='photo.block.menu'}
                                        </ul>
                                    </div>
                                </div>
                            {/if}
                        </div>
                        <ul>
                            <li>
                                
                            </li>
                        </ul>
                    </article>
                {/foreach}
                {else}
                <div class="extra_info p-2">
                    {_p var='no_photos_found'}
                </div>
                {/if}
            </div>
            {if $bShowModerator && $bModeratorPhotoActive}
                {moderation}
            {/if}
            {if !empty($sMore) && !empty($sLinkPhoto)}<a class="ync-fbclone-information-view-more" href="{$sLinkPhoto}">{_p var = 'see_all'}</a>{/if}
        </div>
        <div id="tab2" class="tab_content container-album">
            <div class="profile-album-listing item-container" id="profile-album-collection">
                {if count($aAlbums)>0}
                {foreach from=$aAlbums item=aAlbum name=albums}
                <article data-url="{$aAlbum.link}" data-uid="{$aAlbum.album_id}" id="js_album_id_{$aAlbum.album_id}" class="photo-album-item">
                    <div class="item-outer">
                        <div class="item-media">
                            <a href="{$aAlbum.link}" style="background-image: url(
                        {if ($aAlbum.mature == 0 || (($aAlbum.mature == 1 || $aAlbum.mature == 2) && Phpfox::getUserId() && Phpfox::getUserParam('photo.photo_mature_age_limit') <= Phpfox::getUserBy('age'))) || $aAlbum.user_id == Phpfox::getUserId()}
                            {if !empty($aAlbum.destination)}
                                {img return_url="true" server_id=$aAlbum.server_id path='photo.url_photo' file=$aAlbum.destination suffix='_500' max_width=500 max_height=500}
                            {else}
                            {param var='photo.default_album_photo'}
                            {/if}
                            {else}
                            {img return_url="true" theme='misc/mature.jpg' alt=''}
                            {/if}
                            )">
                            </a>
                            
                        </div>

                        <div class="item-inner {if $aAlbum.hasPermission}has-permission{/if}">
                            <div class="item-title"><a class="text-transition" href="{$aAlbum.link}">{$aAlbum.name|clean}</a></div>
                            <div class="item-info">
                                <span class="item-total-photo">
                                    {if isset($aAlbum.total_photo)}
                                        {if $aAlbum.total_photo == '1'}1{else}{$aAlbum.total_photo|number_format}{/if}<span class="item-text">{_p var = 'items'}</span>
                                    {/if}
                                </span>
                                <span class="item-privacy">
                                    {$aAlbum.privacy_text}
                                </span>
                            </div>
                            {if $aAlbum.hasPermission}
                            <div class="item-option">
                                <div class="dropdown">
                            <span role="button" class="row_edit_bar_action" data-toggle="dropdown">
                                <i class="ico ico-dottedmore"></i>
                            </span>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        {template file='photo.block.menu-album'}
                                    </ul>
                                </div>
                            </div>
                            {/if}
                        </div>

                        {if $bShowModeratorAlbum && $aAlbum.canDelete && $bModeratorAlbumActive}
                        <div class="moderation_row js_moderation_album">
                            <label class="item-checkbox">
                                <input type="checkbox" class="js_global_item_moderate" name="item_moderate[]" value="{$aAlbum.album_id}" id="check{$aAlbum.album_id}" />
                                <i class="ico ico-square-o"></i>
                            </label>
                        </div>
                        {/if}
                    </div>
                </article>
                {/foreach}
                {else}
                <div class="extra_info pt-2 px-1">
                    {_p var='no_albums_found'}
                </div>
                {/if}
            </div>
            
            {if !empty($sMore) && !empty($sLinkAlbums)}<a class="ync-fbclone-information-view-more" href="{$sLinkAlbums}">{_p var = 'see_all'}</a>{/if}
            {if $bShowModeratorAlbum && $bModeratorAlbumActive}
                {moderation}
            {/if}
        </div>
    </div>
</div>
{literal}
<script type="text/javascript">
    $Behavior.activeBlockProfile = function() {
        if ($('#page_yncfbclone_photoprofile').length > 0) {
            if ($('.js_yncfbclone_is_photo_profile').data('is-profile') == 0) {
                $('.ync-fbclone-information-content').find('.container-photo').hide();
                $('.ync-fbclone-information-content').find('.container-album').show();
                $('#js_yncfbclone_photo').removeClass('active');
                $('#js_yncfbclone_album').addClass('active');
            } else {
                $('.ync-fbclone-information-content').find('.container-photo').show();
                $('.ync-fbclone-information-content').find('.container-album').hide();
                $('#js_yncfbclone_photo').addClass('active');
                $('#js_yncfbclone_album').removeClass('active');
            }
        }
    }
</script>
{/literal}