<?php
include '../ajaxconfig.php';
?>

<table class="table custom-table" id="categoryTable"> 
    <thead>
        <tr>
            <th>S. NO</th>
            <th>CATEGORY</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ctselect="SELECT * FROM category_creation WHERE 1 AND status=0 ORDER BY category_creation_id DESC";
        $ctresult=$con->query($ctselect);
        if($ctresult->num_rows>0){
        $i=1;
        while($ct=$ctresult->fetch_assoc()){
        ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php if(isset($ct["category_creation_name"])){ echo $ct["category_creation_name"]; }?></td>
          <td>
            <a id="edit_category" value="<?php if(isset($ct["category_creation_id"])){ echo $ct["category_creation_id"];}?>"><span class="icon-border_color"></span></a> &nbsp
            <a id="delete_category" value="<?php if(isset($ct["category_creation_id"])){ echo $ct["category_creation_id"]; }?>"><span class='icon-trash-2'></span></a>
          </td>
        </tr>
        <?php $i = $i+1; }} ?>
    </tbody>
</table>

<script type="text/javascript">
$(function(){
  $('#categoryTable').DataTable({
    'iDisplayLength': 5,
    "language": {
      "lengthMenu": "Display _MENU_ Records Per Page",
      "info": "Showing Page _PAGE_ of _PAGES_",
    }
  });
});
</script>