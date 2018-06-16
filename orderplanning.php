<?php ini_set('max_execution_time', 0);?>
<html>
   <body bgcolor="">
      <?php 
         include 'header2.php';
         include '/config/db.php';
         
         $sqld = "SELECT *
FROM ordermst
JOIN Supplier_master 
ON ordermst.SKU = Supplier_master.SKU order by Supplier_master.Supplier_name,Supplier_master.SKU ASC ";
               // echo $sqld;
          $result = mysqli_query($conn,$sqld);     
          //$rowd= mysqli_fetch_array($resultd);
         
         ?>
      <div class="main-panel">
      <div class="content-wrapper">
         <div class ="row">
            <div class="col-6" >
               <h1 style="text-align:center;"> Order Planning </h1>
               
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
              <div class="table-responsive">
               <table class="table table-border">
                  <thead>
                     <tr >
                        <th ><span>Supplier Name</span></th>
                        <th ><span>SKU</span></th>
                        <th ><span>APR-QTY</span></th>
                        <th ><span>APR-Rate</span></th>
                        <th ><span>APR-Value</span></th>
                          <th ><span>MAY-QTY</span></th>
                        <th ><span>MAY-Rate</span></th>
                        <th ><span>MAY-Value</span></th>
                          <th ><span>JUN-QTY</span></th>
                        <th ><span>JUN-Rate</span></th>
                        <th ><span>JUN-Value</span></th>
                          <th ><span>JULY-QTY</span></th>
                        <th ><span>JULY-Rate</span></th>
                        <th ><span>JULY-Value</span></th>
                          <th ><span>AUG-QTY</span></th>
                        <th ><span>AUG-Rate</span></th>
                        <th ><span>AUG-Value</span></th>
                          <th ><span>SEP-QTY</span></th>
                        <th ><span>SEP-Rate</span></th>
                        <th ><span>SEP-Value</span></th>
                          <th ><span>OCT-QTY</span></th>
                        <th ><span>OCT-Rate</span></th>
                        <th ><span>OCT-Value</span></th>
                          <th ><span>NOV-QTY</span></th>
                        <th ><span>NOV-Rate</span></th>
                        <th ><span>NOV-Value</span></th>
                          <th ><span>DEC-QTY</span></th>
                        <th ><span>DEC-Rate</span></th>
                        <th ><span>DEC-Value</span></th>
                          <th ><span>JAN-QTY</span></th>
                        <th ><span>JAN-Rate</span></th>
                        <th ><span>JAN-Value</span></th>
                          <th ><span>FEB-QTY</span></th>
                        <th ><span>FEB-Rate</span></th>
                        <th ><span>FEB-Value</span></th>
                          <th ><span>MAR-QTY</span></th>
                        <th ><span>MAR-Rate</span></th>
                        <th ><span>MAR-Value</span></th>
                        <th ><span>Year</span></th>
                          
                     </tr>
                  </thead>
                  <tbody>
                    <?php 
                        while($row = mysqli_fetch_array($result)) {
                          $price=$row["price"];
                          $res = preg_replace('/[^0-9-.]/','',$price);
                          $del=$row["Supplier_name"];
                          $dealer=preg_replace('/,/' , '', $del);
                          ?>
                    <tr>
                    <td><?php echo $dealer;?></td>
                    <td><?php echo $row["SKU"];?></td>
                    <td><?php echo $row["july"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["july"]);?></td>
                    <td><?php echo $row["agust"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["agust"]);?></td>
                    <td><?php echo $row["sep"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["sep"]);?></td>
                    <td><?php echo $row["oct"];?></td>
                     <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["oct"]);?></td>
                    <td><?php echo $row["nov"];?></td>
                     <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["nov"]);?></td>
                    <td><?php echo $row["dec"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["dec"]);?></td>
                    <td><?php echo $row["jan"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["jan"]);?></td>
                    <td><?php echo $row["feb"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["feb"]);?></td>
                    <td><?php echo $row["mar"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["mar"]);?></td>
                    <td><?php echo $row["april"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["april"]);?></td>
                    <td><?php echo $row["may"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["may"]);?></td>
                    <td><?php echo $row["june"];?></td>
                    <td><?php echo $res;?></td>
                    <td><?php echo ($res*$row["june"]);?></td>
                    <td><?php echo $row["year"];?></td>
                  </tr>
                  <?php }?>
                  <tbody>
               </table>
               <button onclick="exportTableToCSV('Order_planning.csv')">Export HTML Table To CSV File</button>
             </div>
            </div>
         </div>
      </div>
   </body>
</html>

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
