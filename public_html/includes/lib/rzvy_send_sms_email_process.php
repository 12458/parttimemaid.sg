<?php 
include(dirname(dirname(dirname(__FILE__))).'/includes/sms/twilio/autoload.php');
use Twilio\Rest\Client;
			
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once(dirname(dirname(dirname(__FILE__))).'/includes/sms/plivo/rzvy_plivo.php');
include_once(dirname(dirname(dirname(__FILE__))).'/includes/sms/nexmo/rzvy_nexmo.php');
include_once(dirname(dirname(dirname(__FILE__))).'/includes/sms/textlocal/rzvy_textlocal.php');
include_once(dirname(dirname(dirname(__FILE__))).'/includes/sms/web2sms/rzvy_w2s.php');

    if(!isset($feedback_url)){
        $feedback_url = '';
    }
    if(!isset($cancel_url)){
        $cancel_url = '';
    }

	/*send SMS & Email code start **/
	$rzvy_admin_email_notification_status = $obj_settings->get_option('rzvy_admin_email_notification_status');
	$rzvy_staff_email_notification_status = $obj_settings->get_option('rzvy_staff_email_notification_status');
	$rzvy_customer_email_notification_status = $obj_settings->get_option('rzvy_customer_email_notification_status');
	$rzvy_admin_sms_notification_status = $obj_settings->get_option('rzvy_admin_sms_notification_status');
	$rzvy_staff_sms_notification_status = $obj_settings->get_option('rzvy_staff_sms_notification_status');
	$rzvy_customer_sms_notification_status = $obj_settings->get_option('rzvy_customer_sms_notification_status');
	
	if(isset($es_r_template)){
		if($es_r_template == "referral" && ($rzvy_customer_email_notification_status == "Y" || $rzvy_customer_sms_notification_status == "Y")){
			$customer_email_sms_template_data = $obj_es_information->get_email_template($es_r_template, "customer");
			$customer_email_sms_template_row_count = mysqli_num_rows($customer_email_sms_template_data);
			
			if($customer_email_sms_template_row_count>0){
				
				/** Get detail for email **/
				$customer_name = ucwords(html_entity_decode($es_r_firstname)." ".html_entity_decode($es_r_lastname));
				$customer_email = $es_r_email;
				$customer_phone = $es_r_phone;
				$company_name = $obj_settings->get_option('rzvy_company_name');
				$company_email = $obj_settings->get_option('rzvy_company_email');
				$company_phone = $obj_settings->get_option('rzvy_company_phone');
				$company_address = $obj_settings->get_option('rzvy_company_address').", ".$obj_settings->get_option('rzvy_company_city').", ".$obj_settings->get_option('rzvy_company_state').", ".$obj_settings->get_option('rzvy_company_country')." - ".$obj_settings->get_option('rzvy_company_zip');
				$company_logo = $obj_settings->get_option('rzvy_company_logo');
				
				if($company_logo != "" && file_exists(dirname(dirname(dirname(__FILE__)))."/uploads/images/".$company_logo)){
					$company_logo = SITE_URL.'uploads/images/'.$company_logo;
				}else{
					$company_logo = "";
				}
				
				$tags_array = array('{{{customer_name}}}', '{{{company_name}}}', '{{{company_email}}}', '{{{company_phone}}}', '{{{company_address}}}', '{{{company_logo}}}', '{{{referral_code}}}', '{{{referral_url}}}');

				$replace_array = array($customer_name, $company_name, $company_email, $company_phone, $company_address, $company_logo, $es_r_rcode, $es_r_rcode_url);
			
				$rzvy_email_sender_name = $obj_settings->get_option('rzvy_email_sender_name');
				$rzvy_email_sender_email = $obj_settings->get_option('rzvy_email_sender_email');
				$rzvy_email_smtp_hostname = $obj_settings->get_option("rzvy_email_smtp_hostname");
				$rzvy_email_smtp_username = $obj_settings->get_option("rzvy_email_smtp_username");
				$rzvy_email_smtp_password = $obj_settings->get_option("rzvy_email_smtp_password");
				$rzvy_email_smtp_port = $obj_settings->get_option("rzvy_email_smtp_port");
				$rzvy_email_encryption_type = $obj_settings->get_option("rzvy_email_encryption_type");
				$rzvy_email_smtp_authentication = $obj_settings->get_option("rzvy_email_smtp_authentication");
				$rzvy_send_email_with = $obj_settings->get_option("rzvy_send_email_with");
				
				$mail_SMTPAuth = $rzvy_email_smtp_authentication;
				
				/********************* Customer Email & SMS ************************/
				if($customer_email_sms_template_row_count>0){
					$customer_email_sms_template = mysqli_fetch_array($customer_email_sms_template_data);
					/* Customer Email */
					if($rzvy_customer_email_notification_status == "Y" && $customer_email_sms_template["email_status"] == "Y"){ 
						$rzvy_customer_email_template = $customer_email_sms_template["email_content"];
						$customer_template = base64_decode($rzvy_customer_email_template);
						$customer_email_body = str_replace($tags_array,$replace_array,$customer_template);
						$customer_email_subject = str_replace($tags_array,$replace_array,html_entity_decode($customer_email_sms_template["subject"]));
						
						/* Send Mail code start here */
						try {
							$cmail = new PHPMailer(true, $conn);
							if($rzvy_send_email_with=='SMTP' &&  $rzvy_email_smtp_hostname != '' && $rzvy_email_sender_name != '' && $rzvy_email_sender_email != '' && $rzvy_email_smtp_username != '' && $rzvy_email_smtp_password != '' && $rzvy_email_smtp_port != ''){
								$cmail->isSMTP();
								$cmail->Host = $rzvy_email_smtp_hostname;
								$cmail->SMTPAuth = $mail_SMTPAuth;
								$cmail->Username = $rzvy_email_smtp_username;
								$cmail->Password = $rzvy_email_smtp_password;
								$cmail->SMTPSecure = $rzvy_email_encryption_type;
								$cmail->Port = $rzvy_email_smtp_port;
							}else{
								$cmail->isMail();
							}
							$cmail->isHTML(true);
							$cmail->SMTPDebug  = 0;
							$cmail->CharSet = "UTF-8";
							$cmail->setFrom($rzvy_email_sender_email, $rzvy_email_sender_name);
							$cmail->Subject = $customer_email_subject;
							$cmail->Body = $customer_email_body;
							$cmail->addAddress($customer_email, $customer_name);
							$cmail->send();
						} catch (Exception $e) { }
					}
					
					/* Customer SMS */
					if($rzvy_customer_sms_notification_status == "Y" && $customer_email_sms_template["sms_status"] == "Y"){
						$rzvy_customer_sms_template = $customer_email_sms_template["sms_content"];
						$customer_smstemplate = html_entity_decode(base64_decode($rzvy_customer_sms_template));
						$customer_sms_body = str_replace($tags_array,$replace_array,$customer_smstemplate);
						
						/** Send SMS using Twilio **/
						if($obj_settings->get_option("rzvy_twilio_sms_status") == "Y"){
							$rzvy_twilio_account_SID = $obj_settings->get_option("rzvy_twilio_account_SID");
							$rzvy_twilio_auth_token = $obj_settings->get_option("rzvy_twilio_auth_token");
							$rzvy_twilio_sender_number = $obj_settings->get_option("rzvy_twilio_sender_number");
							
							if($rzvy_twilio_account_SID != "" && $rzvy_twilio_auth_token != "" && $rzvy_twilio_sender_number != ""){
								try {
									$twilio_obj = new Client($rzvy_twilio_account_SID, $rzvy_twilio_auth_token);
									$response = $twilio_obj->messages->create($customer_phone,
									   array(
										   "from" => $rzvy_twilio_sender_number,
										   "body" => $customer_sms_body
									   )
									);
								} catch (Exception $e) { }
							}
						}
						
						/** Send SMS using Plivo **/
						if($obj_settings->get_option("rzvy_plivo_sms_status") == "Y"){
							$rzvy_plivo_account_SID = $obj_settings->get_option("rzvy_plivo_account_SID");
							$rzvy_plivo_auth_token = $obj_settings->get_option("rzvy_plivo_auth_token");
							$rzvy_plivo_sender_number = $obj_settings->get_option("rzvy_plivo_sender_number");
							
							if($rzvy_plivo_account_SID != "" && $rzvy_plivo_auth_token != "" && $rzvy_plivo_sender_number != ""){
								try {
									$plivo_obj = new rzvy_Plivo\RestAPI($rzvy_plivo_account_SID, $rzvy_plivo_auth_token, '', '');
									$params = array(
										'src' => $rzvy_plivo_sender_number,
										'dst' => $customer_phone,
										'text' => $customer_sms_body,
										'method' => 'POST'
									);
									$response = $plivo_obj->send_message($params);
								} catch (Exception $e) { }
							}
						}
						
						/** Send SMS using Nexmo **/
						if($obj_settings->get_option("rzvy_nexmo_sms_status") == "Y"){
							$rzvy_nexmo_api_key = $obj_settings->get_option("rzvy_nexmo_api_key");
							$rzvy_nexmo_api_secret = $obj_settings->get_option("rzvy_nexmo_api_secret");
							$rzvy_nexmo_from = $obj_settings->get_option("rzvy_nexmo_from");
							
							if($rzvy_nexmo_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_nexmo_from != ""){
								try {
									$nexmo_obj = new rzvy_nexmo();
									$response = $nexmo_obj->rzvy_send_nexmo_sms($customer_phone,$customer_sms_body,$rzvy_nexmo_api_key,$rzvy_nexmo_api_secret,$rzvy_nexmo_from);
								} catch (Exception $e) { }
							}
						}
						
						/** Send SMS using TextLocal **/
						if($obj_settings->get_option("rzvy_textlocal_sms_status") == "Y"){
							$rzvy_textlocal_api_key = $obj_settings->get_option("rzvy_textlocal_api_key");
							$rzvy_textlocal_sender = $obj_settings->get_option("rzvy_textlocal_sender");
							$rzvy_textlocal_country = $obj_settings->get_option("rzvy_textlocal_country");
							
							if($rzvy_textlocal_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_textlocal_sender != ""){
								try {
									$textlocal_obj = new rzvy_textlocal();
									$response = $textlocal_obj->rzvy_send_textlocal_sms($customer_phone,$customer_sms_body,$rzvy_textlocal_api_key,$rzvy_textlocal_country,$rzvy_textlocal_sender);
								} catch (Exception $e) { }
							}
						}
												
						/** Send SMS using Web2SMS **/
						if($obj_settings->get_option("rzvy_w2s_sms_status") == "Y"){
							$rzvy_w2s_api_key = $obj_settings->get_option("rzvy_w2s_api_key");
							$rzvy_w2s_api_secret = $obj_settings->get_option("rzvy_w2s_api_secret");
							$rzvy_w2s_sender = $obj_settings->get_option("rzvy_w2s_sender");
							
							if($rzvy_w2s_api_key != "" && $rzvy_w2s_api_secret != "" && $rzvy_w2s_sender != ""){
								try {
									$w2s_obj = new rzvy_w2s();
									$response = $w2s_obj->rzvy_send_web2_sms($customer_phone,$customer_sms_body,$rzvy_w2s_api_key,$rzvy_w2s_api_secret,$rzvy_w2s_sender);
								} catch (Exception $e) { }
							}
						}
					}
				}
			}
		}
	}
if(!isset($es_r_template) || (isset($es_r_template) && $es_r_template=='')){
	if($es_template != "reset_password" && $es_template != "forgot_password" && ($rzvy_admin_email_notification_status == "Y" || $rzvy_staff_email_notification_status == "Y" || $rzvy_customer_email_notification_status == "Y" || $rzvy_admin_sms_notification_status == "Y" || $rzvy_staff_sms_notification_status == "Y" || $rzvy_customer_sms_notification_status == "Y")){
	
		$admin_email_sms_template_data = $obj_es_information->get_email_template($es_template, "admin");
		$staff_email_sms_template_data = $obj_es_information->get_email_template($es_template, "staff");
		$customer_email_sms_template_data = $obj_es_information->get_email_template($es_template, "customer");
		
		$admin_email_sms_template_row_count = mysqli_num_rows($admin_email_sms_template_data);
		$staff_email_sms_template_row_count = mysqli_num_rows($staff_email_sms_template_data);
		$customer_email_sms_template_row_count = mysqli_num_rows($customer_email_sms_template_data);
		
		if($admin_email_sms_template_row_count>0 || $staff_email_sms_template_row_count>0 || $customer_email_sms_template_row_count>0){
			
			/** Get detail for email **/
			$rzvy_currency_symbol = $obj_settings->get_option('rzvy_currency_symbol');
			$rzvy_currency_position = $obj_settings->get_option('rzvy_currency_position');
			$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
			$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');
			
			$obj_es_information->category_id = $es_category_id;
			$obj_es_information->service_id = $es_service_id;

			$category_title = $obj_es_information->readone_category_name();
			$readone_service = $obj_es_information->readone_service();
			$service_amount = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$readone_service['rate']);
			$service_title = $readone_service['title'];
			$booking_date = date($rzvy_date_format, strtotime($es_booking_datetime));
			$booking_time = date($rzvy_time_format, strtotime($es_booking_datetime));
			
			$payment_method = $es_payment_method;
			$payment_date = date("Y-m-d");
			$transaction_id = "-";
			if($es_transaction_id != ""){ $transaction_id = $es_transaction_id; }
			$sub_total = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$es_subtotal);
			$coupon_discount = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$es_coupondiscount);
			$frequently_discount = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$es_freqdiscount);
			$tax = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$es_tax);
			$net_total = $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$es_nettotal);
		
			$customer_name = ucwords(html_entity_decode($es_firstname)." ".html_entity_decode($es_lastname));
			$customer_email = trim(strip_tags(mysqli_real_escape_string($conn, $es_email)));
			$customer_phone = $es_phone;
			$customer_address = html_entity_decode($es_address).", ".html_entity_decode($es_city).", ".html_entity_decode($es_state).", ".html_entity_decode($es_country)." - ".html_entity_decode($es_zip);
			
			$admin_email = $obj_es_information->get_admin_email();
			$admin_name = $obj_es_information->get_admin_name();
			$staff_email = $obj_es_information->get_staff_email($es_staff_id);
			$staff_name = $obj_es_information->get_staff_name($es_staff_id);
			$staff_phone = $obj_es_information->get_staff_phone($es_staff_id);
			$company_name = $obj_settings->get_option('rzvy_company_name');
			$company_email = $obj_settings->get_option('rzvy_company_email');
			$company_phone = $obj_settings->get_option('rzvy_company_phone');
			$company_address = $obj_settings->get_option('rzvy_company_address').", ".$obj_settings->get_option('rzvy_company_city').", ".$obj_settings->get_option('rzvy_company_state').", ".$obj_settings->get_option('rzvy_company_country')." - ".$obj_settings->get_option('rzvy_company_zip');
			$company_logo = $obj_settings->get_option('rzvy_company_logo');
			
			if($company_logo != "" && file_exists(dirname(dirname(dirname(__FILE__)))."/uploads/images/".$company_logo)){
				$company_logo = SITE_URL.'uploads/images/'.$company_logo;
			}else{
				$company_logo = "";
			}
			
			$addons_detail = '';
			$flag = true;
			
			$addons_items_arr = @unserialize($es_addons_items_arr);
			if($addons_items_arr === false) {
				$addons_items_arr = $es_addons_items_arr;
			}
			
			foreach($addons_items_arr as $addon){
				$obj_es_information->addon_id = $addon['id'];
				$addon_name = $obj_es_information->get_addon_name();
				if($flag){
					$addons_detail .= $addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
					$flag = false;
				}else{
					$addons_detail .= "<br/>".$addon['qty']." ".$addon_name." of ".$obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$addon['rate']);
				}
			}
			
			if(!isset($es_rcode)){
				$es_rcode = '';
			}
			if(!isset($es_rcode_url)){
				$es_rcode_url = '';
			}
			
			$tags_array = array('{{{category}}}', '{{{service}}}', '{{{service_amount}}}', '{{{addons}}}', '{{{booking_date}}}', '{{{booking_time}}}', '{{{payment_method}}}', '{{{payment_date}}}', '{{{transaction_id}}}', '{{{sub_total}}}', '{{{coupon_discount}}}', '{{{frequently_discount}}}', '{{{tax}}}', '{{{net_total}}}', '{{{customer_name}}}', '{{{customer_email}}}', '{{{customer_phone}}}', '{{{customer_address}}}', '{{{admin_name}}}', '{{{company_name}}}', '{{{company_email}}}', '{{{company_phone}}}', '{{{company_address}}}', '{{{company_logo}}}', '{{{reschedule_reason}}}', '{{{reject_reason}}}', '{{{cancel_reason}}}', '{{{staff_name}}}', '{{{cancel_url}}}', '{{{feedback_url}}}', '{{{referral_code}}}', '{{{referral_url}}}');

			$replace_array = array($category_title, $service_title, $service_amount, $addons_detail, $booking_date, $booking_time, $payment_method, $payment_date, $transaction_id, $sub_total, $coupon_discount, $frequently_discount, $tax, $net_total, $customer_name, $customer_email, $customer_phone, $customer_address, $admin_name, $company_name, $company_email, $company_phone, $company_address, $company_logo, $es_reschedule_reason, $es_reject_reason, $es_cancel_reason, $staff_name, $cancel_url, $feedback_url, $es_rcode, $es_rcode_url);
		
			$rzvy_email_sender_name = $obj_settings->get_option('rzvy_email_sender_name');
			$rzvy_email_sender_email = $obj_settings->get_option('rzvy_email_sender_email');
			$rzvy_email_smtp_hostname = $obj_settings->get_option("rzvy_email_smtp_hostname");
			$rzvy_email_smtp_username = $obj_settings->get_option("rzvy_email_smtp_username");
			$rzvy_email_smtp_password = $obj_settings->get_option("rzvy_email_smtp_password");
			$rzvy_email_smtp_port = $obj_settings->get_option("rzvy_email_smtp_port");
			$rzvy_email_encryption_type = $obj_settings->get_option("rzvy_email_encryption_type");
			$rzvy_email_smtp_authentication = $obj_settings->get_option("rzvy_email_smtp_authentication");
			$rzvy_send_email_with = $obj_settings->get_option("rzvy_send_email_with");
			
			$mail_SMTPAuth = $rzvy_email_smtp_authentication;
			
			/* include(dirname(dirname(dirname(__FILE__))).'/includes/sms/plivo/rzvy_plivo.php');
			include(dirname(dirname(dirname(__FILE__))).'/includes/sms/nexmo/rzvy_nexmo.php');
			include(dirname(dirname(dirname(__FILE__))).'/includes/sms/textlocal/rzvy_textlocal.php'); */
			
			/********************* Admin Email & SMS ************************/
			if($admin_email_sms_template_row_count>0){
				$admin_email_sms_template = mysqli_fetch_array($admin_email_sms_template_data);
				
				/* Admin Email */
				if($rzvy_admin_email_notification_status == "Y" && $admin_email_sms_template["email_status"] == "Y"){
					$rzvy_admin_email_template = $admin_email_sms_template["email_content"];
					$admin_template = base64_decode($rzvy_admin_email_template);
					$admin_email_body = str_replace($tags_array,$replace_array,$admin_template);
					$admin_email_subject = str_replace($tags_array,$replace_array,html_entity_decode($admin_email_sms_template["subject"]));
					
					/* Send Mail code start here */
					try {
						$amail = new PHPMailer(true, $conn);
						if($rzvy_send_email_with=='SMTP' && $rzvy_email_smtp_hostname != '' && $rzvy_email_sender_name != '' && $rzvy_email_sender_email != '' && $rzvy_email_smtp_username != '' && $rzvy_email_smtp_password != '' && $rzvy_email_smtp_port != ''){
							$amail->isSMTP();
							$amail->Host = $rzvy_email_smtp_hostname;
							$amail->SMTPAuth = $mail_SMTPAuth;
							$amail->Username = $rzvy_email_smtp_username;
							$amail->Password = $rzvy_email_smtp_password;
							$amail->SMTPSecure = $rzvy_email_encryption_type;
							$amail->Port = $rzvy_email_smtp_port;
						}else{
							$amail->isMail();
						}
						$amail->isHTML(true);
						$amail->SMTPDebug  = 0;
						$amail->CharSet = "UTF-8";
						$amail->setFrom($rzvy_email_sender_email, $rzvy_email_sender_name);
						/* $amail->Sender = $rzvy_email_sender_email; */
						$amail->Subject = $admin_email_subject;
						$amail->Body = $admin_email_body;
						$amail->addAddress($admin_email, $admin_name);
						$amail->send();
					} catch (Exception $e) { }
				}
				
				/* Admin SMS */
				if($rzvy_admin_sms_notification_status == "Y" && $admin_email_sms_template["sms_status"] == "Y"){
					$rzvy_admin_sms_template = $admin_email_sms_template["sms_content"];
					$admin_smstemplate = html_entity_decode(base64_decode($rzvy_admin_sms_template));
					$admin_sms_body = str_replace($tags_array,$replace_array,$admin_smstemplate);
					
					/** Send SMS using Twilio **/
					if($obj_settings->get_option("rzvy_twilio_sms_status") == "Y"){
						$rzvy_twilio_account_SID = $obj_settings->get_option("rzvy_twilio_account_SID");
						$rzvy_twilio_auth_token = $obj_settings->get_option("rzvy_twilio_auth_token");
						$rzvy_twilio_sender_number = $obj_settings->get_option("rzvy_twilio_sender_number");
						
						if($rzvy_twilio_account_SID != "" && $rzvy_twilio_auth_token != "" && $rzvy_twilio_sender_number != ""){
							try {
								$twilio_obj = new Client($rzvy_twilio_account_SID, $rzvy_twilio_auth_token);
								$response = $twilio_obj->messages->create($company_phone,
								   array(
									   "from" => $rzvy_twilio_sender_number,
									   "body" => $admin_sms_body
								   )
								);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using Plivo **/
					if($obj_settings->get_option("rzvy_plivo_sms_status") == "Y"){
						$rzvy_plivo_account_SID = $obj_settings->get_option("rzvy_plivo_account_SID");
						$rzvy_plivo_auth_token = $obj_settings->get_option("rzvy_plivo_auth_token");
						$rzvy_plivo_sender_number = $obj_settings->get_option("rzvy_plivo_sender_number");
						
						if($rzvy_plivo_account_SID != "" && $rzvy_plivo_auth_token != "" && $rzvy_plivo_sender_number != ""){
							try {
								$plivo_obj = new rzvy_Plivo\RestAPI($rzvy_plivo_account_SID, $rzvy_plivo_auth_token, '', '');
								$params = array(
									'src' => $rzvy_plivo_sender_number,
									'dst' => $company_phone,
									'text' => $admin_sms_body,
									'method' => 'POST'
								);
								$response = $plivo_obj->send_message($params);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using Nexmo **/
					if($obj_settings->get_option("rzvy_nexmo_sms_status") == "Y"){
						$rzvy_nexmo_api_key = $obj_settings->get_option("rzvy_nexmo_api_key");
						$rzvy_nexmo_api_secret = $obj_settings->get_option("rzvy_nexmo_api_secret");
						$rzvy_nexmo_from = $obj_settings->get_option("rzvy_nexmo_from");
						
						if($rzvy_nexmo_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_nexmo_from != ""){
							try {
								$nexmo_obj = new rzvy_nexmo();
								$response = $nexmo_obj->rzvy_send_nexmo_sms($company_phone,$admin_sms_body,$rzvy_nexmo_api_key,$rzvy_nexmo_api_secret,$rzvy_nexmo_from);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using TextLocal **/
					if($obj_settings->get_option("rzvy_textlocal_sms_status") == "Y"){
						$rzvy_textlocal_api_key = $obj_settings->get_option("rzvy_textlocal_api_key");
						$rzvy_textlocal_sender = $obj_settings->get_option("rzvy_textlocal_sender");
						$rzvy_textlocal_country = $obj_settings->get_option("rzvy_textlocal_country");
						
						if($rzvy_textlocal_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_textlocal_sender != ""){
							try {
								$textlocal_obj = new rzvy_textlocal();
								$response = $textlocal_obj->rzvy_send_textlocal_sms($company_phone,$admin_sms_body,$rzvy_textlocal_api_key,$rzvy_textlocal_country,$rzvy_textlocal_sender);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using Web2SMS **/
					if($obj_settings->get_option("rzvy_w2s_sms_status") == "Y"){
						$rzvy_w2s_api_key = $obj_settings->get_option("rzvy_w2s_api_key");
						$rzvy_w2s_api_secret = $obj_settings->get_option("rzvy_w2s_api_secret");
						$rzvy_w2s_sender = $obj_settings->get_option("rzvy_w2s_sender");
						
						if($rzvy_w2s_api_key != "" && $rzvy_w2s_api_secret != "" && $rzvy_w2s_sender != ""){
							try {
								$w2s_obj = new rzvy_w2s();
								$response = $w2s_obj->rzvy_send_web2_sms($company_phone,$admin_sms_body,$rzvy_w2s_api_key,$rzvy_w2s_api_secret,$rzvy_w2s_sender);
							} catch (Exception $e) { }
						}
					}
				}
			}
			
			/********************* Staff Email & SMS ************************/
			if($staff_email_sms_template_row_count>0){
				$staff_email_sms_template = mysqli_fetch_array($staff_email_sms_template_data);
				
				/* Staff Email */
				if($rzvy_staff_email_notification_status == "Y" && $staff_email_sms_template["email_status"] == "Y" && $staff_email != ""){
					$rzvy_staff_email_template = $staff_email_sms_template["email_content"];
					$staff_template = base64_decode($rzvy_staff_email_template);
					$staff_email_body = str_replace($tags_array,$replace_array,$staff_template);
					$staff_email_subject = str_replace($tags_array,$replace_array,html_entity_decode($staff_email_sms_template["subject"]));
					
					/* Send Mail code start here */
					try {
						$smail = new PHPMailer(true, $conn);
						if($rzvy_send_email_with=='SMTP' && $rzvy_email_smtp_hostname != '' && $rzvy_email_sender_name != '' && $rzvy_email_sender_email != '' && $rzvy_email_smtp_username != '' && $rzvy_email_smtp_password != '' && $rzvy_email_smtp_port != ''){
							$smail->isSMTP();
							$smail->Host = $rzvy_email_smtp_hostname;
							$smail->SMTPAuth = $mail_SMTPAuth;
							$smail->Username = $rzvy_email_smtp_username;
							$smail->Password = $rzvy_email_smtp_password;
							$smail->SMTPSecure = $rzvy_email_encryption_type;
							$smail->Port = $rzvy_email_smtp_port;
						}else{
							$smail->isMail();
						}
						$smail->isHTML(true);
						$smail->SMTPDebug  = 0;
						$smail->CharSet = "UTF-8";
						$smail->setFrom($rzvy_email_sender_email, $rzvy_email_sender_name);
						/* $smail->Sender = $rzvy_email_sender_email; */
						$smail->Subject = $staff_email_subject;
						$smail->Body = $staff_email_body;
						$smail->addAddress($staff_email, $staff_name);
						$smail->send();
					} catch (Exception $e) { }
				}
				
				/* Staff SMS */
				if($rzvy_staff_sms_notification_status == "Y" && $staff_email_sms_template["sms_status"] == "Y" & $staff_phone != ""){
					$rzvy_staff_sms_template = $staff_email_sms_template["sms_content"];
					$staff_smstemplate = html_entity_decode(base64_decode($rzvy_staff_sms_template));
					$staff_sms_body = str_replace($tags_array,$replace_array,$staff_smstemplate);
					
					/** Send SMS using Twilio **/
					if($obj_settings->get_option("rzvy_twilio_sms_status") == "Y"){
						$rzvy_twilio_account_SID = $obj_settings->get_option("rzvy_twilio_account_SID");
						$rzvy_twilio_auth_token = $obj_settings->get_option("rzvy_twilio_auth_token");
						$rzvy_twilio_sender_number = $obj_settings->get_option("rzvy_twilio_sender_number");
						
						if($rzvy_twilio_account_SID != "" && $rzvy_twilio_auth_token != "" && $rzvy_twilio_sender_number != ""){
							try {
								$twilio_obj = new Client($rzvy_twilio_account_SID, $rzvy_twilio_auth_token);
								$response = $twilio_obj->messages->create($staff_phone,
								   array(
									   "from" => $rzvy_twilio_sender_number,
									   "body" => $staff_sms_body
								   )
								);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using Plivo **/
					if($obj_settings->get_option("rzvy_plivo_sms_status") == "Y"){
						$rzvy_plivo_account_SID = $obj_settings->get_option("rzvy_plivo_account_SID");
						$rzvy_plivo_auth_token = $obj_settings->get_option("rzvy_plivo_auth_token");
						$rzvy_plivo_sender_number = $obj_settings->get_option("rzvy_plivo_sender_number");
						
						if($rzvy_plivo_account_SID != "" && $rzvy_plivo_auth_token != "" && $rzvy_plivo_sender_number != ""){
							try {
								$plivo_obj = new rzvy_Plivo\RestAPI($rzvy_plivo_account_SID, $rzvy_plivo_auth_token, '', '');
								$params = array(
									'src' => $rzvy_plivo_sender_number,
									'dst' => $staff_phone,
									'text' => $staff_sms_body,
									'method' => 'POST'
								);
								$response = $plivo_obj->send_message($params);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using Nexmo **/
					if($obj_settings->get_option("rzvy_nexmo_sms_status") == "Y"){
						$rzvy_nexmo_api_key = $obj_settings->get_option("rzvy_nexmo_api_key");
						$rzvy_nexmo_api_secret = $obj_settings->get_option("rzvy_nexmo_api_secret");
						$rzvy_nexmo_from = $obj_settings->get_option("rzvy_nexmo_from");
						
						if($rzvy_nexmo_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_nexmo_from != ""){
							try {
								$nexmo_obj = new rzvy_nexmo();
								$response = $nexmo_obj->rzvy_send_nexmo_sms($staff_phone,$staff_sms_body,$rzvy_nexmo_api_key,$rzvy_nexmo_api_secret,$rzvy_nexmo_from);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using TextLocal **/
					if($obj_settings->get_option("rzvy_textlocal_sms_status") == "Y"){
						$rzvy_textlocal_api_key = $obj_settings->get_option("rzvy_textlocal_api_key");
						$rzvy_textlocal_sender = $obj_settings->get_option("rzvy_textlocal_sender");
						$rzvy_textlocal_country = $obj_settings->get_option("rzvy_textlocal_country");
						
						if($rzvy_textlocal_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_textlocal_sender != ""){
							try {
								$textlocal_obj = new rzvy_textlocal();
								$response = $textlocal_obj->rzvy_send_textlocal_sms($staff_phone,$staff_sms_body,$rzvy_textlocal_api_key,$rzvy_textlocal_country,$rzvy_textlocal_sender);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using Web2SMS **/
					if($obj_settings->get_option("rzvy_w2s_sms_status") == "Y"){
						$rzvy_w2s_api_key = $obj_settings->get_option("rzvy_w2s_api_key");
						$rzvy_w2s_api_secret = $obj_settings->get_option("rzvy_w2s_api_secret");
						$rzvy_w2s_sender = $obj_settings->get_option("rzvy_w2s_sender");
						
						if($rzvy_w2s_api_key != "" && $rzvy_w2s_api_secret != "" && $rzvy_w2s_sender != ""){
							try {
								$w2s_obj = new rzvy_w2s();
								$response = $w2s_obj->rzvy_send_web2_sms($staff_phone,$staff_sms_body,$rzvy_w2s_api_key,$rzvy_w2s_api_secret,$rzvy_w2s_sender);
							} catch (Exception $e) { }
						}
					}
				}
			}
			
			/********************* Customer Email & SMS ************************/
			if($customer_email_sms_template_row_count>0){
				$customer_email_sms_template = mysqli_fetch_array($customer_email_sms_template_data);
				/* Customer Email */
				if($rzvy_customer_email_notification_status == "Y" && $customer_email_sms_template["email_status"] == "Y"){ 
					$rzvy_customer_email_template = $customer_email_sms_template["email_content"];
					$customer_template = base64_decode($rzvy_customer_email_template);
					$customer_email_body = str_replace($tags_array,$replace_array,$customer_template);
					$customer_email_subject = str_replace($tags_array,$replace_array,html_entity_decode($customer_email_sms_template["subject"]));
					
					/* Send Mail code start here */
					try {
						$cmail = new PHPMailer(true, $conn);
						if($rzvy_send_email_with=='SMTP' &&  $rzvy_email_smtp_hostname != '' && $rzvy_email_sender_name != '' && $rzvy_email_sender_email != '' && $rzvy_email_smtp_username != '' && $rzvy_email_smtp_password != '' && $rzvy_email_smtp_port != ''){
							$cmail->isSMTP();
							$cmail->Host = $rzvy_email_smtp_hostname;
							$cmail->SMTPAuth = $mail_SMTPAuth;
							$cmail->Username = $rzvy_email_smtp_username;
							$cmail->Password = $rzvy_email_smtp_password;
							$cmail->SMTPSecure = $rzvy_email_encryption_type;
							$cmail->Port = $rzvy_email_smtp_port;
						}else{
							$cmail->isMail();
						}
						$cmail->isHTML(true);
						$cmail->SMTPDebug  = 0;
						$cmail->CharSet = "UTF-8";
						$cmail->setFrom($rzvy_email_sender_email, $rzvy_email_sender_name);
						/* $cmail->Sender = $rzvy_email_sender_email; */
						$cmail->Subject = $customer_email_subject;
						$cmail->Body = $customer_email_body;
						$cmail->addAddress($customer_email, $customer_name);
						$cmail->send();
					} catch (Exception $e) { }
				}
				
				/* Customer SMS */
				if($rzvy_customer_sms_notification_status == "Y" && $customer_email_sms_template["sms_status"] == "Y"){
					$rzvy_customer_sms_template = $customer_email_sms_template["sms_content"];
					$customer_smstemplate = html_entity_decode(base64_decode($rzvy_customer_sms_template));
					$customer_sms_body = str_replace($tags_array,$replace_array,$customer_smstemplate);
					
					/** Send SMS using Twilio **/
					if($obj_settings->get_option("rzvy_twilio_sms_status") == "Y"){
						$rzvy_twilio_account_SID = $obj_settings->get_option("rzvy_twilio_account_SID");
						$rzvy_twilio_auth_token = $obj_settings->get_option("rzvy_twilio_auth_token");
						$rzvy_twilio_sender_number = $obj_settings->get_option("rzvy_twilio_sender_number");
						
						if($rzvy_twilio_account_SID != "" && $rzvy_twilio_auth_token != "" && $rzvy_twilio_sender_number != ""){
							try {
								$twilio_obj = new Client($rzvy_twilio_account_SID, $rzvy_twilio_auth_token);
								$response = $twilio_obj->messages->create($customer_phone,
								   array(
									   "from" => $rzvy_twilio_sender_number,
									   "body" => $customer_sms_body
								   )
								);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using Plivo **/
					if($obj_settings->get_option("rzvy_plivo_sms_status") == "Y"){
						$rzvy_plivo_account_SID = $obj_settings->get_option("rzvy_plivo_account_SID");
						$rzvy_plivo_auth_token = $obj_settings->get_option("rzvy_plivo_auth_token");
						$rzvy_plivo_sender_number = $obj_settings->get_option("rzvy_plivo_sender_number");
						
						if($rzvy_plivo_account_SID != "" && $rzvy_plivo_auth_token != "" && $rzvy_plivo_sender_number != ""){
							try {
								$plivo_obj = new rzvy_Plivo\RestAPI($rzvy_plivo_account_SID, $rzvy_plivo_auth_token, '', '');
								$params = array(
									'src' => $rzvy_plivo_sender_number,
									'dst' => $customer_phone,
									'text' => $customer_sms_body,
									'method' => 'POST'
								);
								$response = $plivo_obj->send_message($params);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using Nexmo **/
					if($obj_settings->get_option("rzvy_nexmo_sms_status") == "Y"){
						$rzvy_nexmo_api_key = $obj_settings->get_option("rzvy_nexmo_api_key");
						$rzvy_nexmo_api_secret = $obj_settings->get_option("rzvy_nexmo_api_secret");
						$rzvy_nexmo_from = $obj_settings->get_option("rzvy_nexmo_from");
						
						if($rzvy_nexmo_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_nexmo_from != ""){
							try {
								$nexmo_obj = new rzvy_nexmo();
								$response = $nexmo_obj->rzvy_send_nexmo_sms($customer_phone,$customer_sms_body,$rzvy_nexmo_api_key,$rzvy_nexmo_api_secret,$rzvy_nexmo_from);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using TextLocal **/
					if($obj_settings->get_option("rzvy_textlocal_sms_status") == "Y"){
						$rzvy_textlocal_api_key = $obj_settings->get_option("rzvy_textlocal_api_key");
						$rzvy_textlocal_sender = $obj_settings->get_option("rzvy_textlocal_sender");
						$rzvy_textlocal_country = $obj_settings->get_option("rzvy_textlocal_country");
						
						if($rzvy_textlocal_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_textlocal_sender != ""){
							try {
								$textlocal_obj = new rzvy_textlocal();
								$response = $textlocal_obj->rzvy_send_textlocal_sms($customer_phone,$customer_sms_body,$rzvy_textlocal_api_key,$rzvy_textlocal_country,$rzvy_textlocal_sender);
							} catch (Exception $e) { }
						}
					}
					
					/** Send SMS using Web2SMS **/
					if($obj_settings->get_option("rzvy_w2s_sms_status") == "Y"){
						$rzvy_w2s_api_key = $obj_settings->get_option("rzvy_w2s_api_key");
						$rzvy_w2s_api_secret = $obj_settings->get_option("rzvy_w2s_api_secret");
						$rzvy_w2s_sender = $obj_settings->get_option("rzvy_w2s_sender");
						
						if($rzvy_w2s_api_key != "" && $rzvy_w2s_api_secret != "" && $rzvy_w2s_sender != ""){
							try {
								$w2s_obj = new rzvy_w2s();
								$response = $w2s_obj->rzvy_send_web2_sms($customer_phone,$customer_sms_body,$rzvy_w2s_api_key,$rzvy_w2s_api_secret,$rzvy_w2s_sender);
							} catch (Exception $e) { }
						}
					}
				}
			}
		}
	}else{
		$all_email_sms_template_data = $obj_es_information->get_email_template($es_template, "all");
		$all_email_sms_template_row_count = mysqli_num_rows($all_email_sms_template_data);
		
		if($all_email_sms_template_row_count>0){
			/** Get detail for email **/
			$name = $es_firstname." ".$es_lastname;
			$company_name = $obj_settings->get_option('rzvy_company_name');
			$company_email = $obj_settings->get_option('rzvy_company_email');
			$company_phone = $obj_settings->get_option('rzvy_company_phone');
			$company_address = $obj_settings->get_option('rzvy_company_address').", ".$obj_settings->get_option('rzvy_company_city').", ".$obj_settings->get_option('rzvy_company_state').", ".$obj_settings->get_option('rzvy_company_country')." - ".$obj_settings->get_option('rzvy_company_zip');
			$company_logo = $obj_settings->get_option('rzvy_company_logo');
			
			if($company_logo != "" && file_exists(dirname(dirname(dirname(__FILE__)))."/uploads/images/".$company_logo)){
				$company_logo = SITE_URL.'uploads/images/'.$company_logo;
			}else{
				$company_logo = "";
			}
			
			$reset_password_link = "";
			if(isset($es_reset_password_link)){
				$reset_password_link = $es_reset_password_link;
			}
			
			$tags_array = array('{{{name}}}', '{{{email}}}', '{{{phone}}}', '{{{company_name}}}', '{{{company_email}}}', '{{{company_phone}}}', '{{{company_address}}}', '{{{company_logo}}}', '{{{reset_password_link}}}');

			$replace_array = array($name, $es_email, $es_phone, $company_name, $company_email, $company_phone, $company_address, $company_logo, $reset_password_link);
		
			$rzvy_email_sender_name = $obj_settings->get_option('rzvy_email_sender_name');
			$rzvy_email_sender_email = $obj_settings->get_option('rzvy_email_sender_email');
			$rzvy_email_smtp_hostname = $obj_settings->get_option("rzvy_email_smtp_hostname");
			$rzvy_email_smtp_username = $obj_settings->get_option("rzvy_email_smtp_username");
			$rzvy_email_smtp_password = $obj_settings->get_option("rzvy_email_smtp_password");
			$rzvy_email_smtp_port = $obj_settings->get_option("rzvy_email_smtp_port");
			$rzvy_email_encryption_type = $obj_settings->get_option("rzvy_email_encryption_type");
			$rzvy_email_smtp_authentication = $obj_settings->get_option("rzvy_email_smtp_authentication");
			$rzvy_send_email_with = $obj_settings->get_option("rzvy_send_email_with");
			
			$mail_SMTPAuth = $rzvy_email_smtp_authentication;
			
			/* include(dirname(dirname(dirname(__FILE__))).'/includes/sms/plivo/rzvy_plivo.php');
			include(dirname(dirname(dirname(__FILE__))).'/includes/sms/nexmo/rzvy_nexmo.php');
			include(dirname(dirname(dirname(__FILE__))).'/includes/sms/textlocal/rzvy_textlocal.php'); */
			
			/********************* All Email & SMS ************************/
			$all_email_sms_template = mysqli_fetch_array($all_email_sms_template_data);
			
			/* All Email */
			if($all_email_sms_template["email_status"] == "Y"){
				$rzvy_all_email_template = $all_email_sms_template["email_content"];
				$all_template = base64_decode($rzvy_all_email_template);
				$all_email_body = str_replace($tags_array,$replace_array,$all_template);
				$all_email_subject = str_replace($tags_array,$replace_array,html_entity_decode($all_email_sms_template["subject"]));
				
				/* Send Mail code start here */
				try {
					$mail = new PHPMailer(true, $conn);
					if($rzvy_send_email_with=='SMTP' && $rzvy_email_smtp_hostname != '' && $rzvy_email_sender_name != '' && $rzvy_email_sender_email != '' && $rzvy_email_smtp_username != '' && $rzvy_email_smtp_password != '' && $rzvy_email_smtp_port != ''){
						$mail->isSMTP();
						$mail->Host = $rzvy_email_smtp_hostname;
						$mail->SMTPAuth = $mail_SMTPAuth;
						$mail->Username = $rzvy_email_smtp_username;
						$mail->Password = $rzvy_email_smtp_password;
						$mail->SMTPSecure = $rzvy_email_encryption_type;
						$mail->Port = $rzvy_email_smtp_port;
					}else{
						$mail->isMail();
					}
					$mail->isHTML(true);
					$mail->SMTPDebug  = 0;
					$mail->CharSet = "UTF-8";
					$mail->setFrom($rzvy_email_sender_email, $rzvy_email_sender_name);
					$mail->Subject = $all_email_subject;
					$mail->Body = $all_email_body;
					$mail->addAddress($es_email, $name);
					$mail->send();
				} catch (Exception $e) { }
			}
				
			/* All SMS */
			if($all_email_sms_template["sms_status"] == "Y"){
				$rzvy_all_sms_template = $all_email_sms_template["sms_content"];
				$all_smstemplate = html_entity_decode(base64_decode($rzvy_all_sms_template));
				$all_sms_body = str_replace($tags_array,$replace_array,$all_smstemplate);
				
				/** Send SMS using Twilio **/
				if($obj_settings->get_option("rzvy_twilio_sms_status") == "Y"){
					$rzvy_twilio_account_SID = $obj_settings->get_option("rzvy_twilio_account_SID");
					$rzvy_twilio_auth_token = $obj_settings->get_option("rzvy_twilio_auth_token");
					$rzvy_twilio_sender_number = $obj_settings->get_option("rzvy_twilio_sender_number");
					
					if($rzvy_twilio_account_SID != "" && $rzvy_twilio_auth_token != "" && $rzvy_twilio_sender_number != ""){
						try {
							$twilio_obj = new Client($rzvy_twilio_account_SID, $rzvy_twilio_auth_token);
							$response = $twilio_obj->messages->create($es_phone,
								   array(
									   "from" => $rzvy_twilio_sender_number,
									   "body" => $all_sms_body
								   )
								);
						} catch (Exception $e) { }
					}
				}
				
				/** Send SMS using Plivo **/
				if($obj_settings->get_option("rzvy_plivo_sms_status") == "Y"){
					$rzvy_plivo_account_SID = $obj_settings->get_option("rzvy_plivo_account_SID");
					$rzvy_plivo_auth_token = $obj_settings->get_option("rzvy_plivo_auth_token");
					$rzvy_plivo_sender_number = $obj_settings->get_option("rzvy_plivo_sender_number");
					
					if($rzvy_plivo_account_SID != "" && $rzvy_plivo_auth_token != "" && $rzvy_plivo_sender_number != ""){
						try {
							$plivo_obj = new rzvy_Plivo\RestAPI($rzvy_plivo_account_SID, $rzvy_plivo_auth_token, '', '');
							$params = array(
								'src' => $rzvy_plivo_sender_number,
								'dst' => $es_phone,
								'text' => $all_sms_body,
								'method' => 'POST'
							);
							$response = $plivo_obj->send_message($params);
						} catch (Exception $e) { }
					}
				}
				
				/** Send SMS using Nexmo **/
				if($obj_settings->get_option("rzvy_nexmo_sms_status") == "Y"){
					$rzvy_nexmo_api_key = $obj_settings->get_option("rzvy_nexmo_api_key");
					$rzvy_nexmo_api_secret = $obj_settings->get_option("rzvy_nexmo_api_secret");
					$rzvy_nexmo_from = $obj_settings->get_option("rzvy_nexmo_from");
					
					if($rzvy_nexmo_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_nexmo_from != ""){
						try {
							$nexmo_obj = new rzvy_nexmo();
							$response = $nexmo_obj->rzvy_send_nexmo_sms($es_phone,$all_sms_body,$rzvy_nexmo_api_key,$rzvy_nexmo_api_secret,$rzvy_nexmo_from);
						} catch (Exception $e) { }
					}
				}
				
				/** Send SMS using TextLocal **/
				if($obj_settings->get_option("rzvy_textlocal_sms_status") == "Y"){
					$rzvy_textlocal_api_key = $obj_settings->get_option("rzvy_textlocal_api_key");
					$rzvy_textlocal_sender = $obj_settings->get_option("rzvy_textlocal_sender");
					$rzvy_textlocal_country = $obj_settings->get_option("rzvy_textlocal_country");
					
					if($rzvy_textlocal_api_key != "" && $rzvy_nexmo_api_secret != "" && $rzvy_textlocal_sender != ""){
						try {
							$textlocal_obj = new rzvy_textlocal();
							$response = $textlocal_obj->rzvy_send_textlocal_sms($es_phone,$all_sms_body,$rzvy_textlocal_api_key,$rzvy_textlocal_country,$rzvy_textlocal_sender);
						} catch (Exception $e) { }
					}
				}
				
				/** Send SMS using Web2SMS **/
				if($obj_settings->get_option("rzvy_w2s_sms_status") == "Y"){
					$rzvy_w2s_api_key = $obj_settings->get_option("rzvy_w2s_api_key");
					$rzvy_w2s_api_secret = $obj_settings->get_option("rzvy_w2s_api_secret");
					$rzvy_w2s_sender = $obj_settings->get_option("rzvy_w2s_sender");
					
					if($rzvy_w2s_api_key != "" && $rzvy_w2s_api_secret != "" && $rzvy_w2s_sender != ""){
						try {
							$w2s_obj = new rzvy_w2s();
							$response = $w2s_obj->rzvy_send_web2_sms($es_phone,$all_sms_body,$rzvy_w2s_api_key,$rzvy_w2s_api_secret,$rzvy_w2s_sender);
						} catch (Exception $e) { }
					}
				}
			}
		}
	}
}	
	/*send SMS & Email code end **/