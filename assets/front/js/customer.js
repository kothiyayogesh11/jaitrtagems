var curLat;
var curLong = null;

$(document).on("click","#v-pills-book-tab",function(){
    $("#activity-parent:hidden").css("display","block");
    $("#partner-parent").css("display","none");
    $("#partner-details").css("display","none");
    $(".book-form").css("display","none ");
    
});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position){
            curLat = position.coords.latitude;
            curLong = position.coords.longitude;
        });
    }
}
getLocation();

$(document).ready(function(){    
    if( !$('.js-site-navbar').hasClass('scrolled') ) {
        $('.js-site-navbar').addClass('scrolled');  
    }
    if( !$('.js-site-navbar').hasClass('awake') ) {
        $('.js-site-navbar').addClass('awake'); 
    }
    slot.get_open_request();

    $('.partner_date').datepicker({
        format: 'yyyy-mm-dd',
        startDate: "dateToday",
        autoclose: true
    });
                        
    $('input[name="new_from_time"]').timepicki();
    $('input[name="new_to_time"]').timepicki();
});

/* Slot Booking */
var slot = {}
slot.user_id = $("input[name='site_user_key']").val();
slot.url_id = $("input[name='site_url_key']").val();
slot.partner_id = null;
slot.activity_id = null;
slot.order_id = null;
slot.getActivityPartner = function(partner_name){
    $.ajax({
        type:"POST",
        url:base_url+"account/search_partner",
        data:{"activity_id":slot.activity_id,"partner_name":partner_name},
        dataType : "json",
        beforeSend:function(){},
        success:function(res){
            loader.remove();
            $(".partner-list").html(res.data);
        },
        error:function(){
            loader.remove();
        }
    });
}

slot.fancybox = function(){
    $('[data-fancybox="images"]').fancybox({
        keyboard: true,
        arrows: true,
        afterLoad : function(instance, current) {
            var pixelRatio = window.devicePixelRatio || 1;
            if ( pixelRatio > 1.5 ) {
                current.width  = current.width  / pixelRatio;
                current.height = current.height / pixelRatio;
            }
        }
    });
}

slot.activity_details = function(){
    if(this.partner_id != "" && this.activity_id != ""){
        $.ajax({
            type:"POST",
            url:base_url+"account/activity_details",
            data:{"activity_id":slot.activity_id,"partner_id":slot.partner_id,},
            dataType:"json",
            beforeSend:function(){loader.set("body");},
            success:function(res){
                $(".partner-parent").hide();
                $(".partner-details").show();
                if(typeof res.status != "undefined" && res.status == 1){
                    $(".partner-details-wrap").html(res.data);
                    slot.fancybox();
                    slot.initialize();
                }else{
                    $(".partner-details-wrap").html("");
                }
                loader.remove();
            },
            error:function(err){
                loader.remove();
            }
        });
    }else{

    }
}



slot.geocoder;
slot.map;
slot.marker;
slot.geomap_book = "geomap_book";
slot.geomap_book_form = "geomap_book_form";

slot.initialize = function() {
    
    var initialLat = curLat;
    var initialLong = curLong;
    var latlng = new google.maps.LatLng(initialLat, initialLong);
    var options = {zoom: 16, center: latlng,  mapTypeId: google.maps.MapTypeId.ROADMAP };
    map = new google.maps.Map(document.getElementById("geomap"), options);
    geocoder = new google.maps.Geocoder();
    marker = new google.maps.Marker({ map: map, draggable: true, position: latlng});
	google.maps.event.addListener(map, 'click', function(event) {
	  geocoder.geocode({
		'latLng': event.latLng
	  }, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
		  if (results[0]) {
			map.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);
			$('#search_location').val(results[0].formatted_address);
			$('.search_latitude').val(marker.getPosition().lat());
			$('.search_longitude').val(marker.getPosition().lng());
		  }
		}
	  });
	});    
}

slot.initialize_book = function() {
    var initialLat = $('.search_latitude').val();
    var initialLong = $('.search_longitude').val();
    initialLat = initialLat?initialLat:38.89751299999999;
    initialLong = initialLong?initialLong:-77.036562;
    var latlng = new google.maps.LatLng(initialLat, initialLong);
    var options = {zoom: 16, center: latlng,  mapTypeId: google.maps.MapTypeId.ROADMAP,disableDefaultUI: true };
    map = new google.maps.Map(document.getElementById(slot.geomap_book), options);
    geocoder = new google.maps.Geocoder();
    marker = new google.maps.Marker({ map: map, draggable: true, position: latlng});
	google.maps.event.addListener(map, 'click', function(event) {
	  geocoder.geocode({
		'latLng': event.latLng
	  }, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
		  if (results[0]) {
			map.setCenter(results[0].geometry.location);
			$('input[name="slot_address"]').val(results[0].formatted_address);
			$('input[name="slot_lat"]').val(marker.getPosition().lat());
			$('input[name="slot_long"]').val(marker.getPosition().lng());
		  }
		}
	  });
	});
}

slot.get_open_request = function(){
    $.ajax({
        type:"POST",
        url :base_url+"account/get_open_order",
        dataType:"json",
        beforeSend:function(){loader.set("body");},
        success:function(res) {
            if(res.status == 1){
                $(".customer-open-requets").html(res.data);
            }
            loader.remove();

        },
        error:function (err) {
            loader.remove();
        }
    });
}

slot.get_pending_order_form = function(){
    if(this.order_id > 0){
        $.ajax({
            type:"POST",
            url :base_url+"account/get_pending_order_form",
            data:{"order_id":slot.order_id},
            dataType:"json",
            beforeSend:function(){loader.set("body");},
            success:function(res) {
                if(res.status == 1){
                    //$(".customer-open-requets").hide();
                    $(".book-pending-order").hide();
                    $(".book-pending-order-details").html(res.data);
                    $(".book-pending-order-details").show();

                    $('input[name="edit_date"]').datepicker({format: 'yyyy-mm-dd',tartDate: "dateToday",autoclose: true});
                    $('input[name="edit_from_time"]').timepicki();
                    $('input[name="edit_to_time"]').timepicki();
                }
                slot.geomap_book_form = "geomap_book_form";
                slot.initialize_edit_book(res.lat, res.long);
                loader.remove();
            },
            error:function (err) {
                loader.remove();
            }
        });
    }else{

    }
}

slot.initialize_edit_book = function() {
    var initialLat = 38.89751299999999;
    var initialLong = -77.036562;
    var latlng = new google.maps.LatLng(initialLat, initialLong);
    var options = {zoom: 16, center: latlng,  mapTypeId: google.maps.MapTypeId.ROADMAP,disableDefaultUI: true };
    map = new google.maps.Map(document.getElementById(slot.geomap_book_form), options);
    geocoder = new google.maps.Geocoder();
    marker = new google.maps.Marker({ map: map, draggable: true, position: latlng});
}

$(document).on("click",".activity-accelerate",function(){
    var $obj = $(this);
    if($obj.attr("data-act-id") != ""){
        slot.activity_id = $(this).attr("data-act-id");
        loader.set("body");
        slot.getActivityPartner("");
        $(".activity-parent").hide();
        $(".partner-parent").show();

    }else{
        slot.activity_id = null;
    }
    
});

$(document).on("click",".pending-order-wrapper input[data-partner='get']",function(){
    var $obj = $(this);
    slot.order_id = $obj.parents(".pending-order-wrapper").attr("data-order");
    slot.activity_id = $obj.parents(".pending-order-wrapper").attr("data-activity");
    $("form#acitivty_book_form")[0].reset();
    $(".customer-open-requets").hide();
    $(".book-pending-order").hide();
    $(".book-pending-order-details").hide();
    $(".add-new-request-form").hide();
    slot.get_partner_for_order();
});

slot.get_partner_for_order = function(){
    if(slot.order_id != ""){
        $.ajax({
            type:"POST",
            url:slot.url_id+"apitest/activity/get_partner_for_activity",
            data:{"order_id":slot.order_id,"user_id":slot.user_id,"activity_id":slot.activity_id},
            dataType:"json",
            beforeSend:function() {loader.set("body");},
            success:function(res){
                if(res.Result == 1){
                    var $html   = '<h3 class="mb-3">Select Partner</h3>';
                    $html      += "<div>";
                    $.each(res.partner_list,function(index, element){
                        $html += '<div class="row complete-booking-process mt-4 pointer" data-partner="'+element.partner_id+'">';
                            $html += '<div class="col-sm-3">';
                                $html += '<div class="h6 mb-0"> <img style="max-width:40px;" src="'+slot.url_id+'assets/icons/company.png" /> '+element.partner_name+'</div>';
                            $html += '</div>';
                            $html += '<div class="col-sm-2">';
                                $html += '<span class="text-muted">3 kms</span>';
                            $html += '</div>';
                            $html += '<div class="col-sm-2">';
                                $html += '<div class="text-muted">Florida, CL</div>';
                            $html += '</div>';
                            $html += '<div class="col-sm-3"><div><i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i></div>';
                            $html += '</div>';
                            $html += '<div class="col-sm-2">';
                                $html += '<div class="text-muted"><input type="button" class="btn btn-primary login-form-button py-2 px-4 text-white text-center" value="BOOK" /></div>';
                            $html += '</div>';
                        $html += '</div>';
                        $html += "</div>";
                    });
                    $(".edit_partner_list").html($html);
                    $(".edit_partner_list").show();
                }else{
                    
                }
                loader.remove();
            },
            error:function(err){
               console.log(err);
            }
        });
    }
}

$(document).on("click",".complete-booking-process input[type='button']",function(){
    var $obj = $(this);
    slot.partner_id = $obj.parents(".complete-booking-process").attr("data-partner");
    if(slot.partner_id != "" && slot.order_id){
        $.ajax({
            type:"POST",
            url:slot.url_id+"apitest/activity/add_partner_to_booking",
            data:{"order_id":slot.order_id,"user_id":slot.user_id,"partner_id":slot.partner_id},
            dataType:"json",
            beforeSend:function() {loader.set("body");},
            success:function(res){
                if(res.Result == 1){
                    $(".edit_partner_list").html("");
                    $(".edit_partner_list").hide();
                    $("form#acitivty_book_form")[0].reset();
                    $(".customer-open-requets").show();
                    $(".book-pending-order-details").hide();
                    $(".add-new-request-form").hide();
                    $(".book-pending-order").show();
                }else{
                    
                }
                loader.remove();
            },
            error:function(err){
               console.log(err);
            }
        });
    }else{

    }

});

$(document).on("keyup","#get-partner",function(){
    var $obj = $(this);
    var partner_name = jQuery.trim($obj.val());
    if(slot.activity_id != ""){
        slot.getActivityPartner(partner_name);
    }
});

$(document).on("click",".partner-accelerate",function(){
    var $obj = $(this);
    if($obj.attr("data-partner") != ""){
        slot.partner_id = $obj.attr("data-partner");
        slot.activity_details();
    }
});

$(document).on("click",".book-accelaret",function(){
    $obj = $(this);
    if(slot.activity_id != ""){
        $obj.val("Loading...");
        $.ajax({
            type:"POST",
            url :base_url+"account/booking_form",
            data:{"activity_id":slot.activity_id,"partner_id":slot.partner_id,},
            dataType:"json",
            beforeSend:function(){loader.set("body");},
            success:function(res) {
                if(typeof res.status != "undefined" && res.status == 1){
                    $(".partner-details").hide();
                    $(".book-form").html(res.data);
                    slot.initialize_book();
                    //var dateDisabled = ["2014-5-5", "2014-5-6"];	
                    $('.partner_date').datepicker({
                        format: 'yyyy-mm-dd',
                        startDate: "dateToday",
                        autoclose: true
                    });

                    /* $('input[name="slot_from_time"]').timepicker({interval: 30,dropdown: true, scrollbar: true,dynamic: false,});
                    $('input[name="slot_to_time"]').timepicker({interval: 30, dropdown: true, scrollbar: true,dynamic: false,}); */
                    $('input[name="slot_from_time"]').timepicki();
                    $('input[name="slot_to_time"]').timepicki(); 
                    
                    
                    
                    /* beforeShowDay: function(date){
                            if ($.inArray(date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate(), dateDisabled) !== -1){
                                return;
                            }
                            return false;
                        } */

                    $(".book-form").show();
                    loader.remove();
                }
            },
            error:function (err) {
                loader.remove();
            }
        });
    }
});

$(document).on("change",'.partner_date',function(){
    
});


$(document).on("click","#book_accelarate",function(){
    var $address    = $.trim($('input[name="slot_address"]').val());
    var $lat        = $.trim($('input[name="slot_lat"]').val());
    var $long       = $.trim($('input[name="slot_long"]').val());
    var $date       = $.trim($('input[name="slot_date"]').val());
    var $time       = $.trim($('select[name="slot_time"]').val());

    var $from_time  = $.trim($('input[name="slot_from_time"]').val());
    var $to_time    = $.trim($('input[name="slot_to_time"]').val());
    var $ptid       = $.trim($('select[name="slot_payment_method"]').val());
    var $pet       = $.trim($('select[name="slot_pets"]').val());
    var $slot_service_type = $.trim($('select[name="slot_service_type"]').val());
    var err_flag = true;
    $(".slot_err").each(function(index, el){
        if($.trim($(el).val()) == ""){
            $(el).addClass("error");
            err_flag = false;
        }else{
            $(el).removeClass("error");
        }
    });

    var $date_check = $time != "" || $from_time != "" && $to_time != "";
    if(this.partner_id != "" && this.activity_id != "" && $address != "" && $date != "" &&  $ptid != "" && $date_check && err_flag == true){
        $.ajax({
            type:"POST",
            url :slot.url_id+"apitest/activity/book",
            data:{"activity_id":slot.activity_id,"partner_id":slot.partner_id,"date":$date,"from_time":$from_time,"to_time":$to_time,"user_id":slot.user_id,"slot_id":$time,"payment_method":$ptid,"location":$address,"lat":$lat,"long":$long,"pet_id":$pet,"service_type":$slot_service_type},
            dataType:"json",
            beforeSend:function(){loader.set("body");},
            success:function(res) {
                
                if(typeof res.Result != "undefined" && res.Result == 1){
                    slot.partner_id = null;
                    slot.activity_id = null;
                    $("form#acitivty_book_form")[0].reset();
                }else if(res.Result == 0){
                    alert(res.Message);
                }
                loader.remove();
            },
            error:function (err) {
                loader.remove();
            }
        });
    }else{
        alert("Provide missing details");
    }
});

$(document).on("click","#v-pills-request-tab",function(){
    slot.get_open_request();
});

$(document).on("click",".order-view-accelerate",function(){
    var $obj = $(this);
    var $order_id = $obj.parents(".pending-order-wrapper").attr("data-order");
    if($.trim($order_id) != ""){
        slot.order_id = parseInt($.trim($order_id));
        slot.get_pending_order_form();
    }
});

$(document).on("click","input[name='edit_request']",function(){
    var $obj = $(this);
    slot.order_id = $.trim($(this).attr("data-order"));
    if(slot.order_id != ""){
        var err_flag = true;
        $(".edit_err").each(function(index,element){
            if($(element).val() == ""){
                $(element).addClass("error");
                err_flag = false;
            }else{
                $(element).removeClass("error");
            }
        });
        $new_activity   = $.trim($('input[name="edit_activity_id"]').val());
        slot.activity_id = $new_activity;
        $ptid           = $.trim($('select[name="edit_payment_id"]').val());
        $location       = $.trim($('input[name="edit_address"]').val());
        $lat            = $.trim($('input[name="edit_lat"]').val());
        $long           = $.trim($('input[name="edit_long"]').val());
        $pet_id         = $.trim($('select[name="edit_pets_id"]').val());
        $from_time_se   = $.trim($('input[name="edit_from_time"]').val());
        $to_time_se     = $.trim($('input[name="edit_to_time"]').val());
        $slot_date      = $.trim($('input[name="edit_date"]').val());
        $slot_service_type = $.trim($('input[name="edit_service_type"]').val());
        var $date_check = $from_time_se != "" && $to_time_se != "";

        if($location != "" && $slot_date != "" &&  $ptid != "" && $date_check && err_flag == true){
            $.ajax({
                type:"POST",
                url :slot.url_id+"apitest/activity/edit_book",
                data:{"order_id":slot.order_id,"activity_id":$new_activity,"date":$slot_date,"from_time":$from_time_se,"to_time":$to_time_se,"user_id":slot.user_id,"payment_method":$ptid,"location":$location,"lat":$lat,"long":$long,"pet_id":$pet_id,"service_type":$slot_service_type},
                dataType:"json",
                beforeSend:function(){loader.set("body");},
                success:function(res) {
                    loader.remove();
                    if(typeof res.Result != "undefined" && res.Result == 1){
                        $("form#acitivty_book_form")[0].reset();
                        $(".customer-open-requets").hide();
                        $(".book-pending-order").hide();
                        $(".book-pending-order-details").hide();
                        $(".add-new-request-form").hide();
                        slot.get_partner_for_order();
                    }else if(res.Result == 0){
                        alert(res.Message);
                    }
                    
                },
                error:function (err) {
                    loader.remove();
                }
            });
        }else{
            alert("Provide missing details");
        }


    }else{

    }
});

$(document).on("click","#add_new_request",function(){
    $(".book-pending-order").hide();
    $(".book-pending-order-details").hide();
    $(".add-new-request-form").show();
    slot.geomap_book_form = "geomap_book_new";
    slot.initialize_edit_book();
});

$(document).on("click","#new_book_accelarate",function(){

    var $address    = $.trim($('input[name="new_address"]').val());
    var $lat        = $.trim($('input[name="new_lat"]').val());
    var $long       = $.trim($('input[name="new_long"]').val());
    var $date       = $.trim($('input[name="new_date"]').val());

    var $from_time  = $.trim($('input[name="new_from_time"]').val());
    var $to_time    = $.trim($('input[name="new_to_time"]').val());
    var $ptid       = $.trim($('select[name="new_payment_method"]').val());
    var $pet        = $.trim($('select[name="new_pets"]').val());
    var $slot_service_type = $.trim($('select[name="new_service_type"]').val());
    var $new_activity = $.trim($('select[name="new_activity"]').val());
    
    var err_flag = true;
    $(".new_err").each(function(index,element){
        if($(element).val() == ""){
            $(element).addClass("error");
            err_flag = false;
        }else{
            $(element).removeClass("error");
        }
    });
    var $date_check = $from_time != "" && $to_time != "";
    if($address != "" && $date != "" &&  $ptid != "" && $date_check && err_flag == true){
        $.ajax({
            type:"POST",
            url :slot.url_id+"apitest/activity/book",
            data:{"activity_id":$new_activity,"date":$date,"from_time":$from_time,"to_time":$to_time,"user_id":slot.user_id,"payment_method":$ptid,"location":$address,"lat":$lat,"long":$long,"pet_id":$pet,"service_type":$slot_service_type},
            dataType:"json",
            beforeSend:function(){loader.set("body");},
            success:function(res) {
                if(typeof res.Result != "undefined" && res.Result == 1){
                    slot.partner_id = null;
                    slot.activity_id = null;
                    $("form#acitivty_book_form")[0].reset();
                    slot.get_open_request();
                    $(".book-pending-order").show();
                    $(".book-pending-order-details").hide();
                    $(".add-new-request-form").hide();
                }else if(res.Result == 0){
                    alert(res.Message);
                }
                loader.remove();
            },
            error:function (err) {
                loader.remove();
            }
        });
    }else{
        alert("Provide missing details");
    }
});

slot.get_book_order = function(){
    $.ajax({
        type:"POST",
        url:slot.url_id+"apitest/activity/order_history",
        data:{"user_id":slot.user_id},
        dataType:"json",
        beforeSend:function(){loader.set("body");},
        success:function(res){
            if(res.Result == 1){
                var $html = '<div class="row">';
                $html += '<div class="col-sm-12"><div class="h4 mb-3 book-form-heading">Complate Booking</div></div>';
                $html += '<div class="col-md-6"><div id="datepicker" data-date=""></div></div>';
                var enabledDates = [];
                $.each(res.order_date,function(index,element){
                    enabledDates.push(slot.formatDate(element.order_date));
                    $html += '<div class="col-md-6 mb-3 pending-order-wrapper" data-activity="7" data-order="312"><div class="request-wrap"><div class="request-date paddind10 gray"><div class="d50-block text-left">'+element.order_date+'</div><div class="d50-block text-right">Order ID: '+element.order_id+'</div></div><div class="request-date paddind10 no-border"><span class="request-time gray">'+element.from_time+' - '+element.to_time+' </span><span class="bold500">&nbsp; '+element.activity_name+'</span></div></div></div>';
                });
                $html += '</div>';
                
                $(".book_order_history").show();
                $(".book_order_history").html($html);
                $('#datepicker').attr("data-date",enabledDates.join(", "));
                
                
                $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    multidate: true,
                    beforeShowDay: function (date) {
                        let fullDate = slot.formatDate(date);
                        return enabledDates.indexOf(fullDate) != -1
                    }
                });
            }
            loader.remove();
        },
        error:function(){}
    });
}

slot.formatDate = function(date) {
    var d = new Date(date), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    return [year, month, day].join('-');
}

slot.get_partner_profile = function(){
    $.ajax({
        type:"POST",
        url:base_url+"profile/customer_profile",
        data:{"user_id":slot.user_id},
        dataType:"json",
        beforeSend:function(){loader.set("body");},
        success:function(res){
            if(res.Result == 1){
                var user = res.user_data;
                var $html = '<div class="row">';

                    $html += '<div class="col-sm-4 text-center">';
                        $html += '<div class="mb-3"><img src="'+slot.url_id+user.profile+'" class="img-round-cust" /></div>';
                        $html += '<div class="h6 mb-2 font-weight-bold">'+user.name.toUpperCase()+'</div>';
                        $html += '<div class="mb-3"><i class="fa fa-map-marker theam-color"></i> '+user.city+', '+user.state_code+'</div>';
                        $html += '<div class="mb-3"><input type="button" value="Edit Profile" class="btn btn-primary login-form-button py-2 px-4 text-white"></div>';
                        
                    $html += '</div>';

                    $html += '<div class="col-sm-8">';
                        $html += '<div class="row">';
                            
                            $html += '<div class="col-sm-12 mb-3">User Bio Here User Bio Here User Bio Here User Bio HereUser Bio Here User Bio Here User Bio Here User Bio Here User Bio Here User Bio HereUser Bio Here User Bio Here User Bio Here.';
                            $html += '</div>';

                            $html += '<div class="col-sm-6 mb-3"><h5 class="mb-0">My Pets</h5></div>';
                            $html += '<div class="col-sm-6 mb-3 text-right"><i class="fa fa-plus open-pets-form pointer" style="font-size:24px"></i></div>';

                            $html += '<div class="col-sm-12 mb-3">';
                                var $i=0;
                                $.each(res.pets_data, function(index, pets){
                                    if($i <= 3){
                                        $html += '<div class="pets-profile"><a data-fancybox="images" href="'+slot.url_id+pets.pets_profile+'"><img class="img img-fluid p-2" src="'+slot.url_id+pets.pets_profile+'" /></a><div class="pets-image-name">Gill</div></div>';
                                        $i++;
                                    }
                                });
                                
                            $html += '</div>';  
                            $html += '<div class="col-sm-12">';
                                $html += '<div id="geomap"></div>';
                            $html += '</div>'; 
                        $html += '</div>';
                    $html += '</div>';
                $html += '</div>';
                $(".user-profile-parent").html($html);
                $(".user-profile-parent").show();
            }
            loader.remove();
        },
        error:function(){}
    });
}

$('#v-pills-order-tab').on('shown.bs.tab', function(){
    slot.get_book_order();
});

$("#v-pills-profile-tab").on("shown.bs.tab",function(){
    slot.get_partner_profile();
});

$(document).on("click",".open-pets-form",function(){
    $(".user-profile-parent").hide();
    $(".add-pets-form").show();
});

$(document).on("change","select[name='pets_type']",function(){
    $obj = $(this);
    if($.trim($obj.val())){
        $.ajax({
            type:"POST",
            url:base_url+"account/get_breed",
            data:{"pets_type":$obj.val()},
            dataType:"json",
            beforeSend:function(res){loader.set("body");},
            success:function(res){
                if(res.status == 1){
                    $("select[name='breed_type']").html(res.data);                 
                }else{

                }
                loader.remove();
            },
            error:function(){}
        });
    }else{

    }
});

$(document).on("click","#add_pets_accelerate",function(){
    var $obj = $(this);
    var err_flag = true;
    $(".pets_err").each(function(index, ele){
        if($(ele).val() == ""){
            err_flag = false;
            $(ele).addClass("error");
        }else{
            $(ele).removeClass("error");
        }
    });
    
    $file = $("#pets_file");
    if(typeof $file[0] != "undefined"){
        $profile = $file[0].files[0];
    }else{
        $profile = "";
    }
    
    if(err_flag){
        var formdata = new FormData();
        formdata.append("user_id",slot.user_id);
        formdata.append("name",$.trim($("input[name='pets_name']").val()));
        formdata.append("pet_type",$.trim($("select[name='pets_type']").val()));
        formdata.append("breed",$.trim($("select[name='breed_type']").val()));
        formdata.append("age",$.trim($("select[name='pets_age']").val()));
        formdata.append("weight",$.trim($("select[name='pets_weight']").val()));
        formdata.append("profile",$profile);
        $.ajax({
            type:"POST",
            url:slot.url_id+"apitest/pets/add",
            data:formdata,
            cache:false,
            contentType: false,
            processData: false,
            dataType:"json",
            beforeSend:function(){loader.set("body");},
            success:function(res){
                if(res.Result == 1){
                    $("form#acitivty_book_form")[0].reset();
                    $(".add-pets-form").hide();
                    $(".user-profile-parent").show();
                }else{
                    alert(res.Message);
                }

            },
            error:function(err){console.log(err);}
        });
    }else{
        alert("Fill missing parametars");
    }
});