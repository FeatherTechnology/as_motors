<?php
@session_start();
include '../ajaxconfig.php';

    if(isset($_SESSION["userid"])){
        $userid = $_SESSION["userid"];
    }
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

    if(isset($_POST['idupd'])){
        $idupd = $_POST['idupd'];
    } 

    if($idupd ==''){
        $staffInsert="INSERT INTO staff_creation(designation, company_id, staff_name, reporting, emp_code, department, doj, krikpi, 
        dob, key_skills, contact_number, email_id, insert_login_id) 
        VALUES('".strip_tags($designation)."', '".strip_tags($company_id)."', '".strip_tags($staff_name)."', '".strip_tags($reporting)."', 
        '".strip_tags($emp_code)."', '".strip_tags($department)."', '".strip_tags($doj)."', '".strip_tags($krikpi)."', '".strip_tags($dob)."',
        '".strip_tags($key_skills)."','".strip_tags($contact_number)."','".strip_tags($email_id)."','".strip_tags($userid)."' )";
    
        $insresult=$mysqli->query($staffInsert) or die("Error ".$mysqli->error);
        if($insresult){
            $message = '0';
        }

    }else{
        $staffUpdaet = "UPDATE staff_creation SET designation = '".strip_tags($designation)."', company_id = '".strip_tags($company_id)."', staff_name='".strip_tags($staff_name)."', 
        reporting='".strip_tags($reporting)."', emp_code='".strip_tags($emp_code)."', 
        department='".strip_tags($department)."', doj='".strip_tags($doj)."', krikpi='".strip_tags($krikpi)."', dob='".strip_tags($dob)."',
        key_skills='".strip_tags($key_skills)."',contact_number='".strip_tags($contact_number)."', email_id='".strip_tags($email_id)."',
        update_login_id='".strip_tags($userid)."', status = '0' WHERE staff_id= '".strip_tags($idupd)."' ";
        $updresult = $mysqli->query($staffUpdaet )or die ("Error in in update Query!.".$mysqli->error);

        $mysqli->query("UPDATE `user` SET `fullname`='$staff_name', `emailid`='$email_id', `branch_id`='$company_id',`designation_id`='$designation',`mobile_number`='$contact_number', status='0' WHERE `staff_id`='$idupd' ")or die ("Error in user table update Query!.".$mysqli->error);

        if($updresult){
            $message = '1';
        }

    }

    echo json_encode($message);

?>