/*
* rzvy
* Online Multi Business Appointment Scheduling & Reservation Booking Calendar
*/
var rzvy_stripe;
var rzvy_stripe_plan_card;

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
	$("#rzvy_profile_phone, #rzvy_mprof_phone, #rzvy_company_phone").intlTelInput({
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
		eventDrop: function(event, delta, revertFunc) {
			var selected_date = event.start.format().substring(0, 10);
			var selected_datetime = event.start.format().substring(0, 10) + " " + event.start.format().substring(11, 19);
			var d =  new Date(selected_date);
			var tdate = new Date();
			tdate.setDate(tdate.getDate() - 1);
			var curr_date = d.getDate();
			var curr_month = d.getMonth()+1;
			var curr_year = d.getFullYear();
			if(d > tdate){			
				swal({
					title: generalObj.reschedule_reason_ad,
					text: "<textarea class='form-control fullwidth' id='rs_appointment_reason' placeholder='"+generalObj.enter_reschedule_reason+"'></textarea>",
					html: true,
					showCancelButton: true,
					closeOnConfirm: false
				}, function (isRescheduled) {
					if (isRescheduled) {
						$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
						var rs_reason = $("#rs_appointment_reason").val();
						$.ajax({
							type: 'post',
							data: {
								'selected_datetime': selected_datetime,
								'order_id': event.id,
								'reason': rs_reason,
								'update_dragged_appointment': 1
							},
							url: ajaxurl + "rzvy_appointment_detail_ajax.php",
							success: function (res) {
								$(".rzvy_main_loader").addClass("rzvy_hide_loader");
								if(res=="updated"){
									$('#rzvy-appointments-calendar').fullCalendar('refetchEvents');
									swal(generalObj.rescheduled, generalObj.appointment_rescheduled_successfully, "success");
								}else{
									swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
								}
							}
						});
					}else{
						revertFunc();
					}
				});
			} else {
				swal(generalObj.opps, generalObj.you_can_not_book_on_previous_date, "error");
				revertFunc();
			}
		},
		refetch: false,
		firstDay: 1,
		eventLimit: 6,
		eventTextColor: "#FFF",
		events: ajaxurl + 'rzvy_staff_appointments_ajax.php',
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
					url: ajaxurl + "rzvy_appointment_detail_ajax.php",
					success: function (res) {
						$('.rzvy_delete_appt_btn').attr('data-id', event.id);
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
	
	$.validator.addMethod("timeGreaterThan", function(value, element, params) {
		var stt = new Date("January 1, 2021 " + value);
		stt = stt.getTime();

		var endt = new Date("January 1, 2021 " + $(params).val());
		endt = endt.getTime();
		
		if(stt > endt) {
			return false;
		}else{
			return true;
		}
	}, generalObj.please_select_start_time_less_than_end_time);
	
	$.validator.addMethod("timeEqualTo", function(value, element, params) {
		var stt = new Date("January 1, 2021 " + value);
		stt = stt.getTime();

		var endt = new Date("January 1, 2021 " + $(params).val());
		endt = endt.getTime();
		
		if(stt == endt) {
			return false;
		}else{
			return true;
		}
	}, generalObj.please_select_start_time_less_than_end_time);
	
	/** Manage categories & services local session **/
	var site_url = generalObj.site_url;
	var rzvy_pageurl = window.location.pathname;
	
	if(rzvy_pageurl.indexOf("backend/staff") != -1){
		$('#rzvy-staff-list li:first').trigger("click");
	}
	
	
	$("#rzvy_advanceschedule_list_table").DataTable({
		"order": [ 0, 'desc' ],
		bPaginate: $('#rzvy_advanceschedule_list_table tbody tr').length>10,
		aoColumns: [
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: false }
		] 
	});
	
	$("#rzvy_advanceschedule_daysoff_list_table").DataTable({
		"order": [ 0, 'desc' ],
		bPaginate: $('#rzvy_advanceschedule_daysoff_list_table tbody tr').length>10,
		aoColumns: [
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: false }
		] 
	});
	
	$("#rzvy_advanceschedule_breaks_list_table").DataTable({
		"order": [ 0, 'desc' ],
		bPaginate: $('#rzvy_advanceschedule_breaks_list_table tbody tr').length>10,
		aoColumns: [
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: true },
			{ bSortable: false }
		] 
	});
	
	/* Appointments List View DataTable */
	$('#rzvy_appt_list_table thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#rzvy_appt_list_table thead');
		
	$("#rzvy_appt_list_table").DataTable({		
		"order": [ 0, 'desc' ],
		bPaginate: $('#rzvy_appt_list_table tbody tr').length>10,
		orderCellsTop: true,
        fixedHeader: true,
		dom: 'Bfrtip',
        buttons: [
            'print'
        ],
		initComplete: function () {
            var api = this.api();
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})';
 
                            var cursorPosition = this.selectionStart;
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
	});
});

/** Validation JS **/
$(document).ajaxComplete( function(){
	var site_url = generalObj.site_url;
	/** JS to add intltel input to phone number **/
	$("#rzvy_staff_phone").intlTelInput({
		initialCountry: generalObj.defaultCountryCode,
		separateDialCode: true,
		utilsScript: site_url+"includes/vendor/intl-tel-input/js/utils.js",
	});
	$(".rzvy_staff_starttime_dropdown, .rzvy_staff_endtime_dropdown").selectpicker();
	$('#rzvy_staffdaysoff_list_table').DataTable().destroy();
	$("#rzvy_staffdaysoff_list_table").DataTable({
		stripeClasses: [ 'rzvy_datatable_strip', "" ]
	});
});

$(document).bind('ready ajaxComplete',function(){
	$(".rzvy_assign_staff, .rzvy_assign_addonlag").selectpicker();
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
/** image upload js */
function rzvy_update_read_uploaded_file_url(input) {
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
				$('#rzvy_image_section').val('update');
			}else{
			swal(generalObj.opps, generalObj.please_select_a_valid_image_file, "error");
		}
	}	
}
$(document).on('change', "#rzvy-update-image-upload-file", function() {
    rzvy_update_read_uploaded_file_url(this);
});
function rzvy_second_read_uploaded_file_url(input) {
    if (input.files && input.files[0]) {
		if((input.files[0].size/1000) > 1000){
			swal(generalObj.opps, generalObj.maximum_file_upload_size_1_mb, "error");
		}else if(input.files[0].type =="image/jpeg" || input.files[0].type =="image/jpg" || input.files[0].type =="image/png"){
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#rzvy_seo_og_tag_image-hidden').val(e.target.result);
				$('#rzvy_seo_og_tag_image-preview').css('background-image', 'url('+e.target.result +')');
				$('#rzvy_seo_og_tag_image-preview').hide();
				$('#rzvy_seo_og_tag_image-preview').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
		}else{
			swal(generalObj.opps, generalObj.please_select_a_valid_image_file, "error");
		}
    }
}
$(document).on('change', "#rzvy_seo_og_tag_image", function() {
    rzvy_second_read_uploaded_file_url(this);
});

function rzvy_third_read_uploaded_file_url(input) {
    if (input.files && input.files[0]) {
		if((input.files[0].size/1000) > 1000){
			swal(generalObj.opps, generalObj.maximum_file_upload_size_1_mb, "error");
		}else if(input.files[0].type =="image/jpeg" || input.files[0].type =="image/jpg" || input.files[0].type =="image/png"){
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#rzvy_bookingform_bg_image-hidden').val(e.target.result);
				$('#rzvy_bookingform_bg_image-preview').css('background-image', 'url('+e.target.result +')');
				$('#rzvy_bookingform_bg_image-preview').hide();
				$('#rzvy_bookingform_bg_image-preview').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
		}else{
			swal(generalObj.opps, generalObj.please_select_a_valid_image_file, "error");
		}
    }
}

$(document).on('change', "#rzvy_bookingform_bg_image", function() {
    rzvy_third_read_uploaded_file_url(this);
});
/** Tab view js */
$(document).on('click', '.rzvy_tab_view_nav_link', function(){
	var tabNo = $(this).data('tabno');
	$('.custom-nav-item').removeClass('active');
	$(".custom-nav-item:eq("+tabNo+")").addClass("active");
});

/** Change Schedule status JS **/
$(document).on('change', '.rzvy_change_schedule_status', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	var schedule_offday_check = $(this).prop('checked');
	var schedule_offday_text = generalObj.marked_as_offday;
	var schedule_offday = 'Y';
	if(schedule_offday_check){
		schedule_offday_text = generalObj.marked_as_working_day;
		schedule_offday = 'N';
	}
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'offday': schedule_offday,
			'change_schedule_offday': 1
		},
		url: ajaxurl + "rzvy_schedule_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			if(res=="changed"){
				swal(schedule_offday_text+"!", schedule_offday_text+' '+generalObj.successfully, "success");
			}else{
				swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
			}
		}
	});
});

/** Change Schedule start time JS **/
$(document).on('changed.bs.select', 'select.rzvy_starttime_dropdown', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	var db_starttime = $(".rzvy_starttime_dropdown_hidden_"+id).val();
	var starttime = $(this).val();
	var position = $('option:selected', this).data('position');
	var endtime_position = $('#rzvy_endtime_dropdown_'+id+' option:selected').data('position');
	if(endtime_position>position){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'starttime': starttime,
				'update_schedule_starttime': 1
			},
			url: ajaxurl + "rzvy_schedule_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="updated"){
					$(".rzvy_starttime_dropdown_hidden_"+id).val(starttime);
					swal(generalObj.updated, generalObj.schedule_start_time_updated_successfully, "success");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}else{
		$("#rzvy_starttime_dropdown_"+id).val(db_starttime);
		$("#rzvy_starttime_dropdown_"+id).selectpicker("refresh");
		swal(generalObj.opps, generalObj.please_select_start_time_less_than_end_time, "error");
	}
});

/** Change Schedule end time JS **/
$(document).on('changed.bs.select', 'select.rzvy_endtime_dropdown', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	var endtime = $(this).val();
	var db_endtime = $(".rzvy_endtime_dropdown_hidden_"+id).val();
	var position = $('option:selected', this).data('position');
	var starttime_position = $('#rzvy_starttime_dropdown_'+id+' option:selected').data('position');
	if(starttime_position<position){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'endtime': endtime,
				'update_schedule_endtime': 1
			},
			url: ajaxurl + "rzvy_schedule_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="updated"){
					$(".rzvy_endtime_dropdown_hidden_"+id).val(starttime);
					swal(generalObj.updated, generalObj.schedule_end_time_updated_successfully, "success");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}else{
		$("#rzvy_endtime_dropdown_"+id).val(db_endtime);
		$("#rzvy_endtime_dropdown_"+id).selectpicker("refresh");
		swal(generalObj.opps, generalObj.please_select_end_time_greater_than_start_time, "error");
	}
});

/** Registered Customer appointments modal JS **/
$(document).on('click', '.rzvy_customer_appointments_btn', function(){
	$('#rzvy_customer_appointments_listing').DataTable().destroy();
	$('#rzvy_customer_appointments_listing tbody').empty();
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	var ctype = $(this).data('ctype');
	$('#rzvy_customer_appointment_modal').modal('show');
	$('#rzvy_customer_appointments_listing').DataTable( {
		stripeClasses: [ 'rzvy_datatable_strip', "" ],
		processing: true,
        serverSide: true,
        ajax: {
			dataSrc: "data",
            type: "POST",
			processData: true,
			url: ajaxurl + "rzvy_customer_appointments_ajax.php?refresh_appt_detail&c_id="+id+"&ctype="+ctype
        }
    } );
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
		url: ajaxurl + "rzvy_appointment_detail_ajax.php",
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
		url: ajaxurl + "rzvy_appointment_detail_ajax.php",
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
		url: ajaxurl + "rzvy_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('#rzvy_customer_detail').html(res);
			$('#rzvy_appointment_detail').hide();
			$('#rzvy_payment_detail').hide();
			$('#rzvy_feedback_appointment').hide();
			$('#rzvy_customer_detail').show();
			$('#rzvy_reschedule_appointment').hide();
			$('#rzvy_reject_appointment').hide();
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
		url: ajaxurl + "rzvy_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('#rzvy_reschedule_appointment').html(res);
			$('#rzvy_appointment_detail').hide();
			$('#rzvy_payment_detail').hide();
			$('#rzvy_customer_detail').hide();
			$('#rzvy_reschedule_appointment').show();
			$('#rzvy_reject_appointment').hide();
			$('#rzvy_feedback_appointment').hide();
			if($(".rzvy_appt_rs_timeslot").hasClass("endslot_selection_exist")){
				$(".rzvy_appt_rs_timeslot").trigger("change");
			}
		}
	});
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
		url: ajaxurl + "rzvy_appointment_detail_ajax.php",
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
		url: ajaxurl + "rzvy_appointment_detail_ajax.php",
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

/** Confirm Appointment JS **/
$(document).on('click', '.rzvy_confirm_appointment_link', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure,
	  text: generalObj.you_want_to_confirm_this_appointment,
	  type: "success",
	  showCancelButton: true,
	  confirmButtonClass: "btn-primary",
	  confirmButtonText: generalObj.yes_confirm_it,
	  cancelButtonText: generalObj.cancel,
	  closeOnConfirm: false
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'order_id': id,
				'confirm_appointment': 1
			},
			url: ajaxurl + "rzvy_appointment_detail_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="confirmed"){
					$('.rzvy_confirm_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_pending_appointment_link').parent().removeClass('rzvy-hide');
					$('.rzvy_reschedule_appointment_link').parent().removeClass('rzvy-hide');
					$('.rzvy_reject_appointment_link').parent().removeClass('rzvy-hide');
					$('.rzvy_complete_appointment_link').parent().removeClass('rzvy-hide');
					$('#rzvy-appointments-calendar').fullCalendar('refetchEvents');
					$('.rzvy_appointment_detail_link').trigger('click');
					swal(generalObj.confirmed, generalObj.appointment_confirmed_successfully, "success");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});

/** Mark as Pending Appointment JS **/
$(document).on('click', '.rzvy_pending_appointment_link', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure,
	  text: generalObj.you_want_to_mark_this_appointment_as_pending,
	  type: "success",
	  showCancelButton: true,
	  confirmButtonClass: "btn-warning",
	  confirmButtonText: generalObj.yes_mark_as_pending,
	  cancelButtonText: generalObj.cancel,
	  closeOnConfirm: false
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'order_id': id,
				'mark_as_pending_appointment': 1
			},
			url: ajaxurl + "rzvy_appointment_detail_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="pending"){
					$('.rzvy_confirm_appointment_link').parent().removeClass('rzvy-hide');
					$('.rzvy_pending_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_reschedule_appointment_link').parent().removeClass('rzvy-hide');
					$('.rzvy_reject_appointment_link').parent().removeClass('rzvy-hide');
					$('.rzvy_complete_appointment_link').parent().removeClass('rzvy-hide');
					$('#rzvy-appointments-calendar').fullCalendar('refetchEvents');
					$('.rzvy_appointment_detail_link').trigger('click');
					swal(generalObj.marked_as_pending, generalObj.appointment_marked_as_pending_successfully, "success");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});

/** Mark as Complete Appointment JS **/
$(document).on('click', '.rzvy_complete_appointment_link', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure,
	  text: generalObj.you_want_to_mark_this_appointment_as_complete,
	  type: "success",
	  showCancelButton: true,
	  confirmButtonClass: "btn-primary",
	  confirmButtonText: generalObj.yes_mark_as_completed,
	  cancelButtonText: generalObj.cancel,
	  closeOnConfirm: false
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'order_id': id,
				'mark_as_completed_appointment': 1
			},
			url: ajaxurl + "rzvy_appointment_detail_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="completed"){
					$('.rzvy_confirm_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_pending_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_reschedule_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_reject_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_complete_appointment_link').parent().addClass('rzvy-hide');
					$('#rzvy-appointments-calendar').fullCalendar('refetchEvents');
					$('.rzvy_appointment_detail_link').trigger('click');
					swal(generalObj.marked_as_completed, generalObj.appointment_marked_as_completed_successfully, "success");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});

/** On date change get slots **/
$(document).on('change', '#rzvy_appt_rs_date', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var oid = $(this).data('oid');
	var datetime = $(this).data('datetime');
	var selected_date = $(this).val();
	var service_id = $("#rzvy_appt_rs_sid").val();
	var staff_id = $("#rzvy_appt_rs_staff option:selected").val();
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
		url: ajaxurl + "rzvy_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$('.rzvy_appt_rs_timeslot').html(res);
			$('.rzvy_appt_rs_endtimeslot').html("");
			$('.rzvy_appt_rs_timeslot option:first').trigger("change");
		}
	});
});
/** Change endslot on startslot selection JS **/
$(document).on('change', '.rzvy_appt_rs_timeslot', function(){
	var ajaxurl = generalObj.ajax_url;
	var datetime = $("#rzvy_appt_rs_date").data('datetime');
	var service_id = $("#rzvy_appt_rs_sid").val();
	var selected_date = $("#rzvy_appt_rs_date").val();
	var selected_startslot = $(this).val();
	var staff_id = $("#rzvy_appt_rs_staff option:selected").val();
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	if(generalObj.endslot_status == "Y"){
		$.ajax({
			type: 'post',
			data: {
				'booking_datetime': datetime,
				'service_id': service_id,
				'staff_id': staff_id,
				'selected_date': selected_date,
				'selected_startslot': selected_startslot,
				'get_endtimeslots': 1
			},
			url: ajaxurl + "rzvy_appointment_detail_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				$(".rzvy_appt_rs_endtimeslot").html(res);
			}
		});
	}else{
		$.ajax({
			type: 'post',
			data: {
				'booking_datetime': datetime,
				'service_id': service_id,
				'staff_id': staff_id,
				'selected_date': selected_date,
				'selected_startslot': selected_startslot,
				'get_without_endtimeslots': 1
			},
			url: ajaxurl + "rzvy_appointment_detail_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				$(".rzvy_appt_rs_endtimeslot").val(res);
			}
		});
	}
});

/** Reschedule Appointment JS **/
$(document).on('click', '.rzvy_appt_rs_now_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	var date = $("#rzvy_appt_rs_date").val();
	var slot = $(".rzvy_appt_rs_timeslot").val();
	var endslot = $(".rzvy_appt_rs_endtimeslot").val();
	var reason = $("#rzvy_appt_rs_reason").val();
	var staff_id = $("#rzvy_appt_rs_staff option:selected").val();
	if(date != "" && slot != "" && slot !== null && endslot != "" && endslot !== null){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'order_id': id,
				'date': date,
				'slot': slot,
				'staff_id': staff_id,
				'endslot': endslot,
				'reason': reason,
				'reschedule_appointment_detail': 1
			},
			url: ajaxurl + "rzvy_appointment_detail_ajax.php",
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
	var reason = $("#rzvy_appt_reject_reason").val();
	$.ajax({
		type: 'post',
		data: {
			'order_id': id,
			'reason': reason,
			'reject_appointment_detail': 1
		},
		url: ajaxurl + "rzvy_appointment_detail_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			if(res=="updated"){
				$('.rzvy_confirm_appointment_link').parent().addClass('rzvy-hide');
				$('.rzvy_pending_appointment_link').parent().addClass('rzvy-hide');
				$('.rzvy_reschedule_appointment_link').parent().addClass('rzvy-hide');
				$('.rzvy_reject_appointment_link').parent().addClass('rzvy-hide');
				$('.rzvy_complete_appointment_link').parent().addClass('rzvy-hide');
				$('#rzvy-appointments-calendar').fullCalendar('refetchEvents');
				$('.rzvy_appointment_detail_link').trigger('click');
				swal(generalObj.rejected, generalObj.appointment_rejected_successfully, "success");
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
		var old_password = $("#rzvy_old_password").val();
		var new_password = $("#rzvy_rtype_password").val();

		$.ajax({
			type: 'post',
			data: {
				'old_password': old_password,
				'new_password': new_password,
				'change_staff_password': 1
			},
			url: ajaxurl + "rzvy_staff_ajax.php",
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

/** Prevent enter key stroke on form inputs **/
$(document).on("keydown", '.rzvy form input', function (e) {
	if (e.keyCode == 13) {
		e.preventDefault();
		return false;
	}
});

/** STAFF Module JS START **/
$(document).on('click', ".rzvy_uncheckall_services_btn", function() {
	$(".rzvy-cat-services").prop("checked", false);
});

/** Get Staff detail card content */
$(document).on('click', ".rzvy-staff-selection", function() {
	var ajaxurl = generalObj.ajax_url;
	$(".rzvy-staff-selection").removeClass("active");
	$(this).addClass("active");
	var id = $(this).data('id');
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'staff_detail_card': 1
		},
		url: ajaxurl + "rzvy_staff_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$("#rzvy-staff-detail-card").html(res);
			$("#rzvy_staff_detail_tab_selection").trigger("click");
		}
	});
});

/** Get Staff detail tab content */
$(document).on('click', "#rzvy_staff_detail_tab_selection", function() {
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'staff_detail_tab': 1
		},
		url: ajaxurl + "rzvy_staff_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$("#rzvy-staff-tab-content").html(res);
		}
	});
});

/** Get Staff services tab content */
$(document).on('click', "#rzvy_staff_services_tab_selection", function() {
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'staff_services_tab': 1
		},
		url: ajaxurl + "rzvy_staff_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$("#rzvy-staff-tab-content").html(res);
		}
	});
});

/** Get Staff schedule tab content */
$(document).on('click', "#rzvy_staff_schedule_tab_selection", function() {
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'staff_schedule_tab': 1
		},
		url: ajaxurl + "rzvy_staff_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$("#rzvy-staff-tab-content").html(res);
		}
	});
});

/** Get Staff blockoff tab content */
$(document).on('click', "#rzvy_staff_blockoff_tab_selection", function() {
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'staff_blockoff_tab': 1
		},
		url: ajaxurl + "rzvy_staff_ajax.php",
		success: function (res) {
			$("#rzvy-add-staffdaysoff-modal").modal("hide");
			$("#rzvy-mainnav").removeAttr("style");
			$("#rzvy-page-top").removeAttr("style");
			$("#rzvy-page-top").removeClass("modal-open");
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			$("#rzvy-staff-tab-content").html(res);
		}
	});
});

/** Change staff status JS **/
$(document).on('change', '#rzvy_staff_status', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	var staff_status_check = $(this).prop('checked');
	var staff_status_text = generalObj.disabled;
	var staff_status = 'N';
	if(staff_status_check){
		staff_status_text = generalObj.enabled;
		staff_status = 'Y';
	}
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'status': staff_status,
			'change_staff_status': 1
		},
		url: ajaxurl + "rzvy_staff_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			if(res=="changed"){
				swal(staff_status_text+"!", generalObj.staff_status_changed_successfully, "success");
			}else{
				swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
			}
		}
	});
});

/** Save staff detail JS **/
$(document).on('click', '.rzvy_save_staff_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var uploaded_file = $("#rzvy-image-upload-file-hidden").val();
	var firstname = $("#rzvy_staff_firstname").val();
	var lastname = $("#rzvy_staff_lastname").val();
	var phone = $("#rzvy_staff_phone").intlTelInput("getNumber");
	var address = $("#rzvy_staff_address").val();
	var city = $("#rzvy_staff_city").val();
	var state = $("#rzvy_staff_state").val();
	var zip = $("#rzvy_staff_zip").val();
	var country = $("#rzvy_staff_country").val();
	var id = $("#rzvy-staff-detail-id-hidden").val(); 
	var show_ratings_on_booking_form = $("#show_ratings_on_booking_form option:selected").val();
	var show_completed_jobs_on_booking_form = $("#show_completed_jobs_on_booking_form option:selected").val();
	var show_email_on_booking_form = $("#show_email_on_booking_form option:selected").val();
	var show_phone_on_booking_form = $("#show_phone_on_booking_form option:selected").val();
	var show_staff_on_calendar = $("#show_staff_on_calendar option:selected").val();
	
	/** Validate update Profile form **/
	$('#rzvy_staff_detail_form').validate({
		rules: {
			rzvy_staff_firstname:{ required: true, maxlength: 50 },
			rzvy_staff_lastname: { required:true, maxlength: 50 },
			rzvy_staff_phone: { required:true, minlength: 10, maxlength: 15, pattern_phone:true },
			/*rzvy_staff_address: { required:true },
			rzvy_staff_city: { required:true },
			rzvy_staff_state: { required:true },
			rzvy_staff_zip: { required:true, pattern_zip:true, minlength: 5, maxlength: 10 },
			rzvy_staff_country: { required:true }*/
		},
		messages: {
			rzvy_staff_firstname:{ required: generalObj.please_enter_first_name, maxlength: generalObj.please_enter_maximum_50_characters },
			rzvy_staff_lastname: { required: generalObj.please_enter_last_name, maxlength: generalObj.please_enter_maximum_50_characters },
			rzvy_staff_phone: { required: generalObj.please_enter_phone_number, minlength: generalObj.please_enter_minimum_10_digits, maxlength: generalObj.please_enter_maximum_15_digits },
			/* rzvy_staff_address: { required: generalObj.please_enter_address },
			rzvy_staff_city: { required: generalObj.please_enter_city },
			rzvy_staff_state: { required: generalObj.please_enter_state },
			rzvy_staff_zip: { required: generalObj.please_enter_zip, minlength: generalObj.please_enter_minimum_5_characters, maxlength: generalObj.please_enter_maximum_10_characters },
			rzvy_staff_country: { required: generalObj.please_enter_country } */
		}
	});
	
	if($("#rzvy_staff_detail_form").valid()){
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
				'id': id,
				'show_ratings_on_booking_form': show_ratings_on_booking_form,
				'show_completed_jobs_on_booking_form': show_completed_jobs_on_booking_form,
				'show_email_on_booking_form': show_email_on_booking_form,
				'show_phone_on_booking_form': show_phone_on_booking_form,
				'show_staff_on_calendar': show_staff_on_calendar,
				'save_staff': 1
			},
			url: ajaxurl + "rzvy_staff_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="updated"){
					swal(generalObj.updated, generalObj.your_profile_updated_successfully, "success");
					location.reload();
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Save Staff Services **/
$(document).on("click", ".rzvy_update_staff_services_btn", function(){
	var id = $("#rzvy-staff-detail-id-hidden").val();
	var ajaxurl = generalObj.ajax_url;
	var services = "";
	var i = 0;
	$(".rzvy-cat-services").each(function(){
		if($(this).prop("checked")){
			if(i==0){
				services = services+$(this).data("id");
				i++;
			}else{
				services = services+','+$(this).data("id");
				i++;
			}
		}
	});
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'services': services,
			'save_staff_services': 1
		},
		url: ajaxurl + "rzvy_staff_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			swal(generalObj.updated, generalObj.service_linked_successfully, "success");
		}
	});
});

function rzvy_isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

/** Add Staff breaks **/
$(document).on("click", ".rzvy_update_staff_schedule_btn", function(){
	var id = $("#rzvy-staff-detail-id-hidden").val();
	var ajaxurl = generalObj.ajax_url;
	var offday = [];
	var starttime = [];
	var endtime = [];
	var no_of_booking = [];
	var starttime_error = [];
	var endtime_error = [];
	var no_of_booking_error = [];

	$(".rzvy_staff_schedule_offday").each(function(){
		if($(this).prop("checked")){
			offday.push("N");
		}else{
			offday.push("Y");
		}
	});

	$(".rzvy_staff_starttime_dropdown").each(function(){
		if($(this).val() != ""){
			var id = $(this).data('id');
			var start_time = $(this).val();
			var position = $('option:selected', this).data('position');
			var dayname = $(this).data('dayname');
			var endtime_position = $('#rzvy_staff_endtime_dropdown_'+id+' option:selected').data('position');
			if(endtime_position>position){
				starttime.push(start_time);
			}else{
				starttime_error.push(dayname);
			}
		}
	});
	
	$(".rzvy_staff_endtime_dropdown").each(function(){
		if($(this).val() != ""){
			var id = $(this).data('id');
			var end_time = $(this).val();
			var position = $('option:selected', this).data('position');
			var dayname = $(this).data('dayname');
			var starttime_position = $('#rzvy_staff_starttime_dropdown_'+id+' option:selected').data('position');
			if(starttime_position<position){
				endtime.push(end_time);
			}else{
				endtime_error.push(dayname);
			}
		}
	});
	
	$(".rzvy_staff_no_of_booking").each(function(){
		var no_of_b = $(this).val();
		var dayname = $(this).data('dayname');
		if(no_of_b != ""){
			if(rzvy_isNumber(no_of_b)){
				if(no_of_b>=0){
					no_of_booking.push(no_of_b);
				}else{
					no_of_booking_error.push(dayname);
				}
			}else{
				no_of_booking_error.push(dayname);
			}
		}else{
			no_of_booking_error.push(dayname);
		}
	});
	
	if(starttime_error.length>0){
		var start_error = starttime_error.join(", ");
		swal(generalObj.opps, generalObj.please_select_start_time_less_than_end_time_for+" "+start_error+".", "error");
	}else if(endtime_error.length>0){
		var end_error = endtime_error.join(", ");
		swal(generalObj.opps, generalObj.please_select_end_time_greater_than_start_time_for+" "+end_error+".", "error");
	}else if(no_of_booking_error.length>0){
		var nob_error = no_of_booking_error.join(", ");
		swal(generalObj.opps, generalObj.please_enter_valid_no_of_booking_for+" "+nob_error+".", "error");
	}else{
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'offday': offday,
				'starttime': starttime,
				'endtime': endtime,
				'no_of_booking': no_of_booking,
				'save_staff_schedule': 1
			},
			url: ajaxurl + "rzvy_staff_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				swal(generalObj.updated, generalObj.schedule_updated_successfully, "success");
			}
		});
	}
});

/** Add Staff breaks **/
$(document).on("click", ".rzvy_addbreak_btn", function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $("#rzvy-staff-detail-id-hidden").val();
	var dayid = $(this).data("dayid");
	var break_start = $("#rzvy_addbreak_starttime_"+dayid+' option:selected').val();
	var break_end = $("#rzvy_addbreak_endtime_"+dayid+' option:selected').val();
	
	if(break_start != "" && break_end != ""){
		if(break_start < break_end){
			$("#rzvy-add-break-modal_"+id).modal("hide");
			$('body').removeClass('modal-open');
			$('.modal-backdrop').fadeOut();
			$.ajax({
				type: 'post',
				data: {
					'id': id,
					'dayid': dayid,
					'break_start': break_start,
					'break_end': break_end,
					'add_staff_breaks': 1
				},
				url: ajaxurl + "rzvy_staff_ajax.php",
				success: function (res) {
					if(res == "added"){
						swal(generalObj.added, generalObj.break_added_successfully, "success");
						$("#rzvy_staff_schedule_tab_selection").trigger("click");
					}
				}
			});
		}else if(break_start > break_end){
			swal(generalObj.opps, generalObj.please_select_break_start_less_than_break_end, "error");
		}else if(break_start == break_end){
			swal(generalObj.opps, generalObj.break_start_should_not_be_equal_to_break_end, "error");
		}
	}
});

/** Delete Staff breaks **/
$(document).on("click", ".rzvy_delete_staffbreak", function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data("id");
	swal({
		title: generalObj.are_you_sure,
		text: generalObj.you_want_to_delete_this_break,
		type: "error",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: generalObj.yes_confirm_it,
		closeOnConfirm: false
	  },
	  function(){
		  $(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		  $.ajax({
			  type: 'post',
			  data: {
				  'id': id,
				  'delete_staffbreak': 1
			  },
			  url: ajaxurl + "rzvy_staff_ajax.php",
			  success: function (res) {
				  $(".rzvy_main_loader").addClass("rzvy_hide_loader");
				  if(res=="deleted"){
					  swal(generalObj.deleted, generalObj.break_deleted_successfully, "success");
					  $("#rzvy_staff_schedule_tab_selection").trigger("click");
				  }else{
					  swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				  }
			  }
		  });
	  });
});

/** Add staff days off JS */
$(document).on("click", "#rzvy_add_staffdaysoff_btn", function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $("#rzvy-staff-detail-id-hidden").val();
	var off_date = $("#rzvy_staffdaysoff_date").val();
	if(rzvy_isValidDate(off_date)){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'off_date': off_date,
				'add_staff_daysoff': 1
			},
			url: ajaxurl + "rzvy_staff_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res == "added"){
					swal(generalObj.added, generalObj.days_off_added_successfully, "success");
					$("#rzvy-add-staffdaysoff-modal").modal('hide');		
					$(".modal-backdrop").remove();
					$("#rzvy_staff_blockoff_tab_selection").trigger("click");
				}
			}
		});
	}
});

/** validate date **/
function rzvy_isValidDate(dateString) {
	var regEx = /^\d{4}-\d{2}-\d{2}$/;
	if(!dateString.match(regEx)) return false;  /** Invalid format **/
	var d = new Date(dateString);
	if(Number.isNaN(d.getTime())) return false; /** Invalid date **/
	return d.toISOString().slice(0,10) === dateString;
}

/** Delete Staff days off **/
$(document).on("click", ".rzvy_delete_staff_daysoff_btn", function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data("id");
	swal({
		title: generalObj.are_you_sure,
		text: generalObj.you_want_to_delete_this_offday,
		type: "error",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: generalObj.yes_delete_it,
		cancelButtonText: generalObj.cancel,
		closeOnConfirm: false
	  },
	  function(){
		  $(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		  $.ajax({
			  type: 'post',
			  data: {
				  'id': id,
				  'delete_staffdaysoff': 1
			  },
			  url: ajaxurl + "rzvy_staff_ajax.php",
			  success: function (res) {
				  $(".rzvy_main_loader").addClass("rzvy_hide_loader");
				  if(res=="deleted"){
					  swal(generalObj.deleted, generalObj.days_off_deleted_successfully, "success");
					  $("#rzvy_staff_blockoff_tab_selection").trigger("click");
				  }else{
					  swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				  }
			  }
		  });
	  });
});
/** STAFF Module JS END **/

$(document).on('click', '.rzvy_addbreak_popover', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data("id");
	var weekday_id = $(this).data("weekday_id");
	var start_time = $('#rzvy_staff_starttime_dropdown_'+id+' option:selected').val();
	var end_time = $('#rzvy_staff_endtime_dropdown_'+id+' option:selected').val();

	$.ajax({
		type: 'post',
		data: {
			'start_time': start_time,
			'end_time': end_time,
			'weekday_id': weekday_id,
			'update_break_data_content': 1
		},
		url: ajaxurl + "rzvy_staff_ajax.php",
		success: function (res) {
			$("#rzvy_addbreak_popover_datacontent_"+id).html(res);
			$("#rzvy-add-break-modal_"+id).modal("show");
		}
	});
});

/** Change Staff email JS **/
$(document).on('click', '#rzvy_change_staff_email_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	/** Validate Change Email form **/
	$('#rzvy_change_staff_email_form').validate({
		rules: {
			rzvy_change_staff_email:{ required: true, email: true }
		},
		messages: {
			rzvy_change_staff_email:{ required: generalObj.please_enter_email_address, email: generalObj.please_enter_valid_email_address }
		}
	});
	if($("#rzvy_change_staff_email_form").valid()){
		var id = $("#rzvy-staff-detail-id-hidden").val();
		var email = $("#rzvy_change_staff_email").val();
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'email': email,
				'change_email': 1
			},
			url: ajaxurl + "rzvy_staff_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="updated"){
					swal(generalObj.changed, generalObj.email_changed_successfully, "success");
					$("#rzvy_staff_detail_tab_selection").trigger("click");
				}else if(res=="exist"){
					swal(generalObj.exist, generalObj.email_already_exist_please_try_to_update_with_not_registered_email, "error");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

$(document).on('click', '#rzvy_edit_internal_note_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $('#rzvy_edit_internal_note_cid').val();
	var internal_note = $('#rzvy_edit_internal_note').val();
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'internal_note': internal_note,
			'update_internal_note': 1
		},
		url: ajaxurl + "rzvy_customer_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			swal(generalObj.updated, "", "success");
			$('.rzvy_customer_detail_link').trigger("click");	
		}
	});
});

/***************************STAFF ADVANCE SCHEDULE STARTS***********************************/
/** Add Advance Schedule JS **/
$(document).on("click", "#rzvy_add_advanceschedule_btn", function(){
	var ajaxurl = generalObj.ajax_url;
	
	/** Validate add block off form **/
	$('#rzvy_add_advanceschedule_form').validate({
		rules: {
			rzvy_advanceschedule_starttime:{ required: true, timeGreaterThan: "#rzvy_advanceschedule_endtime" },
			rzvy_advanceschedule_endtime:{ required: true },
			rzvy_advanceschedule_noofbooking:{ required: true, number: true },
			rzvy_advanceschedule_status:{ required: true }
		},
		messages: {
			rzvy_advanceschedule_starttime:{ required: generalObj.please_select_start_time },
			rzvy_advanceschedule_endtime:{ required: generalObj.please_select_end_time },
			rzvy_advanceschedule_noofbooking:{ required: generalObj.please_enter_no_of_bookings, number: generalObj.please_enter_only_numerics },
			rzvy_advanceschedule_status:{ required: generalObj.please_select_status }
		}
	});
		
	if($("#rzvy_add_advanceschedule_form").valid()){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		var id=  $("#rzvy_advanceschedule_id").val();
		var startDate=  $("#rzvy_advanceschedule_daterange").data('daterangepicker').startDate.format('YYYY-MM-DD');
		var endDate=  $("#rzvy_advanceschedule_daterange").data('daterangepicker').endDate.format('YYYY-MM-DD');
		var startTime = $("#rzvy_advanceschedule_starttime").val();
		var endTime = $("#rzvy_advanceschedule_endtime").val();
		var noofbooking = $("#rzvy_advanceschedule_noofbooking").val();
		var asStatus = $(".rzvy_advanceschedule_status:checked").val();
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'startdate': startDate,
				'enddate': endDate,
				'starttime': startTime,
				'endtime': endTime,
				'noofbooking': noofbooking,
				'status': asStatus,
				'add_advanceschedule': 1
			},
			url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
			success: function (res) {
				if(res=="added"){
					swal(generalObj.added, "", "success");
					location.reload();
				}else{
					$(".rzvy_main_loader").addClass("rzvy_hide_loader");
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Update Advance schedule modal detail JS **/
$(document).on('click', '.rzvy-update-advanceschedulemodal', function(){
	$(".rzvy-update-advanceschedule-modal-body").html("");
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data("id");
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'get_advanceschedule': 1
		},
		url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
		success: function (res) {
			$(".rzvy-update-advanceschedule-modal-body").html(res);
			$("#rzvy-update-advanceschedule-modal").modal("show");
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
		}
	});
});

/** update Advance Schedule JS **/
$(document).on("click", "#rzvy_update_advanceschedule_btn", function(){
	var ajaxurl = generalObj.ajax_url;
	
	/** Validate update block off form **/
	$('#rzvy_update_advanceschedule_form').validate({
		rules: {
			rzvy_u_advanceschedule_starttime:{ required: true, timeGreaterThan: "#rzvy_u_advanceschedule_endtime" },
			rzvy_u_advanceschedule_endtime:{ required: true },
			rzvy_u_advanceschedule_noofbooking:{ required: true, number: true }
		},
		messages: {
			rzvy_u_advanceschedule_starttime:{ required: generalObj.please_select_start_time },
			rzvy_u_advanceschedule_endtime:{ required: generalObj.please_select_end_time },
			rzvy_u_advanceschedule_noofbooking:{ required: generalObj.please_enter_no_of_bookings, number: generalObj.please_enter_only_numerics }
		}
	});
		
	if($("#rzvy_update_advanceschedule_form").valid()){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		var id=  $("#rzvy_u_advanceschedule_id").val();
		var startDate=  $("#rzvy_u_advanceschedule_daterange").data('daterangepicker').startDate.format('YYYY-MM-DD');
		var endDate=  $("#rzvy_u_advanceschedule_daterange").data('daterangepicker').endDate.format('YYYY-MM-DD');
		var startTime = $("#rzvy_u_advanceschedule_starttime").val();
		var endTime = $("#rzvy_u_advanceschedule_endtime").val();
		var noofbooking = $("#rzvy_u_advanceschedule_noofbooking").val();
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'startdate': startDate,
				'enddate': endDate,
				'starttime': startTime,
				'endtime': endTime,
				'noofbooking': noofbooking,
				'update_advanceschedule': 1
			},
			url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
			success: function (res) {
				if(res=="updated"){
					swal(generalObj.updated, "", "success");
					location.reload();
				}else{
					$(".rzvy_main_loader").addClass("rzvy_hide_loader");
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Delete advanceschedule JS **/
$(document).on('click', '.rzvy_delete_advanceschedule_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure,
	  text: "",
	  type: "error",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: generalObj.yes_delete_it,
	  cancelButtonText: generalObj.cancel,
	  closeOnConfirm: false
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'delete_advanceschedule': 1
			},
			url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="deleted"){
					swal(generalObj.deleted, "", "success");
					location.reload();
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});

/** Change advanceschedule status JS **/
$(document).on('change', '.rzvy_change_advanceschedule_status', function(){
	$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	var status_check = $(this).prop('checked');
	var status_text = generalObj.disabled;
	var status = 'N';
	if(status_check){
		status_text = generalObj.enabled;
		status = 'Y';
	}
	$.ajax({
		type: 'post',
		data: {
			'id': id,
			'status': status,
			'change_advanceschedule_status': 1
		},
		url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
		success: function (res) {
			$(".rzvy_main_loader").addClass("rzvy_hide_loader");
			if(res=="changed"){
				swal(status_text+"!", "", "success");
			}else{
				swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
			}
		}
	});
});

/** Delete advanceschedule daysoff JS **/
$(document).on('click', '.rzvy_delete_advanceschedule_daysoff_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure,
	  text: "",
	  type: "error",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: generalObj.yes_delete_it,
	  cancelButtonText: generalObj.cancel,
	  closeOnConfirm: false
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'delete_advanceschedule_daysoff': 1
			},
			url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="deleted"){
					swal(generalObj.deleted, "", "success");
					location.reload();
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});

/** Add Advance Schedule OFFdays JS **/
$(document).on("click", "#rzvy_add_advanceschedule_daysoff_btn", function(){
	var ajaxurl = generalObj.ajax_url;
	
	/** Validate add block off form **/
	$('#rzvy_add_advanceschedule_daysoff_form').validate({
		rules: {
			rzvy_advanceschedule_offdate:{ required: true, date: true }
		},
		messages: {
			rzvy_advanceschedule_offdate:{ required: generalObj.please_enter_valid_offdate, date: generalObj.please_enter_valid_offdate }
		}
	});
		
	if($("#rzvy_add_advanceschedule_daysoff_form").valid()){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		var id=  $("#rzvy_advanceschedule_id").val();
		var sid=  $("#rzvy_advanceschedule_sid").val();
		var off_date=  $("#rzvy_advanceschedule_offdate").val();
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'sid': sid,
				'off_date': off_date,
				'add_advanceschedule_daysoff': 1
			},
			url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
			success: function (res) {
				if(res=="added"){
					swal(generalObj.added, "", "success");
					location.reload();
				}else{
					$(".rzvy_main_loader").addClass("rzvy_hide_loader");
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Delete advanceschedule break JS **/
$(document).on('click', '.rzvy_delete_advanceschedule_break_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure,
	  text: "",
	  type: "error",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: generalObj.yes_delete_it,
	  cancelButtonText: generalObj.cancel,
	  closeOnConfirm: false
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'delete_advanceschedule_break': 1
			},
			url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="deleted"){
					swal(generalObj.deleted, "", "success");
					location.reload();
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});

/** Add Advance Schedule break JS **/
$(document).on("click", "#rzvy_add_advanceschedule_break_btn", function(){
	var ajaxurl = generalObj.ajax_url;
	
	/** Validate add form **/
	$('#rzvy_add_advanceschedule_break_form').validate({
		rules: {
			rzvy_advanceschedule_break_starttime:{ required: true, timeGreaterThan: "#rzvy_advanceschedule_break_endtime", timeEqualTo: "#rzvy_advanceschedule_break_endtime" },
			rzvy_advanceschedule_break_endtime:{ required: true }
		},
		messages: {
			rzvy_advanceschedule_break_starttime:{ required: generalObj.please_select_start_time, timeGreaterThan: generalObj.please_select_break_start_less_than_break_end, timeEqualTo: generalObj.break_start_should_not_be_equal_to_break_end },
			rzvy_advanceschedule_break_endtime:{ required: generalObj.please_select_end_time }
		}
	});
		
	if($("#rzvy_add_advanceschedule_break_form").valid()){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		var id=  $("#rzvy_advanceschedule_id").val();
		var sid=  $("#rzvy_advanceschedule_sid").val();
		var startDate=  $("#rzvy_advanceschedule_break_daterange").data('daterangepicker').startDate.format('YYYY-MM-DD');
		var endDate=  $("#rzvy_advanceschedule_break_daterange").data('daterangepicker').endDate.format('YYYY-MM-DD');
		var startTime = $("#rzvy_advanceschedule_break_starttime").val();
		var endTime = $("#rzvy_advanceschedule_break_endtime").val();
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'sid': sid,
				'startdate': startDate,
				'enddate': endDate,
				'break_start': startTime,
				'break_end': endTime,
				'add_advanceschedule_break': 1
			},
			url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
			success: function (res) {
				if(res=="added"){
					swal(generalObj.added, "", "success");
					location.reload();
				}else{
					$(".rzvy_main_loader").addClass("rzvy_hide_loader");
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	}
});

/** Change Schedule break type JS **/
$(document).ready(function(){
	var rzvy_pageurl = window.location.pathname;
	if(rzvy_pageurl.indexOf("backend/advance-schedule-breaks") != -1){	
		var sdate = moment(new Date($('select#rzvy_advanceschedule_break_daterange_choice').data("startdate")));
		var edate = moment(new Date($('select#rzvy_advanceschedule_break_daterange_choice').data("enddate")));
		if($('select#rzvy_advanceschedule_break_daterange_choice').val() == "daterange"){
			$('#rzvy_advanceschedule_break_daterange').data('daterangepicker').remove()
			$('#rzvy_advanceschedule_break_daterange').daterangepicker({ minDate: moment(), startDate: sdate, endDate: edate, singleDatePicker: false, locale: { "separator": " - ","applyLabel": generalObj.apply,"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,	"daysOfWeek": [	rzvy_sun,rzvy_mon,rzvy_tue,rzvy_wed,rzvy_thu,rzvy_fri,rzvy_sat], "monthNames": [rzvy_january,rzvy_february,rzvy_march,rzvy_april,rzvy_may,rzvy_june,rzvy_july,rzvy_august,rzvy_september,rzvy_october,rzvy_november,rzvy_december ]	}  });
		}else{
			$('#rzvy_advanceschedule_break_daterange').data('daterangepicker').remove()
			$('#rzvy_advanceschedule_break_daterange').daterangepicker({ minDate: moment(), startDate: sdate, endDate: edate, singleDatePicker: true, locale: { "separator": " - ","applyLabel": generalObj.apply,"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,	"daysOfWeek": [	rzvy_sun,rzvy_mon,rzvy_tue,rzvy_wed,rzvy_thu,rzvy_fri,rzvy_sat], "monthNames": [rzvy_january,rzvy_february,rzvy_march,rzvy_april,rzvy_may,rzvy_june,rzvy_july,rzvy_august,rzvy_september,rzvy_october,rzvy_november,rzvy_december ]	}  });
		}
	}
});
$(document).on('changed.bs.select', 'select#rzvy_advanceschedule_break_daterange_choice', function(){
	var sdate = moment(new Date($(this).data("startdate")));
	var edate = moment(new Date($(this).data("enddate")));
	if($(this).val() == "daterange"){
		$('#rzvy_advanceschedule_break_daterange').data('daterangepicker').remove()
		$('#rzvy_advanceschedule_break_daterange').daterangepicker({ minDate: moment(), startDate: sdate, endDate: edate, singleDatePicker: false, locale: { "separator": " - ","applyLabel": generalObj.apply,"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,	"daysOfWeek": [	rzvy_sun,rzvy_mon,rzvy_tue,rzvy_wed,rzvy_thu,rzvy_fri,rzvy_sat], "monthNames": [rzvy_january,rzvy_february,rzvy_march,rzvy_april,rzvy_may,rzvy_june,rzvy_july,rzvy_august,rzvy_september,rzvy_october,rzvy_november,rzvy_december ]	}  });
	}else{
		$('#rzvy_advanceschedule_break_daterange').data('daterangepicker').remove()
		$('#rzvy_advanceschedule_break_daterange').daterangepicker({ minDate: moment(), startDate: sdate, endDate: edate, singleDatePicker: true, locale: { "separator": " - ","applyLabel": generalObj.apply,"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,	"daysOfWeek": [	rzvy_sun,rzvy_mon,rzvy_tue,rzvy_wed,rzvy_thu,rzvy_fri,rzvy_sat], "monthNames": [rzvy_january,rzvy_february,rzvy_march,rzvy_april,rzvy_may,rzvy_june,rzvy_july,rzvy_august,rzvy_september,rzvy_october,rzvy_november,rzvy_december ]	}  });
	}
});

/** Change Schedule type JS **/
$(document).on('changed.bs.select', 'select#rzvy_advanceschedule_daterange_choice', function(){
	if($(this).val() == "daterange"){
		$('#rzvy_advanceschedule_daterange').data('daterangepicker').remove()
		$('#rzvy_advanceschedule_daterange').daterangepicker({ minDate: moment(), startDate: moment(), endDate: moment().add(2, 'days'), singleDatePicker: false, locale: { "separator": " - ","applyLabel": generalObj.apply,"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,	"daysOfWeek": [	rzvy_sun,rzvy_mon,rzvy_tue,rzvy_wed,rzvy_thu,rzvy_fri,rzvy_sat], "monthNames": [rzvy_january,rzvy_february,rzvy_march,rzvy_april,rzvy_may,rzvy_june,rzvy_july,rzvy_august,rzvy_september,rzvy_october,rzvy_november,rzvy_december ]	}  });
	}else{
		$('#rzvy_advanceschedule_daterange').data('daterangepicker').remove()
		$('#rzvy_advanceschedule_daterange').daterangepicker({ minDate: moment(), startDate: moment(), endDate: moment().add(2, 'days'), singleDatePicker: true, locale: { "separator": " - ","applyLabel": generalObj.apply,"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,	"daysOfWeek": [	rzvy_sun,rzvy_mon,rzvy_tue,rzvy_wed,rzvy_thu,rzvy_fri,rzvy_sat], "monthNames": [rzvy_january,rzvy_february,rzvy_march,rzvy_april,rzvy_may,rzvy_june,rzvy_july,rzvy_august,rzvy_september,rzvy_october,rzvy_november,rzvy_december ]	}  });
	}
});

/** Change update Schedule type JS **/
$(document).on('changed.bs.select', 'select#rzvy_u_advanceschedule_daterange_choice', function(){
	var sdate = moment(new Date($(this).data("startdate")));
	var edate = moment(new Date($(this).data("enddate")));
	if($(this).val() == "daterange"){
		$('#rzvy_u_advanceschedule_daterange').data('daterangepicker').remove()
		$('#rzvy_u_advanceschedule_daterange').daterangepicker({ minDate: moment(), startDate: sdate, endDate: edate, singleDatePicker: false, locale: { "separator": " - ","applyLabel": generalObj.apply,"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,	"daysOfWeek": [	rzvy_sun,rzvy_mon,rzvy_tue,rzvy_wed,rzvy_thu,rzvy_fri,rzvy_sat], "monthNames": [rzvy_january,rzvy_february,rzvy_march,rzvy_april,rzvy_may,rzvy_june,rzvy_july,rzvy_august,rzvy_september,rzvy_october,rzvy_november,rzvy_december ]	}  });
	}else{
		$('#rzvy_u_advanceschedule_daterange').data('daterangepicker').remove()
		$('#rzvy_u_advanceschedule_daterange').daterangepicker({ minDate: moment(), startDate: sdate, endDate: edate, singleDatePicker: true, locale: { "separator": " - ","applyLabel": generalObj.apply,"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,	"daysOfWeek": [	rzvy_sun,rzvy_mon,rzvy_tue,rzvy_wed,rzvy_thu,rzvy_fri,rzvy_sat], "monthNames": [rzvy_january,rzvy_february,rzvy_march,rzvy_april,rzvy_may,rzvy_june,rzvy_july,rzvy_august,rzvy_september,rzvy_october,rzvy_november,rzvy_december ]	}  });
	}
});

/** Clone advanceschedule JS **/
$(document).on('click', '.rzvy_clone_advanceschedule_btn', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure_you_want_to_clone,
	  text: "",
	  type: "success",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: generalObj.yes_clone_it,
	  cancelButtonText: generalObj.cancel,
	  closeOnConfirm: false
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'id': id,
				'clone_advanceschedule': 1
			},
			url: ajaxurl + "rzvy_staff_advanceschedule_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="cloned"){
					swal(generalObj.cloned, "", "success");
					location.reload();
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});
/***************************STAFF ADVANCE SCHEDULE ENDS***********************************/
/** Mark as Complete Appointment JS **/
$(document).on('click', '.rzvy_noshow_appointment_link', function(){
	var ajaxurl = generalObj.ajax_url;
	var id = $(this).data('id');
	swal({
	  title: generalObj.are_you_sure,
	  text: generalObj.you_want_to_mark_this_appointment_as_noshow,
	  type: "success",
	  showCancelButton: true,
	  confirmButtonClass: "btn-primary",
	  confirmButtonText: generalObj.yes_mark_as_noshow,
	  cancelButtonText: generalObj.cancel,
	  closeOnConfirm: true
	},
	function(){
		$(".rzvy_main_loader").removeClass("rzvy_hide_loader");
		$.ajax({
			type: 'post',
			data: {
				'order_id': id,
				'mark_as_noshow_appointment': 1
			},
			url: ajaxurl + "rzvy_appointment_detail_ajax.php",
			success: function (res) {
				$(".rzvy_main_loader").addClass("rzvy_hide_loader");
				if(res=="mark_as_noshow"){
					$('.rzvy_confirm_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_pending_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_reschedule_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_reject_appointment_link').parent().addClass('rzvy-hide');
					$('.rzvy_complete_appointment_link').parent().addClass('rzvy-hide');
					$('#rzvy-appointments-calendar').fullCalendar('refetchEvents');
					$('.rzvy_appointment_detail_link').trigger('click');
					swal(generalObj.marked_as_completed, generalObj.appointment_marked_as_noshow_successfully, "success");
				}else{
					swal(generalObj.opps, generalObj.something_went_wrong_please_try_again, "error");
				}
			}
		});
	});
});

/* Image Cropping Start */
var $rzvy_image_crop_modal = $('#rzvy_image_crop_modal');
var rzvy_croppreview_image = document.getElementById('rzvy_cropped_image_preview');
var cropper;
var canvas;
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
			var rzvy_section = $('#rzvy_image_section').val();
			if(rzvy_section=='update'){
				$('#rzvy-update-image-upload-file-hidden').val(rzvy_cropimg);
				$('#rzvy-update-image-upload-file-preview').css('background-image', 'url('+rzvy_cropimg+')');
				$('#rzvy-update-image-upload-file-preview').hide();
				$('#rzvy-update-image-upload-file-preview').fadeIn(650);
			}else{
				$('#rzvy-image-upload-file-hidden').val(rzvy_cropimg);
				$('#rzvy-image-upload-file-preview').css('background-image', 'url('+rzvy_cropimg+')');
				$('#rzvy-image-upload-file-preview').hide();
				$('#rzvy-image-upload-file-preview').fadeIn(650);
			}				
			$('#rzvy_image_crop_modal').modal('hide');
		};
	});
});