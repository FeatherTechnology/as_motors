// Document is ready
$(document).ready(function () {
    // remove delete option for last child
    $('#delete_row:last').filter(':last').attr('id', '');

    

    // Add new row
    $(document).on('click','#add_row',(function(){
        var appendTxt = "<tr><td><input tabindex='3' 'type='text' class='form-control' id='activity_involved' placeholder='Enter Activity Involved' name='activity_involved[]' ></input></td>"+
        "<td><input tabindex='4' type='text' class='form-control' id='time_frame_start' placeholder='Enter Time_Frame_Start' name='time_frame_start[]' ></input></td>"+
        "<td><input tabindex='6' type='text' class='form-control' id='duration' name='duration[]' placeholder='Enter Duration'></td>" +
       "<td> <button type='button' tabindex='9' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" +
       "<td> <span class='icon-trash-2' tabindex='10' id='delete_row'></span></td></tr>";
        $('#moduleTable').find('tbody').append(appendTxt);
        // sts();
    }));

    // Delete unwanted Rows
    $(document).on("click", '#delete_row', function () {
        $(this).parent().parent().remove();
    });

    
    });

 