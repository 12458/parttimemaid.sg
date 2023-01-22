 

<?php

include('../db.php');

$msg="";
$error="";
if(isset($_GET['delete']))
{
$postid=intval($_GET['delete']);
$query=mysqli_query($con,"delete from rzvy_agency where id='$postid'");
if($query)
{
$msg="Agancy deleted ";
}
else{
$error="Something went wrong . Please try again.";    
}	
}	
	










if(isset($_POST['submit']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];

$status=1;
$query=mysqli_query($con,"insert into rzvy_agency(name,email,password) values('$name','$email','$password')");

if($query)
{
$msg="Agency created "; 
}
else{
$error="Something went wrong . Please try again.";    
} 

}
?> 






<?php include 'header.php'; 
if(!isset($rzvy_rolepermissions['rzvy_staff']) && $rzvy_loginutype=='staff'){ ?>
	<div class="container mt-12">
		  <div class="row mt-5"><div class="col-md-12">&nbsp;</div></div>
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
		<div class="col-sm-12">  
		<!---Success Message--->  
		<?php if($msg){ ?>
		<div class="alert alert-success" role="alert">
		<strong>Well done!</strong> <?php echo htmlentities($msg);?>
		</div>
		<?php } ?>

		<!---Error Message--->
		<?php if($error){ ?>
		<div class="alert alert-danger" role="alert">
		<strong>Oh snap!</strong> <?php echo htmlentities($error);?></div>
		<?php } ?>


		</div>
		</div>		
		
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
				
				 <?php echo $row['name'];?>  </li>
                </a>
											<?php } } ?>
                  </ul>
                </div>
              </div>
            </div>
            <div  class="col-md-8 mb-3">

            </div>
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
							<input class="form-control" name="password" type="password" value="" placeholder="Password" required> 
						</div> 
					</div> 
				
		  </div>
		  <div class="modal-footer">
			<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
			<button class="btn btn-primary" name="submit" type="submit">Add</button>
			 
		  </div>
		  </form>
		  </form>
		</div>
	  </div>
	</div>
	<?php }  ?>
	<!-- Reorder Modal-->
 

<?php include 'footer.php'; ?>