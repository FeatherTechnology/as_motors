<?php
include '../../ajaxconfig.php';
//krakpi.\\         ////designation based.
?>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
    <div class="form-group">
        <input type="button" name="page_print" id="page_print" class="btn btn-danger print-page " value="PRINT">
    </div>
</div>
<table class="table custom-table" id="designation_report_data">
    <thead>
        <tr>
            <th width="15%">S.No</th>
            <th>Emp Code</th>
            <th>Staff Name</th>
            <th>Designation Name</th>
            <th>Frequency</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>KRA Category</th>
            <th>R & R</th>
        </tr>
    </thead>
    <tbody>

<?php

$emp_code = array();
$staff_name = array();
$designation = array();
$frequency = array();
$from_date = array();
$to_date = array();
$kra = array();
$rr = array();

//KRAKPI start//
$qry = "";

$qry = "SELECT dc.designation_name,sc.emp_code, sc.staff_name, kcr.frequency, kcr.from_date, kcr.to_date, kra.kra_category, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as RR
FROM krakpi_creation kc
LEFT JOIN krakpi_creation_ref kcr ON kc.krakpi_id = kcr.krakpi_reff_id 
LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id
LEFT JOIN kra_creation_ref kra ON kcr.kra_category = kra.kra_creation_ref_id
LEFT JOIN staff_creation sc ON kc.designation = sc.designation
LEFT JOIN designation_creation dc ON kc.designation = dc.designation_id
WHERE  kc.status = 0  ";

$krakpiInfo = $connect->query($qry);
if($krakpiInfo){
    
while ($krakpitask = $krakpiInfo->fetch()) { 

    $emp_code[]['emp_code'] = $krakpitask['emp_code'];
    $staff_name[]['staff_name'] = $krakpitask['staff_name'];
    $designation[]['designation_name'] = $krakpitask['designation_name'];
    $frequency[]['frequency'] = $krakpitask['frequency'];
    $from_date[]['from_date'] = $krakpitask['from_date'];
    $to_date[]['to_date'] = $krakpitask['to_date'];
    $kra[]['kra_category'] = $krakpitask['kra_category'];
    $rr[]['RR'] = $krakpitask['RR'];
    }
}
//KRAKPI END//

$a = 1;
for ($i=0; $i<count($kra); $i++) { 
?>    
    <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $emp_code[$i]['emp_code']; ?></td>
        <td><?php echo $staff_name[$i]['staff_name']; ?></td>
        <td><?php echo $designation[$i]['designation_name']; ?></td>
        <td><?php echo $frequency[$i]['frequency']; ?></td>
        <td><?php echo $from_date[$i]['from_date']; ?></td>
        <td><?php echo $to_date[$i]['to_date']; ?></td>
        <td><?php echo $kra[$i]['kra_category']; ?></td>
        <td><?php echo $rr[$i]['RR']; ?></td>
    </tr>
<?php }  ?>
    </tbody>
</table>


<script type="text/javascript">
    $(function() {
        $('#designation_report_data').DataTable({
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
            // "createdRow": function(row, data, dataIndex) {
            //     $(row).find('td:first').html(dataIndex + 1);
            // },
            // "drawCallback": function(settings) {
            //     this.api().column(0).nodes().each(function(cell, i) {
            //         cell.innerHTML = i + 1;
            //     });
            // },
            // "order": [[1, 'asc']] // Order by the second column (staff name) in ascending order
        });
    });

    $('#page_print').click(function (e){
        e.preventDefault();

        const table = document.getElementById('designation_report_data');

        if (table) {
            // Clone the table to avoid modifying the original table
            const tableClone = table.cloneNode(true);
        
            // Create a new window to print the modified table
            const newWindow = window.open('', '_blank');
            newWindow.document.write('<html><head><title>Print Table</title></head><body>');
            newWindow.document.write('<h4> KRA&KPI Report </h4>');
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