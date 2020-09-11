<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/9/16
 * Time: 17:36
 */
defined('PHPFOX') or exit('NO DICE!');
?>

<div class="panel-heading">
    <div class="panel-title">
    {_p('Product Details')}
    </div>
</div>
<form id="ynresphoenix_add_item_form" method="post" action="{url link='current'}" enctype="multipart/form-data">
    <div class="panel-body">
        <input type="hidden" name="val[params][link_text]" value="{if isset($aForms.favorite_quote)}{$aForms.favorite_quote}{/if}" />
        <input type="hidden" name="val[description]" value="{if isset($aForms.description)}{$aForms.description}{/if}" />
        <input type="hidden" name="val[title]" value="{if isset($aForms.title)}{$aForms.title}{/if}" />
        <div class="form-group">
            {field_language phrase='title' label='title' field='title' format='val[title_' size=30 maxlength=64 help_phrase='no_phrase' required='true'}
            <div class="extra_info">
                {phrase var='ynresphoenix.maximum_limit_characters' limit='64'}
            </div>
        </div>
        <input type="hidden" name="val[params][currency]" id="currency" value="{$sSymbol}" size="30" maxlength="12" />
        <div class="form-group">
            <label>
                {_p('Price')} ({$sCurrencyId}):
            </label>
            <input class="form-control" type="text" name="val[params][price]" id="price" value="{if isset($aForms.params.price)}{$aForms.params.price}{/if}" size="30" maxlength="12" />
        </div>
        <div class=" form-group">
            <label>
                {_p('Discount price')} ({$sCurrencyId}):
            </label>
            <input class="form-control" type="text" name="val[params][discount_price]" id="discount_price" value="{if isset($aForms.params.discount_price)}{$aForms.params.discount_price}{/if}" size="30" maxlength="12" />
        </div>
        <div class=" form-group">
            {field_language phrase='description' type='textarea' label='Introduction' field='description' format='val[description_' size=30 maxlength=220 row=3 help_phrase='no_phrase'}
            <div class="extra_info">
                {phrase var='ynresphoenix.maximum_limit_characters' limit='220'}
            </div>
        </div>
        <div class="form-group">
            {field_language phrase='link_text' label='Text button' field='link_text' format='val[params][link_text_' size=30 help_phrase='no_phrase' maxlength=64}
            <label class="p_3">{_p('Product link')}:</label>
            <input class="form-control" type="text" name="val[params][link]" id="link" value="{value id='link' type='input'}" size="30" />
            <div>
                <input type="checkbox" name="val[params][new_tab_l]" {if isset($aForms.params.new_tab_l)}checked{/if}> {_p('open_link_in_new_tab')}
            </div>
        </div>
        <div class="form-group-follow" id="js_ynresphoenix_photos_gallery_holder">
            <label>
                {_p('Add more photos')}:
            </label>
            <div  id="js_submit_upload_image">
                {if $iLimit}<div id="js_progress_uploader"></div>{/if}
                <div class="extra_info">
                    {if $iLimit}{_p('ynresphoenix.you_can_upload_a_jpg_gif_or_png_file')}
                    <br/>{/if}
                    {_p('You can upload maximum')} {$iLimit} {if $iLimit == 1}{_p('photo')}{else}{_p('photos')}{/if}. {phrase var='ynresphoenix.you_should_upload_photos_with_size_of_about_size_in_order_to_get_the_best_layout' size='1000x1000'}
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <input type="submit" value="{_p('Submit')}" class="btn btn-primary" />
    </div>
</form>
<br/>
<div class="panel-heading">
    <div class="panel-title">
    {_p('Photos')}
    </div>
</div>
{if count($aImages)}
<div class="panel-body">
    <div class="table form-group-follow clearfix ynphoenix-photo-group square">
        <div class="sortable table_right">
            {foreach from=$aImages name=images item=aImage}
                <div id="js_photo_holder_{$aImage.photo_id}" class="js_photo_item" style="" >
                    <input type="hidden" name="val[ordering][{$aImage.photo_id}]" class="js_mp_order" value="{$aImage.ordering}">
                    <a href="" class="ynresphoenix-delete-btn" title="{_p('Delete this photo')}" onclick="$Core.jsConfirm({l}message:'{_p('Are you sure to delete this photo?')}'{r},function(){l}$.ajaxCall('ynresphoenix.deletePhoto', 'id={$aImage.photo_id}&product_id={$aForms.item_id}'){r});return false;">{img theme='misc/delete_hover.gif' alt=''}</a>
                    <span id="js_photo_item_{$aImage.photo_id}" class="{if $aImage.photo_type == 'main_photo'}is_main_photo{/if}" data-id="{$aImage.photo_id}" data-product="{if isset($aForms)}{$aForms.item_id}{/if}" onclick="setMainPhoto(this)">
                        {img server_id=$aImage.server_id path='core.url_pic' file=$aImage.photo_path suffix='_1024' width='120px'}
                    </span>
                    <div class="p_4"></div>
                </div>
                {if is_int($phpfox.iteration.images/4)}
                {/if}
            {/foreach}
        </div>
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
    };
    function setMainPhoto(ele)
    {
        var photo_id = $(ele).data('id'),
            product_id = $(ele).data('product');
        $(".js_photo_item").find("span").removeClass("is_main_photo");
        $("#js_photo_item_"+ photo_id).addClass("is_main_photo");
        $.ajaxCall('ynresphoenix.setMainPhoto',$.param({photo_id: photo_id,product_id:product_id}));
    }
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
        $('.apps_menu > ul').find('li:eq(4) a').addClass('active');
    }
</script>
{/literal}