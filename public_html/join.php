<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="cache-control" content="no-cache" />
      <meta http-equiv="Pragma" content="no-cache" />
      <meta http-equiv="Expires" content="-1" />
      <link rel="shortcut icon" type="image/png" href="includes/images/favicon.ico" />
      <title>Singapore Part-time Maid | Part-time Helper</title>
      <meta name="description" content="Book your part-time maids and part-time helper. We provide household cleaning service, babysitters, elderly cares at affordable rates. Book your appointment now!">
      <link href="includes/css/flags.min.css" rel="stylesheet" type="text/css" media="all">
      <link href="includes/css/jquery.datetimepicker.min.css" rel="stylesheet" type="text/css" media="all">
      <link href="includes/css/owl.carousel.min.css" rel="stylesheet" type="text/css" media="all">
      <link href="includes/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
      <link href="includes/vendor/bootstrap/css/bootstrap-select.min.css"  rel="stylesheet" type="text/css" media="all" />
      <link href="includes/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all"/>
      <link href="includes/front/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css" media="all"/>
      <link href="includes/vendor/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" media="all"/>
      <link href="includes/vendor/intl-tel-input/css/intlTelInput.css" rel="stylesheet" type="text/css" media="all" />
      <link href="includes/front/css/rzvy-front-calendar-style.css" rel="stylesheet" type="text/css" media="all"/>
      <link href="includes/front/css/rzvy-front-style.css?1650878645" rel="stylesheet" type="text/css" media="all"/>
      <!-- Bootstrap core JavaScript and Page level plugin JavaScript-->
      <script src="includes/front/js/jquery-3.2.1.min.js?1650878645"></script>
      <script src="includes/front/js/popper.min.js?1650878645"></script>
      <script src="includes/front/js/bootstrap.min.js?1650878645"></script>
      <script src="includes/vendor/bootstrap/js/bootstrap-select.min.js?1650878645"></script>
      <script src="includes/front/js/slick.min.js?1650878645"></script>
      <script src="includes/js/bootstrap.bundle.min.js"></script>
      <script src="includes/js/owl.carousel.min.js"></script>
      <script src="includes/js/rzvy-common-front.js?1650878645"></script>
      <script src="includes/js/jquery.datetimepicker.full.min.js"></script>
      <!--------------- FONTS END ----------------->
   </head>
   <body class="rzvy">

 


<?php 
	 
	 
include(dirname(__FILE__)."/constants.php"); 


$obj_database->check_admin_setup_detail($conn);


include(dirname(__FILE__)."/classes/class_settings.php");


$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

 $saiframe = '';
 if(isset($_GET['if'])){
 $saiframe = '?if=y';  
 }
		
		
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
?>
	  
     <?php include('header2.php') ?>
	  
	 
      <main class="form-style-two rzvy-booking-detail-body">
	  
		<div class="container">    
		  <div class="row content">
			<div class="col-sm-6 sidenav">
				<p>
				
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	

				<br><br>
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	
				
				
				
				<br><br>				
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	
                </p>				
			  </div>
<style>
    .joinform{ 
	background: #ffffff;
    border-radius: 20px;
    transition: all ease .4s;
    box-shadow: 0 0 20px rgb(0 0 0 / 5%);
    z-index: 2;
	padding: 41px;
	}
	

</style>			  
			  <div class="col-sm-6 sidenav">
				<form class="joinform">
				  <div class="form-row row">
					<div class="form-group col-sm-6">
					  <label for="inputEmail4">Email</label>
					  <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
					</div>
					<div class="form-group col-sm-6">
					  <label for="inputPassword4">Password</label>
					  <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
					</div>
			 
				  <div class="form-group col-sm-12">
					<label for="inputAddress">Address</label>
					<input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
				  </div>
				  <div class="form-group col-sm-12">
					<label for="inputAddress2">Address 2</label>
					<input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
				  </div>
				  
					<div class="form-group col-sm-6">
					  <label for="inputCity">City</label>
					  <input type="text" class="form-control" id="inputCity">
					</div>
					<div class="form-group col-sm-6">
					  <label for="inputState">State</label>
					  <select id="inputState" class="form-control">
						<option selected>Choose...</option>
						<option>...</option>
					  </select>
					</div>
 
		 
				  <div class="form-group col-sm-12">
					<div class="form-check">
					  <input class="form-check-input" type="checkbox" id="gridCheck">
					  <label class="form-check-label" for="gridCheck">
						Check me out
					  </label>
					</div>
				  </div>
				  <div class="form-group col-sm-12">
				  <button type="submit" class="btn btn-success w-100">Sign in</button>
				  </div>
				</form>				
			  </div>
			  </div>
		</div>	  
	  
      </main>
      <?php include('footer.php') ?>
      <script src="https://js.stripe.com/v3/"></script>
      <script src="includes/front/js/rzvy-front-jquery.js?1650878645"></script>
      <script src="includes/js/rzvy-set-languages.js?1650878645"></script>
   </body>
</html>