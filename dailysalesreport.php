<?php
ini_set('max_execution_time', 0);
include '/config/db.php';
$post_at = "";
$post_at_to_date = "";

$queryCondition = "";
if(!empty($_POST["search"]["post_at"])) {
    $post_at = $_POST["search"]["post_at"];
    list($fid,$fim,$fiy) = explode("-",$post_at);
    
    $post_at_todate = date('Y-m-d');
    if(!empty($_POST["search"]["post_at_to_date"])) {
        $post_at_to_date = $_POST["search"]["post_at_to_date"];
        list($tid,$tim,$tiy) = explode("-",$_POST["search"]["post_at_to_date"]);
        $post_at_todate = "$tiy-$tim-$tid";
    }
    //echo date("l").$tid;
    $queryCondition .= "WHERE Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
}
$fid='01';
$fim='03';
$fiy=date("Y");
$post_at_todate="2018-03-22";
$queryCondition .= "WHERE Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
$sql = "SELECT * from Salesmst " . $queryCondition . " ORDER BY Date  ";
$result = mysqli_query($conn,$sql);
$ap=array();
$br=array();
$ch=array();
$dl=array();
$goa=array();
$gu=array();
$hp=array();
$hr=array();
$Jk=array();
$jh=array();
$k_c=array();
$k_l=array();
$k_n=array();
$k_s=array();
$kl=array();
$mp=array();
$mh=array();
$nep=array();
$ne=array();
$od=array();
$pj=array();
$tn=array();
$tl=array();
$up_a=array();
$up_b=array();
$up_d=array();
$uk=array();
$wb=array();
$rj=array();
while($row = mysqli_fetch_array($result)) {
    
    $d=$row["Dealer_name"];
    $date=$row["Date"];
    $orderdate = explode('-', $date);
    $month = $orderdate[1];
    $day   = $orderdate[2];
    $year  = $orderdate[0];
    $sqls = "SELECT * from Dealermst where D_name='$d' ";
    $results = mysqli_query($conn,$sqls);
    $rows = mysqli_fetch_array($results);
    $district=$rows["D_distict"];
    $state=$rows["D_state"];
    //print_r($rows);
    
    //echo $state;
    if( $district=="Andhra Pradesh"){
        $ap[$day]=$ap[$day]+$row["Amount"];
    }
    if( $district=="Uttar Pradesh"){
        $sqls1 = "SELECT Zone from Zonesmst where State='$district' AND District= '$state'";
        //echo $sqls1;
        $results1 = mysqli_query($conn,$sqls1);
        $rows1 = mysqli_fetch_array($results1);
        //print_r($rows1);
        if($rows1["Zone"]=="Uttar Pradesh A"){
            $up_a[$day]=$up_a[$day]+$row["Amount"];
        }
        if($rows1["Zone"]=="Uttar Pradesh B"){
            $up_b[$day]=$up_b[$day]+$row["Amount"];
        }
        if($rows1["Zone"]=="Uttar Pradesh D"){
            $up_d[$day]=$up_d[$day]+$row["Amount"];
        }
        
    }
    if( $district=="Karnataka"){
        //$k_c[$day]=$row["Amount"];
        $sqls1 = "SELECT Zone from Zonesmst where State='$district' AND District= '$state'";
        //echo $sqls1;
        $results1 = mysqli_query($conn,$sqls1);
        $rows1 = mysqli_fetch_array($results1);
        //print_r($rows1);
        // echo $rows1["Zone"].$date."<br>";
        if($rows1["Zone"]=="Karnataka Central"){
            $k_c[$day]=$k_c[$day]+$row["Amount"];
        }
        if($rows1["Zone"]=="Karnataka Local"){
            $k_l[$day]=$k_l[$day]+$row["Amount"];
        }
        if($rows1["Zone"]=="Karnataka North"){
            $k_n[$day]=$k_n[$day]+$row["Amount"];
        }
        if($rows1["Zone"]=="Karnataka South"){
            $k_s[$day]=$k_s[$day]+$row["Amount"];
        }
        
    }
    if( $district=="Bihar"){
        $br[$day]=$br[$day]+$row["Amount"];
        
    }
    if( $district=="Chandigarh"){
        $ch[$day]=$ch[$day]+$row["Amount"];
        
    }
    if( $district=="Delhi"){
        $dl[$day]=$dl[$day]+$row["Amount"];
    }
    if( $district=="Goa"){
        $goa[$day]=$goa[$day]+$row["Amount"];
        
    }
    
    if( $district=="Gujarat"){
        $gu[$day]=$gu[$day]+$row["Amount"];
        
    }
    if( $district=="Haryana"){
        $hr[$day]=$hr[$day]+$row["Amount"];
        
    }
    if( $district=="Himachal Pradesh"){
        $hp[$day]=$hp[$day]+$row["Amount"];
        
    }
    if( $district=="Jammu and Kashmir"){
        $Jk[$day]=$Jk[$day]+$row["Amount"];
        
    }
    if( $district=="Jharkhand"){
        $jh[$day]=$jh[$day]+$row["Amount"];
        
    }
    if( $district=="Kerala"){
        $kl[$day]=$kl[$day]+$row["Amount"];
        
    }
    if( $district=="Madhya Pradesh"){
        $mp[$day]=$mp[$day]+$row["Amount"];
        
    }
    if( $district=="Maharashtra"){
        $mp[$day]=$mp[$day]+$row["Amount"];
        
    }
    if( $district=="Nepal"){
        $nep[$day]=$nep[$day]+$row["Amount"];
        
    }
    if( $district=="North East"){
        $ne[$day]=$ne[$day]+$row["Amount"];
        
    }
    if( $district=="Odisha"){
        $od[$day]=$od[$day]+$row["Amount"];
    }
    if( $district=="Punjab"){
        $pj[$day]=$pj[$day]+$row["Amount"];
        
    }
    if( $district=="Rajasthan"){
        $rj[$day]=$rj[$day]+$row["Amount"];
    }
    if( $district=="Tamil Nadu"){
        $tn[$day]=$tn[$day]+$row["Amount"];
        
    }
    if( $district=="Telangana"){
        $tl[$day]=$tl[$day]+$row["Amount"];
    }
    if( $district=="Uttarakhand"){
        $uk[$day]=$uk[$day]+$row["Amount"];
        
    }
    if( $district=="West Bengal"){
        $wb[$day]=$wb[$day]+$row["Amount"];
        
    }
    
}//print_r($k_s);



if(true){
    $delimiter = ",";
    $filename = "daily_Sales_report_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('Dealer Name', 'Date', 'Vorture Type', 'Item Name', 'State', 'District' , 'Executive' , 'ASM' ,'QTY','Amount');
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $data= str_replace("_", "'", $row["Dealer_name"]);
        $data1= str_replace("_", "'", $row["Item_name"]);
        $d=$row["Dealer_name"];
        $sqls = "SELECT * from Dealermst where D_name='$d' ";
        //echo $sqls;
        $results = mysqli_query($conn,$sqls);
        while($rows = mysqli_fetch_array($results)) {
            $district=$rows["D_distict"];
            $state=$rows["D_state"];
        }
        $sqls1 = "SELECT * from Excutivemst where State='$district' AND District= '$state'";
        $results1 = mysqli_query($conn,$sqls1);
        while($rows1 = mysqli_fetch_array($results1)) {
            
            $exec=$rows1["Exexutive"];
            $ASM=$rows1["ASM"];
        }
        
        $lineData = array($data, $row['Date'], $row['Vorture_type'], $data1,$district, $state,$exec,$ASM,$row["Quantity"] ,$row["Amount"]);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>