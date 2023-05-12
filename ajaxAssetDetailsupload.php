<?php
include("ajaxconfig.php");
@session_start();
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

                $asset_class = "";
                if(isset($Row[0])) {
                    $asset_class = mysqli_real_escape_string($con,$Row[0]); 
                    // if($asset_class == 'Plant & Machinary')
                    // if($asset_class == 'Land & Building')
                    // if($asset_class == 'Computer')
                    // if($asset_class == 'Printer and Scanner')
                    // if($asset_class == 'Furniture and Fixtures')
                    // if($asset_class == 'Electrical & fitting')
                }

                $company_name = "";
                $company_id = "";
                if(isset($Row[1])) {
                    $company_name = mysqli_real_escape_string($con,$Row[1]);
                    $query = "SELECT * FROM company_creation where company_name = '".$company_name."' and status = 0";
                    $result1 = $con->query($query) or die("Error ");
                    $row = $result1->fetch_assoc();
                    $company_id = $row["company_id"];
                    
                } 

                $branch_name = "";
                if(isset($Row[2])) {
                    $branch_name = mysqli_real_escape_string($con,$Row[2]); 
                    $query = "SELECT * FROM branch_creation where branch_name = '".$branch_name."' and status = 0";
                    $result2 = $con->query($query) or die("Error ");
                    $row = $result2->fetch_assoc();
                    $branch_id = $row["branch_id"];
                }

                $asset_name = "";
                if(isset($Row[3])) {
                    $asset_name = mysqli_real_escape_string($con,$Row[3]);
                    
                }
                $asset_value = "";
                if(isset($Row[4])) {
                    $asset_value = mysqli_real_escape_string($con,$Row[4]); 
                }
                $as_on = "";
                if(isset($Row[5])) {
                    $as_on = mysqli_real_escape_string($con,$Row[5]); 
                }
                $dou = "";
                if(isset($Row[6])) {
                    $dou =$Row[6]; 
                }
                $depreciation = "";
                if(isset($Row[7])) {
                    $depreciation = mysqli_real_escape_string($con,$Row[7]); 
                }
                $model_no = "";
                if(isset($Row[8])) {
                    $model_no = mysqli_real_escape_string($con,$Row[8]); 
                }
                $warranty_upto = "";
                if(isset($Row[9])) {
                    $warranty_upto = $Row[9]; 
                }
                $spare_name = "";
                if(isset($Row[10])) {
                    $spare_name = mysqli_real_escape_string($con,$Row[10]); 
                }
                
                if($i==0 && $asset_class!="Asset Classification" && $asset_name != "Asset Name" && $dou != "" && $asset_value !="" && $company_id !="" && $branch_id !="" )
                { 
                    // print_r($dou);
                    // print_r($warranty_upto);
                    // die();

                    $insertSpare=$mysqli->query("INSERT INTO spare_creation(spare_name, branch_id, company_id, created_date) 
                    VALUES('".strip_tags($spare_name)."', '".strip_tags($branch_id)."', '".strip_tags($company_id)."', current_timestamp())");
                    $spare_id = $mysqli->insert_id;
                
                    $query = "INSERT INTO asset_details(company_id,branch_id,classification,asset_name,asset_value,dou,depreciation,as_on,spare_names)
                    VALUES('".strip_tags($company_id)."', '".strip_tags($branch_id)."', '".strip_tags($asset_class)."', 
                    '".strip_tags($asset_name)."', '".strip_tags($asset_value)."', '".strip_tags($dou)."', '".strip_tags($depreciation)."', '".strip_tags($as_on)."', 
                    '".strip_tags($spare_id)."' )";
                    
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

    