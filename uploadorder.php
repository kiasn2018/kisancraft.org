<?php ini_set('max_execution_time', 0);?>
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
      <h1 style="text-align:center;"> Upload Order Target</h1>
      <div class="col-12 stretch-card">
         <div class="card">
            <div class="card-body">
               <form class="forms-sample" action="importorder.php" method="post" name="upload_excel" enctype="multipart/form-data">
                  <div class="form-group row">
                     <label for="exampleInputEmail2" class="col-sm-3 col-form-label">CSV File:</label>
                     <div class="col-sm-9">
                        <input type="file" name="file" id="file" class="input">
                        <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>