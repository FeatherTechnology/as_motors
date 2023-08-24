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

    // Get branch based vehicle
    $("#branch_id").change(function(){

        var company_id = $("#branch_id").val();
        if(company_id.length==''){
            $("#branch_id").val('');
        }else{
            getVehicleNo(company_id);

            getBranchStaffList(company_id);
        }
    });

    // Get vehicle details
    $("#vehicle_number").change(function(){

        var vehicle_details_id = $("#vehicle_number").val();
        if(vehicle_details_id.length==''){
            $("#vehicle_number").val('');
        }else{
            getVehicleDetails(vehicle_details_id);
        }
    });

    // $("#present_km").keyup(function(){
    //     var previous_km=$("#previous_km").val();
    //     var present_km=$("#present_km").val();

    //     if(previous_km==''){
    //         previous_km = 0;
    //     }
    //     var total_km_run = (parseInt(previous_km) + parseInt(present_km));
    //     $("#total_km_run").val(total_km_run);
    // });
    
    $("#present_km").keyup(function(){
        var previous_km=$("#previous_km").val();
        var present_km=$("#present_km").val();

        if(previous_km==''){
            previous_km = 0;
        }
        var total_km_run = ( parseInt(present_km) - parseInt(previous_km) );
       
            $("#total_km_run").val(total_km_run);
          
    });
});

// get vehicle no
function getVehicleNo(company_id){

    var vehicle_upd = $('#vehicle_numberEdit').val(); 
    $.ajax({
      url: 'vehicledetailsFile/ajaxFetchVehicleNo.php',
      type: 'post',
      data: { "company_id":company_id },
      dataType: 'json',
      success:function(response){ 
  
        $('#vehicle_number').empty();
        $('#vehicle_number').prepend("<option value=''>" + 'Select Vehicle Number' + "</option>");
        var r = 0;
        for (r = 0; r <= response.vehicle_details_id.length - 1; r++) {  
          var selected = "";
          if(vehicle_upd == response['vehicle_details_id'][r]){ 
            selected = "selected";
          }
          $('#vehicle_number').append("<option value='" + response['vehicle_details_id'][r] + "' "+selected+" >" + response['vehicle_number'][r] + "</option>");
        }
      }
    });
}

// get vehicle details
function getVehicleDetails(vehicle_details_id){

    var vehicle_upd = $('#dept_id_upd').val();
    $.ajax({
      url: 'vehicledetailsFile/ajaxFetchVehicleDetails.php',
      type: 'post',
      data: { "vehicle_details_id":vehicle_details_id },
      dataType: 'json',
      success:function(response){ 
        $('#previous_km').val(response.end_km);
        $('#previous_km_date').val(response.date);
 
      }
    });
}


// print functionality
function print_diesel_slip(id){
    $.ajax({
        url: 'vehicledetailsFile/printDieselSlip.php',
        cache: false,
        type: 'POST',
        data: { 'id':id },
        success: function(html){
            $("#printDieselSlip").html(html);
        }
    });
}


$(function(){ 

    setTimeout(function(){

        var company_id = $("#branch_id").val();
                
        var branchcheck = $('#session_branch_id').val();
        if(branchcheck != 'Overall'){
            getBranchStaffList(company_id);
            getVehicleNo(company_id);
        }
        
        var idupd = $('#idupd').val();
        if(idupd > 0){
            getBranchStaffList(company_id);
        }
    }, 1000)

});

function getBranchStaffList(branchId){
    var staff_id = $('#staff_id').val();
        $.ajax({
            url: 'vehicledetailsFile/getBranchStaffList.php',
            type: 'post',
            data: {"branch_id": branchId},
            dataType: 'json',
            success:function(response){
            
            $('#staff_name').empty();
            $('#staff_name').prepend("<option value=''>" + 'Select Employee Name' + "</option>");
            var i = 0;
            for (i = 0; i <= response.staff_id.length - 1; i++) { 
                var selected = '';
                if(response['staff_id'][i] == staff_id){
                    selected = 'selected';
                }
                $('#staff_name').append("<option value='" + response['staff_id'][i] + "'"+selected+">" + response['staff_name'][i] + "</option>");
            }
            }
        });
}