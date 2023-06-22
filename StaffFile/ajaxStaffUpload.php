<?php
include("../ajaxconfig.php");
@session_start();
// error_reporting(0);
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}

require_once('../vendor/csvreader/php-excel-reader/excel_reader2.php');
require_once('../vendor/csvreader/SpreadsheetReader.php');

if(isset($_FILES["file"]["type"])){
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if(in_array($_FILES["file"]["type"],$allowedFileType)){
        
        $targetPath = '../uploads/staff_creation/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        $sheetCount = count($Reader->sheets()); 
       
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row){ 

                if($Row[0] != "Company Name"){

                    $company_name = "";
                    $company_id = "";
                    if(isset($Row[0])) {
                        $company_name = mysqli_real_escape_string($con,$Row[0]); 
                        $query = "SELECT * FROM company_creation where company_name = '".$company_name."' and status = 0";
                        $result1 = $con->query($query) or die("Error");
                        $row = $result1->fetch_assoc();
                        $company_id = $row["company_id"];
                    } 
    
                    $branch_name = "";
                    $branch_id = "";
                    if(isset($Row[1])) {
                        $branch_name = mysqli_real_escape_string($con,$Row[1]); 
                        $query1 = "SELECT * FROM branch_creation where branch_name = '".$branch_name."' and status = 0";
                        $result1 = $con->query($query1) or die("Error ");
                        $row1 = $result1->fetch_assoc();
                        $branch_id = $row1["branch_id"];
                    }
    
                    $department = "";
                    $department_id = "";
                    if(isset($Row[2])) {
                        $department = mysqli_real_escape_string($con,$Row[2]); 
                        $query2 = "SELECT * FROM department_creation where department_name = '".$department."' and status = 0";
                        $result2 = $con->query($query2) or die("Error ");
                        $row2 = $result2->fetch_assoc();
                        $department_id = $row2["department_id"];
                    }
    
                    $designation = "";
                    $designation_id = "";
                    if(isset($Row[3])) {
                        $designation = mysqli_real_escape_string($con,$Row[3]); 
                        $query3 = "SELECT * FROM designation_creation where designation_name = '".$designation."' and status = 0";
                        $result3 = $con->query($query3) or die("Error ");
                        $row3 = $result3->fetch_assoc();
                        $designation_id = $row3["designation_id"];
                    }
    
                    $emp_code = "";
                    if(isset($Row[4])) {
                        $emp_code = mysqli_real_escape_string($con,$Row[4]);
                    }
    
                    $staff_name = "";
                    if(isset($Row[5])) {
                        $staff_name = mysqli_real_escape_string($con,$Row[5]); 
                    }
    
                    $reporting_to = "";
                    $reporting_id = "";
                    if(isset($Row[6])) {
                        $reporting_to = mysqli_real_escape_string($con,$Row[6]); 
                        $query4 = "SELECT * FROM staff_creation where staff_name = '".$reporting_to."' and status = 0";
                        $result4 = $con->query($query4) or die("Error ");
                        $row4 = $result4->fetch_assoc();
                        $reporting_id = $row4["staff_id"];
                    }
    
                    $doj = "";
                    if(isset($Row[7])) {
                        $doj = mysqli_real_escape_string($con,$Row[7]);
                    }
    
                    $krikpi = "";
                    $krikpi_name = "";
                    if(isset($Row[8])) {
                        $krikpi = mysqli_real_escape_string($con,$Row[8]); 
                        $query5 = "SELECT * FROM designation_creation where designation_name = '".$krikpi."' and status = 0";
                        $result5 = $con->query($query5) or die("Error ");
                        $row5 = $result5->fetch_assoc();
                        $krikpi_name = $row5["designation_id"];
                    }
    
                    $dob = "";
                    if(isset($Row[9])) {
                        $dob = mysqli_real_escape_string($con,$Row[9]);
                    }
    
                    $key_skills = "";
                    if(isset($Row[10])) {
                        $key_skills = mysqli_real_escape_string($con,$Row[10]);
                    }
    
                    $contact_number = "";
                    if(isset($Row[11])) {
                        $contact_number = mysqli_real_escape_string($con,$Row[11]);
                    }
    
                    $email_id = "";
                    if(isset($Row[12])) {
                        $email_id = mysqli_real_escape_string($con,$Row[12]);
                    }
                    
                    if($i==0 && $staff_name!="Staff Name" && $company_id !="Company Name" && $staff_name!="" && $company_id !="" && $designation_id 
                    !="" && $emp_code !="" && $department_id !="" && $doj !="" && $krikpi !="" && $dob !=""  && $key_skills !="" && $contact_number !=""
                    && $email_id !="" && $reporting_id !="")
                    {
                        $query = "INSERT INTO staff_creation(staff_name,company_id,designation,emp_code,department,doj,krikpi,dob,key_skills,contact_number,email_id,reporting) 
                        VALUES ('".strip_tags($staff_name)."','".strip_tags($branch_id)."','".strip_tags($designation_id)."','".strip_tags($emp_code)."',
                        '".strip_tags($department_id)."','".strip_tags($doj)."','".strip_tags($krikpi_name)."','".strip_tags($dob)."','".strip_tags($key_skills)."',
                        '".strip_tags($contact_number)."','".strip_tags($email_id)."','".strip_tags($reporting_id)."')"; 
                        
                    
                        $result = $con->query($query) or die("Error ");
                    }
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
        $message = 11;
    }

    echo $message;
?>