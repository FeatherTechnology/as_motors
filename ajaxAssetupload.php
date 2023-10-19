<?php
include("ajaxconfig.php");
@session_start();
if(isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
if(isset($_SESSION['curdateFromIndexPage'])) {
    $curdate = $_SESSION['curdateFromIndexPage'];
}
error_reporting(0);
require_once('vendor/csvreader/php-excel-reader/excel_reader2.php');
require_once('vendor/csvreader/SpreadsheetReader.php');

if(isset($_FILES["file"]["type"])){
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if(in_array($_FILES["file"]["type"],$allowedFileType)){
        
        $targetPath = 'uploads/asset_register/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        $sheetCount = count($Reader->sheets()); 

        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row){ 

                //Auto Generation Asset id, check record if already having record then just increment the asset id from the last record or insert initial id.
$myStr = "A";
$selectIC = $con->query("SELECT asset_autoGen_id FROM asset_register ORDER BY asset_id DESC LIMIT 1 ");
if($selectIC->num_rows>0)
{
    $row = $selectIC->fetch_assoc();
        $ac2 = $row["asset_autoGen_id"];

    $appno2 = ltrim(strstr($ac2, '-'), '-'); 
    $appno2 = $appno2+1;
    $asset_id = $myStr."-". "$appno2";
}
else
{
    $initialapp = $myStr."-101";
    $asset_id = $initialapp;
}


                $company_name = "";
                $company_id = "";
                if(isset($Row[0])) {
                    $company_name = mysqli_real_escape_string($con,$Row[0]); 
                    $query = "SELECT company_id FROM company_creation where company_name = '".$company_name."' and status = 0";
                    $result1 = $con->query($query) or die("Error ");
                    $row = $result1->fetch_assoc();
                    $company_id = $row["company_id"];
                } 

                $branch_name = "";
                $branch_id = "";
                if(isset($Row[1])) {
                    $branch_name = mysqli_real_escape_string($con,$Row[1]); 
                    $query1 = "SELECT branch_id FROM branch_creation where branch_name = '".$branch_name."' and status = 0";
                    $result1 = $con->query($query1) or die("Error ");
                    $row1 = $result1->fetch_assoc();
                    $branch_id = $row1["branch_id"];
                }

                $asset_class = "";
                $asset_class_id = "";
                if(isset($Row[2])) {
                    $asset_class = mysqli_real_escape_string($con,$Row[2]); 
                    if($asset_class == "Plant & Machinary"){
                        $asset_class_id = "1";
                    }
                    if($asset_class == "Land & Building"){
                        $asset_class_id = "2";
                    }
                    if($asset_class == "Computer"){
                        $asset_class_id = "3";
                    }
                    if($asset_class == "Printer and Scanner"){
                        $asset_class_id = "4";
                    }
                    if($asset_class == "Furniture and Fixtures"){
                        $asset_class_id = "5";
                    }
                    if($asset_class == "Electrical & fitting"){
                        $asset_class_id = "6";
                    }
                }

                $asset_name = "";
                $asset_name_id = "";
                if(isset($Row[3])) {
                    $asset_name = mysqli_real_escape_string($con,$Row[3]); 
                    $query2 = "SELECT asset_name_id FROM asset_name_creation where asset_name = '".$asset_name."' and status = 0";
                    $result2 = $con->query($query2) or die("Error On asset_name_creation");
                    $row2 = $result2->fetch_assoc();
                    $asset_name_id = $row2["asset_name_id"];
                } 

                $vendor_name = "";
                $vendor_name_id = "";
                if(isset($Row[4])) {
                    $vendor_name = mysqli_real_escape_string($con,$Row[4]); 
                    $query3 = "SELECT vendor_name_id FROM vendor_name_creation where vendor_name = '".$vendor_name."' and status = 0";
                    $result3 = $con->query($query3) or die("Error On vendor_name_creation");
                    $row3 = $result3->fetch_assoc();
                    $vendor_name_id = $row3["vendor_name_id"];
                } 

                $dop = "";
                if(isset($Row[5])) {
                    $dop = mysqli_real_escape_string($con,$Row[5]); 
                }

                $asset_nature = "";
                $asset_nature_id = "";
                if(isset($Row[6])) {
                    $asset_nature = mysqli_real_escape_string($con,$Row[6]);
                    if($asset_nature == "Immoveable"){
                        $asset_nature_id = "1";
                    }
                    if($asset_nature == "Moveable"){
                        $asset_nature_id = "2";
                    }
                }

                $depreciation_rate = "";
                if(isset($Row[7])) {
                    $depreciation_rate = mysqli_real_escape_string($con,$Row[7]); 
                }

                $asset_value = "";
                if(isset($Row[8])) {
                    $asset_value = mysqli_real_escape_string($con,$Row[8]); 
                }

                $maintenance = "";
                $maintenance_id = "";
                if(isset($Row[9])) {
                    $maintenance = mysqli_real_escape_string($con,$Row[9]);
                    if($maintenance == "Yes"){$maintenance_id = "1";}
                    if($maintenance == "No"){$maintenance_id = "2";}
                    
                }
                if($i==0 && $company_id !="Company Name" && $branch_id !='' && $asset_class!="Asset Classification" && $asset_name_id != "Asset Name" && $vendor_name_id !='' && $dop != "" && $asset_nature_id !="" && $depreciation_rate != '' && $asset_value !="" && $maintenance !="" )
                { 
                    $query = "INSERT INTO asset_register (company_id, asset_classification, asset_autoGen_id, asset_name, vendor_id, dop, asset_nature, depreciation_rate, asset_value,maintenance, insert_login_id, created_date) VALUES ('".strip_tags($branch_id)."', '".strip_tags($asset_class_id)."', '$asset_id', '".strip_tags($asset_name_id)."', '".strip_tags($vendor_name_id)."', '".$dop."', '".strip_tags($asset_nature_id)."', '".strip_tags($depreciation_rate)."', '".strip_tags($asset_value)."', '".strip_tags($maintenance_id)."', '$userid', '$curdate' )";
                    $result = $con->query($query) or die("Error ".$con->error);
                }
            }
        }
        
        if(!empty($result)) {
        $message = 0;
        unlink($targetPath);
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

    