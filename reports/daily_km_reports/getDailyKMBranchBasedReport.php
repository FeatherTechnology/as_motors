<?php
include '../../ajaxconfig.php';

if(isset($_POST['branch_id'])){
    $branch_id = $_POST['branch_id'];
}
if(isset($_POST['from_date'])){
    $from_date = date('Y-m-d',strtotime($_POST["from_date"]));
}
if(isset($_POST['to_date'])){
    $to_date = date('Y-m-d',strtotime($_POST["to_date"]));
}
?>

<table class="table custom-table" id="dailyKM_report_data">
    <thead>
    <tr>
        <th>S. No.</th>
        <th>Company Name</th>
        <th>Branch Name</th>
        <th>Date</th>
        <th>Vehicle Number</th>
        <th>Start KM</th>
        <th>END KM</th>
        <th>Employee Name</th>
    </tr>
    </thead>
    <tbody>

<?php

//Vehicle Details Start //
$vehicle_details = $mysqli->query("SELECT cc.company_name, bc.branch_name, sc.staff_name, dkm.daily_km_id, dkm.date, dkm.status, dkr.* FROM `daily_km` dkm LEFT JOIN daily_km_ref dkr ON dkm.daily_km_id = dkr.daily_km_id LEFT JOIN branch_creation bc ON dkm.company_id = bc.branch_id LEFT JOIN company_creation cc ON bc.company_id = cc.company_id LEFT JOIN staff_creation sc ON dkr.employee_name = sc.staff_id where dkm.company_id = '$branch_id' && ( DATE(dkm.date) BETWEEN DATE('".$from_date."') and DATE('".$to_date."') ) ORDER BY dkr.vehicle_number DESC");
$sno = 1;
while($row = $vehicle_details->fetch_object()) {
?>
    <tr>
        <td><?php echo $sno++; ?></td>
        <td><?php echo $row->company_name; ?></td>
        <td><?php echo $row->branch_name; ?></td>
        <td><?php echo date('d-m-Y',strtotime($row->date)); ?></td>
        <td><?php echo $row->vehicle_number; ?></td>
        <td><?php echo $row->start_km; ?></td>
        <td><?php echo $row->end_km; ?></td>
        <td><?php echo $row->staff_name; ?></td>
    </tr>

<?php } ?>    

    </tbody>
</table>

<script type="text/javascript">
    $(function() {
        $('#dailyKM_report_data').DataTable({
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
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7 ]
                    }
                }
            ],
            // "createdRow": function(row, data, dataIndex) {
            //     $(row).find('td:first').html(dataIndex + 1);
            // },
            // "drawCallback": function(settings) {
            //     this.api().column(0).nodes().each(function(cell, i) {
            //         cell.innerHTML = i + 1;
            //     });
            // },
        });
    });
</script>