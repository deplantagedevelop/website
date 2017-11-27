$(document).ready(function(){
    $('#menu').slicknav({
        prependTo:'.header-mobile'
    });

    $('.slider').slick({
        infinite: true,
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3500
    });

    $('.slide').height(
        $(document).height() - $('.header').height()
    );

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    var orderby = getParameterByName('order');

    $('#product-filter').change(function () {
        var locAppend = $(this).find('option:selected').attr("name"),
            locSnip = window.location.href.split('?')[0];

        window.location.href = locSnip + '?order=' + locAppend;
    });

    $('#password1').keyup(function () {
        if(this.value == $('#password2').val()) {
            $('.same-pass').addClass('green-validation');
        } else {
            $('.same-pass').removeClass('green-validation');
        }

        if(this.value.length >= 8) {
            $('.length').addClass('green-validation');
        } else {
            $('.length').removeClass('green-validation');
        }

        if(this.value.match('(?=.*?[A-Z])')) {
            $('.uppercase').addClass('green-validation');
        } else {
            $('.uppercase').removeClass('green-validation');
        }

        if(this.value.match('(?=.*?[a-z])')) {
            $('.lowercase').addClass('green-validation');
        } else {
            $('.lowercase').removeClass('green-validation');
        }

        if(this.value.match('(?=.*?[#?!@$%^&*-])')) {
            $('.special').addClass('green-validation');
        } else {
            $('.special').removeClass('green-validation');
        }
    });

    $('#password2').keyup(function () {
        if(this.value == $('#password1').val()) {
            $('.same-pass').addClass('green-validation');
        } else {
            $('.same-pass').removeClass('green-validation');
        }
    });
});

$( window ).resize(function() {
    $('.slide').height(
        $(document).height() - $('.header').height()
    );
});

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 52.447351, lng: 5.8343931},
        zoom: 15,
        styles: [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "-100"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 65
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": "50"
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "-100"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": "30"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": "40"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#ffff00"
                    },
                    {
                        "lightness": -25
                    },
                    {
                        "saturation": -97
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels",
                "stylers": [
                    {
                        "lightness": -25
                    },
                    {
                        "saturation": -100
                    }
                ]
            }
        ]
    });

    marker = new google.maps.Marker({
        map:map,
        // draggable:true,
        // animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(52.447351, 5.8343931),
        icon: 'http://jeffrey.plantagedevelopment.nl/assets/images/marker.png' // null = default icon
    });
}




