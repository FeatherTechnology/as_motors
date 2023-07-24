<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Report </li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--------form start-->
    <form id="assign_work" name="assign_work" action="" method="post" enctype="multipart/form-data">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <div class="card-title">General Info</div> -->
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <!--Type Start  -->
                            <div class="col-md-12 ">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="report_type">Report Type</label>
                                                <select tabindex="1" type="text" class="form-control emptyTable" id="report_type" name="report_type">
                                                    <option value=''>Select Report Type</option>
                                                    <option value='1'>Staff</option>
                                                    <option value='2'>Department</option>
                                                    <option value='3'>Task</option>
                                                    <option value='4'>Work Status</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Type End-->

                            <!--Staff Start-->
                            <div class="col-md-12" id="staff_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="staff_name">Staff Name</label>
                                                <select tabindex="2" type="text" class="form-control clearvalue" id="staff_name" name="staff_name">
                                                    <option value=''>Select Staff Name</option>
                                                </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="staff_from_date">From Date</label>
                                                <input tabindex="3" type="date" class="form-control validateToDate clearvalue" id="staff_from_date" name="staff_from_date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="staff_to_date">To Date</label>
                                                <input tabindex="4" type="date" class="form-control setvaltodate clearvalue" id="staff_to_date" name="staff_to_date">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--Staff End-->

                            <!--Department Start-->
                            <div class="col-md-12" id="dept_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_type">Type</label>
                                                <select tabindex="5" type="text" class="form-control clearvalue" id="dept_type" name="dept_type">
                                                    <option value=''>Select Type</option>
                                                    <option value='1'>Department</option>
                                                    <option value='2'>Staff</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>

                                <!--Department Start-->
                                <div class="row" id="dept_name_report" style="display: none;">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_name">Department Name</label>
                                                <select tabindex="6" type="text" class="form-control clearvalue" id="dept_name" name="dept_name">
                                                    <option value=''>Select Department</option>
                                                </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_from_date">From Date</label>
                                            <input tabindex="7" type="date" class="form-control validateToDate clearvalue" id="dept_from_date" name="dept_from_date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_to_date">To Date</label>
                                            <input tabindex="8" type="date" class="form-control setvaltodate clearvalue" id="dept_to_date" name="dept_to_date">
                                        </div>
                                    </div>
                                </div>
                                <!--Department End-->

                                <!--Department staff Start-->
                                <div class="row" id="dept_staff_report" style="display: none;">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dep_name">Department Name</label>
                                                <select tabindex="9" type="text" class="form-control clearvalue" id="dep_name" name="dep_name">
                                                    <option value=''>Select Department</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_staff_name">Staff Name</label>
                                                <select tabindex="10" type="text" class="form-control clearvalue" id="dept_staff_name" name="dept_staff_name">
                                                    <option value=''>Select Staff Name</option>
                                                </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_staff_from_date">From Date</label>
                                            <input tabindex="11" type="date" class="form-control validateToDate clearvalue" id="dept_staff_from_date" name="dept_staff_from_date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_staff_to_date">To Date</label>
                                            <input tabindex="12" type="date" class="form-control setvaltodate clearvalue" id="dept_staff_to_date" name="dept_staff_to_date">
                                        </div>
                                    </div>
                                </div>
                                <!--Department staff End-->

                            </div>
                            <!--Department End-->

                            <!--Task Start-->
                            <div class="col-md-12" id="task_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="task_name">Task Name</label>
                                                <select tabindex="2" type="text" class="form-control clearvalue" id="task_name" name="task_name">
                                                    <option value=''>Select Task Name</option>
                                                    <option value='1'>KRAKPI</option>
                                                    <option value='2'>AUDIT</option>
                                                    <option value='3'>PM MAINTANCE</option>
                                                    <option value='4'>BM MAINTANCE</option>
                                                    <option value='5'>CAMPAIGN</option>
                                                    <option value='6'>ASSIGN WORK</option>
                                                    <option value='7'>TODO</option>
                                                    <option value='8'>INSURANCE</option>
                                                    <option value='9'>FC INSURANCE RENEWAL</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Task End-->

                            <!--Work status Start-->
                            <div class="col-md-12" id="work_sts_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="work_status">Work Status</label>
                                                <select tabindex="2" type="text" class="form-control clearvalue" id="work_status" name="work_status">
                                                    <option value=''>Select Work Status</option>
                                                    <option value='1'>All</option>
                                                    <option value='2'>In-Progress</option>
                                                    <option value='3'>Pending</option>
                                                    <option value='4'>Completed</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="wrk_dept_name">Department Name</label>
                                                <select tabindex="9" type="text" class="form-control clearvalue" id="wrk_dept_name" name="wrk_dept_name">
                                                    <option value=''>Select Department</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="work_from_date">From Date</label>
                                            <input tabindex="11" type="date" class="form-control validateToDate clearvalue" id="work_from_date" name="work_from_date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="work_to_date">To Date</label>
                                            <input tabindex="12" type="date" class="form-control setvaltodate clearvalue" id="work_to_date" name="work_to_date">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--work status End-->

                            <!--Report View Button Start -->
                            <div class="col-12">
                                <div class="form-group text-right">
                                    <span class="required validate" style="display: none;">*Please Fill All the Field</span>
                                    <button type="button" tabindex="10" class="btn btn-primary" id="view_report" name="view_report" >View Report</button>
                                </div>
                            </div>
                            <!--Report View Button End -->

                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card-body" id="report_view_table">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>