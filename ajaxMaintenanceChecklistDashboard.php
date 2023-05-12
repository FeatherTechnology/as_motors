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
    
    'maintenance_checklist_id',
    'company_id',
    'date_of_inspection',
    'ins_person',
    'asset_details',
    'checklist',
    'responder',
    'status'
);

$query = "SELECT * FROM maintenance_checklist WHERE 1";
// if($sbranch_id == 'Overall'){
    $query .= '';
    if($_POST['search']!="");
    {
        if (isset($_POST['search'])) {
            
            if($_POST['search']=="Active")
            {
                $query .=" and status=0 "; 
            }
            else if($_POST['search']=="Inactive")
            {
                $query .=" and status=1 ";
            }
            
            else{	
                
                $query .= "
                OR maintenance_checklist_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE '%".$_POST['search']."%'
                OR date_of_inspection LIKE '%".$_POST['search']."%'
                OR ins_person LIKE '%".$_POST['search']."%'
                OR asset_details LIKE '%".$_POST['search']."%'
                OR checklist LIKE '%".$_POST['search']."%'
                OR responder LIKE '%".$_POST['search']."%'
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
    $maintenance_checklist_idCheck   = '';
  
    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $maintenance_checklist_id  = $row['maintenance_checklist_id'];
    $getResponderStatus = "SELECT * FROM maintenance_checklist_ref WHERE maintenance_checklist_id = '".strip_tags($maintenance_checklist_id)."' AND responder_status_ref=0";
    $res111 = $con->query($getResponderStatus) or die("Error in Get All Records".$con->error);
    if ($con->affected_rows>0)
    {
        while ($row111 = $res111->fetch_assoc()) {
            $maintenance_checklist_ref_id  = $row111['maintenance_checklist_ref_id'];
            $maintenance_checklist_idCheck  = $row111['maintenance_checklist_id'];
        }
    }
    
    if($maintenance_checklist_idCheck == $row['maintenance_checklist_id']){
        $branch_name='';
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
        
        $ins_person='';
        $insPerson = $row['ins_person'];   
        $getqry6 = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($insPerson)."' and status = 0";
        $res6 = $con->query($getqry6);
        while($row6 = $res6->fetch_assoc())
        {
        $ins_person = $row6["staff_name"];        
        }

        $asset_name='';
        $assetDetails = $row['asset_details'];   
        $getqry7 = "SELECT asset_name FROM asset_register WHERE asset_id ='".strip_tags($assetDetails)."' and status = 0";
        $res7 = $con->query($getqry7);
        while($row7 = $res7->fetch_assoc())
        {
        $asset_name = $row7["asset_name"];        
        }

        $responder_name='';
        $responder = $row['responder'];   
        $getqry6 = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($responder)."' and status = 0";
        $res6 = $con->query($getqry6);
        while($row6 = $res6->fetch_assoc())
        {
        $responder_name = $row6["staff_name"];        
        }
        
        if($row['checklist'] == "pm_checklist"){$checklist = "PM Checklist";}
        if($row['checklist'] == "bm_checklist"){$checklist = "BM Checklist";}
        
        // $sub_array[] = $company_name;
        // $sub_array[] = $branch_name;
        $sub_array[] = $row['date_of_inspection'];
        $sub_array[] = $ins_person;
        $sub_array[] = $asset_name;
        $sub_array[] = $checklist;
        $sub_array[] = $responder_name;
        // $status      = $row['status'];
        // if($status == 1)
        // {
        // $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
        // }
        // else
        // {
        // $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
        // }
        $id   = $row['maintenance_checklist_id'];
        
        $action="<a href='maintenance_checklist&dashupd=$id' title='view details'><span class='btn btn-info'>View</span></a>";

        $sub_array[] = $action;
        $data[]      = $sub_array;
        $sno = $sno + 1;
    }
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM maintenance_checklist";
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