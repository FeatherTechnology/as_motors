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
    
    'bm_checklist_id',
    'company_id',
    'category_id',
    'checklist',
    'rating	',
    'status'
);

$query = "SELECT a.bm_checklist_id,a.category_id,b.id,b.checklist,b.rating,b.status,c.work_status FROM bm_checklist a left join bm_checklist_multiple b on a.bm_checklist_id = b.bm_checklist_id join bm_checklist_ref c on b.id = c.bm_checklist_id WHERE c.work_status != '3' ";
if($sbranch_id == 'Overall'){
    $query .= '';
    if($_POST['search']!="");
    {
        if (isset($_POST['search'])) {
            
            if($_POST['search']=="Active")
            {
                $query .=" and b.status=0 "; 
            }
            else if($_POST['search']=="Inactive")
            {
                $query .=" and b.status=1 ";
            }
            
            else{	
                
                $query .= "
                OR a.bm_checklist_id LIKE '%".$_POST['search']."%'
                OR a.company_id LIKE  '%".$_POST['search']."%'
                OR a.category_id LIKE '%".$_POST['search']."%'
                OR b.checklist LIKE '%".$_POST['search']."%'
                OR b.rating	 LIKE  '%".$_POST['search']."%'
                OR b.status LIKE '%".$_POST['search']."%' ";
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

    if($row['rating'] == 'High' && $row['work_status'] == 0){
        $sub_array   = array();
    
        if($sno!="")
        {
            $sub_array[] = $sno;
        }

        $category_creation_name='';
        $categoryId = $row['category_id'];   
        $getqry = "SELECT category_creation_name FROM category_creation WHERE category_creation_id ='".strip_tags($categoryId)."' and status = 0";
        $res13 = $con->query($getqry);
        while($row13 = $res13->fetch_assoc())
        {
        $category_creation_name = $row13["category_creation_name"];        
        }

        $sub_array[] = $category_creation_name;
        $sub_array[] = $row['checklist'];
        $sub_array[] = $row['rating'];
        $status      = $row['status'];
        if($status == 1)
        {
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
        }
        else
        {
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
        }
        $id   = $row['bm_checklist_id'];
        
        $action="<a href='bm_checklist&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
        <a href='bm_checklist&del=$id' title='Delete details' class='delete_bm_checklist'><span class='icon-trash-2'></span></a>";

        $sub_array[] = $action;
        $data[]      = $sub_array;
        $sno = $sno + 1;
    }
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM bm_checklist";
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