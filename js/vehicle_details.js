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
