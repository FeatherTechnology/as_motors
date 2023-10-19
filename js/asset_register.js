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
  //     $('#downloadAsset').click(function () {
  //      window.location.href='uploads/bulkimport/asset_register_format.xlsx'
  //  });


  // Download button
  $('#downloadAsset').click(function () { 
    $.ajax({
        url: 'ajaxAssetRegisterBulkUpload.php',
        catch: false,
        success: function(){
          window.location.href='uploads/downloadfiles/assetregisterbulksample.xlsx';
        }
    });
  });

});

$(function(){
  autoGenAssetID(); //Auto Generation of Asset ID.

  //Asset Name//
  DropDownAssetName();
  resetAssetName();

  //Vendor Name//
  DropDownVendorName();
  resetVendorName();
})

function autoGenAssetID(){
  let asset_id = $('#id').val();
  $.ajax({
      url: 'assetDetails/asset_id_autoGen.php',
      type: "post",
      dataType: "json",
      data: { "id": asset_id },
      cache: false,
      success: function (response) {
          $('#asset_autoid').val(response);
      }
  })
}

/////////////////////////////  Asset Name Modal START //////////////////////////////

//Asset Name submit button action
$('#submitAssetNameModal').click(function(){
  let asset_name_create = $("#asset_name_create").val();
  let asset_name_id = $("#asset_name_id").val();

  if (asset_name_create !='' ) { 

      $.ajax({
          url:'assetDetails/assetNameInsert.php', 
          data:{'asset_name_create': asset_name_create, 'asset_name_id': asset_name_id },
          dataType:'json',
          type:'POST',
          cache: false,
          success:function(response){
              
              var insresult = response.includes("Added");
              var updresult = response.includes("Updated");
              var updatedresult = response.includes("Already Exists");
              if (insresult) {
                  $('#assetInsertOk').show();
                  setTimeout(function () {
                      $('#assetInsertOk').fadeOut('fast');
                  }, 2000);
              }
              else if (updresult) {
                  $('#assetUpdateOk').show();
                  setTimeout(function () {
                      $('#assetUpdateOk').fadeOut('fast');
                  }, 2000);
              }
              else if (updatedresult) {
                $('#assetInsertNotOk').show();
                setTimeout(function () {
                    $('#assetInsertNotOk').fadeOut('fast');
                }, 2000);
              }
              else {
                  $('#assetDeleteNotOk').show();
                  setTimeout(function () {
                      $('#assetDeleteNotOk').fadeOut('fast');
                  }, 2000);
              }

              DropDownAssetName();
              resetAssetName();
          }
      })
  }else{
      $('#assetnameCheck').show();
  }
})

$("body").on("click", "#edit_asset_name", function (){
  let id = $(this).attr('value');
  $.ajax({
      url: 'assetDetails/assetNameEdit.php',
      type: 'POST',
      data: { "id": id },
      cache: false,
      success: function(response){
          $("#asset_name_id").val(id);
          $("#asset_name_create").val(response);
      }
  });
});

$("body").on("click", "#delete_asset_name", function () {
  var isok = confirm("Do you want delete this Asset Name?");
  if (isok == false) {
      return false;
  } else {
      var id = $(this).attr('value');

      $.ajax({
          url: 'assetDetails/assetNameDelete.php',
          type: 'POST',
          data: { "id": id },
          cache: false,
          success: function (response) {
              var delresult = response.includes("Inactivated");
              if (delresult) {
                  $('#assetDeleteOk').show();
                  setTimeout(function () {
                      $('#assetDeleteOk').fadeOut('fast');
                  }, 2000);
              }
              else {

                  $('#assetDeleteNotOk').show();
                  setTimeout(function () {
                      $('#assetDeleteNotOk').fadeOut('fast');
                  }, 2000);
              }

              DropDownAssetName();
              resetAssetName();
          }
      });
  }
});

//Asset Name List Modal Table
function resetAssetName() {
  $.ajax({
      url: 'assetDetails/assetNameReset.php',
      type: 'POST',
      data: { },
      cache: false,
      success: function (html) {
          $("#AssetNameDiv").empty();
          $("#AssetNameDiv").html(html);

          $("#asset_name_create").val('');
      }
  });
}

//Dropdown for Asset Name
function DropDownAssetName(){
  $.ajax({
      url: 'assetDetails/getAssetNameDropdown.php',
      type: 'post',
      data: {},
      dataType: 'json',
      success:function(response){

          var len = response.length;
          $("#asset_name").empty();
          $("#asset_name").append("<option value=''>"+'Select Asset Name'+"</option>");

          var asset_name_upd = $('#asset_name_upd').val();
          for(var i = 0; i<len; i++){
              var selected = '';
              if(asset_name_upd == response[i]['asset_name_id']){
                  selected = 'selected';
              }
              $("#asset_name").append("<option value='"+response[i]['asset_name_id']+"' "+selected+" >"+response[i]['asset_name']+"</option>");
          }
      }
  });
}
/////////////////////////////  Asset Name Modal END //////////////////////////////

/////////////////////////////  Vendor Name Modal START //////////////////////////////

//Vendor Name submit button action
$('#submitvendorNameModal').click(function(){
  let vendor_name_create = $("#vendor_name_create").val();
  let vendor_name_id = $("#vendor_name_id").val();

  if (vendor_name_create !='' ) { 

      $.ajax({
          url:'assetDetails/vendorNameInsert.php', 
          data:{'vendor_name_create': vendor_name_create, 'vendor_name_id': vendor_name_id },
          dataType:'json',
          type:'POST',
          cache: false,
          success:function(response){
              
              var insresult = response.includes("Added");
              var updresult = response.includes("Updated");
              var updatedresult = response.includes("Already Exists");
              if (insresult) {
                  $('#vendorInsertOk').show();
                  setTimeout(function () {
                      $('#vendorInsertOk').fadeOut('fast');
                  }, 2000);
              }
              else if (updresult) {
                  $('#vendorUpdateOk').show();
                  setTimeout(function () {
                      $('#vendorUpdateOk').fadeOut('fast');
                  }, 2000);
              }
              else if (updatedresult) {
                  $('#vendorInsertNotOk').show();
                  setTimeout(function () {
                      $('#vendorInsertNotOk').fadeOut('fast');
                  }, 2000);
              }
              else {
                  $('#vendorDeleteNotOk').show();
                  setTimeout(function () {
                      $('#vendorDeleteNotOk').fadeOut('fast');
                  }, 2000);
              }

              DropDownVendorName();
              resetVendorName();
          }
      })
  }else{
      $('#vendornameCheck').show();
  }
})

$("body").on("click", "#edit_vendor_name", function (){
  let id = $(this).attr('value');
  $.ajax({
      url: 'assetDetails/vendorNameEdit.php',
      type: 'POST',
      data: { "id": id },
      cache: false,
      success: function(response){
          $("#vendor_name_id").val(id);
          $("#vendor_name_create").val(response);
      }
  });
});

$("body").on("click", "#delete_vendor_name", function () {
  var isok = confirm("Do you want delete this Vendor Name?");
  if (isok == false) {
      return false;
  } else {
      var id = $(this).attr('value');

      $.ajax({
          url: 'assetDetails/vendorNameDelete.php',
          type: 'POST',
          data: { "id": id },
          cache: false,
          success: function (response) {
              var delresult = response.includes("Inactivated");
              if (delresult) {
                  $('#vendorDeleteOk').show();
                  setTimeout(function () {
                      $('#vendorDeleteOk').fadeOut('fast');
                  }, 2000);
              }
              else {

                  $('#vendorDeleteNotOk').show();
                  setTimeout(function () {
                      $('#vendorDeleteNotOk').fadeOut('fast');
                  }, 2000);
              }

              DropDownVendorName();
              resetVendorName();
          }
      });
  }
});

//Vendor Name List Modal Table
function resetVendorName() {
  $.ajax({
      url: 'assetDetails/vendorNameReset.php',
      type: 'POST',
      data: { },
      cache: false,
      success: function (html) {
          $("#vendorNameDiv").empty();
          $("#vendorNameDiv").html(html);

          $("#vendor_name_create").val('');
      }
  });
}

//Dropdown for Vendor Name
function DropDownVendorName(){
  $.ajax({
      url: 'assetDetails/getVendorNameDropdown.php',
      type: 'post',
      data: {},
      dataType: 'json',
      success:function(response){

          var len = response.length;
          $("#vendor_name").empty();
          $("#vendor_name").append("<option value=''>"+'Select Vendor Name'+"</option>");

          var vendor_name_upd = $('#vendor_name_upd').val();
          for(var i = 0; i<len; i++){
              var selected = '';
              if(vendor_name_upd == response[i]['vendor_name_id']){
                  selected = 'selected';
              }
              $("#vendor_name").append("<option value='"+response[i]['vendor_name_id']+"' "+selected+" >"+response[i]['vendor_name']+"</option>");
          }
      }
  });
}
/////////////////////////////  Vendor Name Modal END //////////////////////////////