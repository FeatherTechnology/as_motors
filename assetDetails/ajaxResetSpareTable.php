<?php
include '../ajaxconfig.php';

if (isset($_POST['branch_id'])) {
  $branch_id = $_POST['branch_id'];
}
?>

<table class="table custom-table" id="spareTable"> 
    <thead>
        <tr>
          <th style="width: 15%">S.No</th>
          <th style="width: 15%">Spare Name</th>
          <th style="width: 15%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ctselect="SELECT * FROM spare_creation WHERE branch_id='".$branch_id."' AND status=0 ORDER BY spare_id DESC";
        $ctresult=$con->query($ctselect);
        if($ctresult->num_rows>0){
        $i=1;
        while($ct=$ctresult->fetch_assoc()){
        ?>
        <tr>
        <td><?php echo $i;?></td>
        <td><?php if(isset($ct["spare_name"])){ echo $ct["spare_name"]; }?></td>
        <td>
            <a id="edit_spare" value="<?php if(isset($ct["spare_id"])){ echo $ct["spare_id"];}?>"><span class="icon-border_color"></span></a> &nbsp;
                <a id="delete_spare" value="<?php if(isset($ct["spare_id"])){ echo $ct["spare_id"]; }?>"><span class='icon-trash-2'></span>
            </a>
            </td>
        </tr>
        <?php $i = $i+1; }} ?>
    </tbody>
</table>

<script type="text/javascript">
$(function(){
  $('#spareTable').DataTable({
    'iDisplayLength': 5,
    "language": {
      "lengthMenu": "Display _MENU_ Records Per Page",
      "info": "Showing Page _PAGE_ of _PAGES_",
    }
  });
});
</script>