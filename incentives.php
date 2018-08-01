<html>
   <head>
      <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
      <script src="/kisankraft.org/src/js/sorttable.js"></script>
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <style>
         
      </style>
       <script src="js/tableToExcel.js"></script>
   </head>
   <body bgcolor="">
      <?php 
         include 'header2.php';
         include '/config/db.php';
         ?>
       <div class="main-panel">
      <div class="content-wrapper">
         <div class ="row">
            <div class="col-6" >
               <h1 style="text-align:center;"> P_Bonus For Non-Sales Employees </h1>
               <div class="col-12 stretch-card">
                  <div class="card">
                     <div class="card-body">
                        
                        <form class="forms-sample" action="" method="post">
                           <div class="form-group row">
                             
                           </div>
                           <div class="form-group row">
                             
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
         <?php
//echo $_POST["go"];
if ($_POST["go"] == "Submit") {
    $amount         = "";
    $district       = ($_POST["district"]);
    $state          = ($_POST["state"]);
    $state1         = $state;
    $queryCondition = "";
    if (!empty($_POST["search"]["post_at"])) {
        $post_at = $_POST["search"]["post_at"];
        list($fid, $fim, $fiy) = explode("-", $post_at);
        $post_at_todate = date('Y-m-d');
        if (!empty($_POST["search"]["post_at_to_date"])) {
            $post_at_to_date = $_POST["search"]["post_at_to_date"];
            list($tid, $tim, $tiy) = explode("-", $_POST["search"]["post_at_to_date"]);
            $post_at_todate = "$tiy-$tim-$tid";
            $queryCondition .= "  Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
            $py              = $fiy - 1;
            $post_at_todate1 = "$py-$tim-$tid";
            $lm              = $fim - '01';
            $lm              = '0' . $lm;
            $post_at_todate2 = "$tiy-$lm-$tid";
            $post_at_todate3 = "$py-$lm-$tid";
            $queryCondition1 .= " AND Date BETWEEN '$py-$fim-$fid' AND '" . $post_at_todate1 . "'";
            $queryCondition2 .= " AND Date BETWEEN '$fiy-$lm-$fid' AND '" . $post_at_todate2 . "'";
            $queryCondition3 .= " AND Date BETWEEN '$py-$lm-$fid' AND '" . $post_at_todate3 . "'";
            $nim=$fim+1;
        }
    } ?>
         <?php
            $name=array();
            $sql = "SELECT distinct E_id from Employeemst  ";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_array($result)) {
              if($row["E_id"]!=''){
                $name1=$row["E_id"];
                $name[]=$name1;
            }
          }
            
            //include '/test/index.php';
            //include '/search.php'
            ?>
            <input type="button" onclick="tableToExcel('testTable', 'P_Bonus Non-sales')" value="Export to Excel">
         <table id='testTable' >
            <thead>
               <tr class="d0">
                  <th width="10%"><span>Emp ID</span></th>
                  <th width="50%"><span> Employee Name</span></th>
                  <th width="20%"><span>Branch</span></th>
                  <th width="25%"><span>Department</span></th>
                  <th width="25%"><span>Category</span></th>
                  <th width="25%"><span><?php echo $monthName = date("F", mktime(0, 0, 0, $fim, 10)); ?></span></th>
                  <th width="25%"><span><?php   echo $monthName = date("F", mktime(0, 0, 0, $nim, 10)); ?></span></th>
                  <th width="25%"><span><?php   echo $monthName = date("F", mktime(0, 0, 0, $tim, 10)); ?></span></th>
                  <th width="25%"><span>Total Earning</span></th>
                  <th width="25%"><span> P_Bonus</span></th>
                  <th width="25%"><span>Percentage</span></th>
               </tr>
            </thead>
            <tbody>
               <?php 
               $sub='904663';
                  for($m=0;$m<(count($name));$m++){
                  $sql = "SELECT sum(Total_Earning) Total_Earning,E_name,Branch,Department from Employeemst where E_id='$name[$m]'  and month between '$fim' and '$tim' and year='$tiy' ";
                  //echo $sql;
                  $result = mysqli_query($conn,$sql);
                  $sql1 = "SELECT sum(Total_Earning) Total_Earning,E_name,Branch,Department from Employeemst where E_id='$name[$m]' and month='$fim' and year='$tiy' ";
                  //echo $sql;
                  $result1 = mysqli_query($conn,$sql1);
                  $sql2 = "SELECT sum(Total_Earning) Total_Earning,E_name,Branch,Department from Employeemst where E_id='$name[$m]' and month='$nim' and year='$tiy' ";
                  //echo $sql;
                  $result2 = mysqli_query($conn,$sql2);
                  $sql3 = "SELECT sum(Total_Earning) Total_Earning,E_name,Branch,Department from Employeemst where E_id='$name[$m]' and month='$tim' and year='$tiy' ";
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
                  
                  $sales='sales';
                  $sqli = "SELECT sum(Total_Earning) from Employeemst where Department!='management' AND Department!='Sales' AND Department!='SALES'  and month between '$fim' and '$tim' and year='$tiy' ";
                  $resulti = mysqli_query($conn,$sqli);
                  $rowi = mysqli_fetch_array($resulti);
                  
                  $sql = "SELECT sum(Amount) from sales where  ".$queryCondition;
                  $result = mysqli_query($conn,$sql);
                  $row = mysqli_fetch_array($result);
                  $a=$row['sum(Amount)'];
                  ($Total=$a-$sub); 
                  //echo $Total;
                  $noninc=round($amm=($Total * ( 0.003)));
                  //echo $am;
                  if($str!='management'){
                    if($id != ''){
                       if($str!='sales' && $str!='management'){ if($id!=''){
                  	?>
               <tr >
                  
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
                  }}}}}
                     ?>
            <tbody>
         </table>
        <?PHP } ?>
      </div>
   </body>
   
</html>
