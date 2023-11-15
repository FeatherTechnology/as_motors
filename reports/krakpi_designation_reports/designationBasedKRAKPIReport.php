<?php
include '../../ajaxconfig.php';
//krakpi.\\         ////designation based.
?>

<!-- Responsibility Table START -->
<div class="row">
    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <input type="button" name="page_print" id="page_print" class="btn btn-danger print-page " data-id="reponsibility_report_data" value="PRINT">
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <h5> Reponsibility Report </h5>
        </div>
    </div>
</div>
<table class="table custom-table" id="reponsibility_report_data">
    <thead>
        <tr>
            <th width="15%">S.No</th>
            <th>Emp Code</th>
            <th>Staff Name</th>
            <th>Responsibility</th>
        </tr>
    </thead>
    <tbody>

<?php
$designation_id = '0';
if(isset($_POST["designation_id"])){
    $designation_id = ($_POST["designation_id"]);
}

$res_emp_code = array();
$res_staff_name = array();
$res = array();

if($designation_id != '0'){

$resqry = "";
$resqry = "SELECT sc.emp_code, sc.staff_name, rc.responsibility_name FROM `basic_creation` bc 
LEFT JOIN staff_creation sc ON bc.designation IN (sc.designation) 
LEFT JOIN responsibility_creation rc ON FIND_IN_SET(rc.responsibility_id, bc.responsibility) 
WHERE FIND_IN_SET($designation_id, bc.designation)";

$resInfo = $connect->query($resqry);
if($resInfo -> rowCount() > 0){
    
while ($restask = $resInfo->fetch()) { 

    $res_emp_code[]['emp_code'] = $restask['emp_code'];
    $res_staff_name[]['staff_name'] = $restask['staff_name'];
    $res[]['responsibility_name'] = $restask['responsibility_name'];
    }
}

} else{
    $res_emp_code[]['emp_code'] = '';
    $res_staff_name[]['staff_name'] = '';
    $res[]['responsibility_name'] = '';
}

$a = 1;
for ($i=0; $i<count($res); $i++) { 
?>    
    <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $res_emp_code[$i]['emp_code']; ?></td>
        <td><?php echo $res_staff_name[$i]['staff_name']; ?></td>
        <td><?php echo $res[$i]['responsibility_name']; ?></td>
    </tr>
<?php }  ?>
    </tbody>
</table>
<!-- Responsibility Table END -->

<!-- Daily Task Table START -->
</br></br></br>
<div class="row">
    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <input type="button" name="page_print" id="page_print" class="btn btn-danger print-page " data-id="dailytask_report_data" value="PRINT">
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <h5> Daily Task Report </h5>
        </div>
    </div>
</div>
<table class="table custom-table" id="dailytask_report_data">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Emp Code</th>
            <th>Staff Name</th>
            <th>Frequency</th>
            <th>KRA Category</th>
            <th>R & R</th>
            <th>Date of Task</th>
            <th>Current Status</th>
            <th>Completed File</th>
        </tr>
    </thead>
    <tbody>

<?php
$dailyworkid = array();
$dailyemp_code = array();
$dailystaff_name = array();
$dailyfrequency = array();
$dailykra = array();
$dailyrr = array();
$dailyfrom_date = array();
$dailyto_date = array();
$dailyworksts = array();
$dailycompletedFile = array();

if($designation_id != '0'){
$dailytaskqry = "";
$dailytaskqry = "SELECT 'KRA & KPI' as work_id, sc.emp_code, sc.staff_name, kcr.frequency, kra.kra_category, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as RR,  DATE(kcm.from_date) as f_date, DATE(kcm.to_date) as t_date, kcm.krakpi_calendar_map_id as id, kcm.work_status as sts
FROM krakpi_calendar_map kcm 
LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id 
LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id 
LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id 
LEFT JOIN kra_creation_ref kra ON kcr.kra_category = kra.kra_creation_ref_id
LEFT JOIN staff_creation sc ON kc.designation = sc.designation
WHERE kc.designation = '$designation_id' && kc.status = 0 && kcr.frequency = 'Daily Task'  ";

$dailytaskInfo = $connect->query($dailytaskqry);
if($dailytaskInfo -> rowCount() > 0){
    
while ($dailytask = $dailytaskInfo->fetch()) { 

    $dailykrakpi_id = 'krakpi_ref '.$dailytask['id'];
    $dailykrakpimapdetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$dailykrakpi_id."' ");
    if(mysqli_num_rows($dailykrakpimapdetails)>0){ //checks if the row > 0 then show completed_file else empty.
    $dailykrakpimap = $dailykrakpimapdetails->fetch_assoc();  
        $dailykrakpicompletedfile = $dailykrakpimap["completed_file"];
    }else{
        $dailykrakpicompletedfile = '';
    }

    $dailyworkid[]['work_id'] = $dailytask['work_id'];
    $dailyemp_code[]['emp_code'] = $dailytask['emp_code'];
    $dailystaff_name[]['staff_name'] = $dailytask['staff_name'];
    $dailyfrequency[]['frequency'] = $dailytask['frequency'];
    $dailykra[]['kra_category'] = $dailytask['kra_category'];
    $dailyrr[]['RR'] = $dailytask['RR'];
    $dailyfrom_date[]['from_date'] = $dailytask['f_date'];
    $dailyto_date[]['to_date'] = $dailytask['t_date'];
    $dailyworksts[]['sts'] = $dailytask['sts'];
    $dailycompletedFile[]['com_file'] = $dailykrakpicompletedfile;
    }
}

} else{
    $dailyworkid[]['work_id'] = '';
    $dailyemp_code[]['emp_code'] = '';
    $dailystaff_name[]['staff_name'] = '';
    $dailyfrequency[]['frequency'] = '';
    $dailykra[]['kra_category'] = '';
    $dailyrr[]['RR'] = '';
    $dailyfrom_date[]['from_date'] = '';
    $dailyto_date[]['to_date'] = '';
    $dailyworksts[]['sts'] = '';
    $dailycompletedFile[]['com_file'] = '';
}

$a = 1;
for ($i=0; $i<count($dailykra); $i++) { 
    if($dailyworksts[$i]['sts'] == '0'){ $sts = 'Work Assigned';}
    if($dailyworksts[$i]['sts'] == '1'){ $sts = 'In-Progress';}
    if($dailyworksts[$i]['sts'] == '2'){ $sts = 'Pending';}
    if($dailyworksts[$i]['sts'] == '3'){ $sts = 'Completed';}

    if($dailycompletedFile[$i]['com_file'] != ''){ //if com_file is empty then '-' will show.
        $comFile = $dailycompletedFile[$i]['com_file'];
    }else{
        $comFile ='-';
    }
?>    
    <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $dailyemp_code[$i]['emp_code']; ?></td>
        <td><?php echo $dailystaff_name[$i]['staff_name']; ?></td>
        <td><?php echo $dailyfrequency[$i]['frequency']; ?></td>
        <td><?php echo $dailykra[$i]['kra_category']; ?></td>
        <td><?php echo $dailyrr[$i]['RR']; ?></td>
        <td><?php echo $dailyfrom_date[$i]['from_date']; ?></td>
        <td><?php echo $sts; ?></td>
        <td> <a href="uploads\completedTaskFile\<?php echo $comFile; ?>" target="_blank"> <?php echo $comFile; ?> </a> </td>
    </tr>
<?php }  ?>
    </tbody>
</table>
<!-- Daily Task Table END -->

<!-- calendar Task (KRAKPI, TODO) Table START -->
</br></br></br>
<div class="row">
    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <input type="button" name="page_print" id="page_print" class="btn btn-danger print-page " data-id="calendartask_report_data" value="PRINT">
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <h5> KRAKPI & TODO Report </h5>
        </div>
    </div>
</div>
<table class="table custom-table" id="calendartask_report_data">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Emp Code</th>
            <th>Staff Name</th>
            <th>Task Name</th>
            <th>Frequency</th>
            <th>KRA Category</th>
            <th>R & R</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Current Status</th>
            <th>Completed File</th>
        </tr>
    </thead>
    <tbody>

<?php
$workid = array();
$emp_code = array();
$staff_name = array();
$frequency = array();
$kra = array();
$rr = array();
$from_date = array();
$to_date = array();
$worksts = array();
$completedFile = array();

if($designation_id != '0'){//KRAKPI 
//KRAKPI start//
$qry = "";
$qry = "SELECT 'KRA & KPI' as work_id, sc.emp_code, sc.staff_name, kcr.frequency, kra.kra_category, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as RR,  DATE(kcm.from_date) as f_date, DATE(kcm.to_date) as t_date, kcm.krakpi_calendar_map_id as id, kcm.work_status as sts
FROM krakpi_calendar_map kcm 
LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id 
LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id 
LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id 
LEFT JOIN kra_creation_ref kra ON kcr.kra_category = kra.kra_creation_ref_id
LEFT JOIN staff_creation sc ON kc.designation = sc.designation
WHERE kc.designation = '$designation_id' && kc.status = 0 && kcr.frequency != 'Daily Task' ";

$krakpiInfo = $connect->query($qry);
if($krakpiInfo -> rowCount() > 0){
    
while ($krakpitask = $krakpiInfo->fetch()) { 

    $krakpi_id = 'krakpi_ref '.$krakpitask['id'];
    $krakpimapdetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$krakpi_id."' ");
    if(mysqli_num_rows($krakpimapdetails)>0){ //checks if the row > 0 then show completed_file else empty.
    $krakpimap = $krakpimapdetails->fetch_assoc();  
        $krakpi_completed_file = $krakpimap["completed_file"];
    }else{
        $krakpi_completed_file = '';
    }

    $workid[]['work_id'] = $krakpitask['work_id'];
    $emp_code[]['emp_code'] = $krakpitask['emp_code'];
    $staff_name[]['staff_name'] = $krakpitask['staff_name'];
    $frequency[]['frequency'] = $krakpitask['frequency'];
    $kra[]['kra_category'] = $krakpitask['kra_category'];
    $rr[]['RR'] = $krakpitask['RR'];
    $from_date[]['from_date'] = $krakpitask['f_date'];
    $to_date[]['to_date'] = $krakpitask['t_date'];
    $worksts[]['sts'] = $krakpitask['sts'];
    $completedFile[]['com_file'] = $krakpi_completed_file;
    }
}
//KRAKPI END//

//Todo Start //
$todoqry = "SELECT 'TODO ' as work_id, tc.todo_id as id, tc.work_status as sts, tc.work_des as RR, DATE(tc.from_date) as f_date, DATE(tc.to_date) as t_date, sc.staff_name, sc.emp_code
FROM todo_creation tc 
LEFT JOIN staff_creation sc ON FIND_IN_SET(sc.staff_id, tc.assign_to)
WHERE sc.designation = '$designation_id' &&  tc.status = 0 ";

$gettodoinfo = $con->query($todoqry);
if(mysqli_num_rows($gettodoinfo) > 0){
while($todoinfo = $gettodoinfo->fetch_assoc())
{
    $todo_id = 'todo '.$todoinfo['id'];
    $tododetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$todo_id."' ");
    if(mysqli_num_rows($tododetails)>0){
    $todoinf = $tododetails->fetch_assoc();   
        $todo_completed_file = $todoinf["completed_file"];
    }else{
        $todo_completed_file = '';
    }

    $workid[]['work_id'] = $todoinfo['work_id'];
    $emp_code[]['emp_code'] = $todoinfo['emp_code'];
    $staff_name[]['staff_name'] = $todoinfo['staff_name'];
    $frequency[]['frequency'] = '-';
    $kra[]['kra_category'] = '-';
    $rr[]['RR'] = $todoinfo['RR'];
    $from_date[]['from_date'] = $todoinfo['f_date'];
    $to_date[]['to_date'] = $todoinfo['t_date'];
    $worksts[]['sts'] = $todoinfo['sts'];
    $completedFile[]['com_file'] = $todo_completed_file;
}
}
//ToDo END //

} else{
    $workid[]['work_id'] = '';
    $emp_code[]['emp_code'] = '';
    $staff_name[]['staff_name'] = '';
    $frequency[]['frequency'] = '';
    $kra[]['kra_category'] = '';
    $rr[]['RR'] = '';
    $from_date[]['from_date'] = '';
    $to_date[]['to_date'] = '';
    $worksts[]['sts'] = '';
    $completedFile[]['com_file'] = '';
}

$a = 1;
for ($i=0; $i<count($kra); $i++) { 
    if($worksts[$i]['sts'] == '0'){ $sts = 'Work Assigned';}
    if($worksts[$i]['sts'] == '1'){ $sts = 'In-Progress';}
    if($worksts[$i]['sts'] == '2'){ $sts = 'Pending';}
    if($worksts[$i]['sts'] == '3'){ $sts = 'Completed';}

    if($completedFile[$i]['com_file'] != ''){ //if com_file is empty then '-' will show.
        $comFile = $completedFile[$i]['com_file'];
    }else{
        $comFile ='-';
    }
?>    
    <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $emp_code[$i]['emp_code']; ?></td>
        <td><?php echo $staff_name[$i]['staff_name']; ?></td>
        <td><?php echo $workid[$i]['work_id']; ?></td>
        <td><?php echo $frequency[$i]['frequency']; ?></td>
        <td><?php echo $kra[$i]['kra_category']; ?></td>
        <td><?php echo $rr[$i]['RR']; ?></td>
        <td><?php echo $from_date[$i]['from_date']; ?></td>
        <td><?php echo $to_date[$i]['to_date']; ?></td>
        <td><?php echo $sts; ?></td>
        <td> <a href="uploads\completedTaskFile\<?php echo $comFile; ?>" target="_blank"> <?php echo $comFile; ?> </a> </td>
    </tr>
<?php }  ?>
    </tbody>
</table>
<!-- Calendar Task (KRAKPI, TODO) Table END -->

<script type="text/javascript">
    $(function() {
        $('#reponsibility_report_data').DataTable({
            'processing': true,
            'iDisplayLength': 20,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3 ]
                    }
                }
            ],
        });

        $('#dailytask_report_data').DataTable({
            'processing': true,
            'iDisplayLength': 20,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    }
                }
            ],
        });

        $('#calendartask_report_data').DataTable({
            'processing': true,
            'iDisplayLength': 20,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
                    }
                }
            ],
        });

    });

    $('.print-page').click(function (e){
        e.preventDefault();

        const tableId = $(this).data('id');
        const table = document.getElementById(tableId);

        if (table) {

            if(tableId == 'reponsibility_report_data'){
                title = 'Responsibility Report';

            }else if(tableId == 'dailytask_report_data'){
                title = 'Daily Task Report';
                
            }else if(tableId == 'calendartask_report_data'){
                title = 'KRAKPI & TODO Report';
                
            }else{
                title = 'Report';

            }
            // Clone the table to avoid modifying the original table
            const tableClone = table.cloneNode(true);
        
            // Create a new window to print the modified table
            const newWindow = window.open('', '_blank');
            newWindow.document.write('<html><head><title>Print Table</title></head><body>');
            newWindow.document.write('<h4> '+ title + '</h4>');
            newWindow.document.write('<style>table { border-collapse: collapse; } td, th { border: 1px solid black; padding: 8px; }</style>');
            newWindow.document.write(tableClone.outerHTML);
            newWindow.document.write('</body></html>');
            newWindow.document.close();
        
            // Wait for a small delay to allow the table to be rendered in the new window
            setTimeout(function() {
            newWindow.print();
            newWindow.close();
            }, 1000); // Adjust the delay time as needed
        } else {
            console.error('Table not found.');
        }
    }); //Print END///

</script>