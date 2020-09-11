<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:08
 */
defined('PHPFOX') or exit('NO DICE!');
?>

<div class="panel-heading">
    <div class="panel-title">
    {_p('Gallery Details')}
    </div>
</div>
<form id="ynresphoenix_add_item_form" method="post" action="{url link='current'}" enctype="multipart/form-data">
    <div class="panel-body">
        <input type="hidden" name="val[title]" value="{if isset($aForms.title)}{$aForms.title}{/if}" />
        <div class="form-group-follow" id="js_ynresphoenix_photos_gallery_holder">
            <div class="table form-group">
                {field_language phrase='title' label='title' field='title' format='val[title_' size=30 maxlength=64 help_phrase='no_phrase' required='true'}
                <div class="extra_info">
                    {phrase var='ynresphoenix.maximum_limit_characters' limit='32'}
                </div>
            </div>
            <div class="form-group">
                <label>
                    {if count($aImages) == 0}{required}{/if}{_p('Photos')}:
                </label>
                <input type="hidden" name="val[had_photo]" id="had_photo" value="{if count($aImages)}1{else}0{/if}">
                <div id="js_submit_upload_image">
                    {if $iLimit}
                    <div id="js_progress_uploader"></div>
                    {/if}
                    <div class="extra_info">
                        {if $iLimit}{_p('ynresphoenix.you_can_upload_a_jpg_gif_or_png_file')}
                        <br/>{/if}
                        {_p('You can upload maximum')} {$iLimit} {if $iLimit == 1}{_p('photo')}{else}{_p('photos')}{/if}. {phrase var='ynresphoenix.you_should_upload_photos_with_size_of_about_size_in_order_to_get_the_best_layout' size=$sRecommendSize}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <input type="submit" value="{if count($aImages) == 0}{_p('Upload')}{else}{_p('Update')}{/if}" name="val[submit]" class="btn btn-primary" />
    </div>
</form>

<br/>
<div class="panel-heading">
    <div class="panel-title">
        {_p('Photos')}
    </div>
</div>
{if count($aImages)}
    <div class="ynphoenix-gallery-photo-group table form-group-follow clearfix panel-body">
        <div class="sortable table_right">
            {foreach from=$aImages name=images item=aImage}
                <div id="js_photo_holder_{$aImage.photo_id}" class="js_photo_item" style="">
                    <input type="hidden" name="val[ordering][{$aImage.photo_id}]" class="js_mp_order" value="{$aImage.ordering}">
                    <input type="hidden" id="yn_photo_caption_{$aImage.photo_id}" name="val[photo][caption][{$aImage.photo_id}]" value="{$aImage.description}">
                    <div class="ynphoenix-img">
                        <a href="" class="ynresphoenix-delete-btn" title="{_p('Delete this photo')}" onclick="$Core.jsConfirm({l}message:'{_p('Are you sure to delete this photo?')}'{r},function(){l}$.ajaxCall('ynresphoenix.deletePhoto', 'id={$aImage.photo_id}'){r});return false;">{img theme='misc/delete_hover.gif' alt=''}</a>
                        {img server_id=$aImage.server_id path='core.url_pic' file=$aImage.photo_path suffix='_1024' width='120px'}
                    </div>

                    {foreach from=$aLanguages item=aLanguage}
                        <input type="text" value="{if !empty($aImage.description)}{_p var=$aImage.description language=$aLanguage.language_id}{/if}" data-language="{$aLanguage.language_id}" data-id="{$aImage.photo_id}" placeholder="{_p('Enter photo caption')} {$aLanguage.title}..." class="js_photo_caption form-control js_yn_item_photo_{$aImage.photo_id}" id="js_yn_item_photo_{$aImage.photo_id}" maxlength="100" size="20" style="margin: 5px;">
                    {/foreach}
                    <button style="display: none;" class="js_button_save btn btn-primary" data-id="{$aImage.photo_id}" id="js_button_save_{$aImage.photo_id}">{_p('Save')}</button>
                </div>
                {if is_int($phpfox.iteration.images/4)}
                {/if}
            {/foreach}
        </div>

    </div>

{literal}
<script type="text/javascript">
    $Behavior.yrbUpdateOrderPhotos = function(){
        $('.sortable').sortable({
                opacity: 0.6,
                cursor: 'move',
                scrollSensitivity: 40,
                update: function(element, ui)
                {
                    var iCnt = 0;
                    sParams = '';
                    $('.sortable .js_mp_order').each(function()
                    {
                        iCnt++;
                        this.value = iCnt;
                        sParams += '&' + $(this).attr('name') + '=' + iCnt;
                    });
                    $Core.ajaxMessage();
                    sParams += '&iParent=' + {/literal}{$iEditId}{literal} + '&global_ajax_message=true';
                    $.ajaxCall('ynresphoenix.updatePhotoOrdering', sParams);
                },
            }
        );
        $('.js_photo_caption').on('keyup',function(){
            $(this).parent().find('.js_button_save').show();
        });
        $('.js_button_save').on('click',function(){
            var iId = $(this).data('id'),
                caption = $('#yn_photo_caption_' + iId).val(),
                aTexts = {};
            aTexts['description'] = caption;
            $('.js_yn_item_photo_' + iId).each(function(){
                 var language = $(this).data('language');
                 aTexts['description_'+language] = $(this).val();
            })
            $.ajaxCall('ynresphoenix.updatePhotoCaption', $.param({id:iId,aVals:aTexts}));
            $(this).hide();
        });
    };
</script>
{/literal}
{else}
<div class="panel-body">
    {_p('No photos found.')}
</div>
{/if}
{literal}
<script>
    $Behavior.onLoadManagePage = function(){
        if($('.apps_menu').length == 0) return false;
        $('.apps_menu > ul').find('li:eq(6) a').addClass('active');
    }
</script>
{/literal}
