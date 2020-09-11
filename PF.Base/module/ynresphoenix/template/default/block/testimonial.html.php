<section id="ynresphoenix_testimonial" class="page_ynresphoenix_landing-section">
    <div class="ynresphoenix-bg"></div>
    <div class="container ynresphoenix_testimonial-fix">
        <div class="row">
            <div id="ynresphoenix_slider-testimonial" class="owl-carousel owl-theme"  data-animate="fadeInUp">
                {if count($aTestimonials)}
                {foreach from=$aTestimonials item=aTestimonial key=iKey}
                <div class="col-md-8 col-md-offset-2 col-xs-12 item">
                    <div class="ynresphoenix_testimonial-avatar">
                        {if !empty($aTestimonial.photo)}
                        <span style="background-image: url({img server_id=$aTestimonial.photo.server_id path='core.url_pic' file=$aTestimonial.photo.photo_path suffix='_200' return_url=true});"></span>
                        <div class="ynresphoenix_testimonial-avatar-triangle-down"></div>
                        {/if}
                    </div>
                    <div class="ynresphoenix_testimonial-content">
                        <p class="ynresphoenix_testimonial-content-description">{softPhrase var=$aTestimonial.description}</p>
                        <p class="ynresphoenix_testimonial-content-author">{$aTestimonial.title|clean}</p>
                        <p class="ynresphoenix_testimonial-content-com">({softPhrase var=$aTestimonial.params.position})</p>
                    </div>
                </div>
                {/foreach}
                {/if}
            </div>
        </div>
    </div>


</section>

{literal}
<script>
    $Behavior.initLandingSlider2 = function(){
        var initSlider2 = function() {
            var owl = $('#ynresphoenix_slider-testimonial');
            if (owl.data('initSlide')) {
                return false;
            }
            owl.data('initSlide', 1);
            owl.addClass('dont-unbind-children');
            var rtl = false;
            if(jQuery("html").attr("dir") == "rtl") {
                rtl = true;
            }
            owl.owlCarousel_ynrp({
                rtl:rtl,
                items:1,
                loop:true,
                nav: false,
                margin: false,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true
            });
        }
        if (typeof($.fn.owlCarousel_ynrp) == 'undefined') {
            var script = document.createElement('script');
            script.src = '{/literal}{$sPathFile}{literal}module/ynresphoenix/static/owl-carousel/owl.carousel.min.js';
            script.onload = initSlider2;
            document.getElementsByTagName("head")[0].appendChild(script);
        } else {
            initSlider2();
        }
    }
</script>
{/literal}
