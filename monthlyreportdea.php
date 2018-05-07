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
      <h1 style="text-align:center;"> sales Monthly report Segment wise </h1>
      <div class="container" style="margin-left:30%; width:50%; background-color:lightblue">
         <div class="row">
            <div class="span3 hidden-phone"></div>
            <div class="span6" id="form-login">
               <form name="insert" action="" method="post">
                  <table width="100%" height="117"  border="0">
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
      <div></div>
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
      {   $seg=array();
	      $amt=array();
		  $qty=array();
           $sqld = "SELECT DISTINCT Dealer FROM sales";
           // echo $sqld;
           $resultd = mysqli_query($conn,$sqld);
   		$sqldq = "SELECT DISTINCT Segment from SKU";
           // echo $sqld;
           $resultdq = mysqli_query($conn,$sqldq);
   		$resultdqq = mysqli_query($conn,$sqldq);
           
           ?>
<div style="width:60%; float :left ; margin-left: 15%">
   <table class="sortable" style="with:40%">
      <tr>
         <h1>From <?php echo $post_at; ?> TO <?php echo $post_at_todate ?></h1>
      </tr>
      <tr>
         <th>State</th>
         <th>District</th>
		 <th>Dealer</th>
         <th>ZM</th>
         <th>SM</th>
         <th>ASM</th>
         <th>Executive</th>
         <?php $td='';
			$totalam='';
            while($rowdq = mysqli_fetch_array($resultdq)){ if($rowdq['Segment']!=''){?>
         <th ><?php echo $rowdq['Segment'].'-Qty'; $seg[]=$rowdq['Segment'];?></th>
         <th><?php echo $rowdq['Segment'].'-Amt'; ?></tdh>
            <?php }} ?>
         <th>Trade Discount</th>
         <th>Total Sales (INR)</th>
      </tr>
      <?php $to='';
	        
         while($rowd = mysqli_fetch_array($resultd)) {
          $to='';
               $de=$rowd["Dealer"];
                $sqls1 = "SELECT State,Executive,ASM,SM,ZM,District from sales where  Dealer= '$de'";
                   $results1 = mysqli_query($conn,$sqls1);
                   $rows1 = mysqli_fetch_array($results1);
                   $state=$rows1['State'];
				   $di=$rows1["District"];
               ?>
      <tr>
         <td><?php echo $state; ?></td>
         <td><?php echo $di; ?></td>
		 <td><?php echo str_replace(",",".",$de); ?></td>
         <td><?php echo $rows1["ZM"]; ?></td>
         <td><?php echo $rows1["SM"]; ?></td>
         <td><?php echo $rows1["ASM"]; ?></td>
         <td><?php echo $rows1["Executive"]; ?></td>
         <?php 
            for($j=0;$j<(count($seg));$j++){
                 $sqld1 = "SELECT sum(QTY),sum(Amount) from sales WHERE Dealer='$de' AND Seqment='$seg[$j]' ".$queryCondition;
                // echo $sqld;
                $resultd1 = mysqli_query($conn,$sqld1);     
                $rowd1= mysqli_fetch_array($resultd1);
            //print_r($rowd1);
                 $sqld111 = "SELECT sum(QTY) from sales WHERE Dealer='$de' AND Segment1='$seg[$j]' ".$queryCondition;
                // echo $sqld;
                $resultd111 = mysqli_query($conn,$sqld111);     
                $rowd111= mysqli_fetch_array($resultd111);
            ?>
         <td><?php echo $rowd1['sum(QTY)']+$rowd111['sum(QTY)']; $qty[$j]=$qty[$j]+$rowd1['sum(QTY)']+$rowd111['sum(QTY)']; ?></td>
         <td><?php echo $rowd1['sum(Amount)']; $to=$to+$rowd1['sum(Amount)'];  $amt[$j]=$amt[$j]+$rowd1['sum(Amount)'];?></td>
         <?php }
            $sqld11 = "SELECT sum(Amount) from sales WHERE Dealer='$de' AND Product='' ".$queryCondition;
                  // echo $sqld;
                  $resultd11 = mysqli_query($conn,$sqld11);     
                  $rowd11= mysqli_fetch_array($resultd11);
            
            ?>
         <td><?php echo $rowd11['sum(Amount)']; $to=$to+$rowd11['sum(Amount)']; $td=$td+$rowd11['sum(Amount)'];?></td>
         <td><?php echo $to;?></td>
      </tr>
	   <?php
	  }?> 
	  <tr>
	  <td> Total</td>
	  <td></td>
	  <td></td>
	  <td></td>
	  <td></td>
	  <td></td>
	  <td></td>
	  <?php 
	  for($j=0;$j<(count($seg));$j++){
		  ?>
	  <td><?php echo $qty[$j]; ?></td>
	  <td><?php echo $amt[$j]; $totalam=$totalam+$amt[$j];?></td>
      <?php
	  }?>
	  <td><?php echo $td; $totalam=$totalam+$td;?></td>
	   <td><?php echo $totalam;?></td>
	  </tr>
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
<button onclick="exportTableToCSV('Sales segment wise.csv')">Export HTML Table To CSV File</button>
<?php 
}}