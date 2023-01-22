<?php
 
echo $name=$_POST['name'];
echo $lastname=$_POST['lastname'];

define('DB_SERVER','localhost');
define('DB_USER','techwin_rezdev');
define('DB_PASS' ,'IjsbLwe6gMyp');
define('DB_NAME','techwin_rezervy');

$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

$status=1;
$query=mysqli_query($con,"insert into rzvy_agency(name,lastname) values('$name','$lastname')");

if($query)
{
$msg="Client created ";
}
else{
$error="Something went wrong . Please try again.";    
} 
 
?> 