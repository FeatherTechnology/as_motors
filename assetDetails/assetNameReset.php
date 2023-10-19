<?php
include '../ajaxconfig.php';
?>

<table class="table custom-table" id="assetnameModalTable">
    <thead>
        <tr>
            <th width='50px'>S. No</th>
            <th>Asset Name</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $qry = $connect->query("SELECT asset_name_id, asset_name FROM `asset_name_creation` where status = 0 order by asset_name_id desc");
        while ($row = $qry->fetch()) {
        ?>

            <tr>
                <td></td>
                <td><?php echo $row["asset_name"]; ?></td>
                <td>
                    <a id="edit_asset_name" value="<?php echo $row['asset_name_id']; ?>"> <span class="icon-border_color"></span></a> &nbsp;
                    <a id="delete_asset_name" value="<?php echo $row['asset_name_id']; ?>"> <span class='icon-trash-2'></span> </a>
                </td>

            </tr>

        <?php 
        }     ?>
    </tbody>
</table>


<script type="text/javascript">
    $(function() {
        $('#assetnameModalTable').DataTable({
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