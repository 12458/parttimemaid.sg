<?php 
	$rzvy_settings_timezone = $obj_settings->get_option("rzvy_timezone");
	$rzvy_server_timezone = date_default_timezone_get();
	$currDateTime_withTZ = $obj_settings->get_current_time_according_selected_timezone($rzvy_server_timezone,$rzvy_settings_timezone); 
	
	if(isset($_POST["selected_month"])){
		$selected_date = date("Y-m-d", strtotime($_POST["selected_month"]));
		$selected_date = date($selected_date, $currDateTime_withTZ);
	}else{
		if(isset($_SESSION['rzvy_cart_datetime'])){
			if($_SESSION['rzvy_cart_datetime'] != ""){
				$selected_date = date("Y-m-d", strtotime($_SESSION['rzvy_cart_datetime']));				
			}else{
				$selected_date = date("Y-m-d");
				$selected_date = date($selected_date, $currDateTime_withTZ);
			}
		}else{
			$selected_date = date("Y-m-d");
			$selected_date = date($selected_date, $currDateTime_withTZ);
		}
	}
	
	$today_date = date("Y-m-d");
	$today_date = date($today_date, $currDateTime_withTZ);
	$time = strtotime($selected_date);
	
	$time_interval = $obj_settings->get_option('rzvy_timeslot_interval');
	$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
	$advance_bookingtime = $obj_settings->get_option('rzvy_maximum_advance_booking_time');
	
	$rzvy_hide_already_booked_slots_from_frontend_calendar = $obj_settings->get_option('rzvy_hide_already_booked_slots_from_frontend_calendar');
	$rzvy_minimum_advance_booking_time = $obj_settings->get_option('rzvy_minimum_advance_booking_time');

	/** check for maximum advance booking time **/
	$current_datetime = strtotime(date("Y-m-d H:i:s", $currDateTime_withTZ));
	$maximum_date = date("Y-m-d", strtotime('+'.$advance_bookingtime.' months', $current_datetime));
	$maximum_date = date($maximum_date, $currDateTime_withTZ);

	/** check for minimum advance booking time **/
	$minimum_date = date("Y-m-d H:i:s", strtotime("+".$rzvy_minimum_advance_booking_time." minutes", $current_datetime));  
	
	$prev_next_cdate = date("Y-m-01", $currDateTime_withTZ);
	$prev_next_date = date($selected_date, $currDateTime_withTZ);
	$next_month = date('Y-m-01',strtotime('first day of +1 month', strtotime($prev_next_date)));
	$prev_month = date("Y-m-01", strtotime('-1 months', strtotime($prev_next_date)));
	if(strtotime($prev_next_cdate)>strtotime($prev_month)){
		$prev_month = "";
	}
	if(strtotime($next_month)>strtotime($maximum_date)){
		$next_month = "";
	}
	$pn = array('<i class="fa fa-chevron-left"></i>' => $prev_month, '<i class="fa fa-chevron-right"></i>' => $next_month);

	$staff_id = $_SESSION['rzvy_staff_id'];
	$service_id = $_SESSION['rzvy_cart_service_id'];

	$rzvy_langDefaultArr =  $rzvy_defaultlang; 
	if(isset($rzvy_translangArr)){ 
		$rzvy_langNewArr =  $rzvy_translangArr; 
	}else{
		$rzvy_langNewArr = array();
	}
	
	/** check for GC bookings START **/
	$gc_twowaysync_eventsArr = array();
	/** check for staff GC bookings END **/
	
	echo $obj_calendar->rzvy_generate_calendar(date('Y', $time), date('n', $time), 3, 1, $pn, $time_interval, $rzvy_time_format, $advance_bookingtime, $currDateTime_withTZ, $rzvy_hide_already_booked_slots_from_frontend_calendar, $minimum_date, $maximum_date, $today_date,$service_id,$rzvy_langNewArr, $rzvy_langDefaultArr, $staff_id, $gc_twowaysync_eventsArr);  
	?>