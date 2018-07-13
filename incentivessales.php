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
      <div class="row">
         <div class="span3 hidden-phone"></div>
         <div class="span6" id="form-login">
            <div class="span3 hidden-phone"></div>
         </div>
      </div>
      <div></div>
      <hr>
      <div style="margin-left:1%; width:75%;">
         <?php
            $sql = "SELECT distinct EID from sales";
            //echo $sql;
            $result = mysqli_query($conn,$sql);
            $sql1 = "SELECT distinct AID from sales ";
            //echo $sql;
            $result1 = mysqli_query($conn,$sql1);
            $sql2 = "SELECT distinct SID from sales ";
            //echo $sql;
            $result2 = mysqli_query($conn,$sql2);
            $sql3 = "SELECT distinct ZID from sales ";
            //echo $sql;
            $result3 = mysqli_query($conn,$sql3);
            
            ?>
         <input type="button" onclick="tableToExcel('testTable', 'Incentives sales')" value="Export to Excel">
         <div class="table-responsive">
            <table class="sortable" id="testTable">
               <thead>
                  <tr class="d0">
                     <th width="10%"><span>ID</span></th>
                     <th width="50%"><span> Name</span></th>
                     <th width="50%"><span> Category</span></th>
                     <th width="50%"><span> Branch </span></th>
                     <th width="20%"><span>Sales 17-18</span></th>
                     <th width="20%"><span>Sales 18-19</span></th>
                     <th width="20%"><span>% Progress</span></th>
                     <th width="20%"><span>Eligibility</span></th>
                     <th width="20%"><span>No of Dealers 17-18</span></th>
                     <th width="20%"><span>No of Dealers 18-19</span></th>
                     <th width="20%"><span>% Progress</span></th>
                     <th width="20%"><span>Normal Incentives</span></th>
                     <th width="20%"><span>75% Sales</span></th>
                     <th width="25%"><span> 25% (Dealers)</span></th>
                     <th width="25%"><span> Allocation of sales Incentives</span></th>
                     <th width="25%"><span> Allocation of sales Dealers</span></th>
                     <th width="25%"><span> Final Incentives sales</span></th>
                     <th width="25%"><span> Final Incentives Dealers</span></th>
                     <th width="25%"><span>Total Incentives</span></th>
                     <th width="25%"><span>Trasferred To Jackpot</span></th>
                     <th width="25%"><span>Remark</span></th>
                  </tr>
               </thead>
               <?php
                  while($row = mysqli_fetch_array($result)) {
                    $eid=$row['EID'];
                      $sqli = "SELECT sum(Amount),Executive from sales where EID='$eid' AND Date between '2018-04-01' AND '2018-06-30'";
                      $resulti = mysqli_query($conn,$sqli);
                      $rowi = mysqli_fetch_array($resulti);
                      
                      $sqlip = "SELECT sum(Amount),Executive from Salesmaster where EID='$eid' AND Date between '2017-04-01' AND '2017-06-30'";
                      $resultip = mysqli_query($conn,$sqlip);
                      $rowip = mysqli_fetch_array($resultip);
                  
                  
                      $sqli111 = "SELECT Branch from Employeemst where E_id='$eid' ";
                      $resulti111 = mysqli_query($conn,$sqli111);
                      $rowi111 = mysqli_fetch_array($resulti111);
                      //print_r($sqli111);
                  
                      $sqlid = "select count(*) from
                              (
                                select count(Distinct Dealer), Dealer,sum(Amount)
                                from Sales  where EID='$eid' AND Date between '2018-04-01' AND '2018-06-30'  group by Dealer Having sum(Amount) >='100000'
                                
                              ) d1";
                      $resultid = mysqli_query($conn,$sqlid);
                      $rowid = mysqli_fetch_array($resultid);
                  
                       $sqlidp = "select count(*) from
                              (
                                select count(Distinct Dealer), Dealer,sum(Amount)
                                from Salesmaster  where EID='$eid' AND Date between '2017-04-01' AND '2017-06-30'  group by Dealer Having sum(Amount) >='100000'
                                
                              ) d1";
                      $resultidp = mysqli_query($conn,$sqlidp);
                      $rowidp = mysqli_fetch_array($resultidp);
                  
                    ?>
               <tr class="d1">
                  <td><?php echo $eid; ?></td>
                  <td><?php echo $rowi['Executive']; ?></td>
                  <td><?php echo "Executive"; ?></td>
                  <td><?php echo  $rowi111['Branch'];?></td>
                  <td><?php echo $a=$rowip['sum(Amount)']; ?></td>
                  <td><?php echo $b=$rowi['sum(Amount)']; ?></td>
                  <td><?php echo $e=round((($b/$a)-1)*100); ?></td>
                  <td><?php if($e >= '0'){ echo "Eligible";}else{echo "Not Eligible";} ?></td>
                  <td><?php echo $m = $rowidp['count(*)']; ?></td>
                  <td><?php echo $n = $rowid['count(*)']; ?></td>
                  <td><?php echo $q=round((($n/$m)-1)*100);?></td>
                  <td><?php echo $am=round(($b*0.4)/100);?></td>
                  <td><?php if($e >= '0'){ echo $s=round(($am*75)/100);}else{echo "Not Eligible";$s='0';} ?></td>
                  <td><?php if($q >= '0' && $e >= '0'){ echo $d=round(($am*25)/100);}else{echo "Not Eligible";$d='0';} ?></td>
                  <td><?php
                     if( $e == '0' )
                     { echo '20%';}
                     elseif ($e > '0' && $e <='10')
                      {echo '35%';} 
                     elseif 
                     ($e > '10' && $e <= '20') 
                     { echo '50%';} 
                     elseif ($e > '20' && $e <= '30')
                     {echo '65%';}
                     elseif ($e > '30' && $e <= '40')
                     {echo '80%';}
                     
                     elseif($e > '40' && $e <= '50')
                     { echo '100%';}
                     elseif($e > '50' && $q > '50'){echo "Eligible for Jackpot";}
                      elseif($e > '50' && $q < '50'){echo '100%';}
                     elseif( $e < '0'){echo "Not Eligible";}
                     ?></td>
                  <td><?php
                     if( $q == '0' )
                     { echo '20%';}
                     elseif ($q > '0' && $q <='10')
                     {echo '35%';} 
                     elseif 
                     ($q > '10' && $q <= '20') 
                     { echo '50%';} 
                     elseif ($q > '20' && $q <= '30')
                     {echo '65%';}
                     elseif ($q > '30' && $q <= '40')
                     {echo '80%';}
                     
                     elseif($q > '40' && $q <= '50')
                     { echo '100%';}
                     elseif($q > '50'){echo '100%';}
                     elseif( $q < '0'){echo "Not Eligible";}
                     ?></td>
                  <td><?php 
                     if( $e == '0' )
                     { echo $s1=round(($s*20)/100); }
                     elseif ($e > '0' && $e <='10')
                     { echo $s1=round(($s*35)/100);} 
                     elseif 
                     ($e > '10' && $e <= '20') 
                     { echo $s1=round(($s*50)/100);} 
                     elseif ($e > '20' && $e <= '30')
                     { echo $s1=round(($s*65)/100); }
                     elseif ($e > '30' && $e <= '40')
                     { echo $s1=round(($s*80)/100); }
                     
                     elseif($e > '40' && $e <= '50')
                     { echo $s1=$s; }
                     elseif( $e > '50'){ echo  $s1=$s; }
                     elseif($e< '0'){echo "0"; $s1='0';}
                     ?>
                  <td><?php 
                     if( $q == '0' )
                     { echo $d1=round(($d*20)/100); }
                     elseif ($q > '0' && $q <='10')
                     { echo $d1=round(($d*35)/100);} 
                     elseif 
                     ($q > '10' && $q <= '20') 
                     { echo $d1=round(($d*50)/100);} 
                     elseif ($q > '20' && $q <= '30')
                     { echo $d1=round(($d*65)/100); }
                     elseif ($q > '30' && $q <= '40')
                     { echo $d1=round(($d*80)/100); }
                     
                     elseif($q > '40' && $q <= '50')
                     { echo $d1=$d; }
                     elseif( $q > '50'){ echo  $d1=$d; }
                     elseif($q< '0'){echo "0"; $d1='0';}?></td>
                  <td><?php echo $tot= $s1+$d1; ?></td>
                  <td><?php if($e < '100'){ echo -$tot+$am; }?></td>
               </tr>
               <?php
                  }
                  while($row1 = mysqli_fetch_array($result1)) {
                    $eid=$row1['AID'];
                      $sqli = "SELECT sum(Amount),ASM from sales where AID='$eid' AND Date between '2018-04-01' AND '2018-06-30'";
                      $resulti = mysqli_query($conn,$sqli);
                      $rowi = mysqli_fetch_array($resulti);
                  
                       $sqlip = "SELECT sum(Amount),ASM from Salesmaster where AID='$eid' AND Date between '2017-04-01' AND '2017-06-30'";
                      $resultip = mysqli_query($conn,$sqlip);
                      $rowip = mysqli_fetch_array($resultip);
                  
                  
                  
                      $sqli11 = "SELECT Branch from Employeemst where E_id='$eid' ";
                      $resulti11 = mysqli_query($conn,$sqli11);
                      $rowi11 = mysqli_fetch_array($resulti11);
                  
                  
                       $sqlid = "select count(*) from
                              (
                                select count(Distinct Dealer), Dealer,sum(Amount)
                                from Sales  where AID='$eid' AND Date between '2018-04-01' AND '2018-06-30'  group by Dealer Having sum(Amount) >='100000'
                                
                              ) d1";
                      $resultid = mysqli_query($conn,$sqlid);
                      $rowid = mysqli_fetch_array($resultid);
                  
                       $sqlidp = "select count(*) from
                              (
                                select count(Distinct Dealer), Dealer,sum(Amount)
                                from Salesmaster  where AID='$eid' AND Date between '2017-04-01' AND '2017-06-30'  group by Dealer Having sum(Amount) >='100000'
                                
                              ) d1";
                      $resultidp = mysqli_query($conn,$sqlidp);
                      $rowidp = mysqli_fetch_array($resultidp);
                  
                    ?>
               <tr class="d1">
                  <td><?php echo $eid; ?></td>
                  <td><?php echo $rowi['ASM']; ?></td>
                  <td><?php echo "ASM"; ?></td>
                  <td><?php echo $rowi11[Branch];?></td>
                  <td><?php echo $a=$rowip['sum(Amount)']; ?></td>
                  <td><?php echo $b=$rowi['sum(Amount)']; ?></td>
                  <td><?php echo $e=round((($b/$a)-1)*100); ?></td>
                  <td><?php if($e >= '0'){ echo "Eligible";}else{echo "Not Eligible";} ?></td>
                  <td><?php echo $m = $rowidp['count(*)']; ?></td>
                  <td><?php echo $n = $rowid['count(*)']; ?></td>
                  <td><?php echo $q=round((($n/$m)-1)*100);?></td>
                  <td><?php echo $am=round(($b*0.125)/100);?></td>
                  <td><?php if($e >= '0'){ echo $s=round(($am*75)/100);}else{echo "Not Eligible";$s='0';} ?></td>
                  <td><?php if($q >= '0' && $e >= '0'){ echo $d=round(($am*25)/100);}else{echo "Not Eligible";$d='0';} ?></td>
                  <td><?php
                     if( $e == '0' )
                     { echo '20%';}
                     elseif ($e > '0' && $e <='10')
                      {echo '35%';} 
                     elseif 
                     ($e > '10' && $e <= '20') 
                     { echo '50%';} 
                     elseif ($e > '20' && $e <= '30')
                     {echo '65%';}
                     elseif ($e > '30' && $e <= '40')
                     {echo '80%';}
                     
                     elseif($e > '40' && $e <= '50')
                     { echo '100%';}
                     elseif($e > '50' && $q > '50'){echo "Eligible for Jackpot";}
                      elseif($e > '50' && $q < '50'){echo '100%';}
                     elseif( $e < '0'){echo "Not Eligible";}
                     ?></td>
                  <td><?php
                     if( $q == '0' )
                     { echo '20%';}
                     elseif ($q > '0' && $q <='10')
                     {echo '35%';} 
                     elseif 
                     ($q > '10' && $q <= '20') 
                     { echo '50%';} 
                     elseif ($q > '20' && $q <= '30')
                     {echo '65%';}
                     elseif ($q > '30' && $q <= '40')
                     {echo '80%';}
                     
                     elseif($q > '40' && $q <= '50')
                     { echo '100%';}
                     elseif($q > '50'){echo '100%';}
                     elseif( $q < '0'){echo "Not Eligible";}
                     ?></td>
                  <td><?php 
                     if( $e == '0' )
                     { echo $s1=round(($s*20)/100); }
                     elseif ($e > '0' && $e <='10')
                     { echo $s1=round(($s*35)/100);} 
                     elseif 
                     ($e > '10' && $e <= '20') 
                     { echo $s1=round(($s*50)/100);} 
                     elseif ($e > '20' && $e <= '30')
                     { echo $s1=round(($s*65)/100); }
                     elseif ($e > '30' && $e <= '40')
                     { echo $s1=round(($s*80)/100); }
                     
                     elseif($e > '40' && $e <= '50')
                     { echo $s1=$s; }
                     elseif( $e > '50'){ echo  $s1=$s; }
                     elseif($e< '0'){echo "0"; $s1='0';}
                     ?>
                  <td><?php 
                     if( $q == '0' )
                     { echo $d1=round(($d*20)/100); }
                     elseif ($q > '0' && $q <='10')
                     { echo $d1=round(($d*35)/100);} 
                     elseif 
                     ($q > '10' && $q <= '20') 
                     { echo $d1=round(($d*50)/100);} 
                     elseif ($q > '20' && $q <= '30')
                     { echo $d1=round(($d*65)/100); }
                     elseif ($q > '30' && $q <= '40')
                     { echo $d1=round(($d*80)/100); }
                     
                     elseif($q > '40' && $q <= '50')
                     { echo $d1=$d; }
                     elseif( $q > '50'){ echo  $d1=$d; }
                     elseif($q< '0'){echo "0"; $d1='0';}?></td>
                  <td><?php echo $tot= $s1+$d1; ?></td>
                  <td><?php if($e < '100'){ echo -$tot+$am; }?></td>
               </tr>
               <?php
                  }
                  while($row2= mysqli_fetch_array($result2)) {
                    $eid=$row2['SID'];
                      $sqli = "SELECT sum(Amount),SM from sales where SID='$eid' AND Date between '2018-04-01' AND '2018-06-30'";
                      $resulti = mysqli_query($conn,$sqli);
                      $rowi = mysqli_fetch_array($resulti);
                  
                       $sqlip = "SELECT sum(Amount),ASM from Salesmaster where SID='$eid' AND Date between '2017-04-01' AND '2017-06-30'";
                      $resultip = mysqli_query($conn,$sqlip);
                      $rowip = mysqli_fetch_array($resultip);
                  
                  
                  
                       $sqli112 = "SELECT Branch from Employeemst where E_id='$eid' ";
                      $resulti112 = mysqli_query($conn,$sqli112);
                      $rowi112 = mysqli_fetch_array($resulti112);
                  
                       $sqlid = "select count(*) from
                              (
                                select count(Distinct Dealer), Dealer,sum(Amount)
                                from Sales  where SID='$eid' AND Date between '2018-04-01' AND '2018-06-30'  group by Dealer Having sum(Amount) >='100000'
                                
                              ) d1";
                      $resultid = mysqli_query($conn,$sqlid);
                      $rowid = mysqli_fetch_array($resultid);
                  
                       $sqlidp = "select count(*) from
                              (
                                select count(Distinct Dealer), Dealer,sum(Amount)
                                from Salesmaster  where SID='$eid' AND Date between '2017-04-01' AND '2017-06-30'  group by Dealer Having sum(Amount) >='100000'
                                
                              ) d1";
                      $resultidp = mysqli_query($conn,$sqlidp);
                      $rowidp = mysqli_fetch_array($resultidp);
                  
                  
                    ?>
               <tr class="d1">
                  <td><?php echo $eid; ?></td>
                  <td><?php echo $rowi['SM']; ?></td>
                  <td><?php echo "SM"; ?></td>
                  <td><?php echo  $rowi112['Branch'];?></td>
                  <td><?php echo $a=$rowip['sum(Amount)']; ?></td>
                  <td><?php echo $b=$rowi['sum(Amount)']; ?></td>
                  <td><?php echo $e=round((($b/$a)-1)*100); ?></td>
                  <td><?php if($e >= '0'){ echo "Eligible";}else{echo "Not Eligible";} ?></td>
                  <td><?php echo $m = $rowidp['count(*)']; ?></td>
                  <td><?php echo $n = $rowid['count(*)']; ?></td>
                  <td><?php echo $q=round((($n/$m)-1)*100);?></td>
                  <td><?php echo $am=round(($b*0.125)/100);?></td>
                  <td><?php if($e >= '0'){ echo $s=round(($am*75)/100);}else{echo "Not Eligible";$s='0';} ?></td>
                  <td><?php if($q >= '0' && $e >= '0'){ echo $d=round(($am*25)/100);}else{echo "Not Eligible";$d='0';} ?></td>
                  <td><?php
                     if( $e == '0' )
                     { echo '20%';}
                     elseif ($e > '0' && $e <='10')
                      {echo '35%';} 
                     elseif 
                     ($e > '10' && $e <= '20') 
                     { echo '50%';} 
                     elseif ($e > '20' && $e <= '30')
                     {echo '65%';}
                     elseif ($e > '30' && $e <= '40')
                     {echo '80%';}
                     
                     elseif($e > '40' && $e <= '50')
                     { echo '100%';}
                     elseif($e > '50' && $q > '50'){echo "Eligible for Jackpot";}
                      elseif($e > '50' && $q < '50'){echo '100%';}
                     elseif( $e < '0'){echo "Not Eligible";}
                     ?></td>
                  <td><?php
                     if( $q == '0' )
                     { echo '20%';}
                     elseif ($q > '0' && $q <='10')
                     {echo '35%';} 
                     elseif 
                     ($q > '10' && $q <= '20') 
                     { echo '50%';} 
                     elseif ($q > '20' && $q <= '30')
                     {echo '65%';}
                     elseif ($q > '30' && $q <= '40')
                     {echo '80%';}
                     
                     elseif($q > '40' && $q <= '50')
                     { echo '100%';}
                     elseif($q > '50'){echo '100%';}
                     elseif( $q < '0'){echo "Not Eligible";}
                     ?></td>
                  <td><?php 
                     if( $e == '0' )
                     { echo $s1=round(($s*20)/100); }
                     elseif ($e > '0' && $e <='10')
                     { echo $s1=round(($s*35)/100);} 
                     elseif 
                     ($e > '10' && $e <= '20') 
                     { echo $s1=round(($s*50)/100);} 
                     elseif ($e > '20' && $e <= '30')
                     { echo $s1=round(($s*65)/100); }
                     elseif ($e > '30' && $e <= '40')
                     { echo $s1=round(($s*80)/100); }
                     
                     elseif($e > '40' && $e <= '50')
                     { echo $s1=$s; }
                     elseif( $e > '50'){ echo  $s1=$s; }
                     elseif($e< '0'){echo "0"; $s1='0';}
                     ?>
                  <td><?php 
                     if( $q == '0' )
                     { echo $d1=round(($d*20)/100); }
                     elseif ($q > '0' && $q <='10')
                     { echo $d1=round(($d*35)/100);} 
                     elseif 
                     ($q > '10' && $q <= '20') 
                     { echo $d1=round(($d*50)/100);} 
                     elseif ($q > '20' && $q <= '30')
                     { echo $d1=round(($d*65)/100); }
                     elseif ($q > '30' && $q <= '40')
                     { echo $d1=round(($d*80)/100); }
                     
                     elseif($q > '40' && $q <= '50')
                     { echo $d1=$d; }
                     elseif( $q > '50'){ echo  $d1=$d; }
                     elseif($q< '0'){echo "0"; $d1='0';}?></td>
                  <td><?php echo $tot= $s1+$d1; ?></td>
                  <td><?php if($e < '100'){ echo -$tot+$am; }?></td>
               </tr>
               <?php
                  }
                  while($row3 = mysqli_fetch_array($result3)) {
                    $eid=$row3['ZID'];
                      $sqli = "SELECT sum(Amount),ZM from sales where ZID='$eid' AND Date between '2018-04-01' AND '2018-06-30'";
                      $resulti = mysqli_query($conn,$sqli);
                      $rowi = mysqli_fetch_array($resulti);
                  
                      $sqlip = "SELECT sum(Amount),ASM from Salesmaster where ZID='$eid' AND Date between '2017-04-01' AND '2017-06-30'";
                      $resultip = mysqli_query($conn,$sqlip);
                      $rowip = mysqli_fetch_array($resultip);
                  
                  
                       $sqli1123 = "SELECT Branch from Employeemst where E_id='$eid' ";
                      $resulti1123 = mysqli_query($conn,$sqli1123);
                      $rowi1123 = mysqli_fetch_array($resulti1123);
                  
                       $sqlid = "select count(*) from
                              (
                                select count(Distinct Dealer), Dealer,sum(Amount)
                                from Sales  where ZID='$eid' AND Date between '2018-04-01' AND '2018-06-30'  group by Dealer Having sum(Amount) >='100000'
                                
                              ) d1";
                      $resultid = mysqli_query($conn,$sqlid);
                      $rowid = mysqli_fetch_array($resultid);
                  
                       $sqlidp = "select count(*) from
                              (
                                select count(Distinct Dealer), Dealer,sum(Amount)
                                from Salesmaster  where ZID='$eid' AND Date between '2017-04-01' AND '2017-06-30'  group by Dealer Having sum(Amount) >='100000'
                                
                              ) d1";
                      $resultidp = mysqli_query($conn,$sqlidp);
                      $rowidp = mysqli_fetch_array($resultidp);
                  
                  
                    ?>
               <tr class="d1">
                  <td><?php echo $eid; ?></td>
                  <td><?php echo $rowi['ZM']; ?></td>
                  <td><?php echo "ZM"; ?></td>
                  <td><?php echo $rowi1123['Branch'];?></td>
                  <td><?php echo $a=$rowip['sum(Amount)']; ?></td>
                  <td><?php echo $b=$rowi['sum(Amount)']; ?></td>
                  <td><?php echo $e=round((($b/$a)-1)*100); ?></td>
                  <td><?php if($e >= '0'){ echo "Eligible";}else{echo "Not Eligible";} ?></td>
                  <td><?php echo $m = $rowidp['count(*)']; ?></td>
                  <td><?php echo $n = $rowid['count(*)']; ?></td>
                  <td><?php echo $q=round((($n/$m)-1)*100);?></td>
                  <td><?php echo $am=round(($b*0.03)/100);?></td>
                  <td><?php if($e >= '0'){ echo $s=round(($am*75)/100);}else{echo "Not Eligible";$s='0';} ?></td>
                  <td><?php if($q >= '0' && $e >= '0'){ echo $d=round(($am*25)/100);}else{echo "Not Eligible";$d='0';} ?></td>
                  <td><?php
                     if( $e == '0' )
                     { echo '20%';}
                     elseif ($e > '0' && $e <='10')
                      {echo '35%';} 
                     elseif 
                     ($e > '10' && $e <= '20') 
                     { echo '50%';} 
                     elseif ($e > '20' && $e <= '30')
                     {echo '65%';}
                     elseif ($e > '30' && $e <= '40')
                     {echo '80%';}
                     
                     elseif($e > '40' && $e <= '50')
                     { echo '100%';}
                     elseif($e > '50' && $q > '50'){echo "Eligible for Jackpot";}
                      elseif($e > '50' && $q < '50'){echo '100%';}
                     elseif( $e < '0'){echo "Not Eligible";}
                     ?></td>
                  <td><?php
                     if( $q == '0' )
                     { echo '20%';}
                     elseif ($q > '0' && $q <='10')
                     {echo '35%';} 
                     elseif 
                     ($q > '10' && $q <= '20') 
                     { echo '50%';} 
                     elseif ($q > '20' && $q <= '30')
                     {echo '65%';}
                     elseif ($q > '30' && $q <= '40')
                     {echo '80%';}
                     
                     elseif($q > '40' && $q <= '50')
                     { echo '100%';}
                     elseif($q > '50'){echo '100%';}
                     elseif( $q < '0'){echo "Not Eligible";}
                     ?></td>
                  <td><?php 
                     if( $e == '0' )
                     { echo $s1=round(($s*20)/100); }
                     elseif ($e > '0' && $e <='10')
                     { echo $s1=round(($s*35)/100);} 
                     elseif 
                     ($e > '10' && $e <= '20') 
                     { echo $s1=round(($s*50)/100);} 
                     elseif ($e > '20' && $e <= '30')
                     { echo $s1=round(($s*65)/100); }
                     elseif ($e > '30' && $e <= '40')
                     { echo $s1=round(($s*80)/100); }
                     
                     elseif($e > '40' && $e <= '50')
                     { echo $s1=$s; }
                     elseif( $e > '50'){ echo  $s1=$s; }
                     elseif($e< '0'){echo "0"; $s1='0';}
                     ?>
                  <td><?php 
                     if( $q == '0' )
                     { echo $d1=round(($d*20)/100); }
                     elseif ($q > '0' && $q <='10')
                     { echo $d1=round(($d*35)/100);} 
                     elseif 
                     ($q > '10' && $q <= '20') 
                     { echo $d1=round(($d*50)/100);} 
                     elseif ($q > '20' && $q <= '30')
                     { echo $d1=round(($d*65)/100); }
                     elseif ($q > '30' && $q <= '40')
                     { echo $d1=round(($d*80)/100); }
                     
                     elseif($q > '40' && $q <= '50')
                     { echo $d1=$d; }
                     elseif( $q > '50'){ echo  $d1=$d; }
                     elseif($q< '0'){echo "0"; $d1='0';}?></td>
                  <td><?php echo $tot= $s1+$d1; ?></td>
                  <td><?php if($e < '100'){ echo -$tot+$am; }?></td>
               </tr>
               <?php
                  }
                  exit();
                  $sub='1888078';
                  $sales='sales';
                  $sqli = "SELECT sum(Total_Earning) from Employeemst where Department!='Management' AND Department!='Sales' AND Department!='SALES' and month between 4 and 6 and year='2018' ";
                  $resulti = mysqli_query($conn,$sqli);
                  $rowi = mysqli_fetch_array($resulti);
                  
                  $sql = "SELECT sum(Amount) from sales where Date between '2018-04-01' and '2018-06-31' ";
                  $result = mysqli_query($conn,$sql);
                  $row = mysqli_fetch_array($result);
                  $a=$row['sum(Amount)'];
                  ($Total=$a-$sub); 
                  $noninc=round($amm=(($Total * ( 0.003))/100));
                  //echo $am;
                  if($str!='management'){
                    ?>
               <tr class="d1">
                  <td><?php echo $name[$m]; ?></td>
                  <td><?php echo $id; ?></td>
                  <td><?php echo $br; ?></td>
                  <td><?php echo $str ; ?></td>
                  <td><?php if($str!='sales'){echo "Non-sales"; }else{ echo "Sales";}?></td>
                  <td><?php echo $row1["Total_Earning"]; ?></td>
                  <td><?php echo $row2["Total_Earning"]; ; ?></td>
                  <td><?php echo $row3["Total_Earning"]; ; ?></td>
                  <td><?php echo $am ; ?></td>
                  <td><?php if($str!='sales' && $str!='management'){ echo round(($noninc/$rowi['sum(Total_Earning)'])*$am);}else{ echo "0";}?></td>
               </tr>
               <?php
                  }
                     ?>
               <tbody>
            </table>
         </div>
         <br><br><br>
      </div>
   </body>
   </head>
</html>             