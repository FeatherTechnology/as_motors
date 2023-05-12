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
        //    $audit_area_id = $_POST['audit_area_id'];
           if(isset($idupd)) echo $idupd;
           $addAuditAssign = $userObj->addpromotional_activities($mysqli,$userid,$idupd);  
       ?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_promotional_activities&msc=2';</script> 
<?php	}
   else{  
      
       $addAuditAssign = $userObj->addpromotional_activities($mysqli,$userid,$idupd);   
?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_promotional_activities&msc=1';</script>
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
   $deleteAuditAreaCreation = $userObj->deletepromotional_activities($mysqli,$del); 
   ?>
<script>location.href='<?php echo $HOSTPATH; ?>edit_promotional_activities&msc=3';</script>
<?php	
   }
   
   if(isset($_GET['upd']))
   {
   $idupd=$_GET['upd'];
   }
   
   if($idupd>0)
   {
   	$getPromoActivities = $userObj->getPromoActivities($mysqli,$idupd); 
   	
   	if (sizeof($getPromoActivities)>0) {
           for($i=0;$i<sizeof($getPromoActivities);$i++)  {
               $project                  = $getPromoActivities['project'];
    
   	
   		}
   	}
       
       $getPromoActivities_ref = $userObj->getPromoActivities_ref($mysqli,$idupd);
       
       $promotional_activities_ref_id[]=array();
       $activity_involved[]=array();
       $audit_status[]=array();
       $time_frame_start[]=array();
       $duration[]=array();
 
   
       if (sizeof($getPromoActivities_ref)>0) {
           for($j=0;$j<sizeof($getPromoActivities_ref);$j++)  {
              
               $promotional_activities_ref_id[$j]    	                = $getPromoActivities_ref[$j]['promotional_activities_ref_id'];
               $activity_involved[$j]    	                = $getPromoActivities_ref[$j]['activity_involved'];
               $time_frame_start[$j]    	                = $getPromoActivities_ref[$j]['time_frame_start'];
               $duration[$j]    	                = $getPromoActivities_ref[$j]['duration'];
            
   		}
   	}
   }
   ?>
<!-- Page header start -->
<div class="page-header">
   <ol class="breadcrumb">
      <li class="breadcrumb-item">AS - Promotional Activities </li>
   </ol>
   <a href="edit_promotional_activities">
   <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
</div>
<!-- Page header end -->
<!-- Main container start -->
<div class="main-container">
   <!--------form start-->
   <form id = "audit_checklist" name="audit_checklist" action="" method="post" enctype="multipart/form-data">
      <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
      <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="audit_area_id" name="promotional_activities_ref_id" aria-describedby="id" placeholder="Enter id">
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
                                 <label for="disabledInput">Project</label>
                                 <input type="text" tabindex="1" name="project" id="project" class="form-control" value="<?php if(isset($project)) echo $project; ?>">
                              </div>
                           </div>
                          
                           <!-- <div class="row" > -->
                           <div class="col-md-12" >
                              <table id="moduleTable" class="table custom-table" >
                                 <thead>
                                    <tr>
                                       <th>Activity Involved</th>
                                       <th>Time Frame Start</th>
                                       <th>Duration</th>
                                       <th colspan="2" >Action</th>
                                    </tr>
                                 </thead>
                                 <?php if($idupd<=0){ ?>
                                 <tbody>
                                    <tr>
                                       <td>
                                          <input tabindex="3" type="text" class="form-control" id="activity_involved" placeholder="Enter Activity Involved" name="activity_involved[]" >
                                          </input> 
                                       </td>
                                       <td>
                                          <input tabindex="4" type="text" class="form-control" id="time_frame_start" placeholder="Enter Time_Frame_Start" name="time_frame_start[]" ></input> 
                                      </td>
                                       <td><input tabindex="6" type="text" class="form-control" id="duration" name="duration[]" placeholder="Enter Duration"></td>
                                      <td><button type="button" tabindex="9" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td>
                                       <td><span class='icon-trash-2' tabindex="10" id="delete_row"></span></td>
                                    </tr>
                                 </tbody>
                                 <?php } if($idupd>0){
                                    if(isset($id)){  ?>
                                 <tbody id='t2' >
                                    <?php for($g=0;$g<=count($activity_involved)-1;$g++) { ?>
                                    <tr>
                                       <td>
                                          <input  type="text" class="form-control" id="activity_involved" placeholder="Enter Activity Involved" name="activity_involved[]" value="<?php echo $activity_involved[$g]; ?>">
                                          <input  type="hidden" class="form-control" id="promotional_activities_ref_id" placeholder="Enter Activity Involved" name="promotional_activities_ref_id[]" value="<?php echo $promotional_activities_ref_id[$g]; ?>">
                                         </td>
                                         <td>
                                         <input type="number" class="form-control" id="time_frame_start" placeholder="Enter Time_Frame_Start" name="time_frame_start[]" value="<?php echo $time_frame_start[$g]?>">
                                         </td>
                                       <td>
                                          <input tabindex="4" type="text" class="form-control" id="duration" name="duration[]" placeholder="Enter Duration" value="<?php echo $duration[$g]; ?>"></input> 
                                       </td>
                                      
                                      
                                       <td>
                                          <button type="button" tabindex="8" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button> 
                                       </td>
                                       <td>
                                          <span class='icon-trash-2' tabindex="9" id="delete_row"></span> 
                                       </td>
                                       
                                     
                                       
                                    </tr>
                                      <?php }  ?>
                                    <?php } ?>
                                 </tbody>
                                 <?php }
                                   ?>
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