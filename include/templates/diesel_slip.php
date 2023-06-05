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
if(isset($_POST['submitDieselSlipBtn']) && $_POST['submitDieselSlipBtn'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateDieselSlip = $userObj->updateDieselSlip($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_diesel_slip&msc=2';</script> 
    <?php }
    else{   
        $addDieselSlip = $userObj->addDieselSlip($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_diesel_slip&msc=1';</script>
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
	$deleteDieselSlip = $userObj->deleteDieselSlip($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_diesel_slip&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getDieselSlip = $userObj->getDieselSlip($mysqli,$idupd); 
	if (sizeof($getDieselSlip)>0) {
        for($itag=0;$itag<sizeof($getDieselSlip);$itag++)  {
            $diesel_slip_id       = $getDieselSlip['diesel_slip_id']; 
            $company_id              = $getDieselSlip['company_id'];
			$vehicle_number    	     = $getDieselSlip['vehicle_number'];
			$previous_km    	     = $getDieselSlip['previous_km'];
			$previous_km_date    	     = $getDieselSlip['previous_km_date'];
			$present_km    	     = $getDieselSlip['present_km'];
			$present_km_date    	     = $getDieselSlip['present_km_date'];
			$total_km_run    	     = $getDieselSlip['total_km_run'];
			$diesel_amount    	     = $getDieselSlip['diesel_amount'];
		}
	} 
    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    ?>

    <input type="text" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="text" id="vehicle_numberEdit" name="vehicle_numberEdit" value="<?php print_r($vehicle_number); ?>" >

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
            
            getVehicleNo(branch_id);

        }

    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Diesel Slip</li>
    </ol>
    <a href="edit_diesel_slip">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "diesel_slip" name="diesel_slip" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($diesel_slip_id)) echo $diesel_slip_id ?>" id="id" name="id" aria-describedby="id" >
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
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Vehicle Number</label>
                                            <select tabindex="2" type="text" class="form-control" id="vehicle_number" name="vehicle_number" >
                                                <option value="">Select Vehicle Number</option> 
                                            </select> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Previous KM</label>
                                            <input readonly type="text" tabindex="8" id="previous_km" name="previous_km" class="form-control" value="<?php if(isset($previous_km)) echo $previous_km; ?>" placeholder="Enter Previous KM">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Date</label>
                                            <input readonly type="date" tabindex="5" name="previous_km_date" id="previous_km_date" class="form-control" value="<?php if(isset($previous_km_date)) echo $previous_km_date; ?>" >
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"> </div>
                                    

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Present KM</label>
                                            <input type="number" tabindex="8" id="present_km" name="present_km" class="form-control" value="<?php if(isset($present_km)) echo $present_km; ?>" placeholder="Enter Present KM">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Date</label>
                                            <input readonly type="date" name="present_km_date" id="present_km_date" placeholder="From" class="form-control" value="<?php if(isset($present_km_date)) echo $present_km_date; else echo date('Y-m-d'); ?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"> </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Total KM Run</label>
                                            <input readonly type="text" tabindex="8" id="total_km_run" name="total_km_run" class="form-control" value="<?php if(isset($total_km_run)) echo $total_km_run; ?>" placeholder="Total KM Run">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Diesel Litre</label>
                                            <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2" max="99" tabindex="9" id="diesel_amount" name="diesel_amount" class="form-control" value="<?php if(isset($diesel_amount)) echo $diesel_amount; ?>" placeholder="Enter Diesel Litre" >
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="col-md-12">
                            <div class="text-right">
                                <button type="submit" name="submitDieselSlipBtn" id="submitDieselSlipBtn" class="btn btn-primary" value="Submit" tabindex="12">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="13">Cancel</button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
       
    </form>
</div>
