<section id="ynresphoenix_contact" class="page_ynresphoenix_landing-section">
    <div class="ynresphoenix-bg"{if !empty($aContactSettings.background_path)}style="background-image: url({img server_id=$aContactSettings.server_id path='core.url_pic' file=$aContactSettings.background_path suffix='_1024' return_url='true'})"{/if}></div>
    <div class="ynresphoenix_contact-layer"></div>
    <h1 class="ynresphoenix-title" data-animate="fadeInUp">
        {if !empty($aContactSettings.title)}{softPhrase var=$aContactSettings.title}{/if}
    </h1>
    <div class="container">
        <div class="row">
            <div class="ynresphoenix_contact-above clearfix" data-animate="fadeInUp">


               <div class="col-md-7 col-xs-12 padding0">
                    <a class="ynresphoenix_contact-bg">
                        <span {if !empty($aContactSettings.params.main_photo_path)}style="background-image: url({img server_id=$aContactSettings.server_id path='core.url_pic' file=$aContactSettings.params.main_photo_path suffix='_1024' return_url='true'})"{/if}></span>
                    </a>
                </div>
                <div class="col-md-5 col-xs-12">
                    <div class="ynresphoenix_contact-address">
                        {if count($aContacts)}
                            {foreach from=$aContacts item=aContact key=iKey}
                            <div class="ynresphoenix_contact-address-item">
                                <h3>{softPhrase var=$aContact.title|clean}</h3>
                                {if !empty($aContact.params.location_fulladdress)}<p>{$aContact.params.location_fulladdress}</p>{/if}
                                {if !empty($aContact.params.phone) && count($aContact.params.phone)}
                                    {foreach from=$aContact.params.phone item=aPhone key=iKey}
                                        {if !empty($aPhone)}<p><label>{_p('phone_l')}:</label> {$aPhone}</p>{/if}
                                    {/foreach}
                                {/if}
                                {if !empty($aContact.params.fax) && count($aContact.params.fax)}
                                    {foreach from=$aContact.params.fax item=aFax key=iKey}
                                        {if !empty($aFax)}<p><label>{_p('fax_l')}:</label> {$aFax}</p>{/if}
                                    {/foreach}
                                {/if}
                                {if !empty($aContact.params.zip_code)}<p><label>{_p('zip_code')}:</label> {$aContact.params.zip_code}</p>{/if}
                                {if !empty($aContact.params.email)}<p>{_p('email_l')}: <a href="mailto:{$aContact.params.email}" target="_top">{$aContact.params.email}</a></p>{/if}
                            </div>
                            {/foreach}
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {if $aContactSettings.params.show_map}
        <div class="ynresphoenix_contact-map" id="ynresphoenix_map_detail" data-animate="fadeInUp">
        </div>
    {else}
        <div class="ynresphoenix_contact-no-map"></div>
    {/if}

</section>

<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key={$apiKey}&v=3.exp&libraries=places"></script>

{if isset($aDefaultMap) && count($aDefaultMap)}
{literal}
<script type="text/javascript">
    var mapContent = {/literal}{$oAllMapContent}{literal};
    $Behavior.onLoadContactBlock = function(){
        ynresphoenix.showMapsWithData('ynresphoenix_map_detail', {/literal}{$oAllMapLocation}{literal},{/literal}{$oAllMapContent}{literal});
    }
</script>
{/literal}
{/if}