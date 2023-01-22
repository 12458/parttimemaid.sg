<?php 
/* Include class files */
include(dirname(dirname(dirname(__FILE__)))."/constants.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_bookings.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_settings.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_addons.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_slots.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_loyalty_points.php");

/* Create object of classes */
$obj_bookings = new rzvy_bookings();
$obj_bookings->conn = $conn;
$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

$obj_addons = new rzvy_addons();
$obj_addons->conn = $conn;
$obj_slots = new rzvy_slots();
$obj_slots->conn = $conn;
$obj_lpoint = new rzvy_loyalty_points();
$obj_lpoint->conn = $conn;

$rzvy_book_with_datetime = $obj_settings->get_option("rzvy_book_with_datetime");
$rzvy_price_display = $obj_settings->get_option("rzvy_price_display");
$rzvy_currency_symbol = $obj_settings->get_option('rzvy_currency_symbol');
$rzvy_currency_position = $obj_settings->get_option('rzvy_currency_position');


if(isset($rzvy_translangArr['weekly_label'])){ $fq_weekly_label = $rzvy_translangArr['weekly_label']; }else{ $fq_weekly_label = $rzvy_defaultlang['weekly_label']; }
if(isset($rzvy_translangArr['biweekly_label'])){ $fq_weekly_label = $fq_biweekly_label['biweekly_label']; }else{ $fq_biweekly_label = $rzvy_defaultlang['biweekly_label']; }
if(isset($rzvy_translangArr['monthly_label'])){ $fq_monthly_label = $fq_biweekly_label['monthly_label']; }else{ $fq_monthly_label = $rzvy_defaultlang['monthly_label']; }
if(isset($rzvy_translangArr['one_time_label'])){ $fq_one_time_label = $fq_biweekly_label['one_time_label']; }else{ $fq_one_time_label = $rzvy_defaultlang['one_time_label']; }



/* Get appointment detail from order id ajax */
if(isset($_POST['get_appointment_detail'])){
	$order_id = $_POST['order_id'];
	$obj_bookings->order_id = $order_id;
	$appointment_detail = $obj_bookings->get_appointment_status_and_datetime();
	
	$appointment_datetime = $appointment_detail['booking_datetime'];
	$appointment_status = $appointment_detail['booking_status'];
	
	$rzvy_reschedule_buffer_time = $obj_settings->get_option("rzvy_reschedule_buffer_time");
	$rzvy_cancellation_buffer_time = $obj_settings->get_option("rzvy_cancellation_buffer_time");
	
	$rzvy_settings_timezone = $obj_settings->get_option("rzvy_timezone");
	$rzvy_server_timezone = date_default_timezone_get();
	$currDateTime_withTZ = $obj_settings->get_current_time_according_selected_timezone($rzvy_server_timezone,$rzvy_settings_timezone); 
	$current_time = strtotime(date("Y-m-d H:i:s", $currDateTime_withTZ));
	
	$reschedule_time = strtotime(date("Y-m-d H:i:s", strtotime("-".$rzvy_reschedule_buffer_time." minutes", strtotime($appointment_datetime))));
	$is_reschedule = "Y";
	if($current_time > $reschedule_time){
		$is_reschedule = "N";
	}
	
	$cancellation_time = strtotime(date("Y-m-d H:i:s", strtotime("-".$rzvy_cancellation_buffer_time." minutes", strtotime($appointment_datetime))));
	$is_cancellation = "Y";
	if($current_time > $cancellation_time){
		$is_cancellation = "N";
	}
	$counter_i = 0;
	
	if($rzvy_price_display=='Y'){ 
	?>
	<div class="row">
    	<div class="col-md-12">
    	    <a class="btn btn-link pull-right" href="<?php $invoice_uid = base64_encode($appointment_detail["customer_id"]); $invoice_oid = base64_encode($order_id); echo SITE_URL."/invoice/?invoice=".base64_encode("###_____".$invoice_uid."_____&&&_____".$invoice_oid); ?>" target="_blank"><i class="fa fa-files-o"></i> <?php if(isset($rzvy_translangArr['download_invoice'])){ echo $rzvy_translangArr['download_invoice']; }else{ echo $rzvy_defaultlang['download_invoice']; } ?></a>
    	</div>
	</div><?php } ?>
	<div class="rzvy-tabbable-panel">
		<div class="rzvy-tabbable-line">
			<ul class="nav nav-tabs">
			  <li class="nav-item active custom-nav-item">
				<a class="nav-link custom-nav-link rzvy_tab_view_nav_link rzvy_appointment_detail_link" data-tabno="<?php echo $counter_i; ?>" data-toggle="tab" data-id="<?php echo $order_id; ?>" href="javascript:void(0)"><i class="fa fa-calendar-check-o"></i> <?php if(isset($rzvy_translangArr['appointment_detail'])){ echo $rzvy_translangArr['appointment_detail']; }else{ echo $rzvy_defaultlang['appointment_detail']; } ?></a>
			  </li>
			  <?php $counter_i++; ?>
			  <?php if($appointment_detail['sub_total']>0 && $rzvy_price_display=='Y'){ ?>
				  <li class="nav-item custom-nav-item">
					<a class="nav-link custom-nav-link rzvy_tab_view_nav_link rzvy_payment_detail_link" data-tabno="<?php echo $counter_i; ?>" data-toggle="tab" data-id="<?php echo $order_id; ?>" href="javascript:void(0)"><i class="fa fa-money"></i> <?php if(isset($rzvy_translangArr['payment_detail'])){ echo $rzvy_translangArr['payment_detail']; }else{ echo $rzvy_defaultlang['payment_detail']; } ?></a>
				  </li>
				  <?php $counter_i++; ?>
			  <?php } ?>
			  <li class="nav-item custom-nav-item">
				<a class="nav-link custom-nav-link rzvy_tab_view_nav_link rzvy_customer_detail_link" data-tabno="<?php echo $counter_i; ?>" data-toggle="tab" data-id="<?php echo $order_id; ?>" href="javascript:void(0)"><i class="fa fa-user"></i> <?php if(isset($rzvy_translangArr['customer_detail'])){ echo $rzvy_translangArr['customer_detail']; }else{ echo $rzvy_defaultlang['customer_detail']; } ?></a>
			  </li>
			  <?php $counter_i++; ?>
			  <?php 
			  if($is_reschedule == "Y" && $rzvy_book_with_datetime == "Y"){ 
				  ?>
				  <li class="nav-item custom-nav-item <?php if($appointment_status == "rejected_by_you" || $appointment_status == "cancelled_by_customer" || $appointment_status == "rejected_by_staff" || $appointment_status == "completed" || $appointment_status == "mark_as_noshow"){ echo "rzvy-hide"; } ?>">
					<a class="nav-link custom-nav-link rzvy_tab_view_nav_link rzvy_reschedule_appointment_link" data-tabno="<?php echo $counter_i; ?>" data-toggle="tab" data-id="<?php echo $order_id; ?>" href="javascript:void(0)"><i class="fa fa-pencil"></i> <?php if(isset($rzvy_translangArr['reschedule_appointment'])){ echo $rzvy_translangArr['reschedule_appointment']; }else{ echo $rzvy_defaultlang['reschedule_appointment']; } ?></a>
				  </li>
				  <?php 
				  $counter_i++;
			  }
			  if($is_cancellation == "Y"){ 
				  ?>
				  <li class="nav-item custom-nav-item <?php if($appointment_status == "rejected_by_you" || $appointment_status == "cancelled_by_customer" || $appointment_status == "rejected_by_staff" || $appointment_status == "completed" || $appointment_status == "mark_as_noshow"){ echo "rzvy-hide"; } ?>">
					<a class="nav-link custom-nav-link rzvy_tab_view_nav_link rzvy_reject_appointment_link" data-tabno="<?php echo $counter_i; ?>" data-toggle="tab" data-id="<?php echo $order_id; ?>" href="javascript:void(0)"><i class="fa fa-ban"></i> <?php if(isset($rzvy_translangArr['cancel_appointment'])){ echo $rzvy_translangArr['cancel_appointment']; }else{ echo $rzvy_defaultlang['cancel_appointment']; } ?></a>
				  </li>
				  <?php 
				  $counter_i++;
			  } 
			  ?>
			  <li class="nav-item custom-nav-item <?php if($appointment_status != "cancelled_by_customer" && $appointment_status != "completed"){ echo "rzvy-hide"; } ?>">
				<a class="nav-link custom-nav-link rzvy_tab_view_nav_link rzvy_feedback_appointment_link" data-tabno="<?php echo $counter_i; ?>" data-toggle="tab" data-id="<?php echo $order_id; ?>" href="javascript:void(0)"><i class="fa fa-star"></i> <?php if(isset($rzvy_translangArr['rating_and_review'])){ echo $rzvy_translangArr['rating_and_review']; }else{ echo $rzvy_defaultlang['rating_and_review']; } ?></a>
			  </li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane container" id="rzvy_appointment_detail">
				  
				</div>
				<div class="tab-pane container" id="rzvy_payment_detail">
				  
				</div>
				<div class="tab-pane container" id="rzvy_customer_detail">
				  
				</div>
				<?php 
				if($is_reschedule == "Y"){ 
					?>
					<div class="tab-pane container" id="rzvy_reschedule_appointment">
					  
					</div>
					<?php 
				} 
				if($is_cancellation == "Y"){ 
					?>
					<div class="tab-pane container" id="rzvy_reject_appointment">
					  
					</div>
					<?php 
				} 
				?>
				<div class="tab-pane container" id="rzvy_feedback_appointment">
			  
				</div>
		  </div>
		</div>
	</div>
	<?php
}

/* Get Appointment Detail tab */
else if(isset($_POST['appointment_detail_tab'])){
	$order_id = $_POST['order_id'];
	$obj_bookings->order_id = $order_id;
	
	$all_detail = $obj_bookings->get_appointment_detail_tab();
		
	if(mysqli_num_rows($all_detail)>0){
		$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
		$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
		while($appt = mysqli_fetch_assoc($all_detail)){	
			$flag = true;
			$addons_detail = '';
			$unserialized_addons = unserialize($appt['addons']);
			foreach($unserialized_addons as $addon){
				$obj_addons->id = $addon['id'];
				$addon_name = $obj_addons->get_addon_name();
				if($flag){
					if($rzvy_price_display=='Y'){
						$addons_detail .= $addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
					}else{
						$addons_detail .= $addon['qty']." ".$addon_name;
					}
					$flag = false;
				}else{
					if($rzvy_price_display=='Y'){
						$addons_detail .= "<br/>".$addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
					}else{
						$addons_detail .= "<br/>".$addon['qty']." ".$addon_name;
					}
					
				}
			}
			
			$booking_datetime = date($rzvy_date_format, strtotime($appt['booking_datetime']))." ".date($rzvy_time_format, strtotime($appt['booking_datetime']));
			
			$booking_end_datetime = date($rzvy_date_format, strtotime($appt['booking_end_datetime']))." ".date($rzvy_time_format, strtotime($appt['booking_end_datetime']));
			
			$category_name = ucwords($appt['cat_name']);
			if($rzvy_price_display=='Y'){
				$service_name = ucwords($appt['title'])." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt['service_rate']);
			}else{
				$service_name = ucwords($appt['title']);
			}

			if (strpos($appt['booking_status'], 'you') !== false) {
				$booking_status = strtoupper(str_replace('you', 'customer', str_replace('_', ' ', $appt['booking_status'])));
			}else if (strpos($appt['booking_status'], 'customer') !== false) {
				$booking_status = strtoupper(str_replace('customer', 'you', str_replace('_', ' ', $appt['booking_status'])));
			}else {
				$booking_status = strtoupper(str_replace('_', ' ', $appt['booking_status']));
			} 
			$staff_name = "-";
			if($appt['staff_id']>0){
				$obj_bookings->staff_id = $appt['staff_id'];
				$staffdata = $obj_bookings->readone_staff();
				$staff_name = ucwords($staffdata['firstname']." ".$staffdata["lastname"]); 
			}
				if($rzvy_book_with_datetime == "Y"){
			?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['appointment_starts'])){ echo $rzvy_translangArr['appointment_starts']; }else{ echo $rzvy_defaultlang['appointment_starts']; } ?></b>
				</div>
				<div class="col-md-9">
					<?php echo $booking_datetime; ?>
				</div>
			  </div>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['appointment_ends'])){ echo $rzvy_translangArr['appointment_ends']; }else{ echo $rzvy_defaultlang['appointment_ends']; } ?></b>
				</div>
				<div class="col-md-9">
					<?php echo $booking_end_datetime; ?>
				</div>
			  </div>
				<?php } ?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['status_ad'])){ echo $rzvy_translangArr['status_ad']; }else{ echo $rzvy_defaultlang['status_ad']; } ?></b>
				</div>
				<div class="col-md-9">
					<?php echo $booking_status; ?>
				</div>
			  </div>
			  <?php if($staff_name != "-"){ ?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['staff_ad'])){ echo $rzvy_translangArr['staff_ad']; }else{ echo $rzvy_defaultlang['staff_ad']; } ?></b>
				</div>
				<div class="col-md-9">
					<?php echo $staff_name; ?>
				</div>
			  </div>
			  <?php } ?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['category'])){ echo $rzvy_translangArr['category']; }else{ echo $rzvy_defaultlang['category']; } ?></b>
				</div>
				<div class="col-md-9">
					<?php echo $category_name; ?>
				</div>
			  </div>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['service'])){ echo $rzvy_translangArr['service']; }else{ echo $rzvy_defaultlang['service']; } ?></b>
				</div>
				<div class="col-md-9">
					<?php echo $service_name; ?>
				</div>
			  </div>
			  <?php if($addons_detail!=""){ ?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['addons'])){ echo $rzvy_translangArr['addons']; }else{ echo $rzvy_defaultlang['addons']; } ?></b>
				</div>
				<div class="col-md-9">
					<?php echo $addons_detail; ?>
				</div>
			  </div>
			<?php
			  }
			  if($appt['c_notes']!=""){ ?>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['notes_ad'])){ echo $rzvy_translangArr['notes_ad']; }else{ echo $rzvy_defaultlang['notes_ad']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $appt['c_notes']; ?>
					</div>
				  </div>
					<?php
			  }
			/* Services Package Purchases */
				$Rzvy_Hooks->do_action('services_package_purchase_appdetail', array((isset($rzvy_translangArr)?$rzvy_translangArr:array()), $rzvy_defaultlang,$rzvy_currency_symbol,$order_id,$rzvy_currency_position));
			/* Services Package Purchases End */  
		}
		
		$posbooking = $obj_bookings->check_isposbooking($order_id);
		if(mysqli_num_rows($posbooking)>0){
			$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
			$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
			$fetch_posbookings = $obj_bookings->fetch_posbookings($order_id);
			if(mysqli_num_rows($fetch_posbookings)>0){
				while($pos = mysqli_fetch_array($fetch_posbookings)){
				
					$booking_datetime = date($rzvy_date_format, strtotime($pos['booking_datetime']))." ".date($rzvy_time_format, strtotime($pos['booking_datetime']));
					
					$booking_end_datetime = date($rzvy_date_format, strtotime($pos['booking_end_datetime']))." ".date($rzvy_time_format, strtotime($pos['booking_end_datetime']));
					
					$flag = true;
					$addons_detail = '';
					$unserialized_addons = unserialize($pos['addons']);
					foreach($unserialized_addons as $addon){
						$obj_addons->id = $addon['id'];
						$addon_name = $obj_addons->get_addon_name();
						if($flag){
							if($rzvy_price_display=='Y'){
							$addons_detail .= $addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
							}else{
								$addons_detail .= $addon['qty']." ".$addon_name;
							}
							$flag = false;
						}else{
							if($rzvy_price_display=='Y'){
							$addons_detail .= "<br/>".$addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
							}else{
								$addons_detail .= "<br/>".$addon['qty']." ".$addon_name;
							}
						}
					}
					$category_name = ucwords($pos['cat_name']);
					if($rzvy_price_display=='Y'){
						$service_name = ucwords($pos['title'])." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$pos['service_rate']);
					}else{
						$service_name = ucwords($pos['title']);	
					}
					
					if (strpos($pos['booking_status'], 'you') !== false) {
						$booking_status = strtoupper(str_replace('you', 'customer', str_replace('_', ' ', $pos['booking_status'])));
					}else if (strpos($pos['booking_status'], 'customer') !== false) {
						$booking_status = strtoupper(str_replace('customer', 'you', str_replace('_', ' ', $pos['booking_status'])));
					}else {
						$booking_status = strtoupper(str_replace('_', ' ', $pos['booking_status']));
					} 
					$staff_name = "-";
					if($pos['staff_id']>0){
						$obj_bookings->staff_id = $pos['staff_id'];
						$staffdata = $obj_bookings->readone_staff();
						$staff_name = ucwords($staffdata['firstname']." ".$staffdata["lastname"]); 
					}
					?>
					<hr />
						<div class="row rzvy-mb-5">
						<div class="col-md-3">
							<b><?php if(isset($rzvy_translangArr['service_ad'])){ echo $rzvy_translangArr['service_ad']; }else{ echo $rzvy_defaultlang['service_ad']; } ?></b>
						</div>
						<div class="col-md-9">
							<?php echo $category_name." - ".$service_name; ?>
						</div>
					  </div>
					  <?php if($addons_detail!=""){ ?>
						  <div class="row rzvy-mb-5">
							<div class="col-md-3">
								<b><?php if(isset($rzvy_translangArr['addons_ad'])){ echo $rzvy_translangArr['addons_ad']; }else{ echo $rzvy_defaultlang['addons_ad']; } ?></b>
							</div>
							<div class="col-md-9">
								<?php echo $addons_detail; ?>
							</div>
						  </div>
					  <?php 
					  }
					  
					if($rzvy_book_with_datetime == "Y"){		  
						?>
						<div class="row rzvy-mb-5">
							<div class="col-md-3">
								<b><?php if(isset($rzvy_translangArr['appointment_starts'])){ echo $rzvy_translangArr['appointment_starts']; }else{ echo $rzvy_defaultlang['appointment_starts']; } ?></b>
							</div>
							<div class="col-md-9">
								<?php echo $booking_datetime; ?>
							</div>
						  </div>
						  <div class="row rzvy-mb-5">
							<div class="col-md-3">
								<b><?php if(isset($rzvy_translangArr['appointment_ends'])){ echo $rzvy_translangArr['appointment_ends']; }else{ echo $rzvy_defaultlang['appointment_ends']; } ?></b>
							</div>
							<div class="col-md-9">
								<?php echo $booking_end_datetime; ?>
							</div>
						  </div>
					<?php }
					  
					  if($pos["sdisc"]>0){
						  ?>
							<div class="row rzvy-mb-5">
							<div class="col-md-3">
								<b><?php if(isset($rzvy_translangArr['special_discount_of'])){ echo $rzvy_translangArr['special_discount_of']; }else{ echo $rzvy_defaultlang['special_discount_of']; } ?></b>
							</div>
							<div class="col-md-9">
								<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$pos["sdisc"]); ?>
							</div>
						  </div>
						  <?php 
					  }
					  ?>
					  <?php if($staff_name != "-"){ ?>
					  <div class="row rzvy-mb-5">
						<div class="col-md-3">
							<b><?php if(isset($rzvy_translangArr['staff_ad'])){ echo $rzvy_translangArr['staff_ad']; }else{ echo $rzvy_defaultlang['staff_ad']; } ?></b>
						</div>
						<div class="col-md-9">
							<?php echo $staff_name; ?>
						</div>
					  </div>
					  <?php } ?>
					  <?php 
				}
			}
		}
	}
}

/* Get Payment Detail tab */
else if(isset($_POST['payment_detail_tab'])){
	$order_id = $_POST['order_id'];
	$obj_bookings->order_id = $order_id;
	
	$pospayments = $obj_bookings->fetch_pospayments($order_id);
	if(mysqli_num_rows($pospayments)>0){
		$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
		while($appt = mysqli_fetch_assoc($pospayments)){			
			$payment_date = date($rzvy_date_format, strtotime($appt['last_modify']));
			$refer_discountwcs = $appt['refer_discount'];
			$refer_discountid = $appt['refer_discount_id'];
			$ebcoupon_discount = $appt['ebdiscount'];
			$ebfreq_discountkey = $appt['fd_key'];
			$ebfreq_discountamt = $appt['fd_amount'];
			$ebpartial_deposite = $appt['partial_deposite'];
			$ebnet_total = $appt['ebnet_total'];
			?>
			  
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['payment_date'])){ echo $rzvy_translangArr['payment_date']; }else{ echo $rzvy_defaultlang['payment_date']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $payment_date; ?>
				</div>
			  </div>
			  <?php if($ebpartial_deposite>0){ ?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['online_pending_payment'])){ echo $rzvy_translangArr['online_pending_payment']; }else{ echo $rzvy_defaultlang['online_pending_payment']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$ebpartial_deposite); ?>
				</div>
			  </div>
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['online_paid_payment'])){ echo $rzvy_translangArr['online_paid_payment']; }else{ echo $rzvy_defaultlang['online_paid_payment']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$ebnet_total); ?>
				</div>
			  </div>
			  <?php }elseif($appt["pdeposite"]>0){ ?>
				<div class="row rzvy-mb-5">
					<div class="col-md-5">
						<b><?php if(isset($rzvy_translangArr['online_paid_payment'])){ echo $rzvy_translangArr['online_paid_payment']; }else{ echo $rzvy_defaultlang['online_paid_payment']; } ?></b>
					</div>
					<div class="col-md-7">
						<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt["pdeposite"]); ?>
					</div>
				</div>
			  <?php  } ?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['sub_total'])){ echo $rzvy_translangArr['sub_total']; }else{ echo $rzvy_defaultlang['sub_total']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt["sub_total"]); ?>
				</div>
			  </div>
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['discount'])){ echo $rzvy_translangArr['discount']; }else{ echo $rzvy_defaultlang['discount']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt["discount"]); ?>
				</div>
			  </div>
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['coupon_discount'])){ echo $rzvy_translangArr['coupon_discount']; }else{ echo $rzvy_defaultlang['coupon_discount']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt["cdiscount"]+$ebcoupon_discount); ?>
				</div>
			  </div>
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['referral_discount'])){ echo $rzvy_translangArr['referral_discount']; }else{ echo $rzvy_defaultlang['referral_discount']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt["rdiscount"]+$refer_discountwcs); ?>
				</div>
			  </div>
			  <?php if($refer_discountwcs>0){ ?>
			 <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(!is_numeric($refer_discountid)){ ?>
						<?php if(isset($rzvy_translangArr['referred_code'])){ echo $rzvy_translangArr['referred_code']; }else{ echo $rzvy_defaultlang['referred_code']; } ?>
					<?php } else{ ?>
						<?php if(isset($rzvy_translangArr['referral_code'])){ echo $rzvy_translangArr['referral_code']; }else{ echo $rzvy_defaultlang['referral_code']; } ?>
					<?php } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $refer_discountid; ?>
				</div>
			  </div>
			  <?php } ?>
			  <?php if($ebfreq_discountkey!=''){ ?>
			   <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['frequently_discount'])){ echo $rzvy_translangArr['frequently_discount']; }else{ echo $rzvy_defaultlang['frequently_discount']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php if($ebfreq_discountkey != ""){ if($ebfreq_discountkey=="weekly"){ echo $fq_weekly_label; }else if($ebfreq_discountkey=="bi weekly"){ echo $fq_biweekly_label; }else if($ebfreq_discountkey=="monthly"){ echo $fq_monthly_label; }else{ echo $fq_one_time_label; } echo " - ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$ebfreq_discountamt); }else{ echo "-"; } ?>
				</div>
			  </div>
			  <?php } ?>  
				  
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['loyalty_points_amount'])){ echo $rzvy_translangArr['loyalty_points_amount']; }else{ echo $rzvy_defaultlang['loyalty_points_amount']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt["lpdiscount"]); ?>
				</div>
			  </div>
			  <?php 
			  /* Services Package Discount Display */
				$Rzvy_Hooks->do_action('services_package_discount_bookingdetail_pos', array((isset($rzvy_translangArr)?$rzvy_translangArr:array()), $rzvy_defaultlang,$rzvy_currency_symbol,$order_id,$rzvy_currency_position));
			  /* Services Package Discount Display End */
			  ?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['tax_vat_gst'])){ echo $rzvy_translangArr['tax_vat_gst']; }else{ echo $rzvy_defaultlang['tax_vat_gst']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt["tax"]); ?>
				</div>
			  </div>
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['net_total'])){ echo $rzvy_translangArr['net_total']; }else{ echo $rzvy_defaultlang['net_total']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt["net_total"]); ?>
				</div>
			  </div>
			  <div class="row rzvy-mb-5">
				<div class="col-md-5">
					<b><?php if(isset($rzvy_translangArr['payment_collection'])){ echo $rzvy_translangArr['payment_collection']; }else{ echo $rzvy_defaultlang['payment_collection']; } ?></b>
				</div>
				<div class="col-md-7">
					<?php $pmethod = @unserialize($appt["payment_methods"]);
					if($pmethod !== false) {
						foreach($pmethod as $p){
							echo $p["method"].": ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$p["amount"]).(isset($p["transaction_id"])?" (".$p["transaction_id"].")":"")."<br />";
						}
					} ?>
				</div>
			  </div>
			<?php
		}
	}else{
		
		$all_detail = $obj_bookings->get_payment_detail_tab();
		
		if(isset($rzvy_translangArr['points'])){ $pointslabel =  $rzvy_translangArr['points']; }else{ $pointslabel = $rzvy_defaultlang['points']; }
		
		if(mysqli_num_rows($all_detail)>0){
			while($appt = mysqli_fetch_assoc($all_detail)){	
				$payment_method = ucwords($appt['payment_method']);
				if($payment_method==ucwords('pay-at-venue')){
					if(isset($rzvy_translangArr['pay_at_venue'])){ $payment_method = $rzvy_translangArr['pay_at_venue']; }else{ $payment_method = $rzvy_defaultlang['pay_at_venue']; } 
				}
				$transaction_id = $appt['transaction_id'];
				$payment_date = date($rzvy_date_format, strtotime($appt['payment_date']));
				$sub_total = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt['sub_total']);
				$discount = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt['discount']);
				$refer_discountwcs = $appt['refer_discount'];
				$refer_discount = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt['refer_discount']);
				$refer_discountid = $appt['refer_discount_id'];
				$tax = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt['tax']);
				$partial_depositews = $appt['partial_deposite'];
				$partial_deposite = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt['partial_deposite']);
				$onlinepaid = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt['net_total']);
				$net_total = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt['net_total']+$partial_depositews);
				$fd_key = $appt['fd_key'];
				$fd_amount = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$appt['fd_amount']);
			
				$referral_code = '';
				if(!is_numeric($refer_discountid)){
					$referral_code = $refer_discountid;
				}else{
					if($refer_discountid>0){
						$referral_code = $obj_bookings->get_referral_code_by_id($refer_discountid);
					}
				}
				
			
				/* Loyalty Points If Used */
				$loyalty_points_used =0;
				$loyalty_points_usedval =0;
				if($rzvy_allow_loyalty_points_status=='Y'){
					$usedpoints = $obj_loyalty_points->get_used_points_customer_by_order_id($order_id);
					if(isset($usedpoints) && $usedpoints!=''){
						$loyalty_points_used = $usedpoints;
						$loyalty_points_usedval = $rzvy_perbooking_loyalty_point_value*$usedpoints;
					}
				}
				$loyalty_points_amount = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$loyalty_points_usedval).'('.$loyalty_points_used.' '.$pointslabel.')';
				if($loyalty_points_used==0){
					$loyalty_points_amount = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$loyalty_points_usedval);
				}
				
				?>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['payment_method_ad'])){ echo $rzvy_translangArr['payment_method_ad']; }else{ echo $rzvy_defaultlang['payment_method_ad']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $payment_method; ?>
					</div>
				  </div>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['payment_date'])){ echo $rzvy_translangArr['payment_date']; }else{ echo $rzvy_defaultlang['payment_date']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $payment_date; ?>
					</div>
				  </div>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['transaction_id_ad'])){ echo $rzvy_translangArr['transaction_id_ad']; }else{ echo $rzvy_defaultlang['transaction_id_ad']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php if($transaction_id != ""){ echo $transaction_id; }else{ echo "-"; } ?>
					</div>
				  </div>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['sub_total'])){ echo $rzvy_translangArr['sub_total']; }else{ echo $rzvy_defaultlang['sub_total']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $sub_total; ?>
					</div>
				  </div>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['coupon_discount'])){ echo $rzvy_translangArr['coupon_discount']; }else{ echo $rzvy_defaultlang['coupon_discount']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $discount; ?>
					</div>
				  </div>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(!is_numeric($refer_discountid)){ ?>
							<?php if(isset($rzvy_translangArr['referral_discount_a'])){ echo $rzvy_translangArr['referral_discount_a']; }else{ echo $rzvy_defaultlang['referral_discount_a']; } ?>
						<?php } else{ ?>
							<?php if(isset($rzvy_translangArr['referral_coupon_discount'])){ echo $rzvy_translangArr['referral_coupon_discount']; }else{ echo $rzvy_defaultlang['referral_coupon_discount']; } ?>
						<?php } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $refer_discount; ?>
					</div>
				  </div>
				  
				  <?php if($refer_discountwcs>0){ ?>
				 <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(!is_numeric($refer_discountid)){ ?>
							<?php if(isset($rzvy_translangArr['referred_code'])){ echo $rzvy_translangArr['referred_code']; }else{ echo $rzvy_defaultlang['referred_code']; } ?>
						<?php } else{ ?>
							<?php if(isset($rzvy_translangArr['referral_code'])){ echo $rzvy_translangArr['referral_code']; }else{ echo $rzvy_defaultlang['referral_code']; } ?>
						<?php } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $referral_code; ?>
					</div>
				  </div>
				  <?php } ?>
				  
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['frequently_discount'])){ echo $rzvy_translangArr['frequently_discount']; }else{ echo $rzvy_defaultlang['frequently_discount']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php if($fd_key != ""){ if($fd_key=="weekly"){ echo $fq_weekly_label; }else if($fd_key=="bi weekly"){ echo $fq_biweekly_label; }else if($fd_key=="monthly"){ echo $fq_monthly_label; }else{ echo $fq_one_time_label; } echo " - ".$fd_amount; }else{ echo "-"; } ?>
					</div>
				  </div>
				  
				  <?php 
				  /* Services Package Discount Display */
					$Rzvy_Hooks->do_action('services_package_discount_bookingdetail', array((isset($rzvy_translangArr)?$rzvy_translangArr:array()), $rzvy_defaultlang,$rzvy_currency_symbol,$order_id,$rzvy_currency_position));
				  /* Services Package Discount Display End */
				  ?>
				  
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['tax'])){ echo $rzvy_translangArr['tax']; }else{ echo $rzvy_defaultlang['tax']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $tax; ?>
					</div>
				  </div>
				  <?php if($partial_depositews>0){ ?>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['partial_deposite_ad'])){ echo $rzvy_translangArr['partial_deposite_ad']; }else{ echo $rzvy_defaultlang['partial_deposite_ad']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $onlinepaid; ?>
					</div>
				  </div>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['online_pending_payment'])){ echo $rzvy_translangArr['online_pending_payment']; }else{ echo $rzvy_defaultlang['online_pending_payment']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $partial_deposite; ?>
					</div>
				  </div>
				  <?php } ?>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['loyalty_points_amount'])){ echo $rzvy_translangArr['loyalty_points_amount']; }else{ echo $rzvy_defaultlang['loyalty_points_amount']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $loyalty_points_amount; ?>
					</div>
				  </div>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['net_total'])){ echo $rzvy_translangArr['net_total']; }else{ echo $rzvy_defaultlang['net_total']; } ?></b>
					</div>
					<div class="col-md-9">
						<?php echo $net_total; ?>
					</div>
				  </div>
				<?php
			}
		}
	}
}

/* Get Customer Detail tab */
else if(isset($_POST['customer_detail_tab'])){
	$order_id = $_POST['order_id'];
	$obj_bookings->order_id = $order_id;
	$all_detail = $obj_bookings->get_customer_detail_tab();
	
	if(mysqli_num_rows($all_detail)>0){
		while($appt = mysqli_fetch_assoc($all_detail)){	
			$customer_name = ucwords($appt['c_firstname']." ".$appt['c_lastname']);
			$customer_phone = $appt['c_phone'];
			$customer_email = $appt['c_email'];
			$customer_address = $appt['c_address'];
			$customer_city = $appt['c_city'];
			$customer_state = $appt['c_state'];
			$customer_country = $appt['c_country'];
			$customer_zip = $appt['c_zip']; 
			$customer_dob = $appt['c_dob'];
			
			if($customer_name != "" && $customer_name != " "){ 
				?>
				<div class="row rzvy-mb-5">
					<div class="col-md-2">
						<b><?php if(isset($rzvy_translangArr['name_ad'])){ echo $rzvy_translangArr['name_ad']; }else{ echo $rzvy_defaultlang['name_ad']; } ?></b>
					</div>
					<div class="col-md-10">
						<?php echo $customer_name; ?>
					</div>
				</div>
				<?php 
			}
			if($customer_email != ""){ 
				?>
				<div class="row rzvy-mb-5">
					<div class="col-md-2">
						<b><?php if(isset($rzvy_translangArr['email_ad'])){ echo $rzvy_translangArr['email_ad']; }else{ echo $rzvy_defaultlang['email_ad']; } ?></b>
					</div>
					<div class="col-md-10">
						<?php echo $customer_email; ?>
					</div>
				</div>
				<?php 
			}
			if($customer_phone != ""){ 
				?>
				<div class="row rzvy-mb-5">
					<div class="col-md-2">
						<b><?php if(isset($rzvy_translangArr['phone_ad'])){ echo $rzvy_translangArr['phone_ad']; }else{ echo $rzvy_defaultlang['phone_ad']; } ?></b>
					</div>
					<div class="col-md-10">
						<?php echo $customer_phone; ?>
					</div>
				</div>
				<?php 
			}
			if($customer_dob != "" && $customer_dob != "0000-00-00"){ 
				?>
				<div class="row rzvy-mb-5">
					<div class="col-md-2">
						<b><?php if(isset($rzvy_translangArr['birthdate_ad'])){ echo $rzvy_translangArr['birthdate_ad']; }else{ echo $rzvy_defaultlang['birthdate_ad']; } ?></b>
					</div>
					<div class="col-md-10">
						<?php if($obj_settings->get_option('rzvy_birthdate_with_year') == "Y"){ echo date("j F Y", strtotime($customer_dob)); }else{ echo date("j F", strtotime($customer_dob)); } ?>
					</div>
				</div>
				<?php 
			}
			if($customer_address != ""){ 
				?>
				<div class="row rzvy-mb-5">
					<div class="col-md-2">
						<b><?php if(isset($rzvy_translangArr['address_ad'])){ echo $rzvy_translangArr['address_ad']; }else{ echo $rzvy_defaultlang['address_ad']; } ?></b>
					</div>
					<div class="col-md-10">
						<?php echo $customer_address; ?>
					</div>
				</div>
				<?php 
			}
			if($customer_city != ""){ 
				?>
				<div class="row rzvy-mb-5">
					<div class="col-md-2">
						<b><?php if(isset($rzvy_translangArr['city_ad'])){ echo $rzvy_translangArr['city_ad']; }else{ echo $rzvy_defaultlang['city_ad']; } ?></b>
					</div>
					<div class="col-md-10">
						<?php echo $customer_city; ?>
					</div>
				</div>
				<?php 
			}
			if($customer_state != ""){ 
				?>
				<div class="row rzvy-mb-5">
					<div class="col-md-2">
						<b><?php if(isset($rzvy_translangArr['state_ad'])){ echo $rzvy_translangArr['state_ad']; }else{ echo $rzvy_defaultlang['state_ad']; } ?></b>
					</div>
					<div class="col-md-10">
						<?php echo $customer_state; ?>
					</div>
				</div>
				<?php 
			}
			if($customer_country != ""){ 
				?>
				<div class="row rzvy-mb-5">
					<div class="col-md-2">
						<b><?php if(isset($rzvy_translangArr['country_ad'])){ echo $rzvy_translangArr['country_ad']; }else{ echo $rzvy_defaultlang['country_ad']; } ?></b>
					</div>
					<div class="col-md-10">
						<?php echo $customer_country; ?>
					</div>
				</div>
				<?php 
			}
			if($customer_zip != "" && $customer_zip != "N/A"){ 
				?>
				<div class="row rzvy-mb-5">
					<div class="col-md-2">
						<b><?php if(isset($rzvy_translangArr['zip_ad'])){ echo $rzvy_translangArr['zip_ad']; }else{ echo $rzvy_defaultlang['zip_ad']; } ?></b>
					</div>
					<div class="col-md-10">
						<?php echo $customer_zip; ?>
					</div>
				</div>
				<?php 
			}
		}
	}
}

/* Get Reschedule Appointment detail tab */
else if(isset($_POST['rzvy_reschedule_appointment_tab'])){
	$order_id = $_POST['order_id'];
	$obj_bookings->order_id = $order_id;
	$all_detail = $obj_bookings->get_reschedule_appointment_detail();
	
	if(mysqli_num_rows($all_detail)>0){
		$rzvy_endtimeslot_selection_status = $obj_settings->get_option('rzvy_endtimeslot_selection_status');
		$advance_bookingtime = $obj_settings->get_option('rzvy_maximum_advance_booking_time');
		$time_interval = $obj_settings->get_option('rzvy_timeslot_interval');
		$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
		$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
		while($appt = mysqli_fetch_assoc($all_detail)){
			$service_id = $appt['service_id'];
			$staff_id = $appt['staff_id'];
			
			$booking_datetime = $appt['booking_datetime'];
			$booking_date = date("Y-m-d", strtotime($booking_datetime));
			$booking_time = date("H:i:s", strtotime($booking_datetime));
			
			$booking_end_datetime = $appt['booking_end_datetime'];
			$booking_enddate = date("Y-m-d", strtotime($booking_end_datetime));
			$booking_endtime = date("H:i:s", strtotime($booking_end_datetime));
			
			$reschedule_reason = $appt['reschedule_reason']; 
			$rzvy_settings_timezone = $obj_settings->get_option("rzvy_timezone");
			$rzvy_server_timezone = date_default_timezone_get();
			$currDateTime_withTZ = $obj_settings->get_current_time_according_selected_timezone($rzvy_server_timezone,$rzvy_settings_timezone); 
			?>
			<input type="hidden" name="rzvy_appt_rs_sid" id="rzvy_appt_rs_sid" value="<?php echo $service_id; ?>" />
			  <input type="hidden" name="rzvy_appt_rs_staffid" id="rzvy_appt_rs_staffid" value="<?php echo $staff_id; ?>" />
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['date_time_ad'])){ echo $rzvy_translangArr['date_time_ad']; }else{ echo $rzvy_defaultlang['date_time_ad']; } ?></b>
				</div>
				<div class="col-md-4">
					<input class="form-control" id="rzvy_appt_rs_date" name="rzvy_appt_rs_date" type="date" data-datetime="<?php echo $booking_datetime; ?>" data-oid="<?php echo $order_id; ?>" value="<?php echo $booking_date; ?>" required />
				</div>
			  </div>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['start_time_ad'])){ echo $rzvy_translangArr['start_time_ad']; }else{ echo $rzvy_defaultlang['start_time_ad']; } ?></b>
				</div>
				<div class="col-md-4">
					<select class="form-control rzvy_appt_rs_timeslot <?php /* if($rzvy_endtimeslot_selection_status == "Y"){ echo "endslot_selection_exist"; } */ ?>">
					</select>
				</div>
			  </div>
			  <?php 
			  if($rzvy_endtimeslot_selection_status == "Y"){
				  ?>
				  <div class="row rzvy-mb-5">
					<div class="col-md-3">
						<b><?php if(isset($rzvy_translangArr['end_time_ad'])){ echo $rzvy_translangArr['end_time_ad']; }else{ echo $rzvy_defaultlang['end_time_ad']; } ?></b>
					</div>
					<div class="col-md-4">
						<select class="form-control rzvy_appt_rs_endtimeslot">
							
						</select>
					</div>
				  </div>
				<?php 
			  } else{ 
				  ?>
				  <input type="hidden" name="rzvy_appt_rs_endtimeslot" class="rzvy_appt_rs_endtimeslot rzvy_appt_rs_endtimeslot_input" value="<?php echo $booking_endtime; ?>" />
				  <?php 
			  } 
			  ?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['reschedule_reason_ad'])){ echo $rzvy_translangArr['reschedule_reason_ad']; }else{ echo $rzvy_defaultlang['reschedule_reason_ad']; } ?></b>
				</div>
				<div class="col-md-9">
					<textarea class="form-control" id="rzvy_appt_rs_reason" name="rzvy_appt_rs_reason" placeholder="<?php if(isset($rzvy_translangArr['enter_reschedule_reason'])){ echo $rzvy_translangArr['enter_reschedule_reason']; }else{ echo $rzvy_defaultlang['enter_reschedule_reason']; } ?>"><?php echo $reschedule_reason; ?></textarea>
				</div>
			  </div>
			  <div class="row rzvy-mt-20">
				<div class="col-md-12">
					<a href="javascript:void(0)" data-id="<?php echo $order_id; ?>" class="btn btn-primary rzvy-fullwidth rzvy_appt_rs_now_btn"><?php if(isset($rzvy_translangArr['reschedule_now'])){ echo $rzvy_translangArr['reschedule_now']; }else{ echo $rzvy_defaultlang['reschedule_now']; } ?></a>
				</div>
			  </div>
			<?php
		}
	}
}

/* Get Reject Appointment detail tab */
else if(isset($_POST['rzvy_reject_appointment_tab'])){
	$order_id = $_POST['order_id'];
	$obj_bookings->order_id = $order_id;
	$all_detail = $obj_bookings->get_reject_appointment_detail();
	
	if(mysqli_num_rows($all_detail)>0){
		while($appt = mysqli_fetch_assoc($all_detail)){
			$reject_reason = $appt['reject_reason']; 
			?>
			  <div class="row rzvy-mb-5">
				<div class="col-md-3">
					<b><?php if(isset($rzvy_translangArr['cancellation_reason_ad'])){ echo $rzvy_translangArr['cancellation_reason_ad']; }else{ echo $rzvy_defaultlang['cancellation_reason_ad']; } ?></b>
				</div>
				<div class="col-md-9">
					<textarea class="form-control" id="rzvy_appt_reject_reason" name="rzvy_appt_reject_reason" placeholder="<?php if(isset($rzvy_translangArr['enter_reject_reason'])){ echo $rzvy_translangArr['enter_reject_reason']; }else{ echo $rzvy_defaultlang['enter_reject_reason']; } ?>"><?php echo $reject_reason; ?></textarea>
				</div>
			  </div>
			  <div class="row rzvy-mt-20">
				<div class="col-md-12">
					<a href="javascript:void(0)" data-id="<?php echo $order_id; ?>" class="btn btn-danger rzvy-fullwidth rzvy_appt_reject_now_btn"><?php if(isset($rzvy_translangArr['cancel_now'])){ echo $rzvy_translangArr['cancel_now']; }else{ echo $rzvy_defaultlang['cancel_now']; } ?></a>
				</div>
			  </div>
			  <?php 
			  if($obj_settings->get_option("rzvy_refund_status") == "Y" && $rzvy_price_display=='Y'){ 
				$rzvy_refund_request_buffer_time = $obj_settings->get_option("rzvy_refund_request_buffer_time");
				$rzvy_settings_timezone = $obj_settings->get_option("rzvy_timezone");
				$rzvy_server_timezone = date_default_timezone_get();
				$currDateTime_withTZ = $obj_settings->get_current_time_according_selected_timezone($rzvy_server_timezone,$rzvy_settings_timezone); 

				$cdate = date("Y-m-d H:i:s", $currDateTime_withTZ);
				$bdate = date("Y-m-d H:i:s", strtotime("-".$rzvy_refund_request_buffer_time." minutes", strtotime($appt['booking_datetime']))); 
				?>
				<hr />
                <div class="row mt-3">
					<div class="col-md-12">
						<?php 
						$rzvy_refund_summary = base64_decode($obj_settings->get_option("rzvy_refund_summary"));
						if(strtotime($cdate)<strtotime($bdate)){
							$rzvy_refund_type = $obj_settings->get_option("rzvy_refund_type");
							$rzvy_refund_value = $obj_settings->get_option("rzvy_refund_value");
							
							
							
							if(isset($rzvy_translangArr['you_eligible_get_refund'])){ 
								$you_eligible_get_refund = $rzvy_translangArr['you_eligible_get_refund'];
							}else{
								$you_eligible_get_refund = $rzvy_defaultlang['you_eligible_get_refund'];
							}
							if(isset($rzvy_translangArr['minimum_refund_warning'])){ 
								$minimum_refund_warning = $rzvy_translangArr['minimum_refund_warning'];
							}else{
								 $minimum_refund_warning = $rzvy_defaultlang['minimum_refund_warning'];
							}
							
							
							
							if($rzvy_refund_type == "percentage"){
								$ramount = ($appt['net_total']*$rzvy_refund_value/100);
							}else{
								$ramount = $rzvy_refund_value;
							}
							$ramount = number_format($ramount,2,".",'');
							if($ramount < $appt['net_total']){
								echo "<h5><i class='fa fa-check-square-o text-success'></i>  ".$you_eligible_get_refund."<b>".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$ramount)."</b></h5>"; 
							}else{
								echo "<p><i class='fa fa-exclamation-triangle text-warning'></i> <span class='text-dark'> ".$minimum_refund_warning."<b class='text-danger'>".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$ramount)."</b></span></p>";
							} 
							if($rzvy_refund_summary != ""){ 
								?>
								<div id="rzvy-refund-policy-block" class="row">
									<div class="col-md-12">
										<?php echo $rzvy_refund_summary; ?>
									</div>
								</div>
								<?php 
							}
						}else{ 
							if($rzvy_refund_request_buffer_time<60){
								$hours = $rzvy_refund_request_buffer_time." minutes";
							}else if($rzvy_refund_request_buffer_time==60){
								$hours = "1 hour";
							}else{
								$hours = floor($rzvy_refund_request_buffer_time / 60)." hours";
							}
							
							if(isset($rzvy_translangArr['opps_not_eligible_get_refund'])){ 
								$opps_not_eligible_get_refund = $rzvy_translangArr['opps_not_eligible_get_refund'];
							}else{
								$opps_not_eligible_get_refund = $rzvy_defaultlang['opps_not_eligible_get_refund'];
							}
							if(isset($rzvy_translangArr['you_can_receive_at'])){ 
								$you_can_receive_at = $rzvy_translangArr['you_can_receive_at'];
							}else{
								$you_can_receive_at = $rzvy_defaultlang['you_can_receive_at'];
							}
							if(isset($rzvy_translangArr['before_appointment_time'])){ 
								$before_appointment_time = $rzvy_translangArr['before_appointment_time'];
							}else{
								$before_appointment_time = $rzvy_defaultlang['before_appointment_time'];
							}
							
							 
							
							echo "<p><i class='fa fa-exclamation-triangle text-warning'></i> <span class='text-dark'>".$opps_not_eligible_get_refund."</span></p>";
							echo "<p><i class='fa fa-info-circle text-dark'></i> <span class='text-dark'>".$you_can_receive_at." <b>".$hours."</b> ".$before_appointment_time."</span></p>"; 
							if($rzvy_refund_summary != ""){ 
								?>
								<div id="rzvy-refund-policy-block" class="row">
									<div class="col-md-12">
										<?php echo $rzvy_refund_summary; ?>
									</div>
								</div>
								<?php 
							}
						} 
						?>
						
					</div>
				</div>
				<?php 
			  }
		}
	}
}

/* Get Slots On Date change */
else if(isset($_POST['rzvy_slots_on_date_change'])){
	$order_id = $_POST['order_id'];
	$staff_id = $_POST['staff_id'];
	$obj_bookings->order_id = $order_id;
	$appointment_detail = $obj_bookings->get_appointment_status_and_datetime();

	$advance_bookingtime = $obj_settings->get_option('rzvy_minimum_advance_booking_time');
	$time_interval = $obj_settings->get_option('rzvy_timeslot_interval');
	$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
	$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
	
	$booking_datetime = $_POST['booking_datetime'];
	$booked_time = date("H:i:s", strtotime($booking_datetime));
	$booking_time = date("H:i:s", strtotime($booking_datetime));

	$rzvy_settings_timezone = $obj_settings->get_option("rzvy_timezone");
	$rzvy_server_timezone = date_default_timezone_get();
	$currDateTime_withTZ = $obj_settings->get_current_time_according_selected_timezone($rzvy_server_timezone,$rzvy_settings_timezone); 
	
	$selected_date = date("Y-m-d", strtotime($_POST['selected_date']));
	$selected_date = date($selected_date, $currDateTime_withTZ);
	$current_date = date("Y-m-d", $currDateTime_withTZ);
	
	if(strtotime($selected_date)<strtotime($current_date)){
		$bdate = date("Y-m-d", strtotime($booking_datetime));
		if($bdate == $selected_date){ 
			?>
			<option value="<?php echo $booked_time; ?>" selected>
				<?php echo date($rzvy_time_format,strtotime($booking_datetime)); ?>
			</option>
			<?php 
		}else{
			/** No slots for previous dates booking **/
		}
	}else{
		$isEndTime = false;
		$obj_slots->staff_id = $staff_id;
		$addon_duration = $obj_slots->fetch_addon_duration($appointment_detail['addons']);
		$available_slots = $obj_slots->generate_available_slots_dropdown($time_interval, $rzvy_time_format, $selected_date, $advance_bookingtime, $currDateTime_withTZ, $isEndTime, $_POST["service_id"], $addon_duration);
		
		$no_booking = $available_slots['no_booking'];
		if($available_slots['no_booking']<0){
			$no_booking = 0;
		}
		
		/** check for GC bookings START **/
		$gc_twowaysync_eventsArr = array();
		$rzvy_gc_status = $obj_settings->get_option('rzvy_gc_status');
		$rzvy_gc_twowaysync = $obj_settings->get_option('rzvy_gc_twowaysync');
		$rzvy_gc_clientid = $obj_settings->get_option('rzvy_gc_clientid');
		$rzvy_gc_clientsecret = $obj_settings->get_option('rzvy_gc_clientsecret');
		$rzvy_gc_accesstoken = $obj_settings->get_option('rzvy_gc_accesstoken');
		$rzvy_gc_accesstoken = base64_decode($rzvy_gc_accesstoken);
		
		if($rzvy_gc_status == "Y" && $rzvy_gc_twowaysync == "Y" && $rzvy_gc_clientid != "" && $rzvy_gc_clientsecret != "" && $rzvy_gc_accesstoken != ""){
			$getNewTime = new \DateTime('now', new DateTimeZone($rzvy_settings_timezone));
			$timezoneOffset = $getNewTime->format('P');
			
			include(dirname(dirname(dirname(__FILE__)))."/includes/google-calendar/vendor/autoload.php");
			$client = new Google_Client();
			$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
			$client->setClientId($rzvy_gc_clientid);
			$client->setClientSecret($rzvy_gc_clientsecret);
			$client->setAccessType('offline');
			$client->setPrompt('select_account consent');

			$accessToken = unserialize($rzvy_gc_accesstoken);
			$client->setAccessToken($accessToken);
			if ($client->isAccessTokenExpired()) {
				$newAccessToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
				$obj_settings->update_option('rzvy_gc_accesstoken',base64_encode(serialize($newAccessToken)));
			}
			$service = new Google_Service_Calendar($client);

			$calendarId = (($obj_settings->get_option('rzvy_gc_calendarid')!= "")?$obj_settings->get_option('rzvy_gc_calendarid'):'primary');
			$optParams = array(
			  'orderBy' => 'startTime',
			  'singleEvents' => true,
			  'timeZone' => $rzvy_settings_timezone,
			  'timeMin' => $selected_date.'T00:00:00'.$timezoneOffset,
			  'timeMax' => $selected_date.'T23:59:59'.$timezoneOffset,
			);
			$results = $service->events->listEvents($calendarId, $optParams);
			$events = $results->getItems();

			if (!empty($events)) {
				foreach ($events as $event) {
					if(!isset($event->transparency) || (isset($event->transparency) && $event->transparency!='transparent')){			
						$EventStartTime = substr($event->start->dateTime, 0, 19);
						$EventEndTime = substr($event->end->dateTime, 0, 19);
						$gcEventArr = array();
						$gcEventArr['start'] = date("Y-m-d H:i", strtotime(str_replace("T"," ",$EventStartTime)));
						$gcEventArr['end'] = date("Y-m-d H:i", strtotime(str_replace("T"," ",$EventEndTime)));
						array_push($gc_twowaysync_eventsArr, $gcEventArr);
					}
				}
			}
		}
		/** check for GC bookings END **/
		
		/** check for staff GC bookings START **/
		if($staff_id>0){
			$obj_settings->staff_id = $staff_id;
			$rzvy_gc_status = $obj_settings->get_staff_option('rzvy_gc_status');
			$rzvy_gc_twowaysync = $obj_settings->get_staff_option('rzvy_gc_twowaysync');
			$rzvy_gc_accesstoken = $obj_settings->get_staff_option('rzvy_gc_accesstoken');
			$rzvy_gc_accesstoken = base64_decode($rzvy_gc_accesstoken);
			
			if($rzvy_gc_status == "Y" && $rzvy_gc_twowaysync == "Y" && $rzvy_gc_clientid != "" && $rzvy_gc_clientsecret != "" && $rzvy_gc_accesstoken != ""){
				$getNewTime = new \DateTime('now', new DateTimeZone($rzvy_settings_timezone));
				$timezoneOffset = $getNewTime->format('P');
				
				include(dirname(dirname(dirname(__FILE__)))."/includes/google-calendar/vendor/autoload.php");
				$client = new Google_Client();
				$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
				$client->setClientId($rzvy_gc_clientid);
				$client->setClientSecret($rzvy_gc_clientsecret);
				$client->setAccessType('offline');
				$client->setPrompt('select_account consent');

				$accessToken = unserialize($rzvy_gc_accesstoken);
				$client->setAccessToken($accessToken);
				if ($client->isAccessTokenExpired()) {
					$newAccessToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
					$obj_settings->update_staff_option('rzvy_gc_accesstoken',base64_encode(serialize($newAccessToken)));
				}
				$service = new Google_Service_Calendar($client);

				$calendarId = (($obj_settings->get_staff_option('rzvy_gc_calendarid')!= "")?$obj_settings->get_staff_option('rzvy_gc_calendarid'):'primary');
				$optParams = array(
				  'orderBy' => 'startTime',
				  'singleEvents' => true,
				  'timeZone' => $rzvy_settings_timezone,
				  'timeMin' => $selected_date.'T00:00:00'.$timezoneOffset,
				  'timeMax' => $selected_date.'T23:59:59'.$timezoneOffset,
				);
				$results = $service->events->listEvents($calendarId, $optParams);
				$events = $results->getItems();

				if (!empty($events)) {
					foreach ($events as $event) {
						if(!isset($event->transparency) || (isset($event->transparency) && $event->transparency!='transparent')){			
							$EventStartTime = substr($event->start->dateTime, 0, 19);
							$EventEndTime = substr($event->end->dateTime, 0, 19);
							$gcEventArr = array();
							$gcEventArr['start'] = date("Y-m-d H:i", strtotime(str_replace("T"," ",$EventStartTime)));
							$gcEventArr['end'] = date("Y-m-d H:i", strtotime(str_replace("T"," ",$EventEndTime)));
							array_push($gc_twowaysync_eventsArr, $gcEventArr);
						}
					}
				}
			}
		}
		/** check for GC bookings END **/
		
		if(isset($available_slots['slots']) && sizeof($available_slots['slots'])>0)
		{
			foreach($available_slots['slots'] as $slot) 
			{
				$bookings_blocks = $obj_slots->get_bookings_blocks($selected_date, $slot, $available_slots["serviceaddonduration"]);
				if(!$bookings_blocks){
					continue;
				}
				$no_curr_boookings = $obj_slots->get_slot_bookings($selected_date." ".$slot,$appointment_detail['service_id']);
				$booked_slot_exist = false;
				foreach($gc_twowaysync_eventsArr as $event){
					if(strtotime($event["start"]) <= strtotime($selected_date." ".$slot) && strtotime($event["end"]) > strtotime($selected_date." ".$slot)){
						$no_curr_boookings += 1;
					}
					if(strtotime($event["start"]) <= strtotime($selected_date." ".$slot) && strtotime($event["end"]) > strtotime($selected_date." ".$slot) && $no_booking==0){
						$booked_slot_exist = true;
						continue;
					} 
					else if(strtotime($event["start"]) <= strtotime($selected_date." ".$slot) && strtotime($event["end"]) > strtotime($selected_date." ".$slot) && $no_booking!=0 && $no_curr_boookings>=$no_booking){
						$booked_slot_exist = true;
						continue;
					} 
				}
				
				$new_endtime_timestamp = strtotime("+".$available_slots["serv_timeinterval"]." minutes", strtotime($selected_date." ".$slot));
				$new_starttime_timestamp = strtotime($selected_date." ".$slot);
				
				foreach($available_slots['booked'] as $bslot){
					if($bslot["start_time"] <= strtotime($selected_date." ".$slot) && $bslot["end_time"] > strtotime($selected_date." ".$slot) && $no_booking==0){
						$booked_slot_exist = true;
						continue;
					} 
					else if($bslot["start_time"] <= strtotime($selected_date." ".$slot) && $bslot["end_time"] > strtotime($selected_date." ".$slot) && $no_booking!=0 && $no_curr_boookings>=$no_booking){
						$booked_slot_exist = true;
						continue;
					} 
					
					if($new_starttime_timestamp <= $bslot["start_time"] && $new_endtime_timestamp > $bslot["start_time"] && $no_booking==0){
						$booked_slot_exist = true;
						continue;
					}
					
					if($new_starttime_timestamp <= $bslot["start_time"] && $new_endtime_timestamp > $bslot["start_time"] && $no_booking!=0){
					    $no_curr_boookings = $no_curr_boookings+1;
					    if($no_curr_boookings>=$no_booking){
							$booked_slot_exist = true;
							continue;
					    }
					} 
					if($new_starttime_timestamp < $bslot["end_time"] && $new_endtime_timestamp > $bslot["end_time"] && $no_booking==0){
						$booked_slot_exist = true;
						continue;
					}
					
					if($new_starttime_timestamp < $bslot["end_time"] && $new_endtime_timestamp > $bslot["end_time"] && $no_booking!=0){
					    $no_curr_boookings = $no_curr_boookings+1;
					    if($no_curr_boookings>=$no_booking){
							$booked_slot_exist = true;
							continue;
					    }
					} 
				}
				if($booked_slot_exist){
					if(strtotime($booking_datetime) != strtotime($selected_date." ".$slot)){
						continue;
					}
				}
				
				$blockoff_exist = false;
				if(sizeof($available_slots['block_off'])>0){
					foreach($available_slots['block_off'] as $block_off){
						if((strtotime($selected_date." ".$block_off["start_time"]) <= strtotime($selected_date." ".$slot)) && (strtotime($selected_date." ".$block_off["end_time"]) > strtotime($selected_date." ".$slot))){
							if(strtotime($booking_datetime) != strtotime($selected_date." ".$slot)){
								$blockoff_exist = true;
								continue;
							}
						} 
					}
				} 
				if($blockoff_exist){
					continue;
				} 
				?>
				<option value="<?php echo $slot; ?>" <?php if(strtotime($booking_datetime) == strtotime($selected_date." ".$slot)){ echo "selected"; } ?>>
					<?php echo date($rzvy_time_format,strtotime($selected_date." ".$slot)); ?>
				</option>
				<?php
			}
		}
	}
}

/* Reschedule Appointment Ajax */
else if(isset($_POST['reschedule_appointment_detail'])){
	$order_id = $_POST['order_id'];
	$obj_bookings->order_id = $order_id;
	$appointment_detail = $obj_bookings->get_appointment_status_and_datetime();
	
	$time_interval = $obj_settings->get_option('rzvy_timeslot_interval');
		
	$reason = htmlentities($_POST['reason']);
	$booking_datetime = date("Y-m-d H:i:s", strtotime($_POST['date']." ".$_POST['slot']));
	$booking_end_datetime = date("Y-m-d H:i:s", strtotime($_POST['date']." ".$_POST['endslot']));
	/* $booking_end_datetime = date("Y-m-d H:i:s", strtotime('+'.$time_interval.' minutes',strtotime($booking_datetime))); */
	$obj_bookings->order_id = $order_id;
	$obj_bookings->booking_status = "rescheduled_by_customer";
	$obj_bookings->reschedule_reason = $reason;
	$obj_bookings->booking_datetime = $booking_datetime;
	$obj_bookings->booking_end_datetime = $booking_end_datetime;
	$updated = $obj_bookings->reschedule_appointment();
	if($updated){
		/********************** Send SMS & Email code start ***************************/
		include(dirname(dirname(dirname(__FILE__)))."/classes/class_es_information.php");
		$obj_es_information = new rzvy_es_information();
		$obj_es_information->conn = $conn;
		
		/**** Update to GC start **/
		$rzvy_gc_status = $obj_settings->get_option('rzvy_gc_status');
		$rzvy_gc_clientid = $obj_settings->get_option('rzvy_gc_clientid');
		$rzvy_gc_clientsecret = $obj_settings->get_option('rzvy_gc_clientsecret');
		$rzvy_gc_accesstoken = $obj_settings->get_option('rzvy_gc_accesstoken');
		$rzvy_gc_accesstoken = base64_decode($rzvy_gc_accesstoken);
		$eventId = $obj_es_information->get_appt_gc_eventid($order_id);
		if($rzvy_gc_status == "Y" && $rzvy_gc_clientid != "" && $rzvy_gc_clientsecret != "" && $rzvy_gc_accesstoken != "" && $eventId != ""){
			$rzvy_time_format = $obj_settings->get_option("rzvy_time_format");
			$rzvy_timezone = $obj_settings->get_option("rzvy_timezone");
			
			$getNewTime = new \DateTime('now', new DateTimeZone($rzvy_timezone));
			$timezoneOffset = $getNewTime->format('P');
			
			$gc_StartTime = str_replace(" ", "T", $booking_datetime).$timezoneOffset;
			$gc_EndTime = str_replace(" ", "T", $booking_end_datetime).$timezoneOffset;
			
			include(dirname(dirname(dirname(__FILE__)))."/includes/google-calendar/vendor/autoload.php");
			$client = new Google_Client();
			$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
			$client->setClientId($rzvy_gc_clientid);
			$client->setClientSecret($rzvy_gc_clientsecret);
			$client->setAccessType('offline');
			$client->setPrompt('select_account consent');

			$accessToken = unserialize($rzvy_gc_accesstoken);
			$client->setAccessToken($accessToken);
			if ($client->isAccessTokenExpired()) {
				$newAccessToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
				$obj_settings->update_option('rzvy_gc_accesstoken',base64_encode(serialize($newAccessToken)));
			}
			$service = new Google_Service_Calendar($client);
			$calendarId = (($obj_settings->get_option('rzvy_gc_calendarid')!= "")?$obj_settings->get_option('rzvy_gc_calendarid'):'primary');
			$event = $service->events->get($calendarId, $eventId);
			$startdateobj = new Google_Service_Calendar_EventDateTime(array(
				'dateTime' => $gc_StartTime,
				'timeZone' => $rzvy_timezone
			));
			$enddateobj = new Google_Service_Calendar_EventDateTime(array(
				'dateTime' => $gc_EndTime,
				'timeZone' => $rzvy_timezone
			));
			$event->setStart($startdateobj);
			$event->setEnd($enddateobj);
			$service->events->update('primary', $event->getId(), $event);
		}
		/*** Update to GC end **/
		
		/**** Update to staff GC start **/
		$gc_staff_id = $obj_settings->get_staffid_from_orderid($order_id);
		if($gc_staff_id>0){
			$obj_settings->staff_id = $gc_staff_id;
			$rzvy_gc_status = $obj_settings->get_staff_option('rzvy_gc_status');
			$rzvy_gc_accesstoken = $obj_settings->get_staff_option('rzvy_gc_accesstoken');
			$rzvy_gc_accesstoken = base64_decode($rzvy_gc_accesstoken);
			$eventId = $obj_es_information->get_appt_gc_eventid_staff($order_id);
			if($rzvy_gc_status == "Y" && $rzvy_gc_clientid != "" && $rzvy_gc_clientsecret != "" && $rzvy_gc_accesstoken != "" && $eventId != ""){
				$rzvy_time_format = $obj_settings->get_option("rzvy_time_format");
				$rzvy_timezone = $obj_settings->get_option("rzvy_timezone");
				
				$getNewTime = new \DateTime('now', new DateTimeZone($rzvy_timezone));
				$timezoneOffset = $getNewTime->format('P');
				
				$gc_StartTime = str_replace(" ", "T", $booking_datetime).$timezoneOffset;
				$gc_EndTime = str_replace(" ", "T", $booking_end_datetime).$timezoneOffset;
				
				include(dirname(dirname(dirname(__FILE__)))."/includes/google-calendar/vendor/autoload.php");
				$client = new Google_Client();
				$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
				$client->setClientId($rzvy_gc_clientid);
				$client->setClientSecret($rzvy_gc_clientsecret);
				$client->setAccessType('offline');
				$client->setPrompt('select_account consent');

				$accessToken = unserialize($rzvy_gc_accesstoken);
				$client->setAccessToken($accessToken);
				if ($client->isAccessTokenExpired()) {
					$newAccessToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
					$obj_settings->update_staff_option('rzvy_gc_accesstoken',base64_encode(serialize($newAccessToken)));
				}
				$service = new Google_Service_Calendar($client);
				$calendarId = (($obj_settings->get_staff_option('rzvy_gc_calendarid')!= "")?$obj_settings->get_staff_option('rzvy_gc_calendarid'):'primary');
				$event = $service->events->get($calendarId, $eventId);
				$startdateobj = new Google_Service_Calendar_EventDateTime(array(
					'dateTime' => $gc_StartTime,
					'timeZone' => $rzvy_timezone
				));
				$enddateobj = new Google_Service_Calendar_EventDateTime(array(
					'dateTime' => $gc_EndTime,
					'timeZone' => $rzvy_timezone
				));
				$event->setStart($startdateobj);
				$event->setEnd($enddateobj);
				$service->events->update('primary', $event->getId(), $event);
			}
		}
		/*** Update to staff GC end **/
		
		$get_es_appt_detail_by_order_id = $obj_es_information->get_es_appt_detail_by_order_id($order_id);
		
		if(mysqli_num_rows($get_es_appt_detail_by_order_id)>0){
			$es_appt_detail = mysqli_fetch_array($get_es_appt_detail_by_order_id);
			$es_staff_id = $es_appt_detail['staff_id'];
			$es_template = "reschedulec";
			$es_category_id = $es_appt_detail['cat_id'];
			$es_service_id = $es_appt_detail['service_id'];
			$es_booking_datetime = $es_appt_detail['booking_datetime'];
			$es_transaction_id = $es_appt_detail['transaction_id'];
			$es_subtotal = $es_appt_detail['sub_total'];
			$es_coupondiscount = $es_appt_detail['discount'];
			$es_freqdiscount = $es_appt_detail['fd_amount'];
			$es_tax = $es_appt_detail['tax'];
			$es_nettotal = $es_appt_detail['net_total'];
			$es_payment_method = $es_appt_detail['payment_method'];
			if($es_payment_method==ucwords('pay-at-venue')){
				if(isset($rzvy_translangArr['pay_at_venue'])){ $es_payment_method = $rzvy_translangArr['pay_at_venue']; }else{ $es_payment_method = $rzvy_defaultlang['pay_at_venue']; } 
			}
			$es_firstname = $es_appt_detail['c_firstname'];
			$es_lastname = $es_appt_detail['c_lastname'];
			$es_email = $es_appt_detail['c_email'];
			$es_phone = $es_appt_detail['c_phone'];
			$es_address = $es_appt_detail['c_address'];
			$es_city = $es_appt_detail['c_city'];
			$es_state = $es_appt_detail['c_state'];
			$es_country = $es_appt_detail['c_country'];
			$es_zip = $es_appt_detail['c_zip'];
			$es_addons_items_arr = $es_appt_detail['addons'];
			$es_reschedule_reason = $es_appt_detail['reschedule_reason'];
			$es_reject_reason = $es_appt_detail['reject_reason'];
			$es_cancel_reason = $es_appt_detail['cancel_reason'];
			
			$rzvy_cancel_feedback_sms_shortlink = $obj_settings->get_option('rzvy_cancel_feedback_sms_shortlink');
			if($rzvy_cancel_feedback_sms_shortlink!=""){
				$shortlinkurl = $rzvy_cancel_feedback_sms_shortlink;
			}else{
				$shortlinkurl = SITE_URL;
			}
			
			$cancel_url = $shortlinkurl.'c/B'.rand(101,999).base64_encode($order_id);
			include("rzvy_send_sms_email_process.php");
		}
		@ob_clean(); ob_start();
		/********************** Send SMS & Email code END ****************************/
		echo "updated";
	}
}

/* Reject Appointment Ajax */
else if(isset($_POST['reject_customerappointment_detail'])){
	$order_id = $_POST['order_id'];
	$obj_bookings->order_id = $order_id;
	$all_detail = $obj_bookings->get_reject_appointment_detail();
	if(mysqli_num_rows($all_detail)>0){
		while($appt = mysqli_fetch_assoc($all_detail)){
			if($obj_settings->get_option("rzvy_refund_status") == "Y"){ 
				$rzvy_refund_request_buffer_time = $obj_settings->get_option("rzvy_refund_request_buffer_time");
				$rzvy_settings_timezone = $obj_settings->get_option("rzvy_timezone");
				$rzvy_server_timezone = date_default_timezone_get();
				$currDateTime_withTZ = $obj_settings->get_current_time_according_selected_timezone($rzvy_server_timezone,$rzvy_settings_timezone); 

				$cdate = date("Y-m-d H:i:s", $currDateTime_withTZ);
				$bdate = date("Y-m-d H:i:s", strtotime("-".$rzvy_refund_request_buffer_time." minutes", strtotime($appt['booking_datetime']))); 
			
				if(strtotime($cdate)<strtotime($bdate)){ 
					$rzvy_refund_type = $obj_settings->get_option("rzvy_refund_type");
					$rzvy_refund_value = $obj_settings->get_option("rzvy_refund_value");
					
					if($rzvy_refund_type == "percentage"){
						$ramount = ($appt['net_total']*$rzvy_refund_value/100);
					}else{
						$ramount = $rzvy_refund_value;
					}
					$ramount = number_format($ramount,2,".",'');
					if($ramount < $appt['net_total']){
						/** Insert refund request function **/
						include(dirname(dirname(dirname(__FILE__)))."/classes/class_refund_request.php");
						$obj_refund_request = new rzvy_refund_request();
						$obj_refund_request->conn = $conn;
						$obj_refund_request->order_id = $order_id;
						$obj_refund_request->amount = $ramount;
						$obj_refund_request->requested_on = $cdate;
						$obj_refund_request->status = "pending";
						$obj_refund_request->read_status = "U";
						$obj_refund_request->add_refund_request();
					}
				}
			}
		}
	}
	$reason = htmlentities($_POST['reason']);
	$obj_bookings->order_id = $order_id;
	$obj_bookings->booking_status = "cancelled_by_customer";
	$obj_bookings->reject_reason = $reason;
	$updated = $obj_bookings->reject_appointment();
	if($updated){
		/********************** Send SMS & Email code start ***************************/
		include(dirname(dirname(dirname(__FILE__)))."/classes/class_es_information.php");
		$obj_es_information = new rzvy_es_information();
		$obj_es_information->conn = $conn;
		$get_es_appt_detail_by_order_id = $obj_es_information->get_es_appt_detail_by_order_id($order_id);
		
		/**** Delete to GC start **/
		$rzvy_gc_status = $obj_settings->get_option('rzvy_gc_status');
		$rzvy_gc_clientid = $obj_settings->get_option('rzvy_gc_clientid');
		$rzvy_gc_clientsecret = $obj_settings->get_option('rzvy_gc_clientsecret');
		$rzvy_gc_accesstoken = $obj_settings->get_option('rzvy_gc_accesstoken');
		$rzvy_gc_accesstoken = base64_decode($rzvy_gc_accesstoken);
		$eventId = $obj_es_information->get_appt_gc_eventid($order_id);
		if($rzvy_gc_status == "Y" && $rzvy_gc_clientid != "" && $rzvy_gc_clientsecret != "" && $rzvy_gc_accesstoken != "" && $eventId != ""){
			include(dirname(dirname(dirname(__FILE__)))."/includes/google-calendar/vendor/autoload.php");
			$client = new Google_Client();
			$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
			$client->setClientId($rzvy_gc_clientid);
			$client->setClientSecret($rzvy_gc_clientsecret);
			$client->setAccessType('offline');
			$client->setPrompt('select_account consent');

			$accessToken = unserialize($rzvy_gc_accesstoken);
			$client->setAccessToken($accessToken);
			if ($client->isAccessTokenExpired()) {
				$newAccessToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
				$obj_settings->update_option('rzvy_gc_accesstoken',base64_encode(serialize($newAccessToken)));
			}
			$service = new Google_Service_Calendar($client);
			$calendarId = (($obj_settings->get_option('rzvy_gc_calendarid')!= "")?$obj_settings->get_option('rzvy_gc_calendarid'):'primary');
			$service->events->delete($calendarId, $eventId);
			$obj_es_information->delete_appt_gc_eventid($order_id);
		}
		/*** Delete to GC end **/
		
		/**** Delete to staff GC start **/
		$gc_staff_id = $obj_settings->get_staffid_from_orderid($order_id);
		if($gc_staff_id>0){
			$obj_settings->staff_id = $gc_staff_id;
			$rzvy_gc_status = $obj_settings->get_staff_option('rzvy_gc_status');
			$rzvy_gc_accesstoken = $obj_settings->get_staff_option('rzvy_gc_accesstoken');
			$rzvy_gc_accesstoken = base64_decode($rzvy_gc_accesstoken);
			$eventId = $obj_es_information->get_appt_gc_eventid_staff($order_id);
			if($rzvy_gc_status == "Y" && $rzvy_gc_clientid != "" && $rzvy_gc_clientsecret != "" && $rzvy_gc_accesstoken != "" && $eventId != ""){
				include(dirname(dirname(dirname(__FILE__)))."/includes/google-calendar/vendor/autoload.php");
				$client = new Google_Client();
				$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
				$client->setClientId($rzvy_gc_clientid);
				$client->setClientSecret($rzvy_gc_clientsecret);
				$client->setAccessType('offline');
				$client->setPrompt('select_account consent');

				$accessToken = unserialize($rzvy_gc_accesstoken);
				$client->setAccessToken($accessToken);
				if ($client->isAccessTokenExpired()) {
					$newAccessToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
					$obj_settings->update_staff_option('rzvy_gc_accesstoken',base64_encode(serialize($newAccessToken)));
				}
				$service = new Google_Service_Calendar($client);
				$calendarId = (($obj_settings->get_staff_option('rzvy_gc_calendarid')!= "")?$obj_settings->get_staff_option('rzvy_gc_calendarid'):'primary');
				$service->events->delete($calendarId, $eventId);
				$obj_es_information->delete_appt_gc_eventid_staff($order_id);
			}
		}
		/*** Delete to staff GC end **/
		
		if(mysqli_num_rows($get_es_appt_detail_by_order_id)>0){
			$es_appt_detail = mysqli_fetch_array($get_es_appt_detail_by_order_id);
			$es_staff_id = $es_appt_detail['staff_id'];
			$es_template = "cancelc";
			$es_category_id = $es_appt_detail['cat_id'];
			$es_service_id = $es_appt_detail['service_id'];
			$es_booking_datetime = $es_appt_detail['booking_datetime'];
			$es_transaction_id = $es_appt_detail['transaction_id'];
			$es_subtotal = $es_appt_detail['sub_total'];
			$es_coupondiscount = $es_appt_detail['discount'];
			$es_freqdiscount = $es_appt_detail['fd_amount'];
			$es_tax = $es_appt_detail['tax'];
			$es_nettotal = $es_appt_detail['net_total'];
			$es_payment_method = $es_appt_detail['payment_method'];
			if($es_payment_method==ucwords('pay-at-venue')){
				if(isset($rzvy_translangArr['pay_at_venue'])){ $es_payment_method = $rzvy_translangArr['pay_at_venue']; }else{ $es_payment_method = $rzvy_defaultlang['pay_at_venue']; } 
			}
			$es_firstname = $es_appt_detail['c_firstname'];
			$es_lastname = $es_appt_detail['c_lastname'];
			$es_email = $es_appt_detail['c_email'];
			$es_phone = $es_appt_detail['c_phone'];
			$es_address = $es_appt_detail['c_address'];
			$es_city = $es_appt_detail['c_city'];
			$es_state = $es_appt_detail['c_state'];
			$es_country = $es_appt_detail['c_country'];
			$es_zip = $es_appt_detail['c_zip'];
			$es_addons_items_arr = $es_appt_detail['addons'];
			$es_reschedule_reason = $es_appt_detail['reschedule_reason'];
			$es_reject_reason = $es_appt_detail['reject_reason'];
			$es_cancel_reason = $es_appt_detail['cancel_reason'];
			include("rzvy_send_sms_email_process.php");
		}
		@ob_clean(); ob_start();
		/********************** Send SMS & Email code END ****************************/
		echo "updated";
	}
}

/* Get Appointment Feedback Detail tab */
else if(isset($_POST['rzvy_feedback_appointment_tab'])){
	$order_id = $_POST['order_id'];
	$feedback_detail = $obj_bookings->get_appointment_rating($order_id);
	
	if(mysqli_num_rows($feedback_detail)>0){
		while($feedback = mysqli_fetch_assoc($feedback_detail)){			
			?>
			<div class="m-3">
			  <div class="row rzvy-mb-5">
				<div class="col-md-2">
					<b><?php if(isset($rzvy_translangArr['rating_ad'])){ echo $rzvy_translangArr['rating_ad']; }else{ echo $rzvy_defaultlang['rating_ad']; } ?></b>
				</div>
				<div class="col-md-9">
					<?php 
					if($feedback['rating']>0){
						for($star_i=0;$star_i<$feedback['rating'];$star_i++){ 
							?>
							<i class="fa fa-star rzvy_feedback_star_list" aria-hidden="true"></i>
							<?php 
						} 
						for($star_j=0;$star_j<(5-$feedback['rating']);$star_j++){ 
							?>
							<i class="fa fa-star-o rzvy_feedback_star_list" aria-hidden="true"></i>
							<?php 
						} 
					}else{ 
						?>
						<i class="fa fa-star-o rzvy_feedback_star_list" aria-hidden="true"></i>
						<i class="fa fa-star-o rzvy_feedback_star_list" aria-hidden="true"></i>
						<i class="fa fa-star-o rzvy_feedback_star_list" aria-hidden="true"></i>
						<i class="fa fa-star-o rzvy_feedback_star_list" aria-hidden="true"></i>
						<i class="fa fa-star-o rzvy_feedback_star_list" aria-hidden="true"></i>
						<?php 
					} 
					?>
				</div>
			  </div>
			  <div class="row rzvy-mb-5 mt-3">
				<div class="col-md-2">
					<b><?php if(isset($rzvy_translangArr['review_ad'])){ echo $rzvy_translangArr['review_ad']; }else{ echo $rzvy_defaultlang['review_ad']; } ?></b>
				</div>
				<div class="col-md-9">
					<?php echo ucfirst($feedback['review']); ?>
				</div>
			  </div>
			</div>
			<?php 
		}
	}else{ 
		?>
		<form method="post" name="rzvy_feedback_form" id="rzvy_feedback_form">
		  <input type="hidden" id="rzvy_fb_rating" name="rzvy_fb_rating" value="0" />
		  <div class="row mb-4 mt-2">
			<div class="col-md-2">
				<b><?php if(isset($rzvy_translangArr['rating_ad'])){ echo $rzvy_translangArr['rating_ad']; }else{ echo $rzvy_defaultlang['rating_ad']; } ?></b>
			</div>
			<div class="col-md-9">
				<span class="fa fa-star-o rzvy-sidebar-feedback-star" id="rzvy-sidebar-feedback-star1" onclick="rzvy_add_star_rating(this,1)"></span>
				<span class="fa fa-star-o rzvy-sidebar-feedback-star" id="rzvy-sidebar-feedback-star2" onclick="rzvy_add_star_rating(this,2)"></span>
				<span class="fa fa-star-o rzvy-sidebar-feedback-star" id="rzvy-sidebar-feedback-star3" onclick="rzvy_add_star_rating(this,3)"></span>
				<span class="fa fa-star-o rzvy-sidebar-feedback-star" id="rzvy-sidebar-feedback-star4" onclick="rzvy_add_star_rating(this,4)"></span>
				<span class="fa fa-star-o rzvy-sidebar-feedback-star" id="rzvy-sidebar-feedback-star5" onclick="rzvy_add_star_rating(this,5)"></span>
			</div>
		  </div>
		  <div class="row mb-4">
			<div class="col-md-2">
				<b><?php if(isset($rzvy_translangArr['review_ad'])){ echo $rzvy_translangArr['review_ad']; }else{ echo $rzvy_defaultlang['review_ad']; } ?></b>
			</div>
			<div class="col-md-9">
				<textarea class="form-control" id="rzvy_fb_review" name="rzvy_fb_review" placeholder="<?php if(isset($rzvy_translangArr['write_your_honest_experience'])){ echo $rzvy_translangArr['write_your_honest_experience']; }else{ echo $rzvy_defaultlang['write_your_honest_experience']; } ?>"></textarea>
			</div>
		  </div>
		  <div class="row rzvy-mt-20">
			<div class="col-md-12">
				<a href="javascript:void(0)" data-id="<?php echo $order_id; ?>" class="btn btn-primary rzvy-fullwidth rzvy_submit_feedback_btn"><i class="fa fa-thumbs-up"></i> <?php if(isset($rzvy_translangArr['submit_review'])){ echo $rzvy_translangArr['submit_review']; }else{ echo $rzvy_defaultlang['submit_review']; } ?></a>
			</div>
		  </div>
		</form>
		<?php 
	}
}

/** add appointment feedback ajax **/
else if(isset($_POST["add_feedback"])){
	$added = $obj_bookings->add_appointment_feedback($_POST["order_id"], $_POST["rating"], $_POST["review"]);
	if($added){
		echo "added";
	}
}

/** get end time slot ajax for reschedule **/
else if(isset($_POST['get_endtimeslots'])){
	$order_id = $_POST['order_id'];
	$staff_id = $_POST['staff_id'];
	$obj_bookings->order_id = $order_id;
	$appointment_detail = $obj_bookings->get_appointment_status_and_datetime();
	
	$rzvy_endtimeslot_selection_status = $obj_settings->get_option('rzvy_endtimeslot_selection_status');
	$time_interval = $obj_settings->get_option('rzvy_timeslot_interval');
	$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
	$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
	$advance_bookingtime = $obj_settings->get_option('rzvy_maximum_advance_booking_time');
	
	/** get without end time slot ajax for reschedule **/
	if($rzvy_endtimeslot_selection_status != "Y"){
		$booking_end_datetime = date("Y-m-d H:i:s", strtotime($_POST['selected_date']." ".$_POST["selected_startslot"]));
		$booking_endtime = date("H:i:s", strtotime($booking_end_datetime));
		$booking_enddate = date("Y-m-d", strtotime($booking_end_datetime));	
		if(is_numeric($_POST['service_id']) && $_POST['service_id'] != "0"){
			$time_interval=$obj_slots->get_service_time_interval($_POST['service_id'],$time_interval);
		}
		$sdate_stime = strtotime($booking_end_datetime);
		$sdate_etime = date("Y-m-d H:i:s", strtotime("+".$time_interval." minutes", $sdate_stime));
		$sdate_estime = date("H:i:s", strtotime($sdate_etime)); 
		echo $sdate_estime;
	}else{
		$booking_end_datetime = date("Y-m-d H:i:s", strtotime($_POST['selected_date']." ".$_POST["selected_startslot"]));
		$booking_datetime = $booking_end_datetime;
		$booking_date = date("Y-m-d", strtotime($booking_datetime));
		$booking_time = date("H:i:s", strtotime($booking_datetime));
		$booking_enddate = date("Y-m-d", strtotime($booking_end_datetime));
		$booking_endtime = date("H:i:s", strtotime($booking_end_datetime));
		
		$rzvy_settings_timezone = $obj_settings->get_option("rzvy_timezone");
		$rzvy_server_timezone = date_default_timezone_get();
		$currDateTime_withTZ = $obj_settings->get_current_time_according_selected_timezone($rzvy_server_timezone,$rzvy_settings_timezone); 

		$selected_enddate = date("Y-m-d", strtotime($booking_enddate));
		$selected_enddate = date($selected_enddate, $currDateTime_withTZ);
		$current_date = date("Y-m-d", $currDateTime_withTZ);
		
		$isEndTime = true;
		$obj_slots->staff_id = $staff_id;
		$addon_duration = $obj_slots->fetch_addon_duration($appointment_detail['addons']);
		$available_slots = $obj_slots->generate_available_slots_dropdown($time_interval, $rzvy_time_format, $selected_enddate, $advance_bookingtime, $currDateTime_withTZ, $isEndTime,$_POST['service_id'], $addon_duration);
		
		$no_booking = $available_slots['no_booking'];
		if($available_slots['no_booking']<0){
			$no_booking = 0;
		}
		
		/** check for maximum end time slot limit **/
		$rzvy_maximum_endtimeslot_limit = $obj_settings->get_option('rzvy_maximum_endtimeslot_limit');
		$selected_slot_check = strtotime($booking_end_datetime);
		$maximum_endslot_limit = date("Y-m-d H:i:s", strtotime("+".$rzvy_maximum_endtimeslot_limit." minutes", $selected_slot_check)); 
		
		$j = 0;
		$i = 1;
		if(isset($available_slots['slots']) && sizeof($available_slots['slots'])>0){
			foreach($available_slots['slots'] as $slot){
				if(strtotime($selected_enddate." ".$slot) <= strtotime($selected_enddate." ".$booking_time)){
					continue;
				}elseif(strtotime($selected_enddate." ".$slot) > strtotime($maximum_endslot_limit)){
					continue;
				}else{
					$booked_slot_exist = false;
					foreach($available_slots['booked'] as $bslot){
						if($bslot["start_time"] <= strtotime($selected_enddate." ".$slot) && $bslot["end_time"] > strtotime($selected_enddate." ".$slot)){
							$booked_slot_exist = true;
							continue;
						} 
					}
					if($booked_slot_exist){
						break;
					}else{ 
						$blockoff_exist = false;
						if(sizeof($available_slots['block_off'])>0){
							foreach($available_slots['block_off'] as $block_off){
								if((strtotime($selected_enddate." ".$block_off["start_time"]) <= strtotime($selected_enddate." ".$slot)) && (strtotime($selected_enddate." ".$block_off["end_time"]) > strtotime($selected_enddate." ".$slot))){
									$blockoff_exist = true;
									continue;
								} 
							}
						} 
						if($blockoff_exist){
							break;
						} 
						?>
						<option value="<?php echo $slot; ?>" <?php if($booking_endtime == $slot){ echo "selected"; } ?>>
							<?php echo date($rzvy_time_format,strtotime($booking_enddate." ".$slot)); ?>
						</option>
						<?php
						$j++;
					}
				}
				$i++;
			}
		}
		if($j == 0){ 
			if(is_numeric($_POST['service_id']) && $_POST['service_id'] != "0"){
				$time_interval=$obj_slots->get_service_time_interval($_POST['service_id'],$time_interval);
			}
			
			$sdate_stime = strtotime($selected_enddate." ".$booking_time);
			$sdate_etime = date("Y-m-d H:i:s", strtotime("+".$time_interval." minutes", $sdate_stime));
			$sdate_estime = date("H:i:s", strtotime($sdate_etime)); 
			?>
			<option value="<?php echo $sdate_estime; ?>" selected>
				<?php echo date($rzvy_time_format,strtotime($sdate_etime)); ?>
			</option>
			<?php
		}
	}
}