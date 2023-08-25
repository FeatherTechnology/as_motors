<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}
if(isset($_SESSION["designation_id"])){
    $designation_id = $_SESSION["designation_id"];
}else{
    $designation_id = 0;
}

$column = array(

    'audit_assign_id',
    'date_of_audit',
    'department_id',
    'role1',
    'role2',
    'status'
);

$query = "SELECT * FROM audit_assign WHERE 1";
// if($sbranch_id == 'Overall'){
    $query .= '';
    // if($_POST['search']!="");
    // {
    //     if (isset($_POST['search'])) {

    //         if($_POST['search']=="Active")
    //         {
    //             $query .="and status=0 "; 
    //         }
    //         else if($_POST['search']=="Inactive")
    //         {
    //             $query .="and status=1 ";
    //         }

    //         else {
    //             $query .= "
    //             OR date_of_audit LIKE '%".$_POST['search']."%'
    //             OR department_id LIKE  '%".$_POST['search']."%'
    //             OR role1 LIKE  '%".$_POST['search']."%'
    //             OR role2 LIKE  '%".$_POST['search']."%'
    //             OR status LIKE '%".$_POST['search']."%' ";
    //         }
    //     }
    // }
// }else{
//     $query .=" and company_id= '".$sbranch_id."' ";
// }

    $query .=" and (role1 = '".$designation_id."' || role2 = '".$designation_id."' )";

    if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= ' ';
}

$query1 = '';

if ($_POST['length'] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$number_filter_row = $statement->rowCount();
$statement = $connect->prepare($query . $query1);
$statement->execute();
$result = $statement->fetchAll();
$data = array();

$sno = 1;
foreach ($result as $row) {

    if($row['auditee_response_status'] == 0){
        // get company name
        $audit_status = array();
        $qry = "SELECT * FROM audit_assign_ref WHERE audit_assign_id = '".$row['audit_assign_id']."' AND audit_status = '0' "; 
        $res = $con->query($qry);
        while($row5 = $res->fetch_assoc())
        {
            $audit_status[] = $row5['audit_status'];
        }
        
        if($audit_status > 0){

            $sub_array = array();
            if($sno!="")
            {
                $sub_array[] = $sno;
            }

            $role1Name='';
            $role1Id = $row['role1'];   
            $getAuditorName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($row['role1'])."' and status = 0";
            $res12 = $con->query($getAuditorName);
            while($row12 = $res12->fetch_assoc())
            {
            $role1Name = $row12["designation_name"];        
            }
            
            $role2Name='';
            $role2Id = $row['role2'];   
            $getAuditeeName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($row['role2'])."' and status = 0";
            $res14 = $con->query($getAuditeeName);
            while($row14 = $res14->fetch_assoc())
            {
            $role2Name = $row14["designation_name"];        
            }

            // get department name
            $departmentName=''; 
            $getqry3 = "SELECT * FROM department_creation WHERE department_id ='".strip_tags($row['department_id'])."' and status = 0";
            $res3 = $con->query($getqry3);
            while($row3 = $res3->fetch_assoc())
            {
                $departmentName = $row3["department_name"];          
            }

            $sub_array[] = $row['date_of_audit'];
            $sub_array[] = $departmentName;
            $sub_array[] = $role1Name;
            $sub_array[] = $role2Name;

            $id   = $row['audit_assign_id'];
            $action="<a href='auditee_response&dashboard_upd=$id' title='Edit details'><span class='btn btn-success'>View</span></a>&nbsp;&nbsp;";

            $sub_array[] = $action;
            $data[]      = $sub_array;
            $sno = $sno + 1;
        }
    }
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM audit_assign";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data' => $data
);

echo json_encode($output);

// Close the database connection
$connect = null;
?>