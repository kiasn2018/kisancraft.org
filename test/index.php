<?php
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
		
		$queryCondition .= "WHERE Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
	}

	$sql = "SELECT * from purches_mst " . $queryCondition . " ORDER BY Date desc";
	$result = mysqli_query($conn,$sql);
?>

<html>
	<head>
    <title>Purchase Report By SKU and Supplier</title>		
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
	</head>
	
	<body>
    <div class="demo-content">
		<h2 class="title_with_link">Purchase Report By SKU and Supplier</h2>
		<div style="border: 1px solid green">
		<br>
		<form name="" method="post" action="">
		<div class="search-box">
        <input type="text" name="search[IName]" autocomplete="off" placeholder="Search Item Name..." style="margin-left:10%;" >
         <div class="result"></div>
    </div>
    <input type="submit" name="go0" value="Submit" style="font-size:10pt; margin-left:3%; color:white;background-color:green;border:2px solid #336600;padding:8px" >
    </form>
    <div style="float:right;">
    <form name="frmSearch" method="post" action="purchesreport.php">
	 <p class="">
		<input type="hidden" placeholder="From Date"  name="search[post_at]"  value="<?php echo $post_at; ?>" class="input-control" />
	    <input type="hidden" placeholder="To Date"  name="search[post_at_to_date]" style="margin-left:10px"  value="<?php echo $post_at_to_date; ?>" class="input-control"  />			 
		<input type="submit" style="font-size:10pt;margin-right:250px;color:white;background-color:green;border:2px solid #336600;padding:8px" name="go0" value="Download report" >
	</p>
 </form>
 </div>
  <form name="frmSearch" method="post" action="">
	 <p class="search_input">
		<input type="text" placeholder="From Date" style="margin-left:2%;" id="post_at" name="search[post_at]"  value="<?php echo $post_at; ?>" class="input-control" />
	    <input type="text" placeholder="To Date" id="post_at_to_date" name="search[post_at_to_date]" style="margin-left:10px"  value="<?php echo $post_at_to_date; ?>" class="input-control"  />			 
		<input type="submit" name="go" value="Search" style="font-size:10pt;color:white;background-color:green;border:2px solid #336600;padding:8px" >
	</p>
	</form>
	<br>
	</div>
<?php if(empty($_POST["search"]["IName"])){ if(!empty($result))	 { 

    ?>
<table class="sortable">
          <thead>
        <tr class="d0">
                      
          <th width="20%"><span>Date</span></th>
          <th width="40%"><span>Supplier</span></th>          
          <th width="45%"><span>Item Name</span></th>
          <th width="35%"><span>QTY</span></th>
          <th width="30%"><span>Rate</span></th>
          <th width="15%"><span>Value</span></th>
          <th width="10%"><span>Landed cost</span></th>	  
          <th width="10%"><span>Action</span></th>	  
        </tr>
      </thead>
    <tbody>
	<?php
		while($row = mysqli_fetch_array($result)) {
	?>
        <tr class="d1">
			<td><?php echo $row["Date"]; ?></td>
			<td><?php echo $row["Supplier"]; ?></td>
			<td><?php echo $row["Item_name"]; ?></td>
			<td><?php echo $row["Quantity"]; ?></td>
			<td><?php echo $row["Rate"]; ?></td>
			<td><?php echo $row["Value"]; ?></td>
			<td><?php echo $row["Londedcost_unit"]; ?></td>
			<td><a href="/kisankraft.org/editproduct.php?&rowid=<?php echo $row["ID"]?>" target="blank">View</a> </td>

		</tr>
   <?php
		}
   ?>
   <tbody>
  </table>
<?php }} ?>
<br><br><br>
    </div>
  
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
$.datepicker.setDefaults({
showOn: "button",
buttonImage: "datepicker.png",
buttonText: "Date Picker",
buttonImageOnly: true,
dateFormat: 'dd-mm-yy'  
});
$(function() {
$("#post_at").datepicker();
$("#post_at_to_date").datepicker();
});
</script>
</body></html>
