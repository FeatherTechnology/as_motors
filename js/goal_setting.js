// Document is ready
$(function(){
    var idupd = $('#id').val();
    // console.log("idupd",idupd);
    if(parseInt(idupd) > 0){
        var company_id_upd = $('#company_id_upd').val();
        insertData(company_id_upd);
        
    }
   
})

$(document).ready(function () {
   
     $('#delete_row:last').filter(':last').attr('id', '');
     $(document).on("click", '#execute', function () {

        $('#tables').removeClass('hidden');
     });


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
                success: function(data){
                    // console.log("data",data);
                    if(data['year_id'] == ''){
                        alert('Year Does Not Exist!');
                        $('#yes').prop('checked', false);
                    }else{
                        if(prevyear == data['pyear']){
                            selected = 'selected';
                        }
                        
                        var option = $('<option '+selected+' ></option>').val(data['year_id']).text(data['pyear']);
                        // console.log("option",option);
                         
                        $('#syear').append(option);
                        $('#moduleTable').find('tbody').empty();
                        // $('#moduleTable').find('tbody').remove();
                        var yid = data['year_id']; 
                        console.log("yid",yid);
                        $.ajax({
                            url: 'ajaxGetrowdetailes.php',
                            data: {"yid": yid},
                            cache: false,
                            type: "post",
                            dataType: "json",
                            success: function(data){
                        // console.log("data",data);
                        $('#tables').removeClass('hidden');
                        
                                for(var a=0; a<=data.length-1; a++){
                                    var appendTxt = "<tr><td><input tabindex='4' type='text' class='form-control' id='assertion' value="+ data[a]['assertion'] + " name='assertion[]'></td>"+
                                    "<td><input tabindex='6' type='text' class='form-control' id='target' name='target[]' value="+ data[a]['target'] + " ></td>"+
                                    "<td> <button type='button' tabindex='9' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
                                    "<td> <span class='icon-trash-2' tabindex='10' id='delete_row'></span></td></tr>";
                                    $('#moduleTable').find('tbody').append(appendTxt);
                                }
                             }
                        });

                    }
                    
                    
                }
            });
                    
        }else{ $('#moduleTable').find('tbody').empty(); }
        

        
    
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
$('#dept').change(function() { 
    var company_id=$('#prev').val();
    var department_id =$(this).val();
    var role_id_up = $('#role_id_up').val();
   
    $.ajax({
        url: 'KRA&KPIFile/ajaxKra&KpiFetchDesignationDetails.php',
        type: 'post',
        data: { "company_id":company_id, "department_id":department_id },
        dataType: 'json',
        success:function(response){
          
            $('#designation').text('');
            $('#designation').val('');
            var option = $('<option></option>').val('').text('Select Designation');
            $('#designation').append(option);
          var i = 0;
          for (i = 0; i <= response.designation_id.length - 1; i++) { 
            var selected = "";
            if(role_id_up == response['designation_id'][i]){
              selected = "selected";
          }
            $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+" >" + response['designation_name'][i] + "</option>");
          }
        }
      });
         
});
// insert Data into Module Table
function insertData(prev_company){
  
    var dept_id_upd = $('#dept_id_upd').val();
    $.ajax({
        url: 'getgoalsettings.php',
        data: {'prev_company': prev_company },
        cache: false,
        type:'post',
        dataType: 'json',
        success: function(data){
            $('#dept').text('');
            
            $('#dept').val('');
            
            var option4 = $('<option></option>').val('').text('Select Department');
            $('#dept').append(option4);
            var option5 = $('<option></option>').val('').text('Select Designation');
            $('#designation').append(option5);
        
            for(var a=0; a<=data.length-1; a++){
                
                var selected = '';
                if(dept_id_upd == data[a]['department_id']){
                    selected = 'selected';
                }
               
                var option1 = $('<option '+selected+'></option>').val(data[a]['department_id']).text(data[a]['department_name']);
                $('#dept').append(option1);

               var dept = data[a]['department_id']
            }
           
            var company_id=$('#prev').val();
            var department_id=$('#dept').val();
            var role_id_up = $('#role_id_up').val();
            $.ajax({
                url: 'KRA&KPIFile/ajaxKra&KpiFetchDesignationDetails.php',
                data: {'company_id': company_id,
                        'department_id':department_id
                                      },
                cache: false,
                type:'post',
                dataType: 'json',
                success: function(data){
                  
                    $('#designation').text('');
                    $('#designation').val('');
                    var option = $('<option></option>').val('').text('Select Designation');
                    $('#designation').append(option);
                    var i = 0;
                        for (i = 0; i <= data.designation_id.length - 1; i++) { 
                            var selected = "";
                            if(role_id_up == data['designation_id'][i]){
                            selected = "selected";
                        }
                        $('#designation').append("<option value='" + data['designation_id'][i] + "' "+selected+" >" + data['designation_name'][i] + "</option>");
                    }
            
                
                }
              
                });        
        }
        });
        getyear();
}
$(document).ready(function () {
    var logrole = $('#logrole').val();
    var logtitle= $('#logtitle').val();
    if(logtitle == 'Super Admin'){

    }else{
    $('.backb').css('display', 'none');
    if(logrole == '4'){
       
        var idupd = $('#id').val();
    
        if(idupd == '0'){ 
           
            $('#prev').prop('disabled', true);
            var prev_company = $('#prev').val();
            insertData(prev_company);
        
        }else{
           
            $('.form-control').prop('disabled', true);
            $('#execute').css('display', 'none');
            $('#submit_audit_checklist').css('display', 'none');
            $('#add_row_0').css('display', 'none');
            $('.yes').css('display', 'none');
            $('th:nth-child(3)').remove();
            $('tbody tr td:nth-child(3)').remove();
            $('tbody tr td:nth-child(3)').remove();
        }
    }else{
        
     }
    }       
    
});