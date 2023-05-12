<?php 
date_default_timezone_set('Asia/Calcutta');
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
$companyName = $userObj->getCompanyName($mysqli);

$id=0;
 if(isset($_POST['submitholiday_creation']) && $_POST['submitholiday_creation'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateHolidayCreationmaster = $userObj->updateHolidayCreation($mysqli,$id,$userid);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_holiday_creation&msc=2';</script> 
    <?php	}
    else{   
		$addHolidayCreation = $userObj->addHolidayCreation($mysqli,$userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_holiday_creation&msc=1';</script>
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
	$deleteHolidayCreation = $userObj->deleteHolidayCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_holiday_creation&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getHolidayCreation = $userObj->getHolidayCreation($mysqli,$idupd); 
	
	if (sizeof($getHolidayCreation)>0) {
        for($iholiday=0;$iholiday<sizeof($getHolidayCreation);$iholiday++)  {

            $holiday_ref_id                  = $getHolidayCreation['holiday_ref_id']; 
			$calendar_year                	 = $getHolidayCreation['calendar_year'];
            $company_id                	     = $getHolidayCreation['company_id'];

            $holiday_id                      = $getHolidayCreation['holiday_id'];
			$holiday_date		             = $getHolidayCreation['holiday_date'];
			$holiday_description    	     = $getHolidayCreation['holiday_description'];
	
		}
	}
}

$companyArr = explode(",", $company_id);
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Holiday Creation </li>
    </ol>

    <a href="edit_holiday_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
    </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "holiday_creation" name="holiday_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($holiday_id)) echo $holiday_id ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                                            <label for="disabledInput">Calendar Year</label>
                                            <select readonly type="text" class="form-control" id="calendar_year" name="calendar_year">
                                            <!-- <option value="">Select Calendar Year</option>  -->
                                            <?php
                                                $date2=date('Y', strtotime('+1 Years'));
                                                for($i=date('Y'); $i<$date2;$i++){
                                                    echo '<option value='.$i.'-'.($i+1).'>'.$i.'-'.($i+1).'</option>';
                                                }
                                            ?> 
                                             </select>                                           
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id[]" multiple >
                                                <?php if (sizeof($companyName)>0) { 
                                                    for($j=0;$j<count($companyName);$j++) { ?>
                                                        <option <?php  
                                                            if (isset($companyArr)) {
                                                                for ($i=0; $i < count($companyArr); $i++){
                                                                    if($companyName[$j]['company_id'] == $companyArr[$i] ) echo "selected"; 
                                                                }
                                                            }
                                                            ?> value="<?php echo $companyName[$j]['company_id']; ?>"> <?php echo $companyName[$j]['company_name']; ?>
                                                        </option>
                                                <?php }} ?>  
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"></div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Holiday Date</label>
                                            <input type="date" tabindex="2" id="holiday_date" name="holiday_date" class="form-control"  value="<?php if(isset($holiday_date)) echo $holiday_date; ?>" placeholder="Enter Address 1">
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Holiday Description</label>
                                            <textarea class="form-control" tabindex="3" id="holiday_description" name="holiday_description" 
                                            value="<?php if(isset($holiday_description)) echo $holiday_description; ?>" placeholder="Enter Holiday Descriptionn"></textarea>
                                
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" style="margin-top: 35px;">
                                        <div class="form-group">
                                        <label class="label" style="visibility: hidden;">Add</label>
                                        <button type="button" tabindex="4" class="btn btn-primary" id="add_holidayDetails" name="add_holidayDetails" style="padding: 7px 35px;">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-header">AS - Holiday Creation List</div><hr>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card-body row">
                                <label><span class="text-danger" id="holidaytableCheck">Enter Atleast One Year</span></label>
                                <table id="holidayTable" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Holiday Date</th>
                                            <th>Holiday Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($idupd > 0){ 
                                        
                                            if(isset($holiday_ref_id)){ 

                                                for($tab=0; $tab<=sizeof($holiday_ref_id)-1; $tab++){ 
                                                    
                                                    if($holiday_ref_id[$tab] != ''){ ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" readonly name="holiday_date[]" id="holiday_date" class="form-control" value="<?php echo $holiday_date[$tab]; ?>" >
                                                            </td>
                                                            <td>
                                                                <input type="text" readonly name="holiday_description[]" id="holiday_description" class="form-control" value="<?php echo $holiday_description[$tab]; ?>" >
                                                            </td>
                                                            <td>
                                                                <span onclick='onDelete(this);' class='icon-trash-2'></span>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } 
                                            } 
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submitholiday_creation" id="submitholiday_creation" class="btn btn-primary" value="Submit" tabindex="5">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="6">Cancel</button>
                            </div>
                        </div>

                    </div>
                            
                </div>
            </div>
        </div>
    </form>
</div>



