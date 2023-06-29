$(document).ready(function () { 


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

    // Get assset name based on asset Classification
    $("#asset_class").change(function(){ 
        var asset_class = $("#asset_class").val(); 
        
        if(asset_class.length==''){
        $("#asset_class").val('');
        }else{
            var asset_id = $("#asset_class").val(); 
            $.ajax({
                url: 'ajaxgetassetclssification.php',
                type: 'post',
                data: { "asset_id":asset_id},
                dataType: 'json',
                success:function(response){ 

                    $('#asset_name1').empty();
                    $('#asset_name1').prepend("<option value=''>" + 'Select Asset Name' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.asset_id.length - 1; r++) { 
                    $('#asset_name1').append("<option value='" + response['asset_id'][r] + "'>" + response['asset_name'][r] + "</option>");
                    }
            
                }
            });
        }
    });

     // Get assset value based on asset name
    $("#asset_name1").change(function(){ 
        var asset_name1 = $("#asset_name1").val(); 
        
        if(asset_name1.length==''){
        $("#asset_name1").val('');
        }else{
            var asset_id = $("#asset_name1").val(); 
            $.ajax({
                    url: 'ajaxgetassetvalue.php',
                    type: 'post',
                    data: { "asset_id":asset_id},
                    dataType: 'json',
                    success:function(response){ 
                        $('#asset_value').val(response.asset_value);
                    }
                });
            }
        });

    // Get address based on branch
    $('#branch_id').on('change', function(){
        getBranchAddress();
	});


});

$(function(){
    getBranchAddress();
})

function getBranchAddress(){
var branch_id = $('#branch_id').val();
$.ajax({
    url: 'ajaxFetchBranchAddressDetails.php',
    type:'post',
    data: {'branch_id': branch_id},
    dataType: 'json',
    success: function(response){
        $('#company_address').val(response.address1+', '+response.address2);
        $('#company_address1').val(response.city);
        $('#company_address2').val(response.state);
    }
});
}

