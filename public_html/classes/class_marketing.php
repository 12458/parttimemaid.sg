<?php 
if (!class_exists('rzvy_marketing')){
	class rzvy_marketing{
		public $conn;
		public $id;
		public $name;
		public $start_date;
		public $end_date;
		public $statsin;
		public $other_info;
		public $rzvy_marketing = 'rzvy_marketing';

			
		/* Function to add new campaign */
		public function create_campaign(){
			$query = "INSERT INTO `".$this->rzvy_marketing."`(`id`, `name`, `start_date`, `end_date`, `statsin`, `other_info`) VALUES (NULL,'".$this->name."','".$this->start_date."','".$this->end_date."','0','')";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		
		/* Function to update campaign */
		public function update_campaign(){
			$query = "update `".$this->rzvy_marketing."` set `name`='".$this->name."', `start_date`='".$this->start_date."', `end_date`='".$this->end_date."' where `id`='".$this->id."'";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		/* Function to get all coupons within limit */
		public function get_all_campaigns_within_limit($start, $end, $search, $column,$direction, $draw){
			$order_by_qry = '';
			if($draw == 1){
				$order_by_qry = 'order by `id` DESC';
			}else if($column == 0){
				$order_by_qry = 'order by `name` '.$direction;
			}else if($column == 1){
				$order_by_qry = 'order by `start_date` '.$direction;
			}else if($column == 2){
				$order_by_qry = 'order by `end_date` '.$direction;
			}else if($column == 3){
				$order_by_qry = 'order by `statsin` '.$direction;
			}else{
				$order_by_qry = 'order by `id` '.$direction;
			}
			if($search != ''){
				$query = "select * from `".$this->rzvy_marketing."` where (`name` like '%".$search."%' or `start_date` like '%".$search."%' or `end_date` like '%".$search."%' or `statsin` like '%".$search."%') ".$order_by_qry." limit ".$start.", ".$end;
			}else{
				$query = "select * from `".$this->rzvy_marketing."` ".$order_by_qry." limit ".$start.", ".$end;
			}
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		
		/* Function to count all campaign */
		public function count_all_campaign($search){
			if($search != ''){
				$query = "select count(`id`) from `".$this->rzvy_marketing."` where (`name` like '%".$search."%' or `start_date` like '%".$search."%' or `end_date` like '%".$search."%' or `statsin` like '%".$search."%')";
			}else{
				$query = "select count(`id`) from `".$this->rzvy_marketing."`";
			}
			$result=mysqli_query($this->conn,$query);
			$value=mysqli_fetch_array($result);
			return $value[0];
		}
	
		/* Function to get all campaign */
		public function get_all_campaigns(){
			$query = "select * from `".$this->rzvy_marketing."`";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
		/* Function to read one campaign */
		public function readone_campaign(){
			$query = "select * from `".$this->rzvy_marketing."` where `id`='".$this->id."'";
			$result=mysqli_query($this->conn,$query);
			$value=mysqli_fetch_array($result);
			return $value;
		}
		
		/* Function to delete campaign */
		public function delete_campaign(){
			$query = "delete from `".$this->rzvy_marketing."` where `id`='".$this->id."'";
			$result=mysqli_query($this->conn,$query);
			return $result;
		}
	
	  }
}
?>