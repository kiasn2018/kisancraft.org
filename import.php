<?php
ini_set('max_execution_time', 0);
// date base connection
$servername = "localhost";
$username = "mayurj";
$password = "yes";
$dbname = "branch_mst";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

// select datebase and display
if(isset($_POST["Import"])){
    
    
    echo $filename=$_FILES["file"]["tmp_name"];
    
    
    if($_FILES["file"]["size"] > 0)
    {
        //logic to save in db format
        $file = fopen($filename, "r");
        ?>
        <table style="width:80%" border=1 cellspacing="0" cellpadding="0">
        <tr>
        <th>Date</th>
        <th>Supplier</th>
        <th>Voucher Typ</th>
        <th>Total Value</th>
        <th>Addl Cost</th>
        <th>Item Name.</th>
        <th>Quantity.</th>
        <th>Rate</th>
        <th>Value</th>
        <th>Addl Cost</th>
        <th>Total Cost</th>
        <th>Landed Cost/Jnit</th>
        </tr><?php 
        $I=0;
		($emapData = fgetcsv($file, 10000, ",")) !== FALSE;
        //$date = array_search ('Date', $emapData);
        $vtype = array_search ('Rate', $emapData);
        $add = array_search ('Addl. Cost', $emapData);
        $iname = array_search ('Particulars', $emapData);
        $qty = array_search ('Quantity', $emapData);
        $amount1 = array_search ('Value', $emapData);
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {     //print_r($emapData);
	       
            if($emapData[0]!=""){
                $ppurchesim=$emapData[4];
                $pdate1=$emapData[0];
                $var = $pdate1;
                $orderdate = explode('/', $var);
                $month = $orderdate[1];
                $day   = $orderdate[0];
				$year  = $orderdate[2];
                $psupplier=$emapData[1];
                $padditional_cost=$emapData[$add];
                $pvalue=$emapData[$amount1];
           // print_r($emapData[0]);
            }
            if($emapData[$qty]!="" && $emapData[0]==""){
                if($emapData[1]!=""){
					$data1= str_replace("'", "_", $emapData[1]);
         ?>
  <tr>
    <td><?php echo $year-$month-$day;?></td>
    <td><?php echo $psupplier;?></td>
    <td><?php echo $ppurchesim;?></td>
    <td><?php echo $pvalue;?></td>
    <td><?php echo $padditional_cost;?></td>
    <td><?php echo $emapData[1];?></td>
    <td><?php echo $emapData[$qty];?></td>
    <td><?php echo $emapData[$vtype];?></td>
    <td><?php echo $emapData[$amount1];?></td>
    <td><?php echo $Addl=($padditional_cost*$emapData[$amount1])/$pvalue;?></td>
    <td><?php echo $totalcost=$Addl+$emapData[$amount1];?></td>
    <td><?php echo $landed_cost=$totalcost/$emapData[$qty];?></td>
  </tr>


                <?php 
                //It wiil insert a row to our subject table from our csv file`
                 $sql = "INSERT into purches_mst (Date, Supplier, voucher_type,item_name , Quantity,Rate, Value,Addl_cost,Total_cost,Londedcost_unit,Total_value,Addl_value)
                 values('$year-$month-$day','$psupplier','$ppurchesim','$data1','$emapData[$qty]','$emapData[$vtype]','$emapData[$amount1]','$Addl','$totalcost','$landed_cost','$pvalue','$padditional_cost')";
                 //we are using mysql_query function. it returns a resource on true else False on error
                 //echo "Error: " . $sql . "<br>" . $conn->error;
                 if ($conn->query($sql) === TRUE) {
                 echo "New record created successfully";
                 } else {
                 echo "Error: " . $sql . "<br>" . $conn->error;
                 }//echo $result.$sql;exit();
                 
                 
		   } } }?></table><?php  
          EXIT();
            
                        //It wiil insert a row to our subject table from our csv file`
           /* $sql = "INSERT into purches_mst (Date, Supplier, voucher_type,item_name , Quantity,Rate, Value,Addl_cost,Total_cost,Londedcost_unit,Total_value,Addl_value)
	            	values('$pdate','$psupplier','$ppurchesim','$emapData[1]','$emapData[26]','$emapData[28]','$emapData[29]','$Addl','$totalcost','$landed_cost','$pvalue','$padditional_cost')";
            //we are using mysql_query function. it returns a resource on true else False on error
            //echo "Error: " . $sql . "<br>" . $conn->error; 
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            } //echo $result.$sql;exit();
            if(! $result )
            {
                echo "<script type=\"text/javascript\">
							alert(\"Uploaded .\");
							window.location = \"index.php\"
						</script>";
            } */
            
                
       
           
        
        fclose($file);
        //throws a message if data successfully imported to mysql database from excel file
        echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"index.php\"
					</script>";
        
        
        
        //close of connection
        mysql_close($conn);
        
        
        
    }
}
?>		