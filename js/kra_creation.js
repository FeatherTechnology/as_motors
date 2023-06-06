// Document is ready
$(document).ready(function () { 

	// get company based branch name
	// $('#company_id').on('change', function(){
	// 	var company_id = $('#company_id :selected').val();
	// 	$.ajax({
	// 		url: 'basicFile/ajaxFetchBranchDetails.php',
	// 		type:'post',
	// 		data: {'company_id': company_id},
	// 		dataType: 'json',
	// 		success: function(response){
				
	// 			$("#branch_id").empty();
	// 			$("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
	// 			var r = 0;
	// 			for (r = 0; r <= response.branch_id.length - 1; r++) { 
	// 				$('#branch_id').append("<option value='" + response['branch_id'][r] + "'>" + response['branch_name'][r] + "</option>");
	// 			}
	// 		}
	// 	});
	// });
    
	// Get Company based on Department
	$("#company_id").change(function(){
		var company_id = $("#company_id").val();
		if(company_id.length==''){
			$("#company_id").val('');
		}else{
			getdepartment(company_id);
		}
	});

	// Get Department based on designation
	$("#department").change(function(){ 
		var department_id = $("#department").val();
		if(department_id.length==''){ 
			$("#department").val('');
		}else{
			getdesignation(department_id);
		}
	});

	// Validation holiday table
	$('#kraTableCheck').hide();	
	let tableholidayError = true;
	function validateTableKra(){ 
		var rows = $('#kraTable > tbody > tr').length;
		if(rows<1){ 
			$('#kraTableCheck').show();
			tableholidayError = false;
			return false;
		}else{ 
			$('#kraTableCheck').hide();
			tableholidayError = true;	
		}
	}

	$('#submitKraCreation').click(function () { 
		
		validateTableKra();

		if (tableholidayError == true) 
		{	
			return true;
		} 
		else 
		{
			return false;
		}
	}); 

});


var to100 = 0;
var updweight = $('#updweight').val();
if(updweight>0 ){
	if(updweight>=100 ){
		$('#add_kraDetails').hide();
		to100 = updweight;
	}else{
		$('#add_kraDetails').show()
		to100 = updweight;
		// alert(to100);
	}
}

// Add kra details
$(document).on('click','#add_kraDetails',function(){ 
	
	var kraFormData = addKraTable(to100);
	//check weightage is reached 100 or not
	to100 = parseInt(to100) + parseInt(kraFormData['weightage']);
	// console.log(to100);
	if(to100 == 100){
		$('#add_kraDetails').hide();
	}
	
	validateTableKra();

});

var selectedRow = null;
function addKraTable(to100){ 

	var kraFormData = readKra(); 
	var over100 = 0;
	//Alert when adding existing weightage
	over100 = parseInt(to100) + parseInt(kraFormData['weightage']);
	// console.log(over100);
	if(over100 > 100){
		alert('Enter lesser weightage!');
	}else{
		if(selectedRow == null){
			var partnumberval = []; 
			partnumberval = document.getElementById("kra_category").value; 
			var productarray = document.getElementsByName("kra_category[]");
			var choosen = 0;
			for(var i=0; i<productarray.length; i++){
				if(partnumberval == productarray[i].value){
				choosen++;
				}
			}
			if(choosen == 0){
				insertKra(kraFormData);
				resetKraForm();
			}
			else{
				insertKra(kraFormData);
				resetKraForm();
			}
		} else {
			partnumberval = document.getElementById("kra_category").value;  
			var productarray = document.getElementsByName("kra_category[]");
			var choosen = 0;
			for(var i=0; i<productarray.length; i++){
				if(partnumberval == productarray[i].value){
					choosen++;
				}
			}
			if(choosen == 0){
				updateKra(kraFormData);
				resetKraForm();
			}
			else{
				updateKra(kraFormData);
				resetKraForm();
			}
		}
		return kraFormData;
	}
}

function readKra() {  

	var kraFormData = {};
	kraFormData["kra_category"] = document.getElementById("kra_category").value;
	kraFormData["weightage"] = document.getElementById("weightage").value;
	return kraFormData;
}

function insertKra(data){ 

	var table = document.getElementById("kraTable").getElementsByTagName('tbody')[0];
	var newRow = table.insertRow(table.length);
	if(data.weightage != ""  && data.kra_category != ""){

		cell0=newRow.insertCell(0);
		cell0.innerHTML='<input type="text" readonly name="kra_category[]" id="kra_category" class="form-control" value="'+data.kra_category+'">';

		cell1=newRow.insertCell(1);
		cell1.innerHTML='<input type="text" readonly name="weightage[]" id="weightage" class="form-control weightage" value="'+data.weightage+'">';

		cell2=newRow.insertCell(2);
		cell2.innerHTML="<a  onclick='onDelete(this);' class='' ><span class='icon-trash-2'></span></a>";
		// <a onclick='onUpdate(this)'><span class='icon-border_color'></span></a> &nbsp 
	}
}

function onUpdate(td){
	selectedRow=td.parentElement.parentElement;
	document.getElementById("kra_category").value=selectedRow.cells[1].querySelector('input').value;
	document.getElementById("weightage").value=selectedRow.cells[2].querySelector('input').value;
}

function updateKra(data){
	selectedRow.cells[1].innerHTML='<input type="text" readonly name="kra_category[]" id="kra_category" class="form-control" value="'+data.kra_category+'">';
	selectedRow.cells[2].innerHTML='<input type="text" readonly name="weightage[]" id="weightage" class="form-control" value="'+data.weightage+'">';
}

function onDelete(td){ 
	row = td.parentElement.parentElement;

	var sel=td.closest('tr'); //get closest tr
	var sel2 =sel.querySelectorAll('input.weightage'); //select class
	var cellValue = sel2[0].value;//getting weightage value of this row
	to100 = to100 - parseInt(cellValue);//surbract from total value
	// console.log(to100);
	$('#add_kraDetails').show();
	// console.log(to100);

	document.getElementById("kraTable").deleteRow(row.rowIndex);
	resetKraForm();
}

function resetKraForm(){
	document.getElementById("kra_category").value="";
	document.getElementById("weightage").value="";
	selectedRow = null;
}

	
function getdepartment(company_id){
	var department_upd = $('#department_upd').val();
	$.ajax({
		url: 'R&RFile/ajaxGetCompanyBasedDepartment.php',
		type: 'post',
		data: { "company_id":company_id },
		dataType: 'json',
		success:function(response){ 

			$('#department').empty();
			$('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
			var r = 0;
			for (r = 0; r <= response.department_id.length - 1; r++) { 
				var selected = "";
					if(department_upd == response['department_id'][r]){
						selected = "selected";
					}
				$('#department').append("<option value='" + response['department_id'][r] + "'"+selected+">" + response['department_name'][r] + "</option>");
			}
		}
	});
}

function getdesignation(department_id){

	var company_id = $("#company_id").val();
	var designation_upd = $('#designation_upd').val();

	$.ajax({
		url: 'R&RFile/ajaxR&RDesignationDetails.php',
		type: 'post',
		data: { "company_id":company_id, "department_id":department_id },
		dataType: 'json',
		success:function(response){
		
		$('#designation').empty();
		$('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
		var i = 0;
		for (i = 0; i <= response.designation_id.length - 1; i++) { 
			var selected = "";
                if(designation_upd == response['designation_id'][i]){
                    selected = "selected";
                }
			$('#designation').append("<option value='" + response['designation_id'][i] + "'"+selected+" >" + response['designation_name'][i] + "</option>");
		}

		}
	});
}

//get details on edit
$(function(){

	// manager login
	getdepartmentLoad();
	
	var idupd = $("#company_id :selected").val();
	var upd_name = $("#company_id :selected").text();
	var department_upd = $('#department_upd').val();
	if(idupd > 0 ){
		getdepartment(idupd);
		getdesignation(department_upd);
		// alert(department_upd);
	}else{

	}
});

  
  function getdepartmentLoad(){ 
	var company_id = $("#company_id").val();
	$.ajax({
		url: 'R&RFile/ajaxGetCompanyBasedDepartment.php',
	  type: 'post',
	  data: { "company_id":company_id },
	  dataType: 'json',
	  success:function(response){ 
  
		$('#department').empty();
		$('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
		var r = 0;
		for (r = 0; r <= response.department_id.length - 1; r++) { 
		  $('#department').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r] + "</option>");
		}
	  }
	});
  }