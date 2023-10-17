<?php
include('../ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}

$column = array(

    'memo_id',
    'company_id',
    'to_department',
    'assign_employee',
    'priority',
    'inquiry',
    'suggestion',
    'attachment',
    'completion_target_date',
    'initial_phase',
    'final_phase',
    'date_of_completion',
    'update_attachment',
    'narration',
    'status'
);

$query = "SELECT * FROM memo WHERE 1";
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
                OR company_id LIKE '%".$_POST['search']."%'
                OR to_department LIKE  '%".$_POST['search']."%'
                OR assign_employee LIKE  '%".$_POST['search']."%'
                OR priority LIKE '%".$_POST['search']."%'
                OR inquiry LIKE '%".$_POST['search']."%'
                OR suggestion LIKE '%".$_POST['search']."%'
                OR attachment LIKE '%".$_POST['search']."%'
                OR completion_target_date LIKE '%".$_POST['search']."%'
                OR initial_phase LIKE '%".$_POST['search']."%'
                OR final_phase LIKE '%".$_POST['search']."%'
                OR date_of_completion LIKE '%".$_POST['search']."%'
                OR update_attachment LIKE '%".$_POST['search']."%'
                OR narration LIKE '%".$_POST['search']."%'
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

     //get company Name
    $company_name='';
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    $res = $con->query($qry);
    while($row5 = $res->fetch_assoc())
    {
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
        $res1 = $con->query($getname);
        while ($row52 = $res1->fetch_assoc()) {
            $company_name = $row52['company_name'];
        }
    }

     //get from department name
    $fromDepartmentName=''; 
    $getqry2 = "SELECT * FROM department_creation WHERE department_id ='".strip_tags($row['from_department'])."' and status = 0";
    $res2 = $con->query($getqry2);
    while($row2 = $res2->fetch_assoc())
    {
        $fromDepartmentName = $row2["department_name"];          
    }

    //get to department name
    $toDepartmentName=''; 
    $getqry3 = "SELECT * FROM department_creation WHERE department_id ='".strip_tags($row['to_department'])."' and status = 0";
    $res3 = $con->query($getqry3);
    while($row3 = $res3->fetch_assoc())
    {
        $toDepartmentName = $row3["department_name"];          
    }

    //get staff name
    $staffName='';  
    $getqry4 = "SELECT * FROM staff_creation WHERE staff_id ='".strip_tags($row['assign_employee'])."' and status = 0";
    $res4 = $con->query($getqry4);
    while($row4 = $res4->fetch_assoc())
    {
        $staffName = $row4["staff_name"];        
    }

    //get initial phase
    $initialPhase='';  
    $getqry5 = "SELECT * FROM staff_creation WHERE staff_id ='".strip_tags($row['initial_phase'])."' and status = 0";
    $res5 = $con->query($getqry5);
    while($row5 = $res5->fetch_assoc())
    {
        $initialPhase = $row5["staff_name"];        
    }

     //get final phase
    $finalPhase='';  
    $getqry6 = "SELECT * FROM staff_creation WHERE staff_id ='".strip_tags($row['final_phase'])."' and status = 0";
    $res6 = $con->query($getqry6);
    while($row3 = $res6->fetch_assoc())
    {
        $finalPhase = $row3["staff_name"];        
    }

     // priority
    $priority_name='';
    $priority_id = $row['priority'];
    if($priority_id == "1"){$priority_name = "High";}
    if($priority_id == "2"){$priority_name = "Medium";}
    if($priority_id == "3"){$priority_name = "Low";}

    $sub_array[] = $company_name;
    $sub_array[] = $toDepartmentName;
    $sub_array[] = $staffName;
    $sub_array[] = $priority_name;
    $sub_array[] = $row['inquiry']; 
    $sub_array[] = $row['suggestion']; 
    $sub_array[] = "<a href='uploads/memo/".$row['attachment']."' download='".$row['attachment']."' title='Download File'>".$row['attachment']."</a>";  
    $sub_array[] = $row['completion_target_date'];  
    $sub_array[] = $initialPhase;
    $sub_array[] = $finalPhase; 
    $sub_array[] = $row['date_of_completion'];
    $sub_array[] = "<a href='uploads/memo_update/".$row['update_attachment']."' download='".$row['update_attachment']."' title='Download File'>".$row['update_attachment']."</a>";  
    $sub_array[] = $row['narration'];  
    
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['memo_id'];

    if( $row['date_of_completion'] == ''){
        $action="<a href='memo_update&upd=$id' title='Edit Details'><span class='icon-border_color'></span></a>&nbsp;&nbsp;";
    }
    elseif( $row['date_of_completion'] != ''){
        $action="<button type='button' title='Memo Assign' class='btn btn-success'><span class=''> Updated</span></button>";
    }

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM memo";
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