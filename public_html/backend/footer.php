</div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#rzvy-page-top">
      <i class="fa fa-angle-up"></i>
    </a>
	
	<!-- Appointment Detail Modal-->
	<div class="modal fade" id="rzvy_appointment_detail_modal" tabindex="-1" role="dialog" aria-labelledby="rzvy_appointment_detail_modal_label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="rzvy_appointment_detail_modal_label"><?php if(isset($rzvy_translangArr['appointment_detail'])){ echo $rzvy_translangArr['appointment_detail']; }else{ echo $rzvy_defaultlang['appointment_detail']; } ?></h5>
			
			<div class="pull-right">
				<?php if(isset($rzvy_rolepermissions['rzvy_delete_booking']) || $rzvy_loginutype=='admin'){ ?>
				<a class="btn btn-danger rzvy-white rzvy_delete_appt_btn" data-id=""><i class="fa fa-fw fa-trash"></i></a>
				<?php } ?>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span></button>
			</div>			
		  </div>
		  <div class="modal-body rzvy_appointment_detail_modal_body">
			<center><h2><?php if(isset($rzvy_translangArr['please_wait'])){ echo $rzvy_translangArr['please_wait']; }else{ echo $rzvy_defaultlang['please_wait']; } ?></h2></center>
		  </div>
		  <div class="modal-footer"> </div>
		</div>
	  </div>
	</div>	
	<?php if($rzvy_loginutype=='admin'){ ?>
    <!-- Logout Modal-->
    <div class="modal fade" id="rzvy-logout-modal" tabindex="-1" role="dialog" aria-labelledby="rzvy-logout-modal-label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rzvy-logout-modal-label"><?php if(isset($rzvy_translangArr['ready_to_leave'])){ echo $rzvy_translangArr['ready_to_leave']; }else{ echo $rzvy_defaultlang['ready_to_leave']; } ?></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body"><?php if(isset($rzvy_translangArr['select_logout_below'])){ echo $rzvy_translangArr['select_logout_below']; }else{ echo $rzvy_defaultlang['select_logout_below']; } ?></div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php if(isset($rzvy_translangArr['cancel'])){ echo $rzvy_translangArr['cancel']; }else{ echo $rzvy_defaultlang['cancel']; } ?></button>
            <a id="rzvy_logout_btn" class="btn btn-primary" href="javascript:void(0)"><?php if(isset($rzvy_translangArr['logout'])){ echo $rzvy_translangArr['logout']; }else{ echo $rzvy_defaultlang['logout']; } ?></a>
          </div>
        </div>
      </div>
    </div>
	<?php }else{ ?>
	<!-- Logout Modal-->
    <div class="modal fade" id="rzvy-logout-modal" tabindex="-1" role="dialog" aria-labelledby="rzvy-logout-modal-label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rzvy-logout-modal-label"><?php if(isset($rzvy_translangArr['ready_to_leave'])){ echo $rzvy_translangArr['ready_to_leave']; }else{ echo $rzvy_defaultlang['ready_to_leave']; } ?></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body"><?php if(isset($rzvy_translangArr['select_logout_below'])){ echo $rzvy_translangArr['select_logout_below']; }else{ echo $rzvy_defaultlang['select_logout_below']; } ?></div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php if(isset($rzvy_translangArr['cancel'])){ echo $rzvy_translangArr['cancel']; }else{ echo $rzvy_defaultlang['cancel']; } ?></button>
            <a id="rzvy_logout_btn" class="btn btn-primary" href="javascript:void(0)"><?php if(isset($rzvy_translangArr['logout'])){ echo $rzvy_translangArr['logout']; }else{ echo $rzvy_defaultlang['logout']; } ?></a>
          </div>
        </div>
      </div>
    </div>
	<?php } ?>
	
	<?php if($rzvy_loginutype=='admin'){ ?>
    <!-- Change Password Modal-->
    <div class="modal fade" id="rzvy-change-password-modal" tabindex="-1" role="dialog" aria-labelledby="rzvy-change-password-modal-label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rzvy-change-password-modal-label"><?php if(isset($rzvy_translangArr['change_password'])){ echo $rzvy_translangArr['change_password']; }else{ echo $rzvy_defaultlang['change_password']; } ?></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body">
			<form name="rzvy_change_password_form" id="rzvy_change_password_form" method="post">
			  <div class="form-group">
				<label for="rzvy_old_password"><?php if(isset($rzvy_translangArr['old_password'])){ echo $rzvy_translangArr['old_password']; }else{ echo $rzvy_defaultlang['old_password']; } ?></label>
				<input class="form-control" id="rzvy_old_password" name="rzvy_old_password" type="password" placeholder="<?php if(isset($rzvy_translangArr['enter_old_password'])){ echo $rzvy_translangArr['enter_old_password']; }else{ echo $rzvy_defaultlang['enter_old_password']; } ?>" autocomplete="off" />
			  </div>
			  <div class="form-group">
				<label for="rzvy_new_password"><?php if(isset($rzvy_translangArr['new_password'])){ echo $rzvy_translangArr['new_password']; }else{ echo $rzvy_defaultlang['new_password']; } ?></label>
				<input class="form-control" id="rzvy_new_password" name="rzvy_new_password" type="password" placeholder="<?php if(isset($rzvy_translangArr['enter_new_password'])){ echo $rzvy_translangArr['enter_new_password']; }else{ echo $rzvy_defaultlang['enter_new_password']; } ?>" autocomplete="off" />
			  </div>
			  <div class="form-group">
				<label for="rzvy_rtype_password"><?php if(isset($rzvy_translangArr['retype_new_password'])){ echo $rzvy_translangArr['retype_new_password']; }else{ echo $rzvy_defaultlang['retype_new_password']; } ?></label>
				<input class="form-control" id="rzvy_rtype_password" name="rzvy_rtype_password" type="password" placeholder="<?php if(isset($rzvy_translangArr['enter_retype_new_password'])){ echo $rzvy_translangArr['enter_retype_new_password']; }else{ echo $rzvy_defaultlang['enter_retype_new_password']; } ?>" autocomplete="off" />
			  </div>
			</form>
		  </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php if(isset($rzvy_translangArr['cancel'])){ echo $rzvy_translangArr['cancel']; }else{ echo $rzvy_defaultlang['cancel']; } ?></button>
            <a class="btn btn-primary rzvy_change_password_btn" data-id="<?php if(isset($_SESSION['admin_id'])){ echo $_SESSION['admin_id']; } ?>" href="javascript:void(0);"><?php if(isset($rzvy_translangArr['change_password'])){ echo $rzvy_translangArr['change_password']; }else{ echo $rzvy_defaultlang['change_password']; } ?></a>
          </div>
        </div>
      </div>
    </div>
	<?php }elseif($rzvy_loginutype=='staff'){ ?>
	<!-- Change Password Modal-->
    <div class="modal fade" id="rzvy-change-password-modal" tabindex="-1" role="dialog" aria-labelledby="rzvy-change-password-modal-label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rzvy-change-password-modal-label"><?php if(isset($rzvy_translangArr['change_password'])){ echo $rzvy_translangArr['change_password']; }else{ echo $rzvy_defaultlang['change_password']; } ?></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body">
			<form name="rzvy_change_password_form" id="rzvy_change_password_form" method="post">
			  <div class="form-group">
				<label for="rzvy_old_password"><?php if(isset($rzvy_translangArr['old_password'])){ echo $rzvy_translangArr['old_password']; }else{ echo $rzvy_defaultlang['old_password']; } ?></label>
				<input class="form-control" id="rzvy_old_password" name="rzvy_old_password" type="password" placeholder="<?php if(isset($rzvy_translangArr['enter_old_password'])){ echo $rzvy_translangArr['enter_old_password']; }else{ echo $rzvy_defaultlang['enter_old_password']; } ?>" autocomplete="off" />
			  </div>
			  <div class="form-group">
				<label for="rzvy_new_password"><?php if(isset($rzvy_translangArr['new_password'])){ echo $rzvy_translangArr['new_password']; }else{ echo $rzvy_defaultlang['new_password']; } ?></label>
				<input class="form-control" id="rzvy_new_password" name="rzvy_new_password" type="password" placeholder="<?php if(isset($rzvy_translangArr['enter_new_password'])){ echo $rzvy_translangArr['enter_new_password']; }else{ echo $rzvy_defaultlang['enter_new_password']; } ?>" autocomplete="off" />
			  </div>
			  <div class="form-group">
				<label for="rzvy_rtype_password"><?php if(isset($rzvy_translangArr['retype_new_password'])){ echo $rzvy_translangArr['retype_new_password']; }else{ echo $rzvy_defaultlang['retype_new_password']; } ?></label>
				<input class="form-control" id="rzvy_rtype_password" name="rzvy_rtype_password" type="password" placeholder="<?php if(isset($rzvy_translangArr['enter_retype_new_password'])){ echo $rzvy_translangArr['enter_retype_new_password']; }else{ echo $rzvy_defaultlang['enter_retype_new_password']; } ?>" autocomplete="off" />
			  </div>
			</form>
		  </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php if(isset($rzvy_translangArr['cancel'])){ echo $rzvy_translangArr['cancel']; }else{ echo $rzvy_defaultlang['cancel']; } ?></button>
            <a class="btn btn-primary rzvy_change_password_btn" data-id="<?php if(isset($_SESSION['staff_id'])){ echo $_SESSION['staff_id']; } ?>" href="javascript:void(0);"><?php if(isset($rzvy_translangArr['change_password'])){ echo $rzvy_translangArr['change_password']; }else{ echo $rzvy_defaultlang['change_password']; } ?></a>
          </div>
        </div>
      </div>
    </div>
	<?php } ?>
	 <!-- Appointments Modal-->
	<div class="modal fade" id="rzvy_customer_appointment_modal" tabindex="-1" role="dialog" aria-labelledby="rzvy_customer_appointment_modal_label" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="rzvy_customer_appointment_modal_label"><?php if(isset($rzvy_translangArr['booked_appointments'])){ echo $rzvy_translangArr['booked_appointments']; }else{ echo $rzvy_defaultlang['booked_appointments']; } ?></h5>
			<button class="close" type="button" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
			</button>
		  </div>
		  <div class="modal-body rzvy_customer_appointment_modal_body">
			<div class="table-responsive">
				<table class="display responsive nowrap" width="100%" cellspacing="0" id="rzvy_customer_appointments_listing">
				  <thead>
					<tr>
					  <th><?php if(isset($rzvy_translangArr['order_id'])){ echo $rzvy_translangArr['order_id']; }else{ echo $rzvy_defaultlang['order_id']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['category'])){ echo $rzvy_translangArr['category']; }else{ echo $rzvy_defaultlang['category']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['service'])){ echo $rzvy_translangArr['service']; }else{ echo $rzvy_defaultlang['service']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['addons'])){ echo $rzvy_translangArr['addons']; }else{ echo $rzvy_defaultlang['addons']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['staff_dt_listing'])){ echo $rzvy_translangArr['staff_dt_listing']; }else{ echo $rzvy_defaultlang['staff_dt_listing']; } ?></th>
					  <?php if($rzvy_book_with_datetime == "Y"){ ?><th><?php if(isset($rzvy_translangArr['booking_datetime'])){ echo $rzvy_translangArr['booking_datetime']; }else{ echo $rzvy_defaultlang['booking_datetime']; } ?></th><?php } ?>
					  <th><?php if(isset($rzvy_translangArr['booking_status'])){ echo $rzvy_translangArr['booking_status']; }else{ echo $rzvy_defaultlang['booking_status']; } ?></th>
					  <th><?php if(isset($rzvy_translangArr['payment_method'])){ echo $rzvy_translangArr['payment_method']; }else{ echo $rzvy_defaultlang['payment_method']; } ?></th>
					</tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>
			  </div>
		  </div>
		  <div class="modal-footer"> </div>
		</div>
	  </div>
	</div>
	<!-- Setup instruction Modal-->
    <div class="modal fade" id="rzvy-setup-instruction-modal" tabindex="-1" role="dialog" aria-labelledby="rzvy-setup-instruction-modal-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rzvy-setup-instruction-modal-label"><?php if(isset($rzvy_translangArr['setup_instructions'])){ echo $rzvy_translangArr['setup_instructions']; }else{ echo $rzvy_defaultlang['setup_instructions']; } ?></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body">
			<div class="row border p-4">
				<label><b><?php if(isset($rzvy_translangArr['instructions_step_1'])){ echo $rzvy_translangArr['instructions_step_1']; }else{ echo $rzvy_defaultlang['instructions_step_1']; } ?> </b> <?php if(isset($rzvy_translangArr['step_1_text'])){ echo $rzvy_translangArr['step_1_text']; }else{ echo $rzvy_defaultlang['step_1_text']; } ?></label>
			</div>
			<div class="row border p-4">
				<label><b><?php if(isset($rzvy_translangArr['instructions_step_2'])){ echo $rzvy_translangArr['instructions_step_2']; }else{ echo $rzvy_defaultlang['instructions_step_2']; } ?> </b> <?php if(isset($rzvy_translangArr['step_2_text'])){ echo $rzvy_translangArr['step_2_text']; }else{ echo $rzvy_defaultlang['step_2_text']; } ?></label>
			</div>
			<div class="row border p-4">
				<label><b><?php if(isset($rzvy_translangArr['instructions_step_3'])){ echo $rzvy_translangArr['instructions_step_3']; }else{ echo $rzvy_defaultlang['instructions_step_3']; } ?> </b> <?php if(isset($rzvy_translangArr['step_3_text'])){ echo $rzvy_translangArr['logout']; }else{ echo $rzvy_defaultlang['step_3_text']; } ?></label>
			</div>
		  </div>
        </div>
      </div>
    </div>
	<?php 
	$check_for_setup_instruction_modal = $obj_settings->check_for_setup_instruction_modal(); 
	if($check_for_setup_instruction_modal == "N"){
		if($obj_settings->get_option("rzvy_company_name") == "" || $obj_settings->get_option("rzvy_company_email") == "" || $obj_settings->get_option("rzvy_company_phone") == ""){
			$check_for_setup_instruction_modal = "Y";
		}
	} 
	
	$check_for_setup_instruction_modal = "N";
	?>
	<!-- Image Cropper Modal --->
	<div class="modal fade" id="rzvy_image_crop_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?php if(isset($rzvy_translangArr['crop_image_and_upload'])){ echo $rzvy_translangArr['crop_image_and_upload']; }else{ echo $rzvy_defaultlang['crop_image_and_upload']; } ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">X</span>
					</button>
				</div>
				<div class="modal-body mx-auto col-lg-11">
					<div class="row">
							<input type="hidden" id="rzvy_image_section" value="add" />
							<img src="" id="rzvy_cropped_image_preview" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="rzvy_crop_btn" class="btn btn-primary"><?php if(isset($rzvy_translangArr['crop'])){ echo $rzvy_translangArr['crop']; }else{ echo $rzvy_defaultlang['crop']; } ?></button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php if(isset($rzvy_translangArr['cancel'])){ echo $rzvy_translangArr['cancel']; }else{ echo $rzvy_defaultlang['cancel']; } ?></button>
				</div>
			</div>
		</div>
	</div>

	
	<!-- Bootstrap core JavaScript-->
    <script src='<?php echo SITE_URL; ?>includes/vendor/calendar/moment.min.js?<?php echo time(); ?>'></script>
	<script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery.min.js?<?php echo time(); ?>"></script>
    <script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery.validate.min.js?<?php echo time(); ?>"></script>
	<script src='<?php echo SITE_URL; ?>includes/vendor/calendar/fullcalendar.min.js?<?php echo time(); ?>'></script>
	<script src='<?php echo SITE_URL; ?>includes/vendor/calendar/locale-all.js?<?php echo time(); ?>'></script>
    <script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/bootstrap.bundle.min.js?<?php echo time(); ?>"></script>
    <script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/bootstrap-select.min.js?<?php echo time(); ?>"></script>
    <script src="<?php echo SITE_URL; ?>includes/vendor/sweetalert/sweetalert.js?<?php echo time(); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo SITE_URL; ?>includes/vendor/jquery-easing/jquery.easing.min.js?<?php echo time(); ?>"></script>
    <!-- Page level plugin JavaScript-->
    <script src="<?php echo SITE_URL; ?>includes/vendor/datatables/datatables.min.js?<?php echo time(); ?>"></script>
    <!-- Custom scripts for all pages-->
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'apptlist.php') != false) { ?>
    <script src="<?php echo SITE_URL; ?>includes/vendor/datatables/datatable.responsive.min.js?<?php echo time(); ?>"></script>
    <script src="<?php echo SITE_URL; ?>includes/vendor/datatables/dataTables.buttons.min.js?<?php echo time(); ?>"></script>
    <script src="<?php echo SITE_URL; ?>includes/vendor/datatables/buttons.print.min.js?<?php echo time(); ?>"></script>
    <?php } ?>
	 <!-- Image Cropper JavaScript-->
    <script src="<?php echo SITE_URL; ?>includes/js/cropper.js?<?php echo time(); ?>"></script>
	
	<script> 
		var show_dropdown_languages = [<?php 
			$show_dropdown = $obj_settings->get_option("rzvy_rzvy_show_dropdown_languages");
			if($show_dropdown != ""){
				$lang_exploded = explode(",", $show_dropdown);
				$i=1;
				foreach($lang_exploded as $lng){
					if($i == 1){
						echo "'".$lng."'"; 
					}else{
						echo ", '".$lng."'"; 
					}
					$i++;
				}
			}
			?>]; 
		var generalObj = { 'site_url' : '<?php echo SITE_URL; ?>', 'ajax_url' : '<?php echo AJAX_URL; ?>', 'current_date' : '<?php echo date('Y-m-d', $currDateTime_withTZ); ?>', 'setup_instruction_modal_status': '<?php echo $check_for_setup_instruction_modal; ?>', 'ty_link' : '<?php echo $obj_settings->get_option('rzvy_thankyou_page_url'); ?>', 'endslot_status' : '<?php echo $obj_settings->get_option('rzvy_endtimeslot_selection_status'); ?>', 'single_category_status' : '<?php echo $obj_settings->get_option('rzvy_single_category_autotrigger_status'); ?>', 'single_service_status' : '<?php echo $obj_settings->get_option('rzvy_single_service_autotrigger_status'); ?>', 'defaultCountryCode' : '<?php $rzvy_default_country_code = $obj_settings->get_option("rzvy_default_country_code"); if($rzvy_default_country_code != ""){ echo $rzvy_default_country_code; }else{ echo "us"; } ?>', 'book_with_datetime' : '<?php echo $rzvy_book_with_datetime; ?>', 'rzvy_image_type' : '<?php echo $obj_settings->get_option("rzvy_image_type"); ?>', 'rzvy_croping_type' : '<?php echo $obj_settings->get_option("rzvy_croping_type"); ?>',
		
		'reschedule_reason_ad' : '<?php if(isset($rzvy_translangArr['reschedule_reason_ad'])){ echo $rzvy_translangArr['reschedule_reason_ad']; }else{ echo $rzvy_defaultlang['reschedule_reason_ad']; } ?>',
		'enter_reschedule_reason' : '<?php if(isset($rzvy_translangArr['enter_reschedule_reason'])){ echo $rzvy_translangArr['enter_reschedule_reason']; }else{ echo $rzvy_defaultlang['enter_reschedule_reason']; } ?>',
		'rescheduled' : '<?php if(isset($rzvy_translangArr['rescheduled'])){ echo $rzvy_translangArr['rescheduled']; }else{ echo $rzvy_defaultlang['rescheduled']; } ?>',
		'appointment_rescheduled_successfully' : '<?php if(isset($rzvy_translangArr['appointment_rescheduled_successfully'])){ echo $rzvy_translangArr['appointment_rescheduled_successfully']; }else{ echo $rzvy_defaultlang['appointment_rescheduled_successfully']; } ?>',
		'opps' : '<?php if(isset($rzvy_translangArr['opps'])){ echo $rzvy_translangArr['opps']; }else{ echo $rzvy_defaultlang['opps']; } ?>',
		'something_went_wrong_please_try_again' : '<?php if(isset($rzvy_translangArr['something_went_wrong_please_try_again'])){ echo $rzvy_translangArr['something_went_wrong_please_try_again']; }else{ echo $rzvy_defaultlang['something_went_wrong_please_try_again']; } ?>',
		'you_can_not_book_on_previous_date' : '<?php if(isset($rzvy_translangArr['you_can_not_book_on_previous_date'])){ echo $rzvy_translangArr['you_can_not_book_on_previous_date']; }else{ echo $rzvy_defaultlang['you_can_not_book_on_previous_date']; } ?>',
		'please_enter_only_alphabets' : '<?php if(isset($rzvy_translangArr['please_enter_only_alphabets'])){ echo $rzvy_translangArr['please_enter_only_alphabets']; }else{ echo $rzvy_defaultlang['please_enter_only_alphabets']; } ?>',
		'please_enter_only_numerics' : '<?php if(isset($rzvy_translangArr['please_enter_only_numerics'])){ echo $rzvy_translangArr['please_enter_only_numerics']; }else{ echo $rzvy_defaultlang['please_enter_only_numerics']; } ?>',
		'please_enter_valid_phone_number_without_country_code' : '<?php if(isset($rzvy_translangArr['please_enter_valid_phone_number_without_country_code'])){ echo $rzvy_translangArr['please_enter_valid_phone_number_without_country_code']; }else{ echo $rzvy_defaultlang['please_enter_valid_phone_number_without_country_code']; } ?>',
		'please_enter_valid_zip' : '<?php if(isset($rzvy_translangArr['please_enter_valid_zip'])){ echo $rzvy_translangArr['please_enter_valid_zip']; }else{ echo $rzvy_defaultlang['please_enter_valid_zip']; } ?>',
		'write_something' : '<?php if(isset($rzvy_translangArr['write_something'])){ echo $rzvy_translangArr['write_something']; }else{ echo $rzvy_defaultlang['write_something']; } ?>',
		'please_enter_coupon_code' : '<?php if(isset($rzvy_translangArr['please_enter_coupon_code'])){ echo $rzvy_translangArr['please_enter_coupon_code']; }else{ echo $rzvy_defaultlang['please_enter_coupon_code']; } ?>',
		'please_select_coupon_type' : '<?php if(isset($rzvy_translangArr['please_select_coupon_type'])){ echo $rzvy_translangArr['please_select_coupon_type']; }else{ echo $rzvy_defaultlang['please_select_coupon_type']; } ?>',
		'please_enter_coupon_value' : '<?php if(isset($rzvy_translangArr['please_enter_coupon_value'])){ echo $rzvy_translangArr['please_enter_coupon_value']; }else{ echo $rzvy_defaultlang['please_enter_coupon_value']; } ?>',
		'please_enter_coupon_expiry' : '<?php if(isset($rzvy_translangArr['please_enter_coupon_expiry'])){ echo $rzvy_translangArr['please_enter_coupon_expiry']; }else{ echo $rzvy_defaultlang['please_enter_coupon_expiry']; } ?>',
		'please_enter_frequently_discount_label' : '<?php if(isset($rzvy_translangArr['please_enter_frequently_discount_label'])){ echo $rzvy_translangArr['please_enter_frequently_discount_label']; }else{ echo $rzvy_defaultlang['please_enter_frequently_discount_label']; } ?>',
		'please_select_frequently_discount_type' : '<?php if(isset($rzvy_translangArr['please_select_frequently_discount_type'])){ echo $rzvy_translangArr['please_select_frequently_discount_type']; }else{ echo $rzvy_defaultlang['please_select_frequently_discount_type']; } ?>',
		'please_enter_frequently_discount_value' : '<?php if(isset($rzvy_translangArr['please_enter_frequently_discount_value'])){ echo $rzvy_translangArr['please_enter_frequently_discount_value']; }else{ echo $rzvy_defaultlang['please_enter_frequently_discount_value']; } ?>',
		'please_enter_frequently_discount_description' : '<?php if(isset($rzvy_translangArr['please_enter_frequently_discount_description'])){ echo $rzvy_translangArr['please_enter_frequently_discount_description']; }else{ echo $rzvy_defaultlang['please_enter_frequently_discount_description']; } ?>',
		'please_enter_category_name' : '<?php if(isset($rzvy_translangArr['please_enter_category_name'])){ echo $rzvy_translangArr['please_enter_category_name']; }else{ echo $rzvy_defaultlang['please_enter_category_name']; } ?>',
		'please_enter_service_title' : '<?php if(isset($rzvy_translangArr['please_enter_service_title'])){ echo $rzvy_translangArr['please_enter_service_title']; }else{ echo $rzvy_defaultlang['please_enter_service_title']; } ?>',
		'please_enter_service_duration' : '<?php if(isset($rzvy_translangArr['please_enter_service_duration'])){ echo $rzvy_translangArr['please_enter_service_duration']; }else{ echo $rzvy_defaultlang['please_enter_service_duration']; } ?>',
		'enter_only_numerics' : '<?php if(isset($rzvy_translangArr['enter_only_numerics'])){ echo $rzvy_translangArr['enter_only_numerics']; }else{ echo $rzvy_defaultlang['enter_only_numerics']; } ?>',
		'please_enter_a_value_greater_than_or_equal_to_1' : '<?php if(isset($rzvy_translangArr['please_enter_a_value_greater_than_or_equal_to_1'])){ echo $rzvy_translangArr['please_enter_a_value_greater_than_or_equal_to_1']; }else{ echo $rzvy_defaultlang['please_enter_a_value_greater_than_or_equal_to_1']; } ?>',
		'please_enter_a_value_less_than_or_equal_to_1440' : '<?php if(isset($rzvy_translangArr['please_enter_a_value_less_than_or_equal_to_1440'])){ echo $rzvy_translangArr['please_enter_a_value_less_than_or_equal_to_1440']; }else{ echo $rzvy_defaultlang['please_enter_a_value_less_than_or_equal_to_1440']; } ?>',
		'please_enter_service_padding_before' : '<?php if(isset($rzvy_translangArr['please_enter_service_padding_before'])){ echo $rzvy_translangArr['please_enter_service_padding_before']; }else{ echo $rzvy_defaultlang['please_enter_service_padding_before']; } ?>',
		'please_enter_a_value_greater_than_or_equal_to_0' : '<?php if(isset($rzvy_translangArr['please_enter_a_value_greater_than_or_equal_to_0'])){ echo $rzvy_translangArr['please_enter_a_value_greater_than_or_equal_to_0']; }else{ echo $rzvy_defaultlang['please_enter_a_value_greater_than_or_equal_to_0']; } ?>',
		'please_enter_service_padding_after' : '<?php if(isset($rzvy_translangArr['please_enter_service_padding_after'])){ echo $rzvy_translangArr['please_enter_service_padding_after']; }else{ echo $rzvy_defaultlang['please_enter_service_padding_after']; } ?>',
		'please_enter_service_description' : '<?php if(isset($rzvy_translangArr['please_enter_service_description'])){ echo $rzvy_translangArr['please_enter_service_description']; }else{ echo $rzvy_defaultlang['please_enter_service_description']; } ?>',
		'please_enter_addon_name' : '<?php if(isset($rzvy_translangArr['please_enter_addon_name'])){ echo $rzvy_translangArr['please_enter_addon_name']; }else{ echo $rzvy_defaultlang['please_enter_addon_name']; } ?>',
		'please_enter_addon_rate' : '<?php if(isset($rzvy_translangArr['please_enter_addon_rate'])){ echo $rzvy_translangArr['please_enter_addon_rate']; }else{ echo $rzvy_defaultlang['please_enter_addon_rate']; } ?>',
		'please_enter_addon_description' : '<?php if(isset($rzvy_translangArr['please_enter_addon_description'])){ echo $rzvy_translangArr['please_enter_addon_description']; }else{ echo $rzvy_defaultlang['please_enter_addon_description']; } ?>',
		'maximum_file_upload_size_1_mb' : '<?php if(isset($rzvy_translangArr['maximum_file_upload_size_1_mb'])){ echo $rzvy_translangArr['maximum_file_upload_size_1_mb']; }else{ echo $rzvy_defaultlang['maximum_file_upload_size_1_mb']; } ?>',
		'please_select_a_valid_image_file' : '<?php if(isset($rzvy_translangArr['please_select_a_valid_image_file'])){ echo $rzvy_translangArr['please_select_a_valid_image_file']; }else{ echo $rzvy_defaultlang['please_select_a_valid_image_file']; } ?>',
		'added' : '<?php if(isset($rzvy_translangArr['added'])){ echo $rzvy_translangArr['added']; }else{ echo $rzvy_defaultlang['added']; } ?>',
		'coupon_added_successfully' : '<?php if(isset($rzvy_translangArr['coupon_added_successfully'])){ echo $rzvy_translangArr['coupon_added_successfully']; }else{ echo $rzvy_defaultlang['coupon_added_successfully']; } ?>',
		'disabled' : '<?php if(isset($rzvy_translangArr['disabled'])){ echo $rzvy_translangArr['disabled']; }else{ echo $rzvy_defaultlang['disabled']; } ?>',
		'enabled' : '<?php if(isset($rzvy_translangArr['enabled'])){ echo $rzvy_translangArr['enabled']; }else{ echo $rzvy_defaultlang['enabled']; } ?>',
		'coupon_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['coupon_status_changed_successfully'])){ echo $rzvy_translangArr['coupon_status_changed_successfully']; }else{ echo $rzvy_defaultlang['coupon_status_changed_successfully']; } ?>',
		'are_you_sure' : '<?php if(isset($rzvy_translangArr['are_you_sure'])){ echo $rzvy_translangArr['are_you_sure']; }else{ echo $rzvy_defaultlang['are_you_sure']; } ?>',
		'you_want_to_delete_this_coupon' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_coupon'])){ echo $rzvy_translangArr['you_want_to_delete_this_coupon']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_coupon']; } ?>',
		'yes_delete_it' : '<?php if(isset($rzvy_translangArr['yes_delete_it'])){ echo $rzvy_translangArr['yes_delete_it']; }else{ echo $rzvy_defaultlang['yes_delete_it']; } ?>',
		'deleted' : '<?php if(isset($rzvy_translangArr['deleted'])){ echo $rzvy_translangArr['deleted']; }else{ echo $rzvy_defaultlang['deleted']; } ?>',
		'coupon_deleted_successfully' : '<?php if(isset($rzvy_translangArr['coupon_deleted_successfully'])){ echo $rzvy_translangArr['coupon_deleted_successfully']; }else{ echo $rzvy_defaultlang['coupon_deleted_successfully']; } ?>',
		'updated' : '<?php if(isset($rzvy_translangArr['updated'])){ echo $rzvy_translangArr['updated']; }else{ echo $rzvy_defaultlang['updated']; } ?>',
		'coupon_updated_successfully' : '<?php if(isset($rzvy_translangArr['coupon_updated_successfully'])){ echo $rzvy_translangArr['coupon_updated_successfully']; }else{ echo $rzvy_defaultlang['coupon_updated_successfully']; } ?>',
		'frequently_discount_updated_successfully' : '<?php if(isset($rzvy_translangArr['frequently_discount_updated_successfully'])){ echo $rzvy_translangArr['frequently_discount_updated_successfully']; }else{ echo $rzvy_defaultlang['frequently_discount_updated_successfully']; } ?>',
		'frequently_discount_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['frequently_discount_status_changed_successfully'])){ echo $rzvy_translangArr['frequently_discount_status_changed_successfully']; }else{ echo $rzvy_defaultlang['frequently_discount_status_changed_successfully']; } ?>',
		'marked_as_offday' : '<?php if(isset($rzvy_translangArr['marked_as_offday'])){ echo $rzvy_translangArr['marked_as_offday']; }else{ echo $rzvy_defaultlang['marked_as_offday']; } ?>',
		'marked_as_working_day' : '<?php if(isset($rzvy_translangArr['marked_as_working_day'])){ echo $rzvy_translangArr['marked_as_working_day']; }else{ echo $rzvy_defaultlang['marked_as_working_day']; } ?>',
		'successfully' : '<?php if(isset($rzvy_translangArr['successfully'])){ echo $rzvy_translangArr['successfully']; }else{ echo $rzvy_defaultlang['successfully']; } ?>',
		'schedule_start_time_updated_successfully' : '<?php if(isset($rzvy_translangArr['schedule_start_time_updated_successfully'])){ echo $rzvy_translangArr['schedule_start_time_updated_successfully']; }else{ echo $rzvy_defaultlang['schedule_start_time_updated_successfully']; } ?>',
		'please_select_start_time_less_than_end_time' : '<?php if(isset($rzvy_translangArr['please_select_start_time_less_than_end_time'])){ echo $rzvy_translangArr['please_select_start_time_less_than_end_time']; }else{ echo $rzvy_defaultlang['please_select_start_time_less_than_end_time']; } ?>',
		'schedule_end_time_updated_successfully' : '<?php if(isset($rzvy_translangArr['schedule_end_time_updated_successfully'])){ echo $rzvy_translangArr['schedule_end_time_updated_successfully']; }else{ echo $rzvy_defaultlang['schedule_end_time_updated_successfully']; } ?>',
		'please_select_end_time_greater_than_start_time' : '<?php if(isset($rzvy_translangArr['please_select_end_time_greater_than_start_time'])){ echo $rzvy_translangArr['please_select_end_time_greater_than_start_time']; }else{ echo $rzvy_defaultlang['please_select_end_time_greater_than_start_time']; } ?>',
		'you_want_to_delete_this_appointment' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_appointment'])){ echo $rzvy_translangArr['you_want_to_delete_this_appointment']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_appointment']; } ?>',
		'appointment_deleted_successfully' : '<?php if(isset($rzvy_translangArr['appointment_deleted_successfully'])){ echo $rzvy_translangArr['appointment_deleted_successfully']; }else{ echo $rzvy_defaultlang['appointment_deleted_successfully']; } ?>',
		'you_want_to_confirm_this_appointment' : '<?php if(isset($rzvy_translangArr['you_want_to_confirm_this_appointment'])){ echo $rzvy_translangArr['you_want_to_confirm_this_appointment']; }else{ echo $rzvy_defaultlang['you_want_to_confirm_this_appointment']; } ?>',
		'yes_confirm_it' : '<?php if(isset($rzvy_translangArr['yes_confirm_it'])){ echo $rzvy_translangArr['yes_confirm_it']; }else{ echo $rzvy_defaultlang['yes_confirm_it']; } ?>',
		'confirmed' : '<?php if(isset($rzvy_translangArr['confirmed'])){ echo $rzvy_translangArr['confirmed']; }else{ echo $rzvy_defaultlang['confirmed']; } ?>',
		'appointment_confirmed_successfully' : '<?php if(isset($rzvy_translangArr['appointment_confirmed_successfully'])){ echo $rzvy_translangArr['appointment_confirmed_successfully']; }else{ echo $rzvy_defaultlang['appointment_confirmed_successfully']; } ?>',
		'you_want_to_mark_this_appointment_as_pending' : '<?php if(isset($rzvy_translangArr['you_want_to_mark_this_appointment_as_pending'])){ echo $rzvy_translangArr['you_want_to_mark_this_appointment_as_pending']; }else{ echo $rzvy_defaultlang['you_want_to_mark_this_appointment_as_pending']; } ?>',
		'yes_mark_as_pending' : '<?php if(isset($rzvy_translangArr['yes_mark_as_pending'])){ echo $rzvy_translangArr['yes_mark_as_pending']; }else{ echo $rzvy_defaultlang['yes_mark_as_pending']; } ?>',
		'marked_as_pending' : '<?php if(isset($rzvy_translangArr['marked_as_pending'])){ echo $rzvy_translangArr['marked_as_pending']; }else{ echo $rzvy_defaultlang['marked_as_pending']; } ?>',
		'appointment_marked_as_pending_successfully' : '<?php if(isset($rzvy_translangArr['appointment_marked_as_pending_successfully'])){ echo $rzvy_translangArr['appointment_marked_as_pending_successfully']; }else{ echo $rzvy_defaultlang['appointment_marked_as_pending_successfully']; } ?>',
		'you_want_to_mark_this_appointment_as_complete' : '<?php if(isset($rzvy_translangArr['you_want_to_mark_this_appointment_as_complete'])){ echo $rzvy_translangArr['you_want_to_mark_this_appointment_as_complete']; }else{ echo $rzvy_defaultlang['you_want_to_mark_this_appointment_as_complete']; } ?>',
		'yes_mark_as_completed' : '<?php if(isset($rzvy_translangArr['yes_mark_as_completed'])){ echo $rzvy_translangArr['yes_mark_as_completed']; }else{ echo $rzvy_defaultlang['yes_mark_as_completed']; } ?>',
		'marked_as_completed' : '<?php if(isset($rzvy_translangArr['marked_as_completed'])){ echo $rzvy_translangArr['marked_as_completed']; }else{ echo $rzvy_defaultlang['marked_as_completed']; } ?>',
		'appointment_marked_as_completed_successfully' : '<?php if(isset($rzvy_translangArr['appointment_marked_as_completed_successfully'])){ echo $rzvy_translangArr['appointment_marked_as_completed_successfully']; }else{ echo $rzvy_defaultlang['appointment_marked_as_completed_successfully']; } ?>',
		'refund_process_has_been_transferred' : '<?php if(isset($rzvy_translangArr['refund_process_has_been_transferred'])){ echo $rzvy_translangArr['refund_process_has_been_transferred']; }else{ echo $rzvy_defaultlang['refund_process_has_been_transferred']; } ?>',
		'yes_refunded' : '<?php if(isset($rzvy_translangArr['yes_refunded'])){ echo $rzvy_translangArr['yes_refunded']; }else{ echo $rzvy_defaultlang['yes_refunded']; } ?>',
		'cancel' : '<?php if(isset($rzvy_translangArr['cancel'])){ echo $rzvy_translangArr['cancel']; }else{ echo $rzvy_defaultlang['cancel']; } ?>',
		'not_now' : '<?php if(isset($rzvy_translangArr['not_now'])){ echo $rzvy_translangArr['not_now']; }else{ echo $rzvy_defaultlang['not_now']; } ?>',
		'refunded' : '<?php if(isset($rzvy_translangArr['refunded'])){ echo $rzvy_translangArr['refunded']; }else{ echo $rzvy_defaultlang['refunded']; } ?>',
		'refund_request_processed_successfully' : '<?php if(isset($rzvy_translangArr['refund_request_processed_successfully'])){ echo $rzvy_translangArr['refund_request_processed_successfully']; }else{ echo $rzvy_defaultlang['refund_request_processed_successfully']; } ?>',
		'you_want_to_cancel_refund_request' : '<?php if(isset($rzvy_translangArr['you_want_to_cancel_refund_request'])){ echo $rzvy_translangArr['you_want_to_cancel_refund_request']; }else{ echo $rzvy_defaultlang['you_want_to_cancel_refund_request']; } ?>',
		'yes_cancel_it' : '<?php if(isset($rzvy_translangArr['yes_cancel_it'])){ echo $rzvy_translangArr['yes_cancel_it']; }else{ echo $rzvy_defaultlang['yes_cancel_it']; } ?>',
		'cancelled' : '<?php if(isset($rzvy_translangArr['cancelled'])){ echo $rzvy_translangArr['cancelled']; }else{ echo $rzvy_defaultlang['cancelled']; } ?>',
		'refund_request_cancelled_successfully' : '<?php if(isset($rzvy_translangArr['refund_request_cancelled_successfully'])){ echo $rzvy_translangArr['refund_request_cancelled_successfully']; }else{ echo $rzvy_defaultlang['refund_request_cancelled_successfully']; } ?>',
		'rejected' : '<?php if(isset($rzvy_translangArr['rejected'])){ echo $rzvy_translangArr['rejected']; }else{ echo $rzvy_defaultlang['rejected']; } ?>',
		'appointment_rejected_successfully' : '<?php if(isset($rzvy_translangArr['appointment_rejected_successfully'])){ echo $rzvy_translangArr['appointment_rejected_successfully']; }else{ echo $rzvy_defaultlang['appointment_rejected_successfully']; } ?>',
		'please_enter_old_password' : '<?php if(isset($rzvy_translangArr['please_enter_old_password'])){ echo $rzvy_translangArr['please_enter_old_password']; }else{ echo $rzvy_defaultlang['please_enter_old_password']; } ?>',
		'please_enter_minimum_8_characters' : '<?php if(isset($rzvy_translangArr['please_enter_minimum_8_characters'])){ echo $rzvy_translangArr['please_enter_minimum_8_characters']; }else{ echo $rzvy_defaultlang['please_enter_minimum_8_characters']; } ?>',
		'please_enter_maximum_20_characters' : '<?php if(isset($rzvy_translangArr['please_enter_maximum_20_characters'])){ echo $rzvy_translangArr['please_enter_maximum_20_characters']; }else{ echo $rzvy_defaultlang['please_enter_maximum_20_characters']; } ?>',
		'new_password_and_retype_new_password_mismatch' : '<?php if(isset($rzvy_translangArr['new_password_and_retype_new_password_mismatch'])){ echo $rzvy_translangArr['new_password_and_retype_new_password_mismatch']; }else{ echo $rzvy_defaultlang['new_password_and_retype_new_password_mismatch']; } ?>',
		'please_enter_retype_new_password' : '<?php if(isset($rzvy_translangArr['please_enter_retype_new_password'])){ echo $rzvy_translangArr['please_enter_retype_new_password']; }else{ echo $rzvy_defaultlang['please_enter_retype_new_password']; } ?>',
		'please_enter_new_password' : '<?php if(isset($rzvy_translangArr['please_enter_new_password'])){ echo $rzvy_translangArr['please_enter_new_password']; }else{ echo $rzvy_defaultlang['please_enter_new_password']; } ?>',
		'changed' : '<?php if(isset($rzvy_translangArr['changed'])){ echo $rzvy_translangArr['changed']; }else{ echo $rzvy_defaultlang['changed']; } ?>',
		'your_password_changed_successfully' : '<?php if(isset($rzvy_translangArr['your_password_changed_successfully'])){ echo $rzvy_translangArr['your_password_changed_successfully']; }else{ echo $rzvy_defaultlang['your_password_changed_successfully']; } ?>',
		'incorrect_old_password' : '<?php if(isset($rzvy_translangArr['incorrect_old_password'])){ echo $rzvy_translangArr['incorrect_old_password']; }else{ echo $rzvy_defaultlang['incorrect_old_password']; } ?>',
		'please_select_atleast_any_of_one_option_to_export' : '<?php if(isset($rzvy_translangArr['please_select_atleast_any_of_one_option_to_export'])){ echo $rzvy_translangArr['please_select_atleast_any_of_one_option_to_export']; }else{ echo $rzvy_defaultlang['please_select_atleast_any_of_one_option_to_export']; } ?>',
		'please_select_addon' : '<?php if(isset($rzvy_translangArr['please_select_addon'])){ echo $rzvy_translangArr['please_select_addon']; }else{ echo $rzvy_defaultlang['please_select_addon']; } ?>',
		'please_select_service' : '<?php if(isset($rzvy_translangArr['please_select_service'])){ echo $rzvy_translangArr['please_select_service']; }else{ echo $rzvy_defaultlang['please_select_service']; } ?>',
		'please_select_category' : '<?php if(isset($rzvy_translangArr['please_select_category'])){ echo $rzvy_translangArr['please_select_category']; }else{ echo $rzvy_defaultlang['please_select_category']; } ?>',
		'please_select_from_date' : '<?php if(isset($rzvy_translangArr['please_select_from_date'])){ echo $rzvy_translangArr['please_select_from_date']; }else{ echo $rzvy_defaultlang['please_select_from_date']; } ?>',
		'please_select_to_date' : '<?php if(isset($rzvy_translangArr['please_select_to_date'])){ echo $rzvy_translangArr['please_select_to_date']; }else{ echo $rzvy_defaultlang['please_select_to_date']; } ?>',
		"please_enter_first_name" : "<?php if(isset($rzvy_translangArr['please_enter_first_name'])){ echo $rzvy_translangArr['please_enter_first_name']; }else{ echo $rzvy_defaultlang['please_enter_first_name']; } ?>",
		"please_enter_maximum_50_characters" : "<?php if(isset($rzvy_translangArr['please_enter_maximum_50_characters'])){ echo $rzvy_translangArr['please_enter_maximum_50_characters']; }else{ echo $rzvy_defaultlang['please_enter_maximum_50_characters']; } ?>",
		"please_enter_last_name" : "<?php if(isset($rzvy_translangArr['please_enter_last_name'])){ echo $rzvy_translangArr['please_enter_last_name']; }else{ echo $rzvy_defaultlang['please_enter_last_name']; } ?>",
		"please_enter_phone_number" : "<?php if(isset($rzvy_translangArr['please_enter_phone_number'])){ echo $rzvy_translangArr['please_enter_phone_number']; }else{ echo $rzvy_defaultlang['please_enter_phone_number']; } ?>",
		"please_enter_minimum_10_digits" : "<?php if(isset($rzvy_translangArr['please_enter_minimum_10_digits'])){ echo $rzvy_translangArr['please_enter_minimum_10_digits']; }else{ echo $rzvy_defaultlang['please_enter_minimum_10_digits']; } ?>",
		"please_enter_maximum_15_digits" : "<?php if(isset($rzvy_translangArr['please_enter_maximum_15_digits'])){ echo $rzvy_translangArr['please_enter_maximum_15_digits']; }else{ echo $rzvy_defaultlang['please_enter_maximum_15_digits']; } ?>",
		"please_enter_address" : "<?php if(isset($rzvy_translangArr['please_enter_address'])){ echo $rzvy_translangArr['please_enter_address']; }else{ echo $rzvy_defaultlang['please_enter_address']; } ?>",
		"please_enter_city" : "<?php if(isset($rzvy_translangArr['please_enter_city'])){ echo $rzvy_translangArr['please_enter_city']; }else{ echo $rzvy_defaultlang['please_enter_city']; } ?>",
		"please_enter_state" : "<?php if(isset($rzvy_translangArr['please_enter_state'])){ echo $rzvy_translangArr['please_enter_state']; }else{ echo $rzvy_defaultlang['please_enter_state']; } ?>",
		"please_enter_zip" : "<?php if(isset($rzvy_translangArr['please_enter_zip'])){ echo $rzvy_translangArr['please_enter_zip']; }else{ echo $rzvy_defaultlang['please_enter_zip']; } ?>",
		"please_enter_minimum_5_characters" : "<?php if(isset($rzvy_translangArr['please_enter_minimum_5_characters'])){ echo $rzvy_translangArr['please_enter_minimum_5_characters']; }else{ echo $rzvy_defaultlang['please_enter_minimum_5_characters']; } ?>",
		"please_enter_maximum_10_characters" : "<?php if(isset($rzvy_translangArr['please_enter_maximum_10_characters'])){ echo $rzvy_translangArr['please_enter_maximum_10_characters']; }else{ echo $rzvy_defaultlang['please_enter_maximum_10_characters']; } ?>",
		"please_enter_country" : "<?php if(isset($rzvy_translangArr['please_enter_country'])){ echo $rzvy_translangArr['please_enter_country']; }else{ echo $rzvy_defaultlang['please_enter_country']; } ?>",
		"please_enter_email_address" : "<?php if(isset($rzvy_translangArr['please_enter_email_address'])){ echo $rzvy_translangArr['please_enter_email_address']; }else{ echo $rzvy_defaultlang['please_enter_email_address']; } ?>",
		"please_enter_valid_email_address" : "<?php if(isset($rzvy_translangArr['please_enter_valid_email_address'])){ echo $rzvy_translangArr['please_enter_valid_email_address']; }else{ echo $rzvy_defaultlang['please_enter_valid_email_address']; } ?>",
		'your_profile_updated_successfully' : '<?php if(isset($rzvy_translangArr['your_profile_updated_successfully'])){ echo $rzvy_translangArr['your_profile_updated_successfully']; }else{ echo $rzvy_defaultlang['your_profile_updated_successfully']; } ?>',
		'your_email_changed_successfully' : '<?php if(isset($rzvy_translangArr['your_email_changed_successfully'])){ echo $rzvy_translangArr['your_email_changed_successfully']; }else{ echo $rzvy_defaultlang['your_email_changed_successfully']; } ?>',
		'exist' : '<?php if(isset($rzvy_translangArr['exist'])){ echo $rzvy_translangArr['exist']; }else{ echo $rzvy_defaultlang['exist']; } ?>',
		'email_already_exist_please_try_to_update_with_not_registered_email' : '<?php if(isset($rzvy_translangArr['email_already_exist_please_try_to_update_with_not_registered_email'])){ echo $rzvy_translangArr['email_already_exist_please_try_to_update_with_not_registered_email']; }else{ echo $rzvy_defaultlang['email_already_exist_please_try_to_update_with_not_registered_email']; } ?>',
		'language_deleted_successfully' : '<?php if(isset($rzvy_translangArr['language_deleted_successfully'])){ echo $rzvy_translangArr['language_deleted_successfully']; }else{ echo $rzvy_defaultlang['language_deleted_successfully']; } ?>',
		'you_want_to_delete_this_language' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_language'])){ echo $rzvy_translangArr['you_want_to_delete_this_language']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_language']; } ?>',
		'please_select_language_for_translation' : '<?php if(isset($rzvy_translangArr['please_select_language_for_translation'])){ echo $rzvy_translangArr['please_select_language_for_translation']; }else{ echo $rzvy_defaultlang['please_select_language_for_translation']; } ?>',
		'translated' : '<?php if(isset($rzvy_translangArr['translated'])){ echo $rzvy_translangArr['translated']; }else{ echo $rzvy_defaultlang['translated']; } ?>',
		'language_translation_saved_successfully' : '<?php if(isset($rzvy_translangArr['language_translation_saved_successfully'])){ echo $rzvy_translangArr['language_translation_saved_successfully']; }else{ echo $rzvy_defaultlang['language_translation_saved_successfully']; } ?>',
		'form_field_optional_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['form_field_optional_status_changed_successfully'])){ echo $rzvy_translangArr['form_field_optional_status_changed_successfully']; }else{ echo $rzvy_defaultlang['form_field_optional_status_changed_successfully']; } ?>',
		'please_enable_status' : '<?php if(isset($rzvy_translangArr['please_enable_status'])){ echo $rzvy_translangArr['please_enable_status']; }else{ echo $rzvy_defaultlang['please_enable_status']; } ?>',
		'form_field_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['form_field_status_changed_successfully'])){ echo $rzvy_translangArr['form_field_status_changed_successfully']; }else{ echo $rzvy_defaultlang['form_field_status_changed_successfully']; } ?>',
		'welcome_message_updated_successfully' : '<?php if(isset($rzvy_translangArr['welcome_message_updated_successfully'])){ echo $rzvy_translangArr['welcome_message_updated_successfully']; }else{ echo $rzvy_defaultlang['welcome_message_updated_successfully']; } ?>',
		'please_upload_background_image' : '<?php if(isset($rzvy_translangArr['please_upload_background_image'])){ echo $rzvy_translangArr['please_upload_background_image']; }else{ echo $rzvy_defaultlang['please_upload_background_image']; } ?>',
		'booking_form_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['booking_form_settings_updated_successfully'])){ echo $rzvy_translangArr['booking_form_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['booking_form_settings_updated_successfully']; } ?>',
		'service_schedule_updated_successfully' : '<?php if(isset($rzvy_translangArr['service_schedule_updated_successfully'])){ echo $rzvy_translangArr['service_schedule_updated_successfully']; }else{ echo $rzvy_defaultlang['service_schedule_updated_successfully']; } ?>',
		'customized' : '<?php if(isset($rzvy_translangArr['customized'])){ echo $rzvy_translangArr['customized']; }else{ echo $rzvy_defaultlang['customized']; } ?>',
		'sms_template_customized_successfully' : '<?php if(isset($rzvy_translangArr['sms_template_customized_successfully'])){ echo $rzvy_translangArr['sms_template_customized_successfully']; }else{ echo $rzvy_defaultlang['sms_template_customized_successfully']; } ?>',
		'email_template_customized_successfully' : '<?php if(isset($rzvy_translangArr['email_template_customized_successfully'])){ echo $rzvy_translangArr['email_template_customized_successfully']; }else{ echo $rzvy_defaultlang['email_template_customized_successfully']; } ?>',
		'block_off_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['block_off_status_changed_successfully'])){ echo $rzvy_translangArr['block_off_status_changed_successfully']; }else{ echo $rzvy_defaultlang['block_off_status_changed_successfully']; } ?>',
		'block_off_deleted_successfully' : '<?php if(isset($rzvy_translangArr['block_off_deleted_successfully'])){ echo $rzvy_translangArr['block_off_deleted_successfully']; }else{ echo $rzvy_defaultlang['block_off_deleted_successfully']; } ?>',
		'you_want_to_delete_this_block_off' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_block_off'])){ echo $rzvy_translangArr['you_want_to_delete_this_block_off']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_block_off']; } ?>',
		'block_off_updated_successfully' : '<?php if(isset($rzvy_translangArr['block_off_updated_successfully'])){ echo $rzvy_translangArr['block_off_updated_successfully']; }else{ echo $rzvy_defaultlang['block_off_updated_successfully']; } ?>',
		'please_select_from_time_less_than_to_time' : '<?php if(isset($rzvy_translangArr['please_select_from_time_less_than_to_time'])){ echo $rzvy_translangArr['please_select_from_time_less_than_to_time']; }else{ echo $rzvy_defaultlang['please_select_from_time_less_than_to_time']; } ?>',
		'please_select_from_date_less_than_to_date' : '<?php if(isset($rzvy_translangArr['please_select_from_date_less_than_to_date'])){ echo $rzvy_translangArr['please_select_from_date_less_than_to_date']; }else{ echo $rzvy_defaultlang['please_select_from_date_less_than_to_date']; } ?>',
		'please_enter_block_off_title' : '<?php if(isset($rzvy_translangArr['please_enter_block_off_title'])){ echo $rzvy_translangArr['please_enter_block_off_title']; }else{ echo $rzvy_defaultlang['please_enter_block_off_title']; } ?>',
		'please_select_proper_date' : '<?php if(isset($rzvy_translangArr['please_select_proper_date'])){ echo $rzvy_translangArr['please_select_proper_date']; }else{ echo $rzvy_defaultlang['please_select_proper_date']; } ?>',
		'please_select_block_off_type' : '<?php if(isset($rzvy_translangArr['please_select_block_off_type'])){ echo $rzvy_translangArr['please_select_block_off_type']; }else{ echo $rzvy_defaultlang['please_select_block_off_type']; } ?>',
		'please_select_from_time' : '<?php if(isset($rzvy_translangArr['please_select_from_time'])){ echo $rzvy_translangArr['please_select_from_time']; }else{ echo $rzvy_defaultlang['please_select_from_time']; } ?>',
		'please_select_to_time' : '<?php if(isset($rzvy_translangArr['please_select_to_time'])){ echo $rzvy_translangArr['please_select_to_time']; }else{ echo $rzvy_defaultlang['please_select_to_time']; } ?>',
		'block_off_added_successfully' : '<?php if(isset($rzvy_translangArr['block_off_added_successfully'])){ echo $rzvy_translangArr['block_off_added_successfully']; }else{ echo $rzvy_defaultlang['block_off_added_successfully']; } ?>',
		'please_select_status' : '<?php if(isset($rzvy_translangArr['please_select_status'])){ echo $rzvy_translangArr['please_select_status']; }else{ echo $rzvy_defaultlang['please_select_status']; } ?>',
		'you_want_to_mark_this_support_ticket_as_complete' : '<?php if(isset($rzvy_translangArr['you_want_to_mark_this_support_ticket_as_complete'])){ echo $rzvy_translangArr['you_want_to_mark_this_support_ticket_as_complete']; }else{ echo $rzvy_defaultlang['you_want_to_mark_this_support_ticket_as_complete']; } ?>',
		'support_ticket_marked_as_completed_successfully' : '<?php if(isset($rzvy_translangArr['support_ticket_marked_as_completed_successfully'])){ echo $rzvy_translangArr['support_ticket_marked_as_completed_successfully']; }else{ echo $rzvy_defaultlang['support_ticket_marked_as_completed_successfully']; } ?>',
		'you_cannot_delete_this_support_ticket_you_have_discussion_on_this_support_ticket' : '<?php if(isset($rzvy_translangArr['you_cannot_delete_this_support_ticket_you_have_discussion_on_this_support_ticket'])){ echo $rzvy_translangArr['you_cannot_delete_this_support_ticket_you_have_discussion_on_this_support_ticket']; }else{ echo $rzvy_defaultlang['you_cannot_delete_this_support_ticket_you_have_discussion_on_this_support_ticket']; } ?>',
		'support_ticket_added_successfully' : '<?php if(isset($rzvy_translangArr['support_ticket_added_successfully'])){ echo $rzvy_translangArr['support_ticket_added_successfully']; }else{ echo $rzvy_defaultlang['support_ticket_added_successfully']; } ?>',
		'you_want_to_delete_this_support_ticket' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_support_ticket'])){ echo $rzvy_translangArr['you_want_to_delete_this_support_ticket']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_support_ticket']; } ?>',
		'support_ticket_updated_successfully' : '<?php if(isset($rzvy_translangArr['support_ticket_updated_successfully'])){ echo $rzvy_translangArr['support_ticket_updated_successfully']; }else{ echo $rzvy_defaultlang['support_ticket_updated_successfully']; } ?>',
		'please_enter_ticket_title' : '<?php if(isset($rzvy_translangArr['please_enter_ticket_title'])){ echo $rzvy_translangArr['please_enter_ticket_title']; }else{ echo $rzvy_defaultlang['please_enter_ticket_title']; } ?>',
		'please_enter_ticket_description' : '<?php if(isset($rzvy_translangArr['please_enter_ticket_description'])){ echo $rzvy_translangArr['please_enter_ticket_description']; }else{ echo $rzvy_defaultlang['please_enter_ticket_description']; } ?>',
		'support_ticket_generated_successfully' : '<?php if(isset($rzvy_translangArr['support_ticket_generated_successfully'])){ echo $rzvy_translangArr['support_ticket_generated_successfully']; }else{ echo $rzvy_defaultlang['support_ticket_generated_successfully']; } ?>',
		'upgraded' : '<?php if(isset($rzvy_translangArr['upgraded'])){ echo $rzvy_translangArr['upgraded']; }else{ echo $rzvy_defaultlang['upgraded']; } ?>',
		'sms_plan_upgraded_successfully' : '<?php if(isset($rzvy_translangArr['sms_plan_upgraded_successfully'])){ echo $rzvy_translangArr['sms_plan_upgraded_successfully']; }else{ echo $rzvy_defaultlang['sms_plan_upgraded_successfully']; } ?>',
		'please_contact_super_admin_to_set_sms_plans' : '<?php if(isset($rzvy_translangArr['please_contact_super_admin_to_set_sms_plans'])){ echo $rzvy_translangArr['please_contact_super_admin_to_set_sms_plans']; }else{ echo $rzvy_defaultlang['please_contact_super_admin_to_set_sms_plans']; } ?>',
		'please_enter_card_holder_name' : '<?php if(isset($rzvy_translangArr['please_enter_card_holder_name'])){ echo $rzvy_translangArr['please_enter_card_holder_name']; }else{ echo $rzvy_defaultlang['please_enter_card_holder_name']; } ?>',
		'opps_your_cvv_is_not_valid' : '<?php if(isset($rzvy_translangArr['opps_your_cvv_is_not_valid'])){ echo $rzvy_translangArr['opps_your_cvv_is_not_valid']; }else{ echo $rzvy_defaultlang['opps_your_cvv_is_not_valid']; } ?>',
		'opps_your_card_expiry_is_not_valid' : '<?php if(isset($rzvy_translangArr['opps_your_card_expiry_is_not_valid'])){ echo $rzvy_translangArr['opps_your_card_expiry_is_not_valid']; }else{ echo $rzvy_defaultlang['opps_your_card_expiry_is_not_valid']; } ?>',
		'opps_your_card_number_is_not_valid' : '<?php if(isset($rzvy_translangArr['opps_your_card_number_is_not_valid'])){ echo $rzvy_translangArr['opps_your_card_number_is_not_valid']; }else{ echo $rzvy_defaultlang['opps_your_card_number_is_not_valid']; } ?>',
		'addon_updated_successfully' : '<?php if(isset($rzvy_translangArr['addon_updated_successfully'])){ echo $rzvy_translangArr['addon_updated_successfully']; }else{ echo $rzvy_defaultlang['addon_updated_successfully']; } ?>',
		'addon_added_successfully' : '<?php if(isset($rzvy_translangArr['addon_added_successfully'])){ echo $rzvy_translangArr['addon_added_successfully']; }else{ echo $rzvy_defaultlang['addon_added_successfully']; } ?>',
		'addon_multiple_qty_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['addon_multiple_qty_status_changed_successfully'])){ echo $rzvy_translangArr['addon_multiple_qty_status_changed_successfully']; }else{ echo $rzvy_defaultlang['addon_multiple_qty_status_changed_successfully']; } ?>',
		'addon_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['addon_status_changed_successfully'])){ echo $rzvy_translangArr['addon_status_changed_successfully']; }else{ echo $rzvy_defaultlang['addon_status_changed_successfully']; } ?>',
		'service_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['service_status_changed_successfully'])){ echo $rzvy_translangArr['service_status_changed_successfully']; }else{ echo $rzvy_defaultlang['service_status_changed_successfully']; } ?>',
		'addon_deleted_successfully' : '<?php if(isset($rzvy_translangArr['addon_deleted_successfully'])){ echo $rzvy_translangArr['addon_deleted_successfully']; }else{ echo $rzvy_defaultlang['addon_deleted_successfully']; } ?>',
		'you_cannot_delete_this_addon_you_have_appointment_with_this_addon' : '<?php if(isset($rzvy_translangArr['you_cannot_delete_this_addon_you_have_appointment_with_this_addon'])){ echo $rzvy_translangArr['you_cannot_delete_this_addon_you_have_appointment_with_this_addon']; }else{ echo $rzvy_defaultlang['you_cannot_delete_this_addon_you_have_appointment_with_this_addon']; } ?>',
		'you_want_to_delete_this_addon' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_addon'])){ echo $rzvy_translangArr['you_want_to_delete_this_addon']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_addon']; } ?>',
		'you_cannot_delete_this_service_you_have_appointment_with_this_service' : '<?php if(isset($rzvy_translangArr['you_cannot_delete_this_service_you_have_appointment_with_this_service'])){ echo $rzvy_translangArr['you_cannot_delete_this_service_you_have_appointment_with_this_service']; }else{ echo $rzvy_defaultlang['you_cannot_delete_this_service_you_have_appointment_with_this_service']; } ?>',
		'service_deleted_successfully' : '<?php if(isset($rzvy_translangArr['service_deleted_successfully'])){ echo $rzvy_translangArr['service_deleted_successfully']; }else{ echo $rzvy_defaultlang['service_deleted_successfully']; } ?>',
		'you_want_to_delete_this_service' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_service'])){ echo $rzvy_translangArr['you_want_to_delete_this_service']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_service']; } ?>',
		'service_updated_successfully' : '<?php if(isset($rzvy_translangArr['service_updated_successfully'])){ echo $rzvy_translangArr['service_updated_successfully']; }else{ echo $rzvy_defaultlang['service_updated_successfully']; } ?>',
		'service_added_successfully' : '<?php if(isset($rzvy_translangArr['service_added_successfully'])){ echo $rzvy_translangArr['service_added_successfully']; }else{ echo $rzvy_defaultlang['service_added_successfully']; } ?>',
		'category_updated_successfully' : '<?php if(isset($rzvy_translangArr['category_updated_successfully'])){ echo $rzvy_translangArr['category_updated_successfully']; }else{ echo $rzvy_defaultlang['category_updated_successfully']; } ?>',
		'category_added_successfully' : '<?php if(isset($rzvy_translangArr['category_added_successfully'])){ echo $rzvy_translangArr['category_added_successfully']; }else{ echo $rzvy_defaultlang['category_added_successfully']; } ?>',
		'you_cannot_delete_this_category_you_have_appointment_with_this_category' : '<?php if(isset($rzvy_translangArr['you_cannot_delete_this_category_you_have_appointment_with_this_category'])){ echo $rzvy_translangArr['you_cannot_delete_this_category_you_have_appointment_with_this_category']; }else{ echo $rzvy_defaultlang['you_cannot_delete_this_category_you_have_appointment_with_this_category']; } ?>',
		'category_deleted_successfully' : '<?php if(isset($rzvy_translangArr['category_deleted_successfully'])){ echo $rzvy_translangArr['category_deleted_successfully']; }else{ echo $rzvy_defaultlang['category_deleted_successfully']; } ?>',
		'you_want_to_delete_this_category' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_category'])){ echo $rzvy_translangArr['you_want_to_delete_this_category']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_category']; } ?>',
		'category_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['category_status_changed_successfully'])){ echo $rzvy_translangArr['category_status_changed_successfully']; }else{ echo $rzvy_defaultlang['category_status_changed_successfully']; } ?>',
		'twocheckout_payment_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['twocheckout_payment_settings_updated_successfully'])){ echo $rzvy_translangArr['twocheckout_payment_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['twocheckout_payment_settings_updated_successfully']; } ?>',
		'please_enter_seller_id' : '<?php if(isset($rzvy_translangArr['please_enter_seller_id'])){ echo $rzvy_translangArr['please_enter_seller_id']; }else{ echo $rzvy_defaultlang['please_enter_seller_id']; } ?>',
		'please_enter_private_key' : '<?php if(isset($rzvy_translangArr['please_enter_private_key'])){ echo $rzvy_translangArr['please_enter_private_key']; }else{ echo $rzvy_defaultlang['please_enter_private_key']; } ?>',
		'please_enter_publishable_key' : '<?php if(isset($rzvy_translangArr['please_enter_publishable_key'])){ echo $rzvy_translangArr['please_enter_publishable_key']; }else{ echo $rzvy_defaultlang['please_enter_publishable_key']; } ?>',
		'authorizenet_payment_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['authorizenet_payment_settings_updated_successfully'])){ echo $rzvy_translangArr['authorizenet_payment_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['authorizenet_payment_settings_updated_successfully']; } ?>',
		'please_enter_transaction_key' : '<?php if(isset($rzvy_translangArr['please_enter_transaction_key'])){ echo $rzvy_translangArr['please_enter_transaction_key']; }else{ echo $rzvy_defaultlang['please_enter_transaction_key']; } ?>',
		'please_enter_publishable_key' : '<?php if(isset($rzvy_translangArr['please_enter_publishable_key'])){ echo $rzvy_translangArr['please_enter_publishable_key']; }else{ echo $rzvy_defaultlang['please_enter_publishable_key']; } ?>',
		'please_enter_api_key' : '<?php if(isset($rzvy_translangArr['please_enter_api_key'])){ echo $rzvy_translangArr['please_enter_api_key']; }else{ echo $rzvy_defaultlang['please_enter_api_key']; } ?>',
		'please_enter_api_login_id' : '<?php if(isset($rzvy_translangArr['please_enter_api_login_id'])){ echo $rzvy_translangArr['please_enter_api_login_id']; }else{ echo $rzvy_defaultlang['please_enter_api_login_id']; } ?>',
		'stripe_payment_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['stripe_payment_settings_updated_successfully'])){ echo $rzvy_translangArr['stripe_payment_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['stripe_payment_settings_updated_successfully']; } ?>',
		'please_enter_secret_key' : '<?php if(isset($rzvy_translangArr['please_enter_secret_key'])){ echo $rzvy_translangArr['please_enter_secret_key']; }else{ echo $rzvy_defaultlang['please_enter_secret_key']; } ?>',
		'paypal_payment_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['paypal_payment_settings_updated_successfully'])){ echo $rzvy_translangArr['paypal_payment_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['paypal_payment_settings_updated_successfully']; } ?>',
		'please_enter_signature' : '<?php if(isset($rzvy_translangArr['please_enter_signature'])){ echo $rzvy_translangArr['please_enter_signature']; }else{ echo $rzvy_defaultlang['please_enter_signature']; } ?>',
		'please_enter_api_password' : '<?php if(isset($rzvy_translangArr['please_enter_api_password'])){ echo $rzvy_translangArr['please_enter_api_password']; }else{ echo $rzvy_defaultlang['please_enter_api_password']; } ?>',
		'please_enter_api_username' : '<?php if(isset($rzvy_translangArr['please_enter_api_username'])){ echo $rzvy_translangArr['please_enter_api_username']; }else{ echo $rzvy_defaultlang['please_enter_api_username']; } ?>',
		'location_selector_setting_updated_successfully' : '<?php if(isset($rzvy_translangArr['location_selector_setting_updated_successfully'])){ echo $rzvy_translangArr['location_selector_setting_updated_successfully']; }else{ echo $rzvy_defaultlang['location_selector_setting_updated_successfully']; } ?>',
		'seo_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['seo_settings_updated_successfully'])){ echo $rzvy_translangArr['seo_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['seo_settings_updated_successfully']; } ?>',
		'sms_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['sms_settings_updated_successfully'])){ echo $rzvy_translangArr['sms_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['sms_settings_updated_successfully']; } ?>',
		'email_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['email_settings_updated_successfully'])){ echo $rzvy_translangArr['email_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['email_settings_updated_successfully']; } ?>',
		'please_enter_sender_name' : '<?php if(isset($rzvy_translangArr['please_enter_sender_name'])){ echo $rzvy_translangArr['please_enter_sender_name']; }else{ echo $rzvy_defaultlang['please_enter_sender_name']; } ?>',
		'please_enter_sender_email' : '<?php if(isset($rzvy_translangArr['please_enter_sender_email'])){ echo $rzvy_translangArr['please_enter_sender_email']; }else{ echo $rzvy_defaultlang['please_enter_sender_email']; } ?>',
		'refund_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['refund_settings_updated_successfully'])){ echo $rzvy_translangArr['refund_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['refund_settings_updated_successfully']; } ?>',
		'please_select_refund_request_buffer_time' : '<?php if(isset($rzvy_translangArr['please_select_refund_request_buffer_time'])){ echo $rzvy_translangArr['please_select_refund_request_buffer_time']; }else{ echo $rzvy_defaultlang['please_select_refund_request_buffer_time']; } ?>',
		'please_enter_refund_value' : '<?php if(isset($rzvy_translangArr['please_enter_refund_value'])){ echo $rzvy_translangArr['please_enter_refund_value']; }else{ echo $rzvy_defaultlang['please_enter_refund_value']; } ?>',
		'please_enter_refund_type' : '<?php if(isset($rzvy_translangArr['please_enter_refund_type'])){ echo $rzvy_translangArr['please_enter_refund_type']; }else{ echo $rzvy_defaultlang['please_enter_refund_type']; } ?>',
		'referral_discount_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['referral_discount_settings_updated_successfully'])){ echo $rzvy_translangArr['referral_discount_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['referral_discount_settings_updated_successfully']; } ?>',
		'please_enter_referral_discount_value' : '<?php if(isset($rzvy_translangArr['please_enter_referral_discount_value'])){ echo $rzvy_translangArr['please_enter_referral_discount_value']; }else{ echo $rzvy_defaultlang['please_enter_referral_discount_value']; } ?>',
		'please_enter_referral_discount_type' : '<?php if(isset($rzvy_translangArr['please_enter_referral_discount_type'])){ echo $rzvy_translangArr['please_enter_referral_discount_type']; }else{ echo $rzvy_defaultlang['please_enter_referral_discount_type']; } ?>',
		'appearance_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['appearance_settings_updated_successfully'])){ echo $rzvy_translangArr['appearance_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['appearance_settings_updated_successfully']; } ?>',
		'please_minimum_booking_amount' : '<?php if(isset($rzvy_translangArr['please_minimum_booking_amount'])){ echo $rzvy_translangArr['please_minimum_booking_amount']; }else{ echo $rzvy_defaultlang['please_minimum_booking_amount']; } ?>',
		'please_enter_tax_value' : '<?php if(isset($rzvy_translangArr['please_enter_tax_value'])){ echo $rzvy_translangArr['please_enter_tax_value']; }else{ echo $rzvy_defaultlang['please_enter_tax_value']; } ?>',
		'please_enter_proper_url' : '<?php if(isset($rzvy_translangArr['please_enter_proper_url'])){ echo $rzvy_translangArr['please_enter_proper_url']; }else{ echo $rzvy_defaultlang['please_enter_proper_url']; } ?>',
		'please_enter_thankyou_page_url' : '<?php if(isset($rzvy_translangArr['please_enter_thankyou_page_url'])){ echo $rzvy_translangArr['please_enter_thankyou_page_url']; }else{ echo $rzvy_defaultlang['please_enter_thankyou_page_url']; } ?>',
		'please_enter_terms_condition_link' : '<?php if(isset($rzvy_translangArr['please_enter_terms_condition_link'])){ echo $rzvy_translangArr['please_enter_terms_condition_link']; }else{ echo $rzvy_defaultlang['please_enter_terms_condition_link']; } ?>',
		'maximum_end_time_slot_limit_should_be_greater_than_equal_to_time_slot_interval' : '<?php if(isset($rzvy_translangArr['maximum_end_time_slot_limit_should_be_greater_than_equal_to_time_slot_interval'])){ echo $rzvy_translangArr['maximum_end_time_slot_limit_should_be_greater_than_equal_to_time_slot_interval']; }else{ echo $rzvy_defaultlang['maximum_end_time_slot_limit_should_be_greater_than_equal_to_time_slot_interval']; } ?>',
		'company_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['company_settings_updated_successfully'])){ echo $rzvy_translangArr['company_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['company_settings_updated_successfully']; } ?>',
		'please_enter_company_name' : '<?php if(isset($rzvy_translangArr['please_enter_company_name'])){ echo $rzvy_translangArr['please_enter_company_name']; }else{ echo $rzvy_defaultlang['please_enter_company_name']; } ?>',
		'please_enter_company_email' : '<?php if(isset($rzvy_translangArr['please_enter_company_email'])){ echo $rzvy_translangArr['please_enter_company_email']; }else{ echo $rzvy_defaultlang['please_enter_company_email']; } ?>',
		'please_enter_company_phone' : '<?php if(isset($rzvy_translangArr['please_enter_company_phone'])){ echo $rzvy_translangArr['please_enter_company_phone']; }else{ echo $rzvy_defaultlang['please_enter_company_phone']; } ?>',
		'color_scheme_updated_successfully' : '<?php if(isset($rzvy_translangArr['color_scheme_updated_successfully'])){ echo $rzvy_translangArr['color_scheme_updated_successfully']; }else{ echo $rzvy_defaultlang['color_scheme_updated_successfully']; } ?>',
		'staff_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['staff_status_changed_successfully'])){ echo $rzvy_translangArr['staff_status_changed_successfully']; }else{ echo $rzvy_defaultlang['staff_status_changed_successfully']; } ?>',
		'staff_detail_updated_successfully' : '<?php if(isset($rzvy_translangArr['staff_detail_updated_successfully'])){ echo $rzvy_translangArr['staff_detail_updated_successfully']; }else{ echo $rzvy_defaultlang['staff_detail_updated_successfully']; } ?>',
		'please_enter_password' : '<?php if(isset($rzvy_translangArr['please_enter_password'])){ echo $rzvy_translangArr['please_enter_password']; }else{ echo $rzvy_defaultlang['please_enter_password']; } ?>',
		'please_enter_confirm_password' : '<?php if(isset($rzvy_translangArr['please_enter_confirm_password'])){ echo $rzvy_translangArr['please_enter_confirm_password']; }else{ echo $rzvy_defaultlang['please_enter_confirm_password']; } ?>',
		'password_and_confirm_password_mismatch' : '<?php if(isset($rzvy_translangArr['password_and_confirm_password_mismatch'])){ echo $rzvy_translangArr['password_and_confirm_password_mismatch']; }else{ echo $rzvy_defaultlang['password_and_confirm_password_mismatch']; } ?>',
		'staff_added_successfully' : '<?php if(isset($rzvy_translangArr['staff_added_successfully'])){ echo $rzvy_translangArr['staff_added_successfully']; }else{ echo $rzvy_defaultlang['staff_added_successfully']; } ?>',
		'you_want_to_delete_this_staff' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_staff'])){ echo $rzvy_translangArr['you_want_to_delete_this_staff']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_staff']; } ?>',
		'You_cannot_delete_this_staff_you_have_appointment_with_this_staff' : '<?php if(isset($rzvy_translangArr['You_cannot_delete_this_staff_you_have_appointment_with_this_staff'])){ echo $rzvy_translangArr['You_cannot_delete_this_staff_you_have_appointment_with_this_staff']; }else{ echo $rzvy_defaultlang['You_cannot_delete_this_staff_you_have_appointment_with_this_staff']; } ?>',
		'staff_deleted_successfully' : '<?php if(isset($rzvy_translangArr['staff_deleted_successfully'])){ echo $rzvy_translangArr['staff_deleted_successfully']; }else{ echo $rzvy_defaultlang['staff_deleted_successfully']; } ?>',
		'staff_service_updated_successfully' : '<?php if(isset($rzvy_translangArr['staff_service_updated_successfully'])){ echo $rzvy_translangArr['staff_service_updated_successfully']; }else{ echo $rzvy_defaultlang['staff_service_updated_successfully']; } ?>',
		'please_select_start_time_less_than_end_time_for' : '<?php if(isset($rzvy_translangArr['please_select_start_time_less_than_end_time_for'])){ echo $rzvy_translangArr['please_select_start_time_less_than_end_time_for']; }else{ echo $rzvy_defaultlang['please_select_start_time_less_than_end_time_for']; } ?>',
		'please_select_end_time_greater_than_start_time_for' : '<?php if(isset($rzvy_translangArr['please_select_end_time_greater_than_start_time_for'])){ echo $rzvy_translangArr['please_select_end_time_greater_than_start_time_for']; }else{ echo $rzvy_defaultlang['please_select_end_time_greater_than_start_time_for']; } ?>',
		'please_enter_valid_no_of_booking_for' : '<?php if(isset($rzvy_translangArr['please_enter_valid_no_of_booking_for'])){ echo $rzvy_translangArr['please_enter_valid_no_of_booking_for']; }else{ echo $rzvy_defaultlang['please_enter_valid_no_of_booking_for']; } ?>',
		'staff_schedule_updated_successfully' : '<?php if(isset($rzvy_translangArr['staff_schedule_updated_successfully'])){ echo $rzvy_translangArr['staff_schedule_updated_successfully']; }else{ echo $rzvy_defaultlang['staff_schedule_updated_successfully']; } ?>',
		'please_select_break_start_less_than_break_end' : '<?php if(isset($rzvy_translangArr['please_select_break_start_less_than_break_end'])){ echo $rzvy_translangArr['please_select_break_start_less_than_break_end']; }else{ echo $rzvy_defaultlang['please_select_break_start_less_than_break_end']; } ?>',
		'break_start_should_not_be_equal_to_break_end' : '<?php if(isset($rzvy_translangArr['break_start_should_not_be_equal_to_break_end'])){ echo $rzvy_translangArr['break_start_should_not_be_equal_to_break_end']; }else{ echo $rzvy_defaultlang['break_start_should_not_be_equal_to_break_end']; } ?>',
		'staff_break_added_successfully' : '<?php if(isset($rzvy_translangArr['staff_break_added_successfully'])){ echo $rzvy_translangArr['staff_break_added_successfully']; }else{ echo $rzvy_defaultlang['staff_break_added_successfully']; } ?>',
		'you_want_to_delete_this_break' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_break'])){ echo $rzvy_translangArr['you_want_to_delete_this_break']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_break']; } ?>',
		'break_deleted_successfully' : '<?php if(isset($rzvy_translangArr['break_deleted_successfully'])){ echo $rzvy_translangArr['break_deleted_successfully']; }else{ echo $rzvy_defaultlang['break_deleted_successfully']; } ?>',
		'days_off_added_successfully' : '<?php if(isset($rzvy_translangArr['days_off_added_successfully'])){ echo $rzvy_translangArr['days_off_added_successfully']; }else{ echo $rzvy_defaultlang['days_off_added_successfully']; } ?>',
		'you_want_to_delete_this_offday' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_offday'])){ echo $rzvy_translangArr['you_want_to_delete_this_offday']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_offday']; } ?>',
		'days_off_deleted_successfully' : '<?php if(isset($rzvy_translangArr['days_off_deleted_successfully'])){ echo $rzvy_translangArr['days_off_deleted_successfully']; }else{ echo $rzvy_defaultlang['days_off_deleted_successfully']; } ?>',
		'today' : '<?php if(isset($rzvy_translangArr['today'])){ echo $rzvy_translangArr['today']; }else{ echo $rzvy_defaultlang['today']; } ?>',
		'calendar_view' : '<?php if(isset($rzvy_translangArr['calendar_view'])){ echo $rzvy_translangArr['calendar_view']; }else{ echo $rzvy_defaultlang['calendar_view']; } ?>',
		'month_list_view' : '<?php if(isset($rzvy_translangArr['month_list_view'])){ echo $rzvy_translangArr['month_list_view']; }else{ echo $rzvy_defaultlang['month_list_view']; } ?>',
		'year_list_view' : '<?php if(isset($rzvy_translangArr['year_list_view'])){ echo $rzvy_translangArr['year_list_view']; }else{ echo $rzvy_defaultlang['year_list_view']; } ?>',
		'please_select_staff_member' : '<?php if(isset($rzvy_translangArr['please_select_staff_member'])){ echo $rzvy_translangArr['please_select_staff_member']; }else{ echo $rzvy_defaultlang['please_select_staff_member']; } ?>',
		'email_changed_successfully' : '<?php if(isset($rzvy_translangArr['email_changed_successfully'])){ echo $rzvy_translangArr['email_changed_successfully']; }else{ echo $rzvy_defaultlang['email_changed_successfully']; } ?>',
		'please_enter_service_rate' : '<?php if(isset($rzvy_translangArr['please_enter_service_rate'])){ echo $rzvy_translangArr['please_enter_service_rate']; }else{ echo $rzvy_defaultlang['please_enter_service_rate']; } ?>',
		"textlocal_sms_settings_updated_successfully" : "<?php if(isset($rzvy_translangArr["textlocal_sms_settings_updated_successfully"])){ echo $rzvy_translangArr["textlocal_sms_settings_updated_successfully"]; }else{ echo $rzvy_defaultlang["textlocal_sms_settings_updated_successfully"]; } ?>",
		"please_enter_textlocal_sender" : "<?php if(isset($rzvy_translangArr["please_enter_textlocal_sender"])){ echo $rzvy_translangArr["please_enter_textlocal_sender"]; }else{ echo $rzvy_defaultlang["please_enter_textlocal_sender"]; } ?>",
		"nexmo_sms_settings_updated_successfully" : "<?php if(isset($rzvy_translangArr["nexmo_sms_settings_updated_successfully"])){ echo $rzvy_translangArr["nexmo_sms_settings_updated_successfully"]; }else{ echo $rzvy_defaultlang["nexmo_sms_settings_updated_successfully"]; } ?>",
		"please_enter_nexmo_from" : "<?php if(isset($rzvy_translangArr["please_enter_nexmo_from"])){ echo $rzvy_translangArr["please_enter_nexmo_from"]; }else{ echo $rzvy_defaultlang["please_enter_nexmo_from"]; } ?>",
		"please_enter_api_secret" : "<?php if(isset($rzvy_translangArr["please_enter_api_secret"])){ echo $rzvy_translangArr["please_enter_api_secret"]; }else{ echo $rzvy_defaultlang["please_enter_api_secret"]; } ?>",
		"please_enter_api_key" : "<?php if(isset($rzvy_translangArr["please_enter_api_key"])){ echo $rzvy_translangArr["please_enter_api_key"]; }else{ echo $rzvy_defaultlang["please_enter_api_key"]; } ?>",
		"plivo_sms_settings_updated_successfully" : "<?php if(isset($rzvy_translangArr["plivo_sms_settings_updated_successfully"])){ echo $rzvy_translangArr["plivo_sms_settings_updated_successfully"]; }else{ echo $rzvy_defaultlang["plivo_sms_settings_updated_successfully"]; } ?>",
		"twilio_sms_settings_updated_successfully" : "<?php if(isset($rzvy_translangArr["twilio_sms_settings_updated_successfully"])){ echo $rzvy_translangArr["twilio_sms_settings_updated_successfully"]; }else{ echo $rzvy_defaultlang["twilio_sms_settings_updated_successfully"]; } ?>",
		"please_enter_sender_number" : "<?php if(isset($rzvy_translangArr["please_enter_sender_number"])){ echo $rzvy_translangArr["please_enter_sender_number"]; }else{ echo $rzvy_defaultlang["please_enter_sender_number"]; } ?>",
		"please_enter_auth_token" : "<?php if(isset($rzvy_translangArr["please_enter_auth_token"])){ echo $rzvy_translangArr["please_enter_auth_token"]; }else{ echo $rzvy_defaultlang["please_enter_auth_token"]; } ?>",
		"please_enter_account_sid" : "<?php if(isset($rzvy_translangArr["please_enter_account_sid"])){ echo $rzvy_translangArr["please_enter_account_sid"]; }else{ echo $rzvy_defaultlang["please_enter_account_sid"]; } ?>",
		"changed_successfully" : "<?php if(isset($rzvy_translangArr["changed_successfully"])){ echo $rzvy_translangArr["changed_successfully"]; }else{ echo $rzvy_defaultlang["changed_successfully"]; } ?>",
		"please_enter_addon_maxlimit" : "<?php if(isset($rzvy_translangArr["please_enter_addon_maxlimit"])){ echo $rzvy_translangArr["please_enter_addon_maxlimit"]; }else{ echo $rzvy_defaultlang["please_enter_addon_maxlimit"]; } ?>",
		"please_enter_addon_minlimit" : "<?php if(isset($rzvy_translangArr["please_enter_addon_minlimit"])){ echo $rzvy_translangArr["please_enter_addon_minlimit"]; }else{ echo $rzvy_defaultlang["please_enter_addon_minlimit"]; } ?>",
		"please_enter_a_value_greater_than_or_equal_to_minlimit" : "<?php if(isset($rzvy_translangArr["please_enter_a_value_greater_than_or_equal_to_minlimit"])){ echo $rzvy_translangArr["please_enter_a_value_greater_than_or_equal_to_minlimit"]; }else{ echo $rzvy_defaultlang["please_enter_a_value_greater_than_or_equal_to_minlimit"]; } ?>",
		"please_enter_a_value_less_than_or_equal_to_maxlimit" : "<?php if(isset($rzvy_translangArr["please_enter_a_value_less_than_or_equal_to_maxlimit"])){ echo $rzvy_translangArr["please_enter_a_value_less_than_or_equal_to_maxlimit"]; }else{ echo $rzvy_defaultlang["please_enter_a_value_less_than_or_equal_to_maxlimit"]; } ?>",
		"updated_successfully" : "<?php if(isset($rzvy_translangArr["updated_successfully"])){ echo $rzvy_translangArr["updated_successfully"]; }else{ echo $rzvy_defaultlang["updated_successfully"]; } ?>",
		"deleted_successfully" : "<?php if(isset($rzvy_translangArr["deleted_successfully"])){ echo $rzvy_translangArr["deleted_successfully"]; }else{ echo $rzvy_defaultlang["deleted_successfully"]; } ?>",
		"please_enter_addon_duration" : "<?php if(isset($rzvy_translangArr["please_enter_addon_duration"])){ echo $rzvy_translangArr["please_enter_addon_duration"]; }else{ echo $rzvy_defaultlang["please_enter_addon_duration"]; } ?>",
		"email_already_exist" : "<?php if(isset($rzvy_translangArr["email_already_exist"])){ echo $rzvy_translangArr["email_already_exist"]; }else{ echo $rzvy_defaultlang["email_already_exist"]; } ?>",
		"please_enter_referral_code" : "<?php if(isset($rzvy_translangArr["please_enter_referral_code"])){ echo $rzvy_translangArr["please_enter_referral_code"]; }else{ echo $rzvy_defaultlang["please_enter_referral_code"]; } ?>",
		"enter_referral_code_8_digit_ode" : "<?php if(isset($rzvy_translangArr["enter_referral_code_8_digit_ode"])){ echo $rzvy_translangArr["enter_referral_code_8_digit_ode"]; }else{ echo $rzvy_defaultlang["enter_referral_code_8_digit_ode"]; } ?>",
		"referral_code_already_exist" : "<?php if(isset($rzvy_translangArr["referral_code_already_exist"])){ echo $rzvy_translangArr["referral_code_already_exist"]; }else{ echo $rzvy_defaultlang["referral_code_already_exist"]; } ?>",
		"referral_code_pattern" : "<?php if(isset($rzvy_translangArr["referral_code_pattern"])){ echo $rzvy_translangArr["referral_code_pattern"]; }else{ echo $rzvy_defaultlang["referral_code_pattern"]; } ?>",
		"customer_updated_successfully" : "<?php if(isset($rzvy_translangArr["customer_updated_successfully"])){ echo $rzvy_translangArr["customer_updated_successfully"]; }else{ echo $rzvy_defaultlang["customer_updated_successfully"]; } ?>",
		"please_select_start_time" : "<?php if(isset($rzvy_translangArr["please_select_start_time"])){ echo $rzvy_translangArr["please_select_start_time"]; }else{ echo $rzvy_defaultlang["please_select_start_time"]; } ?>",
		"please_select_end_time" : "<?php if(isset($rzvy_translangArr["please_select_end_time"])){ echo $rzvy_translangArr["please_select_end_time"]; }else{ echo $rzvy_defaultlang["please_select_end_time"]; } ?>",
		"please_enter_no_of_bookings" : "<?php if(isset($rzvy_translangArr["please_enter_no_of_bookings"])){ echo $rzvy_translangArr["please_enter_no_of_bookings"]; }else{ echo $rzvy_defaultlang["please_enter_no_of_bookings"]; } ?>",
		"please_enter_valid_offdate" : "<?php if(isset($rzvy_translangArr["please_enter_valid_offdate"])){ echo $rzvy_translangArr["please_enter_valid_offdate"]; }else{ echo $rzvy_defaultlang["please_enter_valid_offdate"]; } ?>",
		'are_you_sure_you_want_to_clone' : '<?php if(isset($rzvy_translangArr['are_you_sure_you_want_to_clone'])){ echo $rzvy_translangArr['are_you_sure_you_want_to_clone']; }else{ echo $rzvy_defaultlang['are_you_sure_you_want_to_clone']; } ?>',
		'yes_clone_it' : '<?php if(isset($rzvy_translangArr['yes_clone_it'])){ echo $rzvy_translangArr['yes_clone_it']; }else{ echo $rzvy_defaultlang['yes_clone_it']; } ?>',
		'cloned' : '<?php if(isset($rzvy_translangArr['cloned'])){ echo $rzvy_translangArr['cloned']; }else{ echo $rzvy_defaultlang['cloned']; } ?>',
		'reschedule_now' : '<?php if(isset($rzvy_translangArr['reschedule_now'])){ echo $rzvy_translangArr['reschedule_now']; }else{ echo $rzvy_defaultlang['reschedule_now']; } ?>',
		'staff_not_available' : '<?php if(isset($rzvy_translangArr['staff_not_available'])){ echo $rzvy_translangArr['staff_not_available']; }else{ echo $rzvy_defaultlang['staff_not_available']; } ?>',
		'want_to_send_email_sms_notification' : '<?php if(isset($rzvy_translangArr['want_to_send_email_sms_notification'])){ echo $rzvy_translangArr['want_to_send_email_sms_notification']; }else{ echo $rzvy_defaultlang['want_to_send_email_sms_notification']; } ?>',
		'break_date' : '<?php if(isset($rzvy_translangArr['break_date'])){ echo $rzvy_translangArr['break_date']; }else{ echo $rzvy_defaultlang['break_date']; } ?>',
		'add_break' : '<?php if(isset($rzvy_translangArr['add_break'])){ echo $rzvy_translangArr['add_break']; }else{ echo $rzvy_defaultlang['add_break']; } ?>',
		'please_pay_first' : '<?php if(isset($rzvy_translangArr['please_pay_first'])){ echo $rzvy_translangArr['please_pay_first']; }else{ echo $rzvy_defaultlang['please_pay_first']; } ?>',
		'appointment_completed_successfully' : '<?php if(isset($rzvy_translangArr['appointment_completed_successfully'])){ echo $rzvy_translangArr['appointment_completed_successfully']; }else{ echo $rzvy_defaultlang['appointment_completed_successfully']; } ?>',
		'appointment_saved_successfully' : '<?php if(isset($rzvy_translangArr['appointment_saved_successfully'])){ echo $rzvy_translangArr['appointment_saved_successfully']; }else{ echo $rzvy_defaultlang['appointment_saved_successfully']; } ?>',
		'please_add_service' : '<?php if(isset($rzvy_translangArr['please_add_service'])){ echo $rzvy_translangArr['please_add_service']; }else{ echo $rzvy_defaultlang['please_add_service']; } ?>',
		'please_choose_slot' : '<?php if(isset($rzvy_translangArr['please_choose_slot'])){ echo $rzvy_translangArr['please_choose_slot']; }else{ echo $rzvy_defaultlang['please_choose_slot']; } ?>',
		'please_select_customer_to_book_an_appointment' : '<?php if(isset($rzvy_translangArr['please_select_customer_to_book_an_appointment'])){ echo $rzvy_translangArr['please_select_customer_to_book_an_appointment']; }else{ echo $rzvy_defaultlang['please_select_customer_to_book_an_appointment']; } ?>',
		'please_enter_w2s_sender' : '<?php if(isset($rzvy_translangArr['please_enter_w2s_sender'])){ echo $rzvy_translangArr['please_enter_w2s_sender']; }else{ echo $rzvy_defaultlang['please_enter_w2s_sender']; } ?>',
		'w2s_sms_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['w2s_sms_settings_updated_successfully'])){ echo $rzvy_translangArr['w2s_sms_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['w2s_sms_settings_updated_successfully']; } ?>',
		'complete_appointment_quemark' : '<?php if(isset($rzvy_translangArr['complete_appointment_quemark'])){ echo $rzvy_translangArr['complete_appointment_quemark']; }else{ echo $rzvy_defaultlang['complete_appointment_quemark']; } ?>',
		'print' : '<?php if(isset($rzvy_translangArr['print'])){ echo $rzvy_translangArr['print']; }else{ echo $rzvy_defaultlang['print']; } ?>',
		'fiscal_code' : '<?php if(isset($rzvy_translangArr['fiscal_code'])){ echo $rzvy_translangArr['fiscal_code']; }else{ echo $rzvy_defaultlang['fiscal_code']; } ?>',
		'do_you_want_receipt' : '<?php if(isset($rzvy_translangArr['do_you_want_receipt'])){ echo $rzvy_translangArr['do_you_want_receipt']; }else{ echo $rzvy_defaultlang['do_you_want_receipt']; } ?>',
		'please_enter_only_numerics_days' : '<?php if(isset($rzvy_translangArr['please_enter_only_numerics_days'])){ echo $rzvy_translangArr['please_enter_only_numerics_days']; }else{ echo $rzvy_defaultlang['please_enter_only_numerics_days']; } ?>',
		'please_enter_servicespackage_title' : '<?php if(isset($rzvy_translangArr['please_enter_servicespackage_title'])){ echo $rzvy_translangArr['please_enter_servicespackage_title']; }else{ echo $rzvy_defaultlang['please_enter_servicespackage_title']; } ?>',
		'please_enter_servicespackage_rate' : '<?php if(isset($rzvy_translangArr['please_enter_servicespackage_rate'])){ echo $rzvy_translangArr['please_enter_servicespackage_rate']; }else{ echo $rzvy_defaultlang['please_enter_servicespackage_rate']; } ?>',
		'please_enter_servicespackage_duration' : '<?php if(isset($rzvy_translangArr['please_enter_servicespackage_duration'])){ echo $rzvy_translangArr['please_enter_servicespackage_duration']; }else{ echo $rzvy_defaultlang['please_enter_servicespackage_duration']; } ?>',
		'servicespackage_added_successfully' : '<?php if(isset($rzvy_translangArr['servicespackage_added_successfully'])){ echo $rzvy_translangArr['servicespackage_added_successfully']; }else{ echo $rzvy_defaultlang['servicespackage_added_successfully']; } ?>',
		'servicespackage_updated_successfully' : '<?php if(isset($rzvy_translangArr['servicespackage_updated_successfully'])){ echo $rzvy_translangArr['servicespackage_updated_successfully']; }else{ echo $rzvy_defaultlang['servicespackage_updated_successfully']; } ?>',
		'package_status_changed_successfully' : '<?php if(isset($rzvy_translangArr['package_status_changed_successfully'])){ echo $rzvy_translangArr['package_status_changed_successfully']; }else{ echo $rzvy_defaultlang['package_status_changed_successfully']; } ?>',
		'package_deleted_successfully' : '<?php if(isset($rzvy_translangArr['package_deleted_successfully'])){ echo $rzvy_translangArr['package_deleted_successfully']; }else{ echo $rzvy_defaultlang['package_deleted_successfully']; } ?>',
		'are_you_sure_you_want_to_delete_customer' : '<?php if(isset($rzvy_translangArr['are_you_sure_you_want_to_delete_customer'])){ echo $rzvy_translangArr['are_you_sure_you_want_to_delete_customer']; }else{ echo $rzvy_defaultlang['are_you_sure_you_want_to_delete_customer']; } ?>',
		'customer_delete_note' : '<?php if(isset($rzvy_translangArr['customer_delete_note'])){ echo $rzvy_translangArr['customer_delete_note']; }else{ echo $rzvy_defaultlang['customer_delete_note']; } ?>',
		'customer_deleted_successfully' : '<?php if(isset($rzvy_translangArr['customer_deleted_successfully'])){ echo $rzvy_translangArr['customer_deleted_successfully']; }else{ echo $rzvy_defaultlang['customer_deleted_successfully']; } ?>',
		'you_want_to_mark_this_appointment_as_noshow' : '<?php if(isset($rzvy_translangArr['you_want_to_mark_this_appointment_as_noshow'])){ echo $rzvy_translangArr['you_want_to_mark_this_appointment_as_noshow']; }else{ echo $rzvy_defaultlang['you_want_to_mark_this_appointment_as_noshow']; } ?>',
		'yes_mark_as_noshow' : '<?php if(isset($rzvy_translangArr['yes_mark_as_noshow'])){ echo $rzvy_translangArr['yes_mark_as_noshow']; }else{ echo $rzvy_defaultlang['yes_mark_as_noshow']; } ?>',
		'mark_as_noshow' : '<?php if(isset($rzvy_translangArr['mark_as_noshow'])){ echo $rzvy_translangArr['mark_as_noshow']; }else{ echo $rzvy_defaultlang['mark_as_noshow']; } ?>',
		'custom_message_updated_successfully' : '<?php if(isset($rzvy_translangArr['custom_message_updated_successfully'])){ echo $rzvy_translangArr['custom_message_updated_successfully']; }else{ echo $rzvy_defaultlang['custom_message_updated_successfully']; } ?>',
		'appointment_marked_as_noshow_successfully' : '<?php if(isset($rzvy_translangArr['appointment_marked_as_noshow_successfully'])){ echo $rzvy_translangArr['appointment_marked_as_noshow_successfully']; }else{ echo $rzvy_defaultlang['appointment_marked_as_noshow_successfully']; } ?>',
		'campaign_added_successfully' : '<?php if(isset($rzvy_translangArr['campaign_added_successfully'])){ echo $rzvy_translangArr['campaign_added_successfully']; }else{ echo $rzvy_defaultlang['campaign_added_successfully']; } ?>',
		'please_enter_campaign_name' : '<?php if(isset($rzvy_translangArr['please_enter_campaign_name'])){ echo $rzvy_translangArr['please_enter_campaign_name']; }else{ echo $rzvy_defaultlang['please_enter_campaign_name']; } ?>',
		'please_select_campaign_startdate' : '<?php if(isset($rzvy_translangArr['please_select_campaign_startdate'])){ echo $rzvy_translangArr['please_select_campaign_startdate']; }else{ echo $rzvy_defaultlang['please_select_campaign_startdate']; } ?>',
		'please_select_campaign_enddate' : '<?php if(isset($rzvy_translangArr['please_select_campaign_enddate'])){ echo $rzvy_translangArr['please_select_campaign_enddate']; }else{ echo $rzvy_defaultlang['please_select_campaign_enddate']; } ?>',
		'you_want_to_delete_this_campaign' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_campaign'])){ echo $rzvy_translangArr['you_want_to_delete_this_campaign']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_campaign']; } ?>',
		'campaign_deleted_successfully' : '<?php if(isset($rzvy_translangArr['campaign_deleted_successfully'])){ echo $rzvy_translangArr['campaign_deleted_successfully']; }else{ echo $rzvy_defaultlang['campaign_deleted_successfully']; } ?>',
		'campaign_updated_successfully' : '<?php if(isset($rzvy_translangArr['campaign_updated_successfully'])){ echo $rzvy_translangArr['campaign_updated_successfully']; }else{ echo $rzvy_defaultlang['campaign_updated_successfully']; } ?>',
		'review_settings_updated_successfully' : '<?php if(isset($rzvy_translangArr['review_settings_updated_successfully'])){ echo $rzvy_translangArr['review_settings_updated_successfully']; }else{ echo $rzvy_defaultlang['review_settings_updated_successfully']; } ?>',
		'yesterday' : '<?php if(isset($rzvy_translangArr['yesterday'])){ echo $rzvy_translangArr['yesterday']; }else{ echo $rzvy_defaultlang['yesterday']; } ?>',
		'last7days' : '<?php if(isset($rzvy_translangArr['last7days'])){ echo $rzvy_translangArr['last7days']; }else{ echo $rzvy_defaultlang['last7days']; } ?>',
		'last30days' : '<?php if(isset($rzvy_translangArr['last30days'])){ echo $rzvy_translangArr['last30days']; }else{ echo $rzvy_defaultlang['last30days']; } ?>',
		'thismonth' : '<?php if(isset($rzvy_translangArr['thismonth'])){ echo $rzvy_translangArr['thismonth']; }else{ echo $rzvy_defaultlang['thismonth']; } ?>',
		'lastmonth' : '<?php if(isset($rzvy_translangArr['lastmonth'])){ echo $rzvy_translangArr['lastmonth']; }else{ echo $rzvy_defaultlang['lastmonth']; } ?>',
		'apply' : '<?php if(isset($rzvy_translangArr['apply'])){ echo $rzvy_translangArr['apply']; }else{ echo $rzvy_defaultlang['apply']; } ?>',
		'from' : '<?php if(isset($rzvy_translangArr['from'])){ echo $rzvy_translangArr['from']; }else{ echo $rzvy_defaultlang['from']; } ?>',
		'to' : '<?php if(isset($rzvy_translangArr['to'])){ echo $rzvy_translangArr['to']; }else{ echo $rzvy_defaultlang['to']; } ?>',
		'custom' : '<?php if(isset($rzvy_translangArr['custom'])){ echo $rzvy_translangArr['custom']; }else{ echo $rzvy_defaultlang['custom']; } ?>',
		'sun' : '<?php if(isset($rzvy_translangArr['sun'])){ echo $rzvy_translangArr['sun']; }else{ echo $rzvy_defaultlang['sun']; } ?>',
		'mon' : '<?php if(isset($rzvy_translangArr['mon'])){ echo $rzvy_translangArr['mon']; }else{ echo $rzvy_defaultlang['mon']; } ?>',
		'tue' : '<?php if(isset($rzvy_translangArr['tue'])){ echo $rzvy_translangArr['tue']; }else{ echo $rzvy_defaultlang['tue']; } ?>',
		'wed' : '<?php if(isset($rzvy_translangArr['wed'])){ echo $rzvy_translangArr['wed']; }else{ echo $rzvy_defaultlang['wed']; } ?>',
		'thu' : '<?php if(isset($rzvy_translangArr['thu'])){ echo $rzvy_translangArr['thu']; }else{ echo $rzvy_defaultlang['thu']; } ?>',
		'fri' : '<?php if(isset($rzvy_translangArr['fri'])){ echo $rzvy_translangArr['fri']; }else{ echo $rzvy_defaultlang['fri']; } ?>',
		'sat' : '<?php if(isset($rzvy_translangArr['sat'])){ echo $rzvy_translangArr['sat']; }else{ echo $rzvy_defaultlang['sat']; } ?>',
		'sunday' : '<?php if(isset($rzvy_translangArr['sunday'])){ echo $rzvy_translangArr['sunday']; }else{ echo $rzvy_defaultlang['sunday']; } ?>',
		'monday' : '<?php if(isset($rzvy_translangArr['monday'])){ echo $rzvy_translangArr['monday']; }else{ echo $rzvy_defaultlang['monday']; } ?>',
		'tuesday' : '<?php if(isset($rzvy_translangArr['tuesday'])){ echo $rzvy_translangArr['tuesday']; }else{ echo $rzvy_defaultlang['tuesday']; } ?>',
		'wednesday' : '<?php if(isset($rzvy_translangArr['wednesday'])){ echo $rzvy_translangArr['wednesday']; }else{ echo $rzvy_defaultlang['wednesday']; } ?>',
		'thursday' : '<?php if(isset($rzvy_translangArr['thursday'])){ echo $rzvy_translangArr['thursday']; }else{ echo $rzvy_defaultlang['thursday']; } ?>',
		'friday' : '<?php if(isset($rzvy_translangArr['friday'])){ echo $rzvy_translangArr['friday']; }else{ echo $rzvy_defaultlang['friday']; } ?>',
		'saturday' : '<?php if(isset($rzvy_translangArr['saturday'])){ echo $rzvy_translangArr['saturday']; }else{ echo $rzvy_defaultlang['saturday']; } ?>',
		'su' : '<?php if(isset($rzvy_translangArr['su'])){ echo $rzvy_translangArr['su']; }else{ echo $rzvy_defaultlang['su']; } ?>',
		'mo' : '<?php if(isset($rzvy_translangArr['mo'])){ echo $rzvy_translangArr['mo']; }else{ echo $rzvy_defaultlang['mo']; } ?>',
		'tu' : '<?php if(isset($rzvy_translangArr['tu'])){ echo $rzvy_translangArr['tu']; }else{ echo $rzvy_defaultlang['tu']; } ?>',
		'we' : '<?php if(isset($rzvy_translangArr['we'])){ echo $rzvy_translangArr['we']; }else{ echo $rzvy_defaultlang['we']; } ?>',
		'th' : '<?php if(isset($rzvy_translangArr['th'])){ echo $rzvy_translangArr['th']; }else{ echo $rzvy_defaultlang['th']; } ?>',
		'fr' : '<?php if(isset($rzvy_translangArr['fr'])){ echo $rzvy_translangArr['fr']; }else{ echo $rzvy_defaultlang['fr']; } ?>',
		'sa' : '<?php if(isset($rzvy_translangArr['sa'])){ echo $rzvy_translangArr['sa']; }else{ echo $rzvy_defaultlang['sa']; } ?>',
		'january' : '<?php if(isset($rzvy_translangArr['january'])){ echo $rzvy_translangArr['january']; }else{ echo $rzvy_defaultlang['january']; } ?>',
		'february' : '<?php if(isset($rzvy_translangArr['february'])){ echo $rzvy_translangArr['february']; }else{ echo $rzvy_defaultlang['february']; } ?>',
		'march' : '<?php if(isset($rzvy_translangArr['march'])){ echo $rzvy_translangArr['march']; }else{ echo $rzvy_defaultlang['march']; } ?>',
		'april' : '<?php if(isset($rzvy_translangArr['april'])){ echo $rzvy_translangArr['april']; }else{ echo $rzvy_defaultlang['april']; } ?>',
		'may' : '<?php if(isset($rzvy_translangArr['may'])){ echo $rzvy_translangArr['may']; }else{ echo $rzvy_defaultlang['may']; } ?>',
		'june' : '<?php if(isset($rzvy_translangArr['june'])){ echo $rzvy_translangArr['june']; }else{ echo $rzvy_defaultlang['june']; } ?>',
		'july' : '<?php if(isset($rzvy_translangArr['july'])){ echo $rzvy_translangArr['july']; }else{ echo $rzvy_defaultlang['july']; } ?>',
		'august' : '<?php if(isset($rzvy_translangArr['august'])){ echo $rzvy_translangArr['august']; }else{ echo $rzvy_defaultlang['august']; } ?>',
		'september' : '<?php if(isset($rzvy_translangArr['september'])){ echo $rzvy_translangArr['september']; }else{ echo $rzvy_defaultlang['september']; } ?>',
		'october' : '<?php if(isset($rzvy_translangArr['october'])){ echo $rzvy_translangArr['october']; }else{ echo $rzvy_defaultlang['october']; } ?>',
		'november' : '<?php if(isset($rzvy_translangArr['november'])){ echo $rzvy_translangArr['november']; }else{ echo $rzvy_defaultlang['november']; } ?>',
		'december' : '<?php if(isset($rzvy_translangArr['december'])){ echo $rzvy_translangArr['december']; }else{ echo $rzvy_defaultlang['december']; } ?>',		
		'jan' : '<?php if(isset($rzvy_translangArr['jan'])){ echo $rzvy_translangArr['jan']; }else{ echo $rzvy_defaultlang['jan']; } ?>',
		'feb' : '<?php if(isset($rzvy_translangArr['feb'])){ echo $rzvy_translangArr['feb']; }else{ echo $rzvy_defaultlang['feb']; } ?>',
		'mar' : '<?php if(isset($rzvy_translangArr['mar'])){ echo $rzvy_translangArr['mar']; }else{ echo $rzvy_defaultlang['mar']; } ?>',
		'apr' : '<?php if(isset($rzvy_translangArr['apr'])){ echo $rzvy_translangArr['apr']; }else{ echo $rzvy_defaultlang['apr']; } ?>',
		'mays' : '<?php if(isset($rzvy_translangArr['mays'])){ echo $rzvy_translangArr['mays']; }else{ echo $rzvy_defaultlang['mays']; } ?>',
		'jun' : '<?php if(isset($rzvy_translangArr['jun'])){ echo $rzvy_translangArr['jun']; }else{ echo $rzvy_defaultlang['jun']; } ?>',
		'jul' : '<?php if(isset($rzvy_translangArr['jul'])){ echo $rzvy_translangArr['jul']; }else{ echo $rzvy_defaultlang['jul']; } ?>',
		'aug' : '<?php if(isset($rzvy_translangArr['aug'])){ echo $rzvy_translangArr['aug']; }else{ echo $rzvy_defaultlang['aug']; } ?>',
		'sep' : '<?php if(isset($rzvy_translangArr['sep'])){ echo $rzvy_translangArr['sep']; }else{ echo $rzvy_defaultlang['sep']; } ?>',
		'oct' : '<?php if(isset($rzvy_translangArr['oct'])){ echo $rzvy_translangArr['oct']; }else{ echo $rzvy_defaultlang['oct']; } ?>',
		'nov' : '<?php if(isset($rzvy_translangArr['nov'])){ echo $rzvy_translangArr['nov']; }else{ echo $rzvy_defaultlang['nov']; } ?>',
		'dec' : '<?php if(isset($rzvy_translangArr['dec'])){ echo $rzvy_translangArr['dec']; }else{ echo $rzvy_defaultlang['dec']; } ?>',
		
		};
	</script>
	
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'category.php') != false || strpos($_SERVER['SCRIPT_NAME'], 'services.php') != false || strpos($_SERVER['SCRIPT_NAME'], 'reorder-addons.php') != false || strpos($_SERVER['SCRIPT_NAME'], 'staff.php') != false) { ?>
		<script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery-ui.min.js?<?php echo time(); ?>"></script>
	<?php } ?>
	
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'location-selector.php') != false) { ?>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/bootstrap-tagsinput.js?<?php echo time(); ?>"></script>
	<?php } ?>
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'location-selector.php') != false || strpos($_SERVER['SCRIPT_NAME'], 'refund.php') != false || strpos($_SERVER['SCRIPT_NAME'], 'email-sms-templates.php') != false || strpos($_SERVER['SCRIPT_NAME'], 'settings.php') != false) { ?>
		<!-- include text editor -->
		<script type="text/javascript" src="<?php echo SITE_URL; ?>includes/vendor/text-editor/text-editor.js?<?php echo time(); ?>"></script>
	<?php } ?>
	
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'dashboard.php') != false) { ?>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/moment.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/daterangepicker.js?<?php echo time(); ?>"></script>
		<script>
			var start = moment(new Date("<?php echo date('Y/m/d', strtotime($drp_startdate)); ?>"));
			var end = moment(new Date("<?php echo date('Y/m/d', strtotime($drp_enddate)); ?>"));
			$('#rzvy_reportrange').daterangepicker({
					locale: {
					//format: 'DD MMM YYYY'
				},
				startDate: moment(start),
				endDate: moment(end),
				ranges: {
				  '<?php if(isset($rzvy_translangArr['today'])){ echo $rzvy_translangArr['today']; }else{ echo $rzvy_defaultlang['today']; } ?>': [moment(), moment()],
				   '<?php if(isset($rzvy_translangArr['yesterday'])){ echo $rzvy_translangArr['yesterday']; }else{ echo $rzvy_defaultlang['yesterday']; } ?>': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				   '<?php if(isset($rzvy_translangArr['last7days'])){ echo $rzvy_translangArr['last7days']; }else{ echo $rzvy_defaultlang['last7days']; } ?>': [moment().subtract(6, 'days'), moment()],
				   '<?php if(isset($rzvy_translangArr['last30days'])){ echo $rzvy_translangArr['last30days']; }else{ echo $rzvy_defaultlang['last30days']; } ?>': [moment().subtract(29, 'days'), moment()],
				   '<?php if(isset($rzvy_translangArr['thismonth'])){ echo $rzvy_translangArr['thismonth']; }else{ echo $rzvy_defaultlang['thismonth']; } ?>': [moment().startOf('month'), moment().endOf('month')],
				   '<?php if(isset($rzvy_translangArr['lastmonth'])){ echo $rzvy_translangArr['lastmonth']; }else{ echo $rzvy_defaultlang['lastmonth']; } ?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
				},
				"locale": {
					"separator": " - ",
					"applyLabel": generalObj.apply,
					"cancelLabel": generalObj.cancel,
					"fromLabel": generalObj.from,
					"toLabel": generalObj.to,
					"customRangeLabel": generalObj.custom,
					"daysOfWeek": [
						generalObj.sun,
						generalObj.mon,
						generalObj.tue,
						generalObj.wed,
						generalObj.thu,
						generalObj.fri,
						generalObj.sat
					],
					"monthNames": [
						generalObj.january,
						generalObj.february,
						generalObj.march,
						generalObj.april,
						generalObj.may,
						generalObj.june,
						generalObj.july,
						generalObj.august,
						generalObj.september,
						generalObj.october,
						generalObj.november,
						generalObj.december
					]
				}
			}, 
			function(start, end) {			 				
				window.location.href = generalObj.site_url+"backend/dashboard.php?start="+start.format('YYYY-MM-DD')+"&end="+end.format('YYYY-MM-DD');
			});
			var rzvytransmonth = start.format('MMMM');
			if(start.format('MMMM')=='January'){ var rzvytransmonth = generalObj.january; }
			if(start.format('MMMM')=='February'){ var rzvytransmonth = generalObj.february; }
			if(start.format('MMMM')=='March'){ var rzvytransmonth = generalObj.march; }
			if(start.format('MMMM')=='April'){ var rzvytransmonth = generalObj.april; }
			if(start.format('MMMM')=='May'){ var rzvytransmonth = generalObj.may; }
			if(start.format('MMMM')=='June'){ var rzvytransmonth = generalObj.june; }
			if(start.format('MMMM')=='July'){ var rzvytransmonth = generalObj.july; }
			if(start.format('MMMM')=='August'){ var rzvytransmonth = generalObj.august; }
			if(start.format('MMMM')=='September'){ var rzvytransmonth = generalObj.september; }
			if(start.format('MMMM')=='October'){ var rzvytransmonth = generalObj.october; }
			if(start.format('MMMM')=='November'){ var rzvytransmonth = generalObj.november; }
			if(start.format('MMMM')=='December'){ var rzvytransmonth = generalObj.december; }
			var rzvytransmonthend = end.format('MMMM');
			if(end.format('MMMM')=='January'){ var rzvytransmonthend = generalObj.january; }
			if(end.format('MMMM')=='February'){ var rzvytransmonthend = generalObj.february; }
			if(end.format('MMMM')=='March'){ var rzvytransmonthend = generalObj.march; }
			if(end.format('MMMM')=='April'){ var rzvytransmonthend = generalObj.april; }
			if(end.format('MMMM')=='May'){ var rzvytransmonthend = generalObj.may; }
			if(end.format('MMMM')=='June'){ var rzvytransmonthend = generalObj.june; }
			if(end.format('MMMM')=='July'){ var rzvytransmonthend = generalObj.july; }
			if(end.format('MMMM')=='August'){ var rzvytransmonthend = generalObj.august; }
			if(end.format('MMMM')=='September'){ var rzvytransmonthend = generalObj.september; }
			if(end.format('MMMM')=='October'){ var rzvytransmonthend = generalObj.october; }
			if(end.format('MMMM')=='November'){ var rzvytransmonthend = generalObj.november; }
			if(end.format('MMMM')=='December'){ var rzvytransmonthend = generalObj.december; }
			$('#rzvy_reportrange span').html(rzvytransmonth+start.format(' D, YYYY') + ' - ' +rzvytransmonthend+ end.format(' D, YYYY'));
		</script>
	<?php } ?>

	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'advance-schedule.php') != false) { ?>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/moment.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/daterangepicker.js?<?php echo time(); ?>"></script>
		<script>
			$(function() {
				$('#rzvy_advanceschedule_daterange').daterangepicker({ minDate: moment(), startDate: moment(), endDate: moment().add(2, 'days'), singleDatePicker: true,locale: { "separator": " - ",	"applyLabel": generalObj.apply,	"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,	"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,"daysOfWeek": [generalObj.sun,generalObj.mon,generalObj.tue,generalObj.wed,generalObj.thu,generalObj.fri,generalObj.sat],"monthNames": [generalObj.january,generalObj.february,generalObj.march,generalObj.april,generalObj.may,generalObj.june,generalObj.july,generalObj.august,generalObj.september,generalObj.october,generalObj.november,generalObj.december]} });
			});
		</script>
	<?php } ?>
	
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'pos.php') != false ) { ?>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/moment.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/daterangepicker.js?<?php echo time(); ?>"></script>
		<script>
			var start = moment(new Date("<?php echo date('Y/m/d', strtotime($bookingdate)); ?>"));
			$(function() {
				$('#rzvy_pos_bookingdatepicker').daterangepicker({ minDate: moment(), startDate: moment(start), singleDatePicker: true,locale: { "separator": " - ",	"applyLabel": generalObj.apply,	"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,	"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,"daysOfWeek": [generalObj.sun,generalObj.mon,generalObj.tue,generalObj.wed,generalObj.thu,generalObj.fri,generalObj.sat],"monthNames": [generalObj.january,generalObj.february,generalObj.march,generalObj.april,generalObj.may,generalObj.june,generalObj.july,generalObj.august,generalObj.september,generalObj.october,generalObj.november,generalObj.december]} }, 
				function(start, end) {
					$('#rzvy_pos_bookingdatepicker span').html(start.format('YYYY-MM-DD'));					
					$('#rzvy_pos_hidden_bookingdate').val(start.format('YYYY-MM-DD'));
					$('#rzvy_pos_staff_1').trigger('change');
				});			
				$('#rzvy_pos_bookingdatepicker span').html(start.format('YYYY-MM-DD'));
			});
		</script>
	<?php } ?>
	
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'advance-schedule-breaks.php') != false) { ?>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/moment.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/daterangepicker.js?<?php echo time(); ?>"></script>
		<script>
			$(function() {
				$('#rzvy_advanceschedule_break_daterange').daterangepicker({ minDate: moment(), startDate: moment(), endDate: moment().add(2, 'days'), singleDatePicker: true,locale: { "separator": " - ",	"applyLabel": generalObj.apply,	"cancelLabel": generalObj.cancel,"fromLabel": generalObj.from,	"toLabel": generalObj.to,"customRangeLabel": generalObj.custom,"daysOfWeek": [generalObj.sun,generalObj.mon,generalObj.tue,generalObj.wed,generalObj.thu,generalObj.fri,generalObj.sat],"monthNames": [generalObj.january,generalObj.february,generalObj.march,generalObj.april,generalObj.may,generalObj.june,generalObj.july,generalObj.august,generalObj.september,generalObj.october,generalObj.november,generalObj.december]} });
			});
		</script>
	<?php } ?>
	
	<?php include(dirname(dirname(__FILE__))."/includes/lib/rzvy_lang_objects.php"); ?>
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'appointments.php') != false) { ?>
		<!-- Bootstrap core JavaScript and Custom Page level plugin JavaScript-->
		<script src="<?php echo SITE_URL; ?>includes/manual-booking/js/popper.min.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/manual-booking/js/slick.min.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/manual-booking/js/datepicker.min.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/manual-booking/js/rzvy-mb-jquery.js?<?php echo time(); ?>"></script>
	<?php } ?>
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'appointments.php') != false) { ?>
		<script>
		setInterval(function(){$('#rzvy-appointments-calendar').fullCalendar('refetchEvents')}, 15000); 
		</script>
	<?php } ?>
	<?php $Rzvy_Hooks->adminFooterIncludes(); ?>
	<script src="<?php echo SITE_URL; ?>includes/vendor/intl-tel-input/js/intlTelInput.js?<?php echo time(); ?>"></script>
	<script src="<?php echo SITE_URL; ?>includes/js/rzvy-admin.js?<?php echo time(); ?>"></script>
	<script src="<?php echo SITE_URL; ?>includes/js/rzvy-astaff.js?<?php echo time(); ?>"></script>
	<script src="<?php echo SITE_URL; ?>includes/js/rzvy-set-languages.js?<?php echo time(); ?>"></script>
  </div>
</body>
</html>