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
if(isset($_POST['submitPeriodicLevelBtn']) && $_POST['submitPeriodicLevelBtn'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updatePeriodicLevel = $userObj->updatePeriodicLevel($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_periodic_level&msc=2';</script> 
    <?php }
    else{   
        $addPeriodicLevel = $userObj->addPeriodicLevel($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_periodic_level&msc=1';</script>
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
	$deletePeriodicLevel = $userObj->deletePeriodicLevel($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_periodic_level&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getPeriodicLevel = $userObj->getPeriodicLevel($mysqli,$idupd); 
	
	if (sizeof($getPeriodicLevel)>0) {
        for($itag=0;$itag<sizeof($getPeriodicLevel);$itag++)  {

            $periodic_level_id                  = $getPeriodicLevel['periodic_level_id']; 
            $company_id                	     = $getPeriodicLevel['company_id'];
			$periodic_date                	 = $getPeriodicLevel['periodic_date'];
			$asset_details    	     = $getPeriodicLevel['asset_details'];
		}
	} 
    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_id);
    ?>

    <input type="text" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="text" id="asset_detailsEdit" name="asset_detailsEdit" value="<?php print_r($asset_details); ?>" >

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

            editAssetDetails(branch_id);

        }

        function editAssetDetails(company_id){ 
            var asset_detailsEdit = $("#asset_detailsEdit").val(); 

            $.ajax({
                url: 'maintenanceChecklistFile/ajaxGetStaffDepartment.php',
                type: 'post',
                data: { "company_id":company_id },
                dataType: 'json',
                success: function(response){ 

                    $('#asset_details').empty();
                    $('#asset_details').prepend("<option value=''>" + 'Select Asset Details' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.asset_id.length - 1; r++) { 
                        var selected = "";
                        if(response['asset_id'][r] == asset_detailsEdit)
                        {
                            selected = "selected";
                        }
                        $('#asset_details').append("<option value='" + response['asset_id'][r] + "' "+selected+">" + response['asset_name'][r]+' - '+response['asset_classification'][r] + "</option>");
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
        <li class="breadcrumb-item">AS - Periodic Level</li>
    </ol>
    <a href="edit_periodic_level">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "periodic_level" name="periodic_level" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($periodic_level_id)) echo $periodic_level_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                                                <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id" >
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
                                            <label for="disabledInput">Periodic Date</label>
                                            <input type="date" readonly name="periodic_date" id="periodic_date" placeholder="From" class="form-control" value="<?php if(isset($periodic_date)) echo $periodic_date; else echo date('Y-m-d'); ?>" >
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Asset Details</label>
                                            <select id="asset_details" name="asset_details" class="form-control" tabindex="3">
                                                <option value="">Select Asset Details</option>
                                            </select> 
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submitPeriodicLevelBtn" id="submitPeriodicLevelBtn" class="btn btn-primary" value="Submit" tabindex="4">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="5">Cancel</button>
                            </div>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
       
    </form>
</div>
