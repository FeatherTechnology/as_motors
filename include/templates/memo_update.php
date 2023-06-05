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
if(isset($_POST['submitMemoBtn']) && $_POST['submitMemoBtn'] != '')
{
if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){     
    $id = $_POST['id'];     
$updateMemo = $userObj->updateMemoUpdate($mysqli,$id,$userid);  
?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_memo_update&msc=2';</script> 
<?php }
}   

if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
    $getMemo = $userObj->getMemo($mysqli,$idupd); 
    if (sizeof($getMemo)>0) {
        for($itag=0;$itag<sizeof($getMemo);$itag++) {

            $memo_id                 = $getMemo['memo_id']; 
            $company_id              = $getMemo['company_id'];
            $to_department      = $getMemo['to_department'];
            $inquiry      = $getMemo['inquiry'];
            $suggestion      = $getMemo['suggestion'];
            $attachment      = $getMemo['attachment'];
            $assign_employee      = $getMemo['assign_employee'];
            $priority      = $getMemo['priority'];
            $completion_target_date      = $getMemo['completion_target_date'];
            $initial_phase      = $getMemo['initial_phase'];
            $final_phase      = $getMemo['final_phase'];
            $update_attachment      = $getMemo['update_attachment'];
        }
    } 

    $assignEmployeeName = $userObj->getAssignEmployeeName($mysqli, $to_department);  
    $initialPhaseName = $userObj->getInitialPhase($mysqli, $assign_employee);  
    $finalPhaseName = $userObj->getFinalPhase($mysqli, $initial_phase);  
    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);

    ?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="to_deptEdit" name="to_deptEdit" value="<?php print_r($to_department); ?>" >

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

            getdepartmentLoad(branch_id);
        }

        // get department details
        function getdepartmentLoad(branch_id){ 

            var to_dept = $('#to_deptEdit').val(); 
            $.ajax({
            url: 'memoFile/ajaxR&RDepartmentDetailsLoad.php',
            type: 'post',
            data: {'branch_id': branch_id},
            dataType: 'json',
            success:function(response){     
                
                $("#to_department").empty();
                $("#to_department").prepend("<option value=''>"+'To Department'+"</option>");
                var i = 0; 
                for (i = 0; i <= response.department_id.length - 1; i++) {   
                    var selected = "";
                    if(to_dept == response['department_id'][i]){ 
                        selected = "selected";
                    }
                    $('#to_department').append("<option value='" + response['department_id'][i] + "' "+"selected"+">" + response['department_name'][i] + "</option>");
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
        <li class="breadcrumb-item">AS - Memo Assigned</li>
    </ol>

    <a href="edit_memo_update">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
                <!-- Page header end -->

                <!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "edit_memo" name="edit_memo" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($memo_id)) echo $memo_id ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                                                <select tabindex="1" disabled type="text" class="form-control" id="company_id" name="company_id"  >
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
                                    
                                   <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Branch Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select disabled tabindex="2" type="text" class="form-control" id="branch_id" name="branch_id" >
                                                    <option value="" disabled selected>Select Branch Name</option> 
                                                </select> 
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >
                                                <select disabled tabindex="1" type="text" class="form-control" id="branch_id1" name="branch_id1" >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">To Department</label>
                                            <?php if(!isset($to_department) && $idupd<=0){ ?>
                                                <select disabled tabindex="2" type="text" class="form-control" id="to_department" name="to_department" >
                                                    <option value="">Select Department</option> 
                                                </select>  
                                            <?php } else { ?>
                                                <select disabled tabindex="1" type="text" class="form-control" id="to_department" name="to_department" >
                                                    <option value="">Select To Department</option>   
                                                    <?php if (sizeof($fromDepartmentName)>0) { 
                                                    for($j=0;$j<count($fromDepartmentName);$j++) { ?>
                                                    <option <?php if(isset($to_department)) { if($fromDepartmentName[$j]['department_id'] == $to_department)  echo 'selected'; }  ?> value="<?php echo $fromDepartmentName[$j]['department_id']; ?>">
                                                    <?php echo $fromDepartmentName[$j]['department_name'];?></option>
                                                    <?php }} ?> 
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Assign Employee</label>
                                            <?php if(!isset($assign_employee) && $idupd<=0){ ?>
                                                <select disabled tabindex="2" type="text" class="form-control" id="assign_employee" name="assign_employee" >
                                                    <option value="">Assign Employee</option> 
                                                </select>  
                                            <?php } else { ?>
                                                <select disabled tabindex="1" type="text" class="form-control" id="assign_employee" name="assign_employee" >
                                                    <option value="">Assign Employee</option>   
                                                    <?php if (sizeof($assignEmployeeName)>0) { 
                                                    for($i=0;$i<count($assignEmployeeName);$i++) { ?>
                                                    <option <?php if(isset($assign_employee)) { if($assignEmployeeName[$i]['staff_id'] == $assign_employee)  echo 'selected'; }  ?> value="<?php echo $assignEmployeeName[$i]['staff_id']; ?>">
                                                    <?php echo $assignEmployeeName[$i]['staff_name'];?></option>
                                                    <?php }} ?> 
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Priority</label>
                                            <select disabled tabindex="4" type="text" class="form-control" name="priority" id="priority">
                                                <option value="">Select Priority</option>
                                                <option value="1" <?php if(isset($priority) && $priority == '1') echo 'selected'; ?>>High</option>
                                                <option value="2" <?php if(isset($priority) && $priority == '2') echo 'selected'; ?>>Medium</option>
                                                <option value="3" <?php if(isset($priority) && $priority == '3') echo 'selected'; ?>>Low</option>
                                            </select> 
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Inquiry</label>
                                            <textarea readonly class="form-control" tabindex="3" rows="4" cols="50" id="inquiry" name="inquiry" 
                                            value="<?php if(isset($inquiry)) echo $inquiry; ?>" placeholder="Enter Inquiry"><?php if(isset($inquiry)) echo $inquiry; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Suggestion</label>
                                            <textarea readonly class="form-control" tabindex="3" rows="4" cols="50" id="suggestion" name="suggestion" 
                                            value="<?php if(isset($suggestion)) echo $suggestion; ?>" placeholder="Enter Suggestion"><?php if(isset($suggestion)) echo $suggestion; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Attachment</label>
                                            <div style="border: 2px solid black; height:auto;padding:10px;" id="fileList">
                                                <a href="uploads/memo/<?php echo $attachment; ?>" download><li><?php echo $attachment; ?></li></a>
                                            </div>  
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Traget Date For Completion</label>
                                            <input readonly type="date" tabindex="3" id="completion_target_date" name="completion_target_date" class="form-control"  value="<?php if(isset($completion_target_date)) echo $completion_target_date; ?>" >
                                        </div>
                                    </div>

                                </div>

                                <br>
                                <div class="card-header">Escalation Matrix</div>
                                <br>

                                <div class="row">
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Initial Phase</label>
                                                <select disabled tabindex="1" type="text" class="form-control" id="initial_phase" name="initial_phase" >
                                                    <option value="">Assign Employee</option>   
                                                    <?php if (sizeof($initialPhaseName)>0) { 
                                                    for($i=0;$i<count($initialPhaseName);$i++) { ?>
                                                    <option <?php if(isset($initial_phase)) { if($initialPhaseName[$i]['staff_id'] == $initial_phase)  echo 'selected'; }  ?> value="<?php echo $initialPhaseName[$i]['staff_id']; ?>">
                                                    <?php echo $initialPhaseName[$i]['reporting'];?></option>
                                                    <?php }} ?> 
                                            </select>
                                      
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Final Phase</label>
                                                <select disabled tabindex="1" type="text" class="form-control" id="final_phase" name="final_phase" >
                                                    <option value="">Assign Employee</option>   
                                                    <?php if (sizeof($finalPhaseName)>0) { 
                                                    for($i=0;$i<count($finalPhaseName);$i++) { ?>
                                                    <option <?php if(isset($final_phase)) { if($finalPhaseName[$i]['staff_id'] == $final_phase)  echo 'selected'; }  ?> value="<?php echo $finalPhaseName[$i]['staff_id']; ?>">
                                                    <?php echo $finalPhaseName[$i]['reporting'];?></option>
                                                    <?php }} ?> 
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Date Of Completion</label>
                                            <input type="date" tabindex="3" id="date_of_completion" name="date_of_completion" class="form-control"  value="<?php if(isset($date_of_completion)) echo $date_of_completion; ?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Update Attachment</label>
                                            <?php if(!isset($update_attachment) && $idupd<=0){ ?>
                                                <input type="file" tabindex="3" class="form-control" id="update_attachment" name="update_attachment" ></input>   
                                            <?php } else { ?>
                                                <input type="file" tabindex="3" class="form-control" id="update_attachment" name="update_attachment" ></input>   
                                                <input type="hidden" name="edit_update_attachment" id="edit_update_attachment" value="<?php echo $update_attachment; ?>" >
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Narration</label>
                                            <textarea class="form-control" tabindex="3" rows="4" cols="50" id="narration" name="narration" 
                                            value="<?php if(isset($narration)) echo $narration; ?>" placeholder="Enter narration"><?php if(isset($narration)) echo $narration; ?></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submitMemoBtn" id="submitMemoBtn" class="btn btn-primary" value="Submit" tabindex="4">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="5">Cancel</button>
                            </div>
                        </div>  
                    </div>
                    
                </div>
            </div>
        </div>
    </form>
</div>

