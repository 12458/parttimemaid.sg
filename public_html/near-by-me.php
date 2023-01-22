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
			<div class="col-sm-12 sidenav">
		 
 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWyAzig2f4e2rKUKByuE8Wq0CmwX618Gw&sensor=false"></script>
 
    <div id="googleMap" style="width: 100%; height: 400px;"></div>
    <?php
	
	$name = 'Pune Near Kalakhet Near raod No 5';
	?>
    <script type="text/javascript">
    var locationArray = [
	
 <?php
 $querymap=mysqli_query($con,"select *  from rzvy_agency");
while($rowmap=mysqli_fetch_array($querymap))
{
$name= $rowmap['name'];
$longitude= $rowmap['longitude'];
$latitude= $rowmap['latitude'];
?>	
      ['<?php echo $name ;?>', <?php echo $latitude ;?>, <?php echo $longitude ;?>],
 
	  
<?php } ?>

    ];

    var map = new google.maps.Map(document.getElementById('googleMap'), {
      zoom: 10,
      center: new google.maps.LatLng(1.3646673,103.8559692),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locationArray.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locationArray[i][1], locationArray[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locationArray[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
    </script>
 
 
				
                <div class="card" style="width: 100%;">
				  <ul class="list-group list-group-flush">
				  
											<?php
											 
                                            $query=mysqli_query($conn,"select *  from region");
											$rowcount=mysqli_num_rows($query);
											if($rowcount==0)
											{
											?>
											<p style="color:red">No record found</p> 
											<?php 
											} else {
											while($row=mysqli_fetch_array($query))
											{
											?>

											<?php
											$name = explode(' ', $row['region_name']);
											$name1 = strtolower(implode('-', $name));
											?>

								
											
					 <a href="near-by-agancy.php?id=<?php echo $row['id']; ?>"> 
					 <li class="list-group-item">Agancy In <?php echo $row['region_name']; ?></li>
					 </a>

                    <?php } } ?>
				  </ul>
				</div>				
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