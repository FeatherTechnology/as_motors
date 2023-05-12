<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
}
if(isset($_SESSION["company_id"])){
	$branch_id = $_SESSION["company_id"];
}
if(isset($_POST["maintenance_checklist_id"])){
	$maintenance_checklist_id = $_POST["maintenance_checklist_id"]; 
}
if(isset($_POST["maintenance_checklist_ref_id"])){
	$maintenance_checklist_ref_id = $_POST["maintenance_checklist_ref_id"]; 
}
if(isset($_POST["checklist"])){
	$checklist = $_POST["checklist"]; 
} 

function getCategoryName($con, $category_id){
    $category_creation_name='';
    $getqry = "SELECT category_creation_name FROM category_creation WHERE category_creation_id ='".strip_tags($category_id)."' AND status = 0";
    $res = $con->query($getqry);
    while($row = $res->fetch_assoc())
    {
       $category_creation_name = $row["category_creation_name"];        
    }
    return $category_creation_name;
}

if($checklist == 'pm_checklist'){ ?>

    <div class="card" id="stockinformation">
        <div class="card-header">PM Checklist</div>
        <div class="card-body ">
        <br> 
            <div style="overflow-x: auto; white-space: nowrap;" >
                <?php
                $pm_checklist_id = array();       
                $category_id = array();          
                $checklist = array();          
                $type_of_checklist = array();   
                $yes_no_na	= array(); 
                $no_of_option = array();  
                $option1	= array();  
                $option2	= array();  
                $option3	= array();  
                $option4	= array();         
                $frequency = array();          
                $rating = array();  

                $maintenance_checklist_idArr = array();          
                $maintenance_checklist_ref_idArr = array();          
                $pm_checklist_idArr = array();          
                $remarksArr = array();          
                $fileArr = array();          
                
                $getPMChecklistId = $con->query("SELECT * FROM maintenance_checklist_ref WHERE maintenance_checklist_id = '".strip_tags($maintenance_checklist_id)."' ");
                while($row1 = $getPMChecklistId->fetch_assoc()){
                    $maintenance_checklist_idArr[] 	= $row1["maintenance_checklist_id"];
                    $maintenance_checklist_ref_idArr[] 	= $row1["maintenance_checklist_ref_id"];
                    $pm_checklist_idArr[] 	= $row1["pm_checklist_id"];
                    $remarksArr[] 	= $row1["remarks"];
                    $fileArr[] 	= $row1["file"];
                }   

                for($i=0; $i<=sizeof($pm_checklist_idArr)-1; $i++){ 
                    $selectPMChecklist = $con->query("SELECT * FROM pm_checklist WHERE pm_checklist_id = '".strip_tags($pm_checklist_idArr[$i])."' AND status = 0 ");
                    while($row = $selectPMChecklist->fetch_assoc()){

                        $pm_checklist_id[] 	= $row["pm_checklist_id"];
                        $category_id[]	= $row["category_id"];
                        $checklist[]	= $row["checklist"];
                        $type_of_checklist[]	= $row["type_of_checklist"];
                        $yes_no_na[]	= $row["yes_no_na"];
                        $no_of_option[]	= $row["no_of_option"];
                        $option1[]	= $row["option1"];
                        $option2[]	= $row["option2"];
                        $option3[]	= $row["option3"];
                        $option4[]	= $row["option4"];
                        $frequency[] = $row["frequency"];
                        $rating[]	= $row["rating"];
                    }   
                } 
                ?>

                <table class="table custom-table" id="sstable">
                    <tr>
                        <th>S. No.</th>
                        <th></th>
                        <th>Category</th>
                        <th>Checklist</th>
                        <th>Type Of Checklist</th>
                        <th>Frequency</th>
                        <th>Rating</th>
                        <th>Remarks</th>
                        <th>File Attachment</th>
                    </tr>
                    <?php
                    $sno = 1;   
                    if(isset($pm_checklist_id)){
                        for($o=0; $o<=sizeof($pm_checklist_id)-1; $o++){ ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $sno; ?></td>
                                    <input type="hidden" name="maintenanceChceklistId" id="maintenanceChceklistId" value="<?php echo $maintenance_checklist_idArr[$o]; ?>" />
                                    <td style="display: none;"><input type="text" readonly class="form-control" value="<?php echo $maintenance_checklist_ref_idArr[$o]; ?>" name="maintenanceChceklistRefId[]" id="maintenanceChceklistRefId" ></td>
                                    <td><input tabindex="3" type="checkbox" name="pm_checklist_id[]" id="pm_checklist_id" class="pm_checklist_id" value="<?php echo $pm_checklist_id[$o]; ?>" /></td>
                                    <td><input type="text" readonly class="form-control" value="<?php echo getCategoryName($con, $category_id[$o]); ?>" name="category_id[]" id="category_id"></td>
                                    <td><input type="text" readonly class="form-control" value="<?php echo $checklist[$o]; ?>" name="checklist[]" id="checklist" ></td>
                                    <td><input type="text" readonly class="form-control" value="<?php echo $type_of_checklist[$o]; ?>" name="type_of_checklist[]" id="type_of_checklist" ></td>
                                    <td><input type="text" readonly class="form-control" value="<?php echo $frequency[$o]; ?>" name="frequency[]" id="frequency" ></td>
                                    <td><input type="text" readonly class="form-control" value="<?php echo $rating[$o]; ?>" name="rating[]" id="rating" ></td>
                                    <td ><textarea disabled id="remarks" name="remarks[]" rows="3" cols="30" ><?php echo $remarksArr[$o]; ?></textarea></td>
                                    <td ><input disabled type="file" name="file[]" id="file" value="<?php echo $fileArr[$o]; ?>" ></td>
                                </tr>
                            </tbody>
                        <?php $sno = $sno + 1; }
                    } ?>
                </table>
            </div>
        </div>
    </div>

<?php }else if($checklist == 'bm_checklist'){ ?>

    <div class="card" id="stockinformation">
        <div class="card-header">PM Checklist</div>
        <div class="card-body ">
        <br> 
            <div style="overflow-x: auto; white-space: nowrap;" >
                <?php
                $pm_checklist_id = array();       
                $category_id = array();          
                $checklist = array();          
                $rating = array();  

                $maintenance_checklist_idArr = array();          
                $maintenance_checklist_ref_idArr = array();          
                $bm_checklist_idArr = array();          
                $remarksArr = array();          
                $fileArr = array();          
                
                $getPMChecklistId = $con->query("SELECT * FROM maintenance_checklist_ref WHERE maintenance_checklist_id = '".strip_tags($maintenance_checklist_id)."' ");
                while($row1 = $getPMChecklistId->fetch_assoc()){
                    $maintenance_checklist_idArr[] 	= $row1["maintenance_checklist_id"];
                    $maintenance_checklist_ref_idArr[] 	= $row1["maintenance_checklist_ref_id"];
                    $bm_checklist_idArr[] 	= $row1["bm_checklist_id"];
                    $remarksArr[] 	= $row1["remarks"];
                    $fileArr[] 	= $row1["file"];
                }   

                for($i=0; $i<=sizeof($bm_checklist_idArr)-1; $i++){ 
                    $selectPMChecklist = $con->query("SELECT * FROM bm_checklist WHERE bm_checklist_id = '".strip_tags($bm_checklist_idArr[$i])."' AND status = 0 ");
                    while($row = $selectPMChecklist->fetch_assoc()){

                        $bm_checklist_id[] 	= $row["bm_checklist_id"];
                        $category_id[]	= $row["category_id"];
                        $checklist[]	= $row["checklist"];
                        $rating[]	= $row["rating"];
                    }   
                } 
                ?>

                <table class="table custom-table" id="sstable">
                    <tr>
                        <th>S. No.</th>
                        <th></th>
                        <th>Category</th>
                        <th>Checklist</th>
                        <th>Rating</th>
                        <th>Remarks</th>
                        <th>File Attachment</th>
                    </tr>
                    <?php
                    $sno = 1;   
                    if(isset($bm_checklist_id)){
                        for($o=0; $o<=sizeof($bm_checklist_id)-1; $o++){ ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $sno; ?></td>
                                    <input type="hidden" name="maintenanceChceklistId" id="maintenanceChceklistId" value="<?php echo $maintenance_checklist_idArr[$o]; ?>" />
                                    <td style="display: none;"><input type="text" readonly class="form-control" value="<?php echo $maintenance_checklist_ref_idArr[$o]; ?>" name="maintenanceChceklistRefId[]" id="maintenanceChceklistRefId" ></td>
                                    <td><input tabindex="3" type="checkbox" name="bm_checklist_id[]" id="bm_checklist_id" class="bm_checklist_id" value="<?php echo $bm_checklist_id[$o]; ?>" /></td>
                                    <td><input type="text" readonly class="form-control" value="<?php echo getCategoryName($con, $category_id[$o]); ?>" name="category_id[]" id="category_id"></td>
                                    <td><input type="text" readonly class="form-control" value="<?php echo $checklist[$o]; ?>" name="checklist[]" id="checklist" ></td>
                                    <td><input type="text" readonly class="form-control" value="<?php echo $rating[$o]; ?>" name="rating[]" id="rating" ></td>
                                    <td ><textarea disabled id="remarks" name="remarks[]" rows="3" cols="30" ><?php echo $remarksArr[$o]; ?></textarea></td>
                                    <td ><input disabled type="file" name="file[]" id="file" value="<?php echo $fileArr[$o]; ?>" ></td>
                                </tr>
                            </tbody>
                        <?php $sno = $sno + 1; }
                    } ?>
                </table>
            </div>
        </div>
    </div>

<?php } ?>

<script>
    // set enable and disable condition
    $(".pm_checklist_id").on('click', function() { 
        var checkbox = $(this).parents('tr').find('td #pm_checklist_id').is(":checked");

        if (checkbox) { 
            $(this).parents('tr').find('td #remarks').attr("disabled",false);
            $(this).parents('tr').find('td #file').attr("disabled",false);
        } else { 
            $(this).parents('tr').find('td #remarks').attr("disabled",true);
            $(this).parents('tr').find('td #file').attr("disabled",true);
        }
    });

    $(".bm_checklist_id").on('click', function() { 
        var checkbox = $(this).parents('tr').find('td #bm_checklist_id').is(":checked");

        if (checkbox) { 
            $(this).parents('tr').find('td #remarks').attr("disabled",false);
            $(this).parents('tr').find('td #file').attr("disabled",false);
        } else { 
            $(this).parents('tr').find('td #remarks').attr("disabled",true);
            $(this).parents('tr').find('td #file').attr("disabled",true);
        }
    });
</script>