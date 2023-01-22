<?php 
/* Include class files */
include(dirname(dirname(dirname(__FILE__)))."/constants.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_coupons.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_settings.php");

/* Create object of classes */
$obj_coupons = new rzvy_coupons();
$obj_coupons->conn = $conn;
$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

/* Add coupon ajax */
if(isset($_POST['add_coupon'])){
	$obj_coupons->coupon_code = htmlentities($_POST['coupon_code']);
	$obj_coupons->coupon_type = $_POST['coupon_type'];
	$obj_coupons->coupon_value = $_POST['coupon_value'];
	$obj_coupons->coupon_expiry = date('Y-m-d', strtotime($_POST['coupon_expiry']));
	$obj_coupons->coupon_start = date('Y-m-d', strtotime($_POST['coupon_start']));
	$obj_coupons->status = $_POST['status'];
	$obj_coupons->front_status = $_POST['front_status'];
	$obj_coupons->usage = $_POST['usage'];
	$obj_coupons->users = implode('',$_POST['users']);
	$coupon_added = $obj_coupons->add_coupon();
	if($coupon_added){
		echo "added";
	}else{
		echo "failed";
	}
}
/* Change coupon status ajax */
else if(isset($_POST['change_coupon_status'])){
	$obj_coupons->id = $_POST['id'];
	$obj_coupons->status = $_POST['status'];
	$status_changed = $obj_coupons->change_coupon_status();
	if($status_changed){
		echo "changed";
	}else{
		echo "failed";
	}
}
/* Change coupon front status ajax */
else if(isset($_POST['change_coupon_front_status'])){
	$obj_coupons->id = $_POST['id'];
	$obj_coupons->front_status = $_POST['front_status'];
	$status_changed = $obj_coupons->change_coupon_front_status();
	if($status_changed){
		echo "changed";
	}else{
		echo "failed";
	}
}
/* Delete coupon ajax */
else if(isset($_POST['delete_coupon'])){
	$obj_coupons->id = $_POST['id'];
	$coupon_deleted = $obj_coupons->delete_coupon();
	if($coupon_deleted){
		echo "deleted";
	}else{
		echo "failed";
	}
}
/* Refresh coupon ajax */
else if(isset($_REQUEST['refresh_coupon'])){
	$all_coupons = $obj_coupons->get_all_coupons_within_limit($_POST['start'],($_POST['start']+$_POST['length']), $_POST['search']['value'],$_POST['order'][0]['column'],$_POST['order'][0]['dir'],$_POST['draw']);
	$coupons = array();
	$coupons["draw"] = $_POST['draw'];
	$count_all_coupons = $obj_coupons->count_all_coupons($_POST['search']['value']);
	$coupons["recordsTotal"] = $count_all_coupons;
	$coupons["recordsFiltered"] = $count_all_coupons;
	$coupons['data'] =array();
	if(mysqli_num_rows($all_coupons)>0){
		$i=$_POST['start'];
		$rzvy_currency_symbol = $obj_settings->get_option('rzvy_currency_symbol');
		$rzvy_currency_position = $obj_settings->get_option('rzvy_currency_position');
		while($coupon = mysqli_fetch_assoc($all_coupons)){
			$i++;
			$coupon_arr = array();
			if($coupon['coupon_type'] == "flat"){
				$coupon_val = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$coupon['coupon_value']);
			}else{
				$coupon_val = $coupon['coupon_value']."%";
			}
			array_push($coupon_arr, $coupon['coupon_code']);
			array_push($coupon_arr, ucwords($coupon['coupon_type']));
			array_push($coupon_arr, $coupon_val);
			array_push($coupon_arr, date($obj_settings->get_option('rzvy_date_format'), strtotime($coupon['coupon_start'])));
			array_push($coupon_arr, date($obj_settings->get_option('rzvy_date_format'), strtotime($coupon['coupon_expiry'])));

			$checked = '';
			if($coupon['status'] == "Y"){ $checked = "checked"; }
			array_push($coupon_arr, '<label class="rzvy-toggle-switch">
				  <input type="checkbox" data-id="'.$coupon['id'].'" class="rzvy-toggle-switch-input rzvy_change_coupon_status" '.$checked.' />
				  <span class="rzvy-toggle-switch-slider"></span>
				</label>');
	
			$fchecked = '';
			if($coupon['front_status'] == "Y"){ $fchecked = "checked"; }
			array_push($coupon_arr, '<label class="rzvy-toggle-switch">
				  <input type="checkbox" data-id="'.$coupon['id'].'" class="rzvy-toggle-switch-input rzvy_change_coupon_front_status" '.$fchecked.' />
				  <span class="rzvy-toggle-switch-slider"></span>
				</label>');
				
			$couponactionbtns = '';	
			if(isset($rzvy_rolepermissions['rzvy_coupons_edit']) || $rzvy_loginutype=='admin'){
				$couponactionbtns .= '<a class="btn btn-primary rzvy-white btn-sm rzvy-update-couponmodal" data-id="'.$coupon['id'].'"><i class="fa fa-fw fa-pencil"></i></a> &nbsp;';	
			}
			if(isset($rzvy_rolepermissions['rzvy_coupons_delete']) || $rzvy_loginutype=='admin'){
				$couponactionbtns .= '<a data-id="'.$coupon['id'].'" class="btn btn-danger rzvy-white btn-sm rzvy-delete-coupon-sweetalert"><i class="fa fa-fw fa-trash"></i></a>';	
			}
			array_push($coupon_arr, $couponactionbtns);
			array_push($coupons['data'], $coupon_arr);
		}
	}
	echo json_encode($coupons);
}
/* Update coupon modal ajax */
else if(isset($_REQUEST['update_coupon_modal'])){
	$obj_coupons->id = $_POST['id'];
	$coupon = $obj_coupons->readone_coupon();
	?>
	<form name="rzvy_update_coupon_form" id="rzvy_update_coupon_form" method="post">
	  <div class="form-group">
		<label for="rzvy_update_couponcode"><?php if(isset($rzvy_translangArr['coupon_code'])){ echo $rzvy_translangArr['coupon_code']; }else{ echo $rzvy_defaultlang['coupon_code']; } ?></label>
		<input class="form-control" id="rzvy_update_couponcode" name="rzvy_update_couponcode" type="text" value="<?php echo $coupon['coupon_code']; ?>" placeholder="<?php if(isset($rzvy_translangArr['enter_coupon_code'])){ echo $rzvy_translangArr['enter_coupon_code']; }else{ echo $rzvy_defaultlang['enter_coupon_code']; } ?>" />
	  </div>
	  <div class="form-group">
		<label for="rzvy_update_coupontype"><?php if(isset($rzvy_translangArr['coupon_type'])){ echo $rzvy_translangArr['coupon_type']; }else{ echo $rzvy_defaultlang['coupon_type']; } ?></label>
		<select class="form-control" id="rzvy_update_coupontype" name="rzvy_update_coupontype">
		  <option value="percentage" <?php if($coupon['coupon_type'] == "percentage"){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['percentage'])){ echo $rzvy_translangArr['percentage']; }else{ echo $rzvy_defaultlang['percentage']; } ?></option>
		  <option value="flat" <?php if($coupon['coupon_type'] == "flat"){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['flat'])){ echo $rzvy_translangArr['flat']; }else{ echo $rzvy_defaultlang['flat']; } ?></option>
		</select>
	  </div>
	  <div class="form-group">
		<label for="rzvy_update_couponvalue"><?php if(isset($rzvy_translangArr['coupon_value'])){ echo $rzvy_translangArr['coupon_value']; }else{ echo $rzvy_defaultlang['coupon_value']; } ?></label>
		<input class="form-control" id="rzvy_update_couponvalue" name="rzvy_update_couponvalue" type="text" value="<?php echo $coupon['coupon_value']; ?>" placeholder="<?php if(isset($rzvy_translangArr['enter_coupon_value'])){ echo $rzvy_translangArr['enter_coupon_value']; }else{ echo $rzvy_defaultlang['enter_coupon_value']; } ?>" />
	  </div>
	  <div class="form-group">
		<label for="rzvy_update_couponstart"><?php if(isset($rzvy_translangArr['start_date'])){ echo $rzvy_translangArr['start_date']; }else{ echo $rzvy_defaultlang['start_date']; } ?></label>
		<input class="form-control" id="rzvy_update_couponstart" name="rzvy_update_couponstart" type="date" value="<?php echo $coupon['coupon_expiry'];?>" />
	  </div>
	  <div class="form-group">
		<label for="rzvy_update_couponexpiry"><?php if(isset($rzvy_translangArr['expiry_date'])){ echo $rzvy_translangArr['expiry_date']; }else{ echo $rzvy_defaultlang['expiry_date']; } ?></label>
		<input class="form-control" id="rzvy_update_couponexpiry" name="rzvy_update_couponexpiry" type="date" value="<?php echo $coupon['coupon_expiry'];?>" />
	  </div>
	  <div class="form-group">
		<label for="rzvy_update_couponusage"><?php if(isset($rzvy_translangArr['usage_type'])){ echo $rzvy_translangArr['usage_type']; }else{ echo $rzvy_defaultlang['usage_type']; } ?></label>
		<select class="form-control" id="rzvy_update_couponusage" name="rzvy_update_couponusage">
		  <option value="O" <?php if($coupon['usage'] == "O"){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['once'])){ echo $rzvy_translangArr['once']; }else{ echo $rzvy_defaultlang['once']; } ?></option>
		  <option value="M" <?php if($coupon['usage'] == "M"){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['multiple_times'])){ echo $rzvy_translangArr['multiple_times']; }else{ echo $rzvy_defaultlang['multiple_times']; } ?></option>
		</select>
	  </div>
	  <div class="form-group">
		<label for="rzvy_update_couponusers"><?php if(isset($rzvy_translangArr['allowed_for'])){ echo $rzvy_translangArr['allowed_for']; }else{ echo $rzvy_defaultlang['allowed_for']; } ?></label>
		<select class="form-control selectpicker" id="rzvy_update_couponusers" name="rzvy_update_couponusers" multiple>
		  <option value="A" <?php if(is_numeric(strpos($coupon['users'],"A"))){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['all_customers'])){ echo $rzvy_translangArr['all_customers']; }else{ echo $rzvy_defaultlang['all_customers']; } ?></option>
		  <option value="N" <?php if(is_numeric(strpos($coupon['users'],"N"))){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['new_customers'])){ echo $rzvy_translangArr['new_customers']; }else{ echo $rzvy_defaultlang['new_customers']; } ?></option>
		  <option value="E" <?php if(is_numeric(strpos($coupon['users'],"E"))){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['existing_customers'])){ echo $rzvy_translangArr['existing_customers']; }else{ echo $rzvy_defaultlang['existing_customers']; } ?></option>
		  <option value="G" <?php if(is_numeric(strpos($coupon['users'],"G"))){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['guest_customers'])){ echo $rzvy_translangArr['guest_customers']; }else{ echo $rzvy_defaultlang['guest_customers']; } ?></option>
		</select>
	  </div>
	  <div class="form-group">
		  <a class="btn btn-primary rzvy_update_coupon_btn w-100" data-id="<?php echo $coupon['id']; ?>" href="javascript:void(0);"><?php if(isset($rzvy_translangArr['update'])){ echo $rzvy_translangArr['update']; }else{ echo $rzvy_defaultlang['update']; } ?></a>
	  </div>
	</form>
	<?php
}

/* Update coupon ajax */
else if(isset($_POST['update_coupon'])){
	$obj_coupons->id = $_POST['id'];
	$obj_coupons->coupon_code = htmlentities($_POST['coupon_code']);
	$obj_coupons->coupon_type = $_POST['coupon_type'];
	$obj_coupons->coupon_value = $_POST['coupon_value'];
	$obj_coupons->coupon_expiry = date('Y-m-d', strtotime($_POST['coupon_expiry']));
	$obj_coupons->coupon_start = date('Y-m-d', strtotime($_POST['coupon_start']));
	$obj_coupons->usage = $_POST['usage'];
	$obj_coupons->users = implode('',$_POST['users']);
	$coupon_updated = $obj_coupons->update_coupon();
	if($coupon_updated){
		echo "updated";
	}else{
		echo "failed";
	}
}