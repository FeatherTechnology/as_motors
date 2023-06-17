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
        $updatePMChecklist = $userObj->updatePMChecklist($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_pm_checklist&msc=2';</script> 
    <?php }
    else{   
        $addPMChecklist = $userObj->addPMChecklist($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_pm_checklist&msc=1';</script>
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
	$deletePMChecklist = $userObj->deletePMChecklist($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_pm_checklist&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getPMChecklist = $userObj->getPMChecklist($mysqli,$idupd); 
	
	if (sizeof($getPMChecklist)>0) {
        for($itag=0;$itag<sizeof($getPMChecklist);$itag++)  {

            $pm_checklist_id                  = $getPMChecklist['pm_checklist_id']; 
            $company_id                	     = $getPMChecklist['company_id'];
			$category_id                	 = $getPMChecklist['category_id'];
			$checklist    	     = $getPMChecklist['checklist'];
			$type_of_checklist    	     = $getPMChecklist['type_of_checklist'];
			$yes_no_na    	     = $getPMChecklist['yes_no_na'];
			$no_of_option    	     = $getPMChecklist['no_of_option'];
			$option1    	     = $getPMChecklist['option1'];
			$option2    	     = $getPMChecklist['option2'];
			$option3    	     = $getPMChecklist['option3'];
			$option4    	     = $getPMChecklist['option4'];
			$frequency    	     = $getPMChecklist['frequency'];
			$frequency_applicable    	     = $getPMChecklist['frequency_applicable'];
			$rating    	     = $getPMChecklist['rating'];
		}
	} 
    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);

    $getPMChecklistDetails = $userObj->getPMcheckListDetails($mysqli, $pm_checklist_id);
    ?>

    <input type="text" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="text" id="type_of_checklistEdit" name="type_of_checklistEdit" value="<?php print_r($type_of_checklist); ?>" >
    <input type="text" id="no_of_optiontEdit" name="no_of_optiontEdit" value="<?php print_r($no_of_option); ?>" >
    <input type="hidden" id="frequencyEdit" name="frequencyEdit" value="<?php print_r($frequency); ?>" >

    <script language='javascript'>
        window.onload=editCompanyBasedBranch;
        // company based branch
        function editCompanyBasedBranch(branch_id){  

            var branch_id = $("#branchIdEdit").val();
            var type_of_checklist = $("#type_of_checklistEdit").val();
            var no_of_option = $("#no_of_optiontEdit").val();

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

            // Hide and show type of checklist
            if(type_of_checklist == "Yes/No/NA"){
                $(".yes_no_na").css("display", "block");
                $(".no_of_option").css("display", "none");
                $(".options").css("display", "none");
            }else if(type_of_checklist == "Option"){
                $(".yes_no_na").css("display", "none");
                $(".no_of_option").css("display", "block");
                $(".options").css("display", "block");
            }else if(type_of_checklist == ""){
                $(".yes_no_na").css("display", "none");
                $(".no_of_option").css("display", "none");
                $(".options").css("display", "none");
            }

            // option enable and disable
            if(no_of_option == 1){
                $("#option1").attr("readonly", false); 
                $("#option2").attr("readonly", false); 
                $("#option3").attr("readonly", true); 
                $("#option4").attr("readonly", true); 
            }else if(no_of_option == 2){
                $("#option1").attr("readonly", false); 
                $("#option2").attr("readonly", false); 
                $("#option3").attr("readonly", true); 
                $("#option4").attr("readonly", true); 
            }else if(no_of_option == 3){
                $("#option1").attr("readonly", false); 
                $("#option2").attr("readonly", false); 
                $("#option3").attr("readonly", false); 
                $("#option4").attr("readonly", true); 
            }else if(no_of_option == 4){
                $("#option1").attr("readonly", false); 
                $("#option2").attr("readonly", false); 
                $("#option3").attr("readonly", false); 
                $("#option4").attr("readonly", false); 
            }else if(no_of_option == ""){
                $("#option1").attr("readonly", true); 
                $("#option2").attr("readonly", true); 
                $("#option3").attr("readonly", true); 
                $("#option4").attr("readonly", true); 
            }

            // enable and disable frequency
            var frequency = $('#frequencyEdit').val(); 
            if(frequency == 'Fortnightly' || frequency == 'Monthly' || frequency == 'Quaterly' || frequency == 'Half Yearly' ){
                $('#frequency_applicable').attr("disabled",false);
            } else  if(frequency == 'Event Driven' || frequency == 'Yearly'){ 
                $('#frequency_applicable').prop('checked', false);
                $('#frequency_applicable').attr("disabled",true);
            }
        }
    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - PM Checklist</li>
    </ol>
    <a href="edit_pm_checklist">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--form start-->
    <form id = "edit_ pm_checklist" name="edit_ pm_checklist" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($pm_checklist_id)) echo $pm_checklist_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
										</div>
									</div>
									<div class="col-xl-1 col-lg-1 col-md-4 col-sm-4 col-12" style="margin-top: 19px;">
										<div class="form-group float-right">
											<button type="button" tabindex="4" class="btn btn-primary" id="add_CategoryDetails" name="add_CategoryDetails" data-toggle="modal" data-target=".addCategoryModal" style="padding: 5px 35px;"><span class="icon-add"></span></button>
										</div>
									</div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Checklist</label>
                                            <textarea tabindex="5" class="form-control" id="checklist" name="checklist" rows="4" cols="50"
                                            value="<?php if(isset($checklist)) echo $checklist; ?>" placeholder="Enter Checklist"><?php if(isset($checklist)) echo $checklist; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
										<div class="form-group">
											<label for="disabledInput">Frequency</label>
                                            <select type="text" class="form-control frequency" id="frequency" name="frequency" tabindex="15" >
                                                <option value="">Select Frequency</option> 
                                                <option <?php if(isset($frequency)) { if('Fortnightly' == $frequency) echo 'selected';  ?> value="<?php echo 'Fortnightly' ?>">
                                                <?php echo 'Fortnightly'; }else{ ?> <option value="Fortnightly">Fortnightly</option>   <?php } ?></option>
                                                <option <?php if(isset($frequency)) { if('Monthly' == $frequency) echo 'selected';  ?> value="<?php echo 'Monthly' ?>">
                                                <?php echo 'Monthly'; }else{ ?> <option value="Monthly">Monthly</option> <?php } ?></option> 
                                                <option <?php if(isset($frequency)) { if('Quaterly' == $frequency) echo 'selected';  ?> value="<?php echo 'Quaterly' ?>">
                                                <?php echo 'Quaterly'; }else{ ?> <option value="Quaterly">Quaterly</option> <?php } ?></option> 
                                                <option <?php if(isset($frequency)) { if('Half Yearly' == $frequency) echo 'selected';  ?> value="<?php echo 'Half Yearly' ?>">
                                                <?php echo 'Half Yearly'; }else{ ?> <option value="Half Yearly">Half Yearly</option> <?php } ?></option> 
                                                <option <?php if(isset($frequency)) { if('Yearly' == $frequency) echo 'selected';  ?> value="<?php echo 'Yearly' ?>">
                                                <?php echo 'Yearly'; }else{ ?> <option value="Yearly">Yearly</option> <?php } ?></option> 
                                                <option <?php if(isset($frequency)) { if('Event Driven' == $frequency) echo 'selected';  ?> value="<?php echo 'Event Driven' ?>">
                                                <?php echo 'Event Driven'; }else{ ?> <option value="Event Driven">Event Driven</option> <?php } ?></option>  
                                            </select> 
										</div>
									</div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 mt-4" >
										<div class="form-group">
                                            <input disabled type="checkbox" tabindex="7" name="frequency_applicable" id="frequency_applicable" value="frequency_applicable" <?php if($idupd > 0){ if($frequency_applicable== 'frequency_applicable'){ echo'checked'; }} ?>> &nbsp;&nbsp; <label for="frequency_applicable">Is it applicable for all months</label>
										</div>
									</div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
										<div class="form-group">
											<label for="disabledInput">Type Of Checklist</label>
                                            <select tabindex="6" type="text" class="form-control" id="type_of_checklist" name="type_of_checklist" >
                                                <option value="">Select Type Of Checklist</option> 
                                                <option <?php if(isset($type_of_checklist)) { if('Yes/No/NA' == $type_of_checklist) echo 'selected'; ?> value="<?php echo 'Yes/No/NA' ?>">
                                                <?php echo 'Yes/No/NA'; }else{ ?> <option value="Yes/No/NA">Yes/No/NA</option> <?php } ?></option>
                                                <option <?php if(isset($type_of_checklist)) { if('Option' == $type_of_checklist) echo 'selected'; ?> value="<?php echo 'Option' ?>">
                                                <?php echo 'Option'; }else{ ?> <option value="Option">Option</option> <?php } ?></option> 
                                            </select>
                                        </div>
									</div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 mt-4 yes_no_na" style="display: none;" >
                                        <div class="form-group">
                                            <!-- <label for="disabledInput">Marital Status<span class="required">*</span></label> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; -->
                                            <input readonly type="radio" tabindex="7" name="yes_no_na" id="yes" value="Yes" <?php if(isset($yes_no_na))
                                            echo ($yes_no_na=='Yes')?'checked':'' ?> > &nbsp;&nbsp; <label for="yes">Yes </label> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input readonly type="radio" tabindex="8" name="yes_no_na" id="no"  value="No" <?php if(isset($yes_no_na))
                                            echo ($yes_no_na=='No')?'checked':'' ?> > &nbsp;&nbsp; <label for="no">No </label> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input readonly type="radio" tabindex="9" name="yes_no_na" id="N/A"  value="N/A" <?php if(isset($yes_no_na))
                                            echo ($yes_no_na=='N/A')?'checked':'' ?> > &nbsp;&nbsp; <label for="N/A">N/A </label>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 no_of_option" style="display: none;">
										<div class="form-group">
											<label for="disabledInput">No Of Option</label>
                                            <select type="text" class="form-control" id="no_of_option" name="no_of_option" tabindex="10" >
                                                <option value="">Select No Of Option</option> 
                                                <option <?php if(isset($no_of_option)) { if('2' == $no_of_option) echo 'selected';  ?> value="<?php echo '2' ?>">
                                                <?php echo '2'; }else{ ?> <option value="2">2</option>   <?php } ?></option>
                                                <option <?php if(isset($no_of_option)) { if('3' == $no_of_option) echo 'selected';  ?> value="<?php echo '3' ?>">
                                                <?php echo '3'; }else{ ?> <option value="3">3</option> <?php } ?></option> 
                                                <option <?php if(isset($no_of_option)) { if('4' == $no_of_option) echo 'selected';  ?> value="<?php echo '4' ?>">
                                                <?php echo '4'; }else{ ?> <option value="4">4</option> <?php } ?></option> 
                                            </select>
										</div>
									</div>

                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 options" style="display: none;">
                            <div class="row">
                                <!-- <label><span class="text-danger" id="holidaytableCheck">Enter Atleast One Year</span></label> -->
                                <div class="card-header">Options</div>
                                <table id="pmchecklistTable" class="table custom-table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input tabindex="11" type="text" readonly name="option1" id="option1" class="form-control optionclear" value="<?php if(isset($option1)) echo $option1; ?>" >
                                            </td>
                                            <td>
                                                <input tabindex="12" type="text" readonly name="option2" id="option2" class="form-control optionclear" value="<?php if(isset($option2)) echo $option2; ?>" >
                                            </td>
                                            <td>
                                                <input tabindex="13" type="text" readonly name="option3" id="option3" class="form-control optionclear" value="<?php if(isset($option3)) echo $option3; ?>" >
                                            </td>
                                            <td>
                                                <input tabindex="14" type="text" readonly name="option4" id="option4" class="form-control optionclear" value="<?php if(isset($option4)) echo $option4; ?>" >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br><br><br><br>
                        </div>

                        <div class="row">
                            <!--Fields -->
                           <div class="col-md-12 "> 
                              <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
										<div class="form-group">
											<label for="disabledInput">Rating</label>
                                            <select type="text" class="form-control" id="rating" name="rating" tabindex="16" >
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
                                        <button type="button"  tabindex="5" class="btn btn-primary" id="add_pmchecklistDetails" name="add_pmchecklistDetails" style="padding: 7px 35px;">Add</button>
                                        </div>
                                    </div>
                                    

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="card-header">List</div>
                                <label><span class="text-danger" id="checkRowAppend" style="display:none;"> Please fill all the fields </span></label>
                                <table id="pm_checklist_row_append" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Checklist</th>
                                            <th>Type Of Checklist</th>
                                            <th>Rating</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($idupd > 0){ 
                                        
                                            if(isset($getPMChecklistDetails)){
                                                $cnt = $getPMChecklistDetails['cnt']; //Directly Getting Count from while loop , Based on count for will run.

                                                for($i = 0; $i < $cnt ; $i++){  ?>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" readonly name="add_id[]" id="add_id" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['id']; ?>" >
                                                                <input type="text" readonly name="checklist_add[]" id="checklist_add" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['checklist_add']; ?>" >
                                                            </td>
                                                            <td>
                                                                <input type="text" readonly name="type_of_checklist_add[]" id="type_of_checklist_add" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['type_of_checklist_add']; ?>" >
                                                                <input type="hidden" name="yes_no_type[]" id="yes_no_type" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['yes_no_na_add']; ?>">
                                                                <input type="hidden" name="no_option_type[]" id="no_option_type" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['no_of_option_add']; ?>">
                                                                <input type="hidden" name="option1_type[]" id="option1_type" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['option1_add']; ?>">
                                                                <input type="hidden" name="option2_type[]" id="option2_type" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['option2_add']; ?>">
                                                                <input type="hidden" name="option3_type[]" id="option3_type" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['option3_add']; ?>">
                                                                <input type="hidden" name="option4_type[]" id="option4_type" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['option4_add']; ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" readonly name="table_rating[]" id="table_rating" class="form-control" value="<?php echo $getPMChecklistDetails[$i]['rating_add']; ?>" >
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

                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submittag_creation" id="submittag_creation" class="btn btn-primary" value="Submit" tabindex="17">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="18">Cancel</button>
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