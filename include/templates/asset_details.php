<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
    $audit_area_list1 = $userObj->getAuditAreaTable1($mysqli, $sbranch_id);
}
$audit_area_list = $userObj->getAuditAreaTable($mysqli);
$companyName = $userObj->getCompanyName($mysqli);
$SpareName = $userObj->getSpareName($mysqli);
$assetClassName = $userObj->getAssetClassName($mysqli);
$id=0;
$idupd=0;
 if(isset($_POST['submit_asset_details']) && $_POST['submit_asset_details'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	

        $updateAuditAreaCreationmaster = $userObj->updateAssetDetails($mysqli,$id);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_asset_details&msc=2';</script> 
    <?php	}
    else{   
        
        $addAuditAreaCreation = $userObj->addAssetDetails($mysqli);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_asset_details&msc=1';</script>
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
	$deleteAuditAreaCreation = $userObj->deleteAssetDetails($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_asset_details&msc=3';</script>
    <?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}

if($idupd>0)
{
	$getAssetDetails = $userObj->getAssetDetails($mysqli,$idupd); 
	
	if (sizeof($getAssetDetails)>0) {
        for($i=0;$i<sizeof($getAssetDetails);$i++)  {

            $asset_details_id                  = $getAssetDetails['asset_details_id']; 
            $company_id                  = $getAssetDetails['company_id']; 
            $branch_id                  = $getAssetDetails['branch_id']; 
			$asset_class                	 = $getAssetDetails['classification'];
			$asset_name                	 = $getAssetDetails['asset_name'];
            $asset_value                	     = $getAssetDetails['asset_value'];
            $put_to                	     = $getAssetDetails['dou'];
			$depreciation    	                = $getAssetDetails['depreciation'];
			$as_on    	                = $getAssetDetails['as_on'];
			$spare_names    	                = $getAssetDetails['spare_names'];
	
		}
    }
    
    $req_array = '';
    $req_array = explode(',',$spare_names); 
   
    $getAssetDetails_ref = $userObj->getAssetDetails_ref($mysqli,$asset_details_id);
    $model_no[]=array();
    $warranty_upto[]=array();

    if (sizeof($getAssetDetails_ref)>0) {
        for($j=0;$j<sizeof($getAssetDetails_ref);$j++)  {
            $model_no[$j]    	                = $getAssetDetails_ref[$j]['model_no'];
            $warranty_upto[$j]    	                = $getAssetDetails_ref[$j]['warranty_upto'];
	
		}
	}
}

?>
   
    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($branch_id); ?>" >
    <input type="hidden" id="assetclassEdit" name="assetclassEdit" value="<?php print_r($asset_class); ?>" >
    <input type="hidden" id="assetnameEdit" name="assetnameEdit" value="<?php print_r($asset_name); ?>" >

    <script>
        window.onload=editCompanyBasedBranch;
        function editCompanyBasedBranch(){
            var branch_id = $('#company_nameEdit').val();
            var assetClassification = $('#assetclassEdit').val();
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
                        $('#branch_id').append("<option value='" + response['branch_id'][r] + "' "+selected+">" + response['branch_name'][r] + "</option>");
                    }

                }
            });
            getassetNamedropdown(assetClassification);
        }
    </script>
            
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Asset Details </li>
    </ol>

    <a href="edit_asset_details">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "asset_details" name="asset_details" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($asset_details_id)) echo $asset_details_id; ?>"  id="asset_details_id_upd" name="asset_details_id_upd" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($asset_class)) echo $asset_class; ?>"  id="asset_class_id_upd" name="asset_class_id_upd" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($asset_name)) echo $asset_name; ?>"  id="asset_name_upd" name="asset_name_upd" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($branch_id)) echo $branch_id; ?>"  id="branch_id_upd" name="branch_id_upd" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($company_id)) echo $company_id; ?>"  id="company_id_upd" name="company_id_upd" aria-describedby="id" placeholder="Enter id">
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
                                        <label for="disabledInput">Company</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                            <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id" >
                                                <option value="">Select Company Name</option>   
                                                    <?php if (sizeof($companyName)>0) { 
                                                    for($j=0;$j<count($companyName);$j++) { ?>
                                                    <option <?php if(isset($company_id)) { if($companyName[$j]['company_id'] == $company_id)  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                    <?php echo $companyName[$j]['company_name'];?></option>
                                                    <?php }} ?>  
                                            </select> 
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <input type="hidden" name="company_id" id="company_id" class="form-control" value="<?php echo $sCompanyBranchDetail['company_id']; ?>">
                                                    <select disabled tabindex="1" type="text" class="form-control" id="company_id1" name="company_id1"   >
                                                        <option value="<?php echo $sCompanyBranchDetail['company_id']; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
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
                                                <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>">
                                                <select disabled tabindex="2" type="text" class="form-control" id="branch_id1" name="branch_id1"  >
                                                    <option  value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                </select> 
                                            <?php } ?>                               
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                            <label for="disabledInput">Asset Classification</label>
                                            <select tabindex="3" type="text" class="form-control" name="asset_class" id="asset_class">
                                                <option value="">Select Asset Classification</option>

                                                <option value="1" <?php if(isset($asset_class )){if($asset_class == "1") echo "selected";} ?>>Plant & Machinary</option>
                                                <option value="2" <?php if(isset($asset_class )){if($asset_class == "2") echo "selected";} ?>>Land & Building</option>
                                                <option value="3" <?php if(isset($asset_class )){if($asset_class == "3") echo "selected";} ?>>Computer</option>
                                                <option value="4" <?php if(isset($asset_class )){if($asset_class == "4") echo "selected";} ?>>Printer and Scanner</option>
                                                <option value="5" <?php if(isset($asset_class )){if($asset_class == "5") echo "selected";} ?>>Furniture and Fixtures</option>
                                                <option value="6" <?php if(isset($asset_class )){if($asset_class == "6") echo "selected";} ?>>Electrical & fitting</option>

                                                <!-- <?php if (sizeof($assetClassName)>0) { 
                                                    for($j=0;$j<count($assetClassName);$j++) { ?>
                                                    <option <?php if(isset($asset_class)) { if($assetClassName[$j]['asset_class'] == $asset_class)  echo 'selected'; }  ?> 
                                                    value="<?php echo $assetClassName[$j]['asset_class']; ?>">
                                                    <?php echo $assetClassName[$j]['asset_class'];?></option>
                                                    <?php }} ?>  -->

                                            </select>
                                            </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Asset Name</label>
                                            <select tabindex="4" class="form-control" id="asset_name" name="asset_name" >
                                                <option value=''>Select Asset Name</option>
                                            </select>
                                        </div>
                                    </div>
                                   
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Asset Value</label>
                                            <input readonly type="number" class="form-control" id="asset_value" name="asset_value"
                                            value="<?php if(isset($asset_value)) echo $asset_value; ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Date of put to use</label>
                                            <input tabindex="5" type="date" class="form-control" id="put_to" name="put_to" 
                                            value="<?php if(isset($put_to)) echo $put_to; ?>"  >
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Depreciation Date</label>
                                            <input tabindex="6" type="date" class="form-control" id="depreciation" name="depreciation" 
                                            value="<?php if(isset($depreciation)) echo $depreciation; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">As On Date Value</label>
                                            <input tabindex="7" type="text" class="form-control" id="as_on" name="as_on" 
                                            value="<?php if(isset($as_on)) echo $as_on; ?>"  placeholder = "Enter As On Date Value"><br>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
					<div class="card-header">
						<div class="card-title">Warranty Details</div>
					</div>
                    <div class="card-body">
                    	<div class="row ">
                            <div class="col-md-8 "> 
                                <div class="row">
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="modal_no">Model No</label>
                                            <input  tabindex="8" type="text" class="form-control" id="modal_no" name="modal_no" placeholder="Enter Model Number"><br>
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                        <div class="form-group">
                                            <label for="modal_no">Warranty Upto</label>
                                            <input  tabindex="9" type="date" class="form-control" id="warranty_upto" name="warranty_upto"><br>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                        <div class="form-group">
                                            <button  tabindex="10" type="button" class="btn btn-primary" id="add_modal_no" name="add_modal_no"  style="padding: 5px 35px; margin-top:20px;">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
					<div class="card-header">
						<div class="card-title">Model Details</div>
					</div>
                    <div class="card-body">
                        <div class="row" >
                            <div class="col-md-8" >
                                <table id="moduleTable" class="table custom-table " style="min-width:150%">
                                    <thead>
                                        <tr>
                                            <th>Model No</th>
                                            <th>Warranty Upto</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($idupd>0){
                                            if(isset($asset_details_id)){ ?>
                                                <?php for($g=0;$g<=count($model_no)-1;$g++) { ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="modal_no" name="modal_no[]" readonly value="<?php echo $model_no[$g]?>">
                                                            </input> 
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="warranty_upto" name="warranty_upto[]" readonly value="<?php echo $warranty_upto[$g]?>">
                                                            </input> 
                                                        </td>
                                                        <td><a onclick='onDelete(this);'><span class='icon-trash-2' id="delete_row"></span></a></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
					<div class="card-header">
						<div class="card-title">Spares Details</div>
					</div>
                    <div class="card-body">
                    	<div class="row ">
                            <div class="col-md-8 "> 
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                        <div class="form-group">
                                            <label for="spare_names">Spares Name</label>
                                            <select tabindex="11" type="text" class="form-control" id="spare_names" name="spare_names[]" multiple >
                                                <?php if (sizeof($SpareName) > 0) {
                                                    for ($j = 0; $j < count($SpareName); $j++) { ?>
                                                        <option <?php if (isset($req_array)) {
                                                            for ($i = 0; $i < count($req_array); $i++) {
                                                                if ($SpareName[$j]['spare_id'] == $req_array[$i])
                                                                    echo 'selected';
                                                            } } ?> value="<?php echo $SpareName[$j]['spare_id']; ?>">
                                                        <?php echo $SpareName[$j]['spare_name']; ?></option>
                                                        <?php 
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button type="button" tabindex="12" class="btn btn-primary" id="add_spares" name="add_spares"  style="padding: 5px 35px; margin-top:20px;"
                                            data-toggle="modal" data-target = '.addSpareModal'><span class="icon-add"></span></button>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"></div>

                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="col-md-12" style="display: flex; justify-content: space-between;">
                            <div>
                                <button type="button"  tabindex="13"  id="downloadAsset" name="downloadAsset" class="btn btn-primary"><span class="icon-download"></span>Download</button>
                                <button type="button" data-toggle="modal" data-target="#AssetModal" tabindex="14"  id="uploadAsset" name="uploadAsset"  class="btn btn-primary"><span class="icon-upload"></span>Upload</button>		
                            </div>
                            <div>
                                <button type="submit" name="submit_asset_details" id="submit_asset_details" class="btn btn-primary" value="Submit" tabindex="15">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="16">Cancel</button>
                            </div>
                        </div>

                    </div>
                </div>


                 <!-- Add Spare Name Modal -->
                <div class="modal fade addSpareModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="background-color: white">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myLargeModalLabel">Add Spare Name</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DropDownStock()">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- alert messages -->
                                <div id="spareInsertNotOk" class="unsuccessalert">Spare Name Already Exists, Please Enter a Different Name!
                                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>

                                <div id="spareInsertOk" class="successalert">Spare Name Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>

                                <div id="spareUpdateOk" class="successalert">Spare Name Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>

                                <div id="spareDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Spare Name!
                                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>

                                <div id="spareDeleteOk" class="successalert">Spare Name Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                </div>

                                <br />
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label class="label">Enter Spare Name</label>
                                            <input type="hidden" name="spare_id" id="spare_id">
                                            <input type="text" name="spare_name" id="spare_name" class="form-control" placeholder="Enter Spare Name">&nbsp;&nbsp;
                                            <span class="text-danger" tabindex="1" id="sparenameCheck" style="display: none;">Enter Spare Name</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                                            <label class="label" style="visibility: hidden;">Spare Name</label>
                                        <button type="button" tabindex="2" name="submitSpareNameBtn" id="submitSpareNameBtn" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                                <div id="updatedspareTable"> 
                                    <table class="table custom-table" id="spareTable"> 
                                        <thead>
                                            <th style="width:15px">S.No</th>
                                            <th style="width:15px">Spare Name</th>
                                            <th style="width:15px">ACTION</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownStock()">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal for upload -->
                <div class="modal fade" id="AssetModal" tabindex="-1" role="dialog" aria-labelledby="vCenterModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="background-color: white">
                            <div class="modal-header">
                                <h5 class="modal-title" id="vCenterModalTitle">Asset Upload</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" name="assetUpload" id="assetUpload">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12"></div>
                                        <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                        <div id="insertsuccess" style="color: green; font-weight: bold;">Asset Added Successfully</div>
                                        <div id="notinsertsuccess" style="color: red; font-weight: bold;">Problem Importing File or Duplicate Entry found</div>
                                        <label class="label">Select File</label>
                                        <input type="file" name="file" id="file" class="form-control">
                                        </div>
                                        </div> 
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="submitAssetUploadbtn" name="submitAssetUploadbtn">Upload</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                            </div>
                        </div>
                    </div>
                </div>
    </form>
</div>



