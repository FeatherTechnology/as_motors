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
 if(isset($_POST['submitAssetRegister']) && $_POST['submitAssetRegister'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateAssetRegister = $userObj->updateAssetRegister($mysqli,$id, $userid);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>asset_register&msc=2';</script> 
    <?php	}
    else{   
		$addAssetRegister = $userObj->addAssetRegister($mysqli, $userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>asset_register&msc=1';</script>
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
	$deleteAssetRegister = $userObj->deleteAssetRegister($mysqli,$del, $userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>asset_register&msc=3';</script>
<?php	
}
$idupd=0;
if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getAssetRegisterList = $userObj->getAssetRegister($mysqli,$idupd); 
	
	if (sizeof($getAssetRegisterList)>0) {
        for($iasset=0;$iasset<sizeof($getAssetRegisterList);$iasset++)  {	
            $company_id                      = $getAssetRegisterList['company_id'];
            $asset_id                      = $getAssetRegisterList['asset_id'];
			$asset_class_id              	 = $getAssetRegisterList['asset_classification'];
			$asset_autoGen_id              	 = $getAssetRegisterList['asset_autoGen_id'];
			$asset_name          		 = $getAssetRegisterList['asset_name'];
			$vendor_id          		 = $getAssetRegisterList['vendor_id'];
			$dop      			             = $getAssetRegisterList['dop'];
			$asset_nature_id		             = $getAssetRegisterList['asset_nature'];
			$depreciation_rate		             = $getAssetRegisterList['depreciation_rate'];
			$asset_value		             = $getAssetRegisterList['asset_value'];
			$maintenance_id		             = $getAssetRegisterList['maintenance'];
		}
	}

    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_id); ?>" >
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
                        $('#branch_id').append("<option value='" + response['branch_id'][r] + "' "+selected+">" + response['branch_name'][r] + "</option>");
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
        <li class="breadcrumb-item">AS - Asset Register </li>
    </ol>
    <?php if(isset($asset_id)){?>
        <a href="asset_register">
            <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
        </a>
    <?php }?>
   
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "asset_register" name="asset_register" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($asset_id)) echo $asset_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($asset_name)) echo $asset_name; ?>"  id="asset_name_upd" name="asset_name_upd">
<input type="hidden" class="form-control" value="<?php if(isset($vendor_id)) echo $vendor_id; ?>"  id="vendor_name_upd" name="vendor_name_upd">

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
                        <div class="col-md-12"> 
                            <div class="row">

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="company_id">Company Name</label>
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
                                                <select disabled tabindex="1" type="text" class="form-control" id="company_name" name="company_name"  >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="branch_id">Branch Name</label>
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

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="asset_class">Asset Classification</label>
                                            <select tabindex="3" type="text" class="form-control" name="asset_class" id="asset_class">
                                                <option value="">Select Asset Classification</option>
                                                <option value="1" <?php if(isset($asset_class_id )){if($asset_class_id == "1") echo "selected";} ?>>Plant & Machinary</option>
                                                <option value="2" <?php if(isset($asset_class_id )){if($asset_class_id == "2") echo "selected";} ?>>Land & Building</option>
                                                <option value="3" <?php if(isset($asset_class_id )){if($asset_class_id == "3") echo "selected";} ?>>Computer</option>
                                                <option value="4" <?php if(isset($asset_class_id )){if($asset_class_id == "4") echo "selected";} ?>>Printer and Scanner</option>
                                                <option value="5" <?php if(isset($asset_class_id )){if($asset_class_id == "5") echo "selected";} ?>>Furniture and Fixtures</option>
                                                <option value="6" <?php if(isset($asset_class_id )){if($asset_class_id == "6") echo "selected";} ?>>Electrical & fitting</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="asset_autoid">Asset ID</label>
                                            <input tabindex="4" type="text" id='asset_autoid' name="asset_autoid" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label for="asset_name">Asset Name</label>
                                            <select tabindex="5" id='asset_name' name="asset_name" class="form-control">
                                                <option value=''>Select Asset Name</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-4 col-sm-4 col-12" style="margin-top: 20px">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" id="add_asset_name" name="add_asset_name" data-toggle="modal" data-target=".addAssetName" style="padding: 5px 30px;"><span class="icon-add"></span></button>
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                        <div class="form-group">
                                            <label for="vendor_name">Vendor Name</label>
                                            <select tabindex="6" id='vendor_name' name="vendor_name" class="form-control">
                                                <option value=''>Select Vendor Name</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-4 col-sm-4 col-12" style="margin-top: 20px">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" id="add_vendor_name" name="add_vendor_name" data-toggle="modal" data-target=".addVendorName" style="padding: 5px 30px;"><span class="icon-add"></span></button>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="dop">Date of Purchase</label>
                                            <input tabindex="7" type="date" id='dop' name="dop" class="form-control" value="<?php if(isset($dop)) echo $dop; ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="nature">Asset Nature</label>
                                            <select tabindex="8" type="text" class="form-control" name="nature" id="nature">
                                                <option value="" >Select Asset</option>
                                                <option value="2" <?php if(isset($asset_nature_id )){if($asset_nature_id == "2") echo "selected"; }?>>Moveable</option>                                                
                                                <option value="1" <?php if(isset($asset_nature_id )){if($asset_nature_id == "1") echo "selected";} ?>>Immoveable</option>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <br>
                                            <label for="check_list">Maintenance Required</label>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" tabindex="9" checked name="check_list" id="yes" value="1" <?php if(isset($maintenance_id ))
                                                echo ($maintenance_id =='1')?'checked':'' ?>> &nbsp;&nbsp; <label for="yes">Yes </label> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" tabindex="10" name="check_list" id="no"  value="2" <?php if(isset($maintenance_id ))
                                                echo ($maintenance_id =='2')?'checked':'' ?>> &nbsp;&nbsp; <label for="no">No</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="depreciation_rate">Depreciation Rate</label>
                                            <input type="text" tabindex = "11" name="depreciation_rate" id="depreciation_rate" placeholder="Enter Depreciation Rate" class="form-control" 
                                            value="<?php if (isset($depreciation_rate)) echo $depreciation_rate;?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="asset_value">Asset/Book Value</label>
                                            <input type="number" tabindex = "12" name="asset_value" id="asset_value" placeholder="Enter Asset/Book Value" class="form-control" 
                                            value="<?php if (isset($asset_value)) echo $asset_value;?>">
                                        </div>
                                    </div>
                                    
                                </div>  
                            </div>

                            <div class="col-md-12">
                                <br><br>
                                <div class="col-md-3">
                                    <button type="button"  tabindex="13"  id="downloadAsset" name="downloadAsset" class="btn btn-primary"><span class="icon-download"></span>Download</button>
                                    <button type="button" data-toggle="modal" data-target="#AssetModal" tabindex="14"  id="uploadstaff" name="uploadstaff"  class="btn btn-primary"><span class="icon-upload"></span>Upload</button>		
                                </div>
                                <div class="text-right">
                                    <button type="submit" name="submitAssetRegister" id="submitAssetRegister" class="btn btn-primary" value="Submit" tabindex="15">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" tabindex="16" id='reset'>Cancel</button>
                                </div>
                                <br><br>
                            </div>
                        
                        </div>
                    </div>
                </div>
                <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-container">
        
                        <div class="table-responsive">
                            <?php
                            $mscid=0;
                            if(isset($_GET['msc']))
                            {
                            $mscid=$_GET['msc'];
                            if($mscid==1)
                            {?>
                            <div class="alert alert-success" role="alert">
                                <div class="alert-text">Asset Added Successfully!</div>
                            </div> 
                            <?php
                            }
                            if($mscid==2)
                            {?>
                                <div class="alert alert-success" role="alert">
                                <div class="alert-text">Asset Updated Successfully!</div>
                            </div>
                            <?php
                            }
                            if($mscid==3)
                            {?>
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-text">Asset Inactive Successfully!</div>
                            </div>
                            <?php
                            }
                            }
                            ?>
                            <table id="asset_register_table" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Company Name</th>
                                        <th>Branch Name</th>
                                        <th>Asset Classification</th>
                                        <th>Asset ID</th>
                                        <th>Asset Name</th>
                                        <th>Vendor Name</th>
                                        <th>Date Of Purchase</th>
                                        <th>Asset Nature</th>
                                        <th>Depreciation Rate</th>
                                        <th>Asset/Book Value</th>
                                        <th>Maintenance Required</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>    

        <div class="modal fade" id="AssetModal" tabindex="-1" role="dialog" aria-labelledby="vCenterModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color: white">
                <div class="modal-header">
                    <h5 class="modal-title" id="vCenterModalTitle">Asset Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Close</button>
                </div>
            </div>
        </div>       
        
    </div>


<!-- Asset Name creation Modal START-->
    <div class="modal fade addAssetName" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: white">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Asset Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetAssetName();DropDownAssetName();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- alert messages -->
                <div id="assetInsertNotOk" class="unsuccessalert">Asset Name Already Exists, Please Enter a Different Name!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="assetInsertOk" class="successalert">Asset Name Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="assetUpdateOk" class="successalert">Asset Name Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="assetDeleteNotOk" class="unsuccessalert">Process Failed!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="assetDeleteOk" class="unsuccessalert">Asset Name Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <br />
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label class="label">Enter Asset Name</label>
                            <input type="hidden" name="asset_name_id" id="asset_name_id">
                            <input type="text" name="asset_name_create" id="asset_name_create" class="form-control" placeholder="Enter Asset Name">
                            <span class="text-danger" id="assetnameCheck" style="display: none;">Enter Asset Name</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                            <label class="label" style="visibility: hidden;">Asset</label>
                        <button type="button" name="submitAssetNameModal" id="submitAssetNameModal" class="btn btn-primary">Submit</button>
                    </div>
                </div>

                <div id="AssetNameDiv"> 
                    <table class="table custom-table" id="assetTable"> 
                        <thead>
                            <tr>
                                <th>S. No</th>
                                <th>Asset Name</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td class="col-md-2 col-xl-2"></td>
                                    <td></td>
                                    <td>
                                        <!-- <a id="edit_asset_name" value=""><span class="icon-border_color"></span></a> &nbsp
                                        <a id="delete_asset_name" value=""><span class='icon-trash-2'></span></a> -->
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="resetAssetName();DropDownAssetName();">Close</button>
            </div>

        </div>
    </div>
</div>
<!-- Asset Name creation Modal END-->

<!-- Vendor Name creation Modal START-->
    <div class="modal fade addVendorName" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: white">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Vendor Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetVendorName();DropDownVendorName();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- alert messages -->
                <div id="vendorInsertNotOk" class="unsuccessalert">Vendor Name Already Exists, Please Enter a Different Name!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="vendorInsertOk" class="successalert">Vendor Name Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="vendorUpdateOk" class="successalert">Vendor Name Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="vendorDeleteNotOk" class="unsuccessalert">Process Failed!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="vendorDeleteOk" class="unsuccessalert">Vendor Name Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <br />
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label class="label">Enter Vendor Name</label>
                            <input type="hidden" name="vendor_name_id" id="vendor_name_id">
                            <input type="text" name="vendor_name_create" id="vendor_name_create" class="form-control" placeholder="Enter Vendor Name">
                            <span class="text-danger" id="vendornameCheck" style="display: none;">Enter Vendor Name</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                            <label class="label" style="visibility: hidden;">Vendor</label>
                        <button type="button" name="submitvendorNameModal" id="submitvendorNameModal" class="btn btn-primary">Submit</button>
                    </div>
                </div>

                <div id="vendorNameDiv"> 
                    <table class="table custom-table" id="vendorTable"> 
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Vendor Name</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td class="col-md-2 col-xl-2"></td>
                                    <td></td>
                                    <td>
                                        <!-- <a id="edit_asset_name" value=""><span class="icon-border_color"></span></a> &nbsp
                                        <a id="delete_asset_name" value=""><span class='icon-trash-2'></span></a> -->
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="resetVendorName();DropDownVendorName();">Close</button>
            </div>

        </div>
    </div>
</div>
<!-- Vendor Name creation Modal END-->

<script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);
</script>