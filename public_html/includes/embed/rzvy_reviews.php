<?php 
require_once(dirname(dirname(dirname(__FILE__))).'/constants.php'); 

/* Include class files */
include(dirname(dirname(dirname(__FILE__)))."/classes/class_settings.php");
/* Create object of classes */
$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

/* Include class files */
include(dirname(dirname(dirname(__FILE__)))."/classes/class_frontend.php");
/* Create object of classes */
$obj_frontend = new rzvy_frontend();
$obj_frontend->conn = $conn; 

$reviewtype = 'all';
if(isset($_GET['c']) && $_GET['c']!=''){
	$reviewtype = $_GET['c'];
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="-1" />
		<link rel="shortcut icon" type="image/png" href="<?php  echo SITE_URL; ?>includes/images/favicon.ico" />
		<link href="<?php echo SITE_URL; ?>includes/css/owl.carousel.min.css" rel="stylesheet" type="text/css" media="all">
		<link href="<?php echo SITE_URL; ?>includes/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
		<link href="<?php echo SITE_URL; ?>includes/vendor/bootstrap/css/bootstrap-select.min.css"  rel="stylesheet" type="text/css" media="all" />
		<link href="<?php echo SITE_URL; ?>includes/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all"/>
		<link href="<?php echo SITE_URL; ?>includes/stepview/rzvy-stepview.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="all"/>
		<!-- Bootstrap core JavaScript and Page level plugin JavaScript-->
		<script type="text/javascript" src="<?php echo SITE_URL; ?>includes/front/js/jquery-3.2.1.min.js"></script>
			<script src="<?php echo SITE_URL; ?>includes/js/owl.carousel.min.js"></script>
		<script>
		$(document).ready(function() {
			$('.owl-carousel').each(function() {
			var $carousel = $(this);
			var $items = ($carousel.data('items') !== undefined) ? $carousel.data('items') : 1;
			var $items_lg = ($carousel.data('items-lg') !== undefined) ? $carousel.data('items-lg') : 1;
			var $items_md = ($carousel.data('items-md') !== undefined) ? $carousel.data('items-md') : 1;
			var $items_sm = ($carousel.data('items-sm') !== undefined) ? $carousel.data('items-sm') : 1;
			var $items_ssm = ($carousel.data('items-ssm') !== undefined) ? $carousel.data('items-ssm') : 1;
			$carousel.owlCarousel ({
			  loop : ($carousel.data('loop') !== undefined) ? $carousel.data('loop') : true,
			  items : $carousel.data('items'),
			  margin : ($carousel.data('margin') !== undefined) ? $carousel.data('margin') : 0,
			  dots : ($carousel.data('dots') !== undefined) ? $carousel.data('dots') : true,
			  nav : ($carousel.data('nav') !== undefined) ? $carousel.data('nav') : false,
			  navText : ["<div class='slider-no-current'><span class='current-no'></span><span class='total-no'></span></div><span class='current-monials'></span>", "<div class='slider-no-next'></div><span class='next-monials'></span>"],
			  autoplay : ($carousel.data('autoplay') !== undefined) ? $carousel.data('autoplay') : false,
			  autoplayTimeout : ($carousel.data('autoplay-timeout') !== undefined) ? $carousel.data('autoplay-timeout') : 5000000,
			  animateIn : ($carousel.data('animatein') !== undefined) ? $carousel.data('animatein') : false,
			  animateOut : ($carousel.data('animateout') !== undefined) ? $carousel.data('animateout') : false,
			  mouseDrag : ($carousel.data('mouse-drag') !== undefined) ? $carousel.data('mouse-drag') : true,
			  autoWidth : ($carousel.data('auto-width') !== undefined) ? $carousel.data('auto-width') : false,
			  autoHeight : ($carousel.data('auto-height') !== undefined) ? $carousel.data('auto-height') : false,
			  center : ($carousel.data('center') !== undefined) ? $carousel.data('center') : false,
			  responsiveClass: true,
			  dotsEachNumber: true,
			  smartSpeed: 600,
			  autoplayHoverPause: true,
			  responsive : {
				0 : {
				  items : $items_ssm,
				},
				480 : {
				  items : $items_sm,
				},
				768 : {
				  items : $items_md,
				},
				992 : {
				  items : $items_lg,
				},
				1200 : {
				  items : $items,
				}
			  }
			});
			var totLength = $('.owl-dot', $carousel).length;
			$('.total-no', $carousel).html(totLength);
			$('.current-no', $carousel).html(totLength);
			$carousel.owlCarousel();
			$('.current-no', $carousel).html(1);
			$carousel.on('changed.owl.carousel', function(event) {
			  var total_items = event.page.count;
			  var currentNum = event.page.index + 1;
			  $('.total-no', $carousel ).html(total_items);
			  $('.current-no', $carousel).html(currentNum);
			});
		  });
		});
		</script>
	
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
	<body class="rzvy rzvy-booking-detail-body" onscroll="parent.postMessage(document.body.scrollHeight, '*');" onload="parent.postMessage(document.body.scrollHeight, '*');">
		<div class="rzvy-wizard bg-white">
			<main class="px-0 py-0">
				<div class="step-item">
					<?php 						
					/* Booking Reviews */								
					$rzvy_reviews = 'N';
					$reviewlimit = $obj_settings->get_option("rzvy_ratings_limit");
					$all_reviews = $obj_frontend->get_all_reviews_embed($reviewlimit,$reviewtype);
					$total_reviews = mysqli_num_rows($all_reviews);
					if($total_reviews>0){ 
						$rzvy_reviews = 'Y';
					}
				
					if($rzvy_reviews=='Y'){ 
					?> 
					<div class="rzvy-bookingreviews">							
						<div class="owl-carousel rzvy-sidebar-block-content" data-items="4" data-items-lg="4" data-items-md="2" data-items-sm="1" data-items-ssm="1" data-margin="24" data-nav="true" data-dots="false" data-loop="false" data-autoplay="true" data-autoplay-timeout="5000">
							<?php 
							while($reviews = mysqli_fetch_array($all_reviews)){ 
								$staffnameinfo = $obj_frontend->get_rating_staff($reviews['order_id']);
								$reviewmonthname = strtolower(date('M',strtotime($reviews['review_datetime'])));
								?>
								<div class="item">												 
								  <div class="testimonial-item">
									<div class="author-wrap">
									  <img src="<?php echo SITE_URL;?>includes/images/author.png" alt="<?php echo ucwords($reviews['c_firstname'].' '.$reviews['c_lastname']); ?>">
									  <div>
										<h3 class="fw-bold"><?php echo ucwords($reviews['c_firstname']); if($reviews['c_lastname']!=''){ echo ' '.ucwords(mb_substr($reviews['c_lastname'],0,1)).'.';}?></h3>
										<div class="rating">
										  <?php 
											if($reviews['rating']>0){
												for($star_ir=0;$star_ir<$reviews['rating'];$star_ir++){ 
													?>
													<i class="fa fa-star" aria-hidden="true"></i>
													<?php 
												} 
												for($star_jr=0;$star_jr<(5-$reviews['rating']);$star_jr++){ 
													?>
													<i class="fa fa-star-o" aria-hidden="true"></i>
													<?php 
												} 
											}else{ 
												?>
												<i class="fa fa-star-o" aria-hidden="true"></i>
												<i class="fa fa-star-o" aria-hidden="true"></i>
												<i class="fa fa-star-o" aria-hidden="true"></i>
												<i class="fa fa-star-o" aria-hidden="true"></i>
												<i class="fa fa-star-o" aria-hidden="true"></i>
												<?php 
											} 
											?>
										</div>
									  </div>
									</div>
									<div class="text-start text-break"><?php echo ucfirst($reviews['review']); ?></div>
									<div class="small text-start mt-3"><?php if(isset($rzvy_translangArr['staff_review_front'])){ echo $rzvy_translangArr['staff_review_front']; }else{ echo $rzvy_defaultlang['staff_review_front']; } ?><b class="rzvy-bold"><?php echo ucwords($staffnameinfo['firstname']); if($staffnameinfo['lastname']!=''){ echo ' '.ucwords(mb_substr($staffnameinfo['lastname'],0,1)).'.';}?></b> (<?php echo date('d ',strtotime($reviews['review_datetime'])); ?><?php if(isset($rzvy_translangArr[$reviewmonthname])){ echo $rzvy_translangArr[$reviewmonthname]; }else{ echo $rzvy_defaultlang[$reviewmonthname]; } ?>)</div>
								  </div>
								</div>
							<?php } ?>
						</div>
					</div>	
					<?php }else{
						echo '<div class="d-flex justify-content-center">';
							if(isset($rzvy_translangArr['no_review_found'])){ echo $rzvy_translangArr['no_review_found']; }else{ echo $rzvy_defaultlang['no_review_found']; }
						echo '</div>';
					} ?>
				</div>					
			</main>					
		</div>	
	</body>
</html>