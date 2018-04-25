<body bgcolor="">
<?php include 'header.php';?>
<div class="container" style="margin-left:30%; width:60%; background-color:lightblue">
<div class="row">
<div class="span3 hidden-phone"></div>
    <div class="span6" id="form-login">
		<form class="form-horizontal well" action="import.php" method="post" name="upload_excel" enctype="multipart/form-data">
		   <fieldset>
		     <legend>Import CSV/Excel file</legend>
			   <div class="control-group">
  			     <div class="control-label">
    		       <label>CSV/Excel File:</label>
   			     </div>
		         <div class="controls">
                   <input type="file" name="file" id="file" class="input-large">
			       <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
		         </div>
              </div>
<div class="control-group">
<div class="controls">
<a href="/kisankraft.org/sample/sample.csv"> Download Sample File</a>
</div>
</div>
</fieldset>  
</form>
</div>
</div>
</div>
<div>
</div>