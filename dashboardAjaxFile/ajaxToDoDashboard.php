<?php
include('../ajaxconfig.php');
@session_start();
if(isset($_SESSION["curdateFromIndexPage"])){
    $curdate = $_SESSION["curdateFromIndexPage"];
}
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
            <th>Work Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

<?php
$query = $con->query("SELECT * FROM todo_creation WHERE FIND_IN_SET('$staff_id', assign_to) && work_status != 3");
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
    <td><?php $sts = $data['work_status']; 
    if($sts == '0'){
        echo 'Work Assigned';

    }elseif($sts == '1'){
        echo 'In Progress';
        
    }elseif($sts == '2'){
        echo 'Pending';
        
    }
    ?></td>
    <td><input type="button" class="btn btn-primary" id="taskUpdateFromDashboardBtn" value="Update Task" onclick="callupdfunc('<?php echo date('Y-m-d',strtotime($data['to_date']));?>', 'todo <?php echo $data['todo_id'];?>', '<?php echo $data['work_des'];?>' )"></td>
</tr>
<?php $sno++; } ?>
    </tbody>
</table>

<!--onclick fnction ('to date', 'table id', 'Work description')  -->