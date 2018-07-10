<?php
   include 'config/db.php';
   include 'header2.php';
   
   
   $sub='0';
   
   $sql = "SELECT sum(Amount) from Salesmaster where Date between '2018-01-01' and '2018-03-31' ";
   $result = mysqli_query($conn,$sql);
   $row = mysqli_fetch_array($result); {   
    ?>
<div class="main-panel">
<div class="content-wrapper">
<div class ="row">
<div class="col-6" >
   <h2>Incentive Calculation</h2>
   <div class="col-12 stretch-card">
      <div class="card">
         <div class="card-body">
            <form name="frmSearch" method="post" action="" class="forms-sample">
               <div class="form-group row">
                  <div class="col-sm-9">
                     <select name="month" id="month">
                        <option value="">Select Month</option>
                     </select>
                     <input type="submit" name="go" value="Update" class="btn btn-success mr-2" >
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
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
    if($month=="1"){  $start='2018-04-01';$end='2018-06-30';}elseif($month=="2"){$start='2018-07-01';$end='2018-09-30';}elseif($month=='3'){$start='2018-10-01';$end='2018-12-31';}elseif($month=='4'){$start='2019-01-01';$end='2019-03-31';}
       $sql = "SELECT sum(Amount) from sales where Date between '$start' and '$end' ";
    //echo $sql;
   $result = mysqli_query($conn,$sql);
   $row = mysqli_fetch_array($result);
   ?>
<div class="table-responsive">
<table  id="demo" class="table table-hover" >
   <tr>
      <th>Sales Q<?php echo ($month)?></th>
      <th><?php echo $Total=$row['sum(Amount)'];?></th>
   </tr>
   <tr>
   <th>Subsidy</th>
      <th><?php echo $sub='904663';?></th>
    </tr>
    <tr>
       <th>Net sales</th>
      <th><?php echo $total2=$Total-$sub;?></th>
    </tr>
   <tr>
      <th>Incentives Category</th>
      <th>Incentives Amount</th>
   </tr>
   <tr>
      <td>Incentives for Non sales</td>
      <td><?php echo round($amm=( $total2 * ( 0.003))); ?></td>
   </tr>
   <tr>
      <td>Incentives EXECUTIVES</td>
      <td><?php echo round($amm1=($Total * ( 0.004))); ?></td>
   </tr>
   <tr>
      <td>Incentives ASM</td>
      <td><?php echo round($amm1=($Total * ( 0.00125))); ?></td>
   </tr>
   <tr>
      <td>Incentives SM</td>
      <td><?php echo round($amm1=($Total * ( 0.00125))); ?></td>
   </tr>
   <tr>
      <td>Incentives ZM</td>
      <td><?php echo round($amm1=($Total * ( 0.0003))); ?></td>
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