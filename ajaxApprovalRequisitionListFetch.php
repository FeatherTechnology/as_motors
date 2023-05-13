<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}
if(isset($_SESSION["staffid"])){
    $sstaffid = $_SESSION["staffid"];
}

$column = array(

    'approval_line_id',
    'company_id',
    'checker_approval',
    'reviewer_approval',
    'final_approval',
    'status'
);

$query = "SELECT * FROM approval_line WHERE 1";
if($sbranch_id == 'Overall'){
    $query .= '';
    if($_POST['search']!="");
    {
        if (isset($_POST['search'])) {

            if($_POST['search']=="Active")
            {
                $query .="and status=0 "; 
            }
            else if($_POST['search']=="Inactive")
            {
                $query .="and status=1 ";
            }

            else{	
                $query .= "
                OR approval_line_id LIKE  '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR checker_approval LIKE  '%".$_POST['search']."%'
                OR reviewer_approval LIKE  '%".$_POST['search']."%'
                OR final_approval LIKE  '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
}else{
    $query .=" and staff_id= '".$sstaffid."' ";
}

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
    $sub_array   = array();
    
    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $company_name='';
    $qry1 = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0"; 
    $res1 = $con->query($qry1);
    while($row1 = $res1->fetch_assoc())
    {
        $branch_name = $row1['branch_name'];
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row1['company_id']."' ";
        $res2 = $con->query($getname);
        while ($row2 = $res2->fetch_assoc()) {
            $company_name = $row2['company_name'];
        }
    }

    $doc_no='';
    $qry3 = "SELECT * FROM approval_requisition WHERE approval_line_id = '".$row['approval_line_id']."' AND status=0"; 
    $res3 = $con->query($qry3);
    while($row3 = $res3->fetch_assoc())
    {
        $doc_no = $row3['doc_no'];
    }
    
    // own departent status
    $checker_approval = $row['checker_approval'];
    $reviewer_approval = $row['reviewer_approval'];
    $final_approval = $row['final_approval'];

    if($checker_approval == 2 || $reviewer_approval == 2 || $final_approval == 2){
        $department_status = 'Rejected';
    } else if($checker_approval == 0 || $reviewer_approval == 0 || $final_approval == 0){
        $department_status = 'Pending';
    } else if($checker_approval == 1 && $reviewer_approval == 1 && $final_approval == 1){
        $department_status = 'Approved';
    }

    // parallel department status
    $agree_disagree=array();
    $qry4 = "SELECT * FROM approval_requisition_parallel_agree_disagree WHERE approval_line_id = '".$row['approval_line_id']."' AND status=0"; 
    $res4 = $con->query($qry4);
    while($row3 = $res4->fetch_assoc())
    {
        $agree_disagree[] = $row3['agree_disagree'];
    }

    if (in_array(2, $agree_disagree)) {
        $parallel_department_status[] = 'Rejected';
    } else if (in_array(0, $agree_disagree)) {
        $parallel_department_status[] =  'Pending';
    } else if (count(array_unique($agree_disagree)) === 1) {
        $parallel_department_status[] = 'Approved';
    }

    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $doc_no;
    $sub_array[] = $department_status;
    $sub_array[] = $parallel_department_status;

    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM approval_line";
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
?>