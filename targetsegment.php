<?php ini_set('max_execution_time', 0);?>
<html>
   <body bgcolor="">
      <?php 
         include 'header2.php';
         include '/config/db.php';
         
         $sqld = "SELECT distinct segment FROM `targetmst` order by Segment asc";
               // echo $sqld;
          $result = mysqli_query($conn,$sqld);     
          //$rowd= mysqli_fetch_array($resultd);
         
         ?>
      <div class="main-panel">
      <div class="content-wrapper">
         <div class ="row">
            <div class="col-6" >
               <h1 style="text-align:center;"> target Segment wise</h1>
               
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
                        <th >Segment</th>
                        <th>Q1 Sales</th>
                          <th>Q2 Sales</th>
                            <th>Q3 Sales</th>
                              <th>Q4 Sales</th>
                                 <th>Q1 Target</th>
                          <th>Q2 Target</th>
                            <th>Q3 Target</th>
                              <th>Q4 Target</th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php 
                        while($row = mysqli_fetch_array($result)) {
                          $segment=$row["segment"];
                           $sql = "SELECT sum(QS1),sum(QS2),sum(QS3),sum(QS4),sum(QT1),sum(QT2),sum(QT3),sum(QT4) FROM `targetmst` where segment='$segment'";
               // echo $sqld;
          $resultt = mysqli_query($conn,$sql);     
                         ?> <tr> <?php
                        while($rowt = mysqli_fetch_array($resultt)) {   ?>
                    
                    <td><?php echo $segment;?></td>
                       <td><?php echo $rowt['sum(QS1)'];?></td>
                        <td><?php echo $rowt['sum(QS2)'];?></td>
                          <td><?php echo $rowt['sum(QS3)'];?></td>
                             <td><?php echo $rowt['sum(QS4)'];?></td>
                              <td><?php echo $rowt['sum(QT1)'];?></td>
                                <td><?php echo $rowt['sum(QT2)'];?></td>
                                  <td><?php echo $rowt['sum(QT3)'];?></td>
                                    <td><?php echo $rowt['sum(QT4)'];?></td>
                  <?php }?>
                  </tr>
                  <?php }?>
                  <tbody>
               </table>
               <input type="button" onclick="tableToExcel('testTable', 'Target')" value="Export to Excel">
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
