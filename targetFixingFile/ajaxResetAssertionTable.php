<?php
include '../ajaxconfig.php';
if (isset($_POST['dept_id'])) {
    $dept_id = $_POST['dept_id'];   
}
?>

<table class="table custom-table" id="assertion_table"> 
    <thead>
        <tr>
            <th style="width: 15%">S. NO</th>
            <th style="width: 15%">Responsibility</th>
            <th style="width: 15%">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $assertionQry="SELECT * FROM assertion_creation WHERE dept_id = '".$dept_id."' AND status = 0 ORDER BY assertion_id DESC";
        $assertionDetails=$con->query($assertionQry);
        if($assertionDetails->num_rows>0){
        $i=1;
        while($assertionInfo=$assertionDetails->fetch_assoc()){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $assertionInfo["assertion"]; ?></td>
        <td>
            <a id="edit_assertion" value="<?php  echo $assertionInfo["assertion_id"];?>"><span class="icon-border_color"></span></a> &nbsp;
                <a id="delete_assertion" value="<?php  echo $assertionInfo["assertion_id"];?>"><span class='icon-trash-2'></span>
            </a>
            </td>
        </tr>
        <?php $i = $i+1; }} ?>
    </tbody>
</table>

<script type="text/javascript">
$(function(){
    $('#assertion_table').DataTable({
    'processing': true,
    'iDisplayLength': 10,
    "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    });
});
</script>