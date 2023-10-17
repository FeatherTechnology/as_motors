// print functionality
function print_gatePass(id){
    $.ajax({
        url: 'permissionOrOnDutyFile/printGatePass.php',
        cache: false,
        type: 'POST',
        data: {'id':id},
        success: function(html){
            $("#printgatepass").html(html);
        }
    });
}