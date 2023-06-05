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
$companyList = $userObj->getCompanyName($mysqli);

$id=0;
if(isset($_POST['submittag_creation']) && $_POST['submittag_creation'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateTagCreationmaster = $userObj->updateTagCreation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_tag_creation&msc=2';</script> 
    <?php }
    else {   
        $addTagCreation = $userObj->addTagCreation($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_tag_creation&msc=1';</script>
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
	$deleteTagCreation = $userObj->deleteTagCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_tag_creation&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getTagCreation = $userObj->getTagCreation($mysqli,$idupd); 
	
	if (sizeof($getTagCreation)>0) {
        for($itag=0;$itag<sizeof($getTagCreation);$itag++)  {

            $tag_id                  = $getTagCreation['tag_id']; 
            $company_id                	     = $getTagCreation['company_id']; 
            $branch_id                	     = $getTagCreation['branch_id']; 
			$department                	 = $getTagCreation['department_id'];
			$tag_classification    	     = $getTagCreation['tag_classification'];
		}
	} 
    // $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_id);
    $companyArr = explode(",", $company_id);
    ?>

    <input type="text" id="companyIdEdit" name="companyIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="text" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($branch_id); ?>" >
    <input type="text" id="departmentEdit" name="departmentEdit" value="<?php print_r($department); ?>" >

    <script language='javascript'>
        window.onload=editTagCreation;
        function editTagCreation(){ 
            // edit department name
            // var branch_id = $("#companyIdEdit").val(); 
            var branchId = $("#branchIdEdit").val(); 
            var departmentEdit = $("#departmentEdit").val(); 

            $.ajax({
                url: 'tagFile/getDepartmentDetails.php',
                type: 'post',
                data: { "branch_id":branchId },
                dataType: 'json',
                success: function(response){ 

                    $('#department_id').empty();
                    $('#department_id').prepend("<option value=''>" + 'Select Department' + "</option>");
                    var i = 0;
                    for (i = 0; i <= response.departmentId.length - 1; i++) {
                        var selected = "";
                        if(response['departmentId'][i] == departmentEdit)
                        {
                            selected = "selected";
                        }
                        $('#department_id').append("<option value='" + response['departmentId'][i] + "' "+selected+">" + response['departmentName'][i] + "</option>");
                    }
                }
            });
            
            editCompanyBasedBranch(branchId);
        }
    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Tag Creation </li>
    </ol>

    <a href="edit_tag_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "tag_creation" name="tag_creation" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($tag_id)) echo $tag_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                            
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id[]" multiple >
                                                    <option value="">Select Company Name</option>   
                                                        <?php if (sizeof($companyName)>0) { 
                                                            for($j=0;$j<count($companyName);$j++) { ?>
                                                                <option <?php  
                                                                    if (isset($companyArr)) { 
                                                                        for ($i=0; $i < count($companyArr); $i++){ 
                                                                            if($companyName[$j]['company_id'] == $companyArr[$i] ) echo "selected"; 
                                                                        }
                                                                    } 
                                                                    ?> value="<?php echo $companyName[$j]['company_id']; ?>"> <?php echo $companyName[$j]['company_name']; ?>
                                                                </option>
                                                        <?php }} ?>  
                                                </select>  
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id[]" multiple >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>
                                    
                                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Branch Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="branch_id" name="branch_id[]" multiple >
                                                    <option value="" disabled>Select Branch Name</option> 
                                                </select> 
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >
                                                <select tabindex="1" type="text" class="form-control" id="branch_id1" name="branch_id1[]" multiple >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Department</label>
                                            <select tabindex="3" type="text" class="form-control" name="department_id" id="department_id">
                                                <option value="">Select Department</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Tag Classification</label>
                                            <textarea class="form-control" tabindex="4" id="tag_classification" name="tag_classification" 
                                            value="<?php if(isset($tag_classification)) echo $tag_classification; ?>" placeholder="Enter Tag Classification"><?php if(isset($tag_classification)) echo $tag_classification; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                        <br><br>
                        <div class="text-right">
                            <button type="submit" name="submittag_creation" id="submittag_creation" class="btn btn-primary" value="Submit" tabindex="5">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" tabindex="6">Cancel</button>
                        </div>
                    </div>

                    </div>
                    
                    </div>
                </div>
            </div>
       
    </form>

    <!-- <div class="row gutters">
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
						<div class="alert-text">Tag Added Successfully!</div>
					</div> 
					<?php
					}
					if($mscid==2)
					{?>
						<div class="alert alert-success" role="alert">
						<div class="alert-text">Tag Updated Successfully!</div>
					</div>
					<?php
					}
					if($mscid==3)
					{?>
					<div class="alert alert-danger" role="alert">
						<div class="alert-text">Tag Inactive Successfully!</div>
					</div>
					<?php
					}
					}
					?>
					<table id="tagCreation_info" class="table custom-table">
						<thead>
							<tr>
								<th>S. No.</th>
								<th>Company Name</th>
								<th>Department Name</th>
								<th>Tag Classification</th>
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
	</div> -->

</div>

<!-- <script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);
</script> -->