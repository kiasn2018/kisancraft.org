<html>
<head>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="/kisankraft.org/src/js/sorttable.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

	<style>
	tr:nth-child(even) {
    background-color: #99ccb7;
                       }
	
	.sortable{border-top:#CCCCCC 4px solid; width:100%;font-size:15px;}
	.sortable th {padding:5px 20px; background: #F0F0F0;vertical-align:top;} 
	.sortable td {padding:5px 20px; border-bottom: #F0F0F0 1px solid;vertical-align:top;} 
	</style>
<body bgcolor="">
<?php 
include 'header.php';
include '/config/db.php';
?>

<div class="row">
<div class="span3 hidden-phone"></div>
<div class="span6" id="form-login">
<div class="span3 hidden-phone"></div>
</div>
</div>
<div>
</div>
<hr>
<div style="margin-left:22%; width:75%;">
<?php
$sql1 = "SELECT month,year from Stockmst ORDER BY month DESC ";
$result1 = mysqli_query($conn,$sql1);
$row1 = mysqli_fetch_array($result1);
$sql = "SELECT distinct SKU from Stockmst ORDER BY month DESC ";
$result = mysqli_query($conn,$sql);

//include '/test/index.php';
//include '/search.php'
?>
<h1>Ageing Analysis as on <?php echo $row1["month"];?>rd Month</h1>
<table class="sortable">
<thead>
<tr class="d0">
<th width="10%"><span>Stock SKU</span></th>
<th width="5%"><span> Stock QTY</span></th>
<th width="5%"><span>Stock Value</span></th>
<th width="5%"><span>Stock Rate</span></th>
<th width="5%"><span><?php ?>30days</span></th>
<th width="15%"><span>60 Days</span></th>
<th width="15%"><span>90 Days</span></th>
<th width="15%"><span>90-180 Days</span></th>

<th width="25%"><span>180-365 Days</span></th>
<th width="25%"><span>1 Yr - 1.5 Yr </span></th>
<th width="25%"><span> More than 1.5 yr</span></th>

</tr>
</thead>
<tbody>
	<?php
	$date ='2018-03-31';
	$oneMonthAgo = strtotime ( '-30  Day' , strtotime ( $date ) ) ; 
	$fdate=date ( 'Y-m-j' , $oneMonthAgo);
	 $orderdate = explode('-', $date);
            $month = $orderdate[1];
            $day   = $orderdate[2];
            $year  = $orderdate[0];
			$orderdate1 = explode('-',$fdate);
            $fmonth = $orderdate1[1];
            $day   = $orderdate1[2];
            $year  = $orderdate1[0];
	while($row = mysqli_fetch_array($result)){
	$sku=$row["SKU"];
	$sql1 = "SELECT Sum(QTY),Sum(Amount),Product from Stockmst where SKU='$sku' AND month='$month' ";
    $result1 = mysqli_query($conn,$sql1);
    while($row1 = mysqli_fetch_array($result1)){ 
	$p=$row1['Product'];
	$sql11 = "SELECT Sum(Quantity) from purches_mst where Item_name='$p' AND Date between '$fdate' and '$date' "; 
    $result11 = mysqli_query($conn,$sql11);
    ($row11 = mysqli_fetch_array($result11));
	//if($row11["Sum(Quantity)"]==""){echo $sql11."<br/>";}
	$q2=$row11["Sum(Quantity)"];
	?>
        <tr class="d1">
		<td><?php echo $row["SKU"]; ?></td>
			<td><?php echo $q1=$row1["Sum(QTY)"] ; ?></td>
			<td><?php echo $row1["Sum(Amount)"];?></td>
			<td><?php echo round($row1["Sum(Amount)"]/$row1["Sum(QTY)"]); ?></td>
			<td><?php echo min($q1,$q2);?></td>
			<td><?php echo $row3["Total_Earning"];?></td>
			<td><?php echo $am ; ?></td>
			<td><?php ?></td>
			</tr>
   <?php
}}
   ?>
   <tbody>
  </table>
  <br><br><br>
</div>
</body>
</head>
</html>
