<?php
include("../ajaxconfig.php");
@session_start();
error_reporting(0);
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}

require_once('../vendor/csvreader/php-excel-reader/excel_reader2.php');
require_once('../vendor/csvreader/SpreadsheetReader.php');

if(isset($_FILES["file"]["type"])){
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if(in_array($_FILES["file"]["type"],$allowedFileType)){
        
        $targetPath = '../uploads/vehicle_details/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        $sheetCount = count($Reader->sheets()); 
        
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row){ 

                $company_name = "";
                $company_id = "";
                if(isset($Row[0])) {
                    $company_name = mysqli_real_escape_string($con,$Row[0]);
                    $query = "SELECT * FROM company_creation where company_name = '".$company_name."' and status = 0";
                    $result1 = $con->query($query) or die("Error ");
                    $row = $result1->fetch_assoc();
                    $company_id = $row["company_id"];
                } 

                $branch_name = "";
                if(isset($Row[1])) {
                    $branch_name = mysqli_real_escape_string($con,$Row[1]); 
                    $query = "SELECT * FROM branch_creation where branch_name = '".$branch_name."' and status = 0";
                    $result2 = $con->query($query) or die("Error ");
                    $row = $result2->fetch_assoc();
                    $branch_id = $row["branch_id"];
                }

                $vehicle_code='';
                $selectec=$con->query("SELECT vehicle_code FROM vehicle_details");
                if($selectec->num_rows>0){
                    $vehicleCodeAvailable=$con->query("SELECT vehicle_code FROM vehicle_details ORDER BY vehicle_details_id DESC LIMIT 1");
                    while ($row=$vehicleCodeAvailable->fetch_assoc()) {
                        $vehicleCode2=$row["vehicle_code"];
                    }
                    $vehicleCode1 = ltrim(strstr($vehicleCode2, 'C'), 'C')+1;
                    $vehicle_code="VC".$vehicleCode1;
                }else{
                    $initialemployeecode=1;
                    $vehicle_code="VC".$initialemployeecode;
                }

                $vehicle_name = "";
                if(isset($Row[2])) {
                    $vehicle_name = mysqli_real_escape_string($con,$Row[2]);
                }

                $vehicle_number = "";
                if(isset($Row[3])) {
                    $vehicle_number = mysqli_real_escape_string($con,$Row[3]); 
                }

                $date_of_purchase = "";
                if(isset($Row[4])) {
                    $date_of_purchase = mysqli_real_escape_string($con,$Row[4]); 
                }

                $fitment_upto = "";
                if(isset($Row[5])) {
                    $fitment_upto = mysqli_real_escape_string($con,$Row[5]); 
                }

                $insurance_upto = "";
                if(isset($Row[6])) {
                    $insurance_upto = mysqli_real_escape_string($con,$Row[6]); 
                }

                $asset_value = "";
                if(isset($Row[7])) {
                    $asset_value = mysqli_real_escape_string($con,$Row[7]); 
                }

                $book_value_as_on = "";
                if(isset($Row[8])) {
                    $book_value_as_on = mysqli_real_escape_string($con,$Row[8]); 
                }
                
                if($i==0 && $company_name!="Company Name" && $branch_name != "Branch Name" && $vehicle_name != "Vehicle Name" && $vehicle_number !="" && $date_of_purchase !="" )
                { 
                    $insertQry=$con->query("INSERT INTO vehicle_details(company_id, vehicle_code, vehicle_name, vehicle_number, date_of_purchase, fitment_upto, 
                    insurance_upto, asset_value, book_value_as_on, insert_login_id) VALUES('".strip_tags($branch_id)."', '".strip_tags($vehicle_code)."', 
                    '".strip_tags($vehicle_name)."', '".strip_tags($vehicle_number)."', '".strip_tags($date_of_purchase)."', '".strip_tags($fitment_upto)."', 
                    '".strip_tags($insurance_upto)."', '".strip_tags($asset_value)."', '".strip_tags($book_value_as_on)."', '".strip_tags($userid)."')");
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

    