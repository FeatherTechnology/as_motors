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
$("#displayAllVehicleBtn").click(function(){
    
    var branch_id = $("#branch_id").val();
    $.ajax({
        url:"vehicledetailsFile/ajaxGetAllVehicleDetails.php",
        method:"post",
        data: {'branch_id': branch_id},
        success:function(html){
            $("#vehicleListAppend").empty();
            $("#vehicleListAppend").html(html);
        }
    }).then(function(){
        //Check Start KM is greater than previous end KM.
        $('.validate_start_km').change(function(){
            var previousKM = ($(this).attr('data-id')) ? parseInt($(this).attr('data-id')) : 0 ;
            var startkm = ($(this).val()) ? parseInt($(this).val()) : 0 ;

            if(startkm < previousKM){
                alert('Please Enter Start KM higher than Previous End KM')
                $(this).val('');
            }

        })

        $('.validate_end_km').change(function(){
            var start_km =  $(this).parents('tr').find('td #start_km').val();
            var startkilometer = (start_km) ? parseInt(start_km) : 0 ;
            var endkilometer = ($(this).val()) ? parseInt($(this).val()) : 0 ;

            if(endkilometer < startkilometer){
                alert('Please Enter End KM higher than Start KM')
                $(this).val('');
            }

        })
    }) //then end
});


// insert and update
$("#submitDailyKMBtn").click(function(){
    event.preventDefault();

    var totalCheckboxCount = $(':checkbox:checked').length;
    if(totalCheckboxCount > 0 ){
        
        var company_id = $("#branch_id").val();
        var date = $("#date").val();   
        
        var vehicle_details_id = [];
        var vehicle_number = [];
        var start_km = [];
        var end_km = [];
        var dailyKMRefId = [];
        var employee_name = [];
        $(':checkbox:checked').each(function(i){
            vehicle_details_id[i] = $(this).val(); 
            vehicle_number[i] = $(this).parents('tr').find('td #vehicle_number').val();   
            start_km[i] = $(this).parents('tr').find('td #start_km').val();   
            end_km[i] = $(this).parents('tr').find('td #end_km').val();   
            dailyKMRefId[i] = $(this).parents('tr').find('td #dailyKMRefId').val();   
            employee_name[i] = $(this).parents('tr').find('td #employee_name :selected').val();   
        });
        
        var updid = $("#id").val(); 
        if(updid>0){
            
            var dailyKMId = $("#dailyKMId").val();
            $.ajax({
                type: "POST",
                url: 'vehicledetailsFile/updateDailyKM.php',
                data: { "dailyKMId":dailyKMId, "dailyKMRefId":dailyKMRefId, "company_id":company_id, "date":date, "vehicle_details_id":vehicle_details_id, "vehicle_number":vehicle_number, "start_km":start_km, "end_km":end_km, "employee_name":employee_name },
                success:function(response){
                    if(response == 1){
                        window.location.href = "edit_daily_km&msc=2";
                    }else{
                        window.location.href = "edit_daily_km&msc=4";
                    }
                }
            });
    
        }else{
            $.ajax({
                type: "POST",
                url: 'vehicledetailsFile/insertDailyKM.php',
                data: { "company_id":company_id, "date":date, "vehicle_details_id":vehicle_details_id, "vehicle_number":vehicle_number, "start_km":start_km, "end_km":end_km, "employee_name":employee_name },
                success:function(response){
                    if(response == 1){
                        window.location.href = "edit_daily_km&msc=1";
                    }else{
                        window.location.href = "edit_daily_km&msc=5";
                    }
                }
            });
        }
    
    }else{
        alert('Select any one checkbox to submit')
        return false;
    }
});
