// Document is ready
$(document).ready(function () { 
    
    $('#city').change(function() {
        $('#state').val($('#city option:selected').data('id'));
        console.log($('#city option:selected').data('id'));
    })

});

    