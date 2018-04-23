<?php
include 'config/db.php';
include 'header.php';

?>
 <head>
    <style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
input[type=password], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>
    </head>
<?php

$sub='0';

$sql = "SELECT sum(Amount) from Salesmaster where Date between '2018-01-01' and '2018-03-31' ";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result); {   
 ?>
    <fieldset style="margin-left:30% ;width:50%">
    <legend>Incentive Calculation</legend>
    <div style="margin-left:30% ;width:50%">
    <form name="frmSearch" method="post" action="">
    <lable> Year</lable><br>
    <input type="text" placeholder="Year" style="margin-left:2%;" id="post_at" name="year"  value="<?php echo $row['year']; ?>" class="input-control" /><br><br>
    <select name="month" id="month">
    <option value="">Select Month</option>
    </select>
    <lable> Total Sales</lable><br>
    <input type="text" placeholder="Total sales" style="margin-left:2%;" id="post_at" name="tsales"  value="<?php echo  $a=$row['sum(Amount)']; ?>" class="input-control" /><br><br>
    
    <lable> Subsidy</lable><br>
    <input type="text" placeholder="Subsidy" style="margin-left:2%;" id="post_at" name="sub"  value="<?php echo $sub; ?>" class="input-control" /><br><br>
    <lable> Net Sales</lable><br>
    <input type="text" placeholder="Net Sales" style="margin-left:2%;" id="post_at" name="nsales"  value="<?php echo ($Total=$a-$sub); ?>" class="input-control" /><br><br>
    <input type="hidden" placeholder="target" style="margin-left:2%;" id="post_at" name="pince"  value="<?php echo "0.3"; ?>" class="input-control" /><br><br>
    <lable>Incetives for Non sales </lable><br>
    <input type="text" placeholder="Incetives" style="margin-left:2%;" id="post_at" name="inc"  value="<?php echo round($amm=($Total * ( 0.003))); ?>" class="input-control" /><br><br>
    <lable>Incetives EXECUTIVES </lable><br>
    <input type="text" placeholder="Incetives" style="margin-left:2%;" id="post_at" name="exe"  value="<?php echo round($amm1=($Total * ( 0.0025))); ?>" class="input-control" /><br><br>
   
    <lable>Incetives ASM </lable><br>
    <input type="text" placeholder="Incetives" style="margin-left:2%;" id="post_at" name="asm"  value="<?php echo round($amm=($Total * ( 0.00052))); ?>" class="input-control" /><br><br>
    <lable>Incetives SM </lable><br>
    <input type="text" placeholder="Incetives" style="margin-left:2%;" id="post_at" name="sm"  value="<?php echo round($amm=($Total * ( 0.000018))); ?>" class="input-control" /><br><br>
    <lable>Incetives ZM </lable><br>
    <input type="text" placeholder="Incetives" style="margin-left:2%;" id="post_at" name="zm"  value="<?php echo round($amm=($Total * ( 0.00026))); ?>" class="input-control" /><br><br>
   
    <input type="submit" name="go" value="Update" style="font-size:10pt;color:white;background-color:green;border:2px solid #336600;padding:8px" ><br>
    </form>
    </div>
    </fieldset>
    <?php }
?>
<script>
var d = new Date();
var monthArray = new Array();
monthArray[3] = "Jan-Mar-Q4";
monthArray[0] = "April-Jun-Q1";
monthArray[1] = "July-Sept-Q2";
monthArray[2] = "Oct-Dec-Q3";

for(m = 0; m <= 3; m++) {
    var optn = document.createElement("OPTION");
    optn.text = monthArray[m];
    // server side month start from one
    optn.value = (m+1);
 
    // if june selected
    if ( m == 2) {
        optn.selected = true;
    }
 
    document.getElementById('month').options.add(optn);
}
</script>
<?php 

if(isset($_POST["go"])){
    $year=$_POST["year"];
    $month=$_POST["month"];
    $AP=$_POST['tsales'];
    $BH=$_POST['credit'];
    $CH=$_POST['sub'];
    $DL=$_POST['nsales'];
    $GOA=$_POST['pince'];
    $GU=$_POST['inc'];
    $ecom=$_POST['ecom'];
    $exe=$_POST['exe'];
    $asm=$_POST['asm'];
    $sm=$_POST['sm'];
    $zm=$_POST['zm'];
    
    $sql = ("SELECT count(*) as total FROM incentive where year='$year' and month='$month' ");
    $query = $conn->query($sql); 
    $row = mysqli_fetch_array($query);
    if ($row['total'] == 0){
        $sql = "INSERT into incentive(year, month, sales,credit,Subsidy,netsales,incetivenon)
                 values('$year','$month','$AP','$BH','$CH','$DL','$GU')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script type=\"text/javascript\">
						alert(\"Updated Succesfully.\");
						window.location = \"\"
					</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }else{  $sql = "UPDATE incentive SET sales = '$AP',credit='$BH',Subsidy='$CH',netsales='$DL',incetivenon='$GU',Ecomm='$ecom',EXE='$exe',ASM='$asm',SM='$sm',ZM='$zm' ".
        "WHERE year = '$year' and month='$month'" ;
    $query = $conn->query($sql); 
    //$retval = mysql_query( $sql, $conn );
    
    if(! $query ) {
        die('Could not update data: ' . mysql_error());
    }
    echo "<script type=\"text/javascript\">
						alert(\"Updated Succesfully.\");
						window.location = \"\"
					</script>";} 
}