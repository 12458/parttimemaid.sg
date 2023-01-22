
<?php 

include(dirname(__FILE__)."/constants.php"); 


$obj_database->check_admin_setup_detail($conn);

/* Include class files */
include(dirname(__FILE__)."/classes/class_settings.php");
/* Create object of classes */
$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

/* Include class files */
include(dirname(__FILE__)."/classes/class_frontend.php");
/* Create object of classes */
$obj_frontend = new rzvy_frontend();
$obj_frontend->conn = $conn; 

$saiframe = '';
if(isset($_GET['if'])){
	$saiframe = '?if=y';  
}

$show_location_selector = "N";
if(!isset($_SESSION["rzvy_location_selector_zipcode"])){
	$show_location_selector = "Y";
}else if($_SESSION["rzvy_location_selector_zipcode"] == ""){
	$show_location_selector = "Y";
}

$rzvy_frontend = $obj_settings->get_option("rzvy_frontend");

$_SESSION['rzvy_customer_detail'] = array();
$_SESSION['rzvy_cart_items'] = array();
$_SESSION['add_to_cart_package'] = array();
$_SESSION['rzvy_cart_parent_category_id'] = "";
$_SESSION['rzvy_cart_category_id'] = "";
$_SESSION['rzvy_cart_service_id'] = "";
$_SESSION['rzvy_cart_service_price'] = 0;
$_SESSION['rzvy_cart_datetime'] = "";
$_SESSION['rzvy_cart_end_datetime'] = "";
$_SESSION['rzvy_cart_freqdiscount_label'] = "";
$_SESSION['rzvy_cart_freqdiscount_key'] = "";
$_SESSION['rzvy_cart_freqdiscount_id'] = "";
$_SESSION['rzvy_cart_subtotal'] = 0;
$_SESSION['rzvy_cart_freqdiscount'] = 0;
$_SESSION['rzvy_cart_coupondiscount'] = 0;
$_SESSION['rzvy_cart_couponid'] = "";
$_SESSION['rzvy_cart_tax'] = 0;
$_SESSION['rzvy_cart_nettotal'] = 0;
$_SESSION['rzvy_referral_discount_amount'] = 0;
$_SESSION['rzvy_applied_ref_customer_id'] = "";
$_SESSION['rzvy_ref_customer_id'] = "";
$_SESSION['rzvy_staff_id'] = "";
$_SESSION['rzvy_cart_partial_deposite'] = 0;
$_SESSION['rzvy_cart_total_addon_duration'] = 0;
$_SESSION['rzvy_lpoint_used'] = 0;
$_SESSION['rzvy_cart_lpoint'] = 0;
$_SESSION['rzvy_lpoint_total'] = 0;
$_SESSION['rzvy_lpoint_left'] = 0;
$_SESSION['rzvy_lpoint_price'] = 0;
$_SESSION['rzvy_lpoint_value'] = 0;
$_SESSION['rzvy_referred_discount_amount'] = 0;
$_SESSION["referralcode_applied"] = "N";
$_SESSION["rzvy_applied_refcode"] = "";
$_SESSION['rzvy_lpoint_checked'] = false;
if(isset($_SESSION['rzvy_package_service'])){ unset($_SESSION['rzvy_package_service']); }
if(isset($_SESSION['rzvy_package_addons'])){ unset($_SESSION['rzvy_package_addons']); }
if(isset($_SESSION['rzvy_package_discount'])){ unset($_SESSION['rzvy_package_discount']); }
if(isset($_SESSION['rzvy_package_credituse'])){ unset($_SESSION['rzvy_package_credituse']); }
if(isset($_SESSION['rzvy_package_credituse_info'])){ unset($_SESSION['rzvy_package_credituse_info']); }
if(isset($_SESSION['rzvy_activepackage_credituse_info'])){ unset($_SESSION['rzvy_activepackage_credituse_info']); }


/* check location selector status */
$rzvy_location_selector_status = $obj_settings->get_option("rzvy_location_selector_status"); 
if($rzvy_location_selector_status == "N" || $rzvy_location_selector_status == ""){ 
	$show_location_selector = "N";
	$_SESSION['rzvy_location_selector_zipcode'] = "N/A";
} 
if(isset($_SESSION["rzvy_location_selector_zipcode"])){
	if($rzvy_location_selector_status == "Y" && ($_SESSION["rzvy_location_selector_zipcode"]=="" && $_SESSION["rzvy_location_selector_zipcode"]!="N/A")){
		$show_location_selector = "Y";
		$_SESSION['rzvy_location_selector_zipcode'] = "";
	}
}

/** zipcode checker **/
if(isset($_SESSION["rzvy_location_selector_zipcode"])){
	if($_SESSION['rzvy_location_selector_zipcode'] != "N/A"){
		$selector_zipcode = $_SESSION["rzvy_location_selector_zipcode"];
		$rzvy_location_selector = $obj_settings->get_option('rzvy_location_selector');
		$exploded_rzvy_location_selector = explode(",", $rzvy_location_selector);
		
		$j=0;
		for($i=0;$i<sizeof($exploded_rzvy_location_selector);$i++){
			if(strtolower($exploded_rzvy_location_selector[$i]) == strtolower($selector_zipcode)){
				$j++;
			}
		}
		if($j==0){
			$show_location_selector = "Y";
		}
	}
}

/** get form fields options **/
$rzvy_en_ff_firstname_status = $obj_settings->get_option('rzvy_en_ff_firstname_status');
$rzvy_en_ff_lastname_status = $obj_settings->get_option('rzvy_en_ff_lastname_status');
$rzvy_en_ff_phone_status = $obj_settings->get_option('rzvy_en_ff_phone_status');
$rzvy_en_ff_address_status = $obj_settings->get_option('rzvy_en_ff_address_status');
$rzvy_en_ff_city_status = $obj_settings->get_option('rzvy_en_ff_city_status');
$rzvy_en_ff_state_status = $obj_settings->get_option('rzvy_en_ff_state_status');
$rzvy_en_ff_country_status = $obj_settings->get_option('rzvy_en_ff_country_status');
$rzvy_en_ff_dob_status = $obj_settings->get_option('rzvy_en_ff_dob_status');
$rzvy_en_ff_notes_status = $obj_settings->get_option('rzvy_en_ff_notes_status');

$rzvy_g_ff_firstname_status = $obj_settings->get_option('rzvy_g_ff_firstname_status');
$rzvy_g_ff_lastname_status = $obj_settings->get_option('rzvy_g_ff_lastname_status');
$rzvy_g_ff_email_status = $obj_settings->get_option('rzvy_g_ff_email_status');
$rzvy_g_ff_phone_status = $obj_settings->get_option('rzvy_g_ff_phone_status');
$rzvy_g_ff_address_status = $obj_settings->get_option('rzvy_g_ff_address_status');
$rzvy_g_ff_city_status = $obj_settings->get_option('rzvy_g_ff_city_status');
$rzvy_g_ff_state_status = $obj_settings->get_option('rzvy_g_ff_state_status');
$rzvy_g_ff_country_status = $obj_settings->get_option('rzvy_g_ff_country_status');
$rzvy_g_ff_dob_status = $obj_settings->get_option('rzvy_g_ff_dob_status');
$rzvy_g_ff_notes_status = $obj_settings->get_option('rzvy_g_ff_notes_status');

/** get form fields required options **/
$rzvy_en_ff_firstname_optional = $obj_settings->get_option('rzvy_en_ff_firstname_optional');
$rzvy_en_ff_lastname_optional = $obj_settings->get_option('rzvy_en_ff_lastname_optional');
$rzvy_en_ff_phone_optional = $obj_settings->get_option('rzvy_en_ff_phone_optional');
$rzvy_en_ff_address_optional = $obj_settings->get_option('rzvy_en_ff_address_optional');
$rzvy_en_ff_city_optional = $obj_settings->get_option('rzvy_en_ff_city_optional');
$rzvy_en_ff_state_optional = $obj_settings->get_option('rzvy_en_ff_state_optional');
$rzvy_en_ff_country_optional = $obj_settings->get_option('rzvy_en_ff_country_optional');
$rzvy_en_ff_dob_optional = $obj_settings->get_option('rzvy_en_ff_dob_optional');
$rzvy_en_ff_notes_optional = $obj_settings->get_option('rzvy_en_ff_notes_optional');

$rzvy_g_ff_firstname_optional = $obj_settings->get_option('rzvy_g_ff_firstname_optional');
$rzvy_g_ff_lastname_optional = $obj_settings->get_option('rzvy_g_ff_lastname_optional');
$rzvy_g_ff_email_optional = $obj_settings->get_option('rzvy_g_ff_email_optional');
$rzvy_g_ff_phone_optional = $obj_settings->get_option('rzvy_g_ff_phone_optional');
$rzvy_g_ff_address_optional = $obj_settings->get_option('rzvy_g_ff_address_optional');
$rzvy_g_ff_city_optional = $obj_settings->get_option('rzvy_g_ff_city_optional');
$rzvy_g_ff_state_optional = $obj_settings->get_option('rzvy_g_ff_state_optional');
$rzvy_g_ff_country_optional = $obj_settings->get_option('rzvy_g_ff_country_optional'); 
$rzvy_g_ff_dob_optional = $obj_settings->get_option('rzvy_g_ff_dob_optional'); 
$rzvy_g_ff_notes_optional = $obj_settings->get_option('rzvy_g_ff_notes_optional'); 

$rzvy_ff_phone_min = $obj_settings->get_option('rzvy_ff_phone_min'); 
$rzvy_ff_phone_max = $obj_settings->get_option('rzvy_ff_phone_max'); 

/* Check Zip Codes */
$rzvy_location_selector = $obj_settings->get_option('rzvy_location_selector');
$exploded_rzvy_location_selector = array();
if(isset($rzvy_location_selector) && trim($rzvy_location_selector)!=''){
	$exploded_rzvy_location_selector = explode(",", $rzvy_location_selector);
}

$rzvy_booking_first_selection_as = $obj_settings->get_option("rzvy_booking_first_selection_as");
$rzvy_price_display = $obj_settings->get_option("rzvy_price_display");
$rzvy_success_modal_booking = $obj_settings->get_option("rzvy_success_modal_booking");
$rzvy_customer_calendars = $obj_settings->get_option("rzvy_customer_calendars");

$rzvy_currency_symbol = $obj_settings->get_option('rzvy_currency_symbol');
$rzvy_currency_position = $obj_settings->get_option('rzvy_currency_position');
$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');

$currencyB = $rzvy_currency_symbol.' ';
$currencyA = '';
if($rzvy_currency_position=='A'){
	$currencyB = '';
	$currencyA= ' '.$rzvy_currency_symbol;
}

/* Campaign ID Via URL Share */	
if(isset($_GET['campid']) && $_GET['campid']!='' && is_numeric($_GET['campid'])){
	$_SESSION['campaignid'] = $_GET['campid'];
}

/* Coupon Code Via URL Share */
$urlccode = "";
if(isset($_GET['promocode']) && $_GET['promocode'] != ""){
	$urlccode = $_GET['promocode'];
}

/* Referral Code Via URL Share */	
$urlrefcode = "";
if(isset($_GET['ref']) && $_GET['ref'] != ""){
	if(strlen($_GET['ref']) == 8){
		$check_referral_code = $obj_frontend->check_referral_code($_GET['ref']);
		if(mysqli_num_rows($check_referral_code)>0){
			$data = mysqli_fetch_array($check_referral_code);
			if(isset($_SESSION["customer_id"])){
				if($data["id"] == $_SESSION["customer_id"]){
					$_SESSION['rzvy_ref_customer_id'] = "";
					$_SESSION["referralcode_applied"] = "O";
					$_SESSION["rzvy_applied_ref_customer_id"] = "";
					$_SESSION["rzvy_applied_refcode"] = "";
				}else{
					/** check for first booking **/
					$check_referral_firstbooking = $obj_frontend->check_referral_firstbooking($_SESSION["customer_id"]);
					if(mysqli_num_rows($check_referral_firstbooking)==0){
						$_SESSION['rzvy_ref_customer_id'] = $data["id"];
						$_SESSION["referralcode_applied"] = "Y";
						$urlrefcode = $_GET['ref'];
						$_SESSION["rzvy_applied_ref_customer_id"] = $urlrefcode;
						$_SESSION["rzvy_applied_refcode"] = $urlrefcode;
					}else{
						$_SESSION['rzvy_ref_customer_id'] = "";
						$_SESSION["referralcode_applied"] = "F";
						$_SESSION["rzvy_applied_ref_customer_id"] = "";
						$_SESSION["rzvy_applied_refcode"] = "";
					}
				}
			}else{
				$_SESSION['rzvy_ref_customer_id'] = $data["id"];
				$_SESSION["referralcode_applied"] = "Y";
				$urlrefcode = $_GET['ref'];
				$_SESSION["rzvy_applied_ref_customer_id"] = $urlrefcode;
				$_SESSION["rzvy_applied_refcode"] = $urlrefcode;
			}
		}else{
			$_SESSION['rzvy_ref_customer_id'] = "";
			$_SESSION["referralcode_applied"] = "N";
			$_SESSION["rzvy_applied_ref_customer_id"] = "";
			$_SESSION["rzvy_applied_refcode"] = "";
		}
	}else{
		$_SESSION['rzvy_ref_customer_id'] = "";
		$_SESSION["referralcode_applied"] = "N";
		$_SESSION["rzvy_applied_ref_customer_id"] = "";
		$_SESSION["rzvy_applied_refcode"] = "";
	}
}
$rzvy_book_with_datetime = $obj_settings->get_option("rzvy_book_with_datetime"); 
if($rzvy_book_with_datetime != "Y"){
	$_SESSION['rzvy_cart_datetime'] = date("Y-m-d 09:00:00");
	$_SESSION['rzvy_cart_end_datetime'] = date("Y-m-d 10:00:00");
}

$rzvy_stepview_alignment = $obj_settings->get_option("rzvy_stepview_alignment"); 
if($rzvy_stepview_alignment == "center"){
	$alignmentClass = "justify-content-center";
	$labelAlignmentClass = "class='d-flex flex-wrap justify-content-center'";
	$labelAlignmentClassName = "d-flex flex-wrap justify-content-center";
	$inputAlignment = "text-center";
}else if($rzvy_stepview_alignment == "right"){
	$alignmentClass = "justify-content-end";
	$labelAlignmentClass = "class='d-flex flex-wrap justify-content-end'";
	$labelAlignmentClassName = "d-flex flex-wrap justify-content-end";
	$inputAlignment = "text-right";
}else{
	$alignmentClass = "";
	$labelAlignmentClass = "";
	$labelAlignmentClassName = "";
	$inputAlignment = "";
}

$rzvy_coupon_systemcheck = '<style>.rzvy_coupon_system{display:none;}</style>';

?>
<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta http-equiv="cache-control" content="no-cache" />

        <meta http-equiv="Pragma" content="no-cache" />

        <meta http-equiv="Expires" content="-1" />

        <link rel="shortcut icon" type="image/png" href="<?php echo SITE_URL; ?>includes/images/favicon.ico" />



        <?php

        $rzvy_seo_ga_code = $obj_settings->get_option('rzvy_seo_ga_code');

        $rzvy_seo_meta_tag = $obj_settings->get_option('rzvy_seo_meta_tag');

        $rzvy_seo_meta_description = $obj_settings->get_option('rzvy_seo_meta_description');

        $rzvy_seo_og_meta_tag = $obj_settings->get_option('rzvy_seo_og_meta_tag');

        $rzvy_seo_og_tag_type = $obj_settings->get_option('rzvy_seo_og_tag_type');

        $rzvy_seo_og_tag_url = $obj_settings->get_option('rzvy_seo_og_tag_url');

        $rzvy_seo_og_tag_image = $obj_settings->get_option('rzvy_seo_og_tag_image');

        ?>



        <title><?php

            if ($rzvy_seo_meta_tag != "") {

                echo $rzvy_seo_meta_tag;

            } else {

                echo $obj_settings->get_option("rzvy_company_name");

            }

            ?></title>



        <?php

        if ($rzvy_seo_meta_description != '') {

            ?>

            <meta name="description" content="<?php echo $rzvy_seo_meta_description; ?>">

            <?php

        }

        if ($rzvy_seo_og_meta_tag != '') {

            ?>

            <meta property="og:title" content="<?php echo $rzvy_seo_og_meta_tag; ?>" />

            <?php

        }

        if ($rzvy_seo_og_tag_type != '') {

            ?>

            <meta property="og:type" content="<?php echo $rzvy_seo_og_tag_type; ?>" />

            <?php

        }

        if ($rzvy_seo_og_tag_url != '') {

            ?>

            <meta property="og:url" content="<?php echo $rzvy_seo_og_tag_url; ?>" />

            <?php

        }

        if ($rzvy_seo_og_tag_image != '' && file_exists("uploads/images/" . $rzvy_seo_og_tag_image)) {

            ?>

            <meta property="og:image" content="<?php echo SITE_URL; ?>uploads/images/<?php echo $rzvy_seo_og_tag_image; ?>" />

            <?php

        }

        if ($rzvy_seo_ga_code != '') {

            ?>

            <script data-name="googleAnalytics" async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $rzvy_seo_ga_code; ?>"></script>

            <script data-name="googleAnalytics">

                window.dataLayer = window.dataLayer || [];

                function gtag() {

                    dataLayer.push(arguments);

                }

                gtag('js', new Date());

                gtag('config', '<?php echo $rzvy_seo_ga_code; ?>');

            </script>

            <?php

        }

        $rzvy_hotjar_tracking_code = $obj_settings->get_option('rzvy_hotjar_tracking_code');

        if ($rzvy_hotjar_tracking_code != '') {

            ?>

            <script data-name="hotjarAnalytics">

                (function (h, o, t, j, a, r) {

                    h.hj = h.hj || function () {

                        (h.hj.q = h.hj.q || []).push(arguments)

                    };

                    h._hjSettings = {hjid:<?php echo $rzvy_hotjar_tracking_code; ?>, hjsv: 6};

                    a = o.getElementsByTagName('head')[0];

                    r = o.createElement('script');

                    r.async = 1;

                    r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;

                    a.appendChild(r);

                })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');

            </script>

            <?php

        }

        $rzvy_fbpixel_tracking_code = $obj_settings->get_option('rzvy_fbpixel_tracking_code');

        if ($rzvy_fbpixel_tracking_code != '') {

            ?>

            <!-- Facebook Pixel Code -->

            <script data-name="facebookPixelAnalytics">

                !function (f, b, e, v, n, t, s)

                {

                    if (f.fbq)

                        return;

                    n = f.fbq = function () {

                        n.callMethod ?

                                n.callMethod.apply(n, arguments) : n.queue.push(arguments)

                    };

                    if (!f._fbq)

                        f._fbq = n;

                    n.push = n;

                    n.loaded = !0;

                    n.version = '2.0';

                    n.queue = [];

                    t = b.createElement(e);

                    t.async = !0;

                    t.src = v;

                    s = b.getElementsByTagName(e)[0];

                    s.parentNode.insertBefore(t, s)

                }(window, document, 'script',

                        'https://connect.facebook.net/en_US/fbevents.js');

                fbq('init', '<?php echo $rzvy_fbpixel_tracking_code; ?>');

                fbq('track', 'PageView');

            </script>

            <noscript>

        <img height="1" width="1" style="display:none" 

             src="https://www.facebook.com/tr?id=<?php echo $rzvy_fbpixel_tracking_code; ?>&ev=PageView&noscript=1"/>

        </noscript>

        <!-- End Facebook Pixel Code -->

        <?php

    }

    $rzvy_custom_css_bookingform = $obj_settings->get_option("rzvy_custom_css_bookingform");

    if ($rzvy_custom_css_bookingform != '') {

        echo '<style>' . $rzvy_custom_css_bookingform . '</style>';

    }

    ?> 



    <link href="<?php echo SITE_URL; ?>includes/css/flags.min.css" rel="stylesheet" type="text/css" media="all">

    <link href="<?php echo SITE_URL; ?>includes/css/jquery.datetimepicker.min.css" rel="stylesheet" type="text/css" media="all">

    <link href="<?php echo SITE_URL; ?>includes/css/owl.carousel.min.css" rel="stylesheet" type="text/css" media="all">

    <link href="<?php echo SITE_URL; ?>includes/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">

    <link href="<?php echo SITE_URL; ?>includes/vendor/bootstrap/css/bootstrap-select.min.css"  rel="stylesheet" type="text/css" media="all" />

    <link href="<?php echo SITE_URL; ?>includes/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all"/>

    <link href="<?php echo SITE_URL; ?>includes/front/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css" media="all"/>

    <link href="<?php echo SITE_URL; ?>includes/vendor/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" media="all"/>

    <link href="<?php echo SITE_URL; ?>includes/vendor/intl-tel-input/css/intlTelInput.css" rel="stylesheet" type="text/css" media="all" />

    <link href="<?php echo SITE_URL; ?>includes/front/css/rzvy-front-calendar-style.css" rel="stylesheet" type="text/css" media="all"/>

    <link href="<?php echo SITE_URL; ?>includes/front/css/rzvy-front-style.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="all"/>





    <!-- Bootstrap core JavaScript and Page level plugin JavaScript-->

    <script src="<?php echo SITE_URL; ?>includes/front/js/jquery-3.2.1.min.js?<?php echo time(); ?>"></script>

    <script src="<?php echo SITE_URL; ?>includes/front/js/popper.min.js?<?php echo time(); ?>"></script>

    <script src="<?php echo SITE_URL; ?>includes/front/js/bootstrap.min.js?<?php echo time(); ?>"></script>

    <script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/bootstrap-select.min.js?<?php echo time(); ?>"></script>

    <script src="<?php echo SITE_URL; ?>includes/front/js/slick.min.js?<?php echo time(); ?>"></script>



    <script src="<?php echo SITE_URL; ?>includes/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo SITE_URL; ?>includes/js/owl.carousel.min.js"></script>



    <script src="<?php echo SITE_URL; ?>includes/js/rzvy-common-front.js?<?php echo time(); ?>"></script>

    <?php

    $rzvy_birthdate_with_year = $obj_settings->get_option('rzvy_birthdate_with_year');

    if ($rzvy_birthdate_with_year == "Y") {

        ?>

        <script src="<?php echo SITE_URL; ?>includes/js/jquery.datetimepicker.full.min.js"></script>

        <script>

                $(document).ready(function () {

                    $('.datepicker').datetimepicker({

                        timepicker: false,

                        format: "d/m/Y"

                    });

                    $.datetimepicker.setLocale('<?php echo $selectedlangcode; ?>');

                });

        </script>

    <?php } else { ?>

        <script src="<?php echo SITE_URL; ?>includes/js/jquery.datetimepicker.full.min.js"></script>

        <script>

                $(document).ready(function () {

                    $('.datepicker').datetimepicker({

                        timepicker: false,

                        format: "d/m",

                        maxViewMode: 1,

                        defaultViewDate: {year: <?php echo date('Y'); ?>}

                    });

                    $.datetimepicker.setLocale('<?php echo $selectedlangcode; ?>');

                });



        </script>

    <?php } ?>



    <?php /* ?><script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery-ui.js?<?php echo time(); ?>"></script><?php */ ?>

    <script src="<?php echo SITE_URL; ?>includes/vendor/sweetalert/sweetalert.js?<?php echo time(); ?>"></script>

    <script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery.validate.min.js?<?php echo time(); ?>"></script>



    <?php include(dirname(__FILE__) . "/includes/lib/rzvy_lang_objects.php"); ?>

    <?php include(dirname(__FILE__) . "/includes/vendor/rzvyconcent/config.php"); ?>

    <?php if ($obj_settings->get_option("rzvy_authorizenet_payment_status") == "Y" || $obj_settings->get_option("rzvy_twocheckout_payment_status") == "Y") { ?>

        <script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery.payment.min.js?<?php echo time(); ?>" type="text/javascript"></script>

        <script>

                $(document).ready(function () {

                    /** card payment validation **/

                    $('#rzvy-cardnumber').payment('formatCardNumber');

                    $('#rzvy-cardcvv').payment('formatCardCVC');

                    $('#rzvy-cardexmonth').payment('restrictNumeric');

                    $('#rzvy-cardexyear').payment('restrictNumeric');

                });

        </script>

    <?php } ?>



    <?php if ($obj_settings->get_option('rzvy_twocheckout_payment_status') == 'Y') { ?>

        <script src="https://www.2checkout.com/checkout/api/2co.min.js" type="text/javascript"></script>	

    <?php } ?>

    <?php

    $rzvy_ty_link = "";

    $rzvy_thankyou_page_url = $obj_settings->get_option('rzvy_thankyou_page_url');

    if ($rzvy_thankyou_page_url != "") {

        $rzvy_ty_link = $rzvy_thankyou_page_url . $saiframe;

    } else {

        $rzvy_ty_link = SITE_URL . "thankyou.php" . $saiframe;

    }

    ?>

    <!-- Custom scripts -->

    <script>

                var generalObj = {'site_url': '<?php echo SITE_URL; ?>', 'ajax_url': '<?php echo AJAX_URL; ?>', 'ty_link': '<?php echo $rzvy_ty_link; ?>', 'twocheckout_status': '<?php echo $obj_settings->get_option('rzvy_twocheckout_payment_status'); ?>', 'twocheckout_sid': '<?php echo $obj_settings->get_option('rzvy_twocheckout_seller_id'); ?>', 'twocheckout_pkey': '<?php echo $obj_settings->get_option('rzvy_twocheckout_publishable_key'); ?>', 'stripe_status': '<?php echo $obj_settings->get_option('rzvy_stripe_payment_status'); ?>', 'stripe_pkey': '<?php echo $obj_settings->get_option('rzvy_stripe_publishable_key'); ?>', 'location_selector': '<?php echo $show_location_selector; ?>', 'minimum_booking_amount': '<?php echo $obj_settings->get_option('rzvy_minimum_booking_amount'); ?>', 'endslot_status': '<?php echo $obj_settings->get_option('rzvy_endtimeslot_selection_status'); ?>', 'single_category_status': '<?php echo $obj_settings->get_option('rzvy_single_category_autotrigger_status'); ?>', 'defaultCountryCode': '<?php

    $rzvy_default_country_code = $obj_settings->get_option("rzvy_default_country_code");

    if ($rzvy_default_country_code != "") {

        echo $rzvy_default_country_code;

    } else {

        echo "us";

    }

    ?>', 'single_service_status': '<?php echo $obj_settings->get_option('rzvy_single_service_autotrigger_status'); ?>', 'booking_first_selection_as': '<?php

    if ($rzvy_booking_first_selection_as == "allservices") {

        echo "service";

    } else {

        echo "category";

    }

    ?>', 'auto_scroll_each_module_status': '<?php echo $obj_settings->get_option('rzvy_auto_scroll_each_module_status'); ?>', 'single_staff_showhide_status': '<?php echo $obj_settings->get_option('rzvy_single_staff_showhide_status'); ?>', 'book_with_datetime': '<?php echo $rzvy_book_with_datetime; ?>', 'rzvy_success_modal_booking': '<?php echo $rzvy_success_modal_booking; ?>', 'rzvy_customer_calendars': '<?php echo $rzvy_customer_calendars; ?>', 'rzvy_todate': '<?php echo date("Y-m-d"); ?>'};



                var formfieldsObj = {'en_ff_phone_status': '<?php echo $rzvy_en_ff_phone_status; ?>', 'g_ff_phone_status': '<?php echo $rzvy_g_ff_phone_status; ?>', 'en_ff_firstname': '<?php echo $rzvy_en_ff_firstname_optional; ?>', 'en_ff_lastname': '<?php echo $rzvy_en_ff_lastname_optional; ?>', 'en_ff_phone': '<?php echo $rzvy_en_ff_phone_optional; ?>', 'en_ff_address': '<?php echo $rzvy_en_ff_address_optional; ?>', 'en_ff_city': '<?php echo $rzvy_en_ff_city_optional; ?>', 'en_ff_state': '<?php echo $rzvy_en_ff_state_optional; ?>', 'en_ff_country': '<?php echo $rzvy_en_ff_country_optional; ?>', 'g_ff_firstname': '<?php echo $rzvy_g_ff_firstname_optional; ?>', 'g_ff_lastname': '<?php echo $rzvy_g_ff_lastname_optional; ?>', 'g_ff_phone': '<?php echo $rzvy_g_ff_phone_optional; ?>', 'g_ff_address': '<?php echo $rzvy_g_ff_address_optional; ?>', 'g_ff_city': '<?php echo $rzvy_g_ff_city_optional; ?>', 'g_ff_state': '<?php echo $rzvy_g_ff_state_optional; ?>', 'g_ff_country': '<?php echo $rzvy_g_ff_country_optional; ?>',

                    'en_ff_dob': '<?php echo $rzvy_en_ff_dob_optional; ?>',

                    'en_ff_notes': '<?php echo $rzvy_en_ff_notes_optional; ?>',

                    'g_ff_dob': '<?php echo $rzvy_g_ff_dob_optional; ?>',

                    'g_ff_notes': '<?php echo $rzvy_g_ff_notes_optional; ?>',

                    'g_ff_email': '<?php echo $rzvy_g_ff_email_optional; ?>', 'ff_phone_min': '<?php echo $rzvy_ff_phone_min; ?>', 'ff_phone_max': '<?php echo $rzvy_ff_phone_max; ?>'};

    </script>

    <script src="<?php echo SITE_URL; ?>includes/vendor/intl-tel-input/js/intlTelInput.js?<?php echo time(); ?>"></script>		

    <?php $Rzvy_Hooks->onepageHeaderIncludes(); ?>

    <?php include("backend/bf_css.php"); ?>



    <!--------------- FONTS START ----------------->

    <?php

    $rzvy_fontfamily = $obj_settings->get_option("rzvy_fontfamily");

    if ($rzvy_fontfamily == 'Molle') {

        ?><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Molle:400i"><?php

    } else if ($rzvy_fontfamily == 'Coda Caption') {

        ?><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Coda+Caption:800"><?php

    } else {

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

<body class="rzvy"  onscroll="parent.postMessage(document.body.scrollHeight, '*');" onload="parent.postMessage(document.body.scrollHeight, '*');" >

    <?php include(dirname(__FILE__) . "/header2.php"); ?>

      <main class="form-style-two rzvy-booking-detail-body">
	  
		<div class="container">    
		  <div class="row content">
			<div class="col-sm-12 sidenav">
				<p>
				
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	

				<br><br>
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	
				
				
				
				<br><br>				
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	
                </p>				
			  </div>
			  </div>
		</div>	  
	  
      </main>

     

    <?php include(dirname(__FILE__) . "/footer.php"); ?>

    <!-- Location Selector Modal END -->

    <?php if ($obj_settings->get_option('rzvy_stripe_payment_status') == 'Y') { ?>

        <script src="https://js.stripe.com/v3/"></script>

    <?php } ?>

<?php $Rzvy_Hooks->onepageFooterIncludes(); ?>

    <script src="<?php echo SITE_URL; ?>includes/front/js/rzvy-front-jquery.js?<?php echo time(); ?>"></script>

    <script src="<?php echo SITE_URL; ?>includes/js/rzvy-set-languages.js?<?php echo time(); ?>"></script>

</body>

</html>