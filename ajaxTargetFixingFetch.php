<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["role"])){
    $role = $_SESSION["role"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    if($sbranch_id >0){
        $company = $con->query("SELECT company_id FROM branch_creation WHERE branch_id = '$sbranch_id' ");
        $companyDetails = $company->fetch_assoc();
        $company_id = $companyDetails['company_id'];
    }
}
if(isset($_SESSION["staffid"])){
    $sstaffid = $_SESSION["staffid"];
}

$column = array(

    'target_fixing_id',
    'company_id',
    'department_id',
    'designation_id',
    'emp_id',
    'year_id',
    'no_of_months',
    'status'
);

$query = "SELECT * FROM target_fixing WHERE 1";
if($role == '1' || $role == '3'){
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
                OR target_fixing_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR department_id LIKE  '%".$_POST['search']."%'
                OR designation_id LIKE  '%".$_POST['search']."%'
                OR emp_id LIKE  '%".$_POST['search']."%'
                OR year_id LIKE  '%".$_POST['search']."%'
                OR no_of_months LIKE  '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
}else{
  
   $query .=" and company_id= '".$company_id."' and emp_id = '".$sstaffid."' and status = '0' ";
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

    $sub_array = array();

    if($sno!="")
    {
        $sub_array[] = $sno;
    }

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

    $department_name='';
    $getDepartmentName = $row['department_id'];   
    $qry1 = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($getDepartmentName)."' and status = 0";
    $res1 = $con->query($qry1);
    while($row1 = $res1->fetch_assoc())
    {
    $department_name = $row1["department_name"];        
    }

    $designation_name='';
    $getDesignationName = $row['designation_id'];   
    $qry2 = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($getDesignationName)."' and status = 0";
    $res2 = $con->query($qry2);
    while($row2 = $res2->fetch_assoc())
    {
    $designation_name = $row2["designation_name"];        
    }

    $staff_name='';
    $emp_id = $row['emp_id'];   
    $qry3 = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($emp_id)."' and status = 0";
    $res3 = $con->query($qry3);
    while($row3 = $res3->fetch_assoc())
    {
    $staff_name = $row3["staff_name"];        
    }

    $year='';
    $year_id = $row['year_id'];   
    $qry4 = "SELECT year FROM year_creation WHERE year_id ='".strip_tags($year_id)."' and status = 0";
    $res4 = $con->query($qry4);
    while($row4 = $res4->fetch_assoc())
    {
    $year = $row4["year"];        
    }
    
    $sub_array[] = $company_name;
    $sub_array[] = $department_name;
    $sub_array[] = $designation_name;
    $sub_array[] = $staff_name;
    $sub_array[] = $year;
    $sub_array[] = $row['no_of_months'];
    
    $status      = $row['status'];
    if($status == 1)
    {
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
    }
    else
    {
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
    }
    $id   = $row['target_fixing_id'];
    
    if($sstaffid == 'Overall'){
        $action="<a href='target_fixing&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
        <a href='target_fixing&del=$id' title='Delete details' class='delete_target_fixing'><span class='icon-trash-2'></span></a>";
    }else{
        $action="<a href='view_target_fixing&view=$id' title='View details'><span class='icon-eye'></span></a>";
    }
   


    $sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;

}

function count_all_data($connect)
{
    $query     = "SELECT * FROM target_fixing";
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