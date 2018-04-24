<?php
include 'config/db.php';
include 'header.php';

?>
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
    <style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
input[type=password], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>
    </head>
<?php

$sub='0';

$sql = "SELECT sum(Amount) from Salesmaster where Date between '2018-01-01' and '2018-03-31' ";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result); {   
 ?>
    <fieldset style="margin-left:30% ;width:50%">
    <legend>Incentive Calculation</legend>
    <div style="margin-left:30% ;width:50%">
    <form name="frmSearch" method="post" action="">
    <select name="month" id="month">
    <option value="">Select Month</option>
    </select>
   
   
    <input type="submit" name="go" value="Update" style="font-size:10pt;color:white;background-color:green;border:2px solid #336600;padding:8px" ><br>
    </form>
    </div>
    </fieldset>
    <?php }
?>
<script>
var d = new Date();
var monthArray = new Array();
monthArray[3] = "Jan-Mar-Q4";
monthArray[0] = "April-Jun-Q1";
monthArray[1] = "July-Sept-Q2";
monthArray[2] = "Oct-Dec-Q3";

for(m = 0; m <= 3; m++) {
    var optn = document.createElement("OPTION");
    optn.text = monthArray[m];
    // server side month start from one
    optn.value = (m+1);
 
    // if june selected
    
 
    document.getElementById('month').options.add(optn);
}
</script>
<?php 

if(isset($_POST["go"])){
    $year=$_POST["year"];
    $month=$_POST["month"]; 
    $AP=$_POST['tsales'];
    $BH=$_POST['credit'];
    $CH=$_POST['sub'];
    $DL=$_POST['nsales'];
    $GOA=$_POST['pince'];
    $GU=$_POST['inc'];
    $ecom=$_POST['ecom'];
    $exe=$_POST['exe'];
    $asm=$_POST['asm'];
    $sm=$_POST['sm'];
    $zm=$_POST['zm'];
	if($month=="1"){  $start='2017-04-01';$end='2017-06-30';}elseif($month=="2"){$start='2017-07-01';$end='2017-09-30';}elseif($month=='3'){$start='2017-10-01';$end='2017-12-31';}elseif($month=='4'){$start='2018-01-01';$end='2018-03-31';}
    $sql = "SELECT sum(Amount) from Salesmaster where Date between '$start' and '$end' ";
	//echo $sql;
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
?>
<table class="sortable">
<tr>
<th>Sales Q<?php echo ($month)?></th>
<th><?php echo $Total=$row['sum(Amount)'];?></th>
</tr>
<tr>
<th>Incentives Category</th>
<th>Incentives Amount</th>
</tr>
<tr>
<td>Incetives for Non sales</td>
<td><?php echo round($amm=($Total * ( 0.003))); ?></td>
</tr>
<tr>
<td>Incetives EXECUTIVES</td>
<td><?php echo round($amm1=($Total * ( 0.0025))); ?></td>
</tr>
<tr>
<td>Incetives ASM</td>
<td><?php echo round($amm1=($Total * ( 0.00052))); ?></td>
</tr>
<tr>
<td>Incetives SM</td>
<td><?php echo round($amm1=($Total * ( 0.000018))); ?></td>
</tr>
<tr>
<td>Incetives ZM</td>
<td><?php echo round($amm1=($Total * ( 0.00026))); ?></td>
</tr>
 </table>

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
  <button onclick="exportTableToCSV('Incentives summary.csv')">Export HTML Table To CSV File</button>
  <?php
}
