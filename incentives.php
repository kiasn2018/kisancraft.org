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
      <div style="margin-left:22%; width:75%;">
         <?php
            $name=array();
            $sql = "SELECT distinct E_id from Employeemst ";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_array($result)) {
                $name1=$row["E_id"];
                $name[]=$name1;
            }
            
            //include '/test/index.php';
            //include '/search.php'
            ?>
         <table class="sortable">
            <thead>
               <tr class="d0">
                  <th width="10%"><span>Emp ID</span></th>
                  <th width="50%"><span> Employee Name</span></th>
                  <th width="20%"><span>Branch</span></th>
                  <th width="25%"><span>Department</span></th>
                  <th width="25%"><span>Category</span></th>
                  <th width="25%"><span>Jan</span></th>
                  <th width="25%"><span>feb</span></th>
                  <th width="25%"><span>mar</span></th>
                  <th width="25%"><span>Total Earning</span></th>
                  <th width="25%"><span> Incetives</span></th>
                  <th width="25%"><span>Percentage</span></th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  for($m=0;$m<(count($name));$m++){
                  $sql = "SELECT sum(Total_Earning) Total_Earning,E_name,Branch,Department from Employeemst where E_id='$name[$m]' and month between 1 and 3 and year='2018' ";
                  //echo $sql;
                  $result = mysqli_query($conn,$sql);
                  $sql1 = "SELECT sum(Total_Earning) Total_Earning,E_name,Branch,Department from Employeemst where E_id='$name[$m]' and month='1' and year='2018' ";
                  //echo $sql;
                  $result1 = mysqli_query($conn,$sql1);
                  $sql2 = "SELECT sum(Total_Earning) Total_Earning,E_name,Branch,Department from Employeemst where E_id='$name[$m]' and month='2' and year='2018' ";
                  //echo $sql;
                  $result2 = mysqli_query($conn,$sql2);
                  $sql3 = "SELECT sum(Total_Earning) Total_Earning,E_name,Branch,Department from Employeemst where E_id='$name[$m]' and month='3' and year='2018' ";
                  //echo $sql;
                  $result3 = mysqli_query($conn,$sql3);
                  $row1 = mysqli_fetch_array($result1);
                  $row2 = mysqli_fetch_array($result2);
                  $row3 = mysqli_fetch_array($result3);
                  while($row = mysqli_fetch_array($result)) {
                      //print_r($row);
                      $am=$row["Total_Earning"];
                      $id=$row["E_name"];
                      $br= $row["Branch"];
                      $str = strtolower($row["Department"]);
                  }
                  $sub='1888078';
                  $sales='sales';
                  $sqli = "SELECT sum(Total_Earning) from Employeemst where Department!='Management' AND Department!='Sales' AND Department!='SALES' and month between 1 and 3 and year='2018' ";
                  $resulti = mysqli_query($conn,$sqli);
                  $rowi = mysqli_fetch_array($resulti);
                  
                  $sql = "SELECT sum(Amount) from Salesmaster where Date between '2018-01-01' and '2018-03-31' ";
                  $result = mysqli_query($conn,$sql);
                  $row = mysqli_fetch_array($result);
                  $a=$row['sum(Amount)'];
                  ($Total=$a-$sub); 
                  $noninc=round($amm=($Total * ( 0.003)));
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
                  }}
                     ?>
            <tbody>
         </table>
         <br><br><br>
      </div>
   </body>
   </head>
</html>