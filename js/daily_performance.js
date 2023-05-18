// Document is ready
$(document).ready(function () {

    
var currentDate = new Date();

// Format the date as "YYYY-MM-DD" (required by the input type="date")
var formattedDate = currentDate.toISOString().split('T')[0];

// Set the value of the input field to the current date
document.getElementById('sdate').value = formattedDate;




    // remove delete option for last child
    $('#delete_row:last').filter(':last').attr('id', '');

    //disable dropdown in case of update
    if($('#audit_area_id').val() > 0){
        $('#audit').attr("disabled", true);
    }
    $("#audit").change( function(){
        $('#audit_err').css('color','');
        var audit_id = $("#audit").val();
        var id= $('#id').val();
        $.ajax({
            url: 'ajaxAuditDetailsList.php',
            data: {"audit_id": audit_id},
            cache: false,
            type: "post",
            dataType: "json",
            success: function (data) {
                if(data['exist']=='' ){
                    $("#dept").val(data['dept']);
                    $("#dept_id").val(data['dept_id']);
                    $("#auditor").val(data['auditor']);
                    $("#auditor_id").val(data['auditor_id']);
                    $("#auditee").val(data['auditee']);
                    $("#auditee_id").val(data['auditee_id']);
                    $('#checklist').attr('hidden', true);
                    $('#checklist_lable').attr('hidden', true);
                    $('#prev').hide();
                    removeData();
                }else{
                    alert(data['exist']);
                    //changing previous checklist properties
                    $("#checklist").prop("checked", true);
                    $("#checklist").attr("disabled", true);
                    $('#checklist').attr('hidden', false);
                    $('#checklist_lable').attr('hidden', false);
                    $('#prev').show();
                    removeData();
                    //setting existing audit area and changing table contents
                    $('#prev').val(audit_id);
                    $('#prev').attr("disabled", true);
                    insertData(audit_id);
                    $("#dept").val(data['dept']);
                    $("#dept_id").val(data['dept_id']);
                    $("#auditor").val(data['auditor']);
                    $("#auditor_id").val(data['auditor_id']);
                    $("#auditee").val(data['auditee']);
                    $("#auditee_id").val(data['auditee_id']);
                }
            }
        });
    });
    //Previous checklist dropdown open
    $('#checklist').change(function() {
        if ($(this).is(':checked')) {
            $('#prev').show();
            insertData($('#prev'.val()));
        } else {
            $('#prev').hide();
            removeData();
        }
      });



      
     
    //Add new row value="<?php $currentDate = date('Y-m-d'); echo $currentDate;?>"
    // $(document).on('click','#add_row',(function(){ 
        
    //     var appendTxt = "<tr><td><input tabindex='6' type='text' class='form-control' id='assertion' name='assertion[]'></input></td>" +
    //     "<td><input tabindex='7' type='text' class='form-control' id='target' name='target[]'></input></td>"+
    //     "<td><input tabindex='8' type='date' class='form-control' id='sdate' name='sdate[]' value=+"'<?php eho 'hai'; ?>'"+ ></input></td>"+
    //     "<td> <select  class='form-control wstatus' id='wstatus' name='wstatus[]'><option value=''>Select Work Status</option><option value='statisfied'>Statisfied</option><option value='not_done'>Not Done</option><option value='carry_forward'>Carry Forward</option></select></td>"+
    //     "<td><input tabindex='10' type='text' class='form-control' id='status' name='status[]' ></input></td>"+
    //     "<td><button tabindex='11' type='button' tabindex='8' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>"+
    //     "<td><span class='icon-trash-2' tabindex='9' id='delete_row'></span></td></tr>";
               
               
    //              $('#moduleTable').find('tbody').append(appendTxt);
    //              wstatus();
            
    // }));
    $(document).on('click', '#add_row', function() {
        var appendTxt = "<tr><td><input tabindex='6' type='text' class='form-control' id='assertion' name='assertion[]'></input></td>" +
          "<td><input tabindex='7' type='text' class='form-control' id='target' name='target[]'></input></td>" +
          "<td><input tabindex='8' type='date' class='form-control sdate' id='sdate' name='sdate[]' ></input></td>" +
          "<td><select class='form-control wstatus' id='wstatus' name='wstatus[]'><option value=''>Select Work Status</option><option value='statisfied'>Statisfied</option><option value='not_done'>Not Done</option><option value='carry_forward'>Carry Forward</option></select></td>" +
          "<td><input tabindex='10' type='text' class='form-control' id='status' name='status[]'></input></td>" +
          "<td><button tabindex='8' type='button' tabindex='11' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
          "<td><span class='icon-trash-2' tabindex='9' id='delete_row'></span></td></tr>";
      
        $('#moduleTable').find('tbody').append(appendTxt);
        wstatus();
        
      });
      
    // Delete unwanted Rows
    $(document).on("click", '#delete_row', function () {
        $(this).parent().parent().remove();
    });
    //previous checklist append
    $('#prev').change(function() {
        var prev_checklist = $('#prev').val();
        var markup1, markup3 ='';
        if(prev_checklist=="0"){
          removeData();
        }else{
            insertData(prev_checklist);
        }
      });
    //resetting modult table
    function removeData(){
      
        $('#moduleTable').find('tbody').empty();
        var removeData = "<tr><td> <input tabindex='3' type='text' class='form-control' id='major' name='major[]'></input></td>" +
        // "<td> <input tabindex='3' type='text' class='form-control' id='sub' name='sub[]'></input></td>" +
        "<td> <input tabindex='3' type='text' class='form-control' id='assertion' name='assertion[]'></input></td>" +
        // "<td> <input tabindex='3' type='text' class='form-control' id='weightage' name='weightage[]'></input></td>" +
        "<td> <button type='button' tabindex='3' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
        "<td> <span class='icon-trash-2' tabindex='' id='delete_row'></span></td> </tr>";
        $('#moduleTable').find('tbody').html(removeData);
    }
    //insert Data into Module Table
    function insertData(audit_id){
        $('#moduleTable').find('tbody').empty();
                    $.ajax({
                        url: 'getPrevChecklist.php',
                        data: {'prev_checklist': audit_id },
                        cache: false,
                        type:'post',
                        dataType: 'json',
                        success: function(data){
                        //   $('#moduleTable').find('tbody').empty();
                            for(var a=0; a<=data.length-1; a++){
                                markup1 = "<td><input type='text' tabindex='3' class='form-control' value="+ data[a]['major_area'] + " id='major' name='major[]'></input></td>";
                                // markup2= "<td><input type='text' tabindex='3' class='form-control'  value="+ data[a]['sub_area'] + " id='sub' name='sub[]'></input></td>";
                                markup3 = "<td><input type='text' tabindex='3' class='form-control'  value="+ data[a]['assertion'] + " id='assertion' name='assertion[]'></input></td>";
                                // markup4 = "<td><input type='text' tabindex='3' class='form-control'  value="+ data[a]['weightage'] + " id='weightage' name='weightage[]'></input></td>";
                                var dataAppend = "<tr>"+ markup1 + markup3 +
                                "<td> <button type='button' tabindex='3' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
                                "<td> <span class='icon-trash-2' tabindex='' id='delete_row'></span></td> </tr>";
                                $('#moduleTable').find('tbody').append(dataAppend);
                            }
                              // $('#delete_row:last').filter(':last').attr('id', '');
                        }
                      });
    }
    
});


function wstatus() {
            
    $('.wstatus').change(function() { 

            var wstatus=$(this).val();
            if(wstatus == 'statisfied'){
                    $(this).parent().next().children().css("background-color", "green");
                }else if(wstatus == 'not_done'){
                    $(this).parent().next().children().css("background-color", "red");
                }else if(wstatus == 'carry_forward'){
                    $(this).parent().next().children().css("background-color", "blue");
                }else{}
                 
    }); 
}
$('.wstatus').change(function() { 

    var wstatus=$(this).val();
    if(wstatus == 'statisfied'){
            $(this).parent().next().children().css("background-color", "green");
        }else if(wstatus == 'not_done'){
            $(this).parent().next().children().css("background-color", "red");
        }else if(wstatus == 'carry_forward'){
            $(this).parent().next().children().css("background-color", "blue");
        }else{
            
                
    }
       
}); 
$('#company').change(function() { 

    var comid=$(this).val();
    $.ajax({
        url: 'get_perform_detail.php',
        data: {'comid': comid },
        cache: false,
        type:'post',
        dataType: 'json',
        success: function(data){
            console.log("data.departments",data.departments);
            $('#department_id').text('');
            $('#department_id').val('');
            var option = $('<option></option>').val('').text('Select Department');
            $('#department_id').append(option);
            for(var a=0; a<=data.departments.length-1; a++){
                // var selected = '';
                // if(year_idup == data[a]['department_id']){
                //     selected = 'selected';
                // }'+selected+' 
                var option = $('<option ></option>').val(data.departments[a]['department_id']).text(data.departments[a]['department_name']);
                $('#department_id').append(option);
            }

            $('#designation_id').text('');
            $('#designation_id').val('');
            var option = $('<option></option>').val('').text('Select Role');
            $('#designation_id').append(option);
            for(var a=0; a<=data.designations.length-1; a++){
                // var selected = '';
                // if(year_idup == data[a]['department_id']){
                //     selected = 'selected';
                // }'+selected+' 
                var option = $('<option ></option>').val(data.designations[a]['designation_id']).text(data.designations[a]['designation_name']);
                $('#designation_id').append(option);
            }
        }
      });
         
}); 
$('#designation_id').change(function() { 
    var company_id=$('#company').val();
    var department_id=$('#department_id').val();
    var designation_id=$(this).val();
    $.ajax({
        url: 'get_emp_detail.php',
        data: {'company_id': company_id,
               'department_id':department_id,
               'designation_id':designation_id
              },
        cache: false,
        type:'post',
        dataType: 'json',
        success: function(data){
       console.log("data",data);
            $('#staff_id').text('');
            $('#staff_id').val('');
            var option = $('<option></option>').val('').text('Select Employee');
            $('#staff_id').append(option);
            for(var a=0; a<=data.length-1; a++){
                // var selected = '';
                // if(year_idup == data[a]['department_id']){
                //     selected = 'selected';
                // }'+selected+' 
                var option = $('<option ></option>').val(data[a]['staff_id']).text(data[a]['staff_name']);
                   $('#staff_id').append(option);
            }

         }
      });
});
$('#execute').click(function() { 
    var company_id=$('#company').val();
    var department_id=$('#department_id').val();
    var designation_id=$('#designation_id').val();
    var emp_id = $('#staff_id').val();
    var wdays = $('#tday').val();
    // console.log('company_id',company_id);
    // console.log('department_id',department_id);
    // console.log('designation_id',designation_id);
    // console.log('emp_id',emp_id);
    $.ajax({
        url: 'get_all_detail.php',
        data: {'company_id': company_id,
               'department_id':department_id,
               'designation_id':designation_id,
               'emp_id':emp_id,
               'wdays':wdays
              },
        cache: false,
        type:'post',
        dataType: 'json',
        success: function(data){
       console.log("data",data);
            // $('#staff_id').text('');
            // $('#staff_id').val('');
            // var option = $('<option></option>').val('').text('Select Employee');
            // $('#staff_id').append(option);
            // for(var a=0; a<=data.length-1; a++){
            //     // var selected = '';
            //     // if(year_idup == data[a]['department_id']){
            //     //     selected = 'selected';
            //     // }'+selected+' 
            //     var option = $('<option ></option>').val(data[a]['staff_id']).text(data[a]['staff_name']);
            //        $('#staff_id').append(option);
            // }

         }
      });
});
