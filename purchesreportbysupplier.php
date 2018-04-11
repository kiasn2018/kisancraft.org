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

$sql = "SELECT DISTINCT Supplier, Date,Total_value,Addl_value from purches_mst " . $queryCondition . " ORDER BY Date desc";
//$result = mysqli_query($conn,$sql);
//$sql = "SELECT id, BName, BAddress ,BDistict,Bstate,Btaxid FROM usermst";
$query = $conn->query($sql);

//$query = $db->query("SELECT id, BName, BAddress, BDistict,Bstate,Btaxid FROM usermst ");

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "Pureches_report" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('Date', 'Supplier', 'Total Value', 'Additional Value');
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        
        $lineData = array($row['Date'], $row['Supplier'], $row['Total_value'], $row['Addl_value']);
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