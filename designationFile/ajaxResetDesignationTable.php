<?php
include '../ajaxconfig.php';
if (isset($_POST['branch_id'])) {
  $company_id = $_POST['branch_id'];
}
?>

<table class="table custom-table" id="designationTable"> 
    <thead>
        <tr>
            <th style="width: 15%">S. NO</th>
            <th style="width: 15%">Designation</th>
            <th style="width: 15%">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ctselect="SELECT * FROM designation_creation WHERE company_id='".$company_id."' AND status=0 ORDER BY designation_id DESC";
        $ctresult=$con->query($ctselect);
        if($ctresult->num_rows>0){
        $i=1;
        while($ct=$ctresult->fetch_assoc()){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php if(isset($ct["designation_name"])){ echo $ct["designation_name"]; }?></td>
        <td>
            <a id="edit_designation" value="<?php if(isset($ct["designation_id"])){ echo $ct["designation_id"];}?>"><span class="icon-border_color"></span></a> &nbsp;
                <a id="delete_designation" value="<?php if(isset($ct["designation_id"])){ echo $ct["designation_id"]; }?>"><span class='icon-trash-2'></span>
            </a>
            </td>
        </tr>
        <?php $i = $i+1; }} ?>
    </tbody>
</table>

<script type="text/javascript">
$(function(){
  $('#designationTable').DataTable({
    'iDisplayLength': 5,
    "language": {
      "lengthMenu": "Display _MENU_ Records Per Page",
      "info": "Showing Page _PAGE_ of _PAGES_",
    }
  });
});
</script>