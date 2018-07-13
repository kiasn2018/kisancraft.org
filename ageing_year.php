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
       <script src="js/tableToExcel.js"></script>
   <body bgcolor="">
      <?php 
         include 'header2.php';
         include '/config/db.php';
         ?>
      <div class="main-panel">
      <div class="content-wrapper">
      <div class ="row">
      <div class="col-6" >
         <h1 style="text-align:center;">Ageing Analysis </h1>
         <div class="col-12 stretch-card">
            <div class="card">
               <div class="card-body">
                  <form name="insert" action="" method="post" class="forms-sample">
                     <div class="form-group row">
                        <div class="col-sm-9">
                           <select name="year" id="year">
                              <option value="">Select Year</option>
                           </select>
                           <select name="month" id="month">
                              <option value="">Select Month</option>
                           </select>
                           <input type="submit" name="go" value="Submit" class="btn btn-success mr-2"  >
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
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
            $sql1 = "SELECT month,year from Stockmst ORDER BY month DESC ";
            $result1 = mysqli_query($conn,$sql1);
            $row1 = mysqli_fetch_array($result1);
            $sql = "SELECT distinct SKU from Stockmst ORDER BY month DESC ";
            $result = mysqli_query($conn,$sql);
            
            //include '/test/index.php';
            //include '/search.php'
            ?>
      <div class="col-md-12 ">
      <div class="card">
      <h1>Ageing Analysis- <?php echo $month_name = date("F", mktime(0, 0, 0, $month, 10));?> - Month</h1>
      <div class="table-responsive">
         <table  id="demo" class="table table-hover" >
            <thead>
               <tr class="d0">
                  <th width=""><span>Stock SKU</span></th>
                  <th width=""><span> Stock QTY</span></th>
                  <th width=""><span>Stock Value</span></th>
                  <th width=""><span>Stock Rate</span></th>
                  <th width=""><span> Purches >6 months</span></th>
                  <th width=""><span>Ageing </span></th>
                  <th width=""><span>Balance</span></th>
                  <th width=""><span> Purches > 1 year</span></th>
                  <th width=""><span>Ageing </span></th>
                  <th width=""><span>Balance</span></th>
                  <th width=""><span> Purches >2 year</span></th>
                  <th width=""><span>Ageing </span></th>
                  <th width=""><span>Balance</span></th>
                  <th width=""><span> Purches < 3 year </span></th>
                  <th width=""><span>Ageing </span></th>
                  <th width=""><span>Balance</span></th>
                  
               </tr>
            </thead>
            <tbody>
               <?php
                  $date =$year."-".$month;
                  
                  $fdate=date('Y-m', strtotime(date("Y-m-d", strtotime($date)) .'-0 month'));
                  $fdate6=date('Y-m', strtotime(date("Y-m-d", strtotime($date)) .'-6 month'));
                  $fdate1=date('Y-m', strtotime(date("Y-m-d", strtotime($date)) .'-12 month'));
                  $fdate2=date('Y-m', strtotime(date("Y-m-d", strtotime($date)) .'-24 month'));
                  $fdate3=date('Y-m', strtotime(date("Y-m-d", strtotime($date)) .'-36 month'));
                  
                  
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
                  $sql1 = "SELECT Sum(QTY),Sum(Amount),Product from Stockmst where SKU='$sku' AND month='$month'  ";
                     $result1 = mysqli_query($conn,$sql1);
                     while($row1 = mysqli_fetch_array($result1)){ 
                  $p=$row["SKU"];
                  $sql11 = "SELECT Sum(Quantity) from purches_mst where SKU='$p' AND  DATE_FORMAT(date, '%Y-%m') between '$fdate6' and '$fdate'   "; 
                  //echo $sql11;
                     $result11 = mysqli_query($conn,$sql11);
                     ($row11 = mysqli_fetch_array($result11));
                  $sql60 = "SELECT Sum(Quantity) from purches_mst where SKU='$p' AND DATE_FORMAT(date, '%Y-%m')  between '$fdate2' and '$fdate' "; 
                  //echo $sql60;
                     $result60 = mysqli_query($conn,$sql60);
                     ($row60 = mysqli_fetch_array($result60));
                  $sql90 = "SELECT Sum(Quantity) from purches_mst where SKU='$p' AND DATE_FORMAT(date, '%Y-%m') BETWEEN '$fdate3' and '$fdate' "; 
                  //echo $sql90;
                     $result90 = mysqli_query($conn,$sql90);
                     ($row90 = mysqli_fetch_array($result90));
                  $sql180 = "SELECT Sum(Quantity) from purches_mst where SKU='$p' AND DATE_FORMAT(date, '%Y-%m')   <= '$fdate3'   "; 
                      //echo $sql180   ;
                      $result180 = mysqli_query($conn,$sql180);
                     ($row180 = mysqli_fetch_array($result180));
                  
                  //if($row11["Sum(Quantity)"]==""){echo $sql11."<br/>";}
                  $q2=$row11["Sum(Quantity)"];
                  $q60=$row60["Sum(Quantity)"];
                  $q90=$row90["Sum(Quantity)"];
                  $q180=$row180["Sum(Quantity)"];
                  $q365=$row365["Sum(Quantity)"];
                  $q1y=$row1y["Sum(Quantity)"];
                  $q15=$row15["Sum(Quantity)"];
                  ?>
               <tr class="d1">
                  <td><?php echo $row["SKU"]; ?></td>
                  <td><?php echo $q1=$row1["Sum(QTY)"] ; ?></td>
                  <td><?php echo $row1["Sum(Amount)"]; $totalv=$totalv+$row1["Sum(Amount)"];?></td>
                  <td><?php echo $v=round($row1["Sum(Amount)"]/$row1["Sum(QTY)"]); ?></td>
                  <td><?php echo $q2;?></td>
                  <td><?php echo $a30=min($q1,$q2);?></td>
                  <td><?php echo $s30=-$a30+$q1;?></td>
                  <td><?php echo $q60;?></td>
                  <td><?php echo $a60=min($s30,$q60);?></td>
                  <td><?php echo $s60=-$a60+$s30;?></td>
                  <td><?php echo $q90;?></td>
                  <td><?php echo $a90=min($s60,$q90);?></td>
                  <td><?php echo $s90=-$a90+$s60;?></td>
                  <td><?php echo $q180;?></td>
                  <td><?php echo $a180=min($s90,$q180);?></td>
                  <td><?php echo $s180=-$a180+$s90;?></td>
                  
                  <td><?php echo $s180*$v; $totalv1=$totalv1+($s180*$v);?></td>
               </tr>
               <?php
                  }}
                  ?>
               <tr>
                  <td>Total</td>
                  <td></td>
                  <td><?php echo  $totalv=$totalv+$row1["Sum(Amount)"];?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                 
                  <td><?php echo $totalv1=$totalv1+($s180*$v);?></td>
               </tr>
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