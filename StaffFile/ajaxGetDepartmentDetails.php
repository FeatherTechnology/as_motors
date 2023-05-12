<?php
@session_start();
include 'ajaxconfig.php';
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["designation_names"])){
    $designation_list = $_POST["designation_names"];
}
$designation_name_list = explode(',',$designation_list);

$designation_id = array();
$designation_name = array();

echo "<script>alert('vanakkam');</script>";

    for($i=0; $i<=sizeof($designation_name_list)-1; $i++){
        $getqry = "SELECT designation_name, designation_id FROM designation_creation WHERE designation_name ='".strip_tags($designation_name_list[$i])."' and status = 0";
        $res12 = $con->query($getqry);
        while($row12 = $res12->fetch_assoc())
        {
            $designation_id[] = $row12["designation_id"];        
            $designation_name[] = $row12["designation_name"];  
        }
     } 


     

    $minimumrequirementName["designation_id"] = $designation_id;

    $minimumrequirementName["designation_name"] = $designation_name;
    
    echo json_encode($minimumrequirementName);
?>