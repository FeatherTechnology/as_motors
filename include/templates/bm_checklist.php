<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 

$categoryCreationList = $userObj->getCategoryCreationList($mysqli);
$companyName = $userObj->getCompanyName($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$companyList = $userObj->getCompanyName($mysqli);

$id=0;
if(isset($_POST['submittag_creation']) && $_POST['submittag_creation'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateBMChecklist = $userObj->updateBMChecklist($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_bm_checklist&msc=2';</script> 
    <?php }
    else{   
        $addBMChecklist = $userObj->addBMChecklist($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_bm_checklist&msc=1';</script>
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
	$deleteBMChecklist = $userObj->deleteBMChecklist($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_bm_checklist&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getBMChecklist = $userObj->getBMChecklist($mysqli,$idupd); 
	
	if (sizeof($getBMChecklist)>0) {
        for($itag=0;$itag<sizeof($getBMChecklist);$itag++)  {

            $bm_checklist_id                  = $getBMChecklist['bm_checklist_id']; 
            $company_id                	     = $getBMChecklist['company_id'];
			$category_id                	 = $getBMChecklist['category_id'];
			$checklist    	     = $getBMChecklist['checklist'];
			$rating    	     = $getBMChecklist['rating'];
		}
	} 
    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);

    $getBMChecklistDetails = $userObj->getBMcheckListDetails($mysqli, $bm_checklist_id);
    ?>

    <input type="text" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >

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
        }
    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - BM Checklist</li>
    </ol>
    <a href="edit_bm_checklist">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "edit_ pm_checklist" name="edit_ pm_checklist" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($bm_checklist_id)) echo $bm_checklist_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
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

                                    <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div> -->
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
										<div class="form-group">
											<label for="disabledInput">Category</label>
											<select tabindex="3" type="text" class="form-control" id="category_id" name="category_id" >
												<option value="">Select Category</option>   
												<?php if (sizeof($categoryCreationList)>0) { 
												for($j=0;$j<count($categoryCreationList);$j++) { ?>
												<option <?php if(isset($category_id)) { if($categoryCreationList[$j]['category_creation_id'] == $category_id )  echo 'selected'; }  ?> value="<?php echo $categoryCreationList[$j]['category_creation_id']; ?>">
												<?php echo $categoryCreationList[$j]['category_creation_name'];?></option>
												<?php }} ?>  
											</select> 
											<!-- <span id="loanCategoryCheck" class="text-danger" >Select Loan Category</span> -->
										</div>
									</div>
									<div class="col-xl-1 col-lg-1 col-md-4 col-sm-4 col-12" style="margin-top: 19px;">
										<div class="form-group float-right">
											<button type="button"  tabindex="4" class="btn btn-primary" id="add_CategoryDetails" name="add_CategoryDetails" data-toggle="modal" data-target=".addCategoryModal" style="padding: 5px 35px;"><span class="icon-add"></span></button>
										</div>
									</div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Checklist</label>
                                            <textarea class="form-control" tabindex="5" id="checklist" name="checklist" rows="4" cols="50"
                                            value="<?php if(isset($checklist)) echo $checklist; ?>" placeholder="Enter Checklist"><?php if(isset($checklist)) echo $checklist; ?></textarea>
                                        </div>
                                    </div>

                                    <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div> -->
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
										<div class="form-group">
											<label for="disabledInput">Rating</label>
                                            <select type="text" class="form-control" id="rating" name="rating" tabindex="6" >
                                                <option value="">Select Rating</option> 
                                                <option <?php if(isset($rating)) { if('High' == $rating) echo 'selected';  ?> value="<?php echo 'High' ?>">
                                                <?php echo 'High'; }else{ ?> <option value="High">High</option>   <?php } ?></option>
                                                <option <?php if(isset($rating)) { if('Medium' == $rating) echo 'selected';  ?> value="<?php echo 'Medium' ?>">
                                                <?php echo 'Medium'; }else{ ?> <option value="Medium">Medium</option> <?php } ?></option> 
                                                <option <?php if(isset($rating)) { if('Low' == $rating) echo 'selected';  ?> value="<?php echo 'Low' ?>">
                                                <?php echo 'Low'; }else{ ?> <option value="Low">Low</option> <?php } ?></option> 
                                            </select> 
										</div>
									</div>

                                    <div class="col-xl-1 col-lg-1 col-md-4 col-sm-4 col-12" >
                                        <div class="form-group">
                                        <label class="label" style="visibility: hidden;">Add</label>
                                        <button type="button"  tabindex="5" class="btn btn-primary" id="add_bmchecklistDetails" name="add_bmchecklistDetails" style="padding: 7px 35px;">Add</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="card-header">List</div>
                                <label><span class="text-danger" id="checkRowAppend" style="display:none;"> Please fill all the fields </span></label>
                                <table id="bm_checklist_row_append" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Checklist</th>
                                            <th>Rating</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($idupd > 0){ 
                                        
                                            if(isset($getBMChecklistDetails)){
                                                $cnt = $getBMChecklistDetails['cnt']; //Directly Getting Count from while loop , Based on count for will run.

                                                for($i = 0; $i < $cnt ; $i++){  ?>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" readonly name="add_id[]" id="add_id" class="form-control" value="<?php echo $getBMChecklistDetails[$i]['id']; ?>" >
                                                                <input type="text" readonly name="category_val[]" id="category_val" class="form-control" value="<?php echo $getBMChecklistDetails[$i]['category_name']; ?>" >
                                                            </td>
                                                            <td>
                                                                <input type="text" readonly name="checklist_add[]" id="checklist_add" class="form-control" value="<?php echo $getBMChecklistDetails[$i]['checklist_add']; ?>" >
                                                            </td>
                                                            <td>
                                                                <input type="text" readonly name="table_rating[]" id="table_rating" class="form-control" value="<?php echo $getBMChecklistDetails[$i]['rating_add']; ?>" >
                                                            </td>
                                                            <td>
                                                                <span onclick='onDelete(this);' class='icon-trash-2'></span>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } 
                                            } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>

                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submittag_creation" id="submittag_creation" class="btn btn-primary" value="Submit" tabindex="7">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="8">Cancel</button>
                            </div>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
       
    </form>
</div>

<!-- Add Course Category Modal -->
<div class="modal fade addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: white">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DropDownCourse()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- alert messages -->
                <div id="categoryInsertNotOk" class="unsuccessalert">Category Already Exists, Please Enter a Different Name!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryInsertOk" class="successalert">Category Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryUpdateOk" class="successalert">Category Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Category!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryDeleteOk" class="successalert">Category Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <br />
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label class="label">Enter Category</label>
                            <input type="hidden" name="category_creation_id" id="category_creation_id">
                            <input type="text" name="category_creation_name" id="category_creation_name" class="form-control" placeholder="Enter Category">
                            <span class="text-danger" id="loancategorynameCheck">Enter Category</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                            <label class="label" style="visibility: hidden;">Category</label>
                        <button type="button" name="submitLoanCategoryModal" id="submitLoanCategoryModal" class="btn btn-primary">Submit</button>
                    </div>
                </div>

                <div id="updatedloancategoryTable"> 
                    <table class="table custom-table" id="coursecategoryTable"> 
                        <thead>
                            <tr>
                                <th>S. No</th>
                                <th>CATEGORY</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (sizeof($categoryCreationList)>0) { 
                                for($j=0;$j<count($categoryCreationList);$j++) { ?>
                                <tr>
                                    <td class="col-md-2 col-xl-2"><?php echo $j+1; ?></td>
                                    <td><?php  echo $categoryCreationList[$j]['category_creation_name']; ?></td>
                                    <td>
                                        <a id="edit_category" value="<?php echo $categoryCreationList[$j]['category_creation_id'] ?>"><span class="icon-border_color"></span></a> &nbsp
                                        <a id="delete_category" value="<?php echo $categoryCreationList[$j]['category_creation_id'] ?>"><span class='icon-trash-2'></span></a>
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