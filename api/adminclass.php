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
				$detailrecords['branch_id']    = $row->company_id;

				$qry1 = "SELECT * FROM branch_creation WHERE branch_id = '".strip_tags($row->company_id)."' AND status=0"; 
				$res1 = $mysqli->query($qry1);
				while($row5 = $res1->fetch_object())
				{
					$detailrecords['company_id'] = $row5->company_id;
				}

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
			$current_date = date('Y-m-d');

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
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}else{
				$frequency_applicable = '';
			}

			if($calendar == "No"){
				$from_date = '';
				$to_date = '';
			} else {
				$from_date = $from_date1.' '.$current_time;
				$to_date = $to_date1.' '.$current_time;
			}
		
			$auditInsert="INSERT INTO audit_area_creation(audit_area, frequency, frequency_applicable, department_id, calendar, from_date, to_date, role1, role2, check_list, 
			insert_login_id) VALUES ('".strip_tags($audit_area)."', '".strip_tags($frequency)."', '".strip_tags($frequency_applicable)."', '".strip_tags($department_id)."', 
			'".strip_tags($calendar)."', '".strip_tags($from_date)."', '".strip_tags($to_date)."', '".strip_tags($role1)."', '".strip_tags($role2)."', 
			'".strip_tags($check_list)."','".strip_tags($userid)."' )";
			$insresult=$mysqli->query($auditInsert) or die("Error ".$mysqli->error);
			$lastid = $mysqli->insert_id;

			// select holiday
			$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
			$res9 = $mysqli->query($getqry9);
			$holiday_dates = [];
			while ($row9 = $res9->fetch_assoc()) {
				$holiday_dates[] = $row9["holiday_date"];
			}

			$frqArr = array('Yearly', 'Daily Task');
			if($frequency_applicable == 'frequency_applicable' && $calendar == "Yes" && !in_array($frequency, $frqArr)){

				if ($frequency == 'Weekly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}
						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+7 days'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+7 days'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				} else if ($frequency == 'Fortnightly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}
						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+15 days'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+15 days'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				} else if ($frequency == 'Monthly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}

						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 month'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+1 month'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				} else if ($frequency == 'Quaterly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}

						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}

						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+3 months'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+3 months'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				} else if ($frequency == 'Half Yearly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}

						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				}

				for($i=0; $i<=sizeof($from_dates)-1; $i++){

					$insertQry="INSERT INTO audit_area_creation_ref(audit_area_id, from_date, to_date) VALUES ('".strip_tags($lastid)."', 
					'".strip_tags($from_dates[$i].' '.$current_time)."', '".strip_tags($to_dates[$i].' '.$current_time)."' )";
					$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
				} 
			} else if ($frequency == 'Daily Task' && $calendar == "No"){
				//if select Daily Task in frequency then insert record per day for current year. 
				$end_of_year = date('Y-12-31');
				$current_from_date = date('Y-m-d', strtotime($current_date));
			
				$from_dates = array();
			
				while ($current_from_date <= $end_of_year ) {
					// Check if current_from_date is a Sunday or holiday
					while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
						$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
					}

					if ($current_from_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
					}

					$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 DAY'));
				
					if ($current_from_date > $end_of_year ) {
						break;
					}
				}//While END.

				for($a=0; $a <count($from_dates); $a++){

					$insertQry="INSERT INTO audit_area_creation_ref(audit_area_id, from_date, to_date) VALUES ('".strip_tags($lastid)."', 
					'".strip_tags($from_dates[$a].' '.$current_time)."', '".strip_tags($from_dates[$a].' '.$current_time)."' )";
					$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
				} 

			} else {

				$insertQry="INSERT INTO audit_area_creation_ref(audit_area_id, from_date, to_date) VALUES ('".strip_tags($lastid)."', '".strip_tags($from_date)."', 
				'".strip_tags($to_date)."' )";
				$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
			}

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
				$detailrecords['frequency_applicable']      = $row->frequency_applicable;
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
			$current_date = date('Y-m-d');

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
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}else{
				$frequency_applicable = '';
			}

			if($calendar == "No"){
				$from_date = '';
				$to_date = '';
			} else {
				$from_date = $from_date1.' '.$current_time;
				$to_date = $to_date1.' '.$current_time;
			}
		
		   $auditUpdaet = "UPDATE audit_area_creation SET audit_area = '".strip_tags($audit_area)."', frequency='".strip_tags($frequency)."', frequency_applicable='".strip_tags($frequency_applicable)."',
		   department_id='".strip_tags($department_id)."', calendar='".strip_tags($calendar)."', from_date='".strip_tags($from_date)."', to_date='".strip_tags($to_date)."',
		   role1='".strip_tags($role1)."', role2='".strip_tags($role2)."', check_list='".strip_tags($check_list)."', update_login_id='".strip_tags($userid)."', status = '0' 
		   WHERE audit_area_id= '".strip_tags($id)."' ";
		   $updresult = $mysqli->query($auditUpdaet )or die ("Error in in update Query!.".$mysqli->error);

		   // delete audit area ref
			$DeleterrRef = $mysqli->query("DELETE FROM audit_area_creation_ref WHERE audit_area_id = '".$id."' ");

		   // select holiday
			$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
			$res9 = $mysqli->query($getqry9);
			$holiday_dates = [];
			while ($row9 = $res9->fetch_assoc()) {
				$holiday_dates[] = $row9["holiday_date"];
			}

			$frqArr = array('Yearly', 'Daily Task');
			if($frequency_applicable == 'frequency_applicable' && $calendar == "Yes" && !in_array($frequency, $frqArr)){

				if ($frequency == 'Weekly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}

						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+7 days'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+7 days'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				} else if ($frequency == 'Fortnightly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}

						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+15 days'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+15 days'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				} else if ($frequency == 'Monthly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}
					
						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 month'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+1 month'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				} else if ($frequency == 'Quaterly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}
					
						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+3 months'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+3 months'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				} else if ($frequency == 'Half Yearly'){ 

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}

						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
				}

				for($i=0; $i<=sizeof($from_dates)-1; $i++){

					$insertQry="INSERT INTO audit_area_creation_ref(audit_area_id, from_date, to_date) VALUES ('".strip_tags($id)."', 
					'".strip_tags($from_dates[$i].' '.$current_time)."', '".strip_tags($to_dates[$i].' '.$current_time)."' )";
					$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
				} 
			} else if ($frequency == 'Daily Task' && $calendar == "No"){
				//if select Daily Task in frequency then insert record per day for current year. 
				$end_of_year = date('Y-12-31');
				$current_from_date = date('Y-m-d', strtotime($current_date));
			
				$from_dates = array();
			
				while ($current_from_date <= $end_of_year ) {
					// Check if current_from_date is a Sunday or holiday
					while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
						$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
					}

					if ($current_from_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
					}

					$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 DAY'));
				
					if ($current_from_date > $end_of_year ) {
						break;
					}
				}//While END.

				for($a=0; $a <count($from_dates); $a++){

					$insertQry="INSERT INTO audit_area_creation_ref(audit_area_id, from_date, to_date) VALUES ('".strip_tags($id)."', 
					'".strip_tags($from_dates[$a].' '.$current_time)."', '".strip_tags($from_dates[$a].' '.$current_time)."' )";
					$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
				} 

			} else {

				$insertQry="INSERT INTO audit_area_creation_ref(audit_area_id, from_date, to_date) VALUES ('".strip_tags($id)."', '".strip_tags($from_date)."', 
				'".strip_tags($to_date)."' )";
				$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
			}

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

		public function getBranchBasedDepartment($mysqli, $sbranch_ids) {
			$detailrecords = array();
			
			foreach ($sbranch_ids as $sbranch_id) {
				$qry = "SELECT dc.department_id, dc.department_name,dc.company_id, bc.branch_name FROM department_creation dc LEFT JOIN branch_creation bc ON dc.company_id = bc.branch_id WHERE dc.company_id = '$sbranch_id' AND dc.status = 0"; 
				$res = $mysqli->query($qry) or die("Error in Get All Records" . $mysqli->error);
				
				if ($res->num_rows > 0) {
					while ($row = $res->fetch_object()) {
						$detailrecord = array();
						$detailrecord['department_id'] = $row->department_id; 
						$detailrecord['department_name'] = $row->department_name;
						$detailrecord['company_id'] = $row->company_id;
						$detailrecord['branch_name'] = $row->branch_name;
						
						$detailrecords[$sbranch_id][] = $detailrecord;
					}
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
        public function getkrakpicompany($mysqli, $sbranch_id, $company) {

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
				
				$qry = "SELECT krakpi_id, company_name, designation FROM krakpi_creation WHERE company_name = '".$company."' AND status=0 ORDER BY designation ASC";
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
			$report_to = '';
			if(isset($_POST['report_to'])){
                $report_to = $_POST['report_to'];
            }
			if(isset($_POST['responsibility'])){
				$responsibility1 = $_POST['responsibility'];
				$responsibility = implode(",", $responsibility1);
			}
                $basicInsert="INSERT INTO basic_creation(company_id, department_code, department, designation_code, designation, report_to, responsibility, insert_login_id)
                VALUES( '".strip_tags($company_id)."', '".strip_tags($department_code)."', '".strip_tags($department)."',
                '".strip_tags($designation_code)."', '".strip_tags($designation)."', '".strip_tags($report_to)."', '".strip_tags($responsibility)."', '".strip_tags($userid)."')";
                $insresult=$mysqli->query($basicInsert) or die("Error ".$mysqli->error);
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
				$detailrecords['responsibility']         = $row->responsibility;
								
			}
			
			return $detailrecords;
		}
		

		// Update basic
        public function updateBasicCreation($mysqli, $id, $userid){
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
			if(isset($_POST['responsibility'])){
                $responsibility1 = $_POST['responsibility'];
                $responsibility = implode(",", $responsibility1);
            }

            $basicUpdaet = "UPDATE basic_creation SET company_id = '".strip_tags($company_id)."', department_code='".strip_tags($department_code)."',
            department='".strip_tags($department)."', designation_code='".strip_tags($designation_code)."',
            designation='".strip_tags($designation)."', report_to = '".strip_tags($report_to)."', responsibility = '".strip_tags($responsibility)."', update_login_id='".strip_tags($userid)."', status = 0 
			WHERE basic_creation_id = '".strip_tags($id)."' "; 
            $updresult = $mysqli->query($basicUpdaet) or die ("Error in in update Query!.".$mysqli->error);
        }

		//  Delete basic
		public function deleteBasicCreation($mysqli, $id, $userid){

			$basicDelete = "UPDATE basic_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE basic_creation_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($basicDelete) or die("Error in delete query".$mysqli->error);
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
        public function getRNRDepartmentBased($mysqli, $designation) {

			$qry = "SELECT rr_ref_id, rr FROM rr_creation_ref LEFT JOIN rr_creation ON rr_creation_ref.rr_reff_id = rr_creation.rr_id 
			WHERE rr_creation_ref.designation = '".$designation."' AND rr_creation.status = 0 ";

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
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 

			$rrInsert="INSERT INTO rr_creation(company_name, insert_login_id) VALUES('".strip_tags($company_name)."', '".strip_tags($userid)."')";
			$insresult=$mysqli->query($rrInsert) or die("Error ".$mysqli->error);
			$RRId = $mysqli->insert_id; 

			for($i=0; $i<=sizeof($department)-1; $i++){

				$rr1Insert="INSERT INTO rr_creation_ref(rr_reff_id,rr, department, designation, insert_login_id)
				VALUES('".strip_tags($RRId)."', '".strip_tags($rr[$i])."','".strip_tags($department[$i])."', '".strip_tags($designation[$i])."', '".strip_tags($userid)."' )";
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
					$rr[]      = $row1->rr;

				} 
			}
			if($rrRefid > 0)
			{
				$detailrecords['rr_ref_id']        = $rr_ref_id; 
				$detailrecords['department']      = $department;
				$detailrecords['designation'] = $designation;  	
				$detailrecords['rr'] = $rr;  	
				
			}
			else
			{
				$detailrecords['rr_ref_id']      = array();
				$detailrecords['department']     = array();
				$detailrecords['designation']    = array(); 
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
			if(isset($_POST['userid'])){
				$userid = $_POST['userid'];
			} 
			if(isset($_POST['rr_ref_id'])){
				$rr_ref_id = $_POST['rr_ref_id'];
			} 
			if(isset($_POST['rr_ref_id_deleted'])){
				$rr_ref_id_deleted = $_POST['rr_ref_id_deleted'];
			} 
			$updateQry = 'UPDATE rr_creation SET company_name = "'.strip_tags($company_name).'", status = "0" WHERE rr_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 
			
			for($a=0; $a < count($rr_ref_id_deleted); $a++){
				$DeleterrRef = $mysqli->query("DELETE FROM rr_creation_ref WHERE rr_ref_id = '".$rr_ref_id_deleted[$a]."' "); 
			} 

			for($i=0; $i<=sizeof($department)-1; $i++){
				if(!empty($rr_ref_id[$i])){
					$rrUpdaet = "UPDATE `rr_creation_ref` SET `rr_reff_id`='$id',`department`='$department[$i]',`designation`='$designation[$i]',`rr`='$rr[$i]',`update_login_id`='$userid',`updated_date` = now() WHERE `rr_ref_id`='$rr_ref_id[$i]' ";
					$updresult = $mysqli->query($rrUpdaet)or die ("Error in in update Query!.".$mysqli->error);
				
				}else{
					$rrUpdaet = "INSERT INTO rr_creation_ref(rr_reff_id, rr, department, designation, insert_login_id) 
					VALUES('".strip_tags($id)."', '".strip_tags($rr[$i])."','".strip_tags($department[$i])."', '".strip_tags($designation[$i])."', '".strip_tags($userid)."')";
					$updresult = $mysqli->query($rrUpdaet)or die ("Error in in update Query!.".$mysqli->error);
				}

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

			if(isset($_POST['freq_check'])){
				$freq_check = explode(',',$_POST['freq_check']);
			}

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');
			$current_date = date('Y-m-d');

            $rrInsert="INSERT INTO krakpi_creation(company_name, department, designation, insert_login_id) VALUES('".strip_tags($company_name)."', 
			'".strip_tags($department)."', '".strip_tags($designation)."', '".strip_tags($userid)."' )";
            $insresult=$mysqli->query($rrInsert) or die("Error ".$mysqli->error);
            $lastid = $mysqli->insert_id;

			// select holiday
			$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
			$res9 = $mysqli->query($getqry9);
			$holiday_dates = [];
			while ($row9 = $res9->fetch_assoc()) {
				$holiday_dates[] = $row9["holiday_date"];
			}

            for($i=0; $i<=sizeof($rr)-1; $i++){

				if($calendar[$i] == "No"){
					$from_date = '';
				} else {
					$from_date = $from_date1[$i].' '.$current_time;
				}

				if($calendar[$i] == "No"){
					$to_date = '';
				} else {
					$to_date = $to_date1[$i].' '.$current_time;
				}
				$frequency_applicable = $freq_check[$i]!=' '?'frequency_applicable':'';
				$krakpiInsert="INSERT INTO krakpi_creation_ref(krakpi_reff_id, rr, criteria, project_id, frequency, frequency_applicable, calendar, from_date, to_date, 
				insert_login_id, kra_category, kpi) VALUES ('".strip_tags($lastid)."', '".strip_tags($rr[$i])."','".strip_tags($criteria[$i])."', 
				'".strip_tags($project_id[$i])."', '".strip_tags($frequency[$i])."', '".strip_tags($frequency_applicable)."', '".strip_tags($calendar[$i])."', 
				'".strip_tags($from_date)."', '".strip_tags($to_date)."', '".strip_tags($userid)."', '".strip_tags($kra_category[$i])."', '".strip_tags($kpi[$i])."' )";
				$insresult=$mysqli->query($krakpiInsert) or die("Error ".$mysqli->error); 
				$lastref_id = $mysqli->insert_id;

				$frqArr = array('Yearly', 'Daily Task');
				if($frequency_applicable == 'frequency_applicable' && $calendar[$i] == "Yes" && !in_array($frequency[$i], $frqArr)){

					if ($frequency[$i] == 'Weekly'){ 

						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}
						
							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+7 days'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+7 days'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}

					} else if ($frequency[$i] == 'Fortnightly'){ 

						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}
						
							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+15 days'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+15 days'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					} else if ($frequency[$i] == 'Monthly'){ 

						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 month'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+1 month'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					} else if ($frequency[$i] == 'Quaterly'){ 

						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}
						
							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+3 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+3 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					} else if ($frequency[$i] == 'Half Yearly'){ 

						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					}

					for($j=0; $j<=sizeof($from_dates)-1; $j++){

						$insertQry="INSERT INTO krakpi_calendar_map(krakpi_id, krakpi_ref_id, kra_category, calendar, from_date, to_date) VALUES ('".strip_tags($lastid)."', 
						'".strip_tags($lastref_id)."', '".strip_tags($kra_category[$i])."', '".strip_tags($calendar[$i])."', '".strip_tags($from_dates[$j].' '.$current_time)."', 
						'".strip_tags($to_dates[$j].' '.$current_time)."' )";
						$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
					} 
				} else if($frequency[$i] == 'Yearly' && $calendar[$i] == "Yes"){

					$insertQry="INSERT INTO krakpi_calendar_map(krakpi_id, krakpi_ref_id, kra_category, calendar, from_date, to_date) VALUES ('".strip_tags($lastid)."', 
					'".strip_tags($lastref_id)."', '".strip_tags($kra_category[$i])."', '".strip_tags($calendar[$i])."', '".strip_tags($from_date)."', '".strip_tags($to_date)."' )";
					$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	

				} else if ($frequency[$i] == 'Daily Task' && $calendar[$i] == "No"){
					//if select Daily Task in frequency then insert record per day for current year. 
					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($current_date));
				
					$from_dates = array();
				
					while ($current_from_date <= $end_of_year ) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}

						if ($current_from_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
						}

						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 DAY'));
					
						if ($current_from_date > $end_of_year ) {
							break;
						}
					}//While END.

					for($a=0; $a <count($from_dates); $a++){

						$insertQry="INSERT INTO krakpi_calendar_map(krakpi_id, krakpi_ref_id, kra_category, calendar, from_date, to_date) VALUES ('".strip_tags($lastid)."', 
						'".strip_tags($lastref_id)."', '".strip_tags($kra_category[$i])."', '".strip_tags($calendar[$i])."', '".strip_tags($from_dates[$a].' '.$current_time)."', 
						'".strip_tags($from_dates[$a].' '.$current_time)."' )";
						$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
					} 

				}
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
                    $frequency_applicable[]           = $row1->frequency_applicable;
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
                $detailrecords['frequency'] = $frequency;
                $detailrecords['frequency_applicable'] = $frequency_applicable;
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
                $detailrecords['frequency_applicable']     = array();
                $detailrecords['calendar']     = array();
                $detailrecords['from_date']     = array();
                $detailrecords['to_date']     = array();
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

			if(isset($_POST['freq_check'])){
				$freq_check = explode(',',$_POST['freq_check']);
			}

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');
			$current_date = date('Y-m-d');

            $updateQry = 'UPDATE krakpi_creation SET company_name = "'.strip_tags($company_name).'", department = "'.strip_tags($department).'", 
			designation = "'.strip_tags($designation).'", status = "0" WHERE krakpi_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
            $res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error);

            $DeleterrRef = $mysqli->query("DELETE FROM krakpi_creation_ref WHERE krakpi_reff_id = '".$id."' ");
            $DeleterCalendar = $mysqli->query("DELETE FROM krakpi_calendar_map WHERE krakpi_id = '".$id."' ");

			// select holiday
			$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
			$res9 = $mysqli->query($getqry9);
			$holiday_dates = [];
			while ($row9 = $res9->fetch_assoc()) {
				$holiday_dates[] = $row9["holiday_date"];
			}
			
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
				$frequency_applicable = ($freq_check[$i]!=' ')?'frequency_applicable':'';
				$rrUpdaet = "INSERT INTO krakpi_creation_ref(krakpi_reff_id, rr, criteria, project_id, frequency, frequency_applicable, calendar, from_date, to_date, 
				insert_login_id, kra_category, kpi)VALUES('".strip_tags($id)."', '".strip_tags($rr[$i])."', '".strip_tags($criteria[$i])."', 
				'".strip_tags($project_id[$i])."', '".strip_tags($frequency[$i])."', '".strip_tags($frequency_applicable)."', '".strip_tags($calendar[$i])."', 
				'".strip_tags($from_date)."', '".strip_tags($to_date)."', '".strip_tags($userid)."', '".strip_tags($kra_category[$i])."', '".strip_tags($kpi[$i])."')";  
				$updresult = $mysqli->query($rrUpdaet)or die ("Error in in update Query!.".$mysqli->error);
				$lastref_id = $mysqli->insert_id;

				$frqArr = array('Yearly', 'Daily Task');
				if($frequency_applicable == 'frequency_applicable' && $calendar[$i] == "Yes" && !in_array($frequency[$i], $frqArr)){

						if ($frequency[$i] == 'Weekly'){ 
	
							$end_of_year = date('Y-12-31');
							$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
							$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
						
							$from_dates = array();
							$to_dates = array();
						
							while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
								// Check if current_from_date is a Sunday or holiday
								while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
									$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
								}
								
								// Check if current_to_date is a Sunday or holiday
								while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
									$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
								}
							
								if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
								$from_dates[] = $current_from_date;
								$to_dates[] = $current_to_date;
								}
							
								$current_from_date = date('Y-m-d', strtotime($current_from_date . '+7 days'));
								$current_to_date = date('Y-m-d', strtotime($current_to_date . '+7 days'));
							
								if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
									break;
								}
							}
	
						} else if ($frequency[$i] == 'Fortnightly'){ 

						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+15 days'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+15 days'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					} else if ($frequency[$i] == 'Monthly'){ 

						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}

							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}
							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 month'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+1 month'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					} else if ($frequency[$i] == 'Quaterly'){ 

						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+3 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+3 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					} else if ($frequency[$i] == 'Half Yearly'){ 

						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date1[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date1[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					}

					for($j=0; $j<=sizeof($from_dates)-1; $j++){

						$insertQry="INSERT INTO krakpi_calendar_map(krakpi_id, krakpi_ref_id, kra_category, calendar, from_date, to_date) VALUES ('".strip_tags($id)."', 
						'".strip_tags($lastref_id)."', '".strip_tags($kra_category[$i])."', '".strip_tags($calendar[$i])."', '".strip_tags($from_dates[$j].' '.$current_time)."', 
						'".strip_tags($to_dates[$j].' '.$current_time)."' )";
						$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
					} 

				} else if($frequency[$i] == 'Yearly' && $calendar[$i] == "Yes"){

					$insertQry="INSERT INTO krakpi_calendar_map(krakpi_id, krakpi_ref_id, kra_category, calendar, from_date, to_date) VALUES ('".strip_tags($id)."', 
					'".strip_tags($lastref_id)."', '".strip_tags($kra_category[$i])."', '".strip_tags($calendar[$i])."', '".strip_tags($from_date)."', '".strip_tags($to_date)."' )";
					$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);

				} else if ($frequency[$i] == 'Daily Task' && $calendar[$i] == "No"){
					//if select Daily Task in frequency then insert record per day for current year. 
					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($current_date));
				
					$from_dates = array();
				
					while ($current_from_date <= $end_of_year ) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}

						if ($current_from_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
						}

						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 DAY'));
					
						if ($current_from_date > $end_of_year ) {
							break;
						}
					}//While END.

					for($a=0; $a <count($from_dates); $a++){

						$insertQry="INSERT INTO krakpi_calendar_map(krakpi_id, krakpi_ref_id, kra_category, calendar, from_date, to_date) VALUES ('".strip_tags($id)."', 
						'".strip_tags($lastref_id)."', '".strip_tags($kra_category[$i])."', '".strip_tags($calendar[$i])."', '".strip_tags($from_dates[$a].' '.$current_time)."', 
						'".strip_tags($from_dates[$a].' '.$current_time)."' )";
						$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
					} 

				}
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

                $qry2="INSERT INTO audit_checklist_ref(audit_area_id, major_area, assertion)
				VALUES('".strip_tags($audit_area_id)."', '".strip_tags($major[$i])."', '".strip_tags($assertion[$i])."' )";
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
			if(isset($_POST['kra_creation_ref_id'])){
				$kra_creation_ref_id = $_POST['kra_creation_ref_id'];
			}
			if(isset($_POST['kra_creation_ref_id_deleted'])){
				$kra_creation_ref_id_deleted = $_POST['kra_creation_ref_id_deleted'];
			}
		
			$kraUpdaet = "UPDATE kra_creation SET company_id = '".strip_tags($company_id)."', designation_id = '".strip_tags($designation)."', 
			department_id='".strip_tags($department)."', update_login_id='".strip_tags($userid)."', status = '0' WHERE kra_id= '".strip_tags($id)."' ";
			$updresult = $mysqli->query($kraUpdaet )or die ("Error in in update Query!.".$mysqli->error);
			
			for($a=0; $a < count($kra_creation_ref_id_deleted); $a++){
				$deleteKraRef = $mysqli->query("DELETE FROM kra_creation_ref WHERE kra_creation_ref_id = '".$kra_creation_ref_id_deleted[$a]."' "); 
			} 

			for($i=0; $i<=sizeof($kra_category)-1; $i++){

				if($kra_creation_ref_id[$i] != ''){
					$kraUpdaet = "UPDATE `kra_creation_ref` SET `kra_category`='".$kra_category[$i]."',`weightage`='".$weightage[$i]."' WHERE `kra_creation_ref_id`='".$kra_creation_ref_id[$i]."' ";
					$updresult = $mysqli->query($kraUpdaet)or die ("Error in in update Query!.".$mysqli->error);
					
				}else{
					$kraUpdaet = "INSERT INTO kra_creation_ref(kra_category, weightage, kra_id) 
					VALUES('".strip_tags($kra_category[$i])."',  '".strip_tags($weightage[$i])."', '".strip_tags($id)."')";
					$updresult = $mysqli->query($kraUpdaet)or die ("Error in in update Query!.".$mysqli->error);
					
				}
			} 

	 	}

		//  Delete kra
		public function deleteKraCreation($mysqli, $id, $userid){

			$kraDelete = "UPDATE kra_creation set status='1', delete_login_id='".strip_tags($userid)."' WHERE kra_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($kraDelete) or die("Error in delete query".$mysqli->error);
		}

		// get kra category
		public function kraCategoryDepartmentBased($mysqli, $designation) {

			$qry = "SELECT kra_creation_ref_id, kra_category FROM kra_creation_ref LEFT JOIN kra_creation ON kra_creation_ref.kra_id = kra_creation.kra_id 
			WHERE kra_creation.designation_id = '".$designation."' AND kra_creation.status = 0 ";
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
			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}
			$insertQry="INSERT INTO assign_work(company_id,created_date) VALUES('".strip_tags($company_id)."', current_timestamp()  )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
				
			$lastid = $mysqli->insert_id;
			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			for($i=0;$i < count($department_id);$i++){
				
				if($frequency_applicable[$i] == 'frequency_applicable' && $frequency_applicable[$i] != ''){ 
					
					// select holiday
					$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
					$res9 = $mysqli->query($getqry9);
					$holiday_dates = [];
					while ($row9 = $res9->fetch_assoc()) {
						$holiday_dates[] = $row9["holiday_date"];
					}

					if($frequency[$i] == 'Weekly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}
							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+7 days'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+7 days'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
		
					} else if($frequency[$i] == 'Fortnightly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}
							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+15 days'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+15 days'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
		
					} else if($frequency[$i] == 'Monthly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}

							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+1 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
		
					}  else if($frequency[$i] == 'Quaterly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+3 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+3 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
						
					} else if($frequency[$i] == 'Half Yearly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					} 
		
					for($j=0; $j<count($from_dates); $j++){
						$insertQry="INSERT INTO assign_work_ref(assign_work_reff_id, department_id, work_des, work_des_text, frequency, frequency_applicable, designation_id, from_date, to_date) VALUES('".strip_tags($lastid)."', '".strip_tags($department_id[$i])."', '".strip_tags($work_des_id[$i])."','".strip_tags($work_des_text[$i])."', '".strip_tags($frequency[$i])."', '".strip_tags($frequency_applicable[$i])."', '".strip_tags($designation[$i])."', '".strip_tags($from_dates[$j].' '.$current_time)."', '".strip_tags($to_dates[$j].' '.$current_time)."' )";
						$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
					} 
					
				} else {
			
					$insertQry="INSERT INTO assign_work_ref(assign_work_reff_id, department_id, work_des, work_des_text, frequency, frequency_applicable, designation_id, from_date, to_date)
				VALUES('".strip_tags($lastid)."', '".strip_tags($department_id[$i])."', '".strip_tags($work_des_id[$i])."','".strip_tags($work_des_text[$i])."', '".strip_tags($frequency[$i])."', '".strip_tags($frequency_applicable[$i])."', '".strip_tags($designation[$i])."', '".strip_tags($from_date[$i].' '.$current_time)."', '".strip_tags($to_date[$i].' '.$current_time)."' )";
				$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
				}
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
			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}
			
			$updateqry = "UPDATE assign_work set status = 0 where work_id = '".$id."' ";
			$updres = $mysqli->query($updateqry) or die("Error ");

			$delRef = "DELETE FROM assign_work_ref where assign_work_reff_id = '".strip_tags($id)."' ";
			$delres = $mysqli->query($delRef) or die('unable to update');

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');
			
			for($i=0;$i<=sizeof($department_id)-1;$i++){

				if($frequency_applicable[$i] == 'frequency_applicable' && $frequency_applicable[$i] != ''){ 
					
					// select holiday
					$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
					$res9 = $mysqli->query($getqry9);
					$holiday_dates = [];
					while ($row9 = $res9->fetch_assoc()) {
						$holiday_dates[] = $row9["holiday_date"];
					}

					if($frequency[$i] == 'Weekly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}
							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+7 days'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+7 days'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
		
					} else if($frequency[$i] == 'Fortnightly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}
							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+15 days'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+15 days'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
		
					} else if($frequency[$i] == 'Monthly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}

							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+1 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
		
					}  else if($frequency[$i] == 'Quaterly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+3 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+3 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
						
					} else if($frequency[$i] == 'Half Yearly'){
			
						$end_of_year = date('Y-12-31');
						$current_from_date = date('Y-m-d', strtotime($from_date[$i]));
						$current_to_date = date('Y-m-d', strtotime($to_date[$i]));
					
						$from_dates = array();
						$to_dates = array();
					
						while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
							// Check if current_from_date is a Sunday or holiday
							while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
								$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
							}
							
							// Check if current_to_date is a Sunday or holiday
							while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
								$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
							}
						
							if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
							$from_dates[] = $current_from_date;
							$to_dates[] = $current_to_date;
							}

							$current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
							$current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
						
							if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
								break;
							}
						}
					} 
		
					for($j=0; $j<count($from_dates); $j++){
						$insertQry="INSERT INTO assign_work_ref(assign_work_reff_id, department_id, work_des, work_des_text, frequency, frequency_applicable, designation_id, from_date, to_date) VALUES('".strip_tags($id)."', '".strip_tags($department_id[$i])."', '".strip_tags($work_des_id[$i])."','".strip_tags($work_des_text[$i])."', '".strip_tags($frequency[$i])."', '".strip_tags($frequency_applicable[$i])."', '".strip_tags($designation[$i])."', '".strip_tags($from_dates[$j].' '.$current_time)."', '".strip_tags($to_dates[$j].' '.$current_time)."' )";
						$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
					} 
					
				} else {
					$updQry="INSERT INTO assign_work_ref(assign_work_reff_id, department_id, work_des, work_des_text, frequency, frequency_applicable, designation_id, from_date, to_date)
					VALUES('".strip_tags($id)."', '".$department_id[$i]."', '".$work_des_id[$i]."','".$work_des_text[$i]."', '".strip_tags($frequency[$i])."', '".strip_tags($frequency_applicable[$i])."', '".$designation[$i]."', '".$from_date[$i].' '.$current_time."', '".$to_date[$i].' '.$current_time."' )";
					$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
				}
			}
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
			
			$getQry = "SELECT * FROM assign_work_ref where assign_work_reff_id= '".$id."'  group by work_des"; 
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
					$detailrecords[$j]['from_date']      = $row->from_date;		
					$detailrecords[$j]['to_date']      = $row->to_date;		
					$detailrecords[$j]['frequency']      = $row->frequency;		
					$detailrecords[$j]['frequency_applicable']      = $row->frequency_applicable;		
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
			if(isset($_POST['asset_autoid'])){
				$asset_autoid = $_POST['asset_autoid'];
			}
			if(isset($_POST['asset_name'])){
				$asset_name = $_POST['asset_name'];
			}
			if(isset($_POST['vendor_name'])){
				$vendor_name = $_POST['vendor_name'];
			}
			if(isset($_POST['dop'])){
				$dop = $_POST['dop'];
			}
			if(isset($_POST['nature'])){
				$asset_nature_id = $_POST['nature'];
			}
			if(isset($_POST['depreciation_rate'])){
				$depreciation_rate = $_POST['depreciation_rate'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['check_list'])){
				$maintenance = $_POST['check_list'];
			}

			$insertQry="INSERT INTO asset_register(company_id, asset_classification,asset_autoGen_id,asset_name,vendor_id,dop,asset_nature,depreciation_rate,asset_value,maintenance, created_date, insert_login_id) VALUES ('".strip_tags($company_id)."', '".strip_tags($asset_class_id)."', '".strip_tags($asset_autoid)."','".strip_tags($asset_name)."','".strip_tags($vendor_name)."','".$dop."','".strip_tags($asset_nature_id)."','".strip_tags($depreciation_rate)."','".strip_tags($asset_value)."', '".strip_tags($maintenance)."', CURRENT_TIMESTAMP(), '".$userid."' )";
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
			if(isset($_POST['vendor_name'])){
				$vendor_name = $_POST['vendor_name'];
			}
			if(isset($_POST['dop'])){
				$dop = $_POST['dop'];
			}
			if(isset($_POST['nature'])){
				$asset_nature_id = $_POST['nature'];
			}
			if(isset($_POST['depreciation_rate'])){
				$depreciation_rate = $_POST['depreciation_rate'];
			}
			if(isset($_POST['asset_value'])){
				$asset_value = $_POST['asset_value'];
			}
			if(isset($_POST['check_list'])){
				$maintenance = $_POST['check_list'];
			}

			$updQry="UPDATE asset_register set company_id = '".strip_tags($company_id)."', asset_classification = '".strip_tags($asset_class_id)."', asset_name = '".strip_tags($asset_name)."',vendor_id = '".strip_tags($vendor_name)."', dop = '".strip_tags($dop)."', asset_nature = '".strip_tags($asset_nature_id)."', depreciation_rate = '".strip_tags($depreciation_rate)."' , asset_value = '".strip_tags($asset_value)."', maintenance = '".strip_tags($maintenance)."', status = 0 , updated_date = CURRENT_TIMESTAMP(), update_login_id = '".strip_tags($userid)."' WHERE asset_id = '".strip_tags($id)."' ";
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
				$detailrecords['asset_autoGen_id']      = $row->asset_autoGen_id;		
				$detailrecords['asset_name']      = $row->asset_name;		
				$detailrecords['vendor_id']      = $row->vendor_id;		
				$detailrecords['dop']      = $row->dop;		
				$detailrecords['asset_nature']      = $row->asset_nature;		
				$detailrecords['depreciation_rate']      = $row->depreciation_rate;		
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
			if(isset($_POST['policy_company'])){
				$policy_company = $_POST['policy_company'];
			}
			if(isset($_POST['policy_number'])){
				$policy_number = $_POST['policy_number'];
			}
			$policy_upload = '';
			if(!empty($_FILES['policy_upload']['name']))
			{
				$policy_upload = $_FILES['policy_upload']['name'];
				$report_file_temp = $_FILES['policy_upload']['tmp_name'];
				$reportimage_folder="uploads/insurance_policy/".$policy_upload ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}else{
				$policy_upload = $_POST['policy_upload_upd'];
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
			if(isset($_POST['calendar'])){
				$calendar = $_POST['calendar'];
			}
			if(isset($_POST['from_date'])){
				$from_date1 = $_POST['from_date'];
			}
			if(isset($_POST['to_date'])){
				$to_date1 = $_POST['to_date'];
			}
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}else{
				$frequency_applicable = '';
			}

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			if($calendar == "No"){
				$from_date = '';
				$to_date = '';
			} else {
				$from_date = $from_date1.' '.$current_time;
				$to_date = $to_date1.' '.$current_time;
			}

			$insertQry="INSERT INTO insurance_register(company_id, insurance_id, policy_company, policy_number, policy_upload, dept_id, freq_id, department_id, designation_id, calendar, from_date, to_date, frequency_applicable, created_date) VALUES ('".strip_tags($company_id)."','".strip_tags($insurance_id)."', '".strip_tags($policy_company)."', '".strip_tags($policy_number)."', '".strip_tags($policy_upload)."', '".strip_tags($dept_id)."', '".strip_tags($freq_id)."', 
			'".strip_tags($department_id)."', '".strip_tags($designation_id)."', '".strip_tags($calendar)."', '".strip_tags($from_date)."', 
			'".strip_tags($to_date)."', '".strip_tags($frequency_applicable)."', current_timestamp() )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
			$last_id  = $mysqli->insert_id;
		
			// select holiday
			$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
			$res9 = $mysqli->query($getqry9);
			$holiday_dates = [];
			while ($row9 = $res9->fetch_assoc()) {
				$holiday_dates[] = $row9["holiday_date"];
			}

			if($frequency_applicable == 'frequency_applicable'){

				if ($freq_id == 1) {

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}

						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}
	
					for($i=0; $i<=sizeof($from_dates)-1; $i++){
	
						$insertQry="INSERT INTO insurance_register_ref(ins_reg_id, company_id, insurance_id, policy_company, policy_number, policy_upload, dept_id, freq_id, department_id, designation_id, calendar, from_date, to_date, created_date) VALUES ('".strip_tags($last_id)."', '".strip_tags($company_id)."', '".strip_tags($insurance_id)."', '".strip_tags($policy_company)."', '".strip_tags($policy_number)."', '".strip_tags($policy_upload)."', '".strip_tags($dept_id)."', '".strip_tags($freq_id)."', '".strip_tags($department_id)."', '".strip_tags($designation_id)."', '".strip_tags($calendar)."', '".strip_tags($from_dates[$i].' '.$current_time)."', '".strip_tags($to_dates[$i].' '.$current_time)."', current_timestamp() )";
						$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
					} 
				} 
			} else {

				$insertQry="INSERT INTO insurance_register_ref(ins_reg_id, company_id, insurance_id, policy_company, policy_number, policy_upload, dept_id, freq_id, department_id, designation_id, calendar, from_date, to_date, created_date) VALUES ('".strip_tags($last_id)."', '".strip_tags($company_id)."', '".strip_tags($insurance_id)."', '".strip_tags($policy_company)."', '".strip_tags($policy_number)."', '".strip_tags($policy_upload)."', '".strip_tags($dept_id)."', '".strip_tags($freq_id)."', '".strip_tags($department_id)."', '".strip_tags($designation_id)."', '".strip_tags($calendar)."', '".strip_tags($from_date)."',	'".strip_tags($to_date)."', current_timestamp() )";
				$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			}

		}

		// Update Insurance Register
		public function updateInsuranceRegister($mysqli,$id){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['ins_name'])){
				$insurance_id = $_POST['ins_name'];
			}
			if(isset($_POST['policy_company'])){
				$policy_company = $_POST['policy_company'];
			}
			if(isset($_POST['policy_number'])){
				$policy_number = $_POST['policy_number'];
			}
			$policy_upload = '';
			if(!empty($_FILES['policy_upload']['name']))
			{
				$policy_upload = $_FILES['policy_upload']['name'];
				$report_file_temp = $_FILES['policy_upload']['tmp_name'];
				$reportimage_folder="uploads/insurance_policy/".$policy_upload ;
				move_uploaded_file($report_file_temp, $reportimage_folder);
			}else{
				$policy_upload = $_POST['policy_upload_upd'];
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
			if(isset($_POST['calendar'])){
				$calendar = $_POST['calendar'];
			}
			if(isset($_POST['from_date'])){
				$from_date1 = $_POST['from_date'];
			}
			if(isset($_POST['to_date'])){
				$to_date1 = $_POST['to_date'];
			}
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}else{
				$frequency_applicable = '';
			}
			
			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			if($calendar == "No"){
				$from_date = '';
				$to_date = '';
			} else {
				$from_date = $from_date1.' '.$current_time;
				$to_date = $to_date1.' '.$current_time;
			}

			$updQry="UPDATE insurance_register set company_id = '".strip_tags($company_id)."', insurance_id = '".strip_tags($insurance_id)."', policy_company='".strip_tags($policy_company)."',policy_number='".strip_tags($policy_number)."',policy_upload='".strip_tags($policy_upload)."', dept_id = '".strip_tags($dept_id)."', freq_id = '".strip_tags($freq_id)."', department_id = '".strip_tags($department_id)."', designation_id = '".strip_tags($designation_id)."', calendar = '".strip_tags($calendar)."', from_date = '".strip_tags($from_date)."', to_date = '".strip_tags($to_date)."', frequency_applicable = '".strip_tags($frequency_applicable)."', status = 0 WHERE ins_reg_id  = '".strip_tags($id)."' ";
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);

			// delete insurance ref
			$DeleterrRef = $mysqli->query("DELETE FROM insurance_register_ref WHERE ins_reg_id = '".$id."' ");

			// select holiday
			$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
			$res9 = $mysqli->query($getqry9);
			$holiday_dates = [];
			while ($row9 = $res9->fetch_assoc()) {
				$holiday_dates[] = $row9["holiday_date"];
			}

			if($frequency_applicable == 'frequency_applicable'){

				if ($freq_id == 1) {

					$end_of_year = date('Y-12-31');
					$current_from_date = date('Y-m-d', strtotime($from_date1));
					$current_to_date = date('Y-m-d', strtotime($to_date1));
				
					$from_dates = array();
					$to_dates = array();
				
					while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) {
						// Check if current_from_date is a Sunday or holiday
						while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
							$current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
						}
						
						// Check if current_to_date is a Sunday or holiday
						while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
							$current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
						}
					
						if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
						$from_dates[] = $current_from_date;
						$to_dates[] = $current_to_date;
						}
					
						$current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
						$current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
					
						if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
							break;
						}
					}

					for($i=0; $i<=sizeof($from_dates)-1; $i++){

						$insertQry="INSERT INTO insurance_register_ref(ins_reg_id, company_id, insurance_id, policy_company, policy_number, policy_upload, dept_id, freq_id, department_id, designation_id, calendar, from_date, to_date, created_date) VALUES ('".strip_tags($id)."', '".strip_tags($company_id)."', '".strip_tags($insurance_id)."', '".strip_tags($policy_company)."', '".strip_tags($policy_number)."', '".strip_tags($policy_upload)."', '".strip_tags($dept_id)."', '".strip_tags($freq_id)."', '".strip_tags($department_id)."', '".strip_tags($designation_id)."', '".strip_tags($calendar)."', '".strip_tags($from_dates[$i].' '.$current_time)."', '".strip_tags($to_dates[$i].' '.$current_time)."', current_timestamp() )";
						$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
					} 
				} 
			} else {

				$insertQry="INSERT INTO insurance_register_ref(ins_reg_id, company_id, insurance_id, policy_company, policy_number, policy_upload, dept_id, freq_id, department_id, designation_id, calendar, from_date, to_date, created_date) VALUES ('".strip_tags($id)."', '".strip_tags($company_id)."', '".strip_tags($insurance_id)."', '".strip_tags($policy_company)."', '".strip_tags($policy_number)."', '".strip_tags($policy_upload)."', '".strip_tags($dept_id)."', '".strip_tags($freq_id)."', '".strip_tags($department_id)."', '".strip_tags($designation_id)."', '".strip_tags($calendar)."', '".strip_tags($from_date)."',	'".strip_tags($to_date)."', current_timestamp() )";
				$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			}
		}
		
		// get Insurance creation Table
		public function getInsuranceRegisterTable($mysqli,$id) {

			$qry = "SELECT * FROM insurance_register WHERE ins_reg_id  = '".$id."' ORDER BY ins_reg_id ASC"; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			$i=0;
			if($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$detailrecords[$i]['ins_reg_id'] = $row->ins_reg_id;
					$detailrecords[$i]['company_id'] = $row->company_id;
					$detailrecords[$i]['insurance_id']= $row->insurance_id;
					$detailrecords[$i]['policy_company']= $row->policy_company;
					$detailrecords[$i]['policy_number']= $row->policy_number;
					$detailrecords[$i]['policy_upload']= $row->policy_upload;
					$detailrecords[$i]['dept_id']= $row->dept_id;
					$detailrecords[$i]['freq_id']= $row->freq_id;
					$detailrecords[$i]['department_id']= $row->department_id;
					$detailrecords[$i]['designation_id']= $row->designation_id;
					$detailrecords[$i]['staff_id']= $row->staff_id;
					$detailrecords[$i]['calendar']= $row->calendar;
					$detailrecords[$i]['from_date']= $row->from_date;
					$detailrecords[$i]['to_date']= $row->to_date;
					$detailrecords[$i]['frequency_applicable']= $row->frequency_applicable;
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

			if(isset($_POST['work_des'])){
				$work_des = $_POST['work_des'];
			}
			if(isset($_POST['work_des'])){
				$work_des = $_POST['work_des'];
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
			
			$insertQry="INSERT INTO todo_creation( work_des, priority, assign_to, from_date, to_date, criteria, project_id, created_date, created_id)
			VALUES( '".strip_tags($work_des)."','".strip_tags($priority_id)."', '".strip_tags($assign_to_id)."', 
			'".strip_tags($from_date)."', '".strip_tags($to_date)."', '".strip_tags($criteria)."','".strip_tags($project_id)."', current_timestamp(), '".$userid."' )"; 
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		// Update Todo 
		 public function updateTodo($mysqli,$id,$userid){

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			if(isset($_POST['work_des'])){
				$work_des = $_POST['work_des'];
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

			$updQry="UPDATE todo_creation set  work_des = '".strip_tags($work_des)."', priority = '".strip_tags($priority_id)."', assign_to = '".strip_tags($assign_to_id)."', from_date = '".strip_tags($from_date)."', to_date = '".strip_tags($to_date)."', 
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
				$detailrecords['todo_id']      = $row->todo_id; 		
				$detailrecords['work_des']      = $row->work_des;			
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
				$detailrecords['update_attachment']      = $row->update_attachment;			
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

		// Get Assign Employee table
        public function getAssignEmployeeName($mysqli, $to_department){

            $getQry = "SELECT * FROM staff_creation WHERE department ='".strip_tags($to_department)."' AND status = 0 ";
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

		// get initial_phase based final_phase
		public function getInitialFinalPhase($mysqli, $staff_id){
			$detailrecords = array();
			$getStaffDetails = $mysqli->query("SELECT staff_id,staff_name FROM staff_creation WHERE staff_id = '".strip_tags($staff_id)."'");
			if(mysqli_num_rows($getStaffDetails)>0){
				$staffdetails = $getStaffDetails->fetch_assoc();
				$detailrecords['staff_id'] = $staffdetails['staff_id'];
				$detailrecords['staff_name'] = $staffdetails['staff_name'];
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
				$detailrecords[$j]['assign_to'] = '';  
				$to_date = $row12["to_date"];
				$detailrecords[$j]['to_date'] = $to_date ;  
				
				$detailrecords[$j]['designation_id'] = $row12["designation_id"];  
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
			}
			return $detailrecords; 
		}


		// get company and branch name based on session id
		public function getsCompanyBranchDetail($mysqli, $sbranch_id){
            $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$sbranch_id."' AND status=0 ORDER BY branch_id ASC";
            $res = $mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);

            $detailrecords = array();
            $i=0;
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object())
                {
					
					$detailrecords['branch_id']          = strip_tags($row->branch_id);
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

		// get company and branch name based on session id
		public function getCompanyBranchDetail($mysqli, $branch_id){
			$qry = "SELECT * FROM branch_creation WHERE branch_id = '".$branch_id."' AND status=0 ORDER BY branch_id ASC";
			$res = $mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);

			$detailrecords = array();
			$i=0;
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					
					$detailrecords['branch_id']          = strip_tags($row->branch_id);
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

		// get company and branch name based on session id
		public function getsBranchBasedCompanyName($mysqli, $sbranch_id){
            $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$sbranch_id."' AND status=0 ORDER BY branch_id ASC";
            $res = $mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);

            $detailrecords = array();
            $i=0;
            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object())
                {
					
					$detailrecords['branch_id']          = strip_tags($row->branch_id);
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
			if(isset($_POST['asset_id'])){
				$asset_id = $_POST['asset_id'];
			}
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
			if(isset($_POST['asset_location'])){
				$asset_location = $_POST['asset_location'];
			}
			if(isset($_POST['asset_count'])){
				$asset_count = $_POST['asset_count'];
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
			
			
			$insertQry="INSERT INTO asset_details(asset_register_id, company_id, branch_id, classification, asset_name, asset_value, dou, depreciation, asset_location, asset_count, spare_names, created_date) VALUES('".strip_tags($asset_id)."', '".strip_tags($company_id)."', '".strip_tags($branch_id)."', '".strip_tags($asset_class)."', '".strip_tags($asset_name)."', '".strip_tags($asset_value)."', '".strip_tags($put_to)."', '".strip_tags($depreciation)."', '".strip_tags($asset_location)."', '".strip_tags($asset_count)."', '".strip_tags($spare_names)."', current_timestamp() )";
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

			if(isset($_POST['asset_id'])){
				$asset_id = $_POST['asset_id'];
			}
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
			if(isset($_POST['asset_location'])){
				$asset_location = $_POST['asset_location'];
			}
			if(isset($_POST['asset_count'])){
				$asset_count = $_POST['asset_count'];
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
			
			
			$updateQry="UPDATE asset_details set asset_register_id = '".strip_tags($asset_id)."', company_id = '".strip_tags($company_id)."', branch_id = '".strip_tags($branch_id)."', classification ='".strip_tags($asset_class)."', asset_name = '".strip_tags($asset_name)."', asset_value = '".strip_tags($asset_value)."', dou = '".strip_tags($put_to)."', depreciation = '".strip_tags($depreciation)."', asset_location = '".strip_tags($asset_location)."',  asset_count = '".strip_tags($asset_count)."', spare_names= '".strip_tags($spare_names)."', status = 0 WHERE asset_details_id = '".$id."' ";
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
			$row12 = $res12->fetch_assoc();
				$detailrecords['asset_details_id'] = $row12["asset_details_id"];  
				$detailrecords['asset_register_id'] = $row12["asset_register_id"];  
				$detailrecords['company_id'] = $row12["company_id"];  
				$detailrecords['branch_id'] = $row12["branch_id"];  
				$detailrecords['classification'] = $row12["classification"];  
				$detailrecords['asset_name'] = $row12["asset_name"];  
				$detailrecords['asset_value'] = $row12["asset_value"];  
				$detailrecords['dou'] = $row12["dou"];  
				$detailrecords['depreciation'] = $row12["depreciation"];  
				$detailrecords['as_on'] = $row12["as_on"];  
				$detailrecords['asset_location'] = $row12["asset_location"];  
				$detailrecords['asset_count'] = $row12["asset_count"];  
				$detailrecords['spare_names'] = $row12["spare_names"];  
				$j++;
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
			if(isset($_POST['company_to'])){
				$company_to = $_POST['company_to'];
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
			if(isset($_POST['rgp_staff'])){
				$rgp_staff = $_POST['rgp_staff'];
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
			
			
			$insertQry="INSERT INTO rgp_creation(rgp_date,return_date,asset_class,company_id,branch_from,company_to,branch_to,from_comm_line1,from_comm_line2,to_comm_line1,to_comm_line2, rgp_staff_id, asset_name_id,asset_value,reason_rgp,created_date)
			VALUES('".strip_tags($rgp_date)."', '".strip_tags($return_date)."', '".strip_tags($asset_class)."', 
			'".strip_tags($company_id)."', '".strip_tags($branch_from)."','".strip_tags($company_to)."', '".strip_tags($branch_to)."', '".strip_tags($from_comm_line1)."', '".strip_tags($from_comm_line2)."', 
			'".strip_tags($to_comm_line1)."','".strip_tags($to_comm_line2)."','".strip_tags($rgp_staff)."','".strip_tags($asset_name)."','".strip_tags($asset_value)."', '".strip_tags($reason_rgp)."',current_timestamp() )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			$lastId = $mysqli->insert_id;
			
			$insertAsset = "UPDATE asset_register set rgp_status ='inward' where asset_id = '" . strip_tags($asset_name) . "' ";
			$insassetresult=$mysqli->query($insertAsset) or die("Error ".$mysqli->error);
			
			return $lastId;
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
			$detailrecords1['company_to'] = $row12["company_to"];  
			$detailrecords1['branch_to'] = $row12["branch_to"];  
			$detailrecords1['company_id'] = $row12["company_id"];  
			$detailrecords1['from_comm_line1'] = $row12["from_comm_line1"];  
			$detailrecords1['from_comm_line2'] = $row12["from_comm_line2"];  
			$detailrecords1['to_comm_line1'] = $row12["to_comm_line1"];  
			$detailrecords1['to_comm_line2'] = $row12["to_comm_line2"];  
			$detailrecords1['rgp_staff_id'] = $row12["rgp_staff_id"];  
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

			for($j=0; $j<sizeof($designation); $j++){				
				$getDepartmentName = $mysqli->query("SELECT designation_id, designation_name FROM designation_creation WHERE designation_id ='".strip_tags($designation[$j])."' AND status = 0");
				if ($mysqli->affected_rows>0){
					$row2 = $getDepartmentName->fetch_object();
						$detailrecords[$j]['designation_id'] = $row2->designation_id; 
						$detailrecords[$j]['designation_name'] = $row2->designation_name;       
				}
			}
			
			sort($detailrecords);
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

			if(isset($_POST['reg_auto_gen_no'])){
				$reg_auto_gen_no = $_POST['reg_auto_gen_no'];
			}
			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['mySelectedDeptName'])){
				$department_id = $_POST['mySelectedDeptName'];
			}
			if(isset($_POST['mySelectedStaffId'])){
				$staff_id = $_POST['mySelectedStaffId'];
			}
			if(isset($_POST['mySelectedStaffName'])){
				$staff_name = $_POST['mySelectedStaffName'];
			}
			if(isset($_POST['staff_code'])){
				$staff_code = $_POST['staff_code'];
			}
			if(isset($_POST['reporting'])){
				$reporting = $_POST['reporting'];
			}
			if(isset($_POST['reporting_name'])){
				$reporting_name = $_POST['reporting_name'];
			}
			$res_staff_id='';
			if(isset($_POST['res_staff_id'])){
				$res_staff_id = $_POST['res_staff_id'];
			}
			if(isset($_POST['res_staff_name'])){
				$res_staff_name = $_POST['res_staff_name'];
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
			if(isset($_POST['leave_to_date'])){
				$leave_to_date = $_POST['leave_to_date'];
			}
			if(isset($_POST['leave_reason'])){
				$leave_reason = $_POST['leave_reason'];
			}
			
			$insertQry="INSERT INTO permission_or_on_duty(regularisation_id, company_id, department_id, staff_id, staff_code, reporting, reason, permission_from_time, permission_to_time, permission_date, on_duty_place, leave_date, leave_to_date, leave_reason, responsible_staff, insert_login_id, staff_name, manager_name,responsible_staff_name)
			VALUES('".strip_tags($reg_auto_gen_no)."','".strip_tags($company_id)."', '".strip_tags($department_id)."', '".strip_tags($staff_id)."', '".strip_tags($staff_code)."', '".strip_tags($reporting)."', '".strip_tags($reason)."', '".strip_tags($permission_from_time)."', '".strip_tags($permission_to_time)."', '".strip_tags($permission_date)."', '".strip_tags($on_duty_place)."', '".strip_tags($leave_date)."', '".strip_tags($leave_to_date)."', '".strip_tags($leave_reason)."', '".$res_staff_id."', '".$userid."', '".$staff_name."', '".$reporting_name."', '".$res_staff_name."' )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}

		//Update Permission On Dury
		public function updatePermissionOnDuty($mysqli,$id,$userid){

			if(isset($_POST['reg_auto_gen_no'])){
				$reg_auto_gen_no = $_POST['reg_auto_gen_no'];
			}
			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['mySelectedDeptName'])){
				$department_id = $_POST['mySelectedDeptName'];
			}
			if(isset($_POST['mySelectedStaffId'])){
				$staff_id = $_POST['mySelectedStaffId'];
			}
			if(isset($_POST['mySelectedStaffName'])){
				$staff_name = $_POST['mySelectedStaffName'];
			}
			if(isset($_POST['staff_code'])){
				$staff_code = $_POST['staff_code'];
			}
			if(isset($_POST['reporting'])){
				$reporting = $_POST['reporting'];
			}
			if(isset($_POST['reporting_name'])){
				$reporting_name = $_POST['reporting_name'];
			}
			$res_staff_id='';
			if(isset($_POST['res_staff_id'])){
				$res_staff_id = $_POST['res_staff_id'];
			}
			if(isset($_POST['res_staff_name'])){
				$res_staff_name = $_POST['res_staff_name'];
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
			if(isset($_POST['leave_to_date'])){
				$leave_to_date = $_POST['leave_to_date'];
			}
			if(isset($_POST['leave_reason'])){
				$leave_reason = $_POST['leave_reason'];
			}
			
			$updQry="UPDATE permission_or_on_duty set regularisation_id='".strip_tags($reg_auto_gen_no)."', company_id = '".strip_tags($company_id)."', department_id = '".strip_tags($department_id)."', staff_id = '".strip_tags($staff_id)."', staff_code = '".strip_tags($staff_code)."', reporting = '".strip_tags($reporting)."', reason = '".strip_tags($reason)."', permission_from_time = '".strip_tags($permission_from_time)."', permission_to_time = '".strip_tags($permission_to_time)."', 
			permission_date = '".strip_tags($permission_date)."', on_duty_place = '".strip_tags($on_duty_place)."', leave_date = '".strip_tags($leave_date)."', leave_to_date = '".strip_tags($leave_to_date)."', leave_reason = '".strip_tags($leave_reason)."', status = 0, responsible_staff = '".$res_staff_id."', update_login_id = '".$userid."', staff_name = '".$staff_name."', manager_name = '".$reporting_name."', responsible_staff_name = '".$res_staff_name."' WHERE permission_on_duty_id= '".strip_tags($id)."' "; 
			$updresult=$mysqli->query($updQry) or die("Error ".$mysqli->error);
		}
		// Update Leave Approval
		public function updateApproval($mysqli,$id,$userid){

			if(isset($_POST['id'])){
				$id = $_POST['id'];
			}
			if(isset($_POST['approve_or_reject'])){
				$approve_or_reject = $_POST['approve_or_reject'];
			}
			$reject_reason='';
			if(isset($_POST['reject_reason'])){
				$reject_reason = $_POST['reject_reason'];
			}
			$res_staff_id='';
			if(isset($_POST['res_staff_id'])){
				$res_staff_id = $_POST['res_staff_id'];
			}
			if(isset($_POST['res_staff_name'])){
				$res_staff_name = $_POST['res_staff_name'];
			}
			$updresult=$mysqli->query("UPDATE permission_or_on_duty set leave_status='".strip_tags($approve_or_reject)."', reject_reason = '".strip_tags($reject_reason)."', responsible_staff = '".$res_staff_id."', responsible_staff_name = '".$res_staff_name."' WHERE permission_on_duty_id= '".strip_tags($id)."' ") or die("Error ".$mysqli->error);
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
				$detailrecords['leave_to_date']       = $row->leave_to_date;		
				$detailrecords['leave_reason']       = $row->leave_reason;		
				$detailrecords['regularisation_id']       = $row->regularisation_id;	
				$detailrecords['responsible_staff']       = $row->responsible_staff;	
				
				$getname = $mysqli->query("SELECT staff_name FROM staff_creation WHERE staff_id = '".$row->reporting."' ");
				if ($mysqli->affected_rows>0)
				{
					$report_name = $getname->fetch_assoc();
					$detailrecords['reporting_name'] = $report_name["staff_name"];
				}else{
					$detailrecords['reporting_name'] = '';
				}
			}
			
			return $detailrecords;
		}
		
		//Delete Permission On Dury
		public function deletePermissionOnDuty($mysqli, $id, $userid){
			$deleteQry = "DELETE FROM `permission_or_on_duty` WHERE permission_on_duty_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

		// Add Transfer Location
		public function addTransferLocation($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['departmentid'])){
				$department_id = $_POST['departmentid'];
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
			if(isset($_POST['to_company_id'])){
				$to_company_id = $_POST['to_company_id'];
			}
			if(isset($_POST['to_branch_id'])){
				$to_branch_id = $_POST['to_branch_id'];
			}
			if(isset($_POST['to_department'])){
				$to_department = $_POST['to_department'];
			}
			if(isset($_POST['to_designation'])){
				$to_designation = $_POST['to_designation'];
			}
			if(isset($_POST['tef'])){
				$tef = $_POST['tef'];
			}
			if(isset($_POST['krikpi'])){
				$krikpi = $_POST['krikpi'];
			}
			$file = '';
			if(!empty($_FILES['file']['name']))
			{
				$file = $_FILES['file']['name'];
				$media_file_temp = $_FILES['file']['tmp_name'];
				$mediaimage_folder="uploads/transfer_location/".$file;
				move_uploaded_file($media_file_temp, $mediaimage_folder);
			}
			
			$insertQry="INSERT INTO transfer_location(company_id, department_id, staff_id, staff_code, dot, to_company, transfer_location, to_department, to_designation, transfer_effective_from, file, insert_login_id)
			VALUES('".strip_tags($company_id)."', '".strip_tags($department_id)."', '".strip_tags($staff_name)."', '".strip_tags($staff_code)."', '".strip_tags($dot)."', 
			'".strip_tags($to_company_id)."', '".strip_tags($to_branch_id)."', '".strip_tags($to_department)."', '".strip_tags($to_designation)."', '".strip_tags($tef)."', '".strip_tags($file)."', '".$userid."' )";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			$transfer_id = $mysqli->insert_id;

			$insStaffHistory = $mysqli->query("INSERT INTO `staff_creation_history` ( `transfer_location_id`, `staff_id`, `staff_name`, `company_id`, `designation`, `emp_code`, `department`, `doj`, `krikpi`, `dob`, `key_skills`, `contact_number`, `email_id`, `reporting`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date` ) SELECT ".$transfer_id.", `staff_id`, `staff_name`, `company_id`, `designation`, `emp_code`, `department`, `doj`, `krikpi`, `dob`, `key_skills`, `contact_number`, `email_id`, `reporting`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date` FROM `staff_creation` WHERE `staff_id` = '".$staff_code."' ") or die("Error ".$mysqli->error);

			$updStaffCreation = $mysqli->query("UPDATE `staff_creation` SET `company_id`='".strip_tags($to_branch_id)."',`designation`='".strip_tags($to_designation)."',`department`='".strip_tags($to_department)."',`doj`='".strip_tags($tef)."',`krikpi`='".$krikpi."',`update_login_id`= '".$userid."',`updated_date`= now() WHERE `staff_id` = '".$staff_code."' ") or die("Error ".$mysqli->error);

			$updUser = $mysqli->query("UPDATE `user` SET `branch_id`='".strip_tags($to_branch_id)."',`designation_id`='".strip_tags($to_designation)."' WHERE `staff_id`='".$staff_code."' ") or die("Error ".$mysqli->error);

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
			if(isset($_POST['to_company_id'])){
				$to_company_id = $_POST['to_company_id'];
			}
			if(isset($_POST['to_branch_id'])){
				$to_branch_id = $_POST['to_branch_id'];
			}
			if(isset($_POST['to_department'])){
				$to_department = $_POST['to_department'];
			}
			if(isset($_POST['to_designation'])){
				$to_designation = $_POST['to_designation'];
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
			staff_id = '".strip_tags($staff_name)."', staff_code = '".strip_tags($staff_code)."', dot = '".strip_tags($dot)."', `to_company`='".strip_tags($to_company_id)."',`transfer_location`='".strip_tags($to_branch_id)."',`to_department`='".strip_tags($to_department)."',`to_designation`='".strip_tags($to_designation)."', transfer_effective_from = '".strip_tags($tef)."', file = '".strip_tags($file)."',
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
				$detailrecords['to_company']     = $row->to_company;		
				$detailrecords['transfer_location']     = $row->transfer_location;		
				$detailrecords['to_department']     = $row->to_department;		
				$detailrecords['to_designation']     = $row->to_designation;		
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

			if(isset($_POST['checklist_add'])){
				$checklist = $_POST['checklist_add'];
			}
			if(isset($_POST['type_of_checklist_add'])){
				$type_of_checklist = $_POST['type_of_checklist_add'];
			}
			if(isset($_POST['yes_no_type'])){
				$yes_no_na = $_POST['yes_no_type'];
			}
			if(isset($_POST['no_option_type'])){
				$no_of_option = $_POST['no_option_type'];
			}
			if(isset($_POST['option1_type'])){
				$option1 = $_POST['option1_type'];
			}
			if(isset($_POST['option2_type'])){
				$option2 = $_POST['option2_type'];
			}
			if(isset($_POST['option3_type'])){
				$option3 = $_POST['option3_type'];
			}
			if(isset($_POST['option4_type'])){
				$option4 = $_POST['option4_type'];
			}
			if(isset($_POST['table_rating'])){
				$rating = $_POST['table_rating'];
			} 

			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}

			$insertQry="INSERT INTO pm_checklist(company_id, category_id, frequency, frequency_applicable, insert_login_id) VALUES('".strip_tags($company_id)."', '".strip_tags($category_id)."','".strip_tags($frequency)."', '".strip_tags($frequency_applicable)."', '".strip_tags($userid)."')";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);

			$findMaxId = $mysqli->query("Select max(pm_checklist_id) as max_pm_id from pm_checklist ");
			$maxid = $findMaxId->fetch_assoc();
			$pmChkId = $maxid['max_pm_id'];

			for($i=0; $i < count($checklist); $i++){

				$insertchecklist =$mysqli->query("INSERT INTO `pm_checklist_multiple`(`pm_checklist_id`, `checklist`, `type_of_checklist`, `yes_no_na`, `no_of_option`, `option1`, `option2`, `option3`, `option4`, `rating`, `insert_login_id`, `created_date`) VALUES ('".strip_tags($pmChkId)."','".strip_tags($checklist[$i])."','".strip_tags($type_of_checklist[$i])."','".strip_tags($yes_no_na[$i])."','".strip_tags($no_of_option[$i])."','".strip_tags($option1[$i])."','".strip_tags($option2[$i])."','".strip_tags($option3[$i])."','".strip_tags($option4[$i])."','".strip_tags($rating[$i])."', '".strip_tags($userid)."', now() )") or die("Error ".$mysqli->error);

			}
		}

		// Get PM Checklist
		public function getPMChecklist($mysqli, $id){

			$selectQry = "SELECT * FROM pm_checklist WHERE pm_checklist_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
			$res = $mysqli->query($selectQry) or die("Error in Get All Records".$mysqli->error);
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
			    $detailrecords['frequency_applicable']  = $row->frequency_applicable;
			    $detailrecords['rating']  = $row->rating;
			}
			
			return $detailrecords;
		}

		// Get PM Checklist Multiple
		public function getPMcheckListDetails($mysqli, $id){

			$selectQry = $mysqli->query("SELECT * FROM  pm_checklist_multiple WHERE pm_checklist_id = '".$id."' "); 
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$cnt =0;
				while($row = $selectQry->fetch_assoc()){
				$detailrecords[$cnt]['id']      	= $row['id'];  
				$detailrecords[$cnt]['pmchecklistid']      	= $row['pm_checklist_id'];  
			    $detailrecords[$cnt]['checklist_add']  = $row['checklist'];
			    $detailrecords[$cnt]['type_of_checklist_add']  = $row['type_of_checklist'];
			    $detailrecords[$cnt]['yes_no_na_add']  = $row['yes_no_na'];
			    $detailrecords[$cnt]['no_of_option_add']  = $row['no_of_option'];
			    $detailrecords[$cnt]['option1_add']  = $row['option1'];
			    $detailrecords[$cnt]['option2_add']  = $row['option2'];
			    $detailrecords[$cnt]['option3_add']  = $row['option3'];
			    $detailrecords[$cnt]['option4_add']  = $row['option4'];
			    $detailrecords[$cnt]['rating_add']  = $row['rating'];
			$cnt++;
				}
				$detailrecords['cnt']  = $cnt;
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

			$checklist='';
			if(isset($_POST['checklist_add'])){
				$checklist = $_POST['checklist_add'];
			}
			$type_of_checklist='';
			if(isset($_POST['type_of_checklist_add'])){
				$type_of_checklist = $_POST['type_of_checklist_add'];
			}
			$yes_no_na='';
			if(isset($_POST['yes_no_type'])){
				$yes_no_na = $_POST['yes_no_type'];
			}
			$no_of_option='';
			if(isset($_POST['no_option_type'])){
				$no_of_option = $_POST['no_option_type'];
			}
			$option1='';
			if(isset($_POST['option1_type'])){
				$option1 = $_POST['option1_type'];
			}
			$option2 ='';
			if(isset($_POST['option2_type'])){
				$option2 = $_POST['option2_type'];
			}
			$option3='';
			if(isset($_POST['option3_type'])){
				$option3 = $_POST['option3_type'];
			}
			$option4='';
			if(isset($_POST['option4_type'])){
				$option4 = $_POST['option4_type'];
			}
			$rating='';
			if(isset($_POST['table_rating'])){
				$rating = $_POST['table_rating'];
			} 


			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}

			if(isset($_POST['id'])){
				$pmChkId = $_POST['id'];
			}

			$updateQry = 'UPDATE pm_checklist SET company_id = "'.strip_tags($company_id).'", category_id = "'.strip_tags($category_id).'",  frequency = "'.strip_tags($frequency).'", frequency_applicable = "'.strip_tags($frequency_applicable).'"  WHERE pm_checklist_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

			$mysqli->query("DELETE FROM `pm_checklist_multiple` WHERE `pm_checklist_id`='$pmChkId'");

			for($i=0; $i < count($checklist); $i++){
				$insertchecklist =$mysqli->query("INSERT INTO `pm_checklist_multiple`(`pm_checklist_id`, `checklist`, `type_of_checklist`, `yes_no_na`, `no_of_option`, `option1`, `option2`, `option3`, `option4`, `rating`, `update_login_id`, `updated_date`) VALUES ('".strip_tags($pmChkId)."','".strip_tags($checklist[$i])."','".strip_tags($type_of_checklist[$i])."','".strip_tags($yes_no_na[$i])."','".strip_tags($no_of_option[$i])."','".strip_tags($option1[$i])."','".strip_tags($option2[$i])."','".strip_tags($option3[$i])."','".strip_tags($option4[$i])."','".strip_tags($rating[$i])."', '".strip_tags($userid)."', now() )") or die("Error ".$mysqli->error);

			}
			
		}

		//  Delete PM Checklist
		public function deletePMChecklist($mysqli, $id, $userid){

			$deleteQry = "UPDATE pm_checklist set status='1', delete_login_id='".strip_tags($userid)."' WHERE pm_checklist_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($deleteQry) or die("Error in delete query".$mysqli->error);
		}

		// Add BM Checklist
		public function addBMChecklist($mysqli, $userid){

			if(isset($_POST['branch_id'])){
				$company_id = $_POST['branch_id'];
			}
			if(isset($_POST['category_id'])){
				$category_id = $_POST['category_id'];
			}

			if(isset($_POST['category_val'])){
				$category_val = $_POST['category_val'];
			}
			if(isset($_POST['checklist_add'])){
				$checklist_add = $_POST['checklist_add'];
			}
			if(isset($_POST['table_rating'])){
				$table_rating = $_POST['table_rating'];
			} 

			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}


			$rrInsert="INSERT INTO bm_checklist(company_id, category_id, frequency, frequency_applicable, insert_login_id) VALUES('".strip_tags($company_id)."', '".strip_tags($category_id)."', '".strip_tags($frequency)."','".strip_tags($frequency_applicable)."','".strip_tags($userid)."')";
			$insresult=$mysqli->query($rrInsert) or die("Error ".$mysqli->error);

			$findMaxId = $mysqli->query("SELECT max(bm_checklist_id) as max_bm_id FROM bm_checklist ");
			$maxid = $findMaxId->fetch_assoc();
			$bmChkId = $maxid['max_bm_id'];

			for($i=0; $i < count($checklist_add); $i++){

				$insertchecklist =$mysqli->query("INSERT INTO `bm_checklist_multiple`( `bm_checklist_id`, `cat_id`, `checklist`, `rating`, `insert_login_id`, `created_date`) VALUES ('".strip_tags($bmChkId)."', '".strip_tags($category_id)."', '".strip_tags($checklist_add[$i])."','".strip_tags($table_rating[$i])."', '".strip_tags($userid)."', now() )") or die("Error ".$mysqli->error);

			}
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
			    $detailrecords['frequency']  = $row->frequency; 
			    $detailrecords['frequency_applicable']  = $row->frequency_applicable; 
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
			if(isset($_POST['checklist_add'])){
				$checklist_add = $_POST['checklist_add'];
			}
			if(isset($_POST['table_rating'])){
				$table_rating = $_POST['table_rating'];
			} 

			if(isset($_POST['frequency'])){
				$frequency = $_POST['frequency'];
			}
			if(isset($_POST['frequency_applicable'])){
				$frequency_applicable = $_POST['frequency_applicable'];
			}

			$updateQry = 'UPDATE bm_checklist SET company_id = "'.strip_tags($company_id).'", category_id = "'.strip_tags($category_id).'",frequency= "'.strip_tags($frequency).'", frequency_applicable= "'.strip_tags($frequency_applicable).'", status = "0" WHERE bm_checklist_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

			$mysqli->query("DELETE FROM `bm_checklist_multiple` WHERE `bm_checklist_id`='$id'");

			for($i=0; $i < count($checklist_add); $i++){
				$insertchecklist =$mysqli->query("INSERT INTO `bm_checklist_multiple`( `bm_checklist_id`, `cat_id`, `checklist`, `rating`, `insert_login_id`, `created_date`) VALUES ('".strip_tags($id)."', '".strip_tags($category_id)."', '".strip_tags($checklist_add[$i])."','".strip_tags($table_rating[$i])."', '".strip_tags($userid)."', now() )") or die("Error ".$mysqli->error);

			}

		}

		//  Delete BM Checklist
		public function deleteBMChecklist($mysqli, $id, $userid){

			$rrDelete = "UPDATE bm_checklist set status='1', delete_login_id='".strip_tags($userid)."' WHERE bm_checklist_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($rrDelete) or die("Error in delete query".$mysqli->error);
		}

		// Get BM Checklist Multiple
		public function getBMcheckListDetails($mysqli, $id){

			$selectQry = $mysqli->query("SELECT a.id, a.bm_checklist_id, a.cat_id, a.checklist, a.rating, b.category_creation_name FROM bm_checklist_multiple a join category_creation b on a.cat_id = b.category_creation_id WHERE bm_checklist_id = '".$id."' "); 
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$cnt =0;
				while($row = $selectQry->fetch_assoc()){
				$detailrecords[$cnt]['id']      	= $row['id'];  
				$detailrecords[$cnt]['bmchecklistid']      	= $row['bm_checklist_id'];  
				$detailrecords[$cnt]['cat_id']      	= $row['cat_id'];  
				$detailrecords[$cnt]['checklist_add']  = $row['checklist'];
				$detailrecords[$cnt]['rating_add']  = $row['rating'];
				$detailrecords[$cnt]['category_name']  = $row['category_creation_name'];
			$cnt++;
				}
				$detailrecords['cnt']  = $cnt;
			}
			
			return $detailrecords;
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
			if(isset($_POST['vehicle_type'])){
				$vehicle_type = $_POST['vehicle_type'];
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

			$insertQry="INSERT INTO vehicle_details(company_id, vehicle_code, vehicle_type, vehicle_name, vehicle_number, date_of_purchase, fitment_upto, insurance_upto, asset_value, 
			book_value_as_on, insert_login_id) VALUES('".strip_tags($company_id)."', '".strip_tags($vehicle_code)."', '".strip_tags($vehicle_type)."', '".strip_tags($vehicle_name)."', 
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
			    $detailrecords['vehicle_type']  = $row->vehicle_type;
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
			if(isset($_POST['vehicle_code_edit'])){
				$vehicle_code = $_POST['vehicle_code_edit'];
			}
			if(isset($_POST['vehicle_type'])){
				$vehicle_type = $_POST['vehicle_type'];
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

			$updateQry = 'UPDATE vehicle_details SET company_id = "'.strip_tags($company_id).'", vehicle_code = "'.strip_tags($vehicle_code).'", vehicle_type = "'.strip_tags($vehicle_type).'", vehicle_name = "'.strip_tags($vehicle_name).'", vehicle_number = "'.strip_tags($vehicle_number).'", date_of_purchase = "'.strip_tags($date_of_purchase).'", fitment_upto = "'.strip_tags($fitment_upto).'", insurance_upto = "'.strip_tags($insurance_upto).'", asset_value = "'.strip_tags($asset_value).'", book_value_as_on = "'.strip_tags($book_value_as_on).'", status = "0" WHERE vehicle_details_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
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
			if(isset($_POST['staff_name'])){
				$staff_name = $_POST['staff_name'];
			}

			$insertQry="INSERT INTO diesel_slip(company_id, vehicle_number, previous_km, previous_km_date, present_km, present_km_date, total_km_run, diesel_amount, staff_id,
			insert_login_id) VALUES('".strip_tags($company_id)."', '".strip_tags($vehicle_number)."', '".strip_tags($previous_km)."', '".strip_tags($previous_km_date)."',  
			 '".strip_tags($present_km)."', '".strip_tags($present_km_date)."', '".strip_tags($total_km_run)."', '".strip_tags($diesel_amount)."', '".strip_tags($staff_name)."', '".strip_tags($userid)."')";
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
			    $detailrecords['staff_id']  = $row->staff_id;
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
			if(isset($_POST['staff_name'])){
				$staff_name = $_POST['staff_name'];
			}

			$updateQry = 'UPDATE diesel_slip SET company_id = "'.strip_tags($company_id).'", vehicle_number = "'.strip_tags($vehicle_number).'", 
			previous_km = "'.strip_tags($previous_km).'", previous_km_date = "'.strip_tags($previous_km_date).'", present_km = "'.strip_tags($present_km).'", 
			present_km_date = "'.strip_tags($present_km_date).'", total_km_run = "'.strip_tags($total_km_run).'", diesel_amount = "'.strip_tags($diesel_amount).'", staff_id = "'.strip_tags($staff_name).'", status = "0" WHERE diesel_slip_id = "'.mysqli_real_escape_string($mysqli, $id).'" '; 
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
		public function getAuditAssignDashboard($mysqli, $designationID){

			$getRole2 = "SELECT * FROM audit_assign WHERE role2 = '".strip_tags($designationID)."' AND auditee_response_status = 0 AND status=0";
			$res = $mysqli->query($getRole2) or die("Error in Get All Records".$mysqli->error);
			$detailrecords = 0;
			if ($mysqli->affected_rows>0)
			{
				$detailrecords = 1;
			}
			
			return $detailrecords;
		}

		// get auditee response
		public function getAuditeeResponseDashboard($mysqli, $designationID){
			$detailrecords = array();
			if($designationID == 'Overall'){
				$getRole2 = "SELECT * FROM audit_assign WHERE auditee_response_status = 1 AND status=0";
				$res = $mysqli->query($getRole2) or die("Error in Get All Records".$mysqli->error);
				$detailrecords = 0;
				if ($mysqli->affected_rows>0)
				{
					$detailrecords = 1;
				}
			} else {
				$getRole2 = "SELECT * FROM audit_assign WHERE role1 = '".strip_tags($designationID)."' AND auditee_response_status = 1 AND status=0";
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
			if(isset($_POST['branch_name'])){
				$branch_name = $_POST['branch_name'];
				$branch_id = implode(",", $branch_name);
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
			if(isset($_POST['department'])){
				$department = $_POST['department'];
			}
			if(isset($_POST['employee_name'])){
				$employee_name = $_POST['employee_name'];
			}

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			// insert campaign
			$insertQry="INSERT INTO campaign(promotional_activities_id, actual_start_date, branch_id, insert_login_id) VALUES('".strip_tags($project_id)."', '".strip_tags($actual_start_date)."', '".strip_tags($branch_id)."', '".strip_tags($userid)."')";
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
			$last_id  = $mysqli->insert_id;

			// update promotional activity
			$updateQry = 'UPDATE promotional_activities SET campaign_status = "1" WHERE promotional_activities_id = "'.mysqli_real_escape_string($mysqli, $project_id).'" ';
			$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

			for($j=0; $j<=sizeof($promotional_activities_ref_id)-1; $j++){

				// insert campaign ref
				$insertQryRef="INSERT INTO campaign_ref(campaign_id, promotional_activities_ref_id, activity_involved, time_frame_start, duration, start_date, end_date, department_id,
				employee_name) VALUES ('".strip_tags($last_id)."', '".strip_tags($promotional_activities_ref_id[$j])."', '".strip_tags($activity_involved[$j])."', 
				'".strip_tags($time_frame_start[$j])."','".strip_tags($duration[$j])."','".strip_tags($start_date[$j].' '.$current_time)."',
				'".strip_tags($end_date[$j].' '.$current_time)."', '".strip_tags($department[$j])."', '".strip_tags($employee_name[$j])."' )";
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
                $detailrecords['branch_id']              		= $row->branch_id;
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
						$department_id[] = $row2->department_id;
						$staff_name[] = $row2->employee_name;
						
						if($campaign_refId > 0){
							$detailrecords['campaign_ref_id'] = $campaign_ref_id;
							$detailrecords['start_date'] = $start_date;
							$detailrecords['end_date'] = $end_date;
							$detailrecords['staff_name'] = $staff_name;
							$detailrecords['department_id'] = $department_id;
						} else {
							$detailrecords['campaign_ref_id'] = array();
							$detailrecords['start_date'] = array();
							$detailrecords['end_date'] = array();
							$detailrecords['staff_name'] = array();
							$detailrecords['department_id'] = array();
						}
					}
					
				}else {
					$detailrecords['campaign_ref_id'] = array();
					$detailrecords['start_date'] = array();
					$detailrecords['end_date'] = array();
					$detailrecords['staff_name'] = array();
					$detailrecords['department_id'] = array();
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
			if(isset($_POST['branch_name'])){
				$branch_name = $_POST['branch_name'];
				$branch_id = implode(",", $branch_name);
			}
			if(isset($_POST['promotional_activities_ref_id'])){
				$promotional_activities_ref_id = $_POST['promotional_activities_ref_id'];
			}
			if(isset($_POST['campaign_ref_id'])){
				$campaign_ref_id = $_POST['campaign_ref_id'];
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
			if(isset($_POST['department'])){
				$department = $_POST['department'];
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

            $updateQry = 'UPDATE campaign SET promotional_activities_id = "'.strip_tags($project_id).'", actual_start_date = "'.strip_tags($actual_start_date).'", branch_id = "'.strip_tags($branch_id).'", update_login_id = "'.strip_tags($userid).'", status = "0" WHERE campaign_id = "'.mysqli_real_escape_string($mysqli, $id).'" ';
            $res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error);

			date_default_timezone_set('Asia/Calcutta');
			$current_time = date('H:i:s');

			for($j=0; $j < count($campaign_ref_id); $j++){
				// Update campaign ref
				$UpdateCampaignRef = "UPDATE `campaign_ref` SET `campaign_id`='$id',`promotional_activities_ref_id`='$promotional_activities_ref_id[$j]',`activity_involved`='$activity_involved[$j]',`time_frame_start`='$time_frame_start[$j]',`duration`='$duration[$j]',`start_date`='$start_date[$j].' '.$current_time',`end_date`='$end_date[$j].' '.$current_time',`department_id`='$department[$j]',`employee_name`='$employee_name[$j]' WHERE `campaign_ref_id`='$campaign_ref_id[$j]' ";

				$insert_ref = $mysqli->query($UpdateCampaignRef) or die("Error ".$mysqli->error);

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

		public function getgoalsettingTable($mysqli){

            $auditSelect = "SELECT company_id,company_name FROM company_creation WHERE status = '0'";
            $res = $mysqli->query($auditSelect) or die("Error in Get All Records".$mysqli->error);
            $audit_area_list = array();
            $i=0;

            if ($mysqli->affected_rows>0)
            {
                while($row = $res->fetch_object()){

					$audit_area_list[$i]['company_id']      = $row->company_id;
					$audit_area_list[$i]['company_name']      = $row->company_name;
					$i++;
                }
            }

            return $audit_area_list;
        }



		// Add Goal Setting
		public function addgoalsetting($mysqli,$userid){

			if(isset($_POST['goal_setting_id'])){
				$goal_setting_id = $_POST['goal_setting_id'];
			}
			if(isset($_POST['companyid'])){
				$company_name = $_POST['companyid'];
			}
			if(isset($_POST['branchid'])){
				$branch_name = $_POST['branchid'];
			}
			if(isset($_POST['deptid'])){
				$dept = $_POST['deptid'];
			}
			if(isset($_POST['dept_strength'])){
				$dept_strength = $_POST['dept_strength'];
			}

			if(isset($_POST['assertion'])){
				$assertion = $_POST['assertion'];
			}
			if(isset($_POST['rowcnt'])){
				$rowcnt = $_POST['rowcnt'];
			}
			if(isset($_POST['target'])){
				$target = $_POST['target'];
			}
			if(isset($_POST['goal_month'])){
				$goal_month = $_POST['goal_month'];
			}
			if(isset($_POST['monthly_conversion'])){
				$monthly_conversion = $_POST['monthly_conversion']; // 0 -Month, 1 -Daily;
			}
			if(isset($_POST['entry_date_type'])){
				$entry_date_type = $_POST['entry_date_type']; // 0 -current date, 1 -previous date;
			}
			

			if($goal_setting_id == ''){ 

				$qry1="INSERT INTO goal_setting (goal_setting_id, company_name, branch_id, department, dept_strength, insert_login_id, status)
				VALUES (NULL, '$company_name', '$branch_name', '$dept', '$dept_strength', '$userid', '0')";
				$insert_assign=$mysqli->query($qry1) or die("Error ".$mysqli->error);
				$last_id  = $mysqli->insert_id;

				for($j=0; $j<=sizeof($assertion)-1; $j++){

					if(isset($_POST['staff_name'.$j])){
						$staff_name = $_POST['staff_name'.$j];
						$targetPerStaff = $target[$j]/ count($staff_name);
						$staffname = implode(",", $staff_name);
					}

					if($monthly_conversion[$j] == '1'){  //1= Daily, If Daily means enter full month date except sunday and holiday creation date.
					//checking whether the date in holiday creation or not. 
					$holidayCreationDetails = $mysqli->query("SELECT holiday_date FROM holiday_creation_ref WHERE DATE_FORMAT(holiday_date, '%Y-%m') = '$goal_month[$j]' ");
					$holidayDates = array();
					while($holidays = $holidayCreationDetails->fetch_assoc()){
						$holidayDates[] = $holidays['holiday_date'];
					}
					//Holiday Creation END///

					//Count the total days in the month by using selected goal month and also store the date except holidays and sundays. 
					$totalDays = date('t', strtotime("$goal_month[$j]-01"));
					$workingDays = array();

					for ($day = 1; $day <= $totalDays; $day++) {
						$date = "$goal_month[$j]-" . str_pad($day, 2, '0', STR_PAD_LEFT);
						$dayOfWeek = date('N', strtotime($date)); // 1 (Monday) to 7 (Sunday)

						if ($dayOfWeek != 7 && !in_array($date,$holidayDates)) { // Exclude Sundays (dayOfWeek = 7)
							$workingDays[] = $date;
						}
					}
					//Total Days count END///
					$perDayTarget = round($targetPerStaff / count($workingDays));
					//Inserting the goal_setting_ref table based on the assertion and month date.
					foreach ($workingDays as $day) {
					$qry2="INSERT INTO goal_setting_ref(goal_setting_id, assertion_table_sno, assertion, target, per_day_target, goal_month, monthly_conversion_required, entry_date_type, staffname, insert_login_id)
					VALUES('".strip_tags($last_id)."', '".strip_tags($rowcnt[$j])."', '".strip_tags($assertion[$j])."','".strip_tags($target[$j])."', '".$perDayTarget."', '".$day."', '".strip_tags($monthly_conversion[$j])."', '".$entry_date_type[$j]."', '".strip_tags($staffname)."', '".strip_tags($userid)."')";
					$insert_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);

					} //Foreach END///
					//Insertion END///

					}else{ 

					$qry2="INSERT INTO goal_setting_ref(goal_setting_id, assertion_table_sno, assertion, target, goal_month, monthly_conversion_required, entry_date_type, staffname, insert_login_id)
					VALUES('".strip_tags($last_id)."', '".strip_tags($rowcnt[$j])."', '".strip_tags($assertion[$j])."','".strip_tags($target[$j])."', '".$goal_month[$j]."', '".strip_tags($monthly_conversion[$j])."', '".$entry_date_type[$j]."', '".strip_tags($staffname)."', '".strip_tags($userid)."')";
					$insert_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);

					} 
				}

			} else { //Goal Setting Update
				
				$qry1="UPDATE goal_setting set company_name = '$company_name', branch_id = '$branch_name',department = '$dept' , dept_strength = '$dept_strength', status ='0',update_login_id='$userid' WHERE goal_setting_id = '$goal_setting_id' ";
                $update_assign=$mysqli->query($qry1) or die("Error ".$mysqli->error);
                $last_id  = $mysqli->insert_id;

				$deleteqry = " DELETE FROM goal_setting_ref WHERE goal_setting_id = '".$goal_setting_id."' ";
				$delete=$mysqli->query($deleteqry) or die("Error on delete query ".$mysqli->error);


                for($i=0;$i<=sizeof($assertion)-1;$i++){
					if(isset($_POST['staff_name'.$i])){
						$staff_name = $_POST['staff_name'.$i];
						$targetPerStaff = $target[$i]/ count($staff_name);
						$staffname = implode(",", $staff_name);
					}

				if($monthly_conversion[$i] == '1'){  //1= Daily, If Daily means enter full month date except sunday and holiday creation date.
					//checking whether the date in holiday creation or not. 
					$holidayCreationDetails = $mysqli->query("SELECT holiday_date FROM holiday_creation_ref WHERE DATE_FORMAT(holiday_date, '%Y-%m') = '$goal_month[$i]' ");
					$holidayDates = array();
					while($holidays = $holidayCreationDetails->fetch_assoc()){
						$holidayDates[] = $holidays['holiday_date'];
					}
					//Holiday Creation END///

					//Count the total days in the month by using selected goal month and also store the date except holidays and sundays. 
					$totalDays = date('t', strtotime("$goal_month[$i]-01"));
					$workingDays = array();

					for ($day = 1; $day <= $totalDays; $day++) {
						$date = "$goal_month[$i]-" . str_pad($day, 2, '0', STR_PAD_LEFT);
						$dayOfWeek = date('N', strtotime($date)); // 1 (Monday) to 7 (Sunday)

						if ($dayOfWeek != 7 && !in_array($date,$holidayDates)) { // Exclude Sundays (dayOfWeek = 7)
							$workingDays[] = $date;
						}
					}
					//Total Days count END///
					$perDayTarget = round($targetPerStaff / count($workingDays));
					//Inserting the goal_setting_ref table based on the assertion and month date.
					foreach ($workingDays as $day) {
					$qry2="INSERT INTO goal_setting_ref(goal_setting_id, assertion_table_sno, assertion, target, per_day_target, goal_month, monthly_conversion_required, entry_date_type, staffname, update_login_id)
					VALUES('$goal_setting_id', '$rowcnt[$i]', '$assertion[$i]','$target[$i]', '$perDayTarget', '$day', '$monthly_conversion[$i]', '$entry_date_type[$i]', '$staffname', '$userid')";
					$update_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);	

					} //Foreach END///
					//Insertion END///

					}else{ 
					$qry2="INSERT INTO goal_setting_ref(goal_setting_id, assertion_table_sno, assertion, target, goal_month, monthly_conversion_required, entry_date_type, staffname,update_login_id)
					VALUES('$goal_setting_id', '$rowcnt[$i]', '$assertion[$i]','$target[$i]', '$goal_month[$i]', '$monthly_conversion[$i]', '$entry_date_type[$i]','$staffname', '$userid')";
					$update_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);	

					} 
			}
			}
		}
		// Delete goal setting
		public function deleteAuditAssigns($mysqli, $id){
			$checklistDelete = "UPDATE goal_setting set status='1' WHERE goal_setting_id = '".strip_tags($id)."' ";
			$runQry = $mysqli->query($checklistDelete) or die("Error in delete query".$mysqli->error);
		}
		
	// get auditAssign edit list
	public function getGoalSettingfet($mysqli,$id){
		
		$get_checklist = "SELECT * FROM goal_setting_ref where goal_setting_id IN ($id)";
	
		$res2 = $mysqli->query($get_checklist) or die("Error in Get All Records".$mysqli->error);
		$i=0;
		$auditChecklist2='';
		$auditChecklist2=array();
		if ($mysqli->affected_rows>0)
		{
			while($row2 = $res2->fetch_assoc()){
			$auditChecklist2[$i]['goal_setting_ref_id'] = $row2['goal_setting_ref_id'];
			$auditChecklist2[$i]['goal_setting_id'] = $row2['goal_setting_id'];
			$auditChecklist2[$i]['assertion'] = $row2['assertion'];
			$auditChecklist2[$i]['target']=$row2['target'];
			$auditChecklist2[$i]['monthly_conversion']=$row2['monthly_conversion_required'];
			$auditChecklist2[$i]['edt']=$row2['entry_date_type'];
			$auditChecklist2[$i]['staffname']=$row2['staffname'];
			
			$i++;
			}
		}
		return $auditChecklist2;
	}

	// get getGoalSettingfetch list table
	public function getGoalSettingfetch($mysqli,$id){
		if($id>0){
			$goalsettingsQry = "SELECT gs.company_name AS company_id, gs.branch_id, gs.department AS dept_id, gs.dept_strength, gs.status FROM goal_setting gs 
			LEFT JOIN goal_setting_ref gsr ON gsr.goal_setting_id = gs.goal_setting_id WHERE gs.goal_setting_id = '$id' GROUP BY gs.company_name";
			
		} else {
			$goalsettingsQry = "SELECT gs.company_name AS company_id, gs.branch_id, gs.department AS dept_id, gs.dept_strength, gs.status FROM goal_setting gs 
			LEFT JOIN goal_setting_ref gsr ON gsr.goal_setting_id = gs.goal_setting_id GROUP BY gs.company_name";	
		}

		$goalSettingDetails = $mysqli->query($goalsettingsQry) or die("Error in Get All checklist ".$mysqli->error);

		if ($mysqli->affected_rows>0)
		{
			while($goalInfo = $goalSettingDetails->fetch_object()){
			$goalsettings['company_id'] = $goalInfo->company_id;
			$goalsettings['branch_id'] = $goalInfo->branch_id;
			$goalsettings['dept_id'] = $goalInfo->dept_id;
			$goalsettings['dept_strength'] = $goalInfo->dept_strength;
		}

		//change value into new variable
		}
		
		
		return $goalsettings;
	}
		
	public function addTargetFixing($mysqli, $userid){

		if(isset($_POST['company_name'])){
			$company_id = $_POST['company_name'];
		}
		if(isset($_POST['department'])){
			$department_id = $_POST['department'];
		}
		if(isset($_POST['designation'])){
			$designation_id = $_POST['designation'];
		}
		if(isset($_POST['staff_name'])){
			$emp_id = $_POST['staff_name'];
		}
		if(isset($_POST['goal_year'])){
			$year_id = $_POST['goal_year'];
		}
		if(isset($_POST['no_of_months'])){
			$no_of_months = $_POST['no_of_months'];
		} 

		if(isset($_POST['id'])){
			$id = $_POST['id'];
		} 
		if(isset($_POST['assertion'])){
			$assertion = $_POST['assertion'];
		} 
		if(isset($_POST['target'])){
			$target = $_POST['target'];
		} 
		if(isset($_POST['monthly_conversion'])){
			$monthly_conversion = $_POST['monthly_conversion'];
		} 
		if(isset($_POST['new_assertion'])){
			$new_assertion = $_POST['new_assertion'];
		} 
		if(isset($_POST['new_target'])){
			$new_target = $_POST['new_target'];
		} 
		if(isset($_POST['applicability'])){
			$applicability = $_POST['applicability'];
		} 
		if(isset($_POST['deleted_date'])){
			$deleted_date = $_POST['deleted_date'];
		} 
		if(isset($_POST['deleted_remarks'])){
			$deleted_remarks = $_POST['deleted_remarks'];
		} 

		$qry="INSERT INTO target_fixing(company_id, department_id, designation_id, emp_id, year_id, no_of_months, insert_login_id) VALUES('".strip_tags($company_id)."', 
		'".strip_tags($department_id)."', '".strip_tags($designation_id)."', '".strip_tags($emp_id)."', '".strip_tags($year_id)."', '".strip_tags($no_of_months)."', 
		'".strip_tags($userid)."' )";
		$result=$mysqli->query($qry) or die("Error ".$mysqli->error);
		$lastId = $mysqli->insert_id; 

		for($i=0; $i<=sizeof($id)-1; $i++){

			$refQry="INSERT INTO target_fixing_ref(target_fixing_id, goal_setting_and_kra_id, assertion, target, monthly_conversion_required, new_assertion, new_target, applicability, deleted_date, deleted_remarks)
			VALUES('".strip_tags($lastId)."', '".strip_tags($id[$i])."', '".strip_tags($assertion[$i])."', '".strip_tags($target[$i])."', '".strip_tags($monthly_conversion[$i])."', '".strip_tags($new_assertion[$i])."', 
			'".strip_tags($new_target[$i])."', '".strip_tags($applicability[$i])."', '".strip_tags($deleted_date[$i])."', '".strip_tags($deleted_remarks[$i])."')"; 
			$refResult=$mysqli->query($refQry) or die("Error ".$mysqli->error);
		}
	}

	// Get target fixing
	public function getTargetFixing($mysqli, $id){

		$kraSelect = "SELECT * FROM target_fixing WHERE target_fixing_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
		$res = $mysqli->query($kraSelect) or die("Error in Get All Records".$mysqli->error);
		$detailrecords = array();
		if ($mysqli->affected_rows>0)
		{
			$row = $res->fetch_object();	
			$targetFixingId  							= $row->target_fixing_id;
			$detailrecords['target_fixing_id']            = $row->target_fixing_id; 
			$detailrecords['company_id']        = $row->company_id;
			$detailrecords['department']        = $row->department_id;
			$detailrecords['designation']       = $row->designation_id; 	
			$detailrecords['emp_id']       = $row->emp_id; 	
			$detailrecords['year_id']       = $row->year_id; 	
			$detailrecords['no_of_months']       = $row->no_of_months; 	

		}
		
		$targetFixingRefId = 0;
		$kraRefSelect = "SELECT * FROM target_fixing_ref WHERE target_fixing_id='".mysqli_real_escape_string($mysqli, $targetFixingId)."' "; 
		$res1 = $mysqli->query($kraRefSelect) or die("Error in Get All Records".$mysqli->error);
		if ($mysqli->affected_rows>0)
		{
			while($row1 = $res1->fetch_object()){

				$targetFixingRefId         			= $row1->target_fixing_ref_id; 
				$target_fixing_ref_id[]     	    = $row1->target_fixing_ref_id; 
				$goal_setting_and_kra_id[]          = $row1->goal_setting_and_kra_id; 
				$assertion[]                        = $row1->assertion;
				$target[]                           = $row1->target;
				$monthly_conversion[]               = $row1->monthly_conversion_required;
				$new_assertion[]                    = $row1->new_assertion;
				$new_target[]                       = $row1->new_target;
				$applicability[]                    = $row1->applicability;
				$deleted_date[]                     = $row1->deleted_date;
				$deleted_remarks[]                  = $row1->deleted_remarks;
			} 
		}
		if($targetFixingRefId > 0)
		{
			$detailrecords['target_fixing_ref_id']             = $target_fixing_ref_id; 
			$detailrecords['goal_setting_and_kra_id']          = $goal_setting_and_kra_id;
			$detailrecords['assertion']                        = $assertion;  	
			$detailrecords['target']                           = $target;  	
			$detailrecords['monthly_conversion']               = $monthly_conversion;  	
			$detailrecords['new_assertion']                    = $new_assertion;  	
			$detailrecords['new_target']                       = $new_target;  	
			$detailrecords['applicability']                    = $applicability;  	
			$detailrecords['deleted_date']                     = $deleted_date;  	
			$detailrecords['deleted_remarks']                  = $deleted_remarks;  	
		}
		else
		{
			$detailrecords['target_fixing_ref_id']           = array();
			$detailrecords['goal_setting_and_kra_id']        = array();
			$detailrecords['assertion']                      = array(); 
			$detailrecords['target']                         = array(); 
			$detailrecords['monthly_conversion']             = array(); 
			$detailrecords['new_assertion']                  = array(); 
			$detailrecords['new_target']                     = array(); 
			$detailrecords['applicability']                  = array(); 
			$detailrecords['deleted_date']                   = array(); 
			$detailrecords['deleted_remarks']                = array(); 
		}
		
		return $detailrecords;
	}

	// Update target fixing
	public function updateTargetFixing($mysqli, $upd_id, $userid){

		if(isset($_POST['company_name'])){
			$company_id = $_POST['company_name'];
		}
		if(isset($_POST['department'])){
			$department_id = $_POST['department'];
		}
		if(isset($_POST['designation'])){
			$designation_id = $_POST['designation'];
		}
		if(isset($_POST['staff_name'])){
			$emp_id = $_POST['staff_name'];
		}
		if(isset($_POST['goal_year'])){
			$year_id = $_POST['goal_year'];
		}
		if(isset($_POST['no_of_months'])){
			$no_of_months = $_POST['no_of_months'];
		} 

		if(isset($_POST['id'])){
			$id = $_POST['id'];
		} 
		if(isset($_POST['assertion'])){
			$assertion = $_POST['assertion'];
		} 
		if(isset($_POST['target'])){
			$target = $_POST['target'];
		} 
		if(isset($_POST['monthly_conversion'])){
			$monthly_conversion = $_POST['monthly_conversion'];
		} 
		if(isset($_POST['new_assertion'])){
			$new_assertion = $_POST['new_assertion'];
		} 
		if(isset($_POST['new_target'])){
			$new_target = $_POST['new_target'];
		} 
		if(isset($_POST['applicability'])){
			$applicability = $_POST['applicability'];
		} 
		if(isset($_POST['deleted_date'])){
			$deleted_date = $_POST['deleted_date'];
		} 
		if(isset($_POST['deleted_remarks'])){
			$deleted_remarks = $_POST['deleted_remarks'];
		} 

		$qry = "UPDATE target_fixing SET company_id = '".strip_tags($company_id)."', department_id = '".strip_tags($department_id)."', 
		designation_id = '".strip_tags($designation_id)."', emp_id = '".strip_tags($emp_id)."', year_id = '".strip_tags($year_id)."', 
		no_of_months = '".strip_tags($no_of_months)."', update_login_id='".strip_tags($userid)."', status = '0' WHERE target_fixing_id= '".strip_tags($upd_id)."' ";
		$updresult = $mysqli->query($qry )or die ("Error in in update Query!.".$mysqli->error);

		$deleteKraRef = $mysqli->query("DELETE FROM target_fixing_ref WHERE target_fixing_id = '".$upd_id."' "); 

		for($i=0; $i<=sizeof($id)-1; $i++){

			$refQry="INSERT INTO target_fixing_ref(target_fixing_id, goal_setting_and_kra_id, assertion, target, monthly_conversion_required, new_assertion, new_target, applicability, deleted_date, deleted_remarks)
			VALUES('".strip_tags($upd_id)."', '".strip_tags($id[$i])."', '".strip_tags($assertion[$i])."', '".strip_tags($target[$i])."', '".strip_tags($monthly_conversion[$i])."', '".strip_tags($new_assertion[$i])."', 
			'".strip_tags($new_target[$i])."', '".strip_tags($applicability[$i])."', '".strip_tags($deleted_date[$i])."', '".strip_tags($deleted_remarks[$i])."')"; 
			$refResult=$mysqli->query($refQry) or die("Error ".$mysqli->error);
		}

	}

	// Delete Terget fixing
	public function deleteTargetFixing($mysqli, $id, $userid){

		$qry = "UPDATE target_fixing set status='1', delete_login_id='".strip_tags($userid)."' WHERE target_fixing_id = '".strip_tags($id)."' ";
		$runQry = $mysqli->query($qry) or die("Error in delete query".$mysqli->error);
	}

    
	public function addAppDep($mysqli, $userid){

		if(isset($_POST['review'])){
			$review = $_POST['review'];
		}
		if(isset($_POST['company_name'])){
			$company_id = $_POST['company_name'];
		}
		if(isset($_POST['mySelectedDeptName'])){
			$department_id = $_POST['mySelectedDeptName'];
		}
		if(isset($_POST['mySelectedDesgnName'])){
			$designation_id = $_POST['mySelectedDesgnName'];
		}
		if(isset($_POST['mySelectedStaffName'])){
			$emp_id = $_POST['mySelectedStaffName'];
		}
		if(isset($_POST['month'])){
			$yearmonthsplit = explode('-',$_POST["month"]); //format('yyyy-mm'); // we want month only so split month here.
    		$month = intval($yearmonthsplit[1]);
    		$year_id = intval($yearmonthsplit[0]);
		} 
		if(isset($_POST['daily_performance_ref_id'])){
			$daily_performance_ref_id = $_POST['daily_performance_ref_id'];
		} 
		if(isset($_POST['assertion'])){
			$assertion = $_POST['assertion'];
		} 
		if(isset($_POST['target'])){
			$target = $_POST['target'];
		} 
		if(isset($_POST['overall_performance'])){
			$overall_performance1 = $_POST['overall_performance'];
			$overall_performance = str_replace("Total Satisfied - ", "", $overall_performance1);
		} 
		if(isset($_POST['not_done'])){
			$not_done1 = $_POST['not_done'];
			$not_done = str_replace("Total Not Done - ", "", $not_done1);
		} 
		if(isset($_POST['achievement'])){
			$achievement = $_POST['achievement'];
		} 
		if(isset($_POST['employee_rating'])){
			$employee_rating = $_POST['employee_rating'];
		} 
		if(isset($_POST['strength'])){
			$strength = $_POST['strength'];
		} 
		if(isset($_POST['weakness'])){
			$weakness = $_POST['weakness'];
		} 
		if(isset($_POST['need_for_improvement'])){
			$need_for_improvement = $_POST['need_for_improvement'];
		} 
		if(isset($_POST['overall_rating'])){
			$overall_rating = $_POST['overall_rating'];
		} 

		$qry="INSERT INTO appreciation_depreciation( company_id, department_id, designation_id, emp_id, year_id, month, overall_performance, not_done, strength, weakness, need_for_improvement, overall_rating, insert_login_id) VALUES('".strip_tags($company_id)."', 
		'".strip_tags($department_id)."', '".strip_tags($designation_id)."', '".strip_tags($emp_id)."', '".strip_tags($year_id)."', '".strip_tags($month)."', 
		'".strip_tags($overall_performance)."', '".strip_tags($not_done)."', '".strip_tags($strength)."', '".strip_tags($weakness)."', 
		'".strip_tags($need_for_improvement)."', '".strip_tags($overall_rating)."', '".strip_tags($userid)."' )";
		$result=$mysqli->query($qry) or die("Error ".$mysqli->error);
		$lastId = $mysqli->insert_id; 

		for($i=0; $i<=sizeof($review)-1; $i++){

			$refQry="INSERT INTO appreciation_depreciation_ref(appreciation_depreciation_id, review, daily_performance_ref_id, assertion, target, 
			achievement, employee_rating) VALUES ('".strip_tags($lastId)."', '".$review[$i]."', '".strip_tags($daily_performance_ref_id[$i])."', 
			'".strip_tags($assertion[$i])."', '".strip_tags($target[$i])."', '".strip_tags($achievement[$i])."', '".strip_tags($employee_rating[$i])."')";  
			$refResult=$mysqli->query($refQry) or die("Error ".$mysqli->error);
		}
		
	}

	// Get appdeb
	public function getAppDep($mysqli, $id){

		$appDep = "SELECT * FROM appreciation_depreciation WHERE appreciation_depreciation_id='".mysqli_real_escape_string($mysqli, $id)."' ";  //echo $appDep; die;
		$res = $mysqli->query($appDep) or die("Error in Get All Records".$mysqli->error);
		$detailrecords = array();
		if ($mysqli->affected_rows>0)
		{
			$row = $res->fetch_object();	
			$appreciationDepreciationId  					= $row->appreciation_depreciation_id;
			$detailrecords['appreciation_depreciation_id']  = $row->appreciation_depreciation_id; 
			$detailrecords['company_id']                    = $row->company_id;
			$detailrecords['department']                    = $row->department_id;
			$detailrecords['designation']                   = $row->designation_id; 	
			$detailrecords['emp_id']                        = $row->emp_id; 	
			$detailrecords['year_id']                       = $row->year_id; 	
			$detailrecords['month']                         = $row->month; 	
			$detailrecords['overall_performance']           = $row->overall_performance; 	
			$detailrecords['not_done']                      = $row->not_done; 	
			$detailrecords['carry_forward']                 = $row->carry_forward; 	
			$detailrecords['strength']                      = $row->strength; 	
			$detailrecords['weakness']                      = $row->weakness; 	
			$detailrecords['need_for_improvement']          = $row->need_for_improvement; 	
			$detailrecords['overall_rating']                = $row->overall_rating; 	
			$detailrecords['update_login_id']                = $row->update_login_id; 	
		}

		$appDepRefId = 0;
		$appDepRef = "SELECT * FROM appreciation_depreciation_ref WHERE review = 0 && appreciation_depreciation_id='".mysqli_real_escape_string($mysqli, $appreciationDepreciationId)."' ";  //review = 0 = Monthly Task, 1 = Daily Task
		$res1 = $mysqli->query($appDepRef) or die("Error in Get All Records".$mysqli->error);
		if ($mysqli->affected_rows>0)
		{
			while($row1 = $res1->fetch_object()){

				$appDepRefId         			= $row1->appreciation_depreciation_ref_id;  
				$monthly_app_dep_ref_id[]     	    = $row1->appreciation_depreciation_ref_id; 
				$monthly_daily_performance_ref_id[]     	    = $row1->daily_performance_ref_id; 
				$monthly_review[]                                    = $row1->review;
				$monthly_assertion[]                                    = $row1->assertion;
				$monthly_target[]                                       = $row1->target;
				$monthly_achievement[]                                  = $row1->achievement;
				$monthly_employee_rating[]                              = $row1->employee_rating;
			} 
		}
		if($appDepRefId > 0)
		{
			$detailrecords['monthly_app_dep_ref_id']          = $monthly_app_dep_ref_id;  
			$detailrecords['monthly_daily_performance_ref_id']          = $monthly_daily_performance_ref_id;  
			$detailrecords['monthly_review']                        = $monthly_review;
			$detailrecords['monthly_assertion']                                 = $monthly_assertion;  	
			$detailrecords['monthly_target']                                    = $monthly_target;  	
			$detailrecords['monthly_achievement']                               = $monthly_achievement;  	
			$detailrecords['monthly_employee_rating']                           = $monthly_employee_rating;  	
		}
		else
		{
			$detailrecords['monthly_app_dep_ref_id']          = array();
			$detailrecords['monthly_daily_performance_ref_id']          = array();
			$detailrecords['monthly_review']                        = array();
			$detailrecords['monthly_assertion']                                 = array(); 
			$detailrecords['monthly_target']                                    = array(); 
			$detailrecords['monthly_achievement']                               = array(); 
			$detailrecords['monthly_employee_rating']                           = array(); 
		}

		//Daily Task
		$appreciationDepreciationRefId = 0;
		$appDepRef = "SELECT * FROM appreciation_depreciation_ref WHERE review = 1 && appreciation_depreciation_id='".mysqli_real_escape_string($mysqli, $appreciationDepreciationId)."' ";  //review = 0 = Monthly Task, 1 = Daily Task
		$res1 = $mysqli->query($appDepRef) or die("Error in Get All Records".$mysqli->error);
		if ($mysqli->affected_rows>0)
		{
			while($row1 = $res1->fetch_object()){

				$appreciationDepreciationRefId         			= $row1->appreciation_depreciation_ref_id;  
				$appreciation_depreciation_ref_id[]     	    = $row1->appreciation_depreciation_ref_id; 
				$daily_performance_ref_id[]     	    = $row1->daily_performance_ref_id; 
				$review[]                                    = $row1->review;
				$assertion[]                                    = $row1->assertion;
				$target[]                                       = $row1->target;
				$achievement[]                                  = $row1->achievement;
				$employee_rating[]                              = $row1->employee_rating;
			} 
		}
		if($appreciationDepreciationRefId > 0)
		{
			$detailrecords['appreciation_depreciation_ref_id']          = $appreciation_depreciation_ref_id;  
			$detailrecords['daily_performance_ref_id']          = $daily_performance_ref_id;  
			$detailrecords['review']                        = $review;
			$detailrecords['assertion']                                 = $assertion;  	
			$detailrecords['target']                                    = $target;  	
			$detailrecords['achievement']                               = $achievement;  	
			$detailrecords['employee_rating']                           = $employee_rating;  	
		}
		else
		{
			$detailrecords['appreciation_depreciation_ref_id']          = array();
			$detailrecords['daily_performance_ref_id']          = array();
			$detailrecords['review']                        = array();
			$detailrecords['assertion']                                 = array(); 
			$detailrecords['target']                                    = array(); 
			$detailrecords['achievement']                               = array(); 
			$detailrecords['employee_rating']                           = array(); 
		}
		
		return $detailrecords;
	}

	// Update appdep
	public function updateAppDep($mysqli, $id, $userid){

		if(isset($_POST['review'])){
			$review = $_POST['review'];
		}
		if(isset($_POST['company_name'])){
			$company_id = $_POST['company_name'];
		}
		if(isset($_POST['mySelectedDeptName'])){
			$department_id = $_POST['mySelectedDeptName'];
		}
		if(isset($_POST['mySelectedDesgnName'])){
			$designation_id = $_POST['mySelectedDesgnName'];
		}
		if(isset($_POST['mySelectedStaffName'])){
			$emp_id = $_POST['mySelectedStaffName'];
		}
		if(isset($_POST['month'])){
			$yearmonthsplit = explode('-',$_POST["month"]); //format('yyyy-mm'); // we want month only so split month here.
    		$month = intval($yearmonthsplit[1]);
    		$year_id = intval($yearmonthsplit[0]);
		}  

		if(isset($_POST['daily_performance_ref_id'])){
			$daily_performance_ref_id = $_POST['daily_performance_ref_id']; 
		} 
		if(isset($_POST['assertion'])){
			$assertion = $_POST['assertion'];
		} 
		if(isset($_POST['target'])){
			$target = $_POST['target'];
		} 
		if(isset($_POST['overall_performance'])){
			$overall_performance1 = $_POST['overall_performance'];
			$overall_performance = str_replace("Total Satisfied - ", "", $overall_performance1);
		} 
		if(isset($_POST['not_done'])){
			$not_done1 = $_POST['not_done'];
			$not_done = str_replace("Total Not Done - ", "", $not_done1);
		} 
		if(isset($_POST['achievement'])){
			$achievement = $_POST['achievement'];
		} 
		if(isset($_POST['employee_rating'])){
			$employee_rating = $_POST['employee_rating'];
		} 
		if(isset($_POST['strength'])){
			$strength = $_POST['strength'];
		} 
		if(isset($_POST['weakness'])){
			$weakness = $_POST['weakness'];
		} 
		if(isset($_POST['need_for_improvement'])){
			$need_for_improvement = $_POST['need_for_improvement'];
		} 
		if(isset($_POST['overall_rating'])){
			$overall_rating = $_POST['overall_rating'];
		} 
		if(isset($_POST['appreciation_depreciation_ref_id'])){
			$appreciation_depreciation_ref_id = $_POST['appreciation_depreciation_ref_id'];
		} 

		$qry = "UPDATE appreciation_depreciation SET company_id = '".strip_tags($company_id)."', department_id = '".strip_tags($department_id)."', designation_id = '".strip_tags($designation_id)."', emp_id = '".strip_tags($emp_id)."', year_id = '".strip_tags($year_id)."', month = '".strip_tags($month)."', overall_performance = '".strip_tags($overall_performance)."', not_done = '".strip_tags($not_done)."', strength = '".strip_tags($strength)."', weakness = '".strip_tags($weakness)."', need_for_improvement = '".strip_tags($need_for_improvement)."', overall_rating = '".strip_tags($overall_rating)."', update_login_id='".strip_tags($userid)."', status = '0' WHERE appreciation_depreciation_id= '".strip_tags($id)."' ";
		$updresult = $mysqli->query($qry )or die ("Error in in update Query!.".$mysqli->error);

		for($i=0; $i<=sizeof($review)-1; $i++){
			$refQry = "UPDATE `appreciation_depreciation_ref` SET `review`='$review[$i]',`appreciation_depreciation_id`='$id',`daily_performance_ref_id`='$daily_performance_ref_id[$i]',`assertion`='$assertion[$i]',`target`='$target[$i]',`achievement`='$achievement[$i]',`employee_rating`='$employee_rating[$i]' WHERE `appreciation_depreciation_ref_id` = '$appreciation_depreciation_ref_id[$i]' "; 
			$refResult=$mysqli->query($refQry) or die("Error ".$mysqli->error);
		}

	}

	// Delete app dep
	public function deleteAppDep($mysqli, $id, $userid){

		$qry = "UPDATE appreciation_depreciation set status='1', delete_login_id='".strip_tags($userid)."' WHERE appreciation_depreciation_id = '".strip_tags($id)."' ";
		$runQry = $mysqli->query($qry) or die("Error in delete query".$mysqli->error);
	}

	// view app dep
	public function viewAppDep($mysqli){

		$appDep = "SELECT * FROM appreciation_depreciation WHERE review = 'midterm_review' ORDER BY appreciation_depreciation_id DESC LIMIT 1"; 
		$res = $mysqli->query($appDep) or die("Error in Get All Records".$mysqli->error);
		$detailrecords = array();
		if ($mysqli->affected_rows>0)
		{
			$row = $res->fetch_object();	
			$appreciationDepreciationId  							= $row->appreciation_depreciation_id;
			$detailrecords['appreciation_depreciation_id']          = $row->appreciation_depreciation_id; 
			$detailrecords['review']                 = $row->review;
			$detailrecords['company_id']             = $row->company_id;
			$detailrecords['department']             = $row->department_id;
			$detailrecords['designation']            = $row->designation_id; 	
			$detailrecords['emp_id']                 = $row->emp_id; 	
			$detailrecords['year_id']                = $row->year_id; 	
			$detailrecords['month']                  = $row->month; 	
			$detailrecords['overall_performance']    = $row->overall_performance; 	
			$detailrecords['not_done']               = $row->not_done; 	
			$detailrecords['carry_forward']          = $row->carry_forward; 	
			$detailrecords['strength']               = $row->strength; 	
			$detailrecords['weakness']               = $row->weakness; 	
			$detailrecords['need_for_improvement']   = $row->need_for_improvement; 	
			$detailrecords['overall_rating']         = $row->overall_rating; 	
		}
		
		$appreciationDepreciationRefId = 0;
		$appDepRef = "SELECT * FROM appreciation_depreciation_ref WHERE appreciation_depreciation_id='".mysqli_real_escape_string($mysqli, $appreciationDepreciationId)."' "; 
		$res1 = $mysqli->query($appDepRef) or die("Error in Get All Records".$mysqli->error);
		if ($mysqli->affected_rows>0)
		{
			while($row1 = $res1->fetch_object()){

				$appreciationDepreciationRefId         			= $row1->appreciation_depreciation_ref_id;  
				$appreciation_depreciation_ref_id[]     	    = $row1->appreciation_depreciation_ref_id; 
				$daily_performance_ref_id[]     	            = $row1->daily_performance_ref_id; 
				$assertion[]                                    = $row1->assertion;
				$target[]                                       = $row1->target;
				$achievement[]                                  = $row1->achievement;
				$employee_rating[]                              = $row1->employee_rating;
			} 
		}
		if($appreciationDepreciationRefId > 0)
		{
			$detailrecords['appreciation_depreciation_ref_id']          = $appreciation_depreciation_ref_id;  
			$detailrecords['daily_performance_ref_id']                  = $daily_performance_ref_id;  
			$detailrecords['assertion']                                 = $assertion;  	
			$detailrecords['target']                                    = $target;  	
			$detailrecords['achievement']                               = $achievement;  	
			$detailrecords['employee_rating']                           = $employee_rating;  	
		}
		else
		{
			$detailrecords['appreciation_depreciation_ref_id']          = array();
			$detailrecords['daily_performance_ref_id']                  = array();
			$detailrecords['assertion']                                 = array(); 
			$detailrecords['target']                                    = array(); 
			$detailrecords['achievement']                               = array(); 
			$detailrecords['employee_rating']                           = array(); 
		}
		
		return $detailrecords;
	}

		// Add User
		public function adduser($mysqli){

			if(isset($_POST['designation_id'])){
				$designation = $_POST['designation_id'];
			}
			if(isset($_POST['mobilenumber'])){
				$mobile_number = $_POST['mobilenumber'];
			}
			if(isset($_POST['email'])){
				$email_id = $_POST['email'];
			}
			if(isset($_POST['staff_name'])){
				$staff_id = $_POST['staff_name'];
			}

			$fullname = '';
			$qry = "SELECT * FROM staff_creation WHERE staff_id = '".strip_tags($staff_id)."' AND status=0";
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object())
				{
					$fullname        = strip_tags($row->staff_name);
				}
			}

			if(isset($_POST['password'])){
				$password = $_POST['password'];
			}
			if(isset($_POST['role'])){
				$role = $_POST['role'];
			}
			if(isset($_POST['branch_id'])){
				$branch_id = $_POST['branch_id'];
			}
			if(isset($_POST['username'])){
				$username = $_POST['username'];
			}
			
			if(isset($_POST['administration_module']) &&    $_POST['administration_module'] == 'Yes')		
			{
				$administration_module=0;
			}else{
				$administration_module=1;
			}
			if(isset($_POST['dashboard']) &&    $_POST['dashboard'] == 'Yes')		
			{
				$dashboard=0;
			}else{
				$dashboard=1;
			}
			if(isset($_POST['company_creation']) &&    $_POST['company_creation'] == 'Yes')		
			{
				$company_creation=0;
			}else{
				$company_creation=1;
			}
			if(isset($_POST['branch_creation']) &&    $_POST['branch_creation'] == 'Yes')		
			{
				$branch_creation=0;
			}else{
				$branch_creation=1;
			}
			if(isset($_POST['holiday_creation']) &&    $_POST['holiday_creation'] == 'Yes')		
			{
				$holiday_creation=0;
			}else{
				$holiday_creation=1;
			}
			if(isset($_POST['manage_users']) &&    $_POST['manage_users'] == 'Yes')		
			{
				$manage_users=0;
			}else{
				$manage_users=1;
			}
			if(isset($_POST['master_module']) &&    $_POST['master_module'] == 'Yes')		
			{
				$master_module=0;
			}else{
				$master_module=1;
			}
			if(isset($_POST['basic_sub_module']) &&    $_POST['basic_sub_module'] == 'Yes')		
			{
				$basic_sub_module=0;
			}else{
				$basic_sub_module=1;
			}
			if(isset($_POST['responsibility_sub_module']) &&    $_POST['responsibility_sub_module'] == 'Yes')		
			{
				$responsibility_sub_module=0;
			}else{
				$responsibility_sub_module=1;
			}
			if(isset($_POST['audit_module']) &&    $_POST['audit_module'] == 'Yes')		
			{
				$audit_sub_module=0;
			}else{
				$audit_sub_module=1;
			}
			if(isset($_POST['others_sub_module']) &&    $_POST['others_sub_module'] == 'Yes')		
			{
				$others_sub_module=0;
			}else{
				$others_sub_module=1;
			}
			if(isset($_POST['basic_creation']) &&    $_POST['basic_creation'] == 'Yes')		
			{
				$basic_creation=0;
			}else{
				$basic_creation=1;
			}
			if(isset($_POST['tag_creation']) &&    $_POST['tag_creation'] == 'Yes')		
			{
				$tag_creation=0;
			}else{
				$tag_creation=1;
			}
			if(isset($_POST['rr_creation']) &&    $_POST['rr_creation'] == 'Yes')		
			{
				$rr_creation=0;
			}else{
				$rr_creation=1;
			}
			if(isset($_POST['kra_category']) &&    $_POST['kra_category'] == 'Yes')		
			{
				$kra_category=0;
			}else{
				$kra_category=1;
			}
			if(isset($_POST['krakpi_creation']) &&    $_POST['krakpi_creation'] == 'Yes')		
			{
				$krakpi_creation=0;
			}else{
				$krakpi_creation=1;
			}
			if(isset($_POST['staff_creation']) &&    $_POST['staff_creation'] == 'Yes')		
			{
				$staff_creation=0;
			}else{
				$staff_creation=1;
			}
			if(isset($_POST['audit_area_creation']) &&    $_POST['audit_area_creation'] == 'Yes')		
			{
				$audit_area_creation=0;
			}else{
				$audit_area_creation=1;
			}
			if(isset($_POST['audit_area_checklist']) &&    $_POST['audit_area_checklist'] == 'Yes')		
			{
				$audit_area_checklist=0;
			}else{
				$audit_area_checklist=1;
			}
			if(isset($_POST['audit_assign']) &&    $_POST['audit_assign'] == 'Yes')		
			{
				$audit_assign=0;
			}else{
				$audit_assign=1;
			}
			if(isset($_POST['audit_follow_up']) &&    $_POST['audit_follow_up'] == 'Yes')		
			{
				$audit_follow_up=0;
			}else{
				$audit_follow_up=1;
			}
			if(isset($_POST['report_template']) &&    $_POST['report_template'] == 'Yes')		
			{
				$report_template=0;
			}else{
				$report_template=1;
			}
			if(isset($_POST['media_master']) &&    $_POST['media_master'] == 'Yes')		
			{
				$media_master=0;
			}else{
				$media_master=1;
			}
			if(isset($_POST['asset_creation']) &&    $_POST['asset_creation'] == 'Yes')		
			{
				$asset_creation=0;
			}else{
				$asset_creation=1;
			}
			if(isset($_POST['insurance_register']) &&    $_POST['insurance_register'] == 'Yes')		
			{
				$insurance_register=0;
			}else{
				$insurance_register=1;
			}
			if(isset($_POST['service_indent']) &&    $_POST['service_indent'] == 'Yes')		
			{
				$service_indent=0;
			}else{
				$service_indent=1;
			}
			if(isset($_POST['asset_details']) &&    $_POST['asset_details'] == 'Yes')		
			{
				$asset_details=0;
			}else{
				$asset_details=1;
			}
			if(isset($_POST['rgp_creation']) &&    $_POST['rgp_creation'] == 'Yes')		
			{
				$rgp_creation=0;
			}else{
				$rgp_creation=1;
			}
			if(isset($_POST['promotional_activities']) &&    $_POST['promotional_activities'] == 'Yes')		
			{
				$promotional_activities=0;
			}else{
				$promotional_activities=1;
			}
			if(isset($_POST['work_force_module']) &&    $_POST['work_force_module'] == 'Yes')		
			{
				$work_force_module=0;
			}else{
				$work_force_module=1;
			}
			if(isset($_POST['schedule_task_sub_module']) &&    $_POST['schedule_task_sub_module'] == 'Yes')		
			{
				$schedule_task_sub_module=0;
			}else{
				$schedule_task_sub_module=1;
			}
			if(isset($_POST['memo_sub_module']) &&    $_POST['memo_sub_module'] == 'Yes')		
			{
				$memo_sub_module=0;
			}else{
				$memo_sub_module=1;
			}
			if(isset($_POST['campaign']) &&    $_POST['campaign'] == 'Yes')		
			{
				$campaign=0;
			}else{
				$campaign=1;
			}
			if(isset($_POST['assign_work']) &&    $_POST['assign_work'] == 'Yes')		
			{
				$assign_work=0;
			}else{
				$assign_work=1;
			}
			if(isset($_POST['daily_task_update']) &&    $_POST['daily_task_update'] == 'Yes')		
			{
				$daily_task_update=0;
			}else{
				$daily_task_update=1;
			}
			if(isset($_POST['todo']) &&    $_POST['todo'] == 'Yes')		
			{
				$todo=0;
			}else{
				$todo=1;
			}
			if(isset($_POST['assigned_work']) &&    $_POST['assigned_work'] == 'Yes')		
			{
				$assigned_work=0;
			}else{
				$assigned_work=1;
			}
			if(isset($_POST['memo_initiate']) &&    $_POST['memo_initiate'] == 'Yes')		
			{
				$memo_initiate=0;
			}else{
				$memo_initiate=1;
			}
			if(isset($_POST['memo_assigned']) &&    $_POST['memo_assigned'] == 'Yes')		
			{
				$memo_assigned=0;
			}else{
				$memo_assigned=1;
			}
			if(isset($_POST['memo_update']) &&    $_POST['memo_update'] == 'Yes')		
			{
				$memo_update=0;
			}else{
				$memo_update=1;
			}
			if(isset($_POST['maintenance_module']) &&    $_POST['maintenance_module'] == 'Yes')		
			{
				$maintenance_module=0;
			}else{
				$maintenance_module=1;
			}
			if(isset($_POST['pm_checklist']) &&    $_POST['pm_checklist'] == 'Yes')		
			{
				$pm_checklist=0;
			}else{
				$pm_checklist=1;
			}
			if(isset($_POST['bm_checklist']) &&    $_POST['bm_checklist'] == 'Yes')		
			{
				$bm_checklist=0;
			}else{
				$bm_checklist=1;
			}
			if(isset($_POST['maintenance_checklist']) &&    $_POST['maintenance_checklist'] == 'Yes')		
			{
				$maintenance_checklist=0;
			}else{
				$maintenance_checklist=1;
			}
			if(isset($_POST['manpower_in_out_module']) &&    $_POST['manpower_in_out_module'] == 'Yes')		
			{
				$manpower_in_out_module=0;
			}else{
				$manpower_in_out_module=1;
			}
			if(isset($_POST['permission_or_onduty']) &&    $_POST['permission_or_onduty'] == 'Yes')		
			{
				$permission_or_onduty=0;
			}else{
				$permission_or_onduty=1;
			}
			if(isset($_POST['regularisation_approval']) &&    $_POST['regularisation_approval'] == 'Yes')		
			{
				$regularisation_approval=0;
			}else{
				$regularisation_approval=1;
			}
			if(isset($_POST['transfer_location']) &&    $_POST['transfer_location'] == 'Yes')		
			{
				$transfer_location=0;
			}else{
				$transfer_location=1;
			}
			if(isset($_POST['target_fixing_module']) &&    $_POST['target_fixing_module'] == 'Yes')		
			{
				$target_fixing_module=0;
			}else{
				$target_fixing_module=1;
			}
			if(isset($_POST['goal_setting']) &&    $_POST['goal_setting'] == 'Yes')		
			{
				$goal_setting=0;
			}else{
				$goal_setting=1;
			}
			if(isset($_POST['daily_performance']) &&    $_POST['daily_performance'] == 'Yes')		
			{
				$daily_performance=0;
			}else{
				$daily_performance=1;
			}
			if(isset($_POST['daily_performance_review']) &&    $_POST['daily_performance_review'] == 'Yes')		
			{
				$daily_performance_review=0;
			}else{
				$daily_performance_review=1;
			}
			if(isset($_POST['appreciation_depreciation']) &&    $_POST['appreciation_depreciation'] == 'Yes')		
			{
				$appreciation_depreciation=0;
			}else{
				$appreciation_depreciation=1;
			}
			if(isset($_POST['vehicle_management_module']) &&    $_POST['vehicle_management_module'] == 'Yes')		
			{
				$vehicle_management_module=0;
			}else{
				$vehicle_management_module=1;
			}
			if(isset($_POST['vehicle_details']) &&    $_POST['vehicle_details'] == 'Yes')		
			{
				$vehicle_details=0;
			}else{
				$vehicle_details=1;
			}
			if(isset($_POST['daily_km']) &&    $_POST['daily_km'] == 'Yes')		
			{
				$daily_km=0;
			}else{
				$daily_km=1;
			}
			if(isset($_POST['diesel_slip']) &&    $_POST['diesel_slip'] == 'Yes')		
			{
				$diesel_slip=0;
			}else{
				$diesel_slip=1;
			}
			if(isset($_POST['approval_mechanism_module']) &&    $_POST['approval_mechanism_module'] == 'Yes')		
			{
				$approval_mechanism_module=0;
			}else{
				$approval_mechanism_module=1;
			}
			if(isset($_POST['approval_requisition']) &&    $_POST['approval_requisition'] == 'Yes')		
			{
				$approval_requisition=0;
			}else{
				$approval_requisition=1;
			}
			if(isset($_POST['business_communication_outgoing']) &&    $_POST['business_communication_outgoing'] == 'Yes')		
			{
				$business_communication_outgoing=0;
			}else{
				$business_communication_outgoing=1;
			}
			if(isset($_POST['minutes_of_meeting']) &&    $_POST['minutes_of_meeting'] == 'Yes')		
			{
				$minutes_of_meeting=0;
			}else{
				$minutes_of_meeting=1;
			}
			if(isset($_POST['report_module']) &&    $_POST['report_module'] == 'Yes')		
			{
				$report_module=0;
			}else{
				$report_module=1;
			}
			if(isset($_POST['reports']) &&    $_POST['reports'] == 'Yes')		
			{
				$reports=0;
			}else{
				$reports=1;
			}
			if(isset($_POST['daily_performance_report']) &&    $_POST['daily_performance_report'] == 'Yes')		
			{
				$daily_performance_report=0;
			}else{
				$daily_performance_report=1;
			}
			if(isset($_POST['venhicle_management_sub_module']) &&    $_POST['venhicle_management_sub_module'] == 'Yes')		
			{
				$venhicle_management_sub_module=0;
			}else{
				$venhicle_management_sub_module=1;
			}
			if(isset($_POST['vehicle_report']) &&    $_POST['vehicle_report'] == 'Yes')		
			{
				$vehicle_report=0;
			}else{
				$vehicle_report=1;
			}
			if(isset($_POST['daily_km_report']) &&    $_POST['daily_km_report'] == 'Yes')		
			{
				$daily_km_report=0;
			}else{
				$daily_km_report=1;
			}
			if(isset($_POST['diesel_slip_report']) &&    $_POST['diesel_slip_report'] == 'Yes')		
			{
				$diesel_slip_report=0;
			}else{
				$diesel_slip_report=1;
			}
			if(isset($_POST['memo_report']) &&    $_POST['memo_report'] == 'Yes')		
			{
				$memo_report=0;
			}else{
				$memo_report=1;
			}
			if(isset($_POST['krakpi_report']) &&    $_POST['krakpi_report'] == 'Yes')		
			{
				$krakpi_report=0;
			}else{
				$krakpi_report=1;
			}
			if(isset($_POST['staff_task_details']) &&    $_POST['staff_task_details'] == 'Yes')		
			{
				$staff_task_details=0;
			}else{
				$staff_task_details=1;
			}
		
			$userInsert="INSERT INTO user (emailid, user_name, designation_id, mobile_number, user_password, role, branch_id, staff_id, fullname, Createddate, administration_module, dashboard, company_creation, branch_creation, holiday_creation, manage_users, master_module, basic_sub_module, responsibility_sub_module, audit_sub_module, others_sub_module, 
			basic_creation, tag_creation, rr_creation, kra_category, krakpi_creation, staff_creation, audit_area_creation, audit_area_checklist, audit_assign, audit_follow_up, 
			report_template, media_master, asset_creation, insurance_register, service_indent, asset_details, rgp_creation, promotional_activities, work_force_module, schedule_task_sub_module, memo_sub_module, campaign,assign_work,daily_task_update, todo, assigned_work, memo_initiate, memo_assigned, memo_update, maintenance_module, pm_checklist, bm_checklist, maintenance_checklist, manpower_in_out_module, permission_or_onduty, regularisation_approval, transfer_location, target_fixing_module, goal_setting, daily_performance, daily_performance_review, appreciation_depreciation, vehicle_management_module, vehicle_details, daily_km, diesel_slip, approval_mechanism_module, approval_requisition, business_communication_outgoing, minutes_of_meeting, report_module, reports, daily_performance_report, vehicle_management_report_module, vehicle_report, daily_km_report, diesel_slip_report, memo_report, krakpi_report, staff_task_details) VALUES ('".strip_tags($email_id)."', '".strip_tags($username)."', '".strip_tags($designation)."', '".strip_tags($mobile_number)."', '".strip_tags($password)."', '".strip_tags($role)."', '".strip_tags($branch_id)."', '".strip_tags($staff_id)."', '".strip_tags($fullname)."', current_timestamp(), $administration_module, $dashboard, $company_creation, $branch_creation, $holiday_creation, $manage_users, $master_module, $basic_sub_module, $responsibility_sub_module, $audit_sub_module, $others_sub_module, $basic_creation, $tag_creation, $rr_creation, $kra_category, $krakpi_creation, $staff_creation, $audit_area_creation, $audit_area_checklist, $audit_assign, $audit_follow_up, $report_template, $media_master, $asset_creation, $insurance_register, $service_indent, $asset_details, $rgp_creation, $promotional_activities, $work_force_module, $schedule_task_sub_module, $memo_sub_module, $campaign, $assign_work, $daily_task_update, $todo, $assigned_work, $memo_initiate, $memo_assigned, $memo_update, $maintenance_module, $pm_checklist, $bm_checklist, $maintenance_checklist, $manpower_in_out_module, $permission_or_onduty, $regularisation_approval, $transfer_location, $target_fixing_module, $goal_setting, $daily_performance, $daily_performance_review, $appreciation_depreciation, $vehicle_management_module, $vehicle_details, $daily_km, $diesel_slip,  $approval_mechanism_module, $approval_requisition, $business_communication_outgoing, $minutes_of_meeting, $report_module, $reports, $daily_performance_report, $venhicle_management_sub_module, $vehicle_report, $daily_km_report, $diesel_slip_report, $memo_report, $krakpi_report, $staff_task_details )";
			$insresult=$mysqli->query($userInsert) or die("Error ".$mysqli->error);
			
		}

		// get user table for manage users
		public function getmanageuser($mysqli,$idupd) 
		{
			$qry = "SELECT * FROM user WHERE user_id='".mysqli_real_escape_string($mysqli,$idupd)."' "; 
			$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
			$detailrecords = array();
			if ($mysqli->affected_rows>0)
			{
				$row = $res->fetch_object();	
				$detailrecords['user_id']                    = $row->user_id; 
				$detailrecords['user_name']       	        = strip_tags($row->user_name);
				$detailrecords['designation_id']       	        = strip_tags($row->designation_id);

				$getDesignation = $mysqli->query("SELECT designation_name FROM designation_creation WHERE designation_id = '".strip_tags($row->designation_id)."' ");
				$fetchDesignation = $getDesignation->fetch_assoc();
				if ($mysqli->affected_rows>0)
				{
				$detailrecords['designation_name'] = $fetchDesignation['designation_name'];
				}else{
					$detailrecords['designation_name'] ='';
				}
				$detailrecords['mobile_number']       	        = strip_tags($row->mobile_number);
				$detailrecords['staff_id']       	        = strip_tags($row->staff_id);
				$detailrecords['branch_id']       	        = strip_tags($row->branch_id);
				$detailrecords['emailid']       	        = strip_tags($row->emailid);
				$detailrecords['user_password']              = strip_tags($row->user_password);		  	
				$detailrecords['role']              = strip_tags($row->role);		  	
				$detailrecords['status']                     = strip_tags($row->status);

				$detailrecords['administration_module']    = strip_tags($row->administration_module);
				$detailrecords['dashboard']      = strip_tags($row->dashboard);
				$detailrecords['company_creation'] = strip_tags($row->company_creation);
				$detailrecords['branch_creation'] = strip_tags($row->branch_creation);
				$detailrecords['holiday_creation'] = strip_tags($row->holiday_creation);
				$detailrecords['manage_users']   = strip_tags($row->manage_users);
				$detailrecords['master_module']   = strip_tags($row->master_module);
				$detailrecords['basic_sub_module']        = strip_tags($row->basic_sub_module);
				$detailrecords['responsibility_sub_module']         = strip_tags($row->responsibility_sub_module);
				$detailrecords['audit_sub_module'] = strip_tags($row->audit_sub_module);
				$detailrecords['others_sub_module'] = strip_tags($row->others_sub_module);
				$detailrecords['basic_creation'] = strip_tags($row->basic_creation);
				$detailrecords['tag_creation'] = strip_tags($row->tag_creation);
				$detailrecords['rr_creation'] = strip_tags($row->rr_creation);
				$detailrecords['kra_category'] = strip_tags($row->kra_category);
				$detailrecords['krakpi_creation']  = strip_tags($row->krakpi_creation);
				$detailrecords['staff_creation'] = strip_tags($row->staff_creation);
				$detailrecords['audit_area_creation']  = strip_tags($row->audit_area_creation);
				$detailrecords['audit_area_checklist']    = strip_tags($row->audit_area_checklist);
				$detailrecords['audit_assign'] = strip_tags($row->audit_assign);
				$detailrecords['audit_follow_up'] = strip_tags($row->audit_follow_up);
				$detailrecords['report_template']  = strip_tags($row->report_template);
				$detailrecords['media_master']  = strip_tags($row->media_master);
				$detailrecords['asset_creation'] = strip_tags($row->asset_creation);
				$detailrecords['insurance_register'] = strip_tags($row->insurance_register);
				$detailrecords['service_indent']   = strip_tags($row->service_indent);
				$detailrecords['asset_details']    = strip_tags($row->asset_details);
				$detailrecords['rgp_creation']      = strip_tags($row->rgp_creation);
				$detailrecords['promotional_activities']    = strip_tags($row->promotional_activities);
				$detailrecords['work_force_module']  = strip_tags($row->work_force_module);
				$detailrecords['schedule_task_sub_module']        = strip_tags($row->schedule_task_sub_module);
				$detailrecords['memo_sub_module']      = strip_tags($row->memo_sub_module);
				$detailrecords['campaign']        = strip_tags($row->campaign);
				$detailrecords['assign_work'] = strip_tags($row->assign_work);
				$detailrecords['daily_task_update'] = strip_tags($row->daily_task_update);
				$detailrecords['todo'] = strip_tags($row->todo);
				$detailrecords['assigned_work']    = strip_tags($row->assigned_work);
				$detailrecords['memo_initiate']        = strip_tags($row->memo_initiate);
				$detailrecords['memo_assigned']        = strip_tags($row->memo_assigned);
				$detailrecords['memo_update'] = strip_tags($row->memo_update);
				$detailrecords['maintenance_module']    = strip_tags($row->maintenance_module);
				$detailrecords['pm_checklist']    = strip_tags($row->pm_checklist);
				$detailrecords['bm_checklist']   = strip_tags($row->bm_checklist);
				$detailrecords['maintenance_checklist']     = strip_tags($row->maintenance_checklist);
				$detailrecords['manpower_in_out_module'] = strip_tags($row->manpower_in_out_module);
				$detailrecords['permission_or_onduty']    = strip_tags($row->permission_or_onduty);
				$detailrecords['regularisation_approval']    = strip_tags($row->regularisation_approval);
				$detailrecords['transfer_location']    = strip_tags($row->transfer_location);
				$detailrecords['target_fixing_module']  = strip_tags($row->target_fixing_module);
				$detailrecords['goal_setting']      = strip_tags($row->goal_setting);
				$detailrecords['daily_performance']    = strip_tags($row->daily_performance);
				$detailrecords['daily_performance_review']    = strip_tags($row->daily_performance_review);
				$detailrecords['appreciation_depreciation']    = strip_tags($row->appreciation_depreciation);
				$detailrecords['vehicle_management_module']    = strip_tags($row->vehicle_management_module);
				$detailrecords['vehicle_details']    = strip_tags($row->vehicle_details);
				$detailrecords['daily_km']    = strip_tags($row->daily_km);
				$detailrecords['diesel_slip']    = strip_tags($row->diesel_slip);
				$detailrecords['approval_mechanism_module']    = strip_tags($row->approval_mechanism_module);
				$detailrecords['approval_requisition']    = strip_tags($row->approval_requisition);
				$detailrecords['business_communication_outgoing']    = strip_tags($row->business_communication_outgoing);
				$detailrecords['minutes_of_meeting']    = strip_tags($row->minutes_of_meeting);
				$detailrecords['report_module']      = strip_tags($row->report_module);
				$detailrecords['reports']      = strip_tags($row->reports);
				$detailrecords['daily_performance_report']      = strip_tags($row->daily_performance_report);
				$detailrecords['vehicle_management_report_module']      = strip_tags($row->vehicle_management_report_module);
				$detailrecords['vehicle_report']      = strip_tags($row->vehicle_report);
				$detailrecords['daily_km_report']      = strip_tags($row->daily_km_report);
				$detailrecords['diesel_slip_report']      = strip_tags($row->diesel_slip_report);
				$detailrecords['memo_report']      = strip_tags($row->memo_report);
				$detailrecords['krakpi_report']      = strip_tags($row->krakpi_report);
				$detailrecords['staff_task_details']      = $row->staff_task_details;
		
			}
			return $detailrecords;
		}
		

		// Update User
	public function updateuser($mysqli,$id){

		if(isset($_POST['designation_id'])){
			$designation = $_POST['designation_id'];
		}
		if(isset($_POST['mobilenumber'])){
			$mobile_number = $_POST['mobilenumber'];
		}
		if(isset($_POST['email'])){
			$email_id = $_POST['email'];
		}
		if(isset($_POST['staff_name'])){
			$staff_id = $_POST['staff_name'];
		}

		$fullname = '';
		$qry = "SELECT * FROM staff_creation WHERE staff_id = '".strip_tags($staff_id)."' AND status=0";
		$res =$mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
		if ($mysqli->affected_rows>0)
		{
			while($row = $res->fetch_object())
			{
				$fullname        = strip_tags($row->staff_name);
			}
		}

		if(isset($_POST['password'])){
			$password = $_POST['password'];
		}
		if(isset($_POST['role'])){
			$role = $_POST['role'];
		}
		if(isset($_POST['branch_id'])){
			$branch_id = $_POST['branch_id'];
		}
		if(isset($_POST['username'])){
			$username = $_POST['username'];
		}
		
		if(isset($_POST['administration_module']) &&    $_POST['administration_module'] == 'Yes')		
		{
			$administration_module=0;
		}else{
			$administration_module=1;
		}
		if(isset($_POST['dashboard']) &&    $_POST['dashboard'] == 'Yes')		
		{
			$dashboard=0;
		}else{
			$dashboard=1;
		}
		if(isset($_POST['company_creation']) &&    $_POST['company_creation'] == 'Yes')		
		{
			$company_creation=0;
		}else{
			$company_creation=1;
		}
		if(isset($_POST['branch_creation']) &&    $_POST['branch_creation'] == 'Yes')		
		{
			$branch_creation=0;
		}else{
			$branch_creation=1;
		}
		if(isset($_POST['holiday_creation']) &&    $_POST['holiday_creation'] == 'Yes')		
		{
			$holiday_creation=0;
		}else{
			$holiday_creation=1;
		}
		if(isset($_POST['manage_users']) &&    $_POST['manage_users'] == 'Yes')		
		{
			$manage_users=0;
		}else{
			$manage_users=1;
		}
		if(isset($_POST['master_module']) &&    $_POST['master_module'] == 'Yes')		
		{
			$master_module=0;
		}else{
			$master_module=1;
		}
		if(isset($_POST['basic_sub_module']) &&    $_POST['basic_sub_module'] == 'Yes')		
		{
			$basic_sub_module=0;
		}else{
			$basic_sub_module=1;
		}
		if(isset($_POST['responsibility_sub_module']) &&    $_POST['responsibility_sub_module'] == 'Yes')		
		{
			$responsibility_sub_module=0;
		}else{
			$responsibility_sub_module=1;
		}
		if(isset($_POST['audit_module']) &&    $_POST['audit_module'] == 'Yes')		
		{
			$audit_sub_module=0;
		}else{
			$audit_sub_module=1;
		}
		if(isset($_POST['others_sub_module']) &&    $_POST['others_sub_module'] == 'Yes')		
		{
			$others_sub_module=0;
		}else{
			$others_sub_module=1;
		}
		if(isset($_POST['basic_creation']) &&    $_POST['basic_creation'] == 'Yes')		
		{
			$basic_creation=0;
		}else{
			$basic_creation=1;
		}
		if(isset($_POST['tag_creation']) &&    $_POST['tag_creation'] == 'Yes')		
		{
			$tag_creation=0;
		}else{
			$tag_creation=1;
		}
		if(isset($_POST['rr_creation']) &&    $_POST['rr_creation'] == 'Yes')		
		{
			$rr_creation=0;
		}else{
			$rr_creation=1;
		}
		if(isset($_POST['kra_category']) &&    $_POST['kra_category'] == 'Yes')		
		{
			$kra_category=0;
		}else{
			$kra_category=1;
		}
		if(isset($_POST['krakpi_creation']) &&    $_POST['krakpi_creation'] == 'Yes')		
		{
			$krakpi_creation=0;
		}else{
			$krakpi_creation=1;
		}
		if(isset($_POST['staff_creation']) &&    $_POST['staff_creation'] == 'Yes')		
		{
			$staff_creation=0;
		}else{
			$staff_creation=1;
		}
		if(isset($_POST['audit_area_creation']) &&    $_POST['audit_area_creation'] == 'Yes')		
		{
			$audit_area_creation=0;
		}else{
			$audit_area_creation=1;
		}
		if(isset($_POST['audit_area_checklist']) &&    $_POST['audit_area_checklist'] == 'Yes')		
		{
			$audit_area_checklist=0;
		}else{
			$audit_area_checklist=1;
		}
		if(isset($_POST['audit_assign']) &&    $_POST['audit_assign'] == 'Yes')		
		{
			$audit_assign=0;
		}else{
			$audit_assign=1;
		}
		if(isset($_POST['audit_follow_up']) &&    $_POST['audit_follow_up'] == 'Yes')		
		{
			$audit_follow_up=0;
		}else{
			$audit_follow_up=1;
		}
		if(isset($_POST['report_template']) &&    $_POST['report_template'] == 'Yes')		
		{
			$report_template=0;
		}else{
			$report_template=1;
		}
		if(isset($_POST['media_master']) &&    $_POST['media_master'] == 'Yes')		
		{
			$media_master=0;
		}else{
			$media_master=1;
		}
		if(isset($_POST['asset_creation']) &&    $_POST['asset_creation'] == 'Yes')		
		{
			$asset_creation=0;
		}else{
			$asset_creation=1;
		}
		if(isset($_POST['insurance_register']) &&    $_POST['insurance_register'] == 'Yes')		
		{
			$insurance_register=0;
		}else{
			$insurance_register=1;
		}
		if(isset($_POST['service_indent']) &&    $_POST['service_indent'] == 'Yes')		
		{
			$service_indent=0;
		}else{
			$service_indent=1;
		}
		if(isset($_POST['asset_details']) &&    $_POST['asset_details'] == 'Yes')		
		{
			$asset_details=0;
		}else{
			$asset_details=1;
		}
		if(isset($_POST['rgp_creation']) &&    $_POST['rgp_creation'] == 'Yes')		
		{
			$rgp_creation=0;
		}else{
			$rgp_creation=1;
		}
		if(isset($_POST['promotional_activities']) &&    $_POST['promotional_activities'] == 'Yes')		
		{
			$promotional_activities=0;
		}else{
			$promotional_activities=1;
		}
		if(isset($_POST['work_force_module']) &&    $_POST['work_force_module'] == 'Yes')		
		{
			$work_force_module=0;
		}else{
			$work_force_module=1;
		}
		if(isset($_POST['schedule_task_sub_module']) &&    $_POST['schedule_task_sub_module'] == 'Yes')		
		{
			$schedule_task_sub_module=0;
		}else{
			$schedule_task_sub_module=1;
		}
		if(isset($_POST['memo_sub_module']) &&    $_POST['memo_sub_module'] == 'Yes')		
		{
			$memo_sub_module=0;
		}else{
			$memo_sub_module=1;
		}
		if(isset($_POST['campaign']) &&    $_POST['campaign'] == 'Yes')		
		{
			$campaign=0;
		}else{
			$campaign=1;
		}
		if(isset($_POST['assign_work']) &&    $_POST['assign_work'] == 'Yes')		
		{
			$assign_work=0;
		}else{
			$assign_work=1;
		}
		if(isset($_POST['daily_task_update']) &&    $_POST['daily_task_update'] == 'Yes')		
		{
			$daily_task_update=0;
		}else{
			$daily_task_update=1;
		}
		if(isset($_POST['todo']) &&    $_POST['todo'] == 'Yes')		
		{
			$todo=0;
		}else{
			$todo=1;
		}
		if(isset($_POST['assigned_work']) &&    $_POST['assigned_work'] == 'Yes')		
		{
			$assigned_work=0;
		}else{
			$assigned_work=1;
		}
		if(isset($_POST['memo_initiate']) &&    $_POST['memo_initiate'] == 'Yes')		
		{
			$memo_initiate=0;
		}else{
			$memo_initiate=1;
		}
		if(isset($_POST['memo_assigned']) &&    $_POST['memo_assigned'] == 'Yes')		
		{
			$memo_assigned=0;
		}else{
			$memo_assigned=1;
		}
		if(isset($_POST['memo_update']) &&    $_POST['memo_update'] == 'Yes')		
		{
			$memo_update=0;
		}else{
			$memo_update=1;
		}
		if(isset($_POST['maintenance_module']) &&    $_POST['maintenance_module'] == 'Yes')		
		{
			$maintenance_module=0;
		}else{
			$maintenance_module=1;
		}
		if(isset($_POST['pm_checklist']) &&    $_POST['pm_checklist'] == 'Yes')		
		{
			$pm_checklist=0;
		}else{
			$pm_checklist=1;
		}
		if(isset($_POST['bm_checklist']) &&    $_POST['bm_checklist'] == 'Yes')		
		{
			$bm_checklist=0;
		}else{
			$bm_checklist=1;
		}
		if(isset($_POST['maintenance_checklist']) &&    $_POST['maintenance_checklist'] == 'Yes')		
		{
			$maintenance_checklist=0;
		}else{
			$maintenance_checklist=1;
		}
		if(isset($_POST['manpower_in_out_module']) &&    $_POST['manpower_in_out_module'] == 'Yes')		
		{
			$manpower_in_out_module=0;
		}else{
			$manpower_in_out_module=1;
		}
		if(isset($_POST['permission_or_onduty']) &&    $_POST['permission_or_onduty'] == 'Yes')		
		{
			$permission_or_onduty=0;
		}else{
			$permission_or_onduty=1;
		}
		if(isset($_POST['regularisation_approval']) &&    $_POST['regularisation_approval'] == 'Yes')		
		{
			$regularisation_approval=0;
		}else{
			$regularisation_approval=1;
		}
		if(isset($_POST['transfer_location']) &&    $_POST['transfer_location'] == 'Yes')		
		{
			$transfer_location=0;
		}else{
			$transfer_location=1;
		}
		if(isset($_POST['target_fixing_module']) &&    $_POST['target_fixing_module'] == 'Yes')		
		{
			$target_fixing_module=0;
		}else{
			$target_fixing_module=1;
		}
		if(isset($_POST['goal_setting']) &&    $_POST['goal_setting'] == 'Yes')		
		{
			$goal_setting=0;
		}else{
			$goal_setting=1;
		}
		if(isset($_POST['daily_performance']) &&    $_POST['daily_performance'] == 'Yes')		
		{
			$daily_performance=0;
		}else{
			$daily_performance=1;
		}
		if(isset($_POST['daily_performance_review']) &&    $_POST['daily_performance_review'] == 'Yes')		
		{
			$daily_performance_review=0;
		}else{
			$daily_performance_review=1;
		}
		if(isset($_POST['appreciation_depreciation']) &&    $_POST['appreciation_depreciation'] == 'Yes')		
		{
			$appreciation_depreciation=0;
		}else{
			$appreciation_depreciation=1;
		}
		if(isset($_POST['vehicle_management_module']) &&    $_POST['vehicle_management_module'] == 'Yes')		
		{
			$vehicle_management_module=0;
		}else{
			$vehicle_management_module=1;
		}
		if(isset($_POST['vehicle_details']) &&    $_POST['vehicle_details'] == 'Yes')		
		{
			$vehicle_details=0;
		}else{
			$vehicle_details=1;
		}
		if(isset($_POST['daily_km']) &&    $_POST['daily_km'] == 'Yes')		
		{
			$daily_km=0;
		}else{
			$daily_km=1;
		}
		if(isset($_POST['diesel_slip']) &&    $_POST['diesel_slip'] == 'Yes')		
		{
			$diesel_slip=0;
		}else{
			$diesel_slip=1;
		}
		if(isset($_POST['approval_mechanism_module']) &&    $_POST['approval_mechanism_module'] == 'Yes')		
		{
			$approval_mechanism_module=0;
		}else{
			$approval_mechanism_module=1;
		}
		if(isset($_POST['approval_requisition']) &&    $_POST['approval_requisition'] == 'Yes')		
		{
			$approval_requisition=0;
		}else{
			$approval_requisition=1;
		}
		if(isset($_POST['business_communication_outgoing']) &&    $_POST['business_communication_outgoing'] == 'Yes')		
		{
			$business_communication_outgoing=0;
		}else{
			$business_communication_outgoing=1;
		}
		if(isset($_POST['minutes_of_meeting']) &&    $_POST['minutes_of_meeting'] == 'Yes')		
		{
			$minutes_of_meeting=0;
		}else{
			$minutes_of_meeting=1;
		}
		if(isset($_POST['report_module']) &&    $_POST['report_module'] == 'Yes')		
		{
			$report_module=0;
		}else{
			$report_module=1;
		}
		if(isset($_POST['reports']) &&    $_POST['reports'] == 'Yes')		
		{
			$reports=0;
		}else{
			$reports=1;
		}
		if(isset($_POST['daily_performance_report']) &&    $_POST['daily_performance_report'] == 'Yes')		
		{
			$daily_performance_report=0;
		}else{
			$daily_performance_report=1;
		}
		if(isset($_POST['venhicle_management_sub_module']) &&    $_POST['venhicle_management_sub_module'] == 'Yes')		
		{
			$venhicle_management_sub_module=0;
		}else{
			$venhicle_management_sub_module=1;
		}
		if(isset($_POST['vehicle_report']) &&    $_POST['vehicle_report'] == 'Yes')		
		{
			$vehicle_report=0;
		}else{
			$vehicle_report=1;
		}
		if(isset($_POST['daily_km_report']) &&    $_POST['daily_km_report'] == 'Yes')		
		{
			$daily_km_report=0;
		}else{
			$daily_km_report=1;
		}
		if(isset($_POST['diesel_slip_report']) &&    $_POST['diesel_slip_report'] == 'Yes')		
		{
			$diesel_slip_report=0;
		}else{
			$diesel_slip_report=1;
		}
		if(isset($_POST['memo_report']) &&    $_POST['memo_report'] == 'Yes')		
		{
			$memo_report=0;
		}else{
			$memo_report=1;
		}
		if(isset($_POST['krakpi_report']) &&    $_POST['krakpi_report'] == 'Yes')		
		{
			$krakpi_report=0;
		}else{
			$krakpi_report=1;
		}
		if(isset($_POST['staff_task_details']) &&    $_POST['staff_task_details'] == 'Yes')		
		{
			$staff_task_details=0;
		}else{
			$staff_task_details=1;
		}
	
		$userupdate="UPDATE user SET 
		fullname='".strip_tags($fullname)."', 
		designation_id='".strip_tags($designation)."', 
		mobile_number='".strip_tags($mobile_number)."', 
		branch_id='".strip_tags($branch_id)."', 
		staff_id='".strip_tags($staff_id)."', 
		emailid='".strip_tags($email_id)."', 
		user_name='".strip_tags($username)."',
		user_password='".strip_tags($password)."', 
		role='".strip_tags($role)."',

		administration_module    = $administration_module,
		dashboard      = $dashboard,
		company_creation = $company_creation,
		branch_creation = $branch_creation,
		holiday_creation = $holiday_creation,
		manage_users   = $manage_users,
		master_module   = $master_module,
		basic_sub_module        = $basic_sub_module,
		responsibility_sub_module         = $responsibility_sub_module,
		audit_sub_module = $audit_sub_module,
		others_sub_module = $others_sub_module,
		basic_creation = $basic_creation,
		tag_creation = $tag_creation,
		rr_creation = $rr_creation,
		kra_category = $kra_category,
		krakpi_creation  = $krakpi_creation,
		staff_creation = $staff_creation,
		audit_area_creation  = $audit_area_creation,
		audit_area_checklist    = $audit_area_checklist,
		audit_assign = $audit_assign,
		audit_follow_up = $audit_follow_up,
		report_template  = $report_template,
		media_master  = $media_master,
		asset_creation = $asset_creation,
		insurance_register = $insurance_register,
		service_indent   = $service_indent,
		asset_details    = $asset_details,
		rgp_creation      = $rgp_creation,
		promotional_activities    = $promotional_activities,
		work_force_module  = $work_force_module,
		schedule_task_sub_module        = $schedule_task_sub_module,
		memo_sub_module      = $memo_sub_module,
		campaign        = $campaign,
		assign_work = $assign_work,
		daily_task_update = $daily_task_update,
		todo = $todo,
		assigned_work    = $assigned_work,
		memo_initiate        = $memo_initiate,
		memo_assigned        = $memo_assigned,
		memo_update = $memo_update,
		maintenance_module    = $maintenance_module,
		pm_checklist    = $pm_checklist,
		bm_checklist   = $bm_checklist,
		maintenance_checklist     = $maintenance_checklist,
		manpower_in_out_module = $manpower_in_out_module,
		permission_or_onduty    = $permission_or_onduty,
		regularisation_approval    = $regularisation_approval,
		transfer_location    = $transfer_location,
		target_fixing_module  = $target_fixing_module,
		goal_setting      = $goal_setting,
		daily_performance    = $daily_performance,
		daily_performance_review    = $daily_performance_review,
		appreciation_depreciation    = $appreciation_depreciation,
		vehicle_management_module    = $vehicle_management_module,
		vehicle_details    = $vehicle_details,
		daily_km    = $daily_km,
		diesel_slip    = $diesel_slip,
		approval_mechanism_module    = $approval_mechanism_module,
		approval_requisition    = $approval_requisition,
		business_communication_outgoing    = $business_communication_outgoing,
		minutes_of_meeting    = $minutes_of_meeting, 
		report_module      = $report_module,
		reports      = $reports,
		daily_performance_report      = $daily_performance_report,
		vehicle_management_report_module      = $venhicle_management_sub_module,
		vehicle_report      = $vehicle_report,
		daily_km_report      = $daily_km_report,
		diesel_slip_report      = $diesel_slip_report,
		memo_report      = $memo_report,
		krakpi_report      = $krakpi_report,
		staff_task_details      = $staff_task_details,
		status=0 where user_id = '".$id."' ";
		
		$update=$mysqli->query($userupdate) or die("Error ".$mysqli->error);
		
	}

	//  Delete User
	public function deleteuser($mysqli, $id){

		$userDelete = "UPDATE user set status='1' WHERE user_id = '".strip_tags($id)."' ";
		$runQry = $mysqli->query($userDelete) or die("Error in delete query".$mysqli->error);
	}




	//get company daily_performance table

public function get_daily_performance($mysqli){

	$dailyperform = "SELECT * FROM `company_creation` WHERE status='0'";
	
	$res = $mysqli->query($dailyperform) or die("Error in Get All Records".$mysqli->error);
	$dailyperform_list = array();
	$i=0;

	if ($mysqli->affected_rows>0)
	{
		while($row = $res->fetch_object()){
			

			$dailyperform_list[$i]['company_id']      = $row->company_id;
			$dailyperform_list[$i]['company_name']      = $row->company_name;
			
			$i++;
		}
	}

	return $dailyperform_list;
}
 
//get  deptn daily_performance table
public function get_dept_performance($mysqli){

	$dailyperform = "SELECT * FROM `department_creation` WHERE status='0'";
	
	$res = $mysqli->query($dailyperform) or die("Error in Get All Records".$mysqli->error);
	$dailyperformdept_list = array();
	$i=0;

	if ($mysqli->affected_rows>0)
	{
		while($row = $res->fetch_object()){
			

			$dailyperformdept_list[$i]['department_id']      = $row->department_id;
			$dailyperformdept_list[$i]['department_name']      = $row->department_name;
			
			$i++;
		}
	}

	return $dailyperformdept_list;
}


//get  role daily_performance table
public function get_role_performance($mysqli){

	$dailyperform = "SELECT * FROM `designation_creation` WHERE status='0'";
	
	$res = $mysqli->query($dailyperform) or die("Error in Get All Records".$mysqli->error);
	$dailyperformdesi_list = array();
	$i=0;

	if ($mysqli->affected_rows>0)
	{
		while($row = $res->fetch_object()){
			

			$dailyperformdesi_list[$i]['designation_id']      = $row->designation_id;
			$dailyperformdesi_list[$i]['designation_name']      = $row->designation_name;
			
			$i++;
		}
	}

	return $dailyperformdesi_list;
}
	// get company and role name
	public function getsroleDetail ($mysqli, $userid){
		$qry = "SELECT u.role,u.title,b.company_id,c.company_name, b.branch_id, b.branch_name, u.designation_id, sc.department, u.staff_id FROM user u LEFT JOIN branch_creation b ON b.branch_id=u.branch_id LEFT JOIN company_creation c ON c.company_id=b.company_id LEFT JOIN staff_creation sc ON u.staff_id = sc.staff_id WHERE u.user_id ='$userid' AND u.status=0 ORDER BY u.branch_id ASC";
		$res = $mysqli->query($qry)or die("Error in Get All Records".$mysqli->error);
		$detailrecords = array();
	   
		$i=0;
		if ($mysqli->affected_rows>0)
		{
			while($row = $res->fetch_object())
			{
				$detailrecords['role']          	= strip_tags($row->role);
				$detailrecords['title']          	= strip_tags($row->title);
				$detailrecords['company_id']        = strip_tags($row->company_id);
				$detailrecords['company_name']      = strip_tags($row->company_name);
				$detailrecords['branch_id']      	= strip_tags($row->branch_id);
				$detailrecords['branch_name']      	= strip_tags($row->branch_name);
				$detailrecords['department']        = strip_tags($row->department);
				$detailrecords['designation_id']    = strip_tags($row->designation_id);
				$detailrecords['staff_id']    = strip_tags($row->staff_id);
				$i++;
			}
		}
		return $detailrecords;
	}
	// get dailyperformance table
      public function getdailyperformance($mysqli,$id){

		$dailyperform = "SELECT dp.daily_performance_id,dp.company_id,c.company_name, dp.branch_id, bc.branch_name, dp.department_id,dc.department_name,dp.role_id,dsc.designation_name,dp.emp_id,s.staff_name,dp.month,dp.status FROM daily_performance dp LEFT JOIN company_creation c ON c.company_id=dp.company_id LEFT JOIN branch_creation bc ON dp.branch_id = bc.branch_id LEFT JOIN department_creation dc ON dc.department_id=dp.department_id LEFT JOIN designation_creation dsc ON dsc.designation_id = dp.role_id LEFT JOIN staff_creation s ON s.staff_id=dp.emp_id WHERE dp.daily_performance_id ='$id'";
		
		$res = $mysqli->query($dailyperform) or die("Error in Get All Records".$mysqli->error);
		$dailyperform_list = array();
		$i=0;

		if ($mysqli->affected_rows>0)
		{
			while($row = $res->fetch_object()){
			
				$dailyperform_list[$i]['daily_performance_id']      = $row->daily_performance_id;
				$dailyperform_list[$i]['company_id']      = $row->company_id;
				$dailyperform_list[$i]['company_name']      = $row->company_name;
				$dailyperform_list[$i]['branch_id']      = $row->branch_id;
				$dailyperform_list[$i]['branch_name']      = $row->branch_name;
				$dailyperform_list[$i]['department_id']      = $row->department_id;
				$dailyperform_list[$i]['department_name']      = $row->department_name;
				$dailyperform_list[$i]['role_id']      = $row->role_id;
				$dailyperform_list[$i]['designation_name']      = $row->designation_name;
				$dailyperform_list[$i]['emp_id']      = $row->emp_id;
				$dailyperform_list[$i]['staff_name']      = $row->staff_name;
                $dailyperform_list[$i]['month']      = $row->month;
				$dailyperform_list[$i]['status']      = $row->status;
				$emp_id      = $row->emp_id;
                $month      = $row->month;
				
				$i++;
			}
		}

        $dailyperform1 = "SELECT dpr.daily_performance_ref_id, dpr.assertion, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.goal_setting_id, dpr.goal_setting_ref_id, dpr.assertion_table_sno, dpr.status, dpr.manager_updated_status FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.emp_id ='$emp_id' AND dp.month = '$month' order by dpr.system_date ASC";
		
		$res1 = $mysqli->query($dailyperform1) or die("Error in Get All Records".$mysqli->error);
		$dailyperform_list1 = array();
		$i=0;

		if ($mysqli->affected_rows>0)
		{
			while($row1 = $res1->fetch_object()){
			
				$dailyperform_list1[$i]['daily_performance_ref_id']      = $row1->daily_performance_ref_id;
				$dailyperform_list1[$i]['assertion']      = $row1->assertion;	
				$dailyperform_list1[$i]['target']      = $row1->target;	
				$dailyperform_list1[$i]['actual_achieve']      = $row1->actual_achieve;	
				$dailyperform_list1[$i]['system_date']      = $row1->system_date;
				$dailyperform_list1[$i]['goal_setting_id']      = $row1->goal_setting_id;
				$dailyperform_list1[$i]['goal_setting_ref_id']      = $row1->goal_setting_ref_id;
				$dailyperform_list1[$i]['assertion_table_sno']      = $row1->assertion_table_sno;
				$dailyperform_list1[$i]['status']      = $row1->status;
				$dailyperform_list1[$i]['manager_updated_status']      = $row1->manager_updated_status;
				
				$i++;
			}
		}
        $response = array(
            'daily_performance_list' => $dailyperform_list,
            'daily_performance_ref_list' => $dailyperform_list1
          );
        
      
		return $response;
	}

public function adddailyperformance($mysqli,$userid){

		if(isset($_POST['idupd'])){
			$idupd = $_POST['idupd'];
		}
		if(isset($_POST['companyid'])){
			$company_id = $_POST['companyid'];
		}
		if(isset($_POST['branchid'])){
			$branch_id = $_POST['branchid'];
		}
		if(isset($_POST['deptid'])){
			$department_id = $_POST['deptid'];
		}
		if(isset($_POST['desgnid'])){
			$designation_id = $_POST['desgnid'];
		}
		if(isset($_POST['staff_id'])){
			$staff_id = $_POST['staff_id'];
		}
		if(isset($_POST['staffidedit'])){
			$staffidedit = $_POST['staffidedit'];
		}
		if(isset($_POST['nmonth'])){
			$nmonth = $_POST['nmonth'];
		}
	
		if(isset($_POST['assertion'])){
			$assertion = $_POST['assertion'];
		}
		if (isset($_POST['target'])) {
			$target = $_POST['target'];
		} 
		if (isset($_POST['actual_achieve'])) {
			$actual_achieve = $_POST['actual_achieve'];
		} 
		if(isset($_POST['sdate'])){
			$sdate = $_POST['sdate'];
		}
		if (isset($_POST['wstatus'])) {
			$wstatus = $_POST['wstatus'];
		}
		if (isset($_POST['goal_setting_id'])) {
			$goal_setting_id = $_POST['goal_setting_id'];
		}
		if (isset($_POST['goal_setting_ref_id'])) {
			$goal_setting_ref_id = $_POST['goal_setting_ref_id'];
		}
		if (isset($_POST['assertion_table_sno'])) {
			$assertion_table_sno = $_POST['assertion_table_sno'];
		}

		if (isset($_POST['daily_ref_id'])) {
			$daily_ref_id = $_POST['daily_ref_id'];
		}
		
		if($idupd == '0'){

			$qry1="INSERT INTO daily_performance (daily_performance_id, company_id, branch_id, department_id, role_id, emp_id, month, insert_login_id, status)
			VALUES (NULL, '$company_id', '$branch_id', '$department_id', '$designation_id', '$staffidedit','$nmonth','$userid', '0')";

			$insert_assign=$mysqli->query($qry1) or die("Error ".$mysqli->error);
			$last_id  = $mysqli->insert_id;

			for($j=0; $j<=sizeof($assertion)-1; $j++){
				if($actual_achieve[$j] != ''){
				$qry2="INSERT INTO daily_performance_ref(daily_performance_id, assertion, target, actual_achieve, system_date, staff_id, goal_setting_id,goal_setting_ref_id, assertion_table_sno, status)
				VALUES('".strip_tags($last_id)."', '".strip_tags($assertion[$j])."','".strip_tags($target[$j])."', '".strip_tags($actual_achieve[$j])."', '".strip_tags($sdate[$j])."', '$staffidedit', '".strip_tags($goal_setting_id[$j])."','".strip_tags($goal_setting_ref_id[$j])."', '".strip_tags($assertion_table_sno[$j])."', '".strip_tags($wstatus[$j])."')";
				$insert_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);

				$update_goal_ref = $mysqli->query("UPDATE `goal_setting_ref` SET `status`='$wstatus[$j]' WHERE `goal_setting_ref_id`='$goal_setting_ref_id[$j]' ") or die("Error ".$mysqli->error);

				if($wstatus[$j] == '1'){
					$update_goal_ref = $mysqli->query("UPDATE `goal_setting_ref` SET `status`='1'  WHERE  `assertion_table_sno`='$assertion_table_sno[$j]' && DATE_FORMAT(goal_month, '%Y-%m-%d') < '$sdate[$j]'") or die("Error ".$mysqli->error); //AFter Statisfied all Task the  status will changes as statisfied.
				}
				}//if the target row is not fill then do not insert the row.
			}

			}
		else {

			$qry1="UPDATE daily_performance set status ='0', update_login_id='$userid', updated_date = now() WHERE daily_performance_id = '$idupd' ";
			$update_assign=$mysqli->query($qry1) or die("Error ".$mysqli->error);
			$last_id  = $mysqli->insert_id;

			for($i=0;$i<=sizeof($assertion)-1;$i++){
				$qry2="UPDATE `daily_performance_ref` SET `actual_achieve`='$actual_achieve[$i]', `staff_id`= '$staffidedit', `status`='$wstatus[$i]', `manager_updated_status` = 0 WHERE `daily_performance_ref_id` = '$daily_ref_id[$i]' ";
				$update_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);	

				$update_goal_ref = $mysqli->query("UPDATE `goal_setting_ref` SET `status`='$wstatus[$i]' WHERE `goal_setting_ref_id`='$goal_setting_ref_id[$i]' ") or die("Error ".$mysqli->error);

				if($wstatus[$i] == '1'){
					$update_goal_ref = $mysqli->query("UPDATE `goal_setting_ref` SET `status`='1'  WHERE  `assertion_table_sno`='$assertion_table_sno[$i]' && DATE_FORMAT(goal_month, '%Y-%m-%d') < '$sdate[$i]'") or die("Error ".$mysqli->error); //AFter Statisfied all Task the  status will changes as satisfied.
				}
			}
			
		}
	}

	// Delete daily_performance
	public function deletedailyperformance($mysqli, $id){
		$checklistDelete = "UPDATE daily_performance set status='1' WHERE daily_performance_id = '".strip_tags($id)."' ";
		$runQry = $mysqli->query($checklistDelete) or die("Error in delete query".$mysqli->error);
	}

	public function getemployeecode($mysqli) { 
		$qry = "SELECT 	staff_id, emp_code, staff_name FROM staff_creation WHERE 1 and status=0"; 
		$res = $mysqli->query($qry) or die("Error in Get All Records".$mysqli->error);
		$detailrecords = array();
		$i=0;
		if ($mysqli->affected_rows>0)
		{
			while($row = $res->fetch_object())
			{
				$detailrecords[$i]['staff_id']  = strip_tags($row->staff_id);
				$detailrecords[$i]['staff_name']  = strip_tags($row->staff_name);
				$detailrecords[$i]['emp_code']       	    = strip_tags($row->emp_code);
				$i++;
			}
		}
		return $detailrecords;
	}

	// Add Todo
	public function addfcinsurancerenew($mysqli,$userid){

		date_default_timezone_set('Asia/Calcutta');
		$current_time = date('H:i:s');

		if(isset($_POST['branch_id'])){
			$branch_id = $_POST['branch_id'];
		}
		if(isset($_POST['id'])){
			$vehicle_details_id = $_POST['id'];
		}
		if(isset($_POST['assign_staff_name'])){
			$assign_staff_name = $_POST['assign_staff_name']; 
		}
		if(isset($_POST['assign_remark'])){
			$assign_remark = $_POST['assign_remark'];
		}
		if(isset($_POST['from_date'])){
			$from_date = $_POST['from_date'].' '.$current_time;
		}
		if(isset($_POST['to_date'])){
			$to_date = $_POST['to_date'].' '.$current_time;
		}
		if(isset($_POST['fc_insurance_renew_id'])){
			$fc_insurance_renew_id = $_POST['fc_insurance_renew_id'];
		}
		if($fc_insurance_renew_id ==''){
			$insertQry="INSERT INTO `fc_insurance_renew`(`branch_id`, `vehicle_details_id`, `assign_staff_name`, `assign_remark`, `from_date`, `to_date`, `insert_login_id`) 
			VALUES('".strip_tags($branch_id)."', '".strip_tags($vehicle_details_id)."','".strip_tags($assign_staff_name)."', '".strip_tags($assign_remark)."', 
			'".strip_tags($from_date)."', '".strip_tags($to_date)."', '".$userid."' )"; 
			$insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
		}else{
			$upd = $mysqli->query("UPDATE `fc_insurance_renew` SET `assign_staff_name`='$assign_staff_name',`assign_remark`='$assign_remark',`from_date`='$from_date',`to_date`='$to_date',`updated_date`= now(), `update_login_id`='$userid' WHERE `fc_insurance_renew_id`='$fc_insurance_renew_id'");
		}
	}

	// Get Fc Renew Details
	public function getFCInsDetails($mysqli, $id){

		$selectQry = "SELECT * FROM fc_insurance_renew WHERE vehicle_details_id='".mysqli_real_escape_string($mysqli, $id)."' "; 
		$res = $mysqli->query($selectQry) or die("Error in Get All Records".$mysqli->error);
		$detailrecords = array();
		if ($mysqli->affected_rows>0)
		{
			$row = $res->fetch_object();
			$detailrecords['vehicle_details_id']  = $row->vehicle_details_id;  
			$detailrecords['fc_insurance_renew_id']  = $row->fc_insurance_renew_id;  
			$detailrecords['assign_staff_name']  = $row->assign_staff_name;  
			$detailrecords['assign_remark']  = $row->assign_remark;  
			$detailrecords['from_date']  = $row->from_date;  
			$detailrecords['to_date']  = $row->to_date;  
		}
		
		return $detailrecords;
	}

	//Daily Task Update.
	public function addDailyTask($mysqli, $curdate){

		if(isset($_POST['daily_task_id'])){
			$daily_task_id = $_POST['daily_task_id'];
		}
		if(isset($_POST['daily_task_work'])){
			$daily_task_work = $_POST['daily_task_work'];
		}
		if(isset($_POST['daily_task'])){
			$work_name = $_POST['daily_task'];
		}
		if(isset($_POST['work_status'])){
			$work_status = $_POST['work_status'];
		}
		if(isset($_POST['work_remark'])){
			$remarks = $_POST['work_remark'];
		}
		if (isset($_FILES['status_file'])) {
			
			// File uploading code
			$file = $_FILES['status_file'];
			foreach ($file['name'] as $index => $name) {
			$files[] = $file['name'][$index];
			$fileName = $file['name'][$index];
			$fileTmpName = $file['tmp_name'][$index];
			$targetPath = 'uploads/completedTaskFile/'.$fileName;
			move_uploaded_file($fileTmpName, $targetPath);
			}
		}else{
			$files = "";
		}
		
		for($i=0; $i< count($daily_task_id); $i++){
		$workdes_id = $daily_task_work[$i]. $daily_task_id[$i];

		$qry = "INSERT into work_status (work_id, work_des, work_status, remarks, completed_file, created_date) values ('" .$workdes_id. "','" .$work_name[$i]. "', '" .$work_status[$i]. "', '" .$remarks[$i]. "', '" .$files[$i]. "', '$curdate')  ";  
		$result = $mysqli->query($qry) or die("error");

		$ifhas = "todo";
		$ifhas1 = "krakpi_ref";
		$ifhas2 = "audit_area";
		$ifhas3 = "maintenance";
		$ifhas4 = "campaign";
		$ifhas5 = "insurance";
		$ifhas6 = "BM";
		$ifhas7 = "FC_INS_renew";

		if (strstr($workdes_id, $ifhas)) {
			//"The substring was found in the string";
			$todo_id = preg_replace('/todo /', '', $workdes_id);
			$qry = "UPDATE todo_creation set work_status = '$work_status[$i]' where todo_id = '".$todo_id."' ";
			$result = $mysqli->query($qry) or die("Error Not able to update todo table");

		} else if(strstr($workdes_id, $ifhas1)) {
			//"The substring was found in the string";
			$krakpi_calendar_map_id = preg_replace('/krakpi_ref /', '', $workdes_id);
			$qry = "UPDATE krakpi_calendar_map set work_status = '$work_status[$i]' where krakpi_calendar_map_id = '".$krakpi_calendar_map_id."' ";
			$result = $mysqli->query($qry) or die("Error Not able to update assign work table");

		} else if(strstr($workdes_id, $ifhas2)) {
			//"The substring was found in the string";
			$audit_area_id = preg_replace('/audit_area /', '', $workdes_id);
			$qry = "UPDATE audit_area_creation_ref set work_status = '$work_status[$i]' where audit_area_creation_ref_id = '".$audit_area_id."' ";
			$result = $mysqli->query($qry) or die("Error Not able to update assign work table");

		} else if(strstr($workdes_id, $ifhas3)) {
			//"The substring was found in the string";
			$maintenance_checklist_id = preg_replace('/maintenance /', '', $workdes_id);
			$qry = "UPDATE pm_checklist_ref set work_status = '$work_status[$i]' where pm_checklist_ref_id = '".$maintenance_checklist_id."' ";
			$result = $mysqli->query($qry) or die("Error Not able to update assign work table");

		} else if(strstr($workdes_id, $ifhas4)) {
			//"The substring was found in the string";
			$campaign_ref_id = preg_replace('/campaign /', '', $workdes_id);
			$qry = "UPDATE campaign_ref set work_status = '$work_status[$i]' where campaign_ref_id = '".$campaign_ref_id."' ";
			$result = $mysqli->query($qry) or die("Error Not able to update assign work table");

		} else if(strstr($workdes_id, $ifhas5)) {
			//"The substring was found in the string";
			$ins_reg_ref_id = preg_replace('/insurance /', '', $workdes_id);
			$qry = "UPDATE insurance_register_ref set work_status = '$work_status[$i]' where ins_reg_ref_id = '".$ins_reg_ref_id."' ";
			$result = $mysqli->query($qry) or die("Error Not able to update assign work table");

		} else if(strstr($workdes_id, $ifhas6)) {
			//"The substring was found in the string";
			$maintenance_checklist_id_bm = preg_replace('/BM /', '', $workdes_id);
			$qry = "UPDATE bm_checklist_ref set work_status = '$work_status[$i]' where bm_checklist_ref_id = '".$maintenance_checklist_id_bm."' ";
			$result = $mysqli->query($qry) or die("Error Not able to update BM Checklist ref table");

		} else if(strstr($workdes_id, $ifhas7)) {
			//"The substring was found in the string";
			$Fc_insurance_renew_id = preg_replace('/FC_INS_renew /', '', $workdes_id);
			$qry = "UPDATE fc_insurance_renew set work_status = '$work_status[$i]' where Fc_insurance_renew_id = '".$Fc_insurance_renew_id."' ";
			$result = $mysqli->query($qry) or die("Error Not able to update FC Insurance Renew table");
			
		} else {
			//"The substring was not found in the string";
			$assign_work_id = preg_replace('/assign_work /', '', $workdes_id);
			$qry = "UPDATE assign_work_ref set work_status = '$work_status[$i]' where ref_id = '".$assign_work_id."' ";
			$result = $mysqli->query($qry) or die("Error Not able to update assign work table");

		}
	}
	}//Daily Task Add END.



}
?>