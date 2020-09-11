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
        {_p('Testimonial Details')}
    </div>
</div>
<form id="ynresphoenix_add_item_form" method="post" action="{url link='current'}" enctype="multipart/form-data">
    <div class="panel-body">
        <input type="hidden" name="val[params][position]" value="{if isset($aForms.position)}{$aForms.position}{/if}" />
        <input type="hidden" name="val[description]" value="{if isset($aForms.description)}{$aForms.description}{/if}" />
        <div class="form-group">
            <label for="title">
                {required}{_p('User')}:
            </label>
            <input class="form-control" type="text" name="val[title]" id="title" value="{value id='title' type='input'}" size="30" maxlength="64" />
            <div class="extra_info">
                {phrase var='ynresphoenix.maximum_limit_characters' limit='64'}
            </div>
        </div>
        <div class="form-group">
            {field_language phrase='position' label='User Position' field='position' format='val[params][position_' size=30 maxlength=150 help_phrase='no_phrase'}
        </div>
        <div class="form-group-follow">
            <label class="user_photo">
                {_p('User Image')}:
            </label>
            <div id="js_submit_upload_image">
                {if isset($aForms.photo)}
                    {img path='core.url_pic' file=$aForms.photo server_id=$aForms.server_id suffix='_1024' width='100px'}
                    <div class="p_4"></div>
                {/if}
                <input type="file" class="form-control" id='user_photo' name="photo"/>
                <div class="extra_info">
                    {_p('you_can_upload_a_jpg_gif_or_png_file')} {phrase var='ynresphoenix.you_should_upload_photos_with_size_of_about_size_in_order_to_get_the_best_layout' size='120x120'}
                </div>
            </div>
        </div>
        <div class="form-group">
            {field_language phrase='description' type='textarea' label='Testimonial' field='description' format='val[description_' size=30 maxlength=220 row=3 help_phrase='no_phrase' required='true'}
            <div class="extra_info">
                {phrase var='maximum_limit_characters' limit='220'}
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
        $('.apps_menu > ul').find('li:eq(5) a').addClass('active');
    }
</script>
{/literal}
