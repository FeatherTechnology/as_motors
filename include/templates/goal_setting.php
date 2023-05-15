<?php 
   @session_start();
   if(isset($_SESSION["userid"])){
       $userid = $_SESSION["userid"];
   } 
   if(isset($_SESSION["branch_id"])){
       $sbranch_id = $_SESSION["branch_id"];
       $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
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
           $addAuditAssign = $userObj->addAuditAssign($mysqli,$userid,$idupd);  
       ?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_audit_assign&msc=2';</script> 
<?php	}
   else{  
      
       $addAuditAssign = $userObj->addAuditAssign($mysqli,$userid,$idupd);   
       ?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_audit_assign&msc=1';</script>
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
   $deleteAuditAreaCreation = $userObj->deleteAuditAssign($mysqli,$del); 
   ?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_audit_assign&msc=3';</script>
<?php	
   }
   
   if(isset($_GET['upd']))
   {
   $idupd=$_GET['upd'];
   }
   
   if($idupd>0)
   {
   	$getAuditAssignlist = $userObj->getAuditAssignlist($mysqli,$idupd); 
   	
   	if (sizeof($getAuditAssignlist)>0) {
           for($i=0;$i<sizeof($getAuditAssignlist);$i++)  {
               $date_of_audit                  = $getAuditAssignlist['date_of_audit'];
               $audit_area_id                  = $getAuditAssignlist['area_id']; 
               $audit_area_name                  = $getAuditAssignlist['area_name']; 
   			$dept                	 = $getAuditAssignlist['department'];
   			$departid = explode(",", $dept);
    $department_name   = array();
   foreach($departid as $departmentid) {
   $deptid = trim($departmentid);
    $department_name1 = "SELECT department_name FROM department_creation WHERE department_id IN ($deptid) and status = 0";
    $res2 = $mysqli->query($department_name1);
    
   
              $row2 = $res2->fetch_assoc();
              $department_name[] = $row2['department_name'];
   
              
          
   }
   $dept_name                 = $department_name;  
   
   $deptname = implode(', ', $dept_name); 
               // $dept_name                	 = $getAuditAssignlist['department_name'];
               $role1                	     = $getAuditAssignlist['auditor'];
               $auditor_name                	     = $getAuditAssignlist['auditor_name'];
   			$role2    	                = $getAuditAssignlist['auditee'];
   			$auditee_name    	                = $getAuditAssignlist['auditee_name'];
   	
   		}
   	}
       
       $getAuditassign_ref = $userObj->getAuditassign_ref($mysqli,$idupd);
       
       $major[]=array();
       $assertion[]=array();
       $audit_status[]=array();
       $recommendation[]=array();
       $attachment[]=array();
       $audit_remarks[]=array();
        $audit_assign_ref_id[]=array();
       
   
       if (sizeof($getAuditassign_ref)>0) {
           for($j=0;$j<sizeof($getAuditassign_ref);$j++)  {
               // print_r($getAuditassign_ref);
               $major[$j]    	                = $getAuditassign_ref[$j]['major_area'];
               $assertion[$j]    	                = $getAuditassign_ref[$j]['assertion'];
               $audit_status[$j]    	                = $getAuditassign_ref[$j]['audit_status'];
               $recommendation[$j]    	                = $getAuditassign_ref[$j]['recommendation'];
               $attachment[$j]    	                = $getAuditassign_ref[$j]['attachment']; 
               $audit_remarks[$j]    	                = $getAuditassign_ref[$j]['audit_remarks'];
               $audit_assign_ref_id[$j]                 = $getAuditassign_ref[$j]['audit_assign_ref_id'];
   		}
   	}
   }
   ?>
<!-- Page header start -->
<div class="page-header">
   <ol class="breadcrumb">
      <li class="breadcrumb-item">AS - Goal Setting</li>
   </ol>
   <a href="edit_audit_assign">
   <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
</div>
<!-- Page header end -->
<!-- Main container start -->
<div class="main-container">
   <!--------form start-->
   <form id = "audit_checklist" name="audit_checklist" action="" method="post" enctype="multipart/form-data">
      <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
      <input type="hidden" class="form-control" value="<?php if(isset($audit_area_id)) echo $audit_area_id ?>"  id="audit_area_id" name="audit_area_id" aria-describedby="id" placeholder="Enter id">
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
                                 <select type="text" tabindex="2" name="prev" id="prev" class="form-control" >
                                    <?php if ($company_id <>'') {  ?>
                                    <?php if(isset($company_id)) echo $company_id;
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
                                 <select type="text" tabindex="2" name="dept" id="dept" class="form-control" >
                                 <!-- <option value="0">Select Department</option> -->
                                 </select>
                              </div>
                           </div>
                           
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="inputReadOnly">Role</label>
                                 <select type="text" tabindex="2" name="designation" id="designation" class="form-control" >
                                 <!-- <option value="0">Select Role</option> -->
                                 </select>                              
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="label">Year</label>
                                    <select type="text" tabindex="2" name="syear" id="syear" class="form-control syear selectpicker" data-live-search="true" >
                                        <!-- <select class="form-control year selectpicker syear" id="syear"  data-live-search="true" name="state">
                                          
                                        </select> -->
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
                                <div class="form-group">
                                    <input type="checkbox" tabindex="7"  name="preyear" id="yes" value="Yes"> &nbsp;&nbsp; <label for="yes">Use Previous Year Setting</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                    
                                </div>
                            </div>
                           <!-- <div class="row" > -->
                           <div class="col-md-12" >
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
                                    <?php for($g=0;$g<=count($major)-1;$g++) { ?>
                                    <tr>
                                       <td>
                                          <input tabindex="3" type="text" class="form-control" id="major" name="major[]" value="<?php echo $major[$g]?>">
                                          </input> 
                                          <input type="hidden" id='rid' class="rid" name="audit_assign_ref_id[]" value="<?php echo $audit_assign_ref_id[$g]?>">
                                       </td>
                                       <td>
                                          <input tabindex="4" type="text" class="form-control" id="assertion" name="assertion[]" value="<?php echo $assertion[$g]?>"></input> 
                                       </td>
                                       <td>
                                          <select type="text" tabindex="5" name="prevstatus[]" id="prevstatus" class="form-control prevstatus" value="<?php echo $audit_status[$g]; ?>">
                                             <?php $audit= $audit_status[$g]; if ($audit == 0){ ?>
                                             <option value='0'>No</option>
                                             <option value=''>Select Status</option>
                                             <option value='1'>Yes</option>
                                             <?php }else if($audit == 1){?>
                                             <option value='1'>Yes</option>
                                             <option value='0'>No</option>
                                             <option value=''>Select Status</option>
                                             <?php }else{ ?>
                                             <option value=''>Select Status</option>
                                             <option value='1'>Yes</option>
                                             <option value='0'>No</option>
                                             <?php }  ?>
                                          </select>
                                       </td>
                                       <td>
                                          <textarea tabindex="8"  id="aremarks"  class="form-control" rows="1" name="aremarks[]"  cols="35" value="<?php echo $audit_remarks[$g];  ?>" placeholder='Write something here'><?php echo $audit_remarks[$g];  ?></textarea> 
                                          <?php $audit= $audit_status[$g]; if ($audit == 0){  ?>
                                       <td>     
                                          <input tabindex="6" type="text" class="form-control" id="rcmd" name="rcmd[]" value="<?php echo  $recommendation[$g]; ?>">
                                       </td>
                                       <td>
                                          <input type='file' tabindex='7' class='form-control' id='att_file' name='file[]' style='padding: 3px;' value ='<?php echo  $attachment[$g]; ?>'> <input type='text' tabindex='7' style ="display:none;" class='form-control' id='att_filec' name='file1[]' style='padding: 3px;' value ='<?php echo  $attachment[$g]; ?>'>
                                       </td>
                                       <?php }else if($audit == 1){?>
                                       <td>     
                                          <input tabindex="6" type="text" class="form-control" id="rcmd" name="rcmd[]" value="<?php echo  $recommendation[$g]; ?>" readonly>
                                       </td>
                                       <td>
                                          <input type='file' tabindex='7' class='form-control' id='att_file' name='file[]' style='padding: 3px;' value ='<?php echo  $attachment[$g]; ?>' readonly>
                                          <input type='text' tabindex='7' style ="display:none;" class='form-control' id='att_filec' name='file1[]' style='padding: 3px;' value ='<?php echo  $attachment[$g]; ?>' readonly>
                                       </td>
                                       <?php }else{ ?>
                                       <td>     
                                          <input tabindex="6" type="text" class="form-control" id="rcmd" name="rcmd[]" value="<?php echo  $recommendation[$g]; ?>">
                                       </td>
                                       <td>
                                          <input type='file' tabindex='7' class='form-control' id='att_file' name='file[]' style='padding: 3px;' value ='<?php echo  $attachment[$g]; ?>'> <input type='text' tabindex='7' style ="display:none;" class='form-control' id='att_filec' name='file1[]' style='padding: 3px;' value ='<?php echo  $attachment[$g]; ?>'>
                                       </td>
                                       <?php }  ?>
                                       <td>
                                          <button type="button" tabindex="8" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button> 
                                       </td>
                                       <td>
                                          <span class='icon-trash-2' tabindex="9" id="delete_row"></span> 
                                       </td>
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

=======
                 
        </div>
    </div>
</form>
</div>