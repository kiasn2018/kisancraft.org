<?php
ini_set('max_execution_time', 0);
// date base connection
$servername = "localhost";
$username = "kisan";
$password = "yes";
$dbname = "Branch_mst";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// select datebase and display
if(isset($_POST["Import"])){
    
    
    echo $filename=$_FILES["file"]["tmp_name"];
    
    
    if($_FILES["file"]["size"] > 0)
    {
        //logic to save in db format
        $file = fopen($filename, "r");
        
        $I=0;
        ($emapData = fgetcsv($file, 10000, ",")) !== FALSE;
        $date = array_search ('Date', $emapData);
        $vtype = array_search ('Voucher Type', $emapData);
        $pname = array_search ('Party Name', $emapData);
        $iname = array_search ('Item Name', $emapData);
        $qty = array_search ('Billed Quantity', $emapData);
        $amount = array_search ('Amount', $emapData);
       
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {     //print_r($emapData);
            //It wiil insert a row to our subject table from our csv file`
            //remove ' from string
            $data1= str_replace("'", "_", $emapData[$pname]);
            $data2= str_replace("'", "_", $emapData[$iname]);
            $orderdate = explode('/', $emapData[$date]);
            $month = $orderdate[1];
            $day   = $orderdate[0];
            $year  = $orderdate[2];
            echo $year."-".$month."-".$day.$emapData[$vtype].$emapData[$pname].$emapData[$iname].$emapData[$qty].$emapData[$amount]."<br>";
            
            $sql = "INSERT into Salesmst (Date, Dealer_name,Vorture_type,Item_name, Quantity , Amount)
                 values('$year-$day-$month','$data1','$emapData[$vtype]','$data2','$emapData[$qty]','$emapData[$amount]')";
            //we are using mysql_query function. it returns a resource on true else False on error
            //echo "Error: " . $sql . "<br>" . $conn->error;
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }//echo $result.$sql;exit();
            
            
        } } }?><?php
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
        
        
        

?>		