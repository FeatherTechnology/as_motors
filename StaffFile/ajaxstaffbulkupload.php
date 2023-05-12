<?php
// error_reporting(0);
include("../ajaxconfig.php");
@session_start();

require_once('../vendor/csvreader/php-excel-reader/excel_reader2.php');
require_once('../vendor/csvreader/SpreadsheetReader.php');

if(isset($_FILES["file"]["type"])){
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
if(in_array($_FILES["file"]["type"],$allowedFileType)){
	    $targetPath = '../uploads/bulkimport/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        $Reader = new SpreadsheetReader($targetPath);
        $sheetCount = count($Reader->sheets()); 
        for($i=0;$i<$sheetCount;$i++)
        {
        	$Reader->ChangeSheet($i);
        	foreach ($Reader as $Row){ 

                $staff_name = "";
                if(isset($Row[0])) {
                    $staff_name = mysqli_real_escape_string($con,$Row[0]); 
                }
                
                $company_id = "";
                if(isset($Row[1])) {
                    $company_name = mysqli_real_escape_string($con,$Row[1]); 
                    $getqry = "SELECT company_id FROM company_creation WHERE company_name LIKE '%{$company_name}%' "; 
                    $res12 = $con->query($getqry);
                    while($row12 = $res12->fetch_assoc())
                    {
                        $company_id  = $row12["company_id"];       
                    }  
                } 

                $designation = "";
                if(isset($Row[2])) {
                    $designation_name = mysqli_real_escape_string($con,$Row[2]); 
                    $getqry = "SELECT designation_id FROM designation_creation WHERE designation_name LIKE '%{$designation_name}%' "; 
                    $res12 = $con->query($getqry);
                    while($row12 = $res12->fetch_assoc())
                    {
                        $designation  = $row12["designation_id"];       
                    }  
                }

                $emp_code = "";
                if(isset($Row[3])) {
                    $emp_code = mysqli_real_escape_string($con,$Row[3]);
                }

                $department = "";
                if(isset($Row[4])) {
                    $department_name = mysqli_real_escape_string($con,$Row[4]); 
                    $getqry = "SELECT department_id FROM department_creation WHERE department_name LIKE '%{$department_name}%' "; 
                    $res12 = $con->query($getqry);
                    while($row12 = $res12->fetch_assoc())
                    {
                        $department  = $row12["department_id"];       
                    }  
                }

                $doj = "";
                if(isset($Row[5])) {
                    $doj = mysqli_real_escape_string($con,$Row[5]);
                }

                $krikpi = "";
                if(isset($Row[6])) {
                    $krikpi = mysqli_real_escape_string($con,$Row[6]);
                }

                $dob = "";
                if(isset($Row[7])) {
                    $dob = mysqli_real_escape_string($con,$Row[7]);
                }

                $key_skills = "";
                if(isset($Row[8])) {
                    $key_skills = mysqli_real_escape_string($con,$Row[8]);
                }

                $contact_number = "";
                if(isset($Row[9])) {
                    $contact_number = mysqli_real_escape_string($con,$Row[9]);
                }

                $email_id = "";
                if(isset($Row[10])) {
                    $email_id = mysqli_real_escape_string($con,$Row[10]);
                }

                $reporting = "";
                $reporting_name = "";
                if(isset($Row[11])) {
                    $reporting_name = mysqli_real_escape_string($con,$Row[11]);
                    $getqry = "SELECT * FROM staff_creation WHERE staff_name LIKE '%{$reporting_name}%' "; 
                    $res12 = $con->query($getqry);
                    while($row12 = $res12->fetch_assoc())
                    {
                        $reporting  = $row12["staff_id"];       
                    }
                }

                if($i==0 && $staff_name!="Staff Name" && $company_id !="Company Name" && $staff_name!="" && $company_id !="" && $designation 
                !="" && $emp_code !="" && $department !="" && $doj !="" && $krikpi !="" && $dob !=""  && $key_skills !="" && $contact_number !=""
                && $email_id !="" && $reporting !="")
                { 
                    $query = "INSERT INTO staff_creation(staff_name,company_id,designation,emp_code,department,doj,krikpi,dob,key_skills,contact_number,email_id,reporting) 
                    VALUES ('".strip_tags($staff_name)."','".strip_tags($company_id)."','".strip_tags($designation)."','".strip_tags($emp_code)."',
                    '".strip_tags($department)."','".strip_tags($doj)."','".strip_tags($krikpi)."','".strip_tags($dob)."','".strip_tags($key_skills)."',
                    '".strip_tags($contact_number)."','".strip_tags($email_id)."','".strip_tags($reporting)."')"; 
                
                    $result = $con->query($query) or die("Error ");
                }
         }
    } 
        
        if(!empty($result)) {
        $message = 0;
        }
        else{
        $message = 1;
        }
    }
    }else{
    $message = 1;
    }
    echo json_encode($message);
    ?>