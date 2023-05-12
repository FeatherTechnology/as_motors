<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}

$column = array(
    'promotional_activities_id',
    'project',
    'activity_involved',
    'time_frame_start',
    'duration',
    'status'
);

$query = "SELECT pa.promotional_activities_id,
GROUP_CONCAT(DISTINCT pa.project) AS project,
GROUP_CONCAT(DISTINCT par.activity_involved) AS activity_involved,
GROUP_CONCAT(DISTINCT par.time_frame_start) AS time_frame_start,
GROUP_CONCAT(DISTINCT par.duration) AS duration,
GROUP_CONCAT(DISTINCT pa.status) AS status
FROM promotional_activities pa
LEFT JOIN promotional_activities_ref par
ON par.promotional_activities_id = pa.promotional_activities_id
 WHERE 1";

// SELECT pa.promotional_activities_id, 
//        GROUP_CONCAT(pa.project) AS project,
//        GROUP_CONCAT(par.activity_involved) AS activity_involved,
//        GROUP_CONCAT(par.time_frame_start) AS time_frame_start,
//        GROUP_CONCAT(par.duration) AS duration,
//        GROUP_CONCAT(pa.status) AS status
// FROM promotional_activities pa
// LEFT JOIN promotional_activities_ref par
//     ON par.promotional_activities_id = pa.promotional_activities_id
// GROUP BY pa.promotional_activities_id;
// SELECT pa.promotional_activities_id,pa.project,par.activity_involved,par.time_frame_start,par.duration,pa.status FROM promotional_activities pa LEFT JOIN promotional_activities_ref par ON par.promotional_activities_id=pa.promotional_activities_id 
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
            
            OR pa.promotional_activities_id LIKE  '%".$_POST['search']."%'
            OR pa.project LIKE '%".$_POST['search']."%'
            OR par.activity_involved LIKE '%".$_POST['search']."%'
            OR par.time_frame_start LIKE '%".$_POST['search']."%'
            OR par.duration LIKE '%".$_POST['search']."%'
            OR pa.status LIKE '%".$_POST['search']."%'";
            // OR esi_number LIKE '%".$_POST['search']."%'
            // OR tan_number LIKE '%".$_POST['search']."%'
            // OR pf_number LIKE '%".$_POST['search']."%'
            // OR fax_number LIKE '%".$_POST['search']."%'
            // OR status LIKE '%".$_POST['search']."%' 
        }
    }
}

if (isset($_POST['order'])) {
    $query .= 'GROUP BY pa.promotional_activities_id ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
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
    // $sub_array[] = $row['promotional_activities_id'];                      
    $sub_array[] = $row['project'];
    $sub_array[] = $row['activity_involved'];
    $sub_array[] = $row['time_frame_start'];
    $sub_array[] = $row['duration'];
    $status    = $row['status'];
     // $sub_array[] = $row['esi_number'];
    // $sub_array[] = $row['tan_number'];
    // $sub_array[] = $row['pf_number'];  
    // $sub_array[] = $row['fax_number'];
    
   
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['promotional_activities_id'];
	
	$action="<a href='promotional_activities&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='promotional_activities&del=$id' title='Delete details' class='delete_promotional_activities'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
    
}

function count_all_data($connect)
{
    $query     = "SELECT pa.promotional_activities_id,
    GROUP_CONCAT(DISTINCT pa.project) AS project,
    GROUP_CONCAT(DISTINCT par.activity_involved) AS activity_involved,
    GROUP_CONCAT(DISTINCT par.time_frame_start) AS time_frame_start,
    GROUP_CONCAT(DISTINCT par.duration) AS duration,
    GROUP_CONCAT(DISTINCT pa.status) AS status
    FROM promotional_activities pa
    LEFT JOIN promotional_activities_ref par
    ON par.promotional_activities_id = pa.promotional_activities_id
    GROUP BY pa.promotional_activities_id";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}




$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data' => $data,
    // 'deptname' => $deptname
);


echo json_encode($output);
?>





