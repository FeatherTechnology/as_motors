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


    // Modal Box for Category Name
    $("#loancategorynameCheck").hide();
    $(document).on("click", "#submitLoanCategoryModal", function () {
        var category_creation_id=$("#category_creation_id").val();
        var category_creation_name=$("#category_creation_name").val();
        if(category_creation_name!=""){
            $.ajax({
                url: 'pmchecklistFile/ajaxInsertCategory.php',
                type: 'POST',
                data: {"category_creation_name":category_creation_name,"category_creation_id":category_creation_id},
                cache: false,
                success:function(response){
                    var insresult = response.includes("Exists");
                    var updresult = response.includes("Updated");
                    if(insresult){
                        $('#categoryInsertNotOk').show(); 
                        setTimeout(function() {
                            $('#categoryInsertNotOk').fadeOut('fast');
                        }, 2000);
                    }else if(updresult){
                        $('#categoryUpdateOk').show();  
                        setTimeout(function() {
                            $('#categoryUpdateOk').fadeOut('fast');
                        }, 2000);
                        $("#coursecategoryTable").remove();
                        resetloancategoryTable();
                        $("#category_creation_name").val('');
                        $("#category_creation_id").val('');
                    }
                    else{
                        $('#categoryInsertOk').show();  
                        setTimeout(function() {
                            $('#categoryInsertOk').fadeOut('fast');
                        }, 2000);
                        $("#coursecategoryTable").remove();
                        resetloancategoryTable();
                        $("#category_creation_name").val('');
                        $("#category_creation_id").val('');
                    }
                }
            });
        }
        else{
        $("#loancategorynameCheck").show();
        }
    });


    function resetloancategoryTable(){
        $.ajax({
            url: 'pmchecklistFile/ajaxResetCategoryTable.php',
            type: 'POST',
            data: {},
            cache: false,
            success:function(html){
                $("#updatedloancategoryTable").empty();
                $("#updatedloancategoryTable").html(html);
            }
        });
    }

    $("#category_creation_name").keyup(function(){
        var CTval = $("#category_creation_name").val();
        if(CTval.length == ''){
        $("#loancategorynameCheck").show();
        return false;
        }else{
        $("#loancategorynameCheck").hide();
        }
    });

    $("body").on("click","#edit_category",function(){
        var category_creation_id=$(this).attr('value');
        $("#category_creation_id").val(category_creation_id);
        $.ajax({
                url: 'pmchecklistFile/ajaxEditCategory.php',
                type: 'POST',
                data: {"category_creation_id":category_creation_id},
                cache: false,
                success:function(response){
                $("#category_creation_name").val(response);
            }
        });
    });

    $("body").on("click","#delete_category", function(){
        var isok=confirm("Do you want delete course category?");
        if(isok==false){
            return false;
        }else{
            var category_creation_id=$(this).attr('value');
            var c_obj = $(this).parents("tr");
            $.ajax({
                url: 'pmchecklistFile/ajaxDeleteCategory.php',
                type: 'POST',
                data: {"category_creation_id":category_creation_id},
                cache: false,
                success:function(response){
                    var delresult = response.includes("Rights");
                    if(delresult){
                    $('#categoryDeleteNotOk').show(); 
                    setTimeout(function() {
                    $('#categoryDeleteNotOk').fadeOut('fast');
                    }, 2000);
                    }
                    else{
                    c_obj.remove();
                    $('#categoryDeleteOk').show();  
                    setTimeout(function() {
                    $('#categoryDeleteOk').fadeOut('fast');
                    }, 2000);
                    }
                }
            });
        }
    });

    $(function(){
        $('#coursecategoryTable').DataTable({
            'iDisplayLength': 5,
            "language": {
            "lengthMenu": "Display _MENU_ Records Per Page",
            "info": "Showing Page _PAGE_ of _PAGES_",
            }
        });
    });

});

function DropDownCourse(){
    $.ajax({
        url: 'pmchecklistFile/ajaxGetCategory.php',
        type: 'post',
        data: {},
        dataType: 'json',
        success:function(response){

            var len = response.length;
            $("#category_id").empty();
            $("#category_id").append("<option value=''>"+'Select Loan Category'+"</option>");
            for(var i = 0; i<len; i++){
                var category_creation_id = response[i]['category_creation_id'];
                var category_creation_name = response[i]['category_creation_name'];
                $("#category_id").append("<option value='"+category_creation_id+"'>"+category_creation_name+"</option>");
            }
        }
    });
}

// get details on edit
// $(function(){
//     // manager login
//     getdepartmentLoad();
// });

// get department details
// function getdepartmentLoad(){ 
//     $.ajax({
//         url: 'tagFile/ajaxStaffDepartmentDetailsLoad.php',
//         type: 'post',
//         data: {},
//         dataType: 'json',
//         success:function(response){  

//             $('#department_id').empty();
//             $('#department_id').prepend("<option value=''>" + 'Select Department Name' + "</option>");
//             var r = 0;
//             for (r = 0; r <= response.department_id.length - 1; r++) { 
//                 $('#department_id').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r] + "</option>");
//             }
//         }
//     });
// }

// Get branch based on Department
// $(document).on('change','#branch_id', function(){
// $("#branch_id").change(function(){

//     var company_id = $("#branch_id").val();
//     if(company_id.length==''){
//         $("#branch_id").val('');
//     }else{
    
//         $.ajax({
//             url: 'StaffFile/ajaxStaffDepartmentDetails.php',
//             type: 'post',
//             data: { "company_id":company_id },
//             dataType: 'json',
//             success:function(response){ 

//                 $('#department_id').empty();
//                 $('#department_id').prepend("<option value=''>" + 'Select Department Name' + "</option>");
//                 var r = 0;
//                 for (r = 0; r <= response.department_id.length - 1; r++) { 
//                     $('#department_id').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r] + "</option>");
//                 }
//             }
//         });
//     }
// });

// Hide and show type of checklist
$("#type_of_checklist").change(function() {

    var type_of_checklist = $("#type_of_checklist").val(); 

    if(type_of_checklist == "Yes/No/NA"){
        $(".yes_no_na").css("display", "block");
        $(".no_of_option").css("display", "none");
        $(".options").css("display", "none");
    }else if(type_of_checklist == "Option"){
        $(".yes_no_na").css("display", "none");
        $(".no_of_option").css("display", "block");
        $(".options").css("display", "block");
    }else if(type_of_checklist == ""){
        $(".yes_no_na").css("display", "none");
        $(".no_of_option").css("display", "none");
        $(".options").css("display", "none");
    }
});

// option enable and disable
$("#no_of_option").change(function() {

    var no_of_option = $("#no_of_option").val(); 

    if(no_of_option == 1){
        $("#option1").attr("readonly", false); 
        $("#option2").attr("readonly", false); 
        $("#option3").attr("readonly", true); 
        $("#option4").attr("readonly", true); 
    }else if(no_of_option == 2){
        $("#option1").attr("readonly", false); 
        $("#option2").attr("readonly", false); 
        $("#option3").attr("readonly", true); 
        $("#option4").attr("readonly", true); 
    }else if(no_of_option == 3){
        $("#option1").attr("readonly", false); 
        $("#option2").attr("readonly", false); 
        $("#option3").attr("readonly", false); 
        $("#option4").attr("readonly", true); 
    }else if(no_of_option == 4){
        $("#option1").attr("readonly", false); 
        $("#option2").attr("readonly", false); 
        $("#option3").attr("readonly", false); 
        $("#option4").attr("readonly", false); 
    }else if(no_of_option == ""){
        $("#option1").attr("readonly", true); 
        $("#option2").attr("readonly", true); 
        $("#option3").attr("readonly", true); 
        $("#option4").attr("readonly", true); 
    }

});


// Add Customer Info temprorary
// $("#add_pmchecklistDetails").click(function(){ 
//     addpmchecklisttable();
// });
        
// var selectedRow = null;
// function addpmchecklisttable(){ 
//     var pmchecklistFormData = readpmchecklist(); 
//     if(selectedRow == null){
//     var partnumberval = []; 
//     partnumberval = document.getElementById("category_id").value; 
//     var productarray = document.getElementsByName("category_id[]");
//     var choosen = 0;
//     for(var i=0; i<productarray.length; i++){
//         if(partnumberval == productarray[i].value){
//         choosen++;
//         }
//     }
//     if(choosen == 0){
//         insertpmchecklist(pmchecklistFormData);
//         resetpmchecklistForm();
//     }
//     else{
//         insertpmchecklist(pmchecklistFormData);
//         resetpmchecklistForm();
//     }
//     } else {
//         partnumberval = document.getElementById("category_id").value;  
//         var productarray = document.getElementsByName("category_id[]");
//         var choosen = 0;
//         for(var i=0; i<productarray.length; i++){
//             if(partnumberval == productarray[i].value){
//             choosen++;
//             }
//         }
//         if(choosen == 0){
//             updatepmchecklist(pmchecklistFormData);
//             resetpmchecklistForm();
//         }
//         else{
//             updatepmchecklist(pmchecklistFormData);
//             resetpmchecklistForm();
//         }
//     }
// }
    
// function readpmchecklist() {  

//     var pmchecklistFormData = {};
//     pmchecklistFormData["category_id"] = document.getElementById("category_id").value;
//     var selCategoryName = document.getElementById("category_id");
//     pmchecklistFormData["category_val"] = selCategoryName.options[selCategoryName.selectedIndex].text; 
//     pmchecklistFormData["checklist"] = document.getElementById("checklist").value;
//     pmchecklistFormData["type_of_checklist"] = document.getElementById("type_of_checklist").value;
//     pmchecklistFormData["no_of_option"] = document.getElementById("no_of_option").value;
//     return pmchecklistFormData;
// }
    
// function insertpmchecklist(data){ 

//     var table = document.getElementById("pmchecklistTable").getElementsByTagName('tbody')[0];
//     var newRow = table.insertRow(table.length);
//     if(data.checklist != ""  && data.category_id != "" && data.type_of_checklist != "" && data.no_of_option != ""){

//         cell0=newRow.insertCell(0);
//         cell0.innerHTML='<input type="text" readonly name="category_val[]" id="category_val" class="form-control" value="'+data.category_val+'">'+'<input type="hidden" readonly name="category_id[]" id="category_id" class="form-control" value="'+data.category_id+'"></input>';

//         cell1=newRow.insertCell(1);
//         cell1.innerHTML='<input type="text" readonly name="checklist[]" id="checklist" class="form-control" value="'+data.checklist+'">';
        
//         cell2=newRow.insertCell(2);
//         cell2.innerHTML='<input type="text" readonly name="type_of_checklist[]" id="type_of_checklist" class="form-control" value="'+data.type_of_checklist+'">';

//         cell3=newRow.insertCell(3);
//         cell3.innerHTML='<input type="text" readonly name="no_of_option[]" id="no_of_option" class="form-control" value="'+data.no_of_option+'">';

//         cell4=newRow.insertCell(4);
//         cell4.innerHTML="<a onclick='onDelete(this);'><span class='icon-trash-2'></span></a>";
//     }
// }

// function onUpdate(td){
//     selectedRow=td.parentElement.parentElement;
//     document.getElementById("category_id").value=selectedRow.cells[2].querySelector('input').value;
//     document.getElementById("checklist").value=selectedRow.cells[1].querySelector('input').value;
//     document.getElementById("type_of_checklist").value=selectedRow.cells[1].querySelector('input').value;
//     document.getElementById("no_of_option").value=selectedRow.cells[1].querySelector('input').value;
// }

// function updatepmchecklist(data){
//     selectedRow.cells[2].innerHTML='<input type="text" readonly name="category_id[]" id="category_id" class="form-control" value="'+data.category_id+'">';
//     selectedRow.cells[1].innerHTML='<input type="text" readonly name="checklist[]" id="checklist" class="form-control" value="'+data.checklist+'">';
//     selectedRow.cells[1].innerHTML='<input type="text" readonly name="type_of_checklist[]" id="type_of_checklist" class="form-control" value="'+data.type_of_checklist+'">';
//     selectedRow.cells[1].innerHTML='<input type="text" readonly name="no_of_option[]" id="no_of_option" class="form-control" value="'+data.no_of_option+'">';
// }

// function onDelete(td){ 
//     row = td.parentElement.parentElement;
//     document.getElementById("pmchecklistTable").deleteRow(row.rowIndex);
//     resetpmchecklistForm();
// }

// function resetpmchecklistForm(){
//     document.getElementById("category_id").value="";
//     document.getElementById("checklist").value="";
//     document.getElementById("type_of_checklist").value="";
//     document.getElementById("no_of_option").value="";
//     selectedRow = null;
// }
