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
		 
		  $sqld = "SELECT Date FROM `sales` ORDER BY `sales`.`Date` DESC ";
               // echo $sqld;
          $resultd = mysqli_query($conn,$sqld);     
          $rowd= mysqli_fetch_array($resultd);
		 
         ?>
      <h1 style="text-align:center;"> Sales Report Executive wise </h1>
      <div class="container" style="margin-left:30%; width:50%; background-color:lightblue">
         <div class="row">
            <div class="span3 hidden-phone"></div>
            <div class="span6" id="form-login">
               <form name="insert" action="" method="post">
                  <table width="100%" height="117"  border="0">
                     <tr>
                        <th width="50%"> State :</th>
                        <td>
                           <select onChange="getdistrict(this.value);"  name="state" id="state" class="form-control" >
                              <option value="">Select</option>
							   <option value="ALL">ALL</option>
                              <?php $sqlst = "SELECT DISTINCT D_state from Dealermst ";
                                 $resultst = mysqli_query($conn,$sqlst);
                                 
                                 while($rowst=mysqli_fetch_array($resultst))
                                 {  ?>
                              <option value="<?php echo $rowst['D_state'];?>"><?php echo $rowst['D_state'];?></option>
                              <?php
                                 }
                                 ?>
                           </select>
                        </td>
                        <th scope="row">District :</th>
                        <td>
                           <select onChange="getdealer(this.value);" name="district" id="district-list" class="form-control">
                              <option value="">Select</option>
                           </select>
                        </td>
                        
                     <tr>
                        <td>
                           <input type="text" placeholder="From Date" style="margin-left:2%;" id="post_at" name="search[post_at]"  value="<?php echo $post_at; ?>" class="input-control" />
                           <input type="text" placeholder="To Date" id="post_at_to_date" name="search[post_at_to_date]" style="margin-left:10px"  value="<?php echo $post_at_to_date; ?>" class="input-control"  />
                        </td>
                        <td>
                           <input type="submit" name="go" value="Submit" style="font-size:10pt;color:white;background-color:green;border:2px solid #336600;padding:8px;float:left" >
                        </td>
						<td>
						<h3> Updated Till <?php echo $rowd["Date"]; ?></h3>
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
      <script language="javascript" type="text/javascript">
         setFilterGrid("table1");
      </script> 
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
	   $state1=$state;
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
			   $py=$fiy-1;
			   $post_at_todate1 = "$py-$tim-$tid";
			   $lm=$fim-'01';
			   $lm='0'.$lm;
			    $post_at_todate2 = "$tiy-$lm-$tid";
				$post_at_todate3 = "$py-$lm-$tid";
				$queryCondition1 .= " AND Date BETWEEN '$py-$fim-$fid' AND '". $post_at_todate1 . "'";
			    $queryCondition2 .= " AND Date BETWEEN '$fiy-$lm-$fid' AND '". $post_at_todate2 . "'";
				$queryCondition3 .= " AND Date BETWEEN '$py-$lm-$fid' AND '". $post_at_todate3 . "'";
           }}
   		//echo 
       
      {   $seg=array();
	  
	  
	        if($state1=='ALL'){$sqld = "SELECT DISTINCT Executive FROM sales UNION SELECT DISTINCT Executive  FROM Salesmaster ORDER by Executive ASC";}else{
		   if($district=='ALL'){$sqld = "SELECT DISTINCT District from Salesmaster where State='$state' ";}else{
           $sqld = "SELECT DISTINCT District from sales where District='$district' ".$queryCondition;}}
           //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
            //echo $sqld;
           $resultd = mysqli_query($conn,$sqld);  
           ?>
<div style="width:60%; float :left ; margin-left: 15%">
   <table  id="demo">
      <tr>
         <h1>From <?php echo $post_at; ?> TO <?php echo $post_at_todate ?></h1>
      </tr>
      <tr>
		 <?php
		 if($state1!='ALL'){ ?>
         <th>District</th>
         <?php }?>
         <th>Executive</th>
		 <th>Category</th>
		 <!--<th>Zone</th> -->
		  <th>Amount-May-17</th>
		  <th>Amount-May-18</th>
		  <th>Progress(%)</th>
      </tr>
	  
         <?php 
			$amountp='';
			$amountc='';
            while($rowd = mysqli_fetch_array($resultd)) {
                  if($state1=='ALL'){$zone=$rowd["Zone"]; $state=$rowd["Executive"];}
                  $di=$rowd["District"];
                  ?>
        
         <?php 
            $sqldz = "SELECT Zone from Zonesmst WHERE District='$di' ";
               // echo $sqld;
               $resultdz = mysqli_query($conn,$sqldz);     
               $rowdz= mysqli_fetch_array($resultdz);
			   if($state1=='ALL'){ $sqld1 = "SELECT sum(Amount),Executive,Zone from sales WHERE Executive='$state'  ".$queryCondition; }else{
                $sqld1 = "SELECT sum(Amount),Executive,State from sales WHERE District='$di'  ".$queryCondition;
			   }
                //echo $sqld1;
               $resultd1 = mysqli_query($conn,$sqld1);     
               $rowd1= mysqli_fetch_array($resultd1);	
			    if($state1=='ALL'){  $sqldd = "SELECT sum(Amount),Executive,State From Salesmaster WHERE Executive='$state'  ".$queryCondition1;}else{
			   $sqldd = "SELECT sum(Amount),Executive,State from Salesmaster WHERE District='$di' AND DATE_FORMAT(date, '%Y-%m') ='$py-$fim' ";
				}//echo $sqldd;
               $resultdd = mysqli_query($conn,$sqldd);     
               $rowdd= mysqli_fetch_array($resultdd);
			   
			   ?>
		<!-- <td><?php echo $state; ?></td> -->
		 <td><?php echo $state; ?></td>
		 <td>Executive</td>
		 <?php if($state1!='ALL'){ ?>
         <td><?php echo $di; ?></td>
		 <?php } ?>
         <td><?php echo $rowdd['sum(Amount)']; $amountp=$amountp+$rowdd['sum(Amount)'];?></td>
		 <td><?php echo $rowd1['sum(Amount)']; $amountc=$amountc+$rowd1['sum(Amount)']; ?></td>
		 <?php if($rowdd['sum(Amount)']==''){?><td> 0 </td><?php }else{ ?>
		 <td> <?php $p=((($rowd1['sum(Amount)']/$rowdd['sum(Amount)'])-1));  $q=sprintf('%0.2f', $p);$m=$q*100; echo $padded = sprintf('%0.0f', $m);?></td><?php }?>
      </tr>
	  
      <?php
         }?> 
		 <tr>		  
			<td>Total</td>
			<?php if($state1!='ALL'){ ?>
			<td></td>
			<td></td>
			<?php  } ?>
			<td></td>
			<td><?php echo $amountp; ?></td>
			<td><?php echo $amountc; ?></td>
			<td><?php  $p1=((($amountc/$amountp)-1)*100); echo $padded1 = sprintf('%0.0f', $p1); ?> </td>
	  </tr>
   
<?php 
$sqld = "SELECT DISTINCT ASM FROM sales UNION SELECT DISTINCT ASM  FROM Salesmaster ORDER by ASM ASC";
 $resultd = mysqli_query($conn,$sqld);  
           ?>

	  
         <?php 
			$amountp='';
			$amountc='';
            while($rowd = mysqli_fetch_array($resultd)) {
                  if($state1=='ALL'){$zone=$rowd["Zone"]; $state=$rowd["ASM"];}
                  $di=$rowd["District"];
                  ?>
        
         <?php 
            $sqldz = "SELECT Zone from Zonesmst WHERE District='$di' ";
               // echo $sqld;
               $resultdz = mysqli_query($conn,$sqldz);     
               $rowdz= mysqli_fetch_array($resultdz);
			   if($state1=='ALL'){ $sqld1 = "SELECT sum(Amount),Executive,Zone from sales WHERE ASM='$state'  ".$queryCondition; }else{
                $sqld1 = "SELECT sum(Amount),Executive,State from sales WHERE District='$di'  ".$queryCondition;
			   }
                //echo $sqld1;
               $resultd1 = mysqli_query($conn,$sqld1);     
               $rowd1= mysqli_fetch_array($resultd1);	
			    if($state1=='ALL'){  $sqldd = "SELECT sum(Amount),Executive,State From Salesmaster WHERE ASM='$state'  ".$queryCondition1;}else{
			   $sqldd = "SELECT sum(Amount),Executive,State from Salesmaster WHERE District='$di' AND DATE_FORMAT(date, '%Y-%m') ='$py-$fim' ";
				}//echo $sqldd;
               $resultdd = mysqli_query($conn,$sqldd);     
               $rowdd= mysqli_fetch_array($resultdd);
			   
			   ?>
		<!-- <td><?php echo $state; ?></td> -->
		 <td><?php echo $state; ?></td>
		 <td>ASM</td>
		 <?php if($state1!='ALL'){ ?>
         <td><?php echo $di; ?></td>
		 <?php } ?>
         <td><?php echo $rowdd['sum(Amount)']; $amountp=$amountp+$rowdd['sum(Amount)'];?></td>
		 <td><?php echo $rowd1['sum(Amount)']; $amountc=$amountc+$rowd1['sum(Amount)']; ?></td>
		 <?php if($rowdd['sum(Amount)']==''){?><td> 0 </td><?php }else{ ?>
		 <td> <?php $p=((($rowd1['sum(Amount)']/$rowdd['sum(Amount)'])-1));  $q=sprintf('%0.2f', $p);$m=$q*100; echo $padded = sprintf('%0.0f', $m);?></td><?php }?>
      </tr>
	  
      <?php
         }?> 
		 <tr>		  
			<td>Total</td>
			<?php if($state1!='ALL'){ ?>
			<td></td>
			<td></td>
			<?php  } ?>
			<td></td>
			<td><?php echo $amountp; ?></td>
			<td><?php echo $amountc; ?></td>
			<td><?php  $p1=((($amountc/$amountp)-1)*100); echo $padded1 = sprintf('%0.0f', $p1); ?> </td>
	  </tr>
	  <?php 
$sqld = "SELECT DISTINCT SM FROM sales UNION SELECT DISTINCT SM  FROM Salesmaster ORDER by SM ASC";
 $resultd = mysqli_query($conn,$sqld);  
           
			$amountp='';
			$amountc='';
            while($rowd = mysqli_fetch_array($resultd)) {
                  if($state1=='ALL'){$zone=$rowd["Zone"]; $state=$rowd["SM"];}
                  $di=$rowd["District"];
                  ?>
        
         <?php 
            $sqldz = "SELECT Zone from Zonesmst WHERE District='$di' ";
               // echo $sqld;
               $resultdz = mysqli_query($conn,$sqldz);     
               $rowdz= mysqli_fetch_array($resultdz);
			   if($state1=='ALL'){ $sqld1 = "SELECT sum(Amount),Executive,Zone from sales WHERE SM='$state'  ".$queryCondition; }else{
                $sqld1 = "SELECT sum(Amount),Executive,State from sales WHERE District='$di'  ".$queryCondition;
			   }
                //echo $sqld1;
               $resultd1 = mysqli_query($conn,$sqld1);     
               $rowd1= mysqli_fetch_array($resultd1);	
			    if($state1=='ALL'){  $sqldd = "SELECT sum(Amount),Executive,State From Salesmaster WHERE SM='$state'  ".$queryCondition1;}else{
			   $sqldd = "SELECT sum(Amount),Executive,State from Salesmaster WHERE District='$di' AND DATE_FORMAT(date, '%Y-%m') ='$py-$fim' ";
				}//echo $sqldd;
               $resultdd = mysqli_query($conn,$sqldd);     
               $rowdd= mysqli_fetch_array($resultdd);
			   
			   ?>
		<!-- <td><?php echo $state; ?></td> -->
		 <td><?php echo $state; ?></td>
		 <td>SM</td>
		 <?php if($state1!='ALL'){ ?>
         <td><?php echo $di; ?></td>
		 <?php } ?>
         <td><?php echo $rowdd['sum(Amount)']; $amountp=$amountp+$rowdd['sum(Amount)'];?></td>
		 <td><?php echo $rowd1['sum(Amount)']; $amountc=$amountc+$rowd1['sum(Amount)']; ?></td>
		 <?php if($rowdd['sum(Amount)']==''){?><td> 0 </td><?php }else{ ?>
		 <td> <?php $p=((($rowd1['sum(Amount)']/$rowdd['sum(Amount)'])-1));  $q=sprintf('%0.2f', $p);$m=$q*100; echo $padded = sprintf('%0.0f', $m);?></td><?php }?>
      </tr>
	  
			<?php
				}?> 
		 <tr>		  
			<td>Total</td>
			<?php if($state1!='ALL'){ ?>
			<td></td>
			<td></td>
			<?php  } ?>
			<td></td>
			<td><?php echo $amountp; ?></td>
			<td><?php echo $amountc; ?></td>
			<td><?php  $p1=((($amountc/$amountp)-1)*100); echo $padded1 = sprintf('%0.0f', $p1); ?> </td>
	  </tr>
			<?php 
			$sqld = "SELECT DISTINCT ZM FROM sales UNION SELECT DISTINCT ZM  FROM Salesmaster ORDER by ZM ASC";
			$resultd = mysqli_query($conn,$sqld);  
           ?>

	  
         <?php 
			$amountp='';
			$amountc='';
            while($rowd = mysqli_fetch_array($resultd)) {
                  if($state1=='ALL'){$zone=$rowd["Zone"]; $state=$rowd["ZM"];}
                  $di=$rowd["District"];
                  ?>
        
         <?php 
            $sqldz = "SELECT Zone from Zonesmst WHERE District='$di' ";
               // echo $sqld;
               $resultdz = mysqli_query($conn,$sqldz);     
               $rowdz= mysqli_fetch_array($resultdz);
			   if($state1=='ALL'){ $sqld1 = "SELECT sum(Amount),Executive,Zone from sales WHERE ZM='$state'  ".$queryCondition; }else{
                $sqld1 = "SELECT sum(Amount),Executive,State from sales WHERE District='$di'  ".$queryCondition;
			   }
                //echo $sqld1;
               $resultd1 = mysqli_query($conn,$sqld1);     
               $rowd1= mysqli_fetch_array($resultd1);	
			    if($state1=='ALL'){  $sqldd = "SELECT sum(Amount),Executive,State From Salesmaster WHERE ZM='$state'  ".$queryCondition1;}else{
			   $sqldd = "SELECT sum(Amount),Executive,State from Salesmaster WHERE District='$di' AND DATE_FORMAT(date, '%Y-%m') ='$py-$fim' ";
				}//echo $sqldd;
               $resultdd = mysqli_query($conn,$sqldd);     
               $rowdd= mysqli_fetch_array($resultdd);
			   
			   ?>
		<!-- <td><?php echo $state; ?></td> -->
		 <td><?php echo $state; ?></td>
		 <td>ZM</td>
		 <?php if($state1!='ALL'){ ?>
         <td><?php echo $di; ?></td>
		 <?php } ?>
         <td><?php echo $rowdd['sum(Amount)']; $amountp=$amountp+$rowdd['sum(Amount)'];?></td>
		 <td><?php echo $rowd1['sum(Amount)']; $amountc=$amountc+$rowd1['sum(Amount)']; ?></td>
		 <?php if($rowdd['sum(Amount)']==''){?><td> 0 </td><?php }else{ ?>
		 <td> <?php $p=((($rowd1['sum(Amount)']/$rowdd['sum(Amount)'])-1));  $q=sprintf('%0.2f', $p);$m=$q*100; echo $padded = sprintf('%0.0f', $m);?></td><?php }?>
      </tr>
	  
      <?php
         }?> 
		 <tr>		  
			<td>Total</td>
			<?php if($state1!='ALL'){ ?>
			<td></td>
			<td></td>
			<?php  } ?>
			<td></td>
			<td><?php echo $amountp; ?></td>
			<td><?php echo $amountc; ?></td>
			<td><?php  $p1=((($amountc/$amountp)-1)*100); echo $padded1 = sprintf('%0.0f', $p1); ?> </td>
	  </tr>
   </table>
   <button onclick="exportTableToCSV('district executive.csv')">Export HTML Table To CSV File</button>
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

<?php 
}}