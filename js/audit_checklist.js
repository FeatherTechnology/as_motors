// Document is ready
$(document).ready(function () {
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
    //Add new row
    $(document).on('click','#add_row',(function(){
        var appendTxt = "<tr><td> <input tabindex='3' type='text' class='form-control' id='major' name='major[]'></input></td>" +
                // "<td> <input tabindex='3' type='text' class='form-control' id='sub' name='sub[]'></input></td>" +
                "<td> <input tabindex='3' type='text' class='form-control' id='assertion' name='assertion[]'></input></td>" +
                // "<td> <input tabindex='3' type='text' class='form-control' id='weightage' name='weightage[]'></input></td>" +
                "<td> <button type='button' tabindex='3' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
                "<td> <span class='icon-trash-2' tabindex='' id='delete_row'></span></td> </tr>";
                $('#moduleTable').find('tbody').append(appendTxt);
    }));
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
    // //Validations
    // function validateArea(){
    //     var area= $('#audit').val();
    //     if(area == '0'){
    //         areaError = false;
    //         //$('#audit_err').val('required');
    //         $('#audit_err').css('color','red');
    //     }else{
    //         areaError = true;
    //     }
    // }
    // function validateTable(){
    //     var major = $('#major').val();
    //     var sub = $('#sub').val();
    //     var assertion = $('#assertion').val();
    //     var weightage = $('#weightage').val();
    //     if(major=='' || sub=='' || assertion=='' || weightage==''){
    //         $('#major').attr('placeholder','Enter Major Area');
    //         $('#sub').attr('placeholder','Enter Sub Area');
    //         $('#assertion').attr('placeholder','Enter Assertion');
    //         $('#weightage').attr('placeholder','Enter Weightage');
    //         tableError = false;
    //         return false;
    //     }else{
    //         tableError = true;
    //         return true;
    //     }
    // }
    // $('#submit_audit_checklist').click(function(){
    //     validateTable();
    //     validateArea();
    //     if(tableError== true && areaError == true){
    //         return true;
    //     }
    //     else{ return false;}
    // });
});