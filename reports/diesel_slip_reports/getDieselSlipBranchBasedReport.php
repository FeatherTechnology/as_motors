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
        <th>Vehicle Number</th>
        <th>Previous KM</th>
        <th>Previous KM Date</th>
        <th>Present KM</th>
        <th>Present KM Date</th>
        <th>Total KM</th>
        <th>Diesel Litre</th>
        <th>Staff Name</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>

<?php

//Vehicle Details Start //
$vehicle_details = $mysqli->query("SELECT cc.company_name, bc.branch_name, sc.staff_name, vd.vehicle_number as vnum, ds.* FROM `diesel_slip` ds LEFT JOIN vehicle_details vd ON ds.vehicle_number = vd.vehicle_details_id LEFT JOIN branch_creation bc ON ds.company_id = bc.branch_id LEFT JOIN company_creation cc ON bc.company_id = cc.company_id LEFT JOIN staff_creation sc ON ds.staff_id = sc.staff_id WHERE ds.company_id = '$branch_id' && ( DATE(ds.present_km_date) BETWEEN DATE('".$from_date."') and DATE('".$to_date."') ) order by ds.diesel_slip_id DESC ");
$sno = 1;
while($row = $vehicle_details->fetch_object()) {
    $status      = $row->status;
    if($status == 1)
	{
	$sts = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sts = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
?>
    <tr>
        <td><?php echo $sno++; ?></td>
        <td><?php echo $row->company_name; ?></td>
        <td><?php echo $row->branch_name; ?></td>
        <td><?php echo $row->vnum; ?></td>
        <td><?php echo $row->previous_km; ?></td>
        <td><?php if($row->previous_km_date != ''){ echo date('d-m-Y',strtotime($row->previous_km_date)); } ?></td>
        <td><?php echo $row->present_km; ?></td>
        <td><?php if($row->present_km_date != ''){ echo date('d-m-Y',strtotime($row->present_km_date)); } ?></td>
        <td><?php echo $row->total_km_run; ?></td>
        <td><?php echo $row->diesel_amount; ?></td>
        <td><?php echo $row->staff_name; ?></td>
        <td><?php echo $sts; ?></td>
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
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11 ]
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