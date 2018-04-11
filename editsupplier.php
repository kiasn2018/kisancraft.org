<?php
include 'config/db.php';
include 'header.php';
$id=$_REQUEST[rowid];
?>
 <head>
    <style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
input[type=password], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>
    </head>
<?php
$sql = "SELECT * from purches_mst where ID=$id ";
$result = mysqli_query($conn,$sql);
//print_r($result);
while($row = mysqli_fetch_array($result)) {
    ?>
    <fieldset style="margin-left:30% ;width:50%">
    <legend>Update/Edit Product details</legend>
    <div style="margin-left:30% ;width:50%">
    <form name="frmSearch" method="post" action="editproduct.php?&rowid=<?php echo $id;?>">
    <lable> Supplier Name</lable><br>
    <input type="text" placeholder="From Date" style="margin-left:2%;" id="post_at" name="Supplier"  value="<?php echo $row[Supplier]; ?>" class="input-control" /><br><br>
	 <lable> Product Name</lable><br>   
	 <input type="text" placeholder="To Date" id="post_at_to_date" name="Name" style="margin-left:10px"  value="<?php echo $row[Item_name]; ?>" class="input-control"  /><br><br>		
	 <lable> QTY</lable><br>    
	 <input type="text" placeholder="To Date" id="post_at_to_date" name="QTY" style="margin-left:10px"  value="<?php echo $row[Quantity]; ?>" class="input-control"  /><br><br>	
	 <lable> Rate</lable><br>  
	 <input type="text" placeholder="To Date" id="post_at_to_date" name="Rate" style="margin-left:10px"  value="<?php echo $row[Rate]; ?>" class="input-control"  /><br><br>
	 <lable> Value</lable><br>  
	 <input type="text" placeholder="To Date" id="post_at_to_date" name="Value" style="margin-left:10px"  value="<?php echo $row[Value]; ?>" class="input-control"  /><br><br>			 
		<input type="submit" name="go" value="Update" style="font-size:10pt;color:white;background-color:green;border:2px solid #336600;padding:8px" ><br>
    </form>
    </div>
    </fieldset>
    <?php 
}

if(isset($_POST["go"])){
    $sql = "UPDATE purches_mst SET Supplier='$_POST[Supplier]',Item_name='$_POST[Name]',Quantity='$_POST[QTY]',Rate='$_POST[Rate]',Value='$_POST[Value]' WHERE ID=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script type=\"text/javascript\">
						alert(\"Updated Succesfully.\");
						window.location = \"\"
					</script>";
        
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    //echo $sql;
    //print_r($_POST);
}