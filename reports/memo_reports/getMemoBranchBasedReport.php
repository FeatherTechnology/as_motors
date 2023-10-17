<?php
include '../../ajaxconfig.php';

if(isset($_POST['branch_id'])){
    $branch_id = $_POST['branch_id'];
}
// if(isset($_POST['from_date'])){
//     $from_date = date('Y-m-d',strtotime($_POST["from_date"]));
// }
// if(isset($_POST['to_date'])){
//     $to_date = date('Y-m-d',strtotime($_POST["to_date"]));
// }
?>

<table class="table custom-table" id="dailyKM_report_data">
    <thead>
    <tr>
        <th>S. No.</th>
        <th>Company Name</th>
        <th>Branch Name</th>
        <th>To Department</th>
        <th>Assign Employee</th>
        <th>Priority</th>
        <th>Inquiry</th>
        <th>Suggestion</th>
        <th>Attachment</th>
        <th>Target Date For Completion</th>
        <th>Initial Phase</th>
        <th>Final Phase</th>
        <th>Date Of Completion</th>
        <th>Update Attachment</th>
        <th>Narration</th>
    </tr>
    </thead>
    <tbody>

<?php

//Memo Details Start //
$vehicle_details = $mysqli->query("SELECT cc.company_name, bc.branch_name, sc.staff_name as assignEmp, dc.department_name as todeptName, sci.staff_name as initialPhase, scf.staff_name as finalPhase, m.* FROM `memo` m LEFT JOIN branch_creation bc ON m.company_id = bc.branch_id LEFT JOIN company_creation cc ON bc.company_id = cc.company_id LEFT JOIN staff_creation sc ON m.assign_employee = sc.staff_id LEFT JOIN department_creation dc ON m.to_department = dc.department_id LEFT JOIN staff_creation sci ON m.initial_phase = sci.staff_id LEFT JOIN staff_creation scf ON m.final_phase = scf.staff_id WHERE m.company_id = '$branch_id' && m.date_of_completion != '' order by m.memo_id DESC");
$sno = 1;
while($row = $vehicle_details->fetch_object()) {
    // priority
    $priority_name='';
    $priority_id = $row->priority;
    if($priority_id == "1"){$priority_name = "High";}
    if($priority_id == "2"){$priority_name = "Medium";}
    if($priority_id == "3"){$priority_name = "Low";}
?>
    <tr>
        <td><?php echo $sno++; ?></td>
        <td><?php echo $row->company_name; ?></td>
        <td><?php echo $row->branch_name; ?></td>
        <td><?php echo $row->todeptName; ?></td>
        <td><?php echo $row->assignEmp; ?></td>
        <td><?php echo $priority_name;  ?></td>
        <td><?php echo $row->inquiry; ?></td>
        <td><?php echo $row->suggestion; ?></td>
        <td><?php echo "<a href='uploads/memo/".$row->attachment."' download='".$row->attachment."' title='Download File'>".$row->attachment."</a> "; ?></td>
        <td><?php echo $row->completion_target_date; ?></td>
        <td><?php echo $row->initialPhase; ?></td>
        <td><?php echo $row->finalPhase; ?></td>
        <td><?php echo $row->date_of_completion; ?></td>
        <td><?php echo "<a href='uploads/memo_update/".$row->update_attachment."' download='".$row->update_attachment."' title='Download File'>".$row->update_attachment."</a>"; ?></td>
        <td><?php echo $row->narration; ?></td>
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
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 ]
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