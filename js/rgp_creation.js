$(document).ready(function(){

    $('#company_id').change(function(){
        var company_id = $(this).val();
        getBranchdropdown(company_id);
    });
    $('#company_to').change(function(){
        var company_id = $(this).val();
        getBranchdropdownForTo(company_id);
    });
    $('#branch_from').change(function(){
        var branch_id = $('#branch_from').val();
        $.ajax({
            url: 'RGP_ajax/ajaxgetBranchAddress.php',
            type: 'POST',
            data: {'branch_id':branch_id},
            dataType: 'json',
            success:function(response){
                $('#from_comm_line1').val(response['address1']);
                $('#from_comm_line2').val(response['address2']);
            }

        })
    });
    $('#branch_to').change(function(){
        var branch_id = $('#branch_to').val();
        var branch_id_from = $('#branch_from').val();
        if(branch_id_from == branch_id){
            alert('From and To Branch cannot be same!');
            $('#branch_to').val('');
            $('#to_comm_line1').val('');
            $('#to_comm_line2').val('');
        }else{
            $.ajax({
                url: 'RGP_ajax/ajaxgetBranchAddress.php',
                type: 'POST',
                data: {'branch_id':branch_id},
                dataType: 'json',
                success:function(response){
                    $('#to_comm_line1').val(response['address1']);
                    $('#to_comm_line2').val(response['address2']);
                }

            });
        }
    });

    $('#asset_class').change(function(){
        var asset_class = $('#asset_class :selected').val();
        getAssetdropdown(asset_class);
    });
   
    $('#asset_name').change(function(){
        var asset_id = $('#asset_name :selected').val();
        $.ajax({
            url: 'RGP_ajax/ajaxgetAssetValue.php',
            type: 'POST',
            data: {'asset_id':asset_id},
            dataType: 'json',
            success:function(response){
                var asset_value = response['asset_value'];
                $('#asset_value').val(asset_value);
            }

        })
    });
    
    
});//document ready end


// print functionality
function print_rgp(id){
    $.ajax({
        url: 'RGP_ajax/print_rgp.php',
        cache: false,
        type: 'POST',
        data: {'id':id},
        success: function(html){
            $("#printrgp").html(html);
        }
    });
}

//inward functionality
function inward(rgp_id,asset_id){
    var dlt = confirm("Are you sure to want to Inward this RGP?");
    if(dlt){
        $.ajax({
            url: 'RGP_ajax/inwarded.php',
            cache: false,
            type: 'POST',
            data: {'rgp_id':rgp_id,'asset_id':asset_id},
            success: function(response){
                location.href ='edit_rgp_creation&msc=4';
            }
        });
        }else{
            return false;
        }
}


$(function(){
    var idupd = $('#id').val();
    if(idupd > 0){
        var company_id_upd = $('#company_id_upd').val();
        var company_to_upd = $('#company_to_upd').val();
        var asset_class_upd = $('#asset_class_upd').val();
        // getBranchdropdown(company_id_upd);
        getAssetdropdown(asset_class_upd);
        getBranchNamewithCompany(company_id_upd);
        setalltoReadonly();

        getBranchdropdownForTo(company_to_upd);

    }

});

function getBranchNamewithCompany(company_id){
    var branch_from_upd = $('#branch_from_upd').val();
    $.ajax({
        url: 'RGP_ajax/ajaxgetBranchNamewithCompany.php',
        type: 'POST',
        data: {'company_id':company_id},
        dataType: 'json',
        success:function(response){
            var len = response.length;
            $('#branch_from').empty();
            $("#branch_from").prepend("<option value=''>Select Branch Name</option>");
            for(var i = 0; i<len; i++){
                var branch_id = response[i]['branch_id'];
                var branch_name = response[i]['branch_name'];
                var company_name = response[i]['company_name'];
                var selected = '';
                if(branch_from_upd == branch_id){
                    selected = "selected";
                }
                $("#branch_from").append("<option value='"+branch_id+"' "+selected+" >"+branch_name +"</option>");
            }
        }

    });
}
function getBranchdropdown(company_id){
    var branch_from_upd = $('#branch_from_upd').val();
    $.ajax({
        url: 'RGP_ajax/ajaxgetBranchName.php',
        type: 'POST',
        data: {'company_id':company_id},
        dataType: 'json',
        success:function(response){
            var len = response.length;
            $('#branch_from').empty();
            $("#branch_from").prepend("<option value=''>Select Branch Name</option>");

            for(var i = 0; i<len; i++){
                var branch_id = response[i]['branch_id'];
                var branch_name = response[i]['branch_name'];
                var selected = '';
                if(branch_from_upd == branch_id){
                    selected = "selected";
                }
                $("#branch_from").append("<option value='"+branch_id+"' "+selected+" >"+branch_name+"</option>");
            }
        }

    });
}
function getBranchdropdownForTo(company_id){
    var branch_to_upd = $('#branch_to_upd').val();
    $.ajax({
        url: 'RGP_ajax/ajaxgetBranchName.php',
        type: 'POST',
        data: {'company_id':company_id},
        dataType: 'json',
        success:function(response){
            var len = response.length;
            $('#branch_to').empty();
            $("#branch_to").prepend("<option value=''>Select Branch Name</option>");

            for(var i = 0; i<len; i++){
                var branch_id = response[i]['branch_id'];
                var branch_name = response[i]['branch_name'];
                var selected = '';
                if(branch_to_upd == branch_id){
                    selected = "selected";
                }
                $("#branch_to").append("<option value='"+branch_id+"' "+selected+" >"+branch_name+"</option>");
            }
        }

    });
}

function getAssetdropdown(asset_class){
    var asset_name_id_upd = $('#asset_name_id_upd').val();
    $.ajax({
        url: 'RGP_ajax/ajaxgetAssetName.php',
        type: 'POST',
        data: {'asset_class':asset_class},
        dataType: 'json',
        success:function(response){
            var len = response.length;

            $('#asset_name').empty();
            $("#asset_name").prepend("<option value=''>Select Asset Name</option>");

            for(var i = 0; i<len; i++){
                var asset_id = response[i]['asset_id'];
                var asset_name = response[i]['asset_name'];
                var selected = '';
                if(asset_name_id_upd == asset_id){
                    selected = "selected";
                }
                $("#asset_name").append("<option value='"+asset_id+"' "+selected+">"+asset_name+"</option>");
            }
        }

    });
}

function setalltoReadonly(){
    
    $('#rgp_date').attr('readonly',true);
    $('#return_date').attr('readonly',true);
    $('#asset_class').prop('disabled', true)
    $('#company_id').prop('disabled', true)
    $('#branch_from').prop('disabled', true)
    $('#company_to').prop('disabled', true)
    $('#branch_to').prop('disabled', true)
    $('#asset_name').prop('disabled', true)
    $('#asset_value').attr('readonly',true);
    $('#reason_rgp').attr('readonly',true);
}