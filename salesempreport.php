<?php
include '/config/db.php';

$amount="";
$district=($_POST["district"]);
$state=($_POST["search"]["state"]);
$queryCondition = "";
if(!empty($_POST["search"]["post_at"])) {
    $post_at = $_POST["search"]["post_at"];
    list($fid,$fim,$fiy) = explode("-",$post_at);
    
    $post_at_todate = date('Y-m-d');
    if(!empty($_POST["search"]["post_at_to_date"])) {
        $post_at_to_date = $_POST["search"]["post_at_to_date"];
        list($tid,$tim,$tiy) = explode("-",$_POST["search"]["post_at_to_date"]);
        $post_at_todate = "$tiy-$tim-$tid";
        $queryCondition .= " AND Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
    }}
    
    $delimiter = ",";
    $filename = "Saleswrtemp" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('State', 'District', 'Executive', 'ASM', 'SM', 'ZM', 'Amount' );
    fputcsv($f, $fields, $delimiter);
    {
        
        
        $sqld = "SELECT * from Excutivemst where Exexutive='$state' ";
        // echo $sqld;
        $resultd = mysqli_query($conn,$sqld);
        while($rowd = mysqli_fetch_array($resultd)) {
            
            $state=$rowd['State'];
            $dis=$rowd["District"];
            $sqls1 = "SELECT * from Dealermst where D_state='$state' AND D_distict= '$dis'";
            $results1 = mysqli_query($conn,$sqls1);
            $amount="";
            while($rows1 = mysqli_fetch_array($results1)){
                //print_r($rows1);
                $name=($rows1['D_name']);
                $sql = "SELECT SUM(Amount) from Salesmst where Dealer_name='$name' ".$queryCondition;
                
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_array($result)) {
                    
                    $amount=$amount+($row['SUM(Amount)']);
                    
                    
                    
                }}

//$query = $db->query("SELECT id, BName, BAddress, BDistict,Bstate,Btaxid FROM usermst ");


   
    
    //output each row of the data, format line as csv and write to file pointer
   
        $lineData = array( $rowd['State'], $dis, $rowd['Exexutive'], $rowd['ASM'],$rowd['SM'], $rowd['ZM'], $amount);
        fputcsv($f, $lineData, $delimiter);
    }}
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
    
exit;

?>