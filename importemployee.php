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
//echo "Connected successfully";

// select datebase and display
if(isset($_POST["Import"])){
    
    
    echo $filename=$_FILES["file"]["tmp_name"];
    
    
    if($_FILES["file"]["size"] > 0)
    {
        //logic to save in db format
        $file = fopen($filename, "r");
        
        $I=0;
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {     //print_r($emapData);
            for($i=1;$i<=42;$i++){
                $emapData[$i] = str_replace(',', '', $emapData[$i]);
            
            }
            $data= str_replace("'", "_", $emapData[2]);
            if($emapData[2]!=""){
                $pdate1=date("Y-d-m", strtotime($emapData[4]) );
                if($emapData[5]!=""){
                $pdate2=date("Y-d-m", strtotime($emapData[5]) );
                }else{$pdate2="0000-00-00";}
                //It wiil insert a row to our subject table from our csv file`
                $sql = "INSERT into Employeemst (E_id, E_name, Father_name,E_D_O_J,D_o_l,PF_no,ESI_no,PAN_no,Bank_name,Bank_ac_no,Designation,Department,Division,Grade,Branch,Calender_days,UAN,Adhar_no,Pay_days,Prasent_days,Basic_DA,HRA,Conveyance,Medi_Reimb,SPl_Allow,LTA,Bonus_M,gift_Amoun,Bonus_Exgr,Arr_Earn,Total_Earning,PF,ESI,PT,TDS,Total_Dedn,Net_Amount,month,year)
                 values('$emapData[1]','$emapData[2]','$emapData[3]','$pdate1','$pdate2','$emapData[6]','$emapData[7]','$emapData[8]','$emapData[9]','$emapData[10]','$emapData[12]','$emapData[14]','$emapData[15]','$emapData[16]','$emapData[17]','$emapData[18]','$emapData[19]','$emapData[20]','$emapData[21]','$emapData[22]','$emapData[23]','$emapData[24]','$emapData[25]','$emapData[26]','$emapData[27]','$emapData[28]','$emapData[29]','$emapData[30]','$emapData[31]','$emapData[32]','$emapData[33]','$emapData[34]','$emapData[35]','$emapData[36]','$emapData[37]','$emapData[38]','$emapData[39]','$emapData[40]','$emapData[41]')";
                //we are using mysql_query function. it returns a resource on true else False on error
                //echo "Error: " . $sql . "<br>" . $conn->error;
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }//echo $result.$sql;exit();
                
                
            } }} }?><?php
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