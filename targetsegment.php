<?php ini_set('max_execution_time', 0);?>
<html>
   <body bgcolor="">
      <?php 
         include 'header2.php';
         include '/config/db.php';
         
         $sqld = "SELECT distinct state,segment FROM `targetmst` order by state,Segment asc";
               // echo $sqld;
          $result = mysqli_query($conn,$sqld);     
          //$rowd= mysqli_fetch_array($resultd);
         
         ?>
      <div class="main-panel">
      <div class="content-wrapper">
         <div class ="row">
            <div class="col-6" >
               <h1 style="text-align:center;"> Target Segment wise</h1>
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
         <script src="js/tableToExcel.js"></script>
         <div class="col-md-12 ">
            <div class="card">
               <div class="table-responsive">
                  <table id='testTable' class="table table-border">
                     <thead>
                        <tr >
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">State</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Segment</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Rate</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q1 Sales</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q2 Sales</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q3 Sales</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q4 Sales</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Total QTY</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Total Value</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q1 Target</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q2 Target</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q3 Target</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q4 Target</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Total QTY</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Total Value</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"> % Progress</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           while($row = mysqli_fetch_array($result)) {
                             $segment=$row["segment"];
                             $state=$row["state"];
                              $sql = "SELECT sum(QS1),sum(QS2),sum(QS3),sum(QS4),sum(QT1),sum(QT2),sum(QT3),sum(QT4) FROM `targetmst` where segment='$segment' and state='$state'";
                           // echo $sqld;
                           $resultt = mysqli_query($conn,$sql);     
                            ?> 
                        <tr>
                           <?php
                              while($rowt = mysqli_fetch_array($resultt)) {  
                                $sqlp = "SELECT sum(QTY),sum(Amount),Amount FROM `Salesmaster` where seqment='$segment' and Amount > '0'";
                              $resultp = mysqli_query($conn,$sqlp);  
                              $rowp = mysqli_fetch_array($resultp); 
                              $amount=$rowp['sum(Amount)'];   
                              $qty=$rowp['sum(QTY)'];           
                               ?>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $state;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $segment;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php if($qty <='0'){echo '0'; $rate = '0';}else{echo $rate=round($amount/$qty); } ?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qs1=$rowt['sum(QS1)'];?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qs2=$rowt['sum(QS2)'];?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qs3= $rowt['sum(QS3)'];?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qs4=$rowt['sum(QS4)'];?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#6b96db"><?php echo $s1=$qs1+$qs2+$qs3+$qs4; $s=$s+$qs1+$qs2+$qs3+$qs4;?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#6b96db"><?php echo $sa=$rate*$s1; $sa1=$sa1+$sa;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qt1=$rowt['sum(QT1)'];?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qt2=$rowt['sum(QT2)'];?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qt3=$rowt['sum(QT3)'];?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qt4=$rowt['sum(QT4)'];?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#6b96db"><?php echo $t1=$qt1+$qt2+$qt3+$qt4; $t=$t+$qt1+$qt2+$qt3+$qt4;?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#6b96db"><?php echo $ta=$rate*$t1; $ta1=$ta1+$ta; ?></td>
                           <td style=" border: 0.5pt solid #000000;" ><?php if ($s1 == '0'){ echo '0';}else{echo round((($ta/$sa))*100);} ?></td>
                           <?php }?>
                        </tr>
                        <?php }?>
                        <tr>
                          <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Total</th>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"> </td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"><?php echo $s;?></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"><?php echo $sa1;?></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"><?php echo $t;?></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"><?php echo $ta1;?></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"><?php echo round((($ta1/$sa1))*100); ?></td>
                        </tr>
                     <tbody>
                  </table>
                  <input type="button" onclick="tableToExcel('testTable', 'Target')" value="Export to Excel">
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
