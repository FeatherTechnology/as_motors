// Document is ready
$(document).ready(function () { 
    
    // Get read only text box
    $("#company_status").change(function(){ 
        var company_status = $("#company_status").val(); 
    
        if(company_status == 'Partnership' || company_status == 'HUF' || company_status == 'Individual'){ 
            $('#cin').prop('readonly',true);
        }else if(company_status == 'Public Limited' || company_status == 'Private Limited'){
            $('#cin').prop('readonly',false);
        }
    });
    
    $('#city').change(function() {
        $('#state').val($('#city option:selected').data('id'));
        console.log($('#city option:selected').data('id'));
    })

});

    