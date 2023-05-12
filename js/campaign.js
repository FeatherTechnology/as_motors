$(document).ready(function () {

    // auto generate vehicle code
    $.ajax({
        url: "vehicledetailsFile/ajaxGetVehicleCode.php",
        data: {},
        cache: false,
        type: "post",
        dataType: "json",
        success: function (data) {
            $("#vehicle_code").val(data);
        }
    });

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

    // Download button
    $('#vehicleDetailsDownload').click(function () {
        $.ajax({
            url: 'ajaxVehicleDetailsBulkUpload.php',
            catch: false,
            success: function(){
                window.location.href='uploads/downloadfiles/vehicledetailsbulksample.xlsx';
            }
        });
    });

    
    $("#insertsuccess").hide();
    $("#notinsertsuccess").hide();
    //bulk upload
    $("#submitVehicleDetailsUploadBtn").click(function(){
    
        var file_data = $('#file').prop('files')[0];   
        var vehicle = new FormData();                  
        vehicle.append('file', file_data);

        if(file.files.length == 0 ){
            alert("Please Select File");
            return false;
        }
        $.ajax({
            url: 'vehicledetailsFile/ajaxVehicleDetailsUpload.php',
            type: 'POST',
            data: vehicle,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#file').attr("disabled",  true);
                $('#submitVehicleDetailsUploadBtn').attr("disabled", true);
            },
            success: function(data){
                console.log(data)
                if(data == 0){
                    $("#notinsertsuccess").hide();
                    $("#insertsuccess").show();
                    $("#file").val('');
                }else if(data == 1){
                    $("#insertsuccess").hide();
                    $("#notinsertsuccess").show();
                    $("#file").val('');
                }
            },
            complete: function(){
                $('#file').attr("disabled",  false);
                $('#submitVehicleDetailsUploadBtn').attr("disabled", false);         
            }
        });
    });

});

// append all vehicle
$("#viewBtn").click(function(){
    
    var project_id = $('#project_id').val();
    var actual_start_date = $('#actual_start_date').val();
    $.ajax({
        url:"campaignlFile/ajaxGetPromotionalActivityDetails.php",
        method:"post",
        data: {'project_id': project_id, 'actual_start_date': actual_start_date},
        success:function(html){
            $("#projectDetailsAppend").empty();
            $("#projectDetailsAppend").html(html);
        }
    });
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
