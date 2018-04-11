<?php
// date base connection
$servername = "localhost";
$username = "mayur1";
$password = "yes";
$dbname = "kisan";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

$invoiceno=$_POST[invoice_number];
//echo $invoiceno;
$sql = "SELECT Buyerid, Itemid , qty FROM Invoice where INo='$invoiceno'";
$query = $conn->query($sql);
$row = $query->fetch_assoc();
$itemid=$row[Itemid];
//product details
$sql2 = "SELECT Iname, Icategory , IPrice FROM productmst where itemid='$itemid'";
$query2 = $conn->query($sql2);
$row2 = $query2->fetch_assoc();
//print_r($row2);
$id=$row[Buyerid];
//echo $id;
//user details
$sql1 = "SELECT BName, BDistict , BAddress FROM usermst where id='$id'";
$query1 = $conn->query($sql1);
$row1 = $query1->fetch_assoc();
//print_r($row1);
?>

<html>
<head>
	<script src="//cdn.jsdelivr.net/alasql/0.2/alasql.min.js"></script> 	
			
	</head>
	<style>
	
	</style>
	<body>
	
User datails
<table style="width:80%" border=1  cellspacing="0" cellpadding="0" id="table_1">
  <tr>
    <th>Buyers Name</th><td><?php echo $row1[BName]; ?></td>
    <th>Buyers Address</th> <td><?php echo $row1[BAddress]; ?></td>
    </tr><tr><th>Distict</th><td><?php echo $row1[BDistict]; ?></td>
    <th>Invoice No</th><td><?php echo $invoiceno; ?></td>
  </tr>
  <tr>
  </tr>
  <tr>
    
  </tr>
</table>
Product details
<table style="width:80%" border=1 cellspacing="0" cellpadding="0">
<tr>
<th>Item name</th><td><?php echo $row2[Iname]; ?></td>
</tr>
<tr>
<th>Item Category</th><td><?php echo $row2[Icategory]; ?></td>
</tr>
<tr>
<th>Item Price</th><td><?php echo $row2[IPrice]; ?></td>
</tr>
<tr>
<th>Item QTY</th><td><?php echo $row[qty]; ?></td>
</tr>
</table>
Billing
<table style="width:80%" border=1 cellspacing="0" cellpadding="0">
<tr>
<th> Total Bill </th><td><?php echo $total=$row2[IPrice]*$row[qty];?></td>
</tr>
</table>


<?php 
// Set parameters
$apikey = '70d83fea-70ad-4b53-a262-df6e652dd183';
$value = '
User datails
<table style="width:80%" border=1  cellspacing="0" cellpadding="0" id="table_1">
  <tr>
    <th>Buyers Name</th><td>'.$row1[BName].'</td>
    <th>Buyers Address</th> <td>'.$row1[BAddress].'</td>
    </tr><tr><th>Distict</th><td>'. $row1[BDistict].' </td>
    <th>Invoice No</th><td>'. $invoiceno.'</td>
  </tr>
  <tr>
  </tr>
  <tr>
    
  </tr>
</table>
Product details
<table style="width:80%" border=1 cellspacing="0" cellpadding="0">
<tr>
<th>Item name</th><td>'. $row2[Iname].'</td>
</tr>
<tr>
<th>Item Category</th><td>'. $row2[Icategory].'</td>
</tr>
<tr>
<th>Item Price</th><td>'. $row2[IPrice].'</td>
</tr>
<tr>
<th>Item QTY</th><td>'. $row[qty].'</td>
</tr>
</table>
Billing
<table style="width:80%" border=1 cellspacing="0" cellpadding="0">
<tr>
<th> Total Bill </th><td>'.$total=$row2[IPrice]*$row[qty].'</td>
</tr>
</table>'; // can aso be a url, starting with http..

// Convert the HTML string to a PDF using those parameters.  Note if you have a very long HTML string use POST rather than get.  See example #5
$result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($apikey) . "&value=" . urlencode($value));

// Save to root folder in website
file_put_contents($invoiceno.'.pdf', $result);
$invoiceno1="http://192.168.0.157/kisankraft.org/index/$invoiceno.pdf";
//echo $invoiceno1;
echo '<a href="'.$invoiceno1.'" target="_blank">Download Invoice</a>';
?>

</body>

</html>