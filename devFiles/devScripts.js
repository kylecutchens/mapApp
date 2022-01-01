var isEdit = false;

//functions for website utilities
$(document).ready(function () {

    //clear search bars on refresh
    $('input').val('');
    $('textarea').val('');

    //open/close dialogue box when hovering over buttons
    $(".utilityButton").on('hover', function () {
        let button = $(this).attr('id')
        $('#' + button + '> div').addClass('infoBox-visible');
    });
    $(".utilityButton").on('mouseleave', function () {
        let button = $(this).attr('id')
        $('#' + button + '> div').removeClass('infoBox-visible');
    });

    //show utility div
    $(".utilityButton").on('click', function () {
        $(".utilityDiv").removeClass('utilityDiv-visible');
        let button = $(this).attr('data');
        $('#' + button).addClass('utilityDiv-visible');
    });

    //close button
    $('.closeButton').on('click', function () {
        let div = $(this).attr('data')
        $('#' + div).removeClass('utilityDiv-visible');
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

    var $mapProp = {
        center: new google.maps.LatLng('32.8275', '-83.6494'),
        zoom: 18,
        minZoom: 17,
        maxZoom: 20,
        mapId: '313c17d8f0620ca9',
        disableDoubleClickZoom: true,
        disableDefaultUI: true,
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
        markers[coord.bcode].addListener("click", () => { markerClick(coord.indx) });
    }

    $("#getDirections").on('click', function () {

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

    function markerClick(indx) {

        let markerData = coordsArr[indx]

        if (isEdit == true) {


            $('.preSelect').attr('style', 'display: none');

            $('#name').attr('value', markerData.bname);
            $('#bcode').attr('value', markerData.bcode);
            $('#description').attr('value', markerData.description);
            $('#image').attr('value', markerData.image);
            $('#lat').attr('value', markerData.lat);
            $('#lon').attr('value', markerData.lon);

        }
        else {

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

    }


};

//scripts for dev tools

$(document).ready(function () {

    $('.selectorButton').on('click', function () {

        let selection = $(this).attr('data');

        $('#toolForm').attr('data', selection);
        $('.formBar').attr('value', '');

        if (selection == 'insert') {
            $('.formTitle').html('Insert New Marker');
            $('.preSelect').attr('style', 'display: none');
            isEdit = false;
        }
        else if (selection == 'edit') {
            $('.formTitle').html('Edit Marker');
            $('.preSelect').attr('style', 'display: inline');
            isEdit = true;
        }
        else if (selection == 'delete') {
            $('.formTitle').html('Delete Marker');
            $('.preSelect').attr('style', 'display: none');
            isEdit = false;
        }
    });

    $('.submit').on('click', function () {

        let selection = $('#toolForm').attr('data');

        let name = $('#name').attr('value');
        let bcode = $('#bcode').attr('value');
        let description = $('#description').attr('value');
        let image = $('#image').attr('value');
        let lat = $('#lat').attr('value');
        let lon = $('#lon').attr('value');

        console.log(name, bcode, description, image, lat, lon);


        if (!name || !bcode) {
            console.log('no valid marker data found');
        }
        else {
            $.ajax({
                type: 'POST',
                url: 'devAjax.php',
                dataType: 'text',
                data: {
                    //operation: selection,
                    name: name,
                    bcode: bcode,
                    description: description,
                    image: image,
                    lat: lat,
                    lon: lon,
                },
                success: function (result) { console.log(result) },
                error: function (result) { console.log('failed') }
            });
        }

    })

});