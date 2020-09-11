<?php
defined('PHPFOX') or exit('NO DICE!');
?>
<form class="form" method="post" action="{url link='current'}" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">{_p var = edit_icon}</div>
        </div>
        <div class="panel-body">
            <input type="hidden" name="menu_id" value="{$iEditId}" />
            <div class="form-group">
                <label for="image">{ _p var='Icon' }</label>&nbsp;
                <span>
                {if !empty($aForms.mobile_icon) || !empty($aForms.image_path)}
                    {if !empty($aForms.mobile_icon) && !empty($aForms.image_path)}
                        <img src="{$aForms.full_path}" alt="" width="32" height="32">
                    {else}
                        {if $aForms.module_id == 'pages'}
                            <i class="ico ico-flag-waving-o" style="color: #3b5998"></i>
                        {else}
                            <i class="{$aForms.mobile_icon}" style="color: #3b5998"></i>
                        {/if}
                    {/if}
                {else}
                    <i class="ico ico-box-o"></i>
                {/if}
                </span>
                <br />
                <input type="file" name="image" id="image" accept="image/*" class="form-control">
                <p class="help-block">
                    {_p var='you_should_upload_transparent_png_with_size_32_x_32_in_order_to_get_the_best_layout'}
                </p>
            </div>
        </div>
        <div class="panel-footer">
            <input type="submit" value="{_p var='submit'}" class="btn btn-primary" />
            <a href="{url link='admincp.yncfbclone.menu-icons'}" class="btn btn-defaut">{_p var='cancel'}</a>
        </div>
    </div>
</form>