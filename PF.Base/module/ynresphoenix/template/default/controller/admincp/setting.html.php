<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:08
 */
defined('PHPFOX') or exit('NO DICE!');
?>

<form action="{url link='current'}" id="ynresphoenix_setting_page_form" method="POST" enctype="multipart/form-data">
    <div class="panel panel-default" id="ynresphoenix_manage_pages">

        <div class="panel-heading">
            <div class="panel-title">
                {$sPageTitle} {_p('settings')}
            </div>
        </div>
        <input type="hidden" name="val[id]" value="{$aForms.page_id}" />
        <input type="hidden" name="val[type]" value="{$sPagesType}" />
        <input type="hidden" name="val[title]" value="{$aForms.title}" />
        <input type="hidden" name="val[description]" value="{$aForms.description}" />
        <div class="panel-body">
            <div class="form-group">
                {field_language phrase='title' label='title' field='title' format='val[title_' size=30 maxlength=64 help_phrase='no_phrase'}
                <div class="extra_info">{_p('Title will be shown when hover over icon at homepage and in detail of block')}. {_p var='maximum_limit_characters' limit='64'}</div>
            </div>
            {if $sPagesType == 'home' || $sPagesType == 'statistic'}
                <div class="form-group">
                    {field_language phrase='description' type='textarea' label='description' field='description' format='val[description_' size=30 maxlength=250 row=3 help_phrase='no_phrase'}
                    <div class="extra_info">{phrase var='ynresphoenix.maximum_limit_characters' limit='250'}</div>
                </div>
            {/if}
            {if $sPagesType != 'testimonial' && $sPagesType != 'home'}
                <div class="form-group">
                    <label for="background">
                        {_p('background_image')}:
                        <br/>
                        {if !empty($aForms.background_path)}
                            {img server_id=$aForms.server_id path='core.url_pic' file=$aForms.background_path suffix='_1024' width='200px'}
                        {/if}
                    </label>
                    <input type="file" id="background" class="form-control" name="background">
                    <div class="extra_info">{_p('you_can_upload_a_jpg_gif_or_png_file')} {phrase var='ynresphoenix.you_should_upload_photos_with_size_of_about_size_in_order_to_get_the_best_layout' size=$sRecommendSize}</div>
                </div>
            {/if}
            {if $sPagesType == 'contact'}
                {template file='ynresphoenix.block.settings.contact'}
            {/if}
            <div class="form-group">
                <label for="icon" class="ynresphoenix_icon">
                    {_p('icon')}:
                    <br/>
                    {if !empty($aForms.icon_path)}
                        {img server_id=$aForms.icon_server_id path='core.url_pic' file=$aForms.icon_path suffix='_32'}
                    {elseif isset($aForms.default_icon)}
                        {$aForms.default_icon}
                    {/if}
                </label>
                <input class="form-control" type="file" id="icon" name="icon">
                <div class="extra_info">{_p('you_can_upload_a_jpg_gif_or_png_file')} {phrase var='ynresphoenix.you_should_upload_photos_with_size_of_about_size_in_order_to_get_the_best_layout' size='16x16'}</div>
            </div>
            <div class="form-group">
                <label for="icon_hover" class="ynresphoenix_icon">
                    {_p('hover_icon')}:
                    <br/>
                    {if !empty($aForms.icon_hover_path)}
                        {img server_id=$aForms.icon_hover_server_id path='core.url_pic' file=$aForms.icon_hover_path suffix='_32'}
                    {elseif isset($aForms.default_icon)}
                        {$aForms.default_icon}
                    {/if}
                </label>
                <input class="form-control" type="file" id="icon_hover" name="icon_hover">
                <div class="extra_info">{_p('you_can_upload_a_jpg_gif_or_png_file')} {phrase var='ynresphoenix.you_should_upload_photos_with_size_of_about_size_in_order_to_get_the_best_layout' size='16x16'}</div>
            </div>
            <!-- Specific section as page type -->
            {if $sPagesType == 'home'}
                {template file='ynresphoenix.block.settings.home'}
            {elseif $sPagesType == 'introduction'}
                {template file='ynresphoenix.block.settings.introduction'}
            {/if}
            <!-- End specific section -->
        </div>
        <div class="panel-footer">
            <input type="submit" value="{_p('ynresphoenix.submit')}" class="btn btn-primary" />
            <input type="button" value="{_p('ynresphoenix.view_sample_layout')}" class="btn btn-success" onclick="return ynresphoenix.showSampleLayout('{$sSamplePath}');"/>
            <a href="{url link='admincp.ynresphoenix'}" class="btn btn-default">{_p var='cancel'}</a>
        </div>
    </div>
</form>

{literal}
<script type="text/javascript">
    $Behavior.onLoadSettingPage = function(){
        if($('.apps_menu').length == 0) return false;
        $('.apps_menu > ul').find('li:eq(1) a').addClass('active');
    }
</script>
{/literal}