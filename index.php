<?php	
date_default_timezone_set('Asia/Calcutta');
@session_start();

$id=0;
include("api/main.php");
$msg="";
$branchWithCompanyName = $userObj->getBranchWithCompanyName($mysqli);
/* Log In Start  */

if(isset($_POST['lusername'])) {  

	$username  = $_POST['lusername'];
	$password  =  $_POST['lpassword'];
	$branch_id  =  $_POST['branch_id'];

	if($_POST['lusername'] != '') {
		
		$qry     = "SELECT * FROM user WHERE user_name = '".$username."' AND user_password = '".$password."' AND branch_id = '".$branch_id."' AND status=0";  
		$res = mysqli_query($mysqli, $qry)or die("Error in Get All Records".mysqli_error()); 
		$result = mysqli_fetch_array($res);
		if ($mysqli->affected_rows>0)
		{  
			$_SESSION['branch_id']   = $branch_id; 
			$_SESSION['username']    = $result['user_name']; 
			$_SESSION['userid']      = $result['user_id']; 
			$_SESSION['fullname']    = $result['fullname']; 
			$_SESSION['staffid']     = $result['staff_id']; 
			?>
			<script>location.href='<?php echo $HOSTPATH; ?>dashboard';</script>  
			<?php
		}
		else
		{ 
			$msg="Enter Valid Email Id and Password";
		} 
	} 
}
?>

<?php include("include/common/accounthead.php"); ?>

<form id="loginform" name="loginform" action="" method="post">
	<div class="row justify-content-md-center">
		<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
			<div class="login-screen">
				<div class="login-box">
					<a href="#" class="login-logo">
						<h4 style="color: #5090c0; padding-left: 50px;">AS MOTORS SOFTWARE</h4>
					</a>
					<span class="text-danger" id="cinnocheck">		 
						<?php
						if($msg != '')
						{
							echo $msg;
						}
						?>
					</span>
					<h5>Welcome back,<br />Please Login to your Account.</h5>
					<div class="form-group mt-4">
						<input type="text" name="lusername" id="lusername"  tabindex="1"  class="form-control" value="support@feathertechnology.in" placeholder="Enter Email" />
						<span id="usernamecheck" class="text-danger">Enter Email</span>    
					</div>
					<div class="form-group mt-4">
						<input type="password" name="lpassword" id="lpassword"  tabindex="2"  class="form-control" value="admin@123" placeholder="Enter Password" />
						<span id="passwordcheck" class="text-danger">Enter Password</span>    
					</div>		
					<div class="form-group mt-4">                    
						<select type="text" class="form-control" tabindex="3" id="branch_id" name="branch_id">
							<option value="">Select Type</option>                                                    
							<option value="Overall">Overall</option> 
							<!-- <option value="Admin">Admin</option> -->
								<?php if (sizeof($branchWithCompanyName)>0) { 
								for($j=0;$j<count($branchWithCompanyName);$j++) { ?>
								<option <?php if(isset($branch_id)) { if($branchWithCompanyName[$j]['branch_id'] == $branch_id)  echo 'selected'; }  ?> value="<?php echo $branchWithCompanyName[$j]['branch_id']; ?>">
								<?php echo $branchWithCompanyName[$j]['branch_name'].' (Branch)'. ' - '.$branchWithCompanyName[$j]['company_name'].' (Company)'; ?></option>
								<?php }} ?>  
						</select>
						<span id="companycheck" class="text-danger">Select Type</span>       
					</div>
					<div class="actions" style="margin-top: 80px;">
						<button type="submit"  id="lbutton"  tabindex="6" name="lbutton" class="form-control btn btn-primary" >Login</button>
					</div>
					
					<hr>

				</div>
			</div>
		</div>
	</div>
</form>
<?php $current_page = isset($_GET['page']) ? $_GET['page'] : null; ?>
	
<?php include("include/common/dashboardfooter.php"); ?>
		