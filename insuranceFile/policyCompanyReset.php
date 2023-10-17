<?php
include '../ajaxconfig.php';
?>

<table class="table custom-table" id="policyModalTable">
    <thead>
        <tr>
            <th width='50px'>S. No</th>
            <th>Policy Company</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $qry = $connect->query("SELECT * FROM `policy_company_creation` where status = 0 order by policy_company_id desc");
        while ($row = $qry->fetch()) {
        ?>

            <tr>
                <td></td>
                <td><?php echo $row["policy_company"]; ?></td>
                <td>
                    <a id="policy_company_edit" value="<?php echo $row['policy_company_id']; ?>"> <span class="icon-border_color"></span></a> &nbsp;
                    <a id="policy_company_delete" value="<?php echo $row['policy_company_id']; ?>"> <span class='icon-trash-2'></span> </a>
                </td>

            </tr>

        <?php 
        }     ?>
    </tbody>
</table>


<script type="text/javascript">
    $(function() {
        $('#policyModalTable').DataTable({
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
            // dom: 'lBfrtip',
            // buttons: [{
            //         extend: 'excel',
            //     },
            //     {
            //         extend: 'colvis',
            //         collectionLayout: 'fixed four-column',
            //     }
            // ],
        });
    });
</script>