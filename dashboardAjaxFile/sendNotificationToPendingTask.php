<?php
include '../ajaxconfig.php';
@session_start();
if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
}
if(isset($_SESSION['curdateFromIndexPage'])){
    $curdate = $_SESSION['curdateFromIndexPage'];
}
if(isset($_POST['task_name'])){
    $task_name = $_POST['task_name'];
}
if(isset($_POST['task_id'])){
    $task_id = $_POST['task_id'];
}
if(isset($_POST['work_des'])){
    $work_des = $_POST['work_des'];
}
if(isset($_POST['des_staff_id'])){
    $des_staff_id = $_POST['des_staff_id'];
}
//The super Admin/Manager can raise a alert message to staff who have pending task. first time it will be insert if second time raised means it update a created_date because the notification will be shown order by created_date. 
$result = $con->query("SELECT * FROM `pending_task_notification` WHERE `task_name` = '$task_name' && `task_id` = '$task_id' ");
if(mysqli_num_rows($result)>0){
    $insupdresult = $con->query("UPDATE `pending_task_notification` SET `updated_login_id` = '$userid', `created_date`='$curdate' WHERE `task_name`='$task_name' && `task_id`='$task_id' ");

}else{
    if($task_name == 'ToDo' || $task_name == 'Campaign' || $task_name == 'FC INSURANCE RENEW'){ //insert staff directly.
        $insupdresult = "INSERT INTO `pending_task_notification`(`task_name`, `task_id`, `work_des`, `staff_id`, `insert_login_id`, `created_date`) VALUES ('$task_name', '$task_id','$work_des', '$des_staff_id', '$userid', '$curdate') ";
        $result = $con->query($insupdresult) or die("ERROR ON pending_task_notification Staff id");

    }else{ //insert designation. 
        $insupdresult = "INSERT INTO `pending_task_notification`(`task_name`, `task_id`, `work_des`, `designation_id`, `insert_login_id`, `created_date`) VALUES ('$task_name', '$task_id','$work_des', '$des_staff_id', '$userid', '$curdate') ";
        $result = $con->query($insupdresult) or die("ERROR ON pending_task_notification Designation id");
        
    }
}

if($insupdresult){
    $message = 0; //true
}else{
    $message = 1; //false
}

?>