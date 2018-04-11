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
          $keytd = array_search ('Trade Discount', $emapData);
            $keyd = array_search ('Date', $emapData);
            $keypt = array_search ('Particulars', $emapData);
            $keyvc = array_search ('Voucher Type', $emapData);
            $keyqty = array_search ('Quantity', $emapData);
            $keygt = array_search ('Gross Total', $emapData);
            $keyvl = array_search ('Value', $emapData);
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
            {            
                if($emapData[0]!=""){
                
                $vt="Credit Note";
                
            
            $orderdate = explode('/', $emapData[0]);
            $month = $orderdate[1];
            $day   = $orderdate[0];
            $year  = $orderdate[2];
            echo $year."-".$day."-".$month."-".$emapData[1]."-".$emapData[$keyvl]."-".$vt."<br>";
            
            //print_r($emapData);exit();
            $sql = "INSERT into Credit_td (Date,party_name,vourture_type, amount)
                 values('$year-$day-$month','$emapData[1]','$vt','$emapData[$keyvl]')";
            //we are using mysql_query function. it returns a resource on true else False on error
            //echo "Error: " . $sql . "<br>" . $conn->error;
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }//echo $result.$sql;exit();
            
            
                }}}}?><?php
          EXIT();
            
           
           
        
        fclose($file);
        //throws a message if data successfully imported to mysql database from excel file
        echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"index.php\"
					</script>";
        
        
        
        //close of connection
        mysql_close($conn);
        
        
        

?>		