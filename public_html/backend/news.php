 

<?php

 


include('../db.php');

if(isset($_POST['submit']))
{
$news=$_POST['news'];
 
 
$query=mysqli_query($con,"UPDATE  rzvy_news SET  `news`='$news' where id='1'");

if($query)
{
$msg="Content   Updated ";
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
  <li class="breadcrumb-item active">News</li>
</ol>
<!-- Staff DataTables Card-->
<div class="card mb-2">
  <div class="card-body">
    <div class="row">
  <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>  
   <script type="text/javascript">
 
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  </script> 
			
<?php 
 
$query=mysqli_query($con,"SELECT * FROM `rzvy_news` where  id='1'");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>			
      <div id="rzvy-staff-detail-card" class="col-md-12 mb-3">
      
     
            <div class="rzvy-tabbable-panel">
              <div class="rzvy-tabbable-line">
                <ul class="nav nav-tabs">
                  <li class="nav-item active custom-nav-item" id="rzvy_staff_detail_tab_selection" data-id="1">
                    <a class="nav-link custom-nav-link rzvy_tab_view_nav_link" data-tabno="0" data-toggle="tab" href="#rzvy_staff_detail"><i class="fa fa-info-circle"></i> News</a>
                  </li>
 
                </ul>
                <div id="rzvy-staff-tab-content" class="tab-content py-4">

                  <div class="tab-pane container active" id="detail">
                    <form name="detail_form" action="news.php" method="post">
 
 
 
 
                      <div class="form-group row">
                        <div class="col-md-12">
                          <label class="control-label">news</label>
                          <textarea class="form-control"   name="news"  placeholder="Enter News" style="width: 100%; height: 200px;"><?php echo htmlentities($row['news']);?></textarea>
                        </div>
                      </div>
 
 
                      <div class="form-group row">
                        <div class="col-md-12">
						
						  <button class="btn btn-primary " name="submit" type="submit">Save</button>
 
			 
						   
                        </div>
                      </div>
                    </form>
                  </div> 
 
                </div>
              </div>
            </div>
     
         
      </div>
<?php } ?>	  
    </div>
  </div>
</div>
 
 
  
 

 
	
	

 
	<!-- Reorder Modal-->
<?php include 'footer.php'; ?>