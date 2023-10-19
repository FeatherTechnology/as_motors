// choices js for multi select dropdown:
const spare_names = new Choices('#spare_names', {
	removeItemButton: true,
});

$(document).ready(function(){

    //on change company name change Branch dropdown
    $('#company_id').change(function(){
        var company_id = $("#company_id").val();
        if(company_id.length==''){
        $("#company_id").val('');
        }else{
            getBranch(company_id);
        }
    });

    //on change of branch reset spare modal table
    $('#branch_id').change(function(){
        var branch_id = $("#branch_id").val();
        if(branch_id.length==''){
        $("#branch_id").val('');
        }else{
            resetspareTable(branch_id);
            // resetSpareDropdown(branch_id)
        }
    });

    //asset name and value based on asset class change
    $('#asset_class').change(function(){
      var asset_class = $('#asset_class').val();
      getassetNamedropdown(asset_class);
    });
    //asset value based on asset name change
    $('#asset_name').change(function(){
      var assetname = $(this).find('option:selected').data('id');
      $.ajax({
        url: 'assetDetails/ajaxgetassetValuedropdown.php',
        type: 'POST',
        cache: false,
        data:{'asset_name':assetname},
        dataType:'json',
        success:function(response){
          $('#asset_value').val(response);
          
        }
      });
    });

    //on empty display err message
    $("#spare_name").keyup(function(){
        var CTval = $("#spare_name").val();
        if(CTval.length == ''){
        $("#sparenameCheck").show();
        return false;
        }else{
        $("#sparenameCheck").hide();
        }
    });

    
    //Add Customer Info temprorary
    $("#add_modal_no").click(function(){ 
        additemtable();
        validateTableItem();
    });
    
    // Download button
    $('#downloadAsset').click(function () {
        $.ajax({
          url: 'ajaxAssetUpdateExcel.php',
          catch: false,
          success: function(){
            
            window.location.href='uploads/bulkimport/asset_details_format.xlsx';
          }
        });
    });

  $("#insertsuccess").hide();
  $("#notinsertsuccess").hide();
  //bulk upload
  $("#submitAssetUploadbtn").click(function(){
 
    var file_data = $('#file').prop('files')[0];   
    var asset = new FormData();                  
    asset.append('file', file_data);

    if(file.files.length == 0 ){
      alert("Please Select File");
      return false;
    }
    
    $.ajax({
      url: 'ajaxAssetDetailsupload.php',
      type: 'POST',
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
  

  $('#asset_id').change(function(){
    var assetid = $(this).val();
    $.ajax({
      type: 'POST',
      data:{'assetid':assetid},
      url: 'assetDetails/getAssetRegisterDetails.php',
      cache: false,
      dataType:'json',
      success:function(response){
        getBranch(response['company_id'])
        getassetNamedropdown(response['asset_classification'])
        setTimeout(() => {
          $('#company_id').val(response['company_id']);
          $('#branch_id').val(response['branch_name']);
          $('#asset_class').val(response['asset_classification']);
          $('#asset_name').val(response['asset_name']);
          $('#asset_value').val(response['asset_value']);
          
          resetspareTable(response['branch_name']);
          DropDownStock();
        }, 500);

      }
    });

  });

});//document ready end


//
// $(document).on('click','#add_spares',function(){
//   var branch_id = $('#branch_id :selected').val();
//         if(branch_id>0){
//             return true;
//         }else{
//             alert("Please select Company and Branch Name");
//             return false;
//         }
// });


// Start Model Number table store temproray
$("#sparenameCheck").hide();
$(document).on("click", "#submitSpareNameBtn", function () {
    
    var spare_name = $('#spare_name').val();
    var spare_id = $('#spare_id').val();
    var branch_id = $('#branch_id').val();
    var company_id = $('#company_id').val();
    if(spare_name!=""){
        $.ajax({
            url: 'assetDetails/ajaxInsertSpare.php',
            type: 'POST',
            data: {"spare_name":spare_name,'spare_id':spare_id, 'branch_id':branch_id,'company_id':company_id},
            cache: false,
            success:function(response){
                var insresult = response.includes("Exists");
                var updresult = response.includes("Updated");
                if(insresult){
                    $('#spareInsertNotOk').show(); 
                    setTimeout(function() {
                        $('#spareInsertNotOk').fadeOut('fast');
                    }, 2000);
                }else if(updresult){
                    $('#spareUpdateOk').show();  
                    setTimeout(function() {
                        $('#spareUpdateOk').fadeOut('fast');
                    }, 2000);
                    $("#spareTable").remove();
                    resetspareTable(branch_id);
                    $("#spare_name").val('');
                    $("#spare_id").val('');
                }
                else{
                    $('#spareInsertOk').show();  
                    setTimeout(function() {
                        $('#spareInsertOk').fadeOut('fast');
                    }, 2000);
                    $("#spareTable").remove();
                    resetspareTable(branch_id);
                    $("#spare_name").val('');
                    $("#spare_id").val('');
                }
            }
        });
    }
    else{
        $("#sparenameCheck").show();
    }
});


var selectedRow = null;
function additemtable(){
  var itemFormData = readItem(); 
  if(selectedRow == null){
    var partnumberval = []; 
      partnumberval = document.getElementById("modal_no").value; 
      var productarray = document.getElementsByName("modal_no[]");
      var choosen = 0;
      for(var i=0; i<productarray.length; i++){
        if(partnumberval == productarray[i].value){
          choosen++;
        }
      }
      if(choosen == 0){
        insertItem(itemFormData);
        resetItemForm();
      }
      else{
        insertItem(itemFormData);
        resetItemForm();
      }
  } else {
      partnumberval = document.getElementById("relationship").value;  
      var productarray = document.getElementsByName("relationship[]");
      var choosen = 0;
      for(var i=0; i<productarray.length; i++){
        if(partnumberval == productarray[i].value){
          choosen++;
        }
      }
      if(choosen == 0){
        updateItem(itemFormData);
        resetItemForm();
      }
      else{
        updateItem(itemFormData);
        resetItemForm();
      }
  }
}

	function readItem() {  
		var itemFormData = {};
		itemFormData["modal_no"] = document.getElementById("modal_no").value;
		itemFormData["warranty_upto"] = document.getElementById("warranty_upto").value;
		return itemFormData;
	}

	function insertItem(data){ 
		var table = document.getElementById("moduleTable").getElementsByTagName('tbody')[0];
		var newRow = table.insertRow(table.length);
		if(data.modal_no != ""  && data.warranty_upto != ""){

			cell1=newRow.insertCell(0);
			cell1.innerHTML='<input tabindex="4" type="text" class="form-control" id="modal_no" name="modal_no[]" value="'+data.modal_no+'" readonly></input>';
			
			cell1=newRow.insertCell(1);
			cell1.innerHTML='<input tabindex="4" type="text" class="form-control" id="warranty_upto" name="warranty_upto[]" value="'+data.warranty_upto+'" readonly></input>';

			cell2=newRow.insertCell(2);
			cell2.innerHTML="<a onclick='onDelete(this);'><span class='icon-trash-2'></span></a>";
		}

	}

    function updateItem(data){
      selectedRow.cells[1].innerHTML='<input type="text" readonly name="modal_no[]" id="modal_no" class="form-control" value="'+data.modal_no+'">';
      selectedRow.cells[2].innerHTML='<input type="text" readonly name="warranty_upto[]" id="warranty_upto" class="form-control" value="'+data.warranty_upto+'">';
    }

    function onDelete(td){ 
      if(confirm('Are you sure to delete this Model Number?')){
        row = td.parentElement.parentElement;
        document.getElementById("moduleTable").deleteRow(row.rowIndex);
        resetItemForm();
      }
    }

    function resetItemForm(){
      document.getElementById("modal_no").value="";
      document.getElementById("warranty_upto").value="";
      selectedRow = null;
    }

  //End Model Number table store temproray


//get branch name based on company id
  function getBranch(company_id){
    var branch_id_upd = $('#branch_id_upd').val();
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
                var selected = "";
                if(branch_id_upd == response['branch_id'][r]){
                  selected = "selected";
                } 
                  $('#branch_id').append("<option value='" + response['branch_id'][r] +"' "+ selected +" >" + response['branch_name'][r] + "</option>");
              }
          }
      });
  }

//reset Spare modal table
function resetspareTable(branch_id){
    $.ajax({
        url: 'assetDetails/ajaxResetSpareTable.php',
        type: 'POST',
        data: {"branch_id":branch_id},
        cache: false,
        success:function(html){
            $("#updatedspareTable").empty();
            $("#updatedspareTable").html(html);
        }
    });
}

//reset spare dropdown when action
// function resetSpareDropdown(branchLogin){
//     $.ajax({
//         url: 'assetDetails/ajaxgetSparedropdown.php',
//         type: 'post',
//         catch: false,
//         dataType: 'json',
//         data: {'branch_id':branchLogin},
//         success:function(response){
            
//             var len = response.length;
            
//             $("#spare_names").empty();

//             // // Select the dropdown element
//             // var dropdown = document.querySelector(".dropdown-menu.inner.show");

//             // // Remove all existing options
//             // while (dropdown.firstChild) {
//             // dropdown.removeChild(dropdown.firstChild);
//             // }

//             for(var i = 0; i<len; i++){
//                 var spare_id = response[i]['spare_id'];
//                 var spare_name = response[i]['spare_name'];
//                 $("#spare_names").append("<option value='"+spare_id+"'>"+spare_name+"</option>");
                
//                 // var li = document.createElement("li");
//                 // var option = document.createElement("a");
//                 // option.setAttribute("role", "option");
//                 // option.setAttribute("class", "dropdown-item");
//                 // option.setAttribute("aria-disabled", "false");
//                 // option.setAttribute("tabindex", "0");
//                 // option.setAttribute("aria-selected", "false");
                
//                 // var checkmark = document.createElement("span");
//                 // checkmark.setAttribute("class", "bs-ok-default check-mark");
                
//                 // var optionText = document.createElement("span");
//                 // optionText.setAttribute("class", "text");
//                 // optionText.textContent = response[i]['spare_name'];
                
//                 // option.appendChild(checkmark);
//                 // option.appendChild(optionText);
                
//                 // li.appendChild(option);
//                 // dropdown.appendChild(li);
//                 }
//             }
            
//         });  

// }

//table initialize
$(function(){

    $('#spareTable').DataTable({
    'iDisplayLength': 5,
    "language": {
        "lengthMenu": "Display _MENU_ Records Per Page",
        "info": "Showing Page _PAGE_ of _PAGES_",
    }
    });

    //spare table reset based on user login
    // var branchLogin = $('#branch_id').val();
    // resetspareTable(branchLogin);
    // resetSpareDropdown(branchLogin);

    //on update functions
    var asset_details_id_upd = $('#asset_details_id_upd').val();
    var asset_class_id = $('#asset_class_id_upd').val();
    var company_id_upd = $('#company_id_upd').val();
    var branch_id_upd = $('#branch_id_upd').val();
    if(asset_details_id_upd != ''){
      getBranch(company_id_upd);
      resetspareTable(branch_id_upd);
      getassetNamedropdown(asset_class_id);
    }

    getAssetID();
});


$("body").on("click","#edit_spare",function(){

  var spare_id=$(this).attr('value');
  $("#spare_id").val(spare_id);
  $.ajax({
          url: 'assetDetails/ajaxEditSpare.php',
          type: 'POST',
          data: {"spare_id":spare_id},
          cache: false,
          success:function(response){
          $("#spare_name").val(response);
      }
  });
});

$("body").on("click","#delete_spare", function(){
  var isok=confirm("Do you want delete Spare?");
  if(isok==false){
  	return false;
  }else{
      var spare_id=$(this).attr('value');
      var c_obj = $(this).parents("tr");
      $.ajax({
		url: 'assetDetails/ajaxDeleteSpare.php',
		type: 'POST',
		data: {"spare_id":spare_id},
		cache: false,
		success:function(response){
			var delresult = response.includes("Rights");
			if(delresult){
			$('#spareDeleteNotOk').show(); 
			setTimeout(function() {
			$('#spareDeleteNotOk').fadeOut('fast');
			}, 2000);
			}
			else{
			c_obj.remove();
			$('#spareDeleteOk').show();  
			setTimeout(function() {
			$('#spareDeleteOk').fadeOut('fast');
			}, 2000);
			}
		}
      });
  	}
});

function DropDownStock(){
  var branch_id = $('#branch_id').val();
  // var id = $('#id').val();
  // if(id > 0){
    var editsparename = $('#spare_name_edit').val().split(',');
  // }else{
  //   var editsparename = $('#spare_names').val();
  // }
  $.ajax({
      url: 'assetDetails/ajaxgetSparedropdown.php',
      type: 'post',
      catch: false,
      dataType: 'json',
      data: {'branch_id':branch_id},
      success:function(response){

		spare_names.clearStore();
		var len = response.length;
		for(var i = 0; i<len; i++){
			var spare_id = response[i]['spare_id'];
			var spare_name = response[i]['spare_name'];
      var selected = '';
      if(editsparename != ''){
          for(var i=0; i < editsparename.length; i++){
              if(editsparename[i] == spare_id){ 
                  selected = 'selected'; 
              }
          }
      }
			var items = [
				{
					value: spare_id,
					label: spare_name,
          selected: selected,
				}
			];
			spare_names.setChoices(items);
			spare_names.init();
		}
      }
          
  });
}

function getassetNamedropdown(asset_class){
  var asset_name_upd = $('#asset_name_upd').val();
  $.ajax({
    url: 'assetDetails/ajaxgetassetNamedropdown.php',
    type: 'POST',
    cache: false,
    data:{'asset_class':asset_class},
    dataType:'json',
    success:function(response){
      var len = response.length;
      $("#asset_name").empty();
      $("#asset_name").prepend("<option value=''>Select Asset Name</option>");
      for(var i = 0; i<len; i++){
          var asset_id = response[i]['asset_id'];
          var asset_name_id = response[i]['asset_name_id'];
          var asset_name = response[i]['asset_name'];
          var selected = "";
          if(asset_name_upd == response[i]['asset_name_id']){
            selected = "selected";
          } 
          $("#asset_name").append("<option value='"+asset_name_id+"' "+selected+" data-id='"+asset_id+"'>"+asset_name+"</option>");
      }
    }
  });
}

function getAssetID(){
  var asset_register_id = $('#asset_register_id').val();
  $.ajax({
    type: 'POST',
    url: 'assetDetails/getAssetIDAutoGen.php',
    cache: false,
    data:{},
    dataType:'json',
    success:function(response){
      var len = response.length;
      $("#asset_id").empty();
      $("#asset_id").prepend("<option value=''>Select Asset ID</option>");
      for(var i = 0; i<len; i++){
          var asset_id = response[i]['asset_id'];
          var asset_autoGen_id = response[i]['asset_autoGen_id'];
          var selected = "";
          if(asset_register_id == response[i]['asset_id']){
            selected = "selected";
          } 
          $("#asset_id").append("<option value='"+asset_id+"' "+selected+">"+asset_autoGen_id+"</option>");
      }
    }
  });

}