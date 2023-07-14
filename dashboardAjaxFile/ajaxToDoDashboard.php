<?php
include('../ajaxconfig.php');

if(isset($_POST["staff_id"])){
    $staff_id = $_POST["staff_id"];
}
?>
<table id="todo_infoDashboard" class="table custom-table">
    <thead>
        <tr>
            <th width='70'>S. No.</th>
            <th>Priority</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Work Description</th>
        </tr>
    </thead>
    <tbody>

<?php
$query = $con->query("SELECT * FROM todo_creation WHERE FIND_IN_SET('$staff_id', assign_to)");
$sno = 1;
while($data=$query->fetch_assoc()){
?>
<tr>
    <td><?php echo $sno; ?></td>
    <td><?php  //check priority
        if($data['priority'] == '1'){echo 'High';}
        elseif($data['priority'] == '2'){echo 'Medium';}
        else{echo 'Low';} ?></td>
    <td><?php echo date('d-m-Y',strtotime($data['from_date'])); ?></td>
    <td><?php echo date('d-m-Y',strtotime($data['to_date'])); ?></td>
    <td><?php echo $data['work_des']; ?></td>
</tr>
<?php $sno++; } ?>
    </tbody>
</table>