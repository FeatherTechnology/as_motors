
// var newdes = false;
$(document).ready(function(){

    // get company based branch name
    $('#company_id').on('change', function(){
        var company_id = $('#company_id :selected').val();
        $.ajax({
            url: 'basicFile/ajaxFetchBranchDetails.php',
            type:'post',
            data: {'company_id': company_id},
            dataType: 'json',
            success: function(response){
                
                $("#branch_id").empty();
                $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
                var r = 0;
                for (r = 0; r <= response.branch_id.length - 1; r++) { 
                    $('#branch_id').append("<option value='" + response['branch_id'][r] + "'>" + response['branch_name'][r] + "</option>");
                }
            }
        });
    });
       
    $('#work_des').change(function(){
        if($('#work_des').val() == 'new'){
            $('#add_new').show();
            // newdes = true;
        }else{
            $('#add_new').hide();
            $('#add_new').val('');
            // newdes = true;
        }
    });

    //get work description based on department
    $('#work_des').change(function(){
        var select = document.getElementById("work_des");
        var selectedOption = select.options[select.selectedIndex];
        var hiddenInput = document.getElementById("work_des_text");
        hiddenInput.value = selectedOption.text;
    });
    
    // get department details
    $('#branch_id').change(function(){

        var company_id = $('#branch_id').val();
        $.ajax({
        url: 'KRA&KPIFile/ajaxKra&KpiDepartmentDetails.php',
        type: 'post',
        data: { "company_id":company_id },
        dataType: 'json',
        success:function(response){ 
    
            $('#department').empty();
            $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
            var r = 0;
            for (r = 0; r <= response.department_id.length - 1; r++) { 
                $('#department').append("<option value='" + response['department_id'][r] + "' >" + response['department_name'][r] + "</option>");
            }
        }
        });
    });
    
    // get Designation details
    $('#department').change(function(){
        var department_id = $('#department').val();

        $.ajax({
            url: 'R&RFile/ajaxR&RDesignationDetails.php',
            type: 'post',
            data: { "department_id":department_id },
            dataType: 'json',
            success:function(response){ 
                // designation
                $('#designation').empty();
                $('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
                var r = 0;
                for (r = 0; r <= response.designation_id.length - 1; r++) { 
                    $('#designation').append("<option value='" + response['designation_id'][r] + "' >" + response['designation_name'][r] + "</option>");
                }
            }
        });
    });

    // get Work Description details
    $('#designation').change(function(){

        var company_id = $('#company_id').val();
        var designation = $('#designation').val();

        $.ajax({
            url: 'assignworkFile/ajaxFetchWorkDescription.php',
            type: 'post',
            data: { "company_id":company_id, "designation":designation },
            dataType: 'json',
            success:function(response){ 
        
                // work description
                $('#work_des').empty();
                $('#work_des').prepend("<option value=''>" + 'Select Work Description' + "</option>");
                var r = 0;
                for (r = 0; r <= response.id.length - 1; r++) { 
                    $('#work_des').append("<option value='" + response['id'][r] + "' data-value='"+ response['frequency'][r] +"' data-id='"+ response['frequency_applicable'][r] +"' >" + response['name'][r] + "</option>");
                }
            }
        });
    });

    //Add Work Info temprorary
    $("#add_workDetails").click(function(){ 
        addWorkTable();
        $('#company_id').attr('readonly', true);
        $('#branch_id').attr('readonly', true);
    });

});

// get details on edit
$(function(){
    var idupd = $('#id').val();
    if(idupd >0){
        setalltoReadonly();
    }
    // manager login
    getdepartmentLoad();
});
            
var selectedRow = null;
function addWorkTable(){ 
    var workFormData = readWork(); 
    if(selectedRow == null){
        var partnumberval = []; 
        partnumberval = document.getElementById("department").value; 
        var productarray = document.getElementsByName("department[]");
        var choosen = 0;
        for(var i=0; i<productarray.length; i++){
            if(partnumberval == productarray[i].value){
            choosen++;
            }
        }
        if(choosen == 0){
            insertWork(workFormData);
            resetWorkForm();
        }
        else{
            insertWork(workFormData);
            resetWorkForm();
        }
    }else {
        partnumberval = document.getElementById("department").value;  
        var productarray = document.getElementsByName("department[]");
        var choosen = 0;
        for(var i=0; i<productarray.length; i++){
            if(partnumberval == productarray[i].value){
            choosen++;
            }
        }
        if(choosen == 0){
            updateWork(workFormData);
            resetWorkForm();
        }
        else{
            updateWork(workFormData);
            resetWorkForm();
        }
    }
}

function readWork() {  
    var workFormData = {};

    workFormData["department_id"] = document.getElementById("department").value;
    workFormData["work_des_id"] = document.getElementById("work_des").value;
    workFormData["designation"] = document.getElementById("designation").value;
    workFormData["work_des_name"] = $("#work_des option:selected").text().trim();
    workFormData["frequency"] = $('#work_des :selected').data('value');
    workFormData["frequency_applicable"] = $('#work_des :selected').data('id');
    
    //get Department Name
    workFormData["department_name"] = $("#department option:selected").text().trim();

    //get staff name
    workFormData["assign_to_name"] = $("#designation option:selected").text().trim();

    workFormData["from_date"] = document.getElementById("from_date").value;
    workFormData["to_date"] = document.getElementById("to_date").value;
    return workFormData;
}

function insertWork(data){ 

    var table = document.getElementById("assignWorkTable").getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.length);
    if(data.department_id != ""  && data.work_des_id != "" && data.tag_id != "" && data.priority_id != "" && data.designation != "" && data.from_date != "" && data.to_date != ""){

        cell0=newRow.insertCell(0);
        cell0.innerHTML='<input type="hidden" style="display:none" readonly name="department_id[]" id="department_id" class="form-control" value="'+data.department_id+'"/>';
        cell0.innerHTML +='<input type="text" readonly name="department_ins[]" id="department_ins" class="form-control" value="'+data.department_name+'"/>';

        cell1=newRow.insertCell(1);
        cell1.innerHTML='<input type="hidden" style="display:none" readonly name="work_des_id[]" id="work_des_id" class="form-control" value="'+data.work_des_id+'"/>';
        cell1.innerHTML +='<input type="hidden" name="frequency[]" id="frequency" class="form-control" value="'+data.frequency+'"/>';
        cell1.innerHTML +='<input type="hidden" name="frequency_applicable[]" id="frequency_applicable" class="form-control" value="'+data.frequency_applicable+'"/>';
        cell1.innerHTML +='<input type="text" readonly name="work_des_ins[]" id="work_des_ins" class="form-control" value="'+data.work_des_name+'"/>';
        
        cell2=newRow.insertCell(2);
        cell2.innerHTML='<input type="hidden" style="display:none" readonly name="designation[]" id="designation" class="form-control" value="'+data.designation+'"/>';
        cell2.innerHTML +='<input type="text" readonly name="assign_to_ins[]" id="assign_to_name" class="form-control" value="'+data.assign_to_name+'"/>';
        
        cell3=newRow.insertCell(3);
        cell3.innerHTML ='<input type="text" readonly name="from_date_ins[]" id="from_date_ins" class="form-control" value="'+data.from_date+'"/>';
        
        cell4=newRow.insertCell(4);
        cell4.innerHTML ='<input type="text" readonly name="to_date_ins[]" id="to_date_ins" class="form-control" value="'+data.to_date+'"/>';

        cell5=newRow.insertCell(5);
        cell5.innerHTML="<a onclick='onDelete(this);'><span class='icon-trash-2'></span></a>";

    }
    resetWorkForm();

}

function updateWork(data){
selectedRow.cells[1].innerHTML='<input type="text" readonly name="holiday_date[]" id="holiday_date" class="form-control" value="'+data.holiday_date+'">';
selectedRow.cells[2].innerHTML='<input type="text" readonly name="holiday_description[]" id="holiday_description" class="form-control" value="'+data.holiday_description+'">';
}

function onDelete(td){ 
    
    row = td.parentElement.parentElement;
    document.getElementById("assignWorkTable").deleteRow(row.rowIndex);
    resetWorkForm();
}

function resetWorkForm(){
    document.getElementById("department").value="";
    document.getElementById("work_des").value="";
    document.getElementById("designation").value="";
    document.getElementById("from_date").value="";
    document.getElementById("to_date").value="";
    selectedRow = null;
}

// get department details
function getdepartmentLoad(){ 
$.ajax({
    url: 'KRA&KPIFile/ajaxKra&KpiDepartmentDetailsLoad.php',
    type: 'post',
    data: {},
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

function setalltoReadonly(){

    $('#company_id').attr('readonly',true);
    $('#branch_id').attr('readonly',true);
}