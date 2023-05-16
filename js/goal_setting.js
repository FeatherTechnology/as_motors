// Document is ready
$(function(){
    var idupd = $('#id').val();
    if(parseInt(idupd) > 0){
        var company_id_upd = $('#company_id_upd').val();
        insertData(company_id_upd);
        
    }
})

$(document).ready(function () {
//    $('#syear').picker();
    // remove delete option for last child
    $('#delete_row:last').filter(':last').attr('id', '');

    // disable dropdown in case of update
    // if($('#audit_area_id').val() > 0){
    //     $('#date_of_audit').attr("disabled", true);
    // }



    $(document).on("click", '#yes', function () {
        var opt =$('input:visible:checked').val();
        if(opt == 'Yes'){
            var year = new Date().getFullYear();
           var prevyear = parseInt(year) - parseInt(1);

            // console.log('year',year);
            // console.log('prevyear',prevyear);
            $.ajax({
                url: 'ajaxGetyeardetailes.php',
                data: {"prevyear": prevyear},
                cache: false,
                type: "post",
                dataType: "json",
                success: function (data) {
    
                    
                }
            });
        }else{ console.log('clicked'); }
        

        
    
    });
    



    $("#date_of_audit").change( function(){

        var date_of_audit = $("#date_of_audit").val();
        $.ajax({
            url: 'auditFile/ajaxGetAuditDetails.php',
            data: {"date_of_audit": date_of_audit},
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

    // Add new row
    $(document).on('click','#add_row',(function(){
        var appendTxt = "<tr><td><input tabindex='4' type='text' class='form-control' id='assertion' placeholder='Enter Assertion' name='assertion[]'></td>"+
         "<td><input tabindex='6' type='text' class='form-control' id='target' name='target[]' placeholder='Enter Target'></td>"+
         "<td> <button type='button' tabindex='9' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
         "<td> <span class='icon-trash-2' tabindex='10' id='delete_row'></span></td></tr>";
        $('#moduleTable').find('tbody').append(appendTxt);
        // sts();
    }));
//  <input tabindex='7' type='text' class='form-control' id='Astatus' name='Astatus[]'>
    // Delete unwanted Rows
    $(document).on("click", '#delete_row', function () {
        $(this).parent().parent().remove();
    });
    
    // previous checklist append
    $('#prev').change(function() {
        var prev_company = $('#prev').val();
        insertData(prev_company);
       
        
      });

    // resetting modult table
    function removeData(){
        $('#dept').val('');
        $('#designation').val('');

    }

    // insert year <a href="admin.php?function=myFunction">Click here to call myFunction</a>
    $(document).on("click", '#insert', function () {
        var insertedyear = $('#iyear').val();
        var insertedcompany = $('#prev').val();
        // console.log(insertedyear);
        // console.log(insertedcompany);
        $.ajax({
            url: 'add_year.php',
            data: {'insertedyear': insertedyear,
                   'insertedcompany':insertedcompany 
                   },
            cache: false,
            type:'post',
            dataType: 'json',
            success: function(data){
               
            }
          });
          $('.close').trigger('click');
          getyear();
    });
    // $(document).on("click", '#syear', function () {
    // // $("#syear").change( function(){
    //     var insertedcompany = $('#prev').val();
    //     $.ajax({
    //         url: 'fetchyear.php',
    //         data: {'insertedcompany':insertedcompany },
    //         type: "post",
    //         dataType: "json",
    //         success: function (data) {
    //             var option = $('<option></option>').val(data[a]['year_id']).text(data[a]['year']);
    //             $('#syear').append(option);

               
    //         }
    //     });
    // });


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
      
getyear();
        
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

 function getyear(){
    var insertedcompany = $('#prev').val();
    var year_idup =$('#year_idup').val();
    $.ajax({
        url: 'fetchyear.php',
        data: {'insertedcompany': insertedcompany},
        type: "post",
        dataType: "json",
        success: function (data) {
            
           
          
              $('#syear').text('');
            $('#syear').val('');
            var option = $('<option></option>').val('').text('Select Year');
            $('#syear').append(option);


            for(var a=0; a<=data.length-1; a++){
                var selected = '';
                if(year_idup == data[a]['year_id']){
                    selected = 'selected';
                }

            var option = $('<option '+selected+' ></option>').val(data[a]['year_id']).text(data[a]['year']);
            $('#syear').append(option);
            }
       
        }
    });

}

// insert Data into Module Table
function insertData(prev_company){
    // $('#moduleTable').find('tbody').empty();
    var dept_id_upd = $('#dept_id_upd').val();
    var role_id_up = $('#role_id_up').val();
    $.ajax({
        url: 'getgoalsettings.php',
        data: {'prev_company': prev_company },
        cache: false,
        type:'post',
        dataType: 'json',
        success: function(data){
            $('#dept').text('');
            $('#designation').text('');
            $('#dept').val('');
            $('#designation').val('');
            var option4 = $('<option></option>').val('').text('Select Department');
            $('#dept').append(option4);
            var option5 = $('<option></option>').val('').text('Select Role');
            $('#designation').append(option5);
        
            for(var a=0; a<=data.length-1; a++){
                
                var selected = '';
                if(dept_id_upd == data[a]['department_id']){
                    selected = 'selected';
                }
                if(role_id_up == data[a]['designation_id']){
                    selected = 'selected';
                }
                var option1 = $('<option '+selected+'></option>').val(data[a]['department_id']).text(data[a]['department_name']);
                $('#dept').append(option1);

                var option2 = $('<option '+selected+' ></option>').val(data[a]['designation_id']).text(data[a]['designation_name']);
                $('#designation').append(option2);
            }
            // var appendTxt = "<tr><td><input tabindex='4' type='text' class='form-control' id='assertion' placeholder='Enter Assertion' name='assertion[]'></td>"+
            // "<td><input tabindex='6' type='text' class='form-control' id='target' name='target[]' placeholder='Enter Target'></td>"+
            // "<td> <button type='button' tabindex='9' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
            // "<td> <span class='icon-trash-2' tabindex='10' id='delete_row'></span></td></tr>";
            // $('#moduleTable').find('tbody').append(appendTxt);
        }
        });
        getyear();
}

