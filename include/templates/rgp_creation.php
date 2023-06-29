<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
}
$assetClassName = $userObj->getAssetClassName($mysqli);
$companyName = $userObj->getcompanyName($mysqli);
$branchName = $userObj->getBranchName($mysqli);

$id=0;
$idupd=0;
 if(isset($_POST['submit_asset_details']) && $_POST['submit_asset_details'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	

        $updateAuditAreaCreationmaster = $userObj->updateRGP($mysqli,$id);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_rgp_creation&msc=2';</script> 
    <?php	}
    else{   
        
        $addAuditAreaCreation = $userObj->addRGP($mysqli);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_rgp_creation&msc=1';</script>
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
	$deleteAuditAreaCreation = $userObj->deletergp($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_rgp_creation&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}

if($idupd>0)
{
	$getRGPTable = $userObj->getRGPTable($mysqli,$idupd); 
	
	if (sizeof($getRGPTable)>0) {
        for($i=0;$i<sizeof($getRGPTable);$i++)  {

            $rgp_id                  = $getRGPTable['rgp_id']; 
            $rgp_date                  = $getRGPTable['rgp_date']; 
            $return_date                  = $getRGPTable['return_date']; 
			$asset_class                	 = $getRGPTable['asset_class'];
			$branch_from                	 = $getRGPTable['branch_from'];
			$company_to                	 = $getRGPTable['company_to'];
			$branch_to                	 = $getRGPTable['branch_to'];
			$company_id                	 = $getRGPTable['company_id'];
			$from_comm_line1                	 = $getRGPTable['from_comm_line1'];
			$from_comm_line2                	 = $getRGPTable['from_comm_line2'];
			$to_comm_line1                	 = $getRGPTable['to_comm_line1'];
			$to_comm_line2                	 = $getRGPTable['to_comm_line2'];
			$asset_name_id                	 = $getRGPTable['asset_name_id'];
			$asset_value                	 = $getRGPTable['asset_value'];
			$extended_date                	 = $getRGPTable['extended_date'];
			$extend_reason                	 = $getRGPTable['extend_reason'];
			$reason_rgp                	 = $getRGPTable['reason_rgp'];
	
		}
	}
    
    
    
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - RGP Creation</li>
    </ol>

    <a href="edit_rgp_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "asset_details" name="asset_details" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($company_id)) echo $company_id; ?>"  id="company_id_upd" name="company_id_upd" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($branch_from)) echo $branch_from; ?>"  id="branch_from_upd" name="branch_from_upd" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($company_to)) echo $company_to; ?>"  id="company_to_upd" name="company_to_upd" >
<input type="hidden" class="form-control" value="<?php if(isset($branch_to)) echo $branch_to; ?>"  id="branch_to_upd" name="branch_to_upd" >
<input type="hidden" class="form-control" value="<?php if(isset($asset_class)) echo $asset_class; ?>"  id="asset_class_upd" name="asset_class_upd" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($asset_name_id)) echo $asset_name_id; ?>"  id="asset_name_id_upd" name="asset_name_id_upd" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">RGP Outward</div> -->
					</div>
                    <div class="card-body">

                    	<div class="row ">
                            <!--Fields -->
                            <div class="col-md-8 "> 
                                <div class="row">
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Date of RGP</label>
                                            <input tabindex="1" type="date" class="form-control" id="rgp_date" name="rgp_date" value="<?php if(isset($rgp_date)) echo $rgp_date; ?>"  >
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Expected date of Return</label>
                                            <input tabindex="2" type="date" class="form-control" id="return_date" name="return_date" value="<?php if(isset($return_date)) echo $return_date; ?>"  >
                                        </div>
                                    </div>
                                
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                            <label for="disabledInput">Company Name [Sending]</label>
                                            <select tabindex="4" type="text" class="form-control" id="company_id" name="company_id" >
                                                <option value="">Select Company Name</option>   
                                                    <?php if (sizeof($companyName)>0) { 
                                                    for($j=0;$j<count($companyName);$j++) { ?>
                                                    <option <?php if(isset($company_id)) { if($companyName[$j]['company_id'] == $company_id)  echo 'selected'; }  ?> 
                                                    value="<?php echo $companyName[$j]['company_id']; ?>">
                                                    <?php echo $companyName[$j]['company_name'];?></option>
                                                    <?php }} ?>  
                                            </select>
                                    </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                            <label for="disabledInput">Company Name [To]</label>
                                            <select tabindex="4" type="text" class="form-control" id="company_to" name="company_to" >
                                                <option value="">Select Company Name</option>   
                                                    <?php if (sizeof($companyName)>0) { 
                                                    for($j=0;$j<count($companyName);$j++) { ?>
                                                    <option <?php if(isset($company_id)) { if($companyName[$j]['company_id'] == $company_to)  echo 'selected'; }  ?> 
                                                    value="<?php echo $companyName[$j]['company_id']; ?>">
                                                    <?php echo $companyName[$j]['company_name'];?></option>
                                                    <?php }} ?>  
                                            </select>
                                    </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Branch Name [Sending]</label>
                                                <select tabindex="5" type="text" class="form-control" id="branch_from" name="branch_from"  >
                                                <option value="">Select Branch Name</option>   
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                        <label for="inputReadOnly">Branch Name [To]</label>
                                            <select tabindex="6" type="text" class="form-control" id="branch_to" name="branch_to"  >
                                                <option value="">Select Branch Name</option>   
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Address for Communication</label>
                                                <input type="text" class="form-control" id="from_comm_line1" name="from_comm_line1" 
                                                value="<?php if(isset($from_comm_line1)) echo $from_comm_line1; ?>" readonly>
                                                <input type="text" class="form-control" id="from_comm_line2" name="from_comm_line2" 
                                                value="<?php if(isset($from_comm_line2)) echo $from_comm_line2; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Address for Communication</label>
                                            <input type="text" class="form-control" id="to_comm_line1" name="to_comm_line1" 
                                            value="<?php if(isset($to_comm_line1)) echo $to_comm_line1; ?>" readonly>
                                            <input type="text" class="form-control" id="to_comm_line2" name="to_comm_line2" 
                                            value="<?php if(isset($to_comm_line2)) echo $to_comm_line2; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Asset Classification</label>
                                            <select tabindex="3" type="text" class="form-control" id="asset_class" name="asset_class" >
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
                                                <?php }} ?>   -->

                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Asset Name</label>
                                            <select tabindex="7" type="text" class="form-control" id="asset_name" name="asset_name"  >
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Value of Asset</label>
                                            <input type="text" class="form-control" id="asset_value" name="asset_value" 
                                            value="<?php if(isset($asset_value)) echo $asset_value; ?>" readonly> 
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Reason for RGP</label>
                                            <textarea tabindex="8" type="text" class="form-control" id="reason_rgp" name="reason_rgp" width="200px"> <?php if(isset($reason_rgp)) echo $reason_rgp; ?></textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($idupd > 0) { ?>
                <div class="card">
					<div class="card-header">
						<div class="card-title">Inward Extend</div>
					</div>
                    <div class="card-body">

                    	<div class="row ">
                            <!--Fields -->
                            <div class="col-md-8 "> 
                                <div class="row">
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="extended_date">Extended date of Return</label>
                                            <input type="date" class="form-control" id="extended_date" name="extended_date" value="<?php if (isset($extended_date))
                                                echo $extended_date; ?>"  >
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="extend_reason">Reason for Extend</label>
                                            <textarea type="text" class="form-control" id="extend_reason" name="extend_reason" width="200px"> <?php if (isset($extend_reason))
                                                echo $extend_reason; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <div class="col-md-12">
                    <br><br>
                    <div class="text-right">
                        <button type="submit" name="submit_asset_details" id="submit_asset_details" class="btn btn-primary" value="Submit" tabindex="9">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" tabindex="10" >Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



