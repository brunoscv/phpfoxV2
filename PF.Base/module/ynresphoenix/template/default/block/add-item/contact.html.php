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
        {_p('Contact Details')}
    </div>
</div>

<form id="ynresphoenix_add_item_form" method="post" action="{url link='current'}" enctype="multipart/form-data">
    <div class="panel-body">
        <div class="table_header" >{_p('Location')}</div>
        <input type="hidden" name="val[title]" value="{if isset($aForms.title)}{$aForms.title}{/if}" />
        <div class="form-group">
            {field_language phrase='title' label='title' field='title' format='val[title_' size=30 maxlength=32 help_phrase='no_phrase' required='true'}
        </div>
        <div class="form-group js_map_holder">
            <label for="js_ynresphoenix_location">
                {_p('Address')}:
            </label>
            <div class="js_location">
                <input class="form-control" id="js_ynresphoenix_location" type="text" data-inputid="fulladdress" name="val[params][location_fulladdress]" value="{if isset($aForms.params.location_fulladdress)}{$aForms.params.location_fulladdress}{/if}" size="30" placeholder="{_p('Enter a location')}" autocomplete="off">
                <input type="hidden" data-inputid="address" name="val[params][location_address]" value="{if isset($aForms.params.location_address)}{$aForms.params.location_address}{/if}" />
                <input type="hidden" data-inputid="city" name="val[params][location_address_city]" value="" />
                <input type="hidden" data-inputid="country" name="val[params][location_address_country]" value="" />
                <input type="hidden" data-inputid="lat" name="val[params][location_address_lat]" value="{if isset($aForms.params.location_address_lat)}{$aForms.params.location_address_lat}{/if}" />
                <input type="hidden" data-inputid="lng" name="val[params][location_address_lng]" value="{if isset($aForms.params.location_address_lng)}{$aForms.params.location_address_lng}{/if}" />
            </div>
            <p class="help-block">
                <a href="javascript:void(0)" onclick="ynresphoenix.viewMap(this); return false;">{_p var='view_map'}</a>
            </p>
        </div>
        <div class="form-group">
            <label for="zip_code">
                {_p('Zip Code')}:
            </label>
            <input class="form-control" type="text" name="val[params][zip_code]" id="zip_code" value="{if isset($aForms.params.zip_code)}{$aForms.params.zip_code}{/if}" size="30" maxlength="150" />
        </div>
        <div class="table_header" >{_p('Contact Information')}</div>
        <div class="form-group">
            <label>
                {_p('phone_l')}:
            </label>
            <div id="ynresphoenix_phonelist" class="form-group">
                {if isset($aForms) && isset($aForms.params.phone)}
                {foreach from=$aForms.params.phone key=keyphone item=itemphone}
                <div class="ynresphoenix_item-phone">
                    <input class="form-control" type="text" name="val[params][phone][]" value="{$itemphone}" size="40" maxlength="150"/>
                    <div class="extra_info">
                        {if $keyphone == 0}
                        <a id="ynresphoenix_add" href="javascript:void(0)" onclick="ynresphoenix.appendPredefined(this,'phone'); return false;">
                            {img theme='misc/add.png' class='v_middle'}
                        </a>

                        <a id="ynresphoenix_delete" style="display: none;" href="javascript:void(0)" onclick="ynresphoenix.removePredefined(this,'phone'); return false;">
                            {img theme='misc/delete.png' class='v_middle'}
                        </a>
                        {else}
                        <a id="ynresphoenix_delete" href="javascript:void(0)" onclick="ynresphoenix.removePredefined(this,'phone'); return false;">
                            {img theme='misc/delete.png' class='v_middle'}
                        </a>
                        {/if}
                    </div>
                </div>
                {/foreach}
                {else}
                <div class="ynresphoenix_item-phone">
                    <input class="form-control" type="text" name="val[params][phone][]" value="" size="40" maxlength="150"/>
                    <div class="extra_info">
                        <a id="ynresphoenix_add" href="javascript:void(0)" onclick="ynresphoenix.appendPredefined(this,'phone'); return false;">
                            {img theme='misc/add.png' class='v_middle'}
                        </a>

                        <a id="ynresphoenix_delete" style="display: none;" href="javascript:void(0)" onclick="ynresphoenix.removePredefined(this,'phone'); return false;">
                            {img theme='misc/delete.png' class='v_middle'}
                        </a>
                    </div>
                </div>
                {/if}
            </div>
        </div>
        <div class="form-group">
            <label>
                {_p('fax_l')}:
            </label>
            <div id="ynresphoenix_faxlist" class="form-group">
                {if isset($aForms) && isset($aForms.params.fax)}
                {foreach from=$aForms.params.fax key=keyfax item=itemfax}
                <div class="ynresphoenix_item-fax">
                    <input class="form-control" type="text" name="val[params][fax][]" value="{$itemfax}" size="40" maxlength="150"/>
                    <div class="extra_info">
                        {if $keyfax == 0}
                        <a id="ynresphoenix_add" href="javascript:void(0)" onclick="ynresphoenix.appendPredefined(this,'fax'); return false;">
                            {img theme='misc/add.png' class='v_middle'}
                        </a>

                        <a id="ynresphoenix_delete" style="display: none;" href="javascript:void(0)" onclick="ynresphoenix.removePredefined(this,'fax'); return false;">
                            {img theme='misc/delete.png' class='v_middle'}
                        </a>
                        {else}
                        <a id="ynresphoenix_delete" href="javascript:void(0)" onclick="ynresphoenix.removePredefined(this,'fax'); return false;">
                            {img theme='misc/delete.png' class='v_middle'}
                        </a>
                        {/if}
                    </div>
                </div>
                {/foreach}
                {else}
                <div class="ynresphoenix_item-fax">
                    <input class="form-control" type="text" name="val[params][fax][]" value="" size="40" maxlength="150"/>
                    <div class="extra_info">
                        <a id="ynresphoenix_add" href="javascript:void(0)" onclick="ynresphoenix.appendPredefined(this,'fax'); return false;">
                            {img theme='misc/add.png' class='v_middle'}
                        </a>

                        <a id="ynresphoenix_delete" style="display: none;" href="javascript:void(0)" onclick="ynresphoenix.removePredefined(this,'fax'); return false;">
                            {img theme='misc/delete.png' class='v_middle'}
                        </a>
                    </div>
                </div>
                {/if}
            </div>
        </div>
        <div class="table form-group">
            <label  for="email">
                {_p('email_l')}:
            </label>
            <input class="form-control" type="text" name="val[params][email]" id="email" value="{if isset($aForms.params.email)}{$aForms.params.email}{/if}" size="30" maxlength="150" />
        </div>
    </div>
    <div class="panel-footer">
        <input type="submit" value="{_p('Submit')}" class="btn btn-primary" />
    </div>
</form>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key={$apiKey}&v=3.exp&libraries=places"></script>
{literal}
<script type="text/javascript">
    $Behavior.onLoadManagePage = function(){
        if($('.apps_menu').length == 0) return false;
        $('.apps_menu > ul').find('li:eq(9) a').addClass('active');
    }
</script>
{/literal}
