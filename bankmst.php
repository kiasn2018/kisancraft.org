<?php ini_set('max_execution_time', 0);?>
<html>
   <body bgcolor="">
      <?php 
         include 'header2.php';
         include '/config/db.php';
         
          
          //$rowd= mysqli_fetch_array($resultd);
         
         ?>
      <div class="main-panel">
      <div class="content-wrapper">
         <div class ="row">
            <div class="col-6" >
               <h1 style="text-align:center;">Order Planning Segment wise</h1>
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
          <input type="button" onclick="tableToExcel('testTable', 'Actuval Cash flow')" value="Export to Excel">
            <div class="card">
               
               <div class="table-responsive">
                  <table id='testTable' class="table table-border">
                     <thead>
                        <tr >
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Date</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Particulars</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Banklink_1</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Narration</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Vorture</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Debit</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Credit</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Banklink_2</th>
                           <th style=" border: 0.5pt solid #000000;" bgcolor="#ff9999">Banklink_2</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $ID=array();
                           $sql = "SELECT distinct ID FROM `Banktransactionmst` order by Particulars asc ";
                           // echo $sqld;
                           $resultt = mysqli_query($conn,$sql);   
                           while($rowt = mysqli_fetch_array($resultt)) {  
                                 $ID[]=$rowt['ID'];
                             }
                             $i='0';
                             while($i<count($ID)){
                                    $sql = "SELECT * FROM `Banktransactionmst` where ID='$ID[$i]'  ";
                           // echo $sqld;
                           $resultt = mysqli_query($conn,$sql);   
                           while($rowt = mysqli_fetch_array($resultt)) {
                           if($rowt['Date']!='0000-00-00'){
                           $date=$rowt['Date'];
                           $part=$rowt['Particulars'];
                           $debit=$rowt['Debit'];
                            $credit=$rowt['Credit'];
                            $vor=$rowt['Vorture'];
                            //Logic for Contra column
                            $sql2 = "SELECT bankname FROM `Bankmaster` where bankname='$part'  ";
                             $resultt2 = mysqli_query($conn,$sql2);   
                             $rowt2 = mysqli_fetch_array($resultt2);
                             if($rowt2['bankname']!=''){
                               $contra="Contra";
                           
                             }else{
                           
                             $sql2 = "SELECT B_name FROM `branch_mst` where B_name='$part'  ";
                             $resultt2 = mysqli_query($conn,$sql2);   
                             $rowt2 = mysqli_fetch_array($resultt2);
                             if($rowt2['B_name']!=''){
                               $contra="Branch";
                           
                             }elseif($part=='Opening Balance'){
                               $contra='Opening Balance';
                             }else{
                               $contra='';
                             }}
                           
                            $c=$i+1;
                           $sql1 = "SELECT * FROM `Banktransactionmst` where ID='$ID[$c]'  ";
                           // echo $sqld;
                           $resultt1 = mysqli_query($conn,$sql1);   
                           $rowt1 = mysqli_fetch_array($resultt1);
                           if($rowt1['Date']=='0000-00-00'){
                           $nar=$rowt1['Particulars'];
                           }else{ $nar='';}
                           
                           //logic for refund
                           if($credit > '0' && $contra==''){
                           $refu='';
                            $sql3 = "SELECT sub_group FROM `ledger` where ledger='$part'  ";
                             $resultt3 = mysqli_query($conn,$sql3);   
                             $rowt3 = mysqli_fetch_array($resultt3);
                             if($rowt3['sub_group']=='Sundry Drs'){
                              $refu="Refund";

                             }else{
                              $refu=$rowt3['sub_group'];
                             }
                           }
                           //echo $date."-".$part."-".$nar."-".$vor."-".$debit."-".$credit;
                           ?>
                        <tr>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $date;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $part;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $contra;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $nar;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $vor;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $debit;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php echo $credit;?></td>
                           <td style=" border: 0.5pt solid #000000;"><?php if($contra=='' && $debit > '0'){echo "Bank Receipt";}else{echo $refu;}?></td>
                        </tr>
                        <?php
                           }
                           }
                           
                           $i++;
                           }
                            ?> 
                     <tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>