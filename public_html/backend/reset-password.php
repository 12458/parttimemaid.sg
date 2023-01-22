<?php 
/* Include class files */
include(dirname(dirname(__FILE__))."/constants.php");
include(dirname(dirname(__FILE__))."/classes/class_settings.php");

if(!isset($_GET['code'])){
	?>
	<script>
	window.location.href = "<?php echo SITE_URL; ?>backend/";
	</script>
	<?php 
	exit;
}else if($_GET['code'] == ""){
	?>
	<script>
	window.location.href = "<?php echo SITE_URL; ?>backend/";
	</script>
	<?php 
	exit;
}

/* Create object of classes */
$obj_database->check_admin_setup_detail($conn);

$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

/** Start decoding reset password code **/
$current_times = date('Y-m-d H:i:s');
$decrypt_code = base64_decode($_GET['code']);
$explode=explode("#####",$decrypt_code);
$decrypt_id = base64_decode($explode[0]);
$email=$decrypt_id;
$_SESSION["rzvy_rp_cemail"] = $email;
$url_time=$explode[1];
$current_time=strtotime($current_times);
/** END **/

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
		<link href="<?php echo SITE_URL; ?>includes/css/flags.min.css" rel="stylesheet" type="text/css" media="all">
		<link href="<?php echo SITE_URL; ?>includes/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
		<link href="<?php echo SITE_URL; ?>includes/vendor/bootstrap/css/bootstrap-select.min.css"  rel="stylesheet" type="text/css" media="all" />
		<!-- Custom fonts for this template-->
		<link href="<?php echo SITE_URL; ?>includes/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo SITE_URL; ?>includes/vendor/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
		<!-- Custom styles for this template-->
		<link href="<?php echo SITE_URL; ?>includes/css/rzvy-register.css" rel="stylesheet">
		<?php $Rzvy_Hooks->resetpwdHeaderIncludes(); ?>
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
		
		<section class="container rzvy-login-main py-3">
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4 rzvy-login-form-block p-4 whitebox">
						<h2 class="text-center"><?php if(isset($rzvy_translangArr['reset_password'])){ echo $rzvy_translangArr['reset_password']; }else{ echo $rzvy_defaultlang['reset_password']; } ?></h2>
						<form id="rzvy_reset_password_form" name="rzvy_reset_password_form">
							<div class="form-group">
								<label for="rzvy_reset_new_password"><?php if(isset($rzvy_translangArr['new_password'])){ echo $rzvy_translangArr['new_password']; }else{ echo $rzvy_defaultlang['new_password']; } ?></label>
								<input type="password" class="form-control" id="rzvy_reset_new_password" name="rzvy_reset_new_password" placeholder="<?php if(isset($rzvy_translangArr['enter_new_password'])){ echo $rzvy_translangArr['enter_new_password']; }else{ echo $rzvy_defaultlang['enter_new_password']; } ?>" value="" />
							</div>
							<div class="form-group">
								<label for="rzvy_reset_retype_new_password"><?php if(isset($rzvy_translangArr['retype_new_password'])){ echo $rzvy_translangArr['retype_new_password']; }else{ echo $rzvy_defaultlang['retype_new_password']; } ?></label>
								<input type="password" class="form-control" id="rzvy_reset_retype_new_password" name="rzvy_reset_retype_new_password" placeholder="<?php if(isset($rzvy_translangArr['enter_retype_new_password'])){ echo $rzvy_translangArr['enter_retype_new_password']; }else{ echo $rzvy_defaultlang['enter_retype_new_password']; } ?>" value="" />
								<?php if($current_time > $url_time){ ?><label id="rzvy-reset-password-error" class="error"><?php if(isset($rzvy_translangArr['your_reset_password_link_expired'])){ echo $rzvy_translangArr['your_reset_password_link_expired']; }else{ echo $rzvy_defaultlang['your_reset_password_link_expired']; } ?></label><?php } ?>
							</div>
							<div class="row mt-2">
								<?php if($current_time > $url_time){ ?>
									<button type="button" class="btn btn-success float-right w-100 rzvy_reset_password_btn"><?php if(isset($rzvy_translangArr['reset_password'])){ echo $rzvy_translangArr['reset_password']; }else{ echo $rzvy_defaultlang['reset_password']; } ?></button>
								<?php }else{ ?>
									<button type="button" id="rzvy_reset_password_btn" class="btn btn-success float-right w-100 rzvy_reset_password_btn"><?php if(isset($rzvy_translangArr['reset_password'])){ echo $rzvy_translangArr['reset_password']; }else{ echo $rzvy_defaultlang['reset_password']; } ?></button>
								<?php } ?>
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
			var generalObj = { 'site_url' : '<?php echo SITE_URL; ?>', 'ajax_url' : '<?php echo AJAX_URL; ?>', 'defaultCountryCode' : '<?php $rzvy_default_country_code = $obj_settings->get_option("rzvy_default_country_code"); if($rzvy_default_country_code != ""){ echo $rzvy_default_country_code; }else{ echo "us"; } ?>', 'please_enter_email' : "<?php if(isset($rzvy_translangArr['please_enter_email'])){ echo $rzvy_translangArr['please_enter_email']; }else{ echo $rzvy_defaultlang['please_enter_email']; } ?>" 
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
			, 'invalid_email_address' : "<?php if(isset($rzvy_translangArr['invalid_email_address'])){ echo $rzvy_translangArr['invalid_email_address']; }else{ echo $rzvy_defaultlang['invalid_email_address']; } ?>" };
		</script>
		<?php $Rzvy_Hooks->resetpwdFooterIncludes(); ?>
		<script src="<?php echo SITE_URL; ?>includes/js/rzvy-login.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/js/rzvy-set-languages.js?<?php echo time(); ?>"></script>
	</body>
</html>