<?php
ini_set('max_execution_time', 0);
 
?>

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
         .sortable td {padding:5px 20px; border-bottom: #F0F0F0 0.5pt solid;vertical-align:top;} 
      </style>
       <script src="js/tableToExcel.js"></script>
   <body bgcolor="">
      <?php
include 'header2.php';
include '/config/db.php';

$sqld    = "SELECT Date FROM `sales` ORDER BY `sales`.`Date` DESC ";
// echo $sqld;
$resultd = mysqli_query($conn, $sqld);
$rowd    = mysqli_fetch_array($resultd);

?>
     <div class="main-panel">
      <div class="content-wrapper">
         <div class ="row">
            <div class="col-6" >
               <h1 style="text-align:center;"> Quarterly Meeting</h1>
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
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
;
$start_from = ($page - 1) * $results_per_page;
$sql        = "SELECT * from Salesmst LIMIT " . $start_from . "," . $results_per_page;
$result     = mysqli_query($conn, $sql);
//include '/test/index.php';
//include '/search.php';
if (!isset($_POST["go"])) {
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
    while ($row = mysqli_fetch_array($result)) {
?>
                    <tr class="d1">
                        <td><?php
        echo $row["ID"];
?></td>
                        <td><?php
        echo $data = str_replace("_", "'", $row["Dealer_name"]);
?></td>
                        <td><?php
        echo $row["Date"];
?></td>
                        <td><?php
        echo $row["Vorture_type"];
?></td>
                        <td><?php
        echo $data1 = str_replace("_", "'", $row["Item_name"]);
        $row["Item_name"];
?></td>
                        <td><?php
        $d       = $row["Dealer_name"];
        $sqls    = "SELECT * from Dealermst where D_name='$d' ";
        //echo $sqls;
        $results = mysqli_query($conn, $sqls);
        while ($rows = mysqli_fetch_array($results)) {
            $district = $rows["D_distict"];
            $state    = $rows["D_state"];
        }
        $sqls1    = "SELECT * from Excutivemst where State='$state' AND District= '$district'";
        $results1 = mysqli_query($conn, $sqls1);
        while ($rows1 = mysqli_fetch_array($results1)) {
            
            $exec = $rows1["Exexutive"];
            $ASM  = $rows1["ASM"];
        }
        echo $district;
?></td>
                        <td><?php
        echo $state;
?></td>
                        <td><?php
        echo $exec;
?></td>
                        <td><?php
        echo $ASM;
?></td>
                        <td><?php
        echo $row["Quantity"];
?></a> </td>
                        <td><?php
        echo $row["Amount"];
?></a> </td>
                     </tr>
                     <?php
    }
?>
                 <tbody>
               </table>
               <?php
    $sql         = "SELECT COUNT(ID) AS total FROM Salesmst";
    $result      = $conn->query($sql);
    $row         = $result->fetch_assoc();
    $total_pages = ceil($row["total"] / $results_per_page);
    
}
?>
              <br><br><br>
            </div>
         </div>
      </div>
   </body>
</html>
<hr>
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
            $queryCondition .= " AND Date BETWEEN '$fiy-$fim-$fid' AND '" . $post_at_todate . "'";
            $py              = $fiy - 1;
            $post_at_todate1 = "$py-$tim-$tid";
            $lm              = $fim - '01';
            $lm              = '0' . $lm;
            $post_at_todate2 = "$tiy-$lm-$tid";
            $post_at_todate3 = "$py-$lm-$tid";
            $queryCondition1 .= " AND Date BETWEEN '$py-$fim-$fid' AND '" . $post_at_todate1 . "'";
            $queryCondition2 .= " AND Date BETWEEN '$fiy-$lm-$fid' AND '" . $post_at_todate2 . "'";
            $queryCondition3 .= " AND Date BETWEEN '$py-$lm-$fid' AND '" . $post_at_todate3 . "'";
        }
    }
    //echo 
    {
        $seg      = array();
        $amt      = array();
        $amto     = array();
        $count    = '';
        $countly  = '';
        $counti   = '';
        $countlyi = '';
        $c        = '';
        $c1       = '';
        $c2       = '';
        $c3       = '';
        $p        = '';
        $p1       = '';
        $p2       = '';
        $p3       = '';
        $tpd      = array();
        $tpa      = array();
        $tpd1     = array();
        $tpa1     = array();
        
        if ($state1 == 'ALL') {
            $sqld = "SELECT DISTINCT District,Zone,Executive,ASM,SM,ZM FROM sales UNION SELECT DISTINCT District,Zone,Executive,ASM,SM,ZM  FROM Salesmaster ORDER by Zone,Executive,ASM,SM,ZM,District ASC";
        } else {
            if ($district == 'ALL') {
                $sqld  = "SELECT sum(Amount) FROM sales where Zone='$state' " . $queryCondition;
                $sqld1 = "SELECT sum(Amount) FROM Salesmaster where Zone='$state' " . $queryCondition1;
                
            } else {
                $sqld = "SELECT DISTINCT District from sales where District='$district' " . $queryCondition;
            }
        }
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        //echo $sqld;
        $resultd  = mysqli_query($conn, $sqld); 
        $resultd1 = mysqli_query($conn, $sqld1);
        $row      = mysqli_fetch_array($resultd);
        $row1     = mysqli_fetch_array($resultd1)?>   
<div class="table-responsive">
  <h1>From <?php
        echo $post_at;
?> TO <?php
        echo $post_at_todate;
?></h1>
   <table  id="testTable" class="table table-hover"   >

      <tr >
        <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">State</th>
         <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">QTR wise</th>
         <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">Sales 17-18</th>
         <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; " >Sales 18-19</th>
         <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; " >% of Progress</th>
      </tr>
      <tr>
        <td  bgcolor="#6b96db" style=" border: 0.5pt solid #000000; "><?php
        echo $state;
?></td>
        <td bgcolor="#6b96db" style=" border: 0.5pt solid #000000; " >Q1</td>
        <td bgcolor="#6b96db" style=" border: 0.5pt solid #000000; "><?php
        echo $a = $row1["sum(Amount)"];
?></td>
        <td bgcolor="#6b96db" style=" border: 0.5pt solid #000000; "><?php
        echo $b = $row["sum(Amount)"];
?></td>
        <td bgcolor="#6b96db" style=" border: 0.5pt solid #000000; "><?php
        echo round((($b / $a)- 1 )* 100);
?></td>
     </tr>
     <tr></tr>
      <tr><th >Dealer Analysis<th></tr>
<?php
        
        // New Dealers
        $sqlde    = "SELECT DISTINCT Dealer from sales where Zone='$state' ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        //echo $sqlde;
        $resultde = mysqli_query($conn, $sqlde);
        while ($row = mysqli_fetch_array($resultde)) {
            $dealer    = $row["Dealer"];
            $sqlde1    = "SELECT sum(Amount) from Salesmaster where Dealer='$dealer'";
            $resultde1 = mysqli_query($conn, $sqlde1);
            while ($row1 = mysqli_fetch_array($resultde1)) {
                if ($row1["sum(Amount)"] == '') {
                    $count = $count + 1;
                }
            }
        }
        
        $sqldely    = "SELECT DISTINCT Dealer from Salesmaster where Zone='$state' ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        //echo $sqlde;
        $resultdely = mysqli_query($conn, $sqldely);
        while ($rowly = mysqli_fetch_array($resultdely)) {
            $dealerly    = $rowly["Dealer"];
            $sqldely1    = "SELECT sum(Amount) from sales16_17 where Dealer='$dealerly'";
            $resultdely1 = mysqli_query($conn, $sqldely1);
            while ($rowly1 = mysqli_fetch_array($resultdely1)) {
                if ($rowly1["sum(Amount)"] == '') {
                    $countly = $countly + 1;
                }
            }
        }
        
        // Active Dealers
        $sqldec     = "SELECT count(DISTINCT Dealer) from sales where Zone='$state' ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        //echo $sqlde;
        $resultdec  = mysqli_query($conn, $sqldec);
        $rowc       = mysqli_fetch_array($resultdec);
        $sqlde1c    = "SELECT count(Distinct Dealer) from Salesmaster where Zone='$state'";
        $resultde1c = mysqli_query($conn, $sqlde1c);
        $row1c      = mysqli_fetch_array($resultde1c);
        
        
        //discountinue dealers
        $sqldi    = "SELECT DISTINCT Dealer from Salesmaster where Zone='$state' ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        //echo $sqlde;
        $resultdi = mysqli_query($conn, $sqldi);
        while ($rowi = mysqli_fetch_array($resultdi)) {
            $dealeri    = $rowi["Dealer"];
            $sqlde1     = "SELECT sum(Amount) from sales where Dealer='$dealeri'";
            $resultde1i = mysqli_query($conn, $sqlde1);
            while ($row1i = mysqli_fetch_array($resultde1i)) {
                if ($row1i["sum(Amount)"] == '') {
                    $counti = $counti + 1;
                }
            }
        }
        
        $sqldelyi    = "SELECT DISTINCT Dealer from sales16_17 where Zone='$state' ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultdelyi = mysqli_query($conn, $sqldelyi);
        while ($rowlyi = mysqli_fetch_array($resultdelyi)) {
            $dealerlyi    = $rowlyi["Dealer"];
            $sqldely1i    = "SELECT Dealer,sum(Amount) from Salesmaster where Dealer='$dealerlyi'";
            $resultdely1i = mysqli_query($conn, $sqldely1i);
            while ($rowly1i = mysqli_fetch_array($resultdely1i)) {
                if ($rowly1i["sum(Amount)"] == '') {
                    
                    $countlyi = $countlyi + 1;
                }
            }
        }
        
        //Dealers with Amount Range select count( Dealer),sum(Amount) as sum from sales GROUP BY Dealer
        //Having sum(Amount) >= '100000' and sum(Amount) <= '500000'
        $sqlam    = "select Dealer,sum(Amount) as sum from sales where Zone='$state' GROUP BY Dealer
                 Having sum(Amount) >= '100000' and sum(Amount) <= '500000'";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultam = mysqli_query($conn, $sqlam);
        while ($rowam = mysqli_fetch_array($resultam)) {
            $c = $c + 1;
        }
        
        $sqlam1    = "select Dealer,sum(Amount) as sum from sales where Zone='$state' GROUP BY Dealer
                 Having sum(Amount) <= '100000' ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultam1 = mysqli_query($conn, $sqlam1);
        while ($rowam1 = mysqli_fetch_array($resultam1)) {
            $c1 = $c1 + 1;
        }
        
        $sqlam2    = "select Dealer,sum(Amount) as sum from sales where Zone='$state' GROUP BY Dealer
                 Having sum(Amount) >= '500000' and sum(Amount) <= '1000000' ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultam2 = mysqli_query($conn, $sqlam2);
        while ($rowam2 = mysqli_fetch_array($resultam2)) {
            $c2 = $c2 + 1;
        }
        
        $sqlam3    = "select Dealer,sum(Amount) as sum from sales where Zone='$state' GROUP BY Dealer
                 Having sum(Amount) >= '1000000'  ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultam3 = mysqli_query($conn, $sqlam3);
        while ($rowam3 = mysqli_fetch_array($resultam3)) {
            $c3 = $c3 + 1;
        }
        
        
        $sqlam    = "select Dealer,sum(Amount) as sum from Salesmaster where Zone='$state' GROUP BY Dealer
                 Having sum(Amount) >= '100000' and sum(Amount) <= '500000'";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultam = mysqli_query($conn, $sqlam);
        while ($rowam = mysqli_fetch_array($resultam)) {
            $p = $p + 1;
        }
        
        $sqlam1    = "select Dealer,sum(Amount) as sum from Salesmaster where Zone='$state' GROUP BY Dealer
                 Having sum(Amount) <= '100000' ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultam1 = mysqli_query($conn, $sqlam1);
        while ($rowam1 = mysqli_fetch_array($resultam1)) {
            $p1 = $p1 + 1;
        }
        
        $sqlam2    = "select Dealer,sum(Amount) as sum from Salesmaster where Zone='$state' GROUP BY Dealer
                 Having sum(Amount) >= '500000' and sum(Amount) <= '1000000' ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultam2 = mysqli_query($conn, $sqlam2);
        while ($rowam2 = mysqli_fetch_array($resultam2)) {
            $p2 = $p2 + 1;
        }
        
        $sqlam3    = "select Dealer,sum(Amount) as sum from Salesmaster where Zone='$state' GROUP BY Dealer
                 Having sum(Amount) >= '1000000'  ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultam3 = mysqli_query($conn, $sqlam3);
        while ($rowam3 = mysqli_fetch_array($resultam3)) {
            $p3 = $p3 + 1;
        }
        
        
        // top 5 Dealers select distinct Dealer, sum(Amount) as sum from sales group by Dealer order by sum Desc limit 5
        
        $sqlt    = "select distinct Dealer, sum(Amount) as sum from sales where Zone ='$state'" . $queryCondition . "group by Dealer order by sum Desc limit 5";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultt = mysqli_query($conn, $sqlt);
        while ($rowt = mysqli_fetch_array($resultt)) {
            $tpd[] = $rowt["Dealer"];
            $tpa[] = $rowt["sum"];
        }
        
        
        $sqltp    = "select distinct Dealer, sum(Amount) as sum from Salesmaster where Zone ='$state'" . $queryCondition1 . "group by Dealer order by sum Desc limit 5";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resulttp = mysqli_query($conn, $sqltp);
        while ($rowtp = mysqli_fetch_array($resulttp)) {
            $tpd1[] = $rowtp["Dealer"];
            $tpa1[] = $rowtp["sum"];
        }
?>
<tr>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #383e3f; ">Year</th>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #383e3f; "> 2017-18</th>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #383e3f; "> 2018-19</th>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #383e3f; "> Addl Info</th>
</tr>
<tr>
  <th bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; ">No of New Dealers </th>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "><?php
        echo $countly;
?></td>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "><?php
        echo $count;
?></td>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "></td>
</tr>

<tr>
  <th bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; ">No of Active Dealers </th>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "><?php
        echo $row1c["count(Distinct Dealer)"];
?></td>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "><?php
        echo $rowc["count(DISTINCT Dealer)"];
?></td>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "></td>
</tr>

<tr>
  <th bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; ">No of Discontinue Dealers </th>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "><?php
        echo $countlyi;
?></td>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "><?php
        echo $counti;
?></td>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "></td>
</tr>


<tr>
  <th bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; ">Total Dealers </th>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "><?php
        echo $countlyi + $row1c["count(Distinct Dealer)"];
?></td>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "><?php
        echo $counti + $rowc["count(DISTINCT Dealer)"];
?></td>
  <td bgcolor="#9ab1d6" style=" border: 0.5pt solid #000000; "></td>
</tr>
<tr></tr>
<tr>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">No of Dealers ></th>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">2017-18</th>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">2018-19</th>
  </tr>
  <tr>
    <th bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; ">Less then 100000</th>
    <td bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; "><?php
        echo $p1;
?></td>
    <td bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; "><?php
        echo $c1;
?></td>
  </tr>
  <tr>
    <th bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; ">1L-5L</th>
    <td bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; "><?php
        echo $p;
?></td>
    <td bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; "><?php
        echo $c;
?></td>
  </tr>
  <tr>
    <th bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; ">5L-10L</th>
    <td bgcolor="#7cbaad"><?php
        echo $p2;
?></td>
    <td bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; "><?php
        echo $c2;
?></td>
  </tr>
  <tr>
    <th bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; ">10L and Above</th>
    <td bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; "><?php
        echo $p3;
?></td>
    <td bgcolor="#7cbaad" style=" border: 0.5pt solid #000000; "><?php
        echo $c3;
?></td>
  </tr>
  <tr></tr>
  <tr>
    <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">Top 5 Dealers</th>
    <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">2017-18</th>
    <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; "></th>
    <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">2018-19</th>
    

  </tr>
   <?php
        for ($i = 0; $i < 5; $i++) {
?>
   <tr >
      <td bgcolor="#aca9ce" style=" border: 0.5pt solid #000000; "><?php
            echo $tpd1[$i];
?></td>
    <td bgcolor="#aca9ce" style=" border: 0.5pt solid #000000; "><?php
            echo $tpa1[$i];
?></td>
    <td bgcolor="#aca9ce" style=" border: 0.5pt solid #000000; "><?php
            echo $tpd[$i];
?></td>
    <td bgcolor="#aca9ce" style=" border: 0.5pt solid #000000; "><?php
            echo $tpa[$i];
?></td>
    
  </tr>
  <?php } ?>
  <tr></tr>
<tr>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">Executive Name</th>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">Category</th>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">17-18</th>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">18-19</th>
  <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">% of Progress</th>
</tr>
<?php // executive SELECT distinct Executive,ASM,SM,ZM, sum(Amount) from sales where Zone='Karnataka Central' group by Executive
$exe=array();
$exem=array();
$exep=array();
$exemp=array();
$ASM=array();
$ASMm=array();
$ASMp=array();
$ASMmp=array();
$SMp=array();
$SMmp=array();
$SM=array();
$SMm=array();
$ZMp=array();
$ZMmp=array();
$ZM=array();
$ZMm=array();
$seg=array();
$segm=array();
$segp=array();
$segmp=array();
   $sqle   = " SELECT distinct Executive, sum(Amount) from sales where Zone='$state' ".$queryCondition." group by Executive ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
         //echo $sqle;
        $resulte = mysqli_query($conn, $sqle);
        while ($rowe = mysqli_fetch_array($resulte)) { 
          $exe[]=$rowe["Executive"];
          $exem[]=$rowe["sum(Amount)"];
        }

        //last year exce sales
        $sqlep   = " SELECT distinct Executive, sum(Amount) from Salesmaster where Zone='$state' ".$queryCondition1." group by Executive ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
         //echo $sqle;
        $resultep = mysqli_query($conn, $sqlep);
        while ($rowep = mysqli_fetch_array($resultep)) { 
          $exep[]=$rowep["Executive"];
          $exemp[]=$rowep["sum(Amount)"];
        }
        //print_r( $exep);
        //ASM
        $sqla   = " SELECT distinct ASM, sum(Amount) from sales where Zone='$state' ".$queryCondition." group by ASM ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resulta = mysqli_query($conn, $sqla);
        while ($rowa = mysqli_fetch_array($resulta)) {
          $ASM[]=$rowa["ASM"];
          $ASMm[]=$rowa["sum(Amount)"];
        }

        //ASM last year
        $sqla   = " SELECT distinct ASM, sum(Amount) from Salesmaster where Zone='$state' ".$queryCondition1." group by ASM ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
         //echo $sqla;
        $resulta = mysqli_query($conn, $sqla);
        while ($rowa = mysqli_fetch_array($resulta)) { 
          $ASMp[]=$rowa["ASM"];
          $ASMmp[]=$rowa["sum(Amount)"];
        }



        //SM
        $sqlsm   = " SELECT distinct SM, sum(Amount) from sales where Zone='$state' ".$queryCondition." group by SM ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultsm = mysqli_query($conn, $sqlsm);
        while ($rowsm = mysqli_fetch_array($resultsm)) {
          $SM[]=$rowsm["SM"];
          $SMm[]=$rowsm["sum(Amount)"];
        }

        //SM last year
       $sqlsmp   = " SELECT distinct SM, sum(Amount) from Salesmaster where Zone='$state' ".$queryCondition1." group by SM ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultsmp = mysqli_query($conn, $sqlsmp);
        while ($rowsmp = mysqli_fetch_array($resultsmp)) {
          $SMp[]=$rowsmp["SM"];
          $SMmp[]=$rowsmp["sum(Amount)"];
        }

        //ZM
        $sqlzm   = " SELECT distinct ZM, sum(Amount) from sales where Zone='$state' ".$queryCondition." group by ZM ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultzm = mysqli_query($conn, $sqlzm);
        while ($rowzm = mysqli_fetch_array($resultzm)) {
          $ZM[]=$rowzm["ZM"];
          $ZMm[]=$rowzm["sum(Amount)"];
        }

        //ZM last year
        $sqlzmp   = " SELECT distinct ZM, sum(Amount) from Salesmaster where Zone='$state' ".$queryCondition1." group by ZM ";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqldelyi;
        $resultzmp = mysqli_query($conn, $sqlzmp);
        while ($rowzmp = mysqli_fetch_array($resultzmp)) {
          $ZMp[]=$rowzmp["ZM"];
          $ZMmp[]=$rowzmp["sum(Amount)"];
        }

        //segment wise details
         $sqlseg1   = " SELECT distinct supersegment from sales where supersegment !='' and supersegment!='0' order by supersegment DESC";
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
         //echo $sqlseg;
        $resultseg1 = mysqli_query($conn, $sqlseg1);
        while ($rowseg1 = mysqli_fetch_array($resultseg1)) {
          $m=$rowseg1["supersegment"];

        $sqlseg   = " SELECT  sum(QTY) from sales where Zone='$state' AND supersegment='$m' ".$queryCondition;
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
         //echo $sqlseg;
        $resultseg = mysqli_query($conn, $sqlseg);
        while ($rowseg = mysqli_fetch_array($resultseg)) {
        
          $seg[]=$m;
          $segm[]=$rowseg["sum(QTY)"];
        }
         $sqlsegp   = " SELECT  sum(QTY) from Salesmaster where Zone='$state' AND supersegment='$m' ".$queryCondition1;
        //$sqld = "SELECT DISTINCT (D_distict) D_distict, D_state FROM Dealermst";
        // echo $sqlsegp;
        $resultsegp = mysqli_query($conn, $sqlsegp);
        while ($rowsegp = mysqli_fetch_array($resultsegp)) {
          
          $segmp[]=$rowsegp["sum(QTY)"];
        }}
       // print_r($exe);
        for($i=0;$i<count($exe);$i++){
        ?>
        <tr>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $exe[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "> Executive </td>
           <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $exemp[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $exem[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo round((($exem[$i]/$exemp[$i])-1)*100);?></td>
        </tr>
        <?php }
        for($i=0;$i<count($ASM);$i++){
        ?>
        <tr>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $ASM[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "> ASM </td>
           <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $ASMmp[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $ASMm[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo round((($ASMm[$i]/$ASMmp[$i])-1)*100);?></td>
        </tr>
        <?php }
        for($i=0;$i<count($SM);$i++){
        ?>
        <tr>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $SM[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "> SM </td>
           <td bgcolor="#c6c6c6 " style=" border: 0.5pt solid #000000; "><?php echo $SMmp[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $SMm[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo round((($SMm[$i]/$SMmp[$i])-1)*100);?></td>
        </tr>
        <?php }
        for($i=0;$i<count($ZM);$i++){
        ?>
        <tr>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $ZM[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "> ZM </td>
           <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $ZMmp[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo $ZMm[$i];?></td>
          <td bgcolor="#c6c6c6" style=" border: 0.5pt solid #000000; "><?php echo round((($ZMm[$i]/$ZMmp[$i])-1)*100);?></td>
        </tr>
        <?php }?>
        <tr></tr>
        <tr>
          <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">Super segment</th>
          <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">17-18 QTY</th>
          <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; ">18-19 QTY</th>
          <th bgcolor="#a9c1e8" style=" border: 0.5pt solid #000000; "> % of Progress</th>
        </tr>
        <?php for($i=0;$i<count($seg);$i++){
          if($seg[$i] !='' || $seg[$i] !='0'){
          ?>
        <tr>
          <td bgclor="#a8a1a7" style=" border: 0.5pt solid #000000; "><?php echo $seg[$i];?></td>
          <td bgclor="#a8a1a7" style=" border: 0.5pt solid #000000; "><?php echo $e= $segmp[$i];?></td>
          <td bgclor="#a8a1a7" style=" border: 0.5pt solid #000000; "><?php echo $f= $segm[$i];?></td>
          <td bgclor="#a8a1a7" style=" border: 0.5pt solid #000000; "><?php if($e==''){ echo '0';}elseif($e=='0'){echo '0';}else{ echo round((($f/$e)-1)*100);}?></td>
        </tr>
        <?php } }?>
</table>
  <input type="button" onclick="tableToExcel('testTable', '<?php echo $state; ?>')" value="Export to Excel">
  
</div>

<?php
    }
}