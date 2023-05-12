<?php
include '../ajaxconfig.php';

if(isset($_POST["selectledger"])){
	$selectledger=$_POST["selectledger"];
}

$ledgerdetails=array();
$getqry="SELECT * FROM ledger WHERE ledgername='".strip_tags($selectledger)."'  ";
$res=$con->query($getqry);
while ($row=$res->fetch_assoc()){
	$AccountRefId              = $row["AccountRefId"];
	?>
  <select type="text" class="form-control" tabindex="4" id="eledgersubgroup" onchange="Geteledgersubgroup(this)" name="eledgersubgroup">
 <option value="">Select Subgroupname</option> 
<?php
	$getqry1="SELECT * FROM accountsgroup WHERE Id='".strip_tags($AccountRefId)."'  ORDER BY AccountsName ASC";
	$res1=$con->query($getqry1);
	while ($row1=$res1->fetch_assoc()){
		$ParentId                  = $row1["ParentId"];
    $Id                        = $row1["Id"];
    $AccountsName              = $row1["AccountsName"];
    ?>
    <?php
    $getqry2="SELECT * FROM accountsgroup ORDER BY AccountsName ASC ";
	$res2=$con->query($getqry2);
	while ($row2=$res2->fetch_assoc()){
		$ParentId2                  = $row2["ParentId"];
    $Id2                        = $row2["Id"];
    $AccountsName2              = $row2["AccountsName"];?>
  
    <option <?php if(isset($Id)) { if($Id == $Id2 ) echo 'selected'; }  ?> 
    value="<?php echo $Id2; ?>">
    <?php echo $AccountsName2;?></option>
  
    
    <?php
	}

	}?>
  </select>
  <?php
}

?>


<script>

function Geteledgersubgroup() {
  var ledgersubgroup33=$("#eledgersubgroup").val(); 
 
    if (ledgersubgroup33 == 29)
    {
$('#eopeningbalance').attr('readonly', true);    	  
    }
    if (ledgersubgroup33 == 5)	
    {	
        $('#eopeningbalance').attr('readonly', true); 	
        $('#eopeningbalance').val("0");    	  	
    }	
    if (ledgersubgroup33 == 6)	
    {	
        $('#eopeningbalance').attr('readonly', true); 	
        $('#eopeningbalance').val("0");   	  	
    }	
    if (ledgersubgroup33 == 7)	
    {	
        $('#eopeningbalance').attr('readonly', true); 	
        $('#eopeningbalance').val("0");   	  	
    }	
    if (ledgersubgroup33 == 8)	
    {	
        $('#eopeningbalance').attr('readonly', true);	
        $('#eopeningbalance').val("0");    	  	
    }
    if (ledgersubgroup33 == 27) 
    {      
$('#eopeningbalance').attr('readonly', false); 	
    }  
if (ledgersubgroup33 == 26)
    {
$('#eopeningbalance').attr('readonly', true);    	  
    }
    if (ledgersubgroup33 == 17) 
    {      
$('#eopeningbalance').attr('readonly', false); 	
    } 
if (ledgersubgroup33 == 14)
    {
$('#eopeningbalance').attr('readonly', false);    	  
    }
    if (ledgersubgroup33 == 21) 
    {      
$('#eopeningbalance').attr('readonly', true); 	
    } 
if (ledgersubgroup33 == 20)
    {
$('#eopeningbalance').attr('readonly', true);    	  
    }
    if (ledgersubgroup33 == 16) 
    {      
$('#eopeningbalance').attr('readonly', false); 	
    } 
if (ledgersubgroup33 == 28)
    {
$('#eopeningbalance').attr('readonly', true);    	  
    }
    if (ledgersubgroup33 == 18) 
    {      
$('#eopeningbalance').attr('readonly', false); 	
    } 
if (ledgersubgroup33 == 13)
    {
$('#eopeningbalance').attr('readonly', false);    	  
    }
    if (ledgersubgroup33 == 19) 
    {      
$('#eopeningbalance').attr('readonly', false); 	
    } 

if (ledgersubgroup33 == 32) 
    {      
$('#eopeningbalance').attr('readonly', true); 	
    } 

if (ledgersubgroup33 == 33) 
    {      
$('#eopeningbalance').attr('readonly', true); 	
    } 

if (ledgersubgroup33 == 15) 
    {      
$('#eopeningbalance').attr('readonly', false); 	
    } 

if (ledgersubgroup33 == 22) 
    {      
$('#eopeningbalance').attr('readonly', true); 	
    } 

if (ledgersubgroup33 == 25) 
    {      
$('#eopeningbalance').attr('readonly', true); 	
    } 
if (ledgersubgroup33 == 11) 
    {      
$('#eopeningbalance').attr('readonly', false); 	
    } 

if (ledgersubgroup33 == 23) 
    {      
$('#eopeningbalance').attr('readonly', false); 	
    } 

if (ledgersubgroup33 == 24) 
    {      
$('#eopeningbalance').attr('readonly', true); 	
    } 

if (ledgersubgroup33 == 30) 
    {      
$('#eopeningbalance').attr('readonly', true); 	
    } 

if (ledgersubgroup33 == 12) 
    {      
$('#eopeningbalance').attr('readonly', false); 	
    } 
if (ledgersubgroup33 == 31) 
    {      
$('#eopeningbalance').attr('readonly', true); 	
    } 

		var eledgersubgroup=$("#eledgersubgroup").val();
		if(eledgersubgroup == "Sundry Creditors"){
			$("#ledgergroup").val("Current Liabilities");
			$("#ledgercostcentre").prop("checked", false);
			$("#ledgercostcentre").attr("disabled", true);
			$.ajax({
            url: 'financefiles/sundrycreditors.php',
            type: 'post',
            data: {},
            success:function(html){
            	$("#sundrycreditors").html(html);
            }
            });	
		}
		else{
		$("#sundrycreditors").empty();
		$.ajax({
            url: 'financefiles/getledgergroupname.php',
            type: 'post',
            data: {"ledgersubgroup":eledgersubgroup},
            dataType: 'json',
            success:function(response){
            $("#eledgergroup").val(response);
            $("#ledgercostcentre").attr("checked", false);
            if(response == "Purchase Accounts" || response == "Direct Income" || response == ""
            	|| response == "Direct Expenses" || response == "Indirect Income" || 
            	response == "Indirect Expenses"){
            	$("#ledgercostcentre").attr("disabled", false);
             }else{
             	$("#ledgercostcentre").attr("disabled", true);
             }
            }
            });
	}
}

</script>


