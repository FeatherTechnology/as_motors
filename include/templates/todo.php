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
$departmentName = $userObj->getDepartment($mysqli);
$companyList = $userObj->getCompanyName($mysqli);
$tagClassificaition = $userObj->getTagClassification($mysqli);
$staffName = $userObj->getStaff($mysqli);
$projectCreationList = $userObj->getProjectCreationList($mysqli);

$id=0;
if(isset($_POST['submitTodo']) && $_POST['submitTodo'] != '')
{
    
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateTodo = $userObj->updateTodo($mysqli,$id,$userid);  
        ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_todo&msc=2';</script> 
    <?php }
    else {   
		$addTodo = $userObj->addTodo($mysqli,$userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_todo&msc=1';</script>
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
	$deleteTodo = $userObj->deleteTodo($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_todo&msc=3';</script>
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
	$getTodoList = $userObj->getTodo($mysqli,$idupd); 
	
	if (sizeof($getTodoList)>0) {
        for($iwork=0;$iwork<sizeof($getTodoList);$iwork++)  {	
            $company_id                  = $getTodoList['company_id'];
            $todo_id                     = $getTodoList['todo_id'];
            $work_des          		     = $getTodoList['work_des'];
            // $tag_id      			     = $getTodoList['tag_id'];
			$priority		             = $getTodoList['priority'];
			$assign_to		             = $getTodoList['assign_to'];
            $from_date    	             = date('Y-m-d',strtotime($getTodoList['from_date'])); 
			$to_date    	             = date('Y-m-d',strtotime($getTodoList['to_date'])); 
			$criteria		             = $getTodoList['criteria'];
			$project_id		             = $getTodoList['project_id'];
		}
	}

    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - To Do Creation</li>
    </ol>

    <a href="edit_todo">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
        </a>

</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "todo" name="todo" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($todo_id)) echo $todo_id; ?>"  id="id" name="id" placeholder="Enter id">

<input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php if(isset($company_id)) echo $company_id; ?>" >
<input type="hidden" id="staffEdit" name="staffEdit" value="<?php if(isset($assign_to)) echo $assign_to; ?>" >
<!-- <input type="hidden" id="tagEdit" name="tagEdit" value="" > -->
<input type="hidden" id="criteriaEdit" name="criteriaEdit" value="<?php if(isset($criteria)) echo $criteria; ?>" >
<input type="hidden" id="idupd" name="idupd" value="<?php if(isset($idupd)) echo $idupd; ?>" >

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

                                    <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Department</label>
                                            <select tabindex="3" type="text" class="form-control" name="department_id" id="department_id">
                                                <option value="">Select Department</option>
                                            </select>
                                        </div>
                                    </div> -->


                                    <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Tag Classification</label>
                                            <select tabindex="5" type="text" class="form-control" name="tag_id" id="tag_id">
                                                <option value="">Select Tag Classification</option>
                                            </select>
                                        </div>
                                    </div> -->

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Priority</label>
                                            <select tabindex="6" type="text" class="form-control" name="priority" id="priority">
                                                <option value="">Select Priority</option>
                                                <option value="1" <?php if(isset($priority) && $priority == '1') echo 'selected'; ?>>High</option>
                                                <option value="2" <?php if(isset($priority) && $priority == '2') echo 'selected'; ?>>Medium</option>
                                                <option value="3" <?php if(isset($priority) && $priority == '3') echo 'selected'; ?>>Low</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Assign to</label>
                                            <select tabindex="7" type="text" class="form-control" name="assign_to[]" id="assign_to" multiple>
                                                <option value="">Select Assign to</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="from_date">Start Date & End Date</label>
                                            <div class="form-inline">
                                                <input type="date" tabindex = "8" name="from_date" id="from_date" placeholder="From" class="form-control"  value="<?php if (isset($from_date)) echo $from_date;?>">&nbsp;&nbsp;
                                                <span>To</span>&nbsp;&nbsp;<input type="date" tabindex = "9" name="to_date" id="to_date" placeholder="To" class="form-control"  value="<?php if (isset($to_date)) echo $to_date;?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="from_date">Criteria</label>
                                            <select tabindex="8" type="text" class="form-control criteria" id="criteria" name="criteria" >
                                                <option value="">Select Criteria</option>   
                                                <option <?php if(isset($criteria)) { if('Event' == $criteria) echo 'selected'; ?> value="<?php echo 'Event' ?>">
                                                <?php echo 'Event'; }else{ ?> <option value="Event">Event</option> <?php } ?></option>
                                                <option <?php if(isset($criteria)) { if('Project' == $criteria) echo 'selected'; ?> value="<?php echo 'Project' ?>">
                                                <?php echo 'Project'; }else{ ?> <option value="Project">Project</option> <?php } ?></option> 
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Project</label>
                                            <select readonly tabindex="3" type="text" class="form-control project" id="project" name="project" >
                                                <option value="">Select Project</option>   
                                                <?php if (sizeof($projectCreationList)>0) { 
                                                for($j=0;$j<count($projectCreationList);$j++) { ?>
                                                <option <?php if(isset($project_id)) { if($projectCreationList[$j]['project_id'] == $project_id )  echo 'selected'; } ?> value="<?php echo $projectCreationList[$j]['project_id']; ?>">
                                                <?php echo $projectCreationList[$j]['project_name'];?></option>
                                                <?php } } ?>  
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-4 col-sm-4 col-12" style="margin-top: 19px;">
										<div class="form-group float-right">
                                            <button disabled type="button" tabindex="4" class="btn btn-primary" id="add_CategoryDetails" name="add_CategoryDetails" data-toggle="modal" data-target=".addProjectModal" style="padding: 5px 35px;"><span class="icon-add"></span></button>
										</div>
									</div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Work Description</label>
                                            <textarea tabindex="1" id="work_des" name="work_des" class="form-control" placeholder="Enter Work Description" rows="4" cols="50" value="<?php if(isset($work_des)) echo $work_des; ?>"><?php if(isset($work_des)) echo $work_des; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <br><br>
                                        <div class="text-right">
                                            <button type="submit" name="submitTodo" id="submitTodo" class="btn btn-primary" value="Submit" tabindex="10">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary" tabindex="11" id='reset'>Cancel</button>
                                        </div>
                                        <br><br>
                                    </div>
                            </div>  
                        </div>
                        </div>
                    </div>
                </div>
        </form>          
    </div>


    <!-- Add Course Project Modal -->
<div class="modal fade addProjectModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: white">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DropDownCourse()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- alert messages -->
                <div id="categoryInsertNotOk" class="unsuccessalert">Project Already Exists, Please Enter a Different Name!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryInsertOk" class="successalert">Project Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryUpdateOk" class="successalert">Project Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Project!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryDeleteOk" class="successalert">Project Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <br />
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label class="label">Enter Project</label>
                            <input type="hidden" name="project_id" id="project_id">
                            <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Enter Project">
                            <span class="text-danger" id="projectnameCheck">Enter Project</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                            <label class="label" style="visibility: hidden;">Project</label>
                        <button type="button" name="submitProjectModal" id="submitProjectModal" class="btn btn-primary">Submit</button>
                    </div>
                </div>

                <div id="updatedprojectTable"> 
                    <table class="table custom-table" id="projectTable"> 
                        <thead>
                            <tr>
                                <th>S. No</th>
                                <th>PROJECT</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (sizeof($projectCreationList)>0) { 
                                for($j=0;$j<count($projectCreationList);$j++) { ?>
                                <tr>
                                    <td class="col-md-2 col-xl-2"><?php echo $j+1; ?></td>
                                    <td><?php  echo $projectCreationList[$j]['project_name']; ?></td>
                                    <td>
                                        <a id="edit_project" value="<?php echo $projectCreationList[$j]['project_id'] ?>"><span class="icon-border_color"></span></a> &nbsp
                                        <a id="delete_project" value="<?php echo $projectCreationList[$j]['project_id'] ?>"><span class='icon-trash-2'></span></a>
                                    </td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownCourse()">Close</button>
            </div>

        </div>
    </div>
</div>
