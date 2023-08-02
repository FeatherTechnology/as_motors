<?php
include('../ajaxconfig.php');

if(isset($_POST['goal_setting_ref'])){
    $goal_setting_ref = $_POST['goal_setting_ref'];
}


$goalSettingsDetails = $mysqli->query("SELECT * FROM goal_setting_ref where goal_setting_id = '$goal_setting_ref' group by assertion order by assertion_table_sno asc") or die("Error in Get All Records".$mysqli->error);

if ($mysqli->affected_rows>0)
{
    while($goalInfo = $goalSettingsDetails->fetch_assoc()){
?>

<tr>
    <td>
        <input tabindex="9" type="text" class="form-control" id="assertion" placeholder="Enter Assertion" name="assertion[]" value="<?php echo $goalInfo['assertion']; ?>">  
        <input type="hidden" class="form-control" id="iid" name="iid[]" value="<?php echo $goalInfo['goal_setting_ref_id']; ?>">
        <input type="hidden" class="form-control" id="rowcnt" name="rowcnt[]" value="<?php echo $goalInfo['assertion_table_sno']; ?>">
    </td>
    <td><input tabindex="10" type="number" class="form-control" id="target" name="target[]" placeholder="Enter Target" value="<?php echo $goalInfo['target']; ?>"></td>
    <td><input type='month' tabindex='11' class='form-control' id='goal_month' name='goal_month[]' value="<?php echo date('Y-m',strtotime($goalInfo['goal_month'])); ?>"></td>
    <td><select tabindex="11" class="form-control" id="monthly_conversion" name="monthly_conversion[]">
            <option value=''>Select Type</option>
            <option value='0' <?php if (isset($goalInfo['monthly_conversion_required']) && $goalInfo['monthly_conversion_required'] == '0') { echo 'Selected'; } ?>>Month</option>
            <option value='1' <?php if (isset($goalInfo['monthly_conversion_required']) && $goalInfo['monthly_conversion_required'] == '1') { echo 'Selected'; } ?>>Daily</option>
        </select>
    </td>
    <td><button type="button" tabindex="12" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td>
    <td><span class='icon-trash-2' tabindex="13" id="delete_row"></span></td>
</tr>

<?php } } ?>