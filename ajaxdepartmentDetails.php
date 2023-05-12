<?php
@session_start();
include 'ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}


    $department_id = array();
    $designation_name = array();
    $designation_id = array();
    $department_name = array();


    // get department_id and Designation_id based on
    $getInstName=$con->query("SELECT department, designation FROM basic_creation WHERE status = 0 AND FIND_IN_SET($company_id, company_id) > 0 ");
    while($row2=$getInstName->fetch_assoc()){
        $department[]    = $row2["department"];
        $designation[]    = $row2["designation"];
    } 

    // $getDesignationName   = $row2["designation"];

    for($i=0; $i<=sizeof($designation)-1; $i++){
        $getqry = "SELECT designation_name, designation_id FROM designation_creation WHERE designation_id ='".strip_tags($designation[$i])."' and status = 0";
        $res12 = $con->query($getqry);
        while($row12 = $res12->fetch_assoc())
        {
            $designation_id[] = $row12["designation_id"];        
            $designation_name[] = $row12["designation_name"];  
        }
     } 


     for($i=0; $i<=sizeof($department)-1; $i++){
         
        $getqry = "SELECT department_name, department_id FROM department_creation WHERE department_id ='".strip_tags($department[$i])."' and status = 0";
        $res12 = $con->query($getqry);
        while($row12 = $res12->fetch_assoc())
        {
            $department_id[] = $row12["department_id"];        
            $department_name[] = $row12["department_name"];          
        }
     } 


    $minimumrequirementName["department_id"] = $department_id;
    $minimumrequirementName["designation_id"] = $designation_id;

    $minimumrequirementName["designation_name"] = $designation_name;
    $minimumrequirementName["department_name"] = $department_name;
    
    echo json_encode($minimumrequirementName);
?>