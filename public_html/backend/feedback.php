<?php 
include 'header.php'; 
if(!isset($rzvy_rolepermissions['rzvy_feedback']) && $rzvy_loginutype=='staff'){ ?>
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
include(dirname(dirname(__FILE__))."/classes/class_feedback.php");
/* Create object of classes */
$obj_feedback = new rzvy_feedback();
$obj_feedback->conn = $conn; 

$rzvy_categoryids = $obj_feedback->get_all_category_ids();
$categoryids = array();
if(mysqli_num_rows($rzvy_categoryids)>0){
	while($rzvy_categoryid = mysqli_fetch_assoc($rzvy_categoryids)){
		$categoryids[] = $rzvy_categoryid['id'];
	}
}
?>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo SITE_URL; ?>backend/appointments.php"><i class="fa fa-home"></i></a>
        </li>
        <li class="breadcrumb-item active"><?php if(isset($rzvy_translangArr['feedbacks'])){ echo $rzvy_translangArr['feedbacks']; }else{ echo $rzvy_defaultlang['feedbacks']; } ?></li>
      </ol>
      <!-- Feedback DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-fw fa-book"></i> <?php if(isset($rzvy_translangArr['feedback_list'])){ echo $rzvy_translangArr['feedback_list']; }else{ echo $rzvy_defaultlang['feedback_list']; } ?>
		  </div>
        <div class="card-body">
          <div class="table-responsive">
			<div class="rzvy-tabbable-panel">
				<div class="rzvy-tabbable-line">
					<ul class="nav nav-tabs">
						<?php if(isset($rzvy_rolepermissions['rzvy_feedback']) || $rzvy_loginutype=='admin'){ ?>
							  <li class="nav-item custom-nav-item <?php if(isset($rzvy_rolepermissions['rzvy_feedback']) || $rzvy_loginutype=='admin'){ echo 'active'; } ?>">
								<a class="nav-link custom-nav-link rzvy_tab_view_nav_link" data-tabno="0" data-toggle="tab" href="#rzvy_feedback_list"><i class="fa fa-book"></i> <?php if(isset($rzvy_translangArr['feedbacks'])){ echo $rzvy_translangArr['feedbacks']; }else{ echo $rzvy_defaultlang['feedbacks']; } ?></a>
							  </li>
						<?php } if(isset($rzvy_rolepermissions['rzvy_reviewsmanage']) || $rzvy_loginutype=='admin'){ ?>  
							  <li class="nav-item custom-nav-item <?php if(!isset($rzvy_rolepermissions['rzvy_reviewsmanage']) && isset($rzvy_rolepermissions['rzvy_feedback'])){ echo 'active'; } ?>">
								<a class="nav-link custom-nav-link rzvy_tab_view_nav_link" data-tabno="1" data-toggle="tab" href="#rzvy_reviews_list"><i class="fa fa-star"></i> <?php if(isset($rzvy_translangArr['reviews_list'])){ echo $rzvy_translangArr['reviews_list']; }else{ echo $rzvy_defaultlang['reviews_list']; } ?></a>
							  </li>
						<?php } if(isset($rzvy_rolepermissions['rzvy_settings_reviewsettings_view']) || $rzvy_loginutype=='admin'){ ?>  
							  <li class="nav-item custom-nav-item <?php if(!isset($rzvy_rolepermissions['rzvy_feedback']) && !isset($rzvy_rolepermissions['rzvy_reviewsmanage']) && $rzvy_loginutype!='admin' && isset($rzvy_rolepermissions['rzvy_settings_reviewsettings_view'])){ echo 'active'; } ?>">
								<a class="nav-link custom-nav-link rzvy_tab_view_nav_link" data-tabno="2" data-toggle="tab" href="#rzvy_reviews_settings"><i class="fa fa-cog"></i> <?php if(isset($rzvy_translangArr['reviews_settings'])){ echo $rzvy_translangArr['reviews_settings']; }else{ echo $rzvy_defaultlang['reviews_settings']; } ?></a>
							  </li>
						<?php } ?>	  
					</ul>
				</div>
			</div>	
		<div class="tab-content">  
			<div class="tab-pane container <?php if(isset($rzvy_rolepermissions['rzvy_feedback']) || $rzvy_loginutype=='admin'){ echo 'active'; }else{ echo 'fade'; } ?>" id="rzvy_feedback_list">
				<table class="display responsive nowrap" width="100%" cellspacing="0" id="rzvy_feedback_list_table">
				  <thead>
					<tr>
					  <th><?php if(isset($rzvy_translangArr['name'])){ echo $rzvy_translangArr['name']; }else{ echo $rzvy_defaultlang['name']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['email'])){ echo $rzvy_translangArr['email']; }else{ echo $rzvy_defaultlang['email']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['rating'])){ echo $rzvy_translangArr['rating']; }else{ echo $rzvy_defaultlang['rating']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['review'])){ echo $rzvy_translangArr['review']; }else{ echo $rzvy_defaultlang['review']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['review_on'])){ echo $rzvy_translangArr['review_on']; }else{ echo $rzvy_defaultlang['review_on']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['status'])){ echo $rzvy_translangArr['status']; }else{ echo $rzvy_defaultlang['status']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['action'])){ echo $rzvy_translangArr['action']; }else{ echo $rzvy_defaultlang['action']; } ?></th>
					</tr>
				  </thead>
				  <tbody>
					<?php 
					$all_feedbacks = $obj_feedback->get_all_feedbacks();
					$rating_star_array = array(
						"0" => '<i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i>',
						"1" => '<i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i>',
						"2" => '<i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i>',
						"3" => '<i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star-o text-warning"></i><i class="fa fa-lg fa-star-o text-warning"></i>',
						"4" => '<i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star-o text-warning"></i>',
						"5" => '<i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i><i class="fa fa-lg fa-star"></i>',
					);
					if(mysqli_num_rows($all_feedbacks)>0){
						$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
						$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
						
						while($feedback = mysqli_fetch_assoc($all_feedbacks)){
							?>
							<tr>
								<td><?php echo ucwords($feedback['name']); ?></td>
								<td><?php echo $feedback['email']; ?></td>
								<td><?php echo $rating_star_array[$feedback['rating']]; ?></td>
								<td><?php echo $feedback['review']; ?></td>
								<td><?php echo date($rzvy_date_format." ".$rzvy_time_format, strtotime($feedback['review_datetime'])); ?></td>
								<td>
									<?php $checked = ''; if($feedback['status'] == "Y"){ $checked = "checked"; } ?>
									<?php if(isset($rzvy_rolepermissions['rzvy_feedback_status']) || $rzvy_loginutype=='admin'){ ?>
										<label class="rzvy-toggle-switch">
										  <input type="checkbox" data-id="<?php echo $feedback['id']; ?>" class="rzvy-toggle-switch-input rzvy_change_feedback_status" <?php echo $checked; ?> />
										  <span class="rzvy-toggle-switch-slider"></span>
										</label>
									<?php }elseif(!isset($rzvy_rolepermissions['rzvy_feedback_status']) && $rzvy_loginutype=='staff'){ 
											if($feedback['status'] == "Y"){
												if(isset($rzvy_translangArr['enable'])){ echo $rzvy_translangArr['enable']; }else{ echo $rzvy_defaultlang['enable']; }
											}else{
												if(isset($rzvy_translangArr['disable'])){ echo $rzvy_translangArr['disable']; }else{ echo $rzvy_defaultlang['disable']; }
											}
										} ?>		
								</td>
								<td>
									<?php if(isset($rzvy_rolepermissions['rzvy_feedback_delete']) || $rzvy_loginutype=='admin'){ ?>
										<a class="btn btn-danger rzvy-white btn-sm rzvy_delete_feedback_btn m-1" data-id="<?php echo $feedback['id']; ?>"><i class="fa fa-fw fa-trash"></i></a>
									<?php } ?>
								</td>
							</tr>
							<?php 
						}
					}
					?>
				  </tbody>
			   </table>
			</div>
			<div class="tab-pane container <?php if(isset($rzvy_rolepermissions['rzvy_reviewsmanage']) && !isset($rzvy_rolepermissions['rzvy_feedback'])){ echo 'active'; }else{ echo 'fade'; } ?>" id="rzvy_reviews_list">
				<table class="display responsive nowrap" width="100%" cellspacing="0" id="rzvy_review_list_table">
				  <thead>
					<tr>
					  <th><?php if(isset($rzvy_translangArr['name'])){ echo $rzvy_translangArr['name']; }else{ echo $rzvy_defaultlang['name']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['email'])){ echo $rzvy_translangArr['email']; }else{ echo $rzvy_defaultlang['email']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['rating'])){ echo $rzvy_translangArr['rating']; }else{ echo $rzvy_defaultlang['rating']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['review'])){ echo $rzvy_translangArr['review']; }else{ echo $rzvy_defaultlang['review']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['review_on'])){ echo $rzvy_translangArr['review_on']; }else{ echo $rzvy_defaultlang['review_on']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['staff'])){ echo $rzvy_translangArr['staff']; }else{ echo $rzvy_defaultlang['staff']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['service'])){ echo $rzvy_translangArr['service']; }else{ echo $rzvy_defaultlang['service']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['category'])){ echo $rzvy_translangArr['category']; }else{ echo $rzvy_defaultlang['category']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['action'])){ echo $rzvy_translangArr['action']; }else{ echo $rzvy_defaultlang['action']; } ?></th>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>
			</div>
			<?php if(isset($rzvy_rolepermissions['rzvy_settings_reviewsettings_view']) || $rzvy_loginutype=='admin'){ ?>
			<div class="tab-pane container fade mt-4" id="rzvy_reviews_settings">
				<?php if(isset($rzvy_rolepermissions['rzvy_settings_reviewsettings']) || $rzvy_loginutype=='admin'){ ?>
				<div class="row">
					<div class="col-md-12">						
						<div class="form-group row">
							<div class="col-md-6">
								<label class="control-label"><?php if(isset($rzvy_translangArr['display_reviews_on_booking_form'])){ echo $rzvy_translangArr['display_reviews_on_booking_form']; }else{ echo $rzvy_defaultlang['display_reviews_on_booking_form']; } ?></label>
								<?php $rzvy_ratings_status = $obj_settings->get_option("rzvy_ratings_status"); ?>
								<select name="rzvy_ratings_status" id="rzvy_ratings_status" class="form-control selectpicker">
								  <option value="Y" <?php if($rzvy_ratings_status == "Y"){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['yes'])){ echo $rzvy_translangArr['yes']; }else{ echo $rzvy_defaultlang['yes']; } ?></option>
								  <option value="N" <?php if($rzvy_ratings_status == "N"){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['no'])){ echo $rzvy_translangArr['no']; }else{ echo $rzvy_defaultlang['no']; } ?></option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="control-label"><?php if(isset($rzvy_translangArr['number_of_reviews_to_display'])){ echo $rzvy_translangArr['number_of_reviews_to_display']; }else{ echo $rzvy_defaultlang['number_of_reviews_to_display']; } ?></label>
								<?php $rzvy_ratings_limit = $obj_settings->get_option("rzvy_ratings_limit"); ?>
								<select name="rzvy_ratings_limit" id="rzvy_ratings_limit" class="form-control selectpicker">
								  <option value="0" <?php if($rzvy_ratings_limit == "0"){ echo "selected"; } ?>><?php if(isset($rzvy_translangArr['all'])){ echo $rzvy_translangArr['all']; }else{ echo $rzvy_defaultlang['all']; } ?></option>
								  <option value="5" <?php if($rzvy_ratings_limit == "5"){ echo "selected"; } ?>>5</option>
								  <option value="10" <?php if($rzvy_ratings_limit == "10"){ echo "selected"; } ?>>10</option>
								  <option value="15" <?php if($rzvy_ratings_limit == "15"){ echo "selected"; } ?>>15</option>
								  <option value="20" <?php if($rzvy_ratings_limit == "20"){ echo "selected"; } ?>>20</option>
								  <option value="25" <?php if($rzvy_ratings_limit == "25"){ echo "selected"; } ?>>25</option>
								  <option value="30" <?php if($rzvy_ratings_limit == "30"){ echo "selected"; } ?>>30</option>
								  <option value="35" <?php if($rzvy_ratings_limit == "35"){ echo "selected"; } ?>>35</option>
								  <option value="40" <?php if($rzvy_ratings_limit == "40"){ echo "selected"; } ?>>40</option>
								  <option value="45" <?php if($rzvy_ratings_limit == "45"){ echo "selected"; } ?>>45</option>
								  <option value="50" <?php if($rzvy_ratings_limit == "50"){ echo "selected"; } ?>>50</option>
								</select>
							</div>							
						  </div>
						  
							<a id="update_ratingform_settings_btn" class="btn btn-primary btn-block mt-2" href="javascript:void(0);"><?php if(isset($rzvy_translangArr['update_settings'])){ echo $rzvy_translangArr['update_settings']; }else{ echo $rzvy_defaultlang['update_settings']; } ?></a>
					</div>
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-md-12">
						
						<div class="form-group row">
							<!-- Embed as IFrame Cards-->
							<div class="card mb-3 mt-5">
								<h6 class="pl-2 pb-2 pt-2"><?php if(isset($rzvy_translangArr['please_copy_below_code_and_paste'])){ echo $rzvy_translangArr['please_copy_below_code_and_paste']; }else{ echo $rzvy_defaultlang['please_copy_below_code_and_paste']; } ?></h6>
								<div class="card-header"><i class="fa fa-code"></i> <?php if(isset($rzvy_translangArr['embed_all_reviews_with_iframe'])){ echo $rzvy_translangArr['embed_all_reviews_with_iframe']; }else{ echo $rzvy_defaultlang['embed_all_reviews_with_iframe']; } ?></div>
								<div class="card-body">
									<div class="row">
										<div class="col-xl-12 col-sm-6">
											<code>&lt;iframe id="rzy_iframe_object_reviews" src="<?php echo SITE_URL; ?>includes/embed/rzvy_reviews.php"  frameborder='0' allowfullscreen='' width='100%' style='overflow:hidden;width: 100%;' height="300px" &gt;&lt;/iframe&gt;</code>
										</div>
									</div>
								</div>
							</div>
							<?php if(sizeof($categoryids)>0){ ?>
							<div class="card mb-3 mt-5">
								<h6 class="pl-2 pb-2 pt-2"><?php if(isset($rzvy_translangArr['category_specific_note'])){ echo $rzvy_translangArr['category_specific_note']; }else{ echo $rzvy_defaultlang['category_specific_note']; } ?></h6>
								<div class="card-header"><i class="fa fa-code"></i> <?php if(isset($rzvy_translangArr['embed_category_sepcific_reviews_with_iframe'])){ echo $rzvy_translangArr['embed_category_sepcific_reviews_with_iframe']; }else{ echo $rzvy_defaultlang['embed_category_sepcific_reviews_with_iframe']; } ?><?php echo implode(',',$categoryids); ?></div>
								<div class="card-body">
									<div class="row">
										<div class="col-xl-12 col-sm-6">
											<code>&lt;iframe id="rzy_iframe_object_reviews" src="<?php echo SITE_URL; ?>includes/embed/rzvy_reviews.php?c=<?php echo implode(',',$categoryids); ?>"  frameborder='0' allowfullscreen='' width='100%' style='overflow:hidden;width: 100%;' height="300px" &gt;&lt;/iframe&gt;</code>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>	
				</div>
			</div>
			<?php } ?>
	   </div>
	  </div>
	</div>
  </div>
<?php include 'footer.php'; ?>