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
   $audit_area_list = $userObj->getAuditAreaTable($mysqli);
   
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
      <li class="breadcrumb-item">AS - Audit Assign </li>
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
                                 <label for="disabledInput">Date Of Audit</label>
                                 <input type="date" tabindex="1" name="date_of_audit" id="date_of_audit" class="form-control" value="<?php if(isset($date_of_audit)) echo $date_of_audit ; ?>">
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="inputReadOnly">Department </label>
                                 <input type="hidden" class="form-control" id="dept_id" name="dept_id" value="<?php if(isset($dept)) echo $dept; ?>" >
                                 <input type="text" class="form-control" id="dept" name="dept" value="<?php if(isset($deptname)) echo $deptname; ?>" readonly >  
                                 <!-- <input type="text" class="form-control" id="dept" name="dept" 
                                    value="<?php if(isset($dept_name)) echo $dept_name; ?>" readonly >                                 -->
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="inputReadOnly">Role 1</label>
                                 <input type="hidden" class="form-control" id="role1_id" name="role1_id" value="<?php if(isset($role1)) echo $role1; ?>" >
                                 <input type="text" class="form-control" id="role1" name="role1" value="<?php if(isset($auditor_name)) echo $auditor_name; ?>" readonly >                                
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="inputReadOnly">Role 2</label>
                                 <input type="hidden" class="form-control" id="role2_id" name="role2_id" value="<?php if(isset($role2)) echo $role2; ?>">
                                 <input type="text" class="form-control" id="role2" name="role2" value="<?php if(isset($auditee_name)) echo $auditee_name; ?>" readonly >                                
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                              <div class="form-group">
                                 <select type="text" tabindex="2" name="prev" id="prev" class="form-control" >
                                    <?php if ($audit_area_id <>'') {  ?>
                                    <?php if(isset($audit_area_id)) echo $audit_area_id;
                                       for($j=0;$j<count($audit_area_list);$j++) {
                                           $areaid = $audit_area_list[$j]['audit_area_id'];
                                           $areaname = $audit_area_list[$j]['audit_area'];
                                           if($audit_area_id == $areaid){
                                       
                                        ?>
                                    <option value="<?php echo $areaid; ?>"><?php echo  $areaname;?>
                                       <?php for($j=0;$j<count($audit_area_list);$j++) { 
                                          $areaid = $audit_area_list[$j]['audit_area_id'];
                                          if($areaid != $audit_area_id){ ?>
                                    <option value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>"><?php echo $audit_area_list[$j]['audit_area'];?></option>
                                    <?php } }}}}else{ ?> 
                                    <option value="0">Select Checklist</option>
                                    <?php for($j=0;$j<count($audit_area_list);$j++) { ?>
                                    <option value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>"><?php echo $audit_area_list[$j]['audit_area'];?></option>
                                    <?php }} ?>
                                 </select>
                              </div>
                           </div>
                           <!-- <div class="row" > -->
                           <div class="col-md-12" >
                              <table id="moduleTable" class="table custom-table" >
                                 <thead>
                                    <tr>
                                       <th>Area</th>
                                       <!-- <th>Sub area</th> -->
                                       <th>Assertion</th>
                                       <th>Audit Status</th>
                                       <th>Audit Remarks</th>
                                       <th>Recommendation</th>
                                       <th>Attachment</th>
                                       <th colspan="2" >Action</th>
                                    </tr>
                                 </thead>
                                 <?php if($idupd<=0){ ?>
                                 <tbody>
                                    <tr>
                                       <td>
                                          <input tabindex="3" type="text" class="form-control" id="major" placeholder="Enter Area" name="major[]" >
                                          </input> 
                                       </td>
                                       <!-- <td >
                                          <input tabindex="5" type="text" class="form-control" id="sub" name="sub[]" >
                                          </input> 
                                          </td> -->
                                       <td>
                                          <input tabindex="4" type="text" class="form-control" id="assertion" placeholder="Enter Assertion" name="assertion[]" ></input> 
                                       </td>
                                       <!-- <input tabindex="7" type="text" class="form-control" id="weightage" name="weightage[]" ></input>  -->
                                       <td>
                                          <!-- <input tabindex="7" type="text" class="form-control" id="Astatus" name="Astatus[]" > -->
                                          <select type="text" tabindex="5" name="prevstatus[]" id="prevstatus" class="form-control prevstatus">
                                             <option value=''>Select Status</option>
                                             <option value='1'>Yes</option>
                                             <option value='0'>No</option>
                                          </select>
                                       </td>
                                       <td><textarea tabindex="8" id="aremarks"  class="form-control" rows="1" name="aremarks[]"  cols="35" placeholder='Enter Audit Remarks'></textarea></td>
                                       <td><input tabindex="6" type="text" class="form-control" id="rcmd" name="rcmd[]" placeholder="Enter Recommendation"></td>
                                       <td><input type='file' tabindex='7' class='form-control' id='att_file' name='file[]' style='padding: 3px;'></td>
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
</form>
</div>