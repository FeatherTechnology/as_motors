<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
$companyName = $userObj->getCompanyName($mysqli);
$id=0;
 if(isset($_POST['submitbranch_creation']) && $_POST['submitbranch_creation'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateBranchCreationmaster = $userObj->updateBranchCreation($mysqli,$id,$userid);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_branch_creation&msc=2';</script> 
    <?php	}
    else{   
		$addBranchCreation = $userObj->addBranchCreation($mysqli,$userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_branch_creation&msc=1';</script>
        <?php
    }
 }   

// $del=0;
// if(isset($_GET['del']))
// {
// $del=$_GET['del'];
// }
// if($del>0)
// {
// 	$deleteBranchCreation = $userObj->deleteBranchCreation($mysqli,$del,$userid); 
	?>
	<!-- <script>location.href='<?php echo $HOSTPATH; ?>edit_branch_creation&msc=3';</script> -->
<?php	
// }

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getBranchCreation = $userObj->getBranchCreation($mysqli,$idupd); 
	
	if (sizeof($getBranchCreation)>0) {
        for($ibranch=0;$ibranch<sizeof($getBranchCreation);$ibranch++)  {	
            $branch_id                       = $getBranchCreation['branch_id'];
            $branch_name                     = $getBranchCreation['branch_name'];
			$company_id                	     = $getBranchCreation['company_id'];
			$key_personal		             = $getBranchCreation['key_personal'];
			$address2    			         = $getBranchCreation['address2'];
			$address1                	     = $getBranchCreation['address1'];
            $city                            = $getBranchCreation['city'];
			$state       		             = $getBranchCreation['state'];
			$email_id     			         = $getBranchCreation['email_id'];
			$website     		             = $getBranchCreation['website'];
			$pan_number     			     = $getBranchCreation['pan_number'];
			$pf_number     			         = $getBranchCreation['pf_number'];
            $esi_number     			     = $getBranchCreation['esi_number'];
            $fax_number     			     = $getBranchCreation['fax_number'];
            $office_number      			 = $getBranchCreation['office_number'];
			$tan_number                      = $getBranchCreation['tan_number'];
            
            
		}
	}
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Branch Creation </li>
    </ol>

    <a href="edit_branch_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
    </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "branch_creation" name="branch_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($branch_id)) echo $branch_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                                            <label for="disabledInput">Branch Name</label>
                                            <input type="text" tabindex="1" id="branch_name" name="branch_name" class="form-control"  value="<?php if(isset($branch_name)) 
                                            echo $branch_name; ?>" placeholder="Enter Branch Name">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <select tabindex="2" type="text" class="form-control" id="company_id" name="company_id"  >
                                                <option value="">Select Company Name</option>   
                                                    <?php if (sizeof($companyName)>0) { 
                                                    for($j=0;$j<count($companyName);$j++) { ?>
                                                    <option <?php if(isset($company_id)) { if($companyName[$j]['company_id'] == $company_id)  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                    <?php echo $companyName[$j]['company_name'];?></option>
                                                    <?php }} ?>  
                                            </select> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Key Personal</label>
                                            <input type="text" tabindex="3" id="key_personal" name="key_personal" class="form-control"  value="<?php if(isset($key_personal)) 
                                            echo $key_personal; ?>" placeholder="Enter Key Personal">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Address 1</label>
                                            <input type="text" tabindex="4" id="address1" name="address1" class="form-control"  value="<?php if(isset($address1)) echo $address1; ?>" placeholder="Enter Address 1">
                                            
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Address 2</label>
                                            <input type="text" tabindex="5" id="address2" name="address2" class="form-control"  value="<?php if(isset($address2)) echo $address2; ?>" placeholder="Enter Address 2">
                                             
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">E-Mail Id</label>
                                            <input class="form-control" tabindex="6" id="email_id" name="email_id" type="text" 
                                            value="<?php if(isset($email_id)) echo $email_id; ?>" placeholder="Enter Email Id">
                                
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">City</label>
                                            <select id="city" name="city" class="form-control" tabindex = "7">
                                                <option value="" disabled selected>Choose City</option>
                                                <option <?php if(isset($city)) { if($city == "Ambur") echo 'selected'; }?> value="Ambur" data-id="TamilNadu">Ambur</option>
                                                <option <?php if(isset($city)) { if($city == "Ariankuppam") echo 'selected'; }?> value="Ariankuppam" data-id="Puducherry">Ariankuppam</option>
                                                <option <?php if(isset($city)) { if($city == "Ariyalur") echo 'selected'; }?> value="Ariyalur" data-id="TamilNadu">Ariyalur</option>
                                                <option <?php if(isset($city)) { if($city == "Chengalpattu") echo 'selected'; }?> value="Chengalpattu" data-id="TamilNadu">Chengalpattu</option>
                                                <option <?php if(isset($city)) { if($city == "Chennai") echo 'selected'; }?> value="Chennai" data-id="TamilNadu">Chennai</option>
                                                <option <?php if(isset($city)) { if($city == "Coimbatore") echo 'selected'; }?> value="Coimbatore" data-id="TamilNadu">Coimbatore</option>
                                                <option <?php if(isset($city)) { if($city == "Cuddalore") echo 'selected'; }?> value="Cuddalore" data-id="TamilNadu">Cuddalore</option>
                                                <option <?php if(isset($city)) { if($city == "Dharmapuri") echo 'selected'; }?> value="Dharmapuri" data-id="TamilNadu">Dharmapuri</option>
                                                <option <?php if(isset($city)) { if($city == "Dindigul") echo 'selected'; }?> value="Dindigul" data-id="TamilNadu">Dindigul</option>
                                                <option <?php if(isset($city)) { if($city == "Erode") echo 'selected'; }?> value="Erode" data-id="TamilNadu">Erode</option>
                                                <option <?php if(isset($city)) { if($city == "Kallakurichi") echo 'selected'; }?> value="Kallakurichi" data-id="TamilNadu">Kallakurichi</option>
                                                <option <?php if(isset($city)) { if($city == "Kanchipuram") echo 'selected'; }?> value="Kanchipuram" data-id="TamilNadu">Kanchipuram</option>
                                                <option <?php if(isset($city)) { if($city == "Kanniyakumari") echo 'selected'; }?> value="Kanniyakumari" data-id="TamilNadu">Kanniyakumari</option>
                                                <option <?php if(isset($city)) { if($city == "Karaikal") echo 'selected'; }?> value="Karaikal" data-id="Puducherry">Karaikal</option>
                                                <option <?php if(isset($city)) { if($city == "Karaikkudi") echo 'selected'; }?> value="Karaikkudi" data-id="TamilNadu">Karaikkudi</option>
                                                <option <?php if(isset($city)) { if($city == "Karur") echo 'selected'; }?> value="Karur" data-id="TamilNadu">Karur</option>
                                                <option <?php if(isset($city)) { if($city == "Kancheepuram") echo 'selected'; }?> value="Kancheepuram" data-id="TamilNadu">Kancheepuram</option>
                                                <option <?php if(isset($city)) { if($city == "Kurumbapet") echo 'selected'; }?> value="Kurumbapet" data-id="Puducherry">Kurumbapet</option>
                                                <option <?php if(isset($city)) { if($city == "Madurai") echo 'selected'; }?> value="Madurai" data-id="TamilNadu">Madurai</option>
                                                <option <?php if(isset($city)) { if($city == "Mahé") echo 'selected'; }?> value="Mahé" data-id="Mahé">Mahé</option>
                                                <option <?php if(isset($city)) { if($city == "Manavely") echo 'selected'; }?> value="Manavely" data-id="Puducherry">Manavely</option>
                                                <option <?php if(isset($city)) { if($city == "Mayiladuthurai") echo 'selected'; }?> value="Mayiladuthurai" data-id="TamilNadu">Mayiladuthurai</option>
                                                <option <?php if(isset($city)) { if($city == "Nagapattinam") echo 'selected'; }?> value="Nagapattinam" data-id="TamilNadu">Nagapattinam</option>
                                                <option <?php if(isset($city)) { if($city == "Namakkal") echo 'selected'; }?> value="Namakkal" data-id="TamilNadu">Namakkal</option>
                                                <option <?php if(isset($city)) { if($city == "Nilgiris") echo 'selected'; }?> value="Nilgiris" data-id="TamilNadu">Nilgiris</option>
                                                <option <?php if(isset($city)) { if($city == "Ozhukarai") echo 'selected'; }?> value="Ozhukarai" data-id="Puducherry">Ozhukarai</option>
                                                <option <?php if(isset($city)) { if($city == "Perambalur") echo 'selected'; }?> value="Perambalur" data-id="TamilNadu">Perambalur</option>
                                                <option <?php if(isset($city)) { if($city == "Pudukkottai") echo 'selected'; }?> value="Pudukkottai" data-id="TamilNadu">Pudukkottai</option>
                                                <option <?php if(isset($city)) { if($city == "Pudukottai") echo 'selected'; }?> value="Pudukottai" data-id="TamilNadu">Pudukottai</option>
                                                <option <?php if(isset($city)) { if($city == "Ramanathapuram") echo 'selected'; }?> value="Ramanathapuram" data-id="TamilNadu">Ramanathapuram</option>
                                                <option <?php if(isset($city)) { if($city == "Ranipet") echo 'selected'; }?> value="Ranipet" data-id="TamilNadu">Ranipet</option>
                                                <option <?php if(isset($city)) { if($city == "Salem") echo 'selected'; }?> value="Salem" data-id="TamilNadu">Salem</option>
                                                <option <?php if(isset($city)) { if($city == "Sivagangai") echo 'selected'; }?> value="Sivagangai" data-id="TamilNadu">Sivagangai</option>
                                                <option <?php if(isset($city)) { if($city == "Sivakasi") echo 'selected'; }?> value="Sivakasi" data-id="TamilNadu">Sivakasi</option>
                                                <option <?php if(isset($city)) { if($city == "Tenkasi") echo 'selected'; }?> value="Tenkasi" data-id="TamilNadu">Tenkasi</option>
                                                <option <?php if(isset($city)) { if($city == "Thanjavur") echo 'selected'; }?> value="Thanjavur" data-id="TamilNadu">Thanjavur</option>
                                                <option <?php if(isset($city)) { if($city == "Theni") echo 'selected'; }?> value="Theni" data-id="TamilNadu">Theni</option>
                                                <option <?php if(isset($city)) { if($city == "Thirunelveli") echo 'selected'; }?> value="Thirunelveli" data-id="TamilNadu">Thirunelveli</option>
                                                <option <?php if(isset($city)) { if($city == "Thiruvallur") echo 'selected'; }?> value="Thiruvallur" data-id="TamilNadu">Thiruvallur</option>
                                                <option <?php if(isset($city)) { if($city == "Thiruvarur") echo 'selected'; }?> value="Thiruvarur" data-id="TamilNadu">Thiruvarur</option>
                                                <option <?php if(isset($city)) { if($city == "Thoothukudi") echo 'selected'; }?> value="Thoothukudi" data-id="TamilNadu">Thoothukudi</option>
                                                <option <?php if(isset($city)) { if($city == "Tiruchirappalli") echo 'selected'; }?> value="Tiruchirappalli" data-id="TamilNadu">Tiruchirappalli</option>
                                                <option <?php if(isset($city)) { if($city == "Tirupathur") echo 'selected'; }?> value="Tirupathur" data-id="TamilNadu">Tirupathur</option>
                                                <option <?php if(isset($city)) { if($city == "Tiruppur") echo 'selected'; }?> value="Tiruppur" data-id="TamilNadu">Tiruppur</option>
                                                <option <?php if(isset($city)) { if($city == "Tiruvannamalai") echo 'selected'; }?> value="Tiruvannamalai" data-id="TamilNadu">Tiruvannamalai</option>
                                                <option <?php if(isset($city)) { if($city == "Trichy") echo 'selected'; }?> value="Trichy" data-id="TamilNadu">Trichy</option>
                                                <option <?php if(isset($city)) { if($city == "Vaniyambadi") echo 'selected'; }?> value="Vaniyambadi" data-id="TamilNadu">Vaniyambadi</option>
                                                <option <?php if(isset($city)) { if($city == "Vellore") echo 'selected'; }?> value="Vellore" data-id="TamilNadu">Vellore</option>
                                                <option <?php if(isset($city)) { if($city == "Villianur") echo 'selected'; }?> value="Villianur" data-id="Puducherry">Villianur</option>
                                                <option <?php if(isset($city)) { if($city == "Virudhunagar") echo 'selected'; }?> value="Virudhunagar" data-id="TamilNadu">Virudhunagar</option>
                                                <option <?php if(isset($city)) { if($city == "Yanam") echo 'selected'; }?> value="Yanam" data-id="Yanam">Yanam</option>
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
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" name="pan_number" id="pan_number" 
                                             value="<?php if(isset($pan_number)) echo $pan_number; ?>"  class="form-control" placeholder="Enter PAN No">
                                             
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">PF Number</label>
                                            <input tabindex="9" type="text" 
                                            name="pf_number" id="pf_number" pattern="([A-Z]{2})/([A-Z]{3})/([0-9]{7})/([0-9]{3})/([0-9]{7})" 
                                            class="form-control" placeholder="KN/KRP/0054055/000/0000250" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "26" value="<?php if(isset($pf_number )) 
                                            echo $pf_number ; ?>">
                                             
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">ESI Number</label>
                                            <input tabindex="10" type="text" 
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
                                            <input tabindex="11" type="number" 
                                            name="fax_number" id="fax_number" pattern="[0-9]{3}[0-9]{3}[0-9]{7}"
                                            class="form-control" placeholder="7887877458754" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "13"  value="<?php if(isset($fax_number )) 
                                            echo $fax_number ; ?>">
                                             
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Office Number</label>
                                            <input class="form-control" tabindex="12" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "10" id="office_number" name="office_number" 
                                            type="number" value="<?php if(isset($office_number)) echo $office_number; ?>" 
                                            placeholder="Enter Office Number">
                                             
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Website</label>
                                            <input class="form-control" tabindex="13" id="website" name="website" type="text" value="<?php if(isset($website)) echo $website; ?>" placeholder="Enter Website">
                                             
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">TAN No</label>
											<input type="text" tabindex="14" name="tan_number" id="tan_number" pattern="[A-Z]{4}[0-9]{5}[A-Z]{1}"
                                             oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxlength = "10" value="<?php if(isset($tan_number)) echo $tan_number; ?>"  class="form-control" placeholder="Enter TAN No">
									
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                            <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submitbranch_creation" id="submitbranch_creation" class="btn btn-primary" value="Submit" tabindex="15">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="16">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



