<?php 
class rzvy_categories{
	public $conn;
	public $id;
	public $cat_name;
	public $status;
	public $image;
	public $position=0;
	public $rzvy_categories = 'rzvy_categories';
	public $rzvy_parent_categories = 'rzvy_parent_categories';
	public $rzvy_bookings = 'rzvy_bookings';
	
	/* Function to add categories */
	public function add_category(){
		$query = "INSERT INTO `".$this->rzvy_categories."` (`id`, `cat_name`, `status`, `image`, `position`) VALUES (NULL, '".$this->cat_name."', '".$this->status."', '".$this->image."', '".$this->position."')";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	/* Function to get all categories */
	public function get_all_categories(){
		$query = "select * from `".$this->rzvy_categories."` ORDER BY `position` ASC";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* Function to get all categories by parent cat id */
	public function get_all_categories_by_pcid($pcid){
		$query = "select `c`.* from `".$this->rzvy_categories."` as `c`, `".$this->rzvy_parent_categories."` as `p` where `p`.`id` = '".$pcid."' and find_in_set(`c`.`id`, `p`.`linked_subcat`) ORDER BY `c`.`position` ASC";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* Function to get all categories name */
	public function get_all_categories_name(){
		$query = "select `id`, `cat_name` from `".$this->rzvy_categories."`";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* Function to change category status */
	public function change_category_status(){
		$query = "update `".$this->rzvy_categories."` set `status`='".$this->status."' where `id`='".$this->id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* Function to update category */
	public function update_category(){
		$query = "update `".$this->rzvy_categories."` set `cat_name`='".$this->cat_name."', `image`='".$this->image."' where `id`='".$this->id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* Function to delete category */
	public function delete_category(){
		$query = "delete from `".$this->rzvy_categories."` where `id`='".$this->id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
	
	/* Function to check appointments before delete category */
	public function check_appointments_before_delete_category(){
		$query = "select `id` from `".$this->rzvy_bookings."` where `cat_id`='".$this->id."'";
		$result=mysqli_query($this->conn,$query);
		$count=mysqli_num_rows($result);
		return $count;
	}
	
	/* Function to get one categories name */
	public function readone_category_name(){
		$query = "select `cat_name` from `".$this->rzvy_categories."` where `id`='".$this->id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_assoc($result);
		return $value['cat_name'];
	}
	
	/* Function to read one category */
	public function readone_category(){
		$query = "select * from `".$this->rzvy_categories."` where `id`='".$this->id."'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_assoc($result);
		return $value;
	}
	
	/* Function to update category position */
	public function update_category_position($id, $position){
		$query = "update `".$this->rzvy_categories."` set `position`='".$position."' where `id`='".$id."'";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}
}
?>