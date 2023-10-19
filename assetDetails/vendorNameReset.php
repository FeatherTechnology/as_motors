<?php
include '../ajaxconfig.php';
?>

<table class="table custom-table" id="vendornameModalTable">
    <thead>
        <tr>
            <th width='50px'>S. No</th>
            <th>Vendor Name</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $qry = $connect->query("SELECT vendor_name_id, vendor_name FROM `vendor_name_creation` where status = 0 order by vendor_name_id desc");
        while ($row = $qry->fetch()) {
        ?>

            <tr>
                <td></td>
                <td><?php echo $row["vendor_name"]; ?></td>
                <td>
                    <a id="edit_vendor_name" value="<?php echo $row['vendor_name_id']; ?>"> <span class="icon-border_color"></span></a> &nbsp;
                    <a id="delete_vendor_name" value="<?php echo $row['vendor_name_id']; ?>"> <span class='icon-trash-2'></span> </a>
                </td>

            </tr>

        <?php 
        }     ?>
    </tbody>
</table>


<script type="text/javascript">
    $(function() {
        $('#vendornameModalTable').DataTable({
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