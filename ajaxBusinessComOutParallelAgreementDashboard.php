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

    'business_com_line_id',
    'company_id',
    'created_date',
    'status'
);

$query = "SELECT * FROM business_com_line WHERE 1";
// if($sbranch_id == 'Overall'){
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
                OR business_com_line_id LIKE  '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR created_date LIKE  '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
// }else{
//     $query .=" and staff_id= '".$sstaffid."' ";
// }

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

    $final_approval  = $row['final_approval'];
    $agree_par_staff_id  = $row['agree_par_staff_id'];

    $parallel_staff_idArr = array_map('intval', explode(',', $agree_par_staff_id));
    $parallel_staff_idLength = sizeof($parallel_staff_idArr);
    
    $getParallelAgreementStaffId = "SELECT COUNT(agree_disagree) as agree_disagree FROM business_com_parallel_agree_disagree WHERE agree_disagree = '1' AND status=0 ";
    $res11 = $con->query($getParallelAgreementStaffId);
    if ($con->affected_rows>0)
    {
        $row11 = $res11->fetch_object();
        $agree_disagree  = $row11->agree_disagree;
    }

    // if($final_approval != 1 || $parallel_staff_idLength != $agree_disagree){
    if($parallel_staff_idLength != $agree_disagree){

        $company_name='';
        $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
        $res = $con->query($qry);
        while($row5 = $res->fetch_assoc())
        {
            $branch_name = $row5['branch_name'];
            $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
            $res1 = $con->query($getname);
            while ($row52 = $res1->fetch_assoc()) {
                $company_name = $row52['company_name'];
            }
        }

        $sub_array[] = $company_name;
        $sub_array[] = $branch_name;
        $sub_array[] = date('d-m-Y',strtotime($row['created_date']));   

        $id   = $row['business_com_line_id'];
        $action="<a href='business_com_out&dashupd=$id&parallel=$id' title='view details'><span class='btn btn-info'>View</span></a>";

        $sub_array[] = $action;
        $data[]      = $sub_array;
        $sno = $sno + 1;
    }
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM business_com_line";
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