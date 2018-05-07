<?php ini_set('max_execution_time', 0);
   include '/config/db.php';
   $post_at = "";
   $post_at_to_date = "";
   
   $queryCondition = "";
   if(!empty($_POST["search"]["post_at"])) {
       $post_at = $_POST["search"]["post_at"];
       list($fid,$fim,$fiy) = explode("-",$post_at);
       
       $post_at_todate = date('Y-m-d');
       if(!empty($_POST["search"]["post_at_to_date"])) {
           $post_at_to_date = $_POST["search"]["post_at_to_date"];
           list($tid,$tim,$tiy) = explode("-",$_POST["search"]["post_at_to_date"]);
           $post_at_todate = "$tiy-$tim-$tid";
       }
       //echo date("l").$tid;
       //$queryCondition .= "WHERE Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
   }else{
   $fid='01';
   $fim='02';
   $fiy=date("Y");
   $post_at_todate="2018-02-28";}
   list($tid,$tim,$tiy) = explode("-",$post_at_todate);
   //echo $tiy;
   $queryCondition .= "WHERE Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
   $sql = "SELECT * from sales " . $queryCondition . " ORDER BY Date  ";
   //echo $sql;
   
   $result = mysqli_query($conn,$sql);
   
   $ap=array();
   $br=array();
   $ch=array();
   $dl=array();
   $goa=array();
   $gu=array();
   $hp=array();
   $hr=array();
   $Jk=array();
   $jh=array();
   $k_c=array();
   $k_l=array();
   $k_n=array();
   $k_s=array();
   $kl=array();
   $mp=array();
   $mh=array();
   $nep=array();
   $ne=array();
   $od=array();
   $pj=array();
   $tn=array();
   $tl=array();
   $up_a=array();
   $up_b=array();
   $up_d=array();
   $uk=array();
   $wb=array();
   $rj=array();
   $rj=array();
   while($row = mysqli_fetch_array($result)) {
       //print_r($row);exit();
       {
       $d=$row["Dealer"];
       $date=$row["Date"];
       $orderdate = explode('-', $date);
       $month = $orderdate[1];
       $day   = $orderdate[2];
       $year  = $orderdate[0];
      $sqls = "SELECT * from Dealermst where D_name='$d' ";
      $results = mysqli_query($conn,$sqls);
      $rows = mysqli_fetch_array($results);
              $district=$row["District"];
              $state=$row["State"];
              if($state==""){echo $d; }
              
              
          if( $state=="Andhra Pradesh"){
                  $ap[$day]=$ap[$day]-$rowsq["amount"]+$row["Amount"];
                 
              }else
              if( $state=="Uttar Pradesh"){
              $sqls1 = "SELECT Zone from Zonesmst where State='$state' AND District= '$district'";
              //echo $sqls1;
              $results1 = mysqli_query($conn,$sqls1);
              $rows1 = mysqli_fetch_array($results1); 
                  //print_r($rows1);
                  if($rows1["Zone"]=="Uttar Pradesh A"){
                      $up_a[$day]=$up_a[$day]+$row["Amount"]-$rowsq["amount"];
                  }else
                  if($rows1["Zone"]=="Uttar Pradesh B"){
                      $up_b[$day]=$up_b[$day]+$row["Amount"]-$rowsq["amount"];
                  }else
                  if($rows1["Zone"]=="Uttar Pradesh D"){
                      $up_d[$day]=$up_d[$day]+$row["Amount"]-$rowsq["amount"];
                  }else{echo $district; }
                  
           }else
           if( $state=="Karnataka"){
               //$k_c[$day]=$row["Amount"];
               $sqls1 = "SELECT Zone from Zonesmst where State='$state' AND District= '$district'";
               //echo $sqls1;
               $results1 = mysqli_query($conn,$sqls1);
               $rows1 = mysqli_fetch_array($results1);
               //print_r($rows1);
              // echo $rows1["Zone"].$date."<br>";
               if($rows1["Zone"]=="Karnataka Central"){
                   $k_c[$day]=$k_c[$day]+$row["Amount"]-$rowsq["amount"];
               }else
               if($rows1["Zone"]=="Karnataka Local"){
                   $k_l[$day]=$k_l[$day]+$row["Amount"]-$rowsq["amount"];
               }else
               if($rows1["Zone"]=="Karnataka North"){
                   $k_n[$day]=$k_n[$day]+$row["Amount"]-$rowsq["amount"];
               }else
               if($rows1["Zone"]=="Karnataka South"){
                   $k_s[$day]=$k_s[$day]+$row["Amount"]-$rowsq["amount"];
               }else{echo $district; }
               
           }else
           if( $state=="Bihar"){
               $br[$day]=$br[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Chhattisgarh"){
               $ch[$day]=$ch[$day]+$row["Amount"]-$rowsq["amount"];
              
               
           }else
           if( $state=="Delhi"){
               $dl[$day]=$dl[$day]+$row["Amount"]-$rowsq["amount"];
           }else
           if( $state=="Goa"){
               $goa[$day]=$goa[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           
           if( $state=="Gujarat"){
               $gu[$day]=$gu[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Haryana"){
               $hr[$day]=$hr[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Himachal Pradesh"){
               $hp[$day]=$hp[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Jammu and Kashmir"){
               $Jk[$day]=$Jk[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Jharkhand"){
               $jh[$day]=$jh[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Kerala"){
               $kl[$day]=$kl[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Madhya Pradesh"){
               $mp[$day]=$mp[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Maharashtra"){
               $mh[$day]=$mh[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Nepal"){
               $nep[$day]=$nep[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="North East" || $state=="Assam" || $state=="Arunachal Pradesh" || $state=="Nagaland" || $state=="Andaman and Nicobar" || $state=="Tripura" || $state=="Manipur"){
               $ne[$day]=$ne[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Odisha"){
               $od[$day]=$od[$day]+$row["Amount"]-$rowsq["amount"];
           }else
           if( $state=="Punjab" || $state=="Chandigarh"){
               $pj[$day]=$pj[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Rajasthan"){
               $rj[$day]=$rj[$day]+$row["Amount"]-$rowsq["amount"];
           }else
           if( $state=="Tamil Nadu" || $state=="Puducherry"){
               $tn[$day]=$tn[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="Telangana"){
               $tl[$day]=$tl[$day]+$row["Amount"]-$rowsq["amount"];
           }else
           if( $state=="Uttarakhand"){
               $uk[$day]=$uk[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else
           if( $state=="West Bengal"){
               $wb[$day]=$wb[$day]+$row["Amount"]-$rowsq["amount"];
               
           }else echo $state;
           
       }} {
           //credit note calculation
          // $queryCondition .= "WHERE Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
           $sql = "SELECT * from Credit_td " . $queryCondition . " ORDER BY Date  ";
           
           $result = mysqli_query($conn,$sql);
           $aps=array();
           $brs=array();
           $chs=array();
           $dls=array();
           $goas=array();
           $gus=array();
           $hps=array();
           $hrs=array();
           $Jks=array();
           $jhs=array();
           $k_cs=array();
           $k_ls=array();
           $k_ns=array();
           $k_ss=array();
           $kls=array();
           $mps=array();
           $mhs=array();
           $neps=array();
           $nes=array();
           $ods=array();
           $pjs=array();
           $tns=array();
           $tls=array();
           $up_as=array();
           $up_bs=array();
           $up_ds=array();
           $uks=array();
           $wbs=array();
           $rjs=array();
           while($row = mysqli_fetch_array($result)) {
               //print_r($row);
               $d=$row["party_name"];
               $inm=$row["item_name"];
               {
               //echo $d;
               $date=$row["Date"];
               $orderdate = explode('-', $date);
               $month = $orderdate[1];
               $day   = $orderdate[2];
               $year  = $orderdate[0];
               {
                  // echo $d;
               $sqls = "SELECT * from Dealermst where D_name='$d' ";
               $results = mysqli_query($conn,$sqls);
               $rows = mysqli_fetch_array($results);
               $state=$rows["D_distict"];
               $district=$rows["D_state"];
               //print_r($rows);
              
               if( $district=="Andhra Pradesh"){
                   $aps[$day]=$aps[$day]+$row["amount"];
                   
                   }
               
               if( $district=="Uttar Pradesh"){
                   $sqls1 = "SELECT Zone from Zonesmst where State='$district' AND District= '$state'";
                   //echo $sqls1;
                   $results1 = mysqli_query($conn,$sqls1);
                   $rows1 = mysqli_fetch_array($results1);
                   //print_r($rows1);
                   if($rows1["Zone"]=="Uttar Pradesh A"){
                       $up_as[$day]=$up_as[$day]+$row["amount"];
                      
                   }
                   if($rows1["Zone"]=="Uttar Pradesh B"){
                       $up_bs[$day]=$up_bs[$day]+$row["amount"];
                   }
                   if($rows1["Zone"]=="Uttar Pradesh D"){
                       $up_ds[$day]=$up_ds[$day]+$row["amount"];
                   }
                   
               } 
               if( $district=="Karnataka"){
                   //$k_c[$day]=$row["Amount"];
                   $sqls1 = "SELECT Zone from Zonesmst where State='$district' AND District= '$state'";
                   //echo $sqls1;
                   $results1 = mysqli_query($conn,$sqls1);
                   $rows1 = mysqli_fetch_array($results1);
                   //print_r($rows1);
                   // echo $rows1["Zone"].$date."<br>";
                   if($rows1["Zone"]=="Karnataka Central"){
                       $k_cs[$day]=$k_cs[$day]+$row["amount"];
                      
                   }
                   if($rows1["Zone"]=="Karnataka Local"){
                       $k_ls[$day]=$k_ls[$day]+$row["amount"];
                   }
                   if($rows1["Zone"]=="Karnataka North"){
                       $k_ns[$day]=$k_ns[$day]+$row["amount"];
                   }
                   if($rows1["Zone"]=="Karnataka South"){
                       $k_ss[$day]=$k_ss[$day]+$row["amount"];
                   }
                   
               }
               if( $district=="Bihar"){
                   $brs[$day]=$brs[$day]+$row["amount"];
                   
               }
               if( $district=="Chhattisgarh"){
                   $chs[$day]=$chs[$day]+$row["amount"];
                   //print_r($chs);
               }
               if( $district=="Delhi"){
                   $dls[$day]=$dls[$day]+$row["amount"];
               }
               if( $district=="Goa"){
                   $goas[$day]=$goas[$day]+$row["amount"];
                   
               }
               
               if( $district=="Gujarat"){
                   $gus[$day]=$gus[$day]+$row["amount"];
                   
               }
               if( $district=="Haryana"){
                   $hrs[$day]=$hrs[$day]+$row["amount"];
                   
               }
               if( $district=="Himachal Pradesh"){
                   $hps[$day]=$hps[$day]+$row["amount"];
                   
               }
               if( $district=="Jammu and Kashmir"){
                   $Jks[$day]=$Jks[$day]+$row["amount"];
                   
               }
               if( $district=="Jharkhand"){
                   $jhs[$day]=$jhs[$day]+$row["amount"];
                   
               }
               if( $district=="Kerala"){
                   $kls[$day]=$kls[$day]+$row["amount"];
                   
               }
               if( $district=="Madhya Pradesh"){
                   $mps[$day]=$mps[$day]+$row["amount"];
                   
               }
               if( $district=="Maharashtra"){
                   $mhs[$day]=$mhs[$day]+$row["amount"];
                   
               }
               if( $district=="Nepal"){
                   $neps[$day]=$neps[$day]+$row["amount"];
                   
               }
               if( $district=="North East"){
                   $nes[$day]=$nes[$day]+$row["amount"];
                   
               }
               if( $district=="Odisha"){
                   $ods[$day]=$ods[$day]+$row["amount"];
               }
               if( $district=="Punjab"){
                   $pjs[$day]=$pjs[$day]+$row["amount"];
                   
               }
               if( $district=="Rajasthan"){
                   $rjs[$day]=$rjs[$day]+$row["amount"];
               }
               if( $district=="Tamil Nadu"){
                   $tns[$day]=$tns[$day]+$row["amount"];
                   
               }
               if( $district=="Telangana"){
                   $tls[$day]=$tls[$day]+$row["amount"];
               }
               if( $district=="Uttarakhand"){
                   $uks[$day]=$uks[$day]+$row["amount"];
                   
               }
               if( $district=="West Bengal"){
                   $wbs[$day]=$wbs[$day]+$row["amount"];
                   
               }
   
               } }}}// print_r($k_n);exit();
   
   ?>
<html>
   <head>
      <title>Sales Daily Report</title>
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
   </head>
   <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
   <body>
      <div class="demo-content">
         <h2 class="title_with_link">Sales Report</h2>
         <div style="border: 1px solid green">
            <br>
            <div style="float:right;">
               <form name="frmSearch" method="post" action="dailysalesreport.php">
                  <p class="">
                     <input type="hidden" placeholder="From Date"  name="search[post_at]"  value="<?php echo $post_at; ?>" class="input-control" />
                     <input type="hidden" placeholder="To Date"  name="search[post_at_to_date]" style="margin-left:10px"  value="<?php echo $post_at_to_date; ?>" class="input-control"  />			 
                     <input type="submit" style="font-size:10pt;margin-right:250px;color:white;background-color:green;border:2px solid #336600;padding:8px" name="go0" value="Download report" >
                  </p>
               </form>
            </div>
            <form name="frmSearch" method="post" action="">
               <p class="search_input">
                  <input type="text" placeholder="From Date" style="margin-left:2%;" id="post_at" name="search[post_at]"  value="<?php echo $post_at; ?>" class="input-control" />
                  <input type="text" placeholder="To Date" id="post_at_to_date" name="search[post_at_to_date]" style="margin-left:10px"  value="<?php echo $post_at_to_date; ?>" class="input-control"  />			 
                  <input type="submit" name="go" value="Search" style="font-size:10pt;color:white;background-color:green;border:2px solid #336600;padding:8px" >
               </p>
            </form>
            <br>
         </div>
         <table class="sortable">
            <thead>
               <tr class="d0">
                  <th width="10%"><span>Date</span></th>
                  <th width="50%"><span>AP</span></th>
                  <th width="50%"><span>BH</span></th>
                  <th width="50%"><span>CH</span></th>
                  <th width="50%"><span>DL</span></th>
                  <th width="50%"><span>GOA</span></th>
                  <th width="50%"><span>GU</span></th>
                  <th width="50%"><span>HR</span></th>
                  <th width="50%"><span>HP</span></th>
                  <th width="50%"><span>JK</span></th>
                  <th width="50%"><span>JH</span></th>
                  <th width="50%"><span>K_C</span></th>
                  <th width="50%"><span>K_L</span></th>
                  <th width="50%"><span>K_N</span></th>
                  <th width="50%"><span>K_S</span></th>
                  <th width="50%"><span>KL</span></th>
                  <th width="50%"><span>MP</span></th>
                  <th width="50%"><span>MH</span></th>
                  <th width="50%"><span>NEP</span></th>
                  <th width="50%"><span>NE</span></th>
                  <th width="50%"><span>OD</span></th>
                  <th width="50%"><span>PJ</span></th>
                  <th width="50%"><span>RJ</span></th>
                  <th width="50%"><span>TN</span></th>
                  <th width="50%"><span>TL</span></th>
                  <th width="50%"><span>UP_A</span></th>
                  <th width="50%"><span>UP_B</span></th>
                  <th width="50%"><span>UP_D</span></th>
                  <th width="50%"><span>UK</span></th>
                  <th width="50%"><span>WB</span></th>
                  <th width="50%"><span>Total</span></th>
               </tr>
            </thead>
            <tbody>
               <tr class="d1">
                  <?php  for($j=$fid;$j<=$tiy;$j++){
                     if($j<10 && $j!=$fid){$j="0".$j;}?>
                  <td style=""><?php echo $j; ?></td>
                  <td><?php {echo ($ap[$j]-$aps[$j]);} ?></td>
                  <td><?php {echo $br[$j]-$brs[$j];} ?></td>
                  <td><?php {echo $ch[$j]-$chs[$j];} ?></td>
                  <td><?php {echo $dl[$j]-$dls[$j];} ?></td>
                  <td><?php {echo $goa[$j]-$goas[$j];}?></td>
                  <td><?php {echo $gu[$j]-$gus[$j];}?></td>
                  <td><?php {echo $hr[$j]-$hrs[$j];}?></td>
                  <td><?php {echo $hp[$j]-$hps[$j];}?></td>
                  <td><?php {echo $Jk[$j]-$Jks[$j];}?></td>
                  <td><?php {echo $jh[$j]-$jhs[$j];}?></td>
                  <td><?php {echo $k_c[$j]-$k_cs[$j];}?></td>
                  <td><?php {echo $k_l[$j]-$k_ls[$j];}?></td>
                  <td><?php {echo $k_n[$j]-$k_ns[$j];}?></td>
                  <td><?php {echo $k_s[$j]-$k_ss[$j];} ?></td>
                  <td><?php {echo $kl[$j]-$kls[$j];}?></td>
                  <td><?php {echo $mp[$j]-$mps[$j];}?></td>
                  <td><?php {echo $mh[$j]-$mhs[$j];}?></td>
                  <td><?php {echo $nep[$j]-$neps[$j];}?></td>
                  <td><?php {echo $ne[$j]-$nes[$j];}?></td>
                  <td><?php {echo $od[$j]-$ods[$j];}?></td>
                  <td><?php {echo $pj[$j]-$pjs[$j];}?></td>
                  <td><?php {echo $rj[$j]-$rjs[$j];}?></td>
                  <td><?php {echo $tn[$j]-$tns[$j];}?></td>
                  <td><?php {echo $tl[$j]-$tls[$j];} ?></td>
                  <td><?php {echo $up_a[$j]-$up_as[$j];} ?></td>
                  <td><?php {echo $up_b[$j]-$up_bs[$j];} ?></td>
                  <td><?php {echo $up_d[$j]-$up_ds[$j];} ?></td>
                  <td><?php {echo $uk[$j]-$uks[$j];} ?></td>
                  <td><?php {echo $wb[$j]-$wbs[$j];} ?></td>
                  <th><?php echo $toal=($ap[$j]-$aps[$j]+$br[$j]-$brs[$j]+$ch[$j]-$chs[$j]+$dl[$j]-$dls[$j]+$goa[$j]-$goas[$j]+$gu[$j]-$gus[$j]+$hr[$j]-$hrs[$j]+$hp[$j]-$hps[$j]+$Jk[$j]-$Jks[$j]+$jh[$j]-$jhs[$j]+$k_c[$j]-$k_cs[$j]+$k_l[$j]-$k_ls[$j]+$k_n[$j]-$k_ns[$j]+$k_s[$j]-$k_ss[$j]+$kl[$j]-$kls[$j]+$mp[$j]-$mps[$j]+$mh[$j]-$mhs[$j]+$nep[$j]-$neps[$j]+$ne[$j]-$nes[$j]+$od[$j]-$ods[$j]+$pj[$j]-$pjs[$j]+$rj[$j]-$rjs[$j]+$tn[$j]-$tns[$j]+$tl[$j]-$tls[$j]+$up_a[$j]-$up_as[$j]+$up_b[$j]-$up_bs[$j]+$up_d[$j]-$up_ds[$j]+$uk[$j]-$uks[$j]+$wb[$j]-$wbs[$j]);?>
               </tr>
               <?php
                  }
                     ?>
               <tr>
                  <td>Total</td>
                  <td><?php echo (array_sum($ap)-array_sum($aps));?> </td>
                  <td><?php echo (array_sum($br)-array_sum($brs));?> </td>
                  <td><?php echo (array_sum($ch)-array_sum($chs));?> </td>
                  <td><?php echo (array_sum($dl)-array_sum($dls));?> </td>
                  <td><?php echo (array_sum($goa)-array_sum($goas));?> </td>
                  <td><?php echo (array_sum($gu)-array_sum($gus));?> </td>
                  <td><?php echo (array_sum($hr)-array_sum($hrs));?> </td>
                  <td><?php echo (array_sum($hp)-array_sum($hps));?> </td>
                  <td><?php echo (array_sum($Jk)-array_sum($Jks));?> </td>
                  <td><?php echo (array_sum($jh)-array_sum($jhs));?> </td>
                  <td><?php echo (array_sum($k_c)-array_sum($k_cs));?> </td>
                  <td><?php echo (array_sum($k_l)-array_sum($k_ls));?> </td>
                  <td><?php echo (array_sum($k_n)-array_sum($k_ns));?> </td>
                  <td><?php echo (array_sum($k_s)-array_sum($k_ss));?> </td>
                  <td><?php echo (array_sum($kl)-array_sum($kls));?> </td>
                  <td><?php echo (array_sum($mp)-array_sum($mps));?> </td>
                  <td><?php echo (array_sum($mh)-array_sum($mhs));?> </td>
                  <td><?php echo (array_sum($nep)-array_sum($neps));?> </td>
                  <td><?php echo (array_sum($ne)-array_sum($nes));?> </td>
                  <td><?php echo (array_sum($od)-array_sum($ods));?> </td>
                  <td><?php echo (array_sum($pj)-array_sum($pjs));?> </td>
                  <td><?php echo (array_sum($rj)-array_sum($rjs));?> </td>
                  <td><?php echo (array_sum($tn)-array_sum($tns));?> </td>
                  <td><?php echo (array_sum($tl)-array_sum($tls));?> </td>
                  <td><?php echo (array_sum($up_a)-array_sum($up_as));?> </td>
                  <td><?php echo (array_sum($up_b)-array_sum($up_bs));?> </td>
                  <td><?php echo (array_sum($up_d)-array_sum($up_ds));?> </td>
                  <td><?php echo (array_sum($uk)-array_sum($uks));?> </td>
                  <td><?php echo (array_sum($wb)-array_sum($wbs));?> </td>
               </tr>
            <tbody>
         </table>
         <br><br><br>
      </div>
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
   </body>
</html>