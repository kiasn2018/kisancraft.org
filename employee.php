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
<div class="container" style="margin-left:30%; width:60%; background-color:lightblue">
<div class="row">
<div class="span3 hidden-phone"></div>
<div class="span6" id="form-login">
<form class="form-horizontal well" action="importemployee.php" method="post" name="upload_excel" enctype="multipart/form-data">
<fieldset>
<legend>Import CSV/Excel file</legend>
<div class="control-group">
<div class="control-label">
<label>CSV/Excel File:</label>
</div>
<div class="controls">
<label>Please Enter the month and year of uploading data</label><br/>
<input type="Number" placeholder="Enter Month" name="month" id="month" class="input-large" required >
<input type="Number" placeholder="Enter Year" name="year" id="year" class="input-large" required>
<input type="file" name="file" id="file" class="input-large">
<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
<?php 
$sql1 = "SELECT month,year from Employeemst ORDER BY ID DESC ";
$result1 = mysqli_query($conn,$sql1);
$row1 = mysqli_fetch_array($result1);
//print_r($row1[[month]]);
?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label ><font color="mahogany"><b>Last Uploaded Salary sheet : Month = <?php echo $row1["month"]?> and Year = <?php echo $row1["year"] ?></b></font></label>

</div>
</div>

<div class="control-group">
<div class="controls">
<a href="/kisankraft.org/sample/sample1.csv"> Download Sample File</a>
</div>
</div>
</fieldset>
</form>
</div>
<div class="span3 hidden-phone"></div>
</div>
</div>
<div>
</div>
<hr>
<div style="margin-left:22%; width:75%;">
<?php 
$sql = "SELECT * from Employeemst ";
$result = mysqli_query($conn,$sql);
//include '/test/index.php';
//include '/search.php';

?>
<table class="sortable">
          <thead>
        <tr class="d0">
          <th width="10%"><span>Emp ID</span></th>	
        <th width="10%"><span>Month</span></th>	
        <th width="10%"><span>Year</span></th>	
          <th width="50%"><span> Employee Name</span></th>
          <th width="20%"><span>Branch</span></th>          
          <th width="25%"><span>Category</span></th>
          <th width="25%"><span>Total Earning</span></th>	 
        </tr>
      </thead>
    <tbody>
	<?php
		while($row = mysqli_fetch_array($result)) {
	?>
        <tr class="d1">
            <td><?php echo $row["E_id"]; ?></td>
            <td><?php echo $row["month"]; ?></td>
            <td><?php echo $row["year"]; ?></td>
			<td><?php echo $row["E_name"]; ?></td>
			<td><?php echo $row["Branch"]; ?></td>
			<td><?php $str = strtolower($row["Department"]);if($str=="sales") { echo "sales";}else{echo "Non sales";} ?></td>
			<td><?php echo $row["Total_Earning"]; ?></td>
			

		</tr>
   <?php
		}
   ?>
   <tbody>
  </table>
  <br><br><br>
</div>
</body>
</head>
</html>
