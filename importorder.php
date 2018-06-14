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
        $sku = array_search ('SKU', $emapData);
        $apr = array_search ('APR', $emapData);
        $may = array_search ('MAY', $emapData);
        $jun = array_search ('JUN', $emapData);
        $jul = array_search ('JUL', $emapData);
        $aug = array_search ('AUG', $emapData);
        $sep = array_search ('SEP', $emapData);
        $oct = array_search ('OCT', $emapData);
        $nov = array_search ('NOV', $emapData);
        $dec = array_search ('DEC', $emapData);
        $jan = array_search ('JAN', $emapData);
        $feb = array_search ('FEB', $emapData);
        $mar = array_search ('MAR', $emapData);
        $jan = array_search ('JAN', $emapData);
        $year = array_search ('Year', $emapData);

       
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {     //print_r($emapData);
            //It wiil insert a row to our subject table from our csv file`
            //remove ' from string
            
            $sql = "INSERT into ordermst (SKU,april,may,june,july,agust,sep,oct,nov,`dec`,jan,feb,mar,year)
                 values('$emapData[$sku]','$emapData[$apr]','$emapData[$may]','$emapData[$jun]','$emapData[$jul]','$emapData[$aug]','$emapData[$sep]','$emapData[$oct]','$emapData[$nov]','$emapData[$dec]','$emapData[$jan]','$emapData[$feb]','$emapData[$mar]','$emapData[$year]')";
            //we are using mysql_query function. it returns a resource on true else False on error
            //echo "Error: " . $sql . "<br>" . $conn->error;
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }//echo $result.$sql;exit();
            
            
        } } }?><?php
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