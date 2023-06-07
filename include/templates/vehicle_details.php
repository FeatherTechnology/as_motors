<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 

$companyName = $userObj->getCompanyName($mysqli);

$id=0;
if(isset($_POST['submitVehicleDetailsBtn']) && $_POST['submitVehicleDetailsBtn'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateVehicleDetails = $userObj->updateVehicleDetails($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_vehicle_details&msc=2';</script> 
    <?php }
    else{   
        $addVehicleDetails = $userObj->addVehicleDetails($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_vehicle_details&msc=1';</script>
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
	$deleteVehicleDetails = $userObj->deleteVehicleDetails($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_vehicle_details&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
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
    <a href="edit_vehicle_details">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "vehicle_details" name="vehicle_details" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($vehicle_details_id)) echo $vehicle_details_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id">
                                                    <option value="">Select Company Name</option>   
                                                        <?php if (sizeof($companyName)>0) { 
                                                        for($j=0;$j<count($companyName);$j++) { ?>
                                                        <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { 
                                                            if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id']) echo 'selected'; } ?> 
                                                            value="<?php echo $companyName[$j]['company_id']; ?>">
                                                        <?php echo $companyName[$j]['company_name'];?></option>
                                                        <?php }} ?>  
                                                </select>  
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id"  >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>
                                    
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Branch Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="2" type="text" class="form-control" id="branch_id" name="branch_id" >
                                                    <option value="" disabled selected>Select Branch Name</option> 
                                                </select> 
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >
                                                <select disabled tabindex="2" type="text" class="form-control" id="branch_id1" name="branch_id1" >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <?php if($idupd <= 0) { ?>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Vehicle Code</label>
                                                <input type="text" readonly id="vehicle_code" name="vehicle_code" class="form-control" >
                                            </div>
                                        </div>
                                    <?php } ?>
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
                                            <label for="disabledInput">Vehicle Name</label>
                                            <input type="text" tabindex="3" id="vehicle_name" name="vehicle_name" class="form-control" value="<?php if(isset($vehicle_name)) echo $vehicle_name; ?>" placeholder="Enter Vehicle Name">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Vehicle Number</label>
                                            <input type="text" tabindex="4" id="vehicle_number" name="vehicle_number" class="form-control" value="<?php if(isset($vehicle_number)) echo $vehicle_number; ?>" placeholder="Enter Vehicle Number">
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

                        <br>

                        <div class="col-md-12" style="display: flex; justify-content: space-between;">
                            <div>
                                <button type="button" id="vehicleDetailsDownload" name="vehicleDetailsDownload" tabindex="10" class="btn btn-primary"><span class="icon-download"></span>Download</button>
                                <button type="button" id="vehicleDetailsUpload" name="vehicleDetailsUpload" data-toggle="modal" data-target="#vehicleDetailsBulkModal" tabindex="11" class="btn btn-primary"><span class="icon-upload"></span>Upload</button>
                            </div>
                            <div>
                                <button type="submit" name="submitVehicleDetailsBtn" id="submitVehicleDetailsBtn" class="btn btn-primary" value="Submit" tabindex="12">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="13">Cancel</button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="vehicleDetailsBulkModal" tabindex="-1" role="dialog" aria-labelledby="vCenterModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="background-color: white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="vCenterModalTitle">Vehicle Details Bulk Upload</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" name="employeebulk" id="employeebulk">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12"></div>
                                    <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                    <div id="insertsuccess" style="color: green; font-weight: bold;">Excel Data Added Successfully</div>
                                    <label class="label">Select Excel</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                    </div>
                                    </div> 
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="submitVehicleDetailsUploadBtn" name="submitVehicleDetailsUploadBtn">Upload</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
       
    </form>
</div>
