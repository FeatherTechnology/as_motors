// choices js for multi select dropdown:
const company_id = new Choices('#company_id', {
	removeItemButton: true,
});

$(document).ready(function () {

    // Validation holiday table
    $('#holidaytableCheck').hide();	
    let tableholidayError = true;
    function validateTableholiday(){ 
    var rows = $('#holidayTable > tbody > tr').length;
        if(rows<1){ 
            $('#holidaytableCheck').show();
            tableholidayError = false;
            return false;
        }else{ 
            $('#holidaytableCheck').hide();
            tableholidayError = true;	
        }
    }

    $('#submitholiday_creation').click(function () { 
        
        validateTableholiday();

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

// Add Customer Info temprorary
$("#add_holidayDetails").click(function(){ 
    addholidaytable();
    validateTableholiday();
});
        
var selectedRow = null;
function addholidaytable(){ 
    var holidayFormData = readholiday(); 
    if(selectedRow == null){
    var partnumberval = []; 
    partnumberval = document.getElementById("holiday_description").value; 
    var productarray = document.getElementsByName("holiday_description[]");
    var choosen = 0;
    for(var i=0; i<productarray.length; i++){
        if(partnumberval == productarray[i].value){
        choosen++;
        }
    }
    if(choosen == 0){
        insertholiday(holidayFormData);
        resetholidayForm();
    }
    else{
        insertholiday(holidayFormData);
        resetholidayForm();
    }
    } else {
        partnumberval = document.getElementById("holiday_description").value;  
        var productarray = document.getElementsByName("holiday_description[]");
        var choosen = 0;
        for(var i=0; i<productarray.length; i++){
            if(partnumberval == productarray[i].value){
            choosen++;
            }
        }
        if(choosen == 0){
            updateholiday(holidayFormData);
            resetholidayForm();
        }
        else{
            updateholiday(holidayFormData);
            resetholidayForm();
        }
    }
}
    
function readholiday() {  

    var holidayFormData = {};
    holidayFormData["holiday_date"] = document.getElementById("holiday_date").value;
    holidayFormData["holiday_description"] = document.getElementById("holiday_description").value;
    return holidayFormData;
}
    
function insertholiday(data){ 

    var table = document.getElementById("holidayTable").getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.length);
    if(data.holiday_date != ""  && data.holiday_description != ""){

    cell0=newRow.insertCell(0);
    cell0.innerHTML='<input type="text" readonly name="holiday_date[]" id="holiday_date" class="form-control" value="'+data.holiday_date+'">';

    cell1=newRow.insertCell(1);
    cell1.innerHTML='<input type="text" readonly name="holiday_description[]" id="holiday_description" class="form-control" value="'+data.holiday_description+'">';


    cell2=newRow.insertCell(2);
    cell2.innerHTML="<a onclick='onDelete(this);'><span class='icon-trash-2'></span></a>";
    // <a onclick='onUpdate(this)'><span class='icon-border_color'></span></a> &nbsp 
    }
}

function onUpdate(td){
    selectedRow=td.parentElement.parentElement;
    document.getElementById("holiday_date").value=selectedRow.cells[1].querySelector('input').value;
    document.getElementById("holiday_description").value=selectedRow.cells[2].querySelector('input').value;
}

function updateholiday(data){
    selectedRow.cells[1].innerHTML='<input type="text" readonly name="holiday_date[]" id="holiday_date" class="form-control" value="'+data.holiday_date+'">';
    selectedRow.cells[2].innerHTML='<input type="text" readonly name="holiday_description[]" id="holiday_description" class="form-control" value="'+data.holiday_description+'">';
}

function onDelete(td){ 
    row = td.parentElement.parentElement;
    document.getElementById("holidayTable").deleteRow(row.rowIndex);
    resetholidayForm();
}

function resetholidayForm(){
    document.getElementById("holiday_date").value="";
    document.getElementById("holiday_description").value="";
    selectedRow = null;
}

