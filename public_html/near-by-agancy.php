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
        <style>
            .maid-agency-detail {
                padding: 21px;
            }



        </style>
        <?php
        include(dirname(__FILE__) . "/constants.php");


        $obj_database->check_admin_setup_detail($conn);


        include(dirname(__FILE__) . "/classes/class_settings.php");


        $obj_settings = new rzvy_settings();
        $obj_settings->conn = $conn;
		
		$saiframe = '';
		if(isset($_GET['if'])){
			$saiframe = '?if=y';  
		}		

        /* check location selector status */
        $rzvy_location_selector_status = $obj_settings->get_option("rzvy_location_selector_status");
        if ($rzvy_location_selector_status == "N" || $rzvy_location_selector_status == "") {
            $show_location_selector = "N";
            $_SESSION['rzvy_location_selector_zipcode'] = "N/A";
        }
        if (isset($_SESSION["rzvy_location_selector_zipcode"])) {
            if ($rzvy_location_selector_status == "Y" && ($_SESSION["rzvy_location_selector_zipcode"] == "" && $_SESSION["rzvy_location_selector_zipcode"] != "N/A")) {
                $show_location_selector = "Y";
                $_SESSION['rzvy_location_selector_zipcode'] = "";
            }
        }
        ?>
        <?php include('header2.php') ?>
        <main class="form-style-two rzvy-booking-detail-body">
            <div class="container">
                <div class="row content">

                    <?php
					$regionID = $_GET['id'];
					$queryregion=mysqli_query($con,"select *  from region where id = '$regionID'");
					$rowregion=mysqli_fetch_array($queryregion);
		 
					$name= $rowregion['region_name'];
					
					 $latitude= $rowregion['latitude'];
					
					 $longitude= $rowregion['longitude'];
					?>
					
					
		        <?php

				$lat = $latitude;  
				$lon = $longitude;
				$distance = 30; //your distance in KM
				$R = 6371; //constant earth radius. You can add precision here if you wish

				$maxLat = $lat + rad2deg($distance/$R);
				$minLat = $lat - rad2deg($distance/$R);
				$maxLon = $lon + rad2deg(asin($distance/$R) / cos(deg2rad($lat)));
				$minLon = $lon - rad2deg(asin($distance/$R) / cos(deg2rad($lat)));

                //echo "<br> Max Latitude ", $maxLat, "<br> Min Latitude", $minLat, "<br> Max Longitude ", $maxLon, "<br> Min Longitude ", $minLon;
				
				?>
				
				

                        <?php
						
						//Find Total Agancy
						
						
						
                        $querytotal = mysqli_query($conn, "SELECT count(*) AS TA
						FROM rzvy_agency
						WHERE latitude BETWEEN '$minLat' AND '$maxLat' 
						UNION 
						SELECT count(*) AS TA
						FROM rzvy_agency
						WHERE longitude BETWEEN '$maxLon' AND '$minLon'");
                        
						$rowquerytotal = mysqli_fetch_array($querytotal);
                        $totalagancy = $rowquerytotal['TA'];
						
						
                        ?>	


                        <?php
						
						//Find Near Agancy
						
						
                        $querynear = mysqli_query($conn, "SELECT id,`name`,latitude,longitude
						FROM rzvy_agency
						WHERE latitude BETWEEN '$minLat' AND '$maxLat'  
						UNION 
						SELECT id,`name`,latitude,longitude
						FROM rzvy_agency
						WHERE longitude BETWEEN '$maxLon' AND '$minLon' 
						ORDER BY id ASC  LIMIT 1");
                        
						$rownear = mysqli_fetch_array($querynear);
                        $nearagancy = $rownear['name'];
						$nearagancylatitude = $rownear['latitude'];
						$nearagancylongitude = $rownear['longitude'];
						
                        ?>




                       <?php
					   
					   //Find Distance In km 

					  $theta = $longitude - $nearagancylongitude;
					  $dist = sin(deg2rad($latitude)) * sin(deg2rad($nearagancylatitude)) +  cos(deg2rad($latitude)) * cos(deg2rad($nearagancylatitude)) * cos(deg2rad($theta));
					  $dist = acos($dist);
					  $dist = rad2deg($dist);
					  $miles = $dist * 60 * 1.1515;
					  
					   $distance = $miles * 1.609344;
					   

                        ?>


						
					<div class="col-md-12" style="padding-bottom: 12px;">
 
					<p style="color: #fff!important;font-size: 17px;font-weight: 300;background: #e16d30;padding: 10px;border: solid 1px #e2e2e2;box-shadow: 0px 2px 6px rgba(0,0,0,0.2);">
					 Part Time Maid Agancy In 	<?php echo $name; ?> <br>				
					 Fount <?php echo $totalagancy; ?> agancies in this <?php echo $name; ?> <br>
					 The nearest is <?php echo $nearagancy; ?> ,it is <?php echo round($distance,2); ?> km away fom the center of <?php echo $name; ?>
					</p>
					<hr>
				    </div>
		 
		 
		 
		 

		 
		 
		 
		 
		 
		 
		 
		 
		 
					
				   <div class="col-md-12" style="padding-bottom: 12px;">
				       <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWyAzig2f4e2rKUKByuE8Wq0CmwX618Gw&sensor=false"></script>
 
						<div id="googleMap" style="width: 100%; height: 400px;"></div>
 
						<script type="text/javascript">
						var locationArray = [
						
					 <?php
					 $querymap=mysqli_query($con,"SELECT id,`name`, latitude,longitude
						FROM rzvy_agency
						WHERE latitude BETWEEN '$minLat' AND '$maxLat' 
						UNION 
						SELECT id,`name`, latitude,longitude
						FROM rzvy_agency
						WHERE longitude BETWEEN '$maxLon' AND '$minLon'");
						
					while($rowmap=mysqli_fetch_array($querymap))
					{
					$name= $rowmap['name'];
					$latitude= $rowmap['latitude'];
                    $longitude= $rowmap['longitude'];
					?>	
						  ['<?php echo $name ;?>', <?php echo $latitude ;?>, <?php echo $longitude ;?>],
					 
						  
					<?php } ?>

						];

						var map = new google.maps.Map(document.getElementById('googleMap'), {
						  zoom: 10,
						  center: new google.maps.LatLng(<?php echo $lat ;?>,<?php echo $lon ;?>),
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
				   </div>

                    <div class="col-sm-12">

                        <?php
                        $query = mysqli_query($conn, "SELECT *
						FROM rzvy_agency
						WHERE latitude BETWEEN '$minLat' AND '$maxLat' 
						UNION 
						SELECT *
						FROM rzvy_agency
						WHERE longitude BETWEEN '$maxLon' AND '$minLon'");
                        $rowcount = mysqli_num_rows($query);
                        if ($rowcount == 0) {
                            ?>
                            <p style="color:red">No record found</p> 
                            <?php
                        } else {
                            while ($row = mysqli_fetch_array($query)) {
                                ?>

                                <?php
                                $name = explode(' ', $row['name']);
                                $name1 = strtolower(implode('-', $name));
                                ?>
                                                <!--<a href="part-time-maid-details.php?id=<?php echo $row['id']; ?>">-->
                                
                                    <div class="card ">
                                        <div class="row ">
                                            <div class="col-sm-8">
                                                <div class=" ">
                                                    <div class="maid-agency-detail">
                                                        <strong style="font-weight: 700;">Agency Name:</strong>       
														<a href="<?php echo $name1 . '-' .$row['id'].'.html' ?>"><?php echo $row['name']; ?></a><br>
                                                        
														<?php if($row['address'] !=""){ ?>
                                                        <strong style="font-weight: 700;">Address:</strong> <?php echo $row['address']; ?><br> <?php echo $row['city']; ?><br><?php echo $row['state']; ?> <?php echo $row['zip']; ?><br>
														<?php } ?>
                                                        <?php if($row['phone'] !=""){ ?>
														<strong style="font-weight: 700;">Tel:</strong> <?php echo $row['phone']; ?><br>
														<?php } ?>
														
														
														
                                                        <strong style="font-weight: 700;">E-mail: </strong> <a href="mailto:<?php echo $row['email']; ?>" class="email"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $row['email']; ?></a><br>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <!--<a href="part-time-maid-details.php?id=<?php echo $row['id']; ?>">-->
                                               <a href="<?php echo $name1 . '-' .$row['id'].'.html' ?>"> 
                                                    <img class="card-img-top" src="agency/<?php echo $row['photos']; ?>" alt="Card image cap" style="width: 100%;height:162px;object-fit:contain;padding:20px">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                 
                                <br>
                            <?php
                            }
                        }
                        ?>
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