<?php 
// Start the session
session_start();

if($_SESSION['role']==''){ 
    echo "<script type=\"text/javascript\">
						alert(\"Please Login to continue.\");
						window.location = \"login.php\"
					</script>";
}
?>

<html>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Kisankraft Analytics</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="./vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="./vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="./vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="./vendors/icheck/skins/all.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="./css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="./images/favicon.ico" />
</head>
<?php include("navbar.php");?>
<div class="container-fluid page-body-wrapper">
 <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="profile-image">
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Purchase Report</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="#">Item Wise</a></li>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/supplier.php">Supplier Wise</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/preportforall.php">Both</a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Ageing Analysis</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic1">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/aeging.php">Standerd</a></li>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/salesandstock.php">Sales and stock</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Quaterly</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Half Yearly</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Annually</a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Order Planning</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic2">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/uploadorder.php">Upload</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/orderplanning.php">Order Planning</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Projected</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Actual</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Both</a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Cash Flow</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic3">
              <ul class="nav flex-column sub-menu">
				<li class="nav-item">
                  <a class="nav-link" href="#">Projected</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Actual</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Both</a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic4" aria-expanded="false" aria-controls="ui-basic4">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Profitability</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic4">
              <ul class="nav flex-column sub-menu">
				<li class="nav-item">
                  <a class="nav-link" href="#">SKU wise</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Group wise</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Both</a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic5" aria-expanded="false" aria-controls="ui-basic5">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Target</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic5">
              <ul class="nav flex-column sub-menu">
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/targetstate.php">Target State wise</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Actual</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Both</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/targetstatem.php">Upload Target by state manager</a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic6" aria-expanded="false" aria-controls="ui-basic6">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Incentives</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic6">
              <ul class="nav flex-column sub-menu">
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/incentives.php">Incentives For Non-sales</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/incentivessales.php">Incentives for Sales</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/incentivescal.php">Incentives Calculation</a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="menu-icon mdi mdi-backup-restore"></i>
              <span class="menu-title">Quaterly Meeting</span>
            </a>
          </li>
		  
		  <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic7" aria-expanded="false" aria-controls="ui-basic7">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Master File Updation</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic7">
              <ul class="nav flex-column sub-menu">
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/branchmst.php">Branch Master</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/suppliermaster.php">Supplier Master</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Bank Master</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Accounts Head</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/executive.php">Executive Master</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/zonemaster.php">Zone Master</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/employee.php">Employee Master</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/statemst.php">State Master</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">State Employee Mapping</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Distict Master</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/itemid.php">Item Master</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/SKU.php">SKU Master</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/supersegment.php">Super Segment Master</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/dealermst.php">Dealer Master</a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="/kisancraft.org/stockmst.php">Stock Master</a></li>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="#">Trial Balance Master</a>
                </li>
              </ul>
            </div>
          </li>
		  
		  <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="menu-icon mdi mdi-restart"></i>
              <span class="menu-title">Sales Reports</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
				<a class="nav-link" href="/kisancraft.org/master.php">Sales master</a></li>
                <li class="nav-item"><a class="nav-link" href="/kisancraft.org/salesupload.php">Upload sales</a></li>
                <li class="nav-item"><a class="nav-link" href="/kisancraft.org/salesdailyreport.php">Sales Daily Report</a></li>
				 <li class="nav-item"><a class="nav-link" href="/kisancraft.org/monthlyreport.php">Monthly Report</a></li>
				 <li class="nav-item"><a class="nav-link" href="/kisancraft.org/monthlyreportcust.php">Monthly Report Customized</a></li>
				  <li class="nav-item"><a class="nav-link" href="/kisancraft.org/state_district_exe.php">Monthly Report State and District wise</a></li>
          <li class="nav-item"> <a class="nav-link" href="/kisancraft.org/monthlyreport_dealer.php">Monthly Report Dealer wise</a> </li>
				  <li class="nav-item"><a class="nav-link" href="/kisancraft.org/state_monthly.php">Monthly Only state wise</a></li>
				  <li class="nav-item"><a class="nav-link" href="/kisancraft.org/monthly report SKU Wise.php">Monthly Report SKU wise</a></li>
				 <li class="nav-item"><a class="nav-link" href="/kisancraft.org/monthlyreportdea.php">Monthly Report WRT Dealer</a></li>
                <li class="nav-item"><a class="nav-link" href="/kisancraft.org/salesemp.php">Sales WRT Employees</a></li><br>
                <li class="nav-item"><a class="nav-link" href="/kisancraft.org/saleswrtstate.php">Sales WRT State And District wise</a></li>
				<li class="nav-item"><a class="nav-link" href="/kisancraft.org/saleswrtzone.php">Sales WRT Zone wise</a></li>
                <li class="nav-item"><a class="nav-link" href="/kisancraft.org/Monthlyreportsku.php">Sales WRT SKU Wise</a></li>
                <li class="nav-item"><a class="nav-link" href="/kisancraft.org/saleswrtdea.php">Sales Quarter Wise</a></li>
				 <li class="nav-item"><a class="nav-link" href="/kisancraft.org/saleswrtdeal.php">Sales dealer wise</a></li>
				 <li class="nav-item"><a class="nav-link" href="/kisancraft.org/saleswrtmonth.php">Sales State-Month wise</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Target V/s Actual</a></li>
              </ul>
            </div>
          </li>
		  
         <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic8" aria-expanded="false" aria-controls="ui-basic8">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Trial Balance</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic8">
              <ul class="nav flex-column sub-menu">
				<li class="nav-item">
                  <a class="nav-link" href="#">Updation</a>
                </li>
              </ul>
            </div>
          </li>
		  
		  
		  
          
        </ul>
      </nav>
	 
	  
	   <script src="./vendors/js/vendor.bundle.base.js"></script>
  <script src="./vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="./js/off-canvas.js"></script>
  <script src="./js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
	  