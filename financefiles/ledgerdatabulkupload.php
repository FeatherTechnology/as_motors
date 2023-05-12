<?php
error_reporting(0);
@session_start();
require_once('../vendor/csvreader/php-excel-reader/excel_reader2.php');
require_once('../vendor/csvreader/SpreadsheetReader.php');
include("../ajaxconfig.php");
$Id=0;

if(isset($_FILES["file"]["type"])){
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

if(in_array($_FILES["file"]["type"], $allowedFileType)){
	  $targetPath = '../uploads/bulkimport/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        $Reader = new SpreadsheetReader($targetPath);
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
        	$Reader->ChangeSheet($i);
        	foreach ($Reader as $Row){
            $ledgername = "";
            if(isset($Row[0])) {
            $ledgername = mysqli_real_escape_string($con,$Row[0]);
            }
			$ledgersubgroup = "";
            if(isset($Row[1])) {
            $ledgersubgroup = mysqli_real_escape_string($con,$Row[1]);
            }
			if(isset($ledgersubgroup)){
			$getqry="SELECT ParentId,AccountsName,Id FROM accountsgroup WHERE AccountsName='".strip_tags($ledgersubgroup)."' and status=0";
			$res=$con->query($getqry);
			while ($row=$res->fetch_assoc()){	
				$Id                 = $row["Id"];
				$pId                = $row["ParentId"];
				$subgroupname       = $row["AccountsName"];
				if($pId >0)
				{
					$getqry1="SELECT AccountsName,Id FROM accountsgroup WHERE Id='".strip_tags($pId)."' and status=0";
					$res1=$con->query($getqry1);
					while ($row1=$res1->fetch_assoc()){	
						$groupname   = $row1["AccountsName"];
						$Id1         = $row1["Id"];
							if(	$Id1 >0)
							{
									$Id                 = $Id1;
							}
					}
				}
			}
			}
            $costcentre = "";
            if(isset($Row[2])) {
            $costcentre = mysqli_real_escape_string($con,$Row[2]);
            }
            $inventory = "";
            if(isset($Row[3])) {
            $inventory = mysqli_real_escape_string($con,$Row[3]);
            }
            if($i==0 && $ledgername !="Ledger Name" && $ledgername !="" && $ledgersubgroup !="SubGroup" && $ledgersubgroup !="" )
            {
            $ledgerbulkqry="INSERT INTO ledger(ledgername,AccountRefId, costcentre, inventory) VALUES('".strip_tags($ledgername)."', '".strip_tags($Id)."', '".strip_tags($costcentre)."', '".strip_tags($inventory)."')";
            $result = $con->query($ledgerbulkqry);
            }}}

if(!empty($result)) {
	$message=0;
}
else{
    $message=1;
    }
}
}else{
    $message=1;
}
echo json_encode($message);
?> 