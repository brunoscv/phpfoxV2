<section id="ynresphoenix_member" class="page_ynresphoenix_landing-section">
	<div class="ynresphoenix-bg" {if !empty($aMemberSettings.background_path)}style="background-image: url({img server_id=$aMemberSettings.server_id path='core.url_pic' file=$aMemberSettings.background_path suffix='_1024' return_url='true'})"{/if}"></div>

	<div class="ynresphoenix_member-layer"></div>
	<div class="ynresphoenix_member-layer-bottom" style="background-image: url({param var='core.path_file'}module/ynresphoenix/static/images/members_shape_bg.png)"></div>
	<div class="ynresphoenix_member-layer-partern"></div>
	<div class="ynresphoenix-title"  data-animate="fadeInUp">{if !empty($aMemberSettings.title)}{softPhrase var=$aMemberSettings.title|clean}{/if}</div>
	<div class="container ynresphoenix_member-fix">
		<div class="row">
			<div class="owl-theme" id="ynresphoenix_member_slider">
                {if count($aMembers)}
                {foreach from=$aMembers item=aMember key=iKey}
                    <div class="ynresphoenix_member-block item"  data-animate="fadeInUp-parent">
                        <div class="ynresphoenix_member-item" >
                            <div class="ynresphoenix_member-avatar">
                                <span class="element-radius-top" {if !empty($aMember.photo.photo_path)}style="background-image:url({img server_id=$aMember.photo.server_id path='core.url_pic' file=$aMember.photo.photo_path suffix='_1024' return_url='true'})"{else}class="ynresphoenix_no-bg"{/if}>
                                    <div class="ynresphoenix_member_hover">
                                    </div>
                                    <div class="ynresphoenix_member_icon" data-toggle="modal" data-target="#ynresphoenix_member_modal_{$iKey}">
                                        <i class="fa fa-align-left" aria-hidden="true"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="ynresphoenix_member-content">
                                <p class="ynresphoenix_member-name">{$aMember.title|clean}</p>
                                {if !empty($aMember.params.position)}
                                <p class="ynresphoenix_member-regency">
                                     {softPhrase var=$aMember.params.position}
                                </p>
                                {/if}
                            </div>
                        </div>
                    </div>
                {/foreach}
                {/if}
		    </div>
		</div>
	</div>
    {if count($aMembers)}
        {foreach from=$aMembers item=aMember key=iKey}
            <div id="ynresphoenix_member_modal_{$iKey}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body clearfix">
                        	<div class="col-md-5">
                        		<div class="ynresphoenix_member-avatar">
	                                <span {if !empty($aMember.photo.photo_path)}style="background-image:url({img server_id=$aMember.photo.server_id path='core.url_pic' file=$aMember.photo.photo_path suffix='_1024' return_url='true'})"{else}class="ynresphoenix_no-bg"{/if}>
	                                </span>
	                                <button type="button" class="close" data-dismiss="modal">&times;</button>
	                            </div>
	                            <div class="ynresphoenix_member-description-first">
                                    {if !empty(_p($aMember.params.favorite_quote))}<p>{softPhrase var=$aMember.params.favorite_quote}</p>{/if}
	                            </div>
                        	</div>
                        	<div class="col-md-7">
                        		<div class="ynresphoenix_member-inf">
                        			<p class="ynresphoenix_member-name">
                        				{$aMember.title|clean}
                        			</p>
                                    {if !empty($aMember.params.position)}
                                        <p class="ynresphoenix_member-regency">
                                            <span>
                                                {softPhrase var=$aMember.params.position}
                                            </span>
                                        </p>
                                    {/if}
                                    {if !empty(_p($aMember.description))}
                                        <p class="ynresphoenix_member-description-second">
                                            {softPhrase var=$aMember.description}
                                        </p>
                                    {/if}
                        			{if !empty($aMember.params.phone)}<p class="ynresphoenix_member-phone">{_p('phone_l')}: <span>{$aMember.params.phone}</span></p>{/if}
                                    {if !empty($aMember.params.email)}<p class="ynresphoenix_member-email">{_p('email_l')}: <span>{$aMember.params.email}</span></p>{/if}
                                    {if !empty($aMember.params.address)}<p class="ynresphoenix_member-address">{_p('address_l')}: <span>{$aMember.params.address}</span></p>{/if}
                        		</div>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
    {/if}

</section>
{literal}
<script>
$Behavior.initLandingSlider1 = function(){
	if($(window).width() < 1025){
		$('.ynresphoenix_member-fix').find(".owl-theme").addClass('owl-carousel').attr("id","ynresphoenix_member_slider");

		 var initSlider1 = function() {
            var owl = $('#ynresphoenix_member_slider');
            var rtl = false;
            if(jQuery("html").attr("dir") == "rtl") {
                rtl = true;
            }
            owl.owlCarousel_ynrp({
                rtl:rtl,
	            loop:true,
	            dots: true,
	            nav:false,
				autoplay: false,
				autoplayTimeout:4000,
                autoplayHoverPause:true,
				responsive : {
					320 : {
						items: 1,
                        margin: 15,
					},
					480 : {
						items: 2,
                        margin: 10
					},
                    640 : {
                        items: 3,
                        margin: 10
                    },
                    991 : {
                        items: 4,
                        margin: 10
                    }
				}
	        });
	    }
	    if (typeof($.fn.owlCarousel_ynrp) == 'undefined') {
	        var script = document.createElement('script');
	        script.src = '{/literal}{$sPathFile}{literal}module/ynresphoenix/static/owl.carousel.min.js';
            script.onload = initSlider1;
	        document.getElementsByTagName("head")[0].appendChild(script);
	    } else {
	        initSlider1();
	    }

    } else{
    	$('.ynresphoenix_member-fix').find(".owl-theme").removeClass('owl-carousel').attr("id","");
    }
}

</script>
{/literal}
