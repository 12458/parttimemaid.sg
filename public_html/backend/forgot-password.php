<?php 
/* Include class files */
include(dirname(dirname(__FILE__))."/constants.php");

/* Redirect if user logged in */
if(isset($_SESSION['login_type'])) { 
	?>
	<script>
	window.location.href = "<?php echo SITE_URL; ?>backend/";
	</script>
	<?php 
	exit;
}

include(dirname(dirname(__FILE__))."/classes/class_settings.php");

/* Create object of classes */
$obj_database->check_admin_setup_detail($conn);

$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

$company_name = $obj_settings->get_option("rzvy_company_name");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" type="image/png" href="<?php  echo SITE_URL; ?>includes/images/favicon.ico" />
		<?php 
		$rzvy_seo_ga_code = $obj_settings->get_option('rzvy_seo_ga_code');
		$rzvy_seo_meta_tag = $obj_settings->get_option('rzvy_seo_meta_tag');
		$rzvy_seo_meta_description = $obj_settings->get_option('rzvy_seo_meta_description');
		?>
		<title><?php if($rzvy_seo_meta_tag != ""){ echo $rzvy_seo_meta_tag; }else{ echo $obj_settings->get_option("rzvy_company_name"); } ?></title>
		<?php 
		if($rzvy_seo_meta_description != ''){ 
			?>
			<meta name="description" content="<?php echo $rzvy_seo_meta_description; ?>">
			<?php 
		} 
		?>
		<!-- Bootstrap core CSS-->
		<link href="<?php echo SITE_URL; ?>includes/css/flags.min.css" rel="stylesheet" type="text/css" media="all">
		<link href="<?php echo SITE_URL; ?>includes/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
		<link href="<?php echo SITE_URL; ?>includes/vendor/bootstrap/css/bootstrap-select.min.css"  rel="stylesheet" type="text/css" media="all" />
		<!-- Custom fonts for this template-->
		<link href="<?php echo SITE_URL; ?>includes/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo SITE_URL; ?>includes/vendor/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
		<!-- Custom styles for this template-->
		<link href="<?php echo SITE_URL; ?>includes/css/rzvy-register.css" rel="stylesheet">
		<?php $Rzvy_Hooks->forgetpwdHeaderIncludes(); ?>
		<?php include("bf_css.php"); ?>
		
		<!--------------- FONTS START ----------------->
		<?php 
		$rzvy_fontfamily = $obj_settings->get_option("rzvy_fontfamily");
		if($rzvy_fontfamily == 'Molle'){
			?><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Molle:400i"><?php 
		}else if($rzvy_fontfamily == 'Coda Caption'){
			?><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Coda+Caption:800"><?php 
		}else{
			?><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=<?php echo $rzvy_fontfamily; ?>:300,400,700"><?php 
		}
		?>
		<style>
		html {
			font-family: '<?php echo $rzvy_fontfamily; ?>', sans-serif !important;
		}
		body.rzvy {
			font-family: '<?php echo $rzvy_fontfamily; ?>', sans-serif !important;
		}
		</style>
		<!--------------- FONTS END ----------------->
	</head>
	<body class="rzvy">	
		<!-- Brand and toggle get grouped for better mobile display -->
		<?php include(dirname(dirname(__FILE__))."/header1.php"); ?>
		
		<section class="container rzvy-login-main p-3 mt-5">
			<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4 rzvy-login-form-block p-4 m-1 whitebox">
						<h2 class="text-center"><?php if(isset($rzvy_translangArr['forgot_password'])){ echo $rzvy_translangArr['forgot_password']; }else{ echo $rzvy_defaultlang['forgot_password']; } ?></h2>
						<form id="rzvy_forgot_password_form" name="rzvy_forgot_password_form">
							<div class="form-group mt-3">
								<label for="rzvy_forgot_password_email" class="mb-1"><?php if(isset($rzvy_translangArr['enter_your_email_address_to_reset_your_password'])){ echo $rzvy_translangArr['enter_your_email_address_to_reset_your_password']; }else{ echo $rzvy_defaultlang['enter_your_email_address_to_reset_your_password']; } ?></label>
								<input type="text" class="form-control" id="rzvy_forgot_password_email" name="rzvy_forgot_password_email" placeholder="<?php if(isset($rzvy_translangArr['enter_registered_email'])){ echo $rzvy_translangArr['enter_registered_email']; }else{ echo $rzvy_defaultlang['enter_registered_email']; } ?>" />
								<label id="rzvy-forgot-password-success" class="text-success" style="display:none" ></label>
								<label id="rzvy-forgot-password-error" class="error" style="display:none"></label>
							</div>
							<div class="row">
								<button type="submit" id="rzvy_forgot_password_btn" class="btn btn-success float-right w-100"><?php if(isset($rzvy_translangArr['reset_password'])){ echo $rzvy_translangArr['reset_password']; }else{ echo $rzvy_defaultlang['reset_password']; } ?></button>
							</div>
						</form>
					</div>
					<div class="col-md-4"></div>
				</div>
			</div>
		</section>
		<!-- Bootstrap core JavaScript-->
		<script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery.validate.min.js"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/bootstrap-select.min.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/sweetalert/sweetalert.js"></script>
		<!-- Custom scripts for all pages-->
		<script>
			var generalObj = { 'site_url' : '<?php echo SITE_URL; ?>', 'ajax_url' : '<?php echo AJAX_URL; ?>', 'defaultCountryCode' : '<?php $rzvy_default_country_code = $obj_settings->get_option("rzvy_default_country_code"); if($rzvy_default_country_code != ""){ echo $rzvy_default_country_code; }else{ echo "us"; } ?>',
'please_enter_email' : "<?php if(isset($rzvy_translangArr['please_enter_email'])){ echo $rzvy_translangArr['please_enter_email']; }else{ echo $rzvy_defaultlang['please_enter_email']; } ?>" 
			, 'please_enter_valid_email' : "<?php if(isset($rzvy_translangArr['please_enter_valid_email'])){ echo $rzvy_translangArr['please_enter_valid_email']; }else{ echo $rzvy_defaultlang['please_enter_valid_email']; } ?>" 
			, 'email_already_exist' : "<?php if(isset($rzvy_translangArr['email_already_exist'])){ echo $rzvy_translangArr['email_already_exist']; }else{ echo $rzvy_defaultlang['email_already_exist']; } ?>" 
			, 'please_enter_password' : "<?php if(isset($rzvy_translangArr['please_enter_password'])){ echo $rzvy_translangArr['please_enter_password']; }else{ echo $rzvy_defaultlang['please_enter_password']; } ?>" 
			, 'please_enter_minimum_8_characters' : "<?php if(isset($rzvy_translangArr['please_enter_minimum_8_characters'])){ echo $rzvy_translangArr['please_enter_minimum_8_characters']; }else{ echo $rzvy_defaultlang['please_enter_minimum_8_characters']; } ?>" 
			, 'please_enter_maximum_20_characters' : "<?php if(isset($rzvy_translangArr['please_enter_maximum_20_characters'])){ echo $rzvy_translangArr['please_enter_maximum_20_characters']; }else{ echo $rzvy_defaultlang['please_enter_maximum_20_characters']; } ?>"
			, 'please_enter_retype_new_password' : "<?php if(isset($rzvy_translangArr['please_enter_retype_new_password'])){ echo $rzvy_translangArr['please_enter_retype_new_password']; }else{ echo $rzvy_defaultlang['please_enter_retype_new_password']; } ?>"
			, 'new_password_and_retype_new_password_mismatch' : "<?php if(isset($rzvy_translangArr['new_password_and_retype_new_password_mismatch'])){ echo $rzvy_translangArr['new_password_and_retype_new_password_mismatch']; }else{ echo $rzvy_defaultlang['new_password_and_retype_new_password_mismatch']; } ?>"
			, 'your_password_reset_successfully_try_login_to_enjoy_services' : "<?php if(isset($rzvy_translangArr['your_password_reset_successfully_try_login_to_enjoy_services'])){ echo $rzvy_translangArr['your_password_reset_successfully_try_login_to_enjoy_services']; }else{ echo $rzvy_defaultlang['your_password_reset_successfully_try_login_to_enjoy_services']; } ?>"
			, 'reset_qm' : "<?php if(isset($rzvy_translangArr['reset_qm'])){ echo $rzvy_translangArr['reset_qm']; }else{ echo $rzvy_defaultlang['reset_qm']; } ?>"
			, 'opps' : "<?php if(isset($rzvy_translangArr['opps'])){ echo $rzvy_translangArr['opps']; }else{ echo $rzvy_defaultlang['opps']; } ?>"
			, 'something_went_wrong_please_try_again' : "<?php if(isset($rzvy_translangArr['something_went_wrong_please_try_again'])){ echo $rzvy_translangArr['something_went_wrong_please_try_again']; }else{ echo $rzvy_defaultlang['something_went_wrong_please_try_again']; } ?>"
			, 'reset_password_link_sent_successfully_at_your_registered_email_address' : "<?php if(isset($rzvy_translangArr['reset_password_link_sent_successfully_at_your_registered_email_address'])){ echo $rzvy_translangArr['reset_password_link_sent_successfully_at_your_registered_email_address']; }else{ echo $rzvy_defaultlang['reset_password_link_sent_successfully_at_your_registered_email_address']; } ?>"
			, 'oops_error_occurred_please_try_again' : "<?php if(isset($rzvy_translangArr['oops_error_occurred_please_try_again'])){ echo $rzvy_translangArr['oops_error_occurred_please_try_again']; }else{ echo $rzvy_defaultlang['oops_error_occurred_please_try_again']; } ?>"
			, 'invalid_email_address' : "<?php if(isset($rzvy_translangArr['invalid_email_address'])){ echo $rzvy_translangArr['invalid_email_address']; }else{ echo $rzvy_defaultlang['invalid_email_address']; } ?>"			};
		</script>
		<?php $Rzvy_Hooks->forgetpwdFooterIncludes(); ?>
		<script src="<?php echo SITE_URL; ?>includes/js/rzvy-login.js"></script>
		<script src="<?php echo SITE_URL; ?>includes/js/rzvy-set-languages.js?<?php echo time(); ?>"></script>
	</body>
</html>