// choices js for multi select dropdown:
const designation = new Choices('#designation', {
	removeItemButton: true,
});

$(document).ready(function () {

    // get company based branch name
    $('#company_id').on('change',function(){
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

    //Get Department Code
    $("#department").on('change',function(){ 
        var company_name = $('#branch_id :selected').text();
        var department_name = $('#department :selected').text(); 
        var idupd = $("#company_id_upd").val();

        if(idupd == ""){
           getDepartmentCode(department_name,company_name);
            // $("#department_code").val(department_code);
        }else{
            var dept_code_upd = $('#department_code').val();
            var department_name_3 = (department_name).substring(0,3);
            var parts = dept_code_upd.split("-");
            parts[0] = department_name_3;
            var department_code = parts.join("-");
            $("#department_code").val(department_code);
        }
    });
    
   //End Department Code
   $(document).on("click", "#add_departmentDetails", function () {
        if($('#branch_id_session').val() != 'Overall'){
            var branch_id = $('#branch_id').val();
        }else{
        var branch_id = $('#branch_id :selected').val();
        }
        if(branch_id>0 ){
            return true;
        }else{
            alert("Please select Company and Branch Name");
            return false;
        }
   });

   $(document).on("click", "#add_designationDetails", function () {
        if($('#branch_id_session').val() != 'Overall'){
            var branch_id = $('#branch_id').val();
        }else{
        var branch_id = $('#branch_id :selected').val();
        }
        if(branch_id>0){
            return true;
        }else{
            alert("Please select Company and Branch Name");
            return false;
        }
   });
  
    // Modal Box for Department Name
    $("#departmentnameCheck").hide();
    $(document).on("click", "#submitDepartmentBtn", function () {
        if($('#branch_id_session').val() != 'Overall'){
            var branch_id = $('#branch_id').val();
        }else{
        var branch_id = $('#branch_id :selected').val();
        }
        var department_id=$("#department_id").val();
        var department_name=$("#department_name").val();
        if(department_name!=""){
            $.ajax({
                url: 'departmentFile/ajaxInsertDepartment.php',
                type: 'POST',
                data: {"department_name":department_name,"department_id":department_id,"branch_id":branch_id},
                cache: false,
                success:function(response){
                    var insresult = response.includes("Exists");
                    var updresult = response.includes("Updated");
                    if(insresult){
                        $('#departmentInsertNotOk').show(); 
                        setTimeout(function() {
                            $('#departmentInsertNotOk').fadeOut('fast');
                        }, 2000);
                    }else if(updresult){
                        $('#departmentUpdateOk').show();  
                        setTimeout(function() {
                            $('#departmentUpdateOk').fadeOut('fast');
                        }, 2000);
                        $("#departmentTable").remove();
                        resetdepartmentTable(branch_id);
                        $("#department_name").val('');
                        $("#department_id").val('');
                    }
                    else{
                        $('#departmentInsertOk').show();  
                        setTimeout(function() {
                            $('#departmentInsertOk').fadeOut('fast');
                        }, 2000);
                        $("#departmentTable").remove();
                        resetdepartmentTable(branch_id);
                        $("#department_name").val('');
                        $("#department_id").val('');
                    }
                }
            });
        }
        else{
            $("#departmentnameCheck").show();
        }
    });

    //Company name onclick event
    $('#branch_id').on('change',function(){
        var branch_id = $('#branch_id :selected').val();
        var company_name = $('#branch_id :selected').text(); 
        var department_upd,designation_upd,report_to_upd = "";

        if(branch_id != 0){

            // change attribute for modals
            $('#add_departmentDetails').attr({"data-toggle":"modal" ,"data-target":".addDepartmentModal"});
            $('#add_designationDetails').attr({"data-toggle":"modal" ,"data-target":".addDesignationModal"});
    
            //to select departments dropdown based on company name
            companyDetails(branch_id,department_upd,designation_upd);
            
            //Get Designation Code
            // getDesignationCode(company_name);
            var idupd = $("#company_id_upd").val()
            if(idupd <= 0){
                getDesignationCode(company_name);
            }else{
                var des_code_upd = $('#designation_code_upd').val();
                var designation_code =des_code_upd.substring(0,8) + company_name;
                //  alert(designation_code);
                $("#designation_code").val(designation_code);

                var dept_code_upd = $('#department_code_upd').val();
                var department_code =dept_code_upd.substring(0,6) + company_name;
                //  alert(department_code);
                $("#department_code").val(department_code);
            }

            //get department data based on company details for datatables
            $("#departmentTable").remove();
            resetdepartmentTable(branch_id);
            
            //get designation data based on company details for datatables
            $("#designationTable").remove();
            resetdesignationTable(branch_id);

            //get reporting person data based on company name
            resetreportingdropdown(branch_id,report_to_upd);
        }
        else{
            // remove modal attribute when company not selected
            $('#add_departmentDetails').removeAttr("data-toggle");
            $('#add_departmentDetails').removeAttr("data-target");
            $('#add_designationDetails').removeAttr("data-toggle");
            $('#add_designationDetails').removeAttr("data-target");
        }
    });

    $(function(){ 
        var idupd = $("#branch_id").val();
        var upd_name = $("#branch_id :selected").text();
        if(idupd != null){
            var department_upd = $('#department_upd').val();
            var designation_upd = $('#designation_upd').val();
            var report_to_upd = $('#report_to_upd').val();
            $('#add_departmentDetails').attr({"data-toggle":"modal" ,"data-target":".addDepartmentModal"})
            $('#add_designationDetails').attr({"data-toggle":"modal" ,"data-target":".addDesignationModal"})
            // companyDetails(idupd,department_upd,designation_upd);
            resetdepartmentTable(idupd);
            resetdesignationTable(idupd);
            resetreportingdropdown(idupd,report_to_upd);
            getDesignationCode(upd_name);
        }

        $('#departmentTable').DataTable({
            'iDisplayLength': 5,
            "language": {
                "lengthMenu": "Display _MENU_ Records Per Page",
                "info": "Showing Page _PAGE_ of _PAGES_",
            }
        });

        $('#designationTable').DataTable({
            'iDisplayLength': 5,
            "language": {
                "lengthMenu": "Display _MENU_ Records Per Page",
                "info": "Showing Page _PAGE_ of _PAGES_",
            }
        });

    });
    
    //to select departments dropdown based on company name
    function companyDetails(branch_id,department_upd,designation_upd){
        $.ajax({
            url: 'ajaxGetCompanyBasedDetails.php',
            type:'post',
            data: {'branch_id': branch_id,'department_upd':department_upd,'designation_upd':designation_upd},
            dataType: 'json',
            success: function(response){

				designation.clearStore();
				for (r = 0; r <= response.designation_id.length - 1; r++) { 
					var designation_id = response['designation_id'][r];  
					var designation_name = response['designation_name'][r]; 
					var items = [
						{
							value: designation_id,
							label: designation_name,
						}
					];
					designation.setChoices(items);
					designation.init();
				}
                
                $("#department").empty();
                $("#department").prepend("<option value='' disabled selected>"+'Select Department'+"</option>");
                for(var i = 0; i<response['department_id'].length; i++){
                    var department_id = response['department_id'][i];
                    var department_name = response['department_name'][i];
                    var selected = "";
                    if(department_upd==department_id) 
                    {
                        selected = "selected";
                    }
                    $("#department").append("<option value='"+department_id+"' "+selected+">"+department_name+"</option>");
                }
            }
        });
    }

    //Get Department Code
    function getDepartmentCode(department_name,company_name){
        $.ajax({
            url: "departmentFile/getDepartmentCode.php",
            data: {
                "department_name":department_name,
                "company_name": company_name
                },
            cache: false,
            type: "post", 
            dataType: "json",
            success: function (data) {
                
                $("#department_code").val(data);
            }
        });
    }

    function getDesignationCode(company_name){

        $.ajax({
            url: "designationFile/getDesignationCode.php",
            data: {'company_name': company_name},
            cache: false,
            type: "post", 
            dataType: "json",
            success: function (data) {
                $("#designation_code").val(data);
            }
        });  
    }
    
    //report Dropdown
    function resetreportingdropdown(branch_id,report_to_upd){ 

         $.ajax({
            url: 'ajaxResetReportingDropdown.php',
            type: 'POST',
            data: {"branch_id":branch_id},
            cache: false,
            dataType: 'json',
            success:function(response){ 
                
                $("#report_to").empty();
                $("#report_to").append("<option value=''>"+'Select reporting Person'+"</option>");
                for(var i = 0; i<response.designation_id.length; i++){ 
                    var selected = "";
                    if(report_to_upd == response['designation_id'][i]) {
                        selected = "selected";
                    }   
                    $("#report_to").append("<option value='"+response['designation_id'][i]+"' "+selected+">"+response['designation_name'][i]+"</option>");
                }
            }
        });
    }
    
    //reset department modal table
    function resetdepartmentTable(branch_id){
       
        $.ajax({
            url: 'departmentFile/ajaxResetDepartmentTable.php',
            type: 'POST',
            data: {"branch_id":branch_id},
            cache: false,
            success:function(html){
                $("#updateddepartmentTable").empty();
                $("#updateddepartmentTable").html(html);
            }
        });
    }
    

    $("#department_name").keyup(function(){

        var CTval = $("#department_name").val();
        if(CTval.length == ''){
        $("#departmentnameCheck").show();
        return false;
        }else{
        $("#departmentnameCheck").hide();
        }
    });

    
    $("body").on("click","#edit_department",function(){

        var department_id=$(this).attr('value');
        $("#department_id").val(department_id);
        $.ajax({
                url: 'departmentFile/ajaxEditDepartment.php',
                type: 'POST',
                data: {"department_id":department_id},
                cache: false,
                success:function(response){
                $("#department_name").val(response);
            }
        });
    });


    $("body").on("click","#delete_department", function(){

        var isok=confirm("Do you want delete Department?");
        if(isok==false){
        return false;
        }else{
            var department_id=$(this).attr('value');
            var c_obj = $(this).parents("tr");
            $.ajax({
                url: 'departmentFile/ajaxDeleteDepartment.php',
                type: 'POST',
                data: {"department_id":department_id},
                cache: false,
                success:function(response){
                    var delresult = response.includes("Rights");
                    if(delresult){
                    $('#departmentDeleteNotOk').show(); 
                    setTimeout(function() {
                    $('#departmentDeleteNotOk').fadeOut('fast');
                    }, 2000);
                    }
                    else{
                    c_obj.remove();
                    $('#departmentDeleteOk').show();  
                    setTimeout(function() {
                    $('#departmentDeleteOk').fadeOut('fast');
                    }, 2000);
                    }
                }
            });
        }
    });

     // Modal Box for Designation Name
     $("#designationnameCheck").hide();
     $(document).on("click", "#submitDesignationBtn", function () {
        if($('#branch_id_session').val() != 'Overall'){
            var branch_id = $('#branch_id').val();
        }else{
        var branch_id = $('#branch_id :selected').val();
        }
         var designation_id=$("#designation_id").val();
         var designation_name=$("#designation_name").val();
         if(designation_name!=""){
             $.ajax({
                 url: 'designationFile/ajaxInsertDesignation.php',
                 type: 'POST',
                 data: {"designation_name":designation_name,"designation_id":designation_id,"branch_id": branch_id},
                 cache: false,
                 success:function(response){
                     var insresult = response.includes("Exists");
                     var updresult = response.includes("Updated");
                     if(insresult){
                         $('#designationInsertNotOk').show(); 
                         setTimeout(function() {
                             $('#designationInsertNotOk').fadeOut('fast');
                         }, 2000);
                     }else if(updresult){
                         $('#designationUpdateOk').show();  
                         setTimeout(function() {
                             $('#designationUpdateOk').fadeOut('fast');
                         }, 2000);
                         $("#designationTable").remove();
                         resetdesignationTable(branch_id);
                         $("#designation_name").val('');
                         $("#designation_id").val('');
                     }
                     else{
                         $('#designationInsertOk').show();  
                         setTimeout(function() {
                             $('#designationInsertOk').fadeOut('fast');
                         }, 2000);
                         $("#designationTable").remove();
                         resetdesignationTable(branch_id);
                         $("#designation_name").val('');
                         $("#designation_id").val('');
                     }
                 }
             });
         }
         else{
         $("#designationnameCheck").show();
         }
     });

    //reset designation modal table
     function resetdesignationTable(branch_id){

        $.ajax({
            url: 'designationFile/ajaxResetDesignationTable.php',
            type: 'POST',
            data: {"branch_id":branch_id},
            cache: false,
            success:function(html){
                $("#updateddesignationTable").empty();
                $("#updateddesignationTable").html(html);
            }
        });
     }
 
     $("#designation_name").keyup(function(){

         var CTval = $("#designation_name").val();
         if(CTval.length == ''){
         $("#designationnameCheck").show();
         return false;
         }else{
         $("#designationnameCheck").hide();
         }
     });
 
     $("body").on("click","#edit_designation",function(){

         var designation_id=$(this).attr('value');
         $("#designation_id").val(designation_id);
         $.ajax({
                 url: 'designationFile/ajaxEditDesignation.php',
                 type: 'POST',
                 data: {"designation_id":designation_id},
                 cache: false,
                 success:function(response){
                 $("#designation_name").val(response);
             }
         });
     });
 
     $("body").on("click","#delete_designation", function(){

        var isok=confirm("Do you want Delete Designation?");
        if(isok==false){
        return false;
        }else{
            var designation_id=$(this).attr('value');
            var c_obj = $(this).parents("tr");
            $.ajax({
                url: 'designationFile/ajaxDeleteDesignation.php',
                type: 'POST',
                data: {"designation_id":designation_id},
                cache: false,
                success:function(response){
                    var delresult = response.includes("Rights");
                    if(delresult){
                    $('#designationDeleteNotOk').show(); 
                    setTimeout(function() {
                    $('#designationDeleteNotOk').fadeOut('fast');
                    }, 2000);
                    }
                    else{
                    c_obj.remove();
                    $('#designationDeleteOk').show();  
                    setTimeout(function() {
                    $('#designationDeleteOk').fadeOut('fast');
                    }, 2000);
                    }
                }
            });
        }
     });


    $("#common").click(function(){
        $(".common").css('display','block');
        $(".specific").css('display','none');
    });

    $("#specific").click(function(){
        $(".specific").css('display','block');
        $(".common").css('display','none');
    });

    $(document).on('click','#submitBasicCreation', function(){
        var designation_names = $('#defaultCategory').val();
        $.ajax({
            url: 'StaffFile/ajaxGetDepartmentDetails.php',
            type: 'post',
            data: { "designation_names" : designation_names },
            cache: false,
            dataType: 'json',
            success:function(response){ 
                
                $("#end_buttons").append("<input type='hidden' class='form-control designation_id' id='designation_id' name='designation_id' value='"+ response['designation_id'] +"'/>");
            }

        });
    });

    
}); // document ready end

function DropDownStock(){
    if($('#branch_id_session').val() != 'Overall'){
        var company_id = $('#branch_id').val();
    }else{
        var company_id = $('#branch_id :selected').val();
    }
    $.ajax({
        url: 'departmentFile/ajaxgetdepartmentdropdown.php',
        type: 'post',
        data: {'company_id': company_id},
        dataType: 'json',
        success:function(response){

            var len = response.length;

            $("#department").empty();
            $("#department").append("<option value=''disabled selected>"+'Select Department'+"</option>");
            for(var i = 0; i<len; i++){
                var department_id = response[i]['department_id'];
                var department_name = response[i]['department_name'];
                $("#department").append("<option value='"+department_id+"'>"+department_name+"</option>");
            }
        }
    });
}

function DropDownDesignation(){
    if($('#branch_id_session').val() != 'Overall'){
        var company_id = $('#branch_id').val();
    }else{
        var company_id = $('#branch_id :selected').val();
    }
    
    $.ajax({
        url: 'designationFile/ajaxgetdesignationdropdown.php',
        type: 'post',
        data: {'company_id': company_id},
        dataType: 'json',
        success:function(response){

            designation.clearStore();
            var len = response.length;
            for(var i = 0; i<len; i++){
                var designation_id = response[i]['designation_id'];
                var designation_name = response[i]['designation_name'];
                var items = [
                    {
                        value: designation_id,
                        label: designation_name,
                    }
                ];
                designation.setChoices(items);
                designation.init();
            }
        }
            
    });
        
}

// get designation details
function editBranchBasedDesignation(){ 
 
    var basic_creation_id = $('#basic_creation_idEdit').val(); 
    var branch_id = $('#company_nameEdit').val(); 
    var designationEdit = $('#designationEdit').val().split(',');  
//     var desig = $('.choices__list').val();
//  console.log("designation_id",desig);
   
    // console.log(designationEdit)
    $.ajax({
        url: 'basicFile/getDesignationDetails.php',
        type: 'post',
        data: { "basic_creation_id":basic_creation_id, "branch_id":branch_id },
        dataType: 'json',
        success:function(response){  

            designation.clearStore();
            for (var r = 0; r <= response.designation_id.length - 1; r++) {     
                var designation_id = response['designation_id'][r];  
                var designation_name = response['designation_name'][r]; 
// console.log("designation_id",designation_id);
// console.log("designation_name",designation_name);
                var selected = '';
                if(designationEdit != ''){
             
                
                    for(var i=0;i<designationEdit.length;i++){

                        if(designationEdit[i] == designation_id){ 
                            selected = 'selected';
                            
                        }
                    }
                

                }

                var items = [
                    {
                        value: designation_id,
                        label: designation_name,
                        selected: selected,
                    }
                ];
                
                designation.setChoices(items);
                designation.init();
            }
        }
    });
    
};