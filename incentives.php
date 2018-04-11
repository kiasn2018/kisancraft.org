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
$name=array();
$sql = "SELECT distinct E_name from Employeemst ";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)) {
    $name1=$row["E_name"];
    $name[]=$name1;
}

//include '/test/index.php';
//include '/search.php'
?>
<table class="sortable">
<thead>
<tr class="d0">
<th width="10%"><span>Emp ID</span></th>

<th width="50%"><span> Employee Name</span></th>
<th width="20%"><span>Branch</span></th>
<th width="25%"><span>Category</span></th>
<th width="25%"><span>Total Earning</span></th>
</tr>
</thead>
<tbody><?php 
for($m=0;$m<(count($name));$m++){
$sql = "SELECT * from Employeemst where E_name='$name[$m]' and month between 1 and 3 and year='2018' ";
//echo $sql;
$result = mysqli_query($conn,$sql);
$am=0;
while($row = mysqli_fetch_array($result)) {
   
    $am=$am+$row["Total_Earning"];
    $id=$row["E_id"];
    $br= $row["Branch"];
    $str = strtolower($row["Department"]);
}
if($str!='sales'){
	?>
        <tr class="d1">
            <td><?php echo $id; ?></td><td><?php echo $name[$m]; ?></td>
			<td><?php echo $br; ?></td>
			<td><?php echo $str ; ?></td>
			<td><?php echo $am; ?></td>
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
