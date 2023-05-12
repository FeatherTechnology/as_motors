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

campaign


// insert and update
$("#submitDailyKMBtn").click(function(){

    var totalCheckboxCount = $(':checkbox:checked').length;
    if(totalCheckboxCount > 0 ){
        
        var company_id = $("#branch_id").val();
        var date = $("#date").val();   
        
        var vehicle_details_id = [];
        var vehicle_number = [];
        var start_km = [];
        var end_km = [];
        var dailyKMRefId = [];
        $(':checkbox:checked').each(function(i){
            vehicle_details_id[i] = $(this).val(); 
            vehicle_number[i] = $(this).parents('tr').find('td #vehicle_number').val();   
            start_km[i] = $(this).parents('tr').find('td #start_km').val();   
            end_km[i] = $(this).parents('tr').find('td #end_km').val();   
            dailyKMRefId[i] = $(this).parents('tr').find('td #dailyKMRefId').val();   
        });
        
        var updid = $("#id").val(); 
        if(updid>0){
            
            var dailyKMId = $("#dailyKMId").val();
            $.ajax({
                type: "POST",
                url: 'vehicledetailsFile/updateDailyKM.php',
                data: { "dailyKMId":dailyKMId, "dailyKMRefId":dailyKMRefId, "company_id":company_id, "date":date, "vehicle_details_id":vehicle_details_id, "vehicle_number":vehicle_number, "start_km":start_km, "end_km":end_km },
                success:function(response){
                    window.location.href = "edit_daily_km&msc=2";
                }
            });
    
        }else{
            $.ajax({
                type: "POST",
                url: 'vehicledetailsFile/insertDailyKM.php',
                data: { "company_id":company_id, "date":date, "vehicle_details_id":vehicle_details_id, "vehicle_number":vehicle_number, "start_km":start_km, "end_km":end_km },
                success:function(response){
                    window.location.href = "edit_daily_km&msc=1";
                }
            });
        }
     
    }else{
        alert('Select any one checkbox to submit')
        return false;
    }
});
