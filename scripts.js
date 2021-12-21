
//major functions for website functionality
$(document).ready(function () {

    //dialogue box when hovering over buttons
    $(".utilityButton").on('hover', function(){

        $(this + '> div').addClass('infoBox-visible');
        
    });


    //live search bar
    $('.textInput').on('keyup', function () {

        var section = $(this).attr('id');
        var display = $(this).attr('data');

        let input = $(this).val();

        if (input == "") {

            $('#' + display).html("");
        }
        else {
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: { search: input },
                success: function (result) {

                    $('#' + display).html(result).show();

                    $($('.searchResult')).on('click', function () {

                        let selection = $(this).attr('id');

                        $('#' + section).attr('value', selection);
                        $('#' + display).hide();

                    });

                },

                error: function () { console.log('live search failed') }
            });
        }
    });

    });



//map callback function. anything relating to the map goes here
function myMap() {

    var directionsService = new google.maps.DirectionsService();
    var directionsRenderer = new google.maps.DirectionsRenderer();

    //var $style = 

    var $mapProp = {
        center: new google.maps.LatLng('32.8275', '-83.6494'),
        zoom: 18,
        minZoom: 17,
        maxZoom: 20,
        mapId: '313c17d8f0620ca9',
        disableDoubleClickZoom: true,
        disableDefaultUI: true,
        rotateControl: false,
        heading: 36,

    };

    var map = new google.maps.Map(document.getElementById("map"), $mapProp);
    directionsRenderer.setMap(map);

    let markers = {};
    let infowindows = {};



    const coordsArr = JSON.parse($('#totalCoords').text());

    for (let i = 0; i < coordsArr.length; i++) {

        const coord = coordsArr[i];
        markers[coord.bcode] = new google.maps.Marker({
            position: new google.maps.LatLng(coord.lat, coord.lon),
            title: coord.bcode
        });

        infowindows[coord.bcode] = new google.maps.InfoWindow({ content: coord.bcode + " - " + coord.bname });

        markers[coord.bcode].setMap(map);
        markers[coord.bcode].addListener("mouseover", () => { infowindows[coord.bcode].open({ anchor: markers[coord.bcode], map }) });
        markers[coord.bcode].addListener("mouseout", () => { infowindows[coord.bcode].close() });
        markers[coord.bcode].addListener("click", () => { showInfoDiv(coord.indx) });
    }

    $("#directions").on('click', function () {

        var $origin = $('#coordinate').val();
        var $destination = $('#coordinate2').val();

        var $request = {

            origin: $origin,
            destination: $destination,
            travelMode: 'WALKING'

        };

        directionsService.route($request, function (result, status) {

            if (status == 'OK') {

                $('.modal').attr('display', 'none');
                clearMarkers();
                directionsRenderer.setDirections(result);
                $('#myModal1').attr('display', 'none');
                $('.clearDirections').addClass('clearDirections-show');
            }

            $('.clearDirections').on('click', function () {

                directionsRenderer.set('directions', null);
                $('.clearDirections').removeClass('clearDirections-show');
                addMarkers();

            });



        });
    });

    $('#filterbar').on('change', function () {

        var input = $('#filterbar').val()


        if (input == "") {
            addMarkers();
        }
        else {
            clearMarkers(input);

            $.ajax({

                type: "POST",
                url: "filter.php",
                data: { input: input },
                success: function (result) {

                    for (let i = 0; i < result.length; i++) {

                        markers[result[i]].setMap(map);

                    }

                },
                dataType: "json",
                error: function () { console.log('filter failed') }
            });
        }



    });

    $(".details-pane-close").on('click', function () {
        $('.detailsBar').removeClass('details-pane-visible');
    })

    function clearMarkers() {
        for (let i = 0; i < coordsArr.length; i++) {

            const coord = coordsArr[i];
            markers[coord.bcode].setMap(null);

        }

    }

    function addMarkers() {
        for (let i = 0; i < coordsArr.length; i++) {

            const coord = coordsArr[i];
            markers[coord.bcode].setMap(map);

        }
    }

    function showInfoDiv(indx) {

        let markerData = coordsArr[indx]
        const $detailsDiv = $('.detailsBar')
        const $titleDiv = $('.details-pane-title');
        const $contentDiv = $('.details-pane-content');
        const $imageDiv = $('#locationImage');


        $detailsDiv.removeClass('details-pane-visible');

        $imageDiv.attr('src', markerData.image);
        $titleDiv.text(markerData.bname);
        $contentDiv.text(markerData.description);

        $detailsDiv.addClass('details-pane-visible');

        $detailsDiv.removeClass('details-pane--visible');



    }
};

//};


