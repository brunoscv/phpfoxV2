<?php
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="ync-fbclone-profile-video-section">   
    <div class="item-container profile-video-listing " id="profile-container-video">
        {if count($aVideos)>0}
        {foreach from=$aVideos item=aItem}
        <div id="js_video_item_{$aItem.video_id}" class="video-item  js_video_parent"  data-uid="{$aItem.video_id}" >
            <div class="item-outer">
                <!-- moderate_checkbox -->
                <div class="{if !empty($bShowModerator)} moderation_row{/if}">
                    {if !empty($bShowModerator) && $bModeratorVideoActive}
                    <label class="item-checkbox">
                        <input type="checkbox" class="js_global_item_moderate" name="item_moderate[]" value="{$aItem.video_id}" id="check{$aItem.video_id}" />
                        <i class="ico ico-square-o"></i>
                    </label>
                    {/if}
                </div>
                <!-- image -->
                <a class="item-media-src" href="{$aItem.link}">
                    <span class="image_load" data-src="{$aItem.image_path}"></span>
                    <div class="item-media-flag">
                        {if isset($sView) && $sView == 'my' && $aItem.view_id != 0}
                        <div class="sticky-label-icon sticky-pending-icon">
                            <span class="flag-style-arrow"></span>
                            <i class="ico ico-clock-o"></i>
                        </div>
                        {/if}
                        {if $aItem.is_sponsor}
                        <!-- Sponsor -->
                        <div class="sticky-label-icon sticky-sponsored-icon">
                            <span class="flag-style-arrow"></span>
                            <i class="ico ico-sponsor"></i>
                        </div>
                        {/if}
                        {if $aItem.is_featured}
                        <!-- Featured -->
                        <div class="sticky-label-icon sticky-featured-icon">
                            <span class="flag-style-arrow"></span>
                            <i class="ico ico-diamond"></i>
                        </div>
                        {/if}
                    </div>
                </a>
               
                <div class="item-inner">
                    <!-- please show length video time -->
                    {if !empty($aItem.duration)}
                    <div class="item-video-length"><span>{$aItem.duration}</span></div>
                    {/if} 
                </div>
                 <!-- dropdown -->
                {if $aItem.hasPermission}
                <div class="item-option video-button-option">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="ico ico-pencil"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" id="js_video_entry_options_{$aItem.video_id}">
                            {template file='v.block.menu'}
                        </ul>
                    </div>
                </div>
                {/if}
            </div>
        </div>
        {/foreach}
        {else}
        <div class="extra_info p-2">
            {_p var='no_videos_found'}
        </div>
        {/if}
    </div>
{if $bShowModerator && $bModeratorVideoActive}
    {moderation}
{/if}
{if !empty($sMore)}<a class="ync-fbclone-information-view-more" href="{$sLinkViewMore}">{_p var = 'see_all'}</a>{/if}
</div>

