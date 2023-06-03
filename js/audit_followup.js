// Document is ready
$(document).ready(function () {
    // remove delete option for last child
    $('#delete_row:last').filter(':last').attr('id', '');

    
    $("#prev").change( function(){

        var checklist = $("#prev").val();
         $.ajax({
            url: 'auditFile/ajaxGetAuditFollowup.php',
            data: {"checklist": checklist},
            cache: false,
            type: "post",
            dataType: "json",
            success: function (data) {

                $("#dept_id").val(data[0]['department_id']);
                $("#role1").val(data[0]['dcrole1']);
                $("#role1_id").val(data[0]['role1']);
                $("#role2").val(data[0]['dcrole2']);
                $("#role2_id").val(data[0]['role2']);
                $("#dept").val(data['department_name']);  
            }
        });
        getdeptname();
    });

    function getdeptname(){
        var dept_id = $("#dept_id").val();
    }

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
    $(document).on('click','#tab_show',(function(){
        $('#moduleTable').removeClass('hidden');
    }));
    
    // Delete unwanted Rows
    $(document).on("click", '#delete_row', function () {
        $(this).parent().parent().remove();
    });

    // previous checklist append
    $('#prev').change(function() {
        var prev_checklist = $('#prev').val();
        if(prev_checklist=="0"){
            removeData();
        }else{
            insertData(prev_checklist);
        }
    });


    // insert Data into Module Table
    function insertData(date_of_audit){
        $('#moduleTable').find('tbody').empty();
        var date = $('#date_of_audit').val();
        $.ajax({
            url: 'getauditfollowup.php',
            data: {'prev_checklist': date_of_audit ,'date':date},
            cache: false,
            type:'post',
            dataType: 'json',
            success: function(data){
                
                for(var a=0; a<=data.length-1; a++){ 
                    var dataAppend = "<tr id='row_"+a+"' class='row1'><td><input tabindex='4' type='text' class='form-control' id='assertion'  name='assertion[]' value="+ data[a]['assertion'] +" readonly><input  type='hidden' class='form-control' id='assignid_"+a+"'  name='assidnid[]' value="+ data[a]['audit_assign_id'] +" readonly><input  type='hidden' class='form-control assignrefid' id='assignrefid_"+a+"'  name='assidnrefid[]' value="+ data[a]['audit_assign_ref_id'] +" readonly></td>"+
                    "<td><input tabindex='7' type='text' class='form-control' id='audit_remarks' name='audit_remarks[]' value="+ data[a]['audit_remarks'] +" readonly></td>"+  
                    "<td><a href='./uploads/audit_assign/"+ data[a]['attachment'] +"' download='filetodownload' readonly>"+ data[a]['attachment'] +"</a></td>"+
                    "<td><input type='text' tabindex='7' class='form-control' id='auditee_response' name='auditee_response[]' value="+ data[a]['auditee_response'] + " readonly></td>"+
                    "<td><input type='text' tabindex='7' class='form-control' id='action_plan' name='action_plan[]' value="+ data[a]['action_plan'] +" readonly></td>"+
                    "<td><input type='text' tabindex='7' class='form-control' id='target_date' name='target_date[]' value="+ data[a]['target_date'] +" readonly></td>"+
                    "<td><button type='button' class='btn btn-info btn-lg add_row' id='add_row_"+a+"' data-toggle='modal' data-target='#myModal'>Edit</button></td>"+
                        "<td><span class='icon-trash-2' tabindex='10' id='delete_row'></span></td> </tr>";
                        $('#moduleTable').find('tbody').append(dataAppend);                           
                    
                }
            }
        });
    }

    $(document).on('click', '.add_row', function() {
        var str = $(this).attr('id');
        var ret = str.split("_");
        var str1 = ret[0];
        var str3 = ret[2];
        
        var assignid = $("#assignid_" + str3).val();
        var assignrefid = $("#assignrefid_" + str3).val();
     
        var cassignid = $("#assignidc").val(assignid);
        var cassignrefid = $("#assignrefidc").val(assignrefid);
     });
    
    $('#insert').on('click', function(){
        validate();
        
	});   
    
    function validate(){
        var userid = $("#userid").val();
        var assignid = $("#assignidc").val();
        var assignrefid = $("#assignrefidc").val();
        var remark = $("#remarks").val();
        var date =$("#date").val();
		var file = $('#file');
		var file_length = file[0].files.length;
		var file_data = file.prop('files')[0];
		
		var formData = new FormData();
		formData.append('file', file_data);
        formData.append('assignid', assignid);
        formData.append('assignrefid', assignrefid);
        formData.append('remark', remark);
        formData.append('date', date);
        formData.append('userid', userid);
		$.ajax({
			url: "auditFile/ajaxinsertAuditFollowup.php",
			type: "POST",
			data: formData,
			contentType:false,
			cache: false,
			processData: false,
			success: function(data){
                $('.modal-backdrop').remove();
                $('#myModal').removeClass('show');
				$('#prev').trigger('change',function(){})
			}
		});
        var date_of_audit = $('#prev').val();
        insertData(date_of_audit);
    }
    
   
});
    

 