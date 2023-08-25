// choices js for multi select dropdown:
const branch = new Choices('#branch_name', {
	removeItemButton: true,
});

$(document).ready(function () {

    // append all vehicle
$("#viewBtn").click(function(){
    
    var project_id = $('#project_id').val();
    var actual_start_date = $('#actual_start_date').val();
    var branch_name = $('#branch_name').val();
    $.ajax({
        url:"campaignlFile/ajaxGetPromotionalActivityDetails.php",
        method:"post",
        data: {'project_id': project_id, 'actual_start_date': actual_start_date, 'branch_name': branch_name},
        success:function(html){
            $("#projectDetailsAppend").empty();
            $("#projectDetailsAppend").html(html);
        }
    }).then(function(){
        getfunction();
        });//then END
});

// Get the actual start date input element
const actualStartDateInput = document.getElementById('actual_start_date');

// Add an event listener to listen for changes to the actual start date input
actualStartDateInput.addEventListener('change', function() {
    // Get the value of the actual start date input
    const actualStartDate = this.value;
    
    // Get all the start date and end date input elements
    const startDateInputs = document.querySelectorAll('.start_date');
    const endDateInputs = document.querySelectorAll('.end_date');
    
    // Loop through each start date and end date input element and update their values
    for (let i = 0; i < startDateInputs.length; i++) {
        // Get the time frame start and duration input values for the current row
        const timeFrameStart = parseInt(document.querySelectorAll('.time_frame_start')[i].value);
        const duration = parseInt(document.querySelectorAll('.duration')[i].value);
        
        // Calculate the new start date and end date values using the actual start date, time frame start, and duration
        const startDate = new Date(actualStartDate);
        startDate.setDate(startDate.getDate() - timeFrameStart);
        startDateInputs[i].value = startDate.toISOString().slice(0, 10);
        
        const endDate = new Date(actualStartDate);
        endDate.setDate(endDate.getDate() - duration);
        endDateInputs[i].value = endDate.toISOString().slice(0, 10);
    }
});

$('#branch_name').change(function(){
    var branchId = $(this).val();
    $.ajax({
        type: 'POST',
        data: {'branchId': branchId},
        url:'ajaxFetch/ajaxGetBranchBasedDept.php' ,
        dataType: 'json',
        success: function(response){

            $('.employee_name').empty();
            $('.employee_name').append("<option value=''>Select Staff Name</option>");
            $('.department').empty();
            $('.department').append("<option value=''>Select Department Name</option>");
            
            for(var i=0; i < response.length; i++){
                $('.department').append("<option value='"+response[i]['department_id']+"'>"+response[i]['department_name']+"</option>");
            }
        }
    })

});


});  //Document END///

$(function(){

    getbranchName();
    getfunction();
})

function getbranchName(){

    var branch_id_edit = $('#branch_id_edit').val().split(',');
    $.ajax({
        type: 'POST',
        url:'ajaxFetch/ajaxGetAllBranchList.php' ,
        dataType: 'json',
        success: function(response){
            branch.clearStore();
            for (var r = 0; r < response.length; r++) {     
                var branch_id = response[r]['branch_id'];  
                var branch_name = response[r]['branch_name']; 
                var selected = '';
                if(branch_id_edit != ''){
                
                    for(var i=0; i < branch_id_edit.length; i++){
                        if(branch_id_edit[i] == branch_id){ 
                            selected = 'selected'; 
                        }
                    }
                }

                var items = [
                    {
                        value: branch_id,
                        label: branch_name,
                        selected: selected,
                    }
                ];

                branch.setChoices(items);
                branch.init();
            }
        }
    })
}

function getfunction(){
    $('.department').change(function(){
        var deptID = $(this).val();
        var empcolumn = $(this).closest('tr').find('.employee_name');
        $.ajax({
            type: 'POST',
            data: {'department_id': deptID },
            url: 'StaffFile/getDeptBasedStaffDetails.php',
            dataType: 'json',
            success:function(response){

                empcolumn.empty();
                empcolumn.append("<option value=''>Select Employee Name</option>");

                for(var i = 0; i < response.length; i++){
                    empcolumn.append("<option value='"+response[i]['staff_id']+"'>"+response[i]['staff_name']+"</option>");
                }

            }
        })
    })
}