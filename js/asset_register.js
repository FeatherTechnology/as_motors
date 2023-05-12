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



    $("#insertsuccess").hide();
     $("#notinsertsuccess").hide();
    $("#submitAssetUploadbtn").click(function(){
 
        var file_data = $('#file').prop('files')[0];   
        var asset = new FormData();                  
        asset.append('file', file_data);

        if(file.files.length == 0 ){
          alert("Please Select File");
          return false;
        }
        
        $.ajax({
        type: 'POST',
        url: 'ajaxAssetupload.php',
        data: asset,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        $('#file').attr("disabled",  true);
          $('#submitAssetUploadbtn').attr("disabled", true);
        },
        success: function(data){
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
        $('#submitAssetUploadbtn').attr("disabled", false);         
        }
        });
      });
      
 // Download
      $('#downloadAsset').click(function () {
       window.location.href='uploads/bulkimport/asset_register_format.xlsx'
   });

});