<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/7/16
 * Time: 16:06
 */
?>

<div class="panel-heading">
    <div class="panel-title">
    {_p('Member Details')}
    </div>
</div>
<form id="ynresphoenix_add_item_form" method="post" action="{url link='current'}" enctype="multipart/form-data">
    <div class="panel-body">
        <input type="hidden" name="val[params][position]" value="{if isset($aForms.position)}{$aForms.position}{/if}" />
        <input type="hidden" name="val[params][favorite_quote]" value="{if isset($aForms.favorite_quote)}{$aForms.favorite_quote}{/if}" />
        <input type="hidden" name="val[description]" value="{if isset($aForms.description)}{$aForms.description}{/if}" />
        <div class="form-group">
            <label for="title">
                {required}{_p('Name')}:
            </label>
            <input type="text" class="form-control" name="val[title]" id="title" value="{value id='title' type='input'}" size="30" maxlength="64" />
            <div class="extra_info">
                {phrase var='ynresphoenix.maximum_limit_characters' limit='64'}
            </div>
        </div>
        <div class="form-group">
            {field_language phrase='position' label='Position' field='position' format='val[params][position_' size=30 help_phrase='no_phrase' maxlength=64 required='true'}
            <div class="extra_info">
                {phrase var='ynresphoenix.maximum_limit_characters' limit='64'}
            </div>
        </div>
        <div class="form-group-follow">
            <label for="photo">
                {required}{_p('Photo')}:
            </label>
            <div id="js_submit_upload_image">
                {if isset($aForms.photo)}
                    {img path='core.url_pic' file=$aForms.photo server_id=$aForms.server_id suffix='_1024' width='200px'}
                <div class="p_4"></div>
                {/if}
                <input type="hidden" name="val[had_photo]" id="had_photo" value="{if empty($aForms.photo)}0{else}1{/if}">
                <input class="form-control" type="file" id='photo' name="photo"/>
                <div class="extra_info">
                    {_p('ynresphoenix.you_can_upload_a_jpg_gif_or_png_file')}
                </div>
            </div>
        </div>
        <div class="form-group">
            {field_language phrase='description' type='textarea' label='Introduction' field='description' format='val[description_' size=30 maxlength=500 row=3 help_phrase='no_phrase'}
            <div class="extra_info">
                {_p var='maximum_limit_characters' limit='500'}
            </div>
        </div>
        <div class="form-group">
            <label for="phone">
                {_p('Phone')}:
            </label>
            <input class="form-control" type="text" name="val[params][phone]" id="phone" value="{if isset($aForms.params.phone)}{$aForms.params.phone}{/if}" size="30" maxlength="64" />
        </div>
        <div class=" form-group">
            <label for="email">
                {_p('Email')}:
            </label>
            <input type="text" class="form-control" name="val[params][email]" id="email" value="{if isset($aForms.params.email)}{$aForms.params.email}{/if}" size="30" maxlength="150" />
        </div>
        <div class=" form-group">
            <label for="address">
                {_p('Address')}:
            </label>
            <input type="text" class="form-control" name="val[params][address]" id="address" value="{if isset($aForms.params.address)}{$aForms.params.address}{/if}" size="30" maxlength="150" />
        </div>
        <div class="form-group">
            {field_language phrase='favorite_quote' type='textarea' label='Favourite quote' field='favorite_quote_' format='val[params][favorite_quote_' size=30 help_phrase='no_phrase' maxlength=500}
            <div class="extra_info">
                {phrase var='ynresphoenix.maximum_limit_characters' limit='500'}
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <input type="submit" value="{_p('Submit')}" class="btn btn-primary" />
    </div>
</form>
{literal}
<script type="text/javascript">
    $Behavior.onLoadManagePage = function(){
        if($('.apps_menu').length == 0) return false;
        $('.apps_menu > ul').find('li:eq(3) a').addClass('active');
    }
</script>
{/literal}
