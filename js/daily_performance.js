// Document is ready
$(document).ready(function () {

    $('#company_name').change(function(){ // To Get Branch Name based on company//
        var company_id = $('#company_name').val(); 
        var userbranch = '';
        getBranchList(company_id, userbranch);
    });
    
    $('#branch_name').change(function(){ // To get Department Name.
        var branchid = $('#branch_name').val();
        var dept_id = '';
        getDepartmentList(branchid, dept_id);
    })
    
    $('#dept').change(function() { 
        var department_id =$('#dept').val();
        var designation_id ='';
        getDesignationList(department_id,designation_id);
    });

    $('#designation').change(function() { 
        var designation_id=$('#designation').val();
        var user_staff_id='';
        getEmpList(designation_id, user_staff_id);
    });

    $('#execute').click(function() { 
        var designation_id = $('#designation').val();

        $.ajax({
            url: 'get_all_detail.php',
            data: { 'designation_id': designation_id },
            cache: false,
            type:'post',
            dataType: 'json',
            success: function(response){
                $('#moduleTable').find('tbody').empty();
                for(var a=0; a < response.length; a++){
                
                var appendTxt = "<tr><td><textarea tabindex='6' type='text' class='form-control' id='assertion' name='assertion[]' readonly>"+ response[a]['assertion'] +" </textarea><input type='hidden' class='form-control' id='goal_setting_id' name='goal_setting_id[]' value="+ response[a]['goal_setting_id'] +"><input type='hidden' class='form-control' id='goal_setting_ref_id' name='goal_setting_ref_id[]' value="+ response[a]['goal_setting_ref_id'] +"><input type='hidden' class='form-control' id='assertion_table_sno' name='assertion_table_sno[]' value="+ response[a]['assertion_table_sno'] +"></td>" +
                "<td><input tabindex='7' type='text' class='form-control target' id='target' name='target[]' value="+ response[a]['target'] +" readonly></input></td><td><input tabindex='7' type='number' class='form-control actual_achieve' id='actual_achieve' name='actual_achieve[]' ></td>" + "<td><input tabindex='8' type='date' class='form-control sdate' id='sdate' name='sdate[]' value="+ response[a]['cdate'] +" readonly></input></td>" + "<td><select class='form-control wstatus' id='wstatus' name='wstatus[]'><option value=''>Select Work Status</option><option value='1'>Statisfied</option><option value='2'>Not Done</option><option value='3'>Carry Forward</option></select></td>" + "<td><input tabindex='10' type='text' class='form-control status' id='status' name='status[]'></input></td></tr>";
                $('#moduleTable').find('tbody').append(appendTxt);
                
                }

                callFunctionAfterSuccess(); //After data append the function will call to work
                } //Scuccess END.
            });
            
    });

    // $('#page_print').click(function (e){
    //     e.preventDefault();
    //     // $('#moduleTable').print();
        


    //     const table = document.getElementById('moduleTable');

    //     if (table) {
    //         // Clone the table to avoid modifying the original table
    //         const tableClone = table.cloneNode(true);
        
    //         // Remove the last cell of each row
    //         const rows = tableClone.querySelectorAll('tr');
    //         rows.forEach(row => {
    //         const lastCell = row.lastElementChild;
    //         if (lastCell) {
    //             row.removeChild(lastCell);
    //         }
    //         });
        
    //         // Create a new window to print the modified table
    //         const newWindow = window.open('', '_blank');
    //         newWindow.document.write('<html><head><title>Print Table</title></head><body>');
    //         newWindow.document.write('<style>table { border-collapse: collapse; } td, th { border: 1px solid black; padding: 8px; }</style>');
    //         newWindow.document.write(tableClone.outerHTML);
    //         newWindow.document.write('</body></html>');
    //         newWindow.document.close();
        
    //         // Wait for a small delay to allow the table to be rendered in the new window
    //         setTimeout(function() {
    //         newWindow.print();
    //         newWindow.close();
    //         }, 1000); // Adjust the delay time as needed
    //     } else {
    //         console.error('Table not found.');
    //     }


    // }); //Print END///

});  // Document END///

$(function(){

    var idupd = $('#idupd').val();
    if(parseInt(idupd) > 0){ // Edit page value getting.
        var com_id_upd = $('#company_id_upd').val();
        getCompanyNameList(com_id_upd); //Company List.

        var userbranch = $('#branch_id_upd').val();
        getBranchList(com_id_upd, userbranch); //Branch name.

        var branch_id_upd = $('#branch_id_upd').val();
        var dept_id_upd = $('#dept_id_upd').val();
        getDepartmentList(branch_id_upd, dept_id_upd);

        var role_id_up = $('#role_id_up').val();
        getDesignationList(dept_id_upd, role_id_up);

        var emp_idup=$('#emp_idup').val();
        getEmpList(role_id_up, emp_idup);//Emp List.

        // getgoalsettingsdetails(idupd); //if edit page means the details will be show in table.
        
        $('#execute').hide();
        $('select').attr('disabled',true);

        var userRole = $('#user_role').val();
        if(userRole == '1'){
            $('.actual_achieve').removeAttr('readonly');
            $('.wstatus').attr('disabled',false);

        }else{
            $('#submit_daily_performance').hide();
        }

    }else{
        $('#page_print').hide(); //hide print btn when add daily performance.

        var role = $('#user_role').val();
        if(role != '1'){ //if staff or manager login then the details will come automatically.
            var company_id = $('#user_company').val(); 
            var userbranch = $('#user_branch').val();
            getBranchList(company_id, userbranch); //Branch name append auto except for super admin.
    
            var branchid = $('#user_branch').val();
            var dept_id = $('#user_department').val();
            getDepartmentList(branchid, dept_id);
            
            var user_designation = $('#user_designation').val();
            getDesignationList(dept_id, user_designation);

            var userComid = $('#user_company').val();
            getCompanyNameList(userComid); //Company List.

            var user_staff_id=$('#user_staff_id').val();
            getEmpList(user_designation, user_staff_id);//Emp List.
        }else{
            var com = '';
            getCompanyNameList(com); //Company List.
        }
    }

    callFunctionAfterSuccess()//status change, actual input checking.

}); //Function OnLoad END///


function getCompanyNameList(comid){

    $.ajax({
        type: 'POST',
        data:{},
        url: 'ajaxFetch/ajaxgetcompanyList.php',
        dataType: 'json',
        cache: false,
        success: function(response){
    
            $('#company_name').empty();
            $("#company_name").append("<option value=''> Select Company Name </option>");
            for(var i=0; i < response.length; i++){
                
                var companyid = response[i]['companyId'];
                var companyname = response[i]['companyName'];
                var selected ='';
                if(comid == companyid){
                    selected = 'selected';
                }
    
                $('#company_name').append("<option value='"+companyid+"'"+selected+">"+companyname+"</option>");
            }
            {//To Order staffName Alphabetically
                var firstOption = $("#company_name option:first-child");
                $("#company_name").html($("#company_name option:not(:first-child)").sort(function (a, b) {
                    return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                }));
                $("#company_name").prepend(firstOption);
            }
        }
    })
    }
    
function getBranchList(company_id, userbranch){

    $.ajax({
        type: 'POST',
        data:{"company_id": company_id},
        url: 'RGP_ajax/ajaxgetBranchName.php',
        dataType: 'json',
        cache: false,
        success: function(response){
    
            $('#branch_name').empty();
            $("#branch_name").append("<option value=''> Select Branch Name </option>");
            for(var i=0; i < response.length; i++){
                var branchid = response[i]['branch_id'];
                var branchname = response[i]['branch_name'];
                var selected = '';
                if(userbranch == branchid){
                    selected ='selected' ;
                }
                $('#branch_name').append("<option value='"+branchid+"'"+selected+">"+branchname+"</option>");
            }
            {//To Order staffName Alphabetically
                var firstOption = $("#branch_name option:first-child");
                $("#branch_name").html($("#branch_name option:not(:first-child)").sort(function (a, b) {
                    return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                }));
                $("#branch_name").prepend(firstOption);
            }
        }
    })
}

function getDepartmentList(branchid, dept_id){
    $.ajax({
        url: 'getgoalsettings.php',
        data: {'branchid': branchid },
        cache: false,
        type:'post',
        dataType: 'json',
        success: function(data){
            $('#dept').empty();            
            $('#dept').append("<option value=''>Select Department Name</option>");
            for(var a = 0; a < data.length; a++){
                var selected = '';
                if(dept_id == data[a]['department_id']){
                    selected = 'selected';
                }
                $('#dept').append("<option value='"+data[a]['department_id']+"'"+selected+">"+data[a]['department_name']+"</option>");
            }
        }
    });
}

function getDesignationList(department_id, role_id_up){

    $.ajax({
        url: 'R&RFile/ajaxR&RDesignationDetails.php',
        type: 'post',
        data: { "department_id":department_id },
        dataType: 'json',
        success:function(response){
            
            $('#designation').text('');
            $('#designation').val('');
            var option = $('<option></option>').val('').text('Select Designation Name');
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
}

function getEmpList(designation_id, staff_id){

    $.ajax({
        url: 'get_emp_detail.php',
        data: {'designation_id':designation_id },
        cache: false,
        type:'post',
        dataType: 'json',
        success: function(data){
            $('#staff_id').text('');
            $('#staff_id').val('');
            var option = $('<option></option>').val('').text('Select Employee');
            $('#staff_id').append(option);
            for(var a=0; a<=data.length-1; a++){
                var selected = '';
                if(staff_id == data[a]['staff_id']){
                    selected = 'selected';
                }
                $('#staff_id').append("<option value='"+data[a]['staff_id']+"'"+selected+">"+data[a]['staff_name']+"</option>");
            }
            
            }
        });
}

function callFunctionAfterSuccess(){

$('.actual_achieve').off('keyup')
$('.actual_achieve').keyup(function(){
    var target = parseInt($(this).parent().parent().find('.target').val());
    var actual = parseInt($(this).val());
    if(actual > target){
        alert('Actual Achievement cannot be greater than Target.');
        $(this).val('');
    }

    if(actual == target){
        $(this).parent().parent().find('.wstatus').val('1')
        $(this).parent().parent().find('.status').css("background-color", "green");
    }else{
        $(this).parent().parent().find('.wstatus').val('')
        $(this).parent().parent().find('.status').css("background-color", "transparent");
    }
});

$('.wstatus').off('change')
$('.wstatus').change(function() { 

    var wstatus=$(this).val();
    if(wstatus == '1'){
            $(this).parent().next().children().css("background-color", "green");
        }else if(wstatus == '2'){
            $(this).parent().next().children().css("background-color", "red");
        }else if(wstatus == '3'){
            $(this).parent().next().children().css("background-color", "blue");
        }else{
            $(this).parent().next().children().css("background-color", "transparent");
        }
}); 

}


 // Function to handle printing
function printContent() {
    var printWindow = window.open('', '_blank');
    var content = document.getElementById('daily_performace_form').innerHTML; // Replace 'main-container' with the ID of your main container div
    printWindow.document.write('<html><head><title>Daily Performance Print Page</title>');
    // Add inline CSS styles here for proper alignment during printing
    printWindow.document.write('<style>');
    printWindow.document.write(`
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        @media print{
            input[type="text"],
            input[type="number"],
            textarea,
            select {
                width: 100%;
                border: 1px solid #ccc;
                padding: 5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            .input-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr); /* Adjust the number of columns per row as needed */
                grid-gap: 10px; /* Add some spacing between input fields */
            }
            table th:last-child,
            table td:last-child {
                display: none;
            }
            .print-hide {
                display: none;
            }
        }
    `);
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body><h4> Daily Performance Report </h4>');
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}

function exportFormAndTable() {
    var formData = {
        CompanyName: $('#company_name :selected').text(),
        BranchName: $('#branch_name :selected').text(),
        DepartmentName: $('#dept :selected').text(),
        DesignationName: $('#designation :selected').text(),
        Staffname: $('#staff_id :selected').text(),
        Month: $('#month').val(),
        // Add more form fields as needed
    };

    var tableData = [];
    var $table = $('#moduleTable'); // Replace with your table ID using jQuery selector
    var $rows = $table.find('tr');
    $rows.each(function () {
        var $row = $(this);
        var rowData = [];
        var $cols = $row.find("td");
        $cols.each(function () {
            var $input = $(this).find("input");
            var $select = $(this).find("select");
            
            if ($input.length > 0) {
                rowData.push($input.val().trim());
            } else if ($select.length > 0) {
                var selectedOption = $select.find(':selected').text();
                rowData.push(selectedOption);
            } else {
                rowData.push($(this).text().trim());
            }
        });
        tableData.push(rowData.join(","));
    });

    var csvContent = "Daily Performance Report\n";
    // csvContent += "Form Data\n";
    $.each(formData, function (field, value) {
        csvContent += field + "," + value + "\n";
    });
    csvContent += "\nAssertion,Target,Actual Achieve,System Date,Work Status\n";
    csvContent += tableData.join("\n");

    var csvBlob = new Blob([csvContent], { type: "text/csv" });
    var csvUrl = URL.createObjectURL(csvBlob);

    var $downloadLink = $('<a>')
        .attr('href', csvUrl)
        .attr('download', 'form_and_table_data.csv')
        .css('display', 'none');
    
    $('body').append($downloadLink);
    $downloadLink[0].click();
    $downloadLink.remove();
}



// Attach click event to the print button
document.getElementById('page_print').addEventListener('click', function () {
    printContent();
});
// Attach click event to the print button
document.getElementById('page_excel').addEventListener('click', function () {
    exportFormAndTable();
});