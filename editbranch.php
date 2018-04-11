<?php
include 'config/db.php';
include 'header.php';

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
$id=$_REQUEST[rowid];
$sql = "SELECT * from Branch_mst where B_id=$id ";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)) {
    ?>
    <fieldset style="margin-left:30% ;width:50%">
    <legend>Update/Edit Branch details</legend>
    <div style="margin-left:30% ;width:50%">
    <form name="frmSearch" method="post" action="editbranch.php?&rowid=<?php echo$id;?>">
    <lable> Branch Name</lable><br>
    <input type="text" placeholder="From Date" style="margin-left:2%;" id="post_at" name="Branch_name"  value="<?php echo $row[B_name]; ?>" class="input-control" /><br><br>
	 <lable> Branch state</lable><br>   
	 <input type="text" placeholder="To Date" id="post_at_to_date" name="state" style="margin-left:10px"  value="<?php echo $row[B_state]; ?>" class="input-control"  /><br><br>		
	 <lable> Branch Distict</lable><br>    
	 <input type="text" placeholder="To Date" id="post_at_to_date" name="distict" style="margin-left:10px"  value="<?php echo $row[B_distict]; ?>" class="input-control"  /><br><br>		 
		<input type="submit" name="go" value="Update" style="font-size:10pt;color:white;background-color:green;border:2px solid #336600;padding:8px" ><br>
    </form>
    </div>
    </fieldset>
    <?php 
}

if(isset($_POST["go"])){
    $sql = "UPDATE branch_mst SET B_name='$_POST[Branch_name]',B_State='$_POST[state]',B_distict='$_POST[distict]' WHERE B_id=$id";
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