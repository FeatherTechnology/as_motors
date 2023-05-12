<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 

$companyName = $userObj->getcompanyName($mysqli);
$branchName = $userObj->getBranchName($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$companyList = $userObj->getCompanyName($mysqli);

$id=0;
if(isset($_POST['submitMaintenanceChecklistBtn']) && $_POST['submitMaintenanceChecklistBtn'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateMaintenanceChecklist = $userObj->updateMaintenanceChecklist($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_maintenance_checklist&msc=2';</script> 
    <?php }
}   

$del=0;
if(isset($_GET['del']))
{
$del=$_GET['del'];
}
if($del>0)
{
	$deleteMaintenanceChecklist = $userObj->deleteMaintenanceChecklist($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_maintenance_checklist&msc=3';</script>
    <?php	
}

// update
if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getMaintenanceChecklist = $userObj->getMaintenanceChecklist($mysqli,$idupd); 
	if (sizeof($getMaintenanceChecklist)>0) {
        for($itag=0;$itag<sizeof($getMaintenanceChecklist);$itag++) {

            $maintenance_checklist_id            = $getMaintenanceChecklist['maintenance_checklist_id']; 
            $company_id                          = $getMaintenanceChecklist['company_id'];
			$date_of_inspection                  = $getMaintenanceChecklist['date_of_inspection'];
			$asset_details    	                 = $getMaintenanceChecklist['asset_details'];
			$checklist    	                     = $getMaintenanceChecklist['checklist'];
			$calendar    	                     = $getMaintenanceChecklist['calendar']; 
			$from_date    	                     = date('Y-m-d',strtotime($getMaintenanceChecklist['from_date']));
			$to_date    	                     = date('Y-m-d',strtotime($getMaintenanceChecklist['to_date'])); 
			$role1    	                     = $getMaintenanceChecklist['role1']; 
			$role2    	                     = $getMaintenanceChecklist['role2'];
			$maintenance_checklist_ref_id    	 = $getMaintenanceChecklist['maintenance_checklist_ref_id'];
			$pm_checklist_id    	             = $getMaintenanceChecklist['pm_checklist_id'];
			$bm_checklist_id    	             = $getMaintenanceChecklist['bm_checklist_id'];
		}
	} 
    // get company name
    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_id);
    ?>

    <input type="hidden" id="calendarEdit" name="calendarEdit" value="<?php print_r($calendar); ?>" >
    <input type="hidden" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="inspersonEdit" name="inspersonEdit" value="<?php print_r($role1); ?>" >
    <input type="hidden" id="responderEdit" name="responderEdit" value="<?php print_r($role2); ?>" >
    <input type="hidden" id="asset_detailsEdit" name="asset_detailsEdit" value="<?php print_r($asset_details); ?>" >
    <input type="hidden" id="checklistEdit" name="checklistEdit" value="<?php print_r($checklist); ?>" >
    <input type="hidden" id="pm_checklist_idEdit" name="pm_checklist_idEdit" value="<?php print_r($pm_checklist_id); ?>" >
    <input type="hidden" id="bm_checklist_idEdit" name="bm_checklist_idEdit" value="<?php print_r($bm_checklist_id); ?>" >
    <input type="hidden" id="maintenance_checklist_idEdit" name="maintenance_checklist_idEdit" value="<?php print_r($maintenance_checklist_id); ?>" >
    <input type="hidden" id="maintenance_checklist_ref_idEdit" name="maintenance_checklist_ref_idEdit" value="<?php print_r($maintenance_checklist_ref_id); ?>" >

    <script language='javascript'>

        // get branch name
        window.onload=editCompanyBasedBranch;
        function editCompanyBasedBranch(){  
            var branch_id = $("#branchIdEdit").val();

            $.ajax({
                url: 'R&RFile/ajaxEditCompanyBasedBranch.php',
                type:'post',
                data: {'branch_id': branch_id},
                dataType: 'json',
                success: function(response){
                    
                    $("#branch_id").empty();
                    $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
                    var r = 0;
                    for (r = 0; r <= response.branch_id.length - 1; r++) { 
                        var selected = "";
                        if(response['branch_id'][r] == branch_id)
                        {
                            selected = "selected";
                        }
                        $('#branch_id').append("<option value='" + response['branch_id'][r] + "' "+selected+">" + 
                        response['branch_name'][r] + "</option>");
                    }
                }
            });

            editInsPerson(branch_id);
            editChecklist(branch_id);

            // enable disable calendar
            var calendar = $('#calendarEdit').val();
            if(calendar == 'Yes'){ 
                $('#from_date').attr("readonly",false);
                $('#to_date').attr("readonly",false);
            } else if(calendar == 'No'){ 
                $('#from_date').attr("readonly",true);
                $('#to_date').attr("readonly",true);
                $('#from_date').val('');
                $('#to_date').val('');
            }

        }

        function editInsPerson(company_id){ 
            var inspersonEdit = $("#inspersonEdit").val(); 
            var responderEdit = $("#responderEdit").val(); 
            var asset_detailsEdit = $("#asset_detailsEdit").val(); 

            $.ajax({
                url: 'maintenanceChecklistFile/ajaxGetDesignationDepartment.php',
                type: 'post',
                data: { "company_id":company_id },
                dataType: 'json',
                success: function(response){ 

                    $('#role1').empty();
                    $('#role1').prepend("<option value=''>" + 'Select Role 1' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.designation_id.length - 1; r++) { 
                        var selected = "";
                        if(response['designation_id'][r] == inspersonEdit)
                        {
                            selected = "selected";
                        }
                        $('#role1').append("<option value='" + response['designation_id'][r] + "' "+selected+">" + response['designation_name'][r]+ "</option>");
                    }

                    $('#role2').empty();
                    $('#role2').prepend("<option value=''>" + 'Select Role 2' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.designation_id.length - 1; r++) { 
                        var selected = "";
                        if(response['designation_id'][r] == responderEdit)
                        {
                            selected = "selected";
                        }
                        $('#role2').append("<option value='" + response['designation_id'][r] + "' "+selected+">" + response['designation_name'][r]+ "</option>");
                    }

                    $('#asset_details').empty();
                    $('#asset_details').prepend("<option value=''>" + 'Select Asset Details' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.asset_id.length - 1; r++) { 
                        var selected = "";
                        if(response['asset_id'][r] == asset_detailsEdit)
                        {
                            selected = "selected";
                        }
                        $('#asset_details').append("<option value='" + response['asset_id'][r] + "' "+selected+">" + response['asset_name'][r]+' - '+response['asset_classification'][r] + "</option>");
                    }
                }
            });
        }

        function editChecklist(company_id){ 
            var maintenance_checklist_id = $("#maintenance_checklist_idEdit").val();
            var maintenance_checklist_ref_id = $("#maintenance_checklist_ref_idEdit").val();
            var checklist = $("#checklistEdit").val();
            var pm_checklist_id = $("#pm_checklist_idEdit").val();
            var bm_checklist_id = $("#bm_checklist_idEdit").val();

            if(checklist.length != ''){
                $.ajax({
                    url:"maintenanceChecklistFile/ajaxGetPMBMChecklistDetailsEdit.php",
                    method:"post",
                    data:{ "maintenance_checklist_id":maintenance_checklist_id, "maintenance_checklist_ref_id":maintenance_checklist_ref_id, 
                        "company_id":company_id, "checklist":checklist, "pm_checklist_id":pm_checklist_id, "bm_checklist_id":bm_checklist_id  
                    },
                    success:function(html){
                        $("#checklistAppend").empty();
                        $("#checklistAppend").html(html);
                    }
                });
            }
        }
    </script>
    <?php
}

// dashboard
$dashupd=0;
if(isset($_GET['dashupd']))
{
    $dashupd=$_GET['dashupd'];
}
$status =0;
if($dashupd>0)
{ 
	$getMaintenanceChecklist = $userObj->getMaintenanceChecklist($mysqli,$dashupd); 
	if (sizeof($getMaintenanceChecklist)>0) {
        for($itag=0;$itag<sizeof($getMaintenanceChecklist);$itag++) {

            $maintenance_checklist_id            = $getMaintenanceChecklist['maintenance_checklist_id']; 
            $company_id                          = $getMaintenanceChecklist['company_id'];
			$date_of_inspection                  = $getMaintenanceChecklist['date_of_inspection'];
			$asset_details    	                 = $getMaintenanceChecklist['asset_details'];
			$checklist    	                     = $getMaintenanceChecklist['checklist'];
            $calendar    	                     = $getMaintenanceChecklist['calendar']; 
            $from_date    	                     = date('Y-m-d',strtotime($getMaintenanceChecklist['from_date'])); 
			$to_date    	                     = date('Y-m-d',strtotime($getMaintenanceChecklist['to_date'])); 
			$role1    	                     = $getMaintenanceChecklist['role1']; 
			$role2    	                     = $getMaintenanceChecklist['role2'];
			$maintenance_checklist_ref_id    	 = $getMaintenanceChecklist['maintenance_checklist_ref_id'];
			$pm_checklist_id    	             = $getMaintenanceChecklist['pm_checklist_id'];
			$bm_checklist_id    	             = $getMaintenanceChecklist['bm_checklist_id'];
		}
	} 

    // get company name
    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_id);
    ?>

    <input type="hidden" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="inspersonEdit" name="inspersonEdit" value="<?php print_r($role1); ?>" >
    <input type="hidden" id="responderEdit" name="responderEdit" value="<?php print_r($role2); ?>" >
    <input type="hidden" id="asset_detailsEdit" name="asset_detailsEdit" value="<?php print_r($asset_details); ?>" >
    <input type="hidden" id="checklistEdit" name="checklistEdit" value="<?php print_r($checklist); ?>" >
    <input type="hidden" id="pm_checklist_idEdit" name="pm_checklist_idEdit" value="<?php print_r($pm_checklist_id); ?>" >
    <input type="hidden" id="bm_checklist_idEdit" name="bm_checklist_idEdit" value="<?php print_r($bm_checklist_id); ?>" >
    <input type="hidden" id="maintenance_checklist_idEdit" name="maintenance_checklist_idEdit" value="<?php print_r($maintenance_checklist_id); ?>" >
    <input type="hidden" id="maintenance_checklist_ref_idEdit" name="maintenance_checklist_ref_idEdit" value="<?php print_r($maintenance_checklist_ref_id); ?>" >

    <script language='javascript'>
        // get branch name
        window.onload=editCompanyBasedBranch;
        function editCompanyBasedBranch(){  
            var branch_id = $("#branchIdEdit").val();

            $.ajax({
                url: 'R&RFile/ajaxEditCompanyBasedBranch.php',
                type:'post',
                data: {'branch_id': branch_id},
                dataType: 'json',
                success: function(response){
                    
                    $("#branch_id").empty();
                    $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
                    var r = 0;
                    for (r = 0; r <= response.branch_id.length - 1; r++) { 
                        var selected = "";
                        if(response['branch_id'][r] == branch_id)
                        {
                            selected = "selected";
                        }
                        $('#branch_id').append("<option value='" + response['branch_id'][r] + "' "+selected+">" + 
                        response['branch_name'][r] + "</option>");
                    }
                }
            });

            editInsPerson(branch_id);
            editChecklist(branch_id)
        }

        function editInsPerson(company_id){ 

            var inspersonEdit = $("#inspersonEdit").val(); 
            var responderEdit = $("#responderEdit").val(); 
            var asset_detailsEdit = $("#asset_detailsEdit").val(); 

            $.ajax({
                url: 'maintenanceChecklistFile/ajaxGetDesignationDepartment.php',
                type: 'post',
                data: { "company_id":company_id },
                dataType: 'json',
                success: function(response){ 

                    $('#role1').empty();
                    $('#role1').prepend("<option value=''>" + 'Select Role 1' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.designation_id.length - 1; r++) { 
                        var selected = "";
                        if(response['designation_id'][r] == inspersonEdit)
                        {
                            selected = "selected";
                        }
                        $('#role1').append("<option value='" + response['designation_id'][r] + "' "+selected+">" + response['designation_name'][r]+ "</option>");
                    }

                    $('#role2').empty();
                    $('#role2').prepend("<option value=''>" + 'Select Role 2' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.designation_id.length - 1; r++) { 
                        var selected = "";
                        if(response['designation_id'][r] == responderEdit)
                        {
                            selected = "selected";
                        }
                        $('#role2').append("<option value='" + response['designation_id'][r] + "' "+selected+">" + response['designation_name'][r]+ "</option>");
                    }

                    $('#asset_details').empty();
                    $('#asset_details').prepend("<option value=''>" + 'Select Asset Details' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.asset_id.length - 1; r++) { 
                        var selected = "";
                        if(response['asset_id'][r] == asset_detailsEdit)
                        {
                            selected = "selected";
                        }
                        $('#asset_details').append("<option value='" + response['asset_id'][r] + "' "+selected+">" + response['asset_name'][r]+' - '+response['asset_classification'][r] + "</option>");
                    }

                }
            });
        }

        function editChecklist(company_id){ 

            var maintenance_checklist_id = $("#maintenance_checklist_idEdit").val();
            var maintenance_checklist_ref_id = $("#maintenance_checklist_ref_idEdit").val();
            var checklist = $("#checklistEdit").val();
            var pm_checklist_id = $("#pm_checklist_idEdit").val();
            var bm_checklist_id = $("#bm_checklist_idEdit").val();

            if(checklist.length != ''){
                $.ajax({
                    url:"maintenanceChecklistFile/ajaxGetPMBMChecklistDetailsDashboard.php",
                    method:"post",
                    data:{ "maintenance_checklist_id":maintenance_checklist_id, "maintenance_checklist_ref_id":maintenance_checklist_ref_id, 
                        "company_id":company_id, "checklist":checklist, "pm_checklist_id":pm_checklist_id, "bm_checklist_id":bm_checklist_id  
                    },
                    success:function(html){
                        $("#checklistAppend").empty();
                        $("#checklistAppend").html(html);
                    }
                });
            }
        }
    </script>

<?php
}

// view
$view=0;
if(isset($_GET['view']))
{
    $view=$_GET['view'];
}
$status =0;
if($view>0)
{ 
	$getMaintenanceChecklist = $userObj->getMaintenanceChecklist($mysqli,$view); 
	if (sizeof($getMaintenanceChecklist)>0) {
        for($itag=0;$itag<sizeof($getMaintenanceChecklist);$itag++) {

            $maintenance_checklist_id            = $getMaintenanceChecklist['maintenance_checklist_id']; 
            $company_id                          = $getMaintenanceChecklist['company_id'];
			$date_of_inspection                  = $getMaintenanceChecklist['date_of_inspection'];
			$asset_details    	                 = $getMaintenanceChecklist['asset_details'];
			$checklist    	                     = $getMaintenanceChecklist['checklist'];
			$calendar    	                     = $getMaintenanceChecklist['calendar']; 
			$from_date    	                     = date('Y-m-d',strtotime($getMaintenanceChecklist['from_date'])); 
			$to_date    	                     = date('Y-m-d',strtotime($getMaintenanceChecklist['to_date']));  
			$role1    	                         = $getMaintenanceChecklist['role1']; 
			$role2    	                         = $getMaintenanceChecklist['role2'];
			$maintenance_checklist_ref_id    	 = $getMaintenanceChecklist['maintenance_checklist_ref_id'];
			$pm_checklist_id    	             = $getMaintenanceChecklist['pm_checklist_id'];
			$bm_checklist_id    	             = $getMaintenanceChecklist['bm_checklist_id'];
		}
	} 
    // get company name
    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_id);
    ?>

    <input type="hidden" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="inspersonEdit" name="inspersonEdit" value="<?php print_r($role1); ?>" >
    <input type="hidden" id="responderEdit" name="responderEdit" value="<?php print_r($role2); ?>" >
    <input type="hidden" id="asset_detailsEdit" name="asset_detailsEdit" value="<?php print_r($asset_details); ?>" >
    <input type="hidden" id="checklistEdit" name="checklistEdit" value="<?php print_r($checklist); ?>" >
    <input type="hidden" id="pm_checklist_idEdit" name="pm_checklist_idEdit" value="<?php print_r($pm_checklist_id); ?>" >
    <input type="hidden" id="bm_checklist_idEdit" name="bm_checklist_idEdit" value="<?php print_r($bm_checklist_id); ?>" >
    <input type="hidden" id="maintenance_checklist_idEdit" name="maintenance_checklist_idEdit" value="<?php print_r($maintenance_checklist_id); ?>" >
    <input type="hidden" id="maintenance_checklist_ref_idEdit" name="maintenance_checklist_ref_idEdit" value="<?php print_r($maintenance_checklist_ref_id); ?>" >

    <script language='javascript'>

        // get branch name
        window.onload=editCompanyBasedBranch;
        function editCompanyBasedBranch(){  
            var branch_id = $("#branchIdEdit").val();

            $.ajax({
                url: 'R&RFile/ajaxEditCompanyBasedBranch.php',
                type:'post',
                data: {'branch_id': branch_id},
                dataType: 'json',
                success: function(response){
                    
                    $("#branch_id").empty();
                    $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
                    var r = 0;
                    for (r = 0; r <= response.branch_id.length - 1; r++) { 
                        var selected = "";
                        if(response['branch_id'][r] == branch_id)
                        {
                            selected = "selected";
                        }
                        $('#branch_id').append("<option value='" + response['branch_id'][r] + "' "+selected+">" + 
                        response['branch_name'][r] + "</option>");
                    }
                }
            });

            editInsPerson(branch_id);
            editChecklist(branch_id)
        }

        function editInsPerson(company_id){ 

            var inspersonEdit = $("#inspersonEdit").val(); 
            var responderEdit = $("#responderEdit").val(); 
            var asset_detailsEdit = $("#asset_detailsEdit").val(); 

            $.ajax({
                url: 'maintenanceChecklistFile/ajaxGetDesignationDepartment.php',
                type: 'post',
                data: { "company_id":company_id },
                dataType: 'json',
                success: function(response){ 

                    $('#role1').empty();
                    $('#role1').prepend("<option value=''>" + 'Select Role 1' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.designation_id.length - 1; r++) { 
                        var selected = "";
                        if(response['designation_id'][r] == inspersonEdit)
                        {
                            selected = "selected";
                        }
                        $('#role1').append("<option value='" + response['designation_id'][r] + "' "+selected+">" + response['designation_name'][r]+ "</option>");
                    }

                    $('#role2').empty();
                    $('#role2').prepend("<option value=''>" + 'Select Role 2' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.designation_id.length - 1; r++) { 
                        var selected = "";
                        if(response['designation_id'][r] == responderEdit)
                        {
                            selected = "selected";
                        }
                        $('#role2').append("<option value='" + response['designation_id'][r] + "' "+selected+">" + response['designation_name'][r]+ "</option>");
                    }

                    $('#asset_details').empty();
                    $('#asset_details').prepend("<option value=''>" + 'Select Asset Details' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.asset_id.length - 1; r++) { 
                        var selected = "";
                        if(response['asset_id'][r] == asset_detailsEdit)
                        {
                            selected = "selected";
                        }
                        $('#asset_details').append("<option value='" + response['asset_id'][r] + "' "+selected+">" + response['asset_name'][r]+' - '+response['asset_classification'][r] + "</option>");
                    }

                }
            });
        }

        function editChecklist(company_id){ 

            var maintenance_checklist_id = $("#maintenance_checklist_idEdit").val();
            var maintenance_checklist_ref_id = $("#maintenance_checklist_ref_idEdit").val();
            var checklist = $("#checklistEdit").val();
            var pm_checklist_id = $("#pm_checklist_idEdit").val();
            var bm_checklist_id = $("#bm_checklist_idEdit").val();

            if(checklist.length != ''){
                $.ajax({
                    url:"maintenanceChecklistFile/ajaxGetPMBMChecklistDetailsView.php",
                    method:"post",
                    data:{ "maintenance_checklist_id":maintenance_checklist_id, "maintenance_checklist_ref_id":maintenance_checklist_ref_id, 
                        "company_id":company_id, "checklist":checklist, "pm_checklist_id":pm_checklist_id, "bm_checklist_id":bm_checklist_id  
                    },
                    success:function(html){
                        $("#checklistAppend").empty();
                        $("#checklistAppend").html(html);
                    }
                });
            }
        }
    </script>
<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Maintenance Checklist</li>
    </ol>
    <?php if($dashupd<=0){ ?>
        <a href="edit_maintenance_checklist">
            <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
        </a>
    <?php } ?>
</div>
<!-- Page header end -->

<!-- Main container start -->
<?php if($dashupd>0){ ?>
    <div class="main-container">
        <!--form start-->
        <form id="maintenance_checklist" name="maintenance_checklist" action="" method="post" enctype="multipart/form-data"> 
            <input type="hidden" class="form-control" value="<?php if(isset($maintenance_checklist_id)) echo $maintenance_checklist_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
            <!-- Row start -->
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-12 "> 
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Company Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                    <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id" >
                                                        <option value="">Select Company Name</option>   
                                                            <?php if (sizeof($companyName)>0) { 
                                                            for($j=0;$j<count($companyName);$j++) { ?>
                                                            <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { 
                                                                if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id']) echo 'selected'; } ?> 
                                                                value="<?php echo $companyName[$j]['company_id']; ?>">
                                                            <?php echo $companyName[$j]['company_name'];?></option>
                                                            <?php }} ?>  
                                                    </select>  
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id"  >
                                                        <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                    </select> 
                                                <?php } ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Branch Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                    <select disabled tabindex="2" type="text" class="form-control" id="branch_id" name="branch_id" >
                                                        <option value="" disabled selected>Select Branch Name</option> 
                                                    </select> 
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >
                                                    <select disabled tabindex="2" type="text" class="form-control" id="branch_id1" name="branch_id1" >
                                                        <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                    </select> 
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Date Of Inspection</label>
                                                <input readonly type="date" tabindex="3" name="doi" id="doi" placeholder="From" class="form-control"  value="<?php if (isset($date_of_inspection)) echo $date_of_inspection;?>">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Asset Details</label>
                                                <select disabled id="asset_details" name="asset_details" class="form-control" tabindex="5">
                                                    <option value="">Select Asset Details</option>
                                                </select> 
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Calendar</label>
                                                <select tabindex="9" type="text" class="form-control calendar" id="calendar" name="calendar" >
                                                    <option value=''>Select Calendar</option>
                                                    <option <?php if(isset($calendar)) { if('Yes' == $calendar) echo 'selected';  ?> value="<?php echo 'Yes' ?>">
                                                    <?php echo 'Yes'; } else { ?> <option value="Yes">Yes</option>   <?php } ?></option>
                                                    <option <?php if(isset($calendar)) { if('No' == $calendar) echo 'selected';  ?> value="<?php echo 'No' ?>">
                                                    <?php echo 'No'; } else { ?> <option value="No">No</option> <?php } ?></option> 
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="from_date">Start Date & End Date</label>
                                                <div class="form-inline">
                                                    <input readonly type="date" tabindex="8" name="from_date" id="from_date" class="form-control" value="<?php if(isset($from_date)) { if($calendar == 'Yes') { echo $from_date; } else { echo ""; } } ?>" >&nbsp;&nbsp;
                                                    <span>To</span>&nbsp;&nbsp;<input readonly type="date" tabindex = "9" name="to_date" id="to_date" class="form-control" value="<?php if(isset($to_date)) { if($calendar == 'Yes') { echo $to_date; } else { echo ""; } } ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Role 1</label> <span style="color:green;font-weight: bold;">* Who is doing tha inspection </span>
                                                <select id="role1" name="role1" class="form-control" tabindex="7">
                                                    <option value="">Select Role 1</option>
                                                </select> 
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Role 2</label> <span style="color:green;font-weight: bold;">* Who is responding that maintenance activity </span>
                                                <select id="role2" name="role2" class="form-control" tabindex="7">
                                                    <option value="">Select Role 2</option>
                                                </select> 
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Checklist</label>
                                                <select disabled id="checklist" name="checklist" class="form-control" tabindex="6">
                                                    <option value="">Select Checklist</option>
                                                    <option <?php if(isset($checklist)) { if('pm_checklist' == $checklist) echo 'selected';  ?> value="<?php echo 'pm_checklist' ?>">
                                                    <?php echo 'PM Checklist'; }else{ ?> <option value="pm_checklist">PM Checklist</option> <?php } ?></option>
                                                    <option <?php if(isset($checklist)) { if('bm_checklist' == $checklist) echo 'selected';  ?> value="<?php echo 'bm_checklist' ?>">
                                                    <?php echo 'BM Checklist'; }else{ ?> <option value="bm_checklist">BM Checklist</option> <?php } ?></option> 
                                                </select> 
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div id="checklistAppend"></div>

                            <div class="col-md-12">
                                <br><br>
                                <div class="text-right">
                                    <button type="button" name="submitMaintenanceChecklisDashboardtBtn" id="submitMaintenanceChecklisDashboardtBtn" class="btn btn-primary" tabindex="8">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" tabindex="9">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php } else if($view>0){ ?>
    <div class="main-container">
        <!--form start-->
        <form id="maintenance_checklist" name="maintenance_checklist" action="" method="post" enctype="multipart/form-data"> 
            <input type="hidden" class="form-control" value="<?php if(isset($maintenance_checklist_id)) echo $maintenance_checklist_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
            <!-- Row start -->
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-12 "> 
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Company Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                    <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id" >
                                                        <option value="">Select Company Name</option>   
                                                            <?php if (sizeof($companyName)>0) { 
                                                            for($j=0;$j<count($companyName);$j++) { ?>
                                                            <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { 
                                                                if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id']) echo 'selected'; } ?> 
                                                                value="<?php echo $companyName[$j]['company_id']; ?>">
                                                            <?php echo $companyName[$j]['company_name'];?></option>
                                                            <?php }} ?>  
                                                    </select>  
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id"  >
                                                        <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                    </select> 
                                                <?php } ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Branch Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                    <select disabled tabindex="2" type="text" class="form-control" id="branch_id" name="branch_id" >
                                                        <option value="" disabled selected>Select Branch Name</option> 
                                                    </select> 
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >
                                                    <select disabled tabindex="2" type="text" class="form-control" id="branch_id1" name="branch_id1" >
                                                        <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                    </select> 
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Date Of Inspection</label>
                                                <input readonly type="date" tabindex="3" name="doi" id="doi" placeholder="From" class="form-control"  value="<?php if (isset($date_of_inspection)) echo $date_of_inspection;?>">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Asset Details</label>
                                                <select disabled id="asset_details" name="asset_details" class="form-control" tabindex="5">
                                                    <option value="">Select Asset Details</option>
                                                </select> 
                                            </div>
                                        </div>
                                   

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Calendar</label>
                                                <select disabled tabindex="9" type="text" class="form-control calendar" id="calendar" name="calendar" >
                                                    <option value=''>Select Calendar</option>
                                                    <option <?php if(isset($calendar)) { if('Yes' == $calendar) echo 'selected';  ?> value="<?php echo 'Yes' ?>">
                                                    <?php echo 'Yes'; } else { ?> <option value="Yes">Yes</option>   <?php } ?></option>
                                                    <option <?php if(isset($calendar)) { if('No' == $calendar) echo 'selected';  ?> value="<?php echo 'No' ?>">
                                                    <?php echo 'No'; } else { ?> <option value="No">No</option> <?php } ?></option> 
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="from_date">Start Date & End Date</label>
                                                <div class="form-inline">
                                                <input readonly type="date" tabindex="8" name="from_date" id="from_date" class="form-control" value="<?php if(isset($from_date)) { if($calendar == 'Yes') { echo $from_date; } else { echo ""; } } ?>" >&nbsp;&nbsp;
                                                    <span>To</span>&nbsp;&nbsp;<input readonly type="date" tabindex = "9" name="to_date" id="to_date" class="form-control" value="<?php if(isset($to_date)) { if($calendar == 'Yes') { echo $to_date; } else { echo ""; } } ?>" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Role 1</label> <span style="color:green;font-weight: bold;">* Who is doing tha inspection </span>
                                                <select disabled id="role1" name="role1" class="form-control" tabindex="7">
                                                    <option value="">Select Role 1</option>
                                                </select> 
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Role 2</label> <span style="color:green;font-weight: bold;">* Who is responding that maintenance activity </span>
                                                <select disabled id="role2" name="role2" class="form-control" tabindex="7">
                                                    <option value="">Select Role 2</option>
                                                </select> 
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Checklist</label>
                                                <select disabled id="checklist" name="checklist" class="form-control" tabindex="6">
                                                    <option value="">Select Checklist</option>
                                                    <option <?php if(isset($checklist)) { if('pm_checklist' == $checklist) echo 'selected';  ?> value="<?php echo 'pm_checklist' ?>">
                                                    <?php echo 'PM Checklist'; }else{ ?> <option value="pm_checklist">PM Checklist</option> <?php } ?></option>
                                                    <option <?php if(isset($checklist)) { if('bm_checklist' == $checklist) echo 'selected';  ?> value="<?php echo 'bm_checklist' ?>">
                                                    <?php echo 'BM Checklist'; }else{ ?> <option value="bm_checklist">BM Checklist</option> <?php } ?></option> 
                                                </select> 
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div id="checklistAppend"></div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<?php } else { ?>

    <?php if($idupd<=0){ ?>
        <script language='javascript'> 
            window.onload=getdesignation; 
            
            //get designation details
            function getdesignation(){
                var company_id = $("#branch_id").val();

                if(company_id.length==''){
                    $("#branch_id").val('');
                }else{
                    $.ajax({
                        url: 'maintenanceChecklistFile/ajaxGetDesignationDepartment.php',
                        type: 'post',
                        data: { "company_id":company_id },
                        dataType: 'json',
                        success:function(response){ 

                            $('#role1').empty();
                            $('#role1').prepend("<option value=''>" + 'Select Role 1' + "</option>");
                            var r = 0;
                            for (r = 0; r <= response.designation_id.length - 1; r++) { 
                                $('#role1').append("<option value='" + response['designation_id'][r] + "'>" + response['designation_name'][r]+ "</option>");
                            }

                            $('#role2').empty();
                            $('#role2').prepend("<option value=''>" + 'Select Role 2' + "</option>");
                            var r = 0;
                            for (r = 0; r <= response.designation_id.length - 1; r++) { 
                                $('#role2').append("<option value='" + response['designation_id'][r] + "'>" + response['designation_name'][r]+ "</option>");
                            }

                            $('#asset_details').empty();
                            $('#asset_details').prepend("<option value=''>" + 'Select Asset Details' + "</option>");
                            var r = 0;
                            for (r = 0; r <= response.asset_id.length - 1; r++) { 
                                $('#asset_details').append("<option value='" + response['asset_id'][r] + "'>" + response['asset_name'][r]+' - '+response['asset_classification'][r] + "</option>");
                            }
                        }
                    });
                }
            }
        </script>
    <?php } ?>

    <div class="main-container">
        <!--form start-->
        <form id="maintenance_checklist" name="maintenance_checklist" action="" method="post" enctype="multipart/form-data"> 
            <input type="hidden" class="form-control" value="<?php if(isset($maintenance_checklist_id)) echo $maintenance_checklist_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
            <!-- Row start -->
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-12 "> 
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Company Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                    <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id" >
                                                        <option value="">Select Company Name</option>   
                                                            <?php if (sizeof($companyName)>0) { 
                                                            for($j=0;$j<count($companyName);$j++) { ?>
                                                            <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { 
                                                                if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id']) echo 'selected'; } ?> 
                                                                value="<?php echo $companyName[$j]['company_id']; ?>">
                                                            <?php echo $companyName[$j]['company_name'];?></option>
                                                            <?php }} ?>  
                                                    </select>  
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id"  >
                                                        <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                    </select> 
                                                    <?php } ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Branch Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                    <select tabindex="2" type="text" class="form-control" id="branch_id" name="branch_id" >
                                                        <option value="" disabled selected>Select Branch Name</option> 
                                                    </select> 
                                                    <?php } else if($sbranch_id != 'Overall'){ ?>
                                                        <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >
                                                    <select disabled tabindex="2" type="text" class="form-control" id="branch_id1" name="branch_id1" >
                                                        <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                    </select> 
                                                <?php } ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Date Of Inspection</label>
                                                <input type="date" tabindex="3" name="doi" id="doi" placeholder="From" class="form-control"  value="<?php if (isset($date_of_inspection)) echo $date_of_inspection;?>">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Asset Details</label>
                                                <select id="asset_details" name="asset_details" class="form-control" tabindex="5">
                                                    <option value="">Select Asset Details</option>
                                                </select> 
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Calendar</label>
                                                <select tabindex="9" type="text" class="form-control calendar" id="calendar" name="calendar" >
                                                    <option value=''>Select Calendar</option>
                                                    <option <?php if(isset($calendar)) { if('Yes' == $calendar) echo 'selected';  ?> value="<?php echo 'Yes' ?>">
                                                    <?php echo 'Yes'; } else { ?> <option value="Yes">Yes</option>   <?php } ?></option>
                                                    <option <?php if(isset($calendar)) { if('No' == $calendar) echo 'selected';  ?> value="<?php echo 'No' ?>">
                                                        <?php echo 'No'; } else { ?> <option value="No">No</option> <?php } ?></option> 
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="from_date">Start Date & End Date</label>
                                                    <div class="form-inline">
                                                        <input readonly type="date" tabindex="8" name="from_date" id="from_date" class="form-control" value="<?php if(isset($from_date)) { if($calendar == 'Yes') { echo $from_date; } else { echo ""; } } ?>" > &nbsp;&nbsp;
                                                        <span>To</span>&nbsp;&nbsp; <input readonly type="date" tabindex = "9" name="to_date" id="to_date" class="form-control" value="<?php if(isset($to_date)) { if($calendar == 'Yes') { echo $to_date; } else { echo ""; } } ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                    

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Role 1</label> <span style="color:green;font-weight: bold;">* Who is doing tha inspection </span>
                                                <select id="role1" name="role1" class="form-control" tabindex="7">
                                                    <option value="">Select Role 1</option>
                                                </select> 
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Role 2</label> <span style="color:green;font-weight: bold;">* Who is responding that maintenance activity </span>
                                                <select id="role2" name="role2" class="form-control" tabindex="7">
                                                    <option value="">Select Role 2</option>
                                                </select> 
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Checklist</label>
                                                <select id="checklist" name="checklist" class="form-control" tabindex="6">
                                                    <option value="">Select Checklist</option>
                                                    <option <?php if(isset($checklist)) { if('pm_checklist' == $checklist) echo 'selected';  ?> value="<?php echo 'pm_checklist' ?>">
                                                    <?php echo 'PM Checklist'; }else{ ?> <option value="pm_checklist">PM Checklist</option> <?php } ?></option>
                                                    <option <?php if(isset($checklist)) { if('bm_checklist' == $checklist) echo 'selected';  ?> value="<?php echo 'bm_checklist' ?>">
                                                    <?php echo 'BM Checklist'; }else{ ?> <option value="bm_checklist">BM Checklist</option> <?php } ?></option> 
                                                </select> 
                                            </div>
                                        </div>

                                        <?php if($idupd<=0){ ?>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" style="margin-top: 19px;">
                                                <div class="form-group">
                                                    <button type="button" tabindex="8" class="btn btn-primary" id="executeBtn" name="executeBtn" data-toggle="modal" style="padding: 5px 35px;">Execute</button>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                            <div id="checklistAppend"></div>

                            <div class="col-md-12">
                                <br><br>
                                <div class="text-right">
                                    <button type="button" name="submitMaintenanceChecklistBtn" id="submitMaintenanceChecklistBtn" class="btn btn-primary" tabindex="12">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" tabindex="13">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<?php } ?>

