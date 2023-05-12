// JavaScript
OrgChart.templates.ana.plus = '<circle cx="15" cy="15" r="15" fill="#ffffff" stroke="#aeaeae" stroke-width="1"></circle>'
    + '<text text-anchor="middle" style="font-size: 18px;cursor:pointer;" fill="#757575" x="15" y="22">{collapsed-children-count}</text>'; // will show count when collapsed


OrgChart.templates.ana.field_0 ='<text data-width="230" data-text-overflow="multiline" style="font-size: 18px;" fill="#ffffff" x="125" y="95" text-anchor="middle">{val}</text>';
OrgChart.templates.ana.field_2 = '<text data-width="230" style="font-size: 15px;" fill="#ffffff" x="135" y="105" text-anchor="middle">{val}</text>';

OrgChart.templates.itTemplate = Object.assign({}, OrgChart.templates.ana);
OrgChart.templates.itTemplate.nodeMenuButton = "";
OrgChart.templates.itTemplate.nodeCircleMenuButton = {
    radius: 18,
    x: 250,
    y: 60,
    color: '#fff',
    stroke: '#aeaeae'
};


OrgChart.templates.invisibleGroup.padding = [20, 0, 0, 0];

var chart = new OrgChart(document.getElementById("tree"), {
    mouseScrool: OrgChart.action.ctrlZoom,
    template: "ana",
    enableDragDrop: false,//drag boxes
    assistantSeparation: 50,
    mixedHierarchyNodesSeparation: 25,
    // enableSearch: false,
    nodeMouseClick: OrgChart.action.expandCollapse,
    editForm: {
        buttons: {
            edit: null,
            pdf: null,
            share:null
        }
    },
    // miniMap: true,// can have mini map
    // nodeCircleMenu: {
    //     details: {
    //         icon: OrgChart.icon.details(24, 24, '#aeaeae'),
    //         text: "Details",
    //         color: "white"
    //     },
    //     edit: {
    //         icon: OrgChart.icon.edit(24, 24, '#aeaeae'),
    //         text: "Edit node",
    //         color: "white"
    //     },
    //     add: {
    //         icon: OrgChart.icon.add(24, 24, '#aeaeae'),
    //         text: "Add node",
    //         color: "white"
    //     },
    //     remove: {
    //         icon: OrgChart.icon.remove(24, 24, '#aeaeae'),
    //         text: "Remove node",
    //         color: '#fff',
    //     },
    //     addLink: {
    //         icon: OrgChart.icon.link(24, 24, '#aeaeae'),
    //         text: "Add C link(drag and drop)",
    //         color: '#fff',
    //         draggable: true
    //     }
    // },
    // menu: {
    //     pdfPreview: {
    //         text: "Export to PDF",
    //         icon: OrgChart.icon.pdf(24, 24, '#7A7A7A'),
    //         onClick: preview
    //     },
    //     csv: { text: "Save as CSV" }
    // },
    // nodeMenu: {
    //     details: { text: "Details" },
    //     edit: { text: "Edit" },
    //     add: { text: "Add" },
    //     remove: { text: "Remove" }
    // },
    align: OrgChart.align.center,
    toolbar: {
        // fullScreen: true,
        fit: true,
        zoom: true,
        // expandAll: true,
    },
    nodeBinding: {
        field_0: "name",
        field_1: "title",
        field_2: "staff_name",
        img_0: "img"
    },
    tags: {
        "top-management": {
            template: "invisibleGroup",
            subTreeConfig: {
                orientation: OrgChart.orientation.bottom,
                collapse: {
                    level: 1
                }
            }
        },
        "it-team": {
            subTreeConfig: {
                layout: OrgChart.mixed,
                collapse: {
                    level: 1
                }
            },
        },
        "hr-team": {
            subTreeConfig: {
                layout: OrgChart.treeRightOffset,
                collapse: {
                    level: 1
                }
            },
        },
        "sales-team": {
            subTreeConfig: {
                layout: OrgChart.treeRightOffset,
                collapse: {
                    level: 1
                }
            },
        },
        "seo-menu": {
            nodeMenu: {
                addSharholder: { text: "Add new sharholder", icon: OrgChart.icon.add(24, 24, "#7A7A7A"), onClick: addSharholder },
                addDepartment: { text: "Add new department", icon: OrgChart.icon.add(24, 24, "#7A7A7A"), onClick: addDepartment },
                addAssistant: { text: "Add new assitsant", icon: OrgChart.icon.add(24, 24, "#7A7A7A"), onClick: addAssistant },
                edit: { text: "Edit" },
                details: { text: "Details" },
            }
        },
        "menu-without-add": {
            nodeMenu: {
                details: { text: "Details" },
                edit: { text: "Edit" },
                remove: { text: "Remove" }
            }
        },
        "department": {
            template: "group",
            // nodeMenu: {
            //     addManager: { text: "Add new manager", icon: OrgChart.icon.add(24, 24, "#7A7A7A"), onClick: addManager },
            //     remove: { text: "Remove department" },
            //     edit: { text: "Edit department" },
            //     nodePdfPreview: { text: "Export department to PDF", icon: OrgChart.icon.pdf(24, 24, "#7A7A7A"), onClick: nodePdfPreview }
            // }
        },
        "it-team-member": {
            template: "itTemplate",
        },
        "myTag": {template: 'diva'}
    },
    clinks: [
        { from: 11, to: 18 }
    ]
});

chart.nodeCircleMenuUI.on('click', function (sender, args) {
    switch (args.menuItem.text) {
        case "Details": chart.editUI.show(args.nodeId, true);
            break;
        case "Add node": {
            var id = chart.generateId();
            chart.addNode({ id: id, pid: args.nodeId, tags: ["it-team-member"] });
        }
            break;
        case "Edit node": chart.editUI.show(args.nodeId);
            break;
        case "Remove node": chart.removeNode(args.nodeId);
            break;
        default:
    };
});

chart.nodeCircleMenuUI.on('drop', function (sender, args) {
    chart.addClink(args.from, args.to).draw(OrgChart.action.update);
});

chart.on("added", function (sender, id) {
    sender.editUI.show(id);
});

chart.on('drop', function (sender, draggedNodeId, droppedNodeId) {
    var draggedNode = sender.getNode(draggedNodeId);
    var droppedNode = sender.getNode(droppedNodeId);

    if (droppedNode.tags.indexOf("department") != -1 && draggedNode.tags.indexOf("department") == -1) {
        var draggedNodeData = sender.get(draggedNode.id);
        draggedNodeData.pid = null;
        draggedNodeData.stpid = droppedNode.id;
        sender.updateNode(draggedNodeData);
        return false;
    }
});

chart.on('exportstart', function (sender, args) {
    args.styles = document.getElementById('myStyles').outerHTML;
});

function preview() {
    OrgChart.pdfPrevUI.show(chart, {
        format: 'A4'
    });
}

function nodePdfPreview(nodeId) {
    OrgChart.pdfPrevUI.show(chart, {
        format: 'A4',
        nodeId: nodeId
    });
}

function addSharholder(nodeId) {
    chart.addNode({ id: OrgChart.randomId(), pid: nodeId, tags: ["menu-without-add"] });
}

function addAssistant(nodeId) {
    var node = chart.getNode(nodeId);
    var data = { id: OrgChart.randomId(), pid: node.stParent.id, tags: ["assistant"] };
    chart.addNode(data);
}


function addDepartment(nodeId) {
    var node = chart.getNode(nodeId);
    var data = { id: OrgChart.randomId(), pid: node.stParent.id, tags: ["department"] };
    chart.addNode(data);
}

function addManager(nodeId) {
    chart.addNode({ id: OrgChart.randomId(), stpid: nodeId });
}

var userid = $('#id').val();
if(userid != 1){
    $.ajax({
        url: 'getOrgchartdetails.php',
        data: {'userid':userid},
        dataType: 'json',
        type:'POST',
        cache: false,
        success: function(response){
            
            
            chart.load([

                // Creating header module
                { id: response.userfullname, tags: ["top-management"] },

                
                //Contents for Director name and Company name branch name above Director
                { id: 1, stpid: response.userfullname , name: response.userfullname , title: "Director", img: "img/md_avatar.jpg", tags: ["seo-menu"] },
                { id: 2, pid: 1, name:  response['company_name'][0] , title:  'Company Name' , img: "img/company_avatar.jpg", tags: ["menu-without-add"] },
                { id: 3, pid: 1, name: response['branch_address'][0], title: 'Branch Location', img: "img/location_avatar.jpg", tags: ["menu-without-add"] },
            ]);

            // creating department names
            for(var idep = 0; idep < response.hierarchy_id.length; idep++){
                chart
                // .add({ id: "hr-team", pid: response.userfullname, tags: ["hr-team", "department"], name: "HR department" })
                // .add({ id: "sales-team", pid: response.userfullname, tags: ["sales-team", "department"], name: "Sales department" });
                .add({ id: response['department_id'][idep]+"dep", pid: response.userfullname, tags: ["it-team", "department"], name: response['department_name'][idep] + ' Department' })
                chart.draw();
            }

            // Top designation list
            for(var itop=0;itop< response.top_designation_name.length; itop++){
                
                for(var j=0;j< response['top_designation_name'][itop].length;j++){
                    
                    var staff_list = [];
                    for(var k=0;k< response['top_designation_staff_name'][itop].length;k++){
                        staff_list.push(response['top_designation_staff_name'][itop][k]);
                    }
                    var joint = staff_list.flat().join(',');

                    chart.add({ id: response['top_designation'][itop][j]+'top', stpid: response['department_id'][itop]+'dep', name: response['top_designation_name'][itop][j], 
                    title: "Top Designation", img: "img/avatar.jpg" });
                    chart.draw();
                    

                    for(var k=0;k< response['top_designation_staff_name'][itop].length;k++){
                        for(var s=0;s< response['top_designation_staff_name'][itop][k].length;s++){
                            chart.add({ id:response['top_designation_staff_name'][itop][k][s], pid: response['top_designation'][itop][j]+'top', name: response['top_designation_staff_name'][itop][k][s], 
                            title: 'Emp Code: ' + response['top_designation_staff_code'][itop][k][s], img: "img/avatar.jpg", tags: ['assistant'] });
                            chart.draw();
                        }
                    }
                }
            }
            
            // sub designation list
            for(isub=0;isub< response.sub_designation_name.length;isub++){
                for(var j=0;j< response['sub_designation_name'][isub].length;j++){
                    chart
                    .add({ id:response['sub_designation_id'][isub][j]+'sub', pid: response['top_designation'][isub]+'top', tags: ["sales-team", "department"] })
                    chart.add({ id: response['sub_designation_id'][isub][j]+'sub_id', stpid: response['sub_designation_id'][isub][j]+'sub', name: response['sub_designation_name'][isub][j],
                    title: "Sub Designation", img: "img/avatar.jpg" });
                    chart.draw();
                    
                }
            }
            
             // sub designation staff name list
            for(isub=0;isub< response['sub_designation_staff_name'].length;isub++){

                for(var j=0;j< response['sub_designation_staff_name'][isub].length;j++){ 
                
                    for(var k=0;k< response['sub_designation_staff_name'][isub][j].length;k++){
                        
                        chart.add({ id: response['sub_designation_staff_name'][isub][j][k]+'sub_name', pid: response['sub_designation_id'][isub][j]+'sub_id',
                            name: response['sub_designation_staff_name'][isub][j][k], title: "Emp Code: "+response['sub_designation_staff_code'][isub][j][k], img: "img/avatar.jpg",
                            tags: ['sales-team']});
                        chart.draw();

                    }
                }
            }
            
                // { id: 4, stpid: "hr-team", name: "Jordan Harris", title: "HR Manager", img: "https://cdn.balkan.app/shared/4.jpg" },
                // { id: 5, pid: 4, name: "Emerson Adams", title: "Senior HR", img: "https://cdn.balkan.app/shared/5.jpg" },
                // { id: 6, pid: 4, name: "Kai Morgan", title: "Junior HR", img: "https://cdn.balkan.app/shared/6.jpg" },
            
                // { id: 7, stpid: "it-team", name: "Cory Robbins", tags: ["it-team-member"], title: "Core Team Lead", img: "https://cdn.balkan.app/shared/7.jpg" },
                // { id: 8, pid: 7, name: "Billie Roach", tags: ["it-team-member"], title: "Backend Senior Developer", img: "https://cdn.balkan.app/shared/8.jpg" },
                // { id: 9, pid: 7, name: "Maddox Hood", tags: ["it-team-member"], title: "C# Developer", img: "https://cdn.balkan.app/shared/9.jpg" },
                // { id: 10, pid: 7, name: "Sam Tyson", tags: ["it-team-member"], title: "Backend Junior Developer", img: "https://cdn.balkan.app/shared/10.jpg" },
                // chart.load([
                // { id: 11, stpid: "it-team", name: "Lynn Fleming", tags: ["it-team-member"], title: "UI Team Lead", img: "https://cdn.balkan.app/shared/11.jpg" },
                // { id: 12, pid: 11, name: "Jo Baker", tags: ["it-team-member"], title: "JS Developer", img: "https://cdn.balkan.app/shared/12.jpg" },
                // { id: 13, pid: 11, name: "Emerson Lewis", tags: ["it-team-member"], title: "Graphic Designer", img: "https://cdn.balkan.app/shared/13.jpg" },
                // { id: 14, pid: 11, name: "Haiden Atkinson", tags: ["it-team-member"], title: "UX Expert", img: "https://cdn.balkan.app/shared/14.jpg" },
                // ]);
                // { id: 15, stpid: "sales-team", name: "Tyler Chavez", title: "Sales Manager", img: "https://cdn.balkan.app/shared/15.jpg" },
                // { id: 16, pid: 15, name: "Raylee Allen", title: "Sales", img: "https://cdn.balkan.app/shared/16.jpg" },
                // { id: 17, pid: 15, name: "Kris Horne", title: "Sales Guru", img: "https://cdn.balkan.app/shared/8.jpg" },
                // { id: 18, pid: "top-management", name: "Leslie Mcclain", title: "Personal assistant", img: "https://cdn.balkan.app/shared/9.jpg", tags: ["assistant", "menu-without-add"] }
            
        }
    });
}




