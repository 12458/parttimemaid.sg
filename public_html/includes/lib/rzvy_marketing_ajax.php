<?php 
/* Include class files */
include(dirname(dirname(dirname(__FILE__)))."/constants.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_marketing.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_settings.php");

/* Create object of classes */
$obj_marketing = new rzvy_marketing();
$obj_marketing->conn = $conn;
$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

/* Add campaign ajax */
if(isset($_POST['add_campaign'])){
	$obj_marketing->name = htmlentities($_POST['campaign_name']);
	$obj_marketing->start_date = date('Y-m-d', strtotime($_POST['campaign_start']));
	$obj_marketing->end_date = date('Y-m-d', strtotime($_POST['campaign_end']));
	$campaign_added = $obj_marketing->create_campaign();
	if($campaign_added){
		echo "added";
	}else{
		echo "failed";
	}
}
/* Delete coupon ajax */
else if(isset($_POST['delete_campaign'])){
	$obj_marketing->id = $_POST['id'];
	$campaign_deleted = $obj_marketing->delete_campaign();
	if($campaign_deleted){
		echo "deleted";
	}else{
		echo "failed";
	}
}
/* Refresh coupon ajax */
else if(isset($_REQUEST['refresh_campaigns'])){
	$all_campaigns = $obj_marketing->get_all_campaigns_within_limit($_POST['start'],($_POST['start']+$_POST['length']), $_POST['search']['value'],$_POST['order'][0]['column'],$_POST['order'][0]['dir'],$_POST['draw']);
	$campaigns = array();
	$campaigns["draw"] = $_POST['draw'];
	$count_all_coupons = $obj_marketing->count_all_campaign($_POST['search']['value']);
	$campaigns["recordsTotal"] = $count_all_coupons;
	$campaigns["recordsFiltered"] = $count_all_coupons;
	$campaigns['data'] =array();
	if(mysqli_num_rows($all_campaigns)>0){
		$i=$_POST['start'];
		$rzvy_currency_symbol = $obj_settings->get_option('rzvy_currency_symbol');
		$rzvy_currency_position = $obj_settings->get_option('rzvy_currency_position');
		while($campaign = mysqli_fetch_assoc($all_campaigns)){
			$i++;
			$campaign_arr = array();
			array_push($campaign_arr, $campaign['id']);
			array_push($campaign_arr, ucwords($campaign['name']));
			array_push($campaign_arr, date($obj_settings->get_option('rzvy_date_format'), strtotime($campaign['start_date'])));
			array_push($campaign_arr, date($obj_settings->get_option('rzvy_date_format'), strtotime($campaign['end_date'])));
			array_push($campaign_arr, ucwords($campaign['statsin']));
			
			
			
			
			$quicksharebtns = '';
			if(isset($rzvy_rolepermissions['rzvy_campaign_share']) || $rzvy_loginutype=='admin'){
				$campaignurl = SITE_URL.'m/'.$campaign['id'];
				
				$quicksharebtns .= '<a class="btn btn-primary rzvy_fb_share" href="http://www.facebook.com/sharer.php?u='.$campaignurl.'" target="_blank"><i class="fa fa-facebook"></i></a>&nbsp;';
				
				$quicksharebtns .= '<a class="btn btn-info rzvy_fb_share" href="http://twitter.com/share?url='.$campaignurl.'" target="_blank"><i class="fa fa-twitter"></i></a>&nbsp;';
				
				$quicksharebtns .= '<a class="btn btn-danger rzvy_fb_share" href="https://plus.google.com/share?url='.$campaignurl.'" target="_blank"><i class="fa fa-google-plus"></i></a>&nbsp;';
				
				$quicksharebtns .= '<a class="btn btn-success rzvy_fb_share" href="https://wa.me/?text='.$campaignurl.'" target="_blank"><i class="fa fa-whatsapp"></i></a>';
			}			
			array_push($campaign_arr, $quicksharebtns);
			
			$campaignactionbtns = '';	
			if(isset($rzvy_rolepermissions['rzvy_campaign_edit']) || $rzvy_loginutype=='admin'){
				$campaignactionbtns .= '<a class="btn btn-primary rzvy-white btn-sm rzvy-update-campaignmodal" data-id="'.$campaign['id'].'"><i class="fa fa-fw fa-pencil"></i></a> &nbsp;';	
			}
			if(isset($rzvy_rolepermissions['rzvy_campaign_delete']) || $rzvy_loginutype=='admin'){
				$campaignactionbtns .= '<a data-id="'.$campaign['id'].'" class="btn btn-danger rzvy-white btn-sm rzvy-delete-campaign-sweetalert"><i class="fa fa-fw fa-trash"></i></a>';	
			}
			array_push($campaign_arr, $campaignactionbtns);
			array_push($campaigns['data'], $campaign_arr);
		}
	}
	echo json_encode($campaigns);
}
/* Update coupon modal ajax */
else if(isset($_REQUEST['update_campaign_modal'])){
	$obj_marketing->id = $_POST['id'];
	$campaign = $obj_marketing->readone_campaign();
	?>
	<form name="rzvy_update_campaign_form" id="rzvy_update_campaign_form" method="post">
	  <div class="row">
		  <div class="form-group col-md-12">
			<label for="rzvy_campaignname_u"><?php if(isset($rzvy_translangArr['name'])){ echo $rzvy_translangArr['name']; }else{ echo $rzvy_defaultlang['name']; } ?></label>
			<input class="form-control" id="rzvy_campaignname_u" name="rzvy_campaignname_u" type="text" placeholder="<?php if(isset($rzvy_translangArr['enter_campaign_name'])){ echo $rzvy_translangArr['enter_campaign_name']; }else{ echo $rzvy_defaultlang['enter_campaign_name']; } ?>" value="<?php echo $campaign['name']; ?>" />
		  </div>
		   <div class="form-group col-md-12">
			<label for="rzvy_campaignstart_u"><?php if(isset($rzvy_translangArr['start_date'])){ echo $rzvy_translangArr['start_date']; }else{ echo $rzvy_defaultlang['start_date']; } ?></label>
			<input class="form-control" id="rzvy_campaignstart_u" name="rzvy_campaignstart_u" type="date" value="<?php echo $campaign['start_date']; ?>" />
		  </div>
		  <div class="form-group col-md-12">
			<label for="rzvy_campaignend_u"><?php if(isset($rzvy_translangArr['end_date'])){ echo $rzvy_translangArr['end_date']; }else{ echo $rzvy_defaultlang['end_date']; } ?></label>
			<input class="form-control" id="rzvy_campaignend_u" name="rzvy_campaignend_u" type="date" value="<?php echo$campaign['end_date']; ?>" />
		  </div>	
	  </div>
	  <div class="form-group">
		  <a class="btn btn-primary rzvy_update_campaign_btn w-100" data-id="<?php echo $campaign['id']; ?>" href="javascript:void(0);"><?php if(isset($rzvy_translangArr['update'])){ echo $rzvy_translangArr['update']; }else{ echo $rzvy_defaultlang['update']; } ?></a>
	  </div>
	</form><?php
}

/* Update coupon ajax */
else if(isset($_POST['update_campaign'])){
	$obj_marketing->id = $_POST['id'];
	$obj_marketing->name = htmlentities($_POST['campaign_name']);
	$obj_marketing->start_date = date('Y-m-d', strtotime($_POST['campaign_start']));
	$obj_marketing->end_date = date('Y-m-d', strtotime($_POST['campaign_end']));
	$campaign_updated = $obj_marketing->update_campaign();
	if($campaign_updated){
		echo "updated";
	}else{
		echo "failed";
	}
}