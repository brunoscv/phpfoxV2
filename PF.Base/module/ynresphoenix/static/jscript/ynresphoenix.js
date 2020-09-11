var ynresphoenix = {
	showMapsWithData: function (id, datas, contents) {
        if ($('#' + id).length > 0 && datas.length > 0) {
            var center = new google.maps.LatLng(datas[0]['latitude'], datas[0]['longitude']);
            var neighborhoods = [];
            var markers = [];
            var iterator = 0;
            for (i = 0; i < datas.length; i++) {
                neighborhoods.push(new google.maps.LatLng({
                    lat: parseFloat(datas[i]['latitude']),
                    lng: parseFloat(datas[i]['longitude'])
                }));
            }

            function showMapsWithData_initialize() {
                var mapOptions = {
                    zoom: 15,
                    center: center,
                };

                map = new google.maps.Map(document.getElementById(id), mapOptions);
                var bounds = new google.maps.LatLngBounds();

                for (var i = 0; i < neighborhoods.length; i++) {
                    showMapsWithData_addMarker(i);
                    if (neighborhoods.length > 1) {
                        bounds.extend(neighborhoods[i]);
                    }

                }

                if (neighborhoods.length > 1) {
                    map.fitBounds(bounds);
                }
            }

            function showMapsWithData_addMarker(i) {
                marker = new google.maps.Marker({
                    position: neighborhoods[iterator],
                    map: map,
                    draggable: false,
                    animation: google.maps.Animation.DROP,
                    icon: datas[i]['icon']
                })
                markers.push(marker);
                iterator++;
                infowindow = new google.maps.InfoWindow({});
                google.maps.event.addListener(marker, 'mouseover', function () {
                    infowindow.close();
                    infowindow.setContent(contents[i]);
                    infowindow.open(map, markers[i]);
                });
            }

            showMapsWithData_initialize();
        }
    },
};


$Behavior.onLoadEvents = function () {

	tabsmenu("#ynresphoenix_photo");
    slide_item("#ynresphoenix_photo");
	//add animate and remove animate 
	function animateTabContent(currentElement,timeRunAnimate){
		setTimeout(function(){
			currentElement.removeAttr("style").addClass('animated zoomIn');
		},timeRunAnimate);
		setTimeout(function(){
			currentElement.removeClass('animated zoomIn');
		},timeRunAnimate + 1000);
	}

    var dataTab = 'photo_tab_0';

	function tabsmenu(id){

		var tabContent=$(id+" .ynresphoenix_photo-tabs-content-item");
		var tabMenu=$(id+" .ynresphoenix_photo-tabs-menu .ynresphoenix_photo-tabs-menu-item");

		tabMenu.on("click touchstart",function(){

			dataTab = $(this).attr("data-tab");
            console.log(dataTab);
			//remove all class active
			tabMenu.removeClass("active");
			tabContent.removeClass("active");
			//active current tabs-menu
			$(this).addClass("active");

			//active current tabs-content
			var tabCurrentActive = $(id+" .ynresphoenix_photo-tabs-content-item[data-tab='"+dataTab+"']");
			tabCurrentActive.addClass("active");

			//show item animate
			tabCurrentActive.children().css("opacity","0");
			var timeRunAnimate=0;
			for(var i=0;i<tabCurrentActive.children().length;i++){
				animateTabContent(tabCurrentActive.children().eq(i),timeRunAnimate);
				timeRunAnimate +=200;
			}
		}) 
	}


    function slide_item(id) {
        // body...
        var SelectImg;
         $(".ynresphoenix_photo-item_img").click(function() {
            SelectImg =  $(this).index();
        });

        $('#ynresphoenix_photo_modal').on('show.bs.modal', function (e) {
            var owl = $('.ynresphoenix_photo-tabs-content-slider');
            var rtl = false;
            if(jQuery("html").attr("dir") == "rtl") {
                rtl = true;
            }
            owl.owlCarousel_ynrp({
                rtl:rtl,
                items:1,
                loop:true,
                nav: true,
                navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                dots: false,
                margin: false,
                margin:10,
                autoplay: false,
                autoplayTimeout:4000,
                autoplayHoverPause:true,
                startPosition: SelectImg,
                responsive : {
                    991 : {
                        stagePadding: 0,
                        items: 1
                    },
                    992 : {
                        stagePadding: 180,
                    }
                }
            });

            owl.on('changed.owl.carousel',function(property){
                var current = property.item.index;

                $('.ynresphoenix_photo-tabs-content-item .owl-item').removeClass('current');
                $('.ynresphoenix_photo-tabs-content-item[data-tab="' + dataTab +'"] .owl-item:eq('+ current +')').addClass('current');
            }); 

             $(".ynresphoenix_photo-item_img").click(function() {
                owl.trigger('to.owl.carousel', SelectImg);
            });
        });
    }

    var sections = $('.page_ynresphoenix_landing-section')
      , nav = $('#page_ynresphoenix_landing-nav');

    if(sections.length == 0 || nav.length == 0) return false;
    var nav_height = nav.outerHeight();
    $(window).on('scroll', function () {
      var cur_pos = $(this).scrollTop();      
      sections.each(function() {
        var top = $(this).offset().top - nav_height,
            bottom = top + $(this).outerHeight();
        
        if (cur_pos >= top && cur_pos <= bottom) {
          nav.find('a').removeClass('active');
          sections.removeClass('active');
          
          $(this).addClass('active');
          nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active');
        }
      });
    });

    nav.find('a').on('click', function () {
      var $el = $(this)
        , id = $el.attr('href');
      
      $('html, body').animate({
        scrollTop: $(id).offset().top
      }, 500);
      
      return false;
    });

	 $('.ynresphoenix_home-readmore').click(function(e){
        e.preventDefault();
        $("html, body").animate({ scrollTop: $('#ynresphoenix_product').offset().top }, 1000);
    });




    /*---------------------------------------------------
            ANIMATE SCROLL
    --------------------------------------------------*/
    var array=[];
    $(document).ready(function(){
        if($(window).width()>1200){
            $("*").each(function(){
                var attr = $(this).attr('data-animate');
                if (typeof attr !== typeof undefined && attr !== false) {
                    array.push($(this));
                    if(attr.split("-").length>1){
                        $(this).children().css("opacity","0");
                    }
                    else{
                        $(this).css("opacity","0");
                    }
                }
            });
        }
    });

    $(window).on("load scroll",function(){
        if($(window).width()>1200){
            var window_offset_top = $(window).scrollTop();
            var window_offset_bottom =$(window).scrollTop() + $(window).height();
            var elementRemoveArray=[];
            var timeRunAnimate=0;
            for(var i=0;i<array.length;i++){
                var currentElement = array[i];
                var animateCss = array[i].attr("data-animate");
                var split = animateCss.split("-");
                //scroll show
                var element_offset_top = currentElement.offset().top;
                var element_offset_bottom= currentElement.offset().top + currentElement.height();
                if(element_offset_top >= window_offset_top && element_offset_top <= window_offset_bottom || element_offset_bottom <= window_offset_bottom && element_offset_bottom >= window_offset_top)
                {
                    if(split.length>1){
                        for(var j=0;j<currentElement.children().length ;j++){
                            showSort(currentElement.children().eq(j),split[0],timeRunAnimate);
                            timeRunAnimate+=100;
                            removeClassAnimate(currentElement.children(),split[0]);
                        }
                        elementRemoveArray.push(i);
                    }
                    else{
                        currentElement.removeAttr("style").addClass('animated '+animateCss);
                        elementRemoveArray.push(i);
                        removeClassAnimate(currentElement,animateCss);
                    }
                }
            }
            for(var i=elementRemoveArray.length - 1;i >= 0;i--){
                array.splice(elementRemoveArray[i], 1);
            }
        }
    });

    function removeClassAnimate(id,animateCss){
        setTimeout(function(){
            id.removeClass("animated "+animateCss);
        }, 3000);
    };

    function showSort(currentElement,animateCss,timeRunAnimate){
        setTimeout(function(){
            currentElement.removeAttr("style").addClass('animated '+animateCss);
        },timeRunAnimate);
        
    };
    /*---------------------------------------------------
                END ANIMATE SCROLL
    --------------------------------------------------*/
}	

