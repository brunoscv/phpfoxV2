<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:08
 */
defined('PHPFOX') or exit('NO DICE!');
?>

<div class="form-group">
    <input type="hidden" name="val[params][button_text]" value="{if isset($aForms.button_text)}{$aForms.button_text}{/if}" />
    {field_language phrase='button_text' label='text_on_button' field='button_text' format='val[params][button_text_' size=30 help_phrase='no_phrase'}
</div>
<div class="form-group">
    <label for="">
        {_p('link')}:
    </label>
    <input type="text" id="link" class="form-control" value="{if isset($aForms.params.link)}{$aForms.params.link}{/if}" name="val[params][link]">
    <input type="checkbox" name="val[params][new_tab_l]" id="new_tab_l" {if isset($aForms.params.new_tab_l)}checked{/if}> <label for="new_tab_l">{_p('open_link_in_new_tab')}</label>
</div>
<div class="panel-default pb-2">
    <div class="panel-heading">
        <div class="panel-title">
            {_p('social_connect')}
        </div>
    </div>
</div>
<div class="form-group">
    <input type="hidden" name="val[params][social_text]" value="{if isset($aForms.social_text)}{$aForms.social_text}{/if}" />
    {field_language phrase='social_text' label='text' field='social_text' format='val[params][social_text_' size=30 help_phrase='no_phrase'}
</div>
<div class="form-group">
    <label for="">
        {_p('facebook')}:
    </label>
    <input type="text" id="facebook" class="form-control" value="{if isset($aForms.params.facebook)}{$aForms.params.facebook}{/if}" name="val[params][facebook]">
    <input type="checkbox" name="val[params][new_tab_fb]" id="new_tab_fb" {if isset($aForms.params.new_tab_fb)}checked{/if}> <label for="new_tab_fb">{_p('open_link_in_new_tab')}</label>
</div>
<div class="form-group">
    <label for="">
        {_p('twitter')}:
    </label>
    <input type="text" class="form-control" id="twitter" value="{if isset($aForms.params.twitter)}{$aForms.params.twitter}{/if}" name="val[params][twitter]">
    <input type="checkbox" name="val[params][new_tab_tw]" id="new_tab_tw" {if isset($aForms.params.new_tab_tw)}checked{/if}> <label for="new_tab_tw">{_p('open_link_in_new_tab')}</label>
</div>
<div class="form-group">
    <label for="">
        {_p('google')}:
    </label>
    <input type="text" id="google" class="form-control" value="{if isset($aForms.params.google)}{$aForms.params.google}{/if}" name="val[params][google]">
    <input type="checkbox" name="val[params][new_tab_gg]" id="new_tab_gg" {if isset($aForms.params.new_tab_gg)}checked{/if}> <label for="new_tab_gg">{_p('open_link_in_new_tab')}</label>
</div>