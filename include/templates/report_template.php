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

$id=0;
 if(isset($_POST['submitreport_template']) && $_POST['submitreport_template'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateCompanyCreationmaster = $userObj->updateReportCreation($mysqli,$id);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>report_template&msc=2';</script> 
    <?php	}
    else{   
		$addCompanyCreation = $userObj->addReportCreation($mysqli);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>report_template&msc=1';</script>
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
	$deleteCompanyCreation = $userObj->deleteReportTemplate($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>report_template&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getReportList = $userObj->getReportCreation($mysqli,$idupd); 
	
	if (sizeof($getReportList)>0) {
        for($ireport=0;$ireport<sizeof($getReportList);$ireport++)  {	
            $report_id                      = $getReportList['report_id'];
			$report_name                	 = $getReportList['report_name'];
			$company_id          		 = $getReportList['company_id'];
			// $company_name      			    = $getReportList['company_name']; 
			$report_file		             = $getReportList['report_file'];
		}
	}

    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    ?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_id); ?>" >
    <script>
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
        <li class="breadcrumb-item">AS - Report Template </li>
    </ol>
    <?php if(isset($report_id)){?>
    <a href="report_template">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
   <?php }?>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "report_creation" name="report_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($report_id)) echo $report_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">

 		<!-- Row start -->
         <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">General Info</div> -->
					</div>
                    <div class="card-body">
                        <div class="row ">
                            <!--Fields -->
                           <div class="col-md-12 "> 
                              <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="company" name="company">
                                                    <option value="">Select Company Name</option>   
                                                        <?php if (sizeof($companyName)>0) { 
                                                        for($j=0;$j<count($companyName);$j++) { ?>
                                                        <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id'])  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                        <?php echo $companyName[$j]['company_name'];?></option>
                                                        <?php }} ?>  
                                                </select>  
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <input type="hidden" id="company" name="company" value="<?php echo $sCompanyBranchDetail['company_id']; ?>">
                                                <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $sCompanyBranchDetail['company_name']; ?>" readonly>
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

                                    
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Report Template</label>
                                            <input tabindex="3" type="text" class="form-control" id="report_name" name="report_name" placeholder="Enter Report Name"
                                            value="<?php if(isset($report_name)) echo $report_name;?>"> 
                                            </input>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Report File</label>
                                            <?php if(!isset($report_file) && $idupd<=0){ ?>
                                                <input type="file" tabindex="4" class="form-control" id="report_file" name="report_file" ></input>   
                                                
                                            <?php }else{?>
                                                <input type="file" tabindex="4" class="form-control " id="report_file" name="report_file" ></input>   
                                                <input type="hidden" name="editreportfile" id="editreportfile" value="<?php echo $report_file; ?>">
                                            <?php }?>
                                        </div>
                                    </div>
                            
                                

                            
                            </div>  
                        </div>
                            <div class="col-md-12">
                                <br><br>
                                <div class="text-right">
                                    <button type="submit" name="submitreport_template" id="submitreport_template" class="btn btn-primary" value="Submit" tabindex="5">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" tabindex="6" id='reset'>Cancel</button>
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-container">
                        <div class="table-responsive">
                            <?php
                            $mscid=0;
                            if(isset($_GET['msc']))
                            {
                            $mscid=$_GET['msc'];
                            if($mscid==1)
                            {?>
                            <div class="alert alert-success" role="alert">
                                <div class="alert-text">Report Added Successfully!</div>
                            </div> 
                            <?php
                            }
                            if($mscid==2)
                            {?>
                                <div class="alert alert-success" role="alert">
                                <div class="alert-text">Report Updated Successfully!</div>
                            </div>
                            <?php
                            }
                            if($mscid==3)
                            {?>
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-text">Report Inactive Successfully!</div>
                            </div>
                            <?php
                            }
                            }
                            ?>
                            <table id="reportTable" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Company Name</th>
                                        <th>Report Name</th>
                                        <th>Report File</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    </form>
</div>


<script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);
</script>