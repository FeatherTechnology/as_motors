<?php
include("ajaxconfig.php");
@session_start();
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

                $asset_class = "";
                $asset_class_id = "";
                if(isset($Row[0])) {
                    $asset_class = mysqli_real_escape_string($con,$Row[0]); 
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
                if(isset($Row[1])) {
                    $asset_name = mysqli_real_escape_string($con,$Row[1]); 
                   
                } 

                $dop = "";
                if(isset($Row[2])) {
                    $dop = mysqli_real_escape_string($con,$Row[2]); 
                    
                }

                $asset_nature = "";
                $asset_nature_id = "";
                if(isset($Row[3])) {
                    $asset_nature = mysqli_real_escape_string($con,$Row[3]);
                    if($asset_nature == "Immoveable"){
                        $asset_nature_id = "1";
                    }
                    if($asset_nature == "Moveable"){
                        $asset_nature_id = "2";
                    }
                }
                $asset_value = "";
                if(isset($Row[4])) {
                    $asset_value = mysqli_real_escape_string($con,$Row[4]); 
                }
                $maintenance = "";
                if(isset($Row[5])) {
                    $maintenance = mysqli_real_escape_string($con,$Row[5]);
                    if($maintenance == "Yes"){$maintenance_id = "1";}
                    if($maintenance == "No"){$maintenance_id = "2";}
                    
                }
                if($i==0 && $asset_class!="Asset Classification" && $asset_name != "Asset Name" && $dop != "" && $asset_nature !="" && $asset_value !="" && $maintenance !="" )
                { 
                $query = "INSERT INTO asset_register (asset_classification,asset_name,dop,asset_nature,asset_value,maintenance) VALUES 
                ('".strip_tags($asset_class_id)."','".strip_tags($asset_name)."','".$dop."','".strip_tags($asset_nature_id)."','".strip_tags($asset_value)."','".strip_tags($maintenance_id)."')";
        
                $result = $con->query($query) or die("Error ".$con->error);
        
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

    