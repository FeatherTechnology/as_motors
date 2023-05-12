<?php 
$id=0;
if(isset($_POST['submitcustomer']))
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updatecustomer = $userObj->updatecustomer($mysqli, $id);  
        ?>
        <script>location.href='<?php echo $HOSTPATH;  ?>editcustomer&msc=2';</script> 
    <?php }
    else{
        $addcustomer = $userObj->addcustomer($mysqli);   
        ?>
        <script>location.href='<?php echo $HOSTPATH;  ?>editcustomer&msc=1';</script> 
        <?php
    }
}  
 
$del=0;
if(isset($_GET['del']))
{
    $del=$_GET['del'];
}
if($del>0)
{
	$deletecustomer = $userObj->deletecustomer($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH;  ?>editcustomer&msc=3';</script>
    <?php	
}

$cancel_upd=0;
if(isset($_GET['cancel_upd']))
{
    $cancel_upd=$_GET['cancel_upd'];
}
if($cancel_upd>0)
{
	$cancel_updetecustomer = $userObj->cancel_updetecustomer($mysqli,$cancel_upd); 
	?>
	<script>location.href='<?php echo $HOSTPATH;  ?>editcustomer&msc=2';</script>
    <?php	
}

if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getcustomer = $userObj->getcustomer($mysqli,$idupd); 
	
	if (sizeof($getcustomer)>0) {
        for($icustomer=0;$icustomer<sizeof($getcustomer);$icustomer++)  {

            $customer_id            = $getcustomer['customer_id'];
            $customer_sno           = $getcustomer['customer_sno'];
            $vendor_name            = $getcustomer['vendor_name'];
            $pbl_no                 = $getcustomer['pbl_no'];
            $customer_name          = $getcustomer['customer_name'];
            $alias_name             = $getcustomer['alias_name'];
            $flat_no                = $getcustomer['flat_no'];
            $street                 = $getcustomer['street'];
            $line_1                 = $getcustomer['line_1'];
            $line_2                 = $getcustomer['line_2'];
            $city                   = $getcustomer['city'];
            $state                  = $getcustomer['state'];
            $pincode                = $getcustomer['pincode'];
            $contact_no             = $getcustomer['contact_no'];

            $sno                   = $getcustomer['sno'];
            $customer_ref_id       = $getcustomer['customer_ref_id'];
            $item_name             = $getcustomer['item_name']; 
            $bill_no               = $getcustomer['bill_no'];
            $system_no             = $getcustomer['system_no'];
            $serial_no             = $getcustomer['serial_no']; 
            $gross_weight          = $getcustomer['gross_weight'];
            $net_weight            = $getcustomer['net_weight'];
            $loan_date             = $getcustomer['loan_date'];
            $value_of_garment      = $getcustomer['loan_amount'];
            $has_on_date_value     = $getcustomer['has_on_date_value'];
            $status                = $getcustomer['status'];
		}
	}
} 

if(isset($_GET['rem']))
{
    $idrem=$_GET['rem'];
}

if($idrem > 0){	
    $removecustomer = $userObj->removecustomer($mysqli, $idrem);  
    ?>
    <script>location.href='<?php echo $HOSTPATH;  ?>editcustomer&msc=2';</script> 
    <?php
}


?>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">GSM - Manage Users</li>
    </ol>

    <a href="editcustomer">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
	<!-- Row start -->
	<form action="" method="post" name="vendorcreation" id="vendorcreation" >
		<div class="row gutters">
		<!-- General Info -->
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
                    <div class="card-header">
                        <!-- <div class="card-header">General Info</div> -->
					</div>
                    <input type="hidden" name="id" id="id" class="form-control" value="<?php if(isset($customer_id)) echo $customer_id; ?>">
					<div class="card-body row">
						<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<label class="label">First Name<span class="required">*</span></label>
                                <input type="text" tabindex="1" name="first_name" id="first_name" class="form-control" placeholder="Enter Applicant Name" value="<?php if(isset($first_name)) echo $first_name; ?>">
                            </div>
						</div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="disabledInput">Last Name<span class="required">*</span></label>
                                <input type="text" tabindex="2" id="last_name" name="last_name" class="form-control"  value="<?php if(isset($last_name)) echo $last_name; ?>" placeholder="Enter Address 1">
                                <!-- <span id="employeenamecheck" class="text-danger" >Enter Employee Name</span> -->
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="disabledInput">Full Name<span class="required">*</span></label>
                                <input type="text" readonly tabindex="3" id="full_name" name="full_name" class="form-control"  value="<?php if(isset($full_name)) echo $full_name; ?>" placeholder="Enter Address 2">
                                <!-- <span id="employeenamecheck" class="text-danger" >Enter Employee Name</span> -->
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="disabledInput">Title</label>
                                <input type="text" tabindex="4" id="title" name="title" class="form-control"  value="<?php if(isset($title)) echo $title; ?>" placeholder="Enter Address 3">
                                <!-- <span id="employeenamecheck" class="text-danger" >Enter Employee Name</span> -->
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for=""> Password<span class="required">*</span></label>
                                <input type="password" tabindex="5" class="form-control" placeholder="Enter Password" id="password" value="<?php if($idupd > 0){  if(isset($password)) echo $password; } ?>" name="password">
                                <span id="passwordcheck" class="text-danger">Enter Password</span>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input type="password" tabindex="6" class="form-control" placeholder="Enter Password" id="confirm_password" value="<?php if($idupd > 0){  if(isset($confirm_password)) echo $confirm_password; } ?>" name="confirm_password">
                                <!-- <span id="passwordcheck" class="text-danger">Enter Password</span> -->
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="inputReadOnly">E-Mail Id<span class="required">*</span></label>
                                <input type="text" class="form-control" tabindex="7" id="email_id" name="email_id" value="<?php if(isset($email_id)) echo $email_id; ?>" placeholder="Enter Email Id">
                                <!-- <span class="text-danger" id="emailidcheck">Enter Valid E-mail Id</span> -->
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for=""> User Name<span class="required">*</span></label>
                                <input type="text" tabindex="8" class="form-control" placeholder="Enter User Name" value="<?php if($idupd > 0){  if(isset($user_name)) echo $user_name; } ?>" id="user_name" name="user_name">
                                <!-- <span id="usernamecheck" class="text-danger">Enter Username</span> -->
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="col-sm-9">
                                        <label for="disabledInput">Role<span class="required">*</span></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 adminrolehide">
                                        <input type="checkbox" tabindex="9" id="cheStaffLogin" name="cheStaffLogin" class="ace ace-checkbox-2 checkbox checkHeader" />
                                        <label class="lbl" for="cheStaffLogin"> Staff Login</label>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <input type="checkbox" tabindex="10" id="cheStudentLogin" name="cheStudentLogin" class="ace ace-checkbox-2 checkbox checkHeader" />
                                        <label class="lbl" for="cheStudentLogin"> Student Login</label>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
 
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex d-flex">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 adminrolehide">
                                        <input type="checkbox" tabindex="11" id="cheSystemAdministrator" name="cheSystemAdministrator" class="ace ace-checkbox-2 checkbox checkHeader" />
                                        <label class="lbl" for="cheSystemAdministrator"> SystemAdministrator</label>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <input type="checkbox" tabindex="12" id="cheUser" name="cheUser" class="ace ace-checkbox-2 checkbox checkHeader" />
                                        <label class="lbl" for="cheUser"> User Login</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                            <div class="text-right">
                                <div>
                                    <button type="submit"  tabindex="13" name="submitcustomer" id="submitcustomer"  class="btn btn-primary">Submit</button>&nbsp;&nbsp;&nbsp;
                                    <button type="reset"  tabindex="14" class="btn btn-outline-secondary">Cancel</button> 
                                </div> <br><br>
                            </div>
                        </div>
				    </div>
			    </div>

		</div>
	</form>
</div>