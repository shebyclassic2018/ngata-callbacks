var map;
let autocomplete;
var geocoder;
const chicago = { lat: 41.85, lng: -87.65 };
var styles = {
    hide: [
        {
            featureType: "poi.business",
            stylers: [{ visibility: "off" }],
        },
        {
            featureType: "transit",
            elementType: "labels.icon",
            stylers: [{ visibility: "off" }],
        },
        {
            featureType: "administrative.land_parcel",
            stylers: [
                {
                    visibility: "off",
                },
            ],
        },
        {
            featureType: "administrative.neighborhood",
            elementType: "labels.icon",
            stylers: [
                {
                    visibility: "off",
                },
            ],
        },
        {
            featureType: "poi",
            elementType: "labels.text",
            stylers: [
                {
                    visibility: "off",
                },
            ],
        },
        {
            featureType: "water",
            elementType: "labels.text",
            stylers: [
                {
                    visibility: "off",
                },
            ],
        },
    ],
};
var my_location = { lat: -6.781408511892751, lng: 39.247721565043825 };

var markers = [];

function AutoComplete(inputId) {
    // autocomplete = new google.maps.places.Autocomplete(
    //     document.getElementById(inputId), {
    //         types: ["establishment"],
    //         componentRestrictions: {
    //             'country': ['AU']
    //         },
    //         fields: ["place_id", "geometry", "name"],
    //     }
    // );
}

function CenterControl(controlDiv, imageURi, map) {
    // Set CSS for the control border.
    const controlUI = document.createElement("div");

    controlUI.style.backgroundColor = "#fff";
    controlUI.style.border = "2px solid #fff";
    controlUI.style.borderRadius = "3px";
    controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
    controlUI.style.cursor = "pointer";
    controlUI.style.marginTop = "8px";
    controlUI.style.marginBottom = "0px";
    controlUI.style.marginRight = "10px";
    controlUI.style.textAlign = "center";
    controlUI.title = "Houses nearby your location";
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior.
    const controlText = document.createElement("div");

    controlText.style.color = "rgb(25, 25, 25)";
    controlText.style.fontFamily = "Roboto,Arial,sans-serif";
    controlText.style.fontSize = "16px";
    controlText.style.lineHeight = "38px";
    controlText.style.paddingLeft = "10px";
    controlText.style.paddingRight = "10px";
    controlText.innerHTML = "<span class='fa fa-location'></span>";
    controlUI.appendChild(controlText);
    // Setup the click event listeners: simply set the map to Chicago.
    controlUI.addEventListener("click", () => {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var currentLatitude = position.coords.latitude;
                var currentLongitude = position.coords.longitude;
                var currentLocation = {
                    lat: currentLatitude,
                    lng: currentLongitude,
                };
                // var marker = new google.maps.Marker({
                //     position: currentLocation,
                //     icon: imageURi + "/marker/loc.svg",
                //     map: map,
                // });
                map.setCenter(currentLocation);
                map.setZoom(15);
            });
        }
    });
}

function NgataMap(mapProps, imageURi, mapID) {
    map = new google.maps.Map(document.getElementById(mapID), {
        center: my_location,
        zoom: 15,
        disableDefaultUI: true,
        mapTypeId: "roadmap",
        panControl: true,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        overviewMapControl: false,
        rotateControl: true,
        fullscreenControl: true,
        styles: styles["hide"],
        // mapTypeId: google.maps.MapTypeId.SATELLITE
    });

    const centerControlDiv = document.createElement("div");
    CenterControl(centerControlDiv, imageURi, map);
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(
        centerControlDiv
    );

    var mapData = [];

    // INSERTING MAP CONTENT
    for (var i = 0; i < mapProps.length; i++) {
        var houseImage = imageURi + "/houses/" + mapProps[i].path;
        var title = mapProps[i].unit_type;
        

        if (mapProps[i].unit_prices.length > 1) {
            title = "";
            // var content = "<div class='unitInfo'>" + "<div class='row'>";
            var content = `
        <div class="block-content block-content-full px-0">
          <p class="text-center fw-semibold fs-sm">${mapProps[i].wname}, ${mapProps[i].dname}, ${mapProps[i].cname}</p>
            <table class="table table-borderless table-hover table-vcenter">
              <tbody>`;
            for (var j = 0; j < mapProps[i].unit_prices.length; j++) {
                var unit_prices = mapProps[i].unit_prices[j];
                var unit_id = mapProps[i].unit_id[j];
                var total_rooms = mapProps[i].unit_rooms[j];
                if (j <= mapProps[i].unit_prices.length - 2) {
                    title += unit_prices + ",";
                } else {
                    title += unit_prices;
                    // content += "<a href='#' class='many_units'>" + unit_prices + "</a>"
                }

                content += `
                  <tr>
                    <td style="height: 50px">
                    <div>
                    <a class="fs-sm"  href="${getHouseDetailsURI}/${unit_id}/${mapProps[i].unit_prices[j]}/${total_rooms}/${mapProps[i].ward_id}">
                    <img class="img-fluid" src="${houseImage}" alt="" style="height: 50px; width: 100%">
                    </a></div>
                    </td>
                    <td>
                      <a style="color: #00314a;" class="fs-sm" href="${getHouseDetailsURI}/${unit_id}/${mapProps[i].unit_prices[j]}/${total_rooms}/${mapProps[i].ward_id}">${mapProps[i].goal}</a>
                      <div class="fs-sm text-muted">${total_rooms} Rooms | <b>${parseInt(unit_prices).toLocaleString('en-US', currency_format)}</b></div>
                      <a style="color: #b5121f;" href='${getHouseDetailsURI}/${unit_id}/${mapProps[i].unit_prices[j]}/${total_rooms}/${mapProps[i].ward_id}'>More info</a>
                    </td>
                  </tr>`;
                // content += "<div class='col-sm-12' style='padding-top: 5px;'>";
                // content +=
                //     "<a href='" +
                //     getHouseDetailsURI +
                //     "/" +
                //     unit_id +
                //     "/" +
                //     (mapProps[i].unit_prices[j]) +
                //     "/" +
                //     total_rooms +
                //     "/" +
                //     mapProps[i].ward_id +
                //     "' class='many_units'>" +
                //     unit_prices +
                //     " per month | " +
                //     total_rooms +
                //     " Rooms</a>";
                // content += "</div>";
            }

            // content += "</div>" + "</div>";
            content += `</tbody></table></div>`;
        } else {
            var content =
                "<div class='infoWindow'>" +
                "<div class='row'>" +
                "<div class='col-sm-12'>" +
                "<a href='" +
                getHouseDetailsURI +
                "/" +
                mapProps[i].unit_id +
                "/" +
                mapProps[i].price +
                "/" +
                mapProps[i].total_rooms +
                "/" +
                mapProps[i].ward_id +
                "'>"+
                "<img class='img-w img-fluid' src='" +
                houseImage +
                "'/>" +
                "</a>" +
                "</div>" +
                "<div class='col-sm-12 text-cente' style='padding-top: 5px'>" +
                mapProps[i].dname +
                " - " +
                mapProps[i].wname +
                ", " +
                mapProps[i].cname +
                "</div>" +
                "<div class='col-sm-12 fs-xs fw-bold text-cente' style='font-size: 16px; padding-top: 5px; color: #00314a;'>" +
                mapProps[i].goal +
                "</div>" +
                "<div class='col-sm-12 text-center' style='font-size: 14px; padding-top: 5px'><b>" +
                parseInt(mapProps[i].rent_per_month).toLocaleString('en-US', currency_format) +
                "</b>/mo" +
                "</div>" +
                "<div class='col-sm-12 text-center' style='padding-top: 5px'>" +
                "<a href='" +
                getHouseDetailsURI +
                "/" +
                mapProps[i].unit_id +
                "/" +
                mapProps[i].price +
                "/" +
                mapProps[i].total_rooms +
                "/" +
                mapProps[i].ward_id +
                "'>More info</a>" +
                "</div>" +
                "</div>" +
                "</div>";
        }

        mapData.push([
            new google.maps.LatLng(mapProps[i].latitude, mapProps[i].longitude),
            title,
            content,
            mapProps[i].total_units,
        ]);
    }

    // CREATING MARKER AND INFO WINDOW
    var infowindow = new google.maps.InfoWindow();
    $.each(mapData, function (i, item) {
        var myIcon = imageURi + "/marker/hello1.svg";

        if (item[3] > 1) {
            var marker = new google.maps.Marker({
                position: item[0],
                map: map,
                title: item[1],
                icon: myIcon,
                label: {
                    text: "" + item[3],
                    fontSize: "12px",
                    fontWeight: "bold",
                    color: "#00314a",
                    backgroundColor: "red",
                },
            });
        } else {
            var marker = new google.maps.Marker({
                position: item[0],
                map: map,
                title: item[1],
                icon: myIcon,
                label: {
                    text: convertCurrency(mapProps[i].rent_per_month),
                    fontSize: "9px",
                    fontWeight: "bold",
                    color: "#00314a",
                    backgroundColor: "red",
                },
            });
        }
        google.maps.event.addListener(
            marker,
            "click",
            (function (marker) {
                return function () {
                    infowindow.setContent(item[2]);
                    infowindow.open(map, marker);
                };
            })(marker)
        );
    });
}

function addressHolder(
    from_placesInputId,
    to_placesInputId,
    originHiddenInputId,
    destinationHiddenInputId
) {
    google.maps.event.addDomListener(window, "load", function () {
        var from_places = new google.maps.places.Autocomplete(
            document.getElementById(from_placesInputId)
        );
        var to_places = new google.maps.places.Autocomplete(
            document.getElementById(to_placesInputId)
        );

        google.maps.event.addListener(
            from_places,
            "place_changed",
            function () {
                var from_place = from_places.getPlace();
                var from_address = from_place.formatted_address;
                $("#" + originHiddenInputId).val(from_address);
            }
        );

        google.maps.event.addListener(to_places, "place_changed", function () {
            var to_place = to_places.getPlace();
            var to_address = to_place.formatted_address;
            $("#" + destinationHiddenInputId).val(to_address);
        });
    });
}

function calculateDistance() {
    var origin = $("#origin").val();
    var destination = $("#destination").val();
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
        {
            origins: [origin],
            destinations: [destination],
            travelMode: google.maps.TravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false,
        },
        callback
    );
}

function callback(response, status) {
    if (status != google.maps.DistanceMatrixStatus.OK) {
        $("#result").html(err);
    } else {
        var origin = response.originAddresses[0];
        var destination = response.destinationAddresses[0];
        if (response.rows[0].elements[0].status === "ZERO_RESULTS") {
            $(
                "Better get on a plane. There are roads between " +
                    origin +
                    " and " +
                    destination
            );
        } else {
            var distance = response.rows[0].elements[0].distance;
            var duration = response.rows[0].elements[0].duration;
            var distance_km = distance.value / 1000;
            var distance_miles = distance.value / 1609.34;
            var duration_text = duration.text;
            var duration_value = duration.value;
            console.log("Distance KM: " + distance_km);
            console.log("Distance MILES: " + distance_miles);
            console.log("Duration Text: " + duration_text);
            console.log("Duration value: " + duration_value);
        }
    }
}

function codeAddress() {
    // var address = document.getElementById('address').value;
    geocoder.geocode(
        {
            address: "Dar es salaam, Tanzania",
        },
        function (results, status) {
            if (status == "OK") {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                });
            } else {
                alert(
                    "Geocode was not successful for the following reason: " +
                        status
                );
            }
        }
    );
}

function convertCurrency(currency) {
    if (currency >= 0 && currency < 1000) {
        currency = currency;
    } else if (currency >= 1000 && currency < 1000000) {
        currency /= 1000;
        currency = Math.round(currency);
        currency += "K";
    } else if (currency >= 1000000 && currency <= 1000000000) {
        currency /= 1000000;
        currency = Math.round(currency);
        currency += "M";
    } else {
        currency /= 1000000000;
        currency = Math.round(currency);
        currency += "B";
    }

    return currency;
}

function geoCoords() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            // console.log(position);
            // console.log("yes");
        });
    } else {
        // console.log("no");
    }
}

function reverseGeocorder(KEY) {
    const autocompletedValue = new google.maps.places.Autocomplete(
        document.getElementById("alt-neighbourhoo")
    );
    var city;
    var district;
    var neighbourhood;
    var coordinate;

    const handleCityChanges = (part) => {
        city = part.long_name.includes("Region")
            ? part.long_name.split(" ")[0]
            : part.long_name.includes("Mkoa")
            ? part.long_name.split(" ")[2]
            : part.long_name;
    };

    google.maps.event.addListener(
        autocompletedValue,
        "place_changed",
        function () {
            var addressComponents = autocompletedValue.getPlace();
            var LAT = addressComponents.geometry.location.lat();
            var LNG = addressComponents.geometry.location.lng();
            var CTS = LAT + ", " + LNG;
            let url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${LAT},${LNG}&key=${KEY}`;
            fetch(url)
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == "OK") {
                        data.results.forEach((element) => {
                            if (
                                element.types.includes(
                                    "administrative_area_level_4"
                                )
                            ) {
                                var parts = element.address_components;
                                parts.forEach((part) => {
                                    if (
                                        part.types.includes(
                                            "administrative_area_level_4"
                                        )
                                    ) {
                                        neighbourhood = part.long_name;
                                    }

                                    if (
                                        part.types.includes(
                                            "administrative_area_level_2"
                                        )
                                    ) {
                                        district = part.long_name;
                                    }

                                    if (part.types.includes("locality")) {
                                        handleCityChanges(part);
                                    } else if (
                                        part.types.includes(
                                            "administrative_area_level_4"
                                        )
                                    ) {
                                        handleCityChanges(part);
                                    }
                                    coordinate = CTS;
                                });

                                $("#city1").val(city);
                                $("#district1").val(district);
                                $("#ward1").val(neighbourhood);
                            }
                        });
                    } else {
                        console.log("browser not support");
                    }
                })
                .catch((err) => console.warn(err.message));
        }
    );
}
