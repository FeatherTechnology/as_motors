<?php
@session_start();
if (isset($_SESSION["userid"])) {
   $userid = $_SESSION["userid"];

   $CompanyroleDetail = $userObj->getsroleDetail($mysqli, $userid);
   for ($j = 0; $j < count($CompanyroleDetail); $j++) {
      $logrole             = $CompanyroleDetail['role'];
      $logtitle            = $CompanyroleDetail['title'];
      $user_company_id     = $CompanyroleDetail['company_id'];
      $company_name        = $CompanyroleDetail['company_name'];
      $user_desgn_id       = $CompanyroleDetail['designation_id'];
      $user_dept_id        = $CompanyroleDetail['department'];
   }
}
if (isset($_SESSION["role"])) {
   $user_role = $_SESSION["role"];
}

if (isset($_SESSION["branch_id"])) {
   $sbranch_id = $_SESSION["branch_id"];
}

//Submit Goal Settings
if (isset($_POST['submit_goal_settings']) && $_POST['submit_goal_settings'] != '') {

   $add_goal_setting = $userObj->addgoalsetting($mysqli, $userid);
?>
   <script>
      location.href = '<?php echo $HOSTPATH; ?>edit_goal_setting&msc=2';
   </script>

<?php   
} 

$del = 0;
if (isset($_GET['del'])) {
   $del = $_GET['del'];
}
if ($del > 0) {
   $deleteAuditAreaCreation = $userObj->deleteAuditAssigns($mysqli, $del);
   ?>
   <script>
      location.href = '<?php echo $HOSTPATH; ?>edit_goal_setting&msc=3';
   </script>
<?php
}

if (isset($_GET['upd'])) {
   $idupd = $_GET['upd'];
}

if ($idupd > 0) {
   $getgoalsettingsData = $userObj->getGoalSettingfetch($mysqli, $idupd);

   if (sizeof($getgoalsettingsData) > 0) {
      for ($i = 0; $i < sizeof($getgoalsettingsData); $i++) {
         $company_id                  = $getgoalsettingsData['company_id'];
         $branch_id                  = $getgoalsettingsData['branch_id'];
         $dept_id                  = $getgoalsettingsData['dept_id'];
         $dept_strength                    = $getgoalsettingsData['dept_strength'];
      }
   }

   $getGoalSettingfet = $userObj->getGoalSettingfet($mysqli, $idupd);

   $goal_setting_ref_id[] = array();
   $goal_setting_id[] = array();
   $assertion[] = array();
   $target[] = array();



   if (sizeof($getGoalSettingfet) > 0) {
      for ($j = 0; $j < sizeof($getGoalSettingfet); $j++) {
         $goal_setting_ref_id[$j]                       = $getGoalSettingfet[$j]['goal_setting_ref_id'];
         $goal_setting_id[$j]                       = $getGoalSettingfet[$j]['goal_setting_id'];
         $assertion[$j]                       = $getGoalSettingfet[$j]['assertion'];
         $target[$j]                       = $getGoalSettingfet[$j]['target'];
         $monthly_conversion[$j]                       = $getGoalSettingfet[$j]['monthly_conversion'];
         $edt[$j]                       = $getGoalSettingfet[$j]['edt'];
         $staffname[$j]                       = $getGoalSettingfet[$j]['staffname'];
      }
   }
}

$goalsnoDetails = $mysqli->query("SELECT MAX(assertion_table_sno) as sno FROM `goal_setting_ref` ORDER BY assertion_table_sno ASC");
$snoinfo = $goalsnoDetails->fetch_assoc();
if (mysqli_num_rows($goalsnoDetails)>0) {
   $sno = $snoinfo['sno'] + 1;
}else{
   $sno = 1;
}
?>

<!-- Page header start -->
<div class="page-header">
   <ol class="breadcrumb">
      <li class="breadcrumb-item">AS - Goal Setting</li>
   </ol>
   <a href="edit_goal_setting">
      <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
</div>
<!-- Page header end -->
<!-- Main container start -->
<div class="main-container">
   <!--------form start-->
   <form id="goal_setting" name="goal_setting" method="post" enctype="multipart/form-data">
      <input type="hidden" class="form-control" value="<?php if (isset($idupd)) echo $idupd; ?>" id="goal_setting_id" name="goal_setting_id" >
      <input type="hidden" class="form-control" value="<?php if (isset($sno)) echo $sno; ?>" id="snocnt" name="snocnt" >

      <!-- Data will get in edit screen Start -->
      <input type="hidden" class="form-control" value="<?php if (isset($company_id)) echo $company_id; ?>" id="company_id_upd" name="company_id_upd">
      <input type="hidden" class="form-control" value="<?php if (isset($branch_id)) echo $branch_id; ?>" id="branch_id_upd" name="branch_id_upd">
      <input type="hidden" class="form-control" value="<?php if (isset($dept_id)) { echo $dept_id; } else { echo '0'; } ?>" id="dept_id_upd" name="dept_id_upd">
      <!-- <input type="hidden" class="form-control" value="<?php #if (isset($role_id)) echo $role_id; ?>" id="role_id_up" name="role_id_up"> -->
      <!-- Data will get in edit screen END -->
      
      <!-- Login User Data Start -->
      <input type="hidden" class="form-control" value="<?php if (isset($user_company_id)) echo $user_company_id; ?>" id="user_company" name="user_company">
      <input type="hidden" class="form-control" value="<?php if (isset($sbranch_id)) echo $sbranch_id; ?>" id="user_branch" name="user_branch">
      <input type="hidden" class="form-control" value="<?php if (isset($user_desgn_id)) echo $user_desgn_id; ?>" id="user_designation" name="user_designation">
      <input type="hidden" class="form-control" value="<?php if (isset($user_dept_id)) echo $user_dept_id; ?>" id="user_department" name="user_department">
      <input type="hidden" class="form-control" value="<?php if (isset($user_role)) echo $user_role; ?>" id="user_role" name="user_role">
      <!-- Login User Data END -->

      <!-- Row start -->
      <div class="row gutters">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
               <div class="card-header">
               </div>
               <div class="card-body">
                  <div class="row ">
                     <!--Fields -->
                     <div class="col-md-12 ">
                        <div class="row">

                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="company_name">Company Name</label>
                                 <input type="hidden" name="companyid" id="companyid" >
                                 <select type="text" tabindex="1" name="company_name" id="company_name" class="form-control managerlogindisable">
                                    <option value=''>Select Company Name</option>
                                 </select>
                              </div>
                           </div>

                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="branch_name">Branch Name</label>
                                 <input type="hidden" name="branchid" id="branchid" >
                                 <select type="text" tabindex="2" name="branch_name" id="branch_name" class="form-control managerlogindisable">
                                    <option value=''>Select Branch Name</option>
                                 </select>
                              </div>
                           </div>

                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="dept">Department</label>
                                 <input type="hidden" name="deptid" id="deptid" >
                                 <select type="text" tabindex="3" name="dept" id="dept" class="form-control managerlogindisable">
                                    <option value=''>Select Department Name</option>
                                 </select>
                              </div>
                           </div>

                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="dept_strength">Department strength</label>
                                 <input type="number" tabindex="4" name="dept_strength" id="dept_strength" class="form-control" value="<?php if(isset($dept_strength)) echo $dept_strength; ?>" readonly>
                              </div>
                           </div>

                           <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label>Add Assertion</label>
                                 <button type="button" tabindex="5" class="btn btn-primary" id="add_responsibilityDetails" name="add_responsibilityDetails"  style="padding: 5px 35px;" data-toggle="modal" data-target=".addAssertionModal"><span class="icon-add"></span></button>
                              </div>
                           </div>

                           <div class="col-md-12" id="tables">
                              <table id="moduleTable" class="table custom-table">
                                 <thead>
                                    <tr>
                                       <th width='25%'>Assertion</th>
                                       <th>Target</th>
                                       <th>Month</th>
                                       <th>Type</th>
                                       <th>Entry date Type</th>
                                       <th>Staff</th>
                                       <th colspan="2">Action</th>
                                    </tr>
                                 </thead>
                                    <tbody id='goalsettingInfo'>  
                                       <tr>
                                          <td>
                                             <select tabindex="5" class="form-control assertion_names" id="assertion0" name="assertion[]">
                                                <option value=''>Select Assertion </option>
                                             </select>
                                             <input type="hidden" class="form-control" id="rowcnt" name="rowcnt[]" value="<?php echo $sno; ?>">
                                          </td>
                                          <td><input tabindex="6" type="number" class="form-control" id="target" name="target[]" placeholder="Enter Target"></td>
                                          <td><input type="month" tabindex="7" class="form-control" id="goal_month" name="goal_month[]"></td>
                                          <td><select tabindex="8" class="form-control" id="monthly_conversion" name="monthly_conversion[]">
                                                <option value=''>Select Type</option>
                                                <option value='0'>Month</option>
                                                <option value='1'>Daily</option>
                                             </select>
                                          </td>
                                          <td><select tabindex="9" class="form-control" id="entry_date_type" name="entry_date_type[]">
                                                <option value=''>Select Type</option>
                                                <option value='0'>Current date</option>
                                                <option value='1'>Previous date</option>
                                             </select>
                                          </td>
                                          <td><select tabindex="10" class="form-control" id="staff_name0" name="staff_name0[]" multiple>
                                                <option value=''>Select Staff Name</option>
                                             </select>
                                          </td>
                                          <td><button type="button" tabindex="11" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td>
                                          <td><span class='icon-trash-2' tabindex="12" id="delete_row"></span></td>
                                       </tr>
                                    </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <br><br>
                     <div class="text-right">
                        <button type="submit" name="submit_goal_settings" id="submit_goal_settings" class="btn btn-primary" value="Submit" tabindex="13">Submit</button>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
</div>
</div>
</form>
</div>

   <!-- Add Assertion Modal -->
   <div class="modal fade addAssertionModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content" style="background-color: white">
            <div class="modal-header">
                  <h5 class="modal-title" id="myLargeModalLabel">Add Assertion</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DropDownAssertion('.assertion_names','')">
                     <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                  <!-- alert messages -->
                  <div id="assertionInsertNotOk" class="unsuccessalert">Assertion Already Exists, Please Enter a Different Name!
                  <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                  </div>

                  <div id="assertionInsertOk" class="successalert">Assertion Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                  </div>

                  <div id="assertionUpdateOk" class="successalert">Assertion Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                  </div>

                  <div id="assertionDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Assertion!
                  <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                  </div>

                  <div id="assertionDeleteOk" class="successalert">Assertion Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                  </div>
                  <br/>
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                     <div class="form-group">
                        <label class="label">Enter Assertion</label>
                        <input type="hidden" name="assertion_id" id="assertion_id">
                        <input type="text" name="assertion_name" id="assertion_name" class="form-control" placeholder="Enter Assertion">
                        <span class="text-danger" id="assertionnameCheck" style="display: none;">Enter Assertion</span>
                     </div>
                  </div>
                  <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                        <label class="label" style="visibility: hidden;">Assertion</label>
                     <button type="button" tabindex="2" name="submitAssertionBtn" id="submitAssertionBtn" class="btn btn-primary">Submit</button>
                  </div>
               </div>
               <div id="updatedAssertionTable"> 
                  <table class="table custom-table" id="assertionTable"> 
                     <thead>
                        <tr>
                              <th>S.No</th>
                              <th>Assertion</th>
                              <th>ACTION</th>
                        </tr>
                     </thead>
                     <tbody>
                        
                     </tbody>
                     </table>
               </div>
            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownAssertion('.assertion_names','')">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!-- Add Assertion Modal END -->
