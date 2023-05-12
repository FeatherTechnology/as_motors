<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
	$branch_id = $_SESSION["branch_id"];
}
if(isset($_POST["audit_assign_id"])){
    $audit_assign_id  = $_POST["audit_assign_id"];
}
?>

<div class="card" id="stockinformation">
    <!-- <div class="card-header">Audit Assign</div> -->
    <div class="card-body ">
        <br> 
        <div style="overflow-x: auto; white-space: nowrap;" >
            <?php
            $major_area = array();          
            $assertion = array();         
            $audit_status = array();         
            $audit_remarks = array();         
            $recommendation = array();         
            $attachment = array();         

            $selectDailyKMRef = $con->query("SELECT * FROM audit_assign_ref WHERE audit_assign_id = '".strip_tags($audit_assign_id)."' AND audit_status = '0' AND auditee_response_status = '0' ");
            while($row2 = $selectDailyKMRef->fetch_assoc()){
                $audit_assign_ref_id[] 	= $row2["audit_assign_ref_id"];
                $major_area[] 	= $row2["major_area"];
                $assertion[] 	= $row2["assertion"];
                $audit_status[] 	= $row2["audit_status"];
                $audit_remarks[] 	= $row2["audit_remarks"];
                $recommendation[] 	= $row2["recommendation"];
                $attachment[] 	= $row2["attachment"];
            } 
            ?>

            <table class="table custom-table" id="sstable">
                <tr>
                    <th>S. No.</th>
                    <th></th>
                    <th>Area</th>
                    <th>Assertion</th>
                    <th>Audit Status</th>
                    <th>Audit Remarks</th>
                    <th>Recommendation</th>
                    <th>Attachment</th>
                    <th>Auditee Response <span class="text-danger">*</span></th>
                    <th>Action Plan <span class="text-danger">*</span></th>
                    <th>Target Date</th>
                </tr>
                <?php
                $sno = 1;   
                if(isset($audit_assign_ref_id)){
                    for($o=0; $o<=sizeof($audit_assign_ref_id)-1; $o++){ ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td><input tabindex="4" type="checkbox" class="audit_assign_ref_id" name="audit_assign_ref_id[]" id="audit_assign_ref_id" value="<?php echo $audit_assign_ref_id[$o]; ?>" /></td>
                                <td><input type="text" readonly class="form-control" name="major_area[]" id="major_area" value="<?php echo $major_area[$o]; ?>" ></td>
                                <td><input tabindex="6" readonly type="text" class="form-control" name="assertion[]" id="assertion" value="<?php echo $assertion[$o]; ?>" ></td>
                                <td><input tabindex="6" readonly type="text" class="form-control" name="audit_status[]" id="audit_status" value="<?php if($audit_status[$o] == '0') { echo "No"; } else if($audit_status[$o] == '1') { echo 'Yes'; } ?>" ></td>
                                <td><input tabindex="6" readonly type="text" class="form-control" name="audit_remarks[]" id="audit_remarks" value="<?php echo $audit_remarks[$o]; ?>" ></td>
                                <td><input tabindex="6" readonly type="text" class="form-control" name="recommendation[]" id="recommendation" value="<?php echo $recommendation[$o]; ?>" ></td>
                                <td><a href="uploads/audit_assign/<?php echo $attachment[$o]; ?>" download><li><?php echo $attachment[$o]; ?></li></a></td>
                                <td><input tabindex="6" readonly type="text" class="form-control" name="auditee_response[]" id="auditee_response" ></td>
                                <td><input tabindex="6" readonly type="text" class="form-control" name="action_plan[]" id="action_plan" ></td>
                                <td><input tabindex="6" readonly type="date" class="form-control" name="target_date[]" id="target_date" ></td>
                            </tr>
                        </tbody>
                    <?php $sno = $sno + 1; }
                } ?>
            </table>
        </div>
    </div>
</div>
    
<script>
    // set enable and disable condition
    $(".audit_assign_ref_id").on('click', function() { 
        var checkbox = $(this).parents('tr').find('td #audit_assign_ref_id').is(":checked");
        if (checkbox) { 
            $(this).parents('tr').find('td #auditee_response').attr("readonly",false);
            $(this).parents('tr').find('td #action_plan').attr("readonly",false);
            $(this).parents('tr').find('td #target_date').attr("readonly",false);
        } else { 
            $(this).parents('tr').find('td #auditee_response').attr("readonly",true);
            $(this).parents('tr').find('td #action_plan').attr("readonly",true);
            $(this).parents('tr').find('td #target_date').attr("readonly",true);
        }
    });
</script>