<?php
include('../ajaxconfig.php');

if(isset($_POST['goal_setting_ref'])){
    $goal_setting_ref = $_POST['goal_setting_ref'];
}
if(isset($_POST['department_id'])){
    $department_id = $_POST['department_id'];
}


$goalSettingsDetails = $mysqli->query("SELECT * FROM goal_setting_ref where goal_setting_id = '$goal_setting_ref' group by assertion order by assertion_table_sno asc") or die("Error in Get All Records".$mysqli->error);

if ($mysqli->affected_rows>0)
{
    $i=0;
    while($goalInfo = $goalSettingsDetails->fetch_assoc()){
?>

<tr>
    <td>
        <input tabindex="5" type="text" class="form-control" id="assertion" placeholder="Enter Assertion" name="assertion[]" value="<?php echo $goalInfo['assertion']; ?>">  
        <input type="hidden" class="form-control" id="iid" name="iid[]" value="<?php echo $goalInfo['goal_setting_ref_id']; ?>">
        <input type="hidden" class="form-control" id="rowcnt" name="rowcnt[]" value="<?php echo $goalInfo['assertion_table_sno']; ?>">
    </td>
    <td><input tabindex="6" type="number" class="form-control" id="target" name="target[]" placeholder="Enter Target" value="<?php echo $goalInfo['target']; ?>"></td>
    <td><input type='month' tabindex='7' class='form-control' id='goal_month' name='goal_month[]' value="<?php echo date('Y-m',strtotime($goalInfo['goal_month'])); ?>"></td>
    <td><select tabindex="8" class="form-control" id="monthly_conversion" name="monthly_conversion[]">
            <option value=''>Select Type</option>
            <option value='0' <?php if (isset($goalInfo['monthly_conversion_required']) && $goalInfo['monthly_conversion_required'] == '0') { echo 'Selected'; } ?>>Month</option>
            <option value='1' <?php if (isset($goalInfo['monthly_conversion_required']) && $goalInfo['monthly_conversion_required'] == '1') { echo 'Selected'; } ?>>Daily</option>
        </select>
    </td>
    <td>
    <input type="hidden" class="form-control" id="editstaffname<?php echo $i; ?>" name="editstaffname[]" value="<?php echo $goalInfo['staffname']; ?>">
    <select tabindex="9" class="form-control" id="staff_name<?php echo $i; ?>" name="staff_name<?php echo $i; ?>[]" multiple>
            <option value=''>Select Staff Name</option>
        </select>
    </td>
    <td><button type="button" tabindex="10" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td>
    <td><span class='icon-trash-2' tabindex="11" id="delete_row"></span></td>
</tr>

<script>
    const staffname = new Choices('#staff_name<?php echo $i; ?>', {
	removeItemButton: true,
    allowHTML: true, // Set allowHTML to true
});

staffNameListBasedOnDepartment();
//staff Name List
function staffNameListBasedOnDepartment(){ 
    var department_id = <?php echo $department_id; ?> ;
    var editstaffname = $('#editstaffname<?php echo $i; ?>').val().split(',');
    $.ajax({
        url: 'targetFixingFile/ajaxGetDepartmentBasedStaffs.php',
        type: 'post',
        data: { "department_id":department_id },
        dataType: 'json',
        success:function(response){  

            // $('#dept_strength').val(response.staff_id.length);

            staffname.clearStore();
            for (r = 0; r < response.staff_id.length; r++) { 

                var staff_id = response['staff_id'][r];  
                var staff_name = response['staff_name'][r]; 

                var selected = '';
                if(editstaffname != ''){
                
                    for(var i=0; i < editstaffname.length; i++){
                        if(editstaffname[i] == staff_id){ 
                            selected = 'selected'; 
                        }
                    }
                }

                var items = [
                    {
                        value: staff_id,
                        label: staff_name,
                        selected: selected,
                    }
                ];
                staffname.setChoices(items);
                staffname.init();
            }

        }
    });
};
</script>

<?php $i++; } } ?>
