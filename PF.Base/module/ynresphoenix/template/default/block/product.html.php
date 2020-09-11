<section id="ynresphoenix_product" class="page_ynresphoenix_landing-section">
	<div class="ynresphoenix-bg" {if !empty($aProductSettings.background_path)}style="background-image: url({img server_id=$aProductSettings.server_id path='core.url_pic' file=$aProductSettings.background_path suffix='_1024' return_url='true'})"{/if}"></div>

	<div class="ynresphoenix_product-layer"></div>
	<div class="ynresphoenix-title" data-animate="fadeInUp">{if !empty($aProductSettings.title)}{softPhrase var=$aProductSettings.title}{/if}</div>
	<div class="container">
		<div class="row">
			<div class="owl-carousel" id="ynresphoenix_product_slider-big" data-animate="fadeInUp-parent">
			<!-- <div class="owl-carousel" id="ynresphoenix_product_slider-big" > -->
                {if count($aProducts)}
                    {foreach from=$aProducts item=aProduct key=iKey}
                        <div class="item {if !empty($aProduct.photos) && count($aProduct.photos) == 1}ynphoenix-one-img{/if}">
                            <div class="col-md-6">
                                <div class="ynresphoenix_product_main">
                                    <span {if !empty($aProduct.main_photo)}style="background-image: url({img server_id=$aProduct.main_photo.server_id path='core.url_pic' file=$aProduct.main_photo.photo_path suffix='_1024' return_url='true'})"{/if}>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ynresphoenix_product-content">
                                    <a href="{$aProduct.params.link}" class="ynresphoenix_product-title-item">
                                        {softPhrase var=$aProduct.title}
                                    </a>
                                    <div class="ynresphoenix_product-price">
                                        <p>{if !empty($aProduct.params.discount_price)}{$aProduct.params.currency}{$aProduct.params.discount_price|number_format:2}{elseif !empty($aProduct.params.price)}{$aProduct.params.currency}{$aProduct.params.price|number_format:2}{/if}
                                        	<span>{if !empty($aProduct.params.price) && !empty($aProduct.params.discount_price)}{$aProduct.params.currency}{$aProduct.params.price|number_format:2}{/if}</span>
                                        </p>
                                    </div>
                                    {if !empty($aProduct.description)}
                                    <div class="ynresphoenix_product-inf">
                                        {softPhrase var=$aProduct.description}
                                    </div>
                                    {/if}
                                </div>
                                <div class="ynresphoenix_product-small clearfix">
                                    {if !empty($aProduct.photos) && count($aProduct.photos)}
                                        <ul>
                                        {foreach from=$aProduct.photos item=aPhoto key=iKey}
                                            <li>
                                                <div class="ynresphoenix_product-small-change">
                                                    <span style="background-image: url({img server_id=$aPhoto.server_id path='core.url_pic' file=$aPhoto.photo_path suffix='_1024' return_url='true'})" />
                                                </div>
                                            </li>
                                        {/foreach}
                                        </ul>
                                    {/if}
                                    {if !empty(_p($aProduct.params.link_text)) && !empty($aProduct.params.link)}
                                        <a href="{$aProduct.params.link}" class="btn btn-primary {if isset($aProduct.params.new_tab_l)}no_ajax" target="_blank"{else}"{/if} >{softPhrase var=$aProduct.params.link_text}</a>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    {/foreach}
                {/if}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="ynresphoenix_product-draggle">
					<ul>
						<li><i class="fa fa-long-arrow-left" aria-hidden="true"></i></li>
						<li><i class="fa fa-hand-paper-o" aria-hidden="true"></i></li>
						<li><i class="fa fa-long-arrow-right" aria-hidden="true"></i></li>
					</ul>
				</div>
			</div>	
		</div>
	</div>
	<!-- <div class="owl-carousel" id="ynresphoenix_product_slider-small"> -->
	<div class="owl-carousel" id="ynresphoenix_product_slider-small" data-animate="fadeInUp-parent">
        {if count($aProducts)}
            {foreach from=$aProducts item=aProduct key=iKey}
                <div class="item">
                    <span {if !empty($aProduct.main_photo)}style="background-image: url({img server_id=$aProduct.main_photo.server_id path='core.url_pic' file=$aProduct.main_photo.photo_path suffix='_1024' return_url='true'})"{/if}></span>
                    <div class="ynresphoenix_product_slider-small-bg"></div>
                </div>
            {/foreach}
        {/if}
	</div>
</section>

{literal}
<script>
    $Behavior.initLandingSlider = function(){
	    if ($('#ynresphoenix_product').length > 0){	
	        var initSlider = function() {
	        	var sync1 = $('#ynresphoenix_product_slider-big'),
				sync2 = $('#ynresphoenix_product_slider-small');

				var rtl = '';
				if(jQuery("html").attr("dir") == "rtl") {
					rtl = 'rtl';
				}
                if (sync1.data('initSlide') || sync1.length == 0 || sync2.data('initSlide') || sync2.length == 0) {
                    return false;
                }
                sync1.data('initSlide', 1);
                sync1.addClass('dont-unbind-children');

                sync2.data('initSlide', 1);
                sync2.addClass('dont-unbind-children');

				sync1.owlCarousel_ynv1({
				    singleItem: true,
				    slideSpeed: 1000,
				    navigation: true,
				    navigationText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
				    pagination: false,
				    direction: rtl,
				    transitionStyle : "fade",
				    afterAction: syncPosition,
			   	  	afterInit: callback,
			   	  	startDragging: callback,
			   	  	afterMove: callback,
				});

				sync2.owlCarousel_ynv1({
				    items: 8,
				    itemsDesktop: [1199, 8],
				    itemsDesktopSmall: [979, 7],
				    itemsTablet: [768, 5],
				    itemsMobile: [479, 3],
				    direction: rtl,
				    pagination: false,
				    afterInit: function(el) {
				        el.find(".owl-item").eq(0).addClass("current");
				    }
				});

				function syncPosition(el) {
					this
						.$owlItems
						.removeClass('active')

					this
						.$owlItems
						.eq(this.currentItem)
						.addClass('active')

				    var current = this.currentItem;
				    sync2
				        .find(".owl-item")
				        .removeClass("current")
				        .eq(current)
				        .addClass("current")
				    if (sync2.data("owlCarousel_ynv1") !== undefined) {
				        center(current)
				    }
				}

				sync2.on("click", ".owl-item", function(e) {
				    e.preventDefault();
				    var number = $(this).data("owlItem");
				    sync1.trigger("owl.goTo", number);
				    callback();
				});

				function center(number) {
				    var sync2visible = sync2.data("owlCarousel_ynv1").owl.visibleItems;
				    var num = number;
				    var found = false;
				    for (var i in sync2visible) {
				        if (num === sync2visible[i]) {
				            var found = true;
				        }
				    }

				    if (found === false) {
				        if (num > sync2visible[sync2visible.length - 1]) {
				            sync2.trigger("owl.goTo", num - sync2visible.length + 2)
				        } else {
				            if (num - 1 === -1) {
				                num = 0;
				            }
				            sync2.trigger("owl.goTo", num);
				        }
				    } else if (num === sync2visible[sync2visible.length - 1]) {
				        sync2.trigger("owl.goTo", sync2visible[1])
				    } else if (num === sync2visible[0]) {
				        sync2.trigger("owl.goTo", num - 1)
				    }

				}

				function callback() {
		        	$('#ynresphoenix_product_slider-big .owl-item.active .ynresphoenix_product-small li .ynresphoenix_product-small-change').click(function(e){
					    var photo_fullsize =  $(this).find('span').css('background-image');
					    $('#ynresphoenix_product_slider-big .owl-item.active .ynresphoenix_product_main span').css('background-image', photo_fullsize);
					    e.preventDefault();
				    });
				}

		        $(".owl-next").click(function(){
			      	callback();
			    })

			    $(".owl-prev").click(function(){
			        callback();
			    })
			}
                
	        if (typeof($.fn.owlCarousel_ynrp) == 'undefined') {
	            var script = document.createElement('script');
	            script.src = '{/literal}{$sPathFile}{literal}module/ynresphoenix/static/owl-carousel/owl.carousel_v1.js';
	            script.onload = initSlider;
	            document.getElementsByTagName("head")[0].appendChild(script);
	        } else {
	            initSlider();
	        }
		}
	}
</script>
{/literal}