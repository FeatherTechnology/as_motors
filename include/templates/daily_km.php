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




// $id=0;
// if(isset($_POST['submitDailyKMBtn']) && $_POST['submitDailyKMBtn'] != '')
// {
//     if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){     
//         $id = $_POST['id'];     
        ?>
        <!-- <script>location.href='<?php echo $HOSTPATH; ?>edit_daily_km&msc=2';</script>  -->
        <?php   
    // }
    // else{   
        ?>
        <!-- <script>location.href='<?php echo $HOSTPATH; ?>edit_daily_km&msc=1';</script> -->
        <?php
//     }
// }  
 

$del=0;
if(isset($_GET['del']))
{
    $del=$_GET['del'];
}
if($del>0)
{
	$deleteDailyKM = $userObj->deleteDailyKM($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_daily_km&msc=3';</script>
    <?php	
}

if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getDailyKM = $userObj->getDailyKM($mysqli,$idupd); 
	if (sizeof($getDailyKM)>0) {
        for($itag=0;$itag<sizeof($getDailyKM);$itag++) {
            $daily_km_id             = $getDailyKM['daily_km_id']; 
            $company_id              = $getDailyKM['company_id'];
			$date        	         = $getDailyKM['date'];
			$daily_km_ref_id    	 = $getDailyKM['daily_km_ref_id'];
			$vehicle_details_id    	 = $getDailyKM['vehicle_details_id'];
			$vehicle_number    	     = $getDailyKM['vehicle_number'];
			$start_km    	         = $getDailyKM['start_km'];
			$end_km    	             = $getDailyKM['end_km'];
		}
	} 

    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    ?>

    <input type="hidden" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="daily_km_idEdit" name="daily_km_idEdit" value="<?php print_r($daily_km_id); ?>" >

    <script language='javascript'>
        window.onload=editCompanyBasedBranch;
        // company based branch
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
            
            editVehicleKM(branch_id)
        }
        
        function editVehicleKM(branch_id){  
            
            var daily_km_id = $("#daily_km_idEdit").val(); 
            $.ajax({
                url:"vehicledetailsFile/ajaxGetAllVehicleDetailsEdit.php",
                method:"post",
                data:{ 'daily_km_id': daily_km_id },
                success:function(html){
                    $("#vehicleListAppend").empty();
                    $("#vehicleListAppend").html(html);
                }
            }).then(function(){
                //Check Start KM is greater than previous end KM.
                $('.validate_start_km').change(function(){
                    var previousKM = ($(this).attr('data-id')) ? parseInt($(this).attr('data-id')) : 0 ;
                    var startkm = ($(this).val()) ? parseInt($(this).val()) : 0 ;

                    if(startkm < previousKM){
                        alert('Please Enter Start KM higher than Previous End KM')
                        $(this).val('');
                    }

                })

                $('.validate_end_km').change(function(){
                    var start_km =  $(this).parents('tr').find('td #start_km').val();
                    var startkilometer = (start_km) ? parseInt(start_km) : 0 ;
                    var endkilometer = ($(this).val()) ? parseInt($(this).val()) : 0 ;

                    if(endkilometer < startkilometer){
                        alert('Please Enter End KM higher than Start KM')
                        $(this).val('');
                    }

                })
            }) //then end
        }

    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Daily KM</li>
    </ol>
    <a href="edit_daily_km">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "daily_km" name="daily_km" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($daily_km_id)) echo $daily_km_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
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

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Date</label>
                                            <input readonly type="date" name="date" id="date" placeholder="From" class="form-control" value="<?php if(isset($date)) echo $date; else echo date('Y-m-d'); ?>" >
                                        </div>
                                    </div>

                                    <?php if($idupd<=0){ ?>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" style="margin-top: 19px;">
                                            <div class="form-group">
                                                <button tabindex="3" type="button" class="btn btn-primary" id="displayAllVehicleBtn" name="displayAllVehicleBtn" data-toggle="modal" style="padding: 5px 35px;">Display All Vehicle</button>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>

                        <div id="vehicleListAppend"></div>

                        <div class="col-md-12">
                            <div class="text-right">
                                <button type="submit" name="submitDailyKMBtn" id="submitDailyKMBtn" class="btn btn-primary" value="Submit" tabindex="7">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="8">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
