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
    'ins_reg_id ',
    'company_id',
    'insurance_id',
    'dept_id',
    'freq_id',
    'status'
);

$query = "SELECT * FROM insurance_register WHERE 1";
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
                OR ins_reg_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE '%".$_POST['search']."%'
                OR insurance_id LIKE '%".$_POST['search']."%'
                OR dept_id LIKE '%".$_POST['search']."%'
                OR freq_id LIKE '%".$_POST['search']."%'
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

    $insurance_name = '';
    $getInsName = $row['insurance_id'];
    $getqry2 = "SELECT insurance_name FROM insurance_creation WHERE insurance_id   ='".strip_tags($getInsName)."' and status = 0";
    $res2 = $con->query($getqry2);
    while($row2 = $res2->fetch_assoc())
    {
       $insurance_name = $row2["insurance_name"];        
    }

    $sub_array[] = $insurance_name;

    $dept_name = '';
    $getDeptName = $row['dept_id'];
    $getqry3 = "SELECT department_name FROM department_creation WHERE department_id  ='".strip_tags($getDeptName)."' and status = 0";
    $res3 = $con->query($getqry3);
    while($row3 = $res3->fetch_assoc())
    {
       $dept_name = $row3["department_name"];        
    }

    $sub_array[] = $dept_name;

    $freq_name ='';
    $freq_id = $row['freq_id'];
    if($freq_id == '1'){$freq_name ="Half Yearly";}
    if($freq_id == '2'){$freq_name ="Yearly";}

    $sub_array[] = $freq_name;

    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['ins_reg_id'];
	
	$action="<a href='insurance_register&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='insurance_register&del=$id' title='Delete details' class='delete_insurance_register'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM insurance_register";
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