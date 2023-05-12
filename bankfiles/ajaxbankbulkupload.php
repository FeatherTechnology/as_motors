<!-- bank bulk upload -->
<?php
error_reporting(0);
@session_start();
$subgroup=0;

require_once('../vendor/csvreader/php-excel-reader/excel_reader2.php');
require_once('../vendor/csvreader/SpreadsheetReader.php');
include("../ajaxconfig.php");

 $message ='';

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
				
			$bankcode = "";
            $selectcc=$con->query("SELECT bankcode FROM bankmaster");
            if($selectcc->num_rows>0){
            $bankavailable=$con->query("SELECT bankcode FROM bankmaster ORDER BY bankid  DESC LIMIT 1");
            while ($row=$bankavailable->fetch_assoc()) {
            $bankcode2=$row["bankcode"];
            }
            $bankcode1 = ltrim(strstr($bankcode2, 'K'), 'K')+1;
            $bankcode="BAK".$bankcode1;
            }else{
            $initialbankcode=01;
            $bankcode="BAK".$initialbankcode;
            }
			
           // $bankcode = "";
           // if(isset($Row[0])) {
           // $bankcode = mysqli_real_escape_string($con,$Row[0]);
           // }
            $bankname = "";
            if(isset($Row[0])) {
            $bankname = mysqli_real_escape_string($con,$Row[0]);
            }
            $accountno = "";
            if(isset($Row[1])) {
            $accountno = mysqli_real_escape_string($con,$Row[1]);
            }
            $branchname = "";
            if(isset($Row[2])) {
            $branchname = mysqli_real_escape_string($con,$Row[2]);
            }
            $shortform = "";
            if(isset($Row[3])) {
            $shortform = mysqli_real_escape_string($con,$Row[3]);
            }
            $purpose = "";
            if(isset($Row[4])) {
            $purpose = mysqli_real_escape_string($con,$Row[4]);
            }
            $email = "";
            if(isset($Row[5])) {
            $email = mysqli_real_escape_string($con,$Row[5]);
            }
            $ifsccode = "";
            if(isset($Row[6])) {
            $ifsccode = mysqli_real_escape_string($con,$Row[6]);
            }
			$micrcode = "";
            if(isset($Row[7])) {
            $micrcode = mysqli_real_escape_string($con,$Row[7]);
            }
            $contactperson = "";
            if(isset($Row[8])) {
            $contactperson = mysqli_real_escape_string($con,$Row[8]);
            }
            $contactno = "";
            if(isset($Row[9])) {
            $contactno = mysqli_real_escape_string($con,$Row[9]);
            }            
            $accounttype = "";
            if(isset($Row[10])) {
            $accounttype = mysqli_real_escape_string($con,$Row[10]);
            }
			
			if(isset($accounttype))
			{
                
                if($accounttype =='Normal Accounts')
				{
					$accounttype="normalaccounts";
				}     
				if($accounttype !='normalaccounts')
				{
					$subgroup=13;
				}
				if($accounttype =='normalaccounts')
				{
					$subgroup=17;
				}
                if($accounttype =='Bank OD')
				{
					$accounttype="bankod";
				}
                if($accounttype =='CC')
				{
					$accounttype="cc";
				}               
                if($accounttype =='Term Loan')
				{
					$accounttype="termloan";
				}               
                if($accounttype =='Car Loan')
				{
					$accounttype =="carloan";
				}  
				
			}	
			
			$AccountsName="";
			$subgrouptype="";
			$group="";
			$bankgrouprefid="";
			$getqry="SELECT ParentId,AccountsName,Id FROM accountsgroup WHERE Id='".strip_tags($subgroup)."' and status=0";

			$res=$con->query($getqry);
			while ($row=$res->fetch_assoc()){
				$ParentId           = $row["ParentId"];
				//$subgrouptype       = $row["AccountsName"];
				$subgrouptype       = $row["Id"];
				if(	$ParentId > 0)
				{
					$getqry1="SELECT AccountsName, Id FROM accountsgroup WHERE Id='".strip_tags($ParentId)."' and status=0";
					$res1=$con->query($getqry1);
					while ($row1=$res1->fetch_assoc()){	
						$group                       = $row1["AccountsName"];
						$group                       = $row1["Id"];
						$bankgrouprefid              = $row1["Id"];
					}

				}
			}
			
			$getqry="SELECT purposeid,purposename FROM purpose WHERE 	purposename ='".strip_tags($purpose)."' and status=0";
			$res11=$con->query($getqry);
			while($row11=$res11->fetch_assoc())
			{
				$purpose           = $row11["purposeid"];        
			}

           // $subgrouptype = "";
           // if(isset($Row[12])) {
           // $subgrouptype = mysqli_real_escape_string($con,$Row[12]);
          //  }
          //  $group = "";
          //  if(isset($Row[13])) {
           // $group = mysqli_real_escape_string($con,$Row[13]);
          //  }
			
            $ledgername = "";
            if(isset($Row[0])) {
            $ledgername = mysqli_real_escape_string($con,$Row[0]);
            }			
            $costcenter = "";
            if(isset($Row[11])) {
            $costcenter = mysqli_real_escape_string($con,$Row[11]);
            if(isset($costcenter) &&    $costcenter == 'Yes')		
               {
                   $costcenter             = 0;
               }
               else
               {
                   $costcenter             = 1;
               }         
            }         
			
			
        if($i==0 && $bankname !="Bank Name" && $purpose !="Purpose" && $bankname !="" && $accountno !="" && $branchname !="" && $shortform !="" && $purpose !="" && $accounttype !="")
        { 
        $query = "INSERT INTO bankmaster(bankcode,bankname,accountno,branchname,shortform,purpose,mailid,
            ifsccode,contactperson,contactno,micrcode,typeofaccount,undersubgroup,
            fgroup,ledgername,costcenter,bankgrouprefid) 
        VALUES ('".strip_tags($bankcode)."','".strip_tags($bankname)."','".strip_tags($accountno)."',
        '".strip_tags($branchname)."','".strip_tags($shortform)."','".strip_tags($purpose)."',
        '".strip_tags($email)."','".strip_tags($ifsccode)."','".strip_tags($contactperson)."',
        '".strip_tags($contactno)."','".strip_tags($micrcode)."','".strip_tags($accounttype)."',
        '".strip_tags($subgrouptype)."','".strip_tags($group)."','".strip_tags($ledgername)."',
        '".strip_tags($costcenter)."','".strip_tags($bankgrouprefid)."')";

       $result = $con->query($query);

    } } }  

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

echo json_encode($message)
?>