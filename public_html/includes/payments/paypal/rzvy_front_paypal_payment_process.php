<?php ob_start();/* Include class files */include(dirname(dirname(dirname(dirname(__FILE__))))."/constants.php");include(dirname(dirname(dirname(dirname(__FILE__))))."/classes/class_frontend.php");include(dirname(dirname(dirname(dirname(__FILE__))))."/classes/class_settings.php");include("rzvy_paypal_express_checkout.php");/* Create object of classes */$obj_frontend = new rzvy_frontend();$obj_frontend->conn = $conn;$obj_settings = new rzvy_settings();$obj_settings->conn = $conn;$rzvy_paypal_guest_payment = $obj_settings->get_option('rzvy_paypal_guest_payment');$rzvy_paypal_api_username = urlencode($obj_settings->get_option('rzvy_paypal_api_username'));$rzvy_paypal_api_password = urlencode($obj_settings->get_option('rzvy_paypal_api_password'));$rzvy_paypal_signature = urlencode($obj_settings->get_option('rzvy_paypal_signature'));$rzvy_currency = $obj_settings->get_option('rzvy_currency');$rzvy_company_logo = $obj_settings->get_option('rzvy_company_logo');$obj_frontend->category_id = $_SESSION['rzvy_cart_category_id'];$obj_frontend->service_id = $_SESSION['rzvy_cart_service_id'];$category_title = $obj_frontend->readone_category_name();$service_title = $obj_frontend->readone_service_name();$paypaltestmode = "off";$version = urlencode('109.0');$paypal_return_url = urlencode(SITE_URL.'includes/payments/paypal/rzvy_front_paypal_payment_process.php');$paypal_cancel_url = urlencode(SITE_URL);$currency_code = $rzvy_currency;$payment_action = urlencode("SALE");$locale_code = 'US';$company_logo = $rzvy_company_logo;if($company_logo!='') {		$site_logo = SITE_URL."uploads/images/".$rzvy_company_logo;}else{	$site_logo='';}$border_color = '343a40';$allow_note = 1;$obj_rzvy_paypal = new rzvy_paypal();if($paypaltestmode=='off'){	$obj_rzvy_paypal->mode = '';  /* leave empty for 'Live' mode */}else{	$obj_rzvy_paypal->mode = 'SANDBOX'; }	/*set basic name and value pairs for curl post*/$basic_NVP = array(				'VERSION'=>$version,				'USER'=>$rzvy_paypal_api_username,				'PWD'=>$rzvy_paypal_api_password,				'SIGNATURE'=>$rzvy_paypal_signature,				'RETURNURL'=>$paypal_return_url,				'CANCELURL'=>$paypal_cancel_url,				'PAYMENTREQUEST_0_CURRENCYCODE'=>$currency_code,				'NOSHIPPING'=>1,				'PAYMENTREQUEST_0_PAYMENTACTION'=>$payment_action,				'LOCALECODE'=>$locale_code,				'CARTBORDERCOLOR'=>$border_color,				'LOGOIMG'=>$site_logo,				'ALLOWNOTE'=>1			);  if($rzvy_paypal_guest_payment=='on'){	$basic_NVP['SOLUTIONTYPE']='Sole';	$basic_NVP['LANDINGPAGE']='Billing';}foreach($basic_NVP as $key => $value) {  $obj_rzvy_paypal->pv .= "&$key=$value";}$cart_item_counter=0;	$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_NAME$cart_item_counter=$service_title";$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_DESC$cart_item_counter=$category_title for $service_title on ".$_SESSION['rzvy_cart_datetime']." to ".$_SESSION['rzvy_cart_end_datetime']; $obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_AMT$cart_item_counter=".$_SESSION['rzvy_cart_subtotal'];		$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_QTY$cart_item_counter=1";			$cart_item_counter++;if(($_SESSION["rzvy_lpoint_checked"] == "true" || $_SESSION["rzvy_lpoint_checked"] == "on") && $_SESSION['rzvy_cart_lpoint_price']>0){	$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_NAME$cart_item_counter='Loyalty Points'";						$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_DESC$cart_item_counter='Loyalty Points'";								$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_AMT$cart_item_counter=-".$_SESSION['rzvy_cart_lpoint_price'];	$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_QTY$cart_item_counter=1";}				$cart_item_counter++;if(is_numeric($_SESSION['rzvy_cart_freqdiscount']) && $_SESSION['rzvy_cart_freqdiscount']>0){			$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_NAME$cart_item_counter='Frequently Discount - ".$_SESSION['rzvy_cart_freqdiscount_label']."'";						$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_DESC$cart_item_counter='Frequently Discount - ".$_SESSION['rzvy_cart_freqdiscount_label']."'";								$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_AMT$cart_item_counter=-".$_SESSION['rzvy_cart_freqdiscount'];	$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_QTY$cart_item_counter=1";}				$cart_item_counter++;	if($_SESSION['rzvy_cart_couponid'] != "" && is_numeric($_SESSION['rzvy_cart_couponid'])){				   	$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_NAME$cart_item_counter='Discount'";						$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_DESC$cart_item_counter='Discount'";								$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_AMT$cart_item_counter=-".$_SESSION['rzvy_cart_coupondiscount'];	$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_QTY$cart_item_counter=1";									}		$cart_item_counter++;	if($_SESSION['rzvy_applied_ref_customer_id'] != "" && is_numeric($_SESSION['rzvy_applied_ref_customer_id'])){				   	$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_NAME$cart_item_counter='Referral Discount'";						$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_DESC$cart_item_counter='Referral Discount'";								$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_AMT$cart_item_counter=-".$_SESSION['rzvy_referral_discount_amount'];	$obj_rzvy_paypal->pv .= "&L_PAYMENTREQUEST_0_QTY$cart_item_counter=1";									}		$item_amt = $_SESSION['rzvy_cart_subtotal']-$_SESSION['rzvy_cart_freqdiscount'];$final_item_amts = $item_amt-$_SESSION['rzvy_cart_coupondiscount'];$final_item_amt = $final_item_amts-$_SESSION['rzvy_referral_discount_amount'];$obj_rzvy_paypal->pv .= "&PAYMENTREQUEST_0_ITEMAMT=".$final_item_amt;$obj_rzvy_paypal->pv .= "&PAYMENTREQUEST_0_TAXAMT=".$_SESSION['rzvy_cart_tax'];$obj_rzvy_paypal->pv .= "&PAYMENTREQUEST_0_AMT=".$_SESSION['rzvy_cart_nettotal'];$obj_rzvy_paypal->pp_method_name = 'SetExpressCheckout';  /*method name using for API call*/$resultarray = array();if(!isset($_GET["token"])) {	$response_array = $obj_rzvy_paypal->paypal_nvp_api_call();	/*Respond according to message we receive from Paypal*/	if("SUCCESS" == strtoupper($response_array["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($response_array["ACK"]))	{			if(strtoupper($obj_rzvy_paypal->mode)=='SANDBOX') {			  $obj_rzvy_paypal->mode = '.sandbox';			}			/*Redirect user to PayPal store with Token received.*/			$paypal_url ='https://www'.$obj_rzvy_paypal->mode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$response_array["TOKEN"].'';							$resultarray['status']='success';			$resultarray['value']=$paypal_url;			echo json_encode($resultarray);die();								 	}else{		$resultarray['status']='error';		$resultarray['value']=urldecode($response_array["L_LONGMESSAGE0"]);		echo json_encode($resultarray);die();				}}	if(isset($_GET["token"]) && isset($_GET["PayerID"])){	$token = $_GET["token"];	$payer_id = $_GET["PayerID"];		$obj_rzvy_paypal->pv .= "&TOKEN=".urlencode($token)."&PAYERID=".urlencode($payer_id);	$obj_rzvy_paypal->pp_method_name = 'DoExpressCheckoutPayment';  /*method name using for API call*/	$payment_response_array = $obj_rzvy_paypal->paypal_nvp_api_call(); 	if("SUCCESS" == strtoupper($payment_response_array["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($payment_response_array["ACK"])){ 	   $transaction_id = urldecode($payment_response_array["PAYMENTINFO_0_TRANSACTIONID"]);		   	   $_SESSION["transaction_id"] = $transaction_id;	   header('location:'.SITE_URL.'includes/lib/rzvy_front_appt_process_ajax.php');	}}