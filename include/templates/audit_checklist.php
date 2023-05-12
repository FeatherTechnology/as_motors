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
        <li class="breadcrumb-item">AS - Audit Check List </li>
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
                                                <label for="inputReadOnly"id="audit_err" >Audit Area</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                    <option value="">Select Area</option>
                                                    <?php if (sizeof($audit_area_list)>0) { 
                                                    for($j=0;$j<count($audit_area_list);$j++) { ?>
                                                    <option <?php if(isset($audit_area_id) and $audit_area_id == $audit_area_list[$j]['audit_area_id']){ echo "selected";  } ?>
                                                    value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>">
                                                    <?php echo $audit_area_list[$j]['audit_area'];?></option>
                                                    <?php } } ?>
                                                </select>
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <select tabindex="1" type="text" class="form-control" name="audit" id="audit">
                                                        <option value="">Select Area</option>
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
                                                <label for="inputReadOnly">Department </label>
                                                <input type="hidden" class="form-control" id="dept_id" name="dept_id" value="<?php if(isset($dept)) echo $dept; ?>" >
                                                <!-- <input type="text" class="form-control" id="dept" name="dept" value="<?php if(isset($dept_name)) echo $dept_name; ?>" readonly >                                 -->
                                                <input type="text" class="form-control" id="dept" name="dept" value="<?php if(isset($deptname)) echo $deptname; ?>" readonly >
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly">Role 1</label>
                                                <input type="hidden" class="form-control" id="auditor_id" name="auditor_id" value="<?php if(isset($auditor)) echo $auditor; ?>" >
                                                <input type="text" class="form-control" id="auditor" name="auditor" 
                                                value="<?php if(isset($auditor_name)) echo $auditor_name; ?>" readonly >                                
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly">Role 2</label>
                                                <input type="hidden" class="form-control" id="auditee_id" name="auditee_id" value="<?php if(isset($auditee)) echo $auditee; ?>">
                                                <input type="text" class="form-control" id="auditee" name="auditee" 
                                                value="<?php if(isset($auditee_name)) echo $auditee_name; ?>" readonly >                                
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-4">
                                            <div class="form-group">
                                                <?php if(!isset($audit_area_id)){ ?>
                                                <input type="checkbox" tabindex="2" name="checklist " id="checklist" > &nbsp;&nbsp;<label for="checklist" id='checklist_lable'> Use previous checklist</label></input>
                                                <?php }?>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                                            <div class="form-group">
                                                <select type="text" tabindex="3" name="prev " id="prev" style="display:none" class="form-control"> 
                                                    <option value="0">Select Checklist</option>
                                                    <?php if (sizeof($audit_area_list)>0) { 
                                                    for($j=0;$j<count($audit_area_list);$j++) { ?>
                                                    <option value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>">
                                                    <?php echo $audit_area_list[$j]['audit_area'];?></option>
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
                                            <!-- <th>Weightage</th> -->
                                            <th></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php if($idupd<=0){ ?>
                                        <tbody>
                                            <tr>
                                               
                                                <td>
                                                    <input tabindex="4" type="text" class="form-control" id="major" name="major[]" >
                                                    </input> 
                                                </td>
                                                <!-- <td >
                                                    <input tabindex="5" type="text" class="form-control" id="sub" name="sub[]" >
                                                    </input> 
                                                </td> -->
                                                <td>
                                                    <input tabindex="6" type="text" class="form-control" id="assertion" name="assertion[]" ></input> 
                                                </td>
                                                <!-- <td>
                                                    <input tabindex="7" type="text" class="form-control" id="weightage" name="weightage[]" ></input> 
                                                </td> -->
                                                <td>
                                                    <button type="button" tabindex="8" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button> 
                                                </td>
                                                <td><span class='icon-trash-2' tabindex="9" id="delete_row"></span></td>
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



