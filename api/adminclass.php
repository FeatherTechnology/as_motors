<?php
// require 'PHPMailerAutoload.php';
  class admin 
	{ 

		public function getuser($mysqli,$idupd) 
		{
			$qry = "SELECT * FROM user WHERE user_id='".mysqli_real_escape_string($mysqli,$idupd)."'"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['user_id']                    = $row->user_id; 
				$detailrecords['fullname']       	           = strip_tags($row->fullname);
				$detailrecords['user_name']       	        = strip_tags($row->user_name);
				$detailrecords['user_password']              = strip_tags($row->user_password);		  	
				$detailrecords['status']                     = strip_tags($row->status);		
			}
			return $detailrecords;
		}


		// Add company
		public function addCompanyCreation($mysqli, $userid){

			if(isset($_POST['company_name'])){
				$company_name = $_POST['company_name'];
			}
			if(isset($_POST['company_status'])){
				$company_status = $_POST['company_status'];
			}
			if(isset($_POST['cin'])){
				$cin = $_POST['cin'];
			}
			if(isset($_POST['address1'])){
				$address1 = $_POST['address1'];
			}
			if(isset($_POST['address2'])){
				$address2 = $_POST['address2'];
			}
			if(isset($_POST['key_personal'])){
				$key_personal = $_POST['key_personal'];
			}
			if(isset($_POST['city'])){
				$city = $_POST['city'];
			}
			if(isset($_POST['state'])){
				$state = $_POST['state'];
			}
			if(isset($_POST['pan_number'])){
				$pan_number = $_POST['pan_number'];
			}
			if(isset($_POST['email_id'])){
				$email_id = $_POST['email_id'];
			}
			if(isset($_POST['pf_number'])){
				$pf_number = $_POST['pf_number'];
			}
			if(isset($_POST['esi_number'])){
				$esi_number = $_POST['esi_number'];
			}
			if(isset($_POST['fax_number'])){
				$fax_number = $_POST['fax_number'];
			}
			if(isset($_POST['office_number'])){
				$office_number = $_POST['office_number'];
			}
			if(isset($_POST['website'])){
				$website = $_POST['website'];
			}
			if(isset($_POST['tan_number'])){
				$tan_number = $_POST['tan_number'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			$company_logo = '';
			if(!empty($_FILES['company_logo']['name']))		
			{
				$company_logo = $_FILES['company_logo']['name'];
				$companyimage_tmp = $_FILES['company_logo']['tmp_name'];
				$companyimagefolder="uploads/company_logo/".$company_logo ;
				move_uploaded_file($companyimage_tmp, $companyimagefolder);
			} 
		
			$companyInsert="INSERT INTO company_creation(company_name, company_status, cin, address1, address2, key_personal, city, state, pan_number, 
			email_id, pf_number, esi_number, fax_number, office_number, website, tan_number, company_logo, insert_login_id) 
			VALUES('".strip_tags($company_name)."','".strip_tags($company_status)."', '".strip_tags($cin)."', '".strip_tags($address1)."', '".strip_tags($address2)."', 
			'".strip_tags($key_personal)."', '".strip_tags($city)."', '".strip_tags($state)."', '".strip_tags($pan_number)."', '".strip_tags($email_id)."',
			'".strip_tags($pf_number)."','".strip_tags($esi_number)."','".strip_tags($fax_number)."','".strip_tags($office_number)."','".strip_tags($website)."',
			'".strip_tags($tan_number)."','".strip_tags($company_logo)."','".strip_tags($userid)."' )";

			$insresult=$mysqli->query($companyInsert) or die("Error ".$mysqli->error);
		}

		// Get company
		public function getCompanyCreation($mysqli, $id){

			$companySelect = "SELECT * FROM company_creation WHERE company_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($companySelect) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['company_id']      = $row->company_id; 
				$detailrecords['company_name']    = $row->company_name;
				$detailrecords['company_status']    = $row->company_status; 
				$detailrecords['cin']        = $row->cin; 
				$detailrecords['address1']      = $row->address1;
				$detailrecords['address2']      = $row->address2;  	
				$detailrecords['key_personal']       = $row->key_personal;
				$detailrecords['city']         = $row->city;
				$detailrecords['state']       = $row->state;
				$detailrecords['pan_number']       = $row->pan_number;
				$detailrecords['email_id']       = $row->email_id;
				$detailrecords['pf_number']       = $row->pf_number;
				$detailrecords['esi_number']       = $row->esi_number;
				$detailrecords['fax_number']       = $row->fax_number;
				$detailrecords['office_number']       = $row->office_number;
				$detailrecords['website']       = $row->website;
				$detailrecords['tan_number']       = $row->tan_number;
				$detailrecords['company_logo']  = $row->company_logo;
			}
			
			return $detailrecords;
		}

		// Update company
        public function updateCompanyCreation($mysqli, $id, $userid){
            if(isset($_POST['company_name'])){
                $company_name = $_POST['company_name'];
            }
            if(isset($_POST['company_status'])){
                $company_status = $_POST['company_status'];
                // change cin value based on current company status
                if($company_status != "Partnership" and $company_status != "HUF" and $company_status != "Individual"){
                    $cin = $_POST['cin'];
                }else{
                    $cin ="";
                }
            }
            if(isset($_POST['cin'])){
                // if($company_status != 'Partnership' || $company_status != 'HUF' || $company_status != 'Individual'){
                //  $cin = $_POST['cin'];
                // }else{
                //  $cin = '';
                // }
            }
            if(isset($_POST['address1'])){
                $address1 = $_POST['address1'];
            }
            if(isset($_POST['address2'])){
                $address2 = $_POST['address2'];
            }
            if(isset($_POST['key_personal'])){
                $key_personal = $_POST['key_personal'];
            }
            if(isset($_POST['city'])){
                $city = $_POST['city'];
            }
            if(isset($_POST['state'])){
                $state = $_POST['state'];
            }
            if(isset($_POST['pan_number'])){
                $pan_number = $_POST['pan_number'];
            }
            if(isset($_POST['email_id'])){
                $email_id = $_POST['email_id'];
            }
            if(isset($_POST['pf_number'])){
                $pf_number = $_POST['pf_number'];
            }
            if(isset($_POST['esi_number'])){
                $esi_number = $_POST['esi_number'];
            }
            if(isset($_POST['fax_number'])){
                $fax_number = $_POST['fax_number'];
            }
            if(isset($_POST['office_number'])){
                $office_number = $_POST['office_number'];
            }
            if(isset($_POST['website'])){
                $website = $_POST['website'];
            }
            if(isset($_POST['tan_number'])){
                $tan_number = $_POST['tan_number'];
            }
            if(isset($_POST['userid'])){
                $userid = $_POST['userid'];
            }
            $company_logo = '';
            if(!empty($_FILES['company_logo']['name']))
            {
                //delete old file
                $path='uploads/company_logo/'.$_POST["updateimage"];
                if (file_exists($path)) {
                    unlink($path);
                }
                //insert new file
                $company_logo = $_FILES['company_logo']['name'];
                $companyimage_tmp = $_FILES['company_logo']['tmp_name'];
                $companyimagefolder="uploads/company_logo/".$company_logo;
                move_uploaded_file($companyimage_tmp, $companyimagefolder);
            }
            if($company_logo == '' && isset($_POST["updateimage"])){
                $company_logo = $_POST["updateimage"];
            }
           $companyUpdaet = "UPDATE company_creation SET company_name = '".strip_tags($company_name)."', company_status='".strip_tags($company_status)."',
           cin='".strip_tags($cin)."', address1='".strip_tags($address1)."', address2='".strip_tags($address2)."', key_personal='".strip_tags($key_personal)."',
           city='".strip_tags($city)."', state='".strip_tags($state)."', pan_number='".strip_tags($pan_number)."', email_id='".strip_tags($email_id)."',
           pf_number='".strip_tags($pf_number)."',esi_number='".strip_tags($esi_number)."', fax_number='".strip_tags($fax_number)."',
           office_number='".strip_tags($office_number)."', website='".strip_tags($website)."',tan_number='".strip_tags($tan_number)."',
           company_logo='".strip_tags($company_logo)."',
           update_login_id='".strip_tags($userid)."', status = '0' WHERE company_id= '".strip_tags($id)."' ";
           $updresult = $mysqli->query($companyUpdaet )or die ("Error in in update Query!.".$mysqli->error);
        }

		//  Delete company
		public function deleteCompanyCreation($mysqli, $id, $userid){

			$companyDelete = "UPDATE company_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE company_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($companyDelete) or die("Error in delete query".$mysqli->error);
		}

		//  Get Company Name
		public function getCompanyName($mysqli) {

			$qry = "SELECT * FROM company_creation WHERE 1 AND status=0 ORDER BY company_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['company_id']            = $row->company_id; 
					$detailrecords[$i]['company_name']       	= strip_tags($row->company_name);
					$i++;
				}
			}
			return $detailrecords;
		}

		public function getCompnayNameBranchBased($mysqli) {
            $qry = "SELECT * FROM branch_creation WHERE status=0 ORDER BY branch_id ASC";
            $res = $mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            // $detailrecords['company_name'] = '';
            // $detailrecords['branch_name'] = '';
            $i=0;
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object())
                {
                    $detailrecords[$i]['branch_id']          = strip_tags($row->branch_id);
                    $detailrecords[$i]['branch_name']          = strip_tags($row->branch_name);
                    $detailrecords[$i]['company_id']          = strip_tags($row->company_id);
                        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".strip_tags($row->company_id)."' ";
                        $res1 = $mysqli->query($getname) or die("Error in Get All Records".$mysqli->error);
                        while ($row2 = $res1->fetch_object()) {
                            $company_name = $row2->company_name;
                        }
                    $detailrecords[$i]['company_name'] = $company_name;
                    $i++;
                }
            }
            return $detailrecords;
        }

		// Add Branch
		public function addBranchCreation($mysqli, $userid){

			if(isset($_POST['branch_name'])){
				$branch_name = $_POST['branch_name'];
			}
			if(isset($_POST['company_id'])){
				$company_id = $_POST['company_id'];
			}
			if(isset($_POST['address1'])){
				$address1 = $_POST['address1'];
			}
			if(isset($_POST['address2'])){
				$address2 = $_POST['address2'];
			}
			if(isset($_POST['key_personal'])){
				$key_personal = $_POST['key_personal'];
			}
			if(isset($_POST['city'])){
				$city = $_POST['city'];
			}
			if(isset($_POST['state'])){
				$state = $_POST['state'];
			}
			if(isset($_POST['pan_number'])){
				$pan_number = $_POST['pan_number'];
			}
			if(isset($_POST['email_id'])){
				$email_id = $_POST['email_id'];
			}
			if(isset($_POST['pf_number'])){
				$pf_number = $_POST['pf_number'];
			}
			if(isset($_POST['esi_number'])){
				$esi_number = $_POST['esi_number'];
			}
			if(isset($_POST['fax_number'])){
				$fax_number = $_POST['fax_number'];
			}
			if(isset($_POST['office_number'])){
				$office_number = $_POST['office_number'];
			}
			if(isset($_POST['website'])){
				$website = $_POST['website'];
			}
			if(isset($_POST['tan_number'])){
				$tan_number = $_POST['tan_number'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 
		
			$branchInsert="INSERT INTO branch_creation(branch_name, company_id, address1, address2, key_personal, city, state, pan_number, 
			email_id, pf_number, esi_number, fax_number, office_number, website, tan_number, insert_login_id) 
			VALUES('".strip_tags($branch_name)."', '".strip_tags($company_id)."', '".strip_tags($address1)."', '".strip_tags($address2)."', 
			'".strip_tags($key_personal)."', '".strip_tags($city)."', '".strip_tags($state)."', '".strip_tags($pan_number)."', '".strip_tags($email_id)."',
			'".strip_tags($pf_number)."','".strip_tags($esi_number)."','".strip_tags($fax_number)."','".strip_tags($office_number)."','".strip_tags($website)."',
			'".strip_tags($tan_number)."','".strip_tags($userid)."' )";

			$insresult=$mysqli->query($branchInsert) or die("Error ".$mysqli->error);
		}

		// Get Branch
		public function getBranchCreation($mysqli, $id){

			$branchSelect = "SELECT * FROM branch_creation WHERE branch_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($branchSelect) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['branch_id']      = $row->branch_id; 
				$detailrecords['branch_name']      = $row->branch_name;
				$detailrecords['company_id']    = $row->company_id;
				$detailrecords['address1']      = $row->address1;
				$detailrecords['address2']      = $row->address2;  	
				$detailrecords['key_personal']       = $row->key_personal;
				$detailrecords['city']         = $row->city;
				$detailrecords['state']       = $row->state;
				$detailrecords['pan_number']       = $row->pan_number;
				$detailrecords['email_id']       = $row->email_id;
				$detailrecords['pf_number']       = $row->pf_number;
				$detailrecords['esi_number']       = $row->esi_number;
				$detailrecords['fax_number']       = $row->fax_number;
				$detailrecords['office_number']       = $row->office_number;
				$detailrecords['website']       = $row->website;
				$detailrecords['tan_number']       = $row->tan_number;
			}
			
			return $detailrecords;
		}

		// Update Branch
		public function updateBranchCreation($mysqli, $id, $userid){

			if(isset($_POST['branch_name'])){
				$branch_name = $_POST['branch_name'];
			}
			if(isset($_POST['company_id'])){
				$company_id = $_POST['company_id'];
			}

			if(isset($_POST['address1'])){
				$address1 = $_POST['address1'];
			}
			if(isset($_POST['address2'])){
				$address2 = $_POST['address2'];
			}
			if(isset($_POST['key_personal'])){
				$key_personal = $_POST['key_personal'];
			}
			if(isset($_POST['city'])){
				$city = $_POST['city'];
			}
			if(isset($_POST['state'])){
				$state = $_POST['state'];
			}
			if(isset($_POST['pan_number'])){
				$pan_number = $_POST['pan_number'];
			}
			if(isset($_POST['email_id'])){
				$email_id = $_POST['email_id'];
			}
			if(isset($_POST['pf_number'])){
				$pf_number = $_POST['pf_number'];
			}
			if(isset($_POST['esi_number'])){
				$esi_number = $_POST['esi_number'];
			}
			if(isset($_POST['fax_number'])){
				$fax_number = $_POST['fax_number'];
			}
			if(isset($_POST['office_number'])){
				$office_number = $_POST['office_number'];
			}
			if(isset($_POST['website'])){
				$website = $_POST['website'];
			}
			if(isset($_POST['tan_number'])){
				$tan_number = $_POST['tan_number'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 
		
		   $branchUpdaet = "UPDATE branch_creation SET branch_name = '".strip_tags($branch_name)."', company_id = '".strip_tags($company_id)."', address1='".strip_tags($address1)."', address2='".strip_tags($address2)."', key_personal='".strip_tags($key_personal)."', 
		   city='".strip_tags($city)."', state='".strip_tags($state)."', pan_number='".strip_tags($pan_number)."', email_id='".strip_tags($email_id)."',
		   pf_number='".strip_tags($pf_number)."',esi_number='".strip_tags($esi_number)."', fax_number='".strip_tags($fax_number)."',
		   office_number='".strip_tags($office_number)."', website='".strip_tags($website)."',tan_number='".strip_tags($tan_number)."',
		   update_login_id='".strip_tags($userid)."', status = '0' WHERE branch_id= '".strip_tags($id)."' ";
		   $updresult = $mysqli->query($branchUpdaet )or die ("Error in in update Query!.".$mysqli->error);
		
	 	}

		//  Delete Branch
		public function deleteBranchCreation($mysqli, $id, $userid){

			$branchDelete = "UPDATE branch_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE branch_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($branchDelete) or die("Error in delete query".$mysqli->error);
		}


		// Add Branch
		public function addHolidayCreation($mysqli, $userid){

			if(isset($_POST['calendar_year'])){
				$calendar_year = $_POST['calendar_year'];
			}
			if(isset($_POST['company_id'])){
				$company_id1 = $_POST['company_id'];
				$company_id = implode(",", $company_id1); 
			} 
			if(isset($_POST['holiday_date'])){
				$holiday_date = $_POST['holiday_date'];
			}
			if(isset($_POST['holiday_description'])){
				$holiday_description = $_POST['holiday_description'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			$holidayInsert="INSERT INTO holiday_creation(calendar_year, company_id, insert_login_id) VALUES('".strip_tags($calendar_year)."', 
			'".strip_tags($company_id)."', '".strip_tags($userid)."' )";
			$insresult=$mysqli->query($holidayInsert) or die("Error ".$mysqli->error);
			$HolidayId = $mysqli->insert_id; 

			for($i=0; $i<=sizeof($holiday_description)-1; $i++){

				$holidayRefInsert='INSERT INTO holiday_creation_ref(holiday_reff_id, holiday_date, holiday_description, insert_login_id)
				VALUES("'.strip_tags($HolidayId).'", "'.strip_tags($holiday_date[$i]).'", "'.strip_tags($holiday_description[$i]).'", "'.strip_tags($userid).'" )';
				$insresult=$mysqli->query($holidayRefInsert) or die("Error ".$mysqli->error);
			} 

			return true;
		}

		// Get holiday
		public function getHolidayCreation($mysqli, $id){

			$holiday1Select = "SELECT * FROM holiday_creation WHERE holiday_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($holiday1Select) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$holidayId  							= $row->holiday_id;
				$detailrecords['holiday_id']      	= $row->holiday_id;  
				$detailrecords['calendar_year']      	= $row->calendar_year;
			    $detailrecords['company_id']    		= $row->company_id;
			}
			
			$holidayRefid = 0;

			$holidaySelect = "SELECT * FROM holiday_creation_ref WHERE holiday_reff_id='".mysqli_real_escape_string($mysqli, $holidayId)."' "; 
			$res1 = $mysqli->query($holidaySelect) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				while($row1 = $res1->fetch_object()){

					$holidayRefid         		= $row1->holiday_ref_id; 
					$holiday_ref_id[]     			= $row1->holiday_ref_id; 
					$holiday_date[]             = $row1->holiday_date; 
					$holiday_description[]      = $row1->holiday_description;

				} 
			}
			if($holidayRefid > 0)
			{
				$detailrecords['holiday_ref_id']        = $holiday_ref_id; 
				$detailrecords['holiday_date']      = $holiday_date;
				$detailrecords['holiday_description']= $holiday_description;  	
				
			}
			else
			{
				$detailrecords['holiday_ref_id']          = array();
				$detailrecords['holiday_date']            = array();
				$detailrecords['holiday_description']     = array(); 
			}
			
			return $detailrecords;
		}

		// Update holiday
		public function updateHolidayCreation($mysqli, $id, $userid){ 

			if(isset($_POST['calendar_year'])){
				$calendar_year = $_POST['calendar_year'];
			}
			if(isset($_POST['company_id'])){
				$company_id1 = $_POST['company_id'];
				$company_id = implode(",", $company_id1); 
			}
			if(isset($_POST['holiday_date'])){
				$holiday_date = $_POST['holiday_date'];
			}
			if(isset($_POST['holiday_description'])){
				$holiday_description = $_POST['holiday_description'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			$updateQry = 'UPDATE holiday_creation SET company_id = "'.strip_tags($company_id).'", calendar_year = "'.strip_tags($calendar_year).'", status = "0"
			WHERE holiday_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 
			$DeleteHolidayRef = $mysqli->query("DELETE FROM holiday_creation_ref WHERE holiday_reff_id = '".$id."' "); 

			for($i=0; $i<=sizeof($holiday_description)-1; $i++){

				$holidayRefUpdate='INSERT INTO holiday_creation_ref(holiday_reff_id, holiday_date, holiday_description, insert_login_id)
				VALUES("'.strip_tags($id).'", "'.strip_tags($holiday_date[$i]).'", "'.strip_tags($holiday_description[$i]).'", "'.strip_tags($userid).'" )';
				$insresult=$mysqli->query($holidayRefUpdate) or die("Error ".$mysqli->error);
			} 

			return true;
		}

		//  Delete holiday
		public function deleteHolidayCreation($mysqli, $id, $userid){

			$holidayDelete = "UPDATE holiday_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE holiday_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($holidayDelete) or die("Error in delete query".$mysqli->error);
		}

		// Add Branch
		public function addTagCreation($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_idArr = $_POST['branch_id'];
                $company_id = implode(",", $company_idArr);
			}
			if(isset($_POST['department_id'])){
				$department_id = $_POST['department_id'];
			}
			if(isset($_POST['tag_classification'])){
				$tag_classification = $_POST['tag_classification'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			$tagInsert="INSERT INTO tag_creation(department_id, company_id, tag_classification, insert_login_id) 
			VALUES('".strip_tags($department_id)."', '".strip_tags($company_id)."', '".strip_tags($tag_classification)."', '".strip_tags($userid)."' )";
			$insresult=$mysqli->query($tagInsert) or die("Error ".$mysqli->error);
		}

		// Get tag
		public function getTagCreation($mysqli, $id){

			$tagSelect = "SELECT * FROM tag_creation WHERE tag_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($tagSelect) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['tag_id']      = $row->tag_id; 
				$detailrecords['department_id']      = $row->department_id;
				$detailrecords['company_id']    = $row->company_id;
				$detailrecords['tag_classification']      = $row->tag_classification;		
			}
			
			return $detailrecords;
		}

		// Update tag
		public function updateTagCreation($mysqli, $id, $userid){

			if(isset($_POST['branch_id'])){
				$company_idArr = $_POST['branch_id'];
                $company_id = implode(",", $company_idArr);
			}
			if(isset($_POST['department_id'])){
				$department_id = $_POST['department_id'];
			}
			if(isset($_POST['tag_classification'])){
				$tag_classification = $_POST['tag_classification'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 
		
		   $tagUpdaet = "UPDATE tag_creation SET department_id = '".strip_tags($department_id)."', company_id = '".strip_tags($company_id)."', 
		   tag_classification='".strip_tags($tag_classification)."',
		   update_login_id='".strip_tags($userid)."', status = '0' WHERE tag_id= '".strip_tags($id)."' ";
		   $updresult = $mysqli->query($tagUpdaet )or die ("Error in in update Query!.".$mysqli->error);
	 	}

		//  Delete Tag
		public function deleteTagCreation($mysqli, $id, $userid){

			$tagDelete = "UPDATE tag_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE tag_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($tagDelete) or die("Error in delete query".$mysqli->error);
		}

		// Add Audit
		public function addAuditAreaCreation($mysqli, $userid){

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			if(isset($_POST['audit_area'])){
				$audit_area = $_POST['audit_area'];
			}
			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['department_id'])){
				$department_id1 = $_POST['department_id'];
				$department_id = implode(",", $department_id1);
			}
			if(isset($_POST['calendar'])){
				$calendar = $_POST['calendar'];
			}
			if(isset($_POST['from_date'])){
				$from_date1 = $_POST['from_date'];
			}
			if(isset($_POST['to_date'])){
				$to_date1 = $_POST['to_date'];
			}
			if(isset($_POST['role1'])){
				$role1 = $_POST['role1'];
			}
			if(isset($_POST['role2'])){
				$role2 = $_POST['role2'];
			}
			if(isset($_POST['check_list'])){
				$check_list = $_POST['check_list'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			if($calendar == "No"){
				$from_date = '';
				$to_date = '';
			} else {
				$from_date = $from_date1.' '.$current_time;
				$to_date = $to_date1.' '.$current_time;
			}
		
			$auditInsert="INSERT INTO audit_area_creation(audit_area, frequency, department_id, calendar, from_date, to_date, role1, role2, check_list, insert_login_id) 
			VALUES('".strip_tags($audit_area)."', '".strip_tags($frequency)."', '".strip_tags($department_id)."', '".strip_tags($calendar)."', '".strip_tags($from_date)."', 
			'".strip_tags($to_date)."', '".strip_tags($role1)."', '".strip_tags($role2)."', '".strip_tags($check_list)."','".strip_tags($userid)."' )";

			$insresult=$mysqli->query($auditInsert) or die("Error ".$mysqli->error);
		}

		// Get Audit
		public function getAuditAreaCreation($mysqli, $id){

			$auditSelect = "SELECT * FROM audit_area_creation WHERE audit_area_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($auditSelect) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['audit_area_id']      = $row->audit_area_id; 
				$detailrecords['audit_area']      = $row->audit_area;
				$detailrecords['frequency']      = $row->frequency;
				$detailrecords['department_id']      = $row->department_id;  	
				$detailrecords['calendar']       = $row->calendar;
				$detailrecords['from_date']       = $row->from_date;
				$detailrecords['to_date']       = $row->to_date;
				$detailrecords['role1']       = $row->role1;
				$detailrecords['role2']         = $row->role2;
				$detailrecords['check_list']       = $row->check_list;
				
			}
			
			return $detailrecords;
		}

		// Update Audit
		public function updateAuditAreaCreation($mysqli, $id, $userid){

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			if(isset($_POST['audit_area'])){
				$audit_area = $_POST['audit_area'];
			}
			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['department_id'])){
				$department = $_POST['department_id'];
				$department_id = implode(',', $department);
			}
			if(isset($_POST['calendar'])){
				$calendar = $_POST['calendar'];
			}
			if(isset($_POST['from_date'])){
				$from_date1 = $_POST['from_date'];
			}
			if(isset($_POST['to_date'])){
				$to_date1 = $_POST['to_date'];
			}
			if(isset($_POST['role1'])){
				$role1 = $_POST['role1'];
			}
			if(isset($_POST['role2'])){
				$role2 = $_POST['role2'];
			}
			if(isset($_POST['check_list'])){
				$check_list = $_POST['check_list'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			if($calendar == "No"){
				$from_date = '';
				$to_date = '';
			} else {
				$from_date = $from_date1.' '.$current_time;
				$to_date = $to_date1.' '.$current_time;
			}
		
		   $auditUpdaet = "UPDATE audit_area_creation SET audit_area = '".strip_tags($audit_area)."', frequency='".strip_tags($frequency)."',
		   department_id='".strip_tags($department_id)."', calendar='".strip_tags($calendar)."', from_date='".strip_tags($from_date)."', to_date='".strip_tags($to_date)."',
		   role1='".strip_tags($role1)."', role2='".strip_tags($role2)."', check_list='".strip_tags($check_list)."', update_login_id='".strip_tags($userid)."', status = '0' 
		   WHERE audit_area_id= '".strip_tags($id)."' ";
		   $updresult = $mysqli->query($auditUpdaet )or die ("Error in in update Query!.".$mysqli->error);
	 	}

		//  Delete audit
		public function deleteAuditAreaCreation($mysqli, $id, $userid){

			$auditDelete = "UPDATE audit_area_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE audit_area_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($auditDelete) or die("Error in delete query".$mysqli->error);
		}

		// get Department
		public function getDepartment($mysqli) {

			$qry = "SELECT * FROM department_creation WHERE 1 AND status=0 ORDER BY department_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['department_id']            = $row->department_id; 
					$detailrecords[$i]['department_name']       	= strip_tags($row->department_name);
					$detailrecords[$i]['company_id']       	= strip_tags($row->company_id);
					$i++;
				}
			}
			return $detailrecords;
		}

		// get Department Based on Branch id
		public function getDepartment1($mysqli, $sbranch_id) {

			$qry = "SELECT * FROM department_creation WHERE company_id = '".$sbranch_id."' AND status=0 ORDER BY department_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['department_id']            = $row->department_id; 
					$detailrecords[$i]['department_name']       	= strip_tags($row->department_name);
					$detailrecords[$i]['company_id']       	= strip_tags($row->company_id);
					$i++;
				}
			}
			return $detailrecords;
		}

		// get Staff
		public function getStaff($mysqli) {
            $qry = "SELECT * FROM staff_creation WHERE 1 AND status=0 ORDER BY company_id DESC";
            $res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            $i=0;
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object())
                {
                    $detailrecords[$i]['staff_id']            = $row->staff_id;
                    $detailrecords[$i]['staff_name']        = strip_tags($row->staff_name);
                    $detailrecords[$i]['company_id']        = $row->company_id;
                    $i++;
                }
            }
            return $detailrecords;
        }
		
		// get Staff
		public function getStaff1($mysqli,$sbranch_id) {
            $qry = "SELECT * FROM staff_creation WHERE company_id = '".$sbranch_id."' AND status=0 ORDER BY company_id ASC";
            $res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            $i=0;
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object())
                {
                    $detailrecords[$i]['staff_id']            = $row->staff_id;
                    $detailrecords[$i]['staff_name']        = strip_tags($row->staff_name);
                    $detailrecords[$i]['company_id']        = $row->company_id;
                    $i++;
                }
            }
            return $detailrecords;
        }

		// get donor list
        public function getkrakpicompany($mysqli, $sbranch_id) {

			$company_id=array();
			$designation_id = array();

			if($sbranch_id == 'Overall'){
				
				$qry = "SELECT krakpi_id, company_name, designation FROM krakpi_creation WHERE 1 AND status=0 ORDER BY krakpi_id ASC";
				$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
				$j=0;
				while($fetchInstitute = $res->fetch_assoc()){
					$company_id[$j] =  $fetchInstitute['company_name'];
					$designation_id[$j] =  $fetchInstitute['designation'];
					$krakpi_id[$j] =  $fetchInstitute['krakpi_id'];
					$j++;
				}
			   
				$detailrecords = array();
				for($i=0; $i<=sizeof($company_id)-1; $i++){
					$detailrecords[$i]['krakpi'] = $krakpi_id[$i];
					$selectInstituteName=$mysqli->query("SELECT * FROM company_creation WHERE company_id = '".$company_id[$i]."' ");
					$selectDesignationName=$mysqli->query("SELECT * FROM designation_creation WHERE designation_id = '".$designation_id[$i]."' ");
					while($row=$selectInstituteName->fetch_assoc()){
						$detailrecords[$i]['company_id']     = $row["company_id"];
						$detailrecords[$i]['company_name']     = $row["company_name"];
					}
					while($row=$selectDesignationName->fetch_assoc()){
						$detailrecords[$i]['designation_id']     = $row["designation_id"];
						$detailrecords[$i]['designation_name']     = $row["designation_name"];
					}
				}
				
				return $detailrecords;

			}else{
				
				$qry = "SELECT krakpi_id, company_name, designation FROM krakpi_creation WHERE company_name = '".$sbranch_id."' AND status=0 ORDER BY designation ASC";
				$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
				$j=0;
				while($fetchInstitute = $res->fetch_assoc()){
					$company_id[$j] =  $fetchInstitute['company_name'];
					$designation_id[$j] =  $fetchInstitute['designation'];
					$krakpi_id[$j] =  $fetchInstitute['krakpi_id'];
					$j++;
				}
			   
				$detailrecords = array();
				for($i=0; $i<=sizeof($company_id)-1; $i++){
					$detailrecords[$i]['krakpi'] = $krakpi_id[$i];
					$selectInstituteName=$mysqli->query("SELECT * FROM company_creation WHERE company_id = '".$company_id[$i]."' ");
					$selectDesignationName=$mysqli->query("SELECT * FROM designation_creation WHERE designation_id = '".$designation_id[$i]."' ");
					while($row=$selectInstituteName->fetch_assoc()){
						$detailrecords[$i]['company_id']     = $row["company_id"];
						$detailrecords[$i]['company_name']     = $row["company_name"];
					}
					while($row=$selectDesignationName->fetch_assoc()){
						$detailrecords[$i]['designation_id']     = $row["designation_id"];
						$detailrecords[$i]['designation_name']     = $row["designation_name"];
					}
				}
				return $detailrecords;
			}
            
        }

		// get course category
		public function getDesignation($mysqli) {

			$qry = "SELECT * FROM designation_creation WHERE 1 AND status=0 ORDER BY designation_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['designation_id']            = $row->designation_id; 
					$detailrecords[$i]['designation_name']       	= strip_tags($row->designation_name);
					$detailrecords[$i]['company_id']       	= strip_tags($row->company_id);
					$i++;
				}
			}
			return $detailrecords;
		}

		// get course category
		public function getDesignationSession($mysqli, $sbranch_id) {

			$qry = "SELECT * FROM designation_creation WHERE company_id = '".$sbranch_id."' AND status=0 ORDER BY designation_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['designation_id']            = $row->designation_id; 
					$detailrecords[$i]['designation_name']       	= strip_tags($row->designation_name);
					$i++;
				}
			}
			return $detailrecords;
		}

		// Add Basic Creation
        public function addBasicCreation($mysqli, $userid){
            if(isset($_POST['branch_id'])){
                $company_id = $_POST['branch_id'];
            }
            if(isset($_POST['department_code'])){
                $department_code = $_POST['department_code'];
            }
            if(isset($_POST['department'])){
                $department = $_POST['department'];
                // $department = implode(",", $department1);
            }
            if(isset($_POST['designation_code'])){
                $designation_code = $_POST['designation_code'];
            }
			// $designation_id = 1;
            if(isset($_POST['designation'])){
				$designation1 = $_POST['designation'];
				$designation = implode(",", $designation1);
                //  $designation = explode(",", $designation1);
				// echo "<script>alert('".$designation1."');</script>";
				//  for($i=0;$i<count($designation);$i++){
				// 	$qry = "SELECT * FROM designation_creation WHERE designation_name='".$designation[$i]."'"; 
				// 	$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
				// 	if ($mysqli->affected_rows>0)
				// 	{
				// 		while($row = $res->fetch_object())
				// 		{
				// 			$designation_id            = $row->designation_id; 
				// 		}
				// 	}
				// }
			}
            if(isset($_POST['userid'])){
                $userid = $_POST['userid'];
            }
			$report_to = '';
			if(isset($_POST['report_to'])){
                $report_to = $_POST['report_to'];
            }
            // if($type == "Common"){
            //  $selectCompany = $mysqli->query("SELECT * FROM company_creation WHERE 1 AND status=0");
            //  $i=0;
            //  if ($mysqli->affected_rows>0)
            //  {
            //      while($row = $selectCompany->fetch_object())
            //      {
            //          $detailrecords[$i]['company_id']            = $row->company_id;
            //          $detailrecords[$i]['company_name']          = strip_tags($row->company_name);
            //          $i++;
            //      }
            //  }
            //  for($i=0; $i<=sizeof($detailrecords)-1; $i++){
            //      $basicInsert="INSERT INTO basic_creation(type, company_id, department_code, department, designation_code, designation, insert_login_id)
            //      VALUES('".strip_tags($type)."', '".strip_tags($detailrecords[$i]['company_id'])."', '".strip_tags($department_code)."', '".strip_tags($department)."',
            //      '".strip_tags($designation_code)."', '".strip_tags($designation)."','".strip_tags($userid)."')";
            //      $insresult=$mysqli->query($basicInsert) or die("Error ".$mysqli->error);
            //  }
            // }else if($type == "Specific"){
                $basicInsert="INSERT INTO basic_creation(company_id, department_code, department, designation_code, designation, report_to, insert_login_id)
                VALUES( '".strip_tags($company_id)."', '".strip_tags($department_code)."', '".strip_tags($department)."',
                '".strip_tags($designation_code)."', '".strip_tags($designation)."', '".strip_tags($report_to)."', '".strip_tags($userid)."')";
                $insresult=$mysqli->query($basicInsert) or die("Error ".$mysqli->error);
            // }
        }

		// Get basic
		public function getBasicCreation($mysqli, $id){

			$basicSelect = "SELECT * FROM basic_creation WHERE basic_creation_id='". $id."' "; 
			$res = $mysqli->query($basicSelect) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['basic_creation_id']      = $row->basic_creation_id; 
				$detailrecords['type']      = $row->type;
				$detailrecords['company_id']    = $row->company_id;
				$detailrecords['department_code']      = $row->department_code;
				$detailrecords['department']      = $row->department;  	
				$detailrecords['designation_code']       = $row->designation_code;
				$detailrecords['designation']         = $row->designation;
				$detailrecords['report_to']         = $row->report_to;
								
			}
			
			return $detailrecords;
		}
		

		// Update basic
        public function updateBasicCreation($mysqli, $id, $userid){

            // if(isset($_POST['type'])){
            // $type = $_POST['type'];
            // }
            if(isset($_POST['branch_id'])){
                $company_id = $_POST['branch_id'];
            }
            if(isset($_POST['department_code'])){
                $department_code = $_POST['department_code'];
            }
            if(isset($_POST['department'])){
                $department = $_POST['department'];
            }
            if(isset($_POST['designation_code'])){
                $designation_code = $_POST['designation_code'];
            }
            if(isset($_POST['designation'])){
                $designation1 = $_POST['designation'];
                $designation = implode(",", $designation1);
            }
            if(isset($_POST['userid'])){
                $userid = $_POST['userid'];
            }
			if(isset($_POST['report_to'])){
                $report_to = $_POST['report_to'];
            }

            $basicUpdaet = "UPDATE basic_creation SET company_id = '".strip_tags($company_id)."', department_code='".strip_tags($department_code)."',
            department='".strip_tags($department)."', designation_code='".strip_tags($designation_code)."',
            designation='".strip_tags($designation)."',report_to = '".strip_tags($report_to)."', update_login_id='".strip_tags($userid)."', status = 0 
			WHERE basic_creation_id = '".strip_tags($id)."' "; 
            $updresult = $mysqli->query($basicUpdaet) or die ("Error in in update Query!.".$mysqli->error);
        }

		//  Delete basic
		public function deleteBasicCreation($mysqli, $id, $userid){

			$basicDelete = "UPDATE basic_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE basic_creation_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($basicDelete) or die("Error in delete query".$mysqli->error);
		}

		// Add Branch
		public function addStaffCreation($mysqli, $userid){

			if(isset($_POST['designation'])){
				$designation = $_POST['designation'];
			}
			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['staff_name'])){
				$staff_name = $_POST['staff_name'];
			}
			if(isset($_POST['reporting'])){
				$reporting = $_POST['reporting'];
			}
			if(isset($_POST['emp_code'])){
				$emp_code = $_POST['emp_code'];
			}
			if(isset($_POST['department'])){
				$department = $_POST['department'];
			}
			if(isset($_POST['doj'])){
				$doj = $_POST['doj'];
			}
			if(isset($_POST['krikpi'])){
				$krikpi = $_POST['krikpi'];
			}
			if(isset($_POST['dob'])){
				$dob = $_POST['dob'];
			}
			if(isset($_POST['key_skills'])){
				$key_skills = $_POST['key_skills'];
			}
			if(isset($_POST['contact_number'])){
				$contact_number = $_POST['contact_number'];
			}
			if(isset($_POST['email_id'])){
				$email_id = $_POST['email_id'];
			}
			
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 
		
			$staffInsert="INSERT INTO staff_creation(designation, company_id, staff_name, reporting, emp_code, department, doj, krikpi, 
			dob, key_skills, contact_number, email_id, insert_login_id) 
			VALUES('".strip_tags($designation)."', '".strip_tags($company_id)."', '".strip_tags($staff_name)."', '".strip_tags($reporting)."', 
			'".strip_tags($emp_code)."', '".strip_tags($department)."', '".strip_tags($doj)."', '".strip_tags($krikpi)."', '".strip_tags($dob)."',
			'".strip_tags($key_skills)."','".strip_tags($contact_number)."','".strip_tags($email_id)."','".strip_tags($userid)."' )";

			$insresult=$mysqli->query($staffInsert) or die("Error ".$mysqli->error);
		}

		// Get Staff
		public function getStaffCreation($mysqli, $id){

			$staffSelect = "SELECT * FROM staff_creation WHERE staff_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($staffSelect) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['staff_id']      = $row->staff_id; 
				$detailrecords['designation']      = $row->designation;
				$detailrecords['company_id']    = $row->company_id;
				$detailrecords['staff_name']      = $row->staff_name;
				$detailrecords['reporting']      = $row->reporting;  	
				$detailrecords['emp_code']       = $row->emp_code;
				$detailrecords['department']         = $row->department;
				$detailrecords['doj']       = $row->doj;
				$detailrecords['krikpi']       = $row->krikpi;
				$detailrecords['dob']       = $row->dob;
				$detailrecords['key_skills']       = $row->key_skills;
				$detailrecords['contact_number']       = $row->contact_number;
				$detailrecords['email_id']       = $row->email_id;
				
			}
			
			return $detailrecords;
		}

		// Update Staff
		public function updateStaffCreation($mysqli, $id, $userid){

			if(isset($_POST['designation'])){
				$designation = $_POST['designation'];
			}
			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['staff_name'])){
				$staff_name = $_POST['staff_name'];
			}
			if(isset($_POST['reporting'])){
				$reporting = $_POST['reporting'];
			}
			if(isset($_POST['emp_code'])){
				$emp_code = $_POST['emp_code'];
			}
			if(isset($_POST['department'])){
				$department = $_POST['department'];
			}
			if(isset($_POST['doj'])){
				$doj = $_POST['doj'];
			}
			if(isset($_POST['krikpi'])){
				$krikpi = $_POST['krikpi'];
			}
			if(isset($_POST['dob'])){
				$dob = $_POST['dob'];
			}
			if(isset($_POST['key_skills'])){
				$key_skills = $_POST['key_skills'];
			}
			if(isset($_POST['contact_number'])){
				$contact_number = $_POST['contact_number'];
			}
			if(isset($_POST['email_id'])){
				$email_id = $_POST['email_id'];
			}
	
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 
		
		   $staffUpdaet = "UPDATE staff_creation SET designation = '".strip_tags($designation)."', company_id = '".strip_tags($company_id)."', staff_name='".strip_tags($staff_name)."', 
		   reporting='".strip_tags($reporting)."', emp_code='".strip_tags($emp_code)."', 
		   department='".strip_tags($department)."', doj='".strip_tags($doj)."', krikpi='".strip_tags($krikpi)."', dob='".strip_tags($dob)."',
		   key_skills='".strip_tags($key_skills)."',contact_number='".strip_tags($contact_number)."', email_id='".strip_tags($email_id)."',
		   update_login_id='".strip_tags($userid)."', status = '0' WHERE staff_id= '".strip_tags($id)."' ";
		   $updresult = $mysqli->query($staffUpdaet )or die ("Error in in update Query!.".$mysqli->error);
		
	 	}

		//  Delete Staff
		public function deleteStaffCreation($mysqli, $id, $userid){

			$staffDelete = "UPDATE staff_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE staff_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($staffDelete) or die("Error in delete query".$mysqli->error);
		}

		// get r&r
        public function getRNR($mysqli) {
            $qry = "SELECT * FROM rr_creation_ref WHERE 1 AND status=0 ORDER BY rr_ref_id ASC";
            $res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            $i=0;
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object())
                {
                    $detailrecords[$i]['rr_ref_id']            = $row->rr_ref_id;
                    $detailrecords[$i]['rr']        = strip_tags($row->rr);
                    $i++;
                }
            }
            return $detailrecords;
        }

		// get r&r
        public function getRNRDepartmentBased($mysqli, $company_id, $department_id) {

			$qry = "SELECT rr_ref_id, rr FROM rr_creation_ref LEFT JOIN rr_creation ON rr_creation_ref.rr_reff_id = rr_creation.rr_id 
			WHERE rr_creation.company_name = '".$company_id."' AND rr_creation.status = 0 ";

            // $qry = "SELECT * FROM rr_creation_ref WHERE 1 AND status=0 ORDER BY rr_ref_id ASC";
            $res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            $i=0;
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object())
                {
                    $detailrecords[$i]['rr_ref_id']  = $row->rr_ref_id;
                    $detailrecords[$i]['rr']         = strip_tags($row->rr);
                    $i++;
                }
            }

            return $detailrecords;
        }

		// get r&r
        public function getRNRBranchBased($mysqli) {
            $qry = "SELECT * FROM rr_creation_ref WHERE 1 AND status=0 ORDER BY rr_ref_id ASC";
            $res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            $i=0;
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object())
                {
                    $detailrecords[$i]['rr_ref_id']            = $row->rr_ref_id;
                    $detailrecords[$i]['rr']        = strip_tags($row->rr);
                    $i++;
                }
            }
            return $detailrecords;
        }

		// Add r&r
		public function addRolesResponsibilityCreation($mysqli, $userid){

			if(isset($_POST['department'])){
				$department = $_POST['department'];
			}
			if(isset($_POST['company_name'])){
				$company_name = $_POST['company_name'];
			}
			if(isset($_POST['designation'])){
				$designation = $_POST['designation'];
			}
			if(isset($_POST['rr'])){
				$rr = $_POST['rr'];
			}
			// if(isset($_POST['applicability'])){
			// 	$applicability = $_POST['applicability'];
			// }
			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			// if(isset($_POST['code_ref'])){
			// 	$code_ref = $_POST['code_ref'];
			// }
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			$rrInsert="INSERT INTO rr_creation(company_name, insert_login_id) VALUES('".strip_tags($company_name)."', '".strip_tags($userid)."')";
			$insresult=$mysqli->query($rrInsert) or die("Error ".$mysqli->error);
			$RRId = $mysqli->insert_id; 

			for($i=0; $i<=sizeof($department)-1; $i++){

				$rr1Insert="INSERT INTO rr_creation_ref(rr_reff_id,rr, department, designation, frequency, insert_login_id)
				VALUES('".strip_tags($RRId)."', '".strip_tags($rr[$i])."','".strip_tags($department[$i])."', '".strip_tags($designation[$i])."',
				'".strip_tags($frequency[$i])."', '".strip_tags($userid)."' )";
				$insresult=$mysqli->query($rr1Insert) or die("Error ".$mysqli->error);
			} 

			return true;
		}

		// Get r&r
		public function getRolesResponsibilityCreation($mysqli, $id){

			$rr1Select = "SELECT * FROM rr_creation WHERE rr_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($rr1Select) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$rrId  							= $row->rr_id;
				$detailrecords['rr_id']      	= $row->rr_id;  
			    $detailrecords['company_name']  = $row->company_name;
			}
			
			$rrRefid = 0;
			$rrSelect = "SELECT * FROM rr_creation_ref WHERE rr_reff_id='".mysqli_real_escape_string($mysqli, $rrId)."' "; 
			$res1 = $mysqli->query($rrSelect) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				while($row1 = $res1->fetch_object()){

					$rrRefid         		= $row1->rr_ref_id; 
					$rr_ref_id[]     			= $row1->rr_ref_id; 
					$department[]             = $row1->department; 
					$designation[]      = $row1->designation;
					// $applicability[]      = $row1->applicability;
					$frequency[]      = $row1->frequency;
					// $code_ref[]      = $row1->code_ref;
					$rr[]      = $row1->rr;

				} 
			}
			if($rrRefid > 0)
			{
				$detailrecords['rr_ref_id']        = $rr_ref_id; 
				$detailrecords['department']      = $department;
				$detailrecords['designation'] = $designation;  	
				// $detailrecords['code_ref']   = $code_ref;  	
				$detailrecords['frequency']   = $frequency;  	
				// $detailrecords['applicability']  = $applicability;
				$detailrecords['rr'] = $rr;  	
				
			}
			else
			{
				$detailrecords['rr_ref_id']      = array();
				$detailrecords['department']     = array();
				$detailrecords['designation']    = array(); 
				// $detailrecords['applicability']  = array(); 
				$detailrecords['frequency']      = array(); 
				// $detailrecords['code_ref']       = array(); 
				$detailrecords['rr']             = array(); 
			}
			
			return $detailrecords;
		}

		// Update r&r
		public function updateRolesResponsibilityCreation($mysqli, $id, $userid){ 

			if(isset($_POST['department'])){
				$department = $_POST['department'];
			}
			if(isset($_POST['company_name'])){
				$company_name = $_POST['company_name'];
			}
			if(isset($_POST['designation'])){
				$designation = $_POST['designation'];
			} 
			if(isset($_POST['rr'])){
				$rr = $_POST['rr'];
			}
			// if(isset($_POST['applicability'])){
			// 	$applicability = $_POST['applicability'];
			// }
			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			// if(isset($_POST['code_ref'])){
			// 	$code_ref = $_POST['code_ref'];
			// }
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			$updateQry = 'UPDATE rr_creation SET company_name = "'.strip_tags($company_name).'", status = "0" WHERE rr_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

			$DeleterrRef = $mysqli->query("DELETE FROM rr_creation_ref WHERE rr_reff_id = '".$id."' "); 

			for($i=0; $i<=sizeof($department)-1; $i++){

				$rrUpdaet = "INSERT INTO rr_creation_ref(rr_reff_id, rr, department, designation,frequency, insert_login_id) 
					VALUES('".strip_tags($id)."', '".strip_tags($rr[$i])."','".strip_tags($department[$i])."', '".strip_tags($designation[$i])."', 
					'".strip_tags($frequency[$i])."','".strip_tags($userid)."')";
				$updresult = $mysqli->query($rrUpdaet)or die ("Error in in update Query!.".$mysqli->error);
			} 

			return true;
		}

		//  Delete r&r
		public function deleteRolesResponsibilityCreation($mysqli, $id, $userid){

			$rrDelete = "UPDATE rr_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE rr_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($rrDelete) or die("Error in delete query".$mysqli->error);
		}

		// Add krakpi
        public function addKraKpiCreation($mysqli, $userid){

            if(isset($_POST['department'])){
                $department = $_POST['department'];
            }
            if(isset($_POST['company_name'])){
                $company_name = $_POST['company_name'];
            }
            if(isset($_POST['designation'])){
                $designation = $_POST['designation'];
            }
            if(isset($_POST['rr'])){
                $rr = $_POST['rr'];
            }
            if(isset($_POST['criteria'])){
                $criteria = $_POST['criteria'];
            }
            if(isset($_POST['project'])){
                $project_id = $_POST['project'];
            }
            if(isset($_POST['frequency'])){
                $frequency = $_POST['frequency'];
            }
            if(isset($_POST['calendar'])){
				$calendar = $_POST['calendar'];
            } 
            if(isset($_POST['from_date'])){
				$from_date1 = $_POST['from_date'];
            }
            if(isset($_POST['to_date'])){
				$to_date1 = $_POST['to_date'];
            }
            if(isset($_POST['userid'])){
                $userid = $_POST['userid'];
            }
			if(isset($_POST['kra_category'])){
                $kra_category = $_POST['kra_category'];
            } 
			if(isset($_POST['kpi'])){
                $kpi = $_POST['kpi'];
            }

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

            $rrInsert="INSERT INTO krakpi_creation(company_name, department, designation, insert_login_id) VALUES('".strip_tags($company_name)."', 
			'".strip_tags($department)."', '".strip_tags($designation)."', '".strip_tags($userid)."' )";
            $insresult=$mysqli->query($rrInsert) or die("Error ".$mysqli->error);
            $RRId = $mysqli->insert_id;

            for($i=0; $i<=sizeof($rr)-1; $i++){

				if($calendar[$i] == "No"){
					$from_date = '';
				}else{
					$from_date = $from_date1[$i].' '.$current_time;
				}

				if($calendar[$i] == "No"){
					$to_date = '';
				} else {
					$to_date = $to_date1[$i].' '.$current_time;
				}

				$krakpiInsert="INSERT INTO krakpi_creation_ref(krakpi_reff_id,rr, criteria, project_id, frequency, calendar, from_date, to_date, insert_login_id, kra_category, 
				kpi) VALUES ('".strip_tags($RRId)."', '".strip_tags($rr[$i])."','".strip_tags($criteria[$i])."', '".strip_tags($project_id[$i])."', '".strip_tags($frequency[$i])."', 
				'".strip_tags($calendar[$i])."', '".strip_tags($from_date)."', '".strip_tags($to_date)."', '".strip_tags($userid)."', '".strip_tags($kra_category[$i])."', 
				'".strip_tags($kpi[$i])."' )";
				$insresult=$mysqli->query($krakpiInsert) or die("Error ".$mysqli->error); 
			} 

			return true;
    	}

        // Get krakpi
        public function getKraKpiCreation($mysqli, $id){

            $rr1Select = "SELECT * FROM krakpi_creation WHERE krakpi_id='".mysqli_real_escape_string($mysqli, $id)."' ";
            $res = $mysqli->query($rr1Select) or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            if ($mysqli->affected_rows>0)
            {
                $row = $res->fetch_object();
                $rrId                                  = $row->krakpi_id;
                $detailrecords['krakpi_id']             = $row->krakpi_id;
                $detailrecords['company_name']          = $row->company_name;
                $detailrecords['department']            = $row->department;
                $detailrecords['designation']           = $row->designation;
            }
            $rrRefid = 0;
            $rrSelect = "SELECT * FROM krakpi_creation_ref WHERE krakpi_reff_id='".mysqli_real_escape_string($mysqli, $rrId)."' ";
            $res1 = $mysqli->query($rrSelect) or die("Error in Get All Records".$mysqli->error);
            if ($mysqli->affected_rows>0)
            {
                while($row1 = $res1->fetch_object()){
                    $rrRefid               = $row1->krakpi_ref_id;
                    $krakpi_ref_id[]       = $row1->krakpi_ref_id;
                    $criteria[]       = $row1->criteria;
                    $project_id[]       = $row1->project_id;
                    $frequency[]           = $row1->frequency;
                    $calendar[]           = $row1->calendar;
                    $from_date[]           = $row1->from_date;
                    $to_date[]           = $row1->to_date;
                    $rr[]                  = $row1->rr;
                    $kra_category[]        = $row1->kra_category;
                    $kpi[]                 = $row1->kpi;
                }
            }
            if($rrRefid > 0)
            {
                $detailrecords['krakpi_ref_id'] = $krakpi_ref_id;
                $detailrecords['code_ref'] = $code_ref;
                $detailrecords['frequency'] = $frequency;
                $detailrecords['calendar'] = $calendar;
                $detailrecords['from_date'] = $from_date;
                $detailrecords['to_date'] = $to_date;
                $detailrecords['criteria'] = $criteria;
                $detailrecords['project_id'] = $project_id;
                $detailrecords['rr'] = $rr;
                $detailrecords['kra_category'] = $kra_category;
                $detailrecords['kpi'] = $kpi;
            }
            else
            {
                $detailrecords['krakpi_ref_id'] = array();
                $detailrecords['criteria'] = array();
                $detailrecords['project_id'] = array();
                $detailrecords['frequency']     = array();
                $detailrecords['calendar']     = array();
                $detailrecords['from_date']     = array();
                $detailrecords['to_date']     = array();
                $detailrecords['code_ref']      = array();
                $detailrecords['rr']            = array();
                $detailrecords['kra_category']            = array();
                $detailrecords['kpi']            = array();
            }
            
            return $detailrecords;
        }

        // Update krakpi
        public function updateKraKpiCreation($mysqli, $id, $userid){

            if(isset($_POST['department'])){
                $department = $_POST['department'];
            }
            if(isset($_POST['company_name'])){
                $company_name = $_POST['company_name'];
            }
            if(isset($_POST['designation'])){
                $designation = $_POST['designation'];
            }
            if(isset($_POST['rr'])){
                $rr = $_POST['rr'];
            }
            if(isset($_POST['criteria'])){
                $criteria = $_POST['criteria'];
            }
            if(isset($_POST['project'])){
                $project_id = $_POST['project'];
            }
            if(isset($_POST['frequency'])){
                $frequency = $_POST['frequency'];
            }
			if(isset($_POST['calendar'])){
				$calendar = $_POST['calendar'];
            }
			if(isset($_POST['from_date'])){
				$from_date1 = $_POST['from_date'];
            }
            if(isset($_POST['to_date'])){
				$to_date1 = $_POST['to_date'];
            } 
            if(isset($_POST['userid'])){
                $userid = $_POST['userid'];
            }
			if(isset($_POST['kra_category'])){
                $kra_category = $_POST['kra_category'];
            }
			if(isset($_POST['kpi'])){
                $kpi = $_POST['kpi'];
            }

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

            $updateQry = 'UPDATE krakpi_creation SET company_name = "'.strip_tags($company_name).'", department = "'.strip_tags($department).'", 
			designation = "'.strip_tags($designation).'", status = "0" WHERE krakpi_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
            $res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error);
            $DeleterrRef = $mysqli->query("DELETE FROM krakpi_creation_ref WHERE krakpi_reff_id = '".$id."' ");

            for($i=0; $i<=sizeof($rr)-1; $i++){

				if($calendar[$i] == "No"){
					$from_date = '';
				}else{
					$from_date = $from_date1[$i].' '.$current_time;
				}

				if($calendar[$i] == "No"){
					$to_date = '';
				} else {
					$to_date = $to_date1[$i].' '.$current_time;
				}

				$rrUpdaet = "INSERT INTO krakpi_creation_ref(krakpi_reff_id, rr, criteria, project_id, frequency, calendar, from_date, to_date, insert_login_id, 
				kra_category, kpi)
				VALUES('".strip_tags($id)."', '".strip_tags($rr[$i])."', '".strip_tags($criteria[$i])."', '".strip_tags($project_id[$i])."', '".strip_tags($frequency[$i])."', 
				'".strip_tags($calendar[$i])."','".strip_tags($from_date)."', '".strip_tags($to_date)."', '".strip_tags($userid)."', '".strip_tags($kra_category[$i])."', 
				'".strip_tags($kpi[$i])."')";  
				$updresult = $mysqli->query($rrUpdaet)or die ("Error in in update Query!.".$mysqli->error);
			}

			return true;
		}

		//  Delete krakpi
		public function deleteKraKpiCreation($mysqli, $id, $userid){

			$rrDelete = "UPDATE krakpi_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE krakpi_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($rrDelete) or die("Error in delete query".$mysqli->error);
		}

		// get project creation name list
		public function getProjectCreationList($mysqli) {

			$qry = "SELECT * FROM project_creation WHERE 1 AND status=0 ORDER BY project_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['project_id']            = $row->project_id; 
					$detailrecords[$i]['project_name']       	= strip_tags($row->project_name);
					$i++;
				}
			}
			return $detailrecords;
		}

		// // Add krakpi
        // public function addKraKpiCreation($mysqli, $userid){

        //     if(isset($_POST['department'])){
        //         $department = $_POST['department'];
        //     }
        //     if(isset($_POST['branch_id'])){
        //         $company_name = $_POST['branch_id'];
        //     }
        //     if(isset($_POST['designation'])){
        //         $designation = $_POST['designation'];
        //     }
        //     if(isset($_POST['rr'])){
        //         $rr = $_POST['rr'];
        //     }
        //     if(isset($_POST['applicability'])){
        //         $applicability = $_POST['applicability'];
        //     }
        //     if(isset($_POST['frequency'])){
        //         $frequency = $_POST['frequency'];
        //     }
        //     if(isset($_POST['code_ref'])){
        //         $code_ref = $_POST['code_ref'];
        //     }
        //     if(isset($_POST['userid'])){
        //         $userid = $_POST['userid'];
        //     }

		// 	if(isset($_POST['kra_category'])){
        //         $kra_category = $_POST['kra_category'];
        //     } 

		// 	if(isset($_POST['kpi'])){
        //         $kpi = $_POST['kpi'];
        //     }

        //     $rrInsert="INSERT INTO krakpi_creation(company_name, department, designation, insert_login_id)
        //     VALUES('".strip_tags($company_name)."','".strip_tags($department)."', '".strip_tags($designation)."', '".strip_tags($userid)."' )";
        //     $insresult=$mysqli->query($rrInsert) or die("Error ".$mysqli->error);
        //     $RRId = $mysqli->insert_id;

        //     for($i=0; $i<=sizeof($rr)-1; $i++){
		// 		$rr1Insert="INSERT INTO krakpi_creation_ref(krakpi_reff_id,rr, applicability,frequency, code_ref,insert_login_id, kra_category, kpi)
		// 		VALUES('".strip_tags($RRId)."', '".strip_tags($rr[$i])."','".strip_tags($applicability[$i])."',
		// 		'".strip_tags($frequency[$i])."','".strip_tags($code_ref[$i])."','".strip_tags($userid)."', '".strip_tags($kra_category[$i])."', '".strip_tags($kpi[$i])."' )"; 
		// 		$insresult=$mysqli->query($rr1Insert) or die("Error ".$mysqli->error); 
		// 	} 

		// 	return true;
    	// }

        // // Get krakpi
        // public function getKraKpiCreation($mysqli, $id){

        //     $rr1Select = "SELECT * FROM krakpi_creation WHERE krakpi_id='".mysqli_real_escape_string($mysqli, $id)."' ";
        //     $res = $mysqli->query($rr1Select) or die("Error in Get All Records".$mysqli->error);
        //     $detailrecords = array();
        //     if ($mysqli->affected_rows>0)
        //     {
        //         $row = $res->fetch_object();
        //         $rrId                           = $row->krakpi_id;
        //         $detailrecords['krakpi_id']         = $row->krakpi_id;
        //         $detailrecords['company_name']          = $row->company_name;
        //         $detailrecords['department']            = $row->department;
        //         $detailrecords['designation']           = $row->designation;
        //     }
        //     $rrRefid = 0;
        //     $rrSelect = "SELECT * FROM krakpi_creation_ref WHERE krakpi_reff_id='".mysqli_real_escape_string($mysqli, $rrId)."' ";
        //     $res1 = $mysqli->query($rrSelect) or die("Error in Get All Records".$mysqli->error);
        //     if ($mysqli->affected_rows>0)
        //     {
        //         while($row1 = $res1->fetch_object()){
        //             $rrRefid               = $row1->krakpi_ref_id;
        //             $krakpi_ref_id[]       = $row1->krakpi_ref_id;
        //             $applicability[]       = $row1->applicability;
        //             $frequency[]           = $row1->frequency;
        //             $code_ref[]            = $row1->code_ref;
        //             $rr[]                  = $row1->rr;
        //             $kra_category[]        = $row1->kra_category;
        //             $kpi[]                 = $row1->kpi;
        //         }
        //     }
        //     if($rrRefid > 0)
        //     {
        //         $detailrecords['krakpi_ref_id'] = $krakpi_ref_id;
        //         $detailrecords['code_ref'] = $code_ref;
        //         $detailrecords['frequency'] = $frequency;
        //         $detailrecords['applicability'] = $applicability;
        //         $detailrecords['rr'] = $rr;
        //         $detailrecords['kra_category'] = $kra_category;
        //         $detailrecords['kpi'] = $kpi;
        //     }
        //     else
        //     {
        //         $detailrecords['krakpi_ref_id'] = array();
        //         $detailrecords['applicability'] = array();
        //         $detailrecords['frequency']     = array();
        //         $detailrecords['code_ref']      = array();
        //         $detailrecords['rr']            = array();
        //         $detailrecords['kra_category']            = array();
        //         $detailrecords['kpi']            = array();
        //     }
            
        //     return $detailrecords;
        // }

        // // Update krakpi
        // public function updateKraKpiCreation($mysqli, $id, $userid){

        //     if(isset($_POST['department'])){
        //         $department = $_POST['department'];
        //     }
        //     if(isset($_POST['branch_id'])){
        //         $company_name = $_POST['branch_id'];
        //     }
        //     if(isset($_POST['designation'])){
        //         $designation = $_POST['designation'];
        //     }
        //     if(isset($_POST['rr'])){
        //         $rr = $_POST['rr'];
        //     }
        //     if(isset($_POST['applicability'])){
        //         $applicability = $_POST['applicability'];
        //     }
        //     if(isset($_POST['frequency'])){
        //         $frequency = $_POST['frequency'];
        //     }
        //     if(isset($_POST['code_ref'])){
        //         $code_ref = $_POST['code_ref'];
        //     }
        //     if(isset($_POST['userid'])){
        //         $userid = $_POST['userid'];
        //     }

		// 	if(isset($_POST['kra_category'])){
        //         $kra_category = $_POST['kra_category'];
        //     }
		// 	if(isset($_POST['kpi'])){
        //         $kpi = $_POST['kpi'];
        //     }

        //     $updateQry = 'UPDATE krakpi_creation SET company_name = "'.strip_tags($company_name).'", department = "'.strip_tags($department).'", 
		// 	designation = "'.strip_tags($designation).'", status = "0" WHERE krakpi_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
        //     $res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error);
        //     $DeleterrRef = $mysqli->query("DELETE FROM krakpi_creation_ref WHERE krakpi_reff_id = '".$id."' ");

        //     for($i=0; $i<=sizeof($rr)-1; $i++){
		// 		$rrUpdaet = "INSERT INTO krakpi_creation_ref(krakpi_reff_id, rr, applicability, frequency, code_ref, insert_login_id, kra_category, kpi)
		// 			VALUES('".strip_tags($id)."', '".strip_tags($rr[$i])."','".strip_tags($applicability[$i])."', '".strip_tags($frequency[$i])."', 
		// 			'".strip_tags($code_ref[$i])."','".strip_tags($userid)."', '".strip_tags($kra_category[$i])."', '".strip_tags($kpi[$i])."')"; 
		// 		$updresult = $mysqli->query($rrUpdaet)or die ("Error in in update Query!.".$mysqli->error);
		// 	}

		// 	return true;
		// }

		// //  Delete krakpi
		// public function deleteKraKpiCreation($mysqli, $id, $userid){

		// 	$rrDelete = "UPDATE krakpi_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE krakpi_id = '".strip_tags($id)."' ";
		// 	$runQry = $mysqli->query($rrDelete) or die("Error in delete query".$mysqli->error);
		// }

		//get Audit area table
        public function getAuditAreaTable($mysqli){

            $auditSelect = "SELECT * FROM audit_area_creation WHERE check_list = 'Yes' ";
            $res = $mysqli->query($auditSelect) or die("Error in Get All Records".$mysqli->error);
            $audit_area_list = array();
            $i=0;

            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object()){

					$audit_area_list[$i]['audit_area_id']      = $row->audit_area_id;
					$audit_area_list[$i]['audit_area']      = $row->audit_area;
					$audit_area_list[$i]['role1']       = $row->role1;
					$audit_area_list[$i]['role2']         = $row->role2;
					$i++;
                }
            }

            return $audit_area_list;
        }

		//get Audit area table
        public function getAuditAreaTable1($mysqli, $sbranch_id){

            $auditSelect = "SELECT audit_area_creation.* FROM audit_area_creation INNER JOIN department_creation ON department_creation.department_id = audit_area_creation.department_id WHERE audit_area_creation.status = 0 and department_creation.status = 0 and department_creation.company_id = '".$sbranch_id."' ";
            $res = $mysqli->query($auditSelect) or die("Error in Get All Records".$mysqli->error);
            $audit_area_list = array();
            $i=0;

            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object()){

					$audit_area_list[$i]['audit_area_id']      = $row->audit_area_id;
					$audit_area_list[$i]['audit_area']      = $row->audit_area;
					$audit_area_list[$i]['role1']       = $row->role1;
					$audit_area_list[$i]['role2']         = $row->role2;
					$i++;
                }
            }

            return $audit_area_list;
        }

		// get Audit area Checklist table
        public function getAuditAreaChecklist($mysqli,$id){

            if($id>0){
                $checklistSelect = "SELECT * FROM audit_checklist where audit_checklist_id= '$id' ";
            }else{
                $checklistSelect = "SELECT * FROM audit_checklist";
            }
            $res = $mysqli->query($checklistSelect) or die("Error in Get All checklist ".$mysqli->error);
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object()){
					$auditChecklist['area_id'] = $row->audit_area_id;
					$auditChecklist['department'] = $row->department;
					$auditChecklist['auditor'] = $row->auditor;
					$auditChecklist['auditee'] = $row->auditee;
					$auditareaid =  $auditChecklist['area_id'];
					$dept = $auditChecklist['department'];
					$auditor = $auditChecklist['auditor'];
					$auditee = $auditChecklist['auditee'];
				}
            }

            $audit_area_name = "SELECT * FROM audit_area_creation where audit_area_id IN ($auditareaid)";
            $res1 = $mysqli->query($audit_area_name) or die("Error in Get All Records".$mysqli->error);
            if ($mysqli->affected_rows>0)
            {
                $row1 = $res1->fetch_assoc();
                $auditChecklist['area_name'] = $row1['audit_area'];
            }

            $department_name = "SELECT department_name FROM department_creation where department_id IN ($dept)";
            $res2 = $mysqli->query($department_name) or die("Error in Get All Records".$mysqli->error);
            if ($mysqli->affected_rows >0)
            {
                $row2 = $res2->fetch_assoc();
                $auditChecklist['department_name'] = $row2['department_name'];
            }
			
            $auditor_name = "SELECT * FROM designation_creation where designation_id= '".$auditChecklist['auditor']."' ";
            $res3 = $mysqli->query($auditor_name) or die("Error in Get All Records".$mysqli->error);
            if ($mysqli->affected_rows>0)
            {
                $row3 = $res3->fetch_assoc();
                $auditChecklist['auditor_name'] = $row3['designation_name'];
            }

            $auditee_name = "SELECT * FROM designation_creation where designation_id= '".$auditChecklist['auditee']."' ";
            $res4 = $mysqli->query($auditee_name) or die("Error in Get All Records".$mysqli->error);
            if ($mysqli->affected_rows>0)
            {
                $row4 = $res4->fetch_assoc();
                $auditChecklist['auditee_name'] = $row4['designation_name'];
            }

            return $auditChecklist;
        }

		
        // //get Audit area Checklist table
        // public function getAuditAreaChecklist($mysqli,$id){

        //     if($id>0){
        //         $checklistSelect = "SELECT * FROM audit_checklist where audit_checklist_id= '".$id."' ";
        //     }else{
        //         $checklistSelect = "SELECT * FROM audit_checklist";
        //     }
        //     $res = $mysqli->query($checklistSelect) or die("Error in Get All checklist ".$mysqli->error);
        //     if ($mysqli->affected_rows>0)
        //     {
        //         while($row = $res->fetch_object()){
        //         // $auditChecklist[] = $row->audit_checklist_id;
        //         $auditChecklist['area_id'] = $row->audit_area_id;
        //         $auditChecklist['department'] = $row->department;
        //         $auditChecklist['auditor'] = $row->auditor;
        //         $auditChecklist['auditee'] = $row->auditee;
        //         }
        //     }
        //     $audit_area_name = "SELECT * FROM audit_area_creation where audit_area_id= '".$auditChecklist['area_id']."' ";
        //     $res1 = $mysqli->query($audit_area_name) or die("Error in Get All Records".$mysqli->error);
        //     if ($mysqli->affected_rows>0)
        //     {
        //         $row1 = $res1->fetch_assoc();
        //         $auditChecklist['area_name'] = $row1['audit_area'];
        //     }
        //     $department_name = "SELECT * FROM department_creation where department_id= '".$auditChecklist['department']."' ";
        //     $res2 = $mysqli->query($department_name) or die("Error in Get All Records".$mysqli->error);
        //     if ($mysqli->affected_rows>0)
        //     {
        //         $row2 = $res2->fetch_assoc();
        //         $auditChecklist['department_name'] = $row2['department_name'];
        //     }
        //     $auditor_name = "SELECT * FROM staff_creation where staff_id= '".$auditChecklist['auditor']."' ";
        //     $res3 = $mysqli->query($auditor_name) or die("Error in Get All Records".$mysqli->error);
        //     if ($mysqli->affected_rows>0)
        //     {
        //         $row3 = $res3->fetch_assoc();
        //         $auditChecklist['auditor_name'] = $row3['staff_name'];
        //     }
        //     $auditee_name = "SELECT * FROM staff_creation where staff_id= '".$auditChecklist['auditee']."' ";
        //     $res4 = $mysqli->query($auditee_name) or die("Error in Get All Records".$mysqli->error);
        //     if ($mysqli->affected_rows>0)
        //     {
        //         $row4 = $res4->fetch_assoc();
        //         $auditChecklist['auditee_name'] = $row4['staff_name'];
        //     }
            
        //     return $auditChecklist;
        // }

        //get AudiArea Checklist from ref table
        public function getAuditChecklist_ref($mysqli,$id){
            $get_checklist = "SELECT * FROM audit_checklist_ref where audit_area_id='".$id."' ";
            $res2 = $mysqli->query($get_checklist) or die("Error in Get All Records".$mysqli->error);
            $i=0;
            $auditChecklist2='';
            $auditChecklist2=array();
            if ($mysqli->affected_rows>0)
            {
                while($row2 = $res2->fetch_assoc()){
                $auditChecklist2[$i]['major_area'] = $row2['major_area'];
                // $auditChecklist2[$i]['sub_area'] = $row2['sub_area'];
                $auditChecklist2[$i]['assertion'] = $row2['assertion'];
                $auditChecklist2[$i]['weightage'] = $row2['weightage'];
                $i++;
                }
            }
            return $auditChecklist2;
        }

		//Add AuditChecklist
        public function addAuditChecklist($mysqli){

            if(isset($_POST['audit'])){
                $audit_area_id = $_POST['audit'];
            }
            if(isset($_POST['dept_id'])){
                $dept = $_POST['dept_id'];
            }
            if(isset($_POST['auditor_id'])){
                $auditor = $_POST['auditor_id'];
            }
            if(isset($_POST['auditee_id'])){
                $auditee = $_POST['auditee_id'];
            }
            if(isset($_POST['major'])){
                $major = $_POST['major'];
            }
            // if(isset($_POST['sub'])){
            //     $sub = $_POST['sub'];
            // }
            if(isset($_POST['assertion'])){
                $assertion = $_POST['assertion'];
            }
            if(isset($_POST['weightage'])){
                $weightage = $_POST['weightage'];
            }

            $deleteArea = "DELETE FROM audit_checklist where audit_area_id= '".$audit_area_id."' ";
            $run=$mysqli->query($deleteArea) or die("Error ".$mysqli->error);

            $qry1="INSERT INTO audit_checklist(audit_area_id , department, auditor, auditee)
            VALUES('".strip_tags($audit_area_id)."', '".strip_tags($dept)."', '".strip_tags($auditor)."', '".strip_tags($auditee)."' )";
            $insert_checklist=$mysqli->query($qry1) or die("Error ".$mysqli->error);

            $deleteqry = " DELETE FROM audit_checklist_ref WHERE audit_area_id = '".$audit_area_id."' ";
            $delete=$mysqli->query($deleteqry) or die("Error on delete query ".$mysqli->error);

            for($i=0;$i<=sizeof($major)-1;$i++){

                $qry2="INSERT INTO audit_checklist_ref(audit_area_id, major_area, assertion, weightage)
				VALUES('".strip_tags($audit_area_id)."', '".strip_tags($major[$i])."', '".strip_tags($assertion[$i])."',
				'".strip_tags($weightage[$i])."' )";
				$insert_checklist_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);
            }
        }

        // Update Audit area checklist in both tables
        public function updateAuditAreaChecklist($mysqli,$id,$area_id) {

            if(isset($_POST['audit'])){
                $audit_area_id = $_POST['audit'];
            }
            if(isset($_POST['dept_id'])){
                $dept = $_POST['dept_id'];
            }
            if(isset($_POST['auditor_id'])){
                $auditor = $_POST['auditor_id'];
            }
            if(isset($_POST['auditee_id'])){
                $auditee = $_POST['auditee_id'];
            }
            if(isset($_POST['major'])){
                $major = $_POST['major'];
            }
            // if(isset($_POST['sub'])){
            //     $sub = $_POST['sub'];
            // }
            if(isset($_POST['assertion'])){
                $assertion = $_POST['assertion'];
            }
            if(isset($_POST['weightage'])){
                $weightage = $_POST['weightage'];
            }
            $qry1="UPDATE audit_checklist set audit_area_id = '".strip_tags($area_id)."', department = '".strip_tags($dept)."', auditor = '".strip_tags($auditor)."',
            auditee = '".strip_tags($auditee)."', status ='0' WHERE audit_checklist_id= '".$id."'  ";
            $update_checklist=$mysqli->query($qry1) or die("Error ".$mysqli->error);
            $deleteqry = " DELETE FROM audit_checklist_ref WHERE audit_area_id = '".$area_id."' ";
            $delete=$mysqli->query($deleteqry) or die("Error on delete query ".$mysqli->error);
            for($i=0;$i<=sizeof($major)-1;$i++){
                $qry2="INSERT INTO audit_checklist_ref(audit_area_id, major_area, assertion, weightage)
                VALUES('".strip_tags($area_id)."', '".strip_tags($major[$i])."', '".strip_tags($assertion[$i])."', '".strip_tags($weightage[$i])."' )";
                // $qry2="UPDATE audit_checklist_ref set audit_area_id= '".$audit_area_id."' , major_area= '".strip_tags($major[$i])."', sub_area = '".strip_tags($sub[$i])."', assertion ='".strip_tags($assertion[$i])."',
                // weightage = '".strip_tags($weightage[$i])."' WHERE audit_checklist_ref_id= '".$id."' AND audit_area_id= '".$area_id."' ";
            $update_checklist_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);
            }
        }
		
        // Delete Audit Area Checklist
        public function deleteAuditAreaChecklist($mysqli, $id){
            $checklistDelete = "UPDATE audit_checklist set status='1' WHERE audit_checklist_id = '".strip_tags($id)."' ";
            $runQry = $mysqli->query($checklistDelete) or die("Error in delete query".$mysqli->error);
        }


		// Add addAuditAssign
		public function addAuditAssign($mysqli,$userid,$id){

			if(isset($_POST['id'])){
				$id = $_POST['id'];
			}
			if(isset($_POST['date_of_audit'])){
				$date_of_audit = $_POST['date_of_audit'];
			}
			if(isset($_POST['dept_id'])){
				$dept_id = $_POST['dept_id'];
			}
			if(isset($_POST['role1_id'])){
				$role1_id = $_POST['role1_id'];
			}
			if(isset($_POST['role2_id'])){
				$role2_id = $_POST['role2_id'];
			}
			if(isset($_POST['prev'])){
				$prev = $_POST['prev'];
			}
			if(isset($_POST['major'])){
				$major = $_POST['major'];
			}
			if(isset($_POST['assertion'])){
				$assertion = $_POST['assertion'];
			}
			if (isset($_POST['prevstatus'])) {
			   $prevstatus = $_POST['prevstatus'];
			} else {
			}
			if(isset($_POST['aremarks'])){
				$aremarks = $_POST['aremarks'];
			}
			if (isset($_POST['rcmd'])) {
				$rcmd = $_POST['rcmd'];
			}
			if ($id ==''){
				if(isset($_FILES['file'])){
						$files = $_FILES['file'];
						foreach ($files['name'] as $index => $name) {
							$file[] = $files['name'][$index];
							$file_name = $files['name'][$index];
							$checklistfile_tmp = $files['tmp_name'][$index];
							$maintenanceChecklistfilefolder="./uploads/audit_assign/".$file_name;
							move_uploaded_file($checklistfile_tmp, $maintenanceChecklistfilefolder);
						}
				} else { $file=" "; }
			} else{
				if(isset($_POST['file1'])){
                    $files1 = $_POST['file1'];
                    foreach ($files1 as $index ) {
                        $file_name = $index;
                        $maintenanceChecklistfilefolder="./uploads/audit_assign/".$file_name;
                        // Check if the old file exists and delete it
                            if(file_exists($maintenanceChecklistfilefolder)) {
                            unlink($maintenanceChecklistfilefolder);
                            }
                    }
                }
                if(isset($_FILES['file'])){
                    $files = $_FILES['file'];
                    foreach ($files['name'] as $index => $name) {
                        $file[] = $files['name'][$index];
                        $file_name = $files['name'][$index];
                        $checklistfile_tmp = $files['tmp_name'][$index];
                        $maintenanceChecklistfilefolder="./uploads/audit_assign/".$file_name;
                        move_uploaded_file($checklistfile_tmp, $maintenanceChecklistfilefolder);
                        // Check if the old file exists and delete it
                    }
                }
			}

			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			}
			if(isset($_POST['audit_assign_ref_id'])){
				$audit_assign_ref_id = $_POST['audit_assign_ref_id'];
			}

			if($audit_assign_ref_id == ''){

				$qry1="INSERT INTO audit_assign (audit_assign_id, date_of_audit, department_id, role1, role2, audit_area_id, insert_login_id, status)
				VALUES (NULL, '$date_of_audit', '$dept_id', '$role1_id', '$role2_id', '$prev','$userid', '0')";
				$insert_assign=$mysqli->query($qry1) or die("Error ".$mysqli->error);
				$last_id  = $mysqli->insert_id;

				for($j=0; $j<=sizeof($major)-1; $j++){
					$qry2="INSERT INTO audit_assign_ref(audit_assign_id, major_area, assertion, audit_status, recommendation, attachment, audit_remarks)
					VALUES('".strip_tags($last_id)."', '".strip_tags($major[$j])."', '".strip_tags($assertion[$j])."','".strip_tags($prevstatus[$j])."','".strip_tags($rcmd[$j])."','".strip_tags($file[$j])."','".strip_tags($aremarks[$j])."' )";
					$insert_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);
				}

			} else {
				
				$qry1="UPDATE audit_assign set date_of_audit = '$date_of_audit', department_id = '$dept_id' , role1 = '$role1_id',role2 = '$role2_id',audit_area_id = '$prev', status ='0',update_login_id='$userid' WHERE audit_assign_id = '$id' ";
                $update_assign=$mysqli->query($qry1) or die("Error ".$mysqli->error);
                $last_id  = $mysqli->insert_id;
                for($i=0;$i<=sizeof($major)-1;$i++){
                    if($file[$i] == ''){
                        $afile = $files1[$i];
                    } else {
                        $afile = $file[$i];
                    }
                    $qry2="UPDATE audit_assign_ref set major_area= '$major[$i]', assertion= '$assertion[$i]', audit_status = '$prevstatus[$i]',
                    recommendation ='$rcmd[$i]',attachment = '$afile',audit_remarks = '$aremarks[$i]' WHERE audit_assign_id= '$id'
                    AND audit_assign_ref_id  = '$audit_assign_ref_id[$i]'";
                	$update_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);
                }
			}
		}

		// get Audit Assign list table
		public function getAuditAssignlist($mysqli,$id){
			if($id>0){
				$checklistSelect = "SELECT * FROM audit_assign where audit_assign_id= '$id' ";
			} else {
				$checklistSelect = "SELECT * FROM audit_assign";
			}

			$res = $mysqli->query($checklistSelect) or die("Error in Get All checklist ".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object()){
				$auditChecklist['date_of_audit'] = $row->date_of_audit;
				$auditChecklist['area_id'] = $row->audit_area_id;
				$auditChecklist['department'] = $row->department_id;
				$auditChecklist['auditor'] = $row->role1;
				$auditChecklist['auditee'] = $row->role2;
				$auditareaid =  $auditChecklist['area_id'];
				$dept = $auditChecklist['department'];
				$auditor = $auditChecklist['auditor'];
				$auditee = $auditChecklist['auditee'];
			}

			//change value into new variable
			}
			$audit_area_name = "SELECT * FROM audit_area_creation where audit_area_id IN ($auditareaid)";
			$res1 = $mysqli->query($audit_area_name) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				$row1 = $res1->fetch_assoc();
				$auditChecklist['area_name'] = $row1['audit_area'];
			}
			$department_name = "SELECT department_name FROM department_creation where department_id IN ($dept)";

			$res2 = $mysqli->query($department_name) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows >0)
			{
				$row2 = $res2->fetch_assoc();
				$auditChecklist['department_name'] = $row2['department_name'];
			}
			$auditor_name = "SELECT * FROM designation_creation where designation_id= '".$auditChecklist['auditor']."' ";
			$res3 = $mysqli->query($auditor_name) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				$row3 = $res3->fetch_assoc();
				$auditChecklist['auditor_name'] = $row3['designation_name'];
			}
			$auditee_name = "SELECT * FROM designation_creation where designation_id= '".$auditChecklist['auditee']."' ";
			$res4 = $mysqli->query($auditee_name) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				$row4 = $res4->fetch_assoc();
				$auditChecklist['auditee_name'] = $row4['designation_name'];
			}
			return $auditChecklist;
		}

		// get auditAssign edit list
		public function getAuditassign_ref($mysqli,$id){
			$get_checklist = "SELECT * FROM audit_assign_ref where audit_assign_id IN ($id)";
			$res2 = $mysqli->query($get_checklist) or die("Error in Get All Records".$mysqli->error);
			$i=0;
			$auditChecklist2='';
			$auditChecklist2=array();
			if ($mysqli->affected_rows>0)
			{
				while($row2 = $res2->fetch_assoc()){
				$auditChecklist2[$i]['audit_assign_ref_id'] = $row2['audit_assign_ref_id'];
				$auditChecklist2[$i]['major_area'] = $row2['major_area'];
				$auditChecklist2[$i]['assertion'] = $row2['assertion'];
				$auditChecklist2[$i]['audit_status']=$row2['audit_status'];
				$auditChecklist2[$i]['recommendation']=$row2['recommendation'];
				$auditChecklist2[$i]['attachment']=$row2['attachment'];
				$auditChecklist2[$i]['audit_remarks']=$row2['audit_remarks'];
				$i++;
				}
			}
			return $auditChecklist2;
		}


		// Delete AuditAssign
		public function deleteAuditAssign($mysqli, $id){
			$checklistDelete = "UPDATE audit_assign set status='1' WHERE audit_assign_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($checklistDelete) or die("Error in delete query".$mysqli->error);
		}

		// Add Hierarchy Creation
		// public function addHierarchyCreation($mysqli, $userid){ 

		// 	if(isset($_POST['branch_id'])){
		// 		$company_id = $_POST['branch_id'];
		// 	} 
		// 	if(isset($_POST['department'])){
		// 		$department = $_POST['department']; 
		// 	}
		// 	if(isset($_POST['top_hierarchy'])){
		// 		$top_hierarchy1 = $_POST['top_hierarchy'];
		// 		$top_hierarchy = implode(",", $top_hierarchy1); 
		// 	}
		// 	if(isset($_POST['sub_ordinate'])){
		// 		$sub_ordinate1 = $_POST['sub_ordinate'];
		// 		$sub_ordinate = implode(",", $sub_ordinate1); 
		// 	}
		// 	if(isset($_POST['userid'])){
		// 		$userid = $_POST['userid'];
		// 	} 

		// 	$basicHierarchy="INSERT INTO hierarchy_creation(company_id, department_id, top_hierarchy, sub_ordinate, insert_login_id) 
		// 	VALUES('".strip_tags($company_id)."', '".strip_tags($department)."', '".strip_tags($top_hierarchy)."', '".strip_tags($sub_ordinate)."', 
		// 	'".strip_tags($userid)."')"; 
		// 	$insresult=$mysqli->query($basicHierarchy) or die("Error ".$mysqli->error);
			
		// }
	
		// Get Hierarchy
		// public function getHierarchyCreation($mysqli, $id){

		// 	$basicSelect = "SELECT * FROM hierarchy_creation WHERE hierarchy_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
		// 	$res = $mysqli->query($basicSelect) or die("Error in Get All Records".$mysqli->error);
		// 	$detailrecords = array();
			
		// 	if ($mysqli->affected_rows>0){
		// 		$row = $res->fetch_object();	
		// 		$detailrecords['hierarchy_id']      = $row->hierarchy_id; 
		// 		$companyId      = $row->company_id;
		// 		$detailrecords['branch_id']      = $row->company_id;
		// 		$detailrecords['department_id']     = $row->department_id;
		// 		$detailrecords['top_hierarchy']      = $row->top_hierarchy;  	
		// 		$detailrecords['sub_ordinate']       = $row->sub_ordinate;
								
		// 	}
		// 	$qry = "SELECT * FROM branch_creation WHERE branch_id = '".$companyId."' AND status=0 ORDER BY branch_id ASC"; 
		// 	$res = $mysqli->query($qry)or die("Error in Get All Records");
		// 	while($rowss = $res->fetch_object())
		// 	{
		// 		$detailrecords['company_id']       = strip_tags($rowss->company_id);
		// 	}
			
		// 	return $detailrecords;
		// }

		// Update Hierarchy
		// public function updateHierarchyCreation($mysqli, $id, $userid){

		// 	if(isset($_POST['branch_id'])){
		// 		$company_id = $_POST['branch_id'];
		// 	} 
		// 	if(isset($_POST['department'])){
		// 		$department = $_POST['department']; 
		// 	}
		// 	if(isset($_POST['top_hierarchy'])){
		// 		$top_hierarchy1 = $_POST['top_hierarchy'];
		// 		$top_hierarchy = implode(",", $top_hierarchy1); 
		// 	}
		// 	if(isset($_POST['sub_ordinate'])){
		// 		$sub_ordinate1 = $_POST['sub_ordinate'];
		// 		$sub_ordinate = implode(",", $sub_ordinate1); 
		// 	}
		// 	if(isset($_POST['userid'])){
		// 		$userid = $_POST['userid'];
		// 	}  

		// 	$hierarchyUpdaet = "UPDATE hierarchy_creation SET company_id = '".strip_tags($company_id)."', department_id='".strip_tags($department)."', 
		// 	top_hierarchy='".strip_tags($top_hierarchy)."', sub_ordinate='".strip_tags($sub_ordinate)."', update_login_id='".strip_tags($userid)."', status = '0' 
		// 	WHERE hierarchy_id= '".strip_tags($id)."' "; 
		// 	$updresult = $mysqli->query($hierarchyUpdaet )or die ("Error in in update Query!.".$mysqli->error);
		// 	}

		//  Delete Hierarchy
		// public function deleteHierarchyCreation($mysqli, $id, $userid){

		// 	$hierarchyDelete = "UPDATE hierarchy_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE hierarchy_id = '".strip_tags($id)."' ";
		// 	$runQry = $mysqli->query($hierarchyDelete) or die("Error in delete query".$mysqli->error);
		// }

		// Get report template table
		public function getReportCreation($mysqli,$id){
			$getReport = "SELECT * FROM report_creation where report_id='".$id."' ";
			$result = $mysqli->query($getReport) or die("Error in Get All Records".$mysqli->error);
			$report_list=array();
			if ($mysqli->affected_rows>0)
			{
				$row = $result->fetch_assoc();
				$report_list['report_id'] = $row['report_id'];
				$report_list['report_name'] = $row['report_name'];
				$report_list['company_id'] = $row['company_id'];
				$report_list['report_file'] = $row['report_file'];
			}
			// $getqry = "SELECT company_name FROM company_creation WHERE company_id ='".strip_tags($report_list['company_id'])."' and status = 0";
			// $res2 = $mysqli->query($getqry) or die("Error in Get All company".$mysqli->error);
			// while($row2 = $res2->fetch_assoc())
			// {
			// 	$report_list['company_name'] = $row2["company_name"];
			// }
			
			return $report_list;
		}

		// Add Report Creation
		public function addReportCreation($mysqli){
			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['report_name'])){
				$report_name = $_POST['report_name'];
			}

			$report_file = '';
			if(!empty($_FILES['report_file']['name']))
			{
				$report_file = $_FILES['report_file']['name'];
				$report_file_temp = $_FILES['report_file']['tmp_name'];
				$reportimage_folder="uploads/report_file/".$report_file ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}
			$reportInsert="INSERT INTO report_creation(company_id, report_name, report_file)
			VALUES('".strip_tags($company_id)."', '".strip_tags($report_name)."', '".strip_tags($report_file)."' )";
			$insresult=$mysqli->query($reportInsert) or die("Error ".$mysqli->error);
		}


		// Update Report Creation
		public function updateReportCreation($mysqli,$id){
			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['report_name'])){
				$report_name = $_POST['report_name'];
			}
			if(isset($_POST['editreportfile'])){
				$report_file_old = $_POST['editreportfile'];
			}
			//insert new file
			$report_file = '';
			if(!empty($_FILES['report_file']['name']))
			{
				//delete old file
				$path='uploads/report_file/'. $report_file_old;
				if (file_exists($path)) {
					unlink($path);
				}
				//insert new file
				$report_file = $_FILES['report_file']['name'];
				$report_file_temp = $_FILES['report_file']['tmp_name'];
				$reportimage_folder="uploads/report_file/".$report_file ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}
			//check old file name if new is not set
			if($report_file == '' && isset($_POST["editreportfile"])){
				$report_file = $_POST["editreportfile"];
			}
			
			$reportUpdate="UPDATE report_creation set company_id = '". $company_id ."' , report_name = '".strip_tags($report_name)."', 
			report_file = '".strip_tags($report_file)."', status = 0 WHERE report_id= '".$id."' ";
			$update=$mysqli->query($reportUpdate) or die("Error ".$mysqli->error);
		}

		// Delete Report Template
			public function deleteReportTemplate($mysqli, $id){
			$reportDelete = "UPDATE report_creation set status='1' WHERE report_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($reportDelete) or die("Error in delete query".$mysqli->error);
		}
		

		// Add Media Creation
		public function addMediaCreation($mysqli){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['media_name'])){
				$media_name = $_POST['media_name'];
			}
			if(isset($_POST['from_period'])){
				$from_period = $_POST['from_period'];
			}
			if(isset($_POST['to_period'])){
				$to_period = $_POST['to_period'];
			}
			if(isset($_POST['platform'])){
				$platform = $_POST['platform'];
			}

			$media_file = '';
			if(!empty($_FILES['media_file']['name']))
			{
				$media_file = $_FILES['media_file']['name'];
				$media_file_temp = $_FILES['media_file']['tmp_name'];
				$mediaimage_folder="uploads/media_master/".$media_file ;
				move_uploaded_file($media_file_temp, $mediaimage_folder);
			}
			$mediaInsert="INSERT INTO media_creation(company_id, media_name, media_file, from_period, to_period, platform)
			VALUES('".strip_tags($company_id)."', '".strip_tags($media_name)."', '".strip_tags($media_file)."', '".strip_tags($from_period)."', 
			'".strip_tags($to_period)."', '".strip_tags($platform)."' )";
			$insresult=$mysqli->query($mediaInsert) or die("Error ".$mysqli->error);
		}


		// Get Media Master table
		public function getMediaMaster($mysqli,$id){
			$getReport = "SELECT * FROM media_creation where media_id='".$id."' ";
			$result = $mysqli->query($getReport) or die("Error in Get All Records".$mysqli->error);
			$report_list=array();
			if ($mysqli->affected_rows>0)
			{
				$row = $result->fetch_assoc();
				$report_list['media_id'] = $row['media_id'];
				$report_list['company_id'] = $row['company_id'];
				$report_list['media_name'] = $row['media_name'];
				$report_list['from_period'] = $row['from_period'];
				$report_list['to_period'] = $row['to_period'];
				$report_list['platform'] = $row['platform'];
				$report_list['media_file'] = $row['media_file'];
			}
			// $getqry = "SELECT company_name FROM company_creation WHERE company_id ='".strip_tags($report_list['company_id'])."' and status = 0";
			// $res2 = $mysqli->query($getqry) or die("Error in Get All company".$mysqli->error);
			// while($row2 = $res2->fetch_assoc())
			// {
			// 	$report_list['company_name'] = $row2["company_name"];
			// }
			return $report_list;
		}


		// Update media Creation
		public function updateMediaCreation($mysqli,$id){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['media_name'])){
				$media_name = $_POST['media_name'];
			}
			if(isset($_POST['from_period'])){
				$from_period = $_POST['from_period'];
			}
			if(isset($_POST['to_period'])){
				$to_period = $_POST['to_period'];
			}
			if(isset($_POST['platform'])){
				$platform = $_POST['platform'];
			}
			if(isset($_POST['edit_media_file'])){
				$media_file_old = $_POST['edit_media_file'];
			}
			//insert new file
			$media_file = '';
			if(!empty($_FILES['media_file']['name']))
			{
				//delete old file
				$path='uploads/media_master/'.$media_file_old;
				if (file_exists($path)) {
					unlink($path);
				}
				//insert new file
				$media_file = $_FILES['media_file']['name'];
				$media_file_temp = $_FILES['media_file']['tmp_name'];
				$mediaimage_folder="uploads/media_master/".$media_file ;
				move_uploaded_file($media_file_temp, $mediaimage_folder);
			}
			// check old file name if new is not set
			if($media_file == '' && isset($_POST["edit_media_file"])){
				$media_file = $_POST["edit_media_file"];
			}
			
			$mediaUpdate="UPDATE media_creation set company_id = '". $company_id ."' , media_name = '".strip_tags($media_name)."', 
			media_file = '".strip_tags($media_file)."', from_period = '".strip_tags($from_period)."', to_period = '".strip_tags($to_period)."', 
			platform = '".strip_tags($platform)."', status = 0 WHERE media_id= '".$id."' ";
			$update=$mysqli->query($mediaUpdate) or die("Error ".$mysqli->error);
		}

		// Delete Media Master
		public function deleteMediaMaster($mysqli, $id){
			$mediaDelete = "UPDATE media_creation set status='1' WHERE media_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($mediaDelete) or die("Error in delete query".$mysqli->error);
		}

		// Add kra
		public function addkraCreation($mysqli, $userid){

			if(isset($_POST['company_id'])){
				$company_id = $_POST['company_id'];
			}
			if(isset($_POST['designation'])){
				$designation = $_POST['designation'];
			}
			if(isset($_POST['department'])){
				$department = $_POST['department'];
			}
			if(isset($_POST['kra_category'])){
				$kra_category = $_POST['kra_category'];
			}
			if(isset($_POST['weightage'])){
				$weightage = $_POST['weightage'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			$kraInsert="INSERT INTO kra_creation(company_id, department_id, designation_id, insert_login_id) 
			VALUES('".strip_tags($company_id)."', '".strip_tags($department)."', '".strip_tags($designation)."', '".strip_tags($userid)."' )";
			$insresult=$mysqli->query($kraInsert) or die("Error ".$mysqli->error);
			$kraId = $mysqli->insert_id; 

			for($i=0; $i<=sizeof($kra_category)-1; $i++){

				$kraRefInsert="INSERT INTO kra_creation_ref(kra_category, weightage, kra_id)
				VALUES('".strip_tags($kra_category[$i])."', '".strip_tags($weightage[$i])."', '".strip_tags($kraId)."')";
				$insRefresult=$mysqli->query($kraRefInsert) or die("Error ".$mysqli->error);
			}
		}

		// Get kra
		public function getkraCreation($mysqli, $id){

			$kraSelect = "SELECT * FROM kra_creation WHERE kra_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($kraSelect) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$kraId  							= $row->kra_id;
				$detailrecords['kra_id']            = $row->kra_id; 
				$detailrecords['company_id']        = $row->company_id;
				$detailrecords['department']        = $row->department_id;
				$detailrecords['designation']       = $row->designation_id; 	

			}
			
			$kraRefId = 0;
			$kraRefSelect = "SELECT * FROM kra_creation_ref WHERE kra_id='".mysqli_real_escape_string($mysqli, $kraId)."' "; 
			$res1 = $mysqli->query($kraRefSelect) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				while($row1 = $res1->fetch_object()){

					$kraRefId         			= $row1->kra_creation_ref_id; 
					$kra_creation_ref_id[]     	= $row1->kra_creation_ref_id; 
					$kra_category[]             = $row1->kra_category; 
					$weightage[]                = $row1->weightage;
				} 
			}
			if($kraRefId > 0)
			{
				$detailrecords['kra_creation_ref_id']   = $kra_creation_ref_id; 
				$detailrecords['kra_category']          = $kra_category;
				$detailrecords['weightage']              = $weightage;  	
			}
			else
			{
				$detailrecords['kra_creation_ref_id']          = array();
				$detailrecords['kra_category']                 = array();
				$detailrecords['weightage']                    = array(); 
			}
			
			return $detailrecords;
		}

		// Update kra
		public function updatekraCreation($mysqli, $id, $userid){

			if(isset($_POST['company_id'])){
				$company_id = $_POST['company_id'];
			}
			if(isset($_POST['designation'])){
				$designation = $_POST['designation'];
			}
			if(isset($_POST['department'])){
				$department = $_POST['department'];
			}
			if(isset($_POST['kra_category'])){
				$kra_category = $_POST['kra_category'];
			}
			if(isset($_POST['weightage'])){
				$weightage = $_POST['weightage'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			}
		
			$kraUpdaet = "UPDATE kra_creation SET company_id = '".strip_tags($company_id)."', designation_id = '".strip_tags($designation)."', 
			department_id='".strip_tags($department)."', update_login_id='".strip_tags($userid)."', status = '0' WHERE kra_id= '".strip_tags($id)."' ";
			$updresult = $mysqli->query($kraUpdaet )or die ("Error in in update Query!.".$mysqli->error);

			$deleteKraRef = $mysqli->query("DELETE FROM kra_creation_ref WHERE kra_id = '".$id."' "); 

			for($i=0; $i<=sizeof($kra_category)-1; $i++){

				$kraUpdaet = "INSERT INTO kra_creation_ref(kra_category, weightage, kra_id) 
				VALUES('".strip_tags($kra_category[$i])."',  '".strip_tags($weightage[$i])."', '".strip_tags($id)."')";
				$updresult = $mysqli->query($kraUpdaet)or die ("Error in in update Query!.".$mysqli->error);
			} 

	 	}

		//  Delete kra
		public function deleteKraCreation($mysqli, $id, $userid){

			$kraDelete = "UPDATE kra_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE kra_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($kraDelete) or die("Error in delete query".$mysqli->error);
		}

		// get kra category
		public function kraCategoryDepartmentBased($mysqli, $company_id, $department_id) {

			$qry = "SELECT kra_creation_ref_id, kra_category FROM kra_creation_ref LEFT JOIN kra_creation ON kra_creation_ref.kra_id = kra_creation.kra_id 
			WHERE kra_creation.company_id = '".$company_id."' AND kra_creation.status = 0 ";
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['kra_creation_ref_id']    = $row->kra_creation_ref_id; 
					$detailrecords[$i]['kra_category']           = strip_tags($row->kra_category);
					$i++;
				}
			}

			return $detailrecords;
		}

		// Get tag Classification
		public function getTagClassification($mysqli){

			$tagSelect = "SELECT * FROM tag_creation where status = 0 "; 
			$res = $mysqli->query($tagSelect) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object()){	
				$detailrecords[$j]['tag_id']      = $row->tag_id; 
				$detailrecords[$j]['tag_classification']      = $row->tag_classification;		
				$j++;
				}
			}
			
			return $detailrecords;
		}

		// Add Assign Work
		public function addAssignWork($mysqli){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['department_id'])){
				$department_id = $_POST['department_id'];
			}
			if(isset($_POST['work_des_id'])){
				$work_des_id = $_POST['work_des_id'];
			}
			if(isset($_POST['work_des_ins'])){
				$work_des_text = $_POST['work_des_ins'];
			}
			if(isset($_POST['designation'])){
				$designation = $_POST['designation'];
			}
			if(isset($_POST['from_date_ins'])){
				$from_date = $_POST['from_date_ins'];
			}
			if(isset($_POST['to_date_ins'])){
				$to_date = $_POST['to_date_ins'];
			}
			$insertQry="INSERT INTO assign_work(company_id,created_date) VALUES('".strip_tags($company_id)."', current_timestamp()  )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
				
			$lastid = $mysqli->insert_id;
			for($i=0;$i<sizeof($department_id);$i++){
				
				$insertQry="INSERT INTO assign_work_ref(assign_work_reff_id, department_id, work_des, work_des_text, designation_id, from_date, to_date)
				VALUES('".strip_tags($lastid)."', '".strip_tags($department_id[$i])."', '".strip_tags($work_des_id[$i])."','".strip_tags($work_des_text[$i])."', 
				'".strip_tags($designation[$i])."', '".strip_tags($from_date[$i])."', '".strip_tags($to_date[$i])."' )";
				$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			}
		}

		//Update Assign Work
		 public function updateAssignWork($mysqli,$id){
			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['department_id'])){
				$department_id = $_POST['department_id'];
			}
			if(isset($_POST['work_des_id'])){
				$work_des_id = $_POST['work_des_id'];
			}
			if(isset($_POST['work_des_ins'])){
				$work_des_text = $_POST['work_des_ins'];
			}
			if(isset($_POST['designation'])){
				$designation = $_POST['designation'];
			}
			if(isset($_POST['from_date_ins'])){
				$from_date = $_POST['from_date_ins'];
			}
			if(isset($_POST['to_date_ins'])){
				$to_date = $_POST['to_date_ins'];
			}
			
			$delRef = "DELETE FROM assign_work_ref where assign_work_reff_id = '".strip_tags($id)."' ";
			$delres = $mysqli->query($delRef) or die('unable to update');
			
			for($i=0;$i<=sizeof($department_id)-1;$i++){
				$updQry="INSERT INTO assign_work_ref(assign_work_reff_id, department_id, work_des, work_des_text, designation_id, from_date, to_date)
					VALUES('".strip_tags($id)."', '".$department_id[$i]."', '".$work_des_id[$i]."','".$work_des_text[$i]."', '".$designation[$i]."', '".$from_date[$i]."', 
					'".$to_date[$i]."' )";
				$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
			}

			$updateqry = "UPDATE assign_work set status = 0 where work_id = '".$id."' ";
			$updres = $mysqli->query($updateqry) or die("Error ");
		}
		
		// Get Assign Work table
		public function getAssignWork($mysqli, $id){

			$getQry = "SELECT * FROM assign_work where work_id= '".$id."' "; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords[$i]['company_id']      = $row->company_id; 
				$detailrecords[$i]['work_id']      = $row->work_id; 
				
			}
			
			$getQry = "SELECT * FROM assign_work_ref where assign_work_reff_id= '".$id."' "; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object()){
					$detailrecords[$j]['department_id']      = $row->department_id;	
					
					$getqry = "SELECT * FROM department_creation WHERE department_id ='".strip_tags($detailrecords[$j]['department_id'] )."' and status = 0";
					$res1 = $mysqli->query($getqry);
					while($row1 = $res1->fetch_assoc())
					{
					   $detailrecords[$j]['department_name']  = $row1["department_name"];       
					}
					
					$detailrecords[$j]['work_des_id']      = $row->work_des;		
					$detailrecords[$j]['work_des_text']      = $row->work_des_text;	

					$prior = "";
					if($row->priority == 1 ) $prior = "High";
					if($row->priority == 2 ) $prior = "Medium";
					if($row->priority == 3 ) $prior = "Low";

					$detailrecords[$j]['priority_id']      = $row->priority;		
					$detailrecords[$j]['priority_name']      = $prior;	

					$detailrecords[$j]['designation']      = $row->designation_id;	
					$getqry = "SELECT * FROM designation_creation WHERE designation_id ='".strip_tags($detailrecords[$j]['designation'])."' and status = 0";
					$res2 = $mysqli->query($getqry);
					while($row2 = $res2->fetch_assoc())
					{
					   $detailrecords[$j]['designation_name'] = $row2["designation_name"];        
					}
					// print_r($detailrecords[$j]['designation_name']); die;
					$detailrecords[$j]['from_date']      = $row->from_date;		
					$detailrecords[$j]['to_date']      = $row->to_date;		
					$j++;
				}
			}
			
			return $detailrecords;
		}
		
		// Delete Assign Work
		public function deleteAssignWork($mysqli, $id){
			$deleteQry = "UPDATE assign_work set status='1' WHERE work_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
			$deleteQry = "UPDATE assign_work_ref set status='1' WHERE assign_work_reff_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

		
		//Add Asset Register
		public function addAssetRegister($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['asset_class'])){
				$asset_class_id = $_POST['asset_class'];
			}
			if(isset($_POST['asset_name'])){
				$asset_name = $_POST['asset_name'];
			}
			if(isset($_POST['dop'])){
				$dop = $_POST['dop'];
			}
			if(isset($_POST['nature'])){
				$asset_nature_id = $_POST['nature'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['check_list'])){
				$maintenance = $_POST['check_list'];
			}

			$insertQry="INSERT INTO asset_register(company_id, asset_classification,asset_name,dop,asset_nature,asset_value,maintenance, created_date, insert_login_id) VALUES 
				('".strip_tags($company_id)."', '".strip_tags($asset_class_id)."','".strip_tags($asset_name)."','".$dop."','".strip_tags($asset_nature_id)."','".strip_tags($asset_value)."',
				'".strip_tags($maintenance)."', CURRENT_TIMESTAMP(), '".$userid."' )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			
		}

		// Update Asset Register
		public function updateAssetRegister($mysqli,$id, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['asset_class'])){
				$asset_class_id = $_POST['asset_class'];
			}
			if(isset($_POST['asset_name'])){
				$asset_name = $_POST['asset_name'];
			}
			if(isset($_POST['dop'])){
				$dop = $_POST['dop'];
			}
			if(isset($_POST['nature'])){
				$asset_nature_id = $_POST['nature'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['check_list'])){
				$maintenance = $_POST['check_list'];
			}

			$updQry="UPDATE asset_register set company_id = '".strip_tags($company_id)."', asset_classification = '".strip_tags($asset_class_id)."', asset_name = '".strip_tags($asset_name)."', dop = '".strip_tags($dop)."', 
			asset_nature = '".strip_tags($asset_nature_id)."', asset_value = '".strip_tags($asset_value)."', maintenance = '".strip_tags($maintenance)."', status = 0 , updated_date = CURRENT_TIMESTAMP(), update_login_id = '".strip_tags($userid)."'
			WHERE asset_id = '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}
		
		// Get Asset Register table
		public function getAssetRegister($mysqli, $id){

			$getQry = "SELECT * FROM asset_register where asset_id= '".$id."' "; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['company_id']      = $row->company_id; 
				$detailrecords['asset_id']      = $row->asset_id; 
				$detailrecords['asset_classification']      = $row->asset_classification;		
				$detailrecords['asset_name']      = $row->asset_name;		
				$detailrecords['dop']      = $row->dop;		
				$detailrecords['asset_nature']      = $row->asset_nature;		
				$detailrecords['asset_value']      = $row->asset_value;		
				$detailrecords['maintenance']      = $row->maintenance;		
			}
			
			return $detailrecords;
		}
		
		// Delete Asset Register
		public function deleteAssetRegister($mysqli, $id, $userid){
			
			$deleteQry = "UPDATE asset_register set status='1', delete_login_id = '".$userid."' WHERE asset_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

		// get Insurance creation Table
		public function getInsuranceName($mysqli) {

			$qry = "SELECT * FROM insurance_creation WHERE 1 AND status=0 ORDER BY insurance_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['insurance_id']            = $row->insurance_id; 
					$detailrecords[$i]['insurance_name']       	= strip_tags($row->insurance_name);
					$i++;
				}
			}
			return $detailrecords;
		}

		// Add Insurance Register
		public function addInsuranceRegister($mysqli){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['ins_name'])){
				$insurance_id = $_POST['ins_name'];
			}
			if(isset($_POST['dept'])){
				$dept_id = $_POST['dept'];
			}
			if(isset($_POST['frequency'])){
				$freq_id = $_POST['frequency'];
			}
			if(isset($_POST['department'])){
				$department_id = $_POST['department'];
			}
			if(isset($_POST['designation'])){
				$designation_id = $_POST['designation'];
			}
			if(isset($_POST['staff_name'])){
				$staff_id = $_POST['staff_name'];
			}
			if(isset($_POST['from_date'])){
				$from_date = $_POST['from_date'];
			}
			if(isset($_POST['to_date'])){
				$to_date = $_POST['to_date'];
			}

			$insertQry="INSERT INTO insurance_register(company_id, insurance_id, dept_id, freq_id, department_id, designation_id, staff_id, from_date, to_date, created_date) 
			VALUES('".strip_tags($company_id)."','".strip_tags($insurance_id)."', '".strip_tags($dept_id)."', '".strip_tags($freq_id)."', '".strip_tags($department_id)."', 
			'".strip_tags($designation_id)."', '".strip_tags($staff_id)."', '".strip_tags($from_date)."', '".strip_tags($to_date)."', current_timestamp() )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);			
		}

		// Update Insurance Register
		public function updateInsuranceRegister($mysqli,$id){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['ins_name'])){
				$insurance_id = $_POST['ins_name'];
			}
			if(isset($_POST['dept'])){
				$dept_id = $_POST['dept'];
			}
			if(isset($_POST['frequency'])){
				$freq_id = $_POST['frequency'];
			}
			if(isset($_POST['department'])){
				$department_id = $_POST['department'];
			}
			if(isset($_POST['designation'])){
				$designation_id = $_POST['designation'];
			}
			if(isset($_POST['staff_name'])){
				$staff_id = $_POST['staff_name'];
			}
			if(isset($_POST['from_date'])){
				$from_date = $_POST['from_date'];
			}
			if(isset($_POST['to_date'])){
				$to_date = $_POST['to_date'];
			}

			$updQry="UPDATE insurance_register set company_id = '".strip_tags($company_id)."', insurance_id = '".strip_tags($insurance_id)."', 
			dept_id = '".strip_tags($dept_id)."', freq_id = '".strip_tags($freq_id)."', department_id = '".strip_tags($department_id)."', 
			designation_id = '".strip_tags($designation_id)."', staff_id = '".strip_tags($staff_id)."', from_date = '".strip_tags($from_date)."', 
			to_date = '".strip_tags($to_date)."',  status = 0 WHERE ins_reg_id  = '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}
		
		//get Insurance creation Table
		public function getInsuranceRegisterTable($mysqli,$id) {

			$qry = "SELECT * FROM insurance_register WHERE ins_reg_id  = '".$id."' ORDER BY ins_reg_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['ins_reg_id'] = $row->ins_reg_id;
					$detailrecords[$i]['company_id'] = $row->company_id;
					$detailrecords[$i]['insurance_id']= $row->insurance_id;
					$detailrecords[$i]['dept_id']= $row->dept_id;
					$detailrecords[$i]['freq_id']= $row->freq_id;
					$detailrecords[$i]['department_id']= $row->department_id;
					$detailrecords[$i]['designation_id']= $row->designation_id;
					$detailrecords[$i]['staff_id']= $row->staff_id;
					$detailrecords[$i]['from_date']= $row->from_date;
					$detailrecords[$i]['to_date']= $row->to_date;
					$i++;
				}
			}
			return $detailrecords;
		}
		
		// Delete Insurance Register
		public function deleteInsuranceRegister($mysqli, $id){

			$deleteQry = "UPDATE insurance_register set status='1' WHERE ins_reg_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}
		
		// Add Todo
		public function addTodo($mysqli,$userid){

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['work_des'])){
				$work_des = $_POST['work_des'];
			}
			if(isset($_POST['work_des'])){
				$work_des = $_POST['work_des'];
			}
			if(isset($_POST['tag_id'])){
				$tag_id = $_POST['tag_id'];
			}
			if(isset($_POST['priority'])){
				$priority_id = $_POST['priority'];
			}
			if(isset($_POST['assign_to'])){
				$assign_to_idArr = $_POST['assign_to']; 	
				$assign_to_id = implode(",", $assign_to_idArr);  
			}
			if(isset($_POST['from_date'])){
				$from_date = $_POST['from_date'].' '.$current_time;
			}
			if(isset($_POST['to_date'])){
				$to_date = $_POST['to_date'].' '.$current_time;
			}
			if(isset($_POST['criteria'])){
				$criteria = $_POST['criteria'];
			}
			if(isset($_POST['project'])){
				$project_id = $_POST['project'];
			}
			
			$insertQry="INSERT INTO todo_creation(company_id, work_des, tag_id, priority, assign_to, from_date, to_date, criteria, project_id, created_date, created_id)
			VALUES('".strip_tags($company_id)."', '".strip_tags($work_des)."', '".strip_tags($tag_id)."', '".strip_tags($priority_id)."', '".strip_tags($assign_to_id)."', 
			'".strip_tags($from_date)."', '".strip_tags($to_date)."', '".strip_tags($criteria)."','".strip_tags($project_id)."', current_timestamp(), '".$userid."' )"; 
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		// Update Todo 
		 public function updateTodo($mysqli,$id,$userid){

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['work_des'])){
				$work_des = $_POST['work_des'];
			}
			if(isset($_POST['tag_id'])){
				$tag_id = $_POST['tag_id'];
			}
			if(isset($_POST['priority'])){
				$priority_id = $_POST['priority'];
			}
			if(isset($_POST['assign_to'])){
				$assign_to_idArr = $_POST['assign_to']; 
				$assign_to_id = implode(",", $assign_to_idArr); 
			}
			if(isset($_POST['from_date'])){
				$from_date = $_POST['from_date'].' '.$current_time;
			}
			if(isset($_POST['to_date'])){
				$to_date = $_POST['to_date'].' '.$current_time;
			}
			if(isset($_POST['criteria'])){
				$criteria = $_POST['criteria'];
			}
			if(isset($_POST['project'])){
				$project_id = $_POST['project'];
			}

			$updQry="UPDATE todo_creation set company_id = '".strip_tags($company_id)."', work_des = '".strip_tags($work_des)."', tag_id = '".strip_tags($tag_id)."', 
			priority = '".strip_tags($priority_id)."', assign_to = '".strip_tags($assign_to_id)."', from_date = '".strip_tags($from_date)."', to_date = '".strip_tags($to_date)."', 
			criteria = '".strip_tags($criteria)."', project_id = '".strip_tags($project_id)."',	status = 0, updated_id = '".$userid."' WHERE todo_id= '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}
		
		// Get Assign Work table
		public function getTodo($mysqli, $id){

			$getQry = "SELECT * FROM todo_creation where todo_id= '".$id."' "; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['company_id']      = $row->company_id; 
				$detailrecords['todo_id']      = $row->todo_id; 		
				$detailrecords['work_des']      = $row->work_des;		
				$detailrecords['tag_id']      = $row->tag_id;		
				$detailrecords['priority']      = $row->priority;		
				$detailrecords['assign_to']      = $row->assign_to;		
				$detailrecords['from_date']      = $row->from_date;		
				$detailrecords['to_date']      = $row->to_date;	
				$detailrecords['criteria']      = $row->criteria;		
				$detailrecords['project_id']      = $row->project_id;		
			}
			
			return $detailrecords;
		}
		
		// Delete Assign Work
		public function deleteTodo($mysqli, $id){
			$deleteQry = "UPDATE todo_creation set status='1' WHERE todo_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

		// // get work description for assign work
		// function getkpilist($mysqli){

		// 	$getqry = "SELECT * FROM krakpi_creation_ref WHERE rr = 'New' and status = 0";
		// 	$res12 = $mysqli->query($getqry);
		// 	$detailrecords = array();
		// 	$j=0;
		// 	while($row12 = $res12->fetch_assoc())
		// 	{
		// 		$detailrecords[$j]['kpi'] = $row12["kpi"];  
		// 		$detailrecords[$j]['krakpi_ref_id'] = $row12["krakpi_ref_id"];  
		// 		$j++;
		// 	}
		// 	return $detailrecords; 
		// }

		// //get work description for assign work
		// function getrrlist($mysqli){

		// 	$rrrecords = array();
		// 	$detailrecords = array();
			
		// 	$getqry = "SELECT * FROM krakpi_creation_ref WHERE rr != 'New' and status = 0";
		// 	$res12 = $mysqli->query($getqry);
		// 	while($row12 = $res12->fetch_assoc())
		// 	{
		// 		$rrrecords[] = $row12["rr"];       
		// 	}
			
		// 	$z=0;

		// 	// for($i=0; $i<=sizeof($rrrecords)-1; $i++){
		// 	foreach($rrrecords as $rrlist){
		// 		$getqry = "SELECT * FROM rr_creation_ref WHERE rr_ref_id ='".strip_tags($rrlist)."' and status = 0";
		// 		$res2 = $mysqli->query($getqry);
		// 		while($row2 = $res2->fetch_assoc())
		// 		{
		// 			$detailrecords[$z]['rr_id'] = $row2["rr_ref_id"];
		// 			$detailrecords[$z]['rr_name'] = $row2["rr"];        
		// 			$z++;
		// 		}
		// 	}

		// 	return $detailrecords; 
		// }

		// Add memo
		public function addMemo($mysqli,$userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['to_department'])){
				$to_department = $_POST['to_department'];
			}
			if(isset($_POST['inquiry'])){
				$inquiry = $_POST['inquiry'];
			}
			if(isset($_POST['suggestion'])){
				$suggestion = $_POST['suggestion'];
			}
			$attachment = '';
			if(!empty($_FILES['attachment']['name']))
			{
				$attachment = $_FILES['attachment']['name'];
				$report_file_temp = $_FILES['attachment']['tmp_name'];
				$reportimage_folder="uploads/memo/".$attachment ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}
			
			$insertQry="INSERT INTO memo(company_id, to_department, inquiry, suggestion, attachment, insert_login_id)
			VALUES('".strip_tags($company_id)."', '".strip_tags($to_department)."', 
			'".strip_tags($inquiry)."', '".strip_tags($suggestion)."', '".strip_tags($attachment)."', '".$userid."' )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		// Get memo
		public function getMemo($mysqli, $id){

			$getQry = "SELECT * FROM memo where memo_id= '".$id."' "; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['memo_id']      = $row->memo_id; 
				$detailrecords['company_id']      = $row->company_id;			
				$detailrecords['to_department']      = $row->to_department;			
				$detailrecords['inquiry']      = $row->inquiry;		
				$detailrecords['suggestion']      = $row->suggestion;		
				$detailrecords['attachment']      = $row->attachment;		
				$detailrecords['assign_employee']      = $row->assign_employee;		
				$detailrecords['priority']      = $row->priority;		
				$detailrecords['completion_target_date']      = $row->completion_target_date;		
				$detailrecords['initial_phase']      = $row->initial_phase;		
				$detailrecords['final_phase']      = $row->final_phase;			
			}
			
			return $detailrecords;
		}

		// Update memo
		public function updateMemo($mysqli,$id,$userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['to_department'])){
				$to_department = $_POST['to_department'];
			}
			if(isset($_POST['inquiry'])){
				$inquiry = $_POST['inquiry'];
			}
			if(isset($_POST['suggestion'])){
				$suggestion = $_POST['suggestion'];
			}
			$attachment = '';
			if(!empty($_FILES['attachment']['name']))
			{
				$attachment = $_FILES['attachment']['name'];
				$report_file_temp = $_FILES['attachment']['tmp_name'];
				$reportimage_folder="uploads/memo/".$attachment ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}
			if($attachment == '' && isset($_POST["edit_attachment"])){
				$attachment = $_POST["edit_attachment"];
			}
			
			$updQry="UPDATE memo set company_id = '".strip_tags($company_id)."', to_department = '".strip_tags($to_department)."', 
			inquiry = '".strip_tags($inquiry)."', suggestion = '".strip_tags($suggestion)."', attachment = '".strip_tags($attachment)."', 
			status = 0, update_login_id = '".$userid."' WHERE memo_id= '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}
		
		//Delete memo
		public function deleteMemo($mysqli, $id, $userid){

			$deleteQry = "UPDATE memo set status='1', delete_login_id = '".$userid."' WHERE memo_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

		// Update memo assigned
		public function updateMemoAssigned($mysqli,$id,$userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['to_department'])){
				$to_department = $_POST['to_department'];
			}
			if(isset($_POST['assign_employee'])){
				$assign_employee = $_POST['assign_employee'];
			}
			if(isset($_POST['priority'])){
				$priority = $_POST['priority'];
			}
			if(isset($_POST['inquiry'])){
				$inquiry = $_POST['inquiry'];
			}
			if(isset($_POST['suggestion'])){
				$suggestion = $_POST['suggestion'];
			}
			$attachment = '';
			if(!empty($_FILES['attachment']['name']))
			{
				$attachment = $_FILES['attachment']['name'];
				$report_file_temp = $_FILES['attachment']['tmp_name'];
				$reportimage_folder="uploads/memo/".$attachment ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}
			if($attachment == '' && isset($_POST["edit_attachment"])){
				$attachment = $_POST["edit_attachment"];
			}
			if(isset($_POST['completion_target_date'])){
				$completion_target_date = $_POST['completion_target_date'];
			}
			if(isset($_POST['initial_phase'])){
				$initial_phase = $_POST['initial_phase'];
			}
			if(isset($_POST['final_phase'])){
				$final_phase = $_POST['final_phase'];
			}
			
			$updQry="UPDATE memo set assign_employee = '".strip_tags($assign_employee)."', priority = '".strip_tags($priority)."', 
			completion_target_date = '".strip_tags($completion_target_date)."', initial_phase = '".strip_tags($initial_phase)."', final_phase = '".strip_tags($final_phase)."', 
			status = 0, update_login_id = '".$userid."' WHERE memo_id= '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}
	
		// Update memo update
		public function updateMemoUpdate($mysqli,$id,$userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['to_department'])){
				$to_department = $_POST['to_department'];
			}
			if(isset($_POST['assign_employee'])){
				$assign_employee = $_POST['assign_employee'];
			}
			if(isset($_POST['priority'])){
				$priority = $_POST['priority'];
			}
			if(isset($_POST['inquiry'])){
				$inquiry = $_POST['inquiry'];
			}
			if(isset($_POST['suggestion'])){
				$suggestion = $_POST['suggestion'];
			}
			$attachment = '';
			if(!empty($_FILES['attachment']['name']))
			{
				$attachment = $_FILES['attachment']['name'];
				$report_file_temp = $_FILES['attachment']['tmp_name'];
				$reportimage_folder="uploads/memo/".$attachment ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}
			if($attachment == '' && isset($_POST["edit_attachment"])){
				$attachment = $_POST["edit_attachment"];
			}
			if(isset($_POST['completion_target_date'])){
				$completion_target_date = $_POST['completion_target_date'];
			}
			if(isset($_POST['initial_phase'])){
				$initial_phase = $_POST['initial_phase'];
			}
			if(isset($_POST['final_phase'])){
				$final_phase = $_POST['final_phase'];
			}
			if(isset($_POST['date_of_completion'])){
				$date_of_completion = $_POST['date_of_completion'];
			}
			$update_attachment = '';
			if(!empty($_FILES['update_attachment']['name']))
			{
				$update_attachment = $_FILES['update_attachment']['name'];
				$report_file_temp = $_FILES['update_attachment']['tmp_name'];
				$reportimage_folder="uploads/memo_update/".$update_attachment ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}
			if($update_attachment == '' && isset($_POST["edit_update_attachment"])){
				$update_attachment = $_POST["edit_update_attachment"];
			}
			if(isset($_POST['narration'])){
				$narration = $_POST['narration'];
			}
			
			$updQry="UPDATE memo set date_of_completion = '".strip_tags($date_of_completion)."', update_attachment = '".strip_tags($update_attachment)."', 
			narration = '".strip_tags($narration)."', status = 0, update_login_id = '".$userid."' WHERE memo_id= '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}
	

		// public function getDepartmentName($mysqli, $company_id){

		// 	$hierarchyDep = array();
		// 	$department_id = array();
		// 	$department_name = array();

		// 	$getDepartmentId = $mysqli->query("SELECT * FROM basic_creation WHERE company_id ='".strip_tags($company_id)."' AND status = 0 ");
		// 	while($row1=$getDepartmentId->fetch_assoc()){
		// 		$departmentArr[]    = $row1["department"];
		// 	}
		// 	$hierarchyDep = array_unique($departmentArr); 
		// 	// $hierarchyDep = array_map('intval', explode(',', $arrayUnique)); 

		// 	for($i=0; $i<=sizeof($hierarchyDep)-1; $i++){
		// 		$qry = "SELECT * FROM department_creation WHERE department_id ='".strip_tags($hierarchyDep[$i])."' AND status = 0"; 
		// 		$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
		// 		$detailrecords = array();
		// 		$i=0;
		// 		if ($mysqli->affected_rows>0)
		// 		{
		// 			while($row = $res->fetch_object())
		// 			{
		// 				$detailrecords[$i]['department_id']         = $row->department_id; 
		// 				$detailrecords[$i]['department_name']       = strip_tags($row->department_name);
		// 				$i++;
		// 			}
		// 		}
		// 	}

		// 	return $detailrecords;
		// }

		// Get Assign Employee table
        public function getAssignEmployeeName($mysqli, $to_department){

            $getQry = "SELECT * FROM staff_creation WHERE department ='".strip_tags($to_department)."' ";
            $res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            $j=0;
            if ($mysqli->affected_rows>0)
                {
                    while($row = $res->fetch_object())
                    {
                        $detailrecords[$j]['staff_id']            = $row->staff_id;
                        $detailrecords[$j]['staff_name']        = strip_tags($row->staff_name);
                        $j++;
                    }
                }
            return $detailrecords;
        }

        // get reporting staff based on staff
        public function getInitialPhase($mysqli, $assign_employee){
            $getQry = "SELECT * FROM staff_creation WHERE staff_id ='".strip_tags($assign_employee)."' ";
            $res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            $j=0;
			$staff_name='';
            if ($mysqli->affected_rows>0)
                {
                    while($row = $res->fetch_object())
                    {
                        $detailrecords[$j]['staff_id']            = $row->staff_id;
                            $getname = "SELECT staff_name FROM staff_creation WHERE staff_id = '".strip_tags($row->reporting)."' ";
                            $res1 = $mysqli->query($getname) or die("Error in Get All Records".$mysqli->error);
                            while ($row2 = $res1->fetch_object()) {
                                $staff_name = $row2->staff_name;
                            }
                        $detailrecords[$j]['reporting']           = $staff_name;
                        $j++;
                    }
                }
            return $detailrecords;
        }

		// get initial_phase based final_phase
		public function getFinalPhase($mysqli, $initial_phase){
			$getQry = "SELECT * FROM staff_creation WHERE reporting ='".strip_tags($initial_phase)."' ";
				$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
				$detailrecords = array();
				$j=0;
				$staff_name='';
				if ($mysqli->affected_rows>0)
					{
						while($row = $res->fetch_object())
						{
							$detailrecords[$j]['staff_id']            = $row->staff_id;
								$getname = "SELECT staff_name FROM staff_creation WHERE staff_id = '".strip_tags($row->reporting)."' ";
								$res1 = $mysqli->query($getname) or die("Error in Get All Records".$mysqli->error);
								while ($row2 = $res1->fetch_object()) {
									$staff_name = $row2->staff_name;
								}
							$detailrecords[$j]['reporting']           = $staff_name;
							$j++;
						}
					}
				return $detailrecords;
			}

		//  Get branch name with company name
		public function getBranchWithCompanyName($mysqli) {

			$qry = "SELECT * FROM branch_creation WHERE 1 AND status=0 ORDER BY branch_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['branch_id']            = $row->branch_id; 
					$detailrecords[$i]['branch_name']          = strip_tags($row->branch_name);
						$getname = "SELECT company_name FROM company_creation WHERE company_id = '".strip_tags($row->company_id)."' ";
						$res1 = $mysqli->query($getname) or die("Error in Get All Records".$mysqli->error);
						while ($row2 = $res1->fetch_object()) {
							$company_name = $row2->company_name;
						}

					$detailrecords[$i]['company_name']       	   = $company_name;
					$i++;
				}
			}

			return $detailrecords;
		}


		function getOverDueTask($mysqli){
			
			$today = date("Y-m-d");
			$getqry = "SELECT * FROM assign_work_ref WHERE to_date < '".$today."' and work_status != 3 and status =0 ";
			$res12 = $mysqli->query($getqry);
			$detailrecords = array();
			$j=0;
			while($row12 = $res12->fetch_assoc())
			{
				$detailrecords[$j]['work_id'] = $row12["assign_work_reff_id"];  
				$detailrecords[$j]['work_des_text'] = $row12["work_des_text"];  
				$detailrecords[$j]['assign_to'] = $row12["assign_to"];  
				$to_date = $row12["to_date"];
				$detailrecords[$j]['to_date'] = $to_date ;  
				
				$detailrecords[$j]['department_id'] = $row12["department_id"];  
				$getbranch = "SELECT * FROM department_creation where department_id = '".$detailrecords[$j]['department_id']."' ";
				$res2 = $mysqli->query($getbranch);
				$row2 = $res2->fetch_assoc();
				$detailrecords[$j]['branch_id'] = $row2['company_id'];

				$j++;
			}
			return $detailrecords; 
		}

		function getOverDueTask1($mysqli){
			$today = date("Y-m-d");
			$getqry = "SELECT * FROM todo_creation WHERE to_date < '".$today."' AND work_status != 3 AND status = 0";	
			$res12 = $mysqli->query($getqry);
			$detailrecords = array();
			$j=0;
			while($row12 = $res12->fetch_assoc())
			{
				$detailrecords[$j]['todo_id'] = $row12["todo_id"];  
				$detailrecords[$j]['work_des'] = $row12["work_des"];  
				$detailrecords[$j]['assign_to'] = $row12["assign_to"];
				$to_date = $row12["to_date"];
				$detailrecords[$j]['to_date'] = $to_date;
				$detailrecords[$j]['branch_id'] = $row12['company_id'];

				// $detailrecords[$j]['department_id'] = $row12["department_id"];  
				// $getbranch = "SELECT * FROM department_creation where department_id = '".$detailrecords[$j]['department_id']."' ";
				// $res2 = $mysqli->query($getbranch);
				// $row2 = $res2->fetch_assoc();
				// $j++;
			}
			return $detailrecords; 
		}


		// get company and branch name based on session id
        public function getsCompanyBranchDetail($mysqli, $sbranch_id){
            $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$sbranch_id."' AND status=0 ORDER BY branch_id ASC";
            $res = $mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            // $detailrecords['company_name'] = '';
            // $detailrecords['branch_name'] = '';
            $i=0;
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object())
                {
                    $detailrecords['branch_name']          = strip_tags($row->branch_name);
                    $detailrecords['company_id']          = strip_tags($row->company_id);
                    $detailrecords['address1']          = strip_tags($row->address1);
                    $detailrecords['address2']          = strip_tags($row->address2);
                    $detailrecords['state']          = strip_tags($row->state);
                    $detailrecords['city']          = strip_tags($row->city);
                        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".strip_tags($row->company_id)."' ";
                        $res1 = $mysqli->query($getname) or die("Error in Get All Records".$mysqli->error);
                        while ($row2 = $res1->fetch_object()) {
                            $company_name = $row2->company_name;
                        }
                    $detailrecords['company_name'] = $company_name;
                    $i++;
                }
            }
            return $detailrecords;
        }


		//  Get branch Name
		public function getCompanyNameFromBranch($mysqli) {

			$qry = "SELECT * FROM branch_creation WHERE 1 AND status=0 ORDER BY branch_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['company_id']          = strip_tags($row->company_id);
						$getname = "SELECT company_name FROM company_creation WHERE company_id = '".strip_tags($row->company_id)."' ";
						$res1 = $mysqli->query($getname) or die("Error in Get All Records".$mysqli->error);
						while ($row2 = $res1->fetch_object()) {
							$company_name = $row2->company_name;
						}
		
					$detailrecords[$i]['company_name'] = $company_name;
					$i++;
				}
			}
			return $detailrecords;
		}


		public function getEditCompanyBranchDetail($mysqli, $branch_id){

			$qry = "SELECT * FROM branch_creation WHERE branch_id = '".$branch_id."' AND status=0 ORDER BY branch_id ASC"; 
			$res = $mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i = 0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['company_id']  = strip_tags($row->company_id);
					// 	$getname = "SELECT company_name FROM company_creation WHERE company_id = '".strip_tags($row->company_id)."' ";
					// 	$res1 = $mysqli->query($getname) or die("Error in Get All Records".$mysqli->error);
					// 	while ($row2 = $res1->fetch_object()) {
					// 		$company_name = $row2->company_name;
					// 	}
					// $detailrecords[$i]['company_name'] = $company_name;
					$i++;
				}
			}

			return $detailrecords;

		}

			//  Get asset Name
			public function getAssetsName($mysqli) {

				$qry = "SELECT * FROM asset_register WHERE 1 AND status=0 ORDER BY asset_id ASC"; 
				$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
				$detailrecords = array();
				$i=0;
				if ($mysqli->affected_rows>0)
				{
					while($row = $res->fetch_object())
					{
						$detailrecords[$i]['asset_id']            = $row->asset_id; 
						$detailrecords[$i]['asset_classification']       	= strip_tags($row->asset_classification);
						$i++;
					}
				}
				return $detailrecords;
			}

			//Add addAssetDetails
		public function addAssetDetails($mysqli){
			if(isset($_POST['company_id'])){
				$company_id = $_POST['company_id'];
			}
			if(isset($_POST['branch_id'])){
				$branch_id = $_POST['branch_id'];
			}
			if(isset($_POST['asset_class'])){
				$asset_class = $_POST['asset_class'];
			}
			if(isset($_POST['asset_name'])){
				$asset_name = $_POST['asset_name'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['put_to'])){
				$put_to = $_POST['put_to'];
			}
			if(isset($_POST['depreciation'])){
				$depreciation = $_POST['depreciation'];
			}
			if(isset($_POST['as_on'])){
				$as_on = $_POST['as_on'];
			}
			if(isset($_POST['modal_no'])){
				$modal_no = $_POST['modal_no'];
			}
			if(isset($_POST['warranty_upto'])){
				$warranty_upto = $_POST['warranty_upto'];
			}
			if(isset($_POST['spare_names'])){
				$spare_names1 = $_POST['spare_names'];
				$spare_names = implode(",", $spare_names1);
			}
			
			
			$insertQry="INSERT INTO asset_details(company_id,branch_id,classification,asset_name,asset_value,dou,depreciation,as_on,spare_names,created_date)
			VALUES('".strip_tags($company_id)."', '".strip_tags($branch_id)."', '".strip_tags($asset_class)."', 
			'".strip_tags($asset_name)."', '".strip_tags($asset_value)."', '".strip_tags($put_to)."', '".strip_tags($depreciation)."', '".strip_tags($as_on)."', 
			'".strip_tags($spare_names)."', current_timestamp() )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			$asset_details_id = $mysqli->insert_id; 
			
			for($i=0; $i<=sizeof($modal_no)-1; $i++){
				
				$kraRefInsert="INSERT INTO asset_details_ref(modal_no, warranty_upto, asset_details_reff_id)
				VALUES('".strip_tags($modal_no[$i])."', '".strip_tags($warranty_upto[$i])."', '".strip_tags($asset_details_id)."')";
				$insRefresult=$mysqli->query($kraRefInsert) or die("Error ".$mysqli->error);
			}
		}
		
		//Add addAssetDetails
		public function updateAssetDetails($mysqli,$id){

			if(isset($_POST['company_id'])){
				$company_id = $_POST['company_id'];
			}
			
			if(isset($_POST['branch_id'])){
				$branch_id = $_POST['branch_id'];
			}
			if(isset($_POST['asset_class'])){
				$asset_class = $_POST['asset_class'];
			}
			if(isset($_POST['asset_name'])){
				$asset_name = $_POST['asset_name'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['put_to'])){
				$put_to = $_POST['put_to'];
			}
			if(isset($_POST['depreciation'])){
				$depreciation = $_POST['depreciation'];
			}
			if(isset($_POST['as_on'])){
				$as_on = $_POST['as_on'];
			}
			if(isset($_POST['modal_no'])){
				$modal_no = $_POST['modal_no'];
			}
			if(isset($_POST['warranty_upto'])){
				$warranty_upto = $_POST['warranty_upto'];
			}
			if(isset($_POST['spare_names'])){
				$spare_names1 = $_POST['spare_names'];
				$spare_names = implode(",", $spare_names1);
			}
			
			
			$updateQry="UPDATE asset_details set company_id = '".strip_tags($company_id)."',branch_id = '".strip_tags($branch_id)."',
			classification ='".strip_tags($asset_class)."', asset_name = '".strip_tags($asset_name)."',asset_value = '".strip_tags($asset_value)."',
			dou = '".strip_tags($put_to)."',depreciation = '".strip_tags($depreciation)."',as_on = '".strip_tags($as_on)."',spare_names= '".strip_tags($spare_names)."', status = 0
			WHERE asset_details_id = '".$id."' ";
			$updresult=$mysqli->query($updateQry) or die("Error ".$mysqli->error);
			$DeleteAssetRef = $mysqli->query("DELETE FROM asset_details_ref WHERE asset_details_reff_id = '".$id."' ");
			
			for($i=0; $i<=sizeof($modal_no)-1; $i++){
				
				$AssetRefInsert="INSERT INTO asset_details_ref(modal_no, warranty_upto, asset_details_reff_id)
				VALUES('".strip_tags($modal_no[$i])."', '".strip_tags($warranty_upto[$i])."', '".strip_tags($id)."')";
				$insRefresult=$mysqli->query($AssetRefInsert) or die("Error ".$mysqli->error);
			}
		}
		//get spare names
		function getSpareName($mysqli){
			$getqry = "SELECT * FROM spare_creation WHERE status = 0";
			$res12 = $mysqli->query($getqry);
			$detailrecords = array();
			$j=0;
			while($row12 = $res12->fetch_assoc())
			{
				$detailrecords[$j]['spare_id'] = $row12["spare_id"];  
				$detailrecords[$j]['spare_name'] = $row12["spare_name"];  
				$j++;
			}
			return $detailrecords; 
		}
		
		//get Asset Details Table 
		function getAssetDetails($mysqli,$id){
			$getqry = "SELECT * FROM asset_details WHERE asset_details_id='".$id."' ";
			$res12 = $mysqli->query($getqry);
			$detailrecords = array();
			$j=0;
			// while($row12 = $res12->fetch_assoc())
			// {
			$row12 = $res12->fetch_assoc();
				$detailrecords['asset_details_id'] = $row12["asset_details_id"];  
				$detailrecords['company_id'] = $row12["company_id"];  
				$detailrecords['branch_id'] = $row12["branch_id"];  
				$detailrecords['classification'] = $row12["classification"];  
				$detailrecords['asset_name'] = $row12["asset_name"];  
				$detailrecords['asset_value'] = $row12["asset_value"];  
				$detailrecords['dou'] = $row12["dou"];  
				$detailrecords['depreciation'] = $row12["depreciation"];  
				$detailrecords['as_on'] = $row12["as_on"];  
				$detailrecords['spare_names'] = $row12["spare_names"];  
				$j++;
			// }
			return $detailrecords; 
		}
		
		//get Asset Details Table 
		function getAssetDetails_ref($mysqli,$asset_details_id){
			$getqry = "SELECT * FROM asset_details_ref WHERE asset_details_reff_id ='".$asset_details_id."' ";
			$res12 = $mysqli->query($getqry);
			$detailrecords1 = array();
			$j=0;
			while($row12 = $res12->fetch_assoc())
			{
				// $row12 = $res12->fetch_assoc();
				$detailrecords1[$j]['model_no'] = $row12["modal_no"];  
				$detailrecords1[$j]['warranty_upto'] = $row12["warranty_upto"];  
				$j++;
			}
			return $detailrecords1; 
		}
		
		//  Delete company
		public function deleteAssetDetails($mysqli, $id){

			$companyDelete = "UPDATE asset_details set status='1' WHERE asset_details_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($companyDelete) or die("Error in delete query".$mysqli->error);
		}
		
		// Get Asset Register table
		public function getAssetClassName($mysqli){

			$getQry = "SELECT * FROM asset_register"; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				while ($row = $res->fetch_object()) {
					$detailrecords[$j]['asset_id'] = $row->asset_id;
					$detailrecords[$j]['asset_class'] = $row->asset_classification;
					$detailrecords[$j]['asset_name'] = $row->asset_name;
					$detailrecords[$j]['asset_value'] = $row->asset_value;
					$j++;
				}
			}
			
			return $detailrecords;
		}
		//  Get Branch Name
		public function getBranchName($mysqli) {
			$qry = "SELECT * FROM branch_creation WHERE 1 AND status=0 ORDER BY branch_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['branch_id']            = $row->branch_id; 
					$detailrecords[$i]['branch_name']       	= strip_tags($row->branch_name);
					$detailrecords[$i]['company_id']       	= strip_tags($row->company_id);
					$detailrecords[$i]['address1']       	= strip_tags($row->address1);
					$detailrecords[$i]['address2']       	= strip_tags($row->address2);
					$detailrecords[$i]['city']       	= strip_tags($row->city);
					$i++;
				}
			}
			return $detailrecords;
		}


		//Add service Indent
		public function addServiceIndent($mysqli,$userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			} 
			if(isset($_POST['date_of_indent'])){
				$date_of_indent = $_POST['date_of_indent'];
			}
			if(isset($_POST['asset_class'])){
				$asset_class = $_POST['asset_class'];
			}
			if(isset($_POST['asset_name1'])){
				$asset_name1 = $_POST['asset_name1'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['vendor_address'])){
				$vendor_address = $_POST['vendor_address'];
			}
			if(isset($_POST['vendor_address1'])){
				$vendor_address1 = $_POST['vendor_address1'];
			}
			if(isset($_POST['vendor_address2'])){
				$vendor_address2 = $_POST['vendor_address2'];
			}
			if(isset($_POST['company_address'])){
				$company_address = $_POST['company_address'];
			}
			if(isset($_POST['company_address1'])){
				$company_address1 = $_POST['company_address1'];
			}
			if(isset($_POST['company_address2'])){
				$company_address2 = $_POST['company_address2'];
			}
			if(isset($_POST['reason_for_indent'])){
				$reason_for_indent = $_POST['reason_for_indent'];
			}
			if(isset($_POST['expected_to_arrive'])){
				$expected_to_arrive = $_POST['expected_to_arrive'];
			}
			if(isset($_POST['stock_in_out'])){
				$stock_in_out = $_POST['stock_in_out'];
			}

			$insertQry="INSERT INTO service_indent(company_id, date_of_indent, asset_class, asset_name1, asset_value, vendor_address, vendor_address1, vendor_address2, 
			company_address, company_address1, company_address2, reason_for_indent, expected_to_arrive, insert_login_id)VALUES('".strip_tags($company_id)."', '".strip_tags($date_of_indent)."', '".strip_tags($asset_class)."',
			'".strip_tags($asset_name1)."','".strip_tags($asset_value)."', '".strip_tags($vendor_address)."', '".strip_tags($vendor_address1)."', '".strip_tags($vendor_address2)."',
			'".strip_tags($company_address)."', '".strip_tags($company_address1)."', '".strip_tags($company_address2)."', '".strip_tags($reason_for_indent)."', '".strip_tags($expected_to_arrive)."', '".$userid."' )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		// Get Service Indent table
		public function getServiceIndent($mysqli, $id){

			$getQry = "SELECT * FROM service_indent where service_indent_id= '".$id."' "; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['company_id']      = $row->company_id;	
				$detailrecords['service_indent_id']      = $row->service_indent_id; 
				$detailrecords['date_of_indent']      = $row->date_of_indent;		
				$detailrecords['asset_class']      = $row->asset_class;		
				$detailrecords['asset_name1']      = $row->asset_name1;		
				$detailrecords['asset_value']      = $row->asset_value;		
				$detailrecords['vendor_address']      = $row->vendor_address;		
				$detailrecords['vendor_address1']      = $row->vendor_address1;		
				$detailrecords['vendor_address2']      = $row->vendor_address2;		
				$detailrecords['company_address']      = $row->company_address;		
				$detailrecords['company_address1']      = $row->company_address1;		
				$detailrecords['company_address2']      = $row->company_address2;		
				$detailrecords['reason_for_indent']      = $row->reason_for_indent;		
				$detailrecords['expected_to_arrive']      = $row->expected_to_arrive;		
			}

			return $detailrecords;
		}

		//Update Service Indent
		public function updateServiceIndent($mysqli,$id,$userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			} 
			if(isset($_POST['date_of_indent'])){
				$date_of_indent = $_POST['date_of_indent'];
			}
			if(isset($_POST['asset_class'])){
				$asset_class = $_POST['asset_class'];
			}
			if(isset($_POST['asset_name1'])){
				$asset_name1 = $_POST['asset_name1'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['vendor_address'])){
				$vendor_address = $_POST['vendor_address'];
			}
			if(isset($_POST['vendor_address1'])){
				$vendor_address1 = $_POST['vendor_address1'];
			}
			if(isset($_POST['vendor_address2'])){
				$vendor_address2 = $_POST['vendor_address2'];
			}
			if(isset($_POST['company_address'])){
				$company_address = $_POST['company_address'];
			}
			if(isset($_POST['company_address1'])){
				$company_address1 = $_POST['company_address1'];
			}
			if(isset($_POST['company_address2'])){
				$company_address2 = $_POST['company_address2'];
			}
			if(isset($_POST['reason_for_indent'])){
				$reason_for_indent = $_POST['reason_for_indent'];
			}
			if(isset($_POST['expected_to_arrive'])){
				$expected_to_arrive = $_POST['expected_to_arrive'];
			}

			$updQry="UPDATE service_indent set company_id = '".strip_tags($company_id)."', date_of_indent = '".strip_tags($date_of_indent)."', asset_class = '".strip_tags($asset_class)."', asset_name1 = '".strip_tags($asset_name1)."', 
			asset_value = '".strip_tags($asset_value)."', vendor_address = '".strip_tags($vendor_address)."', vendor_address1 = '".strip_tags($vendor_address1)."', 
			vendor_address2 = '".strip_tags($vendor_address2)."', company_address = '".strip_tags($company_address)."', company_address1 = '".strip_tags($company_address1)."', 
			company_address2 = '".strip_tags($company_address2)."', reason_for_indent = '".strip_tags($reason_for_indent)."', expected_to_arrive = '".strip_tags($expected_to_arrive)."', 
			status = 0, stock_in_out = '1', update_login_id = '".$userid."' WHERE service_indent_id= '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);

			// $updQry="UPDATE asset_register set stock_in_out = '1', update_login_id = '".$userid."' WHERE asset_id= '".strip_tags($asset_class)."' ";

			// $updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}

			//Delete Service Indent
		public function deleteServiceIndent($mysqli, $id, $userid){

			$deleteQry = "UPDATE service_indent set status='1', delete_login_id = '".$userid."' WHERE service_indent_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

			//update Stock In out
		public function StockInoutServiceIndent($mysqli, $id, $userid){

			$deleteQry = "UPDATE service_indent set stock_in_out = '2', update_login_id = '".$userid."' WHERE service_indent_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in Update query".$mysqli->error);
		}

			// Get Assign Employee table
		public function getAssetName($mysqli, $asset_class){ 
			$getQry = "SELECT * FROM asset_register WHERE asset_classification ='".strip_tags($asset_class)."' ";
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
				{
					while($row = $res->fetch_object())
					{
						$detailrecords[$j]['asset_id']            = $row->asset_id;
						$detailrecords[$j]['asset_name']        = strip_tags($row->asset_name); 
						$j++;
					}
				}
			return $detailrecords;
		}

		//Add memo status
		public function addMemoStatus($mysqli,$userid){
			if(isset($_POST['date_of_completion'])){
				$date_of_completion = $_POST['date_of_completion'];
			}
			if(isset($_POST['work_update'])){
				$work_update = $_POST['work_update'];
			}
			if(isset($_POST['highlighted'])){
				$highlighted = $_POST['highlighted'];
			}
			
			$attachment = '';
			if(!empty($_FILES['attachment']['name']))
			{
				$attachment = $_FILES['attachment']['name'];
				$report_file_temp = $_FILES['attachment']['tmp_name'];
				$reportimage_folder="uploads/memo_status/".$attachment ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}

			$insertQry="INSERT INTO memo_status(date_of_completion, work_update, highlighted, attachment, insert_login_id)VALUES('".strip_tags($date_of_completion)."',
			'".strip_tags($work_update)."', '".strip_tags($highlighted)."', '".strip_tags($attachment)."', '".$userid."' )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		// Get memo status
		public function getMemoStatus($mysqli, $id){

			$getQry = "SELECT * FROM memo_status where memo_status_id= '".$id."' "; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['memo_status_id']      = $row->memo_status_id; 
				$detailrecords['date_of_completion']      = $row->date_of_completion;		
				$detailrecords['work_update']      = $row->work_update;		
				$detailrecords['highlighted']      = $row->highlighted;		
				$detailrecords['attachment']      = $row->attachment;	
			}
			
			return $detailrecords;
		}

		//Update memo status
		public function updateMemoStatus($mysqli,$id,$userid){

			if(isset($_POST['date_of_completion'])){
				$date_of_completion = $_POST['date_of_completion'];
			}
			if(isset($_POST['work_update'])){
				$work_update = $_POST['work_update'];
			}
			if(isset($_POST['highlighted'])){
				$highlighted = $_POST['highlighted'];
			}

			$attachment = '';
			if(!empty($_FILES['attachment']['name']))
			{
				$attachment = $_FILES['attachment']['name'];
				$report_file_temp = $_FILES['attachment']['tmp_name'];
				$reportimage_folder="uploads/memo_status/".$attachment ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}
			if($attachment == '' && isset($_POST["edit_attachment"])){
				$attachment = $_POST["edit_attachment"];
			}

			$updQry="UPDATE memo_status set date_of_completion = '".strip_tags($date_of_completion)."', work_update = '".strip_tags($work_update)."', 
			highlighted = '".strip_tags($highlighted)."', attachment = '".strip_tags($attachment)."',  
			status = 0, update_login_id = '".$userid."' WHERE memo_status_id= '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}

		//Delete memo status
		public function deleteMemoStatus($mysqli, $id, $userid){

			$deleteQry = "UPDATE memo_status set status='1', delete_login_id = '".$userid."' WHERE memo_status_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

		public function GetMemoId($mysqli, $memoid){
			$staff_id = array();
			$staff_name = array();
			$detailrecords = array();
			$staff_id_reporting = array();
			$getstaffId = $mysqli->query("SELECT * FROM memo WHERE memo_id ='".strip_tags($memoid)."' AND status = 0 ");
			while($row1=$getstaffId->fetch_assoc()){
				$assign_employee    = $row1["assign_employee"];
			}
				$geteqry = "SELECT * FROM staff_creation where staff_id = '".$assign_employee."' ";
				$res2 =$mysqli->query($geteqry) or die("Error in Get All Records".$mysqli->error);
				$row2=$res2->fetch_assoc();
				$reporting_staff = $row2['reporting'];
				$department = $row2["department"];
				
				if($reporting_staff >0){
					$detailrecords[0]['staff_id'] = $reporting_staff;
				//getting whole staffs who has no reporting persons
				$noreportQry = "SELECT * FROM staff_creation where (reporting = '' or reporting = null) and status=0 and department ='".$department."'";
				$noreportRes =$mysqli->query($noreportQry)or die("Error in Get All Records".$mysqli->error);
				while($reportingRow=$noreportRes->fetch_assoc()){
					$staff_id_reporting[]    = $reportingRow["staff_id"];
				}
				$check = false;
				for($s=0; $check == false; $s++){
					for($k=0; $k<=sizeof($staff_id_reporting)-1; $k++){
						if($reporting_staff == $staff_id_reporting[$k]){
							$final_report = $staff_id_reporting[$k];
							$geteqry = "SELECT * FROM staff_creation where staff_id = '".$final_report."' ";
							$res2 =$mysqli->query($geteqry)or die("Error in Get All Records".$mysqli->error);
							$row2=$res2->fetch_assoc();
							$detailrecords[$s]['staff_name'] = $row2["staff_name"];
							$check = true;
						}
					}
					if($check != true){
						$geteqry = "SELECT * FROM staff_creation where staff_id = '".$reporting_staff."' ";
						$res2 =$mysqli->query($geteqry)or die("Error in Get All Records".$mysqli->error);
						$row2=$res2->fetch_assoc();
						$reporting_staff = $row2['reporting'];
						$staff_name = $row2["staff_name"];
						$detailrecords[$s]['staff_name'] = $staff_name;
						$detailrecords[$s+1]['staff_id'] = $reporting_staff;
					}
				}
				return $detailrecords;
			}else{
				return $detailrecords;
			}
            }

			//Add RGP
		public function addRGP($mysqli){
			if(isset($_POST['rgp_date'])){
				$rgp_date = $_POST['rgp_date'];
			}
			if(isset($_POST['return_date'])){
				$return_date = $_POST['return_date'];
			}
			if(isset($_POST['asset_class'])){
				$asset_class = $_POST['asset_class'];
			}
			if(isset($_POST['company_id'])){
				$company_id = $_POST['company_id'];
			}
			if(isset($_POST['branch_from'])){
				$branch_from = $_POST['branch_from'];
			}
			if(isset($_POST['branch_to'])){
				$branch_to = $_POST['branch_to'];
			}
			if(isset($_POST['from_comm_line1'])){
				$from_comm_line1 = $_POST['from_comm_line1'];
			}
			if(isset($_POST['from_comm_line2'])){
				$from_comm_line2 = $_POST['from_comm_line2'];
			}
			if(isset($_POST['to_comm_line1'])){
				$to_comm_line1 = $_POST['to_comm_line1'];
			}
			if(isset($_POST['to_comm_line2'])){
				$to_comm_line2 = $_POST['to_comm_line2'];
			}
			if(isset($_POST['asset_name'])){
				$asset_name = $_POST['asset_name'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['reason_rgp'])){
				$reason_rgp = trim($_POST['reason_rgp']);
			}
			
			
			$insertQry="INSERT INTO rgp_creation(rgp_date,return_date,asset_class,company_id,branch_from,branch_to,from_comm_line1,from_comm_line2,to_comm_line1,to_comm_line2,asset_name_id,asset_value,reason_rgp,created_date)
			VALUES('".strip_tags($rgp_date)."', '".strip_tags($return_date)."', '".strip_tags($asset_class)."', 
			'".strip_tags($company_id)."', '".strip_tags($branch_from)."', '".strip_tags($branch_to)."', '".strip_tags($from_comm_line1)."', '".strip_tags($from_comm_line2)."', 
			'".strip_tags($to_comm_line1)."','".strip_tags($to_comm_line2)."','".strip_tags($asset_name)."','".strip_tags($asset_value)."', '".strip_tags($reason_rgp)."',current_timestamp() )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			
			$insertAsset = "UPDATE asset_register set rgp_status ='inward' where asset_id = '" . strip_tags($asset_name) . "' ";
			$insassetresult=$mysqli->query($insertAsset) or die("Error ".$mysqli->error);
			
		}
		//Update RGP
		public function updateRGP($mysqli,$id){
			if(isset($_POST['rgp_date'])){
				$rgp_date = $_POST['rgp_date'];
			}
			if(isset($_POST['return_date'])){
				$return_date = $_POST['return_date'];
			}
			if(isset($_POST['asset_class'])){
				$asset_class = $_POST['asset_class'];
			}
			if(isset($_POST['company_id'])){
				$company_id = $_POST['company_id'];
			}
			if(isset($_POST['branch_from'])){
				$branch_from = $_POST['branch_from'];
			}
			if(isset($_POST['branch_to'])){
				$branch_to = $_POST['branch_to'];
			}
			if(isset($_POST['from_comm_line1'])){
				$from_comm_line1 = $_POST['from_comm_line1'];
			}
			if(isset($_POST['from_comm_line2'])){
				$from_comm_line2 = $_POST['from_comm_line2'];
			}
			if(isset($_POST['to_comm_line1'])){
				$to_comm_line1 = $_POST['to_comm_line1'];
			}
			if(isset($_POST['to_comm_line2'])){
				$to_comm_line2 = $_POST['to_comm_line2'];
			}
			if(isset($_POST['asset_name'])){
				$asset_name = $_POST['asset_name'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['reason_rgp'])){
				$reason_rgp = trim($_POST['reason_rgp']);
			}
			$extended_date = null;
			if(isset($_POST['extended_date']) and  $_POST['extended_date'] != 0000-00-00 ){
				$extended_date = $_POST['extended_date'];
			}
			$extend_reason = '';
			if(isset($_POST['extend_reason'])){
				$extend_reason = trim($_POST['extend_reason']);
			}

			$updateQry = "UPDATE rgp_creation SET extended_date = '".strip_tags($extended_date)."', extend_reason = '".strip_tags($extend_reason)."', 
			status = 0 WHERE rgp_id = '".$id."' ";
			$updresult=$mysqli->query($updateQry) or die("Error ".$mysqli->error);
			
		}
		//  Delete RGP
		public function deletergp($mysqli, $id){

			$companyDelete = "UPDATE rgp_creation set status='1' WHERE rgp_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($companyDelete) or die("Error in delete query".$mysqli->error);
		}
		

		//get RGP Table 
		function getRGPTable($mysqli,$rgp_id){
			$getqry = "SELECT * FROM rgp_creation WHERE rgp_id ='".$rgp_id."' ";
			$res12 = $mysqli->query($getqry);
			$detailrecords1 = array();
			// $j=0;
			$row12 = $res12->fetch_assoc();
			$detailrecords1['rgp_id'] = $row12["rgp_id"];  
			$detailrecords1['rgp_date'] = $row12["rgp_date"];  
			$detailrecords1['return_date'] = $row12["return_date"];  
			$detailrecords1['asset_class'] = strip_tags($row12["asset_class"]);  
			$detailrecords1['branch_from'] = $row12["branch_from"];  
			$detailrecords1['branch_to'] = $row12["branch_to"];  
			$detailrecords1['company_id'] = $row12["company_id"];  
			$detailrecords1['from_comm_line1'] = $row12["from_comm_line1"];  
			$detailrecords1['from_comm_line2'] = $row12["from_comm_line2"];  
			$detailrecords1['to_comm_line1'] = $row12["to_comm_line1"];  
			$detailrecords1['to_comm_line2'] = $row12["to_comm_line2"];  
			$detailrecords1['asset_name_id'] = $row12["asset_name_id"];  
			$detailrecords1['asset_value'] = $row12["asset_value"];  
			$detailrecords1['extended_date'] = $row12["extended_date"];  
			$detailrecords1['extend_reason'] = $row12["extend_reason"];  
			$detailrecords1['reason_rgp'] = strip_tags($row12["reason_rgp"]);  

			return $detailrecords1; 
		}

		//get Expired RGP
		function getexpiredRGP($mysqli){
			$today = date('Y-m-d');
			$qry = "SELECT * FROM rgp_creation WHERE return_date < '".$today."' or extended_date < '".$today."'  "; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['branch_from_id']            = $row->branch_from; 
					$detailrecords[$i]['branch_to_id']       	= strip_tags($row->branch_to);
					$detailrecords[$i]['asset_name_id']       	= strip_tags($row->asset_name_id);
					$detailrecords[$i]['extended_date']       	= strip_tags($row->extended_date);
					$detailrecords[$i]['return_date']       	= strip_tags($row->return_date);

					$qry1 = "SELECT branch_creation.branch_name, company_creation.company_name
					FROM branch_creation
					JOIN company_creation ON branch_creation.company_id = company_creation.company_id
					WHERE branch_creation.branch_id = '".$detailrecords[$i]['branch_from_id'] ."' ";
					
					$res1 = $mysqli->query($qry1)or die("Error in Get All Records".$mysqli->error);
					$row1 = $res1->fetch_object();
					$detailrecords[$i]['branch_from_name'] = $row1->branch_name;
					$detailrecords[$i]['company_from_name'] = $row1->company_name;
					
					$qry1 = "SELECT branch_creation.branch_name, company_creation.company_name
					FROM branch_creation
					JOIN company_creation ON branch_creation.company_id = company_creation.company_id
					WHERE branch_creation.branch_id = '".$detailrecords[$i]['branch_to_id'] ."' ";
					
					$res1 = $mysqli->query($qry1)or die("Error in Get All Records".$mysqli->error);
					$row1 = $res1->fetch_object();
					$detailrecords[$i]['branch_to_name'] = $row1->branch_name;
					$detailrecords[$i]['company_to_name'] = $row1->company_name;
					
					$qry2 = "SELECT * FROM asset_register where asset_id= '" . $detailrecords[$i]['asset_name_id'] . "' and status = 0 ";
					$res2 = $mysqli->query($qry2)or die("Error in Get All Records".$mysqli->error);
					$row2 = $res2->fetch_object();
					$detailrecords[$i]['asset_name'] = $row2->asset_name;

					$i++;
				}
			}

			return $detailrecords;
		}

		function getEditDepartment($mysqli, $company_id){

			$hierarchyArr = array();
			$hierarchyDep = array();
			$department_id = array();
			$department_name = array();

			// get department based on hierarchy cration
			$getDepartmentId = $mysqli->query("SELECT * FROM basic_creation WHERE company_id ='".strip_tags($company_id)."' AND status = 0 ");
			if ($mysqli->affected_rows>0)
			{
				while($row = $getDepartmentId->fetch_object()){
					$hierarchyArr[]            = $row->department;
				}
			}

			// remove array duplicates without affect array index
			$hierarchyDep=$hierarchyArr;
			$duplicated=array();
			foreach($hierarchyDep as $k=>$v) {
				if( ($kt=array_search($v,$hierarchyDep))!==false and $k!=$kt )
				{ unset($hierarchyDep[$kt]);  $duplicated[]=$v; }
			}
			sort($hierarchyDep); 

			$detailrecords = array();
			$i=0;
			for($j=0; $j<=sizeof($hierarchyDep)-1; $j++){
				
				$getDepartmentName = $mysqli->query("SELECT department_id, department_name FROM department_creation 
				WHERE department_id ='".strip_tags($hierarchyDep[$j])."' AND status = 0");
				if ($mysqli->affected_rows>0)
				{
					while($row2 = $getDepartmentName->fetch_object()){
						$detailrecords[$i]['department_id'] = $row2->department_id; 
						$detailrecords[$i]['department_name'] = $row2->department_name; 
						$i++;       
					}
				}
			}
			
			return $detailrecords;
		}

		function getEditDesignation($mysqli, $department_id){

			$hierarchyDesig = array();
			$designation_name = array();
			$designation_id = array();
			$designationFetch = array();

			// get department based on hierarchy cration
			for($i=0; $i<=sizeof($department_id)-1; $i++){
				$getDepartmentId = $mysqli->query("SELECT * FROM basic_creation WHERE department ='".strip_tags($department_id[$i])."' AND status = 0 ");
				if ($mysqli->affected_rows>0)
				{
					while($row = $getDepartmentId->fetch_object()){
						$designationFetch[]    = $row->designation;
					}
				}
			}

			$designationStr = implode(",", $designationFetch);
			$designationArr = array_map('intval', explode(',', $designationStr)); 

			// remove array duplicates without affect array index
			$designation=$designationArr;
			$duplicated=array();

			foreach($designation as $k=>$v) {

				if( ($kt=array_search($v,$designation))!==false and $k!=$kt )
				{ unset($designation[$kt]);  $duplicated[]=$v; }
			
			}
			sort($designation);

			$detailrecords = array();
			$i=0;
			for($j=0; $j<=sizeof($designation)-1; $j++){
				
				$getDepartmentName = $mysqli->query("SELECT designation_id, designation_name FROM designation_creation 
				WHERE designation_id ='".strip_tags($designation[$i])."' AND status = 0");
				if ($mysqli->affected_rows>0){
					while($row2 = $getDepartmentName->fetch_object()){
						$detailrecords[$i]['designation_id'] = $row2->designation_id; 
						$detailrecords[$i]['designation_name'] = $row2->designation_name; 
						$i++;       
					}
				}
			}
			
			return $detailrecords;
		}

		function getEditDesignationKRAKPI($mysqli, $department){

			$hierarchyDesig = array();
			$designation_name = array();
			$designation_id = array();
			$designationFetch = array();

			$department_id = explode(' ', $department);

			// get department based on hierarchy cration
			for($i=0; $i<=sizeof($department_id)-1; $i++){
				$getDepartmentId = $mysqli->query("SELECT * FROM basic_creation WHERE department ='".strip_tags($department_id[$i])."' AND status = 0 ");
				if ($mysqli->affected_rows>0)
				{
					while($row = $getDepartmentId->fetch_object()){
						$designationFetch[]    = $row->designation;
					}
				}
			}

			// $hierarchyDesig = array_merge($top_hierarchy, $sub_ordinate);
			$designationStr = implode(",", $designationFetch);
			$designationArr = array_map('intval', explode(',', $designationStr)); 

			// remove array duplicates without affect array index
			$designation=$designationArr;
			$duplicated=array();

			foreach($designation as $k=>$v) {

				if( ($kt=array_search($v,$designation))!==false and $k!=$kt )
				{ unset($designation[$kt]);  $duplicated[]=$v; }
			
			}
			sort($designation);

			$detailrecords = array();
			$i=0;
			for($j=0; $j<=sizeof($designation)-1; $j++){
				
				$getDepartmentName = $mysqli->query("SELECT designation_id, designation_name FROM designation_creation 
				WHERE designation_id ='".strip_tags($designation[$i])."' AND status = 0");
				if ($mysqli->affected_rows>0){
					while($row2 = $getDepartmentName->fetch_object()){
						$detailrecords[$i]['designation_id'] = $row2->designation_id; 
						$detailrecords[$i]['designation_name'] = $row2->designation_name; 
						$i++;       
					}
				}
			}
			
			return $detailrecords;
		}


		//Add Permission On Dury
		public function addPermissionOnDuty($mysqli,$userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['department'])){
				$department_id = $_POST['department'];
			}
			if(isset($_POST['staff_name'])){
				$staff_name = $_POST['staff_name'];
			}
			if(isset($_POST['staff_code'])){
				$staff_code = $_POST['staff_code'];
			}
			if(isset($_POST['reporting'])){
				$reporting = $_POST['reporting'];
			}
			if(isset($_POST['reason'])){
				$reason = $_POST['reason'];
			}
			if(isset($_POST['permission_from_time'])){
				$permission_from_time = $_POST['permission_from_time'];
			}
			if(isset($_POST['permission_to_time'])){
				$permission_to_time = $_POST['permission_to_time'];
			}
			if(isset($_POST['permission_date'])){
				$permission_date = $_POST['permission_date'];
			}
			if(isset($_POST['on_duty_place'])){
				$on_duty_place = $_POST['on_duty_place'];
			}
			if(isset($_POST['leave_date'])){
				$leave_date = $_POST['leave_date'];
			}
			if(isset($_POST['leave_reason'])){
				$leave_reason = $_POST['leave_reason'];
			}
			
			$insertQry="INSERT INTO permission_or_on_duty(company_id, department_id, staff_id, staff_code, reporting, reason, permission_from_time, permission_to_time, 
			permission_date, on_duty_place, leave_date, leave_reason, insert_login_id)
			VALUES('".strip_tags($company_id)."', '".strip_tags($department_id)."', '".strip_tags($staff_name)."', '".strip_tags($staff_code)."', '".strip_tags($reporting)."', 
			 '".strip_tags($reason)."', '".strip_tags($permission_from_time)."', '".strip_tags($permission_to_time)."', '".strip_tags($permission_date)."', 
			 '".strip_tags($on_duty_place)."', '".strip_tags($leave_date)."', '".strip_tags($leave_reason)."', '".$userid."' )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		//Update Permission On Dury
		 public function updatePermissionOnDuty($mysqli,$id,$userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['department'])){
				$department_id = $_POST['department'];
			}
			if(isset($_POST['staff_name'])){
				$staff_name = $_POST['staff_name'];
			}
			if(isset($_POST['staff_code'])){
				$staff_code = $_POST['staff_code'];
			}
			if(isset($_POST['reporting'])){
				$reporting = $_POST['reporting'];
			}
			if(isset($_POST['reason'])){
				$reason = $_POST['reason'];
			}
			if(isset($_POST['permission_from_time'])){
				$permission_from_time = $_POST['permission_from_time'];
			}
			if(isset($_POST['permission_to_time'])){
				$permission_to_time = $_POST['permission_to_time'];
			}
			if(isset($_POST['permission_date'])){
				$permission_date = $_POST['permission_date'];
			}
			if(isset($_POST['on_duty_place'])){
				$on_duty_place = $_POST['on_duty_place'];
			}
			if(isset($_POST['leave_date'])){
				$leave_date = $_POST['leave_date'];
			}
			if(isset($_POST['leave_reason'])){
				$leave_reason = $_POST['leave_reason'];
			}
			
			$updQry="UPDATE permission_or_on_duty set company_id = '".strip_tags($company_id)."', department_id = '".strip_tags($department_id)."', 
			staff_id = '".strip_tags($staff_name)."', staff_code = '".strip_tags($staff_code)."', reporting = '".strip_tags($reporting)."', reason = '".strip_tags($reason)."',
			permission_from_time = '".strip_tags($permission_from_time)."', permission_to_time = '".strip_tags($permission_to_time)."', 
			permission_date = '".strip_tags($permission_date)."', on_duty_place = '".strip_tags($on_duty_place)."', leave_date = '".strip_tags($leave_date)."', 
			leave_reason = '".strip_tags($leave_reason)."', status = 0, update_login_id = '".$userid."' WHERE permission_on_duty_id= '".strip_tags($id)."' "; 
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}
		
		// Get Permission On Dury
		public function getPermissionOnDuty($mysqli, $id){

			$getQry = "SELECT * FROM permission_or_on_duty where permission_on_duty_id= '".$id."' "; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['company_id']      = $row->company_id; 
				$detailrecords['permission_on_duty_id']  = $row->permission_on_duty_id; 
				$detailrecords['department_id'] = $row->department_id;		
				$detailrecords['staff_id']      = $row->staff_id;		
				$detailrecords['staff_code']    = $row->staff_code;		
				$detailrecords['reporting']     = $row->reporting;		
				$detailrecords['reason']         = $row->reason;		
				$detailrecords['permission_from_time']     = $row->permission_from_time;		
				$detailrecords['permission_to_time']       = $row->permission_to_time;		
				$detailrecords['permission_date']       = $row->permission_date;		
				$detailrecords['on_duty_place']       = $row->on_duty_place;		
				$detailrecords['leave_date']       = $row->leave_date;		
				$detailrecords['leave_reason']       = $row->leave_reason;		
			}
			
			return $detailrecords;
		}
		
		//Delete Permission On Dury
		public function deletePermissionOnDuty($mysqli, $id, $userid){

			$deleteQry = "UPDATE permission_or_on_duty set status='1', delete_login_id = '".$userid."' WHERE permission_on_duty_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

		// Add Transfer Location
		public function addTransferLocation($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['department'])){
				$department_id = $_POST['department'];
			}
			if(isset($_POST['staff_code'])){
				$staff_code = $_POST['staff_code'];
			}
			if(isset($_POST['staff_name'])){
				$staff_name = $_POST['staff_name'];
			}
			if(isset($_POST['dot'])){
				$dot = $_POST['dot'];
			}
			if(isset($_POST['transfer_location'])){
				$transfer_location = $_POST['transfer_location'];
			}
			if(isset($_POST['tef'])){
				$tef = $_POST['tef'];
			}
			$file = '';
			if(!empty($_FILES['file']['name']))
			{
				$file = $_FILES['file']['name'];
				$media_file_temp = $_FILES['file']['tmp_name'];
				$mediaimage_folder="uploads/transfer_location/".$file;
				move_uploaded_file($media_file_temp, $mediaimage_folder);
			}
			
			$insertQry="INSERT INTO transfer_location(company_id, department_id, staff_id, staff_code, dot, transfer_location, transfer_effective_from, file, insert_login_id)
			VALUES('".strip_tags($company_id)."', '".strip_tags($department_id)."', '".strip_tags($staff_name)."', '".strip_tags($staff_code)."', '".strip_tags($dot)."', 
			'".strip_tags($transfer_location)."', '".strip_tags($tef)."', '".strip_tags($file)."', '".$userid."' )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		// Update Transfer Location
		 public function updateTransferLocation($mysqli,$id,$userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['department'])){
				$department_id = $_POST['department'];
			}
			if(isset($_POST['staff_code'])){
				$staff_code = $_POST['staff_code'];
			}
			if(isset($_POST['staff_name'])){
				$staff_name = $_POST['staff_name'];
			}
			if(isset($_POST['dot'])){
				$dot = $_POST['dot'];
			}
			if(isset($_POST['transfer_location'])){
				$transfer_location = $_POST['transfer_location'];
			}
			if(isset($_POST['tef'])){
				$tef = $_POST['tef'];
			}
			if(isset($_POST['edit_file'])){
				$file_old = $_POST['edit_file'];
			}
			
			if($file_old != ''){
				$file = $file_old;
			}else{
				//insert new file
				$file = '';
				if(!empty($_FILES['file']['name']))
				{
					//delete old file
					$path='uploads/transfer_location/'.$file_old;
					if (file_exists($path)) {
						unlink($path);
					}
					//insert new file
					$file = $_FILES['file']['name'];
					$media_file_temp = $_FILES['file']['tmp_name'];
					$mediaimage_folder="uploads/transfer_location/".$file;
					move_uploaded_file($media_file_temp, $mediaimage_folder);
				}
			}

			$updQry="UPDATE transfer_location set company_id = '".strip_tags($company_id)."', department_id = '".strip_tags($department_id)."', 
			staff_id = '".strip_tags($staff_name)."', staff_code = '".strip_tags($staff_code)."', dot = '".strip_tags($dot)."', 
			transfer_location = '".strip_tags($transfer_location)."', transfer_effective_from = '".strip_tags($tef)."', file = '".strip_tags($file)."',
			status = 0, update_login_id = '".$userid."' WHERE transfer_location_id= '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}
		
		// Get Transfer Location
		public function getTransferLocation($mysqli, $id){

			$getQry = "SELECT * FROM transfer_location where transfer_location_id= '".$id."' "; 
			$res = $mysqli->query($getQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$j=0;
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['company_id']      = $row->company_id; 
				$detailrecords['transfer_location_id']  = $row->transfer_location_id; 
				$detailrecords['department_id'] = $row->department_id;		
				$detailrecords['staff_id']      = $row->staff_id;		
				$detailrecords['staff_code']    = $row->staff_code;		
				$detailrecords['dot']     		= $row->dot;		
				$detailrecords['transfer_location']     = $row->transfer_location;		
				$detailrecords['transfer_effective_from']       = $row->transfer_effective_from;		
				$detailrecords['file']       = $row->file;				
			}
			
			return $detailrecords;
		}
		
		// Delete Transfer Location
		public function deleteTransferLocation($mysqli, $id, $userid){
			$deleteQry = "UPDATE transfer_location set status='1', delete_login_id = '".$userid."' WHERE transfer_location_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}


		// get category creation name list
		public function getCategoryCreationList($mysqli) {

			$qry = "SELECT * FROM category_creation WHERE 1 AND status=0 ORDER BY category_creation_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['category_creation_id']            = $row->category_creation_id; 
					$detailrecords[$i]['category_creation_name']       	= strip_tags($row->category_creation_name);
					$i++;
				}
			}
			return $detailrecords;
		}


		// Add PM Checklist
		public function addPMChecklist($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['category_id'])){
				$category_id = $_POST['category_id'];
			}
			if(isset($_POST['checklist'])){
				$checklist = $_POST['checklist'];
			}
			if(isset($_POST['type_of_checklist'])){
				$type_of_checklist = $_POST['type_of_checklist'];
			}
			if(isset($_POST['yes_no_na'])){
				$yes_no_na = $_POST['yes_no_na'];
			}
			if(isset($_POST['no_of_option'])){
				$no_of_option = $_POST['no_of_option'];
			}
			if(isset($_POST['option1'])){
				$option1 = $_POST['option1'];
			}
			if(isset($_POST['option2'])){
				$option2 = $_POST['option2'];
			}
			if(isset($_POST['option3'])){
				$option3 = $_POST['option3'];
			}
			if(isset($_POST['option4'])){
				$option4 = $_POST['option4'];
			}
			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['rating'])){
				$rating = $_POST['rating'];
			} 

			$rrInsert="INSERT INTO pm_checklist(company_id, category_id, checklist, type_of_checklist, yes_no_na, no_of_option, option1, option2, option3, option4, frequency, 
			rating, insert_login_id) VALUES('".strip_tags($company_id)."', '".strip_tags($category_id)."', '".strip_tags($checklist)."', '".strip_tags($type_of_checklist)."', 
			'".strip_tags($yes_no_na)."', '".strip_tags($no_of_option)."', '".strip_tags($option1)."', '".strip_tags($option2)."', '".strip_tags($option3)."', 
			'".strip_tags($option4)."', '".strip_tags($frequency)."', '".strip_tags($rating)."', '".strip_tags($userid)."')";
			$insresult=$mysqli->query($rrInsert) or die("Error ".$mysqli->error);
		}

		// Get PM Checklist
		public function getPMChecklist($mysqli, $id){

			$rr1Select = "SELECT * FROM pm_checklist WHERE pm_checklist_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($rr1Select) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$detailrecords['pm_checklist_id']      	= $row->pm_checklist_id;  
			    $detailrecords['company_id']  = $row->company_id;
			    $detailrecords['category_id']  = $row->category_id;
			    $detailrecords['checklist']  = $row->checklist;
			    $detailrecords['type_of_checklist']  = $row->type_of_checklist;
			    $detailrecords['yes_no_na']  = $row->yes_no_na;
			    $detailrecords['no_of_option']  = $row->no_of_option;
			    $detailrecords['option1']  = $row->option1;
			    $detailrecords['option2']  = $row->option2;
			    $detailrecords['option3']  = $row->option3;
			    $detailrecords['option4']  = $row->option4;
			    $detailrecords['frequency']  = $row->frequency;
			    $detailrecords['rating']  = $row->rating;
			}
			
			return $detailrecords;
		}

		// Update PM Checklist
		public function updatePMChecklist($mysqli, $id, $userid){ 

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['category_id'])){
				$category_id = $_POST['category_id'];
			}
			if(isset($_POST['checklist'])){
				$checklist = $_POST['checklist'];
			}
			if(isset($_POST['type_of_checklist'])){
				$type_of_checklist = $_POST['type_of_checklist'];
			}
			if(isset($_POST['yes_no_na'])){
				$yes_no_na = $_POST['yes_no_na'];
			}
			if(isset($_POST['no_of_option'])){
				$no_of_option = $_POST['no_of_option'];
			}
			if(isset($_POST['option1'])){
				$option1 = $_POST['option1'];
			}
			if(isset($_POST['option2'])){
				$option2 = $_POST['option2'];
			}
			if(isset($_POST['option3'])){
				$option3 = $_POST['option3'];
			}
			if(isset($_POST['option4'])){
				$option4 = $_POST['option4'];
			}
			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['rating'])){
				$rating = $_POST['rating'];
			} 

			$updateQry = 'UPDATE pm_checklist SET company_id = "'.strip_tags($company_id).'", category_id = "'.strip_tags($category_id).'", 
			checklist = "'.strip_tags($checklist).'", type_of_checklist = "'.strip_tags($type_of_checklist).'", yes_no_na = "'.strip_tags($yes_no_na).'", 
			no_of_option = "'.strip_tags($no_of_option).'", option1 = "'.strip_tags($option1).'", option2 = "'.strip_tags($option2).'", option3 = "'.strip_tags($option3).'", 
			option4 = "'.strip_tags($option4).'", frequency = "'.strip_tags($frequency).'", rating = "'.strip_tags($rating).'", status = "0" 
			WHERE pm_checklist_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 
		}

		//  Delete PM Checklist
		public function deletePMChecklist($mysqli, $id, $userid){

			$rrDelete = "UPDATE pm_checklist set status='1', delete_login_id='".strip_tags($userid)."' WHERE pm_checklist_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($rrDelete) or die("Error in delete query".$mysqli->error);
		}

		// Add BM Checklist
		public function addBMChecklist($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['category_id'])){
				$category_id = $_POST['category_id'];
			}
			if(isset($_POST['checklist'])){
				$checklist = $_POST['checklist'];
			}
			if(isset($_POST['rating'])){
				$rating = $_POST['rating'];
			} 

			$rrInsert="INSERT INTO bm_checklist(company_id, category_id, checklist, rating, insert_login_id) VALUES('".strip_tags($company_id)."', '".strip_tags($category_id)."', 
			'".strip_tags($checklist)."', '".strip_tags($rating)."', '".strip_tags($userid)."')";
			$insresult=$mysqli->query($rrInsert) or die("Error ".$mysqli->error);
		}

		// Get BM Checklist
		public function getBMChecklist($mysqli, $id){

			$rr1Select = "SELECT * FROM bm_checklist WHERE bm_checklist_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($rr1Select) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$detailrecords['bm_checklist_id']      	= $row->bm_checklist_id;  
			    $detailrecords['company_id']  = $row->company_id;
			    $detailrecords['category_id']  = $row->category_id;
			    $detailrecords['checklist']  = $row->checklist;
			    $detailrecords['rating']  = $row->rating;
			}
			
			return $detailrecords;
		}

		// Update BM Checklist
		public function updateBMChecklist($mysqli, $id, $userid){ 

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['category_id'])){
				$category_id = $_POST['category_id'];
			}
			if(isset($_POST['checklist'])){
				$checklist = $_POST['checklist'];
			}
			if(isset($_POST['rating'])){
				$rating = $_POST['rating'];
			} 

			$updateQry = 'UPDATE bm_checklist SET company_id = "'.strip_tags($company_id).'", category_id = "'.strip_tags($category_id).'", 
			checklist = "'.strip_tags($checklist).'", rating = "'.strip_tags($rating).'", status = "0" WHERE bm_checklist_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 
		}

		//  Delete BM Checklist
		public function deleteBMChecklist($mysqli, $id, $userid){

			$rrDelete = "UPDATE bm_checklist set status='1', delete_login_id='".strip_tags($userid)."' WHERE bm_checklist_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($rrDelete) or die("Error in delete query".$mysqli->error);
		}


		// Add approval line
		public function addApprovalLine($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['sstaffid'])){
				$staff_id = $_POST['sstaffid'];
			}
			if(isset($_POST['approvalStaffId'])){
				$approvalStaffId1 = $_POST['approvalStaffId']; 
				$approvalStaffId = implode(",", $approvalStaffId1);
			}
			if(isset($_POST['agreeParallelStaffId'])){
				$agreeParallelStaffId1 = $_POST['agreeParallelStaffId'];
				$agreeParallelStaffId = implode(",", $agreeParallelStaffId1);
			}
			if(isset($_POST['afterNotifiedStaffId'])){
				$afterNotifiedStaffId1 = $_POST['afterNotifiedStaffId'];
				$afterNotifiedStaffId = implode(",", $afterNotifiedStaffId1);
			} 
			if(isset($_POST['receivingDeptId'])){
				$receivingDeptId1 = $_POST['receivingDeptId'];
				$receivingDeptId = implode(",", $receivingDeptId1);
			} 
	
			$addApprovalLine = "INSERT INTO approval_line(company_id, staff_id, approval_staff_id, agree_par_staff_id, after_notified_staff_id, receiving_dept_id, insert_login_id)
				VALUES('".strip_tags($company_id)."', '".strip_tags($staff_id)."', '".strip_tags($approvalStaffId)."','".strip_tags($agreeParallelStaffId)."', '".strip_tags($afterNotifiedStaffId)."', 
				'".strip_tags($receivingDeptId)."','".strip_tags($userid)."')"; 
			$updresult = $mysqli->query($addApprovalLine)or die ("Error in in update Query!.".$mysqli->error);
			$approvalLineId = $mysqli->insert_id;

			for($i=0; $i<=sizeof($agreeParallelStaffId1)-1; $i++){

				$addAgreeDisagree = "INSERT INTO approval_requisition_parallel_agree_disagree(approval_line_id, agree_disagree_staff_id)
				VALUES('".strip_tags($approvalLineId)."', '".strip_tags($agreeParallelStaffId1[$i])."')";
				$updresult1 = $mysqli->query($addAgreeDisagree)or die ("Error in in Insert Query!.".$mysqli->error);
			} 
	
		}
		
		// Get approval requisition approve staff approval line
        public function getApprovalRequisitionApproveStaff($mysqli, $idupd){

            $rr1Select = "SELECT * FROM approval_line WHERE approval_line_id = '".strip_tags($idupd)."' AND status=0 ORDER BY approval_line_id ASC";
            $res = $mysqli->query($rr1Select) or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            if ($mysqli->affected_rows>0)
            {
                $row = $res->fetch_object();
                $detailrecords['approval_line_id']          = $row->approval_line_id;
                $detailrecords['company_id']                = $row->company_id;
                $detailrecords['staff_id']                  = $row->staff_id;
                $detailrecords['approval_staff_id']         = $row->approval_staff_id;
                $detailrecords['agree_par_staff_id']        = $row->agree_par_staff_id;
                $detailrecords['after_notified_staff_id']   = $row->after_notified_staff_id;
                $detailrecords['receiving_dept_id']         = $row->receiving_dept_id;
				$detailrecords['checker_approval']          = $row->checker_approval;
				$detailrecords['reviewer_approval']         = $row->reviewer_approval;
				$detailrecords['final_approval']            = $row->final_approval;
				$detailrecords['created_date']              = $row->created_date;
				$detailrecords['checker_approval_date']     = $row->checker_approval_date;
				$detailrecords['reviewer_approval_date']    = $row->reviewer_approval_date;
				$detailrecords['final_approval_date']       = $row->final_approval_date;
            }
            return $detailrecords;
        }


		// Add approval requisition
		public function addapprovalRequisition($mysqli, $userid){

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$staff_id = $_POST['staffid'];
			}
			if(isset($_POST['doc_no'])){
				$doc_no = $_POST['doc_no'];
			}
			if(isset($_POST['auto_generation_date'])){
				$auto_generation_date = $_POST['auto_generation_date'];
			}
			if(isset($_POST['title'])){
				$title = $_POST['title'];
			}
			if(isset($_POST['comments'])){
				$comments = $_POST['comments'];
			}

			$file1 = array();
			if(count($_FILES["file"]["name"]) > 0)
			{
				// $output = '';
				sleep(3);
				for($count=0; $count<count($_FILES["file"]["name"]); $count++)
				{
					$file_name = $_FILES["file"]["name"][$count];
						array_push($file1,$file_name);
					$tmp_name = $_FILES["file"]['tmp_name'][$count];
					$file_array = explode(".", $file_name);
					$file_extension = end($file_array);
					$location = 'uploads/approval_requisition/'.$file_name;
					move_uploaded_file($tmp_name, $location);
				}
			}
			$file= implode(",", $file1 );

			$addApprovalRequisition = "INSERT INTO approval_requisition(approval_line_id, staff_id, doc_no, auto_generation_date, title, comments, file, insert_login_id)
				VALUES('".strip_tags($approval_line_id)."','".strip_tags($staff_id)."', '".strip_tags($doc_no)."', '".strip_tags($auto_generation_date)."', '".strip_tags($title)."',
				'".strip_tags($comments)."', '".strip_tags($file)."', '".strip_tags($userid)."')";
			$updresult = $mysqli->query($addApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
		}


		// Get all approval requisition approve staff
		public function getApprovalRequisitionApproveStaffDashboard($mysqli){

			$getApprovalReq = "SELECT * FROM approval_requisition WHERE 1 AND status=0";
			$res1 = $mysqli->query($getApprovalReq) or die("Error in Get All Records".$mysqli->error);
			$appReqApproval_line_id = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row1 = $res1->fetch_object())
				{
					$appReqApproval_line_id[] = $row1->approval_line_id;
					$i++;
				}
			}

			if($appReqApproval_line_id > 0){
				$getApprovalLine = "SELECT * FROM approval_line WHERE 1 AND status=0 ORDER BY approval_line_id ASC";
				$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
				$detailrecords = array();
				if ($mysqli->affected_rows>0)
				{

					$row = $res->fetch_object();
					if (in_array($row->approval_line_id, $appReqApproval_line_id)){
						
						$detailrecords['approval_line_id'] = $row->approval_line_id;
						$detailrecords['company_id']  = $row->company_id;
						$detailrecords['approval_staff_id']  = $row->approval_staff_id;
						$detailrecords['agree_par_staff_id']  = $row->agree_par_staff_id;
						$detailrecords['after_notified_staff_id']  = $row->after_notified_staff_id;
						$detailrecords['receiving_dept_id']  = $row->receiving_dept_id;
						$detailrecords['checker_approval']  = $row->checker_approval;
						$detailrecords['reviewer_approval']  = $row->reviewer_approval;
						$detailrecords['final_approval']  = $row->final_approval;
						$detailrecords['created_date']  = $row->created_date;
						$detailrecords['checker_approval_date']  = $row->checker_approval_date;
						$detailrecords['reviewer_approval_date']  = $row->reviewer_approval_date;
						$detailrecords['final_approval_date']  = $row->final_approval_date;
					}
				}
				return $detailrecords;
			}else{
				return false;
			}
				
		}


		// agree approval requisition
		public function agreeApprovalRequisition($mysqli, $userid){

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}

			$getApprovalLine = "SELECT * FROM approval_line WHERE approval_line_id = '".strip_tags($approval_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$checker_approval  = $row->checker_approval;
				$reviewer_approval  = $row->reviewer_approval;
				$final_approval  = $row->final_approval;
				$approval_staff_id  = $row->approval_staff_id;
			}

			$approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
			$approval_staff_idLength = sizeof($approval_staff_idArr);
			$date  = date('Y-m-d');

			if($approval_staff_idLength == '2'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE approval_line set checker_approval = '1', checker_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE approval_line set final_approval = '1', final_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}else if($approval_staff_idLength == '3'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE approval_line set checker_approval = '1', checker_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE approval_line set reviewer_approval = '1', reviewer_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[2]) {
						$agreeApprovalRequisition = "UPDATE approval_line set final_approval = '1', final_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}

			// $addAgreeDisagree = "INSERT INTO approval_requisition_agree_disagree(approval_line_id, agree_disagree, agree_disagree_staff_id)
			// VALUES('".strip_tags($approval_line_id)."', '1', '".strip_tags($sstaffid)."')";
			// $updresult = $mysqli->query($addAgreeDisagree)or die ("Error in in Insert Query!.".$mysqli->error);
		}

		// disagree approval requisition
		public function disagreeApprovalRequisition($mysqli, $userid){

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}

			$getApprovalLine = "SELECT * FROM approval_line WHERE approval_line_id = '".strip_tags($approval_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$checker_approval  = $row->checker_approval;
				$reviewer_approval  = $row->reviewer_approval;
				$final_approval  = $row->final_approval;
				$approval_staff_id  = $row->approval_staff_id;
			}

			$approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
			$approval_staff_idLength = sizeof($approval_staff_idArr);
			$date  = date('Y-m-d');

			if($approval_staff_idLength == '2'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE approval_line set checker_approval = '2', checker_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE approval_line set final_approval = '2', final_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}else if($approval_staff_idLength == '3'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE approval_line set checker_approval = '2', checker_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE approval_line set reviewer_approval = '2', reviewer_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[2]) {
						$agreeApprovalRequisition = "UPDATE approval_line set final_approval = '2', final_approval_date = '".strip_tags($date)."' WHERE approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}
		}

		// parallel agrement approval requisition
		public function parallelAgreeApprovalRequisition($mysqli, $userid){  

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}
			$date  = date('Y-m-d');

			$agreeApprovalRequisition = "UPDATE approval_requisition_parallel_agree_disagree set agree_disagree = '1', agree_disagree_date = '".strip_tags($date)."' 
			WHERE approval_line_id = '".strip_tags($approval_line_id)."' AND agree_disagree_staff_id = '".strip_tags($sstaffid)."' ";
			$updresult1 = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
		}

		// parallel disagrement approval requisition
		public function parallelDisagreeApprovalRequisition($mysqli, $userid){  

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}
			$date  = date('Y-m-d');

			$agreeApprovalRequisition = "UPDATE approval_requisition_parallel_agree_disagree set agree_disagree = '2', agree_disagree_date = '".strip_tags($date)."' 
			WHERE approval_line_id = '".strip_tags($approval_line_id)."' AND agree_disagree_staff_id = '".strip_tags($sstaffid)."' ";
			$updresult1 = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
		}

		// fetch parallel staff on dashboard approval requisition
		public function getApprovalRequisitionParallelAgreement($mysqli, $sessionId, $approval_line_id){
			
			$getParallelAgreementStaffId = "SELECT agree_disagree_staff_id, agree_disagree FROM approval_requisition_parallel_agree_disagree WHERE approval_line_id = '".strip_tags($approval_line_id)."' 
			AND agree_disagree = '0' AND status=0 ORDER BY approval_requisition_agree_disagree_id ASC LIMIT 1";
			$res11 = $mysqli->query($getParallelAgreementStaffId) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row11 = $res11->fetch_object();
				$detailrecords['agree_disagree_staff_id']  = $row11->agree_disagree_staff_id;
				$detailrecords['agree_disagree']  = $row11->agree_disagree;
			}
			return $detailrecords;
		}

		// fetch after notification approval requisition
		public function getApprovalRequisitionAfterNotification($mysqli, $sessionId, $approval_line_id){

			$getafterNotificationStaff = "SELECT final_approval, after_notified_staff_id FROM approval_line WHERE approval_line_id = '".strip_tags($approval_line_id)."' 
			AND final_approval = '1' AND status=0";
			$res = $mysqli->query($getafterNotificationStaff) or die("Error in Get All Records".$mysqli->error);
			$after_notified_staff_id = '';
			$final_approval = '';
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$after_notified_staff_id  = $row->after_notified_staff_id;
				$final_approval  = $row->final_approval;
			}

			$getApprovalLine = "SELECT * FROM approval_line WHERE approval_line_id = '".strip_tags($approval_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$agree_par_staff_id = '';
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$agree_par_staff_id  = $row->agree_par_staff_id;
			}

			$parallel_staff_idArr = array_map('intval', explode(',', $agree_par_staff_id));
			$parallel_staff_idLength = sizeof($parallel_staff_idArr);

			$getParallelAgreementStaffId = "SELECT COUNT(agree_disagree) as agree_disagree FROM approval_requisition_parallel_agree_disagree WHERE agree_disagree = '1' AND status=0 ";
			$res11 = $mysqli->query($getParallelAgreementStaffId) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				$row11 = $res11->fetch_object();
				$agree_disagree  = $row11->agree_disagree;
			}

			if($final_approval == 1 && $parallel_staff_idLength == $agree_disagree){
				$detailrecords['after_notified_staff_id']  = $after_notified_staff_id;
				$detailrecords['status'] = 1;
			}else{
				$detailrecords['status'] = 0;
				$detailrecords['after_notified_staff_id']  = $after_notified_staff_id;
			}

			return $detailrecords;
		}


		// Add Business Com Line
        public function addBusinessComLine($mysqli, $userid){

            if(isset($_POST['sbranch_id'])){
                $company_id = $_POST['sbranch_id'];
            } 
			if(isset($_POST['sstaffid'])){
				$staff_id = $_POST['sstaffid'];
			}
            if(isset($_POST['approvalStaffId'])){
                $approvalStaffId1 = $_POST['approvalStaffId'];
                $approvalStaffId = implode(",", $approvalStaffId1);
            }
            if(isset($_POST['agreeParallelStaffId'])){
                $agreeParallelStaffId1 = $_POST['agreeParallelStaffId'];
                $agreeParallelStaffId = implode(",", $agreeParallelStaffId1);
            }
            if(isset($_POST['afterNotifiedStaffId'])){
                $afterNotifiedStaffId1 = $_POST['afterNotifiedStaffId'];
                $afterNotifiedStaffId = implode(",", $afterNotifiedStaffId1);
            }
            if(isset($_POST['receivingDeptId'])){
                $receivingDeptId1 = $_POST['receivingDeptId'];
                $receivingDeptId = implode(",", $receivingDeptId1);
            }
            if(isset($_POST['receivingCompanyId'])){
                $receivingCompanyId1 = $_POST['receivingCompanyId'];
                $receivingCompanyId = implode(",", $receivingCompanyId1);
            }
            $addBusinessComLine = "INSERT INTO business_com_line(company_id, staff_id, approval_staff_id, agree_par_staff_id, after_notified_staff_id, recipient_id, receiving_branch_id, insert_login_id)
                VALUES('".strip_tags($company_id)."', '".strip_tags($staff_id)."', '".strip_tags($approvalStaffId)."','".strip_tags($agreeParallelStaffId)."', '".strip_tags($afterNotifiedStaffId)."',
                '".strip_tags($receivingDeptId)."', '".strip_tags($receivingCompanyId)."', '".strip_tags($userid)."')";
            $updresult = $mysqli->query($addBusinessComLine)or die ("Error in in Insert Query!.".$mysqli->error);
			$businessComOutLineId = $mysqli->insert_id;

			for($i=0; $i<=sizeof($agreeParallelStaffId1)-1; $i++){

				$addAgreeDisagree = "INSERT INTO business_com_parallel_agree_disagree(business_com_line_id, agree_disagree_staff_id)
				VALUES('".strip_tags($businessComOutLineId)."', '".strip_tags($agreeParallelStaffId1[$i])."')";
				$updresult1 = $mysqli->query($addAgreeDisagree)or die ("Error in in Insert Query!.".$mysqli->error);
			} 
        }

		// Get business com out approve staff
		public function getBusinessComOutApproveStaff($mysqli, $idupd){

			$businessComOutSelect = "SELECT * FROM business_com_line WHERE business_com_line_id = '".strip_tags($idupd)."' AND status=0 ORDER BY business_com_line_id ASC";
			$res = $mysqli->query($businessComOutSelect) or die("Error in Get All Records".$mysqli->error); 
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$detailrecords['business_com_line_id']      = $row->business_com_line_id;
				$detailrecords['company_id']                = $row->company_id;
				$detailrecords['staff_id']                  = $row->staff_id;
				$detailrecords['approval_staff_id']         = $row->approval_staff_id;
				$detailrecords['agree_par_staff_id']        = $row->agree_par_staff_id;
				$detailrecords['after_notified_staff_id']   = $row->after_notified_staff_id;
				$detailrecords['recipient_id']              = $row->recipient_id;
				$detailrecords['checker_approval']          = $row->checker_approval;
				$detailrecords['reviewer_approval']         = $row->reviewer_approval;
				$detailrecords['final_approval']            = $row->final_approval;
				$detailrecords['created_date']              = $row->created_date;
				$detailrecords['checker_approval_date']     = $row->checker_approval_date;
				$detailrecords['reviewer_approval_date']    = $row->reviewer_approval_date;
				$detailrecords['final_approval_date']       = $row->final_approval_date;
			}

			return $detailrecords;
		}

		// Add Business Com out
		public function addBusinessComOut($mysqli, $userid){

			if(isset($_POST['approval_line_id'])){
				$business_com_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$staff_id = $_POST['staffid'];
			}
			if(isset($_POST['doc_no'])){
				$doc_no = $_POST['doc_no'];
			}
			if(isset($_POST['auto_generation_date'])){
				$auto_generation_date = $_POST['auto_generation_date'];
			}
			if(isset($_POST['title'])){
				$title = $_POST['title'];
			}
			if(isset($_POST['comments'])){
				$comments = $_POST['comments'];
			}

			$file1 = array();
			if(count($_FILES["file"]["name"]) > 0)
			{
				// $output = '';
				sleep(3);
				for($count=0; $count<count($_FILES["file"]["name"]); $count++)
				{
					$file_name = $_FILES["file"]["name"][$count];
						array_push($file1,$file_name);
					$tmp_name = $_FILES["file"]['tmp_name'][$count];
					$file_array = explode(".", $file_name);
					$file_extension = end($file_array);
					$location = 'uploads/business_com_out/'.$file_name;
					move_uploaded_file($tmp_name, $location);
				}
			}
			$file= implode(",", $file1 );

			$addApprovalRequisition = "INSERT INTO business_com_out(business_com_line_id, staff_id, doc_no, auto_generation_date, title, comments, file, insert_login_id)
				VALUES('".strip_tags($business_com_line_id)."','".strip_tags($staff_id)."', '".strip_tags($doc_no)."', '".strip_tags($auto_generation_date)."', '".strip_tags($title)."',
				'".strip_tags($comments)."', '".strip_tags($file)."', '".strip_tags($userid)."')";
			$updresult = $mysqli->query($addApprovalRequisition) or die ("Error in in Insert Query!.".$mysqli->error);
		}
		
		// Get BusinessComLine
		public function getBusinessComOutApproveStaffDashboard($mysqli){

			$getBusinessComOut = "SELECT * FROM business_com_out WHERE 1 AND status=0";
			$res1 = $mysqli->query($getBusinessComOut) or die("Error in Get All Records".$mysqli->error);
			$business_com_line_idArr = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row1 = $res1->fetch_object())
				{
					$business_com_line_idArr[] = $row1->business_com_line_id;
					$i++;
				}
			}

			if($business_com_line_idArr > 0){
				$getBusinessComOutApprovalLine = "SELECT * FROM business_com_line WHERE 1 AND status=0 ORDER BY business_com_line_id ASC";
				$res = $mysqli->query($getBusinessComOutApprovalLine) or die("Error in Get All Records".$mysqli->error);
				$detailrecords = array();
				if ($mysqli->affected_rows>0)
				{
					$row = $res->fetch_object();
					if (in_array($row->business_com_line_id, $business_com_line_idArr)){
						$detailrecords['business_com_line_id']          = $row->business_com_line_id;
						$detailrecords['company_id']  = $row->company_id;
						$detailrecords['approval_staff_id']  = $row->approval_staff_id;
						$detailrecords['agree_par_staff_id']  = $row->agree_par_staff_id;
						$detailrecords['after_notified_staff_id']  = $row->after_notified_staff_id;
						$detailrecords['recipient_id']  = $row->recipient_id;
						$detailrecords['checker_approval']  = $row->checker_approval;
						$detailrecords['reviewer_approval']  = $row->reviewer_approval;
						$detailrecords['final_approval']  = $row->final_approval;
						$detailrecords['created_date']  = $row->created_date;
						$detailrecords['checker_approval_date']  = $row->checker_approval_date;
						$detailrecords['reviewer_approval_date']  = $row->reviewer_approval_date;
						$detailrecords['final_approval_date']  = $row->final_approval_date;
					}
				}
				return $detailrecords;
			}else{
				return false;
			}
		}

		// agree Business Com out
		public function agreeBusinessComOut($mysqli, $userid){

			if(isset($_POST['approval_line_id'])){
				$business_com_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}

			$getApprovalLine = "SELECT * FROM business_com_line WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$checker_approval  = $row->checker_approval;
				$reviewer_approval  = $row->reviewer_approval;
				$final_approval  = $row->final_approval;
				$approval_staff_id  = $row->approval_staff_id;
			}

			$approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
			$approval_staff_idLength = sizeof($approval_staff_idArr);
			$date  = date('Y-m-d');

			if($approval_staff_idLength == '2'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set checker_approval = '1', checker_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set final_approval = '1', final_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}else if($approval_staff_idLength == '3'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set checker_approval = '1', checker_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set reviewer_approval = '1', reviewer_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[2]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set final_approval = '1', final_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}
		}


		// disagree Business Com out
		public function disagreeBusinessComOut($mysqli, $userid){

			if(isset($_POST['approval_line_id'])){
				$business_com_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}

			$getApprovalLine = "SELECT * FROM business_com_line WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$checker_approval  = $row->checker_approval;
				$reviewer_approval  = $row->reviewer_approval;
				$final_approval  = $row->final_approval;
				$approval_staff_id  = $row->approval_staff_id;
			}

			$approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
			$approval_staff_idLength = sizeof($approval_staff_idArr);
			$date  = date('Y-m-d');

			if($approval_staff_idLength == '2'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set checker_approval = '2', checker_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set final_approval = '2', final_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}else if($approval_staff_idLength == '3'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set checker_approval = '2', checker_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set reviewer_approval = '2', reviewer_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[2]) {
						$agreeApprovalRequisition = "UPDATE business_com_line set final_approval = '2', final_approval_date = '".strip_tags($date)."' WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}
		}

		// parallel agrement business com out
		public function parallelAgreeBusinessComOut($mysqli, $userid){  

			if(isset($_POST['approval_line_id'])){
				$business_com_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}
			$date  = date('Y-m-d');

			$agreeApprovalRequisition = "UPDATE business_com_parallel_agree_disagree set agree_disagree = '1', agree_disagree_date = '".strip_tags($date)."' 
			WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' AND agree_disagree_staff_id = '".strip_tags($sstaffid)."' ";
			$updresult1 = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
		}

		// parallel disagrement business com out
		public function parallelDisagreeBusinessComOut($mysqli, $userid){  

			if(isset($_POST['approval_line_id'])){
				$business_com_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}
			$date  = date('Y-m-d');

			$agreeApprovalRequisition = "UPDATE business_com_parallel_agree_disagree set agree_disagree = '2', agree_disagree_date = '".strip_tags($date)."' 
			WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' AND agree_disagree_staff_id = '".strip_tags($sstaffid)."' ";
			$updresult1 = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
		}

		
		// fetch parallel staff on dashboard business Com Line
		public function getBusinessComOutParallelAgreement($mysqli, $sessionId, $business_com_line_id){
			
			$getParallelAgreementStaffId = "SELECT agree_disagree_staff_id, agree_disagree FROM business_com_parallel_agree_disagree WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' 
			AND agree_disagree = '0' AND status=0 ORDER BY business_com_parallel_agree_disagree_id ASC LIMIT 1";
			$res11 = $mysqli->query($getParallelAgreementStaffId) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row11 = $res11->fetch_object();
				$detailrecords['agree_disagree_staff_id']  = $row11->agree_disagree_staff_id;
				$detailrecords['agree_disagree']  = $row11->agree_disagree;
			}
			return $detailrecords;
		}


		// fetch after notification business com out
		public function getBusinessComOutAfterNotification($mysqli, $sessionId, $business_com_line_id){

			$getafterNotificationStaff = "SELECT final_approval, after_notified_staff_id FROM business_com_line WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' AND final_approval = '1' AND status=0";
			$res = $mysqli->query($getafterNotificationStaff) or die("Error in Get All Records".$mysqli->error);
			$final_approval = '';
			$after_notified_staff_id = '';
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$after_notified_staff_id  = $row->after_notified_staff_id;
				$final_approval  = $row->final_approval;
			}

			$getApprovalLine = "SELECT * FROM business_com_line WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$agree_par_staff_id = '';
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$agree_par_staff_id  = $row->agree_par_staff_id;
			}

			$parallel_staff_idArr = array_map('intval', explode(',', $agree_par_staff_id));
			$parallel_staff_idLength = sizeof($parallel_staff_idArr);

			
			$getParallelAgreementStaffId = "SELECT COUNT(agree_disagree) as agree_disagree FROM business_com_parallel_agree_disagree WHERE agree_disagree = '1' AND status=0 ";
			$res11 = $mysqli->query($getParallelAgreementStaffId) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				$row11 = $res11->fetch_object();
				$agree_disagree  = $row11->agree_disagree;
			}

			
			if($final_approval == 1 && $parallel_staff_idLength == $agree_disagree){
				$detailrecords['status'] = 1;
				$detailrecords['after_notified_staff_id']  = $after_notified_staff_id;
			}else{
				$detailrecords['status'] = 0;
				$detailrecords['after_notified_staff_id']  = $after_notified_staff_id;
			}

			return $detailrecords;
		}


		// Receiving branch approve (checker, reviewer, approver) - business communication (outgoing)
		public function getBusinessComOutReceivingBrachStaffApprove($mysqli, $sessionId, $business_com_line_id){

			$getafterNotificationStaff = "SELECT final_approval, recipient_id, receiving_branch_id FROM business_com_line WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' AND final_approval = '1' AND status=0";
			$res = $mysqli->query($getafterNotificationStaff) or die("Error in Get All Records".$mysqli->error);
			$receiving_branch_id = '';
			$recipient_id = '';
			$final_approval = '';
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$receiving_branch_id  = $row->receiving_branch_id;
				$recipient_id  = $row->recipient_id;
				$final_approval  = $row->final_approval;
			}

			$getApprovalLine = "SELECT * FROM business_com_line WHERE business_com_line_id = '".strip_tags($business_com_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$agree_par_staff_id = '';
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$agree_par_staff_id  = $row->agree_par_staff_id;
			}

			$parallel_staff_idArr = array_map('intval', explode(',', $agree_par_staff_id));
			$parallel_staff_idLength = sizeof($parallel_staff_idArr);
			
			$getParallelAgreementStaffId = "SELECT COUNT(agree_disagree) as agree_disagree FROM business_com_parallel_agree_disagree WHERE agree_disagree = '1' AND status=0 ";
			$res11 = $mysqli->query($getParallelAgreementStaffId) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				$row11 = $res11->fetch_object();
				$agree_disagree  = $row11->agree_disagree;
			}
			
			if($final_approval == 1 && $parallel_staff_idLength == $agree_disagree){

				$getReceivingDeptStaff = "SELECT * FROM staff_creation WHERE FIND_IN_SET($receiving_branch_id, company_id) > 0 AND FIND_IN_SET($recipient_id, department) > 0 
				AND status=0"; 
				$res = $mysqli->query($getReceivingDeptStaff) or die("Error in Get All Records".$mysqli->error);
				$staff_id = '';
				if ($mysqli->affected_rows>0)
				{
					$row12 = $res->fetch_object();
					$staff_id = $row12->staff_id;
				}

				$detailrecords['status'] = 1;
				$detailrecords['receiving_branch_id']  = $receiving_branch_id;
				$detailrecords['recipient_id']  = $recipient_id;
				$detailrecords['staff_id'] = $staff_id;
			}else{
				$detailrecords['status'] = 0;
				$detailrecords['receiving_branch_id']  = $receiving_branch_id;
				$detailrecords['recipient_id']  = $recipient_id;
				$detailrecords['staff_id'] = '';
			}

			return $detailrecords;
		}



		// Get Maintenance Checklist
		public function getMaintenanceChecklist($mysqli, $id){

			$kraSelect = "SELECT * FROM maintenance_checklist WHERE maintenance_checklist_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($kraSelect) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$maintenanceChecklistId  					= $row->maintenance_checklist_id;
				$detailrecords['maintenance_checklist_id']  = $row->maintenance_checklist_id; 
				$detailrecords['company_id']                = $row->company_id;
				$detailrecords['date_of_inspection']        = $row->date_of_inspection;
				$detailrecords['asset_details']             = $row->asset_details; 	
				$detailrecords['checklist']                 = $row->checklist; 	
				$detailrecords['calendar']                = $row->calendar; 	
				$detailrecords['from_date']                = $row->from_date;
				$detailrecords['to_date']                = $row->to_date; 	
				$detailrecords['role1']                = $row->role1; 	
				$detailrecords['role2']                 = $row->role2; 	

			}
			
			$maintenanceChecklistRefId = 0;
			$kraRefSelect = "SELECT * FROM maintenance_checklist_ref WHERE maintenance_checklist_id='".mysqli_real_escape_string($mysqli, $maintenanceChecklistId)."' "; 
			$res1 = $mysqli->query($kraRefSelect) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				while($row1 = $res1->fetch_object()){
					$maintenanceChecklistRefId        = $row1->maintenance_checklist_ref_id; 
					$maintenance_checklist_ref_id[]   = $row1->maintenance_checklist_ref_id; 
					$pm_checklist_id[]                = $row1->pm_checklist_id; 
					$bm_checklist_id[]                = $row1->bm_checklist_id;
				} 
			}
			if($maintenanceChecklistRefId > 0)
			{
				$detailrecords['maintenance_checklist_ref_id']  = $maintenance_checklist_ref_id; 
				$detailrecords['pm_checklist_id']               = $pm_checklist_id;
				$detailrecords['bm_checklist_id']               = $bm_checklist_id;  	
			}
			else
			{
				$detailrecords['maintenance_checklist_ref_id']    = array();
				$detailrecords['pm_checklist_id']                 = array();
				$detailrecords['bm_checklist_id']                 = array(); 
			}
			
			return $detailrecords;
		}

		//  Delete Maintenance Checklist
		public function deleteMaintenanceChecklist($mysqli, $id, $userid){

			$maintenanceChecklistDelete = "UPDATE maintenance_checklist set status='1', delete_login_id='".strip_tags($userid)."' WHERE maintenance_checklist_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($maintenanceChecklistDelete) or die("Error in delete query".$mysqli->error);
		}

		// get maintenance checklist role2
		public function getMaintenanceChecklistResponder($mysqli, $sessionId){
			
			$getResponder = "SELECT * FROM maintenance_checklist WHERE role2 = '".strip_tags($sessionId)."' AND status=0";
			$res = $mysqli->query($getResponder) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$maintenance_checklist_id  = $row->maintenance_checklist_id;
				$getResponderStatus = "SELECT * FROM maintenance_checklist_ref WHERE maintenance_checklist_id = '".strip_tags($maintenance_checklist_id)."' AND responder_status_ref=0";
				$res1 = $mysqli->query($getResponderStatus) or die("Error in Get All Records".$mysqli->error);
				if ($mysqli->affected_rows>0)
				{
					$row1 = $res1->fetch_object();
					$detailrecords['maintenance_checklist_ref_id']  = $row1->maintenance_checklist_ref_id;
				}
			}
			
			return $detailrecords;
		}


		// Add Periodic Level
		public function addPeriodicLevel($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['periodic_date'])){
				$periodic_date = $_POST['periodic_date'];
			}
			if(isset($_POST['asset_details'])){
				$asset_details = $_POST['asset_details'];
			}

			$rrInsert="INSERT INTO periodic_level(company_id, periodic_date, asset_details, insert_login_id) VALUES('".strip_tags($company_id)."', '".strip_tags($periodic_date)."', 
			'".strip_tags($asset_details)."', '".strip_tags($userid)."')";
			$insresult=$mysqli->query($rrInsert) or die("Error ".$mysqli->error);
		}

		// Get Periodic Level
		public function getPeriodicLevel($mysqli, $id){

			$rr1Select = "SELECT * FROM periodic_level WHERE periodic_level_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($rr1Select) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$detailrecords['periodic_level_id']      	= $row->periodic_level_id;  
			    $detailrecords['company_id']  = $row->company_id;
			    $detailrecords['periodic_date']  = $row->periodic_date;
			    $detailrecords['asset_details']  = $row->asset_details;
			}
			
			return $detailrecords;
		}

		// Update Periodic Level
		public function updatePeriodicLevel($mysqli, $id, $userid){ 

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['periodic_date'])){
				$periodic_date = $_POST['periodic_date'];
			}
			if(isset($_POST['asset_details'])){
				$asset_details = $_POST['asset_details'];
			}

			$updateQry = 'UPDATE periodic_level SET company_id = "'.strip_tags($company_id).'", periodic_date = "'.strip_tags($periodic_date).'", 
			asset_details = "'.strip_tags($asset_details).'", status = "0" WHERE periodic_level_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 
		}

		//  Delete Periodic Level
		public function deletePeriodicLevel($mysqli, $id, $userid){

			$rrDelete = "UPDATE periodic_level set status='1', delete_login_id='".strip_tags($userid)."' WHERE periodic_level_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($rrDelete) or die("Error in delete query".$mysqli->error);
		}


		// get periodic level dashboard
		public function getPeriodicLevelDashboard($mysqli, $sessionId){
	
			$getResponder = "SELECT * FROM maintenance_checklist WHERE role1 = '".strip_tags($sessionId)."' AND checklist = 'pm_checklist' AND status=0";
			$res = $mysqli->query($getResponder) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = 0;
			if ($mysqli->affected_rows>0)
			{
				// $row = $res->fetch_object();
				// $getPeriodicLevel = "SELECT * FROM periodic_level WHERE 1 AND status=0";
				// $res1 = $mysqli->query($getPeriodicLevel) or die("Error in Get All Records".$mysqli->error);
				// if ($mysqli->affected_rows>0)
				// {
				// 	$row1 = $res1->fetch_object();
				// 	$detailrecords['periodic_level_id']  = $row1->periodic_level_id;

				// 	$getqry7 = "SELECT asset_name FROM asset_register WHERE asset_id ='".strip_tags($row1->asset_details)."' and status = 0";
				// 	$res7 = $mysqli->query($getqry7);
				// 	while($row7 = $res7->fetch_object())
				// 	{ 
				// 	   $detailrecords['asset_name']  = $row7->asset_name;   
				// 	}

				// }

				$detailrecords = 1;
			}
			
			return $detailrecords;
		}

		
		// Add Vehicle Details
		public function addVehicleDetails($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['vehicle_code'])){
				$vehicle_code = $_POST['vehicle_code'];
			}
			if(isset($_POST['vehicle_name'])){
				$vehicle_name = $_POST['vehicle_name'];
			}
			if(isset($_POST['vehicle_number'])){
				$vehicle_number = $_POST['vehicle_number'];
			}
			if(isset($_POST['date_of_purchase'])){
				$date_of_purchase = $_POST['date_of_purchase'];
			}
			if(isset($_POST['fitment_upto'])){
				$fitment_upto = $_POST['fitment_upto'];
			}
			if(isset($_POST['insurance_upto'])){
				$insurance_upto = $_POST['insurance_upto'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['book_value_as_on'])){
				$book_value_as_on = $_POST['book_value_as_on'];
			}

			$insertQry="INSERT INTO vehicle_details(company_id, vehicle_code, vehicle_name, vehicle_number, date_of_purchase, fitment_upto, insurance_upto, asset_value, 
			book_value_as_on, insert_login_id) VALUES('".strip_tags($company_id)."', '".strip_tags($vehicle_code)."', '".strip_tags($vehicle_name)."', 
			'".strip_tags($vehicle_number)."', '".strip_tags($date_of_purchase)."', '".strip_tags($fitment_upto)."', '".strip_tags($insurance_upto)."', 
			'".strip_tags($asset_value)."', '".strip_tags($book_value_as_on)."', '".strip_tags($userid)."')";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		// Get Vehicle Details
		public function getVehicleDetails($mysqli, $id){

			$selectQry = "SELECT * FROM vehicle_details WHERE vehicle_details_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($selectQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$detailrecords['vehicle_details_id']  = $row->vehicle_details_id;  
			    $detailrecords['company_id']  = $row->company_id;
			    $detailrecords['vehicle_code']  = $row->vehicle_code;
			    $detailrecords['vehicle_name']  = $row->vehicle_name;
			    $detailrecords['vehicle_number']  = $row->vehicle_number;
			    $detailrecords['date_of_purchase']  = $row->date_of_purchase;
			    $detailrecords['fitment_upto']  = $row->fitment_upto;
			    $detailrecords['insurance_upto']  = $row->insurance_upto;
			    $detailrecords['asset_value']  = $row->asset_value;
			    $detailrecords['book_value_as_on']  = $row->book_value_as_on;
			}
			
			return $detailrecords;
		}

		// Update Vehicle Details
		public function updateVehicleDetails($mysqli, $id, $userid){ 

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['vehicle_code'])){
				$vehicle_code = $_POST['vehicle_code'];
			}
			if(isset($_POST['vehicle_name'])){
				$vehicle_name = $_POST['vehicle_name'];
			}
			if(isset($_POST['vehicle_number'])){
				$vehicle_number = $_POST['vehicle_number'];
			}
			if(isset($_POST['date_of_purchase'])){
				$date_of_purchase = $_POST['date_of_purchase'];
			}
			if(isset($_POST['fitment_upto'])){
				$fitment_upto = $_POST['fitment_upto'];
			}
			if(isset($_POST['insurance_upto'])){
				$insurance_upto = $_POST['insurance_upto'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['book_value_as_on'])){
				$book_value_as_on = $_POST['book_value_as_on'];
			}

			$updateQry = 'UPDATE vehicle_details SET company_id = "'.strip_tags($company_id).'", vehicle_code = "'.strip_tags($vehicle_code).'", 
			vehicle_name = "'.strip_tags($vehicle_name).'", vehicle_number = "'.strip_tags($vehicle_number).'", date_of_purchase = "'.strip_tags($date_of_purchase).'", 
			fitment_upto = "'.strip_tags($fitment_upto).'", insurance_upto = "'.strip_tags($insurance_upto).'", asset_value = "'.strip_tags($asset_value).'", 
			book_value_as_on = "'.strip_tags($book_value_as_on).'", status = "0" WHERE vehicle_details_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 
		}

		//  Delete Vehicle Details
		public function deleteVehicleDetails($mysqli, $id, $userid){

			$deleteQry = "UPDATE vehicle_details set status='1', delete_login_id='".strip_tags($userid)."' WHERE vehicle_details_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}


		// Get Daily KM
		public function getDailyKM($mysqli, $id){

			$selectQry = "SELECT * FROM daily_km WHERE daily_km_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($selectQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$dailyKMId  								= $row->daily_km_id;
				$detailrecords['daily_km_id']  				= $row->daily_km_id; 
				$detailrecords['company_id']                = $row->company_id;
				$detailrecords['date']       				= $row->date;
			}
			
			$dailyKMRefId = 0;
			$selectRefQry = "SELECT * FROM daily_km_ref WHERE daily_km_id='".mysqli_real_escape_string($mysqli, $dailyKMId)."' "; 
			$res1 = $mysqli->query($selectRefQry) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				while($row1 = $res1->fetch_object()){
					$dailyKMRefId                    = $row1->daily_km_ref_id; 
					$daily_km_ref_id[]               = $row1->daily_km_ref_id; 
					$vehicle_details_id[]            = $row1->vehicle_details_id; 
					$vehicle_number[]                = $row1->vehicle_number;
					$start_km[]                      = $row1->start_km;
					$end_km[]                        = $row1->end_km;
				} 
			}
			if($dailyKMRefId > 0)
			{
				$detailrecords['daily_km_ref_id']           = $daily_km_ref_id; 
				$detailrecords['vehicle_details_id']        = $vehicle_details_id;
				$detailrecords['vehicle_number']            = $vehicle_number;  	
				$detailrecords['start_km']                  = $start_km;  
				$detailrecords['end_km']                    = $end_km;  	
			}
			else
			{
				$detailrecords['daily_km_ref_id']           = array();
				$detailrecords['vehicle_details_id']        = array();
				$detailrecords['vehicle_number']            = array(); 
				$detailrecords['start_km']                  = array(); 
				$detailrecords['end_km']                    = array();
			}
			
			return $detailrecords;
		}

		//  memo assign dashboard
		public function deleteDailyKM($mysqli, $id, $userid){

			$deleteQry = "UPDATE daily_km set status='1', delete_login_id='".strip_tags($userid)."' WHERE daily_km_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}


		// Add Diesel Slip
		public function addDieselSlip($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['vehicle_number'])){
				$vehicle_number = $_POST['vehicle_number'];
			}
			if(isset($_POST['previous_km'])){
				$previous_km = $_POST['previous_km'];
			}
			if(isset($_POST['previous_km_date'])){
				$previous_km_date = $_POST['previous_km_date'];
			}
			if(isset($_POST['present_km'])){
				$present_km = $_POST['present_km'];
			}
			if(isset($_POST['present_km_date'])){
				$present_km_date = $_POST['present_km_date'];
			}
			if(isset($_POST['total_km_run'])){
				$total_km_run = $_POST['total_km_run'];
			}
			if(isset($_POST['diesel_amount'])){
				$diesel_amount = $_POST['diesel_amount'];
			}

			$insertQry="INSERT INTO diesel_slip(company_id, vehicle_number, previous_km, previous_km_date, present_km, present_km_date, total_km_run, diesel_amount, 
			insert_login_id) VALUES('".strip_tags($company_id)."', '".strip_tags($vehicle_number)."', '".strip_tags($previous_km)."', '".strip_tags($previous_km_date)."',  
			 '".strip_tags($present_km)."', '".strip_tags($present_km_date)."', '".strip_tags($total_km_run)."', '".strip_tags($diesel_amount)."', '".strip_tags($userid)."')";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		// Get Diesel Slip
		public function getDieselSlip($mysqli, $id){

			$selectQry = "SELECT * FROM diesel_slip WHERE diesel_slip_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($selectQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$detailrecords['diesel_slip_id']  = $row->diesel_slip_id;  
			    $detailrecords['company_id']  = $row->company_id;
			    $detailrecords['vehicle_number']  = $row->vehicle_number;
			    $detailrecords['previous_km']  = $row->previous_km;
			    $detailrecords['previous_km_date']  = $row->previous_km_date;
			    $detailrecords['present_km']  = $row->present_km;
			    $detailrecords['present_km_date']  = $row->present_km_date;
			    $detailrecords['total_km_run']  = $row->total_km_run;
			    $detailrecords['diesel_amount']  = $row->diesel_amount;
			}
			
			return $detailrecords;
		}

		// Update Diesel Slip
		public function updateDieselSlip($mysqli, $id, $userid){ 

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['vehicle_number'])){
				$vehicle_number = $_POST['vehicle_number'];
			}
			if(isset($_POST['previous_km'])){
				$previous_km = $_POST['previous_km'];
			}
			if(isset($_POST['previous_km_date'])){
				$previous_km_date = $_POST['previous_km_date'];
			}
			if(isset($_POST['present_km'])){
				$present_km = $_POST['present_km'];
			}
			if(isset($_POST['present_km_date'])){
				$present_km_date = $_POST['present_km_date'];
			}
			if(isset($_POST['total_km_run'])){
				$total_km_run = $_POST['total_km_run'];
			}
			if(isset($_POST['diesel_amount'])){
				$diesel_amount = $_POST['diesel_amount'];
			}

			$updateQry = 'UPDATE diesel_slip SET company_id = "'.strip_tags($company_id).'", vehicle_number = "'.strip_tags($vehicle_number).'", 
			previous_km = "'.strip_tags($previous_km).'", previous_km_date = "'.strip_tags($previous_km_date).'", present_km = "'.strip_tags($present_km).'", 
			present_km_date = "'.strip_tags($present_km_date).'", total_km_run = "'.strip_tags($total_km_run).'", diesel_amount = "'.strip_tags($diesel_amount).'", 
			status = "0" WHERE diesel_slip_id = "'.mysqli_real_escape_string($mysqli, $id).'" '; 
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 
		}

		// Delete Diesel Slip
		public function deleteDieselSlip($mysqli, $id, $userid){

			$deleteQry = "UPDATE diesel_slip set status='1', delete_login_id='".strip_tags($userid)."' WHERE diesel_slip_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

		// get memo initiate
		public function getMemoInitiateDashboard($mysqli, $sessionId){

			$getMemo = "SELECT * FROM memo WHERE 1 AND status=0";
			$res = $mysqli->query($getMemo) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = 0;
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$getMemoStaff = "SELECT * FROM staff_creation WHERE department = '".strip_tags($row->to_department)."' AND staff_id = '".strip_tags($sessionId)."' 
				AND reporting = '' AND status=0";
				$res1 = $mysqli->query($getMemoStaff) or die("Error in Get All Records".$mysqli->error);
				if ($mysqli->affected_rows>0)
				{
					$detailrecords = 1;
				}
			}
			
			return $detailrecords;
		}

		// get memo assigned
		public function getMemoAssignDashboard($mysqli, $sessionId){

			$getMemo = "SELECT * FROM memo WHERE assign_employee = '".strip_tags($sessionId)."' AND status=0";
			$res = $mysqli->query($getMemo) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = 0;
			if ($mysqli->affected_rows>0)
			{
				$detailrecords = 1;
			}
			
			return $detailrecords;
		}

		// get assign to for kra kpi edit
		function getEditAssignTo($mysqli, $company_name, $designation){

			$detailrecords = array();
			$i=0;
			$getStaffName = $mysqli->query("SELECT * FROM staff_creation WHERE company_id = '".$company_name."' AND department = '".$designation."' AND status=0");
			if ($mysqli->affected_rows>0){
				while($row2 = $getStaffName->fetch_object()){
					$detailrecords[$i]['staff_id'] = $row2->staff_id; 
					$detailrecords[$i]['staff_name'] = $row2->staff_name; 
					$i++;       
				}
			}
			
			return $detailrecords;
		}

		// get audit assign
		public function getAuditAssignDashboard($mysqli, $sessionId){

			$getRole2 = "SELECT * FROM audit_assign WHERE role2 = '".strip_tags($sessionId)."' AND auditee_response_status = 0 AND status=0";
			$res = $mysqli->query($getRole2) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = 0;
			if ($mysqli->affected_rows>0)
			{
				$detailrecords = 1;
			}
			
			return $detailrecords;
		}

		// get auditee response
		public function getAuditeeResponseDashboard($mysqli, $sessionId){

			if($sessionId == 'Overall'){
				$getRole2 = "SELECT * FROM audit_assign WHERE auditee_response_status = 1 AND status=0";
				$res = $mysqli->query($getRole2) or die("Error in Get All Records".$mysqli->error);
				$detailrecords = 0;
				if ($mysqli->affected_rows>0)
				{
					$detailrecords = 1;
				}
			} else {
				$getRole2 = "SELECT * FROM audit_assign WHERE role1 = '".strip_tags($sessionId)."' AND auditee_response_status = 1 AND status=0";
				$res = $mysqli->query($getRole2) or die("Error in Get All Records".$mysqli->error);
				$detailrecords = 0;
				if ($mysqli->affected_rows>0)
				{
					$detailrecords = 1;
				}
			}
			
			return $detailrecords;
		}

		// Get Diesel Slip
		public function getAuditAssignDetails($mysqli, $id){

			$selectQry = "SELECT * FROM audit_assign WHERE audit_assign_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($selectQry) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$detailrecords['audit_assign_id']  = $row->audit_assign_id;  
				$detailrecords['date_of_audit']  = $row->date_of_audit;

				// department
				$departmentId1 = explode(",", $row->department_id);
				foreach($departmentId1 as $departmentId) {
					$departmentId = trim($departmentId);
					$getqry1 = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($departmentId)."' and status = 0";
					$res13 = $mysqli->query($getqry1);
					if ($mysqli->affected_rows>0)
					{
						$row13 = $res13->fetch_object();
						$department_name[] = $row13->department_name;      
					}
				}
				$detailrecords['department_name'] = implode(",", $department_name);

				// role 1
				$role1Id = $row->role1;   
				$getAuditorName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($role1Id)."' and status = 0"; 
				$res12 = $mysqli->query($getAuditorName);
				if ($mysqli->affected_rows>0)
				{
					$row12 = $res12->fetch_object();
					$detailrecords['role1'] = $row12->designation_name;        
				}

				// role 2
				$role2Id = $row->role2;   
				$getAuditeeName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($role2Id)."' and status = 0";
				$res14 = $mysqli->query($getAuditeeName);
				if ($mysqli->affected_rows>0)
				{
					$row14 = $res14->fetch_object();
					$detailrecords['role2'] = $row14->designation_name;        
				}

				$getAuditArea = "SELECT * FROM audit_area_creation WHERE audit_area_id = '".strip_tags($row->audit_area_id)."' AND status=0"; 
				$res2 = $mysqli->query($getAuditArea) or die("Error in Get All Records".$mysqli->error);
				if ($mysqli->affected_rows>0)
				{
					$row2 = $res2->fetch_object();
					$detailrecords['audit_area'] = $row2->audit_area;
				}
			}
			
			return $detailrecords;
		}


		// get project name from promotional activity
		public function getPromotionalProjectName($mysqli) {

			$qry = "SELECT * FROM promotional_activities WHERE campaign_status = '0' AND status=0 ORDER BY promotional_activities_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['promotional_activities_id']            = $row->promotional_activities_id; 
					$detailrecords[$i]['project']       	= strip_tags($row->project);
					$i++;
				}
			}
			return $detailrecords;
		}

		// get project name from promotional activity for update
		public function getPromotionalProjectNameUpdate($mysqli) {

			$qry = "SELECT * FROM promotional_activities WHERE status=0 ORDER BY promotional_activities_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['promotional_activities_id']            = $row->promotional_activities_id; 
					$detailrecords[$i]['project']       	= strip_tags($row->project);
					$i++;
				}
			}
			return $detailrecords;
		}


		// Add Campaign
		public function addCampaign($mysqli, $userid){ 

			if(isset($_POST['project_id'])){
				$project_id = $_POST['project_id'];
			}
			if(isset($_POST['actual_start_date'])){
				$actual_start_date = $_POST['actual_start_date'];
			}
			if(isset($_POST['promotional_activities_ref_id'])){
				$promotional_activities_ref_id = $_POST['promotional_activities_ref_id'];
			}
			if(isset($_POST['activity_involved'])){
				$activity_involved = $_POST['activity_involved'];
			}
			if(isset($_POST['time_frame_start'])){
				$time_frame_start = $_POST['time_frame_start'];
			}
			if(isset($_POST['duration'])){
				$duration = $_POST['duration'];
			}
			if(isset($_POST['start_date'])){
				$start_date = $_POST['start_date'];
			}
			if(isset($_POST['end_date'])){
				$end_date = $_POST['end_date'];
			}
			if(isset($_POST['employee_name'])){
				$employee_name = $_POST['employee_name'];
			}

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			// insert campaign
			$insertQry="INSERT INTO campaign(promotional_activities_id, actual_start_date, insert_login_id) VALUES('".strip_tags($project_id)."', '".strip_tags($actual_start_date)."', 
			'".strip_tags($userid)."')";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			$last_id  = $mysqli->insert_id;

			// update promotional activity
			$updateQry = 'UPDATE promotional_activities SET campaign_status = "1" WHERE promotional_activities_id = "'.mysqli_real_escape_string($mysqli, $project_id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

			for($j=0; $j<=sizeof($promotional_activities_ref_id)-1; $j++){

				// insert campaign ref
				$insertQryRef="INSERT INTO campaign_ref(campaign_id, promotional_activities_ref_id, activity_involved, time_frame_start, duration, start_date, end_date, 
				employee_name) VALUES ('".strip_tags($last_id)."', '".strip_tags($promotional_activities_ref_id[$j])."', '".strip_tags($activity_involved[$j])."', 
				'".strip_tags($time_frame_start[$j])."','".strip_tags($duration[$j])."','".strip_tags($start_date[$j].' '.$current_time)."',
				'".strip_tags($end_date[$j].' '.$current_time)."', '".strip_tags($employee_name[$j])."' )";
				$insert_ref=$mysqli->query($insertQryRef) or die("Error ".$mysqli->error);

				// update promotional activity ref
				$updateQryRef = 'UPDATE promotional_activities_ref SET start_date = "'.strip_tags($start_date[$j]).'", end_date = "'.strip_tags($end_date[$j]).'", 
				employee_name = "'.strip_tags($employee_name[$j]).'" WHERE promotional_activities_ref_id = "'.mysqli_real_escape_string($mysqli, $promotional_activities_ref_id[$j]).'" ';
				$res = $mysqli->query($updateQryRef) or die ("Error in in update Query!.".$mysqli->error); 
			}
			
		}

		// Get campaign
        public function getCampaign($mysqli, $id){ 

            $rr1Select = "SELECT * FROM campaign WHERE campaign_id='".mysqli_real_escape_string($mysqli, $id)."' ";
            $res = $mysqli->query($rr1Select) or die("Error in Get All Records".$mysqli->error);
            $detailrecords = array();
            if ($mysqli->affected_rows>0)
            {
                $row = $res->fetch_object();
                $campId                                          = $row->campaign_id;
                $detailrecords['campaign_id']                    = $row->campaign_id;
                $promotional_activities_id                       = $row->promotional_activities_id;
                $detailrecords['promotional_activities_id']      = $row->promotional_activities_id;
                $detailrecords['actual_start_date']              = $row->actual_start_date;
            }

			$selectDetails = "SELECT * FROM promotional_activities_ref WHERE promotional_activities_id = '".strip_tags($promotional_activities_id)."' ";
			$res1 = $mysqli->query($selectDetails) or die("Error in Get All Records".$mysqli->error);
            if ($mysqli->affected_rows>0)
            {
				while($row1 = $res1->fetch_object()){

					$promotional_activities_refId = $row1->promotional_activities_ref_id;
					$promotional_activities_ref_id[] = $row1->promotional_activities_ref_id;
					$activity_involved[] = $row1->activity_involved;
					$time_frame_start[] = $row1->time_frame_start;
					$duration[] = $row1->duration;
				}

				if($promotional_activities_refId > 0)
				{
					$detailrecords['promotional_activities_ref_id'] = $promotional_activities_ref_id;
					$detailrecords['activity_involved'] = $activity_involved;
					$detailrecords['time_frame_start'] = $time_frame_start;
					$detailrecords['duration'] = $duration;
				}else{
					$detailrecords['promotional_activities_ref_id'] = array();
					$detailrecords['activity_involved'] = array();
					$detailrecords['time_frame_start'] = array();
					$detailrecords['duration'] = array();
				}

				$selectDetails1 = "SELECT * FROM campaign_ref WHERE campaign_id = '".strip_tags($campId)."' ";
				$res2 = $mysqli->query($selectDetails1) or die("Error in Get All Records".$mysqli->error);
				if ($mysqli->affected_rows>0)
				{
					while($row2 = $res2->fetch_object()){
						$campaign_refId = $row2->campaign_ref_id;
						$campaign_ref_id[] = $row2->campaign_ref_id;
						$start_date[] = $row2->start_date; 
						$end_date[] = $row2->end_date;
						$staff_name[] = $row2->employee_name;
						
						if($campaign_refId > 0){
							$detailrecords['campaign_ref_id'] = $campaign_ref_id;
							$detailrecords['start_date'] = $start_date;
							$detailrecords['end_date'] = $end_date;
							$detailrecords['staff_name'] = $staff_name;
						} else {
							$detailrecords['campaign_ref_id'] = array();
							$detailrecords['start_date'] = array();
							$detailrecords['end_date'] = array();
							$detailrecords['staff_name'] = array();
						}
					}
					
				} 
			}
            
            return $detailrecords;
        }

        // Update campaign
        public function updateCampaign($mysqli, $id, $userid){  

            if(isset($_POST['project_id'])){
				$project_id = $_POST['project_id'];
			}
			if(isset($_POST['actual_start_date'])){
				$actual_start_date = $_POST['actual_start_date'];
			}
			if(isset($_POST['promotional_activities_ref_id'])){
				$promotional_activities_ref_id = $_POST['promotional_activities_ref_id'];
			}
			if(isset($_POST['activity_involved'])){
				$activity_involved = $_POST['activity_involved'];
			}
			if(isset($_POST['time_frame_start'])){
				$time_frame_start = $_POST['time_frame_start'];
			}
			if(isset($_POST['duration'])){
				$duration = $_POST['duration'];
			}
			if(isset($_POST['start_date'])){
				$start_date = $_POST['start_date'];
			}
			if(isset($_POST['end_date'])){
				$end_date = $_POST['end_date'];
			}
			if(isset($_POST['employee_name'])){
				$employee_name = $_POST['employee_name'];
			}
			if(isset($_POST['old_project_id'])){
				$old_project_id = $_POST['old_project_id'];
			}
			if(isset($_POST['old_promotional_activity_ref_id'])){
				$old_promotional_activity_ref_id = $_POST['old_promotional_activity_ref_id'];
			}

            $updateQry = 'UPDATE campaign SET promotional_activities_id = "'.strip_tags($project_id).'", actual_start_date = "'.strip_tags($actual_start_date).'", 
			update_login_id = "'.strip_tags($userid).'", status = "0" WHERE campaign_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
            $res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error);

			// delete ref
            $DeleterrRef = $mysqli->query("DELETE FROM campaign_ref WHERE campaign_id = '".$id."' ");

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			for($j=0; $j<=sizeof($promotional_activities_ref_id)-1; $j++){
				// insert campaign ref
				$insertQryRef="INSERT INTO campaign_ref(campaign_id, promotional_activities_ref_id, activity_involved, time_frame_start, duration, start_date, end_date, 
				employee_name) VALUES ('".strip_tags($id)."', '".strip_tags($promotional_activities_ref_id[$j])."', '".strip_tags($activity_involved[$j])."', 
				'".strip_tags($time_frame_start[$j])."','".strip_tags($duration[$j])."','".strip_tags($start_date[$j].' '.$current_time)."', 
				'".strip_tags($end_date[$j].' '.$current_time)."', '".strip_tags($employee_name[$j])."' )";
				$insert_ref=$mysqli->query($insertQryRef) or die("Error ".$mysqli->error);

				// update promotional activity ref
				$updateQryRef = 'UPDATE promotional_activities_ref SET start_date = "'.strip_tags($start_date[$j]).'", end_date = "'.strip_tags($end_date[$j]).'", 
				employee_name = "'.strip_tags($employee_name[$j]).'" WHERE promotional_activities_ref_id = "'.mysqli_real_escape_string($mysqli, $promotional_activities_ref_id[$j]).'" ';
				$res = $mysqli->query($updateQryRef) or die ("Error in in update Query!.".$mysqli->error); 
			}

			return true;
		}

		//  Delete Campaign
		public function deleteCampaign($mysqli, $id, $userid){

			$deleteQry = "UPDATE campaign set status='1', delete_login_id='".strip_tags($userid)."' WHERE campaign_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}


		// Add promotional_activities
		public function addpromotional_activities($mysqli,$userid,$id){
							   
			if(isset($_POST['id'])){
				$id = $_POST['id'];
			}
			if(isset($_POST['promotional_activities_ref_id'])){
				$refid = $_POST['promotional_activities_ref_id'];
			}
			if(isset($_POST['project'])){
				$project = $_POST['project'];
			}
			if(isset($_POST['activity_involved'])){
				$activity = $_POST['activity_involved'];
			}
			if(isset($_POST['time_frame_start'])){
				$time_frame = $_POST['time_frame_start'];
			}
			if(isset($_POST['duration'])){
				$duration = $_POST['duration'];
			}
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			}
				
			if($id == '0'){
				$qry1="INSERT INTO promotional_activities (promotional_activities_id,project,insert_login_id,status) VALUES (NULL, '$project', '$userid', '0');";
						$insert_assign=$mysqli->query($qry1) or die("Error ".$mysqli->error);
						$last_id  = $mysqli->insert_id;

				for($j=0; $j<=sizeof($activity)-1; $j++){
					$qry2="INSERT INTO promotional_activities_ref (promotional_activities_ref_id,promotional_activities_id,activity_involved,time_frame_start,duration) VALUES (NULL,'$last_id','$activity[$j]','$time_frame[$j]','$duration[$j]');";
					// echo $qry2; die;
					$insert_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);
				}
			}else{
				$qry1="UPDATE promotional_activities set project = '$project',status ='0',update_login_id='$userid' WHERE promotional_activities_id = '$id' ";
				$update_assign=$mysqli->query($qry1) or die("Error ".$mysqli->error);
				$last_id  = $mysqli->insert_id;
				
				$deleteqry = " DELETE FROM promotional_activities_ref WHERE promotional_activities_id = '".$id."' ";
				$delete=$mysqli->query($deleteqry) or die("Error on delete query ".$mysqli->error);

				for($j=0; $j<=sizeof($activity)-1; $j++){

					if($refid = ' '){
						$qry2="INSERT INTO promotional_activities_ref (promotional_activities_ref_id,promotional_activities_id,activity_involved,time_frame_start,duration)
						VALUES (NULL,'$id','$activity[$j]','$time_frame[$j]','$duration[$j]');";
							$insert_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);
							
					}
				}
			}  
		} 

		// Promotional_activities DELETE
		public function deletepromotional_activities($mysqli, $id){
			$checklistDelete = "UPDATE promotional_activities set status='1' WHERE promotional_activities_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($checklistDelete) or die("Error in delete query".$mysqli->error);
		}

		//get promotional_activities list table
		  public function getPromoActivities($mysqli,$id){

			if($id>0){
				$checklistSelect = "SELECT * FROM promotional_activities where promotional_activities_id = '$id'";
			}else{
				$checklistSelect = "SELECT * FROM promotional_activities";
			}
			$res = $mysqli->query($checklistSelect) or die("Error in Get All checklist ".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object()){
				$auditChecklist['project'] = $row->project;
				$auditChecklist['promotional_activities_id'] = $row->promotional_activities_id;
				
			}
			}    
			return $auditChecklist;
		 }

		// get getPromoActivities_ref edit list
		public function getPromoActivities_ref($mysqli,$id){
			$get_checklist = "SELECT * FROM promotional_activities_ref where promotional_activities_id IN ($id)";

			$res2 = $mysqli->query($get_checklist) or die("Error in Get All Records".$mysqli->error);
			$i=0;
			$activities='';
			$activities=array();
			if ($mysqli->affected_rows>0)
			{
				while($row2 = $res2->fetch_assoc()){
				$activities[$i]['promotional_activities_ref_id'] = $row2['promotional_activities_ref_id'];
				$activities[$i]['activity_involved'] = $row2['activity_involved'];
				$activities[$i]['time_frame_start'] = $row2['time_frame_start'];
				$activities[$i]['duration']=$row2['duration'];
				$i++;
				}
			}
			return $activities;
		}

		// Add approval line
		public function addMeetingMinutesApprovalLine($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['sstaffid'])){
				$staff_id = $_POST['sstaffid'];
			}
			if(isset($_POST['approvalStaffId'])){
				$approvalStaffId1 = $_POST['approvalStaffId']; 
				$approvalStaffId = implode(",", $approvalStaffId1);
			}
			if(isset($_POST['agreeParallelStaffId'])){
				$agreeParallelStaffId1 = $_POST['agreeParallelStaffId'];
				$agreeParallelStaffId = implode(",", $agreeParallelStaffId1);
			}
			if(isset($_POST['afterNotifiedStaffId'])){
				$afterNotifiedStaffId1 = $_POST['afterNotifiedStaffId'];
				$afterNotifiedStaffId = implode(",", $afterNotifiedStaffId1);
			} 
			if(isset($_POST['receivingDeptId'])){
				$receivingDeptId1 = $_POST['receivingDeptId'];
				$receivingDeptId = implode(",", $receivingDeptId1);
			} 
	
			$addMeetingMinutesApprovalLine = "INSERT INTO meeting_minutes_approval_line(company_id, staff_id, approval_staff_id, agree_par_staff_id, after_notified_staff_id, receiving_dept_id, insert_login_id)
				VALUES('".strip_tags($company_id)."', '".strip_tags($staff_id)."', '".strip_tags($approvalStaffId)."','".strip_tags($agreeParallelStaffId)."', '".strip_tags($afterNotifiedStaffId)."', 
				'".strip_tags($receivingDeptId)."','".strip_tags($userid)."')"; 
			$updresult = $mysqli->query($addMeetingMinutesApprovalLine)or die ("Error in in update Query!.".$mysqli->error);
			$approvalLineId = $mysqli->insert_id;

			for($i=0; $i<=sizeof($agreeParallelStaffId1)-1; $i++){

				$addAgreeDisagree = "INSERT INTO meeting_minutes_parallel_agree_disagree(meeting_minutes_approval_line_id, agree_disagree_staff_id)
				VALUES('".strip_tags($approvalLineId)."', '".strip_tags($agreeParallelStaffId1[$i])."')";
				$updresult1 = $mysqli->query($addAgreeDisagree)or die ("Error in in Insert Query!.".$mysqli->error);
			} 
		}


		// Add approval requisition
		public function addMeetingMinutes($mysqli, $userid){

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$staff_id = $_POST['staffid'];
			}
			if(isset($_POST['doc_no'])){
				$doc_no = $_POST['doc_no'];
			}
			if(isset($_POST['auto_generation_date'])){
				$auto_generation_date = $_POST['auto_generation_date'];
			}
			if(isset($_POST['title'])){
				$title = $_POST['title'];
			}
			if(isset($_POST['comments'])){
				$comments = $_POST['comments'];
			}

			$file1 = array();
			if(count($_FILES["file"]["name"]) > 0)
			{
				sleep(3);
				for($count=0; $count<count($_FILES["file"]["name"]); $count++)
				{
					$file_name = $_FILES["file"]["name"][$count];
						array_push($file1,$file_name);
					$tmp_name = $_FILES["file"]['tmp_name'][$count];
					$file_array = explode(".", $file_name);
					$file_extension = end($file_array);
					$location = 'uploads/meeting_minutes/'.$file_name;
					move_uploaded_file($tmp_name, $location);
				}
			}
			$file= implode(",", $file1 );

			$addApprovalRequisition = "INSERT INTO meeting_minutes(meeting_minutes_approval_line_id, staff_id, doc_no, auto_generation_date, title, comments, file, insert_login_id)
				VALUES('".strip_tags($approval_line_id)."','".strip_tags($staff_id)."', '".strip_tags($doc_no)."', '".strip_tags($auto_generation_date)."', '".strip_tags($title)."',
				'".strip_tags($comments)."', '".strip_tags($file)."', '".strip_tags($userid)."')"; 
			$updresult = $mysqli->query($addApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
		}


		// Get all approval requisition approve staff
		public function getMeetingMinutesApproveStaffDashboard($mysqli){

			$getApprovalReq = "SELECT * FROM meeting_minutes WHERE 1 AND status=0";
			$res1 = $mysqli->query($getApprovalReq) or die("Error in Get All Records".$mysqli->error);
			$appReqApproval_line_id = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row1 = $res1->fetch_object())
				{
					$appReqApproval_line_id[] = $row1->meeting_minutes_approval_line_id;
					$i++;
				}
			}

			if($appReqApproval_line_id > 0){
				$getApprovalLine = "SELECT * FROM meeting_minutes_approval_line WHERE 1 AND status=0 ORDER BY meeting_minutes_approval_line_id ASC";
				$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
				$detailrecords = array();
				if ($mysqli->affected_rows>0)
				{

					$row = $res->fetch_object();
					if (in_array($row->meeting_minutes_approval_line_id, $appReqApproval_line_id)){
						
						$detailrecords['meeting_minutes_approval_line_id'] = $row->meeting_minutes_approval_line_id;
						$detailrecords['company_id']  = $row->company_id;
						$detailrecords['approval_staff_id']  = $row->approval_staff_id;
						$detailrecords['agree_par_staff_id']  = $row->agree_par_staff_id;
						$detailrecords['after_notified_staff_id']  = $row->after_notified_staff_id;
						$detailrecords['receiving_dept_id']  = $row->receiving_dept_id;
						$detailrecords['checker_approval']  = $row->checker_approval;
						$detailrecords['reviewer_approval']  = $row->reviewer_approval;
						$detailrecords['final_approval']  = $row->final_approval;
						$detailrecords['created_date']  = $row->created_date;
						$detailrecords['checker_approval_date']  = $row->checker_approval_date;
						$detailrecords['reviewer_approval_date']  = $row->reviewer_approval_date;
						$detailrecords['final_approval_date']  = $row->final_approval_date;
					}
				}
				return $detailrecords;
			}else{
				return false;
			}
		}


		// fetch parallel staff on dashboard meeting minutes
		public function getMeetingMinutesParallelAgreement($mysqli, $sessionId, $meeting_minutes_approval_line_id){
	
			$getParallelAgreementStaffId = "SELECT agree_disagree_staff_id, agree_disagree FROM meeting_minutes_parallel_agree_disagree 
			WHERE meeting_minutes_approval_line_id = '".strip_tags($meeting_minutes_approval_line_id)."' AND agree_disagree = '0' AND status=0 
			ORDER BY meeting_minutes_agree_disagree_id ASC LIMIT 1";
			$res11 = $mysqli->query($getParallelAgreementStaffId) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row11 = $res11->fetch_object();
				$detailrecords['agree_disagree_staff_id']  = $row11->agree_disagree_staff_id;
				$detailrecords['agree_disagree']  = $row11->agree_disagree;
			}
			return $detailrecords;
		}


		// fetch after notification meeting minutes
		public function getMeetingMinutesAfterNotification($mysqli, $sessionId, $meeting_minutes_approval_line_id){

			$getafterNotificationStaff = "SELECT final_approval, after_notified_staff_id FROM meeting_minutes_approval_line WHERE meeting_minutes_approval_line_id = '".strip_tags($meeting_minutes_approval_line_id)."' 
			AND final_approval = '1' AND status=0";
			$res = $mysqli->query($getafterNotificationStaff) or die("Error in Get All Records".$mysqli->error);
			$after_notified_staff_id = '';
			$final_approval = '';
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$after_notified_staff_id  = $row->after_notified_staff_id;
				$final_approval  = $row->final_approval;
			}

			$getApprovalLine = "SELECT * FROM meeting_minutes_approval_line WHERE meeting_minutes_approval_line_id = '".strip_tags($meeting_minutes_approval_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$agree_par_staff_id = '';
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$agree_par_staff_id  = $row->agree_par_staff_id;
			}

			$parallel_staff_idArr = array_map('intval', explode(',', $agree_par_staff_id));
			$parallel_staff_idLength = sizeof($parallel_staff_idArr);

			$getParallelAgreementStaffId = "SELECT COUNT(agree_disagree) as agree_disagree FROM meeting_minutes_parallel_agree_disagree WHERE agree_disagree = '1' AND status=0 ";
			$res11 = $mysqli->query($getParallelAgreementStaffId) or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				$row11 = $res11->fetch_object();
				$agree_disagree  = $row11->agree_disagree;
			}

			if($final_approval == 1 && $parallel_staff_idLength == $agree_disagree){
				$detailrecords['after_notified_staff_id']  = $after_notified_staff_id;
				$detailrecords['status'] = 1;
			}else{
				$detailrecords['status'] = 0;
				$detailrecords['after_notified_staff_id']  = $after_notified_staff_id;
			}

			return $detailrecords;
		}

		// Get meeting minutes approval line approve staff approval line
		public function getMeetingMinutesApprovalLineApproveStaff($mysqli, $idupd){

			$rr1Select = "SELECT * FROM meeting_minutes_approval_line WHERE meeting_minutes_approval_line_id = '".strip_tags($idupd)."' AND status=0 ORDER BY meeting_minutes_approval_line_id ASC";
			$res = $mysqli->query($rr1Select) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$detailrecords['approval_line_id']          = $row->meeting_minutes_approval_line_id;
				$detailrecords['company_id']                = $row->company_id;
				$detailrecords['staff_id']                  = $row->staff_id;
				$detailrecords['approval_staff_id']         = $row->approval_staff_id;
				$detailrecords['agree_par_staff_id']        = $row->agree_par_staff_id;
				$detailrecords['after_notified_staff_id']   = $row->after_notified_staff_id;
				$detailrecords['receiving_dept_id']         = $row->receiving_dept_id;
				$detailrecords['checker_approval']          = $row->checker_approval;
				$detailrecords['reviewer_approval']         = $row->reviewer_approval;
				$detailrecords['final_approval']            = $row->final_approval;
				$detailrecords['created_date']              = $row->created_date;
				$detailrecords['checker_approval_date']     = $row->checker_approval_date;
				$detailrecords['reviewer_approval_date']    = $row->reviewer_approval_date;
				$detailrecords['final_approval_date']       = $row->final_approval_date;
			}
			return $detailrecords;
		}

		// parallel agrement meeting minutes
		public function parallelMeetingMinutes($mysqli, $userid){  

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}
			$date  = date('Y-m-d');

			$agreeApprovalRequisition = "UPDATE meeting_minutes_parallel_agree_disagree set agree_disagree = '1', agree_disagree_date = '".strip_tags($date)."' 
			WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' AND agree_disagree_staff_id = '".strip_tags($sstaffid)."' ";
			$updresult1 = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
		}


		// agree approval requisition
		public function agreeMeetingMinutes($mysqli, $userid){

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}

			$getApprovalLine = "SELECT * FROM meeting_minutes_approval_line WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$checker_approval  = $row->checker_approval;
				$reviewer_approval  = $row->reviewer_approval;
				$final_approval  = $row->final_approval;
				$approval_staff_id  = $row->approval_staff_id;
			}

			$approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
			$approval_staff_idLength = sizeof($approval_staff_idArr);
			$date  = date('Y-m-d');

			if($approval_staff_idLength == '2'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set checker_approval = '1', checker_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set final_approval = '1', final_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}else if($approval_staff_idLength == '3'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set checker_approval = '1', checker_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set reviewer_approval = '1', reviewer_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[2]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set final_approval = '1', final_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}
		}

		// parallel disagrement meeting minutes
		public function parallelDisagreeMeetingMinutes($mysqli, $userid){  

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}
			$date  = date('Y-m-d');

			$agreeApprovalRequisition = "UPDATE meeting_minutes_parallel_agree_disagree set agree_disagree = '2', agree_disagree_date = '".strip_tags($date)."' 
			WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' AND agree_disagree_staff_id = '".strip_tags($sstaffid)."' ";
			$updresult1 = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
		}


		// disagree meeting minutes
		public function disagreeMeetingMinutes($mysqli, $userid){

			if(isset($_POST['approval_line_id'])){
				$approval_line_id = $_POST['approval_line_id'];
			}
			if(isset($_POST['staffid'])){
				$sstaffid = $_POST['staffid'];
			}

			$getApprovalLine = "SELECT * FROM meeting_minutes_approval_line WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' AND status=0"; 
			$res = $mysqli->query($getApprovalLine) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();
				$checker_approval  = $row->checker_approval;
				$reviewer_approval  = $row->reviewer_approval;
				$final_approval  = $row->final_approval;
				$approval_staff_id  = $row->approval_staff_id;
			}

			$approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
			$approval_staff_idLength = sizeof($approval_staff_idArr);
			$date  = date('Y-m-d');

			if($approval_staff_idLength == '2'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set checker_approval = '2', checker_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set final_approval = '2', final_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}else if($approval_staff_idLength == '3'){
				if($checker_approval == 0){
					if($sstaffid == $approval_staff_idArr[0]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set checker_approval = '2', checker_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 0){
					if($sstaffid == $approval_staff_idArr[1]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set reviewer_approval = '2', reviewer_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} } else if($checker_approval == 1 && $reviewer_approval == 1 && $final_approval == 0){
					if($sstaffid == $approval_staff_idArr[2]) {
						$agreeApprovalRequisition = "UPDATE meeting_minutes_approval_line set final_approval = '2', final_approval_date = '".strip_tags($date)."' WHERE meeting_minutes_approval_line_id = '".strip_tags($approval_line_id)."' ";
						$updresult = $mysqli->query($agreeApprovalRequisition)or die ("Error in in Insert Query!.".$mysqli->error);
				} }
			}
		}

		//  Get Company Name
		public function getGoalYear($mysqli) {

			$qry = "SELECT * FROM goal_setting WHERE 1 AND status=0 ORDER BY goal_setting_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['goal_setting_id']            = $row->goal_setting_id; 

					$selectYear = "SELECT * FROM year_creation WHERE year_id = '".strip_tags($row->year)."' ";
					$res1 = $mysqli->query($selectYear) or die("Error in Get All Records".$mysqli->error);
					if ($mysqli->affected_rows>0)
					{
						while($row1 = $res1->fetch_object()){
							$detailrecords[$i]['year'] = $row1->year;
						}
					}
					$i++;
				}
			}
			return $detailrecords;
		}



}
?>



