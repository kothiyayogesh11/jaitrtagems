$(document).ready(function(){    
    if( !$('.js-site-navbar').hasClass('scrolled'))
    $('.js-site-navbar').addClass('scrolled');
    if( !$('.js-site-navbar').hasClass('awake'))
    $('.js-site-navbar').addClass('awake');
});
var curLat;
var curLong = null;

/* Slot Booking */
var slot = {}
slot.user_id = $("input[name='site_user_key']").val();
slot.url_id = $("input[name='site_url_key']").val();
slot.customer_id = null;
slot.activity_id = null;
slot.order_id = null;


slot.geocoder;
slot.map;
slot.marker;
slot.geomap_book = "geomap_book";
slot.geomap_book_form = "geomap_book_form";

/* Get Partner Schedule */
slot.get_schedule = function(){
    if(this.user_id != null && this.user_id.length > 0){

    }else{

    }
}
$("#v-pills-schedule-tab").on("shown.bs.tab",function(){
    slot.get_schedule();
});

$(document).ready(function(e){
    slot.get_schedule();
});

$(document).on("click","#save-schedule",function(){
    var dataPost = {};
    dataPost.date = $('#available_datepicker').data('date');
    dataPost.availability = $("input[name='available']:checked").val();
    if(dataPost.date != ""){
        $.ajax({
            type:"POST",
            url:slot.url_id+"apitest/partner/partner_schedule",
            data:{"user_id":slot.user_id,"availability":dataPost.availability,"date":dataPost.date},
            dataType:"json",
            beforeSend:function(){loader.set("body")},
            success:function(res){
                slot.set_time();
                loader.remove();
            },
            error:function(){loader.remove();}
        });
    }
});

$(document).on("change","input[name=main_availability]",function(){
    var availability = $(this).is(":checked") == true ? '1' : '0';
    var date = $('#available_datepicker').data('date');
    if(availability!=""){
        $.ajax({
            type:"POST",
            url:slot.url_id+"apitest/partner/set_partner_availibility",
            data:{"user_id":slot.user_id,"availability":availability},
            dataType:"json",
            beforeSend:function(){loader.set("body")},
            success:function(res){
                slot.set_time();
                loader.remove();
            },
            error:function(){loader.remove();}
        });
    }
});

slot.set_time = function(){
    var availability = $(this).is(":checked") == true ? 1 : 0;
    var from_time = $("#from_time").val();
    var to_time = $("#to_time").val();
    var date = $('#available_datepicker').data('date');
    if(from_time != "" && to_time != ""){
        $.ajax({
            type:"POST",
            url:slot.url_id+"apitest/partner/set_availibility_time",
            data:{"user_id":slot.user_id,"availability":availability,"from_time":from_time,"to_time":to_time,"date":date},
            dataType:"json",
            beforeSend:function(){loader.set("body")},
            success:function(res){
                loader.remove();
            },
            error:function(){loader.remove();}
        });
    }
}

$(function () {
    $('#from_time').datetimepicker({
        format: 'LT',
        ignoreReadonly:true
    });

    $('#to_time').datetimepicker({
        format: 'LT',
        ignoreReadonly:true
    });
    $("#from_time").val($("#from_time").attr("data-time"));
    $("#to_time").val($("#to_time").attr("data-time"));

    $('#available_datepicker').datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function(e) {
        $('#available_datepicker').data("date",e.format());
        $(".request-date .date-div-title").text(e.format());
        slot.get_schedule(e.format());
    });
});




slot.get_schedule = function(date){
    console.log(date);
    if(typeof date != "undefined" && date != ""){
        $.ajax({
            type:"POST",
            url:base_url+"account/get_schedule",
            data:{"date":date},
            dataType:"json",
            beforeSend:function(){loader.set("body")},
            success:function(res){
                if(res.status == 1){
                    if(typeof res.data.partner_availability.is_available != "undefined" && res.data.partner_availability.is_available == 1){
                        $('input[name="main_availability"]').prop("checked",true);
                    }else{
                        $('input[name="main_availability"]').prop("checked",false);
                    }
                    if(typeof res.data.partner_availability != "undefined"){
                        $("#from_time").val(res.data.partner_availability.from_time);
                        $("#to_time").val(res.data.partner_availability.to_time);
                    }
                    if(typeof res.data.partner_schedule.available_date != "undefined" && res.data.partner_schedule.available_date != "")
                    $(".request-date .date-div-title").text(res.data.partner_schedule.available_date);

                    if(typeof res.data.partner_schedule != "undefined" && res.data.partner_schedule.available == 1){
                        $("#availabel-on").prop("checked",true);
                    }else{
                        $("#availabel-off").prop("checked",true);
                    }
                }
                loader.remove();
            },
            error:function(){loader.remove();}
        })
    }
}

$(document).on("click",".add-service",function(){
    $.ajax({
        type:"POST",
        url:base_url+"account/get_unadded_service",
        dataType:"json",
        beforeSend:function(){loader.set("body")},
        success:function(res){
            if(res.result == 1){
                $('select[name="activity_main"]').html(res.data);
                $("#addServiceModal").modal({backdrop: 'static', keyboard: false,show: true});
            }else{
                alert(res.message);
            }
            loader.remove();
        },
        error:function(res){
            loader.remove();
        }
    });
    
});

$(document).on("click",".edit-activity",function(){
    $activity_id = $(this).parents('div.activity-block').attr('data-activity');
    if(typeof $activity_id != "undefined" && $activity_id != ""){
        $.ajax({
            type:"POST",
            url:base_url+"partner/get_activity_details_by_id",
            data:{"activity_id":$activity_id},
            dataType:"json",
            beforeSend:function(){loader.set("body");$("#addServiceModal").modal("hide");},
            success:function(res){
                if(res.result == 1){
                    $("#editServiceModal .edit-main-activity").attr("data-activity-id",$activity_id);
                    $(".edit-act-name").text(res.data.activity.activity_title);
                    $('#editServiceModal textarea[name="comment"]').val(res.data.activity.description);
                    $('#editServiceModal input[name="activity_rate"]').val(res.data.activity.price);
                    $("#editServiceModal").modal({backdrop: 'static', keyboard: false,show: true});
                }else{
                    $("#editServiceModal .edit-main-activity").attr("data-activity-id","");
                    alert(res.Message);
                }
                loader.remove();
            },
            error:function(err){
                loader.remove();
            }
        });
    }
    
});

$(document).on("click","#editServiceModal .edit-main-activity",function(){
    $activity_id = $(this).attr("data-activity-id");
    $description = $('#editServiceModal textarea[name="comment"]').val();
    $rate = $('#editServiceModal input[name="activity_rate"]').val();
    if($activity_id != ""){
        $.ajax({
            type:"POST",
            url:base_url+"partner/get_activity_details_by_id",
            data:{"activity_id":$activity_id},
            dataType:"json",
            beforeSend:function(){loader.set("body");},
            success:function(res){
                if(res.result == 1){
                    $("#editServiceModal .edit-main-activity").attr("data-activity-id","");
                    $("#editServiceModal").modal({backdrop: 'static', keyboard: false,show: true});
                }else{
                    alert(res.Message);
                }
                loader.remove();
            },
            error:function(err){
                loader.remove();
            }
        });
    }
});

$(document).on("click",".add-sub-activity",function(){
    $activity = $("select[name='activity_category']").val();
    $sub_activity = $("input[name='sub_activity']").val();
    $comment = $("textarea[name='comment']").val();
    $sub_activity_rate = $("input[name='sub_activity_rate']").val();
    $activity_duration = $("select[name='activity_duration']").val();

    if($activity != ""){
        $.ajax({
            type:"POST",
            url:slot.url_id+"apitest/subservice/add",
            data:{"activity_id":$activity,"partner_id":slot.user_id,"service_name":$sub_activity,"price":$sub_activity_rate,"duration":$activity_duration,"description":$comment},
            dataType:"json",
            beforeSend:function(){loader.set("body");$("#addServiceModal").modal("hide");},
            success:function(res){
                if(res.Result == 0){
                    $("#addServiceModal").modal("show");
                    $("form#partner_order_form")[0].reset();
                    alert(res.Message);
                }
                loader.remove();
            },
            error:function(err){
                loader.remove();
            }
        });
    }
});

$(document).on('keypress',"input[name='sub_activity_rate'], input[name='activity_rate']",function(e){
	var regex = new RegExp("^[0-9.]+$");
	console.log(e.which);
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
	console.log(str);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});

slot.get_sub_service = function(){
    /* if(slot.user_id != ""){
        $.ajax({
            type:"POST",
            url:api_url+"subservice/add",
            data:{"partner_id":slot.user_id},
            dataType:"json",
            beforeSend:function(){loader.set("body");},
            success:function(res){
                if(res.Result == 0){
                    
                    alert(res.Message);
                }
                loader.remove();
            },
            error:function(err){
                loader.remove();
            }
        });
    } */
}

$("#v-pills-profile-tab").on("shown.bs.tab",function(){
    slot.get_sub_service();
});