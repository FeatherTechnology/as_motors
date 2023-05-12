// Document is ready
$(document).ready(function () {
    // remove delete option for last child
    $('#delete_row:last').filter(':last').attr('id', '');

    // disable dropdown in case of update
    // if($('#audit_area_id').val() > 0){
    //     $('#date_of_audit').attr("disabled", true);
    // }

    $("#checklist").change( function(){

        var checklist = $("#checklist").val();
        $.ajax({
            url: 'auditFile/ajaxGetAuditFollowup.php',
            data: {"checklist": checklist},
            cache: false,
            type: "post",
            dataType: "json",
            success: function (data) {

                $("#dept").val(data['dept']);
                $("#dept_id").val(data['dept_id']);
                $("#role1").val(data['role1']);
                $("#role1_id").val(data['role1_id']);
                $("#role2").val(data['role2']);
                $("#role2_id").val(data['role2_id']);
                
            }
        });
    });

    // Previous checklist dropdown open
    $('#checklist').change(function() {
        if ($(this).is(':checked')) {
            $('#prev').show();
            insertData($('#prev'.val()));
        } else {
            $('#prev').hide();
            removeData();
        }
    });

    // // Add new row
    // $(document).on('click','#add_row',(function(){
    //     var appendTxt = "<tr><td> <input tabindex='4' type='text' class='form-control' id='major' name='major[]' placeholder='Enter Area'></td>" +
    //     "<td> <input tabindex='5' type='text' class='form-control' id='assertion' name='assertion[]'placeholder='Enter Assertion'></td>" +
    //    "<td> <select type='text' tabindex='6' name='prevstatus[]'  id='prevstatus' class='form-control prevstatus'><option value=''>Select Status</option><option value='1'>Yes</option><option value='0'>No</option></select></td>"+
    //    "<td><textarea id='aremarks'  class='form-control' rows='1' name='aremarks[]'  cols='35' placeholder='Enter Audit Remarks'></textarea></td>"+
    //    "<td><input tabindex='7' type='text' class='form-control' id='rcmd' name='rcmd[]' placeholder='Enter Recommendation' ></td>"+
    //    "<td><input type='file' style='padding: 3px;' tabindex='8' class='form-control' id='att_file' name='file[]'></td>"+
    //    "<td> <button type='button' tabindex='9' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
    //    "<td> <span class='icon-trash-2' tabindex='10' id='delete_row'></span></td></tr>";
    //     $('#moduleTable').find('tbody').append(appendTxt);
    //     sts();
    // }));
     // Add new row
     $(document).on('click','#tab_show',(function(){
        $('#moduleTable').removeClass('hidden');
    }));
    
//  <input tabindex='7' type='text' class='form-control' id='Astatus' name='Astatus[]'>
    // Delete unwanted Rows
    $(document).on("click", '#delete_row', function () {
        $(this).parent().parent().remove();
    });

    // previous checklist append
    $('#prev').change(function() {
        var prev_checklist = $('#prev').val();
        var markup1, markup3 ='';
        if(prev_checklist=="0"){
          removeData();
        }else{
            insertData(prev_checklist);
        }
      });

    // resetting modult table
    function removeData(){
        $('#moduleTable').find('tbody').empty();
        var removeData = "<tr><td> <input tabindex='4' type='text' class='form-control' id='major' name='major[]' placeholder='Enter Area'></input></td>" +
        // "<td> <input tabindex='3' type='text' class='form-control' id='sub' name='sub[]'></input></td>" +
        "<td> <input tabindex='5' type='text' class='form-control' id='assertion' placeholder='Enter Assertion' name='assertion[]'></input></td>" +
        "<td> <select type='text' tabindex='6' name='prevstatus[]'  id='prevstatus' class='form-control prevstatus'><option value=''>Select Status</option><option value='1'>Yes</option><option value='0'>No</option></select></td>"+
        "<td><textarea  id='aremarks'  class='form-control' rows='1' name='aremarks[]'  cols='35' placeholder='Enter Audit Remarks'></textarea></td>"+
        "<td><input tabindex='7' type='text' class='form-control' id='rcmd' placeholder='Enter Recommendation' name='rcmd[]' ></td>"+
        "<td><input type='file' style='padding: 3px;' tabindex='8' class='form-control' id='att_file' name='file[]'></td>"+
        // "<td> <input tabindex='3' type='text' class='form-control' id='weightage' name='weightage[]'></input></td>" +
        "<td> <button type='button' tabindex='9' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
        "<td> <span class='icon-trash-2' tabindex='10' id='delete_row'></span></td> </tr>";
        $('#moduleTable').find('tbody').html(removeData);
        sts();
    }

    // insert Data into Module Table
    function insertData(date_of_audit){
        $('#moduleTable').find('tbody').empty();
        var date = $('#date_of_audit').val();
        console.log("date",date);
                    $.ajax({
                        url: 'getauditfollowup.php',
                        data: {'prev_checklist': date_of_audit ,'date':date},
                        cache: false,
                        type:'post',
                        dataType: 'json',
                        success: function(data){
                        //   $('#moduleTable').find('tbody').empty();
                            for(var a=0; a<=data.length-1; a++){
                                markup1 = "<td><input type='text' tabindex='4' class='form-control' value="+ data[a]['major_area'] + " id='major' name='major[]' placeholder='Enter Area'></input></td>";
                                // markup2= "<td><input type='text' tabindex='3' class='form-control'  value="+ data[a]['sub_area'] + " id='sub' name='sub[]'></input></td>";
                                markup3 = "<td><input type='text' tabindex='5' class='form-control'  value="+ data[a]['assertion'] + " id='assertion' name='assertion[]' placeholder='Enter Assertion'></input></td>";
                                // markup4 = "<td><input type='text' tabindex='3' class='form-control'  value="+ data[a]['weightage'] + " id='weightage' name='weightage[]'></input></td>";
                                var dataAppend = "<tr>"+ markup1 + markup3 +
                                "<td> <select type='text' tabindex='6' name='prevstatus[]'  id='prevstatus' class='form-control prevstatus'><option value=''>Select Status</option><option value='1'>Yes</option><option value='0'>No</option></select></td>"+
                                "<td><textarea  id='aremarks'  class='form-control' rows='1' name='aremarks[]'  cols='35' placeholder='Enter Audit Remarks'></textarea></td>"+
                                "<td><input tabindex='7' type='text' class='form-control' id='rcmd' name='rcmd[]' placeholder='Enter Recommendation' ></td>"+
                                "<td><input type='file' style='padding: 3px;' tabindex='8' class='form-control' id='att_file' name='file[]'></td>"+
                                "<td> <button type='button' tabindex='9' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
                                "<td> <span class='icon-trash-2' tabindex='10' id='delete_row'></span></td> </tr>";
                                $('#moduleTable').find('tbody').append(dataAppend);
                                sts();
                            }
                              // $('#delete_row:last').filter(':last').attr('id', '');
                        }
                      });
    }
    // SELECT aai.audit_assign_id,aai.assertion,aai.audit_remarks,aai.recommendation,aai.attachment,aai.auditee_response,aai.action_plan,aai.target_date,aai.audit_status FROM audit_assign_ref aai LEFT JOIN audit_assign aa ON aa.audit_assign_id = aai.audit_assign_id WHERE  aai.auditee_response_status='1' AND aai.target_date NOT IN ('NULL');
    // "<td> <input tabindex='7' type='text' class='form-control' id='Astatus' name='Astatus[]'></td>"+"<td><input tabindex='9' type='text' class='form-control' id='rcmd' name='rcmd[]' ></td>"+"<td><input tabindex='10' type='text' class='form-control' id='assertion' name='assertion[]' ></td>"+"<td><input tabindex='11' type='text' class='form-control' id='aremarks' name='aremarks[]' ></td>"+"<td> <button type='button' tabindex='3' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" + "<td> <span class='icon-trash-2' tabindex='' id='delete_row'></span></td></tr>"
    // //Validations
    // function validateArea(){
    //     var area= $('#date_of_audit').val();
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
    // $(document).on("click", '#prevstatus', function () {
     
       
//    $('.prevstatus').change(function() { 

//         var ans=$(this).val();
//         if(ans=='1'){
//         $(this).parent().next().children().prop('disabled', true);
//         $(this).parent().next().next().children().prop('disabled', true); 
//         }else{
//             $(this).parent().next().children().prop('disabled', false);
//             $(this).parent().next().next().children().prop('disabled', false);
//         }
//           }); 
      

        
    });
    function sts() {
            
        $('.prevstatus').change(function() { 

                var ans=$(this).val();
                if(ans=='1'){
                $(this).parent().next().next().children().prop('readonly', true);
                $(this).parent().next().next().next().children().prop('readonly', true); 
                }else{
                    $(this).parent().next().next().children().prop('readonly', false);
                    $(this).parent().next().next().next().children().prop('readonly', false);
                }


         
        }); 
    }
 sts();

 