<section id="ynresphoenix_photo" class="page_ynresphoenix_landing-section" data-toggle="modal">
	<div class="ynresphoenix-title" data-animate="fadeInUp">{if !empty($aPhotoSettings.title)}{softPhrase var=$aPhotoSettings.title}{/if}</div>
    <div class="ynresphoenix-bg" {if !empty($aPhotoSettings.background_path)}style="background-image: url({img server_id=$aPhotoSettings.server_id path='core.url_pic' file=$aPhotoSettings.background_path suffix='_1024' return_url='true'})"{/if}"></div>
    <div class="ynresphoenix_photo-layer"></div>
	{if count($aGalleries)}
    <div class="ynresphoenix_photo_menu" data-animate="fadeInUp">
		<ul class="ynresphoenix_photo-tabs-menu">
            {foreach from=$aGalleries item=aGallery key=iKey}
            <li class="ynresphoenix_photo-tabs-menu-item {if $iKey == 0}active{/if}" data-tab="photo_tab_{$iKey}">
                <span>{softPhrase var=$aGallery.title}</span>
            </li>
            {/foreach}
        </ul>	
	</div>
    {/if}
	<div class="ynresphoenix_photo-tabs-content clearfix">
        {foreach from=$aGalleries item=aGallery key=iKey}
            <div class="ynresphoenix_photo-tabs-content-item clearfix {if $iKey == 0}active{/if}" data-tab="photo_tab_{$iKey}"  data-animate="fadeInUp-parent">
                {if isset($aGallery.photos)}
                    {foreach from=$aGallery.photos item=aPhoto key=pKey}
                        <a class="ynresphoenix_photo-item_img" href="#" data-toggle="modal" data-target="#ynresphoenix_photo_modal">
                            <span style="background-image: url({img server_id=$aPhoto.server_id path='core.url_pic' file=$aPhoto.photo_path suffix='_1024' return_url='true'})"></span>
                        </a>
                    {/foreach}
                {/if}
            </div>
        {/foreach}
	</div>
	<div class="modal fade" id="ynresphoenix_photo_modal" tabindex="-1" role="dialog" aria-labelledby="ynresphoenix_photo_modal" aria-hidden="true">
	  	<div class="modal-dialog">
	    	<div class="modal-content">   
	    		<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      	</div>           
	      		<div class="modal-body">
                        {foreach from=$aGalleries item=aGallery key=iKey}
                            <div class="ynresphoenix_photo-tabs-content-item {if $iKey == 0}active{/if} item" data-tab="photo_tab_{$iKey}" >
                                <div class="owl-carousel owl-theme fadeInDown ynresphoenix_photo-tabs-content-slider">
                                {if isset($aGallery.photos)}
                                    {foreach from=$aGallery.photos item=aPhoto key=pKey}
                                        <a class="ynresphoenix_photo-item_img" href="#" data-toggle="modal" data-target="#ynresphoenix_photo_modal">
                                            <span style="background-image: url({img server_id=$aPhoto.server_id path='core.url_pic' file=$aPhoto.photo_path suffix='_1024' return_url='true'})"></span>
                                            <p>{softPhrase var=$aPhoto.description}</p>
                                        </a>
                                    {/foreach}
                                {/if}
                                </div>
                            </div>
                        {/foreach}
	      		</div>
	    	</div>
	  	</div>
	</div>
</section>


