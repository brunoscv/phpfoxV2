/**
 * Created by minhhai on 12/5/16.
 */
var ynresphoenix = {
    initUpdateSetting: function(){
        if($('#ynresphoenix_setting_page_form').length == 0) return false;
        ynresphoenix.initValidator($('#ynresphoenix_setting_page_form'));
        if($('#ynresphoenix_setting_page_form #link').length) {
            $('#ynresphoenix_setting_page_form #link').rules('add', {
                url: true
            });
        }
        if($('#ynresphoenix_setting_page_form #facebook').length) {
            $('#ynresphoenix_setting_page_form #facebook').rules('add', {
                url: true
            });
        }
        if($('#ynresphoenix_setting_page_form #twitter').length) {
            $('#ynresphoenix_setting_page_form #twitter').rules('add', {
                url: true
            });
        }
        if($('#ynresphoenix_setting_page_form #google').length) {
            $('#ynresphoenix_setting_page_form #google').rules('add', {
                url: true
            });
        }
        if($('#ynresphoenix_setting_page_form #video_url').length) {
            jQuery.validator.addMethod('checkYoutubeUrl', function (value, element, params) {
                var result = false;
                var videoid = $(element).val().match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
                if(videoid){
                    return true;
                }
                return result;
            }, oTranslations['please_enter_a_valid_youtube_link']);
            $('#ynresphoenix_setting_page_form #video_url').rules('add', {
                url: true,
                checkYoutubeUrl: true
            });
        }
    },
    initAddItem: function(){
        if($('#ynresphoenix_add_item_form').length == 0) return false;
        ynresphoenix.initValidator($('#ynresphoenix_add_item_form'));
        if($('#ynresphoenix_add_item_form #title').length)
        {
            $('#ynresphoenix_add_item_form #title').rules('add',{
                required: true,
                maxlength: 64,
            })
        }
        if($('#ynresphoenix_add_item_form #description').length)
        {
            $('#ynresphoenix_add_item_form #description').rules('add',{
                required: true,
                maxlength: 220,
            })
        }
        if($('#ynresphoenix_add_item_form #link').length) {
            $('#ynresphoenix_add_item_form #link').rules('add', {
                url: true
            });
        }
        if($('#ynresphoenix_add_item_form #email').length) {
            $('#ynresphoenix_add_item_form #email').rules('add', {
                email: true
            });
        }
        if($('#ynresphoenix_add_item_form #position').length)
        {
            $('#ynresphoenix_add_item_form #position').rules('add',{
                maxlength: 64,
            })
        }
        if($('#ynresphoenix_add_item_form #introduction').length)
        {
            $('#ynresphoenix_add_item_form #introduction').rules('add',{
                maxlength: 500,
            })
            $('#ynresphoenix_add_item_form #favorite_quote').rules('add',{
                maxlength: 500,
            })
        }
        if($('#ynresphoenix_add_item_form #photo').length && $('#ynresphoenix_add_item_form #had_photo').val() == 0) {
            $('#ynresphoenix_add_item_form #photo').rules('add', {
                required: true
            });
        }
        if($('#ynresphoenix_add_item_form #client_title').length)
        {
            $('#ynresphoenix_add_item_form #client_title').rules('add',{
                maxlength: 64,
            })
        }
        if($('#ynresphoenix_add_item_form #statistic_number').length)
        {
            $('#ynresphoenix_add_item_form #statistic_number').rules('add',{
                required: true,
                number: true,
                min: 0
            })
        }
        if($('#ynresphoenix_add_item_form #user_position').length) {
            $('#ynresphoenix_add_item_form #user_position').rules('add', {
                required: true,
                maxlength: 150
            });
        }
        if ($("#ynresphoenix_add_item_form #js_ynresphoenix_location").length > 0) {
            var input = ($("#ynresphoenix_add_item_form #js_ynresphoenix_location")[0]);
            if (window.google) {
            } else {
                return false;
            }
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }

                var $parent = $(input).closest('.js_location');
                $parent.find('[data-inputid="address"]').val($parent.find('[data-inputid="fulladdress"]').val());
                $parent.find('[data-inputid="lat"]').val(place.geometry.location.lat());
                $parent.find('[data-inputid="lng"]').val(place.geometry.location.lng());
                $parent.find('.text-danger').last().remove();
                $parent.find('.text-danger').removeClass('text-danger');
            });
        }
        if($('#ynresphoenix_add_item_form #price').length)
        {
            $('#ynresphoenix_add_item_form #price').rules('add',{
                number: true,
                min: 0
            })
        }
        if($('#ynresphoenix_add_item_form #discount_price').length)
        {
            $('#ynresphoenix_add_item_form #discount_price').rules('add',{
                number: true,
                min: 0
            })
        }
    },
    initValidator: function(element) {
        jQuery.validator.messages.url = oTranslations['please_enter_a_valid_url_for_example_http_example_com'];
        jQuery.validator.messages.email = oTranslations['please_enter_a_valid_email_address'];
        $.data(element[0], 'validator', null);
        element.validate({
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox") || element.is("textarea") || element.is('#ynstore_product_discount_value')) {
                    error.appendTo($(element).closest('.form-group'));
                } else {
                    error.appendTo(element.parent());
                }
            },
            errorClass: 'text-danger',
            errorElement: 'span',
            debug: false
        });
    },
    appendPredefined: function (ele, classname) {
        var now = +new Date();
        switch (classname) {
            case 'phone':
                var oCloned = $(ele).closest('.ynresphoenix_item-phone').clone();
                oCloned.find('input').attr('value', '');
                oCloned.find('#ynresphoenix_delete').show();
                oCloned.find('#ynresphoenix_add').remove();
                oCloned.find('span.text-danger').remove();
                var oFirst = oCloned.clone();
                var firstAnswer = oFirst.html();
                $(ele).closest('#ynresphoenix_phonelist').append('<div class="ynresphoenix_item-phone">' + firstAnswer + '</div>');
                break;
            case 'fax':
                var oCloned = $(ele).closest('.ynresphoenix_item-fax').clone();
                oCloned.find('input').attr('value', '');
                oCloned.find('#ynresphoenix_delete').show();
                oCloned.find('#ynresphoenix_add').remove();
                var oFirst = oCloned.clone();
                var firstAnswer = oFirst.html();
                $(ele).closest('#ynresphoenix_faxlist').append('<div class="ynresphoenix_item-fax">' + firstAnswer + '</div>');
                break;
        }
    },
    removePredefined: function (ele, classname) {
        switch (classname) {
            case 'phone':
                $(ele).closest('.ynresphoenix_item-phone').remove();
                break;
            case 'fax':
                $(ele).closest('.ynresphoenix_item-fax').remove();
                break;

        }
    },
    viewMap: function (ele) {
        var obj = $(ele).parents('.js_map_holder').find('.js_location'),
            latitude = obj.find('[data-inputid="lat"]').val(),
            longitude = obj.find('[data-inputid="lng"]').val(),
            address = obj.find('[data-inputid="address"]').val();
        console.log(latitude,longitude,address);
        if (latitude == '' || longitude == '' || address == '') {
            // Open directly via API
            $.magnificPopup.open({
                items: {
                    src: '<div class="white-popup-block" style="width: 300px;">' + oTranslations['please_enter_location'] + '</div>', // can be a HTML string, jQuery object, or CSS selector
                    type: 'inline'
                }
            });
            return false;
        }
        else {
            $.magnificPopup.open({
                items: {
                    src: '<div class="white-popup-block-without-width" >' + '<div id="ynresphoenix_viewmap" style="height: 450px;"></div>' + '</div>', // can be a HTML string, jQuery object, or CSS selector
                    type: 'inline'
                }
            });

            ynresphoenix.showMapsWithData('ynresphoenix_viewmap', [{
                latitude: latitude,
                longitude: longitude
            }], [address]);
        }
    },
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
    showSampleLayout: function(sPath){
        $.magnificPopup.open({
            items: {
                src: sPath,
                type: 'image'
            }
        });
        return false;
    }
};

$Ready(function(){
    ynresphoenix.initUpdateSetting();
    ynresphoenix.initAddItem();
});