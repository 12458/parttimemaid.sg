<?php 
include 'header.php'; 
if(!isset($rzvy_rolepermissions['rzvy_marketing_campaigns']) && $rzvy_loginutype=='staff'){ ?>
	<div class="container mt-12">
		  <div class="row mt-5"><div class="col-md-12">&nbsp;</div></div>
          <div class="row mt-5">
               <div class="col-md-2 text-center mt-5">
                  <i class="fa fa-exclamation-triangle fa-5x"></i>
               </div>
               <div class="col-md-10 mt-5">
                   <p><?php if(isset($rzvy_translangArr['permission_error_message'])){ echo $rzvy_translangArr['permission_error_message']; }else{ echo $rzvy_defaultlang['permission_error_message']; } ?></p>                    
               </div>
          </div>
     </div>		
<?php die(); } 
include(dirname(dirname(__FILE__))."/classes/class_marketing.php");
/* Create object of classes */
$obj_marketing = new rzvy_marketing();
$obj_marketing->conn = $conn; 
$allcampaigns = $obj_marketing->get_all_campaigns();

$rzvy_cards_width_class = 'col-lg-3';
?>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo SITE_URL; ?>backend/appointments.php"><i class="fa fa-home"></i></a>
        </li>
        <li class="breadcrumb-item active"><?php if(isset($rzvy_translangArr['marketing_campaigns'])){ echo $rzvy_translangArr['marketing_campaigns']; }else{ echo $rzvy_defaultlang['marketing_campaigns']; } ?></li>
      </ol>
      <!-- Feedback DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
            <?php if(isset($rzvy_rolepermissions['rzvy_add_campaigns']) || $rzvy_loginutype=='admin'){ ?>
				<a class="btn btn-primary btn-sm rzvy-white pull-right" data-toggle="modal" data-target="#rzvy_add_campaign_modal"><i class="fa fa-plus"></i> <?php if(isset($rzvy_translangArr['add_campaign'])){ echo $rzvy_translangArr['add_campaign']; }else{ echo $rzvy_defaultlang['add_campaign']; } ?></a>
			<?php } ?>	
		</div>
        <div class="card-body">
          <div class="table-responsive">
			<div class="rzvy-tabbable-panel">
				<div class="rzvy-tabbable-line">
					<ul class="nav nav-tabs">
						<?php if(isset($rzvy_rolepermissions['rzvy_campaigns_statistics']) || $rzvy_loginutype=='admin'){ ?>
							  <li class="nav-item custom-nav-item <?php if(isset($rzvy_rolepermissions['rzvy_campaigns_statistics']) || $rzvy_loginutype=='admin'){ echo 'active'; } ?>">
								<a class="nav-link custom-nav-link rzvy_tab_view_nav_link <?php if(isset($rzvy_rolepermissions['rzvy_campaigns_statistics']) || $rzvy_loginutype=='admin'){ echo 'active'; } ?>" data-tabno="0" data-toggle="tab" href="#rzvy_campaigns_statistics"><i class="fa fa-bar-chart"></i> <?php if(isset($rzvy_translangArr['campaigns_statistics'])){ echo $rzvy_translangArr['campaigns_statistics']; }else{ echo $rzvy_defaultlang['campaigns_statistics']; } ?></a>
							  </li>
						<?php } if(isset($rzvy_rolepermissions['rzvy_manage_campaigns']) || $rzvy_loginutype=='admin'){ ?>  
							  <li class="nav-item custom-nav-item <?php if(!isset($rzvy_rolepermissions['rzvy_manage_campaigns']) && isset($rzvy_rolepermissions['rzvy_manage_campaigns'])){ echo 'active'; } ?>">
								<a class="nav-link custom-nav-link rzvy_tab_view_nav_link <?php if(!isset($rzvy_rolepermissions['rzvy_manage_campaigns']) && isset($rzvy_rolepermissions['rzvy_manage_campaigns'])){ echo 'active'; } ?>" data-tabno="1" data-toggle="tab" href="#rzvy_manage_campaigns"><i class="fa fa-cog"></i> <?php if(isset($rzvy_translangArr['manage_campaigns'])){ echo $rzvy_translangArr['manage_campaigns']; }else{ echo $rzvy_defaultlang['manage_campaigns']; } ?></a>
							  </li>
						<?php } ?>	  
					</ul>
				</div>
			</div>	
		<div class="tab-content">  
			<div class="tab-pane container <?php if(isset($rzvy_rolepermissions['rzvy_campaigns_statistics']) || $rzvy_loginutype=='admin'){ echo 'active'; }else{ echo 'fade'; } ?>" id="rzvy_campaigns_statistics">
				<div class="row mt-4 mb-4">
					<?php if(@mysqli_num_rows($allcampaigns)>0){
						$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
						$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
						$colorsarry = array('danger','success','primary','info','secondary','warning');
						$faiconssarry = array('fa-line-chart','fa-pie-chart','fa-area-chart','fa-bar-chart','fa-sliders','fa-tachometer');
						$cardcolorkey = array_rand($colorsarry ,6);
						$campcounter = 0 ;
						while($allcampaign = mysqli_fetch_assoc($allcampaigns)){ 
							$colorkey = $cardcolorkey[$campcounter];
							$iconkey = $faiconssarry[$campcounter];
							 ?>
							<div class="col-xl-4 col-lg-6 mb-5">
								<div class="card card-stats mb-4 mb-xl-0">
									<div class="card-body">
									  <div class="row">
										<div class="col">
										  <h5 class="card-title text-muted mb-0"><?php echo ucwords($allcampaign['name']); ?></h5>
										  <span class="h2 font-weight-bold mb-0"><?php echo ucwords($allcampaign['statsin']); ?></span>
										</div>
										<div class="col-auto">
										  <div class="icon icon-shape bg-<?php echo $colorsarry[$colorkey]; ?> text-white rounded-circle shadow rzvy-card-icon-css d-flex justify-content-center">
											<i class="fa <?php echo $faiconssarry[$campcounter]; ?> fa-2x"></i>
										  </div>
										</div>
									  </div>
									  <p class="mt-3 mb-0 text-muted text-sm">										
										<span class="text-nowrap"><?php echo date($rzvy_date_format,strtotime($allcampaign['start_date'])); ?>&nbsp;<?php if(isset($rzvy_translangArr['to'])){ echo $rzvy_translangArr['to']; }else{ echo $rzvy_defaultlang['to']; } ?>&nbsp;<?php echo date($rzvy_date_format,strtotime($allcampaign['end_date'])); ?></span>
									  </p>
									</div>
								</div>
							</div>
						<?php if($campcounter==5){
								$campcounter = 0;
								}else{
									$campcounter++;
								}
							}  
					} ?>
				</div>
			</div>
			<div class="tab-pane container <?php if(isset($rzvy_rolepermissions['rzvy_manage_campaigns']) && !isset($rzvy_rolepermissions['rzvy_campaigns_statistics'])){ echo 'active'; }else{ echo 'fade'; } ?>" id="rzvy_manage_campaigns">
				<table class="display responsive nowrap" width="100%" cellspacing="0" id="rzvy_manage_campaigns_table">
				  <thead>
					<tr>
					  <th><?php if(isset($rzvy_translangArr['hash_rzy_translation'])){ echo $rzvy_translangArr['hash_rzy_translation']; }else{ echo $rzvy_defaultlang['hash_rzy_translation']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['name'])){ echo $rzvy_translangArr['name']; }else{ echo $rzvy_defaultlang['name']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['start_date'])){ echo $rzvy_translangArr['start_date']; }else{ echo $rzvy_defaultlang['start_date']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['end_date'])){ echo $rzvy_translangArr['end_date']; }else{ echo $rzvy_defaultlang['end_date']; } ?></th>					
					  <th><?php if(isset($rzvy_translangArr['statistics'])){ echo $rzvy_translangArr['statistics']; }else{ echo $rzvy_defaultlang['statistics']; } ?></th>					
					  <th><?php if(isset($rzvy_translangArr['quick_share'])){ echo $rzvy_translangArr['quick_share']; }else{ echo $rzvy_defaultlang['quick_share']; } ?></th>					
					  <th><?php if(isset($rzvy_translangArr['action'])){ echo $rzvy_translangArr['action']; }else{ echo $rzvy_defaultlang['action']; } ?></th>
					</tr>
				  </thead>
				  <tbody></tbody>
			   </table>
			</div>
	   </div>
	  </div>
	</div>
  </div>
  <?php if(isset($rzvy_rolepermissions['rzvy_add_campaigns']) || $rzvy_loginutype=='admin'){ ?>  
	<!-- Add Modal-->
	<div class="modal fade" id="rzvy_add_campaign_modal" tabindex="-1" role="dialog" aria-labelledby="rzvy_add_campaign_modal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="rzvy_add_campaign_modal_label"><?php if(isset($rzvy_translangArr['add_campaign'])){ echo $rzvy_translangArr['add_campaign']; }else{ echo $rzvy_defaultlang['add_campaign']; } ?></h5>
			<button class="close" type="button" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
			</button>
		  </div>
		  <div class="modal-body">
			<form name="rzvy_add_campaign_form" id="rzvy_add_campaign_form" method="post">
			  <div class="row">
				  <div class="form-group col-md-12">
					<label for="rzvy_campaignname"><?php if(isset($rzvy_translangArr['name'])){ echo $rzvy_translangArr['name']; }else{ echo $rzvy_defaultlang['name']; } ?></label>
					<input class="form-control" id="rzvy_campaignname" name="rzvy_campaignname" type="text" placeholder="<?php if(isset($rzvy_translangArr['enter_campaign_name'])){ echo $rzvy_translangArr['enter_campaign_name']; }else{ echo $rzvy_defaultlang['enter_campaign_name']; } ?>" />
				  </div>
				   <div class="form-group col-md-12">
					<label for="rzvy_campaignstart"><?php if(isset($rzvy_translangArr['start_date'])){ echo $rzvy_translangArr['start_date']; }else{ echo $rzvy_defaultlang['start_date']; } ?></label>
					<input class="form-control" id="rzvy_campaignstart" name="rzvy_campaignstart" type="date" value="<?php echo date('Y-m-d', $currDateTime_withTZ); ?>" />
				  </div>
				  <div class="form-group col-md-12">
					<label for="rzvy_campaignend"><?php if(isset($rzvy_translangArr['end_date'])){ echo $rzvy_translangArr['end_date']; }else{ echo $rzvy_defaultlang['end_date']; } ?></label>
					<input class="form-control" id="rzvy_campaignend" name="rzvy_campaignend" type="date" value="<?php echo date('Y-m-d', $currDateTime_withTZ); ?>" />
				  </div>	
			  </div>
			</form>
		  </div>
		  <div class="modal-footer">
			<a class="btn btn-primary add_campaign_btn w-100" href="javascript:void(0);"><?php if(isset($rzvy_translangArr['add'])){ echo $rzvy_translangArr['add']; }else{ echo $rzvy_defaultlang['add']; } ?></a>
		  </div>
		</div>
	  </div>
	</div>
	<?php } if(isset($rzvy_rolepermissions['rzvy_campaign_edit']) || $rzvy_loginutype=='admin'){ ?>
	<!-- Update Modal-->
	<div class="modal fade" id="rzvy_update_campaign_modal" tabindex="-1" role="dialog" aria-labelledby="rzvy_update_coupon_modal_label" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="rzvy_update_campaign_modal_label"><?php if(isset($rzvy_translangArr['update_campaign'])){ echo $rzvy_translangArr['update_campaign']; }else{ echo $rzvy_defaultlang['update_campaign']; } ?></h5>
			<button class="close" type="button" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
			</button>
		  </div>
		  <div class="modal-body rzvy_campaign_coupon_modal_body">
			<h2><?php if(isset($rzvy_translangArr['please_wait'])){ echo $rzvy_translangArr['please_wait']; }else{ echo $rzvy_defaultlang['please_wait']; } ?></h2>
		  </div>
		</div>
	  </div>
	</div>
	<?php } ?>
<?php include 'footer.php'; ?>