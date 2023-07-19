<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 

// $companyName = $userObj->getCompanyName($mysqli);

$id=0;
if(isset($_POST['submitfcinsurancerenew']) && $_POST['submitfcinsurancerenew'] != '')
{  
        $addVehicleDetails = $userObj->addfcinsurancerenew($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>dashboard&returnid=1';</script>
        <?php
}


if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];

$getFCInsuranceRenew = $userObj->getFCInsDetails($mysqli,$idupd);
if(count($getFCInsuranceRenew)>0){
    $fc_insurance_renew_id       = $getFCInsuranceRenew['fc_insurance_renew_id']; 
    $assign_staff_name       = $getFCInsuranceRenew['assign_staff_name']; 
    $assign_remark       = $getFCInsuranceRenew['assign_remark']; 
    $from_date    	             = date('Y-m-d',strtotime($getFCInsuranceRenew['from_date'])); 
	$to_date    	             = date('Y-m-d',strtotime($getFCInsuranceRenew['to_date'])); 
}
}
$status =0;
if($idupd>0)
{ 
	$getVehicleDetails = $userObj->getVehicleDetails($mysqli,$idupd); 
	if (sizeof($getVehicleDetails)>0) {
        for($itag=0;$itag<sizeof($getVehicleDetails);$itag++)  {
            $vehicle_details_id       = $getVehicleDetails['vehicle_details_id']; 
            $company_id              = $getVehicleDetails['company_id'];
			$vehicle_code        	 = $getVehicleDetails['vehicle_code'];
			$vehicle_type    	     = $getVehicleDetails['vehicle_type'];
			$vehicle_name    	     = $getVehicleDetails['vehicle_name'];
			$vehicle_number    	     = $getVehicleDetails['vehicle_number'];
			$date_of_purchase    	     = $getVehicleDetails['date_of_purchase'];
			$fitment_upto    	     = $getVehicleDetails['fitment_upto'];
			$insurance_upto    	     = $getVehicleDetails['insurance_upto'];
			$asset_value    	     = $getVehicleDetails['asset_value'];
			$book_value_as_on    	     = $getVehicleDetails['book_value_as_on'];
		}
	} 
    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    $cmpny_name = $sCompanyBranchDetailEdit['company_name'];
    $cmpny_id = $sCompanyBranchDetailEdit['company_id'];
    $brnch_name = $sCompanyBranchDetailEdit['branch_name'];
    $brnch_id = $sCompanyBranchDetailEdit['branch_id'];
    ?>

    <input type="text" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >

    <script language='javascript'>
        window.onload=editCompanyBasedBranch;
        // company based branch
        function editCompanyBasedBranch(branch_id){  

            var branch_id = $("#branchIdEdit").val();
            $.ajax({
                url: 'R&RFile/ajaxEditCompanyBasedBranch.php',
                type:'post',
                data: {'branch_id': branch_id},
                dataType: 'json',
                success: function(response){
                    
                    $("#branch_id").empty();
                    $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
                    var r = 0;
                    for (r = 0; r <= response.branch_id.length - 1; r++) { 
                        var selected = "";
                        if(response['branch_id'][r] == branch_id)
                        {
                            selected = "selected";
                        }
                        $('#branch_id').append("<option value='" + response['branch_id'][r] + "' "+selected+">" + 
                        response['branch_name'][r] + "</option>");
                    }
                }
            });

        }

    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Vehicle Details</li>
    </ol>
    <a href="dashboard">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "vehicle_details" name="vehicle_details" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($vehicle_details_id)) echo $vehicle_details_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
    <input type="hidden" class="form-control" value="<?php if(isset($fc_insurance_renew_id)) echo $fc_insurance_renew_id ?>" id="fc_insurance_renew_id" name="fc_insurance_renew_id" >
    <input type="hidden" class="form-control" value="<?php if(isset($assign_staff_name)) echo $assign_staff_name ?>" id="assign_staff" name="assign_staff" >
 		<!-- Row start -->
         <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">General Info</div> -->
					</div>
                    <div class="card-body">

                            <div class="row ">
                            <!--Fields -->
                            <div class="col-md-12 "> 
                                <div class="row">
                            
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                                <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id"  >
                                                    <?php if($sbranch_id == 'Overall'){ ?>    
                                                        <option value="<?php echo $cmpny_id; ?>"><?php echo $cmpny_name; ?></option> 
                                                    <?php }else{ ?>   
                                                            <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                    <?php } ?>
                                                </select> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Branch Name</label>
                                                <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >
                                                <select disabled tabindex="2" type="text" class="form-control" id="branch_id1" name="branch_id1" >
                                                    <?php if($sbranch_id == 'Overall'){ ?>
                                                        <option value="<?php echo $brnch_id; ?>"><?php echo $brnch_name; ?></option> 
                                                    <?php }else{ ?>
                                                        <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                    <?php } ?>
                                                </select> 
                                        </div>
                                    </div>

                                    <?php if(isset($vehicle_code)) { ?>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Vehicle Code</label>
                                                <input type="text" readonly id="vehicle_code_edit" name="vehicle_code_edit" class="form-control" value="<?php if(isset($vehicle_code)) echo $vehicle_code; ?>" >
                                            </div>
                                        </div>
                                    <?php } ?> 
                                        
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="vehicle_type">Vehicle Type</label>
                                            <select id="vehicle_type" name="vehicle_type" class="form-control">
                                                <option value=""> Select Vehicle Type </option>
                                                <option value="1" <?php if(isset($vehicle_type) && $vehicle_type == '1'){ echo 'selected';} ?> > Own Vehicle </option>
                                                <option value="2" <?php if(isset($vehicle_type) && $vehicle_type == '2'){ echo 'selected';} ?> > Rental Vehicle </option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Vehicle Name</label>
                                            <input type="text" tabindex="3" id="vehicle_name" name="vehicle_name" class="form-control" value="<?php if(isset($vehicle_name)) echo $vehicle_name; ?>" placeholder="Enter Vehicle Name">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Vehicle Number</label>
                                            <input type="text" tabindex="4" id="vehicle_number" name="vehicle_number" class="form-control" value="<?php if(isset($vehicle_number)) echo $vehicle_number; ?>" placeholder="Enter Vehicle Number" oninput="convertToUppercase(this)">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Date Of Purchase</label>
                                            <input type="date" tabindex="5" name="date_of_purchase" id="date_of_purchase" class="form-control" value="<?php if(isset($date_of_purchase)) echo $date_of_purchase; ?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Fitment Upto</label>
                                            <input type="date" tabindex="6" name="fitment_upto" id="fitment_upto" class="form-control" value="<?php if(isset($fitment_upto)) echo $fitment_upto; ?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Insurance Upto</label>
                                            <input type="date" tabindex="7" name="insurance_upto" id="insurance_upto" class="form-control" value="<?php if(isset($insurance_upto)) echo $insurance_upto; ?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Asset Value</label>
                                            <input type="text" tabindex="8" id="asset_value" name="asset_value" class="form-control" value="<?php if(isset($asset_value)) echo $asset_value; ?>" placeholder="Enter Asset Value">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Book Value As On</label>
                                            <input type="text" tabindex="9" id="book_value_as_on" name="book_value_as_on" class="form-control" value="<?php if(isset($book_value_as_on)) echo $book_value_as_on; ?>" placeholder="Enter Book Value As On">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        
                        
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Assign Employee</label>
                                    <select type="text"  id="assign_staff_name" name="assign_staff_name" class="form-control">
                                        <option value=''> Select Employee </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Remark</label>
                                    <textarea type="text"  id="assign_remark" name="assign_remark" class="form-control"><?php if(isset($assign_remark)) echo $assign_remark; ?></textarea>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="from_date">Start Date & End Date</label>
                                    <div class="form-inline">
                                        <input type="date" tabindex = "8" name="from_date" id="from_date" placeholder="From" class="form-control"  value="<?php if (isset($from_date)) echo $from_date;?>">&nbsp;&nbsp;
                                        <span>To</span>&nbsp;&nbsp;<input type="date" tabindex = "9" name="to_date" id="to_date" placeholder="To" class="form-control"  value="<?php if (isset($to_date)) echo $to_date;?>">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <button type="submit" name="submitfcinsurancerenew" id="submitfcinsurancerenew" class="btn btn-primary" value="Submit" tabindex="12" style="float: right;">Submit</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
    </form>
</div>
