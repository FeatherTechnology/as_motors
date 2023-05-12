$(document).ready(function(){




});//document ready end

function approve(rgp_id){
    var dlt = confirm("Are you sure to want to Approve this RGP?");
    if(dlt){
        $.ajax({
            url: 'RGP_ajax/ajaxapprovergp.php',
            cache: false,
            type: 'POST',
            data: {'rgp_id':rgp_id},
            success: function(response){
                location.href ='dashboard&msc=1';
            }
        });
        }else{
            return false;
        }
}

function reject(rgp_id){
    var dlt = confirm("Are you sure to want to Reject this RGP?");
    if(dlt){
        $.ajax({
            url: 'RGP_ajax/ajaxrejectrgp.php',
            cache: false,
            type: 'POST',
            data: {'rgp_id':rgp_id},
            success: function(response){
                location.href ='dashboard&msc=2';
            }
        });
        }else{
            return false;
        }
}