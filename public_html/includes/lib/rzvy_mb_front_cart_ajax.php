<?php 
/* Include class files */
include(dirname(dirname(dirname(__FILE__)))."/constants.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_manual_booking.php");
include(dirname(dirname(dirname(__FILE__)))."/classes/class_settings.php");

/* Create object of classes */

$obj_frontend = new rzvy_manual_booking();
$obj_frontend->conn = $conn;

$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

$rzvy_date_format = $obj_settings->get_option('rzvy_date_format');
$rzvy_time_format = $obj_settings->get_option('rzvy_time_format');

/* add to cart item ajax */
if(isset($_POST['add_to_cart_item'])){
	$id = $_POST['id'];
	$qty = $_POST['qty'];
	
	if($_POST['qty']>0){
		/** Add and update item into cart **/
		$obj_frontend->addon_id = $id;
		$addon_rate = $obj_frontend->get_addon_rate();
		$rate = ($addon_rate['rate']*$qty);
		$duration = ($addon_rate['duration']*$qty);
		$item_arr = array();
		$item_arr['id'] = $id;
		$item_arr['qty'] = $qty;
		$item_arr['rate'] = $rate;
		$item_arr['duration'] = $duration;
		
		$cart_item_key = $obj_frontend->rzvy_check_existing_cart_item($_SESSION['rzvy_mb_cart_items'], $id);
		if(is_numeric($cart_item_key)){
			$_SESSION['rzvy_mb_cart_items'][$cart_item_key] = $item_arr;
			$_SESSION['rzvy_mb_cart_items'] = array_values($_SESSION['rzvy_mb_cart_items']);
		}else{
			array_push($_SESSION['rzvy_mb_cart_items'], $item_arr);
			$_SESSION['rzvy_mb_cart_items'] = array_values($_SESSION['rzvy_mb_cart_items']);
		}
		
		$subtotal = $_SESSION['rzvy_mb_cart_service_price'];
		foreach($_SESSION['rzvy_mb_cart_items'] as $val){ 
			$subtotal = $subtotal+$val['rate'];
		} 
		$_SESSION['rzvy_mb_cart_subtotal'] = $subtotal;
		$_SESSION['rzvy_mb_cart_nettotal'] = $subtotal;
	}else{
		/** remove item from cart **/	
		$subtotal = $_SESSION['rzvy_mb_cart_service_price'];
		foreach($_SESSION['rzvy_mb_cart_items'] as $val){ 
			$subtotal = $subtotal+$val['rate'];
		} 
		$cart_item_key = $obj_frontend->rzvy_check_existing_cart_item($_SESSION['rzvy_mb_cart_items'], $id);
		if(is_numeric($cart_item_key)){
			$subtotal = $subtotal-$_SESSION['rzvy_mb_cart_items'][$cart_item_key]['rate'];
			if ($subtotal < 0){
				$_SESSION['rzvy_mb_cart_subtotal'] = 0;
				$_SESSION['rzvy_mb_cart_nettotal'] = 0;
			}else{
				$_SESSION['rzvy_mb_cart_subtotal'] = $subtotal;
				$_SESSION['rzvy_mb_cart_nettotal'] = $subtotal;
			}
			unset($_SESSION['rzvy_mb_cart_items'][$cart_item_key]);
			$_SESSION['rzvy_mb_cart_items'] = array_values($_SESSION['rzvy_mb_cart_items']);
		}
	}
}

/* refresh cart sidebar ajax */
else if(isset($_POST['refresh_cart_sidebar'])){ 
	if($_SESSION['rzvy_mb_cart_service_id']!="" && $_SESSION['rzvy_mb_cart_service_id']>0){
		$rzvy_currency_symbol = $obj_settings->get_option('rzvy_currency_symbol');
		$rzvy_currency_position = $obj_settings->get_option('rzvy_currency_position');
		?>
		<ul class="rzvy_cart_items_list">
			<li class="rzvy_cart_items_list_li">
				<i class="fa fa-bookmark" aria-hidden="true"></i>
				<p>
					<?php 
					$obj_frontend->category_id = $_SESSION['rzvy_mb_cart_category_id'];
					$category_name = $obj_frontend->readone_category_name(); 
					echo ucwords($category_name); 
					?>
				</p>
			</li>
			<li class="rzvy_cart_items_list_li">
				<i class="fa fa-paint-brush" aria-hidden="true"></i>
				<p>
					<?php 
					$obj_frontend->service_id = $_SESSION['rzvy_mb_cart_service_id'];
					$readone_service = $obj_frontend->readone_service(); 
					$service_name = ucwords($readone_service["title"]); 
					$service_rate = $readone_service['rate']; 
					echo ucwords($service_name); 
					?>
					<span class="pull-right"><?php if($service_rate>0){ echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$service_rate); } ?></span>
				</p>
			</li>
			<?php 
			if($_SESSION['rzvy_mb_cart_datetime'] != "" && $_SESSION['rzvy_mb_cart_end_datetime'] != ""){ 
				$rzvy_cart_date = date($rzvy_date_format, strtotime($_SESSION['rzvy_mb_cart_datetime'])); 
				$rzvy_cart_starttime = date($rzvy_time_format, strtotime($_SESSION['rzvy_mb_cart_datetime'])); 
				$rzvy_cart_endtime = date($rzvy_time_format, strtotime($_SESSION['rzvy_mb_cart_end_datetime'])); 
				?>
				<li class="rzvy_cart_items_list_li">
					<i class="fa fa-calendar" aria-hidden="true"></i>
					<p><?php echo $rzvy_cart_date." ".$rzvy_cart_starttime." to ".$rzvy_cart_endtime; ?></p>
				</li>
			<?php 
			} 
			?>
			<?php 
			if($_SESSION['rzvy_mb_cart_freqdiscount_key'] != ""){ 
				?>
				<li class="rzvy_cart_items_list_li">
					<i class="fa fa-refresh" aria-hidden="true"></i>
					<p><?php echo $_SESSION['rzvy_mb_cart_freqdiscount_label']; ?></p>
				</li>
			<?php 
			} 
			if(sizeof($_SESSION['rzvy_mb_cart_items'])>0){
				?>
				<li class="rzvy_cart_items_list_li">
					<i class="fa fa-puzzle-piece" aria-hidden="true"></i>
					<p><?php if(isset($rzvy_translangArr['addons'])){ echo $rzvy_translangArr['addons']; }else{ echo $rzvy_defaultlang['addons']; } ?>:</p>
				</li>
				<li class="rzvy_cart_items_list_li">
					<div class="rzvy_cart_addons_list">
						<?php 
						foreach($_SESSION['rzvy_mb_cart_items'] as $val){ 
							$obj_frontend->addon_id = $val['id'];
							$addon_name = $obj_frontend->readone_addon_name(); 
							?>
							<label class="col-md-12">
								<a class="rzvy_remove_addon_from_cart" href="javascript:void(0)" data-id="<?php echo $val['id']; ?>"><i class="fa fa-trash rzvy_remove_addon_icon" aria-hidden="true"></i></a> &nbsp; 
								<?php echo ucwords($addon_name); if($val['qty']>1){ echo " - ".$val['qty']; } ?>
								<span class="pull-right"><?php if($val['rate']>0){ echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$val['rate']); } ?></span>
							</label>
							<?php 
						} 
						?>
					</div>
				</li>
				<?php 
			} 
			if($_SESSION['rzvy_mb_cart_subtotal']>0){
				?>
				<hr />
				<li class="rzvy_cart_items_list_li">
					<i class="fa fa-money" aria-hidden="true"></i> 
					<p>
						<?php if(isset($rzvy_translangArr['sub_total'])){ echo $rzvy_translangArr['sub_total']; }else{ echo $rzvy_defaultlang['sub_total']; } ?>
						<span class="pull-right"><?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$_SESSION['rzvy_mb_cart_subtotal']); ?></span>
					</p>
				</li>
				<?php 
				if($_SESSION['rzvy_mb_cart_freqdiscount']>0){ 
					?>
					<li class="rzvy_cart_items_list_li">
						<i class="fa fa-percent" aria-hidden="true"></i> 
						<p>
							<?php if(isset($rzvy_translangArr['frequently_discount'])){ echo $rzvy_translangArr['frequently_discount']; }else{ echo $rzvy_defaultlang['frequently_discount']; } ?>
							<span class="pull-right">-<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$_SESSION['rzvy_mb_cart_freqdiscount']); ?></span>
						</p>
					</li>
				<?php 
				} 
				if($_SESSION['rzvy_mb_cart_coupondiscount']>0){ 
					?>
					<li class="rzvy_cart_items_list_li">
						<i class="fa fa-ticket" aria-hidden="true"></i> 
						<p>
							<?php if(isset($rzvy_translangArr['coupon_discount'])){ echo $rzvy_translangArr['coupon_discount']; }else{ echo $rzvy_defaultlang['coupon_discount']; } ?>
							<span class="pull-right">-<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$_SESSION['rzvy_mb_cart_coupondiscount']); ?></span>
						</p>
					</li>
				<?php 
				} 
				if($_SESSION['rzvy_mb_cart_tax']>0){ 
					?>
					<li class="rzvy_cart_items_list_li">
						<i class="fa fa-tags" aria-hidden="true"></i> 
						<p>
							<?php if(isset($rzvy_translangArr['tax'])){ echo $rzvy_translangArr['tax']; }else{ echo $rzvy_defaultlang['tax']; } ?>
							<span class="pull-right">+<?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$_SESSION['rzvy_mb_cart_tax']); ?></span>
						</p>
					</li>
					<?php 
				} 
			}
			?>
		</ul>
		<?php if($_SESSION['rzvy_mb_cart_subtotal']>0){ ?>
			<h4><?php if(isset($rzvy_translangArr['net_total'])){ echo $rzvy_translangArr['net_total']; }else{ echo $rzvy_defaultlang['net_total']; } ?><span><?php echo $obj_settings->rzvy_currency_position($rzvy_currency_symbol,$rzvy_currency_position,$_SESSION['rzvy_mb_cart_nettotal']); ?></span></h4>
		<?php 
		}else{
			echo "<br />";
		}
	}else{ 
		?>
		<label><?php if(isset($rzvy_translangArr['no_items_in_cart'])){ echo $rzvy_translangArr['no_items_in_cart']; }else{ echo $rzvy_defaultlang['no_items_in_cart']; } ?></label>
		<?php 
	}
}