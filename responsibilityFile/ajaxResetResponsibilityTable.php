<?php
include '../ajaxconfig.php';
if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];   
}
?>

<table class="table custom-table" id="responsibilityTable"> 
    <thead>
        <tr>
            <th style="width: 15%">S. NO</th>
            <th style="width: 15%">Responsibility</th>
            <th style="width: 15%">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $resSelect="SELECT * FROM responsibility_creation WHERE branch_id = '".$branch_id."' AND status = 0 ORDER BY responsibility_id DESC";
        $resresult=$con->query($resSelect);
        if($resresult->num_rows>0){
        $i=1;
        while($res=$resresult->fetch_assoc()){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php if(isset($res["responsibility_name"])){ echo $res["responsibility_name"]; }?></td>
        <td>
            <a id="edit_responsibility" value="<?php if(isset($res["responsibility_id"])){ echo $res["responsibility_id"];}?>"><span class="icon-border_color"></span></a> &nbsp;
                <a id="delete_responsibility" value="<?php if(isset($res["responsibility_id"])){ echo $res["responsibility_id"]; }?>"><span class='icon-trash-2'></span>
            </a>
            </td>
        </tr>
        <?php $i = $i+1; }} ?>
    </tbody>
</table>

<script type="text/javascript">
$(function(){
  $('#responsibilityTable').DataTable({
    'iDisplayLength': 5,
    "language": {
      "lengthMenu": "Display _MENU_ Records Per Page",
      "info": "Showing Page _PAGE_ of _PAGES_",
    }
  });
});
</script>