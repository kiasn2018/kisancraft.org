<?php

include '/config/db.php';

if(!empty($_POST["state_id"]))
{   $dt=$_POST["state_id"];
    $sqlst = "SELECT DISTINCT District from Excutivemst WHERE State = '$dt'";
    echo $sqlst;
    $resultst = mysqli_query($conn,$sqlst);
    ?>
<option value="">Select District</option>
<option value="<?php echo "ALL"; ?>"><?php echo "ALL"; ?></option>
<?php
while($rowst=mysqli_fetch_array($resultst))
{ 
?>
<option value="<?php echo $rowst["District"]; ?>"><?php echo $rowst["District"]; ?></option>
<?php
}
}
?>