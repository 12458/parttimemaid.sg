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
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span></button>
			</div>
		  </div>
		  <div class="modal-body rzvy_appointment_detail_modal_body">
			<center><h2><?php if(isset($rzvy_translangArr['please_wait_while_processing'])){ echo $rzvy_translangArr['please_wait_while_processing']; }else{ echo $rzvy_defaultlang['please_wait_while_processing']; } ?></h2></center>
		  </div>
		  <div class="modal-footer"> </div>
		</div>
	  </div>
	</div>	
	
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
            <a class="btn btn-primary rzvy_change_password_btn" data-id="<?php if(isset($_SESSION['customer_id'])){ echo $_SESSION['customer_id']; } ?>" href="javascript:void(0);"><?php if(isset($rzvy_translangArr['change_password'])){ echo $rzvy_translangArr['change_password']; }else{ echo $rzvy_defaultlang['change_password']; } ?></a>
          </div>
        </div>
      </div>
    </div>
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
	<!-- Image Cropper JavaScript-->
    <script src="<?php echo SITE_URL; ?>includes/js/cropper.js?<?php echo time(); ?>"></script>
	<script>
		var generalObj = { 'site_url' : '<?php echo SITE_URL; ?>', 'ajax_url' : '<?php echo AJAX_URL; ?>', 'current_date' : '<?php echo date('Y-m-d'); ?>', 'defaultCountryCode' : '<?php $rzvy_default_country_code = $obj_settings->get_option("rzvy_default_country_code"); if($rzvy_default_country_code != ""){ echo $rzvy_default_country_code; }else{ echo "us"; } ?>','rzvy_image_type' : '<?php echo $obj_settings->get_option("rzvy_image_type"); ?>','rzvy_croping_type' : '<?php echo $obj_settings->get_option("rzvy_croping_type"); ?>',
			'please_enter_only_alphabets' : '<?php if(isset($rzvy_translangArr['please_enter_only_alphabets'])){ echo $rzvy_translangArr['please_enter_only_alphabets']; }else{ echo $rzvy_defaultlang['please_enter_only_alphabets']; } ?>',
			'please_enter_only_numerics' : '<?php if(isset($rzvy_translangArr['please_enter_only_numerics'])){ echo $rzvy_translangArr['please_enter_only_numerics']; }else{ echo $rzvy_defaultlang['please_enter_only_numerics']; } ?>',
			'please_enter_valid_phone_number_without_country_code' : '<?php if(isset($rzvy_translangArr['please_enter_valid_phone_number_without_country_code'])){ echo $rzvy_translangArr['please_enter_valid_phone_number_without_country_code']; }else{ echo $rzvy_defaultlang['please_enter_valid_phone_number_without_country_code']; } ?>',
			'please_enter_valid_zip' : '<?php if(isset($rzvy_translangArr['please_enter_valid_zip'])){ echo $rzvy_translangArr['please_enter_valid_zip']; }else{ echo $rzvy_defaultlang['please_enter_valid_zip']; } ?>',
			'opps' : '<?php if(isset($rzvy_translangArr['opps'])){ echo $rzvy_translangArr['opps']; }else{ echo $rzvy_defaultlang['opps']; } ?>',
			'something_went_wrong_please_try_again' : '<?php if(isset($rzvy_translangArr['something_went_wrong_please_try_again'])){ echo $rzvy_translangArr['something_went_wrong_please_try_again']; }else{ echo $rzvy_defaultlang['something_went_wrong_please_try_again']; } ?>',
			'maximum_file_upload_size_1_mb' : '<?php if(isset($rzvy_translangArr['maximum_file_upload_size_1_mb'])){ echo $rzvy_translangArr['maximum_file_upload_size_1_mb']; }else{ echo $rzvy_defaultlang['maximum_file_upload_size_1_mb']; } ?>',
			'please_select_a_valid_image_file' : '<?php if(isset($rzvy_translangArr['please_select_a_valid_image_file'])){ echo $rzvy_translangArr['please_select_a_valid_image_file']; }else{ echo $rzvy_defaultlang['please_select_a_valid_image_file']; } ?>',
			'rescheduled' : '<?php if(isset($rzvy_translangArr['rescheduled'])){ echo $rzvy_translangArr['rescheduled']; }else{ echo $rzvy_defaultlang['rescheduled']; } ?>',
			'appointment_rescheduled_successfully' : '<?php if(isset($rzvy_translangArr['appointment_rescheduled_successfully'])){ echo $rzvy_translangArr['appointment_rescheduled_successfully']; }else{ echo $rzvy_defaultlang['appointment_rescheduled_successfully']; } ?>',
			'cancelled' : '<?php if(isset($rzvy_translangArr['cancelled'])){ echo $rzvy_translangArr['cancelled']; }else{ echo $rzvy_defaultlang['cancelled']; } ?>',
			'appointment_cancelled_successfully' : '<?php if(isset($rzvy_translangArr['appointment_cancelled_successfully'])){ echo $rzvy_translangArr['appointment_cancelled_successfully']; }else{ echo $rzvy_defaultlang['appointment_cancelled_successfully']; } ?>',
			'please_enter_old_password' : '<?php if(isset($rzvy_translangArr['please_enter_old_password'])){ echo $rzvy_translangArr['please_enter_old_password']; }else{ echo $rzvy_defaultlang['please_enter_old_password']; } ?>',
			'please_enter_new_password' : '<?php if(isset($rzvy_translangArr['please_enter_new_password'])){ echo $rzvy_translangArr['please_enter_new_password']; }else{ echo $rzvy_defaultlang['please_enter_new_password']; } ?>',
			'please_enter_retype_new_password' : '<?php if(isset($rzvy_translangArr['please_enter_retype_new_password'])){ echo $rzvy_translangArr['please_enter_retype_new_password']; }else{ echo $rzvy_defaultlang['please_enter_retype_new_password']; } ?>',
			'please_enter_minimum_8_characters' : '<?php if(isset($rzvy_translangArr['please_enter_minimum_8_characters'])){ echo $rzvy_translangArr['please_enter_minimum_8_characters']; }else{ echo $rzvy_defaultlang['please_enter_minimum_8_characters']; } ?>',
			'please_enter_maximum_20_characters' : '<?php if(isset($rzvy_translangArr['please_enter_maximum_20_characters'])){ echo $rzvy_translangArr['please_enter_maximum_20_characters']; }else{ echo $rzvy_defaultlang['please_enter_maximum_20_characters']; } ?>',
			'new_password_and_retype_new_password_mismatch' : '<?php if(isset($rzvy_translangArr['new_password_and_retype_new_password_mismatch'])){ echo $rzvy_translangArr['new_password_and_retype_new_password_mismatch']; }else{ echo $rzvy_defaultlang['new_password_and_retype_new_password_mismatch']; } ?>',
			'your_password_changed_successfully' : '<?php if(isset($rzvy_translangArr['your_password_changed_successfully'])){ echo $rzvy_translangArr['your_password_changed_successfully']; }else{ echo $rzvy_defaultlang['your_password_changed_successfully']; } ?>',
			'incorrect_old_password' : '<?php if(isset($rzvy_translangArr['incorrect_old_password'])){ echo $rzvy_translangArr['incorrect_old_password']; }else{ echo $rzvy_defaultlang['incorrect_old_password']; } ?>',
			'changed' : '<?php if(isset($rzvy_translangArr['changed'])){ echo $rzvy_translangArr['changed']; }else{ echo $rzvy_defaultlang['changed']; } ?>',
			'please_enter_first_name' : '<?php if(isset($rzvy_translangArr['please_enter_first_name'])){ echo $rzvy_translangArr['please_enter_first_name']; }else{ echo $rzvy_defaultlang['please_enter_first_name']; } ?>',
			'please_enter_last_name' : '<?php if(isset($rzvy_translangArr['please_enter_last_name'])){ echo $rzvy_translangArr['please_enter_last_name']; }else{ echo $rzvy_defaultlang['please_enter_last_name']; } ?>',
			'please_enter_maximum_50_characters' : '<?php if(isset($rzvy_translangArr['please_enter_maximum_50_characters'])){ echo $rzvy_translangArr['please_enter_maximum_50_characters']; }else{ echo $rzvy_defaultlang['please_enter_maximum_50_characters']; } ?>',
			'please_enter_phone_number' : '<?php if(isset($rzvy_translangArr['please_enter_phone_number'])){ echo $rzvy_translangArr['please_enter_phone_number']; }else{ echo $rzvy_defaultlang['please_enter_phone_number']; } ?>',
			'please_enter_minimum_10_digits' : '<?php if(isset($rzvy_translangArr['please_enter_minimum_10_digits'])){ echo $rzvy_translangArr['please_enter_minimum_10_digits']; }else{ echo $rzvy_defaultlang['please_enter_minimum_10_digits']; } ?>',
			'please_enter_maximum_15_digits' : '<?php if(isset($rzvy_translangArr['please_enter_maximum_15_digits'])){ echo $rzvy_translangArr['please_enter_maximum_15_digits']; }else{ echo $rzvy_defaultlang['please_enter_maximum_15_digits']; } ?>',
			'please_enter_address' : '<?php if(isset($rzvy_translangArr['please_enter_address'])){ echo $rzvy_translangArr['please_enter_address']; }else{ echo $rzvy_defaultlang['please_enter_address']; } ?>',
			'please_enter_city' : '<?php if(isset($rzvy_translangArr['please_enter_city'])){ echo $rzvy_translangArr['please_enter_city']; }else{ echo $rzvy_defaultlang['please_enter_city']; } ?>',
			'please_enter_state' : '<?php if(isset($rzvy_translangArr['please_enter_state'])){ echo $rzvy_translangArr['please_enter_state']; }else{ echo $rzvy_defaultlang['please_enter_state']; } ?>',
			'please_enter_zip' : '<?php if(isset($rzvy_translangArr['please_enter_zip'])){ echo $rzvy_translangArr['please_enter_zip']; }else{ echo $rzvy_defaultlang['please_enter_zip']; } ?>',
			'please_enter_minimum_5_characters' : '<?php if(isset($rzvy_translangArr['please_enter_minimum_5_characters'])){ echo $rzvy_translangArr['please_enter_minimum_5_characters']; }else{ echo $rzvy_defaultlang['please_enter_minimum_5_characters']; } ?>',
			'please_enter_maximum_10_characters' : '<?php if(isset($rzvy_translangArr['please_enter_maximum_10_characters'])){ echo $rzvy_translangArr['please_enter_maximum_10_characters']; }else{ echo $rzvy_defaultlang['please_enter_maximum_10_characters']; } ?>',
			'please_enter_country' : '<?php if(isset($rzvy_translangArr['please_enter_country'])){ echo $rzvy_translangArr['please_enter_country']; }else{ echo $rzvy_defaultlang['please_enter_country']; } ?>',
			'your_profile_updated_successfully' : '<?php if(isset($rzvy_translangArr['your_profile_updated_successfully'])){ echo $rzvy_translangArr['your_profile_updated_successfully']; }else{ echo $rzvy_defaultlang['your_profile_updated_successfully']; } ?>',
			'updated' : '<?php if(isset($rzvy_translangArr['updated'])){ echo $rzvy_translangArr['updated']; }else{ echo $rzvy_defaultlang['updated']; } ?>',
			'please_enter_ticket_title' : '<?php if(isset($rzvy_translangArr['please_enter_ticket_title'])){ echo $rzvy_translangArr['please_enter_ticket_title']; }else{ echo $rzvy_defaultlang['please_enter_ticket_title']; } ?>',
			'please_enter_ticket_description' : '<?php if(isset($rzvy_translangArr['please_enter_ticket_description'])){ echo $rzvy_translangArr['please_enter_ticket_description']; }else{ echo $rzvy_defaultlang['please_enter_ticket_description']; } ?>',
			'added' : '<?php if(isset($rzvy_translangArr['added'])){ echo $rzvy_translangArr['added']; }else{ echo $rzvy_defaultlang['added']; } ?>',
			'support_ticket_generated_successfully' : '<?php if(isset($rzvy_translangArr['support_ticket_generated_successfully'])){ echo $rzvy_translangArr['support_ticket_generated_successfully']; }else{ echo $rzvy_defaultlang['support_ticket_generated_successfully']; } ?>',
			'support_ticket_updated_successfully' : '<?php if(isset($rzvy_translangArr['support_ticket_updated_successfully'])){ echo $rzvy_translangArr['support_ticket_updated_successfully']; }else{ echo $rzvy_defaultlang['support_ticket_updated_successfully']; } ?>',
			'you_want_to_delete_this_support_ticket' : '<?php if(isset($rzvy_translangArr['you_want_to_delete_this_support_ticket'])){ echo $rzvy_translangArr['you_want_to_delete_this_support_ticket']; }else{ echo $rzvy_defaultlang['you_want_to_delete_this_support_ticket']; } ?>',
			'you_cannot_delete_this_support_ticket_you_have_discussion_on_this_support_ticket' : '<?php if(isset($rzvy_translangArr['you_cannot_delete_this_support_ticket_you_have_discussion_on_this_support_ticket'])){ echo $rzvy_translangArr['you_cannot_delete_this_support_ticket_you_have_discussion_on_this_support_ticket']; }else{ echo $rzvy_defaultlang['you_cannot_delete_this_support_ticket_you_have_discussion_on_this_support_ticket']; } ?>',
			'support_ticket_deleted_successfully' : '<?php if(isset($rzvy_translangArr['support_ticket_deleted_successfully'])){ echo $rzvy_translangArr['support_ticket_deleted_successfully']; }else{ echo $rzvy_defaultlang['support_ticket_deleted_successfully']; } ?>',
			'deleted' : '<?php if(isset($rzvy_translangArr['deleted'])){ echo $rzvy_translangArr['deleted']; }else{ echo $rzvy_defaultlang['deleted']; } ?>',
			'are_you_sure' : '<?php if(isset($rzvy_translangArr['are_you_sure'])){ echo $rzvy_translangArr['are_you_sure']; }else{ echo $rzvy_defaultlang['are_you_sure']; } ?>',
			'yes_delete_it' : '<?php if(isset($rzvy_translangArr['yes_delete_it'])){ echo $rzvy_translangArr['yes_delete_it']; }else{ echo $rzvy_defaultlang['yes_delete_it']; } ?>',
			'yes_mark_it' : '<?php if(isset($rzvy_translangArr['yes_mark_it'])){ echo $rzvy_translangArr['yes_mark_it']; }else{ echo $rzvy_defaultlang['yes_mark_it']; } ?>',
			'marked_as_completed' : '<?php if(isset($rzvy_translangArr['marked_as_completed'])){ echo $rzvy_translangArr['marked_as_completed']; }else{ echo $rzvy_defaultlang['marked_as_completed']; } ?>',
			'you_want_to_mark_this_support_ticket_as_complete' : '<?php if(isset($rzvy_translangArr['you_want_to_mark_this_support_ticket_as_complete'])){ echo $rzvy_translangArr['you_want_to_mark_this_support_ticket_as_complete']; }else{ echo $rzvy_defaultlang['you_want_to_mark_this_support_ticket_as_complete']; } ?>',
			'marked_as_completed' : '<?php if(isset($rzvy_translangArr['marked_as_completed'])){ echo $rzvy_translangArr['marked_as_completed']; }else{ echo $rzvy_defaultlang['marked_as_completed']; } ?>',
			'support_ticket_marked_as_completed_successfully' : '<?php if(isset($rzvy_translangArr['support_ticket_marked_as_completed_successfully'])){ echo $rzvy_translangArr['support_ticket_marked_as_completed_successfully']; }else{ echo $rzvy_defaultlang['support_ticket_marked_as_completed_successfully']; } ?>',
			'please_enter_email' : '<?php if(isset($rzvy_translangArr['please_enter_email'])){ echo $rzvy_translangArr['please_enter_email']; }else{ echo $rzvy_defaultlang['please_enter_email']; } ?>',
			'please_enter_valid_email' : '<?php if(isset($rzvy_translangArr['please_enter_valid_email'])){ echo $rzvy_translangArr['please_enter_valid_email']; }else{ echo $rzvy_defaultlang['please_enter_valid_email']; } ?>',
			'your_email_changed_successfully' : '<?php if(isset($rzvy_translangArr['your_email_changed_successfully'])){ echo $rzvy_translangArr['your_email_changed_successfully']; }else{ echo $rzvy_defaultlang['your_email_changed_successfully']; } ?>',
			'exist' : '<?php if(isset($rzvy_translangArr['exist'])){ echo $rzvy_translangArr['exist']; }else{ echo $rzvy_defaultlang['exist']; } ?>',
			'email_already_exist_please_try_to_update_with_not_registered_email' : '<?php if(isset($rzvy_translangArr['email_already_exist_please_try_to_update_with_not_registered_email'])){ echo $rzvy_translangArr['email_already_exist_please_try_to_update_with_not_registered_email']; }else{ echo $rzvy_defaultlang['email_already_exist_please_try_to_update_with_not_registered_email']; } ?>',
			'please_enter_name' : '<?php if(isset($rzvy_translangArr['please_enter_name'])){ echo $rzvy_translangArr['please_enter_name']; }else{ echo $rzvy_defaultlang['please_enter_name']; } ?>',
			'please_enter_review' : '<?php if(isset($rzvy_translangArr['please_enter_review'])){ echo $rzvy_translangArr['please_enter_review']; }else{ echo $rzvy_defaultlang['please_enter_review']; } ?>',
			'submitted_your_review_submitted_successfully' : '<?php if(isset($rzvy_translangArr['submitted_your_review_submitted_successfully'])){ echo $rzvy_translangArr['submitted_your_review_submitted_successfully']; }else{ echo $rzvy_defaultlang['submitted_your_review_submitted_successfully']; } ?>',
			'today' : '<?php if(isset($rzvy_translangArr['today'])){ echo $rzvy_translangArr['today']; }else{ echo $rzvy_defaultlang['today']; } ?>',
			'calendar_view' : '<?php if(isset($rzvy_translangArr['calendar_view'])){ echo $rzvy_translangArr['calendar_view']; }else{ echo $rzvy_defaultlang['calendar_view']; } ?>',
			'month_list_view' : '<?php if(isset($rzvy_translangArr['month_list_view'])){ echo $rzvy_translangArr['month_list_view']; }else{ echo $rzvy_defaultlang['month_list_view']; } ?>',
			'year_list_view' : '<?php if(isset($rzvy_translangArr['year_list_view'])){ echo $rzvy_translangArr['year_list_view']; }else{ echo $rzvy_defaultlang['year_list_view']; } ?>',
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
	
	<?php if (strpos($_SERVER['SCRIPT_NAME'], 'c_profile.php') != false) { ?>
		<?php 
		$rzvy_birthdate_with_year = $obj_settings->get_option('rzvy_birthdate_with_year');
		if($rzvy_birthdate_with_year == "Y"){ ?>
			<script src="<?php echo SITE_URL; ?>includes/front/js/datepicker.year.min.js?<?php echo time(); ?>"></script>
			<script>
			$('#rzvy_profile_dob').datepicker({
				format: "d MM yyyy"
			});
			</script>
		<?php }else{ ?>
			<script src="<?php echo SITE_URL; ?>includes/front/js/datepicker.min.js?<?php echo time(); ?>"></script>
			<script>
			$('#rzvy_profile_dob').datepicker({
				format: "d MM",
				maxViewMode: 1,
				defaultViewDate: {year: <?php echo date('Y'); ?>}
			});
			</script>
		<?php } ?>
	<?php } ?>
	<?php $Rzvy_Hooks->customerFooterIncludes(); ?>
	<script src="<?php echo SITE_URL; ?>includes/vendor/intl-tel-input/js/intlTelInput.js?<?php echo time(); ?>"></script>
	<script src="<?php echo SITE_URL; ?>includes/js/rzvy-customer.js?<?php echo time(); ?>"></script>
	<script src="<?php echo SITE_URL; ?>includes/js/rzvy-set-languages.js?<?php echo time(); ?>"></script>
  </div>
</body>
</html>