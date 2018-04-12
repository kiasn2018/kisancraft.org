<?php ini_set('max_execution_time', 0);?>
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
<h1 style="text-align:center;"> sales with respect Dealer wise </h1>
<div class="container" style="margin-left:30%; width:50%; background-color:lightblue">
<div class="row">
<div class="span3 hidden-phone"></div>
<div class="span6" id="form-login">
<form name="insert" action="" method="post">
<table width="100%" height="117"  border="0">
<tr>
<th  height="63" scope="row"> State :</th>
<td width=""><select onChange="getdistrict(this.value);"  name="state" id="state" class="form-control" >
<option value="">Select</option>
<?php $sqlst = "SELECT DISTINCT D_state from Dealermst ";
$resultst = mysqli_query($conn,$sqlst);

while($rowst=mysqli_fetch_array($resultst))
{  ?>
<option value="<?php echo $rowst['D_state'];?>"><?php echo $rowst['D_state'];?></option>
<?php
}
?>
</select></td>
<th scope="row">District :</th>
<td><select onChange="getdealer(this.value);" name="district" id="district-list" class="form-control">
<option value="">Select</option>
</select></td>
<th scope="row">Dealer :</th>
<td><select  name="dealer" id="dealer-list" class="form-control">
<option value="">Select</option>
</select></td>
<td>

<tr>
<td>
<input type="text" placeholder="From Date" style="margin-left:2%;" id="post_at" name="search[post_at]"  value="<?php echo $post_at; ?>" class="input-control" />
<input type="text" placeholder="To Date" id="post_at_to_date" name="search[post_at_to_date]" style="margin-left:10px"  value="<?php echo $post_at_to_date; ?>" class="input-control"  />
</td>
<td>
<input type="submit" name="go" value="Submit" style="font-size:10pt;color:white;background-color:green;border:2px solid #336600;padding:8px;float:left" >
</td>
</tr>
</table>

</form>

</div>
<div class="span3 hidden-phone"></div>
</div>
</div>
<div>
</div>
<hr>
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
<script>
function getdistrict(val) {
$.ajax({
type: "POST",
url: "getdistrict.php",
data:'state_id='+val,
success: function(data){
$("#district-list").html(data);
}
});
}

function getdealer(val) {
	$.ajax({
	type: "POST",
	url: "getdealer.php",
	data:'state_id='+val,
	success: function(data){
	$("#dealer-list").html(data);
	}
	});
	}
</script>
<div style="margin-left:22%; width:75%;">
<?php 
$results_per_page = 100;
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $results_per_page;
$sql = "SELECT * from Salesmst LIMIT ".$start_from.",".$results_per_page;
$result = mysqli_query($conn,$sql);
//include '/test/index.php';
//include '/search.php';
if(!isset($_POST["go"]) ){
?>
<table class="sortable">
          <thead>
        <tr class="d0">
          <th width="10%"><span>ID</span></th>	
          <th width="50%"><span> Dealer Name</span></th>
          <th width="20%"><span>Date</span></th>  
          <th width="20%"><span>Voucher Type</span></th>          
          <th width="25%"><span>Item Name</span></th>
          <th width="25%"><span>District</span></th>
          <th width="25%"><span>State</span></th>
          <th width="25%"><span>Executive</span></th>
          <th width="25%"><span>ASM</span></th>
          <th width="25%"><span>QTY</span></th>
          <th width="25%"><span>Amount</span></th>	  
        </tr>
      </thead>
    <tbody>
	<?php
		while($row = mysqli_fetch_array($result)) {
	?>
        <tr class="d1">
            <td><?php echo $row["ID"]; ?></td>
			<td><?php echo  $data= str_replace("_", "'", $row["Dealer_name"]); ?></td>
			<td><?php echo  $row["Date"]; ?></td>
			<td><?php echo $row["Vorture_type"];  ?></td>
			<td><?php echo $data1= str_replace("_", "'", $row["Item_name"]);$row["Item_name"]; ?></td>
			<td><?php $d=$row["Dealer_name"];
			$sqls = "SELECT * from Dealermst where D_name='$d' ";
			//echo $sqls;
            $results = mysqli_query($conn,$sqls);
            while($rows = mysqli_fetch_array($results)) {
                $district=$rows["D_distict"];
                $state=$rows["D_state"];
            } 
            $sqls1 = "SELECT * from Excutivemst where State='$state' AND District= '$district'";
            $results1 = mysqli_query($conn,$sqls1);
            while($rows1 = mysqli_fetch_array($results1)) {
           
                $exec=$rows1["Exexutive"];
                $ASM=$rows1["ASM"];
            }
            echo $district;
            ?></td>
            <td><?php echo $state;?></td>
            <td><?php echo $exec;?></td>
            <td><?php echo $ASM;?></td>
			<td><?php echo $row["Quantity"]; ?></a> </td>
			<td><?php echo $row["Amount"]; ?></a> </td>

		</tr>
   <?php
		}
   ?>
   <tbody>
  </table>
  <?php
$sql = "SELECT COUNT(ID) AS total FROM Salesmst";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page);

for ($i=1; $i<=$total_pages; $i++) {
    ?>  <a href="/kisankraft.org/salesupload.php?page=<?php echo $i;?>"><?php echo $i;?></a><?php 
    
    //echo "<a href=''?page=".$i."'>".$i."</a> ";
};
   }?>
  <br><br><br>
</div>
</body>
</head>
</html>
<hr>
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
        $sqld = "SELECT D_state,D_name from Dealermst  ";
        // echo $sqld;
        $resultd = mysqli_query($conn,$sqld);
        
        ?>
     <div style="width:60%; float :left ; margin-left: 15%">
     <a href="#">Download report</a>
                <table class="sortable" style="with:40%">
                <tr>
                <th>State</th>
                <th>Dealer</th>
                <th>Q1</th>
				<th>Q2</th>
                
                </tr>
    <?php 
  while($rowd = mysqli_fetch_array($resultd)) {
        
        $state=$rowd['D_state'];
        $di=$rowd["D_name"];
        $amount="";
        //print_r($rows1);
        $sql1 = "SELECT SUM(amount) from Credit_td where party_name='$di' ".$queryCondition; 
		//echo $sql;	
        $result1 = mysqli_query($conn,$sql1);
        ($row1 = mysqli_fetch_array($result1));
		$amo=$row1['SUM(amount)'];
        $sql = "SELECT SUM(Amount) from Salesmst where Vorture_type!='Stock Transfer Issues' AND Dealer_name='$di' ".$queryCondition; 
		//echo $sql;	
        $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result)) {
        //print_r($row);
        $amount=$row['SUM(Amount)'];
        
        
      
    }
        ?>
                <tr>
                <td><?php echo $state; ?></td>
                <td><?php echo $di; ?></td>
				<td><?php echo $amount; ?></td>
                <td><?php echo ($amount-$amo); ?></td>
                </tr> 
                <?php }?> 
				</table>
                </div>
                <?php 
   }}
