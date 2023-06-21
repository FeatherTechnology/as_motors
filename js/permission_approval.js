$(document).ready(function(){

    $('#approve_or_reject').change(function(){
        var type = $(this).val();

        if(type == '2'){
            $('.rejectReason').show();
        }else{
            $('.rejectReason').hide();
        }
    });

});




