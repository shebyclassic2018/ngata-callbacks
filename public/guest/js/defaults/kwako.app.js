function iPhoneDatetimeLocal() {
  var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
  var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0,-1);
  var localISOTimeWithoutSeconds = localISOTime.slice(0,16);
  var dtlInput = document.querySelector('input[type="datetime-local"]');
  dtlInput.value = localISOTime.slice(0,16);
}


function getNeighbourhoodAjax(city_id, flag) {
  // var city_id = $('#city').val();
  // var flag    = 'districts';

  $('#districts').html('<option><em>Loading...</em></option>');
  
  $.ajax({
    url: "{{ url('fetchByFlag') }}",
    type: "POST",
    data: {
      _token: '{{ csrf_token() }}',
      _flag: flag,
      city_id: city_id,
    },
    dataType: 'json',
    success: function (result) {

      console.log(result);
      // setTimeout(() => {
      //   $('#districts').html('<option disabled selected>-- Choose --</option>');
      //   $.each(result.districts, function (key, value) {
      //   $("#districts").append('<option value="'+value.id+'">'+value.name+'</option>');});
      // }, 1000);
    }
  });
}


function money_format(params) {
  
}

function money_format_zeros(money) {
  if (money >= 1000000) {
    money /= 1000000;
    money = roundTo(3, money);
    money += 'M';
  } else if (money >= 1000) {
    money /= 1000;
    money = roundTo(3, money);
    money += 'K';
  }
  
  return  money
};

function format_currency(money) { return new Intl.NumberFormat().format(money); };
function nimAVGmax(n, x, i) { return (i < n) ? n : ((x < i) ?  x : i); };

function returnParcentage(housePrice, P) {
  var HP = housePrice; 
  var xValue = HP * P;
  xValue /= 100;

  return { housePrice, xValue };
}

function currency(amount, _country) {
  return (_country == 'TZ' || _country == 'tz') ? `Tsh ${amount}` : `$ ${amount}`;
}

function roundTo(places, num) {
  return +(Math.round(num + `e+${places}`) + `e-${places}`);
}

function monthlyPayment(P,R,N) {
  var M = 0; R /= 100; R /= 12; N *= 12;
  M += (P * R) * Math.pow((1+R), N);
  M /= (Math.pow((1+R), N) - 1); 
  return M;
}

function getBaseAmountOverHousePrice(HP, P, LIR, UDP){
  // RDP => Required Down Payment;
  var RDP = HP;
  RDP *= P;
  RDP/= 100

  var ScreeningMonth = 0;
  // DP = (UDP > RDP) ? UDP : RDP;
  var DP = UDP;

  var duration = howLongToPay;
  var houseAmount = HP;

  // find The MonthyPayment By RDP
  var MP = monthlyPayment((houseAmount - (( UDP > 0 ) ? UDP : RDP)), LIR, duration);

  if (UDP == 0) {
    ScreeningMonth = calculateMonthlyPaymentFirst();
  } else {
    ScreeningMonth = (UDP > RDP) ? 3 : ((UDP == RDP) ? 6 : calculateMonthlyPaymentFirst());
  }
  

  function calculateMonthlyPaymentFirst() {
    /* find the monthly payment then in how wrong user will complite the RDP 
    *  the do thefollowing 
    */

    // take required amount
    var diffAmount = RDP - UDP;

    var Month = 0;
    if (diffAmount <= MP) {
      Month = 1;
    } else {
      Month = roundTo(0, (diffAmount / MP));
    }

    // find Value of month until user save the requiredAmount.
    return Month += (Month <= 6) ? 6 : ((Month <= 9) ? 5 : 4);
  }

  return {DP, ScreeningMonth, MP, status } ;    
}


function removeServiceAfterSend(itemName) {
  if(localStorage.getItem(itemName) != null){
    localStorage.removeItem(itemName);
  }
}

function mortgageAjaxService(prefix, items, image_base) {

  $('#view-items-container').show();
  $('#looading_spinner').html('');
  $('#count-result').html('');

  if (items.length > 0) {
  // console.log(items);

    $('#count-result').html(`${items.length} HOUSE(S) FOUND`);

    // var image_base = "{{ asset('media/photos/') }}";

    $.each(items, function (key, value) {

      $("#view-items").append(`
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="property-box">
            <div class="property-thumbnail">
              <a href="/service/${prefix}/${value.ID}/details" class="property-img">
                <div class="price-ratings-box">
                  <p class="price">${convert(value.amount)}</p>
                  <div class="ratings">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                  </div>
                </div>
                <img src="${image_base}/${value.propertyImage}" alt="${value.propertyImage}" class="img-fluid">
              </a>
              <div class="property-overlay">
                <a href="/${prefix}/${value.ID}/id" class="overlay-link">
                  <i class="fa fa-link"></i>
                </a>
              
                <a class="overlay-link" id="propertyView" data-id="${value.ID}" data-toggle="modal" data-target="#propertyModal">
                  <i class="fa fa-video-camera"></i>
                </a>
                <div class="property-magnify-gallery">
                  <a href="javascript:void(0)" class="overlay-link">
                    <i class="fa fa-expand"></i>
                  </a>
      
                </div>
                                
              </div>
            </div>
            <div class="detail">
              <h1 class="title">
                <a href="/service/${prefix}/${value.ID}/details">${value.propertyName}</a>
              </h1>
              <div class="location">
                <a href="">
                  <i class="fa fa-map-marker"></i>${value.district}, ${value.city}
                </a>
              </div>
              
            </div>
      
          </div>
        </div>
      `); 
    });      
  }else {
    $("#view-items").append('<div class="col-12"><p class""> No Map belong to this Type of house Please Follow Step to complete your request our team will review and return feedback to your shotly</p> <span class"text-primary">click here</span> </div>'); 
  } 
}

function rentToOwnAjaxService(prefix, items, image_base) {

  $('#view-items-container').show();
  $('#looading_spinner').html('');
  $('#count-result').text('');

  if (items.length > 0) {
    // console.log(items);

    $('#count-result').text(`${items.length} MAP(S) FOUND`);

    $.each(items, function (key, value) {

      $("#view-items").append(`
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="property-box">
          <div class="property-thumbnail">

            <a href="/service/${prefix}/${value.mapID}/details" class="property-img">
              <div class="price-ratings-box">
                <p class="price">${convert(5678877)}</p>
                <div class="ratings">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star-o"></i>
                </div>
              </div>
              <img src="${image_base}/${value.map_path}" alt="${image_base}/${value.map_path}" class="img-fluid">
            </a>

            <div class="property-overlay">
              <a href="/${prefix}/${value.mapID}/id" class="overlay-link">
                <i class="fa fa-link"></i>
              </a>
            
              <a class="overlay-link" id="mapView" data-id="${value.mapID}" data-toggle="modal" data-target="#mapModal">
                <i class="fa fa-video-camera"></i>
              </a>

              <div class="property-magnify-gallery">
                <a href="javascript:void(0)" class="overlay-link">
                  <i class="fa fa-expand"></i>
                </a>
              </div>  
                       
            </div>
          </div>
        </div>
      </div>
    `);

      // $("#view-items").append(`
      // <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn" >
      //   <a class="img-link img-thumb img-lightbox" data-toggle="modal"
      //   data-id="${value.id}" id="mapView" data-target="#mapModal">
        
      //     <img class="img-fluid drawing" src="${image_base}/${value.map_path}" alt="">
      //     <div class="options-overlay bg-black-75">
      //                               <div class="options-overlay-content">
      //                                   <h3 class="h4 font-w400 text-white mb-1">Image Caption</h3>
      //                                   <h4 class="h6 font-w400 text-white-75 mb-3">Some extra info</h4>
      //                                   <a class="btn btn-sm btn-primary img-lightbox" href="assets/media/photos/photo17@2x.jpg">
      //                                       <i class="fa fa-search-plus mr-1"></i> View
      //                                   </a>
      //                                   <a class="btn btn-sm btn-secondary" href="javascript:void(0)">
      //                                       <i class="fa fa-pencil-alt mr-1"></i> Edit
      //                                   </a>
      //                               </div>
      //                           </div>
      //   </a>
      // </div>`);

    //   // $("#view-items").append(`
    //   // <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn" >
        
    //   //   <div class="options-container fx-item-rotate-r">
    //   //   <a data-toggle="modal" data-id="${value.id}" id="mapView" data-target="#mapModal"><img class="img-fluid options-item drawing" src="${image_base}/${value.map_path}" alt="">
    //   //   </a>
          
    //   //     <div class="options-overlay bg-black-75">
    //   //       <div class="options-overlay-content">
    //   //           <h3 class="h4 font-w400 text-white mb-1"></h3>
    //   //           <h4 class="h6 font-w400 text-white-75 mb-3"></h4>
    //   //           <a class="btn btn-sm btn-primary img-lightbox" href="${image_base}/${value.map_path}">
    //   //               <i class="fa fa-expand mr-1"></i> Expand
    //   //           </a>
    //   //           <a class="btn btn-sm btn-secondary" data-toggle="modal" data-id="${value.id}" id="mapView" data-target="#mapModal"><i class="fa fa-eye mr-1"></i> Continue
    //   //           </a>
    //   //       </div>
    //   //     </div>
    //   //   </div>
        
    //   // </div>`);

    });      
  }else {
    $("#view-items").append('<div class="col-12"><p class""> No Map belong to this Type of house Please Follow Step to complete your request our team will review and return feedback to your shotly</p> <span class"text-primary">click here</span> </div>'); 
  } 
}

function displayHouseModal(prefix, property, image_base, map_base) {

  $('#viewProperty-header').html(`
    <h5 class="modal-title" id="propertyModalLabel">Get Your Dream House</h5>
    <p>
      <i class="flaticon-facebook-placeholder-for-locate-places-on-maps"></i> ${property.district}, ${property.city} .
    </p>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  `);

  // var image_base = "{{ asset('media/photos/') }}";
  // var map_base = "{{ asset('media/maps/') }}";

  $('#viewProperty-body').html(`
      <div class="col-lg-6 modal-left">
        <div class="modal-left-content">
          <div id="modalCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <img src="${image_base}/${property.propertyImage}" alt="Test ALT">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('guest_assets/img/property-1.jpg') }}" alt="Test ALT">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('guest_assets/img/property-2.jpg') }}" alt="Test ALT">
              </div>
              <div class="carousel-item">
                <img src="${map_base}/${property.map}" alt="Test ALT">
              </div>
              <div class="carousel-item ">
                <iframe class="modalIframe" src="https://www.youtube.com/embed/5e0LxrLSzok"
                  allowfullscreen></iframe>
              </div>
            </div>
            <a class="control control-prev" href="#modalCarousel" role="button" data-slide="prev">
              <i class="fa fa-angle-left"></i>
            </a>
            <a class="control control-next" href="#modalCarousel" role="button" data-slide="next">
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
          <div class="description">
            <h3>Description</h3>
            <p>
              Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque
              massa, viverra interdum eros ut, imperdiet pellentesque mauris. Proin sit amet scelerisque
              risus. Donec
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 modal-right">
        <div class="modal-right-content bg-white">
          <strong class="price">${convert(property.amount)}</strong>
          <section>
            <h3>Features</h3>
            <ul class="bullets">
              <li><i class="flaticon-bed"></i> Double Bed</li>
              <li><i class="flaticon-swimmer"></i> Swimming Pool</li>
              <li><i class="flaticon-bath"></i> 2 Bathroom</li>
              <li><i class="flaticon-car-repair"></i> Garage</li>
              <li><i class="flaticon-parking"></i> Parking</li>
              <li><i class="flaticon-theatre-masks"></i> Home Theater</li>
              <li><i class="flaticon-old-typical-phone"></i> Telephone</li>
              <li><i class="flaticon-green-park-city-space"></i> Private space</li>
            </ul>
          </section>
          <section>
            <h3>Overview</h3>
            <dl>
              <dt>Area</dt>
              <dd>2500 Sq Ft:3400</dd>
              <dt>Condition</dt>
              <dd>New</dd>
              <dt>Year</dt>
              <dd>2018</dd>
              <dt>Price</dt>
              <dd>${convert(property.amount)}</dd>
            </dl>
          </section>
          <section class="row justify-content-between">
            <a href="/contract/{{ Request::segment(2) }}/details/${property.propertyID}" data-id="${property.propertyID}" class="btn btn-warning" id="start${prefix}">Start Now</a>
            <a href="/${prefix}/${property.propertyID}/id" class="btn kwako-bg-primary">More Detail</a>
          </section>
          
        </div>
      </div>
  `);
}



function displayMapModal_OUTDATE(prefix, mapObject, map_base) {

  $('#showDownPaymentFieldModal').hide();


  $('#viewMap-body').html('');

  $('#viewMap-body').html(`
      <div class="col-lg-6 modal-left">
        <div class="modal-left-content kwako-bg-primary">
          <div id="modalCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <img src="${map_base}/${mapObject.map_path}" alt="Test ALT">
              </div>
              <div class="carousel-item">
                <img src="${map_base}/${mapObject.map_path}" alt="Test ALT">
              </div>
              <div class="carousel-item">
                <img src="${map_base}/${mapObject.map_path}" alt="Test ALT">
              </div>
              <div class="carousel-item">
                <img src="${map_base}/${mapObject.map_path}" alt="Test ALT">
              </div>
            </div>
            <a class="control control-prev" href="#modalCarousel" role="button" data-slide="prev">
              <i class="fa fa-angle-left"></i>
            </a>
            <a class="control control-next" href="#modalCarousel" role="button" data-slide="next">
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
          <div class="modal-right-content">
            <section>
              <h3 class="text-white">Features</h3>
              <ul class="bullets text-white pb-2">
                <li><i class="flaticon-bed text-warning"></i> Double Bed</li>
                <li><i class="flaticon-swimmer text-warning"></i> Swimming Pool</li>
                <li><i class="flaticon-bath text-warning"></i> 2 Bathroom</li>
                <li><i class="flaticon-car-repair text-warning"></i> Garage</li>
                <li><i class="flaticon-parking text-warning"></i> Parking</li>
                <li><i class="flaticon-theatre-masks text-warning"></i> Home Theater</li>
                <li><i class="flaticon-old-typical-phone text-warning"></i> Telephone</li>
                <li><i class="flaticon-green-park-city-space text-warning"></i> Private space</li>
              </ul>
            </section>
          </div>
        </div>
      </div>
      <div class="col-lg-6 modal-right">
        <div class="modal-right-content bg-white">
          <section>
            <h3>Price Summary</h3>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label class="kwako-text-primary">Range From </label>
                  <p class="kwako-text-primary border border-2x p-2 bg-white border-black kwako-text-primary"><span class="ml-2 font-size-h6">
                  ${format_currency(mapObject.rangeFrom)}/=</span></p>
                </div>
              </div>

              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label class="kwako-text-primary">Range To </label>
                  <p class="kwako-text-primary border border-2x p-2 bg-white border-black kwako-text-primary"><span class="ml-2 font-size-h6">
                  ${format_currency(mapObject.rangeTo)}/=</span></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="" class="kwako-text-primary">Your Budget</label>
                  <input type="number" class="form-control" id="yourBudget" name="yourBudget">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label class="kwako-text-primary mb-1">Do you have down payment ?</label>
                  <div class="col-12">
                    <input type="radio" class="dpBoolean mr-2" id="noButton" name="down-payment" checked>
                    <label class="custom-control-label" for="noButton"> No</label>
                  </div>
                  <div class="col-12">
                    <input type="radio" class="dpBoolean mr-2" id="yesButton" name="down-payment">
                    <label class="custom-control-label" for="yesButton"> Yes</label>
                  </div>
                </div>
              </div>

              <div class="col-12" id="showDownPaymentFieldInpurt"></div>
            </div>
            

            <dl>
              <dt>Payment</dt>
              <dd>1 to 15 years</dd>
              <dt>Required</dt>
              <dd id="">10%</dd>
            </dl>
          </section>
          <section class="row justify-content-between">
            <a href="/contract/${prefix}/details/${mapObject.mapID}" data-id="${mapObject.mapID}" 
            data-range="${mapObject.PriceRangeID}" data-sqr="${mapObject.sqrtSizeID}" class="btn btn-warning" id="start${prefix}">Start Now</a>
            <a href="/${prefix}/${mapObject.mapID}/id/drawing" id="viwMore${prefix}" class="btn kwako-bg-primary">More Detail</a>
          </section>
          
        </div>
      </div>
  `);

  $('#mapModal').modal();
}


