<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/5/16
 * Time: 15:05
 */
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="form-group">
    <label>
        {_p('Show Map')}
    </label>
    <div class="item_is_active_holder {if isset($aForms.params.show_map) && $aForms.params.show_map} item_selection_active {else} item_selection_not_active {/if}">
        <span class="js_item_active item_is_active">
            <input type="radio" value="1" name="val[params][show_map]" {if (isset($aForms.params.show_map) && $aForms.params.show_map) || !isset($aForms.params.show_map)} checked="checked" {/if}> {_p('core.yes')}
        </span>
        <span class="js_item_active item_is_not_active">
            <input type="radio" value="0" name="val[params][show_map]" {if !isset($aForms.params.show_map) && !$aForms.params.show_map} checked="checked" {/if}> {_p('core.no')}
        </span>
    </div>
</div>
<div class="form-group">
    <label>
        {_p('Main Photo')}:
        <br/>
        {if !empty($aForms.params.main_photo_path)}
            {img server_id=$aForms.server_id path='core.url_pic' file=$aForms.params.main_photo_path suffix='_1024' width='200px'}
        {/if}
    </label>

    <input type="file" id="main_photo" name="main_photo" class="form-control">
    <div class="extra_info">{_p('ynresphoenix.you_can_upload_a_jpg_gif_or_png_file')} </div>
</div>
