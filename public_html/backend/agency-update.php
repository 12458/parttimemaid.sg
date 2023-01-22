 

<?php

include('../db.php');


if(isset($_POST['submit']))
{
$name=$_POST['name'];
$phone=$_POST['phone'];
$address=$_POST['address'];
$city=$_POST['city'];
$zip=$_POST['zip'];
$country=$_POST['country'];
$show_ratings=$_POST['show_ratings'];
$show_completed=$_POST['show_completed'];
$show_email=$_POST['show_email'];
$show_phone=$_POST['show_phone'];
$show_staff=$_POST['show_staff'];
$longitude=$_POST['longitude'];
$latitude=$_POST['latitude'];
$description=$_POST['description'];
$email=$_POST['email'];
  

$catid=intval($_GET['id']);
 

 $image = $_FILES['photos']['name'];
 $image_temp = $_FILES['photos']['tmp_name'];
 move_uploaded_file($image_temp ,"../agency/$image");


if(empty($image)){		 
$query=mysqli_query($con,"UPDATE  rzvy_agency SET  `name`='$name',`phone`='$phone',`address`='$address',`city`='$city',`zip`='$zip',`country`='$country',`show_ratings`='$show_ratings',`show_completed`='$show_completed',`show_email`='$show_email',`show_phone`='$show_phone',`show_staff`='$show_staff',`longitude`='$longitude',`latitude`='$latitude',`description`='$description',`email`='$email' where id='$catid'");
}

else{
	
$query=mysqli_query($con,"UPDATE  rzvy_agency SET  `name`='$name',`phone`='$phone',`address`='$address',`city`='$city',`zip`='$zip',`country`='$country',`show_ratings`='$show_ratings',`show_completed`='$show_completed',`show_email`='$show_email',`show_phone`='$show_phone',`show_staff`='$show_staff',`longitude`='$longitude',`latitude`='$latitude',`email`='$email',`photos`='$image',`description`='$description' where id='$catid'");	
	
}


if($query)
{
$msg="Client created ";
}
else{
$error="Something went wrong . Please try again.";    
} 

}
?> 
 


<?php include 'header.php'; 
  if(!isset($rzvy_rolepermissions['rzvy_staff']) && $rzvy_loginutype=='staff'){ ?>
<div class="container mt-12">
  <div class="row mt-5">
    <div class="col-md-12">&nbsp;</div>
  </div>
  <div class="row mt-5">
    <div class="col-md-2 text-center mt-5">
      <i class="fa fa-exclamation-triangle fa-5x"></i>
    </div>
    <div class="col-md-10 mt-5">
      <p><?php if(isset($rzvy_translangArr['permission_error_message'])){ echo $rzvy_translangArr['permission_error_message']; }else{ echo $rzvy_defaultlang['permission_error_message']; } ?></p>
    </div>
  </div>
</div>
<?php die(); } ?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="<?php echo SITE_URL; ?>backend/appointments.php"><i class="fa fa-home"></i></a>
  </li>
  <li class="breadcrumb-item active">Agency</li>
</ol>
<!-- Staff DataTables Card-->
<div class="card mb-2">
  <div class="card-body">
    <div class="row">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-header border-0">
                  <b class="pull-left">Agency Member</b>
				  <?php if(isset($rzvy_rolepermissions['rzvy_staff_add']) || $rzvy_loginutype=='admin'){ ?>
					<a class="btn btn-link pull-right py-0 pl-2 pr-0 text-primary" data-toggle="modal" data-target="#rzvy-add-staff-modal"><i class="fa fa-user-plus"></i></a>
				  <?php } if(isset($rzvy_rolepermissions['rzvy_staff_reorder']) || $rzvy_loginutype=='admin'){ ?>
					<a class="btn btn-link pull-right py-0 px-1 text-primary" data-toggle="modal" data-target="#rzvy-reorder-staff-modal"><i class="fa fa-sort"></i></a>
				  <?php } ?>
                </div>
                <div class="card-body p-0 border-0">
                  <ul class="list-group" id="rzvy-staff-list">

											<?php
                                            $query=mysqli_query($con,"select *  from rzvy_agency");
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
				<a href="agency-update.php?id=<?php echo $row['id'];?>">
				<li  class="rzvy-staff-selection list-group-item border-0">
                <img class="rounded mr-2" src="../agency/<?php echo $row['photos']; ?>" onerror="this.onerror=null;this.src='https://techwingspace.com/rezervy/includes/images/staff-sm.png';" alt="logo" title="">
				<?php echo $row['name'];?> <?php echo $row['lastname'];?></li>
                </a>
											<?php } } ?>
                  </ul>
                </div>
              </div>
            </div>
			
<?php 
$catid=intval($_GET['id']);
$query=mysqli_query($con,"SELECT * from rzvy_agency where  id='$catid'");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>			
      <div id="rzvy-staff-detail-card" class="col-md-8 mb-3">
        <div class="card">
          <div class="card-body p-0">
            <div class="rzvy-tabbable-panel">
              <div class="rzvy-tabbable-line">
                <ul class="nav nav-tabs">
                  <li class="nav-item active custom-nav-item" id="rzvy_staff_detail_tab_selection" data-id="1">
                    <a class="nav-link custom-nav-link rzvy_tab_view_nav_link" data-tabno="0" data-toggle="tab" href="#rzvy_staff_detail"><i class="fa fa-info-circle"></i> Detail</a>
                  </li>
 
                </ul>
                <div id="rzvy-staff-tab-content" class="tab-content py-4">

                  <div class="tab-pane container active" id="detail">
                    <form name="detail_form"  enctype='multipart/form-data'  action="agency-update.php?id=<?php echo $_GET['id']; ?>" method="post">
                      <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id">
 
                      <div class="form-group row">
                        <div class="col-md-3">
                          <div class="rzvy-image-upload">
                            <div class="rzvy-image-edit-icon">
                              <input type="hidden" id="rzvy-image-upload-file-hidden" name="photos">
                              <input type="file" name="photos" id="rzvy-image-upload-file" accept=".png, .jpg, .jpeg">
                              <label for="rzvy-image-upload-file"></label>
                            </div>
							
							<?php if(empty($row['photos'])) { ?>
                            <div class="rzvy-image-preview">
                              <div id="rzvy-image-upload-file-preview" style="background-image: url(https://techwingspace.com/rezervy/includes/images/staff-lg.png);"></div>
                            </div>
							<?php } else { ?>

                            <div class="rzvy-image-preview">
                              <div id="rzvy-image-upload-file-preview" style="background-image: url(../agency/<?php echo $row['photos']; ?>);"></div>
                            </div>							
								
							<?php } ?>
							
							
                          </div>
                        </div>
                        <div class="col-md-7 pt-2">
                          <p></p>
                          <h3><?php echo htmlentities($row['name']);?></h3>
                          <p></p>
                          <p class="text-muted"><i class="fa fa-envelope"></i> <?php echo htmlentities($row['email']);?></p>
                        </div>
 
                      </div>
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label class="control-label">Agency Name</label>
                          <input class="form-control"  value="<?php echo htmlentities($row['name']);?>"  name="name" type="text"  placeholder="Enter first name">
                        </div>

                        <div class="col-md-6">
                          <label class="control-label">Email</label>
                          <input class="form-control" value="<?php echo htmlentities($row['email']);?>" name="email" type="text"   placeholder="Enter last name">
                        </div>		 
						
                        <div class="col-md-4">
                          <label class="control-label">Phone</label>
                          <input class="form-control" value="<?php echo htmlentities($row['phone']);?>" name="phone" type="text"   placeholder="Enter last name">
                        </div>						
 
 
 
                        <div class="col-md-4">
                          <label class="control-label">Longitude </label>
<input class="form-control"  value="<?php echo htmlentities($row['longitude']);?>"  name="longitude" type="text"  placeholder="Enter first name">
                        </div>
 
						
                        <div class="col-md-4">
                          <label class="control-label">Latitude</label>
                          <input class="form-control" value="<?php echo htmlentities($row['latitude']);?>" name="latitude" type="text"   placeholder="Enter last name">
                        </div> 
 
 
 
 
 
                      </div>
                      <div class="form-group row">
                        <div class="col-md-12">
                          <label class="control-label">Address</label>
                          <textarea class="form-control"   name="address"  placeholder="Enter address"><?php echo htmlentities($row['address']);?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label class="control-label">City</label>
                          <input class="form-control" value="<?php echo htmlentities($row['city']);?>" name="city" type="text"  placeholder="Enter city">
                        </div>
                        <div class="col-md-6">
                          <label class="control-label">State</label>
                          <input class="form-control" value="<?php echo htmlentities($row['state']);?>" name="state" type="text" placeholder="Enter state">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label class="control-label">Zip</label>
                          <input class="form-control" value="<?php echo htmlentities($row['zip']);?>" name="zip" type="text"  placeholder="Enter zip">
                        </div>
                        <div class="col-md-6">
                          <label class="control-label">Country</label>
                          <input class="form-control" ivalue="<?php echo htmlentities($row['country']);?>" name="country" type="text"  placeholder="Enter country">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-12">
                          <label class="control-label">Show ratings in booking form</label>
                          <select name="show_ratings"  class="form-control">
						  
						    <?php if($row['show_ratings']='Y'){ ?>
                            <option value="Y">Enable</option>
                            <option value="N">Disable</option>							
							<?php } else { ?>
                            <option value="N">Disable</option>	
                            <option value="Y">Enable</option>							
							<?php } ?>
 
                          </select>
                        </div>
                        <div class="col-md-12 mt-2">
                          <label class="control-label">Show completed jobs in booking form</label>
                          <select name="show_completed" id="show_completed" class="form-control">
						    <?php if($row['show_completed']='Y'){ ?>
                            <option value="Y">Enable</option>
                            <option value="N">Disable</option>							
							<?php } else { ?>
                            <option value="N">Disable</option>	
                            <option value="Y">Enable</option>							
							<?php } ?>
                          </select>
                        </div>
                        <div class="col-md-12 mt-2">
                          <label class="control-label">Show email in booking form</label>
                          <select name="show_email" id="show_email" class="form-control">
						    <?php if($row['show_email']='Y'){ ?>
                            <option value="Y">Enable</option>
                            <option value="N">Disable</option>							
							<?php } else { ?>
                            <option value="N">Disable</option>	
                            <option value="Y">Enable</option>							
							<?php } ?>
                          </select>
                        </div>
                        <div class="col-md-12 mt-2">
                          <label class="control-label">Show phone in booking form</label>
                          <select name="show_phone" id="show_phone" class="form-control">
						    <?php if($row['show_phone']='Y'){ ?>
                            <option value="Y">Enable</option>
                            <option value="N">Disable</option>							
							<?php } else { ?>
                            <option value="N">Disable</option>	
                            <option value="Y">Enable</option>							
							<?php } ?>
                          </select>
                        </div>
                        <div class="col-md-12 mt-2">
                          <label class="control-label">Show staff on calendar</label>
                          <select name="show_staff" id="" class="form-control">
						    <?php if($row['show_staff']='Y'){ ?>
                            <option value="Y">Enable</option>
                            <option value="N">Disable</option>							
							<?php } else { ?>
                            <option value="N">Disable</option>	
                            <option value="Y">Enable</option>							
							<?php } ?>
                          </select>
                        </div>
						
					  <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>  
					   <script type="text/javascript">
					 
							bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
					  </script> 							


                        <div class="col-md-12 mt-2">
                          <label class="control-label">Description </label>
						<textarea class="form-control"   name="description"  placeholder="Enter News" style="width: 100%; height: 200px;"><?php echo htmlentities($row['description']);?></textarea>
                        </div>						
                      </div>
					  
					  
 					  
					  
					  
					  
					  
					  
					  
					  
					  
                      <div class="form-group row">
                        <div class="col-md-12">
						
						  <button class="btn btn-primary " name="submit" type="submit">Save Agency</button>
						  
                          <a class="btn btn-danger pull-right" href="agency.php?delete=<?php echo htmlentities($row['id']);?>"><i class="fa fa-trash"></i> Delete Agency</a>
			 
						   
                        </div>
                      </div>
                    </form>
                  </div> 
 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php } ?>	  
    </div>
  </div>
</div>
 

	<!-- Add Modal-->
	<?php if(isset($rzvy_rolepermissions['rzvy_staff_add']) || $rzvy_loginutype=='admin'){ ?>
	<div class="modal fade" id="rzvy-add-staff-modal" tabindex="-1" role="dialog" aria-labelledby="rzvy-add-staff-modal-label" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="rzvy-add-staff-modal-label">Add Agency</h5>
			<button class="close" type="button" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
			</button>
		  </div>
		  <div class="modal-body">
				<form name="rzvy_addstaff_form" action="agency.php" method="post">
					<div class="form-group row"> 
						<div class="col-md-12"> 
							<input class="form-control" name="name" type="text" value="" placeholder="Agency Name" required> 
						</div> 
					</div> 
					<div class="form-group row"> 
						<div class="col-md-12"> 
							<input class="form-control"  name="email" type="email" value="" placeholder="Enter email" required> 
						</div> 
					</div> 
					<div class="form-group row"> 
						<div class="col-md-12"> 
							<input class="form-control" name="password" type="password" value="Password" placeholder="" required> 
						</div> 
 
					</div> 
				
		  </div>
		  <div class="modal-footer">
			<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
			<button class="btn btn-primary" name="submit" type="submit">Add</button>
			 
		  </div>
		  </form>
	 
		</div>
	  </div>
	</div>
	<?php }  ?>
	<!-- Reorder Modal-->
<?php include 'footer.php'; ?>