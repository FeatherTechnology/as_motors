<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["branch_id"])){
    $company_id = $_SESSION["branch_id"];
}
?>

<table class="table custom-table" id="insuranceTable"> 
    <thead>
      <tr>
        <th style="width: 15%">S.No</th>
        <th style="width: 15%">Insurance</th>
        <th style="width: 15%">Action</th>
      </tr>
    </thead>
    <tbody>
        <?php
        $ctselect="SELECT * FROM insurance_creation WHERE status = 0 and company_id = '".$company_id."' ORDER BY insurance_id DESC";
        $ctresult=$con->query($ctselect);
        if($ctresult->num_rows>0){
        $i=1;
        while($ct=$ctresult->fetch_assoc()){
        ?>
        <tr>
        <td><?php echo $i;?></td>
        <td><?php if(isset($ct["insurance_name"])){ echo $ct["insurance_name"]; }?></td>
        <td>
            <a id="edit_insurance" value="<?php if(isset($ct["insurance_id"])){ echo $ct["insurance_id"];}?>"><span class="icon-border_color"></span></a> &nbsp;
                <a id="delete_insurance" value="<?php if(isset($ct["insurance_id"])){ echo $ct["insurance_id"]; }?>"><span class='icon-trash-2'></span>
            </a>
            </td>
        </tr>
        <?php $i++; }} ?>
    </tbody>
</table>

<script type="text/javascript">
  $('#insuranceTable').DataTable({
    'iDisplayLength': 5,
    "language": {
        "lengthMenu": "Display _MENU_ Records Per Page",
        "info": "Showing Page _PAGE_ of _PAGES_",
    }
  });
</script>