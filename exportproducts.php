<?php
include '/config/db.php';

//get records from database
$sql = "SELECT o.Itemid, o.qty, o.INo, c.itemid, c.Iname, c.Icategory, c.IPrice FROM productmst c, Invoice o WHERE c.itemid = o.Itemid";
//print_r($sql);
$query = $conn->query($sql);

//$query = $db->query("SELECT id, BName, BAddress, BDistict,Bstate,Btaxid FROM usermst ");

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "product_sold_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('Item id', 'IName', 'Icategory', 'Invoice no', 'Date', 'Item price', 'QTY' ,'Total price');
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){     
        $lineData = array($row['Itemid'], $row['Iname'], $row['Icategory'], $row['INo'],'07/03/2018', $row['IPrice'], $row['qty'],$price=$row['IPrice']*$row['qty']);
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