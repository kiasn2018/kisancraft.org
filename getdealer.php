<?php

include '/config/db.php';

if(!empty($_POST["state_id"]))
{   $dt=$_POST["state_id"];
$sqlst = "SELECT DISTINCT D_name from Dealermst WHERE D_distict = '$dt'";
echo $sqlst;
$resultst = mysqli_query($conn,$sqlst);
?>
<option value="">Select Dealer</option>
<option value="<?php echo "ALL"; ?>"><?php echo "ALL"; ?></option>
<?php
while($rowst=mysqli_fetch_array($resultst))
{ 
?>
<option value="<?php echo $rowst["D_name"]; ?>"><?php echo $rowst["D_name"]; ?></option>
<?php
}
}
?>