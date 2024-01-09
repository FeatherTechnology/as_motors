// print functionality
function print_transfer_location(id){
    $.ajax({
        url: 'transferLocationFile/printTransferLocation.php',
        cache: false,
        type: 'POST',
        data: { 'id':id },
        success: function(html){
            $("#printTransferLocation").html(html);
        }
    });
}