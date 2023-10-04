<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
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

    $staffDetails = $con->query("SELECT `department` FROM `staff_creation` WHERE `staff_id` = '$sstaffid' ");
    if(mysqli_num_rows($staffDetails)>0){
        $staffinfo = $staffDetails->fetch_assoc();
        $user_dept_id = $staffinfo['department'];
    }
}

$column = array(

    'appreciation_depreciation_id',
    'review',
    'company_id',
    'department_id',
    'designation_id',
    'emp_id',
    'year_id',
    'month',
    'status'
);

$query = "SELECT * FROM appreciation_depreciation WHERE 1";
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

                OR appreciation_depreciation_id LIKE '%".$_POST['search']."%'
                OR review LIKE  '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR department_id LIKE  '%".$_POST['search']."%'
                OR designation_id LIKE  '%".$_POST['search']."%'
                OR emp_id LIKE  '%".$_POST['search']."%'
                OR year_id LIKE  '%".$_POST['search']."%'
                OR month LIKE  '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
}else{

    $query .=" and company_id= '".$company_id."' and ( department_id = '".$user_dept_id."' or emp_id = '".$sstaffid."') and status = '0' ";
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
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
        $res1 = $con->query($getname) ;
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

    // $year='';
    // $year_id = $row['year_id'];   
    // $qry4 = "SELECT year FROM year_creation WHERE year_id ='".strip_tags($year_id)."' and status = 0";
    // $res4 = $con->query($qry4);
    // while($row4 = $res4->fetch_assoc())
    // {
    //    $year = $row4["year"];        
    // }
    
    // if($row['review'] == 'midterm_review') { $review = 'Midterm Review'; } else if($row['review'] == 'final_review') { $review = 'Final Review'; }else{ $review = '';}

    // $sub_array[] = $review;
    $sub_array[] = $company_name;
    $sub_array[] = $department_name;
    $sub_array[] = $designation_name;
    $sub_array[] = $staff_name;
    // $sub_array[] = $year;
    $date = mktime(0, 0, 0, $row['month'], 1, date('Y'));

    // Format the date to display the month name
    // $monthName = date('F', $date);
    $sub_array[] = date('F', $date);
    
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['appreciation_depreciation_id'];
	
    if($sstaffid == 'Overall' || $role == '3'){
        $action="<a href='appreciation_depreciation&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
    <a href='appreciation_depreciation&del=$id' title='Delete details' class='delete_appreciation_depreciation'><span class='icon-trash-2'></span></a>";
    }else{
        $action="<a href='view_appreciation_depreciation&view=$id' title='View details'><span class='icon-eye'></span></a>";
    }


	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM appreciation_depreciation";
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