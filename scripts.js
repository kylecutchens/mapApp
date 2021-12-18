//declaring globals because it's 3am and I can't think of a better way to do it

//Getting value from "ajax.php".
function fill(Value) {
    //Assigning value to "search" div in "search.php" file.
    $('#search').val(Value);
    //Hiding "display" div in "search.php" file.
    $('#display').hide();
}

function fill2(Value2) {
    //Assigning value to "search" div in "search.php" file.
    $('#search2').val(Value2);
    //Hiding "display" div in "search.php" file.
    $('#display2').hide();
}



//directions request
$(document).ready(function () {


    $('#confirm').on('click', function () {

        var $search = $('#search').val();

        if (search == "") {
            $('#display').html("No Location Selected")
        }


        else {

            //$('#message').html($search);


            $.ajax({

                type: "POST",
                url: "getcoords.php",
                data: { search: $search },
                success: function (result) {

                    $('#coordinate').attr("value", result);
                    $("#message").html('Valid Location Confirmed')

                }
            });

        }


    });

    $('#confirm2').on('click', function () {

        var $search2 = $('#search2').val();

        if ($search2 == "") {
            $('#display2').html("No Location Selected")
        }
        else {
            $.ajax({

                type: "POST",
                url: "getcoords.php",
                data: { search: $search2 },
                success: function (result) {


                    $('#coordinate2').attr("value", result);
                    $("#message2").html('Valid Location Confirmed')
                }
            });
        }


    });


});

//origin live search bar
$(document).ready(function () {
    //On pressing a key on "Search box" in "search.php" file. This function will be called.
    $("#search").keyup(function () {
        //Assigning search box value to javascript variable named as "name".
        var name = $('#search').val();
        //Validating, if "name" is empty.
        if (name == "") {
            //Assigning empty value to "display" div in "search.php" file.
            $("#display").html("");
        }
        //If name is not empty.
        else {
            //AJAX is called.
            $.ajax({
                //AJAX type is "Post".
                type: "POST",
                //Data will be sent to "ajax.php".
                url: "ajax.php",
                //Data, that will be sent to "ajax.php".
                data: {
                    //Assigning value of "name" into "search" variable.
                    search: name
                },
                //If result found, this funtion will be called.
                success: function (html) {
                    //Assigning result to "display" div in "search.php" file.
                    $("#display").html(html).show();
                    // $("#display").append("<li value='" + id + "'>" + name + "</li>");
                }
            });
        }
    });
});
//destination live search bar
$(document).ready(function () {
    //On pressing a key on "Search box" in "search.php" file. This function will be called.
    $("#search2").keyup(function () {
        //Assigning search2 box value to javascript variable named as "name".
        var name = $('#search2').val();
        //Validating, if "name" is empty.
        if (name == "") {
            //Assigning empty value to "display" div in "search.php" file.
            $("#display2").html("");
        }
        //If name is not empty.
        else {
            //AJAX is called.
            $.ajax({
                //AJAX type is "Post".
                type: "POST",
                //Data will be sent to "ajax.php".
                url: "ajax2.php",
                //Data, that will be sent to "ajax.php".
                data: {
                    //Assigning value of "name" into "search" variable.
                    search: name
                },
                //If result found, this funtion will be called.
                success: function (html) {
                    //Assigning result to "display2" div in "search.php" file.
                    $("#display2").html(html).show();
                    //$("#display2").append("<li value='" + id + "'>" + name + "</li>");
                }
            });
        }
    });
});


window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        for (var index in modals) {
            if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";
        }
    }
}



//map callback function. anything relating to the map goes here
function myMap() {

    var directionsService = new google.maps.DirectionsService();
    var directionsRenderer = new google.maps.DirectionsRenderer();

    //var $style = 

    var mapProp = {
        center: new google.maps.LatLng('32.8275', '-83.6494'),
        zoom: 16.5,
        //does the hide thing
       /*styles: [
            {
                "featureType": "all",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#585858"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#202020"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "weight": "4.33"
                    },
                    {
                        "visibility": "on"
                    },
                    {
                        "gamma": "1.51"
                    },
                    {
                        "color": "#ff8f00"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#1f2f20"
                    }
                ]
            },
            {
                "featureType": "poi.school",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#868686"
                    }
                ]
            },
            {
                "featureType": "poi.sports_complex",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c1baba"
                    }
                ]
            },
            {
                "featureType": "poi.sports_complex",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#000000"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#1a1919"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#784307"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#3d3e3f"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#2f3032"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#171e35"
                    }
                ]
            }
        ],*/
        mapId: '313c17d8f0620ca9',
        zoomControl: false,
        scrollwheel: false,
        disableDoubleClickZoom: true,
        disableDefaultUI: true,
        heading: 40

    };

    var map = new google.maps.Map(document.getElementById("map"), mapProp);
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

    $('#filterbar').on('keyup', function () {

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


