<section id="ynresphoenix_home" class="ynresphoenix_home ynresphoenix-main page_ynresphoenix_landing-section ynresphoenix_home-animate">
    <div class="ynresphoenix_home-main">
        <div class="container">
            <div class="row clearfix">
                <div class="ynresphoenix_home-top animated fadeInDown">
                    <div class="ynresphoenix_home-content">
                        <h2 class="ynresphoenix-title">{if !empty($aHomeSettings.params.social_text)}{softPhrase var=$aHomeSettings.params.social_text|clean}{/if}</h2>
                        <p>{softPhrase var=$aHomeSettings.description}</p>
                        {if !empty($aHomeSettings.params.link)}
                           <a href="{$aHomeSettings.params.link}"
                              class="button btn-default
                              {if isset($aHomeSettings.params.new_tab_l)}no_ajax" target="_blank" {else} "{/if}>
                              {if !empty($aHomeSettings.params.button_text)}{softPhrase var=$aHomeSettings.params.button_text}{else}{_p('view_more')}{/if}
                           </a>
                        {/if}
                    </div>
                </div>

                  {if !$bNoPhotos}
                  <div class="ms-partialview-template">
                     <div class="master-slider ms-skin-default" id="ynresphoenix-home-slider">
                          {foreach from=$aPhotos item=aPhoto}
                             <div class="ms-slide">
                                <div class="ynresphoenix-home-bg-img">
                                   <span style="background-image: url({img server_id=$aPhoto.server_id path='core.url_pic' file=$aPhoto.photo_path suffix='_1024' return_url='true'})"></span>
                                </div>
                             </div>
                          {/foreach}
                      </div>
                   </div>
                  {/if}

                <ul class="ynresphoenix_home-social">
                    <li class="ynresphoenix_home-social-follow">
                       <p>{_p('Follow us')}</p>
                    </li>
                    {if !empty($aHomeSettings.params.facebook)}
                    <li class="ynresphoenix_home-social-fb uppercase">
                       <a href="{$aHomeSettings.params.facebook}" {if isset($aHomeSettings.params.new_tab_fb)}class="no_ajax" target="_blank"{/if}>Facebook</a>
                    </li>
                    {/if}
                    {if !empty($aHomeSettings.params.twitter)}
                    <li class="ynresphoenix_home-social-tw uppercase">
                       <a href="{$aHomeSettings.params.twitter}" {if isset($aHomeSettings.params.new_tab_tw)}class="no_ajax" target="_blank"{/if}>Twitter</a>
                    </li>
                    {/if}
                    {if !empty($aHomeSettings.params.google)}
                    <li class="ynresphoenix_home-social-gg uppercase">
                       <a href="{$aHomeSettings.params.google}" {if isset($aHomeSettings.params.new_tab_gg)}class="no_ajax" target="_blank"{/if}>Google+</a>
                    </li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
</section>
{literal}
<script>
   $Behavior.initLandingSlider3 = function(){

      function GetIEVersion() {
        var sAgent = window.navigator.userAgent;
        var Idx = sAgent.indexOf("MSIE");

        // If IE, return version number.
        if (Idx > 0){
          return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));
        }

        // If IE 11 then look for Updated user agent string.
        else if (!!navigator.userAgent.match(/Trident\/7\./)){
          return 11;
        }

        else{
          return 0; //It is not IE
        }
      };
      var space;

      if(GetIEVersion() > 0){
          space = 20;
      }else{
          space = 170;
      }

      //slider.control('arrows');
      var slider = new MasterSlider();
       if ($('#ynresphoenix-home-slider').data('initSlide') || $('#ynresphoenix-home-slider').length == 0) {
           return false;
       }
       $('#ynresphoenix-home-slider').data('initSlide', 1);
       $('#ynresphoenix-home-slider').addClass('dont-unbind-children');
      slider.setup('ynresphoenix-home-slider' , {
          width:760,
          height:510,
          space: space,
          autoplay: true,
          loop:true,
          speed: 100,
          view:'partialWave',
          layout:'partialview'
      });

      //CHANGE START
      $previous = jQuery('');
      slider.api.addEventListener(MSSliderEvent.CHANGE_START , function(){
          $previous.find('.ynresphoenix-home-bg-img').removeClass('active');
          $current = slider.api.view.currentSlide.$element;
          $current.find('.ynresphoenix-home-bg-img').addClass('active');
          $previous = $current;
      });
   }
</script>
{/literal}