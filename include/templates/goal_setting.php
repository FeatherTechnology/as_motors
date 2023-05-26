<?php 
   @session_start();
   if(isset($_SESSION["userid"])){
       $userid = $_SESSION["userid"];
   } 
   if(isset($_SESSION["branch_id"])){

       $sbranch_id = $_SESSION["branch_id"];
       $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
       $CompanyroleDetail = $userObj->getsroleDetail($mysqli, $sbranch_id);
       for($j=0;$j<count($CompanyroleDetail);$j++) {
               $logrole = $CompanyroleDetail['role'];
               $logtitle = $CompanyroleDetail['title'];
               $company_id         = $CompanyroleDetail['company_id'];
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
      <input type="hidden" class="form-control" value="<?php if(isset($dept_id)) echo $dept_id; ?>"  id="dept_id_upd" name="dept_id_upd">
      <input type="hidden" class="form-control" value="<?php if(isset($role_id)) echo $role_id; ?>"  id="role_id_up" name="role_id_up">
      <input type="hidden" class="form-control" value="<?php if(isset($year_id)) echo $year_id; ?>"  id="year_idup" name="year_idup">
      <input type="hidden" class="form-control" value="<?php if(isset($audit_area_id)) echo $audit_area_id ?>"  id="audit_area_id" name="audit_area_id" aria-describedby="id" placeholder="Enter id">
      <input type="hidden" class="form-control" value="<?php if(isset($logrole)) echo $logrole; ?>"  id="logrole" name="logrole">
      <input type="hidden" class="form-control" value="<?php if(isset($logtitle)) echo $logtitle; ?>"  id="logtitle" name="logtitle">
      <input type="hidden" class="form-control" value="<?php if(isset($company_id)) echo $company_id; ?>"  id="logcomp" name="logcomp">
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
                                 <select type="text" tabindex="2" name="cname" id="prev" class="form-control"  >
                                    <?php if ($company_id <>'') {  ?>
                                    <?php  if(isset($company_id)) echo $company_id;
                                       for($j=0;$j<count($audit_area_list);$j++) {
                                           $areaid = $audit_area_list[$j]['company_id'];
                                           $areaname = $audit_area_list[$j]['company_name'];
                                           if($company_id == $areaid){
                                       
                                        ?>
                                    <option value="<?php echo $areaid; ?>"><?php echo  $areaname;?>
                                       <?php for($j=0;$j<count($audit_area_list);$j++) { 
                                          $areaid = $audit_area_list[$j]['company_id'];
                                          if($areaid != $company_id){ ?>
                                    <option value="<?php echo $audit_area_list[$j]['company_id']; ?>"><?php echo $audit_area_list[$j]['company_name'];?></option>
                                    <?php } }}}}else{ ?> 
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
                                 <select type="text" tabindex="2" name="designation" id="designation" class="form-control"  >
                                
                                 </select>                              
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="label">Year</label>
                                    <select type="text" tabindex="2" name="syear" id="syear" class="form-control syear"  >
                                    
                                 </select>           
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="label" style="visibility: hidden;">Add Year</label>
                                    <!-- <button type="button" tabindex="4" class="btn btn-primary" id="add_departmentDetails" name="add_departmentDetails" style="padding: 5px 35px;"><span class="icon-add"></span></button> -->
                                    <button type="button" class="btn btn-primary btn-lg add_row" id="add_row_0" data-toggle="modal" data-target="#myModal"><span class="icon-add"></span></button>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-4">
                                <div class="form-group yes">
                                    <input type="checkbox" tabindex="7"  name="preyear" id="yes" value="Yes"> &nbsp;&nbsp; <label for="yes">Use Previous Year Setting</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                    
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-2 col-12 mt-4">
                                <div class="form-group">
                                    <input type="button" tabindex="7"  name="execute" id="execute" class="btn btn-primary" value="execute">
                                    
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
                                       <th colspan="2" >Action</th>
                                    </tr>
                                 </thead>
                                 <?php if($idupd<=0){ ?>
                                 <tbody>
                                    <tr>
                                       <td>
                                          <input tabindex="4" type="text" class="form-control" id="assertion" placeholder="Enter Assertion" name="assertion[]" ></input> 
                                       </td>
                                       <td><input tabindex="6" type="text" class="form-control" id="target" name="target[]" placeholder="Enter Target"></td>
                                       <td><button type="button" tabindex="9" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td>
                                       <td><span class='icon-trash-2' tabindex="10" id="delete_row"></span></td>
                                    </tr>
                                 </tbody>
                                 <?php } if($idupd>0){ 
                                    if(isset($id)){  ?>
                                 <tbody id='t2' >
                                    <?php for($g=0;$g<=count($getGoalSettingfet)-1;$g++) {  ?>
                                       
                                      
                                    <tr>
                                    <td>
                                    <input tabindex="4" type="text" class="form-control" id="assertion" placeholder="Enter Assertion" name="assertion[]"  value="<?php echo $assertion[$g]; ?>"></input>  <input  type="hidden" class="form-control" id="iid"  name="iid[]"  value="<?php echo $goal_setting_ref_id[$g]; ?>"></input> 
                                       </td>
                                       <td><input tabindex="6" type="text" class="form-control" id="target" name="target[]" placeholder="Enter Target" value="<?php echo $target[$g]; ?>"></td>
                                       <td><button type="button" tabindex="9" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td>
                                       <td><span class='icon-trash-2' tabindex="10" id="delete_row"></span></td>
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
                  <button type="submit" name="submit_audit_checklist" id="submit_audit_checklist" class="btn btn-primary" value="Submit" tabindex="10">Submit</button>
               </div>
            </div>
         </div>
      </div>
</div>
</div>
<div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Year</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="background-color: whitesmoke;">
                    <div class="form-group">
                        <label for="year">Year</label>
                        <select type="text" tabindex="2" name="iyear" id="iyear" class="form-control" >
                                        <?php

                                            foreach(range(1950, (int)date("Y")) as $year) {
                                            echo "\t<option value='".$year."'>".$year."</option>\n\r";
                                            }

                                        ?>
                        </select>         
                        <input type="hidden" name="icompany" id="icompany" >
                    </div>
                </div>
                <div class="modal-footer" style="background-color: whitesmoke;">
                    <button type="button" id="insert" class="btn btn-primary insert" name="insert">Submit</button>
                    <button type="button" style="display:none"; class="btn btn-warning close" data-dismiss="modal">Close</button>
                </div>
            </div>                
        </div>
    </div>
</form>
</div>