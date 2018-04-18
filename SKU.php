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
<form class="form-horizontal well" action="importsku.php" method="post" name="upload_excel" enctype="multipart/form-data">
<fieldset>
<legend>Import CSV/Excel file</legend>
<div class="control-group">
<div class="control-label">
<label>CSV/Excel File:</label>
</div>
<div class="controls">
<input type="file" name="file" id="file" class="input-large">
<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
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
$results_per_page = 100;
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $results_per_page;
$sql = "SELECT * from Itemmst LIMIT ".$start_from.",".$results_per_page;


//$sql = "SELECT * from Itemmst ";
$result = mysqli_query($conn,$sql);
//include '/test/index.php';
//include '/search.php';

?>
<table class="sortable">
          <thead>
        <tr class="d0">
          <th width="10%"><span>ID</span></th>	
          <th width="50%"><span> Item Name</span></th>
          <th width="20%"><span>SKU</span></th>          
          <th width="25%"><span>Item Group</span></th>
          <th width="25%"><span>Action</span></th>	  
        </tr>
      </thead>
    <tbody>
	<?php
		while($row = mysqli_fetch_array($result)) {
	?>
        <tr class="d1">
            <td><?php echo $row["Itemid"]; ?></td>
			<td><?php echo $data= str_replace("_", "'",$row["Item_name"]); ?></td>
			<td><?php echo $row["SKU"]; ?></td>
			<td><?php echo $row["Item_group"]; ?></td>
			<td><a href="/kisankraft.org/editbranch.php?&rowid=<?php echo $row["Itemid"]?>" target="blank">Edit</a> | <a href="/kisankraft.org/editbranch.php?&rowid=<?php echo $row["Itemid"]?>" target="">Delete</a> </td>

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
<?php 
$sql = "SELECT COUNT(Itemid) AS total FROM Itemmst";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$total_pages = ceil($row["total"] / $results_per_page);
for ($i=1; $i<=$total_pages; $i++) {
    ?>  <a href="/kisankraft.org/itemid.php?page=<?php echo $i;?>"><?php echo $i;?></a><?php
    
    //echo "<a href=''?page=".$i."'>".$i."</a> ";
};
?>
</html>
