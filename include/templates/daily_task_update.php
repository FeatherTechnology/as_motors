<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
}

$companyName = $userObj->getCompanyName($mysqli);
$departmentName = $userObj->getDepartment($mysqli);
$companyList = $userObj->getCompanyName($mysqli);

$id=0;
if(isset($_POST['dsffs']) && $_POST['fsfsd'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateAssignWork = $userObj->updateAssignWork($mysqli,$id);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_assign_work&msc=2';</script> 
    <?php	}
    else{   
        $addAssignWork = $userObj->addAssignWork($mysqli);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_assign_work&msc=1';</script>
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
	$deleteAssignWork = $userObj->deleteAssignWork($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_assign_work&msc=3';</script>
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
	$getAssignWorkList = $userObj->getAssignWork($mysqli,$idupd); 
	if (sizeof($getAssignWorkList)>0) {
        for($iwork=0;$iwork<sizeof($getAssignWorkList);$iwork++)  {	
            $company_id                      = $getAssignWorkList[0]['company_id'];
            $work_id                      = $getAssignWorkList[0]['work_id'];
			$department_id                	 = $getAssignWorkList[$iwork]['department_id'];
			$work_des          		 = $getAssignWorkList[$iwork]['work_des_id'];
			$work_des_text          		 = $getAssignWorkList[$iwork]['work_des_text'];
			$priority_id		             = $getAssignWorkList[$iwork]['priority_id'];
			$priority_name		             = $getAssignWorkList[$iwork]['priority_name'];
			$designation		             = $getAssignWorkList[$iwork]['designation'];
			$from_date		             = $getAssignWorkList[$iwork]['from_date'];
			$to_date		             = $getAssignWorkList[$iwork]['to_date'];
		}
	}
    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    $editDesignation = $userObj->getEditDesignationKRAKPI($mysqli, $department_id);
    ?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="departmentEdit" name="departmentEdit" value="<?php print_r($department_id); ?>" >
    <input type="hidden" id="work_descEdit" name="work_descEdit" value="<?php print_r($work_des); ?>" >
    <input type="hidden" id="designationEdit" name="designationEdit" value="<?php print_r($designation); ?>" >
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

            editBranchBasedDepartment();
            editDeptBasedWorkDesc();
        }

    // get department details
    function editBranchBasedDepartment(){ 

        var company_id = $('#company_nameEdit').val(); 
        var department_upd = $('#departmentEdit').val();

        $.ajax({
        url: 'KRA&KPIFile/ajaxKra&KpiDepartmentDetails.php',
        type: 'post',
        data: { "company_id":company_id },
        dataType: 'json',
        success:function(response){ 

            $('#department').empty();
            $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
            var r = 0;
            for (r = 0; r <= response.department_id.length - 1; r++) { 
                $('#department').append("<option value='" + response['department_id'][r] + "' >" + response['department_name'][r] + "</option>");
            }
        }
        });
    };

    // get department details
    function editDeptBasedWorkDesc(){ 

        var company_id = $('#company_nameEdit').val(); 
        var department_id = $('#departmentEdit').val();
        var department_upd = $('#departmentEdit').val();
        var work_desc = $('#work_descEdit').val();
        var designation = $('#designationEdit').val();

        $.ajax({
            url: 'assignworkFile/ajaxFetchWorkDescription.php',
            type: 'post',
            data: { "company_id":company_id, "department_id":department_id },
            dataType: 'json',
            success:function(response){ 
        
                // work description
                $('#work_des').empty();
                $('#work_des').prepend("<option value=''>" + 'Select Work Description' + "</option>");
                var r = 0;
                for (r = 0; r <= response.id.length - 1; r++) { 
                    $('#work_des').append("<option value='" + response['id'][r] + "' >" + response['name'][r] + "</option>");
                }

                // designation
                $('#designation').empty();
                $('#designation').prepend("<option value=''>" + 'Select Tag Classification' + "</option>");
                var r = 0;
                for (r = 0; r <= response.designation_id.length - 1; r++) {
                    $('#designation').append("<option value='" + response['designation_id'][r] + "' >" + response['designation_name'][r] + "</option>");
                }
            }
        });
    };
    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Daily Task Update </li>
    </ol>
   
    <!-- <a href="edit_daily_task">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a> -->
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "assign_work" name="assign_work" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($work_id)) echo $work_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($staffid)) echo $staffid; ?>"  id="staffid" name="staffid" >

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
                                                    <option value="<?php echo $sCompanyBranchDetail['company_id']; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
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
                                            <label for="disabledInput">Employee</label>
                                            <select tabindex="3" type="text" class="form-control" name="employee" id="employee">
                                                <option value="">Select employee</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="from_date">Date</label>
                                                <input type="date" tabindex = "9" name="current_date" id="current_date" class="form-control"  value="<?php echo Date('Y-m-d');?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group text-right">
                                        <label class="label" style="visibility: hidden;">View</label>
                                        <button type="button" tabindex="10" class="btn btn-primary" id="dailytask_update" name="dailytask_update" style="padding: 7px 35px;">View</button>
                                        </div>
                                    </div>

                            </div>  
                        </div>
                        
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card-body row">
                        <!-- alert messages -->
                        <div id="insertsuccess" class="successalert">Status Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                            </div>
                            <br>

                    <table id="dailyTaskTable" class="table custom-table">
                        <thead>
                            <tr>
                                <th>Task</th>
								<th>Status</th>
								<th>Remark</th>
								<th>File Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <br><br>
                <div class="text-right">
                    <button type="submit" name="submit_daily_task_update" id="submit_daily_task_update" class="btn btn-primary" value="Submit" tabindex="11">Submit</button>
                    <!-- <button type="reset" class="btn btn-outline-secondary" tabindex="12" id='reset'>Cancel</button> -->
                </div>
                <br><br>
            </div>
        </form>          
    </div>
