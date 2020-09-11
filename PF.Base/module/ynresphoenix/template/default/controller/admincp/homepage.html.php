<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:08
 */
defined('PHPFOX') or exit('NO DICE!');
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            {_p('Homepage Details')}
        </div>
    </div>
    <form id="ynresphoenix_add_item_form" method="post" action="{url link='current'}" enctype="multipart/form-data">
        <div class="panel-body">
            <div class="form-group-follow" id="js_ynresphoenix_slider_photos_holder">
                <label>
                   {_p('Add Photos to homepage slider')}:
                </label>
                <div id="js_submit_upload_image">
                    {if $iLimit}<div id="js_progress_uploader"></div>{/if}
                    <div class="extra_info">
                        {if $iLimit}{_p('ynresphoenix.you_can_upload_a_jpg_gif_or_png_file')}
                        <br/>{/if}
                        {_p('You can upload maximum')} {$iLimit} {if $iLimit == 1}{_p('photo')}{else}{_p('photos')}{/if}. {phrase var='ynresphoenix.you_should_upload_photos_with_size_of_about_size_in_order_to_get_the_best_layout' size=$sRecommendSize}
                    </div>
                </div>
            </div>
        </div>
        {if $iLimit}
        <div class="panel-footer">
            <input type="submit" value="{_p('Upload')}" name="val[submit]" class="btn btn-primary" />
        </div>
        {/if}
    </form>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            {_p('Photos')}
        </div>
    </div>
    {if count($aImages)}
        <div class="table form-group-follow ynphoenix-photo-group clearfix panel-body">
            <div class="sortable table_right">
                {foreach from=$aImages name=images item=aImage}
                    <div id="js_photo_holder_{$aImage.photo_id}" class="js_photo_item" style="">
                        <input type="hidden" name="val[ordering][{$aImage.photo_id}]" class="js_mp_order" value="{$aImage.ordering}">
                        <a href="" class="ynresphoenix-delete-btn" title="{_p('Delete this photo')}" onclick="$Core.jsConfirm({l}message:'{_p('Are you sure to delete this photo?')}'{r},function(){l}$.ajaxCall('ynresphoenix.deletePhoto', 'id={$aImage.photo_id}'){r});return false;">{img theme='misc/delete_hover.gif' alt=''}</a>
                        {img server_id=$aImage.server_id path='core.url_pic' file=$aImage.photo_path suffix='_1024' width='150px'}
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
                        $.ajaxCall('ynresphoenix.updatePhotoOrdering', sParams + '&global_ajax_message=true');
                    },
                }
            );
            $('.js_photo_caption').on('keyup',function(){
                $(this).parent().find('.js_button_save').show();
            });
            $('.js_button_save').on('click',function(){
                var ele = $(this).parent().find('.js_photo_caption'),
                    sText = ele.val(),
                    iId = ele.data('id');
                $.ajaxCall('ynresphoenix.updatePhotoCaption', $.param({id:iId,text:sText}));
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
</div>
