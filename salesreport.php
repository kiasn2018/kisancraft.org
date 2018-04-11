<?php
//include database configuration file
// date base connection
$servername = "localhost";
$username = "kisan";
$password = "yes";
$dbname = "branch_mst";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

//get records from database
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
    
    $queryCondition .= "WHERE Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
}

$sql = "SELECT * from Salesmst " . $queryCondition . " ORDER BY Date desc";
//$result = mysqli_query($conn,$sql);
//$sql = "SELECT id, BName, BAddress ,BDistict,Bstate,Btaxid FROM usermst";
$query = $conn->query($sql);

//$query = $db->query("SELECT id, BName, BAddress, BDistict,Bstate,Btaxid FROM usermst ");

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "Sales_report_" . date('Y-m-d') . ".csv";
    
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