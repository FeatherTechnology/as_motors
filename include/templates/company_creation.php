<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 

$id=0;
 if(isset($_POST['submitcompany_creation']) && $_POST['submitcompany_creation'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateCompanyCreationmaster = $userObj->updateCompanyCreation($mysqli,$id,$userid);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_company_creation&msc=2';</script> 
    <?php	}
    else{   
		$addCompanyCreation = $userObj->addCompanyCreation($mysqli,$userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_company_creation&msc=1';</script>
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
	$deleteCompanyCreation = $userObj->deleteCompanyCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_company_creation&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getCompanyCreation = $userObj->getCompanyCreation($mysqli,$idupd); 
	
	if (sizeof($getCompanyCreation)>0) {
        for($ibranch=0;$ibranch<sizeof($getCompanyCreation);$ibranch++)  {	
            $company_id                      = $getCompanyCreation['company_id'];
			$company_name                	 = $getCompanyCreation['company_name'];
			$company_status          		 = $getCompanyCreation['company_status'];
			$cin      			             = $getCompanyCreation['cin'];
			$key_personal		             = $getCompanyCreation['key_personal'];
			$address2    			         = $getCompanyCreation['address2'];
			$address1                	     = $getCompanyCreation['address1'];
            $city                            = $getCompanyCreation['city'];
			$state       		             = $getCompanyCreation['state'];
			$email_id     			         = $getCompanyCreation['email_id'];
			$website     		             = $getCompanyCreation['website'];
			$pan_number     			     = $getCompanyCreation['pan_number'];
			$pf_number     			         = $getCompanyCreation['pf_number'];
            $esi_number     			     = $getCompanyCreation['esi_number'];
            $fax_number     			     = $getCompanyCreation['fax_number'];
            $office_number      			 = $getCompanyCreation['office_number'];
			$tan_number                      = $getCompanyCreation['tan_number'];
            $company_logo                    = $getCompanyCreation['company_logo'];
            
		}
	}
    ?>
    <input type="hidden" id="company_status_edit" name="company_status_edit" value="<?php print_r($company_status); ?>" >
    <script language='javascript'>
            window.onload=editEnableDisable;

            function editEnableDisable(){  
                var company_status = $("#company_status_edit").val();

                if(company_status == 'Partnership' || company_status == 'HUF' || company_status == 'Individual'){ 
                    $('#cin').prop('readonly',true);
                }else if(company_status == 'Public Limited' || company_status == 'Private Limited'){
                    $('#cin').prop('readonly',false);
                }
            }
    </script>

<?php } ?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Company Creation </li>
    </ol>

    <a href="edit_company_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "company_creation" name="company_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($company_id)) echo $company_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                           <div class="col-md-8 "> 
                              <div class="row">
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <input type="text" tabindex="1" id="company_name" name="company_name" class="form-control"  value="<?php if(isset($company_name)) echo $company_name; ?>" placeholder="Enter company Name">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Status</label>
                                            <select tabindex="2" type="text" class="form-control" id="company_status" name="company_status" >
                                                <option value="">Select Company Status</option>   
                                                <option <?php  if(isset($company_status)) { if($company_status == "Public Limited" ) echo 'selected'; }?>  value="Public Limited">Public Limited</option>
                                                <option <?php  if(isset($company_status)) { if($company_status == "Private Limited" ) echo 'selected'; }?>  value="Private Limited">Private Limited</option>
                                                <option <?php  if(isset($company_status)) { if($company_status == "Partnership" ) echo 'selected'; }?>  value="Partnership">Partnership</option>
                                                <option <?php  if(isset($company_status)) { if($company_status == "HUF" ) echo 'selected'; }?>  value="HUF">HUF</option>
                                                <option <?php  if(isset($company_status)) { if($company_status == "Individual" ) echo 'selected'; }?>  value="Individual">Individual</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">CIN</label>
                                            <input readonly type="number" tabindex="3" id="cin" name="cin" class="form-control" 
                                            oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "10" value="<?php if(isset($cin)) echo $cin; ?>" 
                                            placeholder="Enter CIN Number">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Key Personal</label>
                                            <input type="text" tabindex="4" id="key_personal" name="key_personal" class="form-control"  value="<?php if(isset($key_personal)) 
                                            echo $key_personal; ?>" placeholder="Enter Key Personal">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Address 1</label>
                                            <input type="text" tabindex="5" id="address1" name="address1" class="form-control"  value="<?php if(isset($address1)) echo $address1; ?>" placeholder="Enter Address 1">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Address 2</label>
                                            <input type="text" tabindex="6" id="address2" name="address2" class="form-control"  value="<?php if(isset($address2)) echo $address2; ?>" placeholder="Enter Address 2">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">City</label>
                                            <select id="city" name="city" class="form-control" tabindex="7">
                                                <option value="" disabled selected>Choose City</option>
                                                <option <?php  if(isset($city)) { if($city == "Chennai" ) echo 'selected'; }?> 
                                                value="Chennai" data-id="TamilNadu">Chennai</option>
                                                <option <?php  if(isset($city)) { if($city == "Coimbatore" ) echo 'selected'; }?>
                                                value="Coimbatore" data-id="TamilNadu">Coimbatore</option>
                                                <option <?php  if(isset($city)) { if($city == "Madurai" ) echo 'selected'; }?>
                                                value="Madurai" data-id="TamilNadu">Madurai</option>
                                                <option <?php  if(isset($city)) { if($city == "Tiruchirappalli" ) echo 'selected'; }?>
                                                value="Tiruchirappalli" data-id="TamilNadu">Tiruchirappalli</option>
                                                <option <?php  if(isset($city)) { if($city == "Salem" ) echo 'selected'; }?>
                                                value="Salem" data-id="TamilNadu">Salem</option>
                                                <option <?php  if(isset($city)) { if($city == "Tiruppur" ) echo 'selected'; }?>
                                                value="Tiruppur" data-id="TamilNadu">Tiruppur</option>
                                                <option <?php  if(isset($city)) { if($city == "Tiruvannamalai" ) echo 'selected'; }?>
                                                value="Tiruvannamalai" data-id="TamilNadu">Tiruvannamalai</option>
                                                <option <?php  if(isset($city)) { if($city == "Cuddalore" ) echo 'selected'; }?>
                                                value="Cuddalore" data-id="TamilNadu">Cuddalore</option>
                                                <option <?php  if(isset($city)) { if($city == "Pudukkottai" ) echo 'selected'; }?>
                                                value="Pudukkottai" data-id="TamilNadu"> Pudukkottai</option>
                                                <option <?php  if(isset($city)) { if($city == "Vaniyambadi" ) echo 'selected'; }?>
                                                value="Vaniyambadi" data-id="TamilNadu">Vaniyambadi</option>
                                                <option <?php  if(isset($city)) { if($city == "Ambur" ) echo 'selected'; }?>
                                                value="Ambur" data-id="TamilNadu">Ambur</option>
                                                <option <?php  if(isset($city)) { if($city == "Nagapattinam" ) echo 'selected'; }?>
                                                value="Nagapattinam" data-id="TamilNadu">Nagapattinam</option>
                                                <option <?php  if(isset($city)) { if($city == "Karaikkudi" ) echo 'selected'; }?>
                                                value="Karaikkudi" data-id="TamilNadu">Karaikkudi</option>
                                                <option <?php  if(isset($city)) { if($city == "Kanchipuram" ) echo 'selected'; }?>
                                                value="Kanchipuram" data-id="TamilNadu">Kanchipuram</option>
                                                <option <?php  if(isset($city)) { if($city == "Sivakasi" ) echo 'selected'; }?>
                                                value="Sivakasi" data-id="TamilNadu">Sivakasi</option>
                                                <option <?php  if(isset($city)) { if($city == "Ariankuppam" ) echo 'selected'; }?>
                                                value="Ariankuppam" data-id="Puducherry">Ariankuppam</option>
                                                <option <?php  if(isset($city)) { if($city == "Kurumbapet" ) echo 'selected'; }?>
                                                value="Kurumbapet" data-id="Puducherry">Kurumbapet</option>
                                                <option <?php  if(isset($city)) { if($city == "Manavely" ) echo 'selected'; }?>
                                                value="Manavely" data-id="Puducherry">Manavely</option>
                                                <option <?php  if(isset($city)) { if($city == "Ozhukarai" ) echo 'selected'; }?>
                                                value="Ozhukarai" data-id="Puducherry">Ozhukarai</option>
                                                <option <?php  if(isset($city)) { if($city == "Villianur" ) echo 'selected'; }?>
                                                value="Villianur" data-id="Puducherry">Villianur</option>
                                                <option <?php  if(isset($city)) { if($city == "Karaikal" ) echo 'selected'; }?>
                                                value="Karaikal" data-id="Puducherry">Karaikal</option>
                                                <option <?php  if(isset($city)) { if($city == "Yanam" ) echo 'selected'; }?>
                                                value="Yanam" data-id="Yanam">Yanam</option>
                                                <option <?php  if(isset($city)) { if($city == "Mahé" ) echo 'selected'; }?>
                                                value="Mahé" data-id="Mahé">Mahé</option>
                                            </select>   
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">State</label>
                                            <input type="text" id="state" name="state" readonly
                                             value="<?php if(isset($state)) echo $state; ?>"  class="form-control" placeholder="Enter State">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">PAN No</label>
											<input type="text" tabindex="8" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);" maxlength = "10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" name="pan_number" id="pan_number" 
                                             value="<?php if(isset($pan_number)) echo $pan_number; ?>"  class="form-control" placeholder="Enter PAN No">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">E-Mail Id</label>
                                            <input class="form-control" tabindex="9" id="email_id" name="email_id" type="email" 
                                            value="<?php if(isset($email_id)) echo $email_id; ?>" placeholder="Enter Email Id">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">PF Number</label>
                                            <input tabindex="10" type="text" 
                                            name="pf_number" id="pf_number" pattern="([A-Z]{2})/([A-Z]{3})/([0-9]{7})/([0-9]{3})/([0-9]{7})" 
                                            class="form-control" placeholder="KN/KRP/0054055/000/0000250" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "26" value="<?php if(isset($pf_number )) 
                                            echo $pf_number ; ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">ESI Number</label>
                                            <input tabindex="11" type="text" 
                                            name="esi_number" id="esi_number" pattern="[0-9]{2}/[0-9]{2}/[0-9]{6}/[0-9]{3}/[0-9]{4}" 
                                            class="form-control" placeholder="31/00/123456/000/0001" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "21"
                                            value="<?php if(isset($esi_number )) 
                                            echo $esi_number ; ?>" >
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">FAX Number</label>
                                            <input tabindex="12" type="number" 
                                            name="fax_number" id="fax_number" pattern="[0-9]{3}[0-9]{3}[0-9]{7}"
                                            class="form-control" placeholder="7887877458754" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "13"  value="<?php if(isset($fax_number )) 
                                            echo $fax_number ; ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Office Number</label>
                                            <input class="form-control" tabindex="13" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "10" id="office_number" name="office_number" 
                                            type="number" value="<?php if(isset($office_number)) echo $office_number; ?>" 
                                            placeholder="Enter Office Number">
                                             
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Website</label>
                                            <input class="form-control" tabindex="14" id="website" name="website" type="text" pattern="^www\.[a-zA-Z0-9]+\.com$" value="<?php if(isset($website)) echo $website; ?>" placeholder="Enter Website">
                                             
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">TAN No</label>
											<input type="text" tabindex="15" name="tan_number" id="tan_number" pattern="[A-Z]{4}[0-9]{5}[A-Z]{1}"
                                             oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxlength = "10" value="<?php if(isset($tan_number)) echo $tan_number; ?>"  class="form-control" placeholder="Enter TAN No">
									
                                        </div>
                                    </div>

                                </div>
                            </div>  

                            <!-- Field Finished -->
                            <div class="col-md-4"><br />
                                <div class="col-xl-12 col-lg-4 col-md-6 col-sm-6 col-12 mx-auto">
                                <label for="disabledInput">Company Logo</label>
                                    <?php if(isset($_GET['upd'])<=0){ ?>
                                        <div class="form-group" style="margin: auto;"> 
                                            <img src="img/profile-pic.jpg" width="43%" id="viewimage">
                                            <input type="file" tabindex="16"  class="form-control" 
                                            accept="image/*" onchange="loadFile(event)"  
                                            id="company_logo" name="company_logo" style="width:43%">
                                        </div>
                                    <?php } ?>
                                    <?php if(isset($company_logo)){ if($company_logo != ''){ ?>
                                        <div class="form-group" style="margin: auto;"> 
                                            <img src="<?php echo "uploads/company_logo/".$company_logo ?>" width="43%" id="viewimage">
                                            <input type="file" tabindex="16"  class="form-control" 
                                            accept="image/*" onchange="loadFile(event)"  
                                            id="company_logo" name="company_logo" style="width:43%">
                                            <input type="hidden" name="updateimage" id="updateimage" value="<?php echo $company_logo; ?>">
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group" style="margin: auto;"> 
                                            <img src="img/profile-pic.jpg" width="43%" id="viewimage">
                                            <input type="file" tabindex="16"  class="form-control" 
                                            accept="image/*" onchange="loadFile(event)"  
                                            id="company_logo" name="company_logo" style="width:43%">
                                        </div>
                                    <?php }} ?>
                                </div>
                            </div>
                        </div>
                            <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submitcompany_creation" id="submitcompany_creation" class="btn btn-primary" value="Submit" tabindex="17">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="18">Cancel</button>
                            </div>
                        </div>
                    </div>
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



