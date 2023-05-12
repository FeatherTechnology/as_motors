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
<!-- <script>location.href='<?php echo $HOSTPATH; ?>edit_audit_assign&msc=2';</script>  -->
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
<style>
   .hidden{
      display: none;
   }
</style>

<div class="page-header">
   
   <ol class="breadcrumb">
      <li class="breadcrumb-item">AS - Audit Follow Up </li>
   </ol>
   <a href="edit_audit_assign">
   <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
</div>

<!-- Page header end -->
<!-- Main container start -->
<div class="main-container">
   <!--form start-->
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
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3" style="margin-top: 0rem!important;">
                              <div class="form-group">
                              <label for="disabledInput">Checklist</label>
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
                                 <label for="inputReadOnly">Auditor</label>
                                 <input type="hidden" class="form-control" id="role1_id" name="role1_id" value="<?php if(isset($role1)) echo $role1; ?>" >
                                 <input type="text" class="form-control" id="role1" name="role1" value="<?php if(isset($auditor_name)) echo $auditor_name; ?>" readonly >
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="inputReadOnly">Auditee</label>
                                 <input type="hidden" class="form-control" id="role2_id" name="role2_id" value="<?php if(isset($role2)) echo $role2; ?>">
                                 <input type="text" class="form-control" id="role2" name="role2" value="<?php if(isset($auditee_name)) echo $auditee_name; ?>" readonly >
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                                 <label for="disabledInput">Date Of Audit</label>
                                 <input type="texty" tabindex="1" name="date_of_audit" id="date_of_audit" class="form-control" value="<?php echo date("d/m/Y") ; ?>" readonly>
                              </div>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                              <div class="form-group">
                              <button type="button" style="margin-top: 18px;" tabindex="9" id="tab_show" name="tab_show" value="" class="btn btn-primary add_row">Execute</button>
                              </div>
                           </div>
                          
                           <!-- <div class="row" > -->
                           <div class="col-md-12" >
                              <table id="moduleTable" class="table custom-table hidden" >
                                 <thead>
                                    <tr>
                                       <th> Assertion</th>
                                       <!-- <th>Sub area</th> -->
                                       <th>Audit Observation </th>
                                       <th>Attachment</th>
                                       <th>Auditee Response*</th>
                                       <th>Action plan*</th>
                                       <th>Target Date</th>
                                       <th colspan="2" >Action</th>
                                    </tr>
                                 </thead>
                                
                                 <tbody id='t1'>
                                    <tr>
                                    <td>
                                          <input tabindex="4" type="text" class="form-control" id="assertion"  name="assertion[]" ></input>
                                    </td>
                                    <td>
                                          <input tabindex="7" type="text" class="form-control" id="audit_remarks" name="audit_remarks[]" >
                                    </td>  
                                    <td>
                                       <input tabindex="6" type="text" class="form-control" id="attachment" name="attachment[]">
                                    </td>
                                    <td>
                                       <input type='text' tabindex='7' class='form-control' id='auditee_response' name='auditee_response[]'>
                                    </td>
                                    <td>
                                       <input type='text' tabindex='7' class='form-control' id='action_plan' name='action_plan[]'>
                                    </td>
                                    <td>
                                       <input type='text' tabindex='7' class='form-control' id='target_date' name='target_date[]'>
                                    </td>
                                       <td><button type="button" tabindex="9" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td>
                                       <td><span class='icon-trash-2' tabindex="10" id="delete_row"></span></td>
                                    </tr>
                                 </tbody>
                                 
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
         <h4 class="modal-title">Follow Up</h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="
    background-color: whitesmoke;
">
          <p>Some text in the modal.</p>
          <p>Some text in the modal.</p>
          <p>Some text in the modal.</p>
          <p>Some text in the modal.</p>
          <p>Some text in the modal.</p>
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</form>
</div>
 <!-- Modal -->
 
  
                    
                    
                     