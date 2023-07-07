<?php
// include('ajaxconfig.php');
// @session_start();

// if(isset($_SESSION["userid"])){
//     $userid = $_SESSION["userid"];
// }
// if (isset($_POST['icompany'])) {
//     $icompany = $_POST["icompany"];
// }
// // print_r($icompany);
// $column = array(
//     // 'year_id',
//     'year',
//     'status'
// );
// $query = "SELECT y.year_id,y.year,y.status FROM year_creation y WHERE company_id='$icompany'";

// if($_POST['search']!="");
// {
//     if (isset($_POST['search'])) {

//         if($_POST['search']=="Active")
//         {
//             $query .="and y.status=0 "; 
//         }
//         else if($_POST['search']=="Inactive")
//         {
//             $query .="and y.status=1 ";
//         }

//         else{	
//             $query .= "
            
           
//             AND y.year LIKE '%".$_POST['search']."%'";
           
//         }
//     }
// }

// if (isset($_POST['order'])) {
//     $query .= ' ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
// } else {
//     $query .= ' ';
// }
// // print_r($query);
// $query1 = '';

// if ($_POST['length'] != -1) {
//     $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
// }

// $statement = $connect->prepare($query);
// $statement->execute();
// $number_filter_row = $statement->rowCount();
// $statement = $connect->prepare($query . $query1);
// $statement->execute();
// $result = $statement->fetchAll();
// $data = array();
// // print_r($data);
// $sno = 1;
// foreach ($result as $row) {
//     $sub_array   = array();
    
//     if($sno!="")
//     {
//         $sub_array[] = $sno;
//     }
                        
//     // $sub_array[] = $row['year_id'];
//     $sub_array[] = $row['year'];
//     $status    = $row['status'];
    
    
   
//     if($status == 1)
// 	{
// 	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
// 	}
// 	else
// 	{
//     $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
// 	}
// 	$id   = $row['year_id'];
	
// 	$action="<a  class='edpage' title='Edit details'><span class='icon-border_color idval' id='idval'><span class='idval' id='idval' style='display:none;'>$id</span></span></a>&nbsp;&nbsp; 
// 	<a  title='Delete details' class='delete_year_setting'><span class='icon-trash-2 idval' id='idval'><span class='idval' id='idval' style='display:none;'>$id</span></span></a>";

// 	$sub_array[] = $action;
//     $data[]      = $sub_array;
//     $sno = $sno + 1;
  
// }

// function count_all_data($connect)
// {
//     if (isset($_POST['icompany'])) {
//         $icompany = $_POST["icompany"];
//     }
//     $query     = "SELECT y.year_id,y.year FROM year_creation y WHERE y.company_id='$icompany' AND y.status='0'";
//     $statement = $connect->prepare($query);
//     $statement->execute();
//     return $statement->rowCount();
// }




// $output = array(
//     'draw' => intval($_POST['draw']),
//     'recordsTotal' => count_all_data($connect),
//     'recordsFiltered' => $number_filter_row,
//     'data' => $data
//     // 'deptname' => $deptname
// );


// echo json_encode($output);
?>




<?php
include 'ajaxconfig.php';
?>

<table class="table custom-table" id="year_infoDashboard">
    <thead>
    <tr>
        <th width="25%">S. No</th>
        <th>Year</th>
        <th>status</th>
        <th>ACTION</th>
    </tr>
    </thead>
    <tbody>

        <?php
        if (isset($_POST['icompany'])) {
            $icompany = $_POST["icompany"];
        }
        $yearCreation = $connect->query("SELECT y.year_id,y.year,y.status FROM year_creation y WHERE y.company_id='$icompany' ");
        //Status = 0 - Acitve,
        //Status = 1 - In-Active.
        $i = 1;
        while ($year = $yearCreation->fetch()) {
        ?>

            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $year["year"]; ?></td>
                <td><?php echo ($year["status"] =='0') ?  'Active' : 'In-Active'; ?></td>
                <td>
                    <a id="edpage" value="<?php echo $year['year_id']; ?>"> <span class="icon-border_color"></span></a> &nbsp
                    <a id="delete_year_setting" value="<?php echo $year['year_id']; ?>"> <span class='icon-trash-2'></span> </a>
                </td>
            </tr>

        <?php $i = $i + 1;
        }     ?>
    </tbody>
</table>


<script type="text/javascript">
    $(function() {
        $('#year_infoDashboard').DataTable({
            'processing': true,
            'iDisplayLength': 5,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "createdRow": function(row, data, dataIndex) {
                $(row).find('td:first').html(dataIndex + 1);
            },
            "drawCallback": function(settings) {
                this.api().column(0).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            },
        });
    });
</script>
