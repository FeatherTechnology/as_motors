<?php
   @session_start();
   if(isset($_SESSION["userid"])){
       $userid = $_SESSION["userid"];
   }
  
   $audit_area_list = $userObj->getAuditAreaTable($mysqli);

   $id=0;

   $idupd=0;
    if(isset($_POST['submit_audit_followup']) && $_POST['submit_audit_followup'] != '')
    {
       
           $id = $_POST['id'];
           $audit_area_id = $_POST['audit_area_id'];
          
    }
      
      ?>


<!-- Page header start -->
<style>
.hidden {
    display: none;
}
</style>

<div class="page-header">

    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Audit Follow Up </li>
    </ol>
    <!-- <a href="audit_followup">
   <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a> -->
</div>

<!-- Page header end -->
<!-- Main container start -->
<div class="main-container">
    <!--form start-->
    <form id="audit_checklist" name="audit_checklist" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>" id="id" name="id"
            aria-describedby="id" placeholder="Enter id">
        <input type="hidden" class="form-control" value="<?php if(isset($audit_area_id)) echo $audit_area_id ?>"
            id="audit_area_id" name="audit_area_id" aria-describedby="id" placeholder="Enter id">
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
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3"
                                        style="margin-top: 0rem!important;">
                                        <div class="form-group">
                                            <label for="disabledInput">Checklist</label>
                                            <select type="text" tabindex="2" name="prev" id="prev" class="form-control">
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
                                                <option value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>">
                                                    <?php echo $audit_area_list[$j]['audit_area'];?></option>
                                                <?php } }}}}else{ ?>
                                                <option value="0">Select Checklist</option>
                                                <?php for($j=0;$j<count($audit_area_list);$j++) { ?>
                                                <option value="<?php echo $audit_area_list[$j]['audit_area_id']; ?>">
                                                    <?php echo $audit_area_list[$j]['audit_area'];?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Department </label>
                                            <input type="hidden" class="form-control" id="dept_id" name="dept_id"
                                                value="<?php if(isset($dept)) echo $dept; ?>">
                                            <input type="text" class="form-control" id="dept" name="dept"
                                                value="<?php if(isset($deptname)) echo $deptname; ?>" readonly>
                                            <!-- <input type="text" class="form-control" id="dept" name="dept"
                                    value="<?php if(isset($dept_name)) echo $dept_name; ?>" readonly >                                 -->
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Auditor</label>
                                            <input type="hidden" class="form-control" id="role1_id" name="role1_id"
                                                value="<?php if(isset($role1)) echo $role1; ?>">
                                            <input type="text" class="form-control" id="role1" name="role1"
                                                value="<?php if(isset($auditor_name)) echo $auditor_name; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Auditee</label>
                                            <input type="hidden" class="form-control" id="role2_id" name="role2_id"
                                                value="<?php if(isset($role2)) echo $role2; ?>">
                                            <input type="text" class="form-control" id="role2" name="role2"
                                                value="<?php if(isset($auditee_name)) echo $auditee_name; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Date Of Audit</label>
                                            <input type="texty" tabindex="1" name="date_of_audit" id="date_of_audit"
                                                class="form-control" value="<?php echo date("d/m/Y") ; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button type="button" style="margin-top: 18px;" tabindex="9" id="tab_show"
                                                name="tab_show" value=""
                                                class="btn btn-primary add_row">Execute</button>
                                        </div>
                                    </div>

                                    <!-- <div class="row" > -->
                                    <div class="col-md-12">
                                        <table id="moduleTable" class="table custom-table hidden">
                                            <thead>
                                                <tr>
                                                    <th> Assertion</th>
                                                    <!-- <th>Sub area</th> -->
                                                    <th>Audit Observation </th>
                                                    <th>Attachment</th>
                                                    <th>Auditee Response*</th>
                                                    <th>Action plan*</th>
                                                    <th>Target Date</th>
                                                    <th colspan="2">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id='t1'>
                                                <tr>
                                                    <td>
                                                        <input tabindex="4" type="text" class="form-control"
                                                            id="assertion" name="assertion[]"></input>
                                                    </td>
                                                    <td>
                                                        <input tabindex="7" type="text" class="form-control"
                                                            id="audit_remarks" name="audit_remarks[]">
                                                    </td>
                                                    <td>
                                                        <input tabindex="6" type="text" class="form-control"
                                                            id="attachment" name="attachment[]">
                                                    </td>
                                                    <td>
                                                        <input type='text' tabindex='7' class='form-control'
                                                            id='auditee_response' name='auditee_response[]'>
                                                    </td>
                                                    <td>
                                                        <input type='text' tabindex='7' class='form-control'
                                                            id='action_plan' name='action_plan[]'>
                                                    </td>
                                                    <td>
                                                        <input type='text' tabindex='7' class='form-control'
                                                            id='target_date' name='target_date[]'>
                                                    </td>
                                                    <td><button type="button" tabindex="9" id="add_row" name="add_row"
                                                            value="Submit" class="btn btn-primary add_row">Add</button>
                                                    </td>
                                                    <td><span class='icon-trash-2' tabindex="10" id="delete_row"></span>
                                                    </td>
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

            </div>
        </div>
</div>
</div>
</form>
<form>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Follow Up</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="background-color: whitesmoke;">
                    <div class="form-group">
                        <label for="remarks">Remarks *</label>
                        <?php 
                                             if(isset($_SESSION["userid"])){
                                                   $userid = $_SESSION["userid"];
                                             }
                                        ?>
                        <textarea id='remarks' class='form-control' rows='5' name='remarks' cols='35'
                            placeholder='Enter Audit Remarks'></textarea>
                        <input type='hidden' class='form-control assignid' id='assignidc' name='assidnid' value=""
                            readonly>
                        <input type='hidden' class='form-control assignrefid' id='assignrefidc' name='assidnrefid'
                            value="" readonly>
                        <input type='hidden' class='form-control userid' id='userid' name='userid'
                            value="<?php echo   $userid;?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="date">Completed Date *</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="form-group">
                        <label for="file">Attachment If Any</label>
                        <input type="file" class="form-control" style='padding: 3px;' id="file" name="file">

                    </div>

                </div>
                <div class="modal-footer" style="background-color: whitesmoke;">
                    <button type="button" id="insert" class="btn btn-primary insert" name="insert">Submit</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</form>
</div>
<!-- Modal -->