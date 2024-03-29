<?php 
/* Include class files */
include(dirname(dirname(dirname(__FILE__)))."/constants.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_customers.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_settings.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_addons.php");

/* Create object of classes */
$obj_customers = new rzvy_customers();
$obj_customers->conn = $conn;
$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;
$obj_addons = new rzvy_addons();
$obj_addons->conn = $conn;

$rzvy_currency_symbol = $obj_settings->get_option('rzvy_currency_symbol');
$rzvy_currency_position = $obj_settings->get_option('rzvy_currency_position');
$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
$rzvy_book_with_datetime = $obj_settings->get_option("rzvy_book_with_datetime");

/* Refresh Registered customer's appointments ajax */
if(isset($_REQUEST['refresh_appt_detail']) && $_REQUEST['ctype'] == 'R'){
	$obj_customers->id = $_REQUEST['c_id'];
	$all_rc_detail = $obj_customers->get_all_rc_appointments($_POST['start'],($_POST['start']+$_POST['length']), $_POST['search']['value'],$_POST['order'][0]['column'],$_POST['order'][0]['dir'],$_POST['draw']);
	$customers = array();
	$customers["draw"] = $_POST['draw'];
	$count_all_appt = $obj_customers->count_all_rc_appointments($_POST['search']['value']);
	$customers["recordsTotal"] = $count_all_appt;
	$customers["recordsFiltered"] = $count_all_appt;
	$customers['data'] =array();
	if(mysqli_num_rows($all_rc_detail)>0){
		$i=$_POST['start'];
		while($rc = mysqli_fetch_assoc($all_rc_detail)){
			$i++;
			$flag = true;
			$addons_detail = '';
			$unserialized_addons = unserialize($rc['addons']);
			foreach($unserialized_addons as $addon){
				$obj_addons->id = $addon['id'];
				$addon_name = $obj_addons->get_addon_name();
				if($flag){
					$addons_detail .= $addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
					$flag = false;
				}else{
					$addons_detail .= "<hr class='rzvy_hr' />".$addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
				}
			}
			$service_detail = ucwords($rc['title'])." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$rc['service_rate']);
			$booking_datetime = date($rzvy_date_format, strtotime($rc['booking_datetime']))." ".date($rzvy_time_format, strtotime($rc['booking_datetime']));
			
			$payment_method = ucwords($rc['payment_method']);
			if($payment_method==ucwords('pay-at-venue')){
				if(isset($rzvy_translangArr['pay_at_venue'])){ $payment_method = $rzvy_translangArr['pay_at_venue']; }else{ $payment_method = $rzvy_defaultlang['pay_at_venue']; } 
			}
			
			$rzvy_staff_name =  '';
			$rzvy_staff_nameinfo = $obj_settings->get_staff_name($rc['staff_id']);
			if(mysqli_num_rows($rzvy_staff_nameinfo)>0){
				$staffinfovalue=mysqli_fetch_array($rzvy_staff_nameinfo);
				$rzvy_staff_name =  $staffinfovalue['firstname'].' '.$staffinfovalue['lastname'];
			}
			
			
			$rc_arr = array();
			array_push($rc_arr, $rc['order_id']);
			array_push($rc_arr, ucwords($rc['cat_name']));
			array_push($rc_arr, $service_detail);
			array_push($rc_arr, $addons_detail);
			array_push($rc_arr, $rzvy_staff_name);
			if($rzvy_book_with_datetime == "Y"){
				array_push($rc_arr, $booking_datetime);
			}
			array_push($rc_arr, ucwords(str_replace("_"," ",$rc['booking_status'])));
			array_push($rc_arr, $payment_method);
			array_push($customers['data'], $rc_arr);
		}
	}
	echo json_encode($customers);
}
/* Refresh Guest customer's appointments ajax */
else if(isset($_REQUEST['refresh_appt_detail']) && $_REQUEST['ctype'] == 'G'){
	$obj_customers->order_id = $_REQUEST['c_id'];
	$all_gc_detail = $obj_customers->get_all_gc_appointments($_POST['start'],($_POST['start']+$_POST['length']), $_POST['search']['value'],$_POST['order'][0]['column'],$_POST['order'][0]['dir'],$_POST['draw']);
	$customers = array();
	$customers["draw"] = $_POST['draw'];
	$count_all_appt = '1';
	$customers["recordsTotal"] = $count_all_appt;
	$customers["recordsFiltered"] = $count_all_appt;
	$customers['data'] =array();
	if(mysqli_num_rows($all_gc_detail)>0){
		$i=$_POST['start'];
		while($rc = mysqli_fetch_assoc($all_gc_detail)){
			$i++;
			
			$flag = true;
			$addons_detail = '';
			$unserialized_addons = unserialize($rc['addons']);
			foreach($unserialized_addons as $addon){
				$obj_addons->id = $addon['id'];
				$addon_name = $obj_addons->get_addon_name();
				if($flag){
					$addons_detail .= $addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
					$flag = false;
				}else{
					$addons_detail .= "<hr class='rzvy_hr' />".$addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
				}
			}
			$service_detail = ucwords($rc['title'])." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$rc['service_rate']);
			$booking_datetime = date($rzvy_date_format, strtotime($rc['booking_datetime']))." ".date($rzvy_time_format, strtotime($rc['booking_datetime']));
			
			$rzvy_staff_name =  '';
			$rzvy_staff_nameinfo = $obj_settings->get_staff_name($rc['staff_id']);
			if(mysqli_num_rows($rzvy_staff_nameinfo)>0){
				$staffinfovalue=mysqli_fetch_array($rzvy_staff_nameinfo);
				$rzvy_staff_name =  $staffinfovalue['firstname'].' '.$staffinfovalue['lastname'];
			}		
			
			$gc_arr = array();
			array_push($gc_arr, $rc['order_id']);
			array_push($gc_arr, ucwords($rc['cat_name']));
			array_push($gc_arr, $service_detail);
			array_push($gc_arr, $addons_detail);
			array_push($gc_arr, $rzvy_staff_name);
			if($rzvy_book_with_datetime == "Y"){
				array_push($gc_arr, $booking_datetime);
			}
			array_push($gc_arr, ucwords(str_replace("_"," ",$rc['booking_status'])));
			array_push($gc_arr, ucwords($rc['payment_method']));
			array_push($customers['data'], $gc_arr);
		}
	}
	echo json_encode($customers);
}