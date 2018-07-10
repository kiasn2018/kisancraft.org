<?php ini_set('max_execution_time', 0);?>
<html>
   <head>
      <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
      <script src="/kisankraft.org/src/js/sorttable.js"></script>
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
     
      <script src="js/tableToExcel.js"></script>
   <body bgcolor="">
      <?php 
         include 'header2.php';
         include '/config/db.php';
         
         $sqld = "SELECT Date FROM `sales` ORDER BY `sales`.`Date` DESC ";
               // echo $sqld;
          $resultd = mysqli_query($conn,$sqld);     
          $rowd= mysqli_fetch_array($resultd);
         
         ?>
      
      <div class="main-panel">
      <div class="content-wrapper">
         <div class ="row">
            <div class="col-6" >
               <h1 style="text-align:center;">Sales Report State,Month,sku wise</h1>
               <div class="col-12 stretch-card">
                  <div class="card">
                     <div class="card-body">
                        <h3> Updated Till <?php
                           echo $rowd["Date"];
                           ?></h3>
                        <form class="forms-sample" action="" method="post">
                           <div class="form-group row">
                              <label for="exampleInputEmail2" class="col-sm-3 col-form-label">State</label>
                              <div class="col-sm-9">
                                 <select onChange="getdistrict(this.value);"  name="state" id="state" class="form-control" >
                                    <option value="">Select</option>
                                    <option value="ALL">ALL</option>
                                    <?php
                                       $sqlst    = "SELECT DISTINCT Zone FROM sales UNION SELECT DISTINCT Zone  FROM Salesmaster ORDER by Zone ASC ";
                                       $resultst = mysqli_query($conn, $sqlst);
                                       
                                       while ($rowst = mysqli_fetch_array($resultst)) {
                                       ?>
                                    <option value="<?php
                                       echo $rowst['Zone'];
                                       ?>"><?php
                                       echo $rowst['Zone'];
                                       ?></option>
                                    <?php
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="exampleInputPassword2" class="col-sm-3 col-form-label">District</label>
                              <div class="col-sm-9">
                                 <select onChange="getdealer(this.value);" name="district" id="district-list" class="form-control">
                                    <option value="">Select</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="exampleInputPassword2" class="col-sm-3 col-form-label">From </label>
                              <div class="col-sm-9">
                                 <input type="text" placeholder="From Date" style="margin-left:2%;" id="post_at" name="search[post_at]"  value="<?php
                                    echo $post_at;
                                    ?>"   />
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="exampleInputPassword2" class="col-sm-3 col-form-label">To Date</label>
                              <div class="col-sm-9">
                                 <input type="text" placeholder="To Date" id="post_at_to_date" name="search[post_at_to_date]" style="margin-left:10px"  value="<?php
                                    echo $post_at_to_date;
                                    ?>"  />
                              </div>
                           </div>
                           <button type="submit" name="go" value="Submit" class="btn btn-success mr-2">Submit</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
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
         url: "getdistrict1.php",
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
     <div class="col-md-12 ">
            <div class="card">
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
         </div>
         </div>
      </div>
   </body>
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
          // $post_at_todate = date('Y-m-d');
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
   $amt=array();
     $amto=array();
   
         if($state1=='ALL'){$sqld = "SELECT DISTINCT District,Zone,Executive,ASM,SM,ZM FROM sales UNION SELECT DISTINCT District,Zone,Executive,ASM,SM,ZM  FROM Salesmaster ORDER by Zone,Executive,ASM,SM,ZM,District ASC";}else{
     if($district=='ALL'){$sqld = "SELECT DISTINCT District,Zone,Executive,ASM,SM,ZM FROM sales where zone='$state' UNION SELECT DISTINCT District,Zone,Executive,ASM,SM,ZM  FROM Salesmaster where zone='$state' ORDER by Zone,Executive,ASM,SM,ZM,District ASC";}else{
           $sqld = "SELECT DISTINCT District from sales where District='$district' ".$queryCondition;}}
           //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
            //echo $sqld;
           $resultd = mysqli_query($conn,$sqld);  
     $resultd1 = mysqli_query($conn,$sqld);  
     $resultd2 = mysqli_query($conn,$sqld); 
     $resultd3 = mysqli_query($conn,$sqld); 
     $resultd4 = mysqli_query($conn,$sqld); 	
     $resultd5 = mysqli_query($conn,$sqld); 	
     $resultd6 = mysqli_query($conn,$sqld); 
     $resultd7 = mysqli_query($conn,$sqld); 		   
      $sqlc = "SELECT count(DISTINCT Executive),count(DISTINCT ASM) FROM sales where zone='$state' UNION SELECT count(DISTINCT Executive),count(DISTINCT ASM) FROM Salesmaster where zone='$state' " ; 
	  $resultc = mysqli_query($conn,$sqlc); 
      $rowc = mysqli_fetch_array($resultc);
	 $counte=$rowc["count(DISTINCT Executive)"];
	 $counts=$rowc["count(DISTINCT Executive)"];
	 
?>	  
<div class="table-responsive">
   <table  id="testTable" class="table table-hover">
      <tr>
         <h1>From <?php echo $post_at; ?> TO <?php echo $post_at_todate ?></h1>
      </tr>
      <tr>
         <th style=" border: 0.5pt solid #000000; ">State</th>
         <?php while($row = mysqli_fetch_array($resultd)) {
            $exe=$row["Executive"];
			$SM=$row["ASM"];
            if($exel != $exe || $SM != $SML){
                 ?>
         <td style=" border: 0.5pt solid #000000; "><?php echo $row["Zone"]; ?></td>
         <td style=" border: 0.5pt solid #000000; "></td></td>
         <?php }else{?>
         <td style=" border: 0.5pt solid #000000; "></td>
         <td style=" border: 0.5pt solid #000000; "></td>
         <?php } $exel=$row["Executive"]; $SML=$row["ASM"];}?>
      </tr>
      <tr>
         <th style=" border: 0.5pt solid #000000; ">Executive</th>
         <?php while($row = mysqli_fetch_array($resultd1)) {
            $exe1=$row["Executive"];
            $SM1=$row["ASM"];
            if($exel1 != $exe1 || $SM1 != $SML1){
                 ?>
         <td style=" border: 0.5pt solid #000000; "><?php echo $row["Executive"]; ?></td>
         <td style=" border: 0.5pt solid #000000; "></td>
         <?php }else{?>
         <td style=" border: 0.5pt solid #000000; "></td>
         <td style=" border: 0.5pt solid #000000; "></td>
         <?php } $exel1=$row["Executive"]; $SML1=$row["ASM"];}?>
      </tr>
      <th style=" border: 0.5pt solid #000000; ">ASM</th>
      <?php while($row = mysqli_fetch_array($resultd2)) {
         $exe2=$row["Executive"];
        $SM2=$row["ASM"];
            if($exel2 != $exe2 || $SM2 != $SML2){
              ?>
      <td style=" border: 0.5pt solid #000000; "><?php echo $row["ASM"]; ?></td>
      <td style=" border: 0.5pt solid #000000; "></td>
      <?php }else{?>
      <td style=" border: 0.5pt solid #000000; "></td>
      <td style=" border: 0.5pt solid #000000; "></td>
      <?php } $exel2=$row["Executive"];$SML2=$row["ASM"];}?>
      </tr>
      <tr>
         <th style=" border: 0.5pt solid #000000; ">SM</th>
         <?php while($row = mysqli_fetch_array($resultd3)) {
            $exe3=$row["Executive"];
           $SM3=$row["ASM"];
            if($exel3 != $exe3 || $SM3 != $SML3){
                 ?>
         <td style=" border: 0.5pt solid #000000; "><?php echo $row["SM"]; ?></td>
         <td style=" border: 0.5pt solid #000000; "></td>
         <?php }else{?>
         <td style=" border: 0.5pt solid #000000; "></td>
         <td style=" border: 0.5pt solid #000000; "></td>
         <?php } $exel3=$row["Executive"];$SML3=$row["ASM"];}?>
      </tr>
      <tr>
         <th style=" border: 0.5pt solid #000000; ">ZM</th>
         <?php while($row = mysqli_fetch_array($resultd4)) {
            $exe4=$row["Executive"];
            $SM4=$row["ASM"];
            if($exel4 != $exe4 || $SM4 != $SML4){
                 ?>
         <td style=" border: 0.5pt solid #000000; "><?php echo $row["ZM"]; ?></td>
         <td style=" border: 0.5pt solid #000000; "></td>
         <?php }else{?>
         <td style=" border: 0.5pt solid #000000; "></td>
         <td style=" border: 0.5pt solid #000000; "></td>
	 <?php } $exel4=$row["Executive"];$SML4=$row["ASM"];}?>
      </tr>
      <tr>
         <th style=" border: 0.5pt solid #000000; ">District</th>
         <?php while($row = mysqli_fetch_array($resultd5)) {
            $exe=$row["Executive"];
            $District=$row["District"];
            ?>
         <td style=" border: 0.5pt solid #000000; " ><?php echo $row["District"]; ?></td>
         <td style=" border: 0.5pt solid #000000; "></td>
         <?php  } ?>
         <td style=" border: 0.5pt solid #000000; ">Total</td>
      </tr>
      <tr>
         <th style=" border: 0.5pt solid #000000; ">FY</th>
         <?php while($row = mysqli_fetch_array($resultd6)) {
            ?>
         <td style=" border: 0.5pt solid #000000; ">FY2017-18</td>
         <td bgcolor="#6b96db" style=" border: 0.5pt solid #000000; ">FY2018-19</td>
         <?php  } ?>
         <td style=" border: 0.5pt solid #000000; ">FY2017-18</td>
         <td  bgcolor="#6b96db" style=" border: 0.5pt solid #000000; ">FY2018-19</td>
      </tr>
      <?php 
         $ss=array();
         $di=array();
         $totalam='';
            $totalamo='';
         while($row = mysqli_fetch_array($resultd7)){
         $ss[]=$row["District"]; }
         $sqlss = "SELECT DISTINCT SKU FROM sales where Zone='$state' UNION SELECT DISTINCT SKU FROM Salesmaster where Zone='$state' ORDER by SKU ASC"; 
         $resultss = mysqli_query($conn,$sqlss);
          while($rowss = mysqli_fetch_array($resultss)){
          $di[]=$rowss["SKU"]; }
          for($j=0;$j<count($di);$j++)
          { $too='';
         $to='';
         {?> 
      <tr>
         <td style=" border: 0.5pt solid #000000; "><?php echo $di[$j]; ?></td>
         <?php
            for($i=0;$i<count($ss);$i++)
            { 
            $sqldo = "SELECT sum(QTY),sum(Amount) from Salesmaster WHERE SKU='$di[$j]' AND District='$ss[$i]' ".$queryCondition1;
                       $resultdo = mysqli_query($conn,$sqldo);     
                       $rowdo= mysqli_fetch_array($resultdo);
                        $sqld1 = "SELECT sum(QTY),sum(Amount) from sales WHERE SKU='$di[$j]' AND District='$ss[$i]' ".$queryCondition;
                        //echo $sqld1;
                       $resultd1 = mysqli_query($conn,$sqld1);     
                       $rowd1= mysqli_fetch_array($resultd1);
            ?>
         <td style=" border: 0.5pt solid #000000; "><?php echo $rowdo["sum(Amount)"];  $amto[$i]=$amto[$i]+$rowdo['sum(Amount)']; $too=$too+$rowdo['sum(Amount)'];?></td>
         <td bgcolor="#6b96db" style=" border: 0.5pt solid #000000; "><?php echo $rowd1["sum(Amount)"];  $amt[$i]=$amt[$i]+$rowd1['sum(Amount)']; $to=$to+$rowd1['sum(Amount)'];?></td>
         <?php }?>
         <td style=" border: 0.5pt solid #000000; "><?php echo $too;$totalamo=$totalamo+$too;?></td>
         <td bgcolor="#6b96db" style=" border: 0.5pt solid #000000; "><?php echo $to; $totalam=$totalam+$to;?></td>
      </tr>
      <?php }}
         ?>
      <tr>
         <td style=" border: 0.5pt solid #000000; ">Total</td>
         <?php for($j=0;$j<(count($ss));$j++){ ?>
         <td style=" border: 0.5pt solid #000000; "><?php echo $amto[$j]; ?></td>
         <td bgcolor="#6b96db" style=" border: 0.5pt solid #000000; "><?php echo $amt[$j]; ?></td>
         <?php }?>
         <td style=" border: 0.5pt solid #000000; "><?php echo $totalamo;?></td>
         <td style=" border: 0.5pt solid #000000;" bgcolor="#6b96db" ><?php echo $totalam;?></td>
      <tr/>
   </table>
    <input type="button" onclick="tableToExcel('testTable', '<?php echo $state; ?>')" value="Export to Excel">
</div>

<?php 
}}