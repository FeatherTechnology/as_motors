<?php
include '../ajaxconfig.php';

if(isset($_POST['work_id'])){
    $work_id = $_POST['work_id'];
}

// To Split string and number in work_id./////

// $inputString = "krakpi_ref 44";
// $pattern = '/([a-zA-Z_]+)\s(\d+)/';
// $matches = array();

// preg_match($pattern, $work_id, $matches);

// if (count($matches) > 0) {
//     $stringPart = $matches[1];
//     $numberPart = $matches[2];
    
//     echo "String part: " . $stringPart . "\n<br>";
//     echo "Number part: " . $numberPart . "\n<br>";
    
// }

    // $workDescription = array();
        $getqry = "SELECT `remarks`, `completed_file` FROM `work_status` WHERE `work_id` = '$work_id' && `work_status` = 3 "; // Work id is from task table id , it comes from multiple table so differentiate by table name or task name in work_id column.
        $res3 = $con->query($getqry);
        if(mysqli_num_rows($res3)>0){
            $row3 = $res3->fetch_assoc();      
            // $workDescription['remark'] = $row3["remarks"]; 
            // $workDescription['completedFile'] = $row3["completed_file"]; 
            ?>
            <div class="form-group ">
                <label class="label" id="over_due_label" >Completed File</label>
                <a href='uploads/completedTaskFile/<?php echo $row3["completed_file"];?>' download id="com_file"><li><?php echo $row3["completed_file"];?></li></a><br>
                <label class="label">Completed Remark</label>
                <textarea name="completed_Remark" id="completed_Remark" class="form-control" style="height:100px ; width: 350px" readonly><?php echo $row3["remarks"];?></textarea><br>
            </div>
            <?php
        }else{ ?>
        <div class="form-group ">
            <label class="label">Completed Remark</label>
            <label class="required"> No Completed Remark Uploaded </label> <br><br>
        </div>
        <?php
        }

// echo json_encode($workDescription);
?>