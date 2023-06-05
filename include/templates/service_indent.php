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
$departmentList = $userObj->getDepartment($mysqli); 
$AssetList = $userObj->getAssetsName($mysqli);

$id=0;
if(isset($_POST['submitServiceIndent']) && $_POST['submitServiceIndent'] != '')
{
if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
    $id = $_POST['id']; 	
$updateServiceIndent = $userObj->updateServiceIndent($mysqli,$id,$userid);  
?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_service_indent&msc=2';</script> 
<?php	}
else{   
    $addServiceIndent = $userObj->addServiceIndent($mysqli,$userid);   
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>edit_service_indent&msc=1';</script>
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
	$deleteServiceIndent = $userObj->deleteServiceIndent($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_service_indent&msc=3';</script>
<?php	
}

$stock=0;
if(isset($_GET['stock']))
{
    $stock=$_GET['stock'];
}
if($stock>0)
{
	$StockInoutServiceIndent = $userObj->StockInoutServiceIndent($mysqli,$stock,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_service_indent&msc=2';</script>
<?php	
}

if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getServiceIndent = $userObj->getServiceIndent($mysqli,$idupd); 
	if (sizeof($getServiceIndent)>0) {
        for($itag=0;$itag<sizeof($getServiceIndent);$itag++) {

            $company_id   = $getServiceIndent['company_id']; 
            $service_indent_id   = $getServiceIndent['service_indent_id']; 
			$date_of_indent      = $getServiceIndent['date_of_indent'];
            $asset_class         = $getServiceIndent['asset_class']; 
            $asset_name1         = $getServiceIndent['asset_name1']; 
			$asset_value         = $getServiceIndent['asset_value'];
			$vendor_address      = $getServiceIndent['vendor_address'];
			$vendor_address1     = $getServiceIndent['vendor_address1'];
			$vendor_address2     = $getServiceIndent['vendor_address2'];
			$company_address     = $getServiceIndent['company_address'];
			$company_address1    = $getServiceIndent['company_address1'];
			$company_address2    = $getServiceIndent['company_address2'];
			$reason_for_indent   = $getServiceIndent['reason_for_indent'];
			$expected_to_arrive  = $getServiceIndent['expected_to_arrive'];
		}
	} 
    $getAssetName = $userObj->getAssetName($mysqli, $asset_class);  
    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    ?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="insuranceEdit" name="insuranceEdit" value="<?php print_r($insurance_id); ?>" >
    <input type="hidden" id="deptEdit" name="deptEdit" value="<?php print_r($dept_id); ?>" >
    <script>
        window.onload=editCompanyBasedBranch;
        function editCompanyBasedBranch(){  
            var branch_id = $('#company_nameEdit').val();
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
        <li class="breadcrumb-item">AS - Service Indent </li>
    </ol>

    <a href="edit_service_indent">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "service_indent" name="service_indent" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($service_indent_id)) echo $service_indent_id ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                           <div class="col-md-8 "> 
                              <div class="row">

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id" >
                                                    <option value="">Select Company Name</option>   
                                                        <?php if (sizeof($companyName)>0) { 
                                                        for($j=0;$j<count($companyName);$j++) { ?>
                                                        <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id'])  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
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
                                    
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
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

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Date Of Service Indent</label>
                                            <input type="date" tabindex="3" id="date_of_indent" name="date_of_indent" class="form-control"  value="<?php if(isset($date_of_indent)) echo $expected_to_arrive; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Asset Classification</label>
                                                <select tabindex="4" type="text" class="form-control" id="asset_class" name="asset_class" >
                                                    <option value="">Select Asset Classification</option>   

                                                    <option value="1" <?php if(isset($asset_class )){if($asset_class == "1") echo "selected";} ?>>Plant & Machinary</option>
                                                    <option value="2" <?php if(isset($asset_class )){if($asset_class == "2") echo "selected";} ?>>Land & Building</option>
                                                    <option value="3" <?php if(isset($asset_class )){if($asset_class == "3") echo "selected";} ?>>Computer</option>
                                                    <option value="4" <?php if(isset($asset_class )){if($asset_class == "4") echo "selected";} ?>>Printer and Scanner</option>
                                                    <option value="5" <?php if(isset($asset_class )){if($asset_class == "5") echo "selected";} ?>>Furniture and Fixtures</option>
                                                    <option value="6" <?php if(isset($asset_class )){if($asset_class == "6") echo "selected";} ?>>Electrical & fitting</option>

                                                </select>
                                            </div>
                                        </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Asset Name</label>
                                            <?php if(!isset($asset_name1) && $idupd<=0){ ?>
                                                <select tabindex="5" type="text" class="form-control" id="asset_name1" name="asset_name1" >
                                                    <option value="">Asset Name</option> 
                                                </select>  
                                            <?php } else { ?>
                                                <select tabindex="5" type="text" class="form-control" id="asset_name1" name="asset_name1" >
                                                    <option value="">Asset Name</option>   
                                                    <?php if (sizeof($getAssetName)>0) {  
                                                    for($j=0;$j<count($getAssetName);$j++) { ?>
                                                    <option <?php if(isset($asset_name1)) { if($getAssetName[$j]['asset_id'] == $asset_name1)  echo 'selected'; }  ?> value="<?php echo $getAssetName[$j]['asset_id']; ?>">
                                                    <?php echo $getAssetName[$j]['asset_name'];?></option>
                                                    <?php }} ?> 
                                                </select>
                                            <?php } ?>
                                           
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Value Of Asset</label>
                                            <input type="text" readonly id="asset_value" name="asset_value" class="form-control"  value="<?php if(isset($asset_value)) echo $asset_value; ?>" placeholder="Value Of Asset">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Vendor Address</label>
                                            <input type="text" tabindex="6" id="vendor_address" name="vendor_address" class="form-control"  value="<?php if(isset($vendor_address)) echo $vendor_address; ?>"  placeholder="Vendor Address">
                                            <input type="text" tabindex="7" id="vendor_address" name="vendor_address1" class="form-control"  value="<?php if(isset($vendor_address1)) echo $vendor_address1; ?>"  placeholder="Vendor Address1">
                                            <input type="text" tabindex="8" id="vendor_address" name="vendor_address2" class="form-control"  value="<?php if(isset($vendor_address2)) echo $vendor_address2; ?>"  placeholder="Vendor Address2">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Address</label>

                                            <input readonly type="text" id="company_address" name="company_address" class="form-control"  value='<?php if(isset($company_address)) echo ($company_address);?>'  placeholder="Company Address">
                                            <input readonly type="text" id="company_address1" name="company_address1" class="form-control"  value='<?php if(isset($company_address1)) echo ($company_address1);?>'  placeholder="Company Address1">
                                            <input readonly type="text" id="company_address2" name="company_address2" class="form-control"  value='<?php if(isset($company_address2)) echo ($company_address2);?>'  placeholder="Company Address2">
                                       
                                        </div>
                                    </div>
                                    <!-- <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Address</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <input readonly type="text" id="company_address" name="company_address" class="form-control" placeholder="Company Address">
                                                <input readonly type="text" id="company_address1" name="company_address1" class="form-control" placeholder="Company Address1">
                                                <input readonly type="text" id="company_address2" name="company_address2" class="form-control" placeholder="Company Address2">
                                            <?php } else if($sbranch_id != 'Overall'){ ?> 
                                            <input readonly type="text" id="company_address" name="company_address" class="form-control"  value='<?php echo ($sCompanyBranchDetail["address1"]),',', ($sCompanyBranchDetail["address2"]);?>'  placeholder="Company Address">
                                            <input readonly type="text" id="company_address1" name="company_address1" class="form-control"  value='<?php  echo $sCompanyBranchDetail["city"]; ?>'  placeholder="Company Address1">
                                            <input readonly type="text" id="company_address2" name="company_address2" class="form-control"  value='<?php  echo $sCompanyBranchDetail["state"]; ?>'  placeholder="Company Address2">
                                            <?php } ?>
                                        </div>
                                    </div> -->
                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Reason For Service Indent</label>
                                            <textarea class="form-control" tabindex="9" rows="4" cols="50" id="reason_for_indent" name="reason_for_indent" 
                                            value="<?php if(isset($reason_for_indent)) echo $reason_for_indent; ?>" placeholder="Enter Reason For Service Indent"><?php if(isset($reason_for_indent)) echo $reason_for_indent; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Expected To Be Arrive</label>
                                            <input type="date" tabindex="10" id="expected_to_arrive" name="expected_to_arrive" class="form-control"  value="<?php if(isset($expected_to_arrive)) echo $expected_to_arrive; ?>" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-md-12">
                        <div class="text-right">
                                <button type="submit" name="submitServiceIndent" id="submitServiceIndent" class="btn btn-primary" value="Submit" tabindex="11">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="12">Cancel</button>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

