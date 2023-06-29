<?php
include '../ajaxconfig.php';

if(isset($_POST['work_id'])){
    $work_id = $_POST['work_id'];
}
?>
    <div class="form-group" >
    <label class="label">In Progress Remark</label>
    
    <?php
        $getqry = "SELECT `remarks`, `completed_file`, `created_date` FROM `work_status` WHERE `work_id` = '$work_id' && `work_status` = 1 "; 
        $res3 = $con->query($getqry);
        if(mysqli_num_rows($res3)>0){
        while($row3 = $res3->fetch_assoc()){
            ?>
            <input type="text" class="form-control" name="remark_inserted_date" id="remark_inserted_date" value="<?php echo date('d-m-Y',strtotime($row3['created_date'])); ?>" readonly> <br>
            <textarea name="in_progress_Remark" id="in_progress_Remark" class="form-control" style="height:100px ; width: 350px" readonly><?php echo $row3['remarks'];?></textarea><br><br>
            
            <?php 
        }      
    }else{ ?>
        <label class="required"> No In Progress Remark Uploaded </label> <br><br>
    <?php

    }
    ?>
    </div>