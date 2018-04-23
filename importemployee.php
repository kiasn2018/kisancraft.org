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
        ($emapData = fgetcsv($file, 10000, ",")) !== FALSE;
        $eid = array_search ('Emp ID', $emapData);
        $ename = array_search ('Employee Name', $emapData);
        
        $jdate = array_search ('Date of Joining', $emapData);
        $ldate = array_search ('Date of Leaving', $emapData);
        
		$des = array_search ('Designation', $emapData);
		$dep = array_search ('Department', $emapData);
		$basic = array_search ('BASIC+DA', $emapData);
		$hra = array_search ('HRA', $emapData);
		$other = array_search ('Arr.Earn', $emapData);
		$convey = array_search ('Conveyance', $emapData);
		$med= array_search ('Medi Reimb', $emapData);
		$spi = array_search ('SPl Allow', $emapData);
		$lta = array_search ('LTA', $emapData);
		$bm = array_search ('Bonus M', $emapData);
		$branch = array_search ('Branch', $emapData);
		$el= array_search ('EL ENCASHM', $emapData);
		
		$be= array_search ('Bonus.Exgr', $emapData);
		$month = $_POST["month"];
		$year = $_POST["year"];
		$emapData[$basic]=$emapData[$hra]=$emapData[$convey]=$emapData[$med]=$emapData[$spi]=$emapData[$lta]=$emapData[$bm]=$emapData[$other]=$emapData[$EL]=$emapData[$be]='0';
        $I=0;
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {     //print_r($emapData);
            for($i=1;$i<=42;$i++){
                $emapData[$i] = str_replace(',', '', $emapData[$i]);
            
            }
            $data= str_replace("'", "_", $emapData[2]);
            if($emapData[2]!=""){
                $pdate1=date("Y-d-m", strtotime($emapData[$jdate]) );
                if($emapData[5]!=""){
                $pdate2=date("Y-d-m", strtotime($emapData[$ldate]) );
                }else{$pdate2="0000-00-00";}
				$totalearnings='';
				//echo $emapData[$basic]."=".$emapData[$hra]."=".$emapData[$convey]."=".$emapData[$med]."=".$emapData[$spi]."=".$emapData[$lta]."=".$emapData[$bm]."=".$emapData[$other]."=".$emapData[$be]."=";
                //It wiil insert a row to our subject table from our csv file`
				$totalearnings=$emapData[$basic]+$emapData[$hra]+$emapData[$convey]+$emapData[$med]+$emapData[$spi]+$emapData[$lta]+$emapData[$bm]+$emapData[$other]+$emapData[$el];
                $sql = "INSERT into Employeemst (E_id, E_name,E_D_O_J,D_o_l,Designation,Department,Branch,Basic_DA,HRA,Conveyance,Medi_Reimb,SPl_Allow,LTA,Bonus_M,other,Total_Earning,month,year,BE,EL_encash)
                 values('$emapData[$eid]','$emapData[$ename]','$pdate1','$pdate2','$emapData[$des]','$emapData[$dep]','$emapData[$branch]','$emapData[$basic]','$emapData[$hra]',
				 '$emapData[$convey]','$emapData[$med]','$emapData[$spi]','$emapData[$lta]','$emapData[$bm]','$emapData[$other]','$totalearnings','$month','$year','$emapData[$be]','$emapData[$el]')";
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