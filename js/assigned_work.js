
document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');
    $.ajax({
        url:'getAssignWorkTable.php',
        data:{} ,
        cache: false,
        type: 'post',
        dataType: 'json',
        success: function(data){

            var events= [];
            for(var i=0;i<data.length;i++){ 

                var work_status = '';
                if(data[i]['work_status'] != ''){
                    work_status = ' - '+ data[i]['work_status']; 
                }
                
                events.push({
                    title:  data[i]['work_des_text'] + work_status,
                    description: data[i]['work_des_text'],
                    work_id:data[i]['work_id'],
                    work_des_id: data[i]['work_des'],
                    start: data[i]['from_date'],
                    end: data[i]['to_date'],      
                });
                
                if(data[i]['priority']=='1' ){
                    events[i].backgroundColor = 'red';
                }
                if(data[i]['priority']=='2' ){
                    events[i].backgroundColor = '#DBA800';
                }
                if(data[i]['priority']=='3' ){
                    events[i].backgroundColor = 'green';
                }
            }

            j = i;
            var todoCount = data.filter(item => item.hasOwnProperty('todo_work_des')).length;
            for(var i=0;i<todoCount;i++){

                var todo_work_status = '';
                if(data[i]['todo_work_status'] != ''){
                    todo_work_status = ' - '+ data[i]['todo_work_status']; 
                }
               
                events.push({ 
                    title:  data[i]['todo_work_des'] + todo_work_status,
                    description: data[i]['todo_work_des'],
                    todo_id:data[i]['todo_id'],
                    start: data[i]['todo_from_date'], 
                    end: data[i]['todo_to_date'],
                });
                if(data[i]['todo_priority']=='1' ){
                    events[j].backgroundColor = 'red';
                }
                if(data[i]['todo_priority']=='2' ){
                    events[j].backgroundColor = '#DBA800';
                }
                if(data[i]['todo_priority']=='3' ){
                    events[j].backgroundColor = 'green';
                }
                j++;
            }

            k = j;
            var krakpiCount = data.filter(item => item.hasOwnProperty('krakpi_rr')).length;
            for(var i=0;i<krakpiCount;i++){

                var krakpi_work_status = '';
                if(data[i]['krakpi_work_status'] != ''){
                    krakpi_work_status = ' - '+ data[i]['krakpi_work_status']; 
                }
                events.push({ 
                    title:  data[i]['krakpi_rr'] + krakpi_work_status,
                    description: data[i]['krakpi_rr'],
                    krakpi_ref_id:data[i]['krakpi_ref_id'],
                    start: data[i]['krakpi_from_date'], 
                    end: data[i]['krakpi_to_date'],
                });
                k++;
            }

            l = k;
            var auditCount = data.filter(item => item.hasOwnProperty('audit_area')).length;
            for(var i=0;i<auditCount;i++){

                var audit_work_status = '';
                if(data[i]['audit_work_status'] != ''){
                    audit_work_status = ' - '+ data[i]['audit_work_status']; 
                }
                events.push({ 
                    title:  data[i]['audit_area'] + audit_work_status,
                    description: data[i]['audit_area'],
                    audit_area_id:data[i]['audit_area_id'],
                    start: data[i]['audit_from_date'], 
                    end: data[i]['audit_to_date'],
                });
                l++;
            }

            m = l;
            var maintenanceCount = data.filter(item => item.hasOwnProperty('maintenance_asset_details')).length;
            for(var i=0;i<maintenanceCount;i++){

                var maintenance_work_status = '';
                if(data[i]['maintenance_work_status'] != ''){
                    maintenance_work_status = ' - '+ data[i]['maintenance_work_status']; 
                }
                events.push({ 
                    title:  data[i]['maintenance_asset_details'] + maintenance_work_status,
                    description: data[i]['maintenance_asset_details'],
                    maintenance_checklist_id:data[i]['maintenance_checklist_id'],
                    start: data[i]['maintenance_from_date'], 
                    end: data[i]['maintenance_to_date'],
                });
                m++;
            }

            n = m;
            var campaignCount = data.filter(item => item.hasOwnProperty('activity_involved')).length;
            for(var i=0;i<campaignCount;i++){

                var campaign_work_status = '';
                if(data[i]['campaign_work_status'] != ''){
                    campaign_work_status = ' - '+ data[i]['campaign_work_status']; 
                }
                events.push({ 
                    title:  data[i]['activity_involved'] + campaign_work_status,
                    description: data[i]['activity_involved'],
                    campaign_ref_id:data[i]['campaign_ref_id'],
                    start: data[i]['campaign_start_date'], 
                    end: data[i]['campaign_end_date'],
                });
                n++;
            }
         
            var calendar = new FullCalendar.Calendar(calendarEl, {
                
                headerToolbar: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                timezone: 'local',
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectMirror: true,
                
                eventClick: function(arg) { 
                    var work_id='';
                    if(arg.event._def.extendedProps.work_id != undefined){
                        work_id = arg.event._def.extendedProps.work_id;
                    }
                    else if(arg.event._def.extendedProps.todo_id != undefined){
                        work_id = 'todo ' + arg.event._def.extendedProps.todo_id;
                    }
                    else if(arg.event._def.extendedProps.krakpi_ref_id != undefined){
                        work_id = 'krakpi_ref ' + arg.event._def.extendedProps.krakpi_ref_id;
                    }
                    else if(arg.event._def.extendedProps.audit_area_id != undefined){
                        work_id = 'audit_area ' + arg.event._def.extendedProps.audit_area_id;
                    }
                    else if(arg.event._def.extendedProps.maintenance_checklist_id != undefined){
                        work_id = 'maintenance ' + arg.event._def.extendedProps.maintenance_checklist_id;
                    }
                    else if(arg.event._def.extendedProps.campaign_ref_id != undefined){
                        work_id = 'campaign ' + arg.event._def.extendedProps.campaign_ref_id;
                    }
                    var work_des = arg.event._def.extendedProps.description;
                    var end_date = arg.event.endStr;

                    editStatus(work_id,work_des,end_date);
                },

                editable: false, // event cannot be dragged
                dayMaxEvents: true, // allow "more" link when too many events
                
                events: events,
                eventColor: function(event, element) { 
                    element.css('background-color', event.backgroundColor);
                },
                
                // event for tooltip
                eventRender: {
                    function(event) {
                        element.tooltip({
                            content: event.tooltip,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                },

                // set times to be displayed
                slotMinTime: '09:30:00',
                slotMaxTime: '19:30:00'

            }); // calendar end
            calendar.render();

        } // success end

    }); // ajax end

}); // DOMContentLoaded


$(document).ready(function(){

    $('#inprogressgbtn').on('click', function(){
        
        $('#progress_label').show();
        $('#in_progress').show();
        $('#submit_progress').show();
        $('#cancel_progress').show();
        
        $('#inprogressgbtn').hide();
        $('#pendingbtn').hide();
        $('#completedbtn').hide();
        
        $('#work_des_label').hide();
        $('#work_id').hide();
        $('#work_name').hide();    
    });
    
    $('#pendingbtn').on('click', function(){
        
        $('#pending_label').show();
        $('#pending').show();
        $('#submit_pending').show();
        $('#cancel_pending').show();
        
        $('#inprogressgbtn').hide();
        $('#pendingbtn').hide();
        $('#completedbtn').hide();
        
        $('#work_des_label').hide();
        $('#work_id').hide();
        $('#work_name').hide();
    });

    $('#completedbtn').on('click', function(){
        
        $('#completed_label').show();
        $('#completed_file').show();
        $('#submit_completed').show();
        $('#cancel_completed').show();
        
        $('#inprogressgbtn').hide();
        $('#pendingbtn').hide();
        $('#completedbtn').hide();
        
        $('#work_des_label').hide();
        $('#work_id').hide();
        $('#work_name').hide();
    });

    $('#cancel_progress').on('click',function(event){

        event.preventDefault();
        //progress index
        $('#progress_label').hide();
        $('#in_progress').hide();
        $('#submit_progress').hide();
        $('#cancel_progress').hide();
        
        //buttons
        $('#inprogressgbtn').show();
        $('#pendingbtn').show();
        $('#completedbtn').show();
        //work descriptions
        $('#work_des_label').show();
        $('#work_id').show();
        $('#work_name').show();
    });

    $('#cancel_pending').on('click',function(event){

        event.preventDefault();
        //pending index
        $('#pending_label').hide();
        $('#pending').hide();
        $('#submit_pending').hide();
        $('#cancel_pending').hide();

        //buttons
        $('#inprogressgbtn').show();
        $('#pendingbtn').show();
        $('#completedbtn').show();
        //work descriptions
        $('#work_des_label').show();
        $('#work_id').show();
        $('#work_name').show();
    });

    $('#cancel_completed').on('click',function(event){

        event.preventDefault();
        //completed index
        $('#completed_label').hide();
        $('#completed_file').hide();
        $('#submit_completed').hide();
        $('#cancel_completed').hide();
        
        //buttons
        $('#inprogressgbtn').show();
        $('#pendingbtn').show();
        $('#completedbtn').show();
        //work descriptions
        $('#work_des_label').show();
        $('#work_id').show();
        $('#work_name').show();
    });
    
    
});//document ready end

// submit in progress
$('#submit_progress').click(function(event){

    event.preventDefault();
    var id = $('#work_id').val(); 
    var work_name = $('#work_name').val();
    var remarks = $('#in_progress').val();
    
    $.ajax({
        url: 'WorkCalendar/ajaxProgressInsert.php',
        type: 'post',
        data: {'remarks':remarks,'id':id, 'work_name':work_name},
        dataType: 'json',
        cache: false,
        success: function(response){
            
            $('#insertsuccess').show();
            setTimeout(function() {
                $('#insertsuccess').fadeOut('fast');
                location.href='assigned_work';
                }, 1000);
            // buttons
            $('#inprogressgbtn').show();
            $('#pendingbtn').show();
            $('#completedbtn').show();
            //work descriptions
            $('#work_des_label').show();
            $('#work_id').show();
            $('#work_name').show();
            
            // progress index
            $('#progress_label').hide();
            $('#in_progress').hide();
            $('#submit_progress').hide();
            $('#cancel_progress').hide();
        }
    });
});

// submit pending
$('#submit_pending').click(function(event){

    event.preventDefault();
    var id = $('#work_id').val();
    var work_name = $('#work_name').val();
    var remarks = $('#pending').val();
    
    $.ajax({
        url: 'WorkCalendar/ajaxPendingInsert.php',
        type: 'post',
        data: {'remarks':remarks,'id':id, 'work_name':work_name},
        dataType: 'json',
        cache: false,
        success: function(response){
            
            $('#insertsuccess').show();
            setTimeout(function() {
                $('#insertsuccess').fadeOut('fast');
                location.href='assigned_work';
            }, 1000);

            // buttons
            $('#inprogressgbtn').show();
            $('#pendingbtn').show();
            $('#completedbtn').show();

            // work descriptions
            $('#work_des_label').show();
            $('#work_id').show();
            $('#work_name').show();
            
            // progress index
            $('#pending_label').hide();
            $('#pending').hide();
            $('#submit_pending').hide();
            $('#cancel_pending').hide();
        }
    });
});

// submit Completed
$('#submit_completed').click(function(event){

    event.preventDefault();
    var id = $('#work_id').val();
    var work_name = $('#work_name').val();
    var completed_file = $('#completed_file')[0].files[0];

    var formData = new FormData();
    formData.append('id', id);
    formData.append('work_name', work_name);
    formData.append('completed_file', completed_file);

    $.ajax({
        url: 'WorkCalendar/ajaxCompletedInsert.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function(response){
            $('#insertsuccess').show();
            setTimeout(function() {
                $('#insertsuccess').fadeOut('fast');
                location.href='assigned_work';
            }, 1000);

            //buttons
            $('#inprogressgbtn').show();
            $('#pendingbtn').show();
            $('#completedbtn').show();
            
            //work descriptions
            $('#work_des_label').show();
            $('#work_id').show();
            $('#work_name').show();
            
            //progress index
            $('#completed_label').hide();
            $('#completed_file').hide();
            $('#submit_completed').hide();
            $('#cancel_completed').hide();
        }
    });
});


// submit outdated
$('#submit_outdated').click(function(event){

    event.preventDefault();
    var id = $('#work_id1').val(); 
    var work_name = $('#work_name1').val();
    var outdated = $('#outdated').val();
    
    $.ajax({
        url: 'WorkCalendar/ajaxOutDatedInsert.php',
        type: 'post',
        data: {'outdated':outdated,'id':id, 'work_name':work_name},
        dataType: 'json',
        cache: false,
        success: function(response){
            
            $('#insertsuccess1').show();
            setTimeout(function() {
                $('#insertsuccess1').fadeOut('fast');
                location.href='assigned_work';
            }, 1000);
           
            // $('#over_due_label').show();
            // $('#outdated').show();
            // $('#submit_outdated').show();
            // $('#cancel_outdated').show();
        }
    });
});


// edit work status modal show
function editStatus(work_id,work_des,end_date){ 
  
    var today = moment().format('YYYY-MM-DD'); 
    if(end_date < today){
        // Swal.fire({
        //     timerProgressBar: true,
        //     timer: 2000,
        //     title: 'Task Date Exceeded!',
        //     icon: 'error',
        //     showConfirmButton: true
        // });
        
        $("#workStatusModal1").addClass("show");

        $("#workStatusModal1").removeAttr("aria-hidden");
        $("#workStatusModal1").css("display","block");
        $("#workStatusModal1").css("width","500px");

        $('#work_id1').val(work_id);
        $('#work_name1').val(work_des);

    } else { 
    
        $("#workStatusModal").addClass("show");

        $("#workStatusModal").removeAttr("aria-hidden");
        $("#workStatusModal").css("display","block");
        $("#workStatusModal").css("width","500px");

        $('#work_id').val(work_id);
        $('#work_name').val(work_des);
    }
}

// reset modal contents while close modal 
function closeStatusModal(){

    $("#workStatusModal").removeClass("show");
    $("#workStatusModal").attr("aria-hidden", "true");
    $("#workStatusModal").css("display","none");

    // buttons
    $('#inprogressgbtn').show();
    $('#pendingbtn').show();
    $('#completedbtn').show();

    // work descriptions
    $('#work_des_label').show();
    $('#work_id').show();
    $('#work_name').show();
    
    // progress index
    $('#progress_label').hide();
    $('#in_progress').hide();
    $('#submit_progress').hide();
    $('#cancel_progress').hide();

    // pending index
    $('#pending_label').hide();
    $('#pending').hide();
    $('#submit_pending').hide();
    $('#cancel_pending').hide();

    // completed index
    $('#completed_label').hide();
    $('#completed_file').hide();
    $('#submit_completed').hide();
    $('#cancel_completed').hide();
}

// reset modal contents while close modal1
function closeStatusModal1(){

    $("#workStatusModal1").removeClass("show");
    $("#workStatusModal1").attr("aria-hidden", "true");
    $("#workStatusModal1").css("display","none");

    // outdated index
    // $('#over_due_label').hide();
    // $('#outdated').hide();
    // $('#submit_outdated').hide();
    // $('#cancel_outdated').hide();
}

function checkWorkDes(workdes_id){

    $.ajax({
        url: 'WorkCalendar/ajaxValidateWorkDes.php',
        type: 'post',
        data: {'workdes_id':workdes_id},
        dataType: 'json',
        cache: false,
        success: function(response){
            var work_des = response;
            return work_des;
        }
    });

}

