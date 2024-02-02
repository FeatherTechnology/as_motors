<?php $current_page = isset($_GET['page']) ? $_GET['page'] : null; 

if(isset($_SESSION['role'])){
    $user_role = $_SESSION['role']; 
}
?>
<input type="hidden" name='user_role_dashboard_use' id='user_role_dashboard_use' value='<?php if(isset($user_role))echo $user_role; ?>'>
<!-- Required jQuery first, then Bootstrap Bundle JS -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/moment.js"></script>
<script src="js/jspdf.js"></script>
<script src="js/xlsx.js"></script>
<script src="vendor/apex/apexcharts.min.js"></script>


<!-- Slimscroll JS -->
<script src="vendor/slimscroll/slimscroll.min.js"></script>
<script src="vendor/slimscroll/custom-scrollbar.js"></script>

<!-- Daterange -->
<script src="vendor/daterange/daterange.js"></script>
<script src="vendor/daterange/custom-daterange.js"></script>

<script src="vendor/bs-select/bs-select.min.js"></script>
<!-- <script src="vendor/bs-select/bootstrap-select.js"></script> -->
<!-- Font -->
<script src="js/main.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- choices css for multi select -->
<script src="vendor/choicesjs/public/assets/scripts/choices.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/js/bootstrap-select.min.js"></script> -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css"> -->

<!-- org chart plugin -->
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<script type="text/javascript" src="vendor/org_chart/loader.js"></script>
<script src="vendor/org_chart/OrgChart.js"></script>

<script type="text/javascript" src="jsd/datatables.min.js"></script>
<!-- CSV Format Export --->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
<!-- CSV Format Export END -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- select2 cdns -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script type="text/javascript" language="javascript">


	// $('select').selectpicker();

    $(document).ready(function() {
        //"Max-User-Connection" exceeded when more than 10 DB connection made, All ajax are run at a time to getting a data for dashboard so connection exceeded bug are coming in alert, so calling the particular function based on the login. Now the function run one by one so the connection exceed will not reach.
        // here we call the function and in this function ajax will run and end of the each ajax "drawCallBack" function will run to call next function.  
        var user_role_dashboard_use = $('#user_role_dashboard_use').val();
        if(user_role_dashboard_use == '1'){ //Overall
            commonDashboard();
            setTimeout(function(){
                overallManagerLoginDashboard();

                setTimeout(function(){
                    OverallLoginFunc();
                },1000);

            },2000);
            
        }else if(user_role_dashboard_use == '3'){ //Manager
            commonDashboard();
            

            var i=0;
            var dashboardDelay = setInterval(function(){

                for(; i< 3; ){
                    if(i == 0){
                        managerStaffLoginDashboard();
                        i++
                        return;

                    }else if(i == 1){
                        overallManagerLoginDashboard();
                        i++
                        return;

                    }else if(i == 2){
                        regularisationApprovalDashboard();
                        i++
                        return;

                    }
                }
                
            },1000)
            setTimeout(function(){
            
                    clearInterval(dashboardDelay);
                
            },3500)
        }else if(user_role_dashboard_use == '4'){ //Staff
            commonDashboard();
            setTimeout(function(){
                managerStaffLoginDashboard();
            },2000)

        }

		var companyCreation_info = $('#companyCreation_info').DataTable({
		"order": [[ 0, "desc" ]],
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		//'searching': false, // Remove default Search Control
		'ajax': {
			'url':'ajaxCompanyCreationFetch.php',
			'data': function(data){
                var search = $('#search').val();						
				// Append to data               
		  		data.search      = search;
			}
		},
		
		dom: 'lBfrtip',
		buttons: [		
			{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3,4,5,6,7,8,9,10,11]
					}
			}

		],	
		"lengthMenu": [
			[10, 25, 50, -1],
			[10, 25, 50, "All"]
		]
	});
    // Branch Creation Fetching
    	var branchCreation_info = $('#branchCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxBranchCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4, 5 ]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

		
    // Holiday Creation Fetching
    var holidayCreation_info = $('#holidayCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxHolidayCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4, 5 ]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

    });

    // TagCreation Fetching
    var tagCreation_info = $('#tagCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxTagCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			// dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

		//TagCreation Fetching
		var staffCreation_info = $('#staffCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxStaffCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

		//TagCreation Fetching
		var auditareaCreation_info = $('#auditareaCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxAuditAreaCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10 ]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

		//TagCreation Fetching
		var basicCreation_info = $('#basicCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxBasicCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4, 5, 6 ]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

		//TagCreation Fetching
		var roles_responsibilityCreation_info = $('#roles_responsibilityCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxRolseResponsibilityCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

			//TagCreation Fetching
			var krakpiCreation_info = $('#krakpiCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxKraKpiCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

		//Audit Check List Fetching
		var audit_area_checklist_table = $('#audit_area_checklist_table').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxGetAuditAreaChecklist.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4, 5 ]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});


		// Hierarchy creation fetching
		var hierarchyCreation_info = $('#hierarchyCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxHierarchyCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
					}
				}

			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

		// Report Template Fetching
        var report_template_table = $('#reportTable').DataTable({
            "order": [[ 0, "desc" ]],
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxGetReportTemplate.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

        // Media Creation Fetching
        var media_master_table = $('#mediaMasterTable').DataTable({
            "order": [[ 0, "desc" ]],
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxGetMediaMaster.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });


		// KRA creation fetching
		var kraCreation_info = $('#kraCreation_info').DataTable({
			"order": [[ 0, "desc" ]],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			//'searching': false, // Remove default Search Control
			'ajax': {
				'url':'ajaxKraCreationFetch.php',
				'data': function(data){
					var search = $('#search').val();
					data.search = search;
				}
			},
			
			dom: 'lBfrtip', 
			buttons: [		
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2 ,3, 4 ]
					}
				}
			],	
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			]
		});

		//Assign Work Fetching
        var assign_work_table = $('#assign_work_table').DataTable({
            "order": [[ 0, "desc" ]],
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxGetAssignWork.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
		//Asset Register Fetching
        var assign_work_table = $('#asset_register_table').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxGetAssetRegisterTable.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

		//Insurance Register Fetching
        var insuranceRegisterTable = $('#insuranceRegisterTable').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'insuranceFile/ajaxFetchInsuranceRegisterTable.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
		
		//To Do Fetching
        var todoTable = $('#todoTable').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxToDoTableFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });


		// memo initiate
		var memo_info = $('#memo_info').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'memoFile/ajaxMemoFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

		// memo assigned
		var memo_assigned_info = $('#memo_assigned_info').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'memoFile/ajaxMemoAssignedFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

        // memo update
		var memo_update_info = $('#memo_update_info').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'memoFile/ajaxMemoUpdateFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

		// Service Indent
		var service_indent_info = $('#service_indent_info').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxServiceIndentFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

		// Memo status
		var memo_status_info = $('#memo_status_info').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'memostatusFile/ajaxMemoStatusFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
		// Asset Details
		var asset_details_table = $('#asset_details_table').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'assetDetails/ajaxAssetDetailsFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
		// RGP Creation
		var rgp_table = $('#rgp_table').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'RGP_ajax/ajaxRGPFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

		// RGP Extended
		var permission_on_duty_table = $('#permission_on_duty_table').DataTable({

            "order": [[ 0, "desc" ]],
			// "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxPermissionOnDutyFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
        //Permission Approval 
		var permission_approval = $('#permission_approval').DataTable({

            "order": [[ 0, "desc" ]],
			// "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxPermissionApproval.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

		// Transfer Location
		var transfer_location_info = $('#transfer_location_info').DataTable({

            "order": [[ 0, "desc" ]],
			// "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxTransferLocationFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

		// PM Checklist 
		var pmChecklist_info = $('#pmChecklist_info').DataTable({

            "order": [[ 0, "desc" ]],
			// "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxPMChecklistFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });

		// BM Checklist 
		var bmChecklist_info = $('#bmChecklist_info').DataTable({

            "order": [[ 0, "desc" ]],
			// "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxBMChecklistFetch.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
    
    // approval line - approval requisition
    var approvalLine_info = $('#approvalLine_info').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxApprovalLineFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // approval requisition list fetching
    var approvalRequisition_info = $('#approvalRequisition_info').DataTable({
        "order": [[ 0, "desc" ]],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxApprovalRequisitionListFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },

        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5 ]
                }
            }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    // approval line - approval requisition dashboard
    var approvalLine_info_dashboard = $('#approvalLine_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxApprovalLineDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // parallel agreement - approval requisition dashboard
    var parallelAgreement_info_dashboard = $('#parallelAgreement_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxParallelAgreementDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // after notification - approval requisition dashboard
    var afterNotification_info_dashboard = $('#afterNotification_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxAfterNotificationDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    // Business Com approval line - Business Com out
    var business_approvalLine_info = $('#business_approvalLine_info').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxBusinessComcApprovalLineFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // business communication outgoing list fetching
    var businessComOut_info = $('#businessComOut_info').DataTable({
        "order": [[ 0, "desc" ]],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxBusinessComOutListFetch.php',
            'data': function(data){
                
                var search = $('#search').val();
                data.search = search;
            }
        },

        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // approval line - business com out dashboard
    var business_com_out_approvalLine_info_dashboard = $('#business_com_out_approvalLine_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxBusinessComOutApprovalLineDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    // parallel agreement - Business Communication (Outgoing)
    var business_com_out_parallelAgreement_info_dashboard = $('#business_com_out_parallelAgreement_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxBusinessComOutParallelAgreementDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    // after notification dashboard - Business Communication (Outgoing)
    var business_com_out_afterNotification_info_dashboard = $('#business_com_out_afterNotification_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxBusinessComOutAfterNotificationDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    // after notification - Business Communication (Outgoing)
    var business_com_out_receivingBranch_info_dashboard = $('#business_com_out_receivingBranch_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxBusinessComOutReceivingBranchDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // after maintenance checklist
    var maintenanceChecklist_info = $('#maintenanceChecklist_info').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'ordering': false,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxMaintenanceChecklistFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // Periodic Level
    var periodicLevel_info = $('#periodicLevel_info').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxPeriodicLevelFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // Periodic Level
    var periodicLevel_infoDashboard = $('#periodicLevel_infoDashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxPeriodicLevelDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    // Vehicle Details
    var vehicleDetails_info = $('#vehicleDetails_info').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxVehicleDetailsFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // Daily KM
    var dailyKM_info = $('#dailyKM_info').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxDailyKMFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // Diesel Slip
    var dieselSlip_info = $('#dieselSlip_info').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxDieselSlipFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // audit assign Creation Fetching
    var auditassignCreation_info = $('#auditassignCreation_info').DataTable({
        "order": [[ 0, "desc" ]],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxAuditAssignFetch.php',
            'data': function(data){
                
                var search = $('#search').val();
                data.search = search;
            }
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // campaign Fetching
    var campaign_info = $('#campaign_info').DataTable({
        "order": [[ 0, "desc" ]],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxCampaignFetch.php',
            'data': function(data){
                
                var search = $('#search').val();
                data.search = search;
            }
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    //promotional_activities Fetching
    var promotional_activities_info = $('#promotional_activities_info').DataTable({
        "order": [[ 0, "desc" ]],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxpromoactivitiesFetch.php',
            'data': function(data){
                
                var search = $('#search').val();
                data.search = search;
            }
        },

        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5 ]
                }
            }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // goal dashboard
    var goal_setting_infoDashboard = $('#goal_setting_infoDashboard').DataTable({

        "order": [[ 0, "desc" ]],
        //"ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxGoalSettingFetchDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
                
            }
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });
    
   
    // meeting minutes - approval line
    var minutesMeetingApprovalLine_info = $('#minutesMeetingApprovalLine_info').DataTable({

        "order": [[ 0, "desc" ]],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url':'ajaxMinutesMeetingApprovalLineFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // meeting minutes 
    var meetingMinutes_info = $('#meetingMinutes_info').DataTable({
        "order": [[ 0, "desc" ]],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url':'ajaxMeetingMinutesListFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },

        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5 ]
                }
            }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    // Meeting minutes approval line - dashboard
    var meetingMinutesApprovalLine_info_dashboard = $('#meetingMinutesApprovalLine_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxMeetingMinutesApprovalLineDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

// Daily Performance
var daily_performance_info = $('#daily_performance_info').DataTable({

"order": [[ 0, "desc" ]],
//"ordering": false, //removes sorting by column
'processing': true,
'serverSide': true,
'serverMethod': 'post',
//'searching': false, // Remove default Search Control
'ajax': {
    'url':'ajaxdaily_performance_info.php',
    'data': function(data){
        var search = $('#search').val();
        data.search = search;
    }
},
dom: 'lBfrtip',
buttons: [
    {
        extend: 'csv',
        exportOptions: {
            columns: [ 0, 1, 2 ,3, 4, 5, 6 ]
        }
    }
],
"lengthMenu": [
    [10, 25, 50, -1],
    [10, 25, 50, "All"]
]
});
// Daily Performance Review
var daily_performance_review_fetch = $('#daily_performance_review_fetch').DataTable({

"order": [[ 0, "desc" ]],
//"ordering": false, //removes sorting by column
'processing': true,
'serverSide': true,
'serverMethod': 'post',
//'searching': false, // Remove default Search Control
'ajax': {
    'url':'ajaxFetch/ajaxDailyPerformanceReviewFetch.php',
    'data': function(data){
        var search = $('#search').val();
        data.search = search;
    }
},
dom: 'lBfrtip',
buttons: [
    {
        extend: 'csv',
        exportOptions: {
            columns: [ 0, 1, 2 ,3, 4, 5, 6 ]
        }
    }
],
"lengthMenu": [
    [10, 25, 50, -1],
    [10, 25, 50, "All"]
]
});


    // parallel agreement - meeting minutes dashboard
    var meetingMinutesParallelAgreement_info_dashboard = $('#meetingMinutesParallelAgreement_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxMeetingMinutesParallelAgreementDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    // after notification - approval requisition dashboard
    var afterMeetingMinutesNotification_info_dashboard = $('#afterMeetingMinutesNotification_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxMeetingMinutesAfterNotificationDashboard.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // Target fixing
    var targetFixing_info = $('#targetFixing_info').DataTable({

        "order": [[ 0, "desc" ]],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url':'ajaxTargetFixingFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        
        dom: 'lBfrtip', 
        buttons: [		
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7 ]
                }
            }

        ],	
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    // Appreciation Depreciation
    var appreciation_depreciation_info = $('#appreciation_depreciation_info').DataTable({

        "order": [[ 0, "desc" ]],
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url':'ajaxAppreciationDepreciationFetch.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        
        dom: 'lBfrtip', 
        buttons: [		
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ]
                }
            }

        ],	
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });


    var user_info = $('#user_info').DataTable({

		"order": [[ 0, "desc" ]],
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		// 'searching': false,
		info:false,
		//'searching': false, // Remove default Search Control
		'ajax': {
			'url':'ajaxUserinfoFetch.php',
			'data': function(data){
                var search = $('#search').val();
				// Append to data                           
				data.search      = search;
			}
		},
		dom: 'lBfrtip',
        buttons: [		
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4 ]
                }
            }

        ],
		"lengthMenu": [
			[10, 25, 50, -1],
			[10, 25, 50, "All"]
		]
	});


///////////////////////////////////////////////////////////////////////// Overall & Manager & Staff Login Dashboard  //////////////////////////////////////////////////////

     // PM Checklist dashboard
    function commonDashboard(){
        var pmChecklist_dashboard = $('#pmChecklist_dashboard').DataTable({

            "order": [[ 0, "desc" ]],
            // "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxPMChecklistDashboard.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "drawCallback":function(){
                // After the first DataTable is loaded, proceed to the next one
                initializeBMChecklistDashboard();
            }
        });
    }

    // BM Checklist dashboard
    function initializeBMChecklistDashboard(){

        var bmChecklist_dashboard = $('#bmChecklist_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
        'url':'ajaxBMChecklistDashboard.php',
        'data': function(data){
            var search = $('#search').val();
            data.search = search;
        }
        },
        // dom: 'lBfrtip',
        buttons: [
        {
            extend: 'csv',
            exportOptions: {
                columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
            }
        }
        ],
        "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
        ],
        "drawCallback":function(){
            // After the first DataTable is loaded, proceed to the next one
            initializeRegularisationApprovedDashboard();
        }
        });
    }//Function END.

    // approved List - Regularaisation dashboard
    function initializeRegularisationApprovedDashboard(){
        var regularisation_approved_info_dashboard = $('#regularisation_approved_info_dashboard').DataTable({

            "order": [[ 0, "desc" ]],
            // "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxRegularisationApprovedList.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
            });

    } //Function END.
///////////////////////////////////////////////////////////////////////// Overall & Manager & Staff Login Dashboard  END //////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////// Overall & Manager Login Dashboard  //////////////////////////////////////////////////////
    // RGP Extended
    function overallManagerLoginDashboard(){
        var rgpExtendedTable = $('#rgpExtendedTable').DataTable({

        "order": [[ 0, "desc" ]],
        //"ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':'RGP_ajax/ajaxRGPExtended.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "drawCallback":function(){
            // After the first DataTable is loaded, proceed to the next one
            initializeFcInsuranceDashboard();
        }
        });
    }//Function END///

    // Vehicle Management dashboard
    function initializeFcInsuranceDashboard(){
        var fc_insurance_info_dashboard = $('#fc_insurance_info_dashboard').DataTable({

        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'ajaxFCinsuranceinfoList.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "drawCallback": function(){pagepassing();}
        });
    } //Function END.
/////////////////////////////////////////////////////////////////////////Overall & Manager Login Dashboard END //////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////// Manager & Staff Login Dashboard ///////////////////////////////////////////////////////////

    // Today's Task List dashboard
    function managerStaffLoginDashboard(){
        var todays_task_info = $('#todays_task_info').DataTable({
            "order": [[ 0, "desc" ]],
            // "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'dashboardAjaxFile/todays_task_list.php',
                'cache': false,
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "drawCallback":function(){
                // After the first DataTable is loaded, proceed to the next one
                initializeMemoDashboard();
            }
            });

            var manager_comment_info_dashboard = $('#manager_comment_info_dashboard').DataTable({
            "order": [[ 0, "desc" ]],
            // "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'dashboardAjaxFile/ajaxManagerCommentDashboardInfo.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
            });
    }
    // Today's Task List dashboard END/////

    // memo initiate dashboard
    function initializeMemoDashboard(){
		var memo_infoDashboard = $('#memo_infoDashboard').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'memoFile/ajaxMemoFetchDashboard.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "drawCallback":function(){
                // After the first DataTable is loaded, proceed to the next one
                initializeMemoAssignedDashboard();
            }
        });
    }

    // memo assigned dashboard
    function initializeMemoAssignedDashboard(){
		var memo_assigned_infoDashboard = $('#memo_assigned_infoDashboard').DataTable({
            "order": [[ 0, "desc" ]],
			//"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'memoFile/ajaxMemoAssignedFetchDashboard.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "drawCallback":function(){
                // After the first DataTable is loaded, proceed to the next one
                initializeAuditAssignDashboard();
            }
        });
    } //Function END///

    // audit assign dashboard
    function initializeAuditAssignDashboard(){
        var audit_assign_infoDashboard = $('#audit_assign_infoDashboard').DataTable({

            "order": [[ 0, "desc" ]],
            //"ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxAuditAssignFetchDashboard.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "drawCallback":function(){
                // After the first DataTable is loaded, proceed to the next one
                initializeAuditResponseDashboard();
            }
        });
    }//Function END///

    // auditee response dashboard
    function initializeAuditResponseDashboard(){
        var auditee_response_infoDashboard = $('#auditee_response_infoDashboard').DataTable({

            "order": [[ 0, "desc" ]],
            //"ordering": false, // removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxAuditeeResponseFetchDashboard.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "drawCallback":function(){
                // After the first DataTable is loaded, proceed to the next one
                initializeMaintenanceCheckListDashboard();
            }
        });
    }//Function END///

    // after maintenance checklist
    function initializeMaintenanceCheckListDashboard(){
        var maintenanceChecklist_infoDashboard = $('#maintenanceChecklist_infoDashboard').DataTable({

            "order": [[ 0, "desc" ]],
            // "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'ajaxMaintenanceChecklistDashboard.php',
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
    } //Function END///
///////////////////////////////////////////////////////////////////////// Manager & Staff Login Dashboard END///////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////// Manager Login Dashboard ///////////////////////////////////////////////////////////
    // Regularisation Approval List dashboard
    function regularisationApprovalDashboard(){
        var regularisation_approval_info = $('#regularisation_approval_info').DataTable({
            "order": [[ 0, "desc" ]],
            // "ordering": false, //removes sorting by column
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            // 'searching': false, // Remove default Search Control
            'ajax': {
                'url':'dashboardAjaxFile/regularisationApprovalDashboard.php',
                'cache': false,
                'data': function(data){
                    var search = $('#search').val();
                    data.search = search;
                }
            },
            // dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ]
                    }
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ]
        });
        // Regularisation Approval List dashboard END/////

        //Manager Completed Task dashboard
		var managerlogin_completed_task_dashboard = $('#managerlogin_completed_task_dashboard').DataTable({
        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'dashboardAjaxFile/ajaxManagerLoginCompletedTaskList.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ,3, 4, 5 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "drawCallback":function(){
            managerLoginPendingDashboard();
        }
        });
        //Manager Completed Task dashboard END
    }

    function managerLoginPendingDashboard(){
        //Manager Pending Task dashboard
		var managerlogin_pending_task_dashboard = $('#managerlogin_pending_task_dashboard').DataTable({
        "order": [[ 0, "desc" ]],
        // "ordering": false, //removes sorting by column
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        // 'searching': false, // Remove default Search Control
        'ajax': {
            'url':'dashboardAjaxFile/ajaxManagerLoginPendingTaskList.php',
            'data': function(data){
                var search = $('#search').val();
                data.search = search;
            }
        },
        // dom: 'lBfrtip',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                columns: [ 0, 1, 2 ,3, 4, 5 ]
                }
            }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "drawCallback":function(){
            changeRowBGColor();
        }
        });
        //Manager Pending Task dashboard END
    }
///////////////////////////////////////////////////////////////////////// Manager Login Dashboard END///////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////// Overall Login Dashboard END///////////////////////////////////////////////////////////
function OverallLoginFunc(){
    // Completed Task dashboard - Overall Login
    var completed_task_dashboard = $('#completed_task_dashboard').DataTable({
    "order": [[ 0, "desc" ]],
    // "ordering": false, //removes sorting by column
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    // 'searching': false, // Remove default Search Control
    'ajax': {
        'url':'dashboardAjaxFile/ajaxCompletedTaskList.php',
        'data': function(data){
            var search = $('#search').val();
            data.search = search;
        }
    },
    // dom: 'lBfrtip',
    buttons: [
        {
            extend: 'csv',
            exportOptions: {
            columns: [ 0, 1, 2 ,3, 4, 5 ]
            }
        }
    ],
    "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    "drawCallback":function(){
        OverallLoginPendingTask();
    }
    });

}//Function END

function OverallLoginPendingTask(){
        // Pending Task dashboard
        var pending_task_dashboard = $('#pending_task_dashboard').DataTable({
    "order": [[ 0, "desc" ]],
    // "ordering": false, //removes sorting by column
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    // 'searching': false, // Remove default Search Control
    'ajax': {
        'url':'dashboardAjaxFile/ajaxPendingTaskList.php',
        'data': function(data){
            var search = $('#search').val();
            data.search = search;
        }
    },
    // dom: 'lBfrtip',
    buttons: [
        {
            extend: 'csv',
            exportOptions: {
            columns: [ 0, 1, 2 ,3, 4, 5 ]
            }
        }
    ],
    "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    "drawCallback":function(){
        changeRowColor();
        // OverallLoginFunc();
    }
    });
}//Function END.

///////////////////////////////////////////////////////////////////////// Overall Login Dashboard END///////////////////////////////////////////////////////////


	$('#search').change(function(){
		companyCreation_info.draw();
		branchCreation_info.draw();
		holidayCreation_info.draw();
		tagCreation_info.draw();
		StaffCreation_info.draw();
		auditareaCreation_info.draw();
		basicCreation_info.draw();
		roles_responsibilityCreation_info.draw();
		krakpiCreation_info.draw();
		audit_area_checklist_table.draw();
		hierarchyCreation_info.draw();
		report_template_table.draw();
		media_master_table.draw();
		kraCreation_info.draw();
		assign_work_table.draw();
		insuranceRegisterTable.draw();
		memo_info.draw();
		memo_assigned_info.draw();
		memo_assigned_infoDashboard.draw();
		service_indent_info.draw();
		memo_status_info.draw();
		asset_details_table.draw();
		rgp_table.draw();
		rgpExtendedTable.draw();
		permission_on_duty_table.draw();
		permission_approval.draw();
		transfer_location_info.draw();
		pmChecklist_info.draw();
		bmChecklist_info.draw();
		approvalLine_info.draw();
		parallelAgreement_info_dashboard.draw();
		afterNotification_info_dashboard.draw();
        business_approvalLine_info.draw();
        business_com_out_approvalLine_info_dashboard.draw();
        business_com_out_parallelAgreement_info_dashboard.draw();
        business_com_out_afterNotification_info_dashboard.draw();
        business_com_out_receivingBranch_info_dashboard.draw();
        maintenanceChecklist_info.draw();
        maintenanceChecklist_infoDashboard.draw();
        periodicLevel_infoDashboard.draw();
        vehicleDetails_info.draw();
        dailyKM_info.draw();
        dieselSlip_info.draw();
        audit_assign_infoDashboard.draw();
        auditee_response_infoDashboard.draw();
        auditassignCreation_info.draw();
        campaign_info.draw();
        promotional_activities_info.draw();
        goal_setting_infoDashboard.draw();
        approvalRequisition_info.draw();
        businessComOut_info.draw();
        minutesMeetingApprovalLine_info.draw();
        meetingMinutes_info.draw();
        meetingMinutesApprovalLine_info_dashboard.draw();
        meetingMinutesParallelAgreement_info_dashboard.draw();
        afterMeetingMinutesNotification_info_dashboard.draw();
        daily_performance_info.draw();
        daily_performance_review_fetch.draw();
        appreciation_depreciatione_info.draw();
        targetFixing_info.draw();
        appreciation_depreciation_info.draw();
        user_info.draw();
    });
	
</script>

<?php if($current_page == 'company_creation') { ?>
<script src="js/company_creation.js"></script>
<?php }

if($current_page == 'branch_creation') { ?>
<script src="js/branch_creation.js"></script>
<?php }

if($current_page == 'holiday_creation') { ?>
<script src="js/holiday_creation.js"></script>
<?php }

if($current_page == 'edit_investment_entry') { ?>
<script src="js/investment_entry.js"></script>
<?php }

if($current_page == 'staff_creation') { ?>
<script src="js/staff_creation.js"></script>
<?php }

if($current_page == 'hierarchy_creation') { ?>
<script src="js/hierarchy_creation.js"></script>
<?php }

if($current_page == 'basic_creation') { ?>
<script src="js/basic_creation.js"></script>
<?php }

if($current_page == 'roles_responsibility_creation') { ?>
<script src="js/roles_responsibility_creation.js"></script>
<?php }

if($current_page == 'krakpi_creation') { ?>
<script src="js/krakpi_creation.js"></script>
<?php }

if($current_page == 'audit_checklist') { ?>
<script src="js/audit_checklist.js"></script>
<?php }

if($current_page == 'kra_creation') { ?>
<script src="js/kra_creation.js"></script>
<?php }

if($current_page == 'assign_work') { ?>
	<script src="js/assign_work.js"></script>
	<?php }

if($current_page == 'daily_task_update') { ?>
	<script src="js/daily_task_update.js"></script>
	<?php }
	
if($current_page == 'assigned_work') { ?>
	<script src="dist/index.global.js"></script>
	<script src="js/assigned_work.js"></script>
	<?php }

if($current_page == 'asset_register') { ?>
	<script src="js/asset_register.js"></script>
	<?php }

if($current_page == 'insurance_register') { ?>
	<script src="js/insurance_register.js"></script>
	<?php }

if($current_page == 'memo') { ?>
	<script src="js/memo.js"></script>
	<?php }

if($current_page == 'memo_assigned') { ?>
	<script src="js/memo.js"></script>
	<?php }

if($current_page == 'memo_update') { ?>
	<script src="js/memo.js"></script>
	<?php }

if($current_page == 'tag_creation') { ?>
	<script src="js/tag_creation.js"></script>
	<?php }

if($current_page == 'report_template') { ?>
<script src="js/report_template.js"></script>
<?php }

if($current_page == 'media_master') { ?>
<script src="js/media_master.js"></script>
<?php }

if($current_page == 'tag_creation') { ?>
<script src="js/tag_creation.js"></script>
<?php }

if($current_page == 'service_indent') { ?>
<script src="js/service_indent.js"></script>
<?php }

if($current_page == 'memo_status') { ?>
<script src="js/memo_status.js"></script>
<?php }

if($current_page == 'audit_area_creation') { ?>
	<script src="js/audit_area_creation.js"></script>
	<?php }

if($current_page == 'asset_details') { ?>
	<script src="js/asset_details.js"></script>
	<?php }

if($current_page == 'rgp_creation') { ?>
	<script src="js/rgp_creation.js"></script>
	<?php }

if($current_page == 'edit_rgp_creation') { ?>
	<script src="js/rgp_creation.js"></script>
	<?php }

if($current_page == 'dashboard') { ?>
	<script src="js/dashboard.js"></script>
	<?php }

if($current_page == 'todo') { ?>
	<script src="js/todo.js"></script>
	<?php }

if($current_page == 'org_chart') { ?>
	<script src="js/org_chart.js"></script>
	<?php }

if($current_page == 'approval_requisition') { ?>
	<script src="js/approval_requisition.js"></script>
	<?php }

if($current_page == 'permission_or_on_duty') { ?>
	<script src="js/permission_or_on_duty.js"></script>
	<?php }

if($current_page == 'edit_permission_or_on_duty') { ?>
	<script src="js/edit_permission_or_on_duty.js"></script>
	<?php }

if($current_page == 'permission_approval') { ?>
	<script src="js/permission_approval.js"></script>
	<?php }

if($current_page == 'transfer_location') { ?>
	<script src="js/transfer_location.js"></script>
	<?php }

if($current_page == 'edit_transfer_location') { ?>
	<script src="js/edit_transfer_location.js"></script>
	<?php }

if($current_page == 'pm_checklist') { ?>
	<script src="js/pm_checklist.js"></script>
	<?php }

if($current_page == 'bm_checklist') { ?>
	<script src="js/bm_checklist.js"></script>
	<?php }

if($current_page == 'approval_line') { ?>
	<script src="js/approval_line.js"></script>
	<?php }

if($current_page == 'business_com_approval_line') { ?>
	<script src="js/business_com_approval_line.js"></script>
	<?php }

if($current_page == 'business_com_out') { ?>
	<script src="js/business_com_out.js"></script>
	<?php }

if($current_page == 'maintenance_checklist') { ?>
	<script src="js/maintenance_checklist.js"></script>
	<?php }
    
if($current_page == 'periodic_level') { ?>
	<script src="js/periodic_level.js"></script>
	<?php }

if($current_page == 'vehicle_details') { ?>
	<script src="js/vehicle_details.js"></script>
	<?php }

if($current_page == 'vehicle_fc_insurance') { ?>
	<script src="js/vehicle_fc_insurance.js"></script>
	<?php }

if($current_page == 'daily_km') { ?>
	<script src="js/daily_km.js"></script>
	<?php }

if($current_page == 'diesel_slip') { ?>
	<script src="js/diesel_slip.js"></script>
	<?php }

if($current_page == 'edit_diesel_slip') { ?>
	<script src="js/diesel_slip.js"></script>
	<?php }

if($current_page == 'audit_assign') { ?>
	<script src="js/audit_assign.js"></script>
	<?php }

if($current_page == 'auditee_response') { ?>
	<script src="js/auditee_response.js"></script>
	<?php }

if($current_page == 'campaign') { ?>
	<script src="js/campaign.js"></script>
	<?php }

if($current_page == 'promotional_activities') { ?>
    <script src="js/promotional_activities.js"></script>
    <?php }

if($current_page == 'audit_followup') { ?>
	<script src="js/audit_followup.js"></script>
	<?php }


if($current_page == 'goal_setting') { ?>
	<script src="js/goal_setting.js"></script>
	<?php }

if($current_page == 'meeting_minutes_approval_line') { ?>
	<script src="js/meeting_minutes_approval_line.js"></script>
	<?php }

if($current_page == 'meeting_minutes') { ?>
	<script src="js/meeting_minutes.js"></script>
	<?php }

if($current_page == 'target_fixing') { ?>
	<script src="js/target_fixing.js"></script>
	<?php }

if($current_page == 'daily_performance') { ?>
	<script src="js/daily_performance.js"></script>
	<?php } 

if($current_page == 'daily_performance_review') { ?>
	<script src="js/daily_performance_review.js"></script>
	<?php } 

if($current_page == 'appreciation_depreciation') { ?>
	<script src="js/appreciation_depreciation.js"></script>
	<?php } 

if($current_page == 'manage_users') { ?>
	<script src="js/manage_users.js"></script>
    <?php }

if($current_page == 'work_status_report') { ?>
	<script src="js/work_status_report.js"></script>
    <?php }
    

if($current_page == 'daily_performance_report') { ?>
	<script src="js/daily_performance_report.js"></script>
    <?php }

if($current_page == 'vehicle_report') { ?>
	<script src="js/vehicle_report.js"></script>
    <?php }

if($current_page == 'daily_km_report') { ?>
	<script src="js/daily_km_report.js"></script>
    <?php }

if($current_page == 'diesel_slip_report') { ?>
	<script src="js/diesel_slip_report.js"></script>
    <?php }

if($current_page == 'memo_report') { ?>
	<script src="js/memo_report.js"></script>
    <?php }

if($current_page == 'kra_kpi_report') { ?>
	<script src="js/kra_kpi_report.js"></script>
    <?php }

if($current_page == 'staff_task_details') { ?>
	<script src="js/staff_task_details.js"></script>
    <?php }
    
?> 

<script src="js/logincreation.js"></script>

<!-- Slimscroll JS -->
<script src="vendor/slimscroll/slimscroll.min.js"></script>
<script src="vendor/slimscroll/custom-scrollbar.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.7/dist/sweetalert2.all.min.js"></script>

<!-- Datepickers -->
<script src="vendor/datepicker/js/picker.js"></script>
<script src="vendor/datepicker/js/picker.date.js"></script>
<script src="vendor/datepicker/js/custom-picker.js"></script>

<script type="text/javascript">
	// Company delete
    $(document).on("click", '.delete_company_creation', function(){
        var dlt = prompt("Please enter remark before delete this Company ?");
        if(dlt){
            var id  = $(this).data('value'); //row id.
            inActiveRemark('company_id',id,'company_creation',dlt,'edit_company_creation'); //call function to add in active remark.
            return true;
        }else{
                return false;
            }
    });
  //Branch delete
	$(document).on("click", '.delete_branch_creation', function(){
        var dlt = prompt("Please enter remark before delete this Branch ?");
        if(dlt){
            var id  = $(this).data('value'); //row id.
            inActiveRemark('branch_id',id,'branch_creation',dlt,'edit_branch_creation'); //('column name,row id, table name, remark, return page ')//call function to add in active remark.
                return true;
            }else{
                return false;
            }
    });

	//Holiday delete
	$(document).on("click", '.delete_holiday_creation', function(){
        var dlt = confirm("Do you want to delete this Holiday ?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	//Tag delete
	$(document).on("click", '.delete_tag_creation', function(){
        var dlt = confirm("Do you want to delete this Tag Creation ?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	//Staff delete
	$(document).on("click", '.delete_staff_creation', function(){
        var dlt = confirm("Do you want to delete this Staff Creation ?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	//Audit delete
	$(document).on("click", '.delete_audit_area_creation', function(){
        var dlt = confirm("Do you want to delete this Audit Area Creation ?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	//Basic delete
	$(document).on("click", '.delete_basic_creation', function(){
        var dlt = confirm("Do you want to delete this Basic Creation ?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	//roles_responsibility_creation delete
	$(document).on("click", '.delete_roles_responsibility_creation', function(){
        var dlt = confirm("Do you want to delete this Roles ?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	//roles_responsibility_creation delete
	$(document).on("click", '.delete_krakpi_creation', function(){
        var dlt = confirm("Do you want to delete this KRA & KPI?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });

	// hierarchy creation delete
	$(document).on("click", '.delete_hierarchy_creation', function(){
        var dlt = confirm("Do you want to delete this Hierarchy?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });

	// kra creation delete
	$(document).on("click", '.delete_kra_creation', function(){
        var dlt = confirm("Do you want to delete this KRA?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });

	// Assign Work delete
	$(document).on("click", '.delete_assign_work', function(){
        var dlt = confirm("Do you want to delete this Work?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	
	// Asset Register delete
	$(document).on("click", '.delete_asset_register', function(){
        var dlt = confirm("Do you want to delete this Asset?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });

	// Insurance Register delete
	$(document).on("click", '.delete_insurance_register', function(){
        var dlt = confirm("Do you want to delete this Insurance?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	
	// Todo delete
	$(document).on("click", '.delete_todo', function(){
        var dlt = confirm("Do you want to delete this ToDo?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });

	// Service Indent delete
	$(document).on("click", '.delete_service_indent', function(){
        var dlt = confirm("Do you want to delete this Service Indent?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });

	// Service Indent Closed inward
	$(document).on("click", '.approvepo', function(){
        var dlt = confirm("Are you sure want to Closed this Service Indent?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	// Memo Status delete
	$(document).on("click", '.delete_memo_status', function(){
        var dlt = confirm("Do you want to delete this Memo Status?");
        if(dlt){
                return true;
            }else{
                return false;
            }
    });
	
	// Asset delete
	$(document).on("click", '.delete_asset_details', function(){
        var dlt = confirm("Do you want to delete this Asset?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });
	
	// RGP delete
	$(document).on("click", '.delete_rgp', function(){
        var dlt = confirm("Do you want to delete this RGP Data?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// RGP delete
	$(document).on("click", '.delete_report_template', function(){
        var dlt = confirm("Do you want to delete this Report Template?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// permission on duty delete
	$(document).on("click", '.delete_permission_on_duty', function(){
        var dlt = confirm("Do you want to delete this Permission OR On Duty?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// Transfer Location delete
	$(document).on("click", '.delete_transfer_location', function(){
        var dlt = confirm("Do you want to delete this Transfer Location?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// pm checklist delete
	$(document).on("click", '.delete_pm_checklist', function(){
        var dlt = confirm("Do you want to delete this PM Checklist?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// bm checklist delete
	$(document).on("click", '.delete_bm_checklist', function(){
        var dlt = confirm("Do you want to delete this BM Checklist?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// maintenance checklist delete
	$(document).on("click", '.delete_maintenance_checklist', function(){
        var dlt = confirm("Do you want to delete this Maintenance Checklist?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// periodic level delete
	$(document).on("click", '.delete_periodic_level', function(){
        var dlt = confirm("Do you want to delete this Periodic Level?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// vehicle details delete
	$(document).on("click", '.delete_vehicle_details', function(){
        var dlt = confirm("Do you want to delete this Vehicle Datails?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// daily km delete
	$(document).on("click", '.delete_daily_km', function(){
        var dlt = confirm("Do you want to delete this Daily KM?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

	// diesel slip delete
	$(document).on("click", '.delete_diesel_slip', function(){
        var dlt = confirm("Do you want to delete this Diesel Slip?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

    // Audit assign delete
    $(document).on("click", '.delete_audit_assign', function(){
        var dlt = confirm("Do you want to delete this Audit Assign?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

    // Audit campaign
    $(document).on("click", '.delete_campaign', function(){
        var dlt = confirm("Do you want to delete this Campaign?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

    //  delete promotional_activities
    $(document).on("click", '.delete_promotional_activities', function(){
        var dlt = confirm("Do you want to delete this promotional_activities?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });
	
    // delete goal_setting
    $(document).on("click", '.delete_goal_setting', function(){
        var dlt = confirm("Do you want to delete this goal_setting?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });
	
    // delete daily_performance
    $(document).on("click", '.delete_daily_performance', function(){
        var dlt = confirm("Do you want to delete this daily performance?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

    // delete target fixing
    $(document).on("click", '.delete_target_fixing', function(){
        var dlt = confirm("Do you want to delete this target fixing?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

    // delete Appreciation Depreciation
    $(document).on("click", '.delete_appreciation_depreciation', function(){
        var dlt = confirm("Do you want to delete this Appreciation Depreciation?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

    // delete manage users
    $(document).on("click", '.delete_user', function(){
        var dlt = confirm("Do you want to delete this user?");
        if(dlt){
            return true;
        }else{
            return false;
        }
    });

    window.alert = function(message) {// this will prevent normal window.alert messages to set it as swal
        Swal.fire({
            text: message,
            target: 'body',
            toast: true,
            position: 'top-right',
            // background: '#00E2CD',
            timer: 5000,
            showConfirmButton: true,
            confirmButtonColor: '#1b6aaa',
            timerProgressBar: true,
        })
        return false;
    };

    function inActiveRemark(idColumn,id,table,remark,returnPage){
        $.ajax({
            type: 'POST',
            data:{'idColumn': idColumn, 'rowId': id, 'tableName': table, 'remark': remark},
            url:'ajaxFetch/addInActiveRemark.php',
            cache: false,
            dataType: 'json',
            success: function(response){
                if(response == 1){
                    window.location.href= returnPage+'&msc=3';
                }else{
                    window.location.href= returnPage+'&msc=4';
                }
            }
        })
    }

    function changeRowColor(){
        $('#pending_task_dashboard tbody tr').each(function(){
            let sts = $(this).find('td:nth-child(5)').html();
            if (sts == 'Work Assigned') { 
                $(this).closest('tr').css({'backgroundColor':'yellow', 'fontWeight': 'bold'})
            }else if (sts == 'In Progress') {
                $(this).closest('tr').css({'backgroundColor':'#ffd486', 'fontWeight': 'bold'})
                
            }else if (sts == 'Pending') {
                $(this).closest('tr').css({'backgroundColor':'#f44', 'fontWeight': 'bold'})
                
            }
            // else if (sts == 'Completed') {
            //     $(this).closest('tr').css('backgroundColor','')

            // }
        });

    }

    function changeRowBGColor(){
        $('#managerlogin_pending_task_dashboard tbody tr').each(function(){
            let sts = $(this).find('td:nth-child(5)').html();
            if (sts == 'Work Assigned') { 
                $(this).closest('tr').css({'backgroundColor':'yellow', 'fontWeight': 'bold'})
            }else if (sts == 'In Progress') {
                $(this).closest('tr').css({'backgroundColor':'#ffd486', 'fontWeight': 'bold'})
                
            }else if (sts == 'Pending') {
                $(this).closest('tr').css({'backgroundColor':'#f44', 'fontWeight': 'bold'})
                
            }
            // else if (sts == 'Completed') {
            //     $(this).closest('tr').css('backgroundColor','')

            // }
        });

    }

    // Function to add the overlay
    // function showOverlay() {
    // var overlayDiv = document.createElement('div');
    // overlayDiv.classList.add('overlay');
    // document.body.appendChild(overlayDiv);

    // var loaderDiv = document.createElement('div');
    // loaderDiv.classList.add('loader');
    // overlayDiv.appendChild(loaderDiv);

    // var overlayText = document.createElement('span');
    // overlayText.classList.add('overlay-text');
    // overlayText.innerText = 'Please Wait';
    // overlayDiv.appendChild(overlayText);
    // }

    // // Function to remove the overlay and clear the timer
    // function hideOverlay() {
    // var overlayDiv = document.querySelector('.overlay');
    // overlayDiv.remove();
    // }
    
    // $(document).ajaxStart(function() {
    //     showOverlay();
    // });
    
    // $(document).ajaxStop(function() {
    //     hideOverlay();
    // });

</script>


