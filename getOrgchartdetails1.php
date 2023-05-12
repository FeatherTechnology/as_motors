<?php
include('ajaxconfig.php');
if(isset($_POST["userid"])){
    $userid = $_POST["userid"];
} 
// if($userid == '1'){
    function getStaffName($con, $top_des_name1){

        $k=0;
        $staffName = array();
        foreach($top_des_name1 as $top_des_name){
            $getdesignation = "SELECT * FROM staff_creation where designation = '".$top_des_name."' and status = 0";
            $resdesignation = $con->query($getdesignation) or die("Error On designation");
            
            $l=0;
            while($rowdept = $resdesignation->fetch_assoc()){
                $staffName[$k][$l] = $rowdept['staff_name'];
                $l++;
            }
            $k++;
        }
            return $staffName;
    }

    function getStaffCode($con, $top_des_name1){

        $k=0;
        $staffCode = array();
        foreach($top_des_name1 as $top_des_name){
            $l=0;
            $getdesignation = "SELECT * FROM staff_creation where designation = '".$top_des_name."' and status = 0";
            $resdesignation = $con->query($getdesignation) or die("Error On designation");

            while($rowdept = $resdesignation->fetch_assoc()){
                $staffCode[$k][$l] = $rowdept['emp_code'];
                $l++;
            }
            $k++;
        }
            return $staffCode;
    }


    $chartRecords = array();

    $getuser = "SELECT * FROM user where user_id = '".$userid."' ";
    $resuser = $con->query($getuser) or die("Error On user");
    $rowuser = $resuser->fetch_assoc();
    $chartRecords['userfullname'] = $rowuser['fullname'];
    $chartRecords['userbranch_id'] = $rowuser['branch_id'];

    $getcompany = "SELECT * FROM company_creation where insert_login_id = '".$userid."' and status = 0";
    $rescompany = $con->query($getcompany) or die("Error On company");
    $i=0;
    while($rowcomp = $rescompany->fetch_assoc()){
        $chartRecords['company_id'][$i]= $rowcomp['company_id'];
        $chartRecords['company_name'][$i]= $rowcomp['company_name'];
        $chartRecords['company_address1'][$i]= $rowcomp['address1'];
        $chartRecords['company_address2'][$i]= $rowcomp['address2'];
        $chartRecords['company_city'][$i]= $rowcomp['city'];
        $i++;
    }

    if($chartRecords['userbranch_id'] != 'Overall'){
        $getbranch = "SELECT * FROM branch_creation where branch_id = '".$chartRecords['userbranch_id']."' and status = 0";
    }else{
        $getbranch = "SELECT * FROM branch_creation where status = 0";
    }
    $resbranch = $con->query($getbranch) or die("Error On branch");
    $i=0;
    while($rowcomp = $resbranch->fetch_assoc()){
        $chartRecords['branch_id'][$i]= $rowcomp['branch_id'];
        $chartRecords['branch_company_id'][$i]= $rowcomp['company_id'];
        $chartRecords['branch_name'][$i]= $rowcomp['branch_name'];
        $chartRecords['branch_address'][$i]= $rowcomp['address1']. ','.$rowcomp['address2'].','.$rowcomp['city'].'.';
        $i++;
    }

    foreach( $chartRecords['branch_id'] as $branchid){
        //get Hierarchy table
        $gethierarchy = "SELECT * FROM hierarchy_creation where company_id= '".$branchid."' and status = 0 ";
        $reshierarchy = $con->query($gethierarchy) or die("Error On hierarchy");
        $i=0;

        while($rowcomp = $reshierarchy->fetch_assoc()){
            $chartRecords['hierarchy_id'][$i]= $rowcomp['hierarchy_id'];
            $chartRecords['hierarchy_branch_id'][$i]= $rowcomp['company_id'];
            $chartRecords['department_id'][$i]= $rowcomp['department_id'];
            $chartRecords['top_designation'][$i]= explode(',',$rowcomp['top_hierarchy']);
            $chartRecords['sub_designation'][$i]= explode(',',$rowcomp['sub_ordinate']);

            $getdepartment = "SELECT * FROM department_creation where department_id = '".$chartRecords['department_id'][$i]."' and status = 0";
            $resdepartment = $con->query($getdepartment) or die("Error On department");
            while($rowdept = $resdepartment->fetch_assoc()){
                $chartRecords['department_branch_id'][$i]= $rowdept['company_id'];
                $chartRecords['department_name'][$i]= $rowdept['department_name'];
            }
            $j=0;
            foreach($chartRecords['top_designation'][$i] as $top_des)
            {
                $getdesignation = "SELECT * FROM designation_creation where designation_id = '".$top_des."' and status = 0";
                $resdesignation = $con->query($getdesignation) or die("Error On designation");
                while($rowdept = $resdesignation->fetch_assoc()){
                    $chartRecords['top_designation_branch_id'][$i]= $rowdept['company_id'];
                    $chartRecords['top_designation_id'][$i][$j]= $rowdept['designation_id'];
                    $chartRecords['top_designation_name'][$i][$j] = $rowdept['designation_name'];
                    $chartRecords['top_designation_staff_name'][$i] = getStaffName($con, $chartRecords['top_designation_id'][$i]);
                    $chartRecords['top_designation_staff_code'][$i] = getStaffCode($con, $chartRecords['top_designation_id'][$i]);
                    

                }
                $j++;
            }
            $j=0;
            foreach($chartRecords['sub_designation'][$i] as $sub_des)
            {
                $getdesignation = "SELECT * FROM designation_creation where designation_id = '".$sub_des."' and status = 0";
                $resdesignation = $con->query($getdesignation) or die("Error On designation");
                while($rowdept = $resdesignation->fetch_assoc()){
                    $chartRecords['sub_designation_branch_id'][$i]= $rowdept['company_id'];
                    $chartRecords['sub_designation_id'][$i][$j]= $rowdept['designation_id'];
                    $chartRecords['sub_designation_name'][$i][$j]= $rowdept['designation_name'];
                    $chartRecords['sub_designation_staff_name'][$i]= getStaffName($con, $chartRecords['sub_designation_id'][$i]) ;
                    $chartRecords['sub_designation_staff_code'][$i]= getStaffCode($con, $chartRecords['sub_designation_id'][$i]) ;
                }$j++;
            }
            
            $i++;
        } 
    }
    // print_r($chartRecords); die;
    echo json_encode($chartRecords);

?>