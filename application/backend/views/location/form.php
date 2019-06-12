<?php 
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header);
?>
<style>
.remove-image-wp{display: inline-block; width: 40px; position: relative;}
.remove-image-wp label{color: #FFF; background: #000000cc; opacity: 0; position: absolute; top: 0; left: 0; text-align: center; width: 100%; height: 100%;   padding: 0%; border-radius: 50%; text-shadow: 1px 1px 1px #000; zoom: 1.5; cursor:pointer;}
.remove-image-wp label:hover{opacity: 0.8; border:2px solid #FFF;}
#geomap{ width: 100%; height: 400px;}
</style>
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Location</a></li>
				<li class="breadcrumb-item active">Add</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Add Location<!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
			
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                <div class="mb-4" id="geomap"></div>
                <?php
				$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', "autocomplete"=>"off", 'name' => 'frm_add',"method"=>"post");
				echo form_open_multipart('location/process', $attributes);
					echo form_input(array('type' => 'hidden', 'name' => 'hid_id','id' => 'hid_id' ,'value' => @$rsEdit->id));
				?>
                    
                    
                    <div class="form-group">
                        <label for="search_location" class="col-form-label col-sm-3">Address</label> 
                        <div class="col-sm-6">
                        	<input type="text" name="address" value="<?php echo @$rsEdit->address; ?>" id="search_location" autocomplete="false" class="form-control required" placeholder="i.e Enter pickup address">
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="lat" class="col-form-label col-sm-3">Latitude</label> 
                        <div class="col-sm-6">
                        	<input type="text" name="lat" id="lat" value="<?php echo @$rsEdit->lat; ?>" class="form-control required search_latitude" placeholder="i.e Enter">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="long" class="col-form-label col-sm-3">Longitude</label> 
                        <div class="col-sm-6">
                        	<input type="text" name="long" value="<?php echo @$rsEdit->long; ?>" class="form-control required search_longitude" placeholder="i.e Enter longitude">
                        </div>
                    </div>
                    
                    
                    
                    <div class="form-group m-b-0">
                        <label class="col-form-label col-sm-3"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success width-xs">Submit</button>
                            <button type="button" class="btn btn-success width-xs" onclick="window.history.go(-1);">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtCb2Pn0IVPkyDrg0HHzRK98joxHgNgiA&callback=initialize" type="text/javascript"> console.log(google); </script>-->
<?php 
$assets_header['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script><script src="'.base_url('assets/plugins/drag-upload/dist/bs-custom-file-input.min.js').'"></script><script src="'.base_url('assets/js/demo.min.js').'"></script><script src="'.base_url('assets/js/apps.min.js').'"></script><script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyAOrnFPCKruyje0NvuFMkBEB17L_JHUnyM"></script>';
$this->load->view('bottom',$assets_header); ?>

<script>
var media = [];
document.addEventListener('DOMContentLoaded', function() {
	bsCustomFileInput.init()
});
var code_error = true;
$(document).ready(function(e) {
	$("#category_id").selectpicker("render");
	$("#price_type").selectpicker("render");
});
$(document).on("click","button[type=submit]",function(){
	var error_lable = true;
	$form = $(this).parents("form");
	if($('.bootstrap-select.required').length > 0) $('.bootstrap-select.required').removeClass('required');
	$form.find(".required").each(function(index, element) {
        if($(element).val() == ""){
			error_lable = false;
			$(element).addClass("parsley-error");
		}else{
			if(element.name == 'email' && !(/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test($(element).val()))){
				$(element).addClass('parsley-error');
				error_lable = false;
			}else{
				$(element).removeClass('parsley-error');
			}
		}
    });
	if(!code_error){
		error_lable = false;
		$("#email").addClass("parsley-error");
	}else{
		$("#email").removeClass("parsley-error");
	}
	return error_lable && code_error;
});

var geocoder;
var map;
var marker;
function initialize() {
    var initialLat = $('.search_latitude').val();
    var initialLong = $('.search_longitude').val();
    initialLat = initialLat?initialLat:33.1860308;
    initialLong = initialLong?initialLong:-87.27489220000001;
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
    google.maps.event.addListener(marker, "dragend", function () {
        var point = marker.getPosition();
        map.panTo(point);
        geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $('.search_addr').val(results[0].formatted_address);
                $('.search_latitude').val(marker.getPosition().lat());
                $('.search_longitude').val(marker.getPosition().lng());
            }
        });
    });
}
initialize();
$(document).ready(function () {
    initialize();
    var PostCodeid = '#search_location';
    $(function () {
        $(PostCodeid).autocomplete({
            source: function (request, response) {
                geocoder.geocode({
                    'address': request.term
                }, function (results, status) {
                    response($.map(results, function (item) {
                        return {
                            label: item.formatted_address,
                            value: item.formatted_address,
                            lat: item.geometry.location.lat(),
                            lon: item.geometry.location.lng()
                        };
                    }));
                });
            },
            select: function (event, ui) {
                $('.search_addr').val(ui.item.value);
                $('.search_latitude').val(ui.item.lat);
                $('.search_longitude').val(ui.item.lon);
                var latlng = new google.maps.LatLng(ui.item.lat, ui.item.lon);
                marker.setPosition(latlng);
                initialize();
            }
        });
    });
    
    $('.get_map').click(function (e) {
        var address = $(PostCodeid).val();
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $('.search_addr').val(results[0].formatted_address);
                $('.search_latitude').val(marker.getPosition().lat());
                $('.search_longitude').val(marker.getPosition().lng());
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
        e.preventDefault();
    });

    google.maps.event.addListener(marker, 'drag', function () {
        geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('.search_addr').val(results[0].formatted_address);
                    $('.search_latitude').val(marker.getPosition().lat());
                    $('.search_longitude').val(marker.getPosition().lng());
                }
            }
        });
    });
});


</script>