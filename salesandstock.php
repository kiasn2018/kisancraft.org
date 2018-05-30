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
      <h1 style="text-align:center;">Ageing Analysis </h1>
      <div class="container" style="margin-left:30%; width:50%; background-color:lightblue">
         <div class="row">
            <div class="span3 hidden-phone"></div>
            <div class="span6" id="form-login">
               <form name="insert" action="" method="post">
                  <table width="100%" height="117"  border="0">
                     <tr>
                        <td>
                           <select name="year" id="year">
                              <option value="">Select Year</option>
                           </select>
                           <select name="month" id="month">
                              <option value="">Select Month</option>
                           </select>
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
      <div></div>
      <hr>
      <script type="text/javascript">
         for(y = 2000; y <= 2500; y++) {
                 var optn = document.createElement("OPTION");
                 optn.text = y;
                 optn.value = y;
                 
                 // if year is 2015 selected
                 if (y == 2018) {
                     optn.selected = true;
                 }
                 
                 document.getElementById('year').options.add(optn);
         }
      </script>
      <script type="text/javascript">
         var d = new Date();
         var monthArray = new Array();
         monthArray[0] = "January";
         monthArray[1] = "February";
         monthArray[2] = "March";
         monthArray[3] = "April";
         monthArray[4] = "May";
         monthArray[5] = "June";
         monthArray[6] = "July";
         monthArray[7] = "August";
         monthArray[8] = "September";
         monthArray[9] = "October";
         monthArray[10] = "November";
         monthArray[11] = "December";
         for(m = 0; m <= 11; m++) {
             var optn = document.createElement("OPTION");
             optn.text = monthArray[m];
             // server side month start from one
             optn.value = (m+1);
          
             // if june selected
             if ( m == 3) {
                 optn.selected = true;
             }
          
             document.getElementById('month').options.add(optn);
         }
      </script>
      <?php
         if($_POST["go"]=="Submit"){
             $amount="";
             $year=($_POST["year"]);
             $month=($_POST["month"]);
         	//echo $year."-".$month;
         
         ?>
      <div style="margin-left:22%; width:100%;">
         <?php 
            $sql1 = "SELECT month,year from Stockmst ORDER BY month DESC ";
            $result1 = mysqli_query($conn,$sql1);
            $row1 = mysqli_fetch_array($result1);
            $sql = "SELECT DISTINCT Product from Stockmst where SKU='X-Part' ";
            $result = mysqli_query($conn,$sql);
            
            //include '/test/index.php';
            //include '/search.php'
            ?>
         <h1>Ageing Analysis- <?php echo $month_name = date("F", mktime(0, 0, 0, $month, 10));?> - Month</h1>
         <table class="sortable">
            <thead>
               <tr class="d0">
			   <th width=""><span>Stock Product</span></th>
                  <th width=""><span>Stock SKU</span></th>
                  <th width=""><span> Stock QTY</span></th>
                  <th width=""><span>Stock Value</span></th>
                  <th width=""><span>Stock Rate</span></th>
                  <th width=""><span>Last one year sales(QTY) </span></th>
                  <th width=""><span>Last one year sales(Amount) </span></th>
                 
               </tr>
            </thead>
            <tbody>
               <?php
                  $date =$year."-".$month;
                  
                  $fdate=date('Y-m', strtotime( date("Y-m-d", strtotime($date)) . '-1 month'));
                  $fdate60=date('Y-m', strtotime('-2 month'));
                  $fdate90=date('Y-m', strtotime('-3 month'));
                  $fdate91=date('Y-m', strtotime('-4 month'));
                  $fdate180=date('Y-m', strtotime('-6 month'));
                  $fdate181=date('Y-m', strtotime('-7 month'));
                  $fdate365=date('Y-m', strtotime(date("Y-m-d", strtotime($date)) .'-12 month'));
                  $fdate366=date('Y-m', strtotime('-13 month'));
                  $fdate367=date('Y-m', strtotime('-12 month'));
                  $fdate1y=date('Y-m', strtotime('-18 month'));
                  
                  //echo $fdate.$fdate60.$fdate90.$fdate180.$fdate365.$fdate1y;
                   $orderdate = explode('-', $date);
                             $month = $orderdate[1];
                             $day   = $orderdate[2];
                             $year  = $orderdate[0];
                  		$orderdate1 = explode('-',$fdate);
                             $fmonth = $orderdate1[1];
                             $day   = $orderdate1[2];
                             $year  = $orderdate1[0];
                  		$totalv="";
                  		$totalv1="";
                  while($row = mysqli_fetch_array($result)){
                  $sku=$row["SKU"];
				  $product=$row["Product"];
                  $sql1 = "SELECT Sum(QTY),Sum(Amount),Product,SKU from Stockmst where Product='$product' AND month='$month'  ";
                     $result1 = mysqli_query($conn,$sql1);
                     while($row1 = mysqli_fetch_array($result1)){ 
                  $sql15 = "SELECT Sum(QTY),Sum(Amount) from salesmerge where Product='$product' AND DATE_FORMAT(date, '%Y-%m') Between '$fdate365' And '$fdate' "; //echo $sql15;
                     $result15 = mysqli_query($conn,$sql15);
                     $row15 = mysqli_fetch_array($result15);
                  ?>
               <tr class="d1">
                  <td><?php echo $row["Product"]; ?></td>
				  <td><?php echo $row1["SKU"]; ?></td>
                  <td><?php echo $q1=$row1["Sum(QTY)"] ; ?></td>
                  <td><?php echo $row1["Sum(Amount)"]; $totalv=$totalv+$row1["Sum(Amount)"];?></td>
                  <td><?php echo $v=round($row1["Sum(Amount)"]/$row1["Sum(QTY)"]); ?></td>  
                  <td><?php echo $row15["Sum(QTY)"]; ?></td>
				  <td><?php echo $row15["Sum(Amount)"]; ?></td>
               </tr>
               <?php
                  }}
                  ?>
               
            <tbody>
         </table>
         <br><br><br>
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
         <button onclick="exportTableToCSV('Stock.csv')">Export HTML Table To CSV File</button>
      </div>
      <?php } ?>
   </body>
   </head>
</html>