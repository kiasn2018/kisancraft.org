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
    $month = $_POST["month"];
		$year = $_POST["year"];
    
    if($_FILES["file"]["size"] > 0)
    {
        //logic to save in db format
        $file = fopen($filename, "r");
        $unmatched=array();
        $I=0;
        ($emapData = fgetcsv($file, 10000, ",")) !== FALSE;
        //$date = array_search ('Date', $emapData);
        $vtype = array_search ('Rate', $emapData);
        
        $iname = array_search ('Particulars', $emapData);
        $qty = array_search ('Quantity', $emapData);
        $amount1 = array_search ('Value', $emapData);
       
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {     //print_r($emapData);
            //It wiil insert a row to our subject table from our csv file`
            //remove ' from string
            $data1= str_replace("'", "_", $emapData[$pname]);
            $data2= str_replace("'", "_", $emapData[$iname]);
           
			$sql = "SELECT SKU from Itemmst where Item_name='$data2'";
             //echo $sql;
             $result = mysqli_query($conn,$sql);
			$row = mysqli_fetch_array($result);
			
			$state=$row["SKU"];
			if($state=="")
			{
				$unmatched[]=$data2;
			}
            
            $sql = "INSERT into Stockmst (Product, SKU,QTY,Rate,Amount,month,year)
                 values('$data2','$state','$emapData[$qty]','$emapData[$vtype]','$emapData[$amount1]','$month','$year')";
            //we are using mysql_query function. it returns a resource on true else False on error
            //echo "Error: " . $sql . "<br>" . $conn->error;
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }//echo $result.$sql;exit();
            
            
        } } 
		for($j=0;$j<=count($unmatched);$j++){
		echo $unmatched[$j]	."<br/>";
		}
		}?><?php
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