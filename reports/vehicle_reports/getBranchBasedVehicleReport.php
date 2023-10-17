<?php
include '../../ajaxconfig.php';

if(isset($_POST['branch_id'])){
    $branch_id = $_POST['branch_id'];
}
?>

<table class="table custom-table" id="vehicle_report_data">
    <thead>
    <tr>
        <th>S. No.</th>
        <th>Company Name</th>
        <th>Branch Name</th>
        <th>Vehicle Code</th>
        <th>Vehicle Type</th>
        <th>Vehicle Name</th>
        <th>Vehicle Number</th>
        <th>Date Of Purchase</th>
        <th>Fitment Upto</th>
        <th>Insurance Upto</th>
        <th>Asset Value</th>
        <th>Book Value As On</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>

<?php

//Vehicle Details Start //
$vehicle_details = $mysqli->query("SELECT cc.company_name, bc.branch_name, vd.* FROM `vehicle_details` vd LEFT JOIN branch_creation bc ON vd.company_id = bc.branch_id LEFT JOIN company_creation cc ON bc.company_id = cc.company_id where vd.company_id = '$branch_id' ");
$sno = 1;
while($row = $vehicle_details->fetch_object()) {
    $vehicle_type = $row->vehicle_type;
    if($vehicle_type == '1'){
        $v_type = 'Own Vehicle';
    }elseif($vehicle_type == '2'){
        $v_type = 'Rental Vehicle';
    }else{
        $v_type = '';
    }

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
        <td><?php echo $row->vehicle_code; ?></td>
        <td><?php echo $v_type; ?></td>
        <td><?php echo $row->vehicle_name; ?></td>
        <td><?php echo $row->vehicle_number; ?></td>
        <td><?php if($row->date_of_purchase != ''){ echo date('d-m-Y',strtotime($row->date_of_purchase)); } ?></td>
        <td><?php if($row->fitment_upto != ''){ echo date('d-m-Y',strtotime($row->fitment_upto)); } ?></td>
        <td><?php if($row->insurance_upto != ''){ echo date('d-m-Y',strtotime($row->insurance_upto)); } ?></td>
        <td><?php echo $row->asset_value; ?></td>
        <td><?php echo $row->book_value_as_on; ?></td>
        <td><?php echo $sts; ?></td>
    </tr>

<?php } ?>    

    </tbody>
</table>

<script type="text/javascript">
    $(function() {
        $('#vehicle_report_data').DataTable({
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
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
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