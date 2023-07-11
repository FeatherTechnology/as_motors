<?php 
   @session_start();
   if(isset($_SESSION["userid"])){
       $userid = $_SESSION["userid"];
   } 
   if(isset($_SESSION["branch_id"])){

       $sbranch_id = $_SESSION["branch_id"];
       $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
       $CompanyroleDetail = $userObj->getsroleDetail($mysqli, $userid);
       for($j=0;$j<count($CompanyroleDetail);$j++) {
               $logrole = $CompanyroleDetail['role'];
               $logtitle = $CompanyroleDetail['title'];
               $user_company_id         = $CompanyroleDetail['company_id'];
					$company_name         = $CompanyroleDetail['company_name'];
       }
    $audit_area_list1 = $userObj->getAuditAreaTable1($mysqli, $sbranch_id);
   }
   $audit_area_list = $userObj->getgoalsettingTable($mysqli);
   // $goalsetyear = $userObj->getgoalsettingdata($mysqli);
   
   $id=0;
   
   $idupd=0;
    if(isset($_POST['submit_audit_checklist']) && $_POST['submit_audit_checklist'] != '')
    {
       if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
           $id = $_POST['id']; 	
           $audit_area_id = $_POST['audit_area_id'];
           if(isset($idupd)) echo $idupd;
           $addAuditAssign = $userObj->addgoalsetting($mysqli,$userid,$idupd);  
       ?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_goal_setting&msc=2';</script> 
<?php	}
   else{  
      
       $addAuditAssign = $userObj->addgoalsetting($mysqli,$userid,$idupd);   
       ?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_goal_setting&msc=1';</script>
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
   $deleteAuditAreaCreation = $userObj->deleteAuditAssigns($mysqli,$del); 
   ?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_goal_setting&msc=3';</script>
<?php	
   }
   
   if(isset($_GET['upd']))
   {
   $idupd=$_GET['upd'];
   }
   
   if($idupd>0)
   {
   	$getAuditAssignlist = $userObj->getGoalSettingfetch($mysqli,$idupd); 
   	
   	if (sizeof($getAuditAssignlist)>0) {
           for($i=0;$i<sizeof($getAuditAssignlist);$i++)  {
                        $company_id                  = $getAuditAssignlist['company_id'];
                        $company                  = $getAuditAssignlist['company']; 
                        $dept_id                  = $getAuditAssignlist['dept_id']; 
                        $dept                	 = $getAuditAssignlist['dept'];
                        $role_id                	 = $getAuditAssignlist['role_id'];
                        $role                	     = $getAuditAssignlist['role'];
                        $year_id                	     = $getAuditAssignlist['year_id'];
                        $year    	                = $getAuditAssignlist['year'];

   	
   		}
   	}
       
       $getGoalSettingfet = $userObj->getGoalSettingfet($mysqli,$idupd);
       
       $goal_setting_ref_id[]=array();
       $goal_setting_id[]=array();
       $assertion[]=array();
       $target[]=array();
      
       
   
       if (sizeof($getGoalSettingfet)>0) {
           for($j=0;$j<sizeof($getGoalSettingfet);$j++)  {
               // print_r($getAuditassign_ref);
               $goal_setting_ref_id[$j]    	                = $getGoalSettingfet[$j]['goal_setting_ref_id'];
               $goal_setting_id[$j]    	                = $getGoalSettingfet[$j]['goal_setting_id'];
               $assertion[$j]    	                = $getGoalSettingfet[$j]['assertion'];
               $target[$j]    	                = $getGoalSettingfet[$j]['target'];
               $monthly_conversion[$j]    	                = $getGoalSettingfet[$j]['monthly_conversion'];
              
   		}
   	}
   }
   ?>
   <style>
      .hidden{
         display: none;
      }
   </style>
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
   <form id = "audit_checklist" name="audit_checklist" action="" method="post" enctype="multipart/form-data">
      <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
      <input type="hidden" class="form-control" value="<?php if(isset($company_id)) echo $company_id; ?>"  id="company_id_upd" name="company_id_upd">
      <input type="hidden" class="form-control" value="<?php if(isset($dept_id)){ echo $dept_id; }else{ echo '0';} ?>"  id="dept_id_upd" name="dept_id_upd">
      <input type="hidden" class="form-control" value="<?php if(isset($role_id)) echo $role_id; ?>"  id="role_id_up" name="role_id_up">
      <input type="hidden" class="form-control" value="<?php if(isset($year_id)) echo $year_id; ?>"  id="year_idup" name="year_idup">
      <input type="hidden" class="form-control" value="<?php if(isset($audit_area_id)) echo $audit_area_id ?>"  id="audit_area_id" name="audit_area_id" aria-describedby="id" placeholder="Enter id">
      <input type="hidden" class="form-control" value="<?php if(isset($logrole)) echo $logrole; ?>"  id="logrole" name="logrole">
      <input type="hidden" class="form-control" value="<?php if(isset($logtitle)) echo $logtitle; ?>"  id="logtitle" name="logtitle">
      <input type="hidden" class="form-control" value="<?php if(isset($user_company_id)) echo $user_company_id; ?>"  id="logcomp" name="logcomp">
      <input type="hidden" class="form-control" value="<?php if(isset($company_name)) echo $company_name; ?>"  id="logcname" name="logcname">
        

      
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
                              <label for="inputReadOnly">Company Name</label>
                                 <select type="text" tabindex="1" name="cname" id="prev" class="form-control"  >
                                    <?php if ($company_id <>'') {  ?>
                                    <?php  if(isset($company_id)) echo $company_id;
                                       for($j=0;$j<count($audit_area_list);$j++) {
                                           $areaid = $audit_area_list[$j]['company_id'];
                                           $areaname = $audit_area_list[$j]['company_name'];
                                           if($company_id == $areaid){
                                       
                                        ?>
                                    <!-- <option value="<?php echo $areaid; ?>"><?php echo  $areaname;?> -->
                                       <?php for($j=0;$j<count($audit_area_list);$j++) { 
                                          $areaid = $audit_area_list[$j]['company_id'];
                                          // if($areaid != $company_id){ ?>
                                    <option value="<?php echo $audit_area_list[$j]['company_id']; ?>"><?php echo $audit_area_list[$j]['company_name'];?></option>
                                    <?php } }}}else{ ?> 
                                    <option value="0">Select Company</option>
                                    <?php for($j=0;$j<count($audit_area_list);$j++) { ?>
                                       
                                    <option value="<?php echo $audit_area_list[$j]['company_id']; ?>"><?php echo $audit_area_list[$j]['company_name'];?></option>
                                    <?php }} ?>
                                 </select>
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="inputReadOnly">Department</label>
                                 <select type="text" tabindex="2" name="dept" id="dept" class="form-control"  >
                               
                                 </select>
                              </div>
                           </div>
                           
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="inputReadOnly">Designation</label>
                                 <select type="text" tabindex="3" name="designation" id="designation" class="form-control"  >
                                
                                 </select>                              
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="label">Year</label>
                                    <select type="text" tabindex="4" name="syear" id="syear" class="form-control syear"  >
                                    
                                 </select>           
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="label" style="visibility: hidden;">Add Year</label>
                                    <!-- <button type="button" tabindex="4" class="btn btn-primary" id="add_departmentDetails" name="add_departmentDetails" style="padding: 5px 35px;"><span class="icon-add"></span></button> -->
                                    <button type="button" tabindex="" class="btn btn-primary" id="add_group" name="add_group" data-toggle="modal" data-target=".addGroup" style="padding: 5px 35px;" tabindex="5"><span class="icon-add"></span></button>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-4">
                                <div class="form-group yes">
                                    <input type="checkbox" tabindex="6" name="preyear" id="yes" value="Yes"> &nbsp;&nbsp; <label for="yes">Use Previous Year Setting</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-2 col-12 mt-4">
                                <div class="form-group">
                                    <input type="button" tabindex="8"  name="execute" id="execute" class="btn btn-primary" value="Execute">
                                    
                                </div>
                            </div>
                           <!-- <div class="row" > -->
                          <?php if($idupd>0){ ?>
                              <div class="col-md-12" id="tables" >
                           <?php }else{ ?>
                              <div class="col-md-12 hidden" id="tables" >
                           <?php } ?>
                              <table id="moduleTable" class="table custom-table" >
                                 <thead>
                                    <tr>
                                       
                                       <th>Assertion</th>
                                       <th>Target</th>
                                       <th>Monthly Conversion Required </th>
                                       <th colspan="2" >Action</th>
                                    </tr>
                                 </thead>
                                 <?php if($idupd<=0){ ?>
                                 <tbody>
                                    <tr>
                                       <td>
                                          <input tabindex="9" type="text" class="form-control" id="assertion" placeholder="Enter Assertion" name="assertion[]" ></input> 
                                       </td>
                                       <td><input tabindex="10" type="number" class="form-control" id="target" name="target[]" placeholder="Enter Target"></td>
                                       <td><select tabindex="11" class="form-control" id="monthly_conversion" name="monthly_conversion[]">
                                          <option value=''>Select Monthly Conversion Required</option>
                                          <option value='0'>Yes</option>
                                          <option value='1'>No</option>
                                       </select></td>
                                       <td><button type="button" tabindex="12" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td>
                                       <td><span class='icon-trash-2' tabindex="13" id="delete_row"></span></td>
                                    </tr>
                                 </tbody>
                                 <?php } if($idupd>0){ 
                                    if(isset($id)){  ?>
                                 <tbody id='t2' >
                                    <?php for($g=0;$g<=count($getGoalSettingfet)-1;$g++) { ?>
                                       
                                      
                                    <tr>
                                    <td>
                                    <input tabindex="9" type="text" class="form-control" id="assertion" placeholder="Enter Assertion" name="assertion[]"  value="<?php echo $assertion[$g]; ?>"></input>  <input  type="hidden" class="form-control" id="iid"  name="iid[]"  value="<?php echo $goal_setting_ref_id[$g]; ?>"></input> 
                                       </td>
                                       <td><input tabindex="10" type="number" class="form-control" id="target" name="target[]" placeholder="Enter Target" value="<?php echo $target[$g]; ?>"></td>
                                       <td><select tabindex="11" class="form-control" id="monthly_conversion" name="monthly_conversion[]" >
                                          <option value=''>Select Monthly Conversion Required</option>
                                          <option value='0' <?php if(isset($monthly_conversion[$g]) && $monthly_conversion[$g] == '0'){echo 'Selected';} ?>>Yes</option>
                                          <option value='1' <?php if(isset($monthly_conversion[$g]) && $monthly_conversion[$g] == '1'){echo 'Selected';} ?>>No</option>
                                       </select></td>
                                       <td><button type="button" tabindex="12" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td>
                                       <td><span class='icon-trash-2' tabindex="13" id="delete_row"></span></td>
                                    </tr>
                                 
                                    <?php } ?>
                                    
                                 </tbody>
                                 <?php }
                                    } ?>
                              </table>
                           </div>
                           <!-- </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <br><br>
               <div class="text-right">
                  <!-- <button type="button" class="btn btn-outline-secondary" tabindex="15">Save</button> -->
                  <button type="submit" name="submit_audit_checklist" id="submit_audit_checklist" class="btn btn-primary" value="Submit" tabindex="13">Submit</button>
               </div>
            </div>
         </div>
      </div>
</div>
</div>
</form>
</div>

<!-- /////////////////////////////////////////////////////////////////// Add Year Modal START ////////////////////////////////////////////////////////////// -->
<div class="modal fade addGroup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: white">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Year</h5>
                <button type="button" class="close closebtn" data-dismiss="modal" aria-label="Close" >
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- alert messages -->
                <div id="agentInsertNotOk" class="unsuccessalert">Year Already Exists, Please Enter a Different Year!
                    <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>
                <div id="agentInsertOk" class="successalert">Year Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>
                <div id="agentUpdateOk" class="successalert">Year Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>
                <div id="agentDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Year!
                    <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>
                <div id="agentDeleteOk" class="successalert">Year Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>
                <br />
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                        <label for="year">Year</label>
                        <input type="number" name="iyear" id="iyear" class="form-control" pattern="\d{4}" title="Please enter a Year" tabindex="1">
                        <input type="hidden" name="iyearid" id="iyearid" class="form-control" pattern="\d{4}" title="">
                       
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                        <button type="button" tabindex="2" name="insert" id="insert" class="btn btn-primary" style="margin-top: 20px;">Submit</button>
                    </div>
                </div>
                <div id="yearcreationTable">
                    <table class="table custom-table" id="year_infoDashboard">
                        <thead>
                            <tr>
                                <th width="25%">S. No</th>
                                <th>Year</th>
                                <th>status</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closebtn" data-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /////////////////////////////////////////////////////////////////// Add Year Modal END ////////////////////////////////////////////////////////////////////// -->