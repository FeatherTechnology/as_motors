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
        
        $targetPath = 'uploads/asset_details/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        $sheetCount = count($Reader->sheets()); 
        

        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row){ 

                $asset_auto_id = "";
                $asset_id = "";
                $asset_class_id = "";
                $company_id = "";
                $branch_id = "";
                $asset_name_id = "";
                $asset_value = "";
                if(isset($Row[0])) {
                    $asset_auto_id = mysqli_real_escape_string($con,$Row[0]);
                    $query = "SELECT cc.company_id as comid, ar.* FROM asset_register ar LEFT JOIN branch_creation bc ON ar.company_id = bc.branch_id LEFT JOIN company_creation cc ON bc.company_id = cc.company_id where ar.asset_autoGen_id = '".$asset_auto_id."' and ar.status = 0";
                    $result1 = $con->query($query) or die("Error On asset_register");
                    $row = $result1->fetch_assoc();
                    $asset_id = $row["asset_id"];   
                    $asset_class_id = $row["asset_classification"];   
                    $company_id = $row["comid"];   
                    $branch_id = $row["company_id"];  //Branch id.
                    $asset_name_id = $row["asset_name"];   
                    $asset_value = $row["asset_value"];   
                } 

                // $asset_class = "";
                // $asset_class_id = "";
                // if(isset($Row[1])) {
                //     $asset_class = mysqli_real_escape_string($con,$Row[2]); 
                //     if($asset_class == "Plant & Machinary"){
                //         $asset_class_id = "1";
                //     }
                //     if($asset_class == "Land & Building"){
                //         $asset_class_id = "2";
                //     }
                //     if($asset_class == "Computer"){
                //         $asset_class_id = "3";
                //     }
                //     if($asset_class == "Printer and Scanner"){
                //         $asset_class_id = "4";
                //     }
                //     if($asset_class == "Furniture and Fixtures"){
                //         $asset_class_id = "5";
                //     }
                //     if($asset_class == "Electrical & fitting"){
                //         $asset_class_id = "6";
                //     }
                // }

                // $company_name = "";
                // $company_id = "";
                // if(isset($Row[2])) {
                //     $company_name = mysqli_real_escape_string($con,$Row[2]);
                //     $query = "SELECT * FROM company_creation where company_name = '".$company_name."' and status = 0";
                //     $result1 = $con->query($query) or die("Error ");
                //     $row = $result1->fetch_assoc();
                //     $company_id = $row["company_id"];
                    
                // } 

                // $branch_name = "";
                // if(isset($Row[3])) {
                //     $branch_name = mysqli_real_escape_string($con,$Row[3]); 
                //     $query = "SELECT * FROM branch_creation where branch_name = '".$branch_name."' and status = 0";
                //     $result2 = $con->query($query) or die("Error ");
                //     $row = $result2->fetch_assoc();
                //     $branch_id = $row["branch_id"];
                // }

                // $asset_name = "";
                // $asset_name_id = "";
                // if(isset($Row[4])) {
                //     $asset_name = mysqli_real_escape_string($con,$Row[4]); 
                //     $query2 = "SELECT asset_name_id FROM asset_name_creation where asset_name = '".$asset_name."' and status = 0";
                //     $result2 = $con->query($query2) or die("Error On asset_name_creation");
                //     $row2 = $result2->fetch_assoc();
                //     $asset_name_id = $row2["asset_name_id"];
                // } 

                // $asset_value = "";
                // if(isset($Row[5])) {
                //     $asset_value = mysqli_real_escape_string($con,$Row[5]); 
                // }

                // $as_on = "";
                // if(isset($Row[5])) {
                //     $as_on = mysqli_real_escape_string($con,$Row[5]); 
                // }

                $dou = "";
                if(isset($Row[6])) {
                    $dou =mysqli_real_escape_string($con,$Row[6]); 
                }

                $depreciation = "";
                if(isset($Row[7])) {
                    $depreciation = mysqli_real_escape_string($con,$Row[7]); 
                }

                $asset_location = "";
                if(isset($Row[8])) {
                    $asset_location = mysqli_real_escape_string($con,$Row[8]); 
                }

                $model_no = "";
                if(isset($Row[9])) {
                    $model_no = mysqli_real_escape_string($con,$Row[9]); 
                }

                $warranty_upto = "";
                if(isset($Row[10])) {
                    $warranty_upto = mysqli_real_escape_string($con,$Row[10]); 
                }

                $spare_name = "";
                $spare_id = "";
                if(isset($Row[11])) {
                    $spare_name = mysqli_real_escape_string($con,$Row[11]); 
                    $sparequery = "SELECT spare_id FROM spare_creation where spare_name = '".$spare_name."' and status = 0";
                    $spareinfo = $con->query($sparequery) or die("Error On spare_creation");
                    $sparerow = $spareinfo->fetch_assoc();
                    $spare_id = $sparerow["spare_id"];
                }
                
                if($i==0 && $asset_auto_id != "" && $dou != "" && $depreciation !="" && $asset_location !="Asset Location" && $model_no !="" && $warranty_upto !='' && $spare_name !='')
                {                 
                    $query = "INSERT INTO asset_details(asset_register_id, company_id, branch_id, classification, asset_name, asset_value, dou, depreciation, asset_location, spare_names, created_id, created_date)
                    VALUES('".strip_tags($asset_id)."', '".strip_tags($company_id)."', '".strip_tags($branch_id)."', '".strip_tags($asset_class_id)."', '".strip_tags($asset_name_id)."', '".strip_tags($asset_value)."', '".strip_tags($dou)."', '".strip_tags($depreciation)."', '".strip_tags($asset_location)."', '".strip_tags($spare_id)."', '$userid', '$curdate' )";
                    
                    $result = $mysqli->query($query) or die("Error ");
                    $asset_details_id = $mysqli->insert_id;
                    
                    $assetRefInsert="INSERT INTO asset_details_ref(modal_no, warranty_upto, asset_details_reff_id)
                    VALUES('".strip_tags($model_no)."', '".strip_tags($warranty_upto)."', '".strip_tags($asset_details_id)."')";
                    $insRefresult=$con->query($assetRefInsert) or die("Error on Asset details ref");                
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

    