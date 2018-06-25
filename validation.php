<?php
   include 'config/db.php';
   include 'header2.php';
   
                //It wiil insert a row to our subject table from our csv file`
                 $sql = "UPDATE sales
INNER
  JOIN Excutivemst
    ON sales.District = Excutivemst.District 
   SET sales.Executive = Excutivemst.Exexutive,sales.EID = Excutivemst.EID,sales.ASM = Excutivemst.ASM,sales.AID = Excutivemst.AID,sales.SM = Excutivemst.SM,sales.SID = Excutivemst.SID,sales.ZM = Excutivemst.ZM,sales.ZID = Excutivemst.ZID
   ";
                 //we are using mysql_query function. it returns a resource on true else False on error
                 //echo "Error: " . $sql . "<br>" . $conn->error;
                 
                 
   
   $sub='0';
   
   $sql = "SELECT sum(Amount) from Salesmaster where Date between '2018-01-01' and '2018-03-31' ";
   $result = mysqli_query($conn,$sql);
   $row = mysqli_fetch_array($result); {   
    ?>
<div class="main-panel">
<div class="content-wrapper">
<div class ="row">
<div class="col-6" >
   <h2>Validation</h2>
   <div class="col-12 stretch-card">
      <div class="card">
         <div class="card-body">
            <form name="frmSearch" method="post" action="" class="forms-sample">
               <div class="form-group row">
                  <div class="col-sm-9">
                     <select name="month" id="month">
                        <option value="">Select Month</option>
                     </select>
                     <input type="submit" name="go" value="Validate Dealer" class="btn btn-success mr-2" >
                  </div>
               </div>
            </form>
         </div>
      </div>
       <div class="card">
         <div class="card-body">
            <form name="frmSearch" method="post" action="" class="forms-sample">
               <div class="form-group row">
                  <div class="col-sm-9">
                     <select name="month1" id="month1">
                        <option value="">Select Month</option>
                     </select>
                     <input type="submit" name="go1" value="Validate SKU" class="btn btn-success mr-2" >
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php }
   ?>
<script>
   var d = new Date();
   var monthArray = new Array();
   monthArray[3] = "Jan-Mar-Q4";
   monthArray[0] = "April-Jun-Q1";
   monthArray[1] = "July-Sept-Q2";
   monthArray[2] = "Oct-Dec-Q3";
   
   for(m = 0; m <= 3; m++) {
       var optn = document.createElement("OPTION");
       optn.text = monthArray[m];
       // server side month start from one
       optn.value = (m+1);
    
       // if june selected
       
    
       document.getElementById('month').options.add(optn);
   }
</script>
<script>
   var d = new Date();
   var monthArray = new Array();
   monthArray[3] = "Jan-Mar-Q4";
   monthArray[0] = "April-Jun-Q1";
   monthArray[1] = "July-Sept-Q2";
   monthArray[2] = "Oct-Dec-Q3";
   
   for(m = 0; m <= 3; m++) {
       var optn = document.createElement("OPTION");
       optn.text = monthArray[m];
       // server side month start from one
       optn.value = (m+1);
    
       // if june selected
       
    
       document.getElementById('month1').options.add(optn);
   }
</script>
<?php 
   if(isset($_POST["go"])){
        $sql1="UPDATE sales
INNER
  JOIN Dealermst
    ON sales.Dealer = Dealermst.D_name
   SET sales.state = Dealermst.D_state,sales.District = Dealermst.D_distict";
       $year=$_POST["year"];
       $month=$_POST["month"]; 
       $AP=$_POST['tsales'];
       $BH=$_POST['credit'];
       $CH=$_POST['sub'];
       $DL=$_POST['nsales'];
       $GOA=$_POST['pince'];
       $GU=$_POST['inc'];
       $ecom=$_POST['ecom'];
       $exe=$_POST['exe'];
       $asm=$_POST['asm'];
       $sm=$_POST['sm'];
       $zm=$_POST['zm'];
    if($month=="1"){  $start='2018-04-01';$end='2018-06-30';}elseif($month=="2"){$start='2018-07-01';$end='2018-09-30';}elseif($month=='3'){$start='2018-10-01';$end='2018-12-31';}elseif($month=='4'){$start='2019-01-01';$end='2019-03-31';}
       $sql = "SELECT Distinct Dealer from sales where Date between '$start' and '$end' and district='' or state='' ";
    //echo $sql;
   $result = mysqli_query($conn,$sql);
  ?>
<div class="table-responsive">
<table  id="demo" class="table table-hover" >
   <tr>
      <th>Unmatched Dealers Q<?php echo ($month)?></th>
      
   </tr>
   <tr>
      <th>Unmatched Dealers</th>
      
   </tr>
   <?php  while($row = mysqli_fetch_array($result)){
   ?>
   <tr>
    <td><?php echo $Total=$row['Dealer'];?></td>
   </tr>
   <?php } ?>
</table>
<button onclick="exportTableToCSV('Unmatched Dealers.csv')">Export HTML Table To CSV File</button>

<?php }?>
<?php if(isset($_POST["go1"])){ 
  $sql3="UPDATE sales
INNER
  JOIN Itemmst
    ON sales.Product = Itemmst.Item_name
   SET sales.SKU = Itemmst.SKU,sales.SKU1 = Itemmst.SKU1";
  $sql2="UPDATE sales
INNER
  JOIN SKU       
    ON sales.SKU = SKU.SKU
   SET sales.seqment = SKU.segment";
   $sql4="UPDATE sales INNER JOIN supersegment ON sales.Seqment = supersegment.segment SET sales.supersegment = supersegment.supersegment";
       $year=$_POST["year"];
       $month=$_POST["month1"]; 
       $AP=$_POST['tsales'];
       $BH=$_POST['credit'];
       $CH=$_POST['sub'];
       $DL=$_POST['nsales'];
       $GOA=$_POST['pince'];
       $GU=$_POST['inc'];
       $ecom=$_POST['ecom'];
       $exe=$_POST['exe'];
       $asm=$_POST['asm'];
       $sm=$_POST['sm'];
       $zm=$_POST['zm'];
    if($month=="1"){  $start='2018-04-01';$end='2018-06-30';}elseif($month=="2"){$start='2018-07-01';$end='2018-09-30';}elseif($month=='3'){$start='2018-10-01';$end='2018-12-31';}elseif($month=='4'){$start='2019-01-01';$end='2019-03-31';}
       $sql = "SELECT Distinct Product from sales where Date between '$start' and '$end' and Product!='' and  SKU=''   ";
    //echo $sql;
   $result = mysqli_query($conn,$sql);
   
   ?>
<div class="table-responsive">
<table  id="demo" class="table table-hover" >
   <tr>
      <th>Unmatched Products Q<?php echo ($month)?></th>
      
   </tr>
   <tr>
      <th>Unmatched Products</th>
      
   </tr>
   <?php while($row = mysqli_fetch_array($result)){ ?>
   <tr>
    <td><?php echo $Total=$row['Product'];?></td>
   </tr>
   <?PHP }?>
   <button onclick="exportTableToCSV('Unmatched Products.csv')">Export HTML Table To CSV File</button>

</table>

<?php }?>
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
