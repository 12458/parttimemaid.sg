<?php 
include "staff-header.php";
include(dirname(dirname(__FILE__))."/classes/class_dashboard.php"); 
$obj_dashboard = new rzvy_dashboard();
$obj_dashboard->conn = $conn; 
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
$drp_samedate = "N";
$drp_startdate = date('Y-m-d');
$drp_enddate = date('Y-m-d');
if(isset($_GET["start"],$_GET["end"])){	
	if(validateDate($_GET["start"]) && validateDate($_GET["end"])){
		$drp_startdate = $_GET["start"];
		$drp_enddate = $_GET["end"];
		if(strtotime($drp_startdate) == strtotime($drp_enddate)){
			$drp_samedate = "Y";
		}
	}
}
$obj_dashboard->startdate = $drp_startdate;
$obj_dashboard->enddate = $drp_enddate;
$obj_dashboard->samedate = $drp_samedate;

if(isset($rzvy_translangArr['pending'])){ $label_pending = $rzvy_translangArr['pending']; }else{ $label_pending = $rzvy_defaultlang['pending']; }
if(isset($rzvy_translangArr['confirmed_by_you'])){ $label_confirmed_by_you = $rzvy_translangArr['confirmed_by_you']; }else{ $label_confirmed_by_you = $rzvy_defaultlang['confirmed_by_you']; }
if(isset($rzvy_translangArr['confirmed_by_admin'])){ $label_confirmed_by_admin = $rzvy_translangArr['confirmed_by_admin']; }else{ $label_confirmed_by_admin = $rzvy_defaultlang['confirmed_by_admin']; }
if(isset($rzvy_translangArr['rescheduled_by_customer'])){ $label_rescheduled_by_customer = $rzvy_translangArr['rescheduled_by_customer']; }else{ $label_rescheduled_by_customer = $rzvy_defaultlang['rescheduled_by_customer']; }
if(isset($rzvy_translangArr['rescheduled_by_you'])){ $label_rescheduled_by_you = $rzvy_translangArr['rescheduled_by_you']; }else{ $label_rescheduled_by_you = $rzvy_defaultlang['rescheduled_by_you']; }
if(isset($rzvy_translangArr['rescheduled_by_admin'])){ $label_rescheduled_by_admin = $rzvy_translangArr['rescheduled_by_admin']; }else{ $label_rescheduled_by_admin = $rzvy_defaultlang['rescheduled_by_admin']; }
if(isset($rzvy_translangArr['cancelled_by_customer'])){ $label_cancelled_by_customer = $rzvy_translangArr['cancelled_by_customer']; }else{ $label_cancelled_by_customer = $rzvy_defaultlang['cancelled_by_customer']; }
if(isset($rzvy_translangArr['rejected_by_you'])){ $label_rejected_by_you = $rzvy_translangArr['rejected_by_you']; }else{ $label_rejected_by_you = $rzvy_defaultlang['rejected_by_you']; }
if(isset($rzvy_translangArr['rejected_by_admin'])){ $label_rejected_by_admin = $rzvy_translangArr['rejected_by_admin']; }else{ $label_rejected_by_admin = $rzvy_defaultlang['rejected_by_admin']; }
if(isset($rzvy_translangArr['completed'])){ $label_completed = $rzvy_translangArr['completed']; }else{ $label_completed = $rzvy_defaultlang['completed']; }
if(isset($rzvy_translangArr['mark_as_noshow'])){ $label_noshow = $rzvy_translangArr['mark_as_noshow']; }else{ $label_noshow = $rzvy_defaultlang['mark_as_noshow']; }
if(isset($rzvy_translangArr['with'])){ $label_with = $rzvy_translangArr['with']; }else{ $label_with = $rzvy_defaultlang['with']; }
if(isset($rzvy_translangArr['on'])){ $label_on = $rzvy_translangArr['on']; }else{ $label_on = $rzvy_defaultlang['on']; }

/*** Fetch Appointment Status color START ***/
$defaultApptStatusColorScheme = array(
	"pending" => "#1589FF",
	"confirmed" => "#008000",
	"confirmed_by_staff" => "#008000",
	"rescheduled_by_customer" => "#04B4AE",
	"rescheduled_by_you" => "#6960EC",
	"rescheduled_by_staff" => "#6960EC",
	"cancelled_by_customer" => "#FF4500",
	"rejected_by_you" => "#F70D1A",
	"rejected_by_staff" => "#F70D1A",
	"completed" => "#b7950b",
	"mark_as_noshow" => "#F70D1A",
);
$rzvy_apptstatus_colorscheme = $obj_settings->get_option("rzvy_apptstatus_colorscheme");
if($rzvy_apptstatus_colorscheme != ""){
	$astatuscscheme = json_decode(htmlspecialchars_decode($rzvy_apptstatus_colorscheme));
	if ($astatuscscheme !== false) {
		if(isset($astatuscscheme->pending) && $astatuscscheme->pending != ""){ $defaultApptStatusColorScheme["pending"] = $astatuscscheme->pending; }
		if(isset($astatuscscheme->confirmed) && $astatuscscheme->confirmed != ""){ $defaultApptStatusColorScheme["confirmed"] = $astatuscscheme->confirmed; }
		if(isset($astatuscscheme->confirmed_by_staff) && $astatuscscheme->confirmed_by_staff != ""){ $defaultApptStatusColorScheme["confirmed_by_staff"] = $astatuscscheme->confirmed_by_staff; }
		if(isset($astatuscscheme->rescheduled_by_customer) && $astatuscscheme->rescheduled_by_customer != ""){ $defaultApptStatusColorScheme["rescheduled_by_customer"] = $astatuscscheme->rescheduled_by_customer; }
		if(isset($astatuscscheme->rescheduled_by_you) && $astatuscscheme->rescheduled_by_you != ""){ $defaultApptStatusColorScheme["rescheduled_by_you"] = $astatuscscheme->rescheduled_by_you; }
		if(isset($astatuscscheme->rescheduled_by_staff) && $astatuscscheme->rescheduled_by_staff != ""){ $defaultApptStatusColorScheme["rescheduled_by_staff"] = $astatuscscheme->rescheduled_by_staff; }
		if(isset($astatuscscheme->cancelled_by_customer) && $astatuscscheme->cancelled_by_customer != ""){ $defaultApptStatusColorScheme["cancelled_by_customer"] = $astatuscscheme->cancelled_by_customer; }
		if(isset($astatuscscheme->rejected_by_you) && $astatuscscheme->rejected_by_you != ""){ $defaultApptStatusColorScheme["rejected_by_you"] = $astatuscscheme->rejected_by_you; }
		if(isset($astatuscscheme->rejected_by_staff) && $astatuscscheme->rejected_by_staff != ""){ $defaultApptStatusColorScheme["rejected_by_staff"] = $astatuscscheme->rejected_by_staff; }
		if(isset($astatuscscheme->completed) && $astatuscscheme->completed != ""){ $defaultApptStatusColorScheme["completed"] = $astatuscscheme->completed; }
		if(isset($astatuscscheme->mark_as_noshow) && $astatuscscheme->mark_as_noshow != ""){ $defaultApptStatusColorScheme["mark_as_noshow"] = $astatuscscheme->mark_as_noshow; }
	}
}
/*** Fetch Appointment Status color END ***/ 

$rzvy_book_with_datetime = $obj_settings->get_option("rzvy_book_with_datetime");
$rzvy_currency_symbol = $obj_settings->get_option('rzvy_currency_symbol');
$rzvy_currency_position = $obj_settings->get_option('rzvy_currency_position');
$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
$datetime_format = $rzvy_date_format." ".$rzvy_time_format;
$rzvy_settings_timezone = $obj_settings->get_option("rzvy_timezone");
$rzvy_server_timezone = date_default_timezone_get();
$currDateTime_withTZ = $obj_settings->get_current_time_according_selected_timezone($rzvy_server_timezone,$rzvy_settings_timezone); 
$currdatetime = date("Y-m-d H:i:s", $currDateTime_withTZ);
$currenddatetime = date("Y-m-d 23:59:59", $currDateTime_withTZ);
$status_array = array(
	'pending' => array(
		"status" => $label_pending,
		"icon" => '<i class="fa fa-info-circle" title="'.$label_pending.'"></i> ',
		"color" => $defaultApptStatusColorScheme["pending"],
	),
	'confirmed' => array(
		"status" => $label_confirmed_by_admin,
		"icon" => '<i class="fa fa-check" title="'.$label_confirmed_by_admin.'"></i> ',
		"color" => $defaultApptStatusColorScheme["confirmed"],
	),
	'confirmed_by_staff' => array(
		"status" => $label_confirmed_by_you,
		"icon" => '<i class="fa fa-check" title="'.$label_confirmed_by_you.'"></i> ',
		"color" => $defaultApptStatusColorScheme["confirmed_by_staff"],
	),
	'rescheduled_by_customer' => array(
		"status" => $label_rescheduled_by_customer,
		"icon" => '<i class="fa fa-refresh" title="'.$label_rescheduled_by_customer.'"></i> ',
		"color" => $defaultApptStatusColorScheme["rescheduled_by_customer"],
	),
	'rescheduled_by_you' => array(
		"status" => $label_rescheduled_by_admin,
		"icon" => '<i class="fa fa-repeat" title="'.$label_rescheduled_by_admin.'"></i> ',
		"color" => $defaultApptStatusColorScheme["rescheduled_by_you"],
	),
	'rescheduled_by_staff' => array(
		"status" => $label_rescheduled_by_you,
		"icon" => '<i class="fa fa-repeat" title="'.$label_rescheduled_by_you.'"></i> ',
		"color" => $defaultApptStatusColorScheme["rescheduled_by_staff"],
	),
	'cancelled_by_customer' => array(
		"status" => $label_cancelled_by_customer,
		"icon" => '<i class="fa fa-close" title="'.$label_cancelled_by_customer.'"></i> ',
		"color" => $defaultApptStatusColorScheme["cancelled_by_customer"],
	),
	'rejected_by_you' => array(
		"status" => $label_rejected_by_admin,
		"icon" => '<i class="fa fa-ban" title="'.$label_rejected_by_admin.'"></i> ',
		"color" => $defaultApptStatusColorScheme["rejected_by_you"],
	),
	'rejected_by_staff' => array(
		"status" => $label_rejected_by_you,
		"icon" => '<i class="fa fa-ban" title="'.$label_rejected_by_you.'"></i> ',
		"color" => $defaultApptStatusColorScheme["rejected_by_staff"],
	),
	'completed' => array(
		"status" => $label_completed,
		"icon" => '<i class="fa fa-calendar-check-o" title="'.$label_completed.'"></i> ',
		"color" => $defaultApptStatusColorScheme["completed"],
	),
	'mark_as_noshow' => array(
		"status" => $label_noshow,
		"icon" => '<i class="fa fa-calendar-check-o" title="'.$label_noshow.'"></i> ',
		"color" => $defaultApptStatusColorScheme["mark_as_noshow"],
	)
);

$all_today_appointments = $obj_dashboard->get_all_today_upcoming_staff_appointments($currdatetime,$currenddatetime, $_SESSION['staff_id']);
$all_appointments = $obj_dashboard->get_all_upcoming_staff_appointments($currdatetime, $_SESSION['staff_id']); 
?>
<div class="row mt-4">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="form-group pull-right">
		  <div class="input-group-btn">
			<button type="button" class="btn btn-default" id="rzvy_reportrange" style='width:100%'>
				<i class="fa fa-calendar"></i>&nbsp; <span></span>
			  <i class="fa fa-caret-down"></i>
			</button>
		  </div>
		</div>
		<!-- /.form group -->
	</div>
</div>
<div class="row mt-4">
	<div class="col-md-6 col-md-6 col-sm-6 mb-3">
		<div class="card card-stats mb-4 mb-xl-0">
			<div class="card-body">
			  <div class="row">
				<div class="col">
				  <h5 class="card-title text-muted mb-0"><?php if(isset($rzvy_translangArr['total_revenue'])){ echo $rzvy_translangArr['total_revenue']; }else{ echo $rzvy_defaultlang['total_revenue']; } ?></h5>
				  <span class="h2 font-weight-bold mb-0"></span>
				</div>
				<div class="col-auto">
				  <div class="icon icon-shape bg-danger text-white rounded-circle shadow rzvy-card-icon-css d-flex justify-content-center">
					<i class="fa fa-money fa-2x"></i>
				  </div>
				</div>
			  </div>
			  <p class="mt-3 mb-0 text-muted text-sm">										
				<span class="text-wrap h2 font-weight-bold mb-0"><?php $count_of_total_revenue = $obj_dashboard->get_staff_total_revenue($_SESSION['staff_id']); if($count_of_total_revenue>0){ echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,@number_format($count_of_total_revenue,2)); }else{ echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,"0"); } ?></span>
			  </p>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-md-6 col-sm-6 mb-3">
		<div class="card card-stats mb-4 mb-xl-0">
			<div class="card-body">
			  <div class="row">
				<div class="col">
				  <h5 class="card-title text-muted mb-0"><?php if(isset($rzvy_translangArr['total_appointments'])){ echo $rzvy_translangArr['total_appointments']; }else{ echo $rzvy_defaultlang['total_appointments']; } ?></h5>
				  <span class="h2 font-weight-bold mb-0"></span>
				</div>
				<div class="col-auto">
				  <div class="icon icon-shape bg-success text-white rounded-circle shadow rzvy-card-icon-css d-flex justify-content-center">
					<i class="fa fa-calendar fa-2x"></i>
				  </div>
				</div>
			  </div>
			  <p class="mt-3 mb-0 text-muted text-sm">										
				<span class="text-wrap h2 font-weight-bold mb-0"><?php echo $obj_dashboard->get_staff_total_appointment($_SESSION['staff_id']); ?></span>
			  </p>
			</div>
		</div>
	</div>
</div>
<div class="row mt-2">
	<div class="col-lg-6 col-md-12 my-2">
		<div class="card">
			<div class="card-header card-header-primary">
				<h5><?php if(isset($rzvy_translangArr['upcoming_appointments'])){ echo $rzvy_translangArr['upcoming_appointments']; }else{ echo $rzvy_defaultlang['upcoming_appointments']; } ?></h5>
			</div>
			<div class="card-body" style="height: 430px;max-height: 430px;overflow-y:auto;">
				<table class="table table-borderless" cellspacing="0">
					<tbody>
						<?php 
						if(mysqli_num_rows($all_appointments)>0){
							while($appointment = mysqli_fetch_array($all_appointments)){
								$customer_name = ucwords($appointment['c_firstname']." ".$appointment['c_lastname']);
								if($rzvy_book_with_datetime == "Y"){
									$event_title = "<b>".$appointment['cat_name'].":</b> ".$appointment['title']." ".$label_with." ".$customer_name." ".$label_on." <b>".date($datetime_format, strtotime($appointment['booking_datetime']))."</b>";
								}else{
									$event_title = "<b>".$appointment['cat_name'].":</b> ".$appointment['title']." ".$label_with." ".$customer_name;
								}
								?>
								<tr>
									<td>
										<div class="rzvy-upcoming-appointment-modal-link" data-id="<?php echo $appointment['order_id']; ?>">
											<div class="row">
												<div class="col-md-12">
													<strong style="color: <?php echo $status_array[$appointment['booking_status']]['color']; ?>"><?php echo $status_array[$appointment['booking_status']]['icon']; echo $status_array[$appointment['booking_status']]['status']; ?></strong>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<span class="rzvy_noti_deatil"><?php echo $event_title; ?></span>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<?php
							}
						}else{
							?>
							<tr>
								<td>
									<?php if(isset($rzvy_translangArr['opps_you_have_no_upcoming_appointments'])){ echo $rzvy_translangArr['opps_you_have_no_upcoming_appointments']; }else{ echo $rzvy_defaultlang['opps_you_have_no_upcoming_appointments']; } ?>
								</td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-12 my-2">
		<div class="card">
			<div class="card-header card-header-primary">
				<h5><?php if(isset($rzvy_translangArr['todays_upcoming_appointments'])){ echo $rzvy_translangArr['todays_upcoming_appointments']; }else{ echo $rzvy_defaultlang['todays_upcoming_appointments']; } ?></h5>
			</div>
			<div class="card-body" style="height: 430px;max-height: 430px;overflow-y:auto;">
				<table class="table table-borderless" cellspacing="0">
					<tbody>
						<?php 
						if(mysqli_num_rows($all_today_appointments)>0){
							while($appointment = mysqli_fetch_array($all_today_appointments)){
								$customer_name = ucwords($appointment['c_firstname']." ".$appointment['c_lastname']);
								
								if($rzvy_book_with_datetime == "Y"){
									$event_title = "<b>".$appointment['cat_name'].":</b> ".$appointment['title']." ".$label_with." ".$customer_name." ".$label_on." <b>".date($datetime_format, strtotime($appointment['booking_datetime']))."</b>";
								}else{
									$event_title = "<b>".$appointment['cat_name'].":</b> ".$appointment['title']." ".$label_with." ".$customer_name;
								}
								?>
								<tr>
									<td>
										<div class="rzvy-upcoming-appointment-modal-link" data-id="<?php echo $appointment['order_id']; ?>">
											<div class="row">
												<div class="col-md-12">
													<strong style="color: <?php echo $status_array[$appointment['booking_status']]['color']; ?>"><?php echo $status_array[$appointment['booking_status']]['icon']; echo $status_array[$appointment['booking_status']]['status']; ?></strong>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<span class="rzvy_noti_deatil"><?php echo $event_title; ?></span>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<?php
							}
						}else{
							?>
							<tr>
								<td>
									<?php if(isset($rzvy_translangArr['opps_you_have_no_upcoming_appointments'])){ echo $rzvy_translangArr['opps_you_have_no_upcoming_appointments']; }else{ echo $rzvy_defaultlang['opps_you_have_no_upcoming_appointments']; } ?>
								</td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include "staff-footer.php"; ?>