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
 if(isset($_POST['submitmedia_master']) && $_POST['submitmedia_master'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateCompanyCreationmaster = $userObj->updateMediaCreation($mysqli,$id);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_media_master&msc=2';</script> 
    <?php	}
    else{   
		$addCompanyCreation = $userObj->addMediaCreation($mysqli);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_media_master&msc=1';</script>
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
	$deleteCompanyCreation = $userObj->deleteMediaMaster($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_media_master&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getMediaMaster = $userObj->getMediaMaster($mysqli,$idupd); 
	
	if (sizeof($getMediaMaster)>0) {
        for($imedia=0;$imedia<sizeof($getMediaMaster);$imedia++)  {	
            $media_id                      = $getMediaMaster['media_id'];
            $company_id                      = $getMediaMaster['company_id'];
			$media_name          		 = $getMediaMaster['media_name'];
			$from_period      			       = $getMediaMaster['from_period'];
			$to_period		             = $getMediaMaster['to_period'];
			$platform    			         = $getMediaMaster['platform'];
			$media_file                	     = $getMediaMaster['media_file'];
            
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
        <li class="breadcrumb-item">AS - Media Master </li>
    </ol>
   
    <a href="edit_media_master">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>

</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "media_master" name="media_master" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($media_id)) echo $media_id; ?>"  id="id" name="id" aria-describedby="id">
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
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="company" name="company" >
                                                    <option value="">Select Company Name</option>   
                                                        <?php if (sizeof($companyName)>0) { 
                                                        for($j=0;$j<count($companyName);$j++) { ?>
                                                        <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id'])  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                        <?php echo $companyName[$j]['company_name'];?></option>
                                                        <?php }} ?>  
                                                </select>  
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <select disabled tabindex="1" type="text" class="form-control" id="company" name="company"  >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
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

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Media Name</label>
                                            <input tabindex="3" type="text" class="form-control" id="media_name" name="media_name" placeholder="Enter Media Name" 
                                            value= "<?php if(isset($media_name)) echo $media_name;?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Media File</label>
                                            <?php if(!isset($media_file) && $idupd<=0){ ?>
                                            <input type="file" tabindex="4" class="form-control" id="media_file" name="media_file" ></input>
                                            <?php }else{ ?>
                                            <input type="file" tabindex="4" class="form-control" id="media_file" name="media_file" ></input>   
                                            <input type="hidden"  name="edit_media_file" id="edit_media_file" value="<?php echo $media_file; ?>">
                                        <?php }?>      
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">From Period</label>
                                            <input tabindex="3" type="date" class="form-control" id="from_period" name="from_period" value= "<?php if(isset($from_period)) echo $from_period;?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">To Period</label>
                                            <input tabindex="3" type="date" class="form-control" id="to_period" name="to_period" value= "<?php if(isset($to_period)) echo $to_period;?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Platform</label>
                                            <select id="platform" name="platform" class="form-control">
                                                <option value=''>Select Platform </option>
                                                <option <?php if(isset($platform)) { if('Facebook' == $platform) echo 'selected'; ?> value="<?php echo 'Facebook' ?>">
                                                    <?php echo 'Facebook'; }else{ ?> <option value="Facebook">Facebook</option> <?php } ?></option>
                                                <option <?php if(isset($platform)) { if('Instagram' == $platform) echo 'selected'; ?> value="<?php echo 'Instagram' ?>">
                                                    <?php echo 'Instagram'; }else{ ?> <option value="Instagram">Instagram</option>   <?php } ?></option>
                                                <option <?php if(isset($platform)) { if('YouTube' == $platform) echo 'selected'; ?> value="<?php echo 'YouTube' ?>">
                                                    <?php echo 'YouTube'; }else{ ?> <option value="YouTube">YouTube</option>  <?php } ?></option>
                                                <option <?php if(isset($platform)) { if('TV Ads' == $platform) echo 'selected'; ?> value="<?php echo 'TV Ads' ?>">
                                                    <?php echo 'TV Ads'; }else{ ?> <option value="TV Ads">TV Ads</option>  <?php } ?></option>
                                            </select>             
                                        </div>
                                    </div>

                                </div>  
                            </div>

                            <div class="col-md-12">
                                <br><br>
                                <div class="text-right">
                                    <button type="submit" name="submitmedia_master" id="submitmedia_master" class="btn btn-primary" value="Submit" tabindex="5">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" tabindex="6" id='cancel'>Cancel</button>
                                </div>
                            </div>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
    </form>
</div>