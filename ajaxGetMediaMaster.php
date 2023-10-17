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
    'media_id',
    'company_id',
    'media_name',
    'from_period',
    'to_period',
    'platform',
    'media_file',
    'status'
);

$query = "SELECT * FROM media_creation WHERE 1";
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
                OR media_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE '%".$_POST['search']."%'
                OR media_name LIKE '%".$_POST['search']."%'
                OR from_period LIKE '%".$_POST['search']."%'
                OR to_period LIKE '%".$_POST['search']."%'
                OR platform LIKE '%".$_POST['search']."%'
                OR media_file LIKE '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
}else{
    $query .=" and company_id= '".$sbranch_id."' ";
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
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    $res = $con->query($qry);
    while($row5 = $res->fetch_assoc())
    {
        $branch_name = $row5['branch_name'];
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
        $res1 = $con->query($getname) ;
        while ($row52 = $res1->fetch_assoc()) {
            $company_name = $row52['company_name'];
        }
    }
    
    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $row['media_name'];
    // $sub_array[] = $row['media_file'];
    $sub_array[] = "<a href='uploads/media_master/".$row['media_file']."' download='".$row['media_file']."' title='Download File'>".$row['media_file']."</a> ";
    $sub_array[] = $row['from_period'];
    $sub_array[] = $row['to_period'];

    if($row['platform'] == '1'){
        $platform_name = 'Facebook';
    }
    else if($row['platform'] == '2'){
        $platform_name = 'WhatsApp';
    }
    else if($row['platform'] == '3'){
        $platform_name = 'Instagram';
    }
    else if($row['platform'] == '4'){
        $platform_name = 'Twitter';
    }
    else if($row['platform'] == '5'){
        $platform_name = 'YouTube';
    }
    else if($row['platform'] == '6'){
        $platform_name = 'Telegram';
    }
    else if($row['platform'] == '7'){
        $platform_name = 'Tv ads';
    }else{
        $platform_name = '';
    }
    $sub_array[] = $platform_name;

    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['media_id'];
	
	$action="<a href='media_master&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='media_master&del=$id' title='Delete details' class='delete_audit_creation'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM media_creation";
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