<?php 
if (!class_exists('rzvy_es_information')){
class rzvy_es_information{
	public $conn;
	public $category_id;
	public $service_id;
	public $addon_id;
	public $frequently_discount_id;
	public $coupon_id;
	public $customer_id;
	public $feedback_name;
	public $feedback_email;
	public $feedback_rating;
	public $feedback_review;
	public $feedback_review_datetime;
	public $email;
	public $password;
	public $order_id;
	public $booking_datetime;
	public $booking_end_datetime;
	public $order_date;
	public $addons;
	public $booking_status;
	public $lastmodified;
	public $firstname;
	public $lastname;
	public $phone;
	public $address;
	public $city;
	public $state;
	public $zip;
	public $country;
	public $payment_method;
	public $payment_date;
	public $transaction_id;
	public $sub_total;
	public $discount;
	public $tax;
	public $net_total;
	public $fd_key;
	public $fd_amount;
	public $is_expired;
	public $used_on;
	public $fd_id;
	public $rzvy_services = 'rzvy_services';
	public $rzvy_categories = 'rzvy_categories';
	public $rzvy_addons = 'rzvy_addons';
	public $rzvy_frequently_discount = 'rzvy_frequently_discount';
	public $rzvy_feedback = 'rzvy_feedback';
	public $rzvy_customers = 'rzvy_customers';
	public $rzvy_coupons = 'rzvy_coupons';
	public $rzvy_used_coupons_by_customer = 'rzvy_used_coupons_by_customer';
	public $rzvy_bookings = 'rzvy_bookings';
	public $rzvy_customer_orderinfo = 'rzvy_customer_orderinfo';
	public $rzvy_templates = 'rzvy_templates';
	public $rzvy_admins = 'rzvy_admins';
	public $rzvy_payments = 'rzvy_payments';
	public $rzvy_staff = 'rzvy_staff';
	public $rzvy_customer_referrals = 'rzvy_customer_referrals';
	
	/* Function to get email template */
	public function get_es_appt_detail_by_order_id($order_id){
		$query = "select `b`.`cat_id`, `b`.`service_id`, `b`.`booking_datetime`, `b`.`reschedule_reason`, `b`.`reject_reason`, `b`.`cancel_reason`, `b`.`addons`, `b`.`staff_id`, `p`.`transaction_id`, `p`.`sub_total`, `p`.`discount`, `p`.`tax`, `p`.`net_total`, `p`.`fd_amount`, `p`.`payment_method`, `c`.`c_firstname`, `c`.`c_lastname`, `c`.`c_email`, `c`.`c_phone`, `c`.`c_address`, `c`.`c_city`, `c`.`c_state`, `c`.`c_country`, `c`.`c_zip` from `".$this->rzvy_bookings."` as `b`, `".$this->rzvy_payments."` as `p`, `".$this->rzvy_customer_orderinfo."` as `c` where `b`.`order_id`=`p`.`order_id` and `b`.`order_id`=`c`.`order_id` and `b`.`order_id`='".$order_id."'";
 		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* Function to get email template */
	public function get_es_referred_customer_detail_by_order_id($order_id){
		$query = "select `c`.`firstname`, `c`.`lastname`, `c`.`email`, `c`.`phone` from `".$this->rzvy_customers."` as `c`, `".$this->rzvy_customer_referrals."` as `r` where `r`.`ref_customer_id`=`c`.`id` and `r`.`order_id`='".$order_id."'";
 		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* Function to get email template */
	public function get_email_template($template, $template_for){
		$query = "select * from `".$this->rzvy_templates."` where `template`='".$template."' and `template_for`='".$template_for."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* Function to get admin name */
	public function get_admin_name(){
		$query = "select `firstname`, `lastname` from `".$this->rzvy_admins."`";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_array($result);
		return ucwords($value['firstname']." ".$value['lastname']);
	}
	
	/* Function to get staff name */
	public function get_staff_name($staff_id){
		$query = "select `firstname`, `lastname` from `".$this->rzvy_staff."` where `id`='".$staff_id."'";
		$result=mysqli_query($this->conn,$query);
		if(mysqli_num_rows($result)>0){
			$value=mysqli_fetch_array($result);
			return ucwords($value['firstname']." ".$value['lastname']);
		}else{
			return "-";
		}
	}
	
	/* Function to get staff phone */
	public function get_staff_phone($staff_id){
		$query = "select `phone` from `".$this->rzvy_staff."` where `id`='".$staff_id."'";
		$result=mysqli_query($this->conn,$query);
		if(mysqli_num_rows($result)>0){
			$value=mysqli_fetch_array($result);
			return $value['phone'];
		}else{
			return "";
		}
	}
	
	/* Function to get admin email */
	public function get_admin_email(){
		$query = "select `email` from `".$this->rzvy_admins."`";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_array($result);
		return $value['email'];
	}
	
	/* Function to get staff email */
	public function get_staff_email($staff_id){
		$query = "select `email` from `".$this->rzvy_staff."` where `id`='".$staff_id."'";
		$result=mysqli_query($this->conn,$query);
		if(mysqli_num_rows($result)>0){
			$value=mysqli_fetch_array($result);
			return $value['email'];
		}else{
			return "";
		}
	}
	
	/* Function to get addon name */
	public function get_addon_name(){
		$query = "select `title` from `".$this->rzvy_addons."` where `id`='".$this->addon_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_array($result);
		return $value['title'];
	}

	/* Function to read one service name */
	public function readone_service_name(){
		$query = "select `title` from `".$this->rzvy_services."` where `id`='".$this->service_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_array($result);
		return $value['title'];
	}

	/* Function to read one service name */
	public function readone_service(){
		$query = "select * from `".$this->rzvy_services."` where `id`='".$this->service_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_array($result);
		return $value;
	}

	/* Function to read one category name */
	public function readone_category_name(){
		$query = "select `cat_name` from `".$this->rzvy_categories."` where `id`='".$this->category_id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_array($result);
		return $value['cat_name'];
	}

	/* Function to add gc event id */
	public function insert_appt_gc_eventid($order_id, $gc_eventid){
		$res1 = mysqli_query($this->conn, "SELECT * FROM `rzvy_gc_bookingdetail` where `order_id`='".$order_id."'");
		if(mysqli_num_rows($res1)>0){
			$query = "UPDATE `rzvy_gc_bookingdetail` set `gc_eventid`='".$gc_eventid."' where `order_id`='".$order_id."'";
			$result=mysqli_query($this->conn,$query);
		}else{
			$query = "INSERT INTO `rzvy_gc_bookingdetail`(`id`, `order_id`, `gc_eventid`) VALUES (NULL, '".$order_id."', '".$gc_eventid."')";
			$result=mysqli_query($this->conn,$query);
		}
		return $result;
	}

	/* Function to get gc event id */
	public function get_appt_gc_eventid($order_id){
		$result = mysqli_query($this->conn, "SELECT * FROM `rzvy_gc_bookingdetail` where `order_id`='".$order_id."'");
		if(mysqli_num_rows($result)>0){
			$value=mysqli_fetch_array($result);
			return $value['gc_eventid'];
		}else{
			return "";
		}
	}
	
	/* Function to delete gc event id */
	public function delete_appt_gc_eventid($order_id){
		$result = mysqli_query($this->conn, "delete FROM `rzvy_gc_bookingdetail` where `order_id`='".$order_id."'");
		return $result;
	}

	/* Function to add gc event id */
	public function insert_appt_gc_eventid_staff($order_id, $gc_eventid){
		$res1 = mysqli_query($this->conn, "SELECT * FROM `rzvy_staff_gc_bookingdetail` where `order_id`='".$order_id."'");
		if(mysqli_num_rows($res1)>0){
			$query = "UPDATE `rzvy_staff_gc_bookingdetail` set `gc_eventid`='".$gc_eventid."' where `order_id`='".$order_id."'";
			$result=mysqli_query($this->conn,$query);
		}else{
			$query = "INSERT INTO `rzvy_staff_gc_bookingdetail`(`id`, `order_id`, `gc_eventid`) VALUES (NULL, '".$order_id."', '".$gc_eventid."')";
			$result=mysqli_query($this->conn,$query);
		}
		return $result;
	}

	/* Function to get gc event id */
	public function get_appt_gc_eventid_staff($order_id){
		$result = mysqli_query($this->conn, "SELECT * FROM `rzvy_staff_gc_bookingdetail` where `order_id`='".$order_id."'");
		if(mysqli_num_rows($result)>0){
			$value=mysqli_fetch_array($result);
			return $value['gc_eventid'];
		}else{
			return "";
		}
	}
	
	/* Function to delete gc event id */
	public function delete_appt_gc_eventid_staff($order_id){
		$result = mysqli_query($this->conn, "delete FROM `rzvy_staff_gc_bookingdetail` where `order_id`='".$order_id."'");
		return $result;
	}
	/* Function to get refferal code of customer */
	public function get_refferal_code_customer($customer_email){
		$result = mysqli_query($this->conn, "SELECT `refferral_code` FROM `".$this->rzvy_customers."` where `email`='".$customer_email."'");
		if(mysqli_num_rows($result)>0){
			$value=mysqli_fetch_array($result);
			return $value['refferral_code'];
		}else{
			return "";
		}
	}
} 
} 
?>