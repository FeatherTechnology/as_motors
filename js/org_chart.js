google.charts.load('current', {packages:["orgchart"]});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var userid = $('#id').val();
    // alert(userid)
    $.ajax({
        url: 'getOrgchartdetails.php',
        data: {'userid':userid},
        dataType: 'json',
        type:'POST',
        cache: false,
        success: function(response){
            
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('string', 'Manager');
            data.addColumn('string', 'ToolTip');
            
            // For each orgchart box, provide the name, manager, and tooltip to show.
            data.addRows([
                [{'v':response.userfullname, 'f':response.userfullname},'', 'SuperAdmin']]);
            
            // adding company_names
            var j =0;var isub=0
            for (var i = 0; i < response.company_name.length; i++) {
                
                data.addRows([
                    [{'v':response['company_name'][i], 'f':'<div style="width:200px"><b>Company Name:</b>'+response['company_name'][i] + '<br><b>Address:</b>' + response['company_address1'][i] +',<br>'+response['company_address2'][i] +',<br>'+response['company_city'][i]+'.</div>'}, 
                    response.userfullname, 'Company']
                ]);

                //adding branch names
                for(var ibranch = 0; ibranch < response.branch_id.length ; ibranch++){
                    if(response['branch_company_id'][ibranch] == response['company_id'][i]){
                        
                        data.addRows([
                            [{'v':response['branch_name'][ibranch], 'f':response['branch_name'][ibranch]+ ' Branch'}, response['company_name'][i],'Branch']
                        ]);


                        //adding hierarchy orders
                        for(var idep = 0; idep < response.hierarchy_id.length; idep++){
                            
                            if(response['hierarchy_branch_id'][idep] == response['branch_id'][ibranch]){
                                data.addRows([
                                    [{'v':response['department_id'][idep]+'dep', 'f':response['department_name'][idep]}, response['branch_name'][ibranch],'Department']
                                ]);
                            
                            }
                        }
                    }
                }
            }
            //top designation list
            for(var itop=0;itop< response.top_designation_name.length; itop++){
                
                for(var j=0;j< response['top_designation_name'][itop].length;j++){

                    var staff_list = [];
                    for(var k=0;k< response['top_designation_staff_name'][itop].length;k++){
                        // console.log("itop:",itop,"j:",j,'top_designation_staff_name:', response['top_designation_staff_name'][itop][k]);
                        staff_list.push(response['top_designation_staff_name'][itop][k]);
                    }
                    var joint = staff_list.flat().join(',');

                    data.addRows([
                        [{'v':response['top_designation'][itop][j]+'top','f':response['top_designation_name'][itop][j]+'<div style="color:red; font-style:italic">'+joint+'</div>'},response['department_id'][itop]+'dep','Higher Designation']
                    ]);
                    
                }
            }

            //sub designation list
            for(isub=0;isub< response.sub_designation_name.length;isub++){
                for(var j=0;j< response['sub_designation_name'][isub].length;j++){
                    console.log("isub:",isub,"j:",j,'sub_designation_name: ', response['sub_designation_name'][isub][j]);
                    data.addRows([
                        [{'v':response['sub_designation_id'][isub][j]+'sub', 'f':response['sub_designation_name'][isub][j]},response['top_designation'][isub]+'top','Sub Designation']
                    ]);
                }
            }
            
            //sub designation staff list
            
            for(isub=0;isub< response['sub_designation_staff_name'].length;isub++){
                
                for(var j=0;j< response['sub_designation_staff_name'][isub].length;j++){ 
                
                    for(var k=0;k< response['sub_designation_staff_name'][isub][j].length;k++){
                        
                        console.log("isub:",isub,'j:',j,'sub_designation_staff_name: ', response['sub_designation_staff_name'][isub][j]);
                        data.addRows([
                            [{'v':response['sub_designation_staff_name'][isub][j][k]+'sub', 'f':'<b>Name:</b>'+ response['sub_designation_staff_name'][isub][j][k]+'<br><b>Code:</b>'+ response['sub_designation_staff_code'][isub][j][k]},response['sub_designation_id'][isub][j]+'sub','Staff']
                        ]);
                    }
                }
            }



            // Create the chart.
            var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
            // Draw the chart, setting the allowHtml option to true for the tooltips.
            chart.draw(data, {
                'allowHtml': true,
                // 'allowCollapse':true,//collapse on double click
                // 'size': 'medium',
                // 'nodeClass': 'node-style',
                // 'selectedNodeClass': 'my-selected-node-class',
                // 'chartArea': { width: '80%', height: '80%' }
            });
        }
    });
    
}