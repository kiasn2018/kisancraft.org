<!DOCTYPE html>
<?php
include '/config/db.php';
//include '../header.php';
// select datebase and display
	$post_at1 = "";
	$post_at_to_date1 = "";
	
	$queryCondition1 = "";
	if(!empty($_POST["search"]["IName"])) {			
		$post_at1 = $_POST["search"]["IName"];
		$sql1 = "SELECT * from purches_mst WHERE Item_name='$post_at1' ORDER BY Date desc";
		$result1 = mysqli_query($conn,$sql1);
		//print_r($result1);
	}
?>

<html lang="en">
<head>
<meta charset="UTF-8">
<title></title>
<style type="text/css">
    body{
        font-family: Arail, sans-serif;
    }
    /* Formatting search box */
    .search-box{
        width: 200px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
        color:white;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
        color:Black;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
        background: white;
    }
    .result p:hover{
        background: #f2f2f2;
    }
</style>

<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>
</head>
<body>

    <?php 
    
    
    if(!empty($result1))	 { ?>
    <h2>Search By Name</h2>
<table class="sortable" >
          <thead>
        <tr>
                      
          <th width="20%"><span>Date</span></th>
          <th width="40%"><span>Supplier</span></th>          
          <th width="50%"><span>Item Name</span></th>
          <th width="20%"><span>QTY</span></th>
          <th width="30%"><span>Rate</span></th>
          <th width="20%"><span>Value</span></th>
          <th width="10%"><span>Landed cost</span></th>	 
          <th width="10%"><span>View</span></th>	 
           
        </tr>
      </thead>
    <tbody>
	<?php
		while($row = mysqli_fetch_array($result1)) {
	?>
        <tr>
			<td><?php echo $row["Date"]; ?></td>
			<td><?php echo $row["Supplier"]; ?></td>
			<td><?php echo $row["Item_name"]; ?></td>
			<td><?php echo $row["Quantity"]; ?></td>
			<td><?php echo $row["Rate"]; ?></td>
			<td><?php echo $row["Value"]; ?></td>
			<td><?php echo $row["Londedcost_unit"]; ?></td>
			<td><a href="/kisankraft.org/editproduct.php?&rowid=<?php echo $row["ID"]?>" target="blank">View</a> </td>

		</tr>
   <?php
		}
   ?>
   <tbody>
  </table>
<?php } ?>
    <br><br><br>
</body>
</html>