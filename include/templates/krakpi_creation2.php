<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
}

$companyName = $userObj->getCompanyName($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$designationList = $userObj->getDesignation($mysqli);

$id=0;
if(isset($_POST['submitKraKpiCreation']) && $_POST['submitKraKpiCreation'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){     
        $id = $_POST['id'];     
        $updateKraKpiCreation = $userObj->updateKraKpiCreation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_krakpi_creation&msc=2';</script> 
        <?php   
    }
    else{   
        $addKraKpiCreation = $userObj->addKraKpiCreation($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_krakpi_creation&msc=1';</script>
        <?php
    }
}  
 
$del=0;
if(isset($_GET['del']))
{
    $del=$_GET['del'];
}
if($del>0)
{
    $deleteKraKpiCreation = $userObj->deleteKraKpiCreation($mysqli,$del,$userid); 
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>edit_krakpi_creation&msc=3';</script>
    <?php   
}
if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}

if($idupd>0)
{
    $getKraKpiCreation = $userObj->getKraKpiCreation($mysqli,$idupd); 
    
    if(sizeof($getKraKpiCreation)>0) {
        for($ibranch=0;$ibranch<sizeof($getKraKpiCreation);$ibranch++)  {  

            $krakpi_id                = $getKraKpiCreation['krakpi_id'];
            $company_name         = $getKraKpiCreation['company_name'];
            $department           = $getKraKpiCreation['department']; 
			$designation	      = $getKraKpiCreation['designation']; 

            $krakpi_ref_id            = $getKraKpiCreation['krakpi_ref_id'];
			$rr                   = $getKraKpiCreation['rr'];	
			$frequency            = $getKraKpiCreation['frequency'];
            $applicability        = $getKraKpiCreation['applicability']; 
            $code_ref             = $getKraKpiCreation['code_ref']; 
            $kra_category             = $getKraKpiCreation['kra_category']; 
            $kpi             = $getKraKpiCreation['kpi']; 
        }
    }

    // foreach($department as $dept)

    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_name);
    $kraCategory = $userObj->kraCategoryDepartmentBased($mysqli, $company_name, $department);
    $rrList = $userObj->getRNRDepartmentBased($mysqli, $company_name, $department);

    $editDepartment = $userObj->getEditDepartment($mysqli, $company_name);
    $editDesignation = $userObj->getEditDesignationKRAKPI($mysqli, $department);

    ?>

    <input type="hidden" id="designationEdit" name="designationEdit" value="<?php print_r($designation); ?>" >
    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_name); ?>" >
    <input type="hidden" id="kra_id_Edit" name="kra_id_Edit" class="form-control" value="<?php if(isset($kra_category)) echo (implode(',',$kra_category)); ?>"  aria-describedby="id" >
    <input type="hidden" id="rr_id_Edit" name="rr_id_Edit" class="form-control" value="<?php if(isset($rr)) echo (implode(',',$rr)); ?>"  aria-describedby="id" >

    <script language='javascript'>
        window.onload=editCompanyBasedBranch;

        function editCompanyBasedBranch(){  
            var branch_id = $('#company_nameEdit').val();
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
        }
    </script>
    
<?php
}
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - KRA & KPI Creation</li>
    </ol>

    <a href="edit_krakpi_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
            <!--------form start-->
    <form id = "create_ticket" name="create_ticket" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($krakpi_id)) echo $krakpi_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id" >
        <input type="hidden" class="form-control" value="<?php if(isset($company_name)) echo $company_name; ?>"  id="company_id_upd" name="company_id_upd" aria-describedby="id" placeholder="Enter id" >
        <input type="hidden" class="form-control" value="<?php if(isset($department)) echo $department; ?>"  id="department_upd" name="department_upd" aria-describedby="id" >
        <input type="hidden" class="form-control" value="<?php if(isset($designation)) echo $designation; ?>"  id="designation_upd" name="designation_upd" aria-describedby="id" >
        <input type="hidden" class="form-control" value="<?php if(isset($kra_category)) echo (implode(',',$kra_category)); ?>"  id="kra_id_upd" name="kra_id_upd" aria-describedby="id" >
        <input type="hidden" class="form-control" value="<?php if(isset($rr)) echo (implode(',',$rr)); ?>"  id="rr_id_upd" name="rr_id_upd" aria-describedby="id" >
 		<!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12">
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">General Info</div> -->
					</div>
                    <div class="card-header">KRA & KPI Info<span class="required">*</span></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">   
                                    <label for="disabledInput">Company</label>   
                                    <?php if($sbranch_id == 'Overall'){ ?>
                                        <select tabindex="1" type="text" class="form-control" id="company_name" name="company_name" >
                                            <option value="">Select Company Name</option>   
                                                <?php if (sizeof($companyName)>0) { 
                                                for($j=0;$j<count($companyName);$j++) { ?>
                                                <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id'])  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                <?php echo $companyName[$j]['company_name'];?></option>
                                                <?php }} ?>  
                                        </select>  
                                    <?php } else if($sbranch_id != 'Overall'){ ?>
                                        <select disabled tabindex="1" type="text" class="form-control" id="company_name" name="company_name"  >
                                            <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                        </select> 
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
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

                            <!-- <div class="col-md-4"></div> -->

                            <?php if($idupd<=0){ ?>

                                <script language='javascript'> 
                                    window.onload=getdepartmentLoad; 
                                    
                                    // get department details
                                    function getdepartmentLoad(){ 
                                      var department_upd = $('#department_upd').val();
                                      $.ajax({
                                        url: 'KRA&KPIFile/ajaxKra&KpiDepartmentDetailsLoad.php',
                                        type: 'post',
                                        data: {},
                                        dataType: 'json',
                                        success:function(response){ 

                                          $('#department').empty();
                                          $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
                                          var r = 0;
                                          for (r = 0; r <= response.department_id.length - 1; r++) { 
                                            var selected = "";
                                            if(department_upd == response['department_id'][r]){
                                              selected = "selected";
                                            }
                                            $('#department').append("<option value='" + response['department_id'][r] + "' "+selected+">" + response['department_name'][r] + "</option>");
                                          }
                                        }
                                      });
                                      
                                      getrrdropdownLoad();
                                    }
                                </script>

                                
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Department</label>
                                        <select tabindex="3" type="text" class="form-control" id="department" name="department" >
                                            <option value="">Select Department</option>   
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($idupd>0){ ?>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Department</label>
                                        <select tabindex="3" type="text" class="form-control" id="department" name="department" >
                                            <option value="">Select Department</option>
                                            <?php if (sizeof($editDepartment)>0) { 
                                            for($j=0;$j<count($editDepartment);$j++) { ?>
                                            <option <?php if(isset($department)) { if($editDepartment[$j]['department_id'] == $department)  echo 'selected'; }  ?>
                                            value="<?php echo $editDepartment[$j]['department_id']; ?>">
                                            <?php echo $editDepartment[$j]['department_name'];?></option>
                                            <?php }} ?> 
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if($idupd<=0){ ?>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Designation</label>
                                        <select tabindex="4" type="text" class="form-control" id="designation" name="designation" >
                                                <option value="">Select Designation</option>   
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($idupd>0){ ?>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Designation</label>
                                        <select tabindex="4" type="text" class="form-control" id="designation" name="designation" >
                                            <option value="">Select Designation</option>   
                                            <?php if (sizeof($editDesignation)>0) { 
                                            for($j=0;$j<count($editDesignation);$j++) { ?>
                                            <option <?php if(isset($designation)) { if($editDesignation[$j]['designation_id'] == $designation) echo 'selected'; } ?>
                                            value="<?php echo $editDesignation[$j]['designation_id']; ?>">
                                            <?php echo $editDesignation[$j]['designation_name'];?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    <br><br>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="moduleTable" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>KRA Category</th>
                                        <th>R & R</th>
                                        <th>KPI</th>
                                        <th>Applicability</th>
                                        <th>Frequency</th>
                                        <th>Code Ref</th>
                                        <th></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php if($idupd<=0){ ?>

                                    <script language='javascript'> 
                                        
                                        // get rr dropdown based on company name
                                        function getrrdropdownLoad(){ 
                                            var rr_id_upd = $('#rr_id_upd').val();
                                        
                                            $.ajax({
                                                url: 'KRA&KPIFile/ajaxRRDetailsLoad.php',
                                                type: 'post',
                                                data: {},
                                                dataType: 'json',
                                                success:function(response){
                                                
                                                $('#rr').empty();
                                                $('#rr').prepend("<option value=''>" + 'Select Roles & Responsibility' + "</option>");
                                                $('#rr').append("<option value='New'>" + 'New' + "</option>");
                                                var i = 0;
                                                for (i = 0; i <= response.rr_ref_id.length - 1; i++) { 
                                                    var selected = "";
                                                    if(rr_id_upd == response['rr_ref_id'][i]){
                                                    selected = "selected";
                                                    }
                                                    $('#rr').append("<option value='" + response['rr_ref_id'][i] + "' "+selected+" >" + response['rr'][i] + "</option>");
                                                }
                                                }
                                            });
                                            
                                            getkradropdownLoad();
                                        }

                                        function getkradropdownLoad(){ 
                                            var kra_id_upd = $('#kra_id_upd').val(); 

                                            $.ajax({
                                                url: 'KRA&KPIFile/ajaxKraDetailsLoad.php',
                                                type: 'post',
                                                data: {},
                                                dataType: 'json',
                                                success:function(response){
                                                
                                                $('#kra_category').empty();
                                                $('#kra_category').prepend("<option value=''>" + 'Select KRA Category' + "</option>");
                                                var i = 0;
                                                for (i = 0; i <= response.kra_creation_ref_id.length - 1; i++) { 
                                                    var selected = "";
                                                    if(kra_id_upd == response['kra_creation_ref_id'][i]){
                                                    selected = "selected";
                                                    }
                                                    $('#kra_category').append("<option value='" + response['kra_creation_ref_id'][i] + "' "+selected+" >" + response['kra_category'][i] + "</option>");
                                                }

                                                }
                                            });
                                        }
                                    </script>

                                    <tbody>
                                        <tr>
                                            <td>
                                                <select tabindex="5" type="text" class="form-control" id="kra_category" name="kra_category[]" >
                                                    <option value="">Select KRA Category</option>   
                                                </select>
                                            </td>
                                            <td>
                                                <select tabindex="6" type="text" class="form-control rr" id="rr" name="rr[]" >
                                                    <option value="">Select Roles & Responsibility</option>   
                                                    <option value="New">New</option>  
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" readonly tabindex="7" name="kpi[]" id="kpi" class="form-control" value="">
                                            </td>
                                            <td>
                                                <select tabindex="8" type="text" class="form-control applicability" id="applicability" name="applicability[]" >
                                                    <option value="">Select Applicability</option>
                                                    <option value="Common">Common</option>
                                                    <option value="Specific">Specific</option>
                                                </select> 
                                            </td>
                                            <td>
                                                <select tabindex="9" type="text" class="form-control frequency" id="frequency" name="frequency[]" >
                                                    <option value=''>Select Frequency</option>
                                                    <option value='Fortnightly'>Fortnightly</option>
                                                    <option value='Monthly'>Monthly</option>
                                                    <option value='Quaterly'>Quaterly</option>
                                                    <option value='Half Yearly'>Half Yearly</option>
                                                    <option value='yearly'>Yearly</option>
                                                    <option value='Event Driven'>Event Driven</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" tabindex="10" name="code_ref[]" id="code_ref" class="form-control" value="">
                                            </td>
                                            <td>
                                                <button type="button" tabindex="11" id="add_product" name="add_product" value="Submit" class="btn btn-primary add_product">Add</button> 
                                            </td>
                                            <td><span class='icon-trash-2' tabindex="12"></span></td>
                                        </tr>
                                    </tbody>
                                <?php } if($idupd>0){
                                        if(isset($rr)){ ?>
                                            <tbody>
                                                <?php for($i=0; $i<=sizeof($rr)-1; $i++) { ?>
                                                    <tr>
                                                        <input type="hidden" name="krakpi_ref_id[]" id="krakpi_ref_id" value="<?php if(isset($krakpi_ref_id)){ echo $krakpi_ref_id[$i]; } ?>">

                                                        <td>
                                                            <select tabindex="5" type="text" class="form-control" id="kra_category" name="kra_category[]" >
                                                                <option value="">Select KRA Category</option> 

                                                                <?php if (sizeof($kraCategory)>0) { 
                                                                for($j=0;$j<count($kraCategory);$j++) { ?>
                                                                <option <?php if(isset($kra_category)) { if($kraCategory[$j]['kra_creation_ref_id'] == $kra_category[$i])  echo 'selected'; }  ?> value="<?php echo $kraCategory[$j]['kra_creation_ref_id']; ?>">
                                                                <?php echo $kraCategory[$j]['kra_category'];?></option>
                                                                <?php }} ?>  
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select tabindex="6" type="text" class="form-control rr" id="rr" name="rr[]" >
                                                                <option value="">Select Roles & Responsibility</option> 

                                                                <!-- <option value="New">New</option>  -->
                                                                <?php if (sizeof($rrList)>0) { 
                                                                    $tt=true;
                                                                    for($j=0;$j<count($rrList);$j++) { 
                                                                    if($rr[$i] == "New" && $tt==true) { echo '<option value="New" selected >New</option>'; $tt=false; }
                                                                    else if($tt==true){echo '<option value="New">New</option>'; $tt=false;} ?>
                                                                    <option <?php if(isset($rr)) { if($rrList[$j]['rr_ref_id'] == $rr[$i])  echo 'selected'; }  ?>
                                                                    value="<?php echo $rrList[$j]['rr_ref_id']; ?>">
                                                                    <?php echo $rrList[$j]['rr'];?></option>
                                                                <?php }} ?>

                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" readonly tabindex="7" name="kpi[]" id="kpi" class="form-control" value="<?php if(isset($kpi)){ echo $kpi[$i]; } ?>">
                                                        </td>
                                                        <td>
                                                            <select tabindex="8" type="text" class="form-control" id="applicability" name="applicability[]" >
                                                            <option <?php if(isset($applicability)) { if('Common' == $applicability[$i]) echo 'selected'; ?> value="<?php echo 'Common' ?>">
                                                            <?php echo 'Common'; }else{ ?> <option value="Common">Common</option> <?php } ?></option>
                                                            <option <?php if(isset($applicability)) { if('Specific' == $applicability[$i]) echo 'selected'; ?> value="<?php echo 'Specific' ?>">
                                                            <?php echo 'Specific'; }else{ ?> <option value="Specific">Specific</option> <?php } ?></option> 
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select tabindex="9" type="text" class="form-control" id="frequency" name="frequency[]" >
                                                            <option <?php if(isset($frequency)) { if('Fortnightly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Fortnightly' ?>">
                                                            <?php echo 'Fortnightly'; }else{ ?> <option value="Fortnightly">Fortnightly</option>   <?php } ?></option>
                                                            <option <?php if(isset($frequency)) { if('Monthly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Monthly' ?>">
                                                            <?php echo 'Monthly'; }else{ ?> <option value="Monthly">Monthly</option> <?php } ?></option> 
                                                            <option <?php if(isset($frequency)) { if('Quaterly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Quaterly' ?>">
                                                            <?php echo 'Quaterly'; }else{ ?> <option value="Quaterly">Quaterly</option> <?php } ?></option> 
                                                            <option <?php if(isset($frequency)) { if('Half Yearly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Half Yearly' ?>">
                                                            <?php echo 'Half Yearly'; }else{ ?> <option value="Half Yearly">Half Yearly</option> <?php } ?></option> 
                                                            <option <?php if(isset($frequency)) { if('yearly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'yearly' ?>">
                                                            <?php echo 'yearly'; }else{ ?> <option value="yearly">yearly</option> <?php } ?></option> 
                                                            <option <?php if(isset($frequency)) { if('Event Driven' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Event Driven' ?>">
                                                            <?php echo 'Event Driven'; }else{ ?> <option value="Event Driven">Event Driven</option> <?php } ?></option> 
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" tabindex="10" name="code_ref[]" id="code_ref" class="form-control" value="<?php if(isset($code_ref)){ echo $code_ref[$i]; } ?>">
                                                        </td>
                                                        <td>
                                                            <button type="button" tabindex="11" id="add_product" name="add_product" value="Submit" class="btn btn-primary add_product">Add</button> 
                                                        </td>
                                                        <td>
                                                            <span class='deleterow icon-trash-2' tabindex="12" id="delete_row"></span>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        <?php }
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="text-right">
                    <button type="submit" tabindex="13"  id="submitKraKpiCreation" name="submitKraKpiCreation" value="Submit" class="btn btn-primary">Save</button>
                    <button type="reset" tabindex="14"  id="cancelbtn" name="cancelbtn" class="btn btn-outline-secondary">Cancel</button><br /><br />
                </div>
            </div>       
        </div>
    </form>
</div>

<script>
    var loadFile = function(event) {
        var image = document.getElementById("viewimage");
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
