<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    // $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
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
        $updateAuditAreaCreationmaster = $userObj->updateAuditAreaChecklist($mysqli,$id,$audit_area_id);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_audit_area_checklist&msc=2';</script> 
    <?php	}
    else{   
        $addAuditAreaCreation = $userObj->addAuditChecklist($mysqli);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_audit_area_checklist&msc=1';</script>
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
	$deleteAuditAreaCreation = $userObj->deleteAuditAreaChecklist($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_audit_area_checklist&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}

if($idupd>0)
{
	$getAuditAreaChecklist = $userObj->getAuditAreaChecklist($mysqli,$idupd); 
	
	if (sizeof($getAuditAreaChecklist)>0) {
        for($i=0;$i<sizeof($getAuditAreaChecklist);$i++)  {

            $audit_area_id                  = $getAuditAreaChecklist['area_id']; 
            $audit_area_name                  = $getAuditAreaChecklist['area_name']; 
			$dept                	 = $getAuditAreaChecklist['department'];
            $dept                  = $getAuditAreaChecklist['department'];
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
            $auditor                	     = $getAuditAreaChecklist['auditor'];
            $auditor_name                	     = $getAuditAreaChecklist['auditor_name'];
			$auditee    	                = $getAuditAreaChecklist['auditee'];
			$auditee_name    	                = $getAuditAreaChecklist['auditee_name'];
		}
	}
    $getAuditChecklist_ref = $userObj->getAuditChecklist_ref($mysqli,$audit_area_id);
    $major[]=array();
    $sub[]=array();
    $assertion[]=array();
    $weightage[]=array();

    if (sizeof($getAuditChecklist_ref)>0) {
        for($j=0;$j<sizeof($getAuditChecklist_ref);$j++)  {

            $major[$j]    	                = $getAuditChecklist_ref[$j]['major_area'];
            $assertion[$j]    	                = $getAuditChecklist_ref[$j]['assertion'];
            $weightage[$j]    	                = $getAuditChecklist_ref[$j]['weightage'];
	
		}
	}
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Appreciation_Depreciatione</li>
    </ol>

    <a href="edit_audit_area_checklist">
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
                                                <label for="inputReadOnly"id="audit_err" >Company Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                    <option value="">Select Company</option>
                                                    <?php if (sizeof($audit_area_list)>0) { 
                                                    for($j=0;$j<count($audit_area_list);$j++) { ?>
                                                    <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list[$j]['audit_area_id']){ echo "selected";  } ?>
                                                    value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>">
                                                    <?php echo $audit_area_list[$j]['audit_area'];?></option>
                                                    <?php } } ?>
                                                </select>
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                        <option value="">Select Company</option>
                                                        <?php if (sizeof($audit_area_list1)>0) { 
                                                        for($j=0;$j<count($audit_area_list1);$j++) { ?>
                                                        <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list1[$j]['audit_area_id']){ echo "selected";  } ?>
                                                        value="<?php echo $audit_area_list1[$j]['audit_area_id']; ?>">
                                                        <?php echo $audit_area_list1[$j]['audit_area'];?></option>
                                                        <?php } } ?>  
                                                    </select>
                                            <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Department</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                    <option value="">Select Department</option>
                                                    <?php if (sizeof($audit_area_list)>0) { 
                                                    for($j=0;$j<count($audit_area_list);$j++) { ?>
                                                    <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list[$j]['audit_area_id']){ echo "selected";  } ?>
                                                    value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>">
                                                    <?php echo $audit_area_list[$j]['audit_area'];?></option>
                                                    <?php } } ?>
                                                </select>
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                        <option value="">Select Department</option>
                                                        <?php if (sizeof($audit_area_list1)>0) { 
                                                        for($j=0;$j<count($audit_area_list1);$j++) { ?>
                                                        <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list1[$j]['audit_area_id']){ echo "selected";  } ?>
                                                        value="<?php echo $audit_area_list1[$j]['audit_area_id']; ?>">
                                                        <?php echo $audit_area_list1[$j]['audit_area'];?></option>
                                                        <?php } } ?>  
                                                    </select>
                                            <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Role</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                    <option value="">Select Role</option>
                                                    <?php if (sizeof($audit_area_list)>0) { 
                                                    for($j=0;$j<count($audit_area_list);$j++) { ?>
                                                    <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list[$j]['audit_area_id']){ echo "selected";  } ?>
                                                    value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>">
                                                    <?php echo $audit_area_list[$j]['audit_area'];?></option>
                                                    <?php } } ?>
                                                </select>
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                        <option value="">Select Role</option>
                                                        <?php if (sizeof($audit_area_list1)>0) { 
                                                        for($j=0;$j<count($audit_area_list1);$j++) { ?>
                                                        <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list1[$j]['audit_area_id']){ echo "selected";  } ?>
                                                        value="<?php echo $audit_area_list1[$j]['audit_area_id']; ?>">
                                                        <?php echo $audit_area_list1[$j]['audit_area'];?></option>
                                                        <?php } } ?>  
                                                    </select>
                                            <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Emp Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                    <option value="">Select Emp Name</option>
                                                    <?php if (sizeof($audit_area_list)>0) { 
                                                    for($j=0;$j<count($audit_area_list);$j++) { ?>
                                                    <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list[$j]['audit_area_id']){ echo "selected";  } ?>
                                                    value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>">
                                                    <?php echo $audit_area_list[$j]['audit_area'];?></option>
                                                    <?php } } ?>
                                                </select>
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                        <option value="">Select Emp Name</option>
                                                        <?php if (sizeof($audit_area_list1)>0) { 
                                                        for($j=0;$j<count($audit_area_list1);$j++) { ?>
                                                        <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list1[$j]['audit_area_id']){ echo "selected";  } ?>
                                                        value="<?php echo $audit_area_list1[$j]['audit_area_id']; ?>">
                                                        <?php echo $audit_area_list1[$j]['audit_area'];?></option>
                                                        <?php } } ?>  
                                                    </select>
                                            <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Month</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                    <option value="">Select Month</option>
                                                    <?php if (sizeof($audit_area_list)>0) { 
                                                    for($j=0;$j<count($audit_area_list);$j++) { ?>
                                                    <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list[$j]['audit_area_id']){ echo "selected";  } ?>
                                                    value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>">
                                                    <?php echo $audit_area_list[$j]['audit_area'];?></option>
                                                    <?php } } ?>
                                                </select>
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                        <option value="">Select Month</option>
                                                        <?php if (sizeof($audit_area_list1)>0) { 
                                                        for($j=0;$j<count($audit_area_list1);$j++) { ?>
                                                        <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list1[$j]['audit_area_id']){ echo "selected";  } ?>
                                                        value="<?php echo $audit_area_list1[$j]['audit_area_id']; ?>">
                                                        <?php echo $audit_area_list1[$j]['audit_area'];?></option>
                                                        <?php } } ?>  
                                                    </select>
                                            <?php } ?>
                                            </div>
                                        </div>

                                        

                        <!-- <div class="row" > -->
                            <div class="col-md-12" >
                                <table id="moduleTable" class="table custom-table" >
                                    <thead>
                                        <tr>
                                            <th>Assertion</th>
                                            <th>Target</th>
                                            <th>Overall Performance</th>
                                            <th>Achievement</th>
                                            <th>Employee Rating</th>
                                            <th>Not Done/Carry Forward</th>
                                        </tr>
                                    </thead>
                                    <?php if($idupd<=0){ ?>
                                        <tbody>
                                            <tr>
                                               
                                                <td>
                                                    <input tabindex="4" type="text" class="form-control" id="assertion" name="assertion[]" >
                                                    </input> 
                                                </td>
                                                <td >
                                                    <input tabindex="5" type="text" class="form-control" id="target" name="target[]" >
                                                    </input> 
                                                </td>
                                                <td>
                                                    <input  type="text" class="form-control" id="operformance" name="operformance[]" value=""></input> 
                                                </td>
                                                <td>
                                                    <input  type="text" class="form-control" id="achievement" name="achievement[]" ></input> 
                                                </td>
                                                <td>
                                                    <input  type="text" class="form-control" id="erating" name="erating[]" ></input> 
                                                </td>
                                                
                                                <td>
                                                   
                                                </td>
                                               
                                            </tr>
                                        </tbody>
                                    <?php } if($idupd>0){
                                            if(isset($audit_area_id)){ ?>
                                                <tbody>
                                                    <?php for($g=0;$g<=count($major)-1;$g++) { ?>
                                                        <tr>
                                                            <td>
                                                                <input tabindex="4" type="text" class="form-control" id="major" name="major[]" value="<?php echo $major[$g]?>">
                                                                </input> 
                                                            </td>
                                                            <!-- <td>
                                                                <input tabindex="5" type="text" class="form-control" id="sub" name="sub[]" value="<?php echo $sub[$g]?>">
                                                                </input> 
                                                            </td> -->
                                                            <td>
                                                                <input tabindex="6" type="text" class="form-control" id="assertion" name="assertion[]" value="<?php echo $assertion[$g]?>"></input> 
                                                            </td>
                                                            <!-- <td>
                                                                <input tabindex="7" type="text" class="form-control" id="weightage" name="weightage[]" value="<?php echo $weightage[$g]?>"></input> 
                                                            </td> -->
                                                            <td>
                                                                <button type="button" tabindex="8" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button> 
                                                            </td>
                                                            <td><span class='icon-trash-2' tabindex="9" id="delete_row"></span></td>
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
                        
                        <div class="col-md-12 "> 
                              <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Overall Rating</label>
                                                <input tabindex="4" type="text" class="form-control" id="orating" name="orating[]">
                                            </div>
                                        </div>
                              </div>
                             <div class="row"> 
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Memo if Required</label>
                                                <input tabindex="4" type="text" class="form-control" id="orating" name="orating[]">
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



