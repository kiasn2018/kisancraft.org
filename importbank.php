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
        
        $I=0;
        ($emapData = fgetcsv($file, 10000, ",")) !== FALSE;
        $date = array_search ('Date', $emapData);
        $branch = array_search ('Branch', $emapData);
        $pert = array_search ('Particulars', $emapData);
        $vtype = array_search ('Vch Type', $emapData);
        $debit = array_search ('Debit', $emapData);
        $credit = array_search ('Credit', $emapData);
       
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {     //print_r($emapData);
            //It wiil insert a row to our subject table from our csv file`
            //remove ' from string
            
            $orderdate = explode('/', $emapData[$date]);
            $month = $orderdate[1];
            $day   = $orderdate[0];
            $year  = $orderdate[2];
             $data= str_replace("'", "_", $emapData[$pert]);
             //$data1=preg_replace("/\//", "", "sdjfhf\d");
             $data1= stripslashes($data); 
             
             //$data1= str_replace("\ ", '/', $data);
			
			// if($emapData[$date]==''){
   //              $date1=$pdate;
   //              $vtype1=$pvtype;
   //              $branch1=$pbranch;
   //              $pert1=$ppert;
   //              $debit1=$pdebit;
   //              $credit1=$pcredit;
   //              $narr=$emapData[$pert];

   //          }
            echo $year."-".$month."-".$day.$emapData[$vtype].$emapData[$branch].$emapData[$pert].$emapData[$debit].$emapData[$credit]."<br>";
            
            $sql = "INSERT into Banktransactionmst (Date, Branch,Particulars,Vorture, Debit , Credit)
                 values('$year-$month-$day','$emapData[$branch]','$data1','$emapData[$vtype]','$emapData[$debit]','$emapData[$credit]')";
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