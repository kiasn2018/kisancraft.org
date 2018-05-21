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
   </head>
   <body bgcolor="">
<?php
         include 'header.php';
         include '/config/db.php';
//echo $_POST["go"];
{
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
    
   { 
        $sqld = "SELECT DISTINCT D_name from Dealermst  ";
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
				<th>Q3</th>
				<th>Q4</th>
                
                </tr>
    <?php 
  while($rowd = mysqli_fetch_array($resultd)) {
	     $di=$rowd["D_name"];
         $sqld1 = "SELECT * from Dealermst WHERE D_name='$di' ";
        // echo $sqld;
        $resultd1 = mysqli_query($conn,$sqld1);     
        $rowd1= mysqli_fetch_array($resultd1);		
        $state=$rowd1['D_state'];
       // $di=$rowd1["D_name"];
        $amount="";
        //print_r($rows1);
        $sqlq1 = "SELECT SUM(amount) from Credit_td where party_name='$di' and Date Between '2017-04-01' and '2017-06-30'"; 
		//echo $sql;	
        $resultq1 = mysqli_query($conn,$sqlq1);
        ($rowq1 = mysqli_fetch_array($resultq1));
		$amoq1=$rowq1['SUM(amount)'];
        $sql1 = "SELECT SUM(Amount) from Salesmst where Vorture_type!='Stock Transfer Issues' AND Dealer_name='$di' and Date between '2017-04-01' and '2017-06-30'"; 
		//echo $sql;	
        $result1 = mysqli_query($conn,$sql1);
    while($row1 = mysqli_fetch_array($result1)) {
        //print_r($row);
        $amount1=$row1['SUM(Amount)'];
	}
        $sqlq2 = "SELECT SUM(amount) from Credit_td where party_name='$di' and Date Between '2017-07-01' and '2017-09-30'"; 
		//echo $sql;	
        $resultq2 = mysqli_query($conn,$sqlq2);
        ($rowq2 = mysqli_fetch_array($resultq2));
		$amoq2=$rowq2['SUM(amount)'];
        $sql2 = "SELECT SUM(Amount) from Salesmst where Vorture_type!='Stock Transfer Issues' AND Dealer_name='$di' and Date Between '2017-07-01' and '2017-09-30'"; 
		//echo $sql;	
        $result2 = mysqli_query($conn,$sql2);
    while($row2 = mysqli_fetch_array($result2)) {
        //print_r($row);
        $amount2=$row2['SUM(Amount)'];
    }
	$sqlq3 = "SELECT SUM(amount) from Credit_td where party_name='$di' and Date between'2017-10-01' and '2017-12-31'"; 
		//echo $sql;	
        $resultq3 = mysqli_query($conn,$sqlq3);
        ($rowq3 = mysqli_fetch_array($resultq3));
		$amoq3=$rowq3['SUM(amount)'];
        $sql3 = "SELECT SUM(Amount) from Salesmst where Vorture_type!='Stock Transfer Issues' AND Dealer_name='$di' and Date between'2017-10-01' and '2017-12-31'"; 
		//echo $sql;	
        $result3 = mysqli_query($conn,$sql3);
    while($row3 = mysqli_fetch_array($result3)) {
        //print_r($row);
        $amount3=$row3['SUM(Amount)'];
        
    }
	$sqlq4 = "SELECT SUM(amount) from Credit_td where party_name='$di' and Date Between '2018-01-01' and '2018-03-31'"; 
		//echo $sql;	
        $resultq4 = mysqli_query($conn,$sqlq4);
        ($rowq4 = mysqli_fetch_array($resultq4));
		$amoq4=$rowq4['SUM(amount)'];
        $sql4 = "SELECT SUM(Amount) from Salesmst where Vorture_type!='Stock Transfer Issues' AND Dealer_name='$di' and Date Between '2018-01-01' and '2018-03-31'"; 
		//echo $sql;	
        $result4 = mysqli_query($conn,$sql4);
    while($row4 = mysqli_fetch_array($result4)) {
        //print_r($row);
        $amount4=$row4['SUM(Amount)'];
        
    }
        ?>
                <tr>
                <td><?php echo $state; ?></td>
                <td><?php echo $di; ?></td>
                <td><?php echo ($amount1-$amoq1); ?></td>
				<td><?php echo ($amount2-$amoq2); ?></td>
				<td><?php echo ($amount3-$amoq3); ?></td>
				<td><?php echo ($amount4-$amoq4); ?></td>
                </tr> 
                <?php }?> 
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
