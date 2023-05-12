<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}

$column = array(

    'holiday_id',
    'calendar_year',
    'company_id',
    'status'
);

$query = "SELECT * FROM holiday_creation ";

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
            // $query .= "

            // OR holiday_id LIKE '%".$_POST['search']."%'
            // OR calendar_year LIKE  '%".$_POST['search']."%'
            // OR company_id LIKE  '%".$_POST['search']."%'
            // OR status LIKE '%".$_POST['search']."%' ";
        }
    }
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
    $holiday_date   = array();
    $holiday_description   = array();
    $company_name = array();  
    
    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $companyName1 = explode(",", $row['company_id']);
    foreach($companyName1 as $companyName) {
        $companyName = trim($companyName);
        $getqry1 = "SELECT company_name FROM company_creation WHERE company_id ='".strip_tags($companyName)."' and status = 0";
        $res13 = $con->query($getqry1);
        while($row13 = $res13->fetch_assoc())
        {
           $company_name[] = $row13["company_name"];      
        }
    }

    $holiday_date1="";
    $holiday_description1=""; 
    $getCompanyName1 = $row['holiday_id'];  
    $getqry = "SELECT holiday_date, holiday_description FROM holiday_creation_ref WHERE holiday_reff_id ='".strip_tags($getCompanyName1)."' and status = 0";
    $res12 = $con->query($getqry);
    
    while($row12 = $res12->fetch_assoc())
    {
       $holiday_date[] = $row12["holiday_date"]; 
       $holiday_description[] = $row12["holiday_description"];       
    }

    $holiday_date1 = implode(", ",$holiday_date); 
    $holiday_description1 = implode(", ",$holiday_description);

    
    $sub_array[] = $row['calendar_year'];
    $sub_array[] = $company_name;
    $sub_array[] = $holiday_date1;
    $sub_array[] = $holiday_description1;
    
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['holiday_id'];
	
	$action="<a href='holiday_creation&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='holiday_creation&del=$id' title='Delete details' class='delete_holiday_creation'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM holiday_creation";
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