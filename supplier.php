<?php
include 'header.php';
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
$sql = "SELECT DISTINCT Supplier " . $queryCondition . " ORDER BY Date desc";
$result = mysqli_query($conn,$sql);
$sql = "SELECT DISTINCT Supplier " . $queryCondition . " ORDER BY Date desc";
$result = mysqli_query($conn,$sql);
?>

<html>
	<head>
    <title>Search By Date</title>		
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
	<div style="margin-left:22%; width:75%;">
    <div class="demo-content">
		<h2 class="title_with_link">Filter By Date</h2>
		<div style="border: 1px solid green">
		<br>
		<form name="" method="post" action="">
		<div class="search-box">
        <input type="text" name="search[IName]" autocomplete="off" placeholder="Search Supplier Name..." style="margin-left:10%;" >
         <div class="result"></div>
    </div>
    <input type="submit" name="go0" value="Submit" style="font-size:10pt; margin-left:3%; color:white;background-color:green;border:2px solid #336600;padding:8px" >
    </form>
    <div style="float:right;">
    <form name="frmSearch" method="post" action="purchesreportbysupplier.php">
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
		<input type="submit" name="go" value="Submit" style="font-size:10pt;color:white;background-color:green;border:2px solid #336600;padding:8px" >
	</p>
	</form>
	<br>	
	</div>
<?php
include 'search1.php';
if(empty($_POST["search"]["IName"])){ if(!empty($result))	 { 

    ?>
<table class="sortable">
          <thead>
        <tr class="d0">
                      
          <th width="20%"><span>Date</span></th>
          <th width="40%"><span>Supplier</span></th>          
          <th width="15%"><span>Total Value</span></th>
          <th width="10%"><span>Additional Value</span></th>	  
            
        </tr>
      </thead>
    <tbody>
	<?php
		while($row = mysqli_fetch_array($result)) {
	?>
        <tr class="d1">
			<td><?php echo $row["Date"]; ?></td>
			<td><?php echo $row["Supplier"]; ?></td>
			<td><?php echo $row["Total_value"]; ?></td>
			<td><?php echo $row["Addl_value"]; ?></td>
			

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
</div>
</body></html>

<?php 
//echo $_POST["go"];
if($_POST["go"]=="Submit"){
    $amount="";
    $district=($_POST["district"]);
    $state=($_POST["state"]);
	 $queryCondition = "";
    if(!empty($_POST["search"]["post_at"])) {
        $post_at = $_POST["search"]["post_at"];
        list($fid,$fim,$fiy) = explode("-",$post_at);    
        $post_at_todate = date('Y-m-d');
        if(!empty($_POST["search"]["post_at_to_date"])) {
            $post_at_to_date = $_POST["search"]["post_at_to_date"];
            list($tid,$tim,$tiy) = explode("-",$_POST["search"]["post_at_to_date"]);
            $post_at_todate = "$tiy-$tim-$tid";
            $queryCondition .= " AND Date BETWEEN '$fiy-$fim-$fid' AND '". $post_at_todate . "'";
        }}
		//echo 
    
   {   
        $sqld = "SELECT * FROM purches_mst where voucher_type='Purchase Imports'".$queryCondition;
        // echo $sqld;
        $resultd = mysqli_query($conn,$sqld);
        ?>
     <div style="width:60%; float :left ; margin-left: 15%">
     
                <table class="sortable" style="with:40%">
				<tr>
				<h1>From <?php echo $post_at; ?> TO <?php echo $post_at_todate ?></h1>
				</tr>
                <tr>
                <th>Date</th>
                <th width='25%'>Supplier</th>
				<th>SKU</th>
				<th>QTY</th>
				<th>Rate in USD</th>
				<th>Landed Cost in INR</th>
                </tr>
				<?php 
  while($rowd = mysqli_fetch_array($resultd)) {
	    $state=$rowd['Supplier'];
		$rate=$rowd['Rate'];
		$sku=$rowd['Quantity'];
		$r=str_replace("US$","",$rate); 
		$rt=str_replace("/","",$r);
        ?>
				<td><?php echo $rowd['Date']; ?></td>
                <td><?php echo str_replace(",",".",$state); ?></td>
				<?php 
			     $pro=$rowd['Item_name'];
				 $sqls = "SELECT SKU FROM Itemmst where Item_name='$pro' ";
                 $results = mysqli_query($conn,$sqls);
				 $rows = mysqli_fetch_array($results);
         ?>
				<td><?php echo  $rows['SKU']; ?></td>
				<td><?php echo  str_replace("Pec.","",$sku); ?></td>
				<td><?php echo  $rt; ?></td>
				<td><?php echo  $rowd['Londedcost_unit']; ?></td>
				</tr><?php
  }?> 
				</table>
                </div>
				<script>
  function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
  </script>
				<button onclick="exportTableToCSV('members.csv')">Export HTML Table To CSV File</button>
                <?php 
}}
