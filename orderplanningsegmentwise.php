<?php ini_set('max_execution_time', 0);?>
<html>
   <body bgcolor="">
      <?php 
         include 'header2.php';
         include '/config/db.php';
         
         $sqld = "SELECT distinct segment FROM `targetmst` order by segment asc";
               // echo $sqld;
          $result = mysqli_query($conn,$sqld);     
          //$rowd= mysqli_fetch_array($resultd);
         
         ?>
      <div class="main-panel">
      <div class="content-wrapper">
         <div class ="row">
            <div class="col-6" >
               <h1 style="text-align:center;"> Order Planning Segment wise</h1>
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
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Segment</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Rate</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q4 Order-17-18</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q4 Value</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q1 Order-18-19</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q1 Value</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q2 Order-18-19</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q2 Value</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q3 Order-18-19</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Q3 Value</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Total QTY</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Total Value</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           while($row = mysqli_fetch_array($result)) {
                             $segment=$row["segment"];
                             
                              $sql = "SELECT sum(QS1),sum(QS2),sum(QS3),sum(QS4),sum(QT1),sum(QT2),sum(QT3),sum(QT4) FROM `targetmst` where segment='$segment' ";
                           // echo $sqld;
                           $resultt = mysqli_query($conn,$sql);     
                            ?> 
                        <tr>
                           <?php
                              while($rowt = mysqli_fetch_array($resultt)) {  
                                $sqlp = "SELECT sum(Quantity),sum(Value) FROM `purches_mst` where segment='$segment' ";
                              $resultp = mysqli_query($conn,$sqlp);  
                              $rowp = mysqli_fetch_array($resultp); 
                              $amount=$rowp['sum(Value)'];   
                              $qty=$rowp['sum(Quantity)'];           
                               ?>
                          
                           <td style=" border: 0.5pt solid #000000;"><?php echo $segment;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php if($qty <='0'){echo '0'; $rate = '0';}else{echo $rate=round($amount/$qty); } ?></td>
                           
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qt1=$rowt['sum(QT1)'];?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#6b96db"><?php echo $qt1*$rate; $v1=$v1+$qt1*$rate;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qt2=$rowt['sum(QT2)'];?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#6b96db"><?php echo $qt2*$rate; $v2=$v2+$qt2*$rate;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qt3=$rowt['sum(QT3)'];?></td>
                           <td style=" border: 0.5pt solid #000000; " bgcolor="#6b96db"><?php echo $qt3*$rate; $v3=$v3+$qt3*$rate;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $qt4=$rowt['sum(QT4)'];?></td>
                           <td style=" border: 0.5pt solid #000000; " bgcolor="#6b96db"><?php echo $qt4*$rate; $v4=$v4+$qt4*$rate;?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#6b96db"><?php echo $t1=$qt1+$qt2+$qt3+$qt4; $t=$t+$qt1+$qt2+$qt3+$qt4;?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#6b96db"><?php echo $ta=$rate*$t1; $ta1=$ta1+$ta; ?></td>
                           
                           <?php }?>
                        </tr>
                        <?php }?>
                        <tr>
                          <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Total</th>
                         
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"> <?php echo $v1;?></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"> <?php echo $v2;?></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"> <?php echo $v3;?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"> <?php echo $v4;?></td>
                           <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"><?php echo $t;?></td>
                          <td style=" border: 0.5pt solid #000000;" bgcolor="#ff9999"><?php echo $ta1;?></td>
                          
                        </tr>
                     <tbody>
                  </table>
                  <input type="button" onclick="tableToExcel('testTable', 'Order Planning')" value="Export to Excel">
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
