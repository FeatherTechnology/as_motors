<?php
include('../ajaxconfig.php');

if(isset($_POST['goal_setting_ref'])){
    $goal_setting_ref = $_POST['goal_setting_ref'];
}
if(isset($_POST['department_id'])){
    $department_id = $_POST['department_id'];
}


$goalSettingsDetails = $mysqli->query("SELECT gsr.* FROM goal_setting_ref gsr where gsr.goal_setting_id = '$goal_setting_ref' group by gsr.assertion_table_sno order by gsr.assertion_table_sno asc") or die("Error in Get All Records".$mysqli->error);

if ($mysqli->affected_rows>0)
{
    // Close the database connection
    $mysqli->close();
    $connect = null;

    $i=0;
    while($goalInfo = $goalSettingsDetails->fetch_assoc()){
        $selectBoxId = 'assertion'.$i;
?>

<tr>
    <td>
        <select tabindex="5" class="form-control assertion_names" id="assertion<?php echo $i;?>" name="assertion[]"><option value=''>Select Assertion</option></select> 
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
    <td><select tabindex="9" class="form-control" id="entry_date_type" name="entry_date_type[]">
        <option value=''>Select Type</option>
        <option value='0' <?php if (isset($goalInfo['entry_date_type']) && $goalInfo['entry_date_type'] == '0') { echo 'Selected'; } ?>>Current date</option>
        <option value='1' <?php if (isset($goalInfo['entry_date_type']) && $goalInfo['entry_date_type'] == '1') { echo 'Selected'; } ?>>Previous date</option>
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

$(function(){ //OnLoad Function//

    dropdownAssertions(<?php echo $selectBoxId; ?>,'<?php echo $goalInfo['assertion'];?>'); //Assertion dropdown.
    staffNameListBasedOnDepartment(); //Staff name.
    
});

    function getselectedassertionsOnEdit(){
        var assertionValue = {};
        $('.assertion_names').each(function(){
            var id = $(this).attr('id');
            var value = $(this).val();
            assertionValue[id] = value;
        })
        return assertionValue;
    }

    function dropdownAssertions(id, editvalue){ // when onload & row append passing id, when modal close passing class.
    var branch_id = $('#branch_id :selected').val();
    var dept = $('#dept :selected').val();
    var temporaryAssertion = getselectedassertionsOnEdit(); //To store assertion value temporary.
    
        $.ajax({
            url: 'targetFixingFile/ajaxGetAssertionDropDown.php',
            type: 'post',
            data: {'branch_id': branch_id, "dept": dept},
            dataType: 'json',
            success:function(response){
                $(id).empty();            
                $(id).append("<option value=''>Select Assertion</option>");
                for(var a = 0; a < response.length; a++){
                    var selected = '';
                    if(editvalue.trim().toLowerCase() == response[a]['assertion'].trim().toLowerCase()){
                        selected = 'selected';
                    }
                    $(id).append("<option value='"+response[a]['assertion']+"'"+selected+">"+response[a]['assertion']+"</option>");
                }

                // if(editvalue ==''){ //in edit page value initially set so restrict this function, if this function run it affect edit option value.
                //     $.each(temporaryAssertion, function(key, value) {
                //         $('#' + key).val(value);
                //     });
                // }
            }     
        });     
    }

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
                    var designation_name = response['designation_name'][r]; 

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
                            label: staff_name + ' - (' + designation_name + ')',
                            selected: selected,
                        }
                    ];
                    staffname.setChoices(items);
                    staffname.init();
                }
            }
        });
    }
</script>

<?php $i++; } } ?>
