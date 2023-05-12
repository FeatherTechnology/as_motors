<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}

$column = array(

    'campaign_id',
    'promotional_activities_id',
    'actual_start_date',
    'status'
);

$query = "SELECT * FROM campaign WHERE 1";
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

            else {	
                $query .= "
                OR promotional_activities_id LIKE '%".$_POST['search']."%'
                OR actual_start_date LIKE  '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }

// }else{
//     $query .=" and company_id= '".$sbranch_id."' ";
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

    $sub_array = array();
    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $projectName='';  
    $getAuditorName = "SELECT project FROM promotional_activities WHERE promotional_activities_id ='".strip_tags($row['promotional_activities_id'])."' AND status = 0";
    $res12 = $con->query($getAuditorName);
    while($row12 = $res12->fetch_assoc())
    {
        $projectName = $row12["project"];        
    }

    $sub_array[] = $projectName;
    $sub_array[] = $row['actual_start_date'];

    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}

    $id   = $row['campaign_id'];
    $action="<a href='campaign&upd=$id' title='Edit details'><span class='icon-border_color'></span></a> &nbsp;&nbsp; 
	<a href='campaign&del=$id' title='Delete details' class='delete_campaign'><span class='icon-trash-2'></span></a> &nbsp;&nbsp;";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
    
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM campaign";
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