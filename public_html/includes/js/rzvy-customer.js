/*
* rzvy
* Online Multi Business Appointment Scheduling & Reservation Booking Calendar
*/

var rzvy_sun = generalObj.sun; var rzvy_mon = generalObj.mon; var rzvy_tue = generalObj.tue; var rzvy_wed = generalObj.wed; var rzvy_thu = generalObj.thu; var rzvy_fri = generalObj.fri; var rzvy_sat = generalObj.sat;

var rzvy_su = generalObj.su; var rzvy_mo = generalObj.mo; var rzvy_tu = generalObj.tu; var rzvy_we = generalObj.we; var rzvy_th = generalObj.th; var rzvy_fr = generalObj.fr; var rzvy_sa = generalObj.sa;

var rzvy_sunday = generalObj.sunday; var rzvy_monday = generalObj.monday; var rzvy_tuesday = generalObj.tuesday; var rzvy_wednesday = generalObj.wednesday; var rzvy_thursday = generalObj.thursday; var rzvy_friday = generalObj.friday; var rzvy_saturday = generalObj.saturday;

var rzvy_january = generalObj.january; var rzvy_february = generalObj.february; var rzvy_march = generalObj.march; var rzvy_april = generalObj.april; var rzvy_may = generalObj.may; var rzvy_june = generalObj.june; var rzvy_july = generalObj.july; var rzvy_august = generalObj.august; var rzvy_september = generalObj.september; var rzvy_october = generalObj.october; var rzvy_november = generalObj.november; var rzvy_december = generalObj.december; 

var rzvy_jan = generalObj.jan; var rzvy_feb = generalObj.feb; var rzvy_mar = generalObj.mar; var rzvy_apr = generalObj.apr; var rzvy_mays = generalObj.mays; var rzvy_jun = generalObj.jun; var rzvy_jul = generalObj.jul; var rzvy_aug = generalObj.aug; var rzvy_sep = generalObj.sep; var rzvy_oct = generalObj.oct; var rzvy_nov = generalObj.nov; var rzvy_dec = generalObj.dec; 

moment.defineLocale('en', {
	months : [ rzvy_january,rzvy_february,rzvy_march,rzvy_april,rzvy_may,rzvy_june,rzvy_july,rzvy_august,rzvy_september,rzvy_october,rzvy_november,rzvy_december ],
	monthsShort:[ rzvy_jan,rzvy_feb,rzvy_mar,rzvy_apr,rzvy_mays,rzvy_jun,rzvy_jul,rzvy_aug,rzvy_sep,rzvy_oct,rzvy_nov,rzvy_dec ],
	weekdays:[rzvy_sunday,rzvy_monday,rzvy_tuesday,rzvy_wednesday,rzvy_thursday,rzvy_friday,rzvy_saturday],
	weekdaysShort:[rzvy_sun,rzvy_mon,rzvy_tue,rzvy_wed,rzvy_thu,rzvy_fri,rzvy_sat],
	weekdaysMin:[rzvy_su,rzvy_mo,rzvy_tu,rzvy_we,rzvy_th,rzvy_fr,rzvy_sa],
});


/** Initialization on ready state JS **/
$(document).ready(function () {
	var ajaxurl = generalObj.ajax_url;
	var site_url = generalObj.site_url;
	
	/** JS to add intltel input to phone number **/
	$("#rzvy_profile_phone").intlTelInput({
		initialCountry: generalObj.defaultCountryCode,
		separateDialCode: true,
		utilsScript: site_url+"includes/vendor/intl-tel-input/js/utils.js",
    });
	/** Calendar JS **/
    var curdate = generalObj.current_date;
	$('#rzvy-appointments-calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,listMonth,listYear'
		},
		buttonText: {
			today: generalObj.today,
			month: generalObj.calendar_view,
			listMonth: generalObj.month_list_view,
			listYear: generalObj.year_list_view,
		},
		defaultView: "month",
		locale:'en',
		defaultDate: curdate,
		editable: false,
		refetch: false,
		firstDay: 1,
		eventLimit: 6,
		eventTextColor: "#FFF",
		events: ajaxurl + 'rzvy_my_appointments_ajax.php',
		eventRender: function (event, element) {
			element.attr('href', 'javascript:void(0);');
			element.find('.fc-title').hide();
			element.find('.fc-time').hide();
			element.find('.fc-title').before(
				$("<div class='rzvy-fc-title'>"+event.event_icon+" <span>"+event.event_status+"</span></div><hr class='rzvy-hr' />")
			);
			element.find('.fc-title').after(
				$("<div class='rzvy-fc-title'>" + event.cat_name + "</div><div class='rzvy-fc-title'>" + event.title + "</div><div class='rzvy-fc-title'>" + event.customer_email + "</div><div class='rzvy-fc-title'>" + event.customer_phone + "</div><hr class='rzvy-hr' /><div class='rzvy-fc-title'>" + event.rating + "</div>")
			);
            element.css('padding', "5px");
			element.click(function () {
				$.ajax({
					type: 'post',
					data: {
						'order_id': event.id,
						'get_appointment_detail': 1
					},
					url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
					success: function (res) {
						$('.rzvy_appointment_detail_modal_body').html(res);
						$('#rzvy_appointment_detail_modal').modal('show');
						$('.rzvy_appointment_detail_link').trigger('click');
					}
				});
			});
		}
	});
	
	/** Validation patterns **/
	$.validator.addMethod("pattern_name", function(value, element) {
		return this.optional(element) || /^[a-zA-Z '.']+$/.test(value);
	}, generalObj.please_enter_only_alphabets);
	$.validator.addMethod("pattern_price", function(value, element) {
		return this.optional(element) || /^[0-9]\d*(\.\d{1,2})?$/.test(value);
	}, generalObj.please_enter_only_numerics);
	$.validator.addMethod("pattern_phone", function(value, element) {
		return this.optional(element) || /\d+(?:[ -]*\d+)*$/.test(value);
	}, generalObj.please_enter_valid_phone_number_without_country_code);
	$.validator.addMethod("pattern_zip", function(value, element) {
		return this.optional(element) || /^[a-zA-Z 0-9\-]*$/.test(value);
	}, generalObj.please_enter_valid_zip);
	
	/** DataTable JS **/
	$("#rzvy_support_ticket_list_table").DataTable({
		bPaginate: $('#rzvy_support_ticket_list_table tbody tr').length>10,
		aoColumns: [
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: false }
		] 
	});
	$('#rzvy_refund_request_list_table').DataTable( {
		bPaginate: $('#rzvy_refund_request_list_table tbody tr').length>10,
		aoColumns: [
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true }
		]
    } ); 
	$('#rzvy_customer_referrals_list_table').DataTable( {
		bPaginate: $('#rzvy_customer_referrals_list_table tbody tr').length>10,
		aoColumns: [
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true }
		]
    } ); 
    $('#rzvy_recieved_loyalty_points_table').DataTable( {
		stripeClasses: [ 'rzvy_datatable_strip', "" ],
		processing: true,
        serverSide: true,
        ajax: {
			dataSrc: "data",
            type: "POST",
			processData: true,
			url: ajaxurl + "rzvy_customer_ajax.php?refresh_recieved_loyalty_points"
        }
    } ); 
    $('#rzvy_used_loyalty_points_table').DataTable( {
		stripeClasses: [ 'rzvy_datatable_strip', "" ],
		processing: true,
        serverSide: true,
        ajax: {
			dataSrc: "data",
            type: "POST",
			processData: true,
			url: ajaxurl + "rzvy_customer_ajax.php?refresh_used_loyalty_points"
        }
    } ); 
});

/** image upload js */
function rzvy_read_uploaded_file_url(input) {
	var files = input.files[0];
	var done = function(url){
		$('#rzvy_cropped_image_preview').attr('src',url);
		$('#rzvy_image_crop_modal').modal('show');
	};
	if(files){
		if((files.size/1000) > 1000){
				swal(generalObj.opps, generalObj.maximum_file_upload_size_1_mb, "error");
			}else if(files.type =="image/jpeg" || files.type =="image/jpg" || files.type =="image/png"){
				var reader = new FileReader();
				reader.onload = function(e){
					done(e.target.result);
				};
				reader.readAsDataURL(files);
				$('#rzvy_image_section').val('add');				
			}else{
			swal(generalObj.opps, generalObj.please_select_a_valid_image_file, "error");
		}
	}
}
$(document).on('change', "#rzvy-image-upload-file", function() {
    rzvy_read_uploaded_file_url(this);
});

/** Tab view js */
$(document).on('click', '.rzvy_tab_view_nav_link', function(){
	var tabNo = $(this).data('tabno');
	$('.custom-nav-item').removeClass('active');
	$(".custom-nav-item:eq("+tabNo+")").addClass("active");
});

/** Appointment detail tab content **/
$(document).on('click', '.rzvy_appointment_detail_link', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	$.ajax({
		type: 'post',
		data: {
			'order_id': id,
			'appointment_detail_tab': 1
		},
		url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('#rzvy_appointment_detail').html(res);
			$('#rzvy_appointment_detail').show();
			$('#rzvy_payment_detail').hide();
			$('#rzvy_customer_detail').hide();
			$('#rzvy_reschedule_appointment').hide();
			$('#rzvy_reject_appointment').hide();
			$('#rzvy_feedback_appointment').hide();
		}
	});
});

/** Payment detail tab content **/
$(document).on('click', '.rzvy_payment_detail_link', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	$.ajax({
		type: 'post',
		data: {
			'order_id': id,
			'payment_detail_tab': 1
		},
		url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('#rzvy_payment_detail').html(res);
			$('#rzvy_appointment_detail').hide();
			$('#rzvy_payment_detail').show();
			$('#rzvy_customer_detail').hide();
			$('#rzvy_reschedule_appointment').hide();
			$('#rzvy_reject_appointment').hide();
			$('#rzvy_feedback_appointment').hide();
		}
	});
});

/** Customer detail tab content **/
$(document).on('click', '.rzvy_customer_detail_link', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	$.ajax({
		type: 'post',
		data: {
			'order_id': id,
			'customer_detail_tab': 1
		},
		url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('#rzvy_customer_detail').html(res);
			$('#rzvy_appointment_detail').hide();
			$('#rzvy_payment_detail').hide();
			$('#rzvy_customer_detail').show();
			$('#rzvy_reschedule_appointment').hide();
			$('#rzvy_reject_appointment').hide();
			$('#rzvy_feedback_appointment').hide();
		}
	});
});

/** Reschedule Appointment detail tab content **/
$(document).on('click', '.rzvy_reschedule_appointment_link', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	$.ajax({
		type: 'post',
		data: {
			'order_id': id,
			'rzvy_reschedule_appointment_tab': 1
		},
		url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('#rzvy_reschedule_appointment').html(res);
			$('#rzvy_appointment_detail').hide();
			$('#rzvy_payment_detail').hide();
			$('#rzvy_customer_detail').hide();
			$('#rzvy_reschedule_appointment').show();
			$('#rzvy_reject_appointment').hide();
			$('#rzvy_feedback_appointment').hide();
			$("#rzvy_appt_rs_date").trigger("change");
		}
	});
});

/** Reject Appointment detail tab content **/
$(document).on('click', '.rzvy_reject_appointment_link', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	$.ajax({
		type: 'post',
		data: {
			'order_id': id,
			'rzvy_reject_appointment_tab': 1
		},
		url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('#rzvy_reject_appointment').html(res);
			$('#rzvy_appointment_detail').hide();
			$('#rzvy_payment_detail').hide();
			$('#rzvy_customer_detail').hide();
			$('#rzvy_reschedule_appointment').hide();
			$('#rzvy_reject_appointment').show();
			$('#rzvy_feedback_appointment').hide();
		}
	});
});

/** On date change get slots **/
$(document).on('change', '#rzvy_appt_rs_date', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var datetime = $(this).data('datetime');
	var oid = $(this).data('oid');
	var selected_date = $(this).val();
	var service_id = $("#rzvy_appt_rs_sid").val();
	var staff_id = $("#rzvy_appt_rs_staffid").val();
	$.ajax({
		type: 'post',
		data: {
			'order_id': oid,
			'booking_datetime': datetime,
			'selected_date': selected_date,
			'service_id': service_id,
			'staff_id': staff_id,
			'rzvy_slots_on_date_change': 1
		},
		url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('.rzvy_appt_rs_timeslot').html(res);
			$('.rzvy_appt_rs_endtimeslot').html("");
			$('.rzvy_appt_rs_timeslot option:first').trigger("change");
		}
	});
});

/** Reschedule Appointment JS **/
$(document).on('click', '.rzvy_appt_rs_now_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	var date = $("#rzvy_appt_rs_date").val();
	var slot = $(".rzvy_appt_rs_timeslot").val();
	var endslot = $(".rzvy_appt_rs_endtimeslot").val();
	var reason = $("#rzvy_appt_rs_reason").val();
	if(date != "" && slot != "" && slot !== null && endslot != "" && endslot !== null){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'order_id': id,
				'date': date,
				'slot': slot,
				'endslot': endslot,
				'reason': reason,
				'reschedule_appointment_detail': 1
			},
			url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="updated"){
					$('.rzvy_confirm_appointment_link').parent().removeClass('rzvy-hide');
					$('.rzvy_pending_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_reschedule_appointment_link').parent().removeClass('rzvy-hide');
					$('.rzvy_reject_appointment_link').parent().removeClass('rzvy-hide');
					$('.rzvy_complete_appointment_link').parent().removeClass('rzvy-hide');
					$('#rzvy-appointments-calendar').fullCalendar('refetchEvents');
					$('.rzvy_appointment_detail_link').trigger('click');
					swal(generalObj.rescheduled, generalObj.appointment_rescheduled_successfully, "success");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Reject Appointment JS **/
$(document).on('click', '.rzvy_appt_reject_now_btn', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	var dl = $(this).data('dl');
	var reason = $("#rzvy_appt_reject_reason").val();
	$.ajax({
		type: 'post',
		data: {
			'order_id': id,
			'reason': reason,
			'reject_customerappointment_detail': 1
		},
		url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			if(res=="updated"){
			    if(dl!==undefined && dl=='Y'){
			        swal(generalObj.cancelled, generalObj.appointment_cancelled_successfully, "success");
					 window.location.reload();
				}else{
    				$('.rzvy_confirm_appointment_link').parent().addClass('rzvy-hide');
    				$('.rzvy_pending_appointment_link').parent().addClass('rzvy-hide');
    				$('.rzvy_reschedule_appointment_link').parent().addClass('rzvy-hide');
    				$('.rzvy_reject_appointment_link').parent().addClass('rzvy-hide');
    				$('.rzvy_complete_appointment_link').parent().addClass('rzvy-hide');
    				$('.rzvy_feedback_appointment_link').parent().removeClass('rzvy-hide');
    				$('#rzvy-appointments-calendar').fullCalendar('refetchEvents');
    				$('.rzvy_appointment_detail_link').trigger('click');
    				swal(generalObj.cancelled, generalObj.appointment_cancelled_successfully, "success");
				}
			}else{
				swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
			}
		}
	});
});

/** Change Password JS **/
$(document).on('click', '.rzvy_change_password_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	/** Validate change password form **/
	$('#rzvy_change_password_form').validate({
		rules: {
			rzvy_old_password:{ required: true, minlength: 8, maxlength: 20 },
			rzvy_new_password: { required:true, minlength: 8, maxlength: 20 },
			rzvy_rtype_password: { required:true, equalTo: "#rzvy_new_password", minlength: 8, maxlength: 20 }
		},
		messages: {
			rzvy_old_password:{ required: generalObj.please_enter_old_password, minlength: generalObj.please_enter_minimum_8_characters, maxlength: generalObj.please_enter_maximum_20_characters },
			rzvy_new_password: { required: generalObj.please_enter_new_password, minlength: generalObj.please_enter_minimum_8_characters, maxlength: generalObj.please_enter_maximum_20_characters },
			rzvy_rtype_password: { required: generalObj.please_enter_retype_new_password, equalTo: generalObj.new_password_and_retype_new_password_mismatch, minlength: generalObj.please_enter_minimum_8_characters, maxlength: generalObj.please_enter_maximum_20_characters }
		}
	});
	if($("#rzvy_change_password_form").valid()){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		var id = $(this).data('id');
		var old_password = $("#rzvy_old_password").val();
		var new_password = $("#rzvy_rtype_password").val();
		$.ajax({
			type: 'post',
			data: {
				'customer_id': id,
				'old_password': old_password,
				'new_password': new_password,
				'change_customer_password': 1
			},
			url: ajaxurl + "rzvy_customer_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="changed"){
					$("#rzvy_old_password").val("");
					$("#rzvy_new_password").val("");
					$("#rzvy_rtype_password").val("");
					$("#rzvy-change-password-modal").modal("hide");
					swal(generalObj.changed, generalObj.your_password_changed_successfully, "success");
				}else if(res=="wrong"){
					swal(generalObj.opps, generalObj.incorrect_old_password, "error");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Update Profile JS **/
$(document).on('click', '.rzvy_update_profile_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var uploaded_file = $("#rzvy-image-upload-file-hidden").val();
	var firstname = $("#rzvy_profile_firstname").val();
	var lastname = $("#rzvy_profile_lastname").val();
	var phone = $("#rzvy_profile_phone").intlTelInput("getNumber");
	var address = $("#rzvy_profile_address").val();
	var city = $("#rzvy_profile_city").val();
	var state = $("#rzvy_profile_state").val();
	var zip = $("#rzvy_profile_zip").val();
	var country = $("#rzvy_profile_country").val();
	var dob = $("#rzvy_profile_dob").val();
	var id = $("#rzvy-profile-admin-id-hidden").val();
	
	/** Validate update Profile form **/
	$('#rzvy_profile_form').validate({
		rules: {
			rzvy_profile_firstname:{ required: true, maxlength: 50 },
			rzvy_profile_lastname: { required:true, maxlength: 50 },
			rzvy_profile_phone: { required:true, minlength: 10, maxlength: 15, pattern_phone:true },
			rzvy_profile_address: { required:true },
			rzvy_profile_city: { required:true },
			rzvy_profile_state: { required:true},
			rzvy_profile_zip: { required:true, pattern_zip:true, minlength: 5, maxlength: 10 },
			rzvy_profile_country: { required:true }
		},
		messages: {
			rzvy_profile_firstname:{ required: generalObj.please_enter_first_name, maxlength: generalObj.please_enter_maximum_50_characters },
			rzvy_profile_lastname: { required: generalObj.please_enter_last_name, maxlength: generalObj.please_enter_maximum_50_characters },
			rzvy_profile_phone: { required: generalObj.please_enter_phone_number, minlength: generalObj.please_enter_minimum_10_digits, maxlength: generalObj.please_enter_maximum_15_digits },
			rzvy_profile_address: { required: generalObj.please_enter_address },
			rzvy_profile_city: { required: generalObj.please_enter_city },
			rzvy_profile_state: { required: generalObj.please_enter_state },
			rzvy_profile_zip: { required: generalObj.please_enter_zip, minlength: generalObj.please_enter_minimum_5_characters, maxlength: generalObj.please_enter_maximum_10_characters },
			rzvy_profile_country: { required: generalObj.please_enter_country }
		}
	});
	
	if($("#rzvy_profile_form").valid()){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'uploaded_file': uploaded_file,
				'firstname': firstname,
				'lastname': lastname,
				'phone': phone,
				'address': address,
				'city': city,
				'state': state,
				'zip': zip,
				'country': country,
				'dob': dob,
				'id': id,
				'update_profile': 1
			},
			url: ajaxurl + "rzvy_customer_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="updated"){
					swal(generalObj.updated, generalObj.your_profile_updated_successfully, "success");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** support ticket discussion JS **/
(function () {
    var rzvy_support_ticket_object;
    rzvy_support_ticket_object = function (arg) {
        this.text = arg.text, this.rzvy_support_ticket_reply_side = arg.rzvy_support_ticket_reply_side;
        this.draw = function (_this) {
            return function () {
                var $message;
                $message = $($('.rzvy_support_ticket_reply_template').clone().html());
                $message.addClass(_this.rzvy_support_ticket_reply_side).find('.rzvy_support_ticket_reply_wrapper_content').html(_this.text);
				
                $('.rzvy_support_ticket_reply_list').append($message);
                return setTimeout(function () {
                    return $message.addClass('rzvy_show_support_ticket_reply');
                }, 0);
            };
        }(this);
        return this;
    };
    $(function () {
        var rzvy_get_support_ticket_reply, rzvy_support_ticket_reply_side, rzvy_send_support_ticket_reply;
        rzvy_support_ticket_reply_side = 'rzvy_show_support_ticket_on_right';
        rzvy_get_support_ticket_reply = function () {
            var $rzvy_support_ticket_reply_input;
            $rzvy_support_ticket_reply_input = $('.rzvy_support_ticket_reply_input');
            return $rzvy_support_ticket_reply_input.val();
        };
        rzvy_send_support_ticket_reply = function (text, ticket_id) {
            var $rzvy_support_ticket_reply_list, message;
            if (text.trim() === '') {
                return;
            }
			
			/** Add ticket discussion reply JS start */
			var ajaxurl = generalObj.ajax_url;
			$.ajax({
				type: 'post',
				data: {
					'reply': text,
					'ticket_id': ticket_id,
					'add_ticket_discussion_reply': 1
				},
				url: ajaxurl + "rzvy_customer_support_ticket_discussions_ajax.php",
				success: function (res) { 
				}
			});
			/** Add ticket discussion reply JS end */
			
            $('.rzvy_support_ticket_reply_input').val('');
            $rzvy_support_ticket_reply_list = $('.rzvy_support_ticket_reply_list');
            rzvy_support_ticket_reply_side = 'rzvy_show_support_ticket_on_right';
            message = new rzvy_support_ticket_object({
                text: text,
                rzvy_support_ticket_reply_side: rzvy_support_ticket_reply_side
            });
            message.draw();
			$(".rzvy_remove_empty_discussion_li").remove();
            return $rzvy_support_ticket_reply_list.animate({ scrollTop: $rzvy_support_ticket_reply_list.prop('scrollHeight') }, 300);		
        };
        $('.rzvy_support_ticket_send_reply_btndiv').click(function (e) {
			var ticket_id = $(this).data("id");
            return rzvy_send_support_ticket_reply(rzvy_get_support_ticket_reply(), ticket_id);
        });
        $('.rzvy_support_ticket_reply_input').keyup(function (e) {
            if (e.which === 13) {
                var ticket_id = $(this).data("id");
				return rzvy_send_support_ticket_reply(rzvy_get_support_ticket_reply(), ticket_id);
            }
        });
    });
}.call(this));

/** Generate support ticket JS **/
$(document).on('click', '#rzvy_generate_support_ticket_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	/** Validate generate support ticket form **/
	$('#rzvy_generate_support_ticket_form').validate({
		rules: {
			rzvy_tickettitle:{ required: true },
			rzvy_ticketdescription:{ required: true }
		},
		messages: {
			rzvy_tickettitle:{ required: generalObj.please_enter_ticket_title },
			rzvy_ticketdescription:{ required: generalObj.please_enter_ticket_description }
		}
	});
	if($('#rzvy_generate_support_ticket_form').valid()){
		var title = $("#rzvy_tickettitle").val();
		var description = $("#rzvy_ticketdescription").val();
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'ticket_title': title,
				'description': description,
				'generate_support_ticket': 1
			},
			url: ajaxurl + "rzvy_customer_support_tickets_ajax.php",
			success: function (res) {
				$("#rzvy-generate-ticket-modal").modal("hide");
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="added"){
					swal(generalObj.added, generalObj.support_ticket_generated_successfully, "success");
					location.reload();
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Update support ticket JS **/
$(document).on('click', '#rzvy_update_support_ticket_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	/** Validate update support ticket form **/
	$('#rzvy_update_support_ticket_form').validate({
		rules: {
			rzvy_update_tickettitle:{ required: true },
			rzvy_update_ticketdescription:{ required: true }
		},
		messages: {
			rzvy_update_tickettitle:{ required: generalObj.please_enter_ticket_title },
			rzvy_update_ticketdescription:{ required: generalObj.please_enter_ticket_description }
		}
	});
	if($('#rzvy_update_support_ticket_form').valid()){
		var id = $(this).data("id");
		var title = $("#rzvy_update_tickettitle").val();
		var description = $("#rzvy_update_ticketdescription").val();
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'ticket_title': title,
				'description': description,
				'update_support_ticket': 1
			},
			url: ajaxurl + "rzvy_customer_support_tickets_ajax.php",
			success: function (res) {
				$("#rzvy-update-ticket-modal").modal("hide");
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="updated"){
					swal(generalObj.updated, generalObj.support_ticket_updated_successfully, "success");
					location.reload();
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Update support ticket modal detail JS **/
$(document).on('click', '.rzvy-update-supportticketmodal', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data("id");
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'update_supportticket_modal_detail': 1
		},
		url: ajaxurl + "rzvy_customer_support_tickets_ajax.php",
		success: function (res) {
			$(".rzvy-update-ticket-modal-body").html(res);
			$("#rzvy-update-ticket-modal").modal("show");
			$("#rzvy_update_support_ticket_btn").attr("data-id",id);
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
		}
	});
});

/** Mark as read all support ticket reply modal detail JS **/
$(document).on('click', '.markasread_all_support_ticket_reply', function(){
	var site_url = generalObj.site_url;
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data("id");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'markasread_all_support_ticket_reply': 1
		},
		url: ajaxurl + "rzvy_customer_support_tickets_ajax.php",
		success: function (res) {
			window.location.href = site_url+'backend/c-ticket-discussion.php?tid='+id;
		}
	});
});

/** Delete support ticket JS **/
$(document).on('click', '.rzvy_delete_support_ticket_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure,
	  text: generalObj.you_want_to_delete_this_support_ticket,
	  type: "error",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: generalObj.yes_delete_it,
	  closeOnConfirm: false
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'delete_support_ticket': 1
			},
			url: ajaxurl + "rzvy_customer_support_tickets_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="deleted"){
					swal(generalObj.deleted, generalObj.support_ticket_deleted_successfully, "success");
					location.reload();
				}else if(res=="replyexist"){
					swal(generalObj.opps, generalObj.you_cannot_delete_this_support_ticket_You_have_discussion_on_this_support_ticket, "error");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});

/** Mark support ticket as completed JS **/
$(document).on('click', '.rzvy_markascomplete_support_ticket_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure,
	  text: generalObj.you_want_to_mark_this_support_ticket_as_complete,
	  type: "error",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: generalObj.yes_mark_it,
	  closeOnConfirm: false
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'markascomplete_support_ticket': 1
			},
			url: ajaxurl + "rzvy_customer_support_tickets_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="updated"){
					swal(generalObj.marked_as_completed, generalObj.support_ticket_marked_as_completed_successfully, "success");
					location.reload();
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});

/** Logout JS **/
$(document).on('click','#rzvy_logout_btn',function(){
	var ajax_url = generalObj.ajax_url;
	var site_url = generalObj.site_url;
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	$.ajax({
		type: 'post',
		data: {
			'logout_process': 1
		},
		url: ajax_url + "rzvy_login_ajax.php",
		success: function (res) {
			window.location = site_url+"backend";
		}
	});
});

/** Change Profile email JS **/
$(document).on('click', '#rzvy_change_profile_email_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	/** Validate Change Email form **/
	$('#rzvy_change_profile_email_form').validate({
		rules: {
			rzvy_change_profile_email:{ required: true, email: true }
		},
		messages: {
			rzvy_change_profile_email:{ required: generalObj.please_enter_email, email: generalObj.please_enter_valid_email }
		}
	});
	if($("#rzvy_change_profile_email_form").valid()){
		var email = $("#rzvy_change_profile_email").val();
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'email': email,
				'change_email': 1
			},
			url: ajaxurl + "rzvy_customer_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="updated"){
					swal(generalObj.changed, generalObj.your_email_changed_successfully, "success");
					location.reload();
				}else if(res=="exist"){
					swal(generalObj.exist, generalObj.email_already_exist_please_try_to_update_with_not_registered_email, "error");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Prevent enter key stroke on form inputs **/
$(document).on("keydown", '.rzvy form input', function (e) {
	if (e.keyCode == 13) {
		e.preventDefault();
		return false;
	}
});

/** Rating & Review Appointment detail tab content **/
$(document).on('click', '.rzvy_feedback_appointment_link', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	$.ajax({
		type: 'post',
		data: {
			'order_id': id,
			'rzvy_feedback_appointment_tab': 1
		},
		url: ajaxurl + "rzvy_my_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('#rzvy_feedback_appointment').html(res);
			$('#rzvy_appointment_detail').hide();
			$('#rzvy_payment_detail').hide();
			$('#rzvy_customer_detail').hide();
			$('#rzvy_reschedule_appointment').hide();
			$('#rzvy_reject_appointment').hide();
			$('#rzvy_feedback_appointment').show();
		}
	});
});

/** JS to mark rating stars **/
function rzvy_add_star_rating(ths,sno){
	for (var i=1;i<=5;i++){
		var cur=document.getElementById("rzvy-sidebar-feedback-star"+i)
		cur.className="fa fa-star-o rzvy-sidebar-feedback-star"
	}

	for (var i=1;i<=sno;i++){
		var cur=document.getElementById("rzvy-sidebar-feedback-star"+i)
		if(cur.className=="fa fa-star-o rzvy-sidebar-feedback-star")
		{
			cur.className="fa fa-star rzvy-sidebar-feedback-star rzvy-sidebar-feedback-star-checked"
		}
	}
	$("#rzvy_fb_rating").val(sno);
}

/** JS to submit feedback **/
$(document).on("click", ".rzvy_submit_feedback_btn", function(){
	var ajax_url = generalObj.ajax_url;
	
	/** validate feedback form **/
	$('#rzvy_feedback_form').validate({
		rules: {
			rzvy_fb_name:{ required: true },
			rzvy_fb_email: { required:true, email:true },
			rzvy_fb_review: { required:true }
		},
		messages: {
			rzvy_fb_name:{ required: generalObj.please_enter_name },
			rzvy_fb_email: { required: generalObj.please_enter_email, email: generalObj.please_enter_valid_email },
			rzvy_fb_review: { required: generalObj.please_enter_review }
		}
	});
	
	if($('#rzvy_feedback_form').valid()){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		var order_id = $(this).data("id");
		var review = $("#rzvy_fb_review").val();
		var rating = $("#rzvy_fb_rating").val();
		var dl = $(this).data("dl");
		$.ajax({
			type: 'post',
			data: {
				'order_id': order_id,
				'review': review,
				'rating': rating,
				'add_feedback': 1
			},
			url: ajax_url + "rzvy_my_appointment_detail_ajax.php",
			success: function (res) {
				if(res=="added"){
					swal(generalObj.submitted_your_review_submitted_successfully, "", "success");
					if(dl!==undefined && dl=='Y'){
					    window.location.reload();
					}else{
    					$('#rzvy-appointments-calendar').fullCalendar('refetchEvents');
    					$('.rzvy_feedback_appointment_link').trigger('click');
					}
				}else{
					$(".rzvy_main_loader").addClass("rzvy_hide_loader");
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
				
			}
		});
	}
});

$(document).on('keyup', '#referral_social_share_input', function(){
	var content = $(this).val();
	if(content != ""){
	    $(".err_referral_share_message").hide();
		$(".rzvy_fb_share").attr("href", "http://www.facebook.com/sharer.php?u="+generalObj.site_url+"&quote="+content);
		$(".rzvy_twitter_share").attr("href", "http://twitter.com/share?url="+generalObj.site_url+"&hashtags=referral_code&text="+content);
		$(".rzvy_whatssapp_share").attr("href", "https://wa.me/?text="+content);
		$(".rzvy_gplus_share").attr("href", "https://plus.google.com/share?url="+generalObj.site_url+"&prefilltext="+content);
	}else{
	    $(".err_referral_share_message").show();
		$(".rzvy_fb_share").attr("href", "javascript:void(0)");
		$(".rzvy_twitter_share").attr("href", "javascript:void(0)");
		$(".rzvy_whatssapp_share").attr("href", "javascript:void(0)");
		$(".rzvy_gplus_share").attr("href", "javascript:void(0)");
	}
});
var rzvy_pageurl = window.location.pathname;
if(rzvy_pageurl.indexOf("backend/refer.php") != -1){
	document.getElementById("rzvy_copyto_clipboard").addEventListener("click", function() {
		copyToClipboard(document.getElementById("referral_social_share_input"));
	});
	document.getElementById("rzvy_copyto_clipboard_code").addEventListener("click", function() {
		copyToClipboard(document.getElementById("rzvy_copyto_clipboard_code_input"));
	});
}
function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}

/* Image Cropping Start */
var $rzvy_image_crop_modal = $('#rzvy_image_crop_modal');
var rzvy_croppreview_image = document.getElementById('rzvy_cropped_image_preview');
var cropper;
$rzvy_image_crop_modal.on('shown.bs.modal', function() {
	var rzvy_croping_type = generalObj.rzvy_croping_type;
	cropper = new Cropper(rzvy_croppreview_image, {
		aspectRatio: rzvy_croping_type,
		viewMode: 1,
	});
}).on('hidden.bs.modal', function(){
	cropper.destroy();
	cropper = null;
});
/* Round Cropping */
function rzvy_getRoundedCanvas(sourceCanvas) {
  var canvas = document.createElement('canvas');
  var context = canvas.getContext('2d');
  var width = sourceCanvas.width;
  var height = sourceCanvas.height;

  canvas.width = width;
  canvas.height = height;
  context.imageSmoothingEnabled = true;
  context.drawImage(sourceCanvas, 0, 0, width, height);
  context.globalCompositeOperation = 'destination-in';
  context.beginPath();
  context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
  context.fill();
  return canvas;
}
/* Save Crop */
$(document).on('click','#rzvy_crop_btn',function(){
	var rzvyimage_type = generalObj.rzvy_image_type;
	canvas = cropper.getCroppedCanvas({
		width:400,
		height:400
	});
	if(rzvyimage_type=='rounded-circle'){
		canvas = rzvy_getRoundedCanvas(canvas);	
	}
	canvas.toBlob(function(blob){
		url = URL.createObjectURL(blob);
		var reader = new FileReader();
		reader.readAsDataURL(blob);
		reader.onloadend = function(){
			var rzvy_cropimg = reader.result;			
			$('#rzvy-image-upload-file-hidden').val(rzvy_cropimg);
			$('#rzvy-image-upload-file-preview').css('background-image', 'url('+rzvy_cropimg+')');
			$('#rzvy-image-upload-file-preview').hide();
			$('#rzvy-image-upload-file-preview').fadeIn(650);
							
			$('#rzvy_image_crop_modal').modal('hide');
		};
	});
});